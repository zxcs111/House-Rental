<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password', 'profile_picture',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture && file_exists(public_path('storage/profile/' . $this->profile_picture))) {
            return asset('storage/profile/' . $this->profile_picture) . '?t=' . time();
        }
        return 'https://via.placeholder.com/150';
    }
}