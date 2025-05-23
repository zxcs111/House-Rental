<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Forgot Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/login.css') }}">
</head>
<body>
    <!-- Back to Home Button -->
    <a href="{{ route('home') }}" class="back-to-home">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    <!-- Forgot Password Section -->
    <section class="ftco-section">
        <div class="container">
            <div class="login form">
                <header>Forgot Password</header>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required oninput="validateGmail(this)">
                    <span id="email-error" class="error-message">{{ $errors->first('email') }}</span>
                    <input type="submit" class="button" value="Send Reset Link">
                </form>
                <div class="signup">
                    <span class="signup">
                        <a href="{{ route('login') }}">Back to Login</a>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Include jQuery and Toastr.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('user-template/js/login.js') }}"></script>

    <script id="auth-data" type="application/json">
        {
            "success": @json(Session::get('success')),
            "error": @json(Session::get('error')),
            "errors": @json($errors->all())
        }
    </script>
</body>
</html>