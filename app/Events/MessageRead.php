<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRead implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $senderId;
    public $recipientId;

    public function __construct($senderId, $recipientId)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->senderId);
    }

    public function broadcastAs()
    {
        return 'message.read';
    }
}