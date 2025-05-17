<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Properties</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/properties.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar">
        <div class="logo">Stay Haven</div>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.properties') }}" class="active"><i class="fas fa-home"></i><span>Properties</span></a>
        <a href="{{ route('admin.total-users') }}"><i class="fas fa-users"></i><span>Users</span></a>
        <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i><span>Reports</span></a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Welcome, Admin {{ $name }} to the Properties</h1>
            <div class="header-right">
                <div class="notifications">
                    <div class="notification-trigger">
                        <i class="fas fa-bell"></i>
                        <span class="badge">{{ $notifications->count() }}</span>
                    </div>
                    <div class="notification-dropdown">
                        <div class="notification-header">
                            Notifications
                            @if($notifications->isNotEmpty())
                                <form action="{{ route('admin.notifications.markAsRead') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="mark-all-read">Mark All as Read</button>
                                </form>
                            @endif
                        </div>
                        @if($notifications->isEmpty())
                            <div class="no-notifications">No new notifications</div>
                        @else
                            @foreach($notifications as $notification)
                                <div class="notification-item">
                                    <i class="fas fa-check-circle notification-icon"></i>
                                    <div class="notification-content">
                                        <div class="message">
                                            @if($notification->type === 'property_approved')
                                                Property "{{ $notification->data['property_title'] }}" approved
                                            @elseif($notification->type === 'property_disapproved')
                                                Property "{{ $notification->data['property_title'] }}" disapproved
                                            @else
                                                {{ $notification->type }}
                                            @endif
                                        </div>
                                        <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="user">
                    <div class="user-trigger">
                        <img class="small-img" src="{{ Auth::guard('admin')->user()->profile_picture_url }}" alt="User">
                        <span class="name">{{ Auth::guard('admin')->user()->name }}</span>
                    </div>
                    <div class="dropdown">
                        <div class="profile-header">
                            <img src="{{ Auth::guard('admin')->user()->profile_picture_url }}" alt="Profile">
                            <div class="name">{{ Auth::guard('admin')->user()->name }}</div>
                        </div>
                        <div class="profile-buttons">
                            <a href="#" id="edit-profile-btn" class="dropdown-action">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="dropdown-form">
                                @csrf
                                <button type="submit" class="dropdown-action logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="search-container">
                <form action="{{ route('admin.properties') }}" method="GET">
                    <input type="text" name="search" placeholder="Search by title, property type, or landlord name..." value="{{ $search ?? '' }}">
                    <button type="submit"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
            <div class="table-container">
                <table class="properties-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Property Name</th>
                            <th>Owner</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $property)
                            <tr>
                                <td>
                                    <img src="{{ $property->main_image_url }}" alt="{{ $property->title }}" class="property-image">
                                </td>
                                <td>{{ $property->title }}</td>
                                <td>{{ $property->landlord->name ?? 'N/A' }}</td>
                                <td>${{ number_format($property->price, 2) }}</td>
                                <td>{{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}</td>
                                <td>
                                    <span class="status status-{{ $property->status }}">
                                        {{ App\Models\Property::getStatuses()[$property->status] }}
                                    </span>
                                    @if($property->isPending())
                                        <div class="action-buttons">
                                            <form action="{{ route('admin.properties.approve', $property->id) }}" method="POST" class="action-form" data-action="approve">
                                                @csrf
                                                <button type="submit" class="approve-btn">
                                                    <i class="fas fa-check-circle"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.properties.disapprove', $property->id) }}" method="POST" class="action-form" data-action="disapprove">
                                                @csrf
                                                <button type="submit" class="disapprove-btn">
                                                    <i class="fas fa-times-circle"></i> Disapprove
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">No properties found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container">
            <div class="pagination">
                @if($properties->onFirstPage())
                    <span class="disabled"><i class="fas fa-arrow-left arrow"></i></span>
                @else
                    <a href="{{ $properties->previousPageUrl() }}"><i class="fas fa-arrow-left arrow"></i></a>
                @endif

                @if($properties->hasMorePages())
                    <a href="{{ $properties->nextPageUrl() }}"><i class="fas fa-arrow-right arrow"></i></a>
                @else
                    <span class="disabled"><i class="fas fa-arrow-right arrow"></i></span>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="edit-profile-modal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Edit Profile</h2>
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="profile_picture">Profile Picture</label>
                <div class="profile-picture-preview">
                    <img id="profile-picture-preview-img" src="{{ Auth::guard('admin')->user()->profile_picture_url }}" alt="Profile Preview">
                </div>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ Auth::guard('admin')->user()->name }}" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ Auth::guard('admin')->user()->email }}" required>
                <label for="password">New Password (optional)</label>
                <input type="password" id="password" name="password">
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('user-template/js/properties.js') }}"></script>
    
</body>
</html>
