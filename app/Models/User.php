<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'first_name',      
        'last_name',      
        'phone_number',   
        'address', 
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // In App\Models\User.php
    public function scopeFilterByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // app/Models/User.php
    public function payments()
    {
        return $this->hasMany(Payment::class, 'tenant_id');
    }

    // app/Models/User.php
    public function rentedProperties()
    {
        return $this->hasManyThrough(
            Property::class,
            Payment::class,
            'landlord_id', // Foreign key on payments table
            'id', // Foreign key on properties table
            'id', // Local key on users table
            'property_id' // Local key on payments table
        )->distinct();
    }

    public function receivedPayments()
    {
        return $this->hasMany(Payment::class, 'landlord_id')->with(['property', 'tenant']);
    }
}