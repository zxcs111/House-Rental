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

    return redirect()->route('payment.success', $payment->id);
}

    public function paymentSuccess($paymentId)
    {
        $payment = Payment::with(['property', 'landlord'])->findOrFail($paymentId);
        return view('payment-success', compact('payment'));
    }
}