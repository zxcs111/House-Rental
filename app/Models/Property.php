<?php

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
        'status',
        'available_from',
        'amenities',
        'main_image',
        'gallery_images'
    ];

    protected $casts = [
        'amenities' => 'array',
        'gallery_images' => 'array',
        'available_from' => 'date',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_AVAILABLE = 'available';
    const STATUS_RENTED = 'rented';
    const STATUS_MAINTENANCE = 'maintenance';

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending Approval',
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_RENTED => 'Rented',
            self::STATUS_MAINTENANCE => 'Under Maintenance',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tenants()
    {
        return $this->hasManyThrough(
            User::class,
            Payment::class,
            'property_id',
            'id',
            'id',
            'tenant_id'
        );
    }

    public function getMainImageUrlAttribute()
    {
        return $this->main_image ? asset('storage/'.$this->main_image) : asset('user-template/images/house-placeholder.jpg');
    }

    public function getGalleryImagesUrlsAttribute()
    {
        if (!$this->gallery_images) return [];
        
        return array_map(function($image) {
            return asset('storage/'.$image);
        }, $this->gallery_images);
    }

    // Helper methods for status
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function isRented()
    {
        return $this->status === self::STATUS_RENTED;
    }

    public function isUnderMaintenance()
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }
}