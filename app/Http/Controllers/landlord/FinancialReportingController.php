<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FinancialReportingController extends Controller
{
    public function index()
    {
        // Get authenticated landlord
        $landlord = Auth::user();
        
        // Verify the user is a landlord
        if ($landlord->role !== 'landlord') {
            abort(403, 'Unauthorized access. Landlord privileges required.');
        }

        // Calculate totals using the receivedPayments relationship
        $totalSales = $landlord->receivedPayments()->sum('amount');
        
        $monthlySales = $landlord->receivedPayments()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
            
        $annualSales = $landlord->receivedPayments()
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
            
        // Get transactions with property and tenant relationships
        $transactions = $landlord->receivedPayments()
            ->with(['property', 'tenant'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('landlord.financial-reporting', [
            'totalSales' => $totalSales,
            'monthlySales' => $monthlySales,
            'annualSales' => $annualSales,
            'transactions' => $transactions,
            'landlord' => $landlord
        ]);
    }
}