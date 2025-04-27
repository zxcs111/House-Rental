<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Login</title>
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

<!-- Login Section -->
<section class="ftco-section">
    <div class="container">
        <input type="checkbox" id="check">
        <div class="login form">
            <header>Login</header>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" placeholder="Enter your Gmail address" value="{{ old('email') }}" required oninput="validateGmail(this)">
                <span id="email-error" class="error-message"></span>
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
                <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}" required oninput="validateName(this)">
                <span id="name-error" class="error-message">{{ $errors->first('name') }}</span>
                <input type="email" name="email" placeholder="Enter your Gmail address" value="{{ old('email') }}" required oninput="validateGmail(this)">
                <span id="register-email-error" class="error-message">{{ $errors->first('email') }}</span>
                <input type="password" name="password" placeholder="Create a password" required>
                <span id="password-error" class="error-message">{{ $errors->first('password') }}</span>
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
                <span id="password-confirmation-error" class="error-message">{{ $errors->first('password_confirmation') }}</span>
                <select name="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                    <option value="landlord" {{ old('role') == 'landlord' ? 'selected' : '' }}>Landlord</option>
                </select>
                <span class="error-message">{{ $errors->first('role') }}</span>
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

<!-- Include jQuery and Toastr.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };

    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    function validateGmail(input) {
        const email = input.value;
        const gmailRegex = /^[a-zA-Z][a-zA-Z0-9.]*@gmail\.com$/;
        const errorElement = input.name === 'email' && input.closest('.login') 
            ? document.getElementById('email-error') 
            : document.getElementById('register-email-error');

        if (!email) {
            errorElement.textContent = 'Email is required.';
        } else if (!gmailRegex.test(email)) {
            errorElement.textContent = 'Email must be a valid Gmail address containing only letters, numbers, and dots (e.g., example@gmail.com).';
        } else {
            errorElement.textContent = '';
        }
    }

    function validateName(input) {
        const name = input.value;
        const nameRegex = /^[a-zA-Z\s]+$/;
        const errorElement = document.getElementById('name-error');

        if (!name) {
            errorElement.textContent = 'Name is required.';
        } else if (!nameRegex.test(name)) {
            errorElement.textContent = 'Name must contain only letters and spaces.';
        } else {
            errorElement.textContent = '';
        }
    }

    // Add event listener for name validation
    document.querySelector('input[name="name"]').addEventListener('input', function() {
        validateName(this);
    });
</script>


</body>
</html>