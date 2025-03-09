@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4" style="color: #2B37A0; font-weight: bold; font-size: 30px;">Edit Startup</h2>

        <form action="{{ route('startups.update', $startup->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card"
                style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-4 mb-3">
                        <label for="name">Startup Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $startup->name) }}" required>
                        @error('name')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-4 mb-3">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $startup->email) }}" required>
                        @error('email')                 <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-4 mb-3">
                        <label for="phone_number">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" value="{{ old('phone_number', $startup->phone_number) }}"
                            required>
                        @error('phone_number')            <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Company -->
                    <div class="col-md-4 mb-3">
                        <label for="company">Company <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" id="company"
                            name="company" value="{{ old('company', $startup->company) }}" required>
                        @error('company')       <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Website -->
                    <div class="col-md-4 mb-3">
                        <label for="website">Website <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website"
                            name="website" value="{{ old('website', $startup->website) }}" required>
                        @error('website')  <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Product/Service Description -->
                    <div class="col-md-4 mb-3">
                        <label for="product_service_description">Product/Service Description <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('product_service_description') is-invalid @enderror"
                            id="product_service_description" name="product_service_description"
                            required>{{ old('product_service_description', $startup->product_service_description) }}</textarea>
                        @error('product_service_description')           <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Company Sector -->
                    <div class="col-md-4 mb-3">
                        <label for="company_sector_id">Company Sector <span class="text-danger">*</span></label>
                        <select class="form-control @error('company_sector_id') is-invalid @enderror" id="company_sector_id"
                            name="company_sector_id" required>
                            <option value="">Select Sector</option>
                            @foreach($companySectors as $sector)
                                <option value="{{ $sector->id }}" {{ old('company_sector_id', $startup->company_sector_id) == $sector->id ? 'selected' : '' }}>
                                    {{ $sector->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_sector_id')          <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Operational Phase -->
                    <div class="col-md-4 mb-3">
                        <label for="operational_phase_id">Operational Phase <span class="text-danger">*</span></label>
                        <select class="form-control @error('operational_phase_id') is-invalid @enderror"
                            id="operational_phase_id" name="operational_phase_id" required>
                            <option value="">Select Phase</option>
                            @foreach($operationalPhases as $phase)
                                <option value="{{ $phase->id }}" {{ old('operational_phase_id', $startup->operational_phase_id) == $phase->id ? 'selected' : '' }}>
                                    {{ $phase->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('operational_phase_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Problem Solved -->
                    <div class="col-md-4 mb-3">
                        <label for="problem_solved">Problem Solved <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('problem_solved') is-invalid @enderror" id="problem_solved"
                            name="problem_solved" required>{{ old('problem_solved', $startup->problem_solved) }}</textarea>
                        @error('problem_solved')                 <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Funding Amount -->
                    <div class="col-md-4 mb-3">
                        <label for="funding_amount_id">Funding Amount <span class="text-danger">*</span></label>
                        <select class="form-control @error('funding_amount_id') is-invalid @enderror" id="funding_amount_id"
                            name="funding_amount_id" required>
                            <option value="">Select Amount</option>
                            @foreach($fundingAmounts as $amount)
                                <option value="{{ $amount->id }}" {{ old('funding_amount_id', $startup->funding_amount_id) == $amount->id ? 'selected' : '' }}>
                                    {{ $amount->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('funding_amount_id')   <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Funding Used -->
                    <div class="col-md-4 mb-3">
                        <label for="funding_used">Funding Used <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('funding_used') is-invalid @enderror" id="funding_used"
                            name="funding_used" required>{{ old('funding_used', $startup->funding_used) }}</textarea>
                        @error('funding_used')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Previous Funding Source -->
                    <div class="col-md-4 mb-3">
                        <label for="previous_funding_source_id">Previous Funding Source <span
                                class="text-danger">*</span></label>
                        <select class="form-control @error('previous_funding_source_id') is-invalid @enderror"
                            id="previous_funding_source_id" name="previous_funding_source_id" required>
                            <option value="">Select Source</option>
                            @foreach($fundingSources as $source)
                                <option value="{{ $source->id }}" {{ old('previous_funding_source_id', $startup->previous_funding_source_id) == $source->id ? 'selected' : '' }}>
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('previous_funding_source_id')             <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Target Market -->
                    <div class="col-md-4 mb-3">
                        <label for="target_market_id">Target Market <span class="text-danger">*</span></label>
                        <select class="form-control @error('target_market_id') is-invalid @enderror" id="target_market_id"
                            name="target_market_id" required>
                            <option value="">Select Market</option>
                            @foreach($targetMarkets as $market)
                                <option value="{{ $market->id }}" {{ old('target_market_id', $startup->target_market_id) == $market->id ? 'selected' : '' }}>
                                    {{ $market->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('target_market_id')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Joint Investment -->
                    <div class="col-md-4 mb-3">
                        <label for="joint_investment">Joint Investment <span class="text-danger">*</span></label>
                        <select class="form-control @error('joint_investment') is-invalid @enderror" id="joint_investment"
                            name="joint_investment" required>
                            <option value="">Select Option</option>
                            @foreach($yesNoOptions as $option)
                                <option value="{{ $option->id }}" {{ old('joint_investment', $startup->joint_investment) == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('joint_investment')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Existing Partners -->
                    <div class="col-md-4 mb-3">
                        <label for="existing_partners">Existing Partners <span class="text-danger">*</span></label>
                        <select class="form-control @error('existing_partners') is-invalid @enderror" id="existing_partners"
                            name="existing_partners" required>
                            <option value="">Select Option</option>
                            @foreach($yesNoOptions as $option)
                                <option value="{{ $option->id }}" {{ old('existing_partners', $startup->existing_partners) == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('existing_partners') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Monthly Revenue -->
                    <div class="col-md-4 mb-3">
                        <label for="monthly_revenue">Monthly Revenue</label>
                        <input type="number" step="0.01" class="form-control @error('monthly_revenue') is-invalid @enderror"
                            id="monthly_revenue" name="monthly_revenue"
                            value="{{ old('monthly_revenue', $startup->monthly_revenue) }}">
                        @error('monthly_revenue') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Is Profitable -->
                    <div class="col-md-4 mb-3">
                        <label for="is_profitable">Is Profitable <span class="text-danger">*</span></label>
                        <select class="form-control @error('is_profitable') is-invalid @enderror" id="is_profitable"
                            name="is_profitable" required>
                            <option value="">Select Option</option>
                            @foreach($yesNoOptions as $option)
                                <option value="{{ $option->id }}" {{ old('is_profitable', $startup->is_profitable) == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('is_profitable') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Revenue Growth -->
                    <div class="col-md-4 mb-3">
                        <label for="revenue_growth">Revenue Growth (%)</label>
                        <input type="number" step="0.01" min="0" max="100"
                            class="form-control @error('revenue_growth') is-invalid @enderror" id="revenue_growth"
                            name="revenue_growth" value="{{ old('revenue_growth', $startup->revenue_growth) }}">
                        @error('revenue_growth')          <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Revenue Goal -->
                    <div class="col-md-4 mb-3">
                        <label for="revenue_goal">Revenue Goal <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('revenue_goal') is-invalid @enderror"
                            id="revenue_goal" name="revenue_goal" value="{{ old('revenue_goal', $startup->revenue_goal) }}"
                            required>
                        @error('revenue_goal')     <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Have Debts -->
                    <div class="col-md-4 mb-3">
                        <label for="have_debts">Have Debts <span class="text-danger">*</span></label>
                        <select class="form-control @error('have_debts') is-invalid @enderror" id="have_debts"
                            name="have_debts" required onchange="toggleDebtAmount()">
                            <option value="">Select Option</option>
                            @foreach($yesNoOptions as $option)
                                <option value="{{ $option->id }}" {{ old('have_debts', $startup->have_debts) == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('have_debts')                <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Debt Amount -->
                    <div class="col-md-4 mb-3">
                        <label for="debt_amount">Debt Amount</label>
                        <input type="number" step="0.01" class="form-control @error('debt_amount') is-invalid @enderror"
                            id="debt_amount" name="debt_amount" value="{{ old('debt_amount', $startup->debt_amount) }}">
                        @error('debt_amount')            <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Break Even Point -->
                    <div class="col-md-4 mb-3">
                        <label for="break_even_point">Break Even Point <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('break_even_point') is-invalid @enderror"
                            id="break_even_point" name="break_even_point"
                            value="{{ old('break_even_point', $startup->break_even_point) }}" required>
                        @error('break_even_point')       <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Financial Goal -->
                    <div class="col-md-4 mb-3">
                        <label for="financial_goal">Financial Goal <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('financial_goal') is-invalid @enderror" id="financial_goal"
                            name="financial_goal" required>{{ old('financial_goal', $startup->financial_goal) }}</textarea>
                        @error('financial_goal')                <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Has Exit Strategy -->
                    <div class="col-md-4 mb-3">
                        <label for="has_exit_strategy">Has Exit Strategy <span class="text-danger">*</span></label>
                        <select class="form-control @error('has_exit_strategy') is-invalid @enderror" id="has_exit_strategy"
                            name="has_exit_strategy" required onchange="toggleExitStrategy()">
                            <option value="">Select Option</option>
                            @foreach($yesNoOptions as $option)
                                <option value="{{ $option->id }}" {{ old('has_exit_strategy', $startup->has_exit_strategy) == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('has_exit_strategy')    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Exit Strategy Details -->
                    <div class="col-md-12 mb-3">
                        <label for="exit_strategy_details">Exit Strategy Details</label>
                        <textarea class="form-control @error('exit_strategy_details') is-invalid @enderror"
                            id="exit_strategy_details"
                            name="exit_strategy_details">{{ old('exit_strategy_details', $startup->exit_strategy_details) }}</textarea>
                        @error('exit_strategy_details')           <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update Startup</button>
                        <a href="{{ route('startups') }}" class="btn btn-secondary">Back to Startups</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleDebtAmount() {
            const haveDebts = document.getElementById('have_debts').value;
            const debtAmountField = document.getElementById('debt_amount');
            debtAmountField.disabled = haveDebts !== '1';
            if (debtAmountField.disabled) {
                debtAmountField.value = '';
            }
        }

        function toggleExitStrategy() {
            const hasExitStrategy = document.getElementById('has_exit_strategy').value;
            const exitStrategyDetailsField = document.getElementById('exit_strategy_details');
            exitStrategyDetailsField.disabled = hasExitStrategy !== '1';
            if (exitStrategyDetailsField.disabled) {
                exitStrategyDetailsField.value = '';
            }
        }

        // Initialize the form state
        document.addEventListener('DOMContentLoaded', function () {
            toggleDebtAmount();
            toggleExitStrategy();
        });
    </script>

@endsection