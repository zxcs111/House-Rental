<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Property;

class PropertyController extends Controller
{
    public function property(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You must log in as an admin to access the dashboard.');
        }

            $name = Auth::guard('admin')->user()->name;

            $search = $request->query('search', '');

            $query = Property::with('landlord')->latest();

            // Apply search filter
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('property_type', 'like', '%' . $search . '%')
                      ->orWhereHas('landlord', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
                });
            }

            $properties = $query->paginate(8);

            $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
                ->whereNull('read_at')
                ->latest()
                ->take(5)
                ->get();

            return view('admin.properties', compact('name', 'notifications', 'properties', 'search'));
    }

    public function approve(Property $property)
    {
        if (!$property->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Property is not pending approval.'
            ], 400);
        }

        $property->update(['status' => Property::STATUS_AVAILABLE]);

        // Create notification for the landlord
        Notification::create([
            'user_id' => $property->user_id,
            'admin_id' => Auth::guard('admin')->id(),
            'type' => 'property_approved',
            'data' => [
                'property_title' => $property->title,
                'message' => "Your property '{$property->title}' has been approved.",
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Property approved successfully.'
        ]);
    }

    public function disapprove(Property $property)
    {
        if (!$property->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Property is not pending approval.'
            ], 400);
        }

        $property->update(['status' => Property::STATUS_PENDING]); // Or delete if disapproval means rejection
        // Alternatively: $property->delete();

        // Create notification for the landlord
        Notification::create([
            'user_id' => $property->user_id,
            'admin_id' => Auth::guard('admin')->id(),
            'type' => 'property_disapproved',
            'data' => [
                'property_title' => $property->title,
                'message' => "Your property '{$property->title}' has been disapproved.",
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Property disapproved successfully.'
        ]);
    }


}