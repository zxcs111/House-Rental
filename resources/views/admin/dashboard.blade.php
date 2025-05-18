<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Haven - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">
</head>
<body>
    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar">
        <div class="logo">Stay Haven</div>
        <a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.properties') }}"><i class="fas fa-home"></i><span>Properties</span></a>
        <a href="{{ route('admin.total-users') }}"><i class="fas fa-users"></i><span>Users</span></a>
        <a href="{{ route('admin.transactions') }}"><i class="fas fa-money-bill-wave"></i><span>Transactions</span></a>
        <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i><span>Reports</span></a>
    </div>
    <div class="content">
        <div class="header">
            <h1>Welcome, Admin {{ $name }} to the Dashboard Page</h1>
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
                <h3>Rented Trends</h3>
                <div class="tabs">
                    <button class="tab-button active" data-tab="month">Month</button>
                    <button class="tab-button" data-tab="week">Week</button>
                </div>
                <canvas id="rentedChart"></canvas>
            </div>
            <div class="right-column">
                <div class="chart-container">
                    <h3>Types of Available Properties</h3>
                    <canvas id="propertyTypesChart" style="max-height: 300px;"></canvas>
                    <div class="available-properties-list">
                        @foreach(['Apartment', 'House', 'Condo', 'Townhouse', 'Duplex', 'Studio'] as $type)
                            <!-- Property type list remains unchanged -->
                        @endforeach
                    </div>
                </div>
                <div class="pending-properties">
                    <h3>Pending Properties</h3>
                    @if($pendingProperties->isEmpty())
                        <p class="text-center text-muted">No pending properties at the moment.</p>
                    @else
                        @foreach($pendingProperties as $property)
                            <div class="property">
                                <span>{{ $property->title }} - {{ $property->landlord->name ?? 'Unknown Landlord' }}</span>
                                <a href="{{ route('admin.properties') }}" class="approve-btn">
                                    <i class="fas fa-home"></i> Go to Properties
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="bottom-section">
            <div class="recent-orders">
                <h3>Rented Properties</h3>
                @if($recentRentedProperties->isEmpty())
                    <p class="text-center text-muted">No rented properties at the moment.</p>
                @else
                    @foreach($recentRentedProperties as $property)
                        <div class="booking">
                            <span>{{ $property->title }} - {{ $property->price }} - {{ $property->property_type }}</span>
                            <span>{{ $property->latest_payment ? $property->latest_payment->start_date->format('Y-m-d') : 'N/A' }}</span>
                        </div>
                    @endforeach
                @endif
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Pass PHP data to JavaScript
        window.rentedPerMonth = @json($rentedPerMonth);
        window.rentedPerWeek = @json($rentedPerWeek);
        window.propertyTypes = @json($propertyTypes);
    </script>
    <script src="{{ asset('user-template/js/dashboard.js') }}"></script>
</body>
</html>