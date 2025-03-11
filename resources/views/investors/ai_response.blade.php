@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5 animate-fade-in">
            <h1 class="display-4 text-gradient">Investment Matches</h1>
            <p class="lead text-muted">Recommended startups for {{ $investor->name }}</p>
        </div>

        <!-- Match Summary Section -->
        <div class="match-summary mb-5 animate-fade-in">
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="summary-content">
                        <h4>Average Match</h4>
                        <p>{{ $startups->avg('matching_percentage') ? round($startups->avg('matching_percentage')) : 0 }}%
                        </p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="summary-content">
                        <h4>Best Match</h4>
                        <p>{{ $startups->max('matching_percentage') ? round($startups->max('matching_percentage')) : 0 }}%
                        </p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="summary-content">
                        <h4>Matches Found</h4>
                        <p>{{ $startups->count() }} Startups</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matched Startups Section -->
        <div class="matched-startups">
            @if($startups->count() > 0)
                <div class="row">
                    @foreach($startups as $startup)
                        <div class="col-md-6 col-lg-4 mb-4 animate-slide-up" style="animation-delay: {{ $loop->iteration * 0.1 }}s">
                            <div class="startup-card">
                                <!-- Matching Score Circle -->
                                <div class="matching-percentage" style="--percentage: {{ $startup->matching_percentage }}">
                                    <svg viewBox="0 0 36 36" class="circular-chart">
                                        <path
                                            d="M18 2.0845
                                                                                                                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                                                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                            fill="none" stroke="#eee" stroke-width="3" stroke-dasharray="100, 100" />
                                        <path
                                            d="M18 2.0845
                                                                                                                                                        a 15.9155 15.9155 0 0 1 0 31.831
                                                                                                                                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                            fill="none" stroke="#2B37A0" stroke-width="3"
                                            stroke-dasharray="{{ $startup->matching_percentage }}, 100"
                                            class="percentage-indicator" />
                                        <text x="18" y="20.35" class="percentage">{{ $startup->matching_percentage }}%</text>
                                    </svg>
                                </div>

                                <!-- Startup Header -->
                                <div class="startup-card-header">
                                    <h3 class="company-name">{{ $startup->name }}</h3>
                                    <div class="badges">
                                        <span class="badge sector-badge">{{ $startup->sector_name }}</span>
                                        <span class="badge stage-badge">{{ $startup->phase_name }}</span>
                                    </div>
                                </div>

                                <!-- Startup Body -->
                                <div class="startup-card-body">
                                    <!-- Matching Criteria -->
                                    @if($startup->sector_match_score > 0 || $startup->stage_match_score > 0 || $startup->budget_match_score > 0 || $startup->geographic_match_score > 0)
                                        <div class="matching-criteria">
                                            <h4>Matching Criteria</h4>
                                            <div class="criteria-grid">
                                                @if($startup->sector_match_score > 0)
                                                    <div class="criteria-item">
                                                        <div class="criteria-label">
                                                            <i class="fas fa-bullseye"></i>
                                                            <span>Sector Match</span>
                                                        </div>
                                                        <div class="progress-bar">
                                                            <div class="progress" style="width: {{ $startup->sector_match_score }}%"></div>
                                                        </div>
                                                        <span class="score">{{ $startup->sector_match_score }}%</span>
                                                    </div>
                                                @endif

                                                @if($startup->stage_match_score > 0)
                                                    <div class="criteria-item">
                                                        <div class="criteria-label">
                                                            <i class="fas fa-chart-line"></i>
                                                            <span>Stage Match</span>
                                                        </div>
                                                        <div class="progress-bar">
                                                            <div class="progress" style="width: {{ $startup->stage_match_score }}%"></div>
                                                        </div>
                                                        <span class="score">{{ $startup->stage_match_score }}%</span>
                                                    </div>
                                                @endif

                                                @if($startup->budget_match_score > 0)
                                                    <div class="criteria-item">
                                                        <div class="criteria-label">
                                                            <i class="fas fa-money-bill-wave"></i>
                                                            <span>Budget Match</span>
                                                        </div>
                                                        <div class="progress-bar">
                                                            <div class="progress" style="width: {{ $startup->budget_match_score }}%"></div>
                                                        </div>
                                                        <span class="score">{{ $startup->budget_match_score }}%</span>
                                                    </div>
                                                @endif

                                                @if($startup->geographic_match_score > 0)
                                                    <div class="criteria-item">
                                                        <div class="criteria-label">
                                                            <i class="fas fa-globe-americas"></i>
                                                            <span>Geographic Match</span>
                                                        </div>
                                                        <div class="progress-bar">
                                                            <div class="progress" style="width: {{ $startup->geographic_match_score }}%">
                                                            </div>
                                                        </div>
                                                        <span class="score">{{ $startup->geographic_match_score }}%</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Company Info -->
                                    <div class="company-info">
                                        <div class="info-grid">
                                            <div class="info-item">
                                                <i class="fas fa-building"></i>
                                                <div>
                                                    <label>Company</label>
                                                    <span>{{ $startup->company }}</span>
                                                </div>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <div>
                                                    <label>Funding</label>
                                                    <span>{{ $startup->funding_name }}</span>
                                                </div>
                                            </div>
                                            <div class="info-item">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div>
                                                    <label>Market</label>
                                                    <span>{{ $startup->market_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Metrics -->
                                    <div class="business-metrics">
                                        <div class="metric">
                                            <div class="metric-icon growth">
                                                <i class="fas fa-chart-line"></i>
                                            </div>
                                            <div class="metric-details">
                                                <span class="metric-value">{{ number_format($startup->revenue_growth, 1) }}%</span>
                                                <span class="metric-label">Revenue Growth</span>
                                            </div>
                                        </div>
                                        <div class="metric">
                                            <div class="metric-icon {{ $startup->is_profitable ? 'profit' : 'no-profit' }}">
                                                <i class="fas {{ $startup->is_profitable ? 'fa-check' : 'fa-times' }}"></i>
                                            </div>
                                            <div class="metric-details">
                                                <span class="metric-value">{{ $startup->is_profitable ? 'Yes' : 'No' }}</span>
                                                <span class="metric-label">Profitable</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="card-actions">
                                        <button class=view-details-btn
                                            onclick="window.location.href='{{ route('startups.show', $startup->id) }}'"
                                            class="action-button secondary">
                                            <i class="fas fa-info-circle"></i>
                                            View Details
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-results animate-fade-in">
                    <div class="no-results-content">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h3>No Matching Startups Found</h3>
                        <p>We couldn't find any startups matching your investment criteria at this time.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Navigation -->
        <div class="text-center mt-5 animate-fade-in" style="animation-delay: 0.5s">
            <a href="{{ route('investors.pdf.ai_response.en', ['investor' => $investor->id]) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Download English PDF
            </a>
            <a href="{{ route('investors.pdf.ai_response.ar', ['investor' => $investor->id]) }}" class="btn btn-secondary">
                <i class="fas fa-file-pdf"></i> تحميل PDF بالعربية
            </a>
            <a href="{{ route('investor.api.test', $investor->id) }}" class="back-button">
                <i class="fas fa-arrow-left mr-2"></i> Back to Investor Overview
            </a>
        </div>
    </div>

    <style>
        /* Modern, Professional Styling */
        .text-gradient {
            background: linear-gradient(120deg, #2B37A0, #4e47d1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .matched-startups {
            margin-top: 2rem;
        }

        .startup-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            position: relative;
            margin-top: 30px;
            padding: 1.5rem;
        }

        .startup-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .startup-card-header {
            padding: 1.5rem;
            background: linear-gradient(120deg, #f8f9fa, #ffffff);
            border-bottom: 1px solid #eef0f2;
        }

        .company-name {
            font-size: 1.4rem;
            color: #2B37A0;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .badges {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .sector-badge {
            background: #e8efff;
            color: var(--primary-color);
        }

        .stage-badge {
            background: #fff3e0;
            color: var(--warning-color);
        }

        .startup-card-body {
            padding: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .info-item i {
            color: #2B37A0;
            font-size: 1.2rem;
            margin-top: 0.2rem;
        }

        .info-item label {
            display: block;
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 0.2rem;
        }

        .info-item span {
            color: #2d3748;
            font-weight: 500;
            font-size: 1rem;
        }

        .startup-metrics {
            display: flex;
            justify-content: space-around;
            padding: 1.25rem 0;
            border-top: 1px solid #eef0f2;
            border-bottom: 1px solid #eef0f2;
            margin-bottom: 1.25rem;
        }

        .metric {
            text-align: center;
        }

        .metric-value {
            display: block;
            font-size: 1.25rem;
            font-weight: 600;
            color: #2B37A0;
        }

        .metric-label {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .view-details-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(120deg, #2B37A0, #4e47d1);
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .view-details-btn:hover {
            background: linear-gradient(120deg, #4e47d1, #2B37A0);
            color: white;
            transform: translateY(-2px);
        }

        .view-details-btn i {
            margin-left: 0.5rem;
        }

        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            background: #f8f9fa;
            border-radius: 20px;
            color: #6c757d;
        }

        .no-results i {
            color: #2B37A0;
            opacity: 0.5;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: #f8f9fa;
            color: #2B37A0;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #e9ecef;
            color: #2B37A0;
            text-decoration: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .startup-metrics {
                flex-direction: column;
                gap: 1rem;
            }
        }

        /* Add these new styles */
        .matching-percentage {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .circular-chart {
            width: 100%;
            height: 100%;
        }

        .percentage {
            font-family: sans-serif;
            font-size: 0.6em;
            text-anchor: middle;
            font-weight: bold;
            fill: #2B37A0;
        }

        .percentage-indicator {
            stroke-linecap: round;
            animation: progress 1s ease-out forwards;
        }

        @keyframes progress {
            0% {
                stroke-dasharray: 0, 100;
            }
        }

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
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .startup-card:hover .percentage-indicator {
            stroke: #4e47d1;
        }

        /* Add smooth transitions */
        .startup-card *,
        .back-button * {
            transition: all 0.3s ease;
        }

        /* Summary Grid */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(43, 55, 160, 0.15);
        }

        .summary-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(120deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .summary-content h4 {
            font-size: 0.9rem;
            color: var(--secondary-color);
            margin: 0;
        }

        .summary-content p {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        /* Matching Criteria */
        .matching-criteria {
            margin-bottom: 1.5rem;
        }

        .matching-criteria h4 {
            font-size: 1rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .criteria-grid {
            display: grid;
            gap: 0.75rem;
        }

        .criteria-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .criteria-label {
            width: 120px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        .criteria-label i {
            color: var(--primary-color);
        }

        .progress-bar {
            flex-grow: 1;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: linear-gradient(120deg, var(--primary-color), var(--primary-light));
            border-radius: 4px;
            transition: width 1s ease-out;
        }

        .score {
            width: 50px;
            text-align: right;
            font-weight: 500;
            color: var(--primary-color);
        }

        /* Business Metrics */
        .business-metrics {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin: 1.5rem 0;
            padding: 1rem 0;
            border-top: 1px solid #eef0f2;
            border-bottom: 1px solid #eef0f2;
        }

        .metric {
            display: flex;
            align-items: center;
            gap: 1rem;
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

        .metric-icon.growth {
            background: var(--success-color);
        }

        .metric-icon.profit {
            background: #2e7d32;
        }

        .metric-icon.no-profit {
            background: var(--danger-color);
        }

        .metric-details {
            display: flex;
            flex-direction: column;
        }

        .metric-value {
            font-weight: 600;
            color: #2d3748;
        }

        .metric-label {
            font-size: 0.8rem;
            color: var(--secondary-color);
        }

        /* Card Actions */
        .card-actions {
            display: grid;
            gap: 1rem;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
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

        /* Badges */
        .badges {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .sector-badge {
            background: #e8efff;
            color: var(--primary-color);
        }

        .stage-badge {
            background: #fff3e0;
            color: var(--warning-color);
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .business-metrics {
                grid-template-columns: 1fr;
            }

            .card-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animate progress bars on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.width = entry.target.getAttribute('data-width') + '%';
                    }
                });
            });

            document.querySelectorAll('.progress').forEach(progress => {
                progress.style.width = '0%';
                progress.setAttribute('data-width', progress.style.width.replace('%', ''));
                observer.observe(progress);
            });

            // Handle contact button clicks
            document.querySelectorAll('.contact-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const startupId = this.getAttribute('data-startup');
                    // Add your contact functionality here
                    alert('Contact functionality will be implemented soon!');
                });
            });
        });
    </script>
@endsection