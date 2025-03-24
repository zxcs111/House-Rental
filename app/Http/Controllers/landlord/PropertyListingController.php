<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyListingController extends Controller
{
    /**
     * Check if the authenticated user is a landlord
     */
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
            'amenities' => json_encode($request->amenities ?? [])
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Property created successfully!',
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

    public function destroy($id)
    {
        $this->authorizeLandlord();
        $property = Property::where('user_id', Auth::id())->findOrFail($id);
        
        $this->deletePropertyImages($property);
        $property->delete();

        return redirect()->route('property.listing')->with('success', 'Property deleted successfully!');
    }


    /**
     * Validate property data
     */
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
            'is_available' => 'required|boolean',
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

    /**
     * Handle image uploads for property
     */
    private function handleImageUploads(Request $request, array $validated, Property $property = null)
    {
        // Handle main image
        if ($request->hasFile('main_image')) {
            if ($property && $property->main_image) {
                Storage::disk('public')->delete($property->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('properties', 'public');
        } elseif ($property && !$request->hasFile('main_image')) {
            $validated['main_image'] = $property->main_image;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images if they exist
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

    /**
     * Delete property images
     */
    private function deletePropertyImages(Property $property)
    {
        if ($property->main_image) {
            Storage::disk('public')->delete($property->main_image);
        }
        
        if ($property->gallery_images) {
            $this->deleteImages(json_decode($property->gallery_images, true));
        }
    }

    /**
     * Delete multiple images from storage
     */
    private function deleteImages(array $images)
    {
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }
    }
}