<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_id',
        'recipient_id', 
        'property_id',
        'message',
        'is_read',
        'deleted_by_sender',
        'deleted_by_recipient'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
