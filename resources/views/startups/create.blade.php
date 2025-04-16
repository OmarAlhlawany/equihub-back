@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4"
        style="color: #374151; font-weight: bold; font-size: 30px; text-align: left !important;">Create Startup</h2>

    <form action="{{ route('startups.store') }}" method="POST">
        @csrf

        <div class="card"
            style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <!-- Startup Information Section -->
            <div class="section-title mb-3">
                <h4 style="color: #134DF4;">Startup Information</h4>
                <hr>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="name">Startup Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control input-focus @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control input-focus @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="phone_number">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control input-focus @error('phone_number') is-invalid @enderror"
                        id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Company Details Section -->
            <div class="section-title mb-3 mt-4">
                <h4 style="color: #134DF4;">Company Details</h4>
                <hr>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="company">Company <span class="text-danger">*</span></label>
                    <input type="text" class="form-control input-focus @error('company') is-invalid @enderror"
                        id="company" name="company" value="{{ old('company') }}" required>
                    @error('company')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="website">Website <span class="text-danger">*</span></label>
                    <input type="url" class="form-control input-focus @error('website') is-invalid @enderror"
                        id="website" name="website" value="{{ old('website') }}" required>
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Startup Characteristics Section -->
            <div class="section-title mb-3 mt-4">
                <h4 style="color: #134DF4;">Startup Characteristics</h4>
                <hr>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="company_sector_id">Company Sector <span class="text-danger">*</span></label>
                    <div class="custom-select-wrapper">
                        <select class="form-control input-focus @error('company_sector_id') is-invalid @enderror"
                            id="company_sector_id" name="company_sector_id" required>
                            <option value="" style="color: #4B5563 !important;">Select Sector</option>
                            @foreach($companySectors as $sector)
                                <option value="{{ $sector->id }}" {{ old('company_sector_id') == $sector->id ? 'selected' : '' }}>
                                    {{ $sector->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down icon-toggle"></i>
                    </div>
                    @error('company_sector_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="operational_phase_id">Operational Phase <span class="text-danger">*</span></label>
                    <div class="custom-select-wrapper">
                        <select class="form-control input-focus @error('operational_phase_id') is-invalid @enderror"
                            id="operational_phase_id" name="operational_phase_id" required>
                            <option value="" style="color: #4B5563 !important;">Select Phase</option>
                            @foreach($operationalPhases as $phase)
                                <option value="{{ $phase->id }}" {{ old('operational_phase_id') == $phase->id ? 'selected' : '' }}>
                                    {{ $phase->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down icon-toggle"></i>
                    </div>
                    @error('operational_phase_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="funding_amount_id">Funding Amount <span class="text-danger">*</span></label>
                    <div class="custom-select-wrapper">
                        <select class="form-control input-focus @error('funding_amount_id') is-invalid @enderror"
                            id="funding_amount_id" name="funding_amount_id" required>
                            <option value="" style="color: #4B5563 !important;">Select Amount</option>
                            @foreach($fundingAmounts as $amount)
                                <option value="{{ $amount->id }}" {{ old('funding_amount_id') == $amount->id ? 'selected' : '' }}>
                                    {{ $amount->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down icon-toggle"></i>
                    </div>
                    @error('funding_amount_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="section-title mb-3 mt-4">
                <h4 style="color: #134DF4;">Additional Information</h4>
                <hr>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="problem_solved">Problem Solved <span class="text-danger">*</span></label>
                    <textarea
                        class="form-control input-focus @error('problem_solved') is-invalid @enderror custom-textarea-corner"
                        id="problem_solved" name="problem_solved" rows="3"
                        required>{{ old('problem_solved') }}</textarea>
                    @error('problem_solved')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="product_service_description">Product/Service Description <span
                            class="text-danger">*</span></label>
                    <textarea
                        class="form-control input-focus @error('product_service_description') is-invalid @enderror custom-textarea-corner"
                        id="product_service_description" name="product_service_description" rows="3"
                        required>{{ old('product_service_description') }}</textarea>
                    @error('product_service_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="funding_used">Funding Used <span class="text-danger">*</span></label>
                    <textarea
                        class="form-control input-focus @error('funding_used') is-invalid @enderror custom-textarea-corner"
                        id="funding_used" name="funding_used" rows="3" required>{{ old('funding_used') }}</textarea>
                    @error('funding_used')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-12" style="display: flex; justify-content: flex-end !important;">
                    <a href="{{ route('startups') }}" class="btn btn-secondary"
                        style="width: 200px; height: 40.68px; border-radius: 9.63px; border: 0.96px solid #D1D5DB; padding: 13.31px 26.62px 13.98px 26.62px; background-color: #FBFDFF; color: #9CA3AF; font-weight: 600; font-size: 11.98px; line-height: 13.31px; text-align: center; margin-right: 10px;">Back
                        to Startups</a>
                    <button type="submit" class="btn btn-primary"
                        style="width: 200px; height: 40.68px; border-radius: 9.63px; background-color: #134DF4; color: white; font-weight: 600; font-size: 11.98px; line-height: 13.31px; text-align: center; border: none;">Create
                        Startup</button>
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

    document.addEventListener('DOMContentLoaded', function () {
        // Multi-select for favourite sectors (if needed)
        const favouriteSectorsSelect = document.getElementById('company_sector_id');
        const selectedSectorsContainer = document.getElementById('selected-sectors');

        if (favouriteSectorsSelect && selectedSectorsContainer) {
            favouriteSectorsSelect.addEventListener('change', function () {
                const selectedOptions = Array.from(this.selectedOptions).map(option => option.text);
                selectedSectorsContainer.innerHTML = selectedOptions.map(sector =>
                    `<span class="badge bg-secondary me-1">${sector}</span>`
                ).join('');
            });
        }
    });
</script>
<style>
    .input-focus {
        border: 1px solid #E5E7EB !important;
    }
    .input-focus:focus {
        border: 1px solid #134DF4 !important;
        outline: none !important;
        box-shadow: none !important;
    }   

    .custom-select-wrapper {
        position: relative;
    }

    .custom-select-wrapper .icon-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #6B7280;
    }

    .custom-textarea-corner {
        border-radius: 8px;
    }

    .textarea-wrapper {
        position: relative;
    }
</style>
@endsection