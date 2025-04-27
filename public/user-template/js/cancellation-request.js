document.addEventListener('DOMContentLoaded', function () {
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // SweetAlert Confirmation for Approve
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function () {
            const paymentId = this.dataset.id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this cancellation request?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to approve the cancellation
                    axios.post(`/cancellation-requests/${paymentId}/approve`, {
                        _token: csrfToken
                    }).then(response => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Cancellation approved successfully.',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            location.reload(); // Refresh the page to update the UI
                        });
                    }).catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while approving the cancellation.',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    });
                }
            });
        });
    });

    // Handle Rejection via AJAX
    document.querySelectorAll('.submit-reject').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const paymentId = this.dataset.id;
            const form = document.getElementById(`rejectForm${paymentId}`);
            const formData = new FormData(form);

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to reject this cancellation request?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to reject the cancellation
                    axios.post(`/cancellation-requests/${paymentId}/reject`, formData, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    }).then(response => {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Successfully rejected the cancellation.',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            location.reload(); // Refresh the page to update the UI
                        });
                    }).catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while rejecting the cancellation.',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    });
                }
            });
        });
    });
});