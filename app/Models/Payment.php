<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $property_id
 * @property int $tenant_id
 * @property int $landlord_id
 * @property float $amount
 * @property string $payment_method
 * @property string|null $transaction_id
 * @property string $status
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string|null $notes
 * @property bool $cancellation_requested
 * @property string|null $cancellation_reason
 * @property string|null $cancellation_status
 * @property string|null $rejection_reason
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
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
        'start_date', // Keep start_date
        'notes',
        'cancellation_requested',
        'cancellation_reason',
        'cancellation_status',
        'rejection_reason'
    ];

    protected $casts = [
        'start_date' => 'date', // Keep start_date cast
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'cancellation_requested' => 'boolean',
        'amount' => 'float'
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