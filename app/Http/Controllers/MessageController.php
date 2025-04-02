<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Message;
use App\Events\NewMessage;
use App\Events\MessageRead;
use App\Events\TypingStatus;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'property_id' => 'nullable|exists:properties,id',
            'message' => 'required|string|max:1000'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'property_id' => $request->property_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        // Load relationships
        $message->load('sender', 'recipient', 'property');

        // Broadcast the new message
        broadcast(new NewMessage($message))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }

    public function index()
    {
        // Get all unique conversations with last message and unread count
        $conversations = Message::with(['sender', 'recipient', 'property'])
                ->where(function($query) {
                    $query->where(function($q) {
                        $q->where('recipient_id', Auth::id())
                        ->where('deleted_by_recipient', false);
                    })
                    ->orWhere(function($q) {
                        $q->where('sender_id', Auth::id())
                        ->where('deleted_by_sender', false);
                    });
                })
            ->latest()
            ->get()
            ->groupBy(function($message) {
                return $message->sender_id == Auth::id() 
                    ? $message->recipient_id 
                    : $message->sender_id;
            })
            ->map(function($messages) {
                $otherUser = $messages->first()->sender_id == Auth::id()
                    ? $messages->first()->recipient
                    : $messages->first()->sender;
                
                $lastMessage = $messages->first();
                $unreadCount = $messages->where('recipient_id', Auth::id())
                                      ->where('is_read', false)
                                      ->count();

                return [
                    'user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'property' => $lastMessage->property
                ];
            })
            ->sortByDesc(function($conversation) {
                return $conversation['last_message']->created_at;
            });

        // If there are conversations, redirect to the first one
        if ($conversations->isNotEmpty()) {
            $firstConversation = $conversations->first();
            return redirect()->route('messages.conversation', $firstConversation['user']->id);
        }

        return view('messages.conversation', compact('conversations'));
    }

    public function conversation($userId, Request $request)
    {
        $recipient = User::findOrFail($userId);
        
        // Get all conversations for the sidebar
        $conversations = Message::with(['sender', 'recipient', 'property'])
            ->where(function($query) {
                $query->where('recipient_id', Auth::id())
                    ->orWhere('sender_id', Auth::id());
            })
            ->latest()
            ->get()
            ->groupBy(function($message) {
                return $message->sender_id == Auth::id() 
                    ? $message->recipient_id 
                    : $message->sender_id;
            })
            ->map(function($messages) {
                $otherUser = $messages->first()->sender_id == Auth::id()
                    ? $messages->first()->recipient
                    : $messages->first()->sender;
                
                $lastMessage = $messages->first();
                $unreadCount = $messages->where('recipient_id', Auth::id())
                                      ->where('is_read', false)
                                      ->count();

                return [
                    'user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'property' => $lastMessage->property
                ];
            })
            ->sortByDesc(function($conversation) {
                return $conversation['last_message']->created_at;
            });

        // Get messages for the current conversation with property relationship
        $messages = Message::with('property')
        ->where(function($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                ->where('recipient_id', $userId)
                ->where('deleted_by_sender', false);
        })
        ->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('recipient_id', Auth::id())
                ->where('deleted_by_recipient', false);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Check if this is about a specific property
        $property = null;
        if ($request->has('property_id')) {
            $property = Property::find($request->property_id);
        } elseif ($messages->isNotEmpty() && $messages->first()->property_id) {
            $property = Property::find($messages->first()->property_id);
        }

        // Mark messages as read
        $this->markConversationAsRead(Auth::id(), $userId);

        return view('messages.conversation', [
            'recipient' => $recipient,
            'messages' => $messages,
            'property' => $property,
            'conversations' => $conversations
        ]);
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:messages,id'
        ]);

        $message = Message::find($request->message_id);
        
        if ($message->recipient_id == Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true]);
            broadcast(new MessageRead($message->sender_id, Auth::id(), [$message->id]));
        }

        return response()->json(['status' => 'success']);
    }

    public function markConversationAsRead($userId)
    {
        $unreadMessages = Message::where('sender_id', $userId)
            ->where('recipient_id', Auth::id())
            ->where('is_read', false)
            ->get();

        if ($unreadMessages->isNotEmpty()) {
            Message::whereIn('id', $unreadMessages->pluck('id'))
                ->update(['is_read' => true]);

            broadcast(new MessageRead($userId, Auth::id(), $unreadMessages->pluck('id')->toArray()));
        }

        return response()->json(['status' => 'success']);
    }

    public function typingStatus(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'is_typing' => 'required|boolean'
        ]);

        broadcast(new TypingStatus(
            Auth::id(),
            $request->recipient_id,
            $request->is_typing
        ));

        return response()->json(['status' => 'success']);
    }

    public function unreadCount()
    {
        $count = Message::where('recipient_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
                    
        return response()->json(['count' => $count]);
    }

    public function deleteConversation(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id'
        ]);

        $userId = Auth::id();

        // Update messages where current user is the sender
        Message::where('sender_id', $userId)
            ->where('recipient_id', $request->recipient_id)
            ->update(['deleted_by_sender' => true]);

        // Update messages where current user is the recipient
        Message::where('sender_id', $request->recipient_id)
            ->where('recipient_id', $userId)
            ->update(['deleted_by_recipient' => true]);

        // Soft delete messages that both parties have deleted
        Message::where(function($query) use ($userId, $request) {
                $query->where('sender_id', $userId)
                    ->where('recipient_id', $request->recipient_id)
                    ->where('deleted_by_sender', true)
                    ->where('deleted_by_recipient', true);
            })
            ->orWhere(function($query) use ($userId, $request) {
                $query->where('sender_id', $request->recipient_id)
                    ->where('recipient_id', $userId)
                    ->where('deleted_by_sender', true)
                    ->where('deleted_by_recipient', true);
            })
            ->delete();

        return response()->json(['success' => true]);
    }

    // Add this new method to your MessageController
    public function getNewMessages($userId)
    {
        $messages = Message::with(['sender', 'property'])
            ->where(function($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->where('recipient_id', Auth::id())
                    ->where('deleted_by_recipient', false);
            })
            ->where('created_at', '>', now()->subSeconds(10)) // Get messages from last 10 seconds
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}