@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="text-center mb-4">
            <h2 style="color: #2B37A0; font-weight: bold; font-size: 30px;">Investor Details</h2>
        </div>

        <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <!-- Header Section -->
            <div class="card-header bg-white border-bottom" style="padding: 20px;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0" style="color: #2B37A0; font-weight: bold;">{{ $investor->name }}</h3>
                    <div>
                        <a href="{{ route('investors.edit', $investor->id) }}" class="btn btn-outline-primary me-2"
                            style="border-radius: 20px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('investors') }}" class="btn btn-outline-secondary" style="border-radius: 20px;">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Personal Information -->
                <div class="section mb-4">
                    <h5 class="section-title"
                        style="color: #2B37A0; border-bottom: 2px solid #2B37A0; padding-bottom: 10px;">
                        <i class="fas fa-user"></i> Personal Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Email</label>
                                <p class="mb-0">{{ $investor->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Phone</label>
                                <p class="mb-0">{{ $investor->phone_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Company</label>
                                <p class="mb-0">{{ $investor->company }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Investment Preferences -->
                <div class="section mb-4">
                    <h5 class="section-title"
                        style="color: #2B37A0; border-bottom: 2px solid #2B37A0; padding-bottom: 10px;">
                        <i class="fas fa-chart-pie"></i> Investment Preferences
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-card bg-light p-3 rounded">
                                <label class="text-muted">Investment Type</label>
                                <h5 class="mb-0">{{ $investor->investmentType->name ?? 'N/A' }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card bg-light p-3 rounded">
                                <label class="text-muted">Favourite Investment Stage</label>
                                <h5 class="mb-0">{{ $investor->favouriteInvestmentStage->name ?? 'N/A' }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card bg-light p-3 rounded">
                                <label class="text-muted">Budget Range</label>
                                <h5 class="mb-0">{{ $investor->budgetRange->name ?? 'N/A' }}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="info-item">
                                <label class="text-muted">Favourite Sectors</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @forelse ($investor->favouriteSectors as $sector)
                                        <span class="badge bg-primary">{{ $sector->name }}</span>
                                    @empty
                                        <span class="text-muted">No sectors specified</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Investment Settings -->
                <div class="section mb-4">
                    <h5 class="section-title"
                        style="color: #2B37A0; border-bottom: 2px solid #2B37A0; padding-bottom: 10px;">
                        <i class="fas fa-cog"></i> Investment Settings
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div
                                class="status-badge {{ $investor->coInvest->name == 'yes' ? 'bg-success' : 'bg-warning' }} text-white p-2 rounded text-center">
                                <i class="fas {{ $investor->coInvest->name == 'yes' ? 'fa-check' : 'fa-times' }} me-2"></i>
                                Co-Investment: {{ $investor->coInvest->name ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Geographical Scope</label>
                                <p class="mb-0">{{ $investor->geographicalScope->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Investment Privacy</label>
                                <p class="mb-0">{{ $investor->investmentPrivacyOption->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                @if($investor->additional_notes)
                    <div class="section">
                        <h5 class="section-title"
                            style="color: #2B37A0; border-bottom: 2px solid #2B37A0; padding-bottom: 10px;">
                            <i class="fas fa-sticky-note"></i> Additional Notes
                        </h5>
                        <div class="info-item">
                            <p class="mb-0">{{ $investor->additional_notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .section {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
        }

        .info-item {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            height: 100%;
        }

        .info-item label {
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: block;
        }

        .info-card {
            transition: transform 0.2s;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        .status-badge {
            transition: transform 0.2s;
        }

        .status-badge:hover {
            transform: translateY(-3px);
        }

        .section-title {
            margin-bottom: 20px;
        }

        .section-title i {
            margin-right: 10px;
        }

        .badge {
            font-size: 0.9rem;
            padding: 8px 12px;
            border-radius: 20px;
        }
    </style>
@endsection