<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF; // Correct import

class ReportsController extends Controller
{
    public function reports(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        $name = Auth::guard('admin')->user()->name;
        $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
                                    ->whereNull('read_at')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // Key Metrics
        $totalTransactions = Payment::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $avgPropertyPrice = Property::where('status', Property::STATUS_AVAILABLE)
                                    ->avg('price') ?? 0;
        $totalLandlords = User::where('role', 'landlord')->count();
        $totalTenants = User::where('role', 'tenant')->count();

        // User Registrations by Month
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

        $chartLabels = $userRegistrations->keys()->toArray();
        $chartData = $userRegistrations->values()->toArray();

        // Property Price Range Distribution
        $priceRanges = [
            '0-1000' => Property::where('status', Property::STATUS_AVAILABLE)
                                ->whereBetween('price', [0, 1000])
                                ->count(),
            '1001-2000' => Property::where('status', Property::STATUS_AVAILABLE)
                                   ->whereBetween('price', [1001, 2000])
                                   ->count(),
            '2001-3000' => Property::where('status', Property::STATUS_AVAILABLE)
                                   ->whereBetween('price', [2001, 3000])
                                   ->count(),
            '3001-4000' => Property::where('status', Property::STATUS_AVAILABLE)
                                   ->whereBetween('price', [3001, 4000])
                                   ->count(),
            '4001+' => Property::where('status', Property::STATUS_AVAILABLE)
                               ->where('price', '>=', 4001)
                               ->count(),
        ];

        $priceRangeLabels = array_keys($priceRanges);
        $priceRangeData = array_values($priceRanges);

        // Payment Method Distribution (Including Canceled Payments)
        $paymentMethods = Payment::select('payment_method', 'status', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method', 'status')
            ->get()
            ->groupBy('payment_method')
            ->map(function ($group) {
                $completed = $group->where('status', 'completed')->sum('count') ?? 0;
                $cancelled = $group->where('status', 'cancelled')->sum('count') ?? 0;
                return [
                    'completed' => $completed,
                    'cancelled' => $cancelled
                ];
            });

        $paymentMethodLabels = [];
        $paymentMethodData = [];
        foreach ($paymentMethods as $method => $counts) {
            if ($counts['completed'] > 0) {
                $paymentMethodLabels[] = $method;
                $paymentMethodData[] = $counts['completed'];
            }
            if ($counts['cancelled'] > 0) {
                $paymentMethodLabels[] = "$method (Cancelled)";
                $paymentMethodData[] = $counts['cancelled'];
            }
        }

        // Monthly Revenue
        $monthlyRevenue = Payment::where('status', 'completed')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });

        $revenueLabels = $monthlyRevenue->keys()->toArray();
        $revenueData = $monthlyRevenue->values()->toArray();

        return view('admin.reports', compact(
            'name',
            'notifications',
            'totalTransactions',
            'totalRevenue',
            'avgPropertyPrice',
            'totalLandlords',
            'totalTenants',
            'chartLabels',
            'chartData',
            'priceRangeLabels',
            'priceRangeData',
            'paymentMethodLabels',
            'paymentMethodData',
            'revenueLabels',
            'revenueData'
        ));
    }

    public function download(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        // Key Metrics
        $totalTransactions = Payment::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $avgPropertyPrice = Property::where('status', Property::STATUS_AVAILABLE)
                                    ->avg('price') ?? 0;
        $totalLandlords = User::where('role', 'landlord')->count();
        $totalTenants = User::where('role', 'tenant')->count();

        // User Registrations by Month
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

        $chartLabels = $userRegistrations->keys()->toArray();
        $chartData = $userRegistrations->values()->toArray();

        // Property Price Range Distribution
        $priceRanges = [
            '0-1000' => Property::where('status', Property::STATUS_AVAILABLE)
                                ->whereBetween('price', [0, 1000])
                                ->count(),
            '1001-2000' => Property::where('status', Property::STATUS_AVAILABLE)
                                   ->whereBetween('price', [1001, 2000])
                                   ->count(),
            '2001-3000' => Property::where('status', Property::STATUS_AVAILABLE)
                                   ->whereBetween('price', [2001, 3000])
                                   ->count(),
            '3001-4000' => Property::where('status', Property::STATUS_AVAILABLE)
                                   ->whereBetween('price', [3001, 4000])
                                   ->count(),
            '4001+' => Property::where('status', Property::STATUS_AVAILABLE)
                               ->where('price', '>=', 4001)
                               ->count(),
        ];

        $priceRangeLabels = array_keys($priceRanges);
        $priceRangeData = array_values($priceRanges);

        // Payment Method Distribution (Including Canceled Payments)
        $paymentMethods = Payment::select('payment_method', 'status', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method', 'status')
            ->get()
            ->groupBy('payment_method')
            ->map(function ($group) {
                $completed = $group->where('status', 'completed')->sum('count') ?? 0;
                $cancelled = $group->where('status', 'cancelled')->sum('count') ?? 0;
                return [
                    'completed' => $completed,
                    'cancelled' => $cancelled
                ];
            });

        $paymentMethodLabels = [];
        $paymentMethodData = [];
        foreach ($paymentMethods as $method => $counts) {
            if ($counts['completed'] > 0) {
                $paymentMethodLabels[] = $method;
                $paymentMethodData[] = $counts['completed'];
            }
            if ($counts['cancelled'] > 0) {
                $paymentMethodLabels[] = "$method (Cancelled)";
                $paymentMethodData[] = $counts['cancelled'];
            }
        }

        // Monthly Revenue
        $monthlyRevenue = Payment::where('status', 'completed')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });

        $revenueLabels = $monthlyRevenue->keys()->toArray();
        $revenueData = $monthlyRevenue->values()->toArray();

        // Prepare data for the PDF view
        $data = [
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'avgPropertyPrice' => $avgPropertyPrice,
            'totalLandlords' => $totalLandlords,
            'totalTenants' => $totalTenants,
            'userRegistrations' => array_combine($chartLabels, $chartData),
            'priceRanges' => array_combine($priceRangeLabels, $priceRangeData),
            'paymentMethods' => array_combine($paymentMethodLabels, $paymentMethodData),
            'monthlyRevenue' => array_combine($revenueLabels, $revenueData),
            'date' => now()->format('F d, Y'),
        ];

        // Load the PDF view and generate the PDF
        $pdf = PDF::loadView('admin.reports-pdf', $data);
        return $pdf->download('analytics-report-' . now()->format('Y-m-d') . '.pdf');
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