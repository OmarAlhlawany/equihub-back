<aside class="main-sidebar sidebar-collapse elevation-4" style="overflow-x: hidden;">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Brand Logo (non-clickable) -->
        <div class="brand-container d-flex align-items-center justify-content-center"
            style="height: 70px; padding: 0.5rem; border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.svg') }}" alt="EquiHub Logo" class="brand-image"
                    style="height: 40px; width: auto; opacity: 0.8;">
                <span class="brand-text ml-2" style="display: none; color: #6B7280;">EquiHub</span>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <!-- Menu items remain the same -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <img src="{{ asset('images/dashboard-tab.svg') }}" class="nav-icon" ">
                    <p>Dashboard</p>
                    </a>
                </li>
                <li class=" nav-item">
                        <a href="{{ route('users') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                            <img src="{{ asset('images/accounts-tab.svg') }}" class="nav-icon" style=" height: 20px; ">
                            <p>Accounts</p>
                        </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('investors') }}"
                        class="nav-link {{ request()->is('investors') ? 'active' : '' }}">
                        <img src="{{ asset('images/investors-tab.svg') }}" class="nav-icon" style="height: 20px;">
                        <p>Investors</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('startups') }}" class="nav-link {{ request()->is('startups') ? 'active' : '' }}">
                        <img src="{{ asset('images/startups-tab.svg') }}" class="nav-icon" style="height: 20px;">
                        <p>Startups</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('investor-insights') }}"
                        class="nav-link {{ request()->is('investor-insights') ? 'active' : '' }}">
                        <img src="{{ asset('images/investors-insights-tab.svg') }}" class="nav-icon"
                            style="height: 20px;">
                        <p>Investor Insights</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('startup-insights') }}"
                        class="nav-link {{ request()->is('startup-insights') ? 'active' : '' }}">
                        <img src="{{ asset('images/startups-insights-tab.svg') }}" class="nav-icon"
                            style="height: 20px;">
                        <p>Startup Insights</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dynamic-tables.index') }}"
                        class="nav-link {{ request()->is('dynamic-tables*') ? 'active' : '' }}">
                        <img src="{{ asset('images/edit-tables-tab.svg') }}" class="nav-icon" style="height: 20px;">
                        <p>Edit Tables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('whatsapp.index') }}"
                        class="nav-link {{ request()->is('whatsapp*') ? 'active' : '' }}">
                        <i class="fab fa-whatsapp nav-icon" style="color: #25D366; font-size: 20px;"></i>
                        <p>الواتساب</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
    /* Sidebar Base Styles */
    .main-sidebar {
        background-color: #F2F7FD !important;
        width: 70px;
        transition: width 0.3s ease;
        position: fixed;
        height: 100vh;
        z-index: 1038;

        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    /* Collapsed State */
    .sidebar-collapse .sidebar {
        overflow-x: hidden;

    }

    .sidebar-collapse .nav-sidebar .nav-link p,
    .sidebar-collapse .brand-text {
        display: none;
    }

    .sidebar-collapse .nav-sidebar .nav-link i {
        margin-right: 0;
    }

    /* Expanded State (on hover) */
    .main-sidebar:hover {
        width: 250px !important;
    }

    .main-sidebar:hover .nav-sidebar .nav-link p,
    .main-sidebar:hover .brand-text {
        display: inline-block;
        margin-left: 10px;
    }

    .main-sidebar:hover .nav-sidebar .nav-link i {
        margin-right: 0.5rem;
    }

    /* Nav Item Styling */
    .nav-sidebar>.nav-item>.nav-link {
        color: #6B7280;
        margin: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        justify-content: center;
        width: 50px;
        transition: all 0.3s ease;
    }

    .main-sidebar:hover .nav-sidebar>.nav-item>.nav-link {
        justify-content: flex-start;
        width: 230px;
    }

    .nav-sidebar>.nav-item>.nav-link:hover {
        background-color: rgba(19, 77, 244, 0.1) !important;
        color: #2B37A0;
    }

    .nav-sidebar>.nav-item>.nav-link.active {
        background-color: rgba(19, 77, 244, 0.2) !important;
        color: #2B37A0;
        font-weight: 600;
    }

    /* Brand Logo Styling */
    .brand-container {
        background-color: #F2F7FD !important;
        display: flex;
        justify-content: center;
    }

    .brand-text {
        font-size: 1rem;
        line-height: 1.5;
        transition: all 0.3s ease;
    }

    /* Elevation Shadow */
    .elevation-4 {
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.10), 0 10px 10px rgba(0, 0, 0, 0.08) !important;
    }

    .nav-sidebar>.nav-item {
        margin-bottom: 1rem;
    }

    .nav-icon {
        height: 24px;
        /* 👈 Change this value to control icon size */
        width: auto;
        transition: all 0.3s ease;
    }
</style>