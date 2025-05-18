<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bookins Property</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/dashboard.css') }}">

</head>
<body>

    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar">
        <div class="logo">Stay Haven</div>
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.properties') }}"><i class="fas fa-home"></i><span>Properties</span></a>
        <a href="{{ route('admin.total-users') }}"><i class="fas fa-users"></i><span>Users</span></a>
        <a href="{{ route('admin.transactions') }}"><i class="fas fa-money-bill-wave"></i><span>Transactions</span></a>
        <a href="{{ route('admin.reports') }}" class="active"><i class="fas fa-file-alt"></i><span>Reports</span></a>
    </div>

</body>
</html>