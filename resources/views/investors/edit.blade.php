@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4" style="color: #2B37A0; font-weight: bold; font-size: 30px;">Edit Investor</h2>

    <form action="{{ route('investors.update', $investor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card" style="background-color: #fff; padding: 20px; border-radius: 8px;">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $investor->name }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $investor->email }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="phone_number">Phone</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $investor->phone_number }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="company">Company</label>
                    <input type="text" class="form-control" id="company" name="company" value="{{ $investor->company }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="investment_type_id">Investment Type</label>
                    <select class="form-control" id="investment_type_id" name="investment_type_id" required>
                        @foreach($investmentTypes as $type)
                            <option value="{{ $type->id }}" {{ $type->id == $investor->investment_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="favourite_investment_stage_id">Favourite Investment Stage</label>
                    <select class="form-control" id="favourite_investment_stage_id" name="favourite_investment_stage_id" required>
                        @foreach($investmentStages as $stage)
                            <option value="{{ $stage->id }}" {{ $stage->id == $investor->favourite_investment_stage_id ? 'selected' : '' }}>{{ $stage->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="budget_range_id">Budget Range</label>
                    <select class="form-control" id="budget_range_id" name="budget_range_id" required>
                        @foreach($budgetRanges as $range)
                            <option value="{{ $range->id }}" {{ $range->id == $investor->budget_range_id ? 'selected' : '' }}>{{ $range->range }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="geographical_scope_id">Geographical Scope</label>
                    <select class="form-control" id="geographical_scope_id" name="geographical_scope_id" required>
                        @foreach($geographicalScopes as $scope)
                            <option value="{{ $scope->id }}" {{ $scope->id == $investor->geographical_scope_id ? 'selected' : '' }}>{{ $scope->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="co_invest_id">Co-Invest?</label>
                    <select class="form-control" id="co_invest_id" name="co_invest_id" required>
                        @foreach($yesNoOptions as $option)
                            <option value="{{ $option->id }}" {{ $option->id == $investor->co_invest_id ? 'selected' : '' }}>{{ $option->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="investment_privacy_option_id">Investment Privacy</label>
                    <select class="form-control" id="investment_privacy_option_id" name="investment_privacy_option_id" required>
                        @foreach($investmentPrivacyOptions as $option)
                            <option value="{{ $option->id }}" {{ $option->id == $investor->investment_privacy_option_id ? 'selected' : '' }}>{{ $option->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-8 mb-3">
                    <label for="favourite_sectors">Favourite Sectors</label>
                    <select class="form-control" id="favourite_sectors" name="favourite_sectors[]" multiple required>
                        @foreach($favouriteSectors as $sector)
                            <option value="{{ $sector->id }}" 
                                {{ in_array($sector->id, $investor->favouriteSectors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                    <div id="selected-sectors" class="mt-2"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="additional_notes">Additional Notes</label>
                    <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3">{{ $investor->additional_notes }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Investor</button>
        </div>
    </form>

    <a href="{{ route('investors') }}" class="btn btn-secondary mt-3">Back to Investors</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectElement = document.getElementById('favourite_sectors');
        const selectedSectorsContainer = document.getElementById('selected-sectors');

        // Store selected values to persist selections
        let selectedValues = new Set(
            Array.from(selectElement.selectedOptions).map(option => option.value)
        );

        function updateSelectedSectors() {
            // Refresh selected values to persist selections
            selectedValues = new Set(
                Array.from(selectElement.selectedOptions).map(option => option.value)
            );

            // Ensure the correct options remain selected in the dropdown
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
            tag.classList.add('badge', 'badge-primary', 'mr-2', 'p-2', 'selected-sector');
            tag.setAttribute('data-sector', value);
            tag.innerHTML = `${text} <span class="remove-tag ml-2" style="cursor: pointer; color: #fff;">&times;</span>`;
            return tag;
        }

        function removeSectorTag(tag) {
            const sector = tag.getAttribute('data-sector');

            // Remove from selected values
            selectedValues.delete(sector);

            // Unselect the option in the dropdown
            const option = selectElement.querySelector(`option[value="${sector}"]`);
            if (option) {
                option.selected = false;
            }

            // Remove tag from UI
            tag.remove();
        }

        // Handle tag removal
        selectedSectorsContainer.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-tag')) {
                const tag = e.target.closest('.selected-sector');
                if (tag) {
                    removeSectorTag(tag);
                }
            }
        });

        // Prevent default deselection when clicking new options
        selectElement.addEventListener('mousedown', function (e) {
            e.preventDefault(); // Prevent default selection reset behavior

            const option = e.target;
            if (option.tagName === 'OPTION') {
                if (selectedValues.has(option.value)) {
                    selectedValues.delete(option.value); // Deselect if already selected
                    option.selected = false;
                } else {
                    selectedValues.add(option.value); // Select if not already selected
                    option.selected = true;
                }
                updateSelectedSectors();
            }
        });

        // Initialize tags for already selected sectors
        updateSelectedSectors();
    });
</script>

@endsection
