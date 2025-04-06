<?php

namespace App\Http\Controllers\Landlord;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class CancellationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'landlord') {
                return Redirect::to(url()->previous());
            }
            return $next($request);
        });
    }

    public function cancellationRequests()
    {
        $pendingRequests = Payment::where('landlord_id', Auth::id())
            ->where('cancellation_requested', true)
            ->where('cancellation_status', 'pending')
            ->with(['property', 'tenant'])
            ->get();

        return view('landlord.cancellation-requests', [
            'pendingRequests' => $pendingRequests,
            'pendingCancellationCount' => $this->calculatePendingCount()
        ]);
    }

    protected function calculatePendingCount()
    {
        return Payment::where('landlord_id', Auth::id())
            ->where('cancellation_requested', true)
            ->where('cancellation_status', 'pending')
            ->count();
    }

    public function approveCancellation(Request $request, Payment $payment)
    {
        if ($payment->landlord_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update payment status and property availability
        $payment->update([
            'cancellation_status' => 'approved',
            'status' => 'cancelled',
            'cancellation_requested' => false // Mark as no longer pending
        ]);

        $payment->property->update(['status' => 'available']);

        return back()->with('success', 'Cancellation approved successfully.');
    }

    public function rejectCancellation(Request $request, Payment $payment)
    {
        if ($payment->landlord_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $payment->update([
            'cancellation_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'cancellation_requested' => false 
        ]);

        return back()->with('success', 'Cancellation request rejected.');
    }
}