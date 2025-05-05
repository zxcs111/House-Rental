<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TotalUserController extends Controller
{
    public function totaluser()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        return view('admin.total-users');
    }

    public function show($id)
    {
        // Logic to show a specific user
        return view('admin.user-detail', compact('id'));
    }

    public function create()
    {
        // Logic to create a new user
        return view('admin.create-user');
    }

    public function store(Request $request)
    {
        // Logic to store a new user
        // Validate and save the user data
        return redirect()->route('admin.total-users')->with('success', 'User created successfully!');
    }
}
