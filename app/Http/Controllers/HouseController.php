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
        $properties = Property::where('is_available', true)
            ->with('user') // Eager load the landlord/user relationship
            ->latest()
            ->paginate(12); // Paginate with 12 items per page
        
        return view('houses', compact('properties'));
    }

    /**
     * Display a single property detail
     */
    public function show($id)
    {
        $property = Property::with('user')
            ->where('is_available', true)
            ->findOrFail($id);
            
        $relatedProperties = Property::where('is_available', true)
            ->where('id', '!=', $id)
            ->where('property_type', $property->property_type)
            ->inRandomOrder()
            ->limit(3)
            ->get();
            
        return view('house-detail', compact('property'));
    }
}