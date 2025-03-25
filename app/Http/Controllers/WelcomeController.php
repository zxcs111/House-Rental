<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get 4 available properties
        $featuredProperties = Property::where('is_available', true)
            ->with('user')
            ->latest()
            ->take(4)
            ->get();
            
        return view('welcome', compact('featuredProperties'));
    }
}