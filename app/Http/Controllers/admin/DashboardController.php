<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use App\Models\Visit;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        try {
            // Log the visit
            Visit::create([
                'user_id' => Auth::guard('admin')->check() ? Auth::guard('admin')->id() : null,
                'page_url' => $request->fullUrl(),
                'ip_address' => $request->ip(),
                'visited_at' => now(),
            ]);

            // Fetch pending properties with their landlord details
            $pendingProperties = Property::with('landlord')
                ->where('status', Property::STATUS_PENDING)
                ->latest()
                ->take(3)
                ->get();

            // Fetch total available and rented properties
            $totalAvailableListings = Property::where('status', Property::STATUS_AVAILABLE)->count();
            $totalRentedProperties = Property::where('status', Property::STATUS_RENTED)->count();

            // Fetch total users
            $totalUsers = User::count();

            // Calculate years for comparisons
            $currentYear = now()->year;
            $lastYear = $currentYear - 1;

            // Users data
            $newUsersThisYear = User::whereYear('created_at', $currentYear)->count();
            $usersLastYear = User::whereYear('created_at', $lastYear)->count();
            $usersPercentageChange = $usersLastYear > 0 ? round((($totalUsers - $usersLastYear) / $usersLastYear) * 100, 1) : ($totalUsers > 0 ? 100 : 0);

            $usersData = [
                'total' => $totalUsers,
                'percentage_change' => $usersPercentageChange,
                'new_users_this_year' => $newUsersThisYear,
            ];

            // Rented properties data
            $newRentedThisYear = Property::where('status', Property::STATUS_RENTED)
                ->whereYear('created_at', $currentYear)
                ->count();
            $totalProperties = $totalRentedProperties + $totalAvailableListings;
            $rentedPercentageChange = $totalProperties > 0 ? round(($totalRentedProperties / $totalProperties) * 100, 1) : 0;

            $rentedData = [
                'total' => $totalRentedProperties,
                'percentage_change' => $rentedPercentageChange,
                'new_rented_this_year' => $newRentedThisYear,
            ];

            // Available listings data
            $newListingsThisYear = Property::where('status', Property::STATUS_AVAILABLE)
                ->whereYear('created_at', $currentYear)
                ->count();
            $listingsPercentageChange = $totalProperties > 0 ? round(($totalAvailableListings / $totalProperties) * 100, 1) : 0;

            $listingsData = [
                'total' => $totalAvailableListings,
                'percentage_change' => $listingsPercentageChange,
                'new_listings_this_year' => $newListingsThisYear,
            ];

            // Visits data
            $totalVisits = Visit::count();
            $newVisitsThisYear = Visit::whereYear('visited_at', $currentYear)->count();
            $visitsLastYear = Visit::whereYear('visited_at', $lastYear)->count();
            $visitsPercentageChange = $visitsLastYear > 0 ? round((($totalVisits - $visitsLastYear) / $visitsLastYear) * 100, 1) : ($totalVisits > 0 ? 100 : 0);

            $visitsData = [
                'total' => $totalVisits,
                'percentage_change' => $visitsPercentageChange,
                'new_visits_this_year' => $newVisitsThisYear,
            ];

            // Fetch unread notifications for the current admin
            $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
                ->whereNull('read_at')
                ->latest()
                ->take(5) // Limit to 5 for dropdown
                ->get();

            return view('admin.dashboard', compact(
                'pendingProperties',
                'listingsData',
                'rentedData',
                'usersData',
                'visitsData',
                'notifications'
            ));
        } catch (Exception $e) {
            Log::error('Dashboard data fetch failed', ['error' => $e->getMessage()]);
            $pendingProperties = collect([]);
            $listingsData = [
                'total' => 0,
                'percentage_change' => 0,
                'new_listings_this_year' => 0,
            ];
            $rentedData = [
                'total' => 0,
                'percentage_change' => 0,
                'new_rented_this_year' => 0,
            ];
            $usersData = [
                'total' => 0,
                'percentage_change' => 0,
                'new_users_this_year' => 0,
            ];
            $visitsData = [
                'total' => 0,
                'percentage_change' => 0,
                'new_visits_this_year' => 0,
            ];
            $notifications = collect([]);

            return view('admin.dashboard', compact(
                'pendingProperties',
                'listingsData',
                'rentedData',
                'usersData',
                'visitsData',
                'notifications'
            ))->with('error', 'Failed to load dashboard data. Please try again.');
        }
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
                $file->storeAs('public/profiles', $filename);
                $data['profile_picture'] = $filename;
                Log::info('Profile picture uploaded', [
                    'admin_id' => $admin->id,
                    'filename' => $filename,
                ]);
            }

            $admin->update($data);

            return redirect()->route('admin.dashboard')->with('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            Log::error('Profile update failed', ['error' => $e->getMessage(), 'admin_id' => Auth::guard('admin')->user()->id]);
            return redirect()->route('admin.dashboard')->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function approveProperty(Request $request, $id)
    {
        try {
            $property = Property::findOrFail($id);
            if ($property->status !== Property::STATUS_PENDING) {
                return redirect()->route('admin.dashboard')->with('error', 'Property is not pending approval.');
            }

            $property->update(['status' => Property::STATUS_AVAILABLE]);

            // Create a notification for the approval
            Notification::create([
                'admin_id' => Auth::guard('admin')->id(),
                'type' => 'property_approved',
                'data' => [
                    'property_title' => $property->title,
                ],
                'read_at' => null,
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Property approved successfully.');
        } catch (Exception $e) {
            Log::error('Property approval failed', ['error' => $e->getMessage(), 'property_id' => $id]);
            return redirect()->route('admin.dashboard')->with('error', 'Failed to approve property. Please try again.');
        }
    }

    public function markNotificationsAsRead(Request $request)
    {
        try {
            Notification::where('admin_id', Auth::guard('admin')->id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            return redirect()->route('admin.dashboard')->with('success', 'All notifications marked as read.');
        } catch (Exception $e) {
            Log::error('Failed to mark notifications as read', ['error' => $e->getMessage(), 'admin_id' => Auth::guard('admin')->id()]);
            return redirect()->route('admin.dashboard')->with('error', 'Failed to mark notifications as read. Please try again.');
        }
    }
}