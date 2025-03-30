<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class HouseController extends Controller
{
    /**
     * Display all available properties
     */
    public function index()
    {
        $properties = Property::where('status', 'available')
                    ->with('user')
                    ->latest()
                    ->paginate(12);
        
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
            
        return view('house-detail', compact('property', 'relatedProperties'));
    }
}