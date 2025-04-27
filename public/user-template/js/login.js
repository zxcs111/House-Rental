toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "5000"
};

function showToastrMessages(successMessage, errorMessage, errorList) {
    if (successMessage) {
        toastr.success(successMessage);
    }

    if (errorMessage) {
        toastr.error(errorMessage);
    }

    if (errorList && errorList.length > 0) {
        errorList.forEach(function(error) {
            toastr.error(error);
        });
    }
}

function validateGmail(input) {
    const email = input.value;
    const gmailRegex = /^[a-zA-Z][a-zA-Z0-9.]*@gmail\.com$/;
    const errorElement = input.name === 'email' && input.closest('.login') 
        ? document.getElementById('email-error') 
        : document.getElementById('register-email-error');

    if (!email) {
        errorElement.textContent = 'Email is required.';
    } else if (!gmailRegex.test(email)) {
        errorElement.textContent = 'Email must be a valid Gmail address containing only letters, numbers, and dots (e.g., example@gmail.com).';
    } else {
        errorElement.textContent = '';
    }
}

function validateName(input) {
    const name = input.value;
    const nameRegex = /^[a-zA-Z\s]+$/;
    const errorElement = document.getElementById('name-error');

    if (!name) {
        errorElement.textContent = 'Name is required.';
    } else if (!nameRegex.test(name)) {
        errorElement.textContent = 'Name must contain only letters and spaces.';
    } else {
        errorElement.textContent = '';
    }
}

// Add event listener for name validation
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.querySelector('input[name="name"]');
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            validateName(this);
        });
    }

    // Read auth data from JSON script tag
    const authDataElement = document.getElementById('auth-data');
    if (authDataElement) {
        const authData = JSON.parse(authDataElement.textContent);
        showToastrMessages(authData.success, authData.error, authData.errors);
    }
});