<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class HouseController extends Controller
{
    /**
     * Display all available properties
     */
    public function index(Request $request)
{
    // Start the query for available properties
    $query = Property::where('status', 'available')
                ->with('user')
                ->latest();

    // Handle search by property_type, city, or title
    if ($search = $request->query('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('property_type', 'like', "%{$search}%")
              ->orWhere('city', 'like', "%{$search}%")
              ->orWhere('title', 'like', "%{$search}%");
        });
    }

    // Handle filtering by property_type
    if ($propertyType = $request->query('property_type')) {
        $query->where('property_type', $propertyType);
    }

    // Handle price range filtering
    if ($minPrice = $request->query('min_price')) {
        $query->where('price', '>=', $minPrice);
    }

    if ($maxPrice = $request->query('max_price')) {
        $query->where('price', '<=', $maxPrice);
    }

    $properties = $query->paginate(3);

    $properties->appends($request->only('search', 'property_type', 'min_price', 'max_price'));

    $requestedPage = $request->query('page', 1);
    $requestedPage = max(1, (int) $requestedPage);
    $lastPage = $properties->lastPage();

    if ($requestedPage > $lastPage) {
        return redirect()->route('houses', array_merge(
            $request->only('search', 'property_type', 'min_price', 'max_price'),
            ['page' => $lastPage]
        ));
    }

    return view('houses', compact('properties'));
}

    public function show($id)
    {
        $property = Property::with('user')->findOrFail($id);
        
        // Optional: Prevent access to rented property details
        if ($property->status !== 'available') {
            abort(404, 'This property is not currently available');
        }
            
        $relatedProperties = Property::where('status', 'available')
            ->where('id', '!=', $id)
            ->where('property_type', $property->property_type)
            ->inRandomOrder()
            ->limit(3)
            ->get();
            
        return view('house-detail', compact('property'));
    }
}