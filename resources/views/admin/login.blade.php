<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Add your custom styles here */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #333;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 2rem;
            box-sizing: border-box;
        }
        .form header {
            font-size: 2rem;
            font-weight: 600;
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
            box-sizing: border-box;
        }
        .form input::placeholder {
            color: #ccc;
        }
        .form input:focus {
            border-color: #009579;
            box-shadow: 0 0 5px rgba(0, 149, 121, 0.5);
        }
        .form input.button {
            color: #fff;
            background: rgba(0, 149, 121, 0.8);
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 1px;
            margin-top: 1rem;
            cursor: pointer;
            transition: 0.4s;
            border: none;
            border-radius: 6px;
        }
        .form input.button:hover {
            background: rgba(0, 102, 83, 0.8);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login form">
            <header>Admin Login</header>
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                <input type="submit" class="button" value="Login">
            </form>
        </div>
    </div>
</body>
</html>