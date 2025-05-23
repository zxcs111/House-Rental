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

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
        }
        /* Hero Section */
        .hero-wrap .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            content: '';
            opacity: .3;
            background: #000;
        }
        .slider-text {
            position: relative;
            z-index: 2;
        }
        .breadcrumbs {
            font-size: 14px;
            color: #fff;
        }
        .breadcrumbs a {
            color: #fff;
        }
        .breadcrumbs a:hover {
            text-decoration: underline;
        }
        .hero-wrap h1 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 10px;
        }
        /* Main Content */
        .main-content {
            padding: 50px 0;
        }
        .page-header {
            margin-bottom: 30px;
        }
        .page-header h2 {
            font-weight: 600;
            color: #2c3e50;
        }
        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }
        .card-body {
            padding: 25px;
        }
        .card-title {
            font-size: 1rem;
            font-weight: 500;
            color: #fff;
        }
        .card-value {
            font-size: 1.8rem;
            font-weight: 600;
            color: #fff;
            margin: 10px 0;
        }
        .card-text {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }
        .card-primary {
            background: linear-gradient(135deg, var(--primary-color), #3e5fbc);
        }
        .card-success {
            background: linear-gradient(135deg, var(--success-color), #14a07c);
        }
        .card-info {
            background: linear-gradient(135deg, var(--info-color), #2d9baf);
        }
        .property-list {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            max-height: 60px;
            overflow-y: auto;
            margin-top: 10px;
        }
        .property-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .property-list li {
            margin-bottom: 5px;
        }
        /* Table Styles */
        .card1 {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            color: #2c3e50;
            border-top: none;
            border-bottom: 2px solid #dee2e6;
        }
        .table td {
            vertical-align: middle;
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        /* Custom Search Bar Styles */
        .form {
            --timing: 0.3s;
            --width-of-input: 200px;
            --height-of-input: 30px;
            --border-height: 2px;
            --input-bg: #fff;
            --border-color: #4e73df;
            --border-radius: 30px;
            --after-border-radius: 4px;
            position: relative;
            width: var(--width-of-input);
            height: var(--height-of-input);
            display: flex;
            align-items: center;
            padding-inline: 0.8em;
            border-radius: var(--border-radius);
            transition: border-radius 0.5s ease;
            background: var(--input-bg,#fff);
            border: 1px solid #ced4da;
            margin-right: 0.75rem;
        }
        .form button {
            border: none;
            background: none;
            color: #8b8ba7;
            padding: 0;
            margin-right: 0.5rem;
        }
        .input {
            font-size: 0.875rem;
            background-color: transparent;
            width: 100%;
            height: 100%;
            padding-inline: 0.5em;
            padding-block: 0.5em;
            border: none;
            color: #495057;
        }
        .form:before {
            content: "";
            position: absolute;
            background: var(--border-color);
            transform: scaleX(0);
            transform-origin: center;
            width: 100%;
            height: var(--border-height);
            left: 0;
            bottom: 0;
            border-radius: 1px;
            transition: transform var(--timing) ease;
        }
        .form:focus-within {
            border-radius: var(--after-border-radius);
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .input:focus {
            outline: none;
        }
        .form:focus-within:before {
            transform: scale(1);
        }
        .reset {
            border: none;
            background: none;
            opacity: 0;
            visibility: hidden;
            padding: 0;
            margin-left: 0.5rem;
        }
        .input:not(:placeholder-shown) ~ .reset {
            opacity: 1;
            visibility: visible;
        }
        .form svg {
            width: 14px;
            height: 14px;
        }
        .btn-sm {
            height: 30px;
            line-height: 1;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        .d-flex.align-items-center {
            align-items: center;
        }
        .badge {
            display: inline-block;
            font-weight: 500;
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .badge-success {
            background-color: var(--success-color);
            color: #fff;
        }
        .badge-warning {
            background-color: var(--warning-color);
            color: #212529;
        }
        .badge-danger {
            background-color: var(--danger-color);
            color: #fff;
        }
        .btn-group .btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-group .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table td:nth-child(1) {
            text-align: left;
            padding-left: 12px;
        }
        .table td:nth-child(2) {
            text-align: left;
            padding-left: 12px;
        }
        .table td:nth-child(3) {
            text-align: right;
            padding-right: 12px;
        }
        .table td:nth-child(4) {
            text-align: left;
            padding-left: 12px;
        }
        .table td:nth-child(5) {
            text-align: left;
            padding-left: 12px;
        }
        .table td:nth-child(6) {
            text-align: left;
            padding-left: 12px;
        }
        .table td:nth-child(7) {
            text-align: center;
        }
        .table td:nth-child(8) {
            text-align: center;
        }
        .table th:nth-child(1) {
            text-align: left;
            padding-left: 12px;
        }
        .table th:nth-child(2) {
            text-align: left;
            padding-left: 12px;
        }
        .table th:nth-child(3) {
            text-align: right;
            padding-right: 12px;
        }
        .table th:nth-child(4) {
            text-align: left;
            padding-left: 12px;
        }
        .table th:nth-child(5) {
            text-align: left;
            padding-left: 12px;
        }
        .table th:nth-child(6) {
            text-align: left;
            padding-left: 12px;
        }
        .table th:nth-child(7) {
            text-align: center;
        }
        .table th:nth-child(8) {
            text-align: center;
        }
        @media (max-width: 768px) {
            .card-value {
                font-size: 1.5rem;
            }
            .main-content {
                padding: 30px 0;
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
                          <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                          <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                          <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                          <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                          <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                      @elseif(Auth::user()->role === 'landlord')
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
                                  Financial Report
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
                      <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                      <li class="nav-item"><a href="{{ route('about') }}" class="nav-link">About</a></li>
                      <li class="nav-item"><a href="{{ route('services') }}" class="nav-link">Services</a></li>
                      <li class="nav-item"><a href="{{ route('houses') }}" class="nav-link">Houses</a></li>
                      <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                      <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                  @endauth
              </ul>
          </div>
      </div>
    </nav>
    <!-- Hero Section -->
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('user-template/images/about-landing.jpg') }}'); height: 300px;" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a>
                        </span>
                        <span>Financial Report <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Your Financial Report</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- Main Content -->
    <section class="main-content">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Financial Report</span>
                    <h2 class="mb-4">Manage Rented History Transaction</h2>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total Sales</h5>
                                    <h2 class="card-value">${{ number_format($totalSales, 2) }}</h2>
                                    <p class="card-text">All-time rental income</p>
                                </div>
                                <i class="fas fa-dollar-sign fa-3x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Monthly Sales</h5>
                                    <h2 class="card-value">${{ number_format($monthlySales, 2) }}</h2>
                                    <p class="card-text">This month's rental income</p>
                                </div>
                                <i class="fas fa-dollar-sign fa-3x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Total Rented Properties</h5>
                                    <h2 class="card-value">{{ $totalRentedProperties }}</h2>
                                    <p class="card-text">Properties currently rented</p>
                                </div>
                                <i class="fas fa-home fa-3x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Transactions Table -->
            <div class="card1">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Rental History</h4>
                        <div class="d-flex align-items-center">
                            <form id="searchForm" class="form mr-3" action="{{ route('landlord.financial-reporting') }}" method="GET" style="--width-of-input: 200px; --height-of-input: 30px; --border-color: #4e73df;">
                                <button type="submit">
                                    <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                                        <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="#8b8ba7" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                                <input class="input" id="searchInput" name="search" placeholder="Search property or tenant..." type="text" value="{{ $searchTerm }}">
                                <button class="reset" type="reset">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" fill="none" viewBox="0 0 24 24" stroke="#8b8ba7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" 
                                        style="border-radius: 30px; border-color: #ced4da; height: 30px; line-height: 1;">
                                    <i class="fas fa-filter mr-1"></i> Filter
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <h6 class="dropdown-header">Filter by Status</h6>
                                    <a class="dropdown-item filter-status" href="#" data-status="all">All Transactions</a>
                                    <a class="dropdown-item filter-status" href="#" data-status="rented">Rented</a>
                                    <a class="dropdown-item filter-status" href="#" data-status="cancelled">Cancelled</a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">Time Period</h6>
                                    <a class="dropdown-item filter-period" href="#" data-period="this_month">This Month</a>
                                    <a class="dropdown-item filter-period" href="#" data-status="this_month">Last Month</a>
                                    <a class="dropdown-item filter-period" href="#" data-period="this_year">This Year</a>
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
                                    <th>Next Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr data-status="{{ $transaction->status === 'completed' ? 'rented' : $transaction->status }}">
                                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                    <td>{{ $transaction->property->title ?? 'N/A' }}</td>
                                    <td>${{ number_format($transaction->amount, 2) }}</td>
                                    <td>{{ $transaction->tenant->name ?? 'N/A' }}</td>
                                    <td>{{ $transaction->start_date->format('M d, Y') }}</td>
                                    <td>
                                        @if($transaction->status === 'completed' || $transaction->status === 'rented')
                                            @php
                                                $nextPaymentDate = \Carbon\Carbon::parse($transaction->start_date)->addMonth();
                                                $nextPaymentText = $nextPaymentDate->format('M d, Y');
                                            @endphp
                                            {{ $nextPaymentText }}
                                        @else
                                            N/A
                                        @endif
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
                                        <div class="btn-group" role="group">
                                            @if($transaction->status === 'completed' || $transaction->status === 'rented')
                                            <button class="btn btn-sm btn-primary edit-property mr-2 view-receipt" 
                                                data-transaction-id="{{ $transaction->id }}" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="View Receipt">
                                                <i class="fas fa-receipt"></i>
                                            </button>
                                            @endif
                                            <button class="btn btn-sm btn-danger delete-transaction" 
                                                data-transaction-id="{{ $transaction->id }}" 
                                                data-toggle="tooltip" 
                                                data-placement="top" 
                                                title="Hide Transaction">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries
                            @if($searchTerm)
                                (filtered)
                            @endif
                        </div>
                        <div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm">
                                    <li class="page-item {{ $transactions->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $transactions->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">«</span>
                                        </a>
                                    </li>
                                    <li class="page-item {{ $transactions->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $transactions->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">»</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
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
                        <span aria-hidden="true">×</span>
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
                        <span aria-hidden="true">×</span>
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
                            <li><a href="#" class="py-2 d-block">Privacy & Cookies Policy</a></li>
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
                <div class="col-md-12 text-center"></div>
            </div>
        </div>
    </footer>

    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

    <script>
      window.chatbaseConfig = {
        chatbotId: "4RSSrtK8VY3M7j0m4Tiye",
      };
    </script>

    <script src="https://www.chatbase.co/embed.min.js" defer></script>   

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
    <script src="{{ asset('user-template/js/financial-report.js') }}"></script>
</body>
</html>