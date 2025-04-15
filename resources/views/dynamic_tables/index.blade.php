@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="text-left page-title">Edit Tables</h1>
            <p class="text-left page-subtitle">Here you can Edit the tables</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="card p-4 mb-4 card-custom">
            <form action="{{ route('dynamic-tables.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="table" class="form-label label-bold">Select Table</label>
                    <div class="select-wrapper">
                        <select name="table" id="table" class="form-control select-custom">
                            <option value="CompanySector">Company Sectors</option>
                            <option value="OperationalPhase">Operational Phases</option>
                            <option value="FundingAmount">Funding Amounts</option>
                            <option value="FundingSource">Funding Sources</option>
                            <option value="TargetMarket">Target Markets</option>
                            <option value="InvestmentType">Investment Types</option>
                            <option value="FavouriteInvestmentStage">Favourite Investment Stages</option>
                            <option value="FavouriteSector">Favourite Sectors</option>
                            <option value="BudgetRange">Budget Ranges</option>
                            <option value="GeographicalScope">Geographical Scopes</option>
                            <option value="InvestmentPrivacyOption">Investment Privacy Options</option>
                        </select>
                        <i class="bi bi-chevron-down select-icon"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label label-bold">New Entry Name</label>
                    <input type="text" name="name" id="name" class="form-control input-custom" required
                        placeholder="Enter entry name">
                </div>

                <div class="button-center">
                    <button type="submit" class="btn submit-btn">Add Entry</button>
                </div>
            </form>
        </div>

        <div class="card p-4 mb-4 card-custom">
            <div class="card-header bg-white">
                <h3 class="card-title table-title ">Manage Tables</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(['company_sectors' => $company_sectors, 'operational_phases' => $operational_phases, 'funding_amounts' => $funding_amounts, 'funding_sources' => $funding_sources, 'target_markets' => $target_markets, 'investment_types' => $investment_types, 'favourite_investment_stages' => $favourite_investment_stages, 'favourite_sectors' => $favourite_sectors, 'budget_ranges' => $budget_ranges, 'geographical_scopes' => $geographical_scopes, 'investment_privacy_options' => $investment_privacy_options] as $table_name => $items)
                        <div class="col-12">
                            <div class="card card-outline collapsed-card card-border-radius">
                                <div class="card-header bg-white card-header-custom">
                                    <h3 class="card-title">{{ ucfirst(str_replace('_', ' ', $table_name)) }}</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool toggle-icon-btn" data-card-widget="collapse">
                                            <i class="bi bi-chevron-down icon-toggle"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table borderless-table">
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr id="row-{{ $item->id }}">
                                                    <td class="table-cell {{ $loop->last ? 'no-border-bottom' : '' }}">
                                                        {{ $item->name }}
                                                    </td>
                                                    <td class="text-right table-cell {{ $loop->last ? 'no-border-bottom' : '' }}">
                                                        <button class="btn btn-sm delete-entry delete-btn"
                                                            data-table="{{ $table_name }}" data-id="{{ $item->id }}">
                                                            <img src="{{ asset('images/trash-delete.svg') }}" alt="Delete"
                                                                class="delete-icon">
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            // Initialize Select2
            $('.select2').select2();

            // Delete entry functionality
            $('.delete-entry').on('click', function (e) {
                e.preventDefault(); // Prevent default button behavior
                const $button = $(this);
                const table = $button.data('table');
                const id = $button.data('id');
                const $row = $button.closest('tr');
                const $tbody = $row.closest('tbody');
                const $card = $button.closest('.card-outline');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/dynamic-tables/${table}/${id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            success: function (response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The entry has been removed.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // Remove the row
                                $row.remove();

                                // Check if this was the last row in the table
                                if ($tbody.find('tr').length === 0) {
                                    // Hide the entire card if no rows remain
                                    $card.hide();
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Delete error:', xhr.responseText);
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message || 'Something went wrong. Please try again.',
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
    $(document).on('expanded.lte.cardwidget', function (event) {
        const card = event.target;
        const icon = card.querySelector('.icon-toggle');
        if (icon) {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        }
    });

    $(document).on('collapsed.lte.cardwidget', function (event) {
        const card = event.target;
        const icon = card.querySelector('.icon-toggle');
        if (icon) {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        }
    });
});
    </script>
@endpush

@push('head')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<style>
    .page-title {
        color: #000000;
        font-size: 36px;
        font-weight: 500;
    }

    .page-subtitle {
        color: #9CA3AF;
        font-size: 21px;
        font-weight: 400;
    }

    .label-bold {
        font-weight: bold;
        color: #000000;
    }

    .select-wrapper {
        position: relative;
    }

    .select-custom {
        width: 100%;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 9px;
        background-color: white;
        color: #6B7280;
        border: 1px solid #F3F4F6 !important;
        transition: border-color 0.3s;
        appearance: none;
        padding-right: 36px;
    }

    .select-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 12px;
        color: #6B7280;
        pointer-events: none;
    }

    .input-custom {
        border-radius: 9px;
        border: 1px solid #F3F4F6 !important;
        color: #000000;
    }

    .button-center {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .submit-btn {
        width: 173px;
        height: 45px;
        border-radius: 8px;
        background: linear-gradient(to left, #1D03B5 0%, #3F81F8 100%);
        color: white !important;
        font-weight: bold;
        display: block;
        margin: 0 auto;

    }

    .card-custom {
        border-radius: 15px;
        background-color: white;
        box-shadow: none !important;
    }

    .card-header {
        border-bottom: none !important;
        padding: 10px 15px 0px 15px !important;
        border-radius: 10px 10px 10px 10px !important;
        box-shadow: none !important;
    }

    .table-title {
        font-family: 'Inter', sans-serif;
        font-weight: 600 !important;
        font-size: 21.93px;
        line-height: 24.36px;
        color: #000000;
    }

    .card-border-radius {
        border: 1px solid #F3F4F6 !important;
        border-radius: 10px;
        box-shadow: none !important;

    }

    .card-header-custom {
        border-bottom: none !important;
        border-radius: 10px 10px 10px 10px !important;
        box-shadow: none !important;
    }

    .borderless-table {
        border-top: 1px solid #F3F4F6 !important;
        border-bottom: none !important;
        font-size: 16px !important;
        font-weight: 400 !important;
        color: #000000 !important;
        box-shadow: none !important;

    }

    .toggle-icon-btn {
        padding: 13px 10px 10px 10px !important;
        font-size: 14px !important;
        font-weight: 100 !important;
        color: #6B7280 !important;
        
    }
    .table-cell {
        border-top: 1px solid #F3F4F6 !important;
        border-bottom: 1px solid #F3F4F6 !important;
        font-size: 14px !important;
        font-weight: 400 !important;

    }

    .no-border-bottom {
        border-bottom: none !important;
    }

    .delete-btn {
        background-color: #FBFDFF;
        border: 1px solid #E5E7EB;
        color: #374151;
    }

    .delete-icon {
        color: #6B7280;
        font-size: 15px;
        transition: color 0.3s;
    }

    .delete-icon:hover {
        color: #374151;
    }

    .card.card-outline.collapsed-card,
    .card.card-outline.collapsed-card .card-header {
        box-shadow: none !important;
    }
</style>