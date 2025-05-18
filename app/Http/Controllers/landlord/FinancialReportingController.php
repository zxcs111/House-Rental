<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FinancialReportingController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'landlord') {
            return Redirect::to(url()->previous());
        }

        $landlord = Auth::user();

        // Get the search term from the request
        $searchTerm = $request->query('search', '');

        // Calculate total sales excluding hidden and cancelled transactions
        $totalSales = $landlord->receivedPayments()
            ->where('status', '!=', 'cancelled')
            ->where('hidden_by_landlord', false)
            ->sum('amount');

        // Calculate monthly sales excluding hidden and cancelled transactions
        $monthlySales = $landlord->receivedPayments()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', '!=', 'cancelled')
            ->where('hidden_by_landlord', false)
            ->sum('amount');

        // Calculate total rented properties (distinct properties with active or completed payments)
        $rentedProperties = Property::where('user_id', $landlord->id)
            ->whereHas('payments', function ($query) use ($landlord) {
                $query->where('landlord_id', $landlord->id)
                      ->where('status', '!=', 'cancelled')
                      ->where('hidden_by_landlord', false);
            })
            ->get(['id', 'title']);

        $totalRentedProperties = $rentedProperties->count();

        // Fetch transactions excluding hidden ones, with search filtering
        $query = $landlord->receivedPayments()
            ->with(['property', 'tenant'])
            ->where('hidden_by_landlord', false);

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('property', function ($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%');
                })->orWhereHas('tenant', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends(['search' => $searchTerm]);

        return view('landlord.financial-reporting', [
            'totalSales' => $totalSales,
            'monthlySales' => $monthlySales,
            'totalRentedProperties' => $totalRentedProperties,
            'rentedProperties' => $rentedProperties,
            'totalrented' => $totalRented = User::where('role', 'tenant')->count(),
            'transactions' => $transactions,
            'landlord' => $landlord,
            'searchTerm' => $searchTerm
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

        // Mark the payment as hidden for the landlord
        $payment->hidden_by_landlord = true;
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

        return response()->json([
            'success' => true,
            'message' => 'Rental cancelled successfully'
        ]);
    }
}