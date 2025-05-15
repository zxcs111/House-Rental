<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Log the visit
        Visit::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'page_url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'visited_at' => now(),
        ]);

        // Get 4 properties with status 'available'
        $featuredProperties = Property::where('status', Property::STATUS_AVAILABLE)
            ->with('user')
            ->latest()
            ->take(4)
            ->get();
            
        return view('welcome', compact('featuredProperties'));
    }
}