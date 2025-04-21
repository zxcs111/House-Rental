<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Review;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Property $property)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if user is a tenant
        if (Auth::user()->role !== 'tenant') {
            return response()->json(['error' => 'Only tenants can submit reviews.'], 403);
        }

        // Check if user has a completed payment for the property
        $hasPaid = Payment::where('tenant_id', Auth::id())
            ->where('property_id', $property->id)
            ->where('status', 'completed')
            ->exists();

        if (!$hasPaid) {
            return response()->json(['error' => 'You must rent this property to leave a review.'], 403);
        }

        // Check if user has already reviewed this property
        $existingReview = Review::where('user_id', Auth::id())
            ->where('property_id', $property->id)
            ->exists();

        if ($existingReview) {
            return response()->json(['error' => 'You have already reviewed this property.'], 422);
        }

        $review = Review::create([
            'property_id' => $property->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Your review has been submitted successfully!',
            'review' => [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->format('d M Y'),
                'user' => [
                    'name' => Auth::user()->name,
                    'profile_picture' => Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('user-template/images/person_1.jpg'),
                ],
            ],
        ]);
    }
}