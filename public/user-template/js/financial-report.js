$(document).ready(function() {
    // Submit the search form when the user presses Enter
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            $('#searchForm').submit();
        }
    });

    // Submit the search form when the search button is clicked
    $('#searchForm button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        $('#searchForm').submit();
    });

    // Clear search when reset button is clicked
    $(document).on('click', '.reset', function() {
        $('#searchInput').val('');
        $('#searchForm').submit();
    });

    // Filter transactions by status
    $('.filter-status').on('click', function(e) {
        e.preventDefault();
        const status = $(this).data('status');
        if (status === 'all') {
            $('#transactionsTable tbody tr').show();
        } else {
            $('#transactionsTable tbody tr').each(function() {
                const rowStatus = $(this).data('status');
                if (status === 'rented' && (rowStatus === 'rented' || rowStatus === 'completed')) {
                    $(this).show();
                } else if (rowStatus === status) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
        updatePaginationInfo();
    });

    // Filter transactions by time period
    $('.filter-period').on('click', function(e) {
        e.preventDefault();
        const period = $(this).data('period');
        const now = new Date();
        const currentYear = now.getFullYear();
        const currentMonth = now.getMonth(); // 0-based (0 = January, 11 = December)

        $('#transactionsTable tbody tr').each(function() {
            const rowDateText = $(this).find('td:nth-child(1)').text().trim(); // Date column
            const rowDate = new Date(rowDateText); // Parse date like "Apr 22, 2025"

            if (isNaN(rowDate)) {
                $(this).hide(); // Hide rows with invalid dates
                return;
            }

            let shouldShow = false;

            if (period === 'this_month') {
                // Show rows from the current month and year
                shouldShow = rowDate.getFullYear() === currentYear && rowDate.getMonth() === currentMonth;
            } else if (period === 'last_month') {
                // Show rows from the previous month
                const lastMonth = currentMonth === 0 ? 11 : currentMonth - 1;
                const lastMonthYear = currentMonth === 0 ? currentYear - 1 : currentYear;
                shouldShow = rowDate.getFullYear() === lastMonthYear && rowDate.getMonth() === lastMonth;
            } else if (period === 'this_year') {
                // Show rows from the current year
                shouldShow = rowDate.getFullYear() === currentYear;
            }

            if (shouldShow) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        updatePaginationInfo();
    });

    // View receipt handler
    $(document).on('click', '.view-receipt', function() {
        const transactionId = $(this).data('transaction-id');
        const $row = $(this).closest('tr');
        const status = $row.data('status');
        // Only show receipt for rented/completed transactions
        if (status !== 'rented' && status !== 'completed') {
            alert('Receipt is only available for rented properties');
            return;
        }
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
            url: `/payments/${transactionId}/receipt`,
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
                </script>
            </body>
            </html>
        `);
        printWindow.document.close();
    });

    // Delete transaction handler with SweetAlert
    $(document).on('click', '.delete-transaction', function() {
        const transactionId = $(this).data('transaction-id');
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
                    url: `/landlord/financial-reporting/${transactionId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Hide the row with a fade-out effect
                            $row.fadeOut(300, function() {
                                $(this).remove();
                                updatePaginationInfo();
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

    // Function to update pagination info after client-side filtering
    function updatePaginationInfo() {
        const visibleRows = $('#transactionsTable tbody tr:visible').length;
        const totalRows = $('#transactionsTable tbody tr').length;
        const $paginationInfo = $('.text-muted');

        // Base pagination info is handled server-side, but adjust for client-side filters
        if (visibleRows < totalRows) {
            $paginationInfo.text(`Showing ${visibleRows} of ${totalRows} entries (filtered)`);
        }
    }
});