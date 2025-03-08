@extends('layouts.app')

@section('content')
        <div class="container py-5">
            <div class="text-center mb-5 animate-fade-in">
                <h1 class="display-4 text-gradient">AI Investment Matching</h1>
                <p class="lead text-muted">Advanced Analysis for {{ $investor->name }}</p>
            </div>

            <div class="row">
                <!-- Investor Profile Card -->
                <div class="col-lg-4 mb-4">
                    <div class="profile-card animate-slide-up">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h3>{{ $investor->name }}</h3>
                            <p>{{ $investor->company }}</p>
                        </div>

                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ $investor->favouriteSectors->count() }}</div>
                                <div class="stat-label">Preferred Sectors</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ optional($investor->budgetRange)->name }}</div>
                                <div class="stat-label">Investment Range</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ optional($investor->geographicalScope)->name }}</div>
                                <div class="stat-label">Geographic Focus</div>
                            </div>
                        </div>

                        <div class="profile-body">
                            <div class="profile-section">
                                <h4>Investment Preferences</h4>
                                <div class="preference-grid">
                                    <div class="preference-item">
                                        <i class="fas fa-chart-line"></i>
                                        <div>
                                            <label>Stage</label>
                                            <span>{{ optional($investor->favouriteInvestmentStage)->name }}</span>
                                        </div>
                                    </div>
                                    <div class="preference-item">
                                        <i class="fas fa-handshake"></i>
                                        <div>
                                            <label>Co-Investment</label>
                                            <span>{{ optional($investor->coInvest)->name }}</span>
                                        </div>
                                    </div>
                                    <div class="preference-item">
                                        <i class="fas fa-shield-alt"></i>
                                        <div>
                                            <label>Privacy</label>
                                            <span>{{ optional($investor->investmentPrivacyOption)->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-section">
                                <h4>Focus Sectors</h4>
                                <div class="sectors-grid">
                                    @foreach($investor->favouriteSectors as $sector)
                                        <span class="sector-badge">
                                            <i class="fas fa-check-circle"></i>
                                            {{ $sector->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
            </div>
        </div>
                </div>

                <!-- AI Analysis Section -->
                <div class="col-lg-8 mb-4">
                    <div class="analysis-card animate-slide-up" style="animation-delay: 0.2s">
                        <div class="analysis-header">
                            <div class="analysis-status">
                                <h3>AI Analysis Dashboard</h3>
                                <div class="status-pill {{ $aiResponse ? 'active' : 'pending' }}">
                                <i class="fas {{ $aiResponse ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    {{ $aiResponse ? 'Analysis Complete' : 'Awaiting Analysis' }}
                                </div>
                </div>
            </div>

                        <div class="analysis-body">
                            @if(!$aiResponse)
                                                    <div class="analysis-empty-state">
                                                        <div class="empty-state-icon">
                                                            <i class="fas fa-brain"></i>
                                                        </div>
                                                        <h4>Ready for Analysis</h4>
                                                        <p>Start the AI matching process to find compatible startups</p>
                                <form action="{{ route('investor.api.test.send', $investor->id) }}" method="POST">
                                    @csrf
                                                            <button type="submit" class="action-button">
                                                                <i class="fas fa-play-circle"></i>
                                                                Begin Analysis
                                                            </button>
                                </form>
                                                    </div>
                            @else
                                <div class="analysis-results">
                                    <div class="results-header">
                                        <div class="results-stats">
                                            <div class="stat-box">
                                                <div class="stat-value">{{ $startups->count() }}</div>
                                                <div class="stat-label">Matches Found</div>
                                            </div>
                                            <div class="stat-box">
                                                <div class="stat-value">
                                                    {{ $startups->avg('matching_percentage') ? round($startups->avg('matching_percentage')) : 0 }}%
                                                </div>
                                                <div class="stat-label">Avg. Match Rate</div>
                                            </div>
                                            <div class="stat-box">
                                                <div class="stat-value">
                                                    {{ $startups->max('matching_percentage') ? round($startups->max('matching_percentage')) : 0 }}%
                                                </div>
                                                <div class="stat-label">Best Match</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="results-actions">
                                        <a href="{{ route('investor.response.view', $investor->id) }}" class="action-button primary">
                                            <i class="fas fa-list"></i>
                                            View Detailed Results
                                        </a>
                                        <form action="{{ route('investor.api.test.send', $investor->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="action-button secondary">
                                                <i class="fas fa-redo"></i>
                                                Refresh Analysis
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
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
            .profile-card, .analysis-card {
                background: white;
                border-radius: 20px;
                box-shadow: var(--card-shadow);
                overflow: hidden;
                height: 100%;
                transition: var(--transition);
            }

            .profile-card:hover, .analysis-card:hover {
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

            /* Sectors Grid */
            .sectors-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .sector-badge {
                background: #e8efff;
                color: var(--primary-color);
                padding: 0.4rem 0.8rem;
                border-radius: 50px;
                font-size: 0.85rem;
                display: flex;
                align-items: center;
                gap: 0.3rem;
            }

            /* Analysis Card */
            .analysis-header {
                padding: 1.5rem;
                border-bottom: 1px solid #eef0f2;
            }

            .analysis-status {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .status-pill {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 1rem;
            border-radius: 50px;
                font-size: 0.9rem;
            }

            .status-pill.active {
                background: #e8f5e9;
                color: var(--success-color);
            }

            .status-pill.pending {
                background: #fff3e0;
                color: var(--warning-color);
            }

            /* Empty State */
            .analysis-empty-state {
                text-align: center;
                padding: 3rem 1.5rem;
            }

            .empty-state-icon {
                font-size: 3rem;
                color: var(--primary-color);
                margin-bottom: 1rem;
            }

            /* Results */
            .results-header {
                margin-bottom: 1.5rem;
            }

            .results-stats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            .stat-box {
                background: var(--background-color);
                padding: 1rem;
                border-radius: 12px;
                text-align: center;
            }

            .results-actions {
                display: flex;
                gap: 1rem;
                justify-content: center;
                margin-top: 1.5rem;
            }

            /* Buttons */
            .action-button {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                border-radius: 12px;
                font-weight: 500;
                transition: var(--transition);
                text-decoration: none;
            border: none;
                cursor: pointer;
            }

            .action-button.primary {
                background: linear-gradient(120deg, var(--primary-color), var(--primary-light));
            color: white;
            }

            .action-button.secondary {
                background: var(--background-color);
                color: var(--primary-color);
            }

            .action-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(43, 55, 160, 0.2);
            }

            /* Insights */
            .matching-insights {
                margin-top: 2rem;
            }

            .insights-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
                margin-top: 1rem;
            }

            .insight-card {
                background: white;
                padding: 1.5rem;
                border-radius: 12px;
                text-align: center;
                box-shadow: var(--card-shadow);
            }

            .insight-card i {
                font-size: 2rem;
                color: var(--primary-color);
                margin-bottom: 1rem;
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
                to { opacity: 1; }
            }

            @keyframes slideUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Responsive Design */
            @media (max-width: 992px) {
                .insights-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 768px) {
                .results-stats {
                    grid-template-columns: 1fr;
                }

                .insights-grid {
                    grid-template-columns: 1fr;
                }

                .results-actions {
                    flex-direction: column;
                }

                .action-button {
                    width: 100%;
                    justify-content: center;
                }
        }
    </style>
@endsection