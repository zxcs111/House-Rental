<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stay Haven - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- FontAwesome for icons -->
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
            width: 90%; /* Adjusted for smaller screens */
            background: rgba(0, 0, 0, 0.8); /* Dark transparent background */
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
            padding: 1.5rem; /* Reduced padding for smaller screens */
        }
        .form header {
            font-size: 1.75rem; /* Reduced font size for smaller screens */
            font-weight: 500;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #fff; /* White header color */
        }
        .form input {
            height: 50px; /* Reduced height for smaller screens */
            width: 100%;
            padding: 0 15px;
            font-size: 16px; /* Reduced font size for smaller screens */
            margin-bottom: 1rem; /* Reduced margin for smaller screens */
            border: 1px solid #444; /* Darker border */
            border-radius: 6px;
            outline: none;
            background: rgba(255, 255, 255, 0.1); /* Slightly opaque input background */
            color: #fff; /* White text color */
        }
        .form input::placeholder {
            color: #ccc; /* Light gray placeholder text */
        }
        .form input:focus {
            border-color: #009579; /* Highlight border on focus */
            box-shadow: 0 0 5px rgba(0, 149, 121, 0.5); /* Green glow on focus */
        }
        .form a {
            font-size: 14px; /* Reduced font size for smaller screens */
            color: #009579; /* Green link color */
            text-decoration: none;
        }
        .form a:hover {
            text-decoration: underline;
        }
        .form input.button {
            color: #fff;
            background: rgba(0, 149, 121, 0.8); /* Transparent button background */
            font-size: 1rem; /* Reduced font size for smaller screens */
            font-weight: 500;
            letter-spacing: 1px;
            margin-top: 1.5rem; /* Reduced margin for smaller screens */
            cursor: pointer;
            transition: 0.4s;
            border: none;
            border-radius: 6px;
        }
        .form input.button:hover {
            background: rgba(0, 102, 83, 0.8); /* Darker transparent hover effect */
        }
        .signup {
            font-size: 14px; /* Reduced font size for smaller screens */
            text-align: center;
            color: #ccc; /* Light gray text color */
        }
        .signup label {
            color: #009579; /* Green label color */
            cursor: pointer;
        }
        .signup label:hover {
            text-decoration: underline;
        }

        /* Back to Home Button */
        .back-to-home {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.8); /* Dark transparent background */
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-decoration: none;
            color: #fff; /* White text color */
            font-size: 14px; /* Reduced font size for smaller screens */
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background 0.3s ease;
        }
        .back-to-home:hover {
            background: rgba(0, 0, 0, 0.8); /* Darker on hover */
        }
        .back-to-home i {
            font-size: 12px; /* Reduced icon size for smaller screens */
        }

        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 480px) {
            .container {
                width: 95%; /* Further reduce width for very small screens */
            }
            .form header {
                font-size: 1.5rem; /* Further reduce font size for very small screens */
            }
            .form input {
                height: 45px; /* Further reduce height for very small screens */
                font-size: 14px; /* Further reduce font size for very small screens */
            }
            .form input.button {
                font-size: 0.9rem; /* Further reduce font size for very small screens */
            }
            .back-to-home {
                font-size: 12px; /* Further reduce font size for very small screens */
                padding: 8px 12px; /* Reduce padding for very small screens */
            }
            .back-to-home i {
                font-size: 10px; /* Further reduce icon size for very small screens */
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
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <!-- Login Form Template -->
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
                                <input type="submit" class="button" value="Signup">
                            </form>
                            <div class="signup">
                                <span class="signup">Already have an account?
                                    <label for="check">Login</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</body>
</html>