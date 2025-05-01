toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "5000"
};

// Use the session messages passed from the Blade file
if (window.successMessage) {
    toastr.success(window.successMessage);
}

if (window.errorMessage) {
    toastr.error(window.errorMessage);
}