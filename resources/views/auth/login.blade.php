<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/login.css') }}">
    <style>
        
    </style>
</head>
<body>

<!-- Back to Home Button -->
<a href="{{ route('home') }}" class="back-to-home">
    <i class="fas fa-arrow-left"></i> Back to Home
</a>

<!-- Login Section -->
<section class="ftco-section">
    <div class="container">
        <input type="checkbox" id="check">
        <div class="login form">
            <header>Login</header>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                <a href="#">Forgot password?</a>
                <input type="submit" class="button" value="Login">
            </form>
            <div class="signup">
                <span class="signup">Don't have an account?
                    <label for="check">Signup</label>
                </span>
            </div>
        </div>
        <div class="registration form">
            <header>Signup</header>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" name="name" placeholder="Enter your name" required>
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="password" name="password" placeholder="Create a password" required>
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
                <select name="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="tenant">Tenant</option>
                    <option value="landlord">Landlord</option>
                </select>
                <input type="submit" class="button" value="Signup">
            </form>
            <div class="signup">
                <span class="signup">Already have an account?
                    <label for="check">Login</label>
                </span>
            </div>
        </div>
    </div>
</section>

</body>
</html>