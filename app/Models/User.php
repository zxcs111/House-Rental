<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string|null $profile_picture
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone_number
 * @property string|null $address
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'amount',
        'tenant_id',
        'landlord_id',
        'property_id',
        'email_verification_code',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeFilterByRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    /**
     * Payments made by this user as a tenant
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'tenant_id');
    }

    /**
     * Properties rented by this user (as tenant)
     */
    public function rentedProperties(): HasManyThrough
    {
        return $this->hasManyThrough(
            Property::class,
            Payment::class,
            'tenant_id',    
            'id',           
            'id',           
            'property_id'   
        )->distinct();
    }

    /**
     * Payments received by this user (as landlord)
     */
    public function receivedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'landlord_id');
    }

    /**
     * Properties owned by this user (as landlord)
     */
    public function ownedProperties(): HasMany
    {
        return $this->hasMany(Property::class, 'landlord_id');
    }

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture ? asset('storage/' . $this->profile_picture) : null;
    }
}