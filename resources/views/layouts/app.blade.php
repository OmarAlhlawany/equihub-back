<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EquiHub Dashboard</title>

    <!-- AdminLTE Styles -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Background Image for Content Wrapper */
        .content-wrapper {
            background: url('{{ asset('images/background.svg') }}') no-repeat center center fixed;
            background-size: cover;
        }

        /* Center the navbar title with equal spacing between items */
        .navbar-nav {
            display: flex;
            justify-content: space-between;
        }

        /* Centered Navbar Title */
        .navbar-brand {
            font-size: 32px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
            color: #2B37A0;
            flex-grow: 1;
            /* Allows the title to take available space */
            margin-left: 300px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Dynamic Page Title -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <span class="navbar-brand">@yield('page-title', 'Dashboard')</span>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger"
                            style="border-radius: 50px; margin-right: 20px;">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>


        <!-- Include Sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pt-3">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    <!-- AdminLTE Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
</body>

</html>