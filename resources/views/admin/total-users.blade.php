<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Haven - Admin Total Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/total-user.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar">
        <div class="logo">Stay Haven</div>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.properties') }}"><i class="fas fa-home"></i><span>Properties</span></a>
        <a href="{{ route('admin.total-users') }}" class="active"><i class="fas fa-users"></i><span>Users</span></a>
        <a href="{{ route('admin.transactions') }}"><i class="fas fa-money-bill-wave"></i><span>Transactions</span></a>
        <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i><span>Anayltics</span></a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Welcome, Admin {{ $name }} to the Users Page</h1>
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
                <form action="{{ route('admin.total-users') }}" method="GET">
                    <input type="text" name="search" placeholder="Search by name or email..." value="{{ $search ?? '' }}">
                    <button type="submit"><i class="fas fa-search"></i> Search</button>
                </form>
                <button class="add-user-btn" id="add-user-btn">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </div>
            <div class="table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Email Verified</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role ?? 'User' }}</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="status status-verified">
                                            Verified<br>
                                        </span>
                                    @else
                                        <span class="status status-not-verified">
                                            Not Verified
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="status status-verified">Active</span>
                                    @else
                                        <span class="status status-not-verified">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="view-details-btn" data-user-id="{{ $user->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="edit-user-btn" data-user-id="{{ $user->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="delete-user-btn" data-user-id="{{ $user->id }}">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container">
            <div class="pagination">
                @if($users->onFirstPage())
                    <span class="disabled"><i class="fas fa-arrow-left arrow"></i></span>
                @else
                    <a href="{{ $users->previousPageUrl() }}"><i class="fas fa-arrow-left arrow"></i></a>
                @endif

                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}"><i class="fas fa-arrow-right arrow"></i></a>
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

    <!-- User Details Modal -->
    <div id="user-details-modal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>User Details</h2>
            <div id="user-details-content">
                <!-- Content will be dynamically populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="add-user-modal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Add New User</h2>
            <form id="add-user-form" action="{{ route('admin.store-user') }}" method="POST">
                @csrf
                <label for="add-user-name">Name</label>
                <input type="text" id="add-user-name" name="name" required>
                <label for="add-user-email">Email</label>
                <input type="email" id="add-user-email" name="email" required>
                <label for="add-user-password">Password</label>
                <input type="password" id="add-user-password" name="password" required>
                <label for="add-user-role">Role</label>
                <select id="add-user-role" name="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="Tenant">Tenant</option>
                    <option value="Landlord">Landlord</option>
                </select>
                <button type="submit">Create User</button>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="edit-user-modal" class="modal">
        <div class="modal-content">
            <span class="close">×</span>
            <h2>Edit User</h2>
            <form id="edit-user-form" method="POST">
                @csrf
                <input type="hidden" id="edit-user-id" name="id">
                <label for="edit-user-name">Name</label>
                <input type="text" id="edit-user-name" name="name" required>
                <label for="edit-user-email">Email</label>
                <input type="email" id="edit-user-email" name="email" required>
                <label for="edit-user-password">New Password (optional)</label>
                <input type="password" id="edit-user-password" name="password">
                <label for="edit-user-role">Role</label>
                <select id="edit-user-role" name="role" required>
                    <option value="" disabled>Select Role</option>
                    <option value="Tenant">Tenant</option>
                    <option value="Landlord">Landlord</option>
                </select>
                <label for="edit-user-status">Status</label>
                <select id="edit-user-status" name="is_active" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <button type="submit">Update User</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('user-template/js/total-user.js') }}"></script>
    <script src="{{ asset('user-template/js/dashboard.js') }}"></script>


    <script>
        const userDetailRoute = "{{ route('admin.user-detail', ':id') }}";
        const addUserRoute = "{{ route('admin.store-user') }}";
        const editUserRoute = "{{ route('admin.edit-user', ':id') }}";
        const updateUserRoute = "{{ route('admin.update-user', ':id') }}";
        const deleteUserRoute = "{{ route('admin.delete-user', ':id') }}";

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": 3000,
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "backgroundColor": "#ffffff",
            "color": "#333333",
            "border": "1px solid #ddd",
            "boxShadow": "0 4px 6px rgba(0, 0, 0, 0.1)"
        };
    </script>
</body>
</html>