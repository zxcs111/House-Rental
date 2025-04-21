<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HouseController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('user')->latest();

        if (Auth::check() && Auth::user()->role === 'tenant') {
            // Get property IDs where the tenant has a completed payment
            $rentedPropertyIds = Payment::where('tenant_id', Auth::id())
                ->where('status', 'completed')
                ->pluck('property_id')
                ->unique();

            // Include available properties and properties the tenant has rented
            $query->where(function ($q) use ($rentedPropertyIds) {
                $q->where('status', 'available')
                  ->orWhereIn('id', $rentedPropertyIds);
            });
        } else {
            // Only show available properties for non-tenants or non-authenticated users
            $query->where('status', 'available');
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('property_type', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        if ($propertyType = $request->query('property_type')) {
            $query->where('property_type', $propertyType);
        }

        $properties = $query->paginate(9);

        $properties->appends($request->only('search', 'property_type'));

        $requestedPage = $request->query('page', 1);
        $requestedPage = max(1, (int) $requestedPage);
        $lastPage = $properties->lastPage();

        if ($requestedPage > $lastPage) {
            return redirect()->route('houses', array_merge(
                $request->only('search', 'property_type'),
                ['page' => $lastPage]
            ));
        }

        return view('houses', compact('properties'));
    }

    public function show($id)
    {
        $property = Property::with(['user', 'reviews.user'])->findOrFail($id);

        // Allow tenants with a completed payment to access the property, regardless of status
        if (Auth::check() && Auth::user()->role === 'tenant') {
            $hasPaid = Payment::where('tenant_id', Auth::id())
                ->where('property_id', $property->id)
                ->where('status', 'completed')
                ->exists();

            if ($hasPaid || $property->status === 'available') {
                $relatedProperties = Property::where('status', 'available')
                    ->where('id', '!=', $id)
                    ->where('property_type', $property->property_type)
                    ->inRandomOrder()
                    ->limit(3)
                    ->get();

                $reviews = $property->reviews()->latest()->get();

                return view('house-detail', compact('property', 'reviews', 'relatedProperties'));
            }
        }

        // For non-tenants or tenants without a payment, restrict to available properties
        if ($property->status !== 'available') {
            abort(404, 'This property is not currently available');
        }

        $relatedProperties = Property::where('status', 'available')
            ->where('id', '!=', $id)
            ->where('property_type', $property->property_type)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $reviews = $property->reviews()->latest()->get();

        return view('house-detail', compact('property', 'reviews', 'relatedProperties'));
    }
}