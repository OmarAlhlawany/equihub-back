<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EquiHub Dashboard</title>

    <!-- AdminLTE Styles -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            background-color: #F2F7FD !important;
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
        }

        .main-header .navbar-nav {
            display: flex;
            align-items: center;
        }

        /* Sidebar Overlay Styles */
        .main-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040;
            transition: width 0.3s ease;
            width: 70px;
        }

        /* Content Wrapper Styles */
        .content-wrapper {
            background-color: #F2F7FD !important;
            margin-left: 70px;
            padding-top: 70px;
            transition: margin-left 0.3s ease;
            height: 100vh;
        }

        /* Expanded Sidebar Styles */
        .main-sidebar:hover {
            width: 250px;
        }

        .main-sidebar:hover+.content-wrapper {
            margin-left: 250px;
        }

        /* Logout Button Styles */
        .logout-btn {
            background-color: transparent;
            border: none;
            color: #6B7280;
            transition: color 0.3s ease;
        }

        .logout-btn:hover {
            color: #2B37A0;
        }

        /* Responsive Adjustments */
        @media (max-width: 767px) {
            .main-sidebar {
                width: 0;
            }

            .content-wrapper {
                margin-left: 0;
            }
        }

        /* Complete override for all states */
        .layout-fixed .content-wrapper,
        .layout-fixed .main-footer,
        .layout-fixed .main-header {
            margin-left: 70px !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand">
            <ul class="navbar-nav">
                <!-- Sidebar Toggle (Removed) -->
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn logout-btn" style="margin-left: 20px; font-size: 1.5rem;">
                            <i class="bi bi-box-arrow-left"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Include Sidebar -->
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pt-4">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>

    <!-- AdminLTE Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>

    <!-- Select2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    <script>
        // Ensure sidebar starts in collapsed state
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.add('sidebar-mini');
        });
    </script>

    @stack('scripts')
    @stack('head')
</body>

</html>