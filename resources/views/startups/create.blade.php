@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4" style="color: #2B37A0; font-weight: bold; font-size: 30px;">Create Startup</h2>

    <form action="{{ route('startups.store') }}" method="POST">
        @csrf

        <div class="card" style="background-color: #fff; padding: 20px; border-radius: 8px;">
            <div class="row">
                <!-- Name -->
                <div class="col-md-4 mb-3">
                    <label for="name">Startup Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <!-- Email -->
                <div class="col-md-4 mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <!-- Phone -->
                <div class="col-md-4 mb-3">
                    <label for="phone_number">Phone</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                </div>
            </div>

            <div class="row">
                <!-- Company -->
                <div class="col-md-4 mb-3">
                    <label for="company">Company</label>
                    <input type="text" class="form-control" id="company" name="company" required>
                </div>

                <!-- Website -->
                <div class="col-md-4 mb-3">
                    <label for="website">Website</label>
                    <input type="url" class="form-control" id="website" name="website">
                </div>

                <!-- Product/Service Description -->
                <div class="col-md-4 mb-3">
                    <label for="product_service_description">Product/Service Description</label>
                    <textarea class="form-control" id="product_service_description" name="product_service_description" required></textarea>
                </div>
            </div>

            <div class="row">
                <!-- Company Sector (Dynamic) -->
                <div class="col-md-4 mb-3">
                    <label for="company_sector_id">Company Sector</label>
                    <select class="form-control" id="company_sector_id" name="company_sector_id" required>
                        @foreach($companySectors as $sector)
                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Operational Phase (Dynamic) -->
                <div class="col-md-4 mb-3">
                    <label for="operational_phase_id">Operational Phase</label>
                    <select class="form-control" id="operational_phase_id" name="operational_phase_id" required>
                        @foreach($operationalPhases as $phase)
                            <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Problem Solved -->
                <div class="col-md-4 mb-3">
                    <label for="problem_solved">Problem Solved</label>
                    <textarea class="form-control" id="problem_solved" name="problem_solved" required></textarea>
                </div>
            </div>

            <div class="row">
                <!-- Funding Amount (Dynamic) -->
                <div class="col-md-4 mb-3">
                    <label for="funding_amount_id">Funding Amount</label>
                    <select class="form-control" id="funding_amount_id" name="funding_amount_id" required>
                        @foreach($fundingAmounts as $amount)
                            <option value="{{ $amount->id }}">{{ $amount->range }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Funding Used -->
                <div class="col-md-4 mb-3">
                    <label for="funding_used">Funding Used</label>
                    <textarea class="form-control" id="funding_used" name="funding_used" required></textarea>
                </div>

                <!-- Previous Funding Source (Dynamic) -->
                <div class="col-md-4 mb-3">
                    <label for="previous_funding_source_id">Previous Funding Source</label>
                    <select class="form-control" id="previous_funding_source_id" name="previous_funding_source_id" required>
                        @foreach($fundingSources as $source)
                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Monthly Revenue -->
                <div class="col-md-4 mb-3">
                    <label for="monthly_revenue">Monthly Revenue</label>
                    <input type="number" class="form-control" id="monthly_revenue" name="monthly_revenue">
                </div>

                <!-- Revenue Growth -->
                <div class="col-md-4 mb-3">
                    <label for="revenue_growth">Revenue Growth (%)</label>
                    <input type="number" class="form-control" id="revenue_growth" name="revenue_growth">
                </div>

                <!-- Revenue Goal -->
                <div class="col-md-4 mb-3">
                    <label for="revenue_goal">Revenue Goal</label>
                    <input type="number" class="form-control" id="revenue_goal" name="revenue_goal">
                </div>
            </div>

            <div class="row">
                <!-- Have Debts -->
                <div class="col-md-4 mb-3">
                    <label for="have_debts">Have Debts?</label>
                    <select class="form-control" id="have_debts" name="have_debts" required>
                        @foreach($yesNoOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Debt Amount -->
                <div class="col-md-4 mb-3">
                    <label for="debt_amount">Debt Amount</label>
                    <input type="number" class="form-control" id="debt_amount" name="debt_amount">
                </div>

                <!-- Break-even Point -->
                <div class="col-md-4 mb-3">
                    <label for="break_even_point">Break-even Point</label>
                    <input type="text" class="form-control" id="break_even_point" name="break_even_point" required>
                </div>
            </div>

            <div class="row">
                <!-- Financial Goal -->
                <div class="col-md-4 mb-3">
                    <label for="financial_goal">Financial Goal</label>
                    <textarea class="form-control" id="financial_goal" name="financial_goal" required></textarea>
                </div>

                <!-- Has Exit Strategy -->
                <div class="col-md-4 mb-3">
                    <label for="has_exit_strategy">Has Exit Strategy?</label>
                    <select class="form-control" id="has_exit_strategy" name="has_exit_strategy" required>
                        @foreach($yesNoOptions as $option)
                            <option value="{{ $option->id }}">{{ $option->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Exit Strategy Details -->
                <div class="col-md-4 mb-3">
                    <label for="exit_strategy_details">Exit Strategy Details</label>
                    <textarea class="form-control" id="exit_strategy_details" name="exit_strategy_details"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Create Startup</button>
        </div>
    </form>

    <a href="{{ route('startups') }}" class="btn btn-secondary mt-3">Back to Startups</a>
</div>
@endsection
