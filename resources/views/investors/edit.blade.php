@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mb-4" style="color: #2B37A0; font-weight: bold; font-size: 30px;">Edit Investor</h2>

        <form action="{{ route('investors.update', $investor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card"
                style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <!-- Personal Information Section -->
                <div class="section-title mb-3">
                    <h4 style="color: #2B37A0;">Personal Information</h4>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                            value="{{ old('name', $investor->name) }}" required>
                        @error('name')              <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $investor->email) }}" required>
                        @error('email')        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="phone_number">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" value="{{ old('phone_number', $investor->phone_number) }}"
                            required>
                        @error('phone_number')       <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Company Information Section -->
                <div class="section-title mb-3 mt-4">
                    <h4 style="color: #2B37A0;">Company Information</h4>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="company">Company <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror" id="company"
                            name="company" value="{{ old('company', $investor->company) }}" required>
                        @error('company')     <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="investment_type_id">Investment Type <span class="text-danger">*</span></label>
                        <select class="form-control @error('investment_type_id') is-invalid @enderror"
                            id="investment_type_id" name="investment_type_id" required>
                            <option value="">Select Investment Type</option>
                            @foreach($investmentTypes as $type)
                                <option value="{{ $type->id }}" {{ old('investment_type_id', $investor->investment_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('investment_type_id')               <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Investment Preferences Section -->
                <div class="section-title mb-3 mt-4">
                    <h4 style="color: #2B37A0;">Investment Preferences</h4>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="favourite_investment_stage_id">Favourite Investment Stage <span
                                class="text-danger">*</span></label>
                        <select class="form-control @error('favourite_investment_stage_id') is-invalid @enderror"
                            id="favourite_investment_stage_id" name="favourite_investment_stage_id" required>
                            <option value="">Select Investment Stage</option>
                            @foreach($investmentStages as $stage)
                                <option value="{{ $stage->id }}" {{ old('favourite_investment_stage_id', $investor->favourite_investment_stage_id) == $stage->id ? 'selected' : '' }}>
                                    {{ $stage->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('favourite_investment_stage_id')     <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="budget_range_id">Budget Range <span class="text-danger">*</span></label>
                        <select class="form-control @error('budget_range_id') is-invalid @enderror" id="budget_range_id"
                            name="budget_range_id" required>
                            <option value="">Select Budget Range</option>
                            @foreach($budgetRanges as $range)
                                <option value="{{ $range->id }}" {{ old('budget_range_id', $investor->budget_range_id) == $range->id ? 'selected' : '' }}>
                                    {{ $range->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('budget_range_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="geographical_scope_id">Geographical Scope <span class="text-danger">*</span></label>
                        <select class="form-control @error('geographical_scope_id') is-invalid @enderror"
                            id="geographical_scope_id" name="geographical_scope_id" required>
                            <option value="">Select Geographical Scope</option>
                            @foreach($geographicalScopes as $scope)
                                <option value="{{ $scope->id }}" {{ old('geographical_scope_id', $investor->geographical_scope_id) == $scope->id ? 'selected' : '' }}>
                                    {{ $scope->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('geographical_scope_id')       <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="favourite_sectors">Favourite Sectors <span class="text-danger">*</span></label>
                        <select class="form-control @error('favourite_sectors') is-invalid @enderror" id="favourite_sectors"
                            name="favourite_sectors[]" multiple required>
                            @foreach($favouriteSectors as $sector)
                                <option value="{{ $sector->id }}" {{ in_array($sector->id, old('favourite_sectors', $investor->favouriteSectors->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $sector->name }}
                                </option>
                            @endforeach
                        </select>
                        <div id="selected-sectors" class="mt-2"></div>
                        @error('favourite_sectors')                <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Investment Settings Section -->
                <div class="section-title mb-3 mt-4">
                    <h4 style="color: #2B37A0;">Investment Settings</h4>
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="co_invest_id">Co-Invest? <span class="text-danger">*</span></label>
                        <select class="form-control @error('co_invest_id') is-invalid @enderror" id="co_invest_id"
                            name="co_invest_id" required>
                            <option value="">Select Option</option>
                            @foreach($yesNoOptions as $option)
                                <option value="{{ $option->id }}" {{ old('co_invest_id', $investor->co_invest_id) == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('co_invest_id')          <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="investment_privacy_option_id">Investment Privacy <span
                                class="text-danger">*</span></label>
                        <select class="form-control @error('investment_privacy_option_id') is-invalid @enderror"
                            id="investment_privacy_option_id" name="investment_privacy_option_id" required>
                            <option value="">Select Option</option>
                            @foreach($investmentPrivacyOptions as $option)
                                <option value="{{ $option->id }}" {{ old('investment_privacy_option_id', $investor->investment_privacy_option_id) == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('investment_privacy_option_id')                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="additional_notes">Additional Notes</label>
                        <textarea class="form-control @error('additional_notes') is-invalid @enderror" id="additional_notes"
                            name="additional_notes"
                            rows="3">{{ old('additional_notes', $investor->additional_notes) }}</textarea>
                        @error('additional_notes')          <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update Investor</button>
                        <a href="{{ route('investors') }}" class="btn btn-secondary">Back to Investors</a>
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
            border-color: #2B37A0;
        }
    </style>

@endsection