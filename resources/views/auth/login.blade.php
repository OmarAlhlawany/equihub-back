<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | EquiHub</title>
    
    <!-- AdminLTE Styles -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        /* Background Image */
        body {
            background: url('{{ asset('images/background.svg') }}') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
        }

        /* Centering the login box */
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent;
        }

        /* Login box adjustments */
        .login-box {
            width: 500px;
            
            border-radius: 35px;
            background-color: #fff;
            box-shadow: none;
            padding: 50px;
            text-align: center;
        }

        .login-logo {
            font-family: 'DM Sans', sans-serif;
            color: #2B37A0;
            font-size: 40px;
            font-weight: 700;
            text-shadow: 2px 4px 5px rgba(0, 0, 0, 0.2); /* Soft shadow */
        }

        /* Remove border from card */
        .login-card-body {
            background: transparent;
            border: none;
            padding: 0;
            margin-bottom: 20px;
        }
        /* Adjusted spacing between fields */
        .input-group {
            margin-bottom: 20px; /* Increased spacing */
        }

        /* Error message styles */
        .error-message {
            color: red;
            font-size: 14px;
            text-align: left;
        }
                
        /* Remove borders from input fields */
        .form-control {
            border: 1px solid #F0F0F0; /* Light border */
            border-radius: 5px;
            box-shadow: none;
            padding: 10px;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #1c1f7b;
            box-shadow: none;
        }

        .form-control:focus,
        .form-control:hover {
            border-color: #1c1f7b !important; /* لون الـ hover */
            box-shadow: 0 0 5px rgba(28, 31, 123, 0.5); /* لمعان خفيف */
        }

        .login-card-body .input-group .form-control, .register-card-body .input-group .form-control {
            border-right: 0;
            margin-bottom: 20px;
            margin-top: 20px;

        }
        /* Remove button border */
        .btn-primary {
            background-color: #2B37A0;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #1c1f7b;
        }

        /* Remove input-group border */
        .input-group-text {
            background: transparent;
            border: none;
            color: #2B37A0;
        }
        .input-group .form-control {
            border-right: 1px solid #F0F0F0 !important;
        }

        .input-group .form-control:focus,
        .input-group .form-control:hover {
            border-color: #1c1f7b !important;
        }

    </style>
</head>
<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <b>Login</b>
        </div>
        
        <div class="login-card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="error-message" id="emailError"></div>

                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required minlength="8">
                </div>
                <div class="error-message" id="passwordError"></div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <!-- AdminLTE Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let emailInput = document.getElementById('email');
            let emailError = document.getElementById('emailError');
            let passwordInput = document.getElementById('password');
            let passwordError = document.getElementById('passwordError');
            
            // Email Validation on Blur
            emailInput.addEventListener('blur', function () {
                if (emailInput.value.trim() === "") {
                    emailError.textContent = "Email is required.";
                } else {
                    emailError.textContent = "";
                }
            });
    
            // Password Validation on Blur
            passwordInput.addEventListener('blur', function () {
                if (passwordInput.value.trim() === "") {
                    passwordError.textContent = "Password is required.";
                } else {
                    passwordError.textContent = "";
                }
            });
    
            // Form Submission Validation
            document.getElementById('loginForm').addEventListener('submit', function (event) {
                let valid = true;
                
                // Check if email is empty
                if (emailInput.value.trim() === "") {
                    emailError.textContent = "Email is required.";
                    valid = false;
                } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(emailInput.value)) {
                    emailError.textContent = "Please enter a valid email address.";
                    valid = false;
                } else {
                    emailError.textContent = "";
                }
    
                // Check if password is empty or too short
                if (passwordInput.value.trim() === "") {
                    passwordError.textContent = "Password is required.";
                    valid = false;
                } else if (passwordInput.value.length < 8) {
                    passwordError.textContent = "Password must be at least 8 characters.";
                    valid = false;
                } else {
                    passwordError.textContent = "";
                }
    
                // Prevent form submission if validation fails
                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>

</body>
</html>
