<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FinancialReportingController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'landlord') {
            return Redirect::to(url()->previous()); 
        }

        $landlord = Auth::user();

        $totalSales = $landlord->receivedPayments()->sum('amount');

        $monthlySales = $landlord->receivedPayments()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        $annualSales = $landlord->receivedPayments()
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

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

    public function destroy($id)
    {
        if (Auth::user()->role !== 'landlord') {
            return Redirect::to(url()->previous()); 
        }

        $landlord = Auth::user(); 

        $payment = Payment::where('landlord_id', $landlord->id)
                          ->findOrFail($id);

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaction deleted successfully'
        ]);
    }
}