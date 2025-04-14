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

        // Calculate total sales excluding hidden and cancelled transactions
        $totalSales = $landlord->receivedPayments()
            ->where('status', '!=', 'cancelled')
            ->where('hidden', false) // Exclude hidden transactions
            ->sum('amount');

        // Calculate monthly sales excluding hidden and cancelled transactions
        $monthlySales = $landlord->receivedPayments()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', '!=', 'cancelled')
            ->where('hidden', false) // Exclude hidden transactions
            ->sum('amount');

        // Calculate annual sales excluding hidden and cancelled transactions
        $annualSales = $landlord->receivedPayments()
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', '!=', 'cancelled')
            ->where('hidden', false) // Exclude hidden transactions
            ->sum('amount');

        // Fetch transactions excluding hidden ones
        $transactions = $landlord->receivedPayments()
            ->with(['property', 'tenant'])
            ->where('hidden', false) // Exclude hidden transactions
            ->orderBy('created_at', 'desc')
            ->paginate(5);

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

        // Mark the payment as hidden instead of deleting it
        $payment->hidden = true;
        $payment->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaction hidden successfully'
        ]);
    }

    public function cancelRental(Request $request, $id)
    {
        if (Auth::user()->role !== 'landlord') {
            return Redirect::to(url()->previous()); 
        }

        $landlord = Auth::user(); 

        $payment = Payment::where('landlord_id', $landlord->id)
                          ->findOrFail($id);

        // Update the payment status to 'cancelled'
        $payment->status = 'cancelled';
        $payment->save();

        // Optionally, you could trigger an event or send a notification here

        return response()->json([
            'success' => true,
            'message' => 'Rental cancelled successfully'
        ]);
    }
}