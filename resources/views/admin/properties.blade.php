<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Properties</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin: 20px 0;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
            scrollbar-width: thin; /* Firefox */
            scrollbar-color: #ced4da #f4f4f4; /* Firefox */
        }

        .table-container::-webkit-scrollbar {
            height: 8px; /* Chrome, Safari */
        }

        .table-container::-webkit-scrollbar-track {
            background: #f4f4f4;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #ced4da;
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: #a8b0b8;
        }

        .properties-table {
            width: 100%;
            min-width: 900px; /* Ensures columns don't collapse */
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .properties-table th,
        .properties-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .properties-table th {
            background: #f4f4f4;
            font-weight: 600;
        }

        .properties-table tr:hover {
            background: #f9f9f9;
        }

        .property-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .status {
            padding: 5px 10px;
            border-radius: 12px;
            color: #fff;
            font-size: 12px;
        }

        .status-pending {
            background: #ffa500;
        }

        .status-available {
            background: #28a745;
        }

        .status-rented {
            background: #dc3545;
        }

        .status-maintenance {
            background: #6c757d;
        }

        .status-disapproved {
            background: #6c757d;
        }

        .action-buttons {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .approve-btn, .disapprove-btn {
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            color: #fff;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
            border-radius: 4px;
        }

        .approve-btn {
            background: #28a745;
        }

        .approve-btn:hover {
            background: #218838;
        }

        .disapprove-btn {
            background: #dc3545;
        }

        .disapprove-btn:hover {
            background: #c82333;
        }

        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-start;
        }

        .search-container form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-container input[type="text"] {
            padding: 8px;
            width: 250px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }

        .search-container button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .pagination-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            padding: 10px;
            position: relative;
            z-index: 1;
            visibility: visible !important;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination .disabled {
            color: #6c757d;
            cursor: not-allowed;
            border-color: #ced4da;
        }

        .pagination .arrow {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }

            .approve-btn, .disapprove-btn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }

            .properties-table th,
            .properties-table td {
                padding: 8px;
            }

            .property-image {
                width: 60px;
                height: 45px;
            }

            .search-container input[type="text"] {
                width: 200px;
            }

            .modal-content {
                width: 95%;
            }

            .pagination-container {
                justify-content: center;
                padding: 15px;
            }

            .pagination a, .pagination span {
                padding: 6px 10px;
                font-size: 12px;
            }

            .table-container {
                margin: 15px 0;
                padding-bottom: 10px; /* Space for scrollbar */
            }
        }

        @media (max-width: 480px) {
            .search-container input[type="text"] {
                width: 150px;
            }

            .pagination a, .pagination span {
                padding: 5px 8px;
                font-size: 12px;
            }

            .table-container {
                margin: 10px 0;
            }

            .properties-table th,
            .properties-table td {
                padding: 6px;
                font-size: 12px;
            }

            .property-image {
                width: 50px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar">
        <div class="logo">Stay Haven</div>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.properties') }}" class="active"><i class="fas fa-home"></i><span>Properties</span></a>
        <a href="{{ route('admin.bookings') }}"><i class="fas fa-calendar-check"></i><span>Booked Property</span></a>
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
                                            <form action="{{ route('admin.properties.approve', $property->id) }}" method="POST" class="action-form">
                                                @csrf
                                                <button type="submit" class="approve-btn">
                                                    <i class="fas fa-check-circle"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.properties.disapprove', $property->id) }}" method="POST" class="action-form">
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
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768 && sidebar.classList.contains('open') && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Toggle user dropdown on click
        document.querySelector('.user-trigger').addEventListener('click', function() {
            const user = this.parentElement;
            user.classList.toggle('active');
            document.querySelector('.notifications').classList.remove('active');
        });

        // Toggle notification dropdown on click
        document.querySelector('.notification-trigger').addEventListener('click', function() {
            const notifications = this.parentElement;
            notifications.classList.toggle('active');
            document.querySelector('.user').classList.remove('active');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const user = document.querySelector('.user');
            const userTrigger = document.querySelector('.user-trigger');
            const notifications = document.querySelector('.notifications');
            const notificationTrigger = document.querySelector('.notification-trigger');

            if (!userTrigger.contains(event.target) && !user.querySelector('.dropdown').contains(event.target)) {
                user.classList.remove('active');
            }
            if (!notificationTrigger.contains(event.target) && !notifications.querySelector('.notification-dropdown').contains(event.target)) {
                notifications.classList.remove('active');
            }
        });

        // Modal handling
        const editProfileBtn = document.getElementById('edit-profile-btn');
        const editProfileModal = document.getElementById('edit-profile-modal');
        const closes = document.querySelectorAll('.modal .close');

        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (editProfileModal) {
                    editProfileModal.classList.add('active');
                }
                document.querySelector('.user').classList.remove('active');
            });
        }

        closes.forEach(close => {
            close.addEventListener('click', () => {
                if (editProfileModal) {
                    editProfileModal.classList.remove('active');
                }
            });
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                if (editProfileModal) {
                    editProfileModal.classList.remove('active');
                }
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
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Handle form submissions with SweetAlert2 and AJAX
        document.querySelectorAll('.action-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const action = form.action.includes('approve') ? 'approve' : 'disapprove';
                const propertyTitle = form.closest('tr').querySelector('td:nth-child(2)').textContent;

                Swal.fire({
                    title: `Are you sure you want to ${action} this property?`,
                    text: `Property: ${propertyTitle}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: action === 'approve' ? '#28a745' : '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: `Yes, ${action}!`
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.action,
                            method: 'POST',
                            data: $(form).serialize(),
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#28a745'
                                    }).then(() => {
                                        window.location.reload(); // Maintain pagination/search
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message || 'Something went wrong.',
                                        icon: 'error',
                                        confirmButtonColor: '#dc3545'
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.error('AJAX Error:', xhr.status, xhr.responseText);
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Failed to process the request.',
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
