<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user-template/css/style.css') }}">

    <style>
        body {
            margin-top: 20px;
            background: url('user-template/images/profile-page.jpg');
            background-size: cover;
        }
        .img-account-profile {
            height: 10rem; 
            width: 10rem;
            border-radius: 50% !important; 
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
            border: none;
            border-radius: 0; 
            background: rgba(0, 0, 0, 0.8); 
        }
        
        .card-body{
            color: white;
            font-size: 0.875rem; 
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card .card-header {
            font-weight: 500;
            background-color: rgba(33, 40, 50, 0.03); /* Light gray background */
            border-bottom: 1px solid rgba(248, 249, 250, 0.13); /* Subtle border */
            padding: 1rem 1.35rem; /* Padding to match the previous design */
            font-size: 1rem; /* Font size to match the previous design */
            color: white; /* Dark text color */
            border-radius: 0; /* Removed border radius */
        }
        .form-control, .dataTable-input {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: white;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #c5ccd6;
            border-radius: 0; /* Removed border radius */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }
        .nav-borders .nav-link {
            color: white;
            border-bottom-width: 0.125rem;
            border-bottom-style: solid;
            border-bottom-color: transparent;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0;
            padding-right: 0;
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            border: none;
            border-radius: 0; /* Removed border radius */
            padding: 10px 20px;
            text-decoration: none;
        }
        .profile-image-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-image-section img {
            width: 10rem; /* Adjusted to match the previous design */
            height: 10rem; /* Adjusted to match the previous design */
            border-radius: 50%; /* Ensure the image is circular */
            object-fit: cover;
        }
        .profile-image-section h3 {
            margin-top: 15px;
            font-size: 1.25rem;
            font-weight: bold;
            color: white;
        }
        .btn {
            border-radius: 0; /* Removed border radius */
        }
        .container-xl {
            margin-top: 60px; /* Adjusted to move containers lower */
        }
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container-xl px-4">
        <!-- Back to Home Button -->
        <a href="{{ route('home') }}" class="btn back-to-home">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        <hr class="mt-0 mb-4">

        <div class="row">
            <!-- Profile Section -->
            <div class="col-xl-4">
                <!-- Profile picture card -->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <div class="profile-image-section">
                            @if(Auth::user()->profile_picture)
                                <img class="img-account-profile" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture">
                            @else
                                <i class="fas fa-user-circle img-account-profile" style="font-size: 10rem; color: #ccc;"></i>
                            @endif
                            <h3>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        </div>
                        <!-- Profile Picture Upload Form -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                            @csrf
                            <div class="form-group text-center">
                                <label for="profile_picture" class="btn btn-primary profile-picture-upload">
                                    <i class="fas fa-upload"></i> Upload Picture
                                </label>
                                <input type="file" name="profile_picture" id="profile_picture" class="d-none" onchange="this.form.submit()">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Rent History Section -->
                <div class="card mt-4">
                    <div class="card-header">Rent History</div>
                    <div class="card-body">
                        <!-- Rent History will be dynamically populated from the database -->
                        <div class="rent-history">
                            <!-- Example Rent Item -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Personal Information</div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ Auth::user()->first_name }}">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ Auth::user()->last_name }}">
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ Auth::user()->phone_number }}">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ Auth::user()->address ?? '' }}">
                            </div>
                            <div class="form-group text-center mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>