<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Haven - Admin Analytics Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/reports.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar">
        <div class="logo">Stay Haven</div>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.properties') }}"><i class="fas fa-home"></i><span>Properties</span></a>
        <a href="{{ route('admin.total-users') }}"><i class="fas fa-users"></i><span>Users</span></a>
        <a href="{{ route('admin.transactions') }}"><i class="fas fa-money-bill-wave"></i><span>Transactions</span></a>
        <a href="{{ route('admin.reports') }}" class="active"><i class="fas fa-chart-line"></i><span>Analytics</span></a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Welcome, Admin {{ $name }} to the Analytics Dashboard</h1>
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
                        <img class="small-img" src="{{ Auth::guard('admin')->user()->profile_picture_url ?? asset('user-template/images/default-user.png') }}" alt="User">
                        <span class="name">{{ Auth::guard('admin')->user()->name }}</span>
                    </div>
                    <div class="dropdown">
                        <div class="profile-header">
                            <img src="{{ Auth::guard('admin')->user()->profile_picture_url ?? asset('user-template/images/default-user.png') }}" alt="Profile">
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

        <!-- Analytics Section -->
        <div class="analytics-section">
            <a href="{{ route('admin.reports.download') }}" class="download-report-btn"><i class="fas fa-download"></i> Download Report</a>
            <div class="metrics-grid">
                <div class="card">
                    <h3>Total Transactions</h3>
                    <p>{{ number_format($totalTransactions ?? 0) }}</p>
                </div>
                <div class="card">
                    <h3>Total Revenue</h3>
                    <p>${{ number_format($totalRevenue ?? 0, 2) }}</p>
                </div>
                <div class="card">
                    <h3>Average Property Price</h3>
                    <p>${{ number_format($avgPropertyPrice ?? 0, 2) }}</p>
                </div>
                <div class="card">
                    <h3>Total Landlords</h3>
                    <p>{{ number_format($totalLandlords ?? 0) }}</p>
                </div>
                <div class="card">
                    <h3>Total Tenants</h3>
                    <p>{{ number_format($totalTenants ?? 0) }}</p>
                </div>
            </div>

            <div class="charts-grid">
                <div class="chart-container">
                    <h3>User Registrations by Month</h3>
                    <canvas id="userRegistrationsChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Monthly Revenue</h3>
                    <canvas id="revenueChart"></canvas>
                </div>

                <div class="chart-container">
                    <h3>Property Price Range Distribution</h3>
                    <canvas id="priceRangeChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Payment Method Distribution</h3>
                    <canvas id="paymentMethodChart"></canvas>
                </div>
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
                    <img id="profile-picture-preview-img" src="{{ Auth::guard('admin')->user()->profile_picture_url ?? asset('user-template/images/default-user.png') }}" alt="Profile Preview">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('user-template/js/dashboard.js') }}"></script>
    <script>
        window.chartData = {
            userRegistrationsLabels: <?php echo json_encode($chartLabels ?? []); ?>,
            userRegistrationsData: <?php echo json_encode($chartData ?? []); ?>,
            priceRangeLabels: <?php echo json_encode($priceRangeLabels ?? []); ?>,
            priceRangeData: <?php echo json_encode($priceRangeData ?? []); ?>,
            paymentMethodLabels: <?php echo json_encode($paymentMethodLabels ?? []); ?>,
            paymentMethodData: <?php echo json_encode($paymentMethodData ?? []); ?>,
            revenueLabels: <?php echo json_encode($revenueLabels ?? []); ?>,
            revenueData: <?php echo json_encode($revenueData ?? []); ?>
        };
    </script>
    <script src="{{ asset('user-template/js/reports.js') }}"></script>
</body>
</html>