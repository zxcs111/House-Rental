<!DOCTYPE html>
<html lang="en">
<head>
    <title>Financial Reporting - Stay Haven</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding-top: 70px;
        }
        
        /* Main Content */
        .main-content {
            padding: 30px 0;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-header h2 {
            font-weight: 600;
            color: #2c3e50;
        }
        
        /* Card Styles (removed hover effects) */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: #2c3e50;
        }
        
        .card-value {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 10px 0;
        }
        
        .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .card-primary {
            border-left: 4px solid var(--primary-color);
        }
        
        .card-success {
            border-left: 4px solid var(--success-color);
        }
        
        .card-info {
            border-left: 4px solid var(--info-color);
        }
        
        /* Table Styles */
        .table {
            width: 100%;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            color: #2c3e50;
            border-top: none;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        /* Badge Styles */
        .badge {
            font-weight: 500;
            padding: 5px 10px;
        }
        
        .badge-success {
            background-color: var(--success-color);
        }
        
        .badge-warning {
            background-color: var(--warning-color);
            color: #212529;
        }
        
        .badge-danger {
            background-color: var(--danger-color);
        }
        
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .card-value {
                font-size: 1.5rem;
            }
            
            .main-content {
                padding: 20px 0;
            }
            
            .navbar-nav .nav-link {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
      <div class="container">
          <a class="navbar-brand" href="{{ route('home') }}">Stay<span> Haven</span></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="oi oi-menu"></span> Menu
          </button>

          <div class="collapse navbar-collapse" id="ftco-nav">
              <ul class="navbar-nav ml-auto">
                  @auth
                      @if(Auth::user()->role === 'tenant')
                          <!-- Tenant Menu Items -->
                          <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                          <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                          <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                          <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                          <li class="nav-item"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
                          <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                      @elseif(Auth::user()->role === 'landlord')
                          <!-- Landlord Menu Items -->
                          <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                          <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                          <li class="nav-item"><a href="{{ route('property.listing') }}" class="nav-link">Property Listing</a></li>
                          <li class="nav-item">
                              <a href="{{ route('landlord.cancellation-requests') }}" class="nav-link">
                                  Cancellation Requests
                                  @if(($pendingCancellationCount ?? 0) > 0)
                                      <span class="badge bg-danger">{{ $pendingCancellationCount }}</span>
                                  @endif
                              </a>
                          </li>
                          <li class="nav-item active">
                              <a href="{{ route('landlord.financial-reporting') }}" class="nav-link">
                                  Financial Reporting
                              </a>
                          </li>
                      @endif
                      
                      <!-- Profile Dropdown (Common for both roles) -->
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              @if(Auth::user()->profile_picture)
                                  <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                              @else
                                  <i class="fas fa-user-circle" style="font-size: 24px;"></i>
                              @endif
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                              <a class="dropdown-item" href="{{ route('messages.index') }}">Messages</a>
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  Logout
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </div>
                      </li>
                  @else
                      <!-- Default Menu Items (for non-logged in users) -->
                      <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                      <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                      <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                      <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                      <li class="nav-item"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
                      <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                      <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                  @endauth
              </ul>
          </div>
      </div>
  </nav>

    <!-- Main Content -->
    <section class="main-content">
        <div class="container">
            <div class="page-header">
                <h2>Financial Reporting</h2>
                <p class="text-muted">View your rental income and transaction history</p>
            </div>
            
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-primary">Total Sales</h5>
                                    <h2 class="card-value">${{ number_format($totalSales, 2) }}</h2>
                                    <p class="card-text">All-time rental income</p>
                                </div>
                                <i class="fas fa-dollar-sign fa-3x text-primary opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-success">Monthly Sales</h5>
                                    <h2 class="card-value">${{ number_format($monthlySales, 2) }}</h2>
                                    <p class="card-text">This month's rental income</p>
                                </div>
                                <i class="fas fa-calendar-alt fa-3x text-success opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title text-info">Annual Sales</h5>
                                    <h2 class="card-value">${{ number_format($annualSales, 2) }}</h2>
                                    <p class="card-text">This year's rental income</p>
                                </div>
                                <i class="fas fa-chart-line fa-3x text-info opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Transaction History</h4>
                        <div class="d-flex">
                            <div class="input-group mr-3" style="width: 250px;">
                                <input type="text" id="dateRangePicker" class="form-control" placeholder="Select date range">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <!-- Replace the existing dropdown menu with this one -->
                                <div class="dropdown-menu dropdown-menu-right">
                                    <h6 class="dropdown-header">Filter by Status</h6>
                                    <a class="dropdown-item filter-status" href="#" data-status="all">All Transactions</a>
                                    <a class="dropdown-item filter-status" href="#" data-status="rented">Rented</a>
                                    <a class="dropdown-item filter-status" href="#" data-status="cancelled">Cancelled</a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">Time Period</h6>
                                    <a class="dropdown-item filter-period" href="#" data-period="this_month">This Month</a>
                                    <a class="dropdown-item filter-period" href="#" data-period="last_month">Last Month</a>
                                    <a class="dropdown-item filter-period" href="#" data-period="this_year">This Year</a>
                                    <a class="dropdown-item filter-period" href="#" data-period="all_time">All Time</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table" id="transactionsTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Property</th>
                                    <th>Amount</th>
                                    <th>Tenant</th>
                                    <th>Rental Period</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr data-status="{{ $transaction->status === 'completed' ? 'rented' : $transaction->status }}">
                                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                    <td>
                                        {{ $transaction->property->title ?? 'N/A' }}
                                    </td>
                                    <td>${{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                        {{ $transaction->tenant->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $transaction->start_date->format('M d, Y') }} - 
                                        {{ $transaction->end_date->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            @if($transaction->status === 'completed' || $transaction->status === 'rented') badge-success
                                            @elseif($transaction->status === 'pending') badge-warning
                                            @else badge-danger @endif">
                                            {{ $transaction->status === 'completed' ? 'Rented' : ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($transaction->status === 'completed' || $transaction->status === 'rented')
                                        <button class="btn btn-sm btn-outline-primary view-receipt" data-transaction-id="{{ $transaction->id }}">
                                            <i class="fas fa-receipt"></i> Receipt
                                        </button>
                                        @endif
                                        <button class="btn btn-sm btn-outline-danger delete-transaction" data-transaction-id="{{ $transaction->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries
                        </div>
                        <div>
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tenant Modal -->
    <div class="modal fade" id="tenantModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="tenantDetails">
                    Loading tenant information...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="receiptContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="printReceipt">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2"><a href="#" class="logo">Stay<span> Haven</span></a></h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Information</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Services</a></li>
                <li><a href="#" class="py-2 d-block">Term and Conditions</a></li>
                <li><a href="#" class="py-2 d-block">Best Price Guarantee</a></li>
                <li><a href="#" class="py-2 d-block">Privacy &amp; Cookies Policy</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Customer Support</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">FAQ</a></li>
                <li><a href="#" class="py-2 d-block">Payment Option</a></li>
                <li><a href="#" class="py-2 d-block">Booking Tips</a></li>
                <li><a href="#" class="py-2 d-block">How it works</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">


        </div>
      </div>
    </footer>

    <!-- Scripts -->
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('user-template/js/main.js') }}"></script>
    
    <script>
    $(document).ready(function() {
        // Initialize date range picker
        flatpickr("#dateRangePicker", {
            mode: "range",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    filterTransactions();
                }
            }
        });

        // Filter transactions by status
        $('.filter-status').on('click', function(e) {
            e.preventDefault();
            const status = $(this).data('status');
            
            if (status === 'all') {
                $('#transactionsTable tbody tr').show();
            } else {
                $('#transactionsTable tbody tr').each(function() {
                    const rowStatus = $(this).data('status');
                    if (status === 'rented' && (rowStatus === 'rented' || rowStatus === 'completed')) {
                        $(this).show();
                    } else if (rowStatus === status) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });

        // View receipt handler
        $(document).on('click', '.view-receipt', function() {
            const transactionId = $(this).data('transaction-id');
            const $row = $(this).closest('tr');
            const status = $row.data('status');
            
            // Only show receipt for rented/completed transactions
            if (status !== 'rented' && status !== 'completed') {
                alert('Receipt is only available for rented properties');
                return;
            }
            
            // Show loading state
            $('#receiptContent').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading receipt...</p>
                </div>
            `);
            $('#receiptModal').modal('show');
            
            $.ajax({
                url: `/payments/${transactionId}/receipt`,
                method: 'GET',
                success: function(response) {
                    // Create receipt HTML
                    const receiptHtml = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Property Information</h6>
                                <p><strong>${response.property.title || 'N/A'}</strong></p>
                                <p>${response.property.address || 'N/A'}</p>
                                <p>${response.property.city || 'N/A'}, ${response.property.state || 'N/A'}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h6>Payment Details</h6>
                                <p><strong>Date:</strong> ${new Date(response.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                                <p><strong>Transaction ID:</strong> ${response.transaction_id || 'N/A'}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6>Landlord Information</h6>
                                ${response.landlord ? `
                                    <p><strong>${response.landlord.name || 'N/A'}</strong></p>
                                    <p>${response.landlord.email || 'N/A'}</p>
                                    <p>${response.landlord.phone_number || 'N/A'}</p>
                                ` : '<p class="text-muted">Landlord information not available</p>'}
                            </div>
                            <div class="col-md-6 text-end">
                                <h6>Tenant Information</h6>
                                ${response.tenant ? `
                                    <p><strong>${response.tenant.name || 'N/A'}</strong></p>
                                    <p>${response.tenant.email || 'N/A'}</p>
                                    <p>${response.tenant.phone_number || 'N/A'}</p>
                                ` : '<p class="text-muted">Tenant information not available</p>'}
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6>Financial Details</h6>
                                <p><strong>Amount Paid:</strong> $${(response.amount || 0).toFixed(2)}</p>
                                <p><strong>Payment Method:</strong> ${(response.payment_method || 'N/A').replace('_', ' ')}</p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-${response.status === 'completed' || response.status === 'rented' ? 'success' : 'warning'}">
                                        ${response.status === 'completed' ? 'Rented' : (response.status ? response.status.charAt(0).toUpperCase() + response.status.slice(1) : 'N/A')}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Rental Period</h6>
                                <p>${response.start_date ? new Date(response.start_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A'} to 
                                ${response.end_date ? new Date(response.end_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : 'N/A'}</p>
                            </div>
                        </div>
                    `;
                    
                    $('#receiptContent').html(receiptHtml);
                },
                error: function(xhr) {
                    let errorMessage = 'Error loading receipt details';
                    if (xhr.status === 403) {
                        errorMessage = 'You are not authorized to view this receipt';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    $('#receiptContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> ${errorMessage}
                        </div>
                    `);
                }
            });
        });

        // Print receipt handler
        $(document).on('click', '#printReceipt', function() {
            const printContent = $('#receiptContent').html();
            const printWindow = window.open('', '_blank');
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Payment Receipt</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        @media print {
                            body { padding: 20px; }
                            .no-print { display: none !important; }
                            .receipt-header { border-bottom: 2px solid #000; margin-bottom: 20px; }
                            .receipt-footer { border-top: 2px solid #000; margin-top: 20px; padding-top: 10px; }
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="receipt-header text-center">
                            <h2>Stay Haven</h2>
                            <p>Payment Receipt</p>
                        </div>
                        ${printContent}
                        <div class="receipt-footer text-center text-muted">
                            <p>Printed on ${new Date().toLocaleDateString()}</p>
                        </div>
                    </div>
                    <script>
                        window.onload = function() {
                            setTimeout(function() {
                                window.print();
                                window.onafterprint = function() {
                                    window.close();
                                };
                                setTimeout(function() {
                                    if (!window.closed) {
                                        window.close();
                                    }
                                }, 1000);
                            }, 200);
                        };
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        });

        // Delete transaction handler
        $(document).on('click', '.delete-transaction', function() {
            const transactionId = $(this).data('transaction-id');
            const $row = $(this).closest('tr');
            
            if (confirm('Are you sure you want to delete this transaction? This action cannot be undone.')) {
                $.ajax({
                    url: `/landlord/financial-reporting/${transactionId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $row.fadeOut(300, function() {
                                $(this).remove();
                                updatePaginationInfo();
                            });
                        } else {
                            alert('Error: ' + (response.message || 'Failed to delete transaction'));
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Error deleting transaction';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        alert(errorMsg);
                    }
                });
            }
        });

        // Function to update pagination info after deletion
        function updatePaginationInfo() {
            const remainingRows = $('#transactionsTable tbody tr').length;
            const $paginationInfo = $('.text-muted');
            const currentText = $paginationInfo.text();
            const matches = currentText.match(/Showing (\d+) to (\d+) of (\d+) entries/);
            
            if (matches && matches.length === 4) {
                const total = parseInt(matches[3]) - 1;
                const newText = `Showing ${matches[1]} to ${matches[2] > total ? total : matches[2]} of ${total} entries`;
                $paginationInfo.text(newText);
            }
        }

        // Filter transactions function
        function filterTransactions() {
            const dateRange = $('#dateRangePicker').val();
            if (!dateRange) return;
            
            const dates = dateRange.split(' to ');
            if (dates.length !== 2) return;
            
            const startDate = dates[0];
            const endDate = dates[1];
            
            console.log('Filtering by date range:', startDate, 'to', endDate);
        }
    });
</script>
</body>
</html>