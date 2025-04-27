<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role !== 'tenant') {
            return redirect()->back();
        }

        return view('tenant.contact');
    }

    public function sendMessage(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ];

        try {
            Mail::to('johnlloydjustiniane13@gmail.com')->send(new ContactMessage($data));
            return response()->json([
                'message' => 'Your message has been sent successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to send your message. Please try again later.',
            ], 500);
        }
    }
}