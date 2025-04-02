<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Messages - Stay Haven</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('user-template/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/style.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);
            height: calc(100vh - 20px);
            margin: 10px;
        }
        
        .border-right {
            border-right: 1px solid #eee !important;
        }
        
        .chat-list {
            padding: 0;
            font-size: 0.9rem;
            height: calc(100% - 80px);
            overflow-y: auto;
        }
        
        .chat-list li {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .chat-list li:hover {
            background-color: #f5f5f5;
        }
        
        .chat-list li.active {
            background-color: #f0f7ff;
        }
        
        .chat-list li .badge {
            float: right;
        }
        
        .rounded-circle {
            border-radius: 50% !important;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        
        .chat-messages {
            display: flex;
            flex-direction: column;
            height: calc(100% - 150px);
            overflow-y: auto;
            padding: 1rem;
        }
        
        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0;
            margin-bottom: 1.5rem;
        }
        
        .chat-message-left {
            margin-right: auto;
        }
        
        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto;
        }
        
        .chat-message-text {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            max-width: 70%;
            word-wrap: break-word;
        }
        
        .chat-message-left .chat-message-text {
            background-color: #e8f1f3;
            margin-left: 1rem;
        }
        
        .chat-message-right .chat-message-text {
            background-color: #007bff;
            color: white;
            margin-right: 1rem;
        }
        
        .message-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 0.5rem;
            text-align: right;
        }
        
        .chat-message-right .message-time {
            color: rgba(255,255,255,0.7);
        }
        
        .typing-indicator {
            font-size: 0.8rem;
            color: #6c757d;
            font-style: italic;
            margin-left: 1rem;
            margin-bottom: 1rem;
        }
        
        .property-context {
            background-color: #e2f0fd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
        
        .no-conversation {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            padding: 20px;
        }
        
        .no-conversation-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 20px;
        }
        
        .conversation-header {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }
        
        .conversation-header .user-info {
            flex-grow: 1;
        }
        
        .delete-conversation {
            color: #dc3545;
            cursor: pointer;
        }
        
        .back-to-home {
            display: flex;
            align-items: center;
            color: #007bff;
            padding: 10px 15px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .back-to-home:hover {
            background-color: #e7f1ff;
            text-decoration: none;
        }
        
        .back-to-home i {
            margin-right: 8px;
        }
        
        .message-input-container {
            padding: 15px;
            border-top: 1px solid #eee;
            background: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        
        @media (max-width: 992px) {
            .messages-container {
                padding: 0 !important;
                height: 100vh;
            }
            
            .card {
                height: 100vh;
                margin: 0;
                border-radius: 0;
            }
            
            .border-right {
                border-right: none !important;
                border-bottom: 1px solid #eee !important;
                height: auto;
                max-height: 40vh;
                overflow-y: auto;
            }
            
            .chat-list {
                height: auto;
                max-height: calc(40vh - 80px);
            }
            
            .chat-messages {
                height: calc(60vh - 120px);
                margin-bottom: 70px;
                padding-bottom: 20px;
                max-height: none;
            }
            
            .conversation-header {
                position: sticky;
                top: 0;
                background: white;
                z-index: 100;
                padding: 10px 15px;
            }
            
            .message-input-container {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 100;
                padding: 10px;
            }
            
            .no-conversation {
                height: 60vh;
            }
            
            /* Conversation list improvements */
            .chat-list li {
                padding: 8px 12px;
            }
            
            .chat-list li .rounded-circle {
                width: 36px;
                height: 36px;
            }
            
            /* Message bubbles */
            .chat-message-text {
                max-width: 85%;
            }
            
            /* Hide back to home on mobile */
            .d-none.d-md-block {
                display: none !important;
            }
            
            /* Show mobile header */
            .mobile-header {
                display: flex !important;
                padding: 10px 15px;
                border-bottom: 1px solid #eee;
                align-items: center;
            }
        }
        
        @media (max-width: 576px) {
            .chat-message-text {
                max-width: 80%;
                padding: 0.6rem 0.8rem;
                font-size: 0.9rem;
            }
            
            .chat-messages {
                padding: 0.8rem;
            }
            
            .message-time {
                font-size: 0.7rem;
            }
            
            .conversation-header {
                padding: 8px 12px;
            }
            
            .message-input-container input {
                font-size: 0.9rem;
            }
        }
        
        /* Mobile header (hidden by default) */
        .mobile-header {
            display: none;
            background: white;
            position: sticky;
            top: 0;
            z-index: 101;
        }
        
        .mobile-header .back-button {
            margin-right: 10px;
            color: #007bff;
            font-size: 1.2rem;
        }
        
        /* Ensure proper scrolling */
        .chat-messages {
            -webkit-overflow-scrolling: touch;
        }
        
        .hero-wrap {
            background-image: url('user-template/images/house-landing.jpg');
            background-size: cover;
            background-position: center center;
        }
        
        .messages-container {
            height: 100vh;
            padding: 0;
        }
        
        .messages-row {
            height: 100%;
        }
        
        .messages-col {
            height: 100%;
            padding: 0;
        }
        
        .conversation-title {
            padding: 15px;
            margin: 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    
    <section class="ftco-section bg-light messages-container" style="padding: 0;">
        <div class="container-fluid h-100">
            <div class="row clearfix h-100">
                <div class="col-lg-12 h-100">
                    <div class="card h-100">
                        <div class="row g-0 h-100">
                            <div class="col-12 col-lg-5 col-xl-3 border-right h-100">
                                <div class="px-4 d-none d-md-block">
                                    <a href="{{ route('home') }}" class="back-to-home">
                                        <i class="fas fa-arrow-left"></i> Back to Home
                                    </a>
                                    <h4 class="conversation-title">Conversations</h4>
                                </div>
                                
                                <ul class="list-unstyled chat-list">
                                    @if($conversations->isEmpty())
                                        <div class="text-center py-5">
                                            <i class="fas fa-comments no-messages-icon"></i>
                                            <h4>No conversations yet</h4>
                                            <p class="text-muted">Start a conversation with a property owner or tenant</p>
                                        </div>
                                    @else
                                        @foreach($conversations as $conversation)
                                            <li class="clearfix {{ isset($recipient) && $recipient->id == $conversation['user']->id ? 'active' : '' }}" 
                                                onclick="window.location.href='{{ route('messages.conversation', $conversation['user']->id) }}'">
                                                <div class="d-flex align-items-start">
                                                    <img src="{{ $conversation['user']->profile_picture ? asset('storage/'.$conversation['user']->profile_picture) : asset('user-template/images/default-profile.png') }}" 
                                                         class="rounded-circle mr-1" alt="{{ $conversation['user']->name }}">
                                                    <div class="flex-grow-1 ml-3">
                                                        {{ $conversation['user']->name }}
                                                        <div class="small text-muted">
                                                            @if($conversation['last_message']->sender_id == Auth::id())
                                                                You: {{ Str::limit($conversation['last_message']->message, 20) }}
                                                            @else
                                                                {{ Str::limit($conversation['last_message']->message, 20) }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($conversation['unread_count'] > 0)
                                                        <span class="badge bg-primary">{{ $conversation['unread_count'] }}</span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            
                            <div class="col-12 col-lg-7 col-xl-9 h-100 d-flex flex-column">
                                @if(isset($recipient))
                                <div class="conversation-header">
                                    <div class="user-info">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $recipient->profile_picture ? asset('storage/'.$recipient->profile_picture) : asset('user-template/images/default-profile.png') }}" 
                                                 class="rounded-circle mr-2" alt="{{ $recipient->name }}">
                                            <div>
                                                <strong>{{ $recipient->name }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="delete-conversation" onclick="deleteConversation({{ $recipient->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </div>
                                </div>
                                
                                <div class="chat-messages" id="chat-container">
                                    @if(isset($property))
                                    <div class="property-context">
                                        <h5>Regarding Property: {{ $property->title }}</h5>
                                        <p class="mb-0">{{ $property->address }}</p>
                                    </div>
                                    @endif
                                    
                                    @foreach($messages as $message)
                                        <div class="{{ $message->sender_id == Auth::id() ? 'chat-message-right' : 'chat-message-left' }}">
                                            <div>
                                                <img src="{{ $message->sender_id == Auth::id() ? (Auth::user()->profile_picture ? asset('storage/'.Auth::user()->profile_picture) : asset('user-template/images/default-profile.png')) : ($recipient->profile_picture ? asset('storage/'.$recipient->profile_picture) : asset('user-template/images/default-profile.png')) }}" 
                                                     class="rounded-circle" alt="{{ $message->sender_id == Auth::id() ? Auth::user()->name : $recipient->name }}">
                                                <div class="message-time">
                                                    {{ $message->created_at->format('h:i A') }}
                                                    @if($message->sender_id == Auth::id())
                                                        @if($message->is_read)
                                                            <i class="fas fa-check-double ms-1" title="Read"></i>
                                                        @else
                                                            <i class="fas fa-check ms-1" title="Sent"></i>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="chat-message-text" data-message-id="{{ $message->id }}">
                                                {{ $message->message }}
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="typing-indicator" class="typing-indicator"></div>
                                </div>
                                
                                <div class="message-input-container">
                                    <form id="message-form">
                                        @csrf
                                        <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
                                        @if(isset($property))
                                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                                        @endif
                                        <div class="input-group">
                                            <input type="text" name="message" id="message-input" class="form-control" placeholder="Type your message" autocomplete="off" required>
                                            <button type="submit" id="send-button" class="btn btn-primary">Send</button>
                                        </div>
                                    </form>
                                </div>
                                @else
                                <div class="no-conversation">
                                    <i class="fas fa-comments no-conversation-icon"></i>
                                    <h4>Select a conversation</h4>
                                    <p class="text-muted">Choose a conversation from the list to start chatting</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

    <script src="{{ asset('user-template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('user-template/js/popper.min.js') }}"></script>
    <script src="{{ asset('user-template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('user-template/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('user-template/js/aos.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('user-template/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('user-template/js/scrollax.min.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('user-template/js/main.js') }}"></script>
    
    <script>
        $(window).on('load', function() {
            setTimeout(function(){
                $('#ftco-loader').removeClass('show');
            }, 1000);
        });

        $(document).ready(function() {
            setTimeout(function(){
                $('#ftco-loader').removeClass('show');
            }, 3000);
            
            @if(isset($recipient))
            // Scroll to bottom of chat
            scrollToBottom();
            
            // Initialize Pusher
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                forceTLS: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });

            // Connection monitoring
            pusher.connection.bind('state_change', function(states) {
                console.log('Pusher connection state:', states.current);
            });

            pusher.connection.bind('error', function(err) {
                console.error('Pusher error:', err);
            });

            // Get user IDs
            const currentUserId = {{ Auth::id() }};
            const recipientId = {{ $recipient->id }};
            
            // Subscribe to channels
            const receiveChannel = pusher.subscribe('private-chat.' + currentUserId);
            const typingChannel = pusher.subscribe('private-chat.' + recipientId);

            // Channel subscription events
            receiveChannel.bind('pusher:subscription_succeeded', () => {
                console.log('Subscribed to receive messages');
            });

            // Handle new messages
            receiveChannel.bind('new.message', function(data) {
                // Prevent duplicates
                if (!document.querySelector(`.chat-message-text[data-message-id="${data.message.id}"]`)) {
                    addMessageToChat(data.message);
                }
            });

            // Function to add message to chat UI
            function addMessageToChat(message) {
                const isSent = message.sender_id == currentUserId;
                const messageTime = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                const senderProfilePic = isSent ? 
                    '{{ Auth::user()->profile_picture ? asset('storage/'.Auth::user()->profile_picture) : asset('user-template/images/default-profile.png') }}' : 
                    '{{ $recipient->profile_picture ? asset('storage/'.$recipient->profile_picture) : asset('user-template/images/default-profile.png') }}';
                const senderName = isSent ? 'You' : '{{ $recipient->name }}';
                
                const messageHtml = `
                    <div class="${isSent ? 'chat-message-right' : 'chat-message-left'}">
                        <div>
                            <img src="${senderProfilePic}" class="rounded-circle" alt="${senderName}">
                            <div class="message-time">
                                ${messageTime}
                                ${isSent ? 
                                    (message.is_read ? 
                                        '<i class="fas fa-check-double ms-1" title="Read"></i>' : 
                                        '<i class="fas fa-check ms-1" title="Sent"></i>') : 
                                    ''}
                            </div>
                        </div>
                        <div class="chat-message-text" data-message-id="${message.id}">
                            ${message.message}
                        </div>
                    </div>
                `;
                
                document.getElementById('chat-container').insertAdjacentHTML('beforeend', messageHtml);
                scrollToBottom();
                
                // Mark as read if it's our own message
                if(isSent) {
                    markMessageAsRead(message.id);
                }
            }

            // Message read events
            receiveChannel.bind('message.read', function(data) {
                data.messageIds.forEach(messageId => {
                    const messageEl = document.querySelector(`.chat-message-text[data-message-id="${messageId}"]`);
                    if (messageEl) {
                        const checkIcon = messageEl.parentElement.querySelector('.fa-check');
                        if (checkIcon) {
                            checkIcon.classList.remove('fa-check');
                            checkIcon.classList.add('fa-check-double');
                            checkIcon.title = 'Read';
                        }
                    }
                });
            });

            // Typing indicator
            const messageInput = document.getElementById('message-input');
            const typingIndicator = document.getElementById('typing-indicator');
            let typingTimer;
            let isTyping = false;
            
            messageInput.addEventListener('input', () => {
                if(!isTyping) {
                    isTyping = true;
                    typingChannel.trigger('client-typing', {
                        senderId: currentUserId,
                        recipientId: recipientId,
                        isTyping: true
                    });
                }
                
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    isTyping = false;
                    typingChannel.trigger('client-typing', {
                        senderId: currentUserId,
                        recipientId: recipientId,
                        isTyping: false
                    });
                }, 2000);
            });

            // Listen for typing events
            typingChannel.bind('client-typing', function(data) {
                if(data.senderId === recipientId && data.recipientId === currentUserId) {
                    typingIndicator.textContent = data.isTyping ? '{{ $recipient->name }} is typing...' : '';
                }
            });

            // Message form submission
            document.getElementById('message-form').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const form = this;
                const formData = new FormData(form);
                const messageInput = form.querySelector('input[name="message"]');
                const sendButton = form.querySelector('button[type="submit"]');
                
                // Disable button during send
                sendButton.disabled = true;
                sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                
                try {
                    const response = await fetch('{{ route('messages.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Failed to send message');
                    }

                    const data = await response.json();
                    messageInput.value = '';
                    messageInput.focus();
                    
                    // Add the message to the UI immediately
                    addMessageToChat(data.message);
                    
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to send message. Please try again.');
                } finally {
                    sendButton.disabled = false;
                    sendButton.innerHTML = 'Send';
                }
            });

            // Mark message as read
            async function markMessageAsRead(messageId) {
                try {
                    await fetch('{{ route('messages.mark-as-read') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ message_id: messageId })
                    });
                } catch (error) {
                    console.error('Error marking message as read:', error);
                }
            }

            // Delete conversation
            window.deleteConversation = async function(recipientId) {
                if(confirm('Are you sure you want to delete this conversation? This will remove it from your inbox, but the other user will still see it.')) {
                    try {
                        const response = await fetch('{{ route('messages.delete-conversation') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ recipient_id: recipientId })
                        });

                        const data = await response.json();
                        
                        if (data.success) {
                            window.location.href = '{{ route('messages.index') }}';
                        } else {
                            throw new Error(data.message || 'Failed to delete conversation');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Failed to delete conversation. Please try again.');
                    }
                }
            }

            // Initial setup
            document.addEventListener('DOMContentLoaded', function() {
                scrollToBottom();
                
                // Mark existing unread messages as read
                const unreadMessages = @json($messages->where('sender_id', $recipient->id)->where('is_read', false)->pluck('id'));
                
                if(unreadMessages.length > 0) {
                    fetch('{{ route('messages.mark-conversation-read', $recipient->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                }
            });

            // Update read status when tab becomes visible
            document.addEventListener('visibilitychange', function() {
                if(document.visibilityState === 'visible') {
                    const unreadMessages = document.querySelectorAll('.chat-message-left .fa-check-double');
                    if(unreadMessages.length > 0) {
                        fetch('{{ route('messages.mark-conversation-read', $recipient->id) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                    }
                }
            });
            
            // Scroll to bottom function
            function scrollToBottom() {
                const container = document.getElementById('chat-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }
            @endif
        });
    </script>
</body>
</html>