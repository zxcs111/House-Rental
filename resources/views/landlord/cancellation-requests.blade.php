<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stay Haven - Cancellation Requests</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <style>
        .hero-wrap {
            background-image: url('user-template/images/house-landing.jpg');
            background-size: cover;
            background-position: center center;
            height: 400px;
            position: relative;
        }
        
        .hero-wrap .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
        }
        
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
            border: none;
            border-radius: 0.25rem; 
            background: rgba(255, 255, 255, 0.95);
            color: #333;
        }
        
        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            color: #333;
            background-color: rgba(255, 255, 255, 0.95);
        }
        
        .table {
            color: #333;
            border-color: #dee2e6;
        }
        
        .table th {
            border-bottom-width: 1px;
            border-color: #dee2e6;
            font-weight: 600;
        }
        
        .table td {
            border-color: #dee2e6;
            vertical-align: middle;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }
        
        .modal-content {
            background-color: #fff;
            color: #333;
        }
        
        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }
        
        .modal-footer {
            border-top: 1px solid #dee2e6;
        }
        
        .bg-warning {
            background-color: #ffc107 !important;
        }
        
        .breadcrumbs {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .breadcrumbs a {
            color: white;
        }
        
        .breadcrumbs .ion-ios-arrow-forward {
            color: rgba(255, 255, 255, 0.8);
        }

        .reason-column {
            max-width: 300px; /* Set a maximum width for the reason column */
            white-space: normal; /* Allow text to wrap */
            word-wrap: break-word; /* Break long words if needed */
            overflow-wrap: break-word; /* Modern alternative to word-wrap */
            text-align: left; /* Align text to left (looks better for paragraphs) */
            padding: 8px 12px; /* Add some padding */
        }

        /* Custom Table Design */
        .custom-table {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }

        .custom-table thead {
            background-color: #f8f9fa;
        }

        .custom-table th {
            font-weight: 600;
            color: #333;
            white-space: nowrap;
            vertical-align: middle;
        }

        .custom-table td {
            vertical-align: middle;
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .custom-table tbody tr:hover {
            background-color: #f1f8ff;
        }

        .reason-column {
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            text-align: left;
            padding: 8px 12px;
        }

        /* Action Buttons */
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Card Header */
        .card-header {
            border-bottom: 1px solid #dee2e6;
            font-size: 1rem;
            color: #fff;
            background-color: #ffc107; /* Warning color */
        }

        .card-header .badge {
            font-size: 0.9rem;
            font-weight: bold;
        }

        /* Alert Styling */
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .alert-info i {
            margin-right: 8px;
        }
    </style>
  </head>
  <body>
    
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
                            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                            <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                            <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                            <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                        @elseif(Auth::user()->role === 'landlord')
                            <!-- Landlord Menu Items -->
                            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                            <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                            <li class="nav-item"><a href="{{ route('property.listing') }}" class="nav-link">Property Listing</a></li>
                            <li class="nav-item active"><a href="{{ route('landlord.cancellation-requests') }}" class="nav-link">Cancellation Requests</a></li>
                            <li class="nav-item"><a href="{{ route('landlord.financial-reporting') }}" class="nav-link">Financial Reporting</a></li>
                        @endif
                        
                        <!-- Profile Dropdown -->
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
                                <a class="dropdown-item" href="{{ route('messages.index') }}" >Messages</a>
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
                        <!-- Default Menu Items -->
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-wrap hero-wrap-2 js-fullheight" style="height: 300px;" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Cancellation Requests <i class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-3 bread">Property Cancellation Requests</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <!-- Heading Section -->
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Cancellation Requests</span>
                    <h2 class="mb-4">Manage Pending Cancellations</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Pending Cancellation Requests</h4>
                            @if($pendingRequests->count() > 0)
                                <span class="badge bg-danger">{{ $pendingRequests->count() }} Pending</span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($pendingRequests->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover custom-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Property</th>
                                                <th>Tenant</th>
                                                <th>Rental Period</th>
                                                <th class="reason-column">Reason</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingRequests as $request)
                                                <tr>
                                                    <td>
                                                        <span class="text-primary fw-bold">
                                                            {{ $request->property->title }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $request->tenant->first_name }} {{ $request->tenant->last_name }}
                                                        <br>
                                                        <small class="text-muted">{{ $request->tenant->email }}</small>
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }} - 
                                                        {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                                    </td>
                                                    <td class="reason-column">{{ $request->cancellation_reason }}</td>
                                                    <td class="text-center">
                                                        <!-- Approve Button -->
                                                        <button 
                                                            class="btn btn-sm btn-success me-2 approve-btn" 
                                                            data-id="{{ $request->id }}" 
                                                            title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <!-- Reject Button -->
                                                        <button 
                                                            class="btn btn-sm btn-danger reject-btn" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#rejectModal{{ $request->id }}" 
                                                            title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <!-- Reject Modal -->
                                                <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Reject Cancellation Request</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form id="rejectForm{{ $request->id }}">
                                                                @csrf
                                                                <input type="hidden" name="payment_id" value="{{ $request->id }}">
                                                                <div class="modal-body">
                                                                    <p>Please provide a reason for rejecting this cancellation request:</p>
                                                                    <textarea class="form-control" name="rejection_reason" rows="3" required></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger submit-reject" data-id="{{ $request->id }}">Confirm Rejection</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle me-2"></i> No pending cancellation requests.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2"><a href="#" class="logo">Stay<span>Haven</span></a></h2>
                        <p>Your perfect home away from home. We provide quality rental properties with excellent service.</p>
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
                            <li><a href="{{ route('about') }}" class="py-2 d-block">About</a></li>
                            <li><a href="{{ route('services') }}" class="py-2 d-block">Services</a></li>
                            <li><a href="#" class="py-2 d-block">Term and Conditions</a></li>
                            <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Customer Support</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">FAQ</a></li>
                            <li><a href="#" class="py-2 d-block">Payment Option</a></li>
                            <li><a href="{{ route('contact') }}" class="py-2 d-block">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">123 Main Street, Nairobi, Kenya</span></li>
                                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+254 700 123456</span></a></li>
                                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@stayhaven.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

    <!-- Bootstrap JS and Dependencies -->
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="{{ asset('user-template/js/google-map.js') }}"></script>
    <script src="{{ asset('user-template/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
    // SweetAlert Confirmation for Approve
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function () {
            const paymentId = this.dataset.id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this cancellation request?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to approve the cancellation
                    axios.post(`/cancellation-requests/${paymentId}/approve`, {
                        _token: '{{ csrf_token() }}'
                    }).then(response => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Cancellation approved successfully.',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            location.reload(); // Optionally refresh the page or update the UI dynamically
                        });
                    }).catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while approving the cancellation.',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    });
                }
            });
        });
    });

        // Handle Rejection via AJAX
        document.querySelectorAll('.submit-reject').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const paymentId = this.dataset.id;
                const form = document.getElementById(`rejectForm${paymentId}`);
                const formData = new FormData(form);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to reject this cancellation request?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to reject the cancellation
                        axios.post(`/cancellation-requests/${paymentId}/reject`, formData)
                            .then(response => {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Successfully rejected the cancellation.',
                                    icon: 'success',
                                    confirmButtonColor: '#28a745'
                                }).then(() => {
                                    // Optionally refresh the table or update the UI
                                    location.reload(); // Remove this line if you want to dynamically update the UI
                                });
                            }).catch(error => {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred while rejecting the cancellation.',
                                    icon: 'error',
                                    confirmButtonColor: '#d33'
                                });
                            });
                    }
                });
            });
        });
    </script>

</body>
</html>