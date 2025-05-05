<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        return view('admin.dashboard');
    }

    public function updateProfile(Request $request)
    {
        try {
            $admin = Auth::guard('admin')->user();
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
                'password' => 'nullable|string|min:8',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if ($request->has('password') && $validated['password']) {
                $data['password'] = bcrypt($validated['password']);
            }

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = 'profile_' . $admin->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/profiles', $filename);
                $data['profile_picture'] = $filename;
                $imageUrl = asset('storage/profiles/' . $filename);
                Log::info('Profile picture uploaded', [
                    'admin_id' => $admin->id,
                    'filename' => $filename,
                    'path' => $path,
                    'image_url' => $imageUrl,
                ]);
            }

            $admin->update($data);

            return redirect()->route('admin.dashboard')->with('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            Log::error('Profile update failed', ['error' => $e->getMessage(), 'admin_id' => Auth::guard('admin')->user()->id]);
            return redirect()->route('admin.dashboard')->with('error', 'Failed to update profile. Please try again.');
        }
    }
}