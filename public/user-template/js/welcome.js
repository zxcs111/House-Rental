toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "5000"
};

function showToastrMessages(successMessage, errorMessage) {
    if (successMessage) {
        toastr.success(successMessage);
    }

    if (errorMessage) {
        toastr.error(errorMessage);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const welcomeDataElement = document.getElementById('welcome-data');
    if (welcomeDataElement) {
        const welcomeData = JSON.parse(welcomeDataElement.textContent);
        showToastrMessages(welcomeData.success, welcomeData.error);
    }
});