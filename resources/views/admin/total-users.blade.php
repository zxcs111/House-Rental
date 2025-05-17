<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Total Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/total-user.css') }}">
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
        <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i><span>Reports</span></a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Welcome, Admin {{ $name }} to the Users</h1>
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
                                    <button class="view-details-btn" data-user-id="{{ $user->id }}">
                                        <i class="fas fa-eye"></i> View Details
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">No users found</td>
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
                <p><strong>Name:</strong> <span id="user-name"></span></p>
                <p><strong>Email:</strong> <span id="user-email"></span></p>
                <p><strong>Role:</strong> <span id="user-role"></span></p>
                <p><strong>Created At:</strong> <span id="user-created-at"></span></p>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Set up CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Toggle sidebar on mobile
        const sidebar = document.querySelector('.sidebar');
        const menuToggle = document.querySelector('.menu-toggle');
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                console.log('Sidebar toggled');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768 && sidebar.classList.contains('open') && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('open');
                    console.log('Sidebar closed');
                }
            });
        }

        // Toggle user dropdown on click
        const userTrigger = document.querySelector('.user-trigger');
        if (userTrigger) {
            userTrigger.addEventListener('click', function() {
                const user = this.parentElement;
                user.classList.toggle('active');
                document.querySelector('.notifications')?.classList.remove('active');
                console.log('User dropdown toggled');
            });
        }

        // Toggle notification dropdown on click
        const notificationTrigger = document.querySelector('.notification-trigger');
        if (notificationTrigger) {
            notificationTrigger.addEventListener('click', function() {
                const notifications = this.parentElement;
                notifications.classList.toggle('active');
                document.querySelector('.user')?.classList.remove('active');
                console.log('Notification dropdown toggled');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const user = document.querySelector('.user');
            const userTrigger = document.querySelector('.user-trigger');
            const notifications = document.querySelector('.notifications');
            const notificationTrigger = document.querySelector('.notification-trigger');

            if (user && userTrigger && !userTrigger.contains(event.target) && !user.querySelector('.dropdown').contains(event.target)) {
                user.classList.remove('active');
                console.log('User dropdown closed');
            }
            if (notifications && notificationTrigger && !notificationTrigger.contains(event.target) && !notifications.querySelector('.notification-dropdown').contains(event.target)) {
                notifications.classList.remove('active');
                console.log('Notification dropdown closed');
            }
        });

        // Modal handling for Edit Profile and Add User
        const editProfileBtn = document.getElementById('edit-profile-btn');
        const editProfileModal = document.getElementById('edit-profile-modal');
        const addUserBtn = document.getElementById('add-user-btn');
        const addUserModal = document.getElementById('add-user-modal');
        const closes = document.querySelectorAll('.modal .close');

        if (editProfileBtn && editProfileModal) {
            editProfileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                editProfileModal.classList.add('active');
                document.querySelector('.user')?.classList.remove('active');
                console.log('Edit profile modal opened');
            });
        }

        if (addUserBtn && addUserModal) {
            addUserBtn.addEventListener('click', function(e) {
                e.preventDefault();
                addUserModal.classList.add('active');
                console.log('Add user modal opened');
            });
        }

        closes.forEach(close => {
            close.addEventListener('click', () => {
                editProfileModal?.classList.remove('active');
                addUserModal?.classList.remove('active');
                const userModal = document.getElementById('user-details-modal');
                if (userModal) {
                    userModal.classList.remove('active');
                }
                console.log('Modal closed');
            });
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
                console.log('Modal closed by clicking outside');
            }
        });

        // Profile picture preview
        const profilePictureInput = document.getElementById('profile_picture');
        const profilePicturePreview = document.getElementById('profile-picture-preview-img');
        if (profilePictureInput && profilePicturePreview) {
            profilePictureInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePicturePreview.src = e.target.result;
                        console.log('Profile picture preview updated');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // View Details button handling
        document.querySelectorAll('.view-details-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('View Details button clicked');
                const userId = this.getAttribute('data-user-id');
                console.log('User ID:', userId);

                const modal = document.getElementById('user-details-modal');
                if (!modal) {
                    console.error('User details modal not found');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Modal element not found.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    return;
                }

                $.ajax({
                    url: `/total-users/${userId}`,
                    method: 'GET',
                    success: function(response) {
                        console.log('AJAX Success:', response);
                        if (response.success) {
                            const user = response.data;

                            // Populate modal fields
                            document.getElementById('user-name').textContent = user.name || 'N/A';
                            document.getElementById('user-email').textContent = user.email || 'N/A';
                            document.getElementById('user-role').textContent = user.role || 'User';
                            document.getElementById('user-created-at').textContent = user.created_at || 'N/A';

                            // Show modal
                            console.log('Showing user details modal');
                            modal.classList.add('active');
                        } else {
                            console.error('Response error:', response.message);
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to load user details.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.status, xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to load user details.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            });
        });

        // Add User form submission
        const addUserForm = document.getElementById('add-user-form');
        if (addUserForm) {
            addUserForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Add User form submitted');

                $.ajax({
                    url: addUserForm.action,
                    method: 'POST',
                    data: $(addUserForm).serialize(),
                    success: function(response) {
                        console.log('AJAX Success:', response);
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                addUserModal.classList.remove('active');
                                window.location.reload(); // Refresh to show new user
                            });
                        } else {
                            console.error('Response error:', response.message);
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to create user.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.status, xhr.responseText);
                        let errorMessage = 'Failed to create user.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join(' ');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            });
        }

        // Close user details modal
        const userModal = document.getElementById('user-details-modal');
        if (userModal) {
            userModal.querySelector('.close').addEventListener('click', () => {
                console.log('User modal close button clicked');
                userModal.classList.remove('active');
            });

            userModal.addEventListener('click', function(event) {
                if (event.target === this) {
                    console.log('Clicked outside user modal');
                    this.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>