// Set up CSRF token for AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// View Details button handling
const viewDetailsButtons = document.querySelectorAll('.view-details-btn');

viewDetailsButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        
        const userId = this.getAttribute('data-user-id');
        if (!userId) {
            toastr.error('User ID not found.');
            return;
        }

        const modal = document.getElementById('user-details-modal');
        if (!modal) {
            toastr.error('Modal element not found.');
            return;
        }

        const userDetailsContent = document.getElementById('user-details-content');
        if (!userDetailsContent) {
            toastr.error('User details content element not found.');
            return;
        }

        const requestUrl = userDetailRoute.replace(':id', userId);

        $.ajax({
            url: requestUrl,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const user = response.data;

                    let detailsHtml = `
                        <div class="user-profile-header">
                            ${user.profile_picture ? `<img src="${user.profile_picture}" alt="Profile Picture" class="profile-picture">` : '<div class="profile-placeholder"><i class="fas fa-user"></i></div>'}
                            <h3>${user.name || 'N/A'}</h3>
                        </div>
                        <div class="user-details-grid">
                            <div class="detail-item">
                                <strong>Email:</strong>
                                <span>${user.email || 'N/A'}</span>
                            </div>
                            <div class="detail-item">
                                <strong>Role:</strong>
                                <span>${user.role || 'User'}</span>
                            </div>
                            <div class="detail-item">
                                <strong>Created At:</strong>
                                <span>${user.created_at || 'N/A'}</span>
                            </div>
                    `;

                    if (user.first_name) {
                        detailsHtml += `
                            <div class="detail-item">
                                <strong>First Name:</strong>
                                <span>${user.first_name}</span>
                            </div>`;
                    }
                    if (user.last_name) {
                        detailsHtml += `
                            <div class="detail-item">
                                <strong>Last Name:</strong>
                                <span>${user.last_name}</span>
                            </div>`;
                    }
                    if (user.phone_number) {
                        detailsHtml += `
                            <div class="detail-item">
                                <strong>Phone Number:</strong>
                                <span>${user.phone_number}</span>
                            </div>`;
                    }
                    if (user.address) {
                        detailsHtml += `
                            <div class="detail-item">
                                <strong>Address:</strong>
                                <span>${user.address}</span>
                            </div>`;
                    }

                    detailsHtml += '</div>';

                    userDetailsContent.innerHTML = detailsHtml;
                    modal.classList.add('active');
                } else {
                    toastr.error(response.message || 'Failed to load user details.', '', {
                        timeOut: 2000,
                        closeButton: true,
                        progressBar: true
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = xhr.responseJSON?.message || 'Failed to load user details.';
                if (xhr.status === 401) {
                    errorMessage = 'Unauthorized access. Please log in as an admin.';
                } else if (xhr.status === 404) {
                    errorMessage = `User with ID ${userId} not found.`;
                }
                toastr.error(errorMessage, '', {
                    timeOut: 2000,
                    closeButton: true,
                    progressBar: true
                });
            }
        });
    });
});

// Close user details modal
const userModal = document.getElementById('user-details-modal');
if (userModal) {
    userModal.querySelector('.close').addEventListener('click', () => {
        userModal.classList.remove('active');
    });

    userModal.addEventListener('click', function(event) {
        if (event.target === this) {
            this.classList.remove('active');
        }
    });
}

// Modal handling for Add User
const addUserBtn = document.getElementById('add-user-btn');
const addUserModal = document.getElementById('add-user-modal');
const closes = document.querySelectorAll('.modal .close');

if (addUserBtn && addUserModal) {
    addUserBtn.addEventListener('click', function(e) {
        e.preventDefault();
        addUserModal.classList.add('active');
    });
}

// Close modals when clicking the close button
closes.forEach(close => {
    close.addEventListener('click', () => {
        const addUserModal = document.getElementById('add-user-modal');
        if (addUserModal) {
            addUserModal.classList.remove('active');
        }
        const userModal = document.getElementById('user-details-modal');
        if (userModal) {
            userModal.classList.remove('active');
        }
        const editUserModal = document.getElementById('edit-user-modal');
        if (editUserModal) {
            editUserModal.classList.remove('active');
        }
    });
});

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
});

