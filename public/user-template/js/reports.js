// Access chart data from the window object
const {
    userRegistrationsLabels,
    userRegistrationsData,
    priceRangeLabels,
    priceRangeData,
    paymentMethodLabels,
    paymentMethodData,
    revenueLabels,
    revenueData
} = window.chartData;

// User Registrations Chart
const userRegistrationsCtx = document.getElementById('userRegistrationsChart').getContext('2d');
new Chart(userRegistrationsCtx, {
    type: 'line',
    data: {
        labels: userRegistrationsLabels,
        datasets: [{
            label: 'User Registrations',
            data: userRegistrationsData,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.2)',
            fill: true,
            tension: 0.4,
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Number of Users', color: '#343a40', font: { size: 12 } },
                ticks: { color: '#6c757d', font: { size: 12 } }
            },
            x: {
                title: { display: true, text: 'Month', color: '#343a40', font: { size: 12 } },
                ticks: { color: '#6c757d', font: { size: 12 } }
            }
        },
        plugins: {
            legend: { labels: { color: '#343a40', font: { size: 12 } } },
            tooltip: { backgroundColor: '#fff', titleColor: '#343a40', bodyColor: '#6c757d', borderColor: '#ddd', borderWidth: 1 }
        }
    }
});

// Property Price Range Distribution Chart
const priceRangeCtx = document.getElementById('priceRangeChart').getContext('2d');
new Chart(priceRangeCtx, {
    type: 'pie',
    data: {
        labels: priceRangeLabels,
        datasets: [{
            data: priceRangeData,
            backgroundColor: ['#007bff', '#28a745', '#36b9cc', '#f6c23e', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { color: '#343a40', font: { size: 12 } } },
            tooltip: { backgroundColor: '#fff', titleColor: '#343a40', bodyColor: '#6c757d', borderColor: '#ddd', borderWidth: 1 }
        }
    }
});

// Payment Method Distribution Chart
const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
new Chart(paymentMethodCtx, {
    type: 'doughnut',
    data: {
        labels: paymentMethodLabels,
        datasets: [{
            data: paymentMethodData,
            backgroundColor: ['#28a745', '#f6c23e', '#dc3545', '#007bff', '#ff0000'] // Red for canceled
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { color: '#343a40', font: { size: 12 } } },
            tooltip: { backgroundColor: '#fff', titleColor: '#343a40', bodyColor: '#6c757d', borderColor: '#ddd', borderWidth: 1 }
        }
    }
});

// Monthly Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: revenueLabels,
        datasets: [{
            label: 'Revenue ($)',
            data: revenueData,
            backgroundColor: '#007bff',
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Revenue ($)', color: '#343a40', font: { size: 12 } },
                ticks: { color: '#6c757d', font: { size: 12 } }
            },
            x: {
                title: { display: true, text: 'Month', color: '#343a40', font: { size: 12 } },
                ticks: { color: '#6c757d', font: { size: 12 } }
            }
        },
        plugins: {
            legend: { labels: { color: '#343a40', font: { size: 12 } } },
            tooltip: { backgroundColor: '#fff', titleColor: '#343a40', bodyColor: '#6c757d', borderColor: '#ddd', borderWidth: 1 }
        }
    }
});