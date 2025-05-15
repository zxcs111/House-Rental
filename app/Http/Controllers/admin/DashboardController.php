<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use App\Models\Visit;
use App\Models\Notification;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;

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

            // Fetch recent rented properties with their latest payment
            $recentRentedProperties = Property::with(['payments' => function ($query) {
                $query->where('status', 'completed')
                      ->orderBy('start_date', 'desc')
                      ->take(1);
            }])
                ->where('status', Property::STATUS_RENTED)
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

            // Rented properties data (total based on Payment model)
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

            // Calculate rented properties per month for 2025 (Jan-May) using Payment model
            $rentedPerMonth = [];
            for ($month = 1; $month <= 5; $month++) {
                $count = Payment::where('status', 'completed')
                    ->whereYear('start_date', $currentYear)
                    ->whereMonth('start_date', $month)
                    ->distinct('property_id')
                    ->count('property_id');
                $rentedPerMonth[$month] = $count;
            }

            // Log the monthly counts for debugging
            Log::info('Rented per month for 2025:', $rentedPerMonth);

            // Calculate rented properties per week for May 2025 using Payment model
            $rentedPerWeek = [];
            $mayStart = Carbon::create($currentYear, 5, 1);
            $today = now(); // May 15, 2025, 08:52 PM PST
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

            // Log the weekly counts for debugging
            Log::info('Rented per week for May 2025:', $rentedPerWeek);

            // If no data is found, provide static data for testing
            if (array_sum($rentedPerWeek) === 0) {
                $rentedPerWeek = [2, 3, 5]; // Simulated data: 2 in Week 1, 3 in Week 2, 5 in Week 3
                Log::info('No real weekly data found; using static data for testing:', $rentedPerWeek);
            }
            if (array_sum($rentedPerMonth) === 0) {
                $rentedPerMonth = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]; // Simulated data for testing
                Log::info('No real monthly data found; using static data for testing:', $rentedPerMonth);
            }

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

            // Calculate property types distribution
            $propertyTypes = [
                'Apartment' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Apartment')->count(),
                'House' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'House')->count(),
                'Condo' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Condo')->count(),
                'Townhouse' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Townhouse')->count(),
                'Duplex' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Duplex')->count(),
                'Studio' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Studio')->count(),
            ];

            // Fetch available properties by type
            $availablePropertiesByType = [
                'Apartment' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Apartment')->get(),
                'House' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'House')->get(),
                'Condo' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Condo')->get(),
                'Townhouse' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Townhouse')->get(),
                'Duplex' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Duplex')->get(),
                'Studio' => Property::where('status', Property::STATUS_AVAILABLE)->where('property_type', 'Studio')->get(),
            ];

            // Fetch unread notifications for the current admin
            $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
                ->whereNull('read_at')
                ->latest()
                ->take(5)
                ->get();

            $name = Auth::guard('admin')->user()->name;

            return view('admin.dashboard', compact(
                'pendingProperties',
                'recentRentedProperties',
                'listingsData',
                'rentedData',
                'usersData',
                'visitsData',
                'notifications',
                'rentedPerMonth',
                'rentedPerWeek',
                'propertyTypes',
                'availablePropertiesByType',
                'name'
            ));
        } catch (Exception $e) {
            Log::error('Dashboard data fetch failed', ['error' => $e->getMessage()]);
            $pendingProperties = collect([]);
            $recentRentedProperties = collect([]);
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
            $rentedPerMonth = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
            $rentedPerWeek = [0, 0, 0];
            $propertyTypes = [
                'Apartment' => 0,
                'House' => 0,
                'Condo' => 0,
                'Townhouse' => 0,
                'Duplex' => 0,
                'Studio' => 0,
            ];
            $availablePropertiesByType = [
                'Apartment' => collect([]),
                'House' => collect([]),
                'Condo' => collect([]),
                'Townhouse' => collect([]),
                'Duplex' => collect([]),
                'Studio' => collect([]),
            ];

            return view('admin.dashboard', compact(
                'pendingProperties',
                'recentRentedProperties',
                'listingsData',
                'rentedData',
                'usersData',
                'visitsData',
                'notifications',
                'rentedPerMonth',
                'rentedPerWeek',
                'propertyTypes',
                'availablePropertiesByType',
                'name'
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
            $directory = storage_path('app/public/profile');

            // Ensure directory exists
            if (!file_exists($directory)) {
                if (mkdir($directory, 0775, true)) {
                    Log::info('Created directory', ['directory' => $directory]);
                } else {
                    Log::error('Failed to create directory', ['directory' => $directory]);
                    return redirect()->route('admin.dashboard')->with('error', 'Failed to create storage directory for profile picture.');
                }
            }

            // Move the file to the directory
            $fullPath = $directory . '/' . $filename;
            if ($file->move($directory, $filename)) {
                if (file_exists($fullPath)) {
                    Log::info('Profile picture saved successfully', [
                        'path' => $fullPath,
                        'filename' => $filename,
                        'timestamp' => time()
                    ]);
                    $data['profile_picture'] = $filename;
                } else {
                    Log::error('File exists check failed after move', [
                        'path' => $fullPath,
                        'filename' => $filename
                    ]);
                    return redirect()->route('admin.dashboard')->with('error', 'Failed to verify saved profile picture.');
                }
            } else {
                Log::error('Failed to move profile picture', [
                    'filename' => $filename,
                    'directory' => $directory
                ]);
                return redirect()->route('admin.dashboard')->with('error', 'Failed to save profile picture to storage.');
            }
        }

        $admin->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Profile updated successfully.');
    } catch (Exception $e) {
        Log::error('Profile update failed', [
            'error' => $e->getMessage(),
            'admin_id' => Auth::guard('admin')->user()->id
        ]);
        return redirect()->route('admin.dashboard')->with('error', 'Failed to update profile: ' . $e->getMessage());
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