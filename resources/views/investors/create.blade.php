@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4" style="color: #374151; font-weight: bold; font-size: 30px; text-align: left !important;">Create Investor</h2>

        <form action="{{ route('investors.store') }}" method="POST">
            @csrf

            <div class="card"
                style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <!-- Personal Information Section -->
                <div class="section-title mb-3">
                    <h4 style="color: #134DF4;">Personal Information</h4>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control input-focus @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name') }}" required>
                        @error('name')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control input-focus @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="phone_number">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control input-focus  @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                        @error('phone_number')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Company Information Section -->
                <div class="section-title mb-3 mt-4">
                    <h4 style="color: #134DF4;">Company Information</h4>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="company">Company <span class="text-danger">*</span></label>
                        <input type="text" class="form-control input-focus @error('company') is-invalid @enderror" id="company"
                            name="company" value="{{ old('company') }}" required>
                        @error('company')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
        <label for="investment_type_id">Investment Type <span class="text-danger">*</span></label>
        <div class="custom-select-wrapper">
            <select class="form-control input-focus @error('investment_type_id') is-invalid @enderror"
                id="investment_type_id" name="investment_type_id" required>
                <option value="" style="color: #4B5563 !important;">Select Investment Type</option>
                @foreach($investmentTypes as $type)
                    <option value="{{ $type->id }}" {{ old('investment_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down icon-toggle"></i>
        </div>
        @error('investment_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

                <!-- Investment Preferences Section -->
                <div class="section-title mb-3 mt-4">
                    <h4 style="color: #134DF4;">Investment Preferences</h4>
                    <hr>
                </div>

                <div class="row">
    <div class="col-md-4 mb-3">
        <label for="favourite_investment_stage_id">Favourite Investment Stage <span class="text-danger">*</span></label>
        <div class="custom-select-wrapper">
            <select class="form-control input-focus @error('favourite_investment_stage_id') is-invalid @enderror"
                id="favourite_investment_stage_id" name="favourite_investment_stage_id" required>
                <option value="" style="color: #4B5563 !important;">Select Investment Stage</option>
                @foreach($investmentStages as $stage)
                    <option value="{{ $stage->id }}" {{ old('favourite_investment_stage_id') == $stage->id ? 'selected' : '' }}>{{ $stage->name }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down icon-toggle"></i>
        </div>
        @error('favourite_investment_stage_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
        <label for="budget_range_id">Budget Range <span class="text-danger">*</span></label>
        <div class="custom-select-wrapper">
            <select class="form-control input-focus @error('budget_range_id') is-invalid @enderror" id="budget_range_id"
                name="budget_range_id" required>
                <option value="" style="color: #4B5563 !important;">Select Budget Range</option>
                @foreach($budgetRanges as $range)
                    <option value="{{ $range->id }}" {{ old('budget_range_id') == $range->id ? 'selected' : '' }}>
                        {{ $range->name }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down icon-toggle"></i>
        </div>
        @error('budget_range_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="geographical_scope_id">Geographical Scope <span class="text-danger">*</span></label>
        <div class="custom-select-wrapper">
            <select class="form-control input-focus @error('geographical_scope_id') is-invalid @enderror"
                id="geographical_scope_id" name="geographical_scope_id" required>
                <option value="" style="color: #4B5563 !important;">Select Geographical Scope</option>
                @foreach($geographicalScopes as $scope)
                    <option value="{{ $scope->id }}" {{ old('geographical_scope_id') == $scope->id ? 'selected' : '' }}>{{ $scope->name }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down icon-toggle"></i>
        </div>
        @error('geographical_scope_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="favourite_sectors">Favourite Sectors <span class="text-danger">*</span></label>
                        <select class="form-control input-focus @error('favourite_sectors') is-invalid @enderror" id="favourite_sectors"
                            name="favourite_sectors[]" multiple required>
                            @foreach($favouriteSectors as $sector)
                                <option value="{{ $sector->id }}" {{ (collect(old('favourite_sectors'))->contains($sector->id)) ? 'selected' : '' }}>{{ $sector->name }}</option>
                            @endforeach
                        </select>
                        <div id="selected-sectors" class="mt-2"></div>
                        @error('favourite_sectors')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Investment Settings Section -->
                <div class="section-title mb-3 mt-4">
                    <h4 style="color: #134DF4;">Investment Settings</h4>
                    <hr>
                </div>

                <div class="row">
                <div class="col-md-6 mb-3">
        <label for="co_invest_id">Co-Invest? <span class="text-danger">*</span></label>
        <div class="custom-select-wrapper">
            <select class="form-control input-focus @error('co_invest_id') is-invalid @enderror" id="co_invest_id"
                name="co_invest_id" required>
                <option value="" style="color: #4B5563 !important;">Select Option</option>
                @foreach($yesNoOptions as $option)
                    <option value="{{ $option->id }}" {{ old('co_invest_id') == $option->id ? 'selected' : '' }}>
                        {{ $option->name }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down icon-toggle"></i>
        </div>
        @error('co_invest_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="investment_privacy_option_id">Investment Privacy <span class="text-danger">*</span></label>
        <div class="custom-select-wrapper">
            <select class="form-control input-focus @error('investment_privacy_option_id') is-invalid @enderror"
                id="investment_privacy_option_id" name="investment_privacy_option_id" required>
                <option value="" style="color: #4B5563 !important;">Select Option</option>
                @foreach($investmentPrivacyOptions as $privacyOption)
                    <option value="{{ $privacyOption->id }}" {{ old('investment_privacy_option_id') == $privacyOption->id ? 'selected' : '' }}>
                        {{ $privacyOption->name }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down icon-toggle"></i>
        </div>
        @error('investment_privacy_option_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <label for="additional_notes">Additional Notes</label>
        <div class="textarea-wrapper">
            <textarea class="form-control input-focus @error('additional_notes') is-invalid @enderror custom-textarea-corner"
                id="additional_notes" name="additional_notes" rows="3">{{ old('additional_notes') }}</textarea>
            @error('additional_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

                <div class="row" >
                    <div class="col-12" style="display: flex; justify-content: flex-end !important;">
                        <a href="{{ route('investors') }}" class="btn btn-secondary" style="width: 200px; height: 40.68px; border-radius: 9.63px; border: 0.96px solid #D1D5DB; padding: 13.31px 26.62px 13.98px 26.62px; background-color: #FBFDFF; color: #9CA3AF; font-weight: 600; font-size: 11.98px; line-height: 13.31px; text-align: center; margin-right: 10px;">Back to Investors</a>
                        <button type="submit" class="btn btn-primary"style="width: 200px; height: 40.68px; border-radius: 9.63px; background-color: #134DF4; color: white; font-weight: 600; font-size: 11.98px; line-height: 13.31px; text-align: center; border: none;">Create Investor</button>
                        
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectElement = document.getElementById('favourite_sectors');
            const selectedSectorsContainer = document.getElementById('selected-sectors');

            // Initialize Select2
            $(selectElement).select2({
                placeholder: 'Select Favourite Sectors',
                allowClear: true,
                theme: 'bootstrap4'
            });

            // Store selected values to persist selections
            let selectedValues = new Set(
                Array.from(selectElement.selectedOptions).map(option => option.value)
            );

            function updateSelectedSectors() {
                // Refresh selected values
                selectedValues = new Set(
                    Array.from(selectElement.selectedOptions).map(option => option.value)
                );

                // Ensure correct options remain selected
                Array.from(selectElement.options).forEach(option => {
                    option.selected = selectedValues.has(option.value);
                });

                // Clear displayed tags
                selectedSectorsContainer.innerHTML = '';

                // Create tags for selected options
                selectedValues.forEach(value => {
                    const option = selectElement.querySelector(`option[value="${value}"]`);
                    if (option && !selectedSectorsContainer.querySelector(`[data-sector="${value}"]`)) {
                        const tag = createSectorTag(value, option.text);
                        selectedSectorsContainer.appendChild(tag);
                    }
                });
            }

            function createSectorTag(value, text) {
                const tag = document.createElement('span');
                tag.classList.add('badge', 'bg-primary', 'me-2', 'mb-2', 'selected-sector');
                tag.setAttribute('data-sector', value);
                tag.innerHTML = `${text} <span class="remove-tag" style="cursor: pointer; margin-left: 5px;">&times;</span>`;
                return tag;
            }

            // Handle tag removal
            selectedSectorsContainer.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-tag')) {
                    const tag = e.target.closest('.selected-sector');
                    if (tag) {
                        const value = tag.getAttribute('data-sector');
                        selectedValues.delete(value);
                        const option = selectElement.querySelector(`option[value="${value}"]`);
                        if (option) {
                            option.selected = false;
                            $(selectElement).trigger('change'); // Trigger Select2 update
                        }
                        tag.remove();
                    }
                }
            });

            // Update tags when selection changes
            $(selectElement).on('change', function () {
                updateSelectedSectors();
            });

            // Initialize tags
            updateSelectedSectors();
        });
    </script>

    <style>
        .select2-container--bootstrap4 .select2-selection--multiple {
            min-height: 38px;
        }

        .selected-sector {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 15px;
        }

        .remove-tag {
            color: white;
            font-weight: bold;
        }

        .section-title h4 {
            margin-bottom: 0;
            font-size: 1.2rem;
        }

        .section-title hr {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            border-color: #134DF4;
        }
        .input-focus{
            border: 1px solid #E5E7EB !important;
        }   
        .input-focus:focus {
            border: 1px solid #3B82F6 !important;
            outline: none !important;
            box-shadow: none !important;
        }
        .custom-select-wrapper {
            position: relative;
        }

        .custom-select-wrapper select {
            padding-right: 2rem; /* مساحة للسهم */
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .custom-select-wrapper .icon-toggle {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            color: #6B7280;
            font-size: 14px;
            pointer-events: none;
            }
            .textarea-wrapper {
    position: relative !important;
}

.custom-textarea-corner {
    resize: both !important; /* خليه يقدر يعمل resize */
    overflow: auto !important;
    padding-right: 36px !important;
}

/* صورة التلت نقط */
.custom-textarea-corner::after {
    content: "" !important;
    position: absolute !important;
    bottom: 8px !important;
    right: 8px !important;
    width: 20px !important;
    height: 20px !important;
    background-image: url("{{ asset('images/corner.svg') }}") !important;
    background-size: contain !important;
    background-repeat: no-repeat !important;
    pointer-events: none !important; /* عشان المستخدم يقدر يعمل resize عادي من الزاوية */
}


    </style>

@endsection