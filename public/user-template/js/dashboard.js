document.addEventListener('DOMContentLoaded', function() {
    // Access PHP data from global window object
    const rentedPerMonth = window.rentedPerMonth || {};
    const rentedPerWeek = window.rentedPerWeek || [];
    const propertyTypes = window.propertyTypes || {};

    console.log('Dashboard.js loaded');
    console.log('rentedPerMonth:', rentedPerMonth);
    console.log('rentedPerWeek:', rentedPerWeek);
    console.log('propertyTypes:', propertyTypes);

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
    } else {
        console.error('Sidebar or menu-toggle not found');
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
    } else {
        console.error('User trigger not found');
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
    } else {
        console.error('Notification trigger not found');
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

    // Modal handling
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const editProfileModal = document.getElementById('edit-profile-modal');
    const closes = document.querySelectorAll('.modal .close');

    if (editProfileBtn && editProfileModal) {
        editProfileBtn.addEventListener('click', () => {
            editProfileModal.classList.add('active');
            document.querySelector('.user')?.classList.remove('active');
            console.log('Edit profile modal opened');
        });

        closes.forEach(close => {
            close.addEventListener('click', () => {
                editProfileModal.classList.remove('active');
                console.log('Modal closed');
            });
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                editProfileModal.classList.remove('active');
                console.log('Modal closed by clicking outside');
            }
        });
    } else {
        console.error('Edit profile button or modal not found');
    }

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
    } else {
        console.error('Profile picture input or preview not found');
    }

    // Rented Trends Line Chart with tab switching
    const rentedCtx = document.getElementById('rentedChart')?.getContext('2d');
    if (rentedCtx) {
        let chart = new Chart(rentedCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: 'Rented Properties',
                    data: [
                        rentedPerMonth[1] || 0,
                        rentedPerMonth[2] || 0,
                        rentedPerMonth[3] || 0,
                        rentedPerMonth[4] || 0,
                        rentedPerMonth[5] || 0
                    ],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.max(...Object.values(rentedPerMonth).filter(v => v > 0), 10) + 5,
                        ticks: { stepSize: 5 }
                    }
                },
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
        console.log('Rented Trends Chart initialized');

        // Tab switching logic
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const tab = this.getAttribute('data-tab');
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                if (tab === 'month') {
                    chart.data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
                    chart.data.datasets[0].data = [
                        rentedPerMonth[1] || 0,
                        rentedPerMonth[2] || 0,
                        rentedPerMonth[3] || 0,
                        rentedPerMonth[4] || 0,
                        rentedPerMonth[5] || 0
                    ];
                    chart.options.scales.y.max = Math.max(...Object.values(rentedPerMonth).filter(v => v > 0), 10) + 5;
                } else if (tab === 'week') {
                    chart.data.labels = ['May 1-4', 'May 5-11', 'May 12-18'];
                    chart.data.datasets[0].data = rentedPerWeek;
                    chart.options.scales.y.max = Math.max(...rentedPerWeek.filter(v => v > 0), 5) + 5;
                }
                chart.update();
                console.log(`Switched to ${tab} tab`);
            });
        });
    } else {
        console.error('Rented Chart canvas not found');
    }

    // Types of Properties Pie Chart
    const propertyTypesCtx = document.getElementById('propertyTypesChart')?.getContext('2d');
    if (propertyTypesCtx) {
        const filteredPropertyTypes = Object.fromEntries(
            Object.entries(propertyTypes).filter(([_, value]) => value > 0)
        );
        const labels = Object.keys(filteredPropertyTypes).length > 0 ? Object.keys(filteredPropertyTypes) : ['No Data'];
        const data = Object.keys(filteredPropertyTypes).length > 0 ? Object.values(filteredPropertyTypes) : [1];

        new Chart(propertyTypesCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: labels.map((label) => {
                        const colors = {
                            'Apartment': '#FF6384',
                            'House': '#36A2EB',
                            'Condo': '#FFCE56',
                            'Townhouse': '#4BC0C0',
                            'Duplex': '#9966FF',
                            'Studio': '#FF9F40',
                            'No Data': '#D3D3D3'
                        };
                        return colors[label] || '#D3D3D3';
                    }),
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15
                        }
                    },
                    tooltip: {
                        enabled: Object.keys(filteredPropertyTypes).length > 0,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        console.log('Property Types Chart initialized successfully');
    } else {
        console.error('Property Types Chart canvas not found');
    }
});