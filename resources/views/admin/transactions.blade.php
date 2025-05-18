<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Haven - Admin Transactions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/transactions.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar">
        <div class="logo">Stay Haven</div>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.properties') }}"><i class="fas fa-home"></i><span>Properties</span></a>
        <a href="{{ route('admin.total-users') }}"><i class="fas fa-users"></i><span>Users</span></a>
        <a href="{{ route('admin.transactions') }}" class="active"><i class="fas fa-money-bill-wave"></i><span>Transactions</span></a>
        <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i><span>Reports</span></a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Welcome, Admin {{ $name }} to the Transactions Page</h1>
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
        <!-- Header and other sections remain unchanged -->
        <div class="main-content">
            <div class="search-container">
                <form action="{{ route('admin.transactions') }}" method="GET">
                    <input type="text" name="search" placeholder="Search by transaction ID, tenant, or landlord..." value="{{ request()->query('search') ?? '' }}">
                    <button type="submit"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
            <div class="table-container">
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Tenant</th>
                            <th>Landlord</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Cancellation Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_id }}</td>
                                <td>{{ $transaction->tenant ? $transaction->tenant->name : 'N/A' }}</td>
                                <td>{{ $transaction->landlord ? $transaction->landlord->name : 'N/A' }}</td>
                                <td>${{ number_format($transaction->amount, 2) }}</td>
                                <td>{{ $transaction->payment_method }}</td>
                                <td>
                                    <span class="status status-{{ strtolower($transaction->status) }}">
                                        {{ $transaction->status }}
                                    </span>
                                </td>
                                <td>{{ $transaction->start_date->format('Y-m-d') }}</td>
                                <td>{{ $transaction->cancellation_status ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center;">No transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container">
            <div class="pagination">
                @if($transactions->onFirstPage())
                    <span class="disabled"><i class="fas fa-arrow-left arrow"></i></span>
                @else
                    <a href="{{ $transactions->previousPageUrl() }}"><i class="fas fa-arrow-left arrow"></i></a>
                @endif

                @if($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}"><i class="fas fa-arrow-right arrow"></i></a>
                @else
                    <span class="disabled"><i class="fas fa-arrow-right arrow"></i></span>
                @endif
            </div>
        </div>
    </div>

    <!-- Rest of your HTML (modal, scripts) remains unchanged -->
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                "paging": false,
                "searching": false,
                "info": false
            });
        });
    </script>
</body>
</html>