<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Import Google font - Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: url('user-template/images/login-background.jpg') no-repeat center fixed;
            background-size: cover;
        }
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 430px;
            width: 90%;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 7px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        }
        .container .registration {
            display: none;
        }
        #check:checked ~ .registration {
            display: block;
        }
        #check:checked ~ .login {
            display: none;
        }
        #check {
            display: none;
        }
        .container .form {
            padding: 1.5rem;
        }
        .form header {
            font-size: 1.75rem;
            font-weight: 500;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #fff;
        }
        .form input {
            height: 50px;
            width: 100%;
            padding: 0 15px;
            font-size: 16px;
            margin-bottom: 1rem;
            border: 1px solid #444;
            border-radius: 6px;
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .form input::placeholder {
            color: #ccc;
        }
        .form input:focus {
            border-color: #009579;
            box-shadow: 0 0 5px rgba(0, 149, 121, 0.5);
        }
        .form a {
            font-size: 14px;
            color: #009579;
            text-decoration: none;
        }
        .form a:hover {
            text-decoration: underline;
        }
        .form input.button {
            color: #fff;
            background: rgba(0, 149, 121, 0.8);
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 1px;
            margin-top: 1.5rem;
            cursor: pointer;
            transition: 0.4s;
            border: none;
            border-radius: 6px;
        }
        .form input.button:hover {
            background: rgba(0, 102, 83, 0.8);
        }
        .signup {
            font-size: 14px;
            text-align: center;
            color: #ccc;
        }
        .signup label {
            color: #009579;
            cursor: pointer;
        }
        .signup label:hover {
            text-decoration: underline;
        }
        .back-to-home {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.8);
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-decoration: none;
            color: #fff;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background 0.3s ease;
        }
        .back-to-home:hover {
            background: rgba(0, 0, 0, 0.8);
        }
        .back-to-home i {
            font-size: 12px;
        }

        /* Style for the dropdown */
        select {
            height: 50px;
            width: 100%;
            padding: 0 15px;
            font-size: 16px;
            margin-bottom: 1rem;
            border: 1px solid #444;
            border-radius: 6px;
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
        }

        /* Style for the dropdown arrow */
        select {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ffffff'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 12px;
        }

        /* Style for dropdown options */
        select option {
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
        }

        /* Hover and focus styles */
        select:hover,
        select:focus {
            border-color: #009579;
            box-shadow: 0 0 5px rgba(0, 149, 121, 0.5);
        }

        @media (max-width: 480px) {
            .container {
                width: 95%;
            }
            .form header {
                font-size: 1.5rem;
            }
            .form input {
                height: 45px;
                font-size: 14px;
            }
            .form input.button {
                font-size: 0.9rem;
            }
            .back-to-home {
                font-size: 12px;
                padding: 8px 12px;
            }
            .back-to-home i {
                font-size: 10px;
            }
        }
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
                <!-- Name -->
                <input type="text" name="name" placeholder="Enter your name" required>

                <!-- Email -->
                <input type="email" name="email" placeholder="Enter your email" required>

                <!-- Password -->
                <input type="password" name="password" placeholder="Create a password" required>

                <!-- Confirm Password -->
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>

                <!-- User Type (Role) -->
                <select name="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="tenant">Tenant</option>
                    <option value="landlord">Landlord</option>
                </select>

                <!-- Submit Button -->
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