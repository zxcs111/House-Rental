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