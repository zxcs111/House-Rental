<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'notes',
        'cancellation_requested',
        'cancellation_reason',
        'cancellation_status',
        'rejection_reason',
        'hidden', // Keep for backward compatibility if needed
        'hidden_by_tenant',
        'hidden_by_landlord',
    ];

    protected $casts = [
        'start_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cancellation_requested' => 'boolean',
        'amount' => 'float',
        'hidden_by_tenant' => 'boolean',
        'hidden_by_landlord' => 'boolean',
    ];

    public function scopePendingCancellations($query)
    {
        return $query->where('cancellation_requested', true)
                    ->where('cancellation_status', 'pending');
    }

    public function isCancelled(): bool
    {
        return $this->cancellation_status === 'approved';
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function landlord(): BelongsTo
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }
}