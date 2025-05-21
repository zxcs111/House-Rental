<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stay Haven - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user-template/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user-template/css/profile.css') }}">
</head>
<body>
    <div class="container-xl px-4">
        <a href="{{ route('home') }}" class="btn back-to-home">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        <div class="row profile-row">
            <div class="col-xl-4 profile-column">
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
            <div class="col-xl-8 info-column">
                <div class="card personal-info-card">
                    <div class="card-header">Personal Information</div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <p class="form-control-static">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Phone</label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}" oninput="validatePhone(this)" maxlength="11" pattern="\d{0,11}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control" value="{{ Auth::user()->address ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tenant Rent History Section in a Separate Full-Width Row -->
        @if(Auth::user()->role === 'tenant')
            <div class="row rent-history-row mt-4">
                <div class="col-12">
                    <div class="card rent-history-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="color: white; font-size: 1rem; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Rent History</h5>
                        </div>
                        <div class="card-body">
                            @if($payments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-dark table-striped" id="rentHistoryTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Property</th>
                                                <th scope="col">Landlord</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Period</th>
                                                <th scope="col">Next Payment</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                                @php
                                                    $hasReviewed = App\Models\Review::where('user_id', Auth::id())
                                                        ->where('property_id', $payment->property_id)
                                                        ->exists();
                                                @endphp
                                                <tr data-payment-id="{{ $payment->id }}">
                                                    <td>
                                                        <span class="property-title d-block">
                                                            {{ $payment->property->title }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($payment->landlord)
                                                            <span class="d-block">{{ $payment->landlord->name }}</span>
                                                            <small class="text-muted">{{ $payment->landlord->phone_number }}</small>
                                                        @else
                                                            <span class="text-muted">Landlord not available</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span>${{ number_format($payment->amount, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($payment->start_date)->format('M d, Y') }}
                                                    </td>
                                                    <td>
                                                        @if($payment->status === 'completed' || $payment->status === 'rented')
                                                            @php
                                                                $nextPaymentDate = \Carbon\Carbon::parse($payment->start_date)->addMonth();
                                                                $nextPaymentText = $nextPaymentDate->format('M d, Y');
                                                            @endphp
                                                            {{ $nextPaymentText }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'secondary') }}">
                                                            {{ $payment->status == 'completed' ? 'Rented' : ucfirst($payment->status) }}
                                                        </span>
                                                        @if($payment->property->status === 'maintenance')
                                                            <span class="badge bg-info mt-1 d-block">Under Maintenance</span>
                                                        @endif
                                                        @if($payment->cancellation_status == 'rejected')
                                                            <span class="badge rejection-badge mt-1 d-block">Cancellation Rejected</span>
                                                        @endif
                                                        @if($payment->cancellation_requested && $payment->cancellation_status == 'pending')
                                                            <span class="badge bg-warning mt-1 d-block">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-action-group">
                                                            <!-- View Receipt Button -->
                                                            <button class="btn btn-sm btn-outline-primary view-receipt" data-payment-id="{{ $payment->id }}">
                                                                <i class="fas fa-receipt"></i>
                                                            </button>
                                                            <!-- Message Landlord Button -->
                                                            @if($payment->landlord_id && $payment->status == 'completed')
                                                                <a href="{{ route('messages.conversation', $payment->landlord_id) }}?property_id={{ $payment->property_id }}" class="btn btn-sm btn-outline-light">
                                                                    <i class="fas fa-comment-dots"></i>
                                                                </a>
                                                            @endif
                                                            <!-- Review Button -->
                                                            @if($payment->status == 'completed' && !$hasReviewed)
                                                                <button class="btn btn-sm btn-outline-warning review-property" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $payment->id }}">
                                                                    <i class="fas fa-star"></i>
                                                                </button>
                                                            @endif
                                                            <!-- Cancel Rent Button -->
                                                            @if($payment->status == 'completed')
                                                                @if($payment->cancellation_requested && $payment->cancellation_status == 'pending')
                                                                @elseif($payment->cancellation_status == 'rejected')
                                                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#rejectedModal{{ $payment->id }}">
                                                                        <i class="fas fa-info-circle"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $payment->id }}">
                                                                        <i class="fas fa-redo"></i>
                                                                    </button>
                                                                @elseif(!$payment->cancellation_requested || $payment->cancellation_status == 'approved')
                                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $payment->id }}">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                            <!-- Hide Transaction Button -->
                                                            <button class="btn btn-sm btn-outline-danger hide-transaction" data-payment-id="{{ $payment->id }}" data-toggle="tooltip" title="Hide Transaction">
                                                                <i class="fas fa-eye-slash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Review Modal -->
                                                @if($payment->status == 'completed' && !$hasReviewed)
                                                    <div class="modal fade" id="reviewModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Review Property</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="{{ route('reviews.store', $payment->property_id) }}" method="POST" class="review-form">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="mb-4">
                                                                            <p>You are reviewing:</p>
                                                                            <div class="card modal-info-card">
                                                                                <p class="mb-1"><strong>Property:</strong> {{ $payment->property->title }}</p>
                                                                                <p class="mb-1"><strong>Landlord:</strong> {{ $payment->landlord->name ?? 'N/A' }}</p>
                                                                                <p class="mb-0"><strong>Rental Start</strong> 
                                                                                    {{ \Carbon\Carbon::parse($payment->start_date)->format('M d, Y') }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="rating">Rating</label>
                                                                            <select name="rating" id="rating" class="form-control" required>
                                                                                <option value="">Select Rating</option>
                                                                                <option value="5">5 Stars</option>
                                                                                <option value="4">4 Stars</option>
                                                                                <option value="3">3 Stars</option>
                                                                                <option value="2">2 Stars</option>
                                                                                <option value="1">1 Star</option>
                                                                            </select>
                                                                            @error('rating')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group mt-3">
                                                                            <label for="comment">Your Review</label>
                                                                            <textarea name="comment" id="comment" class="form-control bg-dark text-white" rows="3" placeholder="Write your review here..." required></textarea>
                                                                            @error('comment')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Cancel Rent Modal -->
                                                <div class="modal fade" id="cancelModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Request Rent Cancellation</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('payment.cancel', $payment->id) }}" method="POST" class="cancel-form">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-4">
                                                                        <p>You are requesting cancellation for:</p>
                                                                        <div class="card modal-info-card">
                                                                            <p class="mb-1"><strong>Property:</strong> {{ $payment->property->title }}</p>
                                                                            <p class="mb-1"><strong>Landlord:</strong> {{ $payment->landlord->name }}</p>
                                                                            <p class="mb-0"><strong>Rental Period:</strong> 
                                                                                {{ \Carbon\Carbon::parse($payment->start_date)->format('M d, Y') }} 
                                                                            </p>
                                                                            <p class="mb-0"><strong>Rental Next Payment:</strong> 
                                                                                @if($payment->status === 'completed' || $payment->status === 'rented')
                                                                                    @php
                                                                                        $nextPaymentDate = \Carbon\Carbon::parse($payment->start_date)->addMonth();
                                                                                        $nextPaymentText = $nextPaymentDate->format('M d, Y');
                                                                                    @endphp
                                                                                    {{ $nextPaymentText }}
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="cancellation_reason" class="form-label">Reason for Cancellation:</label>
                                                                        <textarea class="form-control bg-dark text-white" id="cancellation_reason" name="cancellation_reason" rows="4" required placeholder="Please explain your reason for cancellation..."></textarea>
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

                                                <!-- Rejected Cancellation Modal -->
                                                <div class="modal fade" id="rejectedModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Cancellation Rejected</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="alert-modal alert-danger">
                                                                    <i class="fas fa-exclamation-circle me-2"></i> Your cancellation request was rejected by the landlord.
                                                                </div>
                                                                <div class="card modal-info-card">
                                                                    <div class="card-header bg-secondary">Rejection Details</div>
                                                                    <div class="card-body">
                                                                        <p class="text-white"><strong>Reason:</strong></p>
                                                                        <p class="text-white">{{ $payment->rejection_reason }}</p>
                                                                        <p class="text-muted small mt-2">
                                                                            Rejected on: {{ $payment->updated_at->format('M d, Y h:i A') }}<br>
                                                                            <strong class="text-muted">Landlord:</strong> {{ $payment->landlord->name ?? 'N/A' }}
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination-container mt-4">
                                        <div class="pagination-info">
                                            Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} results
                                        </div>
                                        <ul class="pagination">
                                            <!-- Previous Page Link -->
                                            @if($payments->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">«</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $payments->previousPageUrl() }}" rel="prev">«</a>
                                                </li>
                                            @endif

                                            <!-- Page Numbers -->
                                            @foreach(range(1, $payments->lastPage()) as $i)
                                                @if($i >= $payments->currentPage() - 2 && $i <= $payments->currentPage() + 2)
                                                    <li class="page-item {{ ($payments->currentPage() == $i) ? 'active' : '' }}">
                                                        <a class="page-link" href="{{ $payments->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            <!-- Next Page Link -->
                                            @if($payments->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $payments->nextPageUrl() }}" rel="next">»</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">»</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i> You haven't rented any properties yet or all transactions are hidden.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('user-template/js/profile.js') }}"></script>
</body>
</html>