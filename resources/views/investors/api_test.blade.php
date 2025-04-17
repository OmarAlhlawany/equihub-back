@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row mb-4 align-items-center">
    <!-- العنوان والوصف -->
    <div class="col">
        <h2 style="color: #374151; font-weight: 500; font-size: 37px;">Investment Matches</h2>
        <p style="color: #9CA3AF; font-weight: 400; font-size: 21px;">Recommended startups for  {{ $investor->name }}</p>
    </div>

    <!-- زر تحميل PDF -->
    <div class="col-auto text-end">
        <div class="dropdown">
            <button class="btn btn-secondary " type="button" id="languageDropdown"
                data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 10px; border: 1px solid #E5E7EB; background-color: white; color: #6B7280; font-size: 15px; font-weight: 500; height: 40px;">
                <img src="{{ asset('images/startup-pdf-icon.svg') }}" alt="PDF Icon" style="width: 20px; height: 20px; margin-right: 5px;"> Download PDF Report<img src="{{ asset('images/startup-download-icon.svg') }}" alt="Download Icon" style="width: 15px; height: 15px; margin-left: 5px;">
            </button>
            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                <li>
                    <a class="dropdown-item"
                        href="{{ route('investors.pdf.ai_response.ar', ['investor' => $investor->id]) }}">
                        <img src="{{ asset('images/startup-download-icon.svg') }}" alt="Download Icon" style="width: 15px; height: 15px; margin-right: 5px;"> Arabic PDF
                    </a>
                </li>
                <li>
                    <a class="dropdown-item"
                        href="{{ route('investors.pdf.ai_response.en', ['investor' => $investor->id]) }}">
                        <img src="{{ asset('images/startup-download-icon.svg') }}" alt="Download Icon" style="width: 15px; height: 15px; margin-right: 5px;"> English PDF
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

        <div class="row">
            <!-- Investor Profile Card -->
            <div class="col-lg-4 mb-4">
                <div class="profile-card animate-slide-up" style="background-color: white;">
                    <div class="profile-header" style="background-color: white;">
                        <div class="profile-avatar">
                            <img src="{{ asset('images/startup-avatar-icon.svg') }}" alt="User Icon">
                        </div>
                        <h3 style="color: #374151; font-weight: 600; font-size: 21px;">{{ $investor->name }}</h3>
                        <p style="color: #9CA3AF; font-weight: 400; font-size: 15px;">{{ $investor->company }}</p>
                    </div>

                    <hr style="border-top: 1px solid #E5E7EB; width: 300px; height: 1px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); justify-self: center;">

                    <div class="profile-stats d-flex justify-content-between">
                        <div class="stat-item text-center">
                            <div class="stat-value" style="color: #1E3A8A; font-weight: 400; font-size: 20px;">{{ $investor->favouriteSectors->count() }}</div>
                            <div class="stat-label" style="color: #9CA3AF;">Preferred Sectors</div>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-value" style="color: #1E3A8A; font-weight: 400; font-size: 20px;">{{ optional($investor->budgetRange)->name }}
                            </div>
                            <div class="stat-label" style="color: #9CA3AF;">Investment Range</div>
                        </div>
                        <div class="stat-item text-center">
                            <div class="stat-value" style="color: #1E3A8A; font-weight: 400; font-size: 20px;">
                                {{ optional($investor->geographicalScope)->name }}</div>
                            <div class="stat-label" style="color: #9CA3AF;">Geographic Focus</div>
                        </div>
                    </div>

                    <hr style="border-top: 1px solid #E5E7EB; width: 300px; height: 1px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); justify-self: center;">

                    <div class="profile-body">
                        <div class="profile-section">
                            <h4 style="color: #374151; font-weight: 500; font-size: 18px;">Investment Preferences</h4>
                            <div class="preference-grid">
                                <div class="preference-item">
                                    <div class="icon-wrapper me-3">
                                        <img src="{{ asset('images/startup-stats-icon.svg') }}" alt="Investment Type"
                                            class="preference-icon">
                                    </div>
                                    <div>
                                        <label style="color: #9CA3AF; font-weight: 400; font-size: 15px;">Stage</label>
                                        <div style="color: #374151; font-weight: 400; font-size: 20px;">
                                            {{ optional($investor->favouriteInvestmentStage)->name }}</div>
                                    </div>
                                </div>
                                <div class="preference-item">
                                    <div class="icon-wrapper me-3">
                                        <img src="{{ asset('images/startup-coinvest-icon.svg') }}" alt="Co-Investment"
                                            class="preference-icon">
                                    </div>
                                    <div>
                                        <label style="color: #9CA3AF; font-weight: 400; font-size: 15px;">Co-Investment</label>
                                        <div style="color: #374151; font-weight: 400; font-size: 20px;">{{ optional($investor->coInvest)->name }}</div>
                                    </div>
                                </div>
                                <div class="preference-item">
                                    <div class="icon-wrapper me-3">
                                        <img src="{{ asset('images/startup-privacy-icon.svg') }}" alt="Privacy"
                                            class="preference-icon">
                                    </div>
                                    <div>
                                        <label style="color: #9CA3AF; font-weight: 400; font-size: 15px;">Privacy</label>
                                        <div style="color: #374151; font-weight: 400; font-size: 20px;">
                                            {{ optional($investor->investmentPrivacyOption)->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr style="border-top: 1px solid #E5E7EB; width: 300px; height: 1px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); justify-self: center;">

                        <div class="profile-section">
                            <h4 style="color: #374151; font-weight: 500; font-size: 18px;">Focus Sectors</h4>
                            <div class="sectors-grid" >
                                @foreach($investor->favouriteSectors as $sector)
                                    <span class="sector-badge" style="border-radius: 30px; font-size: 15px; font-weight: 400; color: #4B5563;">
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
                                    <img src="{{ asset('images/startup-search-icon.svg') }}" alt="User Icon">
                                </div>
                                <div class="empty-state-icon">
                                    <img src="{{ asset('images/startup-search2-icon.svg') }}" alt="User Icon">
                                </div>
                                <h4 style="color: #374151; font-weight: 600; font-size: 19px;">Vision & Mission</h4>
                                <p style="color: #9CA3AF; font-weight: 400; font-size: 12px;">Start the AI matching process to find compatible startups</p>
                                <form action="{{ route('investor.api.test.send', $investor->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="action-button">
                                        <img src="{{ asset('images/startup-star-icon.svg') }}" alt="User Icon">
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
                                    <a href="{{ route('investor.response.view', $investor->id) }}"
                                        class="action-button primary">
                                        <i class="fas fa-list"></i>
                                        View Detailed Results
                                    </a>
                                    <form action="{{ route('investor.api.test.send', $investor->id) }}" method="POST"
                                        class="d-inline">
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
            margin-bottom: 15px;
        }

        .preference-item .icon-wrapper {
            margin-right: 10px;
        }

        .preference-item .preference-icon {
            width: 24px;
            height: 24px;
        }

        .preference-item label {
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin: 0;
        }

        .preference-item div {
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
            color: #374151;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
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

        /* Dropdown styles */
        .dropdown-menu {
            min-width: 150px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item i {
            color: var(--primary-color);
        }
    </style>

    <!-- Update Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Ensure dropdown functionality is initialized correctly
                var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl);
                });
            });
        </script>
    @endpush
@endsection

@push('head')
    <style>
        /* Existing styles remain the same */
        .dropdown-menu {
            min-width: 150px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item i {
            color: var(--primary-color);
        }
    </style>
@endpush