<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        return view('payment', compact('property'));
    }

    public function processPayment(Request $request, $propertyId)
    {
        $property = Property::findOrFail($propertyId);
        
        // Validate that property is available
        if ($property->status !== 'available') {
            return back()->with('error', 'This property is not available for rent.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'card_number' => 'required_if:payment_method,credit_card',
            'expiry_date' => 'required_if:payment_method,credit_card',
            'cvv' => 'required_if:payment_method,credit_card',
        ]);

        // Convert dates to Carbon instances
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);

        // Create payment record
        $payment = Payment::create([
            'property_id' => $property->id,
            'tenant_id' => Auth::id(),
            'landlord_id' => $property->user_id,
            'amount' => $property->price,
            'payment_method' => $validated['payment_method'],
            'status' => 'completed',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'transaction_id' => uniqid('TRX-')
        ]);

        // Update property status to rented
        $property->update(['status' => 'rented']);

        return redirect()->route('payment.success', $payment->id);
    }

    public function paymentSuccess($paymentId)
    {
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

        // Here you might want to send a notification to the landlord
        // Notification::send($payment->landlord, new CancellationRequested($payment));

        return redirect()->route('profile')->with('success', 'Cancellation request submitted. Waiting for landlord approval.');
    }
}