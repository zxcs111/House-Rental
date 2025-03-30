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
        'notes',
        'cancellation_requested',
        'cancellation_reason',
        'cancellation_status',
        'rejection_reason'
    ];

    // app/Models/Payment.php
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cancellation_requested' => 'boolean'
    ];

    public function scopePendingCancellations($query)
    {
        return $query->where('cancellation_requested', true)
                    ->where('cancellation_status', 'pending');
    }

    public function isCancelled()
    {
        return $this->cancellation_status === 'approved';
    }
    

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