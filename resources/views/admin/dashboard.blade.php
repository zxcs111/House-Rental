<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Haven Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">
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
            <h1>Welcome, Admin {{ $name }} to the Dashboard</h1>
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
    <script>
        // Pass PHP data to JavaScript
        const rentedPerMonth = @json($rentedPerMonth);
        const rentedPerWeek = @json($rentedPerWeek);
        const propertyTypes = @json($propertyTypes);

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

        // Rented Trends Line Chart with tab switching
        const rentedCtx = document.getElementById('rentedChart').getContext('2d');
        if (rentedCtx) {
            let chart = new Chart(rentedCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [
                        {
                            label: 'Rented Properties',
                            data: [
                                rentedPerMonth[1] || 0,
                                rentedPerMonth[2] || 0,
                                rentedPerMonth[3] || 0,
                                rentedPerMonth[4] || 0,
                                rentedPerMonth[5] || 0
                            ],
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
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
                            max: Math.max(...Object.values(rentedPerMonth).filter(v => v > 0), 10) + 5,
                            ticks: { stepSize: 5 }
                        }
                    },
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Tab switching logic
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function() {
                    const tab = this.getAttribute('data-tab');
                    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    if (tab === 'month') {
                        chart.data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
                        chart.data.datasets[0].data = [
                            rentedPerMonth[1] || 0,
                            rentedPerMonth[2] || 0,
                            rentedPerMonth[3] || 0,
                            rentedPerMonth[4] || 0,
                            rentedPerMonth[5] || 0
                        ];
                        chart.options.scales.y.max = Math.max(...Object.values(rentedPerMonth).filter(v => v > 0), 10) + 5;
                    } else if (tab === 'week') {
                        chart.data.labels = ['May 1-4', 'May 5-11', 'May 12-18'];
                        chart.data.datasets[0].data = rentedPerWeek;
                        chart.options.scales.y.max = Math.max(...rentedPerWeek.filter(v => v > 0), 5) + 5;
                    }
                    chart.update();
                });
            });
        } else {
            console.error('Rented Chart canvas not found');
        }

        // Types of Properties Pie Chart
        document.addEventListener('DOMContentLoaded', function() {
            const propertyTypesCtx = document.getElementById('propertyTypesChart')?.getContext('2d');
            if (propertyTypesCtx) {
                const filteredPropertyTypes = Object.fromEntries(
                    Object.entries(propertyTypes).filter(([_, value]) => value > 0)
                );
                const labels = Object.keys(filteredPropertyTypes).length > 0 ? Object.keys(filteredPropertyTypes) : ['No Data'];
                const data = Object.keys(filteredPropertyTypes).length > 0 ? Object.values(filteredPropertyTypes) : [1];

                new Chart(propertyTypesCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: labels.map((label) => {
                                const colors = {
                                    'Apartment': '#FF6384',
                                    'House': '#36A2EB',
                                    'Condo': '#FFCE56',
                                    'Townhouse': '#4BC0C0',
                                    'Duplex': '#9966FF',
                                    'Studio': '#FF9F40',
                                    'No Data': '#D3D3D3'
                                };
                                return colors[label] || '#D3D3D3';
                            }),
                            borderWidth: 1,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15
                                }
                            },
                            tooltip: {
                                enabled: Object.keys(filteredPropertyTypes).length > 0,
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
                console.log('Property Types Chart initialized successfully');
            } else {
                console.error('Property Types Chart canvas not found');
            }
        });
    </script>
</body>
</html>