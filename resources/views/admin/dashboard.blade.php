    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stay Haven Admin Dashboard</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: Arial, sans-serif;
            }
            body {
                background-color: #f5f7fa;
                overflow-x: hidden;
            }
            .sidebar {
                width: 250px;
                height: 100vh;
                background-color: #fff;
                position: fixed;
                padding: 20px;
                box-shadow: 2px 0 5px rgba(0,0,0,0.1);
                z-index: 1000;
                transition: transform 0.3s ease;
            }
            .sidebar .logo {
                font-size: 24px;
                font-weight: bold;
                color: #007bff;
                margin-bottom: 30px;
                display: block;
                white-space: nowrap;
            }
            .sidebar a {
                display: flex;
                align-items: center;
                padding: 10px;
                text-decoration: none;
                color: #6c757d;
                margin-bottom: 10px;
                font-size: 14px;
                white-space: nowrap;
            }
            .sidebar a:hover {
                background-color: #f0f0f0;
            }
            .sidebar a.active {
                background-color: #007bff;
                color: #fff;
            }
            .sidebar a i {
                margin-right: 10px;
                width: 20px;
                text-align: center;
            }
            .content {
                margin-left: 250px;
                padding: 20px;
                transition: margin-left 0.3s ease;
            }
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }
            .header h1 {
                font-size: 24px;
                color: #343a40;
            }
            .header .user {
                position: relative;
                display: flex;
                align-items: center;
                cursor: pointer;
            }
            .header .user .user-trigger {
                display: flex;
                align-items: center;
            }
            .header .user .small-img {
                width: 30px;
                height: 30px;
                margin-right: 10px;
            }
            .header .user .name {
                font-size: 14px;
                color: #343a40;
            }
            .header .user .dropdown {
                display: none;
                position: absolute;
                top: 40px;
                right: 0;
                background-color: #fff;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                z-index: 1;
                width: 300px;
                padding: 15px;
            }
            .header .user.active .dropdown {
                display: block;
            }
            .header .user .dropdown .profile-header {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
                border-bottom: 1px solid #007bff;
                padding-bottom: 10px;
            }
            .header .user .dropdown .profile-header img {
                width: 60px;
                height: 60px;
                margin-right: 10px;
            }
            .header .user .dropdown .profile-header .name {
                font-size: 16px;
                font-weight: bold;
                color: #343a40;
            }
            .header .user .dropdown .profile-buttons {
                display: flex;
                gap: 10px;
                margin-bottom: 15px;
            }
            .header .user .dropdown .profile-buttons button {
                flex: 1;
                padding: 8px;
                background-color: #007bff;
                color: white;
                border: none;
                cursor: pointer;
                font-size: 14px;
            }
            .header .user .dropdown .profile-buttons button:hover {
                background-color: #0056b3;
            }
            .header .user .dropdown form {
                margin: 0;
            }
            .header .user .dropdown button.logout {
                padding: 10px;
                background: none;
                border: none;
                color: #dc3545;
                cursor: pointer;
                font-size: 14px;
                text-align: left;
                width: 100%;
            }
            .header .user .dropdown button.logout:hover {
                background-color: #f8f9fa;
            }
            .stats {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 20px;
                margin-bottom: 20px;
            }
            .card {
                background-color: #fff;
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                text-align: left;
            }
            .card h3 {
                font-size: 14px;
                color: #6c757d;
                margin-bottom: 10px;
            }
            .card p {
                font-size: 24px;
                font-weight: bold;
                color: #343a40;
                margin: 0;
            }
            .card .change {
                font-size: 14px;
                margin-top: 5px;
            }
            .card .change.positive {
                color: #28a745;
            }
            .card .info {
                font-size: 12px;
                color: #6c757d;
                margin-top: 5px;
            }
            .charts {
                display: flex;
                gap: 20px;
                margin-bottom: 20px;
            }
            .chart-container {
                background-color: #fff;
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                flex: 1;
            }
            .chart-container h3 {
                font-size: 16px;
                color: #343a40;
                margin-bottom: 10px;
            }
            .chart-container .tabs {
                display: flex;
                gap: 10px;
                margin-bottom: 20px;
            }
            .chart-container .tabs button {
                padding: 5px 15px;
                border: 1px solid #007bff;
                background-color: #fff;
                color: #007bff;
                cursor: pointer;
                font-size: 12px;
            }
            .chart-container .tabs button.active {
                background-color: #007bff;
                color: #fff;
            }
            .chart-container .revenue {
                font-size: 24px;
                font-weight: bold;
                color: #343a40;
                margin-bottom: 20px;
            }
            .right-column {
                display: flex;
                flex-direction: column;
                gap: 20px;
                flex: 1;
            }
            .pending-properties {
                background-color: #fff;
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            .pending-properties h3 {
                font-size: 16px;
                color: #343a40;
                margin-bottom: 15px;
            }
            .pending-properties .property {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #e9ecef;
            }
            .pending-properties .property:last-child {
                border-bottom: none;
            }
            .pending-properties .property span {
                font-size: 14px;
                color: #343a40;
            }
            .pending-properties .property button {
                padding: 5px 10px;
                background-color: #28a745;
                color: white;
                border: none;
                cursor: pointer;
                font-size: 12px;
            }
            .pending-properties .property button:hover {
                background-color: #218838;
            }
            .bottom-section {
                display: flex;
                gap: 20px;
            }
            .recent-orders, .analytics-report {
                background-color: #fff;
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                flex: 1;
            }
            .recent-orders h3, .analytics-report h3 {
                font-size: 16px;
                color: #343a40;
                margin-bottom: 15px;
            }
            .recent-orders .booking {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid #e9ecef;
                font-size: 14px;
                color: #343a40;
            }
            .recent-orders .booking:last-child {
                border-bottom: none;
            }
            .analytics-report p {
                font-size: 14px;
                color: #6c757d;
            }
            .menu-toggle {
                display: none;
                position: fixed;
                top: 20px;
                left: 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                width: 40px;
                height: 40px;
                cursor: pointer;
                z-index: 1100;
            }
            .menu-toggle i {
                font-size: 20px;
            }

            /* Responsive Design */
            @media (max-width: 1024px) {
                .stats {
                    grid-template-columns: repeat(2, 1fr);
                }
                .charts {
                    flex-direction: column;
                }
                .right-column {
                    flex-direction: column;
                }
                .bottom-section {
                    flex-direction: column;
                }
            }

            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-250px);
                }
                .sidebar.open {
                    transform: translateX(0);
                }
                .content {
                    margin-left: 0;
                }
                .menu-toggle {
                    display: block;
                }
                .stats {
                    grid-template-columns: 1fr;
                }
                .header h1 {
                    font-size: 20px;
                }
                .header .user .dropdown {
                    width: 250px;
                }
            }

            @media (max-width: 480px) {
                .header .user .small-img {
                    width: 25px;
                    height: 25px;
                }
                .header .user .name {
                    font-size: 12px;
                }
                .header .user .dropdown {
                    width: 200px;
                }
                .header .user .dropdown .profile-header img {
                    width: 50px;
                    height: 50px;
                }
                .header .user .dropdown .profile-buttons button {
                    font-size: 12px;
                    padding: 6px;
                }
            }
        </style>
    </head>
    <body>
        <button class="menu-toggle"><i class="fas fa-bars"></i></button>
        <div class="sidebar">
            <div class="logo">Stay Haven</div>
            <a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            <a href="{{ route('admin.properties') }}"><i class="fas fa-home"></i><span>Properties</span></a>
            <a href="{{ route('admin.bookings') }}"><i class="fas fa-calendar-check"></i><span>Booked Property</span></a>
            <a href="{{ route('admin.total-users') }}"><i class="fas fa-users"></i><span>Users</span></a>
            <a href="{{ route('admin.reports') }}"><i class="fas fa-file-alt"></i><span>Reports</span></a>
            </div>
        <div class="content">
            <div class="header">
                <h1>Dashboard</h1>
                <div class="user">
                    <div class="user-trigger">
                        <img class="small-img" src="https://via.placeholder.com/30" alt="User">
                        <span class="name">John Doe</span>
                    </div>
                    <div class="dropdown">
                        <div class="profile-header">
                            <img src="https://via.placeholder.com/60" alt="Profile">
                            <div class="name">John Doe</div>
                        </div>
                        <div class="profile-buttons">
                            <button>Edit Profile</button>
                            <button>View Profile</button>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="stats">
                <div class="card">
                    <h3>Total Listings</h3>
                    <p>1,234</p>
                    <div class="change positive">↑ 5.2%</div>
                    <div class="info">You added 50 new listings this year</div>
                </div>
                <div class="card">
                    <h3>Total Bookings</h3>
                    <p>789</p>
                    <div class="change positive">↑ 3.8%</div>
                    <div class="info">You processed 30 extra bookings this year</div>
                </div>
                <div class="card">
                    <h3>Total Users</h3>
                    <p>2,345</p>
                    <div class="change positive">↑ 6.1%</div>
                    <div class="info">You gained 100 new users this year</div>
                </div>
                <div class="card">
                    <h3>Total Revenue</h3>
                    <p>$45,678</p>
                    <div class="change positive">↑ 4.5%</div>
                    <div class="info">You earned $2,000 extra this year</div>
                </div>
            </div>
            <div class="charts">
                <div class="chart-container" style="flex: 2;">
                    <h3>Booking Trends</h3>
                    <div class="tabs">
                        <button class="active">Month</button>
                        <button>Week</button>
                    </div>
                    <canvas id="bookingChart"></canvas>
                </div>
                <div class="right-column">
                    <div class="chart-container">
                        <h3>Revenue This Week</h3>
                        <div class="revenue">$6,500</div>
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <div class="pending-properties">
                        <h3>Pending Properties</h3>
                        <div class="property">
                            <span>Beachfront Villa - Landlord A</span>
                            <button>Approve</button>
                        </div>
                        <div class="property">
                            <span>Mountain Cabin - Landlord B</span>
                            <button>Approve</button>
                        </div>
                        <div class="property">
                            <span>City Apartment - Landlord C</span>
                            <button>Approve</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-section">
                <div class="recent-orders">
                    <h3>Recent Bookings</h3>
                    <div class="booking">
                        <span>#001 - Beachfront Villa</span>
                        <span>2025-05-01</span>
                    </div>
                    <div class="booking">
                        <span>#002 - Mountain Cabin</span>
                        <span>2025-05-02</span>
                    </div>
                    <div class="booking">
                        <span>#003 - City Apartment</span>
                        <span>2025-05-03</span>
                    </div>
                </div>
                <div class="analytics-report">
                    <h3>Analytics Report</h3>
                    <p>Summary of performance metrics, trends, and insights for the past month. Detailed report available for download.</p>
                </div>
            </div>
        </div>
        <script>
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

            // Toggle dropdown on click
            document.querySelector('.user-trigger').addEventListener('click', function() {
                const user = this.parentElement;
                user.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const user = document.querySelector('.user');
                const userTrigger = document.querySelector('.user-trigger');
                if (!userTrigger.contains(event.target) && !user.querySelector('.dropdown').contains(event.target)) {
                    user.classList.remove('active');
                }
            });

            // Booking Trends Line Chart
            const bookingCtx = document.getElementById('bookingChart').getContext('2d');
            new Chart(bookingCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Bookings',
                            data: [50, 100, 80, 150, 90, 70, 110, 130, 60, 80, 40, 90],
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Cancellations',
                            data: [20, 50, 40, 70, 30, 20, 60, 40, 30, 20, 10, 30],
                            borderColor: '#17a2b8',
                            backgroundColor: 'rgba(23, 162, 184, 0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 180,
                            ticks: { stepSize: 40 }
                        }
                    },
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Revenue Bar Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    datasets: [{
                        label: 'Revenue',
                        data: [900, 1200, 800, 1000, 600, 500, 700],
                        backgroundColor: '#17a2b8',
                        borderRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true, display: false },
                        x: { grid: { display: false } }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        </script>
    </body>
    </html>