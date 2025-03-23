<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add your CSS or styles here -->
    <style>
        /* Basic styling for the logout button */
        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #dc3545; /* Red color for the button */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .logout-button:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>
    <p>You are logged in as an admin.</p>

    <!-- Logout Button -->
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf <!-- CSRF token for security -->
        <button type="submit" class="logout-button">Logout</button>
    </form>
</body>
</html>