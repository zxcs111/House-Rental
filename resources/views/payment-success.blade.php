<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Payment Success</title>
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
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .success-section {
            padding: 60px 0;
            background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
        }
        .success-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .success-card {
            background: #ffffff;
            border-radius: 0;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .success-header {
            background: linear-gradient(135deg, #8b5cf6 0%, #6b21a8 100%);
            color: #ffffff; /* Explicitly set to white */
            padding: 28px 40px;
            border-radius: 0;
        }
        .success-header h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: #ffffff; /* Reinforced white color for the header text */
        }
        .success-header h3 i {
            color: #ffffff; /* Ensure the icon is also white */
        }
        .success-body {
            padding: 40px;
            text-align: center;
        }
        .success-icon {
            font-size: 4rem;
            color: #10b981;
            margin-bottom: 24px;
        }
        .success-body h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 16px;
        }
        .success-body .lead {
            font-size: 1.25rem;
            color: #475569;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        .receipt-details {
            background: #f8fafc;
            padding: 24px;
            border-radius: 16px;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.03);
            margin-bottom: 40px;
        }
        .receipt-details h4 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 24px;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-table th, .receipt-table td {
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .receipt-table th {
            width: 35%;
            font-weight: 600;
            color: #0f172a;
        }
        .receipt-table td {
            color: #475569;
        }
        .receipt-table .font-weight-bold {
            color: #0f172a;
            font-weight: 700;
        }
        .confirmation-message {
            font-size: 1.1rem;
            color: #475569;
            margin-bottom: 40px;
        }
        .btn-dashboard {
            padding: 14px 28px;
            font-size: 1.1rem;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            color: #ffffff;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 0 12px;
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.3);
        }
        .btn-primary {
            background: linear-gradient(135deg, #8b5cf6 0%, #6b21a8 100%);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(139, 92, 246, 0.4);
            background: linear-gradient(135deg, #7c3aed 0%, #5b1a8b 100%);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }
        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(71, 85, 105, 0.4);
            background: linear-gradient(135deg, #5b677d 0%, #3f4b5e 100%);
        }
        .btn-dashboard i {
            margin-right: 8px;
        }
        @media (max-width: 768px) {
            .success-section {
                padding: 40px 0;
            }
            .success-body {
                padding: 24px;
            }
            .success-header h3 {
                font-size: 1.75rem;
            }
            .success-body h2 {
                font-size: 2rem;
            }
            .success-body .lead {
                font-size: 1.1rem;
            }
            .receipt-table th, .receipt-table td {
                padding: 10px;
                display: block;
                width: 100%;
                text-align: center;
                border-bottom: none;
            }
            .receipt-table th {
                margin-top: 12px;
                color: #0f172a;
                font-weight: 600;
            }
            .receipt-table td {
                border-bottom: 1px solid #e2e8f0;
            }
            .btn-dashboard {
                display: block;
                margin: 12px auto;
                width: 100%;
                max-width: 300px;
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
                            <li class="nav-item"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
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
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Payment Success <i class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-3 bread">Successful Payment</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="success-section">
        <div class="success-container">
            <div class="success-card">
                <div class="success-header">
                    <h3><i class="fas fa-check-circle mr-2"></i> Payment Confirmed</h3>
                </div>
                <div class="success-body">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2 class="mb-3">Thank You for Your Payment!</h2>
                    <p class="lead mb-5">Your rental payment has been processed successfully. Below are your payment details.</p>
                    
                    <div class="receipt-details">
                        <h4 class="text-center">Payment Receipt</h4>
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
                        </table>
                    </div>
                    
                    <div class="confirmation-message">
                        <p>A confirmation email has been sent to your registered email address.</p>
                    </div>
                    
                    <div>
                        <a href="{{ route('profile') }}" class="btn btn-primary btn-dashboard">
                            <i class="fas fa-user-circle"></i> View Your Rentals
                        </a>
                        <a href="{{ route('houses') }}" class="btn btn-secondary btn-dashboard">
                            <i class="fas fa-home"></i> Browse More Properties
                        </a>
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
</body>
</html>