<?php

namespace App\Http\Controllers\Tenant;  // Correct namespace

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role !== 'tenant') {
            return redirect()->back();
        }

        return view('tenant.contact');
    }
}