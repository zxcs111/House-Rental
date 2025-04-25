<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
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
    <link rel="stylesheet" href="{{ asset('user-template/css/houses.css') }}">
    <!-- Include SweetAlert2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .payment-section {
            padding: 60px 0;
            background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
        }
        .payment-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: stretch;
        }
        .property-card, .payment-card {
            background: #ffffff;
            border-radius: 0;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .property-header, .payment-header {
            background: linear-gradient(135deg, #8b5cf6 0%, #6b21a8 100%);
            color: #ffffff;
            padding: 28px 40px;
            border-radius: 0;
        }
        .property-header h3, .payment-header h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: #ffffff;
        }
        .property-body, .payment-body {
            padding: 40px;
            background: #ffffff;
        }
        .property-img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        }
        .property-details h4 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 16px;
        }
        .property-details p {
            color: #475569;
            font-size: 1.1rem;
            margin-bottom: 12px;
            line-height: 1.5;
        }
        .property-specs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 24px 0;
            padding: 16px 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        .property-specs p {
            margin: 0;
            font-size: 1rem;
            color: #475569;
        }
        .property-specs p strong {
            color: #0f172a;
            font-weight: 600;
        }
        .price-tag {
            font-size: 2.25rem;
            font-weight: 800;
            color: #0f172a;
            text-align: right;
            margin-top: 24px;
        }
        .price-tag small {
            font-size: 1.25rem;
            color: #64748b;
            font-weight: 500;
        }
        .form-group {
            margin-bottom: 28px;
        }
        .form-group label {
            font-weight: 600;
            color: #0f172a;
            display: block;
            margin-bottom: 12px;
            font-size: 1.1rem;
        }
        .form-control {
            width: 100%;
            padding: 14px 20px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 1rem;
            background: #ffffff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }
        .form-control:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
            background: #ffffff;
        }
        .payment-method {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }
        .payment-method:hover {
            border-color: #8b5cf6;
            background: #f5f3ff;
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.1);
        }
        .payment-method.active {
            border-color: #8b5cf6;
            background: #f5f3ff;
            box-shadow: 0 4px 20px rgba(139, 92, 246, 0.15);
        }
        .payment-method input {
            display: none;
        }
        .payment-method label {
            display: flex;
            align-items: center;
            width: 100%;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: 600;
            color: #0f172a;
        }
        .card-icon {
            font-size: 2rem;
            margin-right: 16px;
            color: #8b5cf6;
            transition: transform 0.3s ease;
        }
        .payment-method:hover .card-icon {
            transform: scale(1.1);
        }
        .payment-details {
            margin-top: 28px;
            padding: 24px;
            background: #f8fafc;
            border-radius: 16px;
            display: none;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.03);
        }
        .payment-details.active {
            display: block;
        }
        .credit-card-details .form-group {
            margin-bottom: 20px;
        }
        .credit-card-details .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .paypal-info {
            color: #475569;
            font-size: 1rem;
            line-height: 1.6;
        }
        .paypal-info a {
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .paypal-info a:hover {
            color: #6b21a8;
            text-decoration: underline;
        }
        .btn-pay {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #8b5cf6 0%, #6b21a8 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.3);
        }
        .btn-pay:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(139, 92, 246, 0.4);
            background: linear-gradient(135deg, #7c3aed 0%, #5b1a8b 100%);
        }
        .btn-pay i {
            margin-right: 12px;
        }
        @media (max-width: 768px) {
            .payment-grid {
                grid-template-columns: 1fr;
            }
            .property-card, .payment-card {
                margin-bottom: 40px;
            }
            .property-img {
                height: 240px;
            }
            .price-tag {
                font-size: 2rem;
            }
            .property-header h3, .payment-header h3 {
                font-size: 1.75rem;
            }
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
                            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                            <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                            <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                            <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                        @elseif(Auth::user()->role === 'landlord')
                            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                            <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
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
                        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                        <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                        <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                        <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('user-template/images/bg_3.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Payment <i class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-3 bread">Complete Your Payment</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="payment-section">
        <div class="payment-container">
            <div class="payment-grid">
                <div class="property-card">
                    <div class="property-header">
                        <h3>Property Details</h3>
                    </div>
                    <div class="property-body">
                        <img src="{{ $property->main_image ? asset('storage/' . $property->main_image) : asset('user-template/images/house-placeholder.jpg') }}" class="property-img" alt="Property Image">
                        <div class="property-details">
                            <h4>{{ $property->title }}</h4>
                            <p>{{ $property->address }}, {{ $property->city }}, {{ $property->state }}</p>
                            <div class="property-specs">
                                <div>
                                    <p><strong>Bedrooms:</strong> {{ $property->bedrooms }}</p>
                                    <p><strong>Bathrooms:</strong> {{ $property->bathrooms }}</p>
                                </div>
                                <div>
                                    <p><strong>Area:</strong> {{ number_format($property->square_feet) }} sqft</p>
                                    <p><strong>Type:</strong> {{ $property->property_type }}</p>
                                </div>
                            </div>
                            <div class="price-tag">${{ number_format($property->price, 2) }} <small>/month</small></div>
                        </div>
                    </div>
                </div>
                <div class="payment-card">
                    <div class="payment-header">
                        <h3>Payment Information</h3>
                    </div>
                    <div class="payment-body">
                        <form id="payment-form" method="POST" action="{{ route('payment.process', $property->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="start_date">Rental Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                            </div>
                            <div class="form-group">
                                <label>Payment Method</label>
                                <div class="payment-method active" data-method="credit_card">
                                    <label>
                                        <input type="radio" name="payment_method" value="credit_card" checked>
                                        <i class="far fa-credit-card card-icon"></i>
                                        Credit/Debit Card
                                    </label>
                                </div>
                                <div class="payment-method" data-method="paypal">
                                    <label>
                                        <input type="radio" name="payment_method" value="paypal">
                                        <i class="fab fa-paypal card-icon"></i>
                                        PayPal
                                    </label>
                                </div>
                            </div>
                            <div class="payment-details credit-card-details active">
                                <div class="form-group">
                                    <label for="card_number">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="grid">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123">
                                    </div>
                                </div>
                            </div>
                            <div class="payment-details paypal-details">
                                <div class="paypal-info">
                                    <p>You will be redirected to PayPal's secure payment page to complete your transaction.</p>
                                    <p>Please ensure you have an active PayPal account. <a href="https://www.paypal.com/signup" target="_blank">Create one here</a> if you don't have an account.</p>
                                </div>
                            </div>
                            <button type="submit" class="btn-pay"><i class="fas fa-lock"></i> Complete Payment</button>
                        </form>
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
                        <h2 class="ftco-heading-2"><a href="#" class="logo">Stay<span> Haven</span></a></h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Information</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">About</a></li>
                            <li><a href="#" class="py-2 d-block">Services</a></li>
                            <li><a href="#" class="py-2 d-block">Term and Conditions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Customer Support</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">FAQ</a></li>
                            <li><a href="#" class="py-2 d-block">Payment Option</a></li>
                            <li><a href="#" class="py-2 d-block">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Copyright ©<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>
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
    <script src="{{ asset('user-template/js/main.js') }}"></script>
    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Payment method toggle functionality
            $('.payment-details.credit-card-details').addClass('active');

            $('.payment-method').click(function() {
                $('.payment-method').removeClass('active');
                $(this).addClass('active');
                $(this).find('input[type="radio"]').prop('checked', true);

                $('.payment-details').removeClass('active');
                var method = $(this).data('method');
                if (method === 'credit_card') {
                    $('.payment-details.credit-card-details').addClass('active');
                } else if (method === 'paypal') {
                    $('.payment-details.paypal-details').addClass('active');
                }
            });

            // Handle form submission with AJAX
            $('#payment-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Show SweetAlert on success
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful!',
                            text: 'Your rental payment has been processed successfully.',
                            confirmButtonText: 'Proceed',
                            confirmButtonColor: '#8b5cf6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to the success page
                                window.location.href = response.redirect_url;
                            }
                        });
                    },
                    error: function(xhr) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                            ? xhr.responseJSON.message 
                            : 'An error occurred while processing your payment. Please try again.';
                        
                        // Show SweetAlert on error
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Failed',
                            text: errorMessage,
                            confirmButtonText: 'Try Again',
                            confirmButtonColor: '#8b5cf6'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>