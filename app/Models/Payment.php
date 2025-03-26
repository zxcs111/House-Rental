<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'landlord_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'start_date',
        'end_date',
        'notes'
    ];

    // app/Models/Payment.php
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }
}