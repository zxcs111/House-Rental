<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TotalUserController extends Controller
{
    public function totaluser(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

        // Fetch paginated users with optional search
        $search = $request->query('search');
        $query = User::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(12);
        $name = Auth::guard('admin')->user()->name;
        $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
                                    ->whereNull('read_at')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('admin.total-users', compact('users', 'name', 'notifications', 'search'));
    }

    public function show($id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        $user = User::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ?? 'User',
                'is_active' => $user->is_active,
                'created_at' => $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : null,
            ]
        ]);
    }

    public function create()
    {
        // Not needed for modal-based creation, but kept for compatibility
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access this page.');
        }

        return response()->json([
            'success' => true,
            'message' => 'Use the modal in total-users page to create a user.'
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:Tenant,Landlord'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }
}