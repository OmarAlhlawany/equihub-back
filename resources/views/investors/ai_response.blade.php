@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="text-center animate-fade-in">
            <h1 class="display-4 text-gradient" style="color: #374151; font-weight: 500; font-size: 37px;">Investment Matches</h1>
            <p class="lead text-muted" style="color: #9CA3AF; font-weight: 400; font-size: 21px; text-align: left;">Recommended startups for {{ $investor->name }}</p>
        </div>

        <!-- Match Summary Section -->
        <div class="match-summary  animate-fade-in">
            <div class="summary-grid">
                <div class="summary-card">
                    
                    <div class="summary-content">
                        <h4>Average Match</h4>
                        <p>{{ $startups->avg('matching_percentage') ? round($startups->avg('matching_percentage')) : 0 }}%
                        </p>
                    </div>
                </div>
                <div class="summary-card">
                    
                    <div class="summary-content">
                        <h4>Best Match</h4>
                        <p>{{ $startups->max('matching_percentage') ? round($startups->max('matching_percentage')) : 0 }}%
                        </p>
                    </div>
                </div>
                <div class="summary-card">

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
                                <div class="d-flex align-items-center justify-content-between" style="gap: 10px;">
    {{-- اللوجو على الشمال --}}
    <div>
        <img src="{{ asset('images/startup-logo-icon.svg') }}" alt="Matching Percentage Icon"
             style="width: 52px; height: 52px;">
    </div>

    {{-- المؤشر على اليمين --}}
    <div style="text-align: center; margin-top: -8px;"> {{-- خلي المؤشر طالع فوق شوية --}}
    @php
        $percentage = $startup->matching_percentage;
        $totalDashes = 13;
        $filledDashes = round($totalDashes * $percentage / 100);
        $dashLength = 2; // طول الشرطة
        $innerRadius = 5; // بداية الشرطة من المركز
        $center = 8; // خلي مركز الدايرة فوق شوية
    @endphp

    <svg viewBox="0 0 17 17" width="22" height="22" class="circular-dash-chart">
        @for ($i = 0; $i < $totalDashes; $i++)
            @php
                $angle = ($i / $totalDashes) * 360 - 90;
                $angleRad = deg2rad($angle);

                $x1 = $center + $innerRadius * cos($angleRad);
                $y1 = $center + $innerRadius * sin($angleRad);

                $x2 = $center + ($innerRadius + $dashLength) * cos($angleRad);
                $y2 = $center + ($innerRadius + $dashLength) * sin($angleRad);
            @endphp
            <line x1="{{ $x1 }}" y1="{{ $y1 }}" x2="{{ $x2 }}" y2="{{ $y2 }}"
                  stroke="{{ $i < $filledDashes ? '#22c55e' : '#E5E7EB' }}"
                  stroke-width="1.5" stroke-linecap="round" />
        @endfor
    </svg>

    {{-- الرقم تحت المؤشر --}}
    <div style="font-size: 11px; font-weight: bold; color: #374151; margin-top: 1px;">
        {{ $percentage }}%
    </div>
</div>

