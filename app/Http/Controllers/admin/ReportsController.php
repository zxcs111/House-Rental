<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function reports(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        // Fetch paginated users with optional search
        $search = $request->query('search');
        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(12);
        $name = Auth::guard('admin')->user()->name;
        $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
                                    ->whereNull('read_at')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // Fetch data for the chart: User registrations by month
        $userRegistrations = User::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->count];
            });

        // Prepare chart data
        $chartLabels = $userRegistrations->keys()->toArray(); 
        $chartData = $userRegistrations->values()->toArray(); 

        return view('admin.reports', compact('users', 'name', 'notifications', 'search', 'chartLabels', 'chartData'));
    }

    public function show($id)
    {
        return view('admin.report-detail', compact('id'));
    }

    public function create()
    {
        return view('admin.create-report');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.reports')->with('success', 'Report created successfully!');
    }
}