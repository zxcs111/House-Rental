<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role !== 'tenant') {
            return redirect()->back();
        }

        return view('tenant.about');
    }
}