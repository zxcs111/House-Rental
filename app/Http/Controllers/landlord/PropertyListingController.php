<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyListingController extends Controller
{
    private function authorizeLandlord()
    {
        if (Auth::user()->role !== 'landlord') {
            abort(403, 'Unauthorized access. Landlord privileges required.');
        }
    }

    public function index()
    {
        $this->authorizeLandlord();
        $properties = Property::where('user_id', Auth::id())->latest()->get();
        return view('landlord.propertylisting', compact('properties'));
    }

    public function store(Request $request)
    {
        $this->authorizeLandlord();
        
        $validated = $this->validatePropertyData($request);
        $validated = $this->handleImageUploads($request, $validated);
        
        $property = Property::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'pending',
            'amenities' => json_encode($request->amenities ?? []) 
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Property created successfully! It will be available after admin approval.',
            'property' => $property,
            'isNew' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorizeLandlord();
        $property = Property::where('user_id', Auth::id())->findOrFail($id);
        
        $validated = $this->validatePropertyData($request, true);
        $validated = $this->handleImageUploads($request, $validated, $property);
        
        // Only update status if it's provided and property is already approved
        if ($request->has('status') && 
            ($property->status === 'available' || $property->status === 'maintenance')) {
            $validated['status'] = $request->status;
        } else {
            unset($validated['status']);
        }
        
        $property->update(array_merge($validated, [
            'amenities' => json_encode($request->amenities ?? [])
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Property updated successfully!',
            'property' => $property,
            'isNew' => false
        ]);
    }

    public function edit($id)
    {
        $this->authorizeLandlord();
        $property = Property::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($property);
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorizeLandlord();
        $property = Property::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:available,maintenance'
        ]);
        
        // Only allow changing between available and maintenance for approved properties
        if ($property->status === 'available' || $property->status === 'maintenance') {
            $property->update(['status' => $request->status]);
            
            return response()->json([
                'success' => true,
                'message' => 'Property status updated successfully!',
                'property' => $property
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'You can only change status between Available and Maintenance for approved properties'
        ], 403);
    }

    public function destroy($id)
    {
        $this->authorizeLandlord();
        $property = Property::where('user_id', Auth::id())->findOrFail($id);
        
        $this->deletePropertyImages($property);
        $property->delete();

        return redirect()->route('property.listing')->with('success', 'Property deleted successfully!');
    }

    private function validatePropertyData(Request $request, $isUpdate = false)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'square_feet' => 'required|integer|min:0',
            'property_type' => 'required|string',
            'available_from' => 'nullable|date',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ];

        if (!$isUpdate) {
            $rules['main_image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:10240';
        } else {
            $rules['main_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240';
        }

        return $request->validate($rules);
    }

    private function handleImageUploads(Request $request, array $validated, Property $property = null)
    {
        if ($request->hasFile('main_image')) {
            if ($property && $property->main_image) {
                Storage::disk('public')->delete($property->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('properties', 'public');
        } elseif ($property && !$request->hasFile('main_image')) {
            $validated['main_image'] = $property->main_image;
        }

        if ($request->hasFile('gallery_images')) {
            if ($property && $property->gallery_images) {
                $this->deleteImages(json_decode($property->gallery_images, true));
            }
            
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $image->store('properties/gallery', 'public');
            }
            $validated['gallery_images'] = json_encode($galleryPaths);
        } elseif ($property && !$request->hasFile('gallery_images')) {
            $validated['gallery_images'] = $property->gallery_images;
        }

        return $validated;
    }

    private function deletePropertyImages(Property $property)
    {
        if ($property->main_image) {
            Storage::disk('public')->delete($property->main_image);
        }
        
        if ($property->gallery_images) {
            $this->deleteImages(json_decode($property->gallery_images, true));
        }
    }

    private function deleteImages(array $images)
    {
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }
    }
}