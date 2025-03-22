<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login'); // Updated path to reflect the correct folder structure
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // If successful, redirect to intended location
            return redirect()->intended('home'); // or any other page
        }

        // If unsuccessful, redirect back to the login with input
        return back()->withInput($request->only('email', 'remember'))->withErrors(['email' => 'Invalid credentials.']);
    }
}
