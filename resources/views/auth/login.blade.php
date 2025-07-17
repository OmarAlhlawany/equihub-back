<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Angeleast</title>

    <!-- AdminLTE Styles -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        /* Global Styles */
        body {
            background-color: #F2F7FD !important;
            font-family: 'DM Sans', sans-serif;
        }

        /* Navbar Styles */
        .main-header {
            background-color: white !important;
            border-bottom: 1px solid #E5E7EB;
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            width: 100%;
            margin-left: 0 !important;
        }

        /* Login Page Styles */
        .login-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #F2F7FD !important;
            padding-top: 70px;
        }

        .login-box {
            width: 400px;
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .login-box img.logo {
            width: 70px;
            margin: 0 auto 20px auto;
            display: block;
        }

        .welcome-text {
            font-size: 12px;
            color: #6B7280;
            margin-bottom: 5px;
            text-align: left;
        }

        .login-title {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

.form-label {
    position: absolute;
    top: -10px;
    left: 12px;
    background: white;
    padding: 0 6px;
    font-size: 13px;
    color: #6B7280;
    z-index: 1;
}
        .form-control:focus {
    border-color: #0E57FF;
    box-shadow: 0 0 0 0.15rem rgba(14, 87, 255, 0.25);
}

.form-control:focus + label,
.form-control:not(:placeholder-shown) + label {
    top: -8px;
    left: 12px;
    font-size: 12px;
    color: #0E57FF;
}

.form-control {
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 14px;
    width: 100%;
    border: 1px solid #D1D5DB;
    background-color: white;
}

        /* Input Validation Styles */

        .form-group .input-validation {
            position: absolute;
            top: -20px;
            right: 0;
            font-size: 12px;
            color: #6B7280;
        }

        .form-check-label {
            font-size: 13px;
            color: #9CA3AF;
            
        }

        .forgot-password {
            font-size: 13px;
            color: #9CA3AF;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            background-color: #0E57FF;
            color: white;
            font-weight: 600;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            width: 100%;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #0046e0;
        }

        .signup-text {
            font-size: 13px;
            margin-top: 20px;
            text-align: center;
        }

        .signup-text span {
            color: #9CA3AF;
        }

        .signup-text a {
            color: #0E57FF;
            font-weight: 500;
            text-decoration: none;
        }

        .signup-text a:hover {
            text-decoration: underline;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9CA3AF;
        }
        .form-check {
    align-items: center;
    gap: 6px;
}
    </style>
</head>

<body class="hold-transition login-page">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand">
        <ul class="navbar-nav ml-auto">
        
        </ul>
    </nav>

    <div class="login-box">
        <img src="{{ asset('images/logo.svg') }}" class="logo" alt="Angeleast Logo">
        <div class="welcome-text">WELCOME</div>
        <div class="login-title">Log In to your Account</div>

        @if ($errors->any())
            <div class="alert alert-danger text-left">
                @foreach ($errors->all() as $error)
                    <p style="margin: 0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="johnsondoe@nomail.com" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="***************" required minlength="8">
                <span class="fas fa-eye toggle-password" onclick="togglePassword()"></span>
            </div>


            <div class="form-group d-flex justify-content-between align-items-center">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Remember me</label>
    </div>
    
</div>

            <button type="submit" class="btn btn-login">Login</button>

            
        </form>
    </div>

    <!-- AdminLTE Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = event.currentTarget;
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>