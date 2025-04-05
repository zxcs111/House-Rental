<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('auth.profile'); 
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|regex:/^[\w\.-]+@gmail\.com$/',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255', 
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete('public/profile/' . $user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile', 'public');
            $user->profile_picture = $path; 
        }

        if ($request->has('name')) {
            $user->name = $request->input('name', $user->name);
        }

        // Only update the email if it's a valid Gmail address
        if ($request->has('email')) {
            $email = $request->input('email');
            if (preg_match('/^[\w\.-]+@gmail\.com$/', $email)) {
                $user->email = $email;
            } else {
                return redirect()->route('profile')->with('error', 'Email must be a valid Gmail address!');
            }
        }

        $user->first_name = $request->input('first_name', $user->first_name);
        $user->last_name = $request->input('last_name', $user->last_name);
        $user->phone_number = $request->input('phone_number', $user->phone_number);
        $user->address = $request->input('address', $user->address); 
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}