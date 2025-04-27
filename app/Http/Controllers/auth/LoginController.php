<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            return redirect()->route('home')->with('success', 'Registration successful! Welcome to Stay Haven.');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['general' => 'Registration failed due to an unexpected error. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}