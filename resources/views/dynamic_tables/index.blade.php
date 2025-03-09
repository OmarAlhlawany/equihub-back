@extends('layouts.app')
@section('page-title', 'Edit Tables')

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="card p-4 mb-4 shadow" style="border-radius: 20px;">
            <form action="{{ route('dynamic-tables.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="table" class="form-label" style="font-weight: bold; color: #2B37A0;">Select Table</label>
                    <select name="table" id="table" class="form-control" style="border-radius: 50px; border: 1px solid #2B37A0; color: #2B37A0;">
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
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label" style="font-weight: bold; color: #2B37A0;">New Entry Name</label>
                    <input type="text" name="name" id="name" class="form-control" style="border-radius: 50px; border: 1px solid #2B37A0; color: #2B37A0;" required>
                </div>

                <button type="submit" class="btn btn-primary w-100" 
                style="border-radius: 50px; background-color: #2B37A0; color: white; font-weight: bold;">
                    Add Entry
                </button>
            </form>
        </div>

        <div class="table-container" style="overflow-x: auto; border-radius: 25px;">
            <table class="table" style="background-color: white; border-radius: 25px;">
                <thead>
                    <tr>
                        <th style="color: #2B37A0; text-align: center; padding: 25px;"></th>
                    </tr >
                </thead>
                <tbody style="border-radius: 25px;">
                    @foreach(['company_sectors' => $company_sectors, 'operational_phases' => $operational_phases, 'funding_amounts' => $funding_amounts, 'funding_sources' => $funding_sources, 'target_markets' => $target_markets, 'investment_types' => $investment_types, 'favourite_investment_stages' => $favourite_investment_stages, 'favourite_sectors' => $favourite_sectors, 'budget_ranges' => $budget_ranges, 'geographical_scopes' => $geographical_scopes, 'investment_privacy_options' => $investment_privacy_options,] as $table_name => $items)
                        <tr >
                            <td style="text-align: center; font-weight: bold; border-radius: 25px;">     <button class="btn btn-link toggle-collapse" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $table_name }}">
                                {{ ucfirst(str_replace('_', ' ', $table_name)) }}
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="collapse" id="collapse-{{ $table_name }}">
                                    <table class="table table-borderless">
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr id="row-{{ $item->id }}" style="border-bottom: 1px solid #ddd; border-radius: 25px;">
                                                    <td style="text-align: left; padding-left: 20px;">{{ $item->name }}</td>
                                                    <td style="text-align: right; padding-right: 20px;">
                                                        <button type="button" class="btn btn-danger btn-sm delete-entry"
                                                        style="border-radius: 50px; background-color: transparent; color: #2B37A0; border: 0px;"
                                                        data-table="{{ $table_name }}" data-id="{{ $item->id }}">
                                                            <i class="fas fa-trash-alt" style="font-size: 20px; transition: color 0.3s;"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.delete-entry').on('click', function() {
                let table = $(this).data('table');
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/dynamic-tables/${table}/${id}`,
                            type: 'DELETE', // Change to POST to handle Laravel CSRF
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE' // Ensure DELETE method is sent correctly
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The entry has been removed.',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                location.reload(); // Refresh the page after deletion
                            });
                                $('#row-' + id).fadeOut(500, function() {
                                    $(this).remove();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something went wrong. Please try again.',
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            });
            $('.toggle-collapse').on('click', function() {
                let icon = $(this).find('i');
                icon.toggleClass('fa-chevron-down fa-chevron-up');
            });
        });
    </script>

    <style>
        .table thead th {
            background-color: #2B37A0;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f0f0f0;
        }

        .table-borderless tbody tr {
            border-bottom: 1px solid #ddd;
        }

        .pagination {
            justify-content: center;
            margin-top: 10px;
        }

        .pagination .page-item {
            margin: 0 5px;
        }

        .toggle-collapse {
            font-size: 18px;
            font-weight: bold;
            color: #2B37A0;
            text-decoration: none;
        }

        .toggle-collapse i {
            transition: transform 0.3s ease;
        }

        .pagination .page-link {
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid #2B37A0;
            color: #2B37A0;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination .page-link:hover {
            background-color: #2B37A0;
            color: white;
        }
    </style>
@endsection
