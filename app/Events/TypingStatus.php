<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TypingStatus implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $senderId;
    public $recipientId;
    public $isTyping;

    public function __construct($senderId, $recipientId, $isTyping)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->isTyping = $isTyping;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->recipientId);
    }

    public function broadcastAs()
    {
        return 'typing.status';
    }
}