 // Set up CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Toggle sidebar on mobile
        const sidebar = document.querySelector('.sidebar');
        const menuToggle = document.querySelector('.menu-toggle');
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768 && sidebar.classList.contains('open') && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });

        // Toggle user dropdown on click
        document.querySelector('.user-trigger').addEventListener('click', function() {
            const user = this.parentElement;
            user.classList.toggle('active');
            document.querySelector('.notifications').classList.remove('active');
        });

        // Toggle notification dropdown on click
        document.querySelector('.notification-trigger').addEventListener('click', function() {
            const notifications = this.parentElement;
            notifications.classList.toggle('active');
            document.querySelector('.user').classList.remove('active');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const user = document.querySelector('.user');
            const userTrigger = document.querySelector('.user-trigger');
            const notifications = document.querySelector('.notifications');
            const notificationTrigger = document.querySelector('.notification-trigger');

            if (!userTrigger.contains(event.target) && !user.querySelector('.dropdown').contains(event.target)) {
                user.classList.remove('active');
            }
            if (!notificationTrigger.contains(event.target) && !notifications.querySelector('.notification-dropdown').contains(event.target)) {
                notifications.classList.remove('active');
            }
        });

        // Modal handling
        const editProfileBtn = document.getElementById('edit-profile-btn');
        const editProfileModal = document.getElementById('edit-profile-modal');
        const closes = document.querySelectorAll('.modal .close');

        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (editProfileModal) {
                    editProfileModal.classList.add('active');
                }
                document.querySelector('.user').classList.remove('active');
            });
        }

        closes.forEach(close => {
            close.addEventListener('click', () => {
                if (editProfileModal) {
                    editProfileModal.classList.remove('active');
                }
            });
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                if (editProfileModal) {
                    editProfileModal.classList.remove('active');
                }
            }
        });

        // Profile picture preview
        const profilePictureInput = document.getElementById('profile_picture');
        const profilePicturePreview = document.getElementById('profile-picture-preview-img');
        if (profilePictureInput && profilePicturePreview) {
            profilePictureInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePicturePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        document.querySelectorAll('.action-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const action = form.getAttribute('data-action');
                const isApprove = action === 'approve';
                const propertyTitle = form.closest('tr').querySelector('td:nth-child(2)').textContent;

                console.log('Action:', action, 'isApprove:', isApprove); // Debug log

                Swal.fire({
                    title: isApprove ? 'Approve Property' : 'Disapprove Property',
                    text: isApprove 
                        ? `Are you sure you want to approve this property? Property: ${propertyTitle}`
                        : `Are you sure you want to disapprove this property? Property: ${propertyTitle}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: isApprove ? '#28a745' : '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: isApprove ? 'Yes, Approve!' : 'Yes, Disapprove!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.action,
                            method: 'POST',
                            data: $(form).serialize(),
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#28a745'
                                    }).then(() => {
                                        window.location.reload(); // Maintain pagination/search
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message || 'Something went wrong.',
                                        icon: 'error',
                                        confirmButtonColor: '#dc3545'
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.error('AJAX Error:', xhr.status, xhr.responseText);
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Failed to process the request.',
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        });
                    }
                });
            });
        });