// Add User form submission with email validation
const addUserForm = document.getElementById('add-user-form');
if (addUserForm) {
    addUserForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const emailInput = document.getElementById('add-user-email');
        const email = emailInput.value.trim();
        const isValidEmail = validateEmail(email);

        if (!isValidEmail) {
            toastr.error('Please enter a valid @gmail.com email with only letters and numbers. No symbols or integers only allowed.', '', {
                timeOut: 2000,
                closeButton: true,
                progressBar: true
            });
            return;
        }

        $.ajax({
            url: addUserRoute,
            method: 'POST',
            data: $(addUserForm).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message || 'User created successfully!', '', {
                        timeOut: 2000,
                        closeButton: true,
                        progressBar: true
                    });
                    setTimeout(() => {
                        addUserModal.classList.remove('active');
                        window.location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message || 'Failed to create user.', '', {
                        timeOut: 2000,
                        closeButton: true,
                        progressBar: true
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to create user.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join(' ');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                toastr.error(errorMessage, '', {
                    timeOut: 2000,
                    closeButton: true,
                    progressBar: true
                });
            }
        });
    });
}

// Email validation function
function validateEmail(email) {
    if (!email.toLowerCase().endsWith('@gmail.com')) {
        return false;
    }

    const username = email.split('@')[0];
    const symbolRegex = /[^a-zA-Z0-9]/;
    if (symbolRegex.test(username)) {
        return false;
    }

    const integerRegex = /^[0-9]+$/;
    if (integerRegex.test(username)) {
        return false;
    }

    const emailRegex = /^[a-zA-Z0-9]+@gmail\.com$/;
    return emailRegex.test(email);
}

// Edit User button handling
const editUserButtons = document.querySelectorAll('.edit-user-btn');
const editUserModal = document.getElementById('edit-user-modal');

editUserButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        const userId = this.getAttribute('data-user-id');
        if (!userId) {
            toastr.error('User ID not found.');
            return;
        }

        const requestUrl = editUserRoute.replace(':id', userId);

        $.ajax({
            url: requestUrl,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const user = response.data;

                    document.getElementById('edit-user-id').value = user.id;
                    document.getElementById('edit-user-name').value = user.name;
                    document.getElementById('edit-user-email').value = user.email;
                    document.getElementById('edit-user-role').value = user.role;
                    document.getElementById('edit-user-status').value = user.is_active ? '1' : '0';
                    document.getElementById('edit-user-password').value = '';

                    editUserModal.classList.add('active');
                } else {
                    toastr.error(response.message || 'Failed to load user data.', '', {
                        timeOut: 2000,
                        closeButton: true,
                        progressBar: true
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = xhr.responseJSON?.message || 'Failed to load user data.';
                if (xhr.status === 401) {
                    errorMessage = 'Unauthorized access. Please log in as an admin.';
                } else if (xhr.status === 404) {
                    errorMessage = `User with ID ${userId} not found.`;
                }
                toastr.error(errorMessage, '', {
                    timeOut: 2000,
                    closeButton: true,
                    progressBar: true
                });
            }
        });
    });
});

// Edit User form submission with email validation
const editUserForm = document.getElementById('edit-user-form');
if (editUserForm) {
    editUserForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const emailInput = document.getElementById('edit-user-email');
        const email = emailInput.value.trim();
        const isValidEmail = validateEmail(email);

        if (!isValidEmail) {
            toastr.error('Please enter a valid @gmail.com email with only letters and numbers. No symbols or integers only allowed.', '', {
                timeOut: 2000,
                closeButton: true,
                progressBar: true
            });
            return;
        }

        const userId = document.getElementById('edit-user-id').value;
        const requestUrl = updateUserRoute.replace(':id', userId);

        $.ajax({
            url: requestUrl,
            method: 'PUT',
            data: $(editUserForm).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message || 'User updated successfully!', '', {
                        timeOut: 2000,
                        closeButton: true,
                        progressBar: true
                    });
                    setTimeout(() => {
                        editUserModal.classList.remove('active');
                        window.location.reload();
                    }, 2000);
                } else {
                    toastr.error(response.message || 'Failed to update user.', '', {
                        timeOut: 2000,
                        closeButton: true,
                        progressBar: true
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to update user.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join(' ');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                toastr.error(errorMessage, '', {
                    timeOut: 2000,
                    closeButton: true,
                    progressBar: true
                });
            }
        });
    });
}

// Delete User button handling with SweetAlert2
const deleteUserButtons = document.querySelectorAll('.delete-user-btn');

deleteUserButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        const userId = this.getAttribute('data-user-id');
        if (!userId) {
            toastr.error('User ID not found.');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this user. This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f44336',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const requestUrl = deleteUserRoute.replace(':id', userId);

                $.ajax({
                    url: requestUrl,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message || 'User deleted successfully!', '', {
                                timeOut: 2000,
                                closeButton: true,
                                progressBar: true
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            toastr.error(response.message || 'Failed to delete user.', '', {
                                timeOut: 2000,
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to delete user.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        toastr.error(errorMessage, '', {
                            timeOut: 2000,
                            closeButton: true,
                            progressBar: true
                        });
                    }
                });
            }
        });
    });
});