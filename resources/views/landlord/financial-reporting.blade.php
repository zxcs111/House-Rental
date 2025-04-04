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
                          <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
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
                          <li class="nav-item">
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
                                <div class="dropdown-menu dropdown-menu-right">
                                    <h6 class="dropdown-header">Filter by Status</h6>
                                    <a class="dropdown-item filter-status" href="#" data-status="all">All Transactions</a>
                                    <a class="dropdown-item filter-status" href="#" data-status="completed">Completed</a>
                                    <a class="dropdown-item filter-status" href="#" data-status="pending">Pending</a>
                                    <a class="dropdown-item filter-status" href="#" data-status="failed">Failed</a>
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
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr data-status="{{ $transaction->status }}">
                                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('house-detail', ['id' => $transaction->property_id]) }}" class="text-decoration-none">
                                            {{ $transaction->property->title ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td>${{ number_format($transaction->amount, 2) }}</td>
                                    <td>
                                        @if($transaction->tenant)
                                            <a href="#" class="text-decoration-none view-tenant" data-tenant-id="{{ $transaction->tenant_id }}">
                                                {{ $transaction->tenant->name }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            @if($transaction->status === 'completed') badge-success
                                            @elseif($transaction->status === 'pending') badge-warning
                                            @else badge-danger @endif">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary view-receipt" data-transaction-id="{{ $transaction->id }}">
                                            <i class="fas fa-receipt"></i> Receipt
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
                    <h5 class="modal-title">Tenant Information</h5>
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
                    Loading receipt...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="printReceipt">
                        <i class="fas fa-print mr-1"></i> Print
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
                        if ($(this).data('status') === status) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });

            // View tenant details
            $('.view-tenant').on('click', function(e) {
                e.preventDefault();
                const tenantId = $(this).data('tenant-id');
                
                $.get(`/api/tenants/${tenantId}`, function(data) {
                    $('#tenantDetails').html(`
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="${data.profile_picture ? '/storage/' + data.profile_picture : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.name)}" 
                                     class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <h4>${data.name}</h4>
                                <p><i class="fas fa-envelope mr-2"></i> ${data.email}</p>
                                <p><i class="fas fa-phone mr-2"></i> ${data.phone_number || 'Not provided'}</p>
                                <p><i class="fas fa-map-marker-alt mr-2"></i> ${data.address || 'Not provided'}</p>
                            </div>
                        </div>
                    `);
                    
                    $('#tenantModal').modal('show');
                }).fail(function() {
                    $('#tenantDetails').html('Error loading tenant information');
                });
            });

            // View receipt
            $('.view-receipt').on('click', function() {
                const transactionId = $(this).data('transaction-id');
                
                $.get(`/payments/${transactionId}/receipt`, function(html) {
                    $('#receiptContent').html(html);
                    $('#receiptModal').modal('show');
                }).fail(function() {
                    $('#receiptContent').html('Error loading receipt');
                });
            });

            // Print receipt
            $('#printReceipt').on('click', function() {
                const printContents = $('#receiptContent').html();
                const originalContents = $('body').html();
                
                $('body').html(printContents);
                window.print();
                $('body').html(originalContents);
            });

            // Filter transactions function
            function filterTransactions() {
                const dateRange = $('#dateRangePicker').val();
                console.log('Filter by date range:', dateRange);
                // Implement AJAX filtering if needed
            }
        });
    </script>
</body>
</html>