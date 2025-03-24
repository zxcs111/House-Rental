<?php

// app/Models/Property.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'price',
        'bedrooms',
        'bathrooms',
        'square_feet',
        'property_type',
        'is_available',
        'available_from',
        'amenities',
        'main_image',
        'gallery_images'
    ];

    protected $casts = [
        'amenities' => 'array',
        'gallery_images' => 'array',
        'is_available' => 'boolean',
        'available_from' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}