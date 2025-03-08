@extends('layouts.app')
@section('page-title', 'Startup Profile')

@section('content')
    <div class="container py-5">
        <!-- Add this section for messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="text-center mb-5 animate-fade-in">
            <h1 class="display-4 text-gradient">Startup Profile</h1>
            <p class="lead text-muted">{{ $startup->name }}</p>
        </div>

        <div class="row">
            <!-- Startup Profile Card -->
            <div class="col-lg-8 mx-auto mb-4">
                <div class="profile-card animate-slide-up">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3>{{ $startup->name }}</h3>
                        <p>{{ $startup->company }}</p>
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-value">{{ $startup->revenue_growth }}%</div>
                            <div class="stat-label">Revenue Growth</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $startup->is_profitable ? 'Yes' : 'No' }}</div>
                            <div class="stat-label">Profitable</div>
                        </div>
                        
                    </div>

                    <div class="profile-body">
                        <!-- Business Overview Section -->
                        <div class="profile-section">
                            <h4>Business Overview</h4>
                            <div class="preference-grid">
                                <div class="preference-item">
                                    <i class="fas fa-industry"></i>
                                    <div>
                                        <label>Sector</label>
                                        <span>{{ $startup->sector_name }}</span>
                                    </div>
                                </div>
                                <div class="preference-item">
                                    <i class="fas fa-chart-line"></i>
                                    <div>
                                        <label>Stage</label>
                                        <span>{{ $startup->phase_name }}</span>
                                    </div>
                                </div>
                                <div class="preference-item">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <div>
                                        <label>Funding Needed</label>
                                        <span>{{ $startup->funding_name }}</span>
                                    </div>
                                </div>
                                <div class="preference-item">
                                    <i class="fas fa-globe-americas"></i>
                                    <div>
                                        <label>Target Market</label>
                                        <span>{{ $startup->market_name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Key Metrics Section -->
                        <div class="profile-section">
                            <h4>Key Metrics</h4>
                            <div class="metrics-grid">
                                <div class="metric-item">
                                    <div class="metric-icon success">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="metric-info">
                                        <label>Customer Base</label>
                                        <span>{{ number_format($startup->customer_count) }}</span>
                                    </div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-icon warning">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="metric-info">
                                        <label>Monthly Revenue</label>
                                        <span>${{ number_format($startup->monthly_revenue) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="profile-section">
                            <h4>Product/Service Description</h4>
                            <div class="description-box">
                                <p>{{ $startup->product_service_description }}</p>
                            </div>
                        </div>

                        <!-- Problem Solved Section -->
                        <div class="profile-section">
                            <h4>Problem Solved</h4>
                            <div class="description-box">
                                <p>{{ $startup->problem_solved }}</p>
                            </div>
                        </div>

                        <!-- Action Section -->
                        <div class="profile-section text-center">
                            <form action="{{ route('startup.api.test.send', $startup->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="action-button primary">
                                    <i class="fas fa-paper-plane"></i>
                                    Send to AI for Analysis
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Base Styles */
        :root {
            --primary-color: #2B37A0;
            --primary-light: #4e47d1;
            --secondary-color: #6c757d;
            --success-color: #2e7d32;
            --warning-color: #ed6c02;
            --danger-color: #d32f2f;
            --background-color: #f8f9fa;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        /* Text Gradient */
        .text-gradient {
            background: linear-gradient(120deg, var(--primary-color), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        /* Cards */
        .profile-card,
        .analysis-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            height: 100%;
            transition: var(--transition);
        }

        .profile-card:hover,
        .analysis-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        /* Profile Header */
        .profile-header {
            padding: 2rem;
            background: linear-gradient(120deg, var(--primary-color), var(--primary-light));
            color: white;
            text-align: center;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-avatar i {
            font-size: 2.5rem;
            color: white;
        }

        /* Profile Stats */
        .profile-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            padding: 1rem;
            background: white;
            margin-top: -1rem;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-item {
            text-align: center;
            padding: 0.5rem;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--secondary-color);
        }

        /* Profile Body */
        .profile-body {
            padding: 1.5rem;
        }

        .profile-section {
            margin-bottom: 1.5rem;
        }

        .profile-section h4 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        /* Preference Grid */
        .preference-grid {
            display: grid;
            gap: 1rem;
        }

        .preference-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            background: var(--background-color);
            border-radius: 12px;
        }

        .preference-item i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .preference-item label {
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin: 0;
        }

        .preference-item span {
            font-weight: 500;
            color: #2d3748;
        }

        /* Metrics Grid */
        .metrics-grid {
            display: grid;
            gap: 1rem;
        }

        .metric-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--background-color);
            border-radius: 12px;
            margin-bottom: 0.5rem;
        }

        .metric-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .metric-icon.success {
            background: var(--success-color);
        }

        .metric-icon.warning {
            background: var(--warning-color);
        }

        .metric-info label {
            display: block;
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin-bottom: 0.2rem;
        }

        .metric-info span {
            font-weight: 600;
            color: #2d3748;
        }

        /* Description Box */
        .description-box {
            background: var(--background-color);
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 1rem;
        }

        .description-box p {
            margin: 0;
            color: #2d3748;
            line-height: 1.6;
        }

        /* Action Button */
        .action-button.primary {
            background: linear-gradient(120deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            margin-top: 1rem;
        }

        .action-button.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(43, 55, 160, 0.2);
        }

        /* Animations */
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-slide-up {
            opacity: 0;
            transform: translateY(20px);
            animation: slideUp 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection