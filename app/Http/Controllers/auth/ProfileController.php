<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Payment;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $payments = [];

        if (Auth::user()->role === 'tenant') {
            $query = Payment::where('tenant_id', Auth::id())
                            ->where('hidden_by_tenant', false)
                            ->with(['property', 'landlord'])
                            ->orderBy('created_at', 'desc');

            $requestedPage = $request->query('page', 1);
            
            $payments = $query->paginate(5);

            if ($requestedPage > $payments->lastPage()) {
                return redirect()->route('profile', ['page' => $payments->lastPage()]);
            }
        }

        return view('auth.profile', compact('payments'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|regex:/^[\w\.-]+@gmail\.com$/',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete('public/profile/' . $user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile', 'public');
            $user->profile_picture = $path;
        }

        if ($request->has('name')) {
            $user->name = $request->input('name', $user->name);
        }

        if ($request->has('email')) {
            $email = $request->input('email');
            if (preg_match('/^[\w\.-]+@gmail\.com$/', $email)) {
                $user->email = $email;
            } else {
                return redirect()->route('profile')->with('error', 'Email must be a valid Gmail address!');
            }
        }

        $user->first_name = $request->input('first_name', $user->first_name);
        $user->last_name = $request->input('last_name', $user->last_name);
        $user->phone_number = $request->input('phone_number', $user->phone_number);
        $user->address = $request->input('address', $user->address);
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function hidePayment(Request $request, $id)
    {
        if (Auth::user()->role !== 'tenant') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $tenant = Auth::user();

        $payment = Payment::where('tenant_id', $tenant->id)
                         ->findOrFail($id);

        $payment->hidden_by_tenant = true;
        $payment->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaction hidden successfully'
        ]);
    }
}