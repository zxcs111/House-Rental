<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AboutController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'tenant') {
            return Redirect::to(url()->previous());
        }

        return view('tenant.about');
    }
}