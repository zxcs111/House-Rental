<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user-template/css/style.css') }}">

    <style>
        body {
            margin-top: 20px;
            background: url('user-template/images/profile-page.jpg');
            background-size: cover;
        }
        .img-account-profile {
            height: 10rem; 
            width: 10rem;
            border-radius: 50% !important; 
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
            border: none;
            border-radius: 0; 
            background: rgba(0, 0, 0, 0.8); 
        }
        
        .card-body{
            color: white;
            font-size: 0.875rem; 
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card .card-header {
            font-weight: 500;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid rgba(248, 249, 250, 0.13);
            padding: 1rem 1.35rem;
            font-size: 1rem;
            color: white;
            border-radius: 0;
        }
        .form-control, .dataTable-input {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: white;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #c5ccd6;
            border-radius: 0;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }
        .nav-borders .nav-link {
            color: white;
            border-bottom-width: 0.125rem;
            border-bottom-style: solid;
            border-bottom-color: transparent;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0;
            padding-right: 0;
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            border: none;
            border-radius: 0;
            padding: 10px 20px;
            text-decoration: none;
        }
        .profile-image-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-image-section img {
            width: 10rem;
            height: 10rem;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-image-section h3 {
            margin-top: 15px;
            font-size: 1.25rem;
            font-weight: bold;
            color: white;
        }
        .btn {
            border-radius: 0;
        }
        .container-xl {
            margin-top: 60px;
        }
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }
        }

        .table {
            color: white;
            border-color: #444;
        }
        .table th {
            border-bottom-width: 1px;
            border-color: #444;
            font-weight: 600;
        }
        .table td {
            border-color: #444;
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .modal-content {
            background-color: #222;
            color: white;
        }
        .modal-header {
            border-bottom: 1px solid #444;
        }
        .modal-footer {
            border-top: 1px solid #444;
        }
        .btn-close {
            filter: invert(1);
        }
        .tenant-info small {
            font-size: 0.8rem;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container-xl px-4">
        <!-- Back to Home Button -->
        <a href="{{ route('home') }}" class="btn back-to-home">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        <hr class="mt-0 mb-4">

        <div class="row">
            <!-- Profile Section -->
            <div class="col-xl-4">
                <!-- Profile picture card -->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <div class="profile-image-section">
                            @if(Auth::user()->profile_picture)
                                <img class="img-account-profile" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture">
                            @else
                                <i class="fas fa-user-circle img-account-profile" style="font-size: 10rem; color: #ccc;"></i>
                            @endif
                            <h3>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        </div>
                        <!-- Profile Picture Upload Form -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                            @csrf
                            <div class="form-group text-center">
                                <label for="profile_picture" class="btn btn-primary profile-picture-upload">
                                    <i class="fas fa-upload"></i> Upload Picture
                                </label>
                                <input type="file" name="profile_picture" id="profile_picture" class="d-none" onchange="this.form.submit()">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Personal Information</div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ Auth::user()->first_name }}">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ Auth::user()->last_name }}">
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ Auth::user()->address ?? '' }}">
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tenant Rent History or Landlord Rented Properties Section -->
                @if(Auth::user()->role === 'tenant')
                    <!-- Rent History Section for Tenants -->
                    <div class="card mt-4">
                        <div class="card-header">Rent History</div>
                        <div class="card-body">
                            @if(Auth::user()->payments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Property</th>
                                                <th>Landlord</th>
                                                <th>Amount</th>
                                                <th>Period</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(Auth::user()->payments as $payment)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('house-detail', $payment->property_id) }}" class="text-decoration-none">
                                                        {{ $payment->property->title }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($payment->landlord)
                                                        {{ $payment->landlord->first_name }} {{ $payment->landlord->last_name }}
                                                        <br>
                                                        <small class="text-muted">{{ $payment->landlord->phone_number }}</small>
                                                    @else
                                                        <span class="text-muted">Landlord not available</span>
                                                    @endif
                                                </td>
                                                <td>${{ number_format($payment->amount, 2) }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($payment->start_date)->format('M d, Y') }} - 
                                                    {{ \Carbon\Carbon::parse($payment->end_date)->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#receiptModal{{ $payment->id }}">
                                                        <i class="fas fa-receipt"></i> Receipt
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Receipt Modal -->
                                            <div class="modal fade" id="receiptModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Payment Receipt</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6>Property Information</h6>
                                                                    <p><strong>{{ $payment->property->title }}</strong></p>
                                                                    <p>{{ $payment->property->address }}</p>
                                                                    <p>{{ $payment->property->city }}, {{ $payment->property->state }}</p>
                                                                </div>
                                                                <div class="col-md-6 text-end">
                                                                    <h6>Payment Details</h6>
                                                                    <p><strong>Date:</strong> {{ $payment->created_at->format('M d, Y h:i A') }}</p>
                                                                    <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <h6>Landlord Information</h6>
                                                                    @if($payment->landlord)
                                                                        <p><strong>{{ $payment->landlord->first_name }} {{ $payment->landlord->last_name }}</strong></p>
                                                                        <p>{{ $payment->landlord->email }}</p>
                                                                        <p>{{ $payment->landlord->phone_number }}</p>
                                                                    @else
                                                                        <p class="text-muted">Landlord information not available</p>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6 text-end">
                                                                    <h6>Tenant Information</h6>
                                                                    <p><strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong></p>
                                                                    <p>{{ Auth::user()->email }}</p>
                                                                    <p>{{ Auth::user()->phone_number }}</p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <h6>Financial Details</h6>
                                                                    <p><strong>Amount Paid:</strong> ${{ number_format($payment->amount, 2) }}</p>
                                                                    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                                                    <p><strong>Status:</strong> 
                                                                        <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }}">
                                                                            {{ ucfirst($payment->status) }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>Rental Period</h6>
                                                                    <p>{{ \Carbon\Carbon::parse($payment->start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($payment->end_date)->format('M d, Y') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="window.print()">
                                                                <i class="fas fa-print"></i> Print Receipt
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> You haven't rented any properties yet.
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif(Auth::user()->role === 'landlord')
                    <!-- Rented Properties Section for Landlords -->
                    <div class="card mt-4">
                        <div class="card-header">Rented Properties</div>
                        <div class="card-body">
                            @if(Auth::user()->receivedPayments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Property</th>
                                                <th>Tenant</th>
                                                <th>Amount</th>
                                                <th>Rental Period</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(Auth::user()->receivedPayments as $payment)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('house-detail', $payment->property_id) }}" class="text-decoration-none">
                                                        {{ $payment->property->title }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($payment->tenant)
                                                        {{ $payment->tenant->first_name }} {{ $payment->tenant->last_name }}
                                                        <br>
                                                        <small class="text-muted">{{ $payment->tenant->email }}</small>
                                                    @else
                                                        <span class="text-muted">Tenant deleted</span>
                                                    @endif
                                                </td>
                                                <td>${{ number_format($payment->amount, 2) }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($payment->start_date)->format('M d, Y') }} - 
                                                    {{ \Carbon\Carbon::parse($payment->end_date)->format('M d, Y') }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $payment->id }}">
                                                        <i class="fas fa-eye"></i> Details
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Payment Details Modal -->
                                            <div class="modal fade" id="paymentModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Rental Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6>Property Information</h6>
                                                                    <p><strong>{{ $payment->property->title }}</strong></p>
                                                                    <p>{{ $payment->property->address }}</p>
                                                                    <p>{{ $payment->property->city }}, {{ $payment->property->state }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>Tenant Information</h6>
                                                                    @if($payment->tenant)
                                                                        <p><strong>{{ $payment->tenant->first_name }} {{ $payment->tenant->last_name }}</strong></p>
                                                                        <p>{{ $payment->tenant->email }}</p>
                                                                        <p>{{ $payment->tenant->phone_number }}</p>
                                                                    @else
                                                                        <p class="text-muted">Tenant account no longer exists</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <h6>Payment Details</h6>
                                                                    <p><strong>Date:</strong> {{ $payment->created_at->format('M d, Y h:i A') }}</p>
                                                                    <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                                                                    <p><strong>Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>Financial Information</h6>
                                                                    <p><strong>Amount Paid:</strong> ${{ number_format($payment->amount, 2) }}</p>
                                                                    <p><strong>Status:</strong> 
                                                                        <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }}">
                                                                            {{ ucfirst($payment->status) }}
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row mt-3">
                                                                <div class="col-md-12">
                                                                    <h6>Rental Period</h6>
                                                                    <p>{{ \Carbon\Carbon::parse($payment->start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($payment->end_date)->format('M d, Y') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="window.print()">
                                                                <i class="fas fa-print"></i> Print Details
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No properties have been rented yet.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
</body>
</html>