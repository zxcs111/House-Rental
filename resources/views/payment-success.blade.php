<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Payment Success</title>
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
        .success-card {
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            border: none;
        }
        .success-header {
            border-radius: 10px 10px 0 0 !important;
            padding: 1.5rem;
        }
        .success-body {
            padding: 2rem;
        }
        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }
        .receipt-table {
            width: 100%;
        }
        .receipt-table th {
            padding: 10px;
            text-align: left;
            width: 30%;
        }
        .receipt-table td {
            padding: 10px;
        }
        .btn-dashboard {
            padding: 10px 25px;
            font-size: 1.1rem;
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

    <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('user-template/images/bg_1.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs mb-2"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Payment Success <i class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-0 bread">Payment Successful</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card success-card">
                        <div class="card-header bg-success text-white success-header">
                            <h3 class="mb-0"><i class="fas fa-check-circle mr-2"></i> Payment Confirmed</h3>
                        </div>
                        <div class="card-body success-body text-center">
                            <div class="success-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h2 class="mb-3">Thank You for Your Payment!</h2>
                            <p class="lead mb-5">Your rental payment has been processed successfully. Below are your payment details.</p>
                            
                            <div class="receipt-details text-left mb-5">
                                <h4 class="mb-4 text-center">Payment Receipt</h4>
                                <table class="receipt-table">
                                    <tr>
                                        <th>Property:</th>
                                        <td>{{ $payment->property->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{ $payment->property->address }}, {{ $payment->property->city }}</td>
                                    </tr>
                                    <tr>
                                        <th>Landlord:</th>
                                        <td>{{ $payment->landlord->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Amount Paid:</th>
                                        <td class="font-weight-bold">${{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method:</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Transaction ID:</th>
                                        <td>{{ $payment->transaction_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Date:</th>
                                        <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rental Period:</th>
                                        <td>{{ $payment->start_date->format('M d, Y') }} to {{ $payment->end_date->format('M d, Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                <p>A confirmation email has been sent to your registered email address.</p>
                            </div>
                            
                            <div class="mt-5">
                                <a href="{{ route('profile') }}" class="btn btn-primary btn-dashboard mr-3">
                                    <i class="fas fa-user-circle mr-2"></i> View Your Rentals
                                </a>
                                <a href="{{ route('houses') }}" class="btn btn-secondary btn-dashboard">
                                    <i class="fas fa-home mr-2"></i> Browse More Properties
                                </a>
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
</body>
</html>