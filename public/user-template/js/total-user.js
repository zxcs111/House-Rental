  // Set up CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Toggle sidebar on mobile
        const sidebar = document.querySelector('.sidebar');
        const menuToggle = document.querySelector('.menu-toggle');
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                console.log('Sidebar toggled');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768 && sidebar.classList.contains('open') && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('open');
                    console.log('Sidebar closed');
                }
            });
        }

        // Toggle user dropdown on click
        const userTrigger = document.querySelector('.user-trigger');
        if (userTrigger) {
            userTrigger.addEventListener('click', function() {
                const user = this.parentElement;
                user.classList.toggle('active');
                document.querySelector('.notifications')?.classList.remove('active');
                console.log('User dropdown toggled');
            });
        }

        // Toggle notification dropdown on click
        const notificationTrigger = document.querySelector('.notification-trigger');
        if (notificationTrigger) {
            notificationTrigger.addEventListener('click', function() {
                const notifications = this.parentElement;
                notifications.classList.toggle('active');
                document.querySelector('.user')?.classList.remove('active');
                console.log('Notification dropdown toggled');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const user = document.querySelector('.user');
            const userTrigger = document.querySelector('.user-trigger');
            const notifications = document.querySelector('.notifications');
            const notificationTrigger = document.querySelector('.notification-trigger');

            if (user && userTrigger && !userTrigger.contains(event.target) && !user.querySelector('.dropdown').contains(event.target)) {
                user.classList.remove('active');
                console.log('User dropdown closed');
            }
            if (notifications && notificationTrigger && !notificationTrigger.contains(event.target) && !notifications.querySelector('.notification-dropdown').contains(event.target)) {
                notifications.classList.remove('active');
                console.log('Notification dropdown closed');
            }
        });

        // Modal handling for Edit Profile and Add User
        const editProfileBtn = document.getElementById('edit-profile-btn');
        const editProfileModal = document.getElementById('edit-profile-modal');
        const addUserBtn = document.getElementById('add-user-btn');
        const addUserModal = document.getElementById('add-user-modal');
        const closes = document.querySelectorAll('.modal .close');

        if (editProfileBtn && editProfileModal) {
            editProfileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                editProfileModal.classList.add('active');
                document.querySelector('.user')?.classList.remove('active');
                console.log('Edit profile modal opened');
            });
        }

        if (addUserBtn && addUserModal) {
            addUserBtn.addEventListener('click', function(e) {
                e.preventDefault();
                addUserModal.classList.add('active');
                console.log('Add user modal opened');
            });
        }

        closes.forEach(close => {
            close.addEventListener('click', () => {
                editProfileModal?.classList.remove('active');
                addUserModal?.classList.remove('active');
                const userModal = document.getElementById('user-details-modal');
                if (userModal) {
                    userModal.classList.remove('active');
                }
                console.log('Modal closed');
            });
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
                console.log('Modal closed by clicking outside');
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
                        console.log('Profile picture preview updated');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // View Details button handling
        document.querySelectorAll('.view-details-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('View Details button clicked');
                const userId = this.getAttribute('data-user-id');
                console.log('User ID:', userId);

                const modal = document.getElementById('user-details-modal');
                if (!modal) {
                    console.error('User details modal not found');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Modal element not found.',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                    return;
                }

                $.ajax({
                    url: `/total-users/${userId}`,
                    method: 'GET',
                    success: function(response) {
                        console.log('AJAX Success:', response);
                        if (response.success) {
                            const user = response.data;

                            // Populate modal fields
                            document.getElementById('user-name').textContent = user.name || 'N/A';
                            document.getElementById('user-email').textContent = user.email || 'N/A';
                            document.getElementById('user-role').textContent = user.role || 'User';
                            document.getElementById('user-created-at').textContent = user.created_at || 'N/A';

                            // Show modal
                            console.log('Showing user details modal');
                            modal.classList.add('active');
                        } else {
                            console.error('Response error:', response.message);
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to load user details.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.status, xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to load user details.',
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            });
        });

        // Add User form submission
        const addUserForm = document.getElementById('add-user-form');
        if (addUserForm) {
            addUserForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Add User form submitted');

                $.ajax({
                    url: addUserForm.action,
                    method: 'POST',
                    data: $(addUserForm).serialize(),
                    success: function(response) {
                        console.log('AJAX Success:', response);
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                addUserModal.classList.remove('active');
                                window.location.reload(); // Refresh to show new user
                            });
                        } else {
                            console.error('Response error:', response.message);
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to create user.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.status, xhr.responseText);
                        let errorMessage = 'Failed to create user.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join(' ');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            });
        }

        // Close user details modal
        const userModal = document.getElementById('user-details-modal');
        if (userModal) {
            userModal.querySelector('.close').addEventListener('click', () => {
                console.log('User modal close button clicked');
                userModal.classList.remove('active');
            });

            userModal.addEventListener('click', function(event) {
                if (event.target === this) {
                    console.log('Clicked outside user modal');
                    this.classList.remove('active');
                }
            });
        }