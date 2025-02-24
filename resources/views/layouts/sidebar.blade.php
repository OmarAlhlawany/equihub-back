<aside class="main-sidebar  elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">EquiHub</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Accounts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('investors') }}" class="nav-link {{ request()->is('investors') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Investors</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('startups') }}" class="nav-link {{ request()->is('startups') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-lightbulb"></i>
                        <p>Startups</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('investor-insights') }}" class="nav-link {{ request()->is('insights') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Investor Insights</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('startup-insights') }}" class="nav-link {{ request()->is('insights') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Startup Insights</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dynamic-tables.index') }}" class="nav-link {{ request()->is('dynamic-tables') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Edit Tables</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
    /* Change Sidebar Background to White */
    .main-sidebar {
        background-color: white !important;
    }

    /* Change Sidebar Text & Icons Color */
    .main-sidebar .nav-link,
    .main-sidebar .brand-link {
        color: #B1B1B1 !important;
    }

    /* Sidebar Hover Effect */
    .main-sidebar .nav-link:hover {
        background-color: #f8f9fa !important;
        color: #2B37A0 !important;
    }

    /* Keep Active Sidebar Item Highlighted */
    .main-sidebar .nav-item .nav-link.active {
        background-color: #f8f9fa !important;
        color: #2B37A0 !important;
        font-weight: bold;
    }
    .main-sidebar .brank-link {
        border-bottom: 1px solid #f8f9fa !important;
    }
</style>
