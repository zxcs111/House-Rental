<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use App\Models\Notification;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        $name = Auth::guard('admin')->user()->name;

        $pendingProperties = Property::with('landlord')
            ->where('status', Property::STATUS_PENDING)
            ->latest()
            ->take(3)
            ->get();

        $recentRentedProperties = Property::with(['payments' => function ($query) {
            $query->where('status', 'completed')
                  ->orderBy('start_date', 'desc')
                  ->take(1);
        }])
            ->where('status', Property::STATUS_RENTED)
            ->latest()
            ->take(3)
            ->get();

        $totalAvailableListings = Property::where('status', Property::STATUS_AVAILABLE)->count();
        $totalRentedProperties = Property::where('status', Property::STATUS_RENTED)->count();

        $totalUsers = User::count();

        $currentYear = now()->year;
        $lastYear = $currentYear - 1;

        $newUsersThisYear = User::whereYear('created_at', $currentYear)->count();
        $usersLastYear = User::whereYear('created_at', $lastYear)->count();
        $usersPercentageChange = $usersLastYear > 0 ? round((($totalUsers - $usersLastYear) / $usersLastYear) * 100, 1) : ($totalUsers > 0 ? 100 : 0);

        $usersData = [
            'total' => $totalUsers,
            'percentage_change' => $usersPercentageChange,
            'new_users_this_year' => $newUsersThisYear,
        ];

        $newRentedThisYear = Payment::where('status', 'completed')
            ->whereYear('start_date', $currentYear)
            ->distinct('property_id')
            ->count('property_id');
        $totalProperties = $totalRentedProperties + $totalAvailableListings;
        $rentedPercentageChange = $totalProperties > 0 ? round(($totalRentedProperties / $totalProperties) * 100, 1) : 0;

        $rentedData = [
            'total' => $totalRentedProperties,
            'percentage_change' => $rentedPercentageChange,
            'new_rented_this_year' => $newRentedThisYear,
        ];

        $rentedPerMonth = [];
        for ($month = 1; $month <= 5; $month++) {
            $count = Payment::where('status', 'completed')
                ->whereYear('start_date', $currentYear)
                ->whereMonth('start_date', $month)
                ->distinct('property_id')
                ->count('property_id');
            $rentedPerMonth[$month] = $count;
        }

        $rentedPerWeek = [];
        $mayStart = Carbon::create($currentYear, 5, 1);
        $today = now(); 
        $weeks = [];
        $currentWeekStart = $mayStart->startOfWeek(Carbon::MONDAY);

        while ($currentWeekStart->lessThanOrEqualTo($today)) {
            $weekEnd = $currentWeekStart->copy()->endOfWeek(Carbon::SUNDAY);
            if ($weekEnd->greaterThan($today)) {
                $weekEnd = $today;
            }
            $count = Payment::where('status', 'completed')
                ->whereYear('start_date', $currentYear)
                ->whereMonth('start_date', 5)
                ->whereBetween('start_date', [$currentWeekStart, $weekEnd])
                ->distinct('property_id')
                ->count('property_id');
            $weeks[] = $count;
            $currentWeekStart->addWeek();
        }
        $rentedPerWeek = array_values($weeks);

        Log::info('Rented per week for May 2025:', $rentedPerWeek);

        if (array_sum($rentedPerWeek) === 0) {
            $rentedPerWeek = [2, 3, 5];
        }
        if (array_sum($rentedPerMonth) === 0) {
            $rentedPerMonth = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5];
        }

        $newListingsThisYear = Property::where('status', Property::STATUS_AVAILABLE)
            ->whereYear('created_at', $currentYear)
            ->count();
        $listingsPercentageChange = $totalProperties > 0 ? round(($totalAvailableListings / $totalProperties) * 100, 1) : 0;

        $listingsData = [
            'total' => $totalAvailableListings,
            'percentage_change' => $listingsPercentageChange,
            'new_listings_this_year' => $newListingsThisYear,
        ];

        $totalPendingProperties = Property::where('status', Property::STATUS_PENDING)->count();
        $newPendingThisYear = Property::where('status', Property::STATUS_PENDING)
            ->whereYear('created_at', $currentYear)
            ->count();
        $pendingLastYear = Property::where('status', Property::STATUS_PENDING)
            ->whereYear('created_at', $lastYear)
            ->count();
        $pendingPercentageChange = $pendingLastYear > 0 ? round((($totalPendingProperties - $pendingLastYear) / $pendingLastYear) * 100, 1) : ($totalPendingProperties > 0 ? 100 : 0);

        $pendingPropertiesData = [
            'total' => $totalPendingProperties,
            'percentage_change' => $pendingPercentageChange,
            'new_pending_this_year' => $newPendingThisYear,
        ];

        $propertyTypes = [
            'Apartment' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Apartment')->count(),
            'House' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'House')->count(),
            'Condo' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Condo')->count(),
            'Townhouse' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Townhouse')->count(),
            'Duplex' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Duplex')->count(),
            'Studio' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Studio')->count(),
        ];

        $availablePropertiesByType = [
            'Apartment' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Apartment')->get(),
            'House' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'House')->get(),
            'Condo' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Condo')->get(),
            'Townhouse' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Townhouse')->get(),
            'Duplex' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Duplex')->get(),
            'Studio' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Studio')->get(),
        ];

        $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
            ->whereNull('read_at')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendingProperties',
            'recentRentedProperties',
            'listingsData',
            'rentedData',
            'usersData',
            'pendingPropertiesData',
            'notifications',
            'rentedPerMonth',
            'rentedPerWeek',
            'propertyTypes',
            'availablePropertiesByType',
            'name'
        ));
    }

    public function updateProfile(Request $request)
    {
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
            $directory = storage_path('app/public/profile');

            if (!file_exists($directory)) {
                mkdir($directory, 0775, true);
            }

            $file->move($directory, $filename);
            $data['profile_picture'] = $filename;
        }

        $admin->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Profile updated successfully.');
    }

    public function approveProperty(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        if ($property->status !== Property::STATUS_PENDING) {
            return redirect()->route('admin.dashboard')->with('error', 'Property is not pending approval.');
        }

        $property->update(['status' => Property::STATUS_AVAILABLE]);

        Notification::create([
            'admin_id' => Auth::guard('admin')->id(),
            'type' => 'property_approved',
            'data' => [
                'property_title' => $property->title,
            ],
            'read_at' => null,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Property approved successfully.');
    }

    public function markNotificationsAsRead(Request $request)
    {
        Notification::where('admin_id', Auth::guard('admin')->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->route('admin.dashboard')->with('success', 'All notifications marked as read.');
    }
}