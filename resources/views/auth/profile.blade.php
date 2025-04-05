<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Haven - Profile</title>
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

        /* Enhanced Table Styles */
        .table {
            color: white;
            border-color: #444;
        }
        .table th {
            border-bottom-width: 1px;
            border-color: #444;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 12px 15px;
        }
        .table td {
            border-color: #444;
            vertical-align: middle;
            padding: 12px 15px;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            font-size: 0.85em;
        }
        
        /* Button Group Styles */
        .btn-action-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn-action-group .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.85rem;
        }
        
        /* Modal Styles */
        .modal-content {
            background-color: #222;
            color: white;
            border-radius: 0;
            border: 1px solid #444;
        }
        .modal-header {
            border-bottom: 1px solid #444;
            padding: 1rem 1.5rem;
        }
        .modal-footer {
            border-top: 1px solid #444;
            padding: 1rem 1.5rem;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }
        .tenant-info small {
            font-size: 0.8rem;
            color: #aaa;
        }
        .rejection-badge {
            background-color: #dc3545;
        }
        .alert-modal {
            background-color: rgba(0, 0, 0, 0.3);
            border-left: 4px solid;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
        }
        .alert-modal.alert-danger {
            border-left-color: #dc3545;
        }
        .alert-modal.alert-warning {
            border-left-color: #ffc107;
        }
        
        /* Property title style (non-clickable) */
        .property-title {
            color:rgb(42, 87, 224);
            font-weight: 500;
            text-decoration: none;
            cursor: default;
            margin-left: 10px;
        
        }

        .table thead th {
            color: white; /* Change header text color to white */
            background-color: #343a40; /* Dark background for contrast */ 
        }

        .table {
            background-color: #222; /* Dark background for entire table */
            color: white; /* Default text color for the table */
        }

        .table tbody tr:hover {
            background-color: #555; /* Darker hover effect for table rows */
        }
        
        /* Spacing improvements */
        .card-body .form-group {
            margin-bottom: 1.25rem;
        }
        .table tr td:not(:last-child) {
            padding-right: 15px;
        }
        .modal-body .form-group {
            margin-bottom: 1.5rem;
        }

        .bg-dark {
            background-color: white !important;
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
                                    <label for="name">Account Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" maxlength="15" oninput="validateName(this)">
                                </div>
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ Auth::user()->first_name }}" maxlength="20" oninput="validateName(this)">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ Auth::user()->last_name }}" maxlength="15" oninput="validateName(this)">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" maxlength="255">
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Phone</label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}" oninput="validatePhone(this)" maxlength="11" pattern="\d{0,11}">
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
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(Auth::user()->payments as $payment)
                                            <tr>
                                                <td>
                                                    <span class="property-title">
                                                        {{ $payment->property->title }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($payment->landlord)
                                                        {{ $payment->landlord->name }} 
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
                                                        {{ $payment->status == 'completed' ? 'Rented' : ucfirst($payment->status) }}
                                                    </span>
                                                    @if($payment->cancellation_status == 'rejected')
                                                        <span class="badge rejection-badge mt-1 d-block">Cancellation Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-action-group">
                                                        <button class="btn btn-sm btn-outline-primary view-receipt" data-payment-id="{{ $payment->id }}">
                                                            <i class="fas fa-receipt"></i> Receipt
                                                        </button>
                                                        @if($payment->status == 'completed')
                                                            @if($payment->cancellation_requested && $payment->cancellation_status == 'pending')
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @elseif($payment->cancellation_status == 'rejected')
                                                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#rejectedModal{{ $payment->id }}">
                                                                    <i class="fas fa-info-circle"></i> Details
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $payment->id }}">
                                                                    <i class="fas fa-redo"></i> Re-request
                                                                </button>
                                                            @elseif(!$payment->cancellation_requested || $payment->cancellation_status == 'approved')
                                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $payment->id }}">
                                                                    <i class="fas fa-times-circle"></i> Cancel
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Rejected Cancellation Modal -->
                                            <div class="modal fade" id="rejectedModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Cancellation Rejected</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert-modal alert-danger">
                                                                <i class="fas fa-exclamation-circle me-2"></i> Your cancellation request was rejected by the landlord.
                                                            </div>
                                                            <div class="card mt-3 bg-dark">
                                                                <div class="card-header bg-secondary">Rejection Details</div>
                                                                <div class="card-body">
                                                                    <p class="text-dark"><strong>Reason:</strong></p>
                                                                    <p class="text-dark">{{ $payment->rejection_reason }}</p> <!-- Changed to text-dark -->
                                                                    <p class="text-muted small mt-2">
                                                                        Rejected on: {{ $payment->updated_at->format('M d, Y h:i A') }}<br>
                                                                        <strong class="text-muted">Landlord:</strong> {{ $payment->landlord->name ?? 'N/A' }} <!-- Adapted for consistency -->
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <p class="mt-3">You may submit a new cancellation request if needed.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $payment->id }}">
                                                                Request Again
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cancel Rent Modal -->
                                            <div class="modal fade" id="cancelModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Request Rent Cancellation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('payment.cancel', $payment->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-4">
                                                                    <p>You are requesting cancellation for:</p>
                                                                    <div class="card bg-dark p-3">
                                                                        <p class="mb-1"><strong>Property:</strong> {{ $payment->property->title }}</p>
                                                                        <p class="mb-1"><strong>Landlord:</strong> {{ $payment->landlord->name }}</p>
                                                                        <p class="mb-0"><strong>Rental Period:</strong> 
                                                                            {{ \Carbon\Carbon::parse($payment->start_date)->format('M d, Y') }} - 
                                                                            {{ \Carbon\Carbon::parse($payment->end_date)->format('M d, Y') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label for="cancellation_reason" class="form-label">Reason for Cancellation:</label>
                                                                    <textarea class="form-control bg-dark text-white" id="cancellation_reason" name="cancellation_reason" rows="3" required placeholder="Please explain your reason for cancellation..."></textarea>
                                                                </div>
                                                                
                                                                <div class="alert-modal alert-warning mt-4">
                                                                    <i class="fas fa-exclamation-triangle me-2"></i> 
                                                                    This request needs approval from the landlord. You may be subject to cancellation fees based on the rental agreement.
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">Submit Request</button>
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
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> You haven't rented any properties yet.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="receiptContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="printReceipt">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // View receipt handler
        $(document).on('click', '.view-receipt', function() {
            const paymentId = $(this).data('payment-id');
            
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
                url: `/payments/${paymentId}/receipt`,
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
    });

    function validateName(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }

    function validatePhone(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }

    function validatePhone(input) {
        // Remove non-digit characters
        input.value = input.value.replace(/\D/g, '');

        // Limit the input to 11 characters
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }

    </script>
</body>
</html>