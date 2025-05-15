<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Haven Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f7fa;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #fff;
            position: fixed;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .sidebar .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 30px;
            display: block;
            white-space: nowrap;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
            color: #6c757d;
            margin-bottom: 10px;
            font-size: 14px;
            white-space: nowrap;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .sidebar a:hover {
            background-color: #f0f0f0;
        }
        .sidebar a.active {
            background-color: #007bff;
            color: #fff;
        }
        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #343a40;
        }
        .header .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .header .notifications {
            position: relative;
            cursor: pointer;
        }
        .header .notifications .notification-trigger {
            position: relative;
            display: flex;
            align-items: center;
        }
        .header .notifications .notification-trigger i {
            font-size: 20px;
            color: #343a40;
            transition: color 0.2s;
        }
        .header .notifications .notification-trigger:hover i {
            color: #007bff;
        }
        .header .notifications .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
        .header .notifications .notification-dropdown {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1;
            width: 300px;
            padding: 15px;
            border-radius: 8px;
        }
        .header .notifications.active .notification-dropdown {
            display: block;
        }
        .header .notifications .notification-dropdown .notification-header {
            font-size: 16px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 15px;
            border-bottom: 1px solid #007bff;
            padding-bottom: 10px;
        }
        .header .notifications .notification-dropdown .notification-item {
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
            color: #343a40;
            transition: background-color 0.2s;
        }
        .header .notifications .notification-dropdown .notification-item:hover {
            background-color: #f8f9fa;
        }
        .header .notifications .notification-dropdown .notification-item:last-child {
            border-bottom: none;
        }
        .header .notifications .notification-dropdown .notification-item .time {
            font-size: 12px;
            color: #6c757d;
        }
        .header .user {
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        .header .user .user-trigger {
            display: flex;
            align-items: center;
            padding: 5px;
            border-radius: 20px;
            transition: background-color 0.2s;
        }
        .header .user .user-trigger:hover {
            background-color: #f0f0f0;
        }
        .header .user .small-img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
            border-radius: 50%;
            object-fit: cover;
        }
        .header .user .name {
            font-size: 14px;
            color: #343a40;
            font-weight: 500;
        }
        .header .user .dropdown {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1;
            width: 250px;
            padding: 15px;
            border-radius: 8px;
        }
        .header .user.active .dropdown {
            display: block;
        }
        .header .user .dropdown .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        .header .user .dropdown .profile-header img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            border-radius: 50%;
            object-fit: cover;
        }
        .header .user .dropdown .profile-header .name {
            font-size: 16px;
            font-weight: bold;
            color: #343a40;
        }
        .header .user .dropdown .profile-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }
        .header .user .dropdown .profile-buttons button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
            transition: background-color 0.2s;
            text-align: center;
        }
        .header .user .dropdown .profile-buttons button:hover {
            background-color: #0056b3;
        }
        .header .user .dropdown form {
            margin: 0;
        }
        .header .user .dropdown button.logout {
            padding: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
            transition: background-color 0.2s;
            text-align: center;
            width: 100%;
        }
        .header .user .dropdown button.logout:hover {
            background-color: #c82333;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .card {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: left;
            border-radius: 8px;
        }
        .card h3 {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin: 0;
        }
        .card .change {
            font-size: 14px;
            margin-top: 5px;
        }
        .card .change.positive {
            color: #28a745;
        }
        .card .info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        .charts {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .chart-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            flex: 1;
            border-radius: 8px;
        }
        .chart-container h3 {
            font-size: 16px;
            color: #343a40;
            margin-bottom: 10px;
        }
        .chart-container .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .chart-container .tabs button {
            padding: 5px 15px;
            border: 1px solid #007bff;
            background-color: #fff;
            color: #007bff;
            cursor: pointer;
            font-size: 12px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .chart-container .tabs button:hover {
            background-color: #f0f0f0;
        }
        .chart-container .tabs button.active {
            background-color: #007bff;
            color: #fff;
        }
        .chart-container .revenue {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
        }
        .right-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
        }
        .pending-properties {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .pending-properties h3 {
            font-size: 16px;
            color: #343a40;
            margin-bottom: 15px;
        }
        .pending-properties .property {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .pending-properties .property:last-child {
            border-bottom: none;
        }
        .pending-properties .property span {
            font-size: 14px;
            color: #343a40;
        }
        .pending-properties .property button {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.2s;
        }
        .pending-properties .property button:hover {
            background-color: #218838;
        }
        .bottom-section {
            display: flex;
            gap: 20px;
        }
        .recent-orders, .analytics-report {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            flex: 1;
            border-radius: 8px;
        }
        .recent-orders h3, .analytics-report h3 {
            font-size: 16px;
            color: #343a40;
            margin-bottom: 15px;
        }
        .recent-orders .booking {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
            color: #343a40;
        }
        .recent-orders .booking:last-child {
            border-bottom: none;
        }
        .analytics-report p {
            font-size: 14px;
            color: #6c757d;
        }
        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            z-index: 1100;
        }
        .menu-toggle i {
            font-size: 20px;
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            position: relative;
        }
        .modal-content h2 {
            font-size: 20px;
            color: #343a40;
            margin-bottom: 20px;
        }
        .modal-content .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            color: #6c757d;
            cursor: pointer;
            transition: color 0.2s;
        }
        .modal-content .close:hover {
            color: #343a40;
        }
        .modal-content form label {
            display: block;
            font-size: 14px;
            color: #343a40;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .modal-content form input[type="text"],
        .modal-content form input[type="email"],
        .modal-content form input[type="password"],
        .modal-content form input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }
        .modal-content form input[type="file"] {
            padding: 3px;
        }
        .modal-content form .profile-picture-preview {
            margin-bottom: 15px;
            text-align: center;
        }
        .modal-content form .profile-picture-preview img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }
        .modal-content form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
        }
        .modal-content form button:hover {
            background-color: #0056b3;
        }
        /* Responsive Design */
        @media (max-width: 1024px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
            .charts {
                flex-direction: column;
            }
            .right-column {
                flex-direction: column;
            }
            .bottom-section {
                flex-direction: column;
            }
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
            .menu-toggle {
                display: block;
            }
            .stats {
                grid-template-columns: 1fr;
            }
            .header h1 {
                font-size: 20px;
            }
            .header .user .dropdown {
                width: 200px;
            }
            .header .notifications .notification-dropdown {
                width: 250px;
            }
        }
        @media (max-width: 480px) {
            .header .user .small-img {
                width: 25px;
                height: 25px;
            }
            .header .user .name {
                font-size: 12px;
            }
            .header .user .dropdown {
                width: 180px;
            }
            .header .user .dropdown .profile-header img {
                width: 40px;
                height: 40px;
            }
            .header .user .dropdown .profile-buttons button {
                font-size: 12px;
                padding: 8px;
            }
            .header .notifications .notification-dropdown {
                width: 200px;
            }
            .modal-content {
                width: 95%;
            }
            .modal-content .profile-picture-preview img {
                width: 80px;
                height: 80px;
            }

            .card .change.negative {
                color: #dc3545; /* Red color for negative change */
            }

          
        }
    </style>
