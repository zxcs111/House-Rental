
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
    input.value = input.value.replace(/\D/g, '');

    // Limit the input to 11 characters
    if (input.value.length > 11) {
        input.value = input.value.slice(0, 11);
    }
}


    // Set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $(document).ready(function() {

        $(document).on('click', '.hide-transaction', function() {
            const paymentId = $(this).data('payment-id');
            const $row = $(this).closest('tr');
    
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "This will hide the transaction from your view but keep it in the database.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hide it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with AJAX request to hide the transaction
                    $.ajax({
                        url: `/tenant/payments/${paymentId}/hide`,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                // Hide the row with a fade-out effect
                                $row.fadeOut(300, function() {
                                    $(this).remove();
                                    updateTableInfo();
                                });
    
                                // Show success message using SweetAlert
                                Swal.fire(
                                    'Hidden!',
                                    'The transaction has been hidden from your view.',
                                    'success'
                                );
                            } else {
                                // Show error message if hiding fails
                                Swal.fire(
                                    'Error!',
                                    response.message || 'Failed to hide transaction.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = 'Error hiding transaction';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
    
                            // Show error message using SweetAlert
                            Swal.fire(
                                'Error!',
                                errorMsg,
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            // Existing code...
        
            // Hide transaction handler with SweetAlert
            $(document).on('click', '.hide-transaction', function() {
                const paymentId = $(this).data('payment-id');
                const $row = $(this).closest('tr');
        
                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will hide the transaction from your view but keep it in the database.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, hide it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with AJAX request to hide the transaction
                        $.ajax({
                            url: `/tenant/payments/${paymentId}/hide`,
                            method: 'DELETE',
                            success: function(response) {
                                if (response.success) {
                                    // Hide the row with a fade-out effect
                                    $row.fadeOut(300, function() {
                                        $(this).remove();
                                        updateTableInfo();
                                    });
        
                                    // Show success message using SweetAlert
                                    Swal.fire(
                                        'Hidden!',
                                        'The transaction has been hidden from your view.',
                                        'success'
                                    );
                                } else {
                                    // Show error message if hiding fails
                                    Swal.fire(
                                        'Error!',
                                        response.message || 'Failed to hide transaction.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                let errorMsg = 'Error hiding transaction';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
        
                                // Show error message using SweetAlert
                                Swal.fire(
                                    'Error!',
                                    errorMsg,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        
            // Function to update table info after hiding
            function updateTableInfo() {
                const visibleRows = $('#rentHistoryTable tbody tr:visible').length;
                if (visibleRows === 0) {
                    $('#rentHistoryTable').hide();
                    $('.rent-history-card .card-body').html(`
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i> You haven't rented any properties yet or all transactions are hidden.
                        </div>
                    `);
                }
            }
        });
        
        // Handle review form submission
        $('.review-form').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let modal = form.closest('.modal');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Show SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Close the modal
                    modal.modal('hide');

                    // Refresh the page to reflect the updated review status
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    // Show SweetAlert error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.error || 'Something went wrong!',
                        timer: 2500,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Handle cancellation request form submission
        $('.cancel-form').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let modal = form.closest('.modal');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // Show SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message || 'Cancellation request submitted successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Close the modal
                    modal.modal('hide');

                    // Refresh the page to reflect the updated cancellation status
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    // Show SweetAlert error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.error || 'Something went wrong!',
                        timer: 2500,
                        showConfirmButton: false
                    });
                }
            });
        });
    });


    