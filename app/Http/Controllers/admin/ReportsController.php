<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function reports()
    {

        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }
        
        return view('admin.reports');
    }

    public function show($id)
    {
        // Logic to show a specific report
        return view('admin.report-detail', compact('id'));
    }

    public function create()
    {
        // Logic to create a new report
        return view('admin.create-report');
    }

    public function store(Request $request)
    {
        // Logic to store a new report
        // Validate and save the report data
        return redirect()->route('admin.reports')->with('success', 'Report created successfully!');
    }
}
