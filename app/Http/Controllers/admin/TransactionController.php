<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transactions(Request $request)
    {
        // Check if admin is authenticated
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        // Get search query
        $search = $request->query('search');
        $query = Payment::with(['tenant', 'landlord']);

        // Apply search filters
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('tenant', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('landlord', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->latest()->paginate(13);

        // Get admin name
        $name = Auth::guard('admin')->user()->name;

        $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
                                    ->whereNull('read_at')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('admin.transactions', compact('transactions', 'notifications', 'search', 'name'));
    }
}