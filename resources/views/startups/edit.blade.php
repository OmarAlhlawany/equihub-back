@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4" style="color: #2B37A0; font-weight: bold; font-size: 30px;">Edit Startup</h2>

    <form action="{{ route('startups.update', $startup->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card" style="background-color: #fff; padding: 20px; border-radius: 8px;">
            <div class="row">
                <!-- Name -->
                <div class="col-md-4 mb-3">
                    <label for="name">Startup Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $startup->name) }}" required>
                </div>

                <!-- Email -->
                <div class="col-md-4 mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $startup->email) }}" required>
                </div>

                <!-- Phone -->
                <div class="col-md-4 mb-3">
                    <label for="phone_number">Phone</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $startup->phone_number) }}" required>
                </div>
            </div>

            <div class="row">
                <!-- Company -->
                <div class="col-md-4 mb-3">
                    <label for="company">Company</label>
                    <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $startup->company) }}" required>
                </div>

                <!-- Website -->
                <div class="col-md-4 mb-3">
                    <label for="website">Website</label>
                    <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $startup->website) }}" required>
                </div>

                <!-- Company Sector -->
                <div class="col-md-4 mb-3">
                    <label for="company_sector_id">Company Sector</label>
                    <select class="form-control" id="company_sector_id" name="company_sector_id" required>
                        @foreach($companySectors as $sector)
                            <option value="{{ $sector->id }}" {{ old('company_sector_id', $startup->company_sector_id) == $sector->id ? 'selected' : '' }}>
                                {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <!-- Operational Phase -->
                <div class="col-md-4 mb-3">
                    <label for="operational_phase_id">Operational Phase</label>
                    <select class="form-control" id="operational_phase_id" name="operational_phase_id" required>
                        @foreach($operationalPhases as $phase)
                            <option value="{{ $phase->id }}" {{ old('operational_phase_id', $startup->operational_phase_id) == $phase->id ? 'selected' : '' }}>
                                {{ $phase->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Funding Amount -->
                <div class="col-md-4 mb-3">
                    <label for="funding_amount_id">Funding Amount</label>
                    <select class="form-control" id="funding_amount_id" name="funding_amount_id" required>
                        @foreach($fundingAmounts as $funding)
                            <option value="{{ $funding->id }}" {{ old('funding_amount_id', $startup->funding_amount_id) == $funding->id ? 'selected' : '' }}>
                                {{ $funding->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Monthly Revenue -->
                <div class="col-md-4 mb-3">
                    <label for="monthly_revenue">Monthly Revenue</label>
                    <input type="number" class="form-control" id="monthly_revenue" name="monthly_revenue" value="{{ old('monthly_revenue', $startup->monthly_revenue) }}">
                </div>
            </div>

            <div class="row">
                <!-- Is Profitable -->
                <div class="col-md-4 mb-3">
                    <label for="is_profitable">Is Profitable?</label>
                    <select class="form-control" id="is_profitable" name="is_profitable" required>
                        @foreach($yesNoOptions as $option)
                            <option value="{{ $option->id }}" {{ old('is_profitable', $startup->is_profitable) == $option->id ? 'selected' : '' }}>
                                {{ $option->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Has Exit Strategy -->
                <div class="col-md-4 mb-3">
                    <label for="has_exit_strategy">Has Exit Strategy?</label>
                    <select class="form-control" id="has_exit_strategy" name="has_exit_strategy" required>
                        @foreach($yesNoOptions as $option)
                            <option value="{{ $option->id }}" {{ old('has_exit_strategy', $startup->has_exit_strategy) == $option->id ? 'selected' : '' }}>
                                {{ $option->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Exit Strategy Details -->
                <div class="col-md-4 mb-3">
                    <label for="exit_strategy_details">Exit Strategy Details</label>
                    <textarea class="form-control" id="exit_strategy_details" name="exit_strategy_details">{{ old('exit_strategy_details', $startup->exit_strategy_details) }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Startup</button>
        </div>
    </form>

    <a href="{{ route('startups') }}" class="btn btn-secondary mt-3">Back to Startups</a>
</div>
@endsection
