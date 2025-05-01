<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Verify Email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('user-template/css/login.css') }}">
</head>
<body>

    <a href="{{ route('home') }}" class="back-to-home">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>

    <section class="ftco-section">
        <div class="container">
            <div class="login form">
                <header>Verify Your Email</header>
                <p>A verification code has been sent to {{ $email }}. Please enter the code below.</p>
                <form method="POST" action="{{ route('verify.email') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="text" name="code" placeholder="Enter verification code" required>
                    <span class="error-message">{{ $errors->first('code') }}</span>
                    <input type="submit" class="button" value="Verify">
                </form>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('user-template/js/verifyemail.js') }}"></script>
    
    <script>
        window.successMessage = "{{ session('success') }}";
        window.errorMessage = "{{ session('error') }}";
    </script>
    
</body>
</html>