</div>

                                <!-- Startup Header -->
                                <div class="startup-card-header">
                                    <h3 class="company-name">{{ $startup->name }}</h3>
                                    <p class="product-service-description">{{ $startup->product_service_description }}</p>
                                    <div class="badges">
                                        <span class="badge stage-badge">{{ $startup->phase_name }}</span>
                                        <span class="badge sector-badge">{{ $startup->sector_name }}</span>
                                    </div>
                                </div>

                                

                                    <!-- Company Info -->
                                    <div class="company-info">
                                        <div class="info-grid">
                                            <div class="info-item">
                                                <img src="{{ asset('images/startup-building-icon.svg') }}" alt="Company Icon" style="width: 20px; height: 20px;">
                                                <div>
                                                    <label>Company</label>
                                                    <span>{{ $startup->company }}</span>
                                                </div>
                                            </div>
                                            <div class="info-item">
                                                <img src="{{ asset('images/startup-pin-icon.svg') }}" alt="Funding Icon" style="width: 20px; height: 20px;">
                                                <div>
                                                    <label>Funding</label>
                                                    <span>{{ $startup->funding_name }}</span>
                                                </div>
                                            </div>
                                            <div class="info-item">
                                                <img src="{{ asset('images/startup-dollar-icon.svg') }}" alt="Market Icon" style="width: 20px; height: 20px;">
                                                <div>
                                                    <label>Market</label>
                                                    <span>{{ $startup->market_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Metrics -->
                                    <div class="d-flex justify-content-between align-items-center" style="gap: 20px; margin-bottom: 1rem;">
    
    <div class="d-flex flex-column align-items-center">
        <div class="d-flex align-items-center" style="gap: 5px;">
            <img src="{{ asset('images/startup-arrowup-icon.svg') }}" alt="Growth Icon" style="width: 16px; height: 16px;">
            <span class="metric-value" style="font-weight: bold;">{{ number_format($startup->revenue_growth, 1) }}%</span>
        </div>
        <span class="metric-label" style="font-size: 12px; color: #6B7280;">Revenue Growth</span>
    </div>

    <div class="text-center">
        <img src="{{ asset('images/startup-incentive-icon.svg') }}" alt="Incentive Icon" style="width: 50px; height: 50px;">
    </div>

    <div class="d-flex flex-column align-items-center">
        <div style="font-weight: bold;">
            {{ $startup->is_profitable ? 'Yes' : 'No' }}
        </div>
        <span class="metric-label" style="font-size: 12px; color: #6B7280;">Profitable</span>
    </div>

</div>


                                    <!-- Action Buttons -->
                                    <div class="card-actions">
                                        <button class="view-details-btn action-button"
                                            onclick="window.location.href='{{ route('startups.show', $startup->id) }}'"
                                            >
                                            <img src="{{ asset('images/startup-details-icon.svg') }}" alt="Info Icon" style="width: 20px; height: 20px; margin-right: 10px;">
                                            Details
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
            <!-- Navigation -->
<div class="text-center animate-fade-in" style="animation-delay: 0.5s; display: flex; justify-content: center; margin-top: 3rem;">
    <div style="display: flex; border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; background-color: white; width: 550px; height: 50px;">

        {{-- English PDF --}}
        <a href="{{ route('investors.pdf.ai_response.en', ['investor' => $investor->id]) }}"
           style="display: flex; align-items: center; justify-content: center; width: 50%; color: #1F2937; font-size: 15px; font-weight: 500; height: 100%; text-decoration: none;">
            <img src="{{ asset('images/startup-pdf-icon.svg') }}" alt="PDF Icon" style="width: 20px; height: 20px; margin-right: 20px;">
            Download English PDF
            <img src="{{ asset('images/startup-download-icon.svg') }}" alt="Download Icon" style="width: 20px; height: 20px; margin-left: 20px;">
        </a>

        {{-- Divider --}}
        <div style="width: 1px; background-color: #E5E7EB; height: 60%; align-self: center;"></div>

        {{-- Arabic PDF --}}
        <a href="{{ route('investors.pdf.ai_response.ar', ['investor' => $investor->id]) }}"
           style="display: flex; align-items: center; justify-content: center; width: 50%; color: #1F2937; font-size: 15px; font-weight: 500; height: 100%; text-decoration: none;">
            <img src="{{ asset('images/startup-pdf-icon.svg') }}" alt="PDF Icon" style="width: 20px; height: 20px; margin-right: 20px;">
            تحميل PDF بالعربية
            <img src="{{ asset('images/startup-download-icon.svg') }}" alt="Download Icon" style="width: 20px; height: 20px; margin-left: 20px;">
        </a>

    </div>
</div>

</div>

        </div>

      

    </div>

    <style>
        /* Modern, Professional Styling */
        .text-gradient {
            color: #374151; 
            font-weight: 500; 
            font-size: 37px;
            text-align: left;
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
            padding: 1.5rem 1.5rem 0.5rem 0rem;
            border-bottom: 1px solid #eef0f2;
            margin-bottom: 1rem;
        }

        .company-name {
            font-size: 21px;
            color: #374151;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .product-service-description {
            font-size: 14.5px;
            color: #6B7280;
            margin-bottom: 0.5rem;
            font-weight: 400;
        }

        .badges {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .sector-badge {
            background: #EFF6FF !important;
            color: #6B7280 !important;
        }

        .stage-badge {
            background: #EFF6FF !important;
            color: #6B7280 !important;
        }

        .startup-card-body {
            padding: 1.5rem;
        }

        .company-info {
            margin-top: 1rem;
            border-bottom: 1px solid #eef0f2;
            margin-bottom: 1rem;
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

        .info-item img {
            font-size: 1.2rem;
            margin-top: 0.2rem;
        }

        .info-item label {
            display: block;
            font-size: 10px;
            color: #6c757d;
            margin-bottom: 0.2rem;
            font-weight: 400;
        }

        .info-item span {
            color: #374151;
            font-weight: 400;
            font-size: 17px;
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
            background: #134DF4 ;
            color: white;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
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
            gap: .5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            border-radius: 7px;
            padding: 1rem 0rem 1rem 1rem;
            display: flex;
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
            font-size: 19px !important;
            font-weight: 500 !important;
            color: #4B5563 !important;
            margin: 0;
        }

        .summary-content p {
            font-size: 19px !important;
            font-weight: 500 !important;
            color: #374151 !important;
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
            border: none !important;
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