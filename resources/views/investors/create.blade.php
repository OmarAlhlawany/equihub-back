@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4" style="color: #2B37A0; font-weight: bold; font-size: 30px;">Create Investor</h2>

    <form action="{{ route('investors.store') }}" method="POST">
        @csrf

        <div class="card" style="background-color: #fff; padding: 20px; border-radius: 8px;">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="phone_number">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                    @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="company">Company <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('company') is-invalid @enderror" id="company" name="company" value="{{ old('company') }}" required>
                    @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="investment_type_id">Investment Type <span class="text-danger">*</span></label>
                    <select class="form-control @error('investment_type_id') is-invalid @enderror" id="investment_type_id" name="investment_type_id" required>
                        <option value="">Select Investment Type</option>
                        @foreach($investmentTypes as $type)
                            <option value="{{ $type->id }}" {{ old('investment_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('investment_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="favourite_investment_stage_id">Favourite Investment Stage <span class="text-danger">*</span></label>
                    <select class="form-control @error('favourite_investment_stage_id') is-invalid @enderror" id="favourite_investment_stage_id" name="favourite_investment_stage_id" required>
                        <option value="">Select Investment Stage</option>
                        @foreach($investmentStages as $stage)
                            <option value="{{ $stage->id }}" {{ old('favourite_investment_stage_id') == $stage->id ? 'selected' : '' }}>{{ $stage->name }}</option>
                        @endforeach
                    </select>
                    @error('favourite_investment_stage_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="budget_range_id">Budget Range <span class="text-danger">*</span></label>
                    <select class="form-control @error('budget_range_id') is-invalid @enderror" id="budget_range_id" name="budget_range_id" required>
                        <option value="">Select Budget Range</option>
                        @foreach($budgetRanges as $range)
                            <option value="{{ $range->id }}" {{ old('budget_range_id') == $range->id ? 'selected' : '' }}>{{ $range->name }}</option>
                        @endforeach
                    </select>
                    @error('budget_range_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="geographical_scope_id">Geographical Scope <span class="text-danger">*</span></label>
                    <select class="form-control @error('geographical_scope_id') is-invalid @enderror" id="geographical_scope_id" name="geographical_scope_id" required>
                        <option value="">Select Geographical Scope</option>
                        @foreach($geographicalScopes as $scope)
                            <option value="{{ $scope->id }}" {{ old('geographical_scope_id') == $scope->id ? 'selected' : '' }}>{{ $scope->name }}</option>
                        @endforeach
                    </select>
                    @error('geographical_scope_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="favourite_sectors">Favourite Sectors <span class="text-danger">*</span></label>
                    <select class="form-control @error('favourite_sectors') is-invalid @enderror" id="favourite_sectors" name="favourite_sectors[]" multiple required>
                        @foreach($favouriteSectors as $sector)
                            <option value="{{ $sector->id }}" {{ (collect(old('favourite_sectors'))->contains($sector->id)) ? 'selected' : '' }}>{{ $sector->name }}</option>
                        @endforeach
                    </select>
                    @error('favourite_sectors') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="co_invest_id">Co-Invest? <span class="text-danger">*</span></label>
                    <select class="form-control @error('co_invest_id') is-invalid @enderror" id="co_invest_id" name="co_invest_id" required>
                        @foreach($yesNoOptions as $option)
                            <option value="{{ $option->id }}" {{ old('co_invest_id') == $option->id ? 'selected' : '' }}>{{ $option->name }}</option>
                        @endforeach
                    </select>
                    @error('co_invest_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="investment_privacy_option_id">Investment Privacy <span class="text-danger">*</span></label>
                    <select class="form-control @error('investment_privacy_option_id') is-invalid @enderror" id="investment_privacy_option_id" name="investment_privacy_option_id" required>
                        @foreach($investmentPrivacyOptions as $privacyOption)
                            <option value="{{ $privacyOption->id }}" {{ old('investment_privacy_option_id') == $privacyOption->id ? 'selected' : '' }}>{{ $privacyOption->name }}</option>
                        @endforeach
                    </select>
                    @error('investment_privacy_option_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="additional_notes">Additional Notes</label>
                <textarea class="form-control @error('additional_notes') is-invalid @enderror" id="additional_notes" name="additional_notes">{{ old('additional_notes') }}</textarea>
                @error('additional_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Create Investor</button>
        </div>
    </form>

    <a href="{{ route('investors') }}" class="btn btn-secondary mt-3">Back to Investors</a>
</div>
@endsection