</head>
<body>
    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar">
        <div class="logo">Stay Haven</div>
        <a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.properties') }}"><i class="fas fa-home"></i><span>Properties</span></a>
        <a href="{{ route('admin.bookings') }}"><i class="fas fa-calendar-check"></i><span>Booked Property</span></a>
        <a href="{{ route('admin.total-users') }}"><i class="fas fa-users"></i><span>Users</span></a>
        <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i><span>Reports</span></a>
    </div>
    <div class="content">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="header-right">
                <div class="notifications">
                    <div class="notification-trigger">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="notification-dropdown">
                        <div class="notification-header">Notifications</div>
                        <div class="notification-item">
                            New booking for Beachfront Villa
                            <div class="time">5 minutes ago</div>
                        </div>
                        <div class="notification-item">
                            Property approval pending for Mountain Cabin
                            <div class="time">1 hour ago</div>
                        </div>
                        <div class="notification-item">
                            New user registered
                            <div class="time">2 hours ago</div>
                        </div>
                    </div>
                </div>
                <div class="user">
                    <div class="user-trigger">
                        <img class="small-img" src="{{ Auth::guard('admin')->user()->profile_picture ? asset('storage/profiles/' . Auth::guard('admin')->user()->profile_picture) . '?t=' . time() : 'https://via.placeholder.com/30' }}" alt="User">
                        <span class="name">{{ Auth::guard('admin')->user()->name }}</span>
                    </div>
                    <div class="dropdown">
                        <div class="profile-header">
                            <img src="{{ Auth::guard('admin')->user()->profile_picture ? asset('storage/profiles/' . Auth::guard('admin')->user()->profile_picture) . '?t=' . time() : 'https://via.placeholder.com/50' }}" alt="Profile">
                            <div class="name">{{ Auth::guard('admin')->user()->name }}</div>
                        </div>
                        <div class="profile-buttons">
                            <button id="edit-profile-btn">Edit Profile</button>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="stats">
            <div class="card">
                <h3>Available Properties</h3>
                <p>{{ isset($listingsData) ? number_format($listingsData['total']) : '0' }}</p>
                <div class="change {{ isset($listingsData) && $listingsData['percentage_change'] >= 0 ? 'positive' : 'negative' }}">
                    {{ isset($listingsData) && $listingsData['percentage_change'] >= 0 ? '↑' : '↓' }} {{ isset($listingsData) ? abs($listingsData['percentage_change']) : '0' }}%
                </div>
                <div class="info">You approved {{ isset($listingsData) ? $listingsData['new_listings_this_year'] : '0' }} new listings this year</div>
            </div>
            <div class="card">
                <h3>Total Rented Properties</h3>
                <p>{{ isset($rentedData) ? number_format($rentedData['total']) : '0' }}</p>
                <div class="change {{ isset($rentedData) && $rentedData['percentage_change'] >= 0 ? 'positive' : 'negative' }}">
                    {{ isset($rentedData) && $rentedData['percentage_change'] >= 0 ? '↑' : '↓' }} {{ isset($rentedData) ? abs($rentedData['percentage_change']) : '0' }}%
                </div>
                <div class="info">{{ isset($rentedData) ? $rentedData['new_rented_this_year'] : '0' }} new rented properties this year</div>
            </div>
            <div class="card">
                <h3>Total Users</h3>
                <p>{{ isset($usersData) ? number_format($usersData['total']) : '0' }}</p>
                <div class="change {{ isset($usersData) && $usersData['percentage_change'] >= 0 ? 'positive' : 'negative' }}">
                    {{ isset($usersData) && $usersData['percentage_change'] >= 0 ? '↑' : '↓' }} {{ isset($usersData) ? abs($usersData['percentage_change']) : '0' }}%
                </div>
                <div class="info">You gained {{ isset($usersData) ? $usersData['new_users_this_year'] : '0' }} new users this year</div>
            </div>
            <div class="card">
                <h3>Total Visits</h3>
                <p>{{ isset($visitsData) ? number_format($visitsData['total']) : '0' }}</p>
                <div class="change {{ isset($visitsData) && $visitsData['percentage_change'] >= 0 ? 'positive' : 'negative' }}">
                    {{ isset($visitsData) && $visitsData['percentage_change'] >= 0 ? '↑' : '↓' }} {{ isset($visitsData) ? abs($visitsData['percentage_change']) : '0' }}%
                </div>
                <div class="info">You recorded {{ isset($visitsData) ? $visitsData['new_visits_this_year'] : '0' }} new visits this year</div>
            </div>
        </div>
        <div class="charts">
            <div class="chart-container" style="flex: 2;">
                <h3>Booking Trends</h3>
                <div class="tabs">
                    <button class="active">Month</button>
                    <button>Week</button>
                </div>
                <canvas id="bookingChart"></canvas>
            </div>
            <div class="right-column">
                <div class="chart-container">
                    <h3>Revenue This Week</h3>
                    <div class="revenue">$6,500</div>
                    <canvas id="revenueChart"></canvas>
                </div>
                <div class="pending-properties">
                    <h3>Pending Properties</h3>
                    @if($pendingProperties->isEmpty())
                        <p class="text-center text-muted">No pending properties at the moment.</p>
                    @else
                        @foreach($pendingProperties as $property)
                            <div class="property">
                                <span>{{ $property->title }} - {{ $property->landlord->name ?? 'Unknown Landlord' }}</span>
                                <form action="{{ route('admin.properties.approve', $property->id) }}" method="POST" class="approve-form" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="approve-btn">Approve</button>
                                </form>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="bottom-section">
            <div class="recent-orders">
                <h3>Recent Bookings</h3>
                <div class="booking">
                    <span>#001 - Beachfront Villa</span>
                    <span>2025-05-01</span>
                </div>
                <div class="booking">
                    <span>#002 - Mountain Cabin</span>
                    <span>2025-05-02</span>
                </div>
                <div class="booking">
                    <span>#003 - City Apartment</span>
                    <span>2025-05-03</span>
                </div>
            </div>
            <div class="analytics-report">
                <h3>Analytics Report</h3>
                <p>Summary of performance metrics, trends, and insights for the past month. Detailed report available for download.</p>
            </div>
        </div>
        <!-- Edit Profile Modal -->
        <div id="edit-profile-modal" class="modal">
            <div class="modal-content">
                <span class="close">×</span>
                <h2>Edit Profile</h2>
                <!-- Note: Ensure the route in routes/web.php is set to POST: Route::post('/admin/profile-update', [DashboardController::class, 'updateProfile'])->name('admin.profile.update'); -->
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="profile_picture">Profile Picture</label>
                    <div class="profile-picture-preview">
                        <img id="profile-picture-preview-img" src="{{ Auth::guard('admin')->user()->profile_picture ? asset('storage/profiles/' . Auth::guard('admin')->user()->profile_picture) . '?t=' . time() : 'https://via.placeholder.com/100' }}" alt="Profile Preview">
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
    </div>
    <script>
    
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
            // Close notification dropdown if open
            document.querySelector('.notifications').classList.remove('active');
        });

        // Toggle notification dropdown on click
        document.querySelector('.notification-trigger').addEventListener('click', function() {
            const notifications = this.parentElement;
            notifications.classList.toggle('active');
            // Close user dropdown if open
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

        editProfileBtn.addEventListener('click', () => {
            editProfileModal.classList.add('active');
            document.querySelector('.user').classList.remove('active');
        });

        closes.forEach(close => {
            close.addEventListener('click', () => {
                editProfileModal.classList.remove('active');
            });
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                editProfileModal.classList.remove('active');
            }
        });

        // Profile picture preview
        const profilePictureInput = document.getElementById('profile_picture');
        const profilePicturePreview = document.getElementById('profile-picture-preview-img');
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

        // Booking Trends Line Chart
        const bookingCtx = document.getElementById('bookingChart').getContext('2d');
        new Chart(bookingCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Bookings',
                        data: [50, 100, 80, 150, 90, 70, 110, 130, 60, 80, 40, 90],
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Cancellations',
                        data: [20, 50, 40, 70, 30, 20, 60, 40, 30, 20, 10, 30],
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23, 162, 184, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 180,
                        ticks: { stepSize: 40 }
                    }
                },
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Revenue Bar Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                datasets: [{
                    label: 'Revenue',
                    data: [900, 1200, 800, 1000, 600, 500, 700],
                    backgroundColor: '#17a2b8',
                    borderRadius: 0
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, display: false },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>

<script>
    document.querySelectorAll('.approve-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to approve this property?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
</body>
</html>