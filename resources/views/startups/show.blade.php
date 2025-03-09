@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="text-center mb-4">
            <h2 style="color: #2B37A0; font-weight: bold; font-size: 30px;">Startup Details</h2>
        </div>

        <div class="card shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <!-- Header Section -->
            <div class="card-header bg-white border-bottom" style="padding: 20px;">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0" style="color: #2B37A0; font-weight: bold;">{{ $startup->name }}</h3>
                    <div>
                        <a href="{{ route('startups.edit', $startup->id) }}" class="btn btn-outline-primary me-2"
                            style="border-radius: 20px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('startups') }}" class="btn btn-outline-secondary" style="border-radius: 20px;">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Basic Information -->
                <div class="section mb-4">
                    <h5 class="section-title"
                        style="color: #2B37A0; border-bottom: 2px solid #2B37A0; padding-bottom: 10px;">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Email</label>
                                <p class="mb-0">{{ $startup->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Phone</label>
                                <p class="mb-0">{{ $startup->phone_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Company</label>
                                <p class="mb-0">{{ $startup->company }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Website</label>
                                <p class="mb-0">
                                    <a href="{{ $startup->website }}" target="_blank"
                                        class="text-primary">{{ $startup->website }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Details -->
                <div class="section mb-4">
                    <h5 class="section-title"
                        style="color: #2B37A0; border-bottom: 2px solid #2B37A0; padding-bottom: 10px;">
                        <i class="fas fa-briefcase"></i> Business Details
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted">Product/Service Description</label>
                                <p class="mb-0">{{ $startup->product_service_description }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted">Problem Solved</label>
                                <p class="mb-0">{{ $startup->problem_solved }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Company Sector</label>
                                <p class="mb-0">{{ $startup->companySector->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Operational Phase</label>
                                <p class="mb-0">{{ $startup->operationalPhase->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="text-muted">Target Market</label>
                                <p class="mb-0">{{ $startup->targetMarket->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="section mb-4">
                    <h5 class="section-title"
                        style="color: #2B37A0; border-bottom: 2px solid #2B37A0; padding-bottom: 10px;">
                        <i class="fas fa-chart-line"></i> Financial Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="info-card bg-light p-3 rounded">
                                <label class="text-muted">Monthly Revenue</label>
                                <h5 class="mb-0">{{ number_format($startup->monthly_revenue, 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card bg-light p-3 rounded">
                                <label class="text-muted">Revenue Growth</label>
                                <h5 class="mb-0">{{ $startup->revenue_growth }}%</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card bg-light p-3 rounded">
                                <label class="text-muted">Revenue Goal</label>
                                <h5 class="mb-0">{{ number_format($startup->revenue_goal, 2) }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card bg-light p-3 rounded">
                                <label class="text-muted">Break-even Point</label>
                                <h5 class="mb-0">{{ $startup->break_even_point }}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted">Financial Goal</label>
                                <p class="mb-0">{{ $startup->financial_goal }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="text-muted">Funding Used</label>
                                <p class="mb-0">{{ $startup->funding_used }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Information -->
                <div class="section mb-4">
                    <h5 class="section-title"
                        style="color: #2B37A0; border-bottom: 2px solid #2B37A0; padding-bottom: 10px;">
                        <i class="fas fa-info-circle"></i> Status Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div
                                class="status-badge {{ $startup->isProfitable->name == 'yes' ? 'bg-success' : 'bg-warning' }} text-white p-2 rounded text-center">
                                <i
                                    class="fas {{ $startup->isProfitable->name == 'yes' ? 'fa-check' : 'fa-times' }} me-2"></i>
                                Is Profitable: {{ $startup->isProfitable->name ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div
                                class="status-badge {{ $startup->haveDebts->name == 'no' ? 'bg-success' : 'bg-warning' }} text-white p-2 rounded text-center">
                                <i
                                    class="fas {{ $startup->haveDebts->name == 'no' ? 'fa-check' : 'fa-exclamation' }} me-2"></i>
                                Have Debts: {{ $startup->haveDebts->name ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div
                                class="status-badge {{ $startup->hasExitStrategy->name == 'yes' ? 'bg-success' : 'bg-warning' }} text-white p-2 rounded text-center">
                                <i
                                    class="fas {{ $startup->hasExitStrategy->name == 'yes' ? 'fa-check' : 'fa-times' }} me-2"></i>
                                Has Exit Strategy: {{ $startup->hasExitStrategy->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>

                    @if($startup->haveDebts->name == 'yes')
                        <div class="mt-3">
                            <div class="info-item">
                                <label class="text-muted">Debt Amount</label>
                                <p class="mb-0">{{ number_format($startup->debt_amount, 2) }}</p>
                            </div>
                        </div>
                    @endif

                    @if($startup->hasExitStrategy->name == 'yes')
                        <div class="mt-3">
                            <div class="info-item">
                                <label class="text-muted">Exit Strategy Details</label>
                                <p class="mb-0">{{ $startup->exit_strategy_details }}</p>
                            </div>
                        </div>
                    @endif
                </div>
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
    </style>
@endsection