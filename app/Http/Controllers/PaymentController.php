<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function showPaymentForm($propertyId)
    {
        if (Auth::user()->role !== 'tenant') {
            return Redirect::to(url()->previous());
        }

        $property = Property::findOrFail($propertyId);

        // If the property is not available (e.g., already rented), redirect to houses
        if ($property->status !== 'available') {
            return Redirect::route('houses')->with('info', 'This property has already been rented.');
        }

        return view('payment', compact('property'));
    }

    public function processPayment(Request $request, $propertyId)
    {
        $property = Property::findOrFail($propertyId);

        // Validate that property is available
        if ($property->status !== 'available') {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'This property is not available for rent.'
                ], 400);
            }
            return Redirect::route('houses')->with('info', 'This property has already been rented.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
            'start_date' => 'required|date|after_or_equal:today',
            'card_number' => 'required_if:payment_method,credit_card',
            'expiry_date' => 'required_if:payment_method,credit_card',
            'cvv' => 'required_if:payment_method,credit_card',
        ]);

        // Create payment record
        $payment = Payment::create([
            'property_id' => $property->id,
            'tenant_id' => Auth::id(),
            'landlord_id' => $property->user_id,
            'amount' => $property->price,
            'payment_method' => $validated['payment_method'],
            'status' => 'completed',
            'start_date' => \Carbon\Carbon::parse($validated['start_date']),
            'transaction_id' => uniqid('TRX-'),
        ]);

        // Update property status to rented
        $property->update(['status' => 'rented']);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Payment processed successfully!',
                'redirect_url' => route('payment.success', $payment->id)
            ]);
        }

        return redirect()->route('payment.success', $payment->id);
    }

    public function paymentSuccess($paymentId)
    {
        if (Auth::user()->role !== 'tenant') {
            return Redirect::to(url()->previous());
        }

        $payment = Payment::with(['property', 'landlord'])->findOrFail($paymentId);
        return view('payment-success', compact('payment'));
    }

    public function requestCancellation(Request $request, Payment $payment)
    {
        // Validate that the payment belongs to the authenticated tenant
        if ($payment->tenant_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate that the payment isn't already cancelled or pending
        if ($payment->cancellation_requested) {
            return back()->with('error', 'Cancellation already requested for this payment.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        // Update payment with cancellation request
        $payment->update([
            'cancellation_requested' => true,
            'cancellation_reason' => $validated['cancellation_reason'],
            'cancellation_status' => 'pending',
        ]);

        return redirect()->route('profile')->with('success', 'Cancellation request submitted. Waiting for landlord approval.');
    }

    public function receipt(Payment $payment)
    {
        // Verify the payment belongs to the authenticated user (either landlord or tenant)
        if (Auth::user()->role === 'landlord' && $payment->landlord_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        } elseif (Auth::user()->role === 'tenant' && $payment->tenant_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json([
            'property' => $payment->property,
            'landlord' => $payment->landlord,
            'tenant' => $payment->tenant,
            'amount' => $payment->amount,
            'payment_method' => $payment->payment_method,
            'status' => $payment->status,
            'transaction_id' => $payment->transaction_id,
            'start_date' => $payment->start_date->format('M d, Y'),
            'created_at' => $payment->created_at->format('M d, Y')
        ]);
    }
}