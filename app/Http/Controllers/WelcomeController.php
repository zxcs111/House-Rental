<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Get 4 properties with status 'available'
        $featuredProperties = Property::where('status', Property::STATUS_AVAILABLE)
            ->with('user')
            ->latest()
            ->take(4)
            ->get();
            
        return view('welcome', compact('featuredProperties'));
    }
}