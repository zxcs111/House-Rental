<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
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
    <style>
        .payment-card {
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            border: none;
        }
        .payment-header {
            border-radius: 10px 10px 0 0 !important;
            padding: 1.5rem;
        }
        .payment-body {
            padding: 2rem;
        }
        .payment-method {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        .payment-method:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }
        .payment-method.active {
            border-color: #007bff;
            background-color: #f0f7ff;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.1);
            border-color: #80bdff;
        }
        .card-icon {
            font-size: 2rem;
            margin-right: 10px;
            color: #555;
        }
        .btn-pay {
            font-size: 1.1rem;
            padding: 12px;
            letter-spacing: 0.5px;
        }
        .property-img {
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
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
                            <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                            <li class="nav-item"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
                            <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                        @elseif(Auth::user()->role === 'landlord')
                            <!-- Landlord Menu Items -->
                            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                            <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                            <li class="nav-item"><a href="{{ route('property.listing') }}" class="nav-link">Property Listing</a></li>
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
                        <!-- Default Menu Items (for non-logged in users) -->
                        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                        <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                        <li class="nav-item active"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                        <li class="nav-item"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
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
                    <p class="breadcrumbs mb-2"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Payment <i class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-0 bread">Complete Your Payment</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card payment-card h-100">
                                <div class="card-header bg-primary text-white payment-header">
                                    <h3 class="mb-0">Property Details</h3>
                                </div>
                                <div class="card-body payment-body">
                                    <img src="{{ $property->main_image ? asset('storage/' . $property->main_image) : asset('user-template/images/house-placeholder.jpg') }}" class="img-fluid property-img mb-4 w-100" alt="Property Image">
                                    <h4>{{ $property->title }}</h4>
                                    <p class="text-muted">{{ $property->address }}, {{ $property->city }}, {{ $property->state }}</p>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1"><strong>Bedrooms:</strong> {{ $property->bedrooms }}</p>
                                            <p class="mb-1"><strong>Bathrooms:</strong> {{ $property->bathrooms }}</p>
                                        </div>
                                        <div>
                                            <p class="mb-1"><strong>Area:</strong> {{ number_format($property->square_feet) }} sqft</p>
                                            <p class="mb-1"><strong>Type:</strong> {{ $property->property_type }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4 class="text-right">${{ number_format($property->price, 2) }} <small class="text-muted">/month</small></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card payment-card">
                                <div class="card-header bg-primary text-white payment-header">
                                    <h3 class="mb-0">Payment Information</h3>
                                </div>
                                <div class="card-body payment-body">
                                    <form method="POST" action="{{ route('payment.process', $property->id) }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="font-weight-bold">Rental Period</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label>Start Date</label>
                                                    <input type="date" class="form-control" id="start_date" name="start_date" required min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="font-weight-bold mb-3">Payment Method</label>
                                            
                                            <div class="payment-method active" id="credit-card-method">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                                    <label class="form-check-label d-flex align-items-center" for="credit_card">
                                                        <i class="far fa-credit-card card-icon"></i>
                                                        <span>Credit/Debit Card</span>
                                                    </label>
                                                </div>
                                                <div class="mt-3" id="credit-card-details">
                                                    <div class="form-group">
                                                        <label>Card Number</label>
                                                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Expiry Date</label>
                                                                <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>CVV</label>
                                                                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="payment-method" id="paypal-method">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                                    <label class="form-check-label d-flex align-items-center" for="paypal">
                                                        <i class="fab fa-paypal card-icon"></i>
                                                        <span>PayPal</span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="payment-method" id="bank-method">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                                    <label class="form-check-label d-flex align-items-center" for="bank_transfer">
                                                        <i class="fas fa-university card-icon"></i>
                                                        <span>Bank Transfer</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary btn-block btn-pay">
                                                <i class="fas fa-lock mr-2"></i> Complete Payment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('user-template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('user-template/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('user-template/js/popper.min.js') }}"></script>
    <script src="{{ asset('user-template/js/bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Show/hide credit card details based on payment method
            $('.payment-method').click(function() {
                $('.payment-method').removeClass('active');
                $(this).addClass('active');
                $(this).find('input[type="radio"]').prop('checked', true);
            });
        });
    </script>
</body>
</html>