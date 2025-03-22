<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class LoginController extends Controller
{
    // Show the login/registration form
    public function showLoginForm()
    {
        return view('auth.login'); // Updated path to reflect the correct folder structure
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // If successful, redirect to intended location
            return redirect()->intended('/'); // or any other page
        }

        // If unsuccessful, redirect back to the login with input
        return back()->withInput($request->only('email', 'remember'))->withErrors(['email' => 'Invalid credentials.']);
    }

    // Handle registration request
    public function register(Request $request)
    {
        // Validate the registration request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log the user in after registration
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        // Redirect to the home page with a success message
        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    // Show the profile page
    public function profile()
    {
        return view('auth.profile'); // Render the profile view
    }

    // Handle profile updates
    public function updateProfile(Request $request)
    {
        // Validate the request
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255', // Add this line
        ]);

        // Get the authenticated user
        /** @var User $user */
        $user = Auth::user();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->profile_picture) {
                Storage::delete('public/profile/' . $user->profile_picture);
            }

            // Store the new profile picture in the storage/app/public/profile folder
            $path = $request->file('profile_picture')->store('profile', 'public');
            $user->profile_picture = $path; // Save the path in the database
        }

        // Update personal information
        $user->first_name = $request->input('first_name', $user->first_name);
        $user->last_name = $request->input('last_name', $user->last_name);
        $user->phone_number = $request->input('phone_number', $user->phone_number);
        $user->address = $request->input('address', $user->address); // Add this line

        // Save the user
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    // Handle logout request
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}