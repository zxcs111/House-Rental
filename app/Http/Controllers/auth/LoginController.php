<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB; 

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z][a-zA-Z0-9.]*@gmail\.com$/'
            ],
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Email must be a valid Gmail address containing only letters, numbers, and dots (e.g., example@gmail.com).',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->email_verified_at) {
            return back()->withInput($request->only('email', 'remember'))->withErrors(['email' => 'Please verify your email before logging in.']);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => ['landlord', 'tenant']], $request->remember)) {
            return redirect()->route('home')->with('success', 'Login successful!');
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors(['email' => 'The provided email or password is incorrect.']);
    }

    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z][a-zA-Z0-9.]*@gmail\.com$/'
            ],
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:tenant,landlord',
        ], [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot be longer than 255 characters.',
            'name.regex' => 'Name must contain only letters and spaces.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'email.regex' => 'Email must be a valid Gmail address containing only letters, numbers, and dots (e.g., example@gmail.com).',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'role.required' => 'Please select a role.',
            'role.in' => 'Invalid role selected.',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        try {
            $verificationCode = rand(1000, 999999); 

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'email_verification_code' => $verificationCode,
            ]);

            // Send verification email
            Mail::raw("Your verification code is: $verificationCode", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Stay Haven Email Verification')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return redirect()->route('verify.email.form', ['email' => $request->email])
                             ->with('success', 'A verification code has been sent to your email.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['general' => 'Registration failed due to an unexpected error. Please try again.']);
        }
    }

    public function showVerifyEmailForm(Request $request)
    {
        return view('auth.verify-email', ['email' => $request->query('email')]);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|numeric|digits_between:4,6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('email_verification_code', $request->code)
                    ->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_code' => null,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Email verified successfully! Welcome to Stay Haven.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z][a-zA-Z0-9.]*@gmail\.com$/',
                'exists:users,email'
            ],
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Email must be a valid Gmail address containing only letters, numbers, and dots (e.g., example@gmail.com).',
            'email.exists' => 'This email address is not registered.',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $resetLink = route('password.reset.form', ['token' => $token, 'email' => $request->email]);
        Mail::raw("Click the link to reset your password: $resetLink", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Stay Haven Password Reset')
                    ->from(config('mail.from.address'), config('mail.from.name'));
        });

        return back()->with('success', 'A password reset link has been sent to your email.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z][a-zA-Z0-9.]*@gmail\.com$/',
                'exists:users,email'
            ],
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Email must be a valid Gmail address containing only letters, numbers, and dots (e.g., example@gmail.com).',
            'email.exists' => 'This email address is not registered.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'token.required' => 'Invalid reset token.',
        ]);

        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        event(new PasswordReset($user));

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Password reset successfully! Welcome back.');
    }
}