$('#contact-form').on('submit', function(e) {
    e.preventDefault();
    $('.form-control').removeClass('is-invalid');
    $('.invalid-feedback').empty();

    var $form = $(this);
    var $submitButton = $form.find('input[type="submit"]');
    $submitButton.prop('disabled', true).val('Sending...'); // Disable button and show loading text

    var formData = new FormData(this);
    console.log('Submitting form to:', $form.attr('action'));

    $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Success response:', response);
            Swal.fire({
                icon: 'success',
                title: 'Message Sent!',
                text: response.message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#8b5cf6'
            }).then((result) => {
                if (result.isConfirmed) {
                    $form[0].reset();
                }
            });
        },
        error: function(xhr) {
            console.log('Error response:', xhr);
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).siblings('.invalid-feedback').text(value[0]);
                });
            } else {
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                    ? xhr.responseJSON.message 
                    : 'An error occurred. Please try again later.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonText: 'Try Again',
                    confirmButtonColor: '#8b5cf6'
                });
            }
        },
        complete: function() {
            $submitButton.prop('disabled', false).val('Send Message'); // Re-enable button
        }
    });
});