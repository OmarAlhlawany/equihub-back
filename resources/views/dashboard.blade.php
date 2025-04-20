@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="text-left" style="color: #374151; font-size: 36px; font-weight: 500;">Dashboard</h1>
                <p class="text-left" style="color: #9CA3AF; font-size: 21px; font-weight: 400;">Overview Platform Details</p>
            </div>
        </div>

        <!-- First Row: Four Cards -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card p-3 flex-fill custom-bottom-shadow">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="background-color: #F2F7FD; border-radius: 7px; height: 85px; width: 85px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('images/investor-logo.svg') }}" alt="Investor Logo" class="img-fluid" style="height: 50px; width: 50px;">
                        </div>
                        <div>
                            <h2 style="color: #374151; font-size: 35px; font-weight: 600;">{{ $investorCount }}</h2>
                            <h4 style="color: #9CA3AF; font-size: 22px; font-weight: 500;">Total Investors</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3 pl-0">
                <div class="card p-3 flex-fill custom-bottom-shadow">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="background-color: #F2F7FD; border-radius: 7px; height: 85px; width: 85px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('images/startup-logo.svg') }}" alt="Startup Logo" class="img-fluid" style="height: 50px; width: 50px;">
                        </div>
                        <div>
                            <h2 style="color: #374151; font-size: 35px; font-weight: 600;">{{ $startupCount }}</h2>
                            <h4 style="color: #9CA3AF; font-size: 22px; font-weight: 500;">Total Startups</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3 pl-0">
                <div class="card p-3 custom-bottom-shadow flex-fill" style="border-radius: 7px;">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="background-color: #F2F7FD; border-radius: 7px; height: 85px; width: 85px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('images/angel-logo.svg') }}" alt="Angel Logo" class="img-fluid" style="height: 50px; width: 50px;">
                        </div>
                        <div>
                            <h2 style="color: #374151; font-size: 35px; font-weight: 600;">{{ $investmentCounts['Angel Investment'] ?? 0 }}</h2>
                            <h4 style="color: #9CA3AF; font-size: 22px; font-weight: 500;">Angel Investors</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3 pl-0">
                <div class="card p-3 custom-bottom-shadow flex-fill" style="border-radius: 7px;">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="background-color: #F2F7FD; border-radius: 7px; height: 85px; width: 85px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('images/funding-logo.svg') }}" alt="Funding Logo" class="img-fluid" style="height: 50px; width: 50px;">
                        </div>
                        <div>
                            <h2 style="color: #374151; font-size: 35px; font-weight: 600;">{{ $investmentCounts['Investment Funding'] ?? 0 }}</h2>
                            <h4 style="color: #9CA3AF; font-size: 20px; font-weight: 500;">Funding Investors</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row: Tables and Chart -->
        <div class="row mt-4">
            <!-- Left Column: Investors and Startups Tables (2/3 width) -->
            <div class="col-md-8">
                <!-- Investors Table -->
                <div class="table-container mb-4" style="overflow-x: auto; border-radius: 10px; background-color: white; border: 1px solid #E5E7EB; padding: 10px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <text class="m-0" style="color: #374151; text-align: center; font-size: 21px; font-weight: 600;">Overview of Investors</text>
                        <a href="{{ route('investors') }}" class="btn btn-primary" style="padding: 5px 10px; border-radius: 10px; background-color: #134DF4; color: white; width: 150px; height: 40px; text-align: center; margin-top: 10px;">
                            View all
                        </a>
                    </div>
                    <table class="table custom-table" style="background-color: white; border-collapse: separate; border-spacing: 0;">
                        <thead style="height: 55px; background-color: #F2F7FD; overflow: hidden; border-bottom: none !important;">
                            <tr style="border-bottom: none !important;">
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-left: 1px solid #E5E7EB; border-top: 1px solid #E5E7EB; border-radius: 10px 0 0 10px;">ID</th>
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-top: 1px solid #E5E7EB;">Name</th>
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-top: 1px solid #E5E7EB;">Email</th>
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-top: 1px solid #E5E7EB;">Phone</th>
                            </tr>
                        </thead>
                        <tbody style="height: 55px; justify-content: center; align-items: center;">
                            @foreach($recentInvestors as $investor)
                                <tr style="border-bottom: 0.5px solid #E5E7EB;">
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $investor->id }}</td>
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $investor->name }}</td>
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $investor->email }}</td>
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $investor->phone_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Startups Table -->
                <div class="table-container" style="overflow-x: auto; border-radius: 10px; background-color: white; border: 1px solid #E5E7EB; padding: 10px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <text class="m-0" style="color: #374151; text-align: center; font-size: 21px; font-weight: 600;">Overview of Startups</text>
                        <a href="{{ route('startups') }}" class="btn btn-primary" style="padding: 5px 10px; border-radius: 10px; background-color: #134DF4; color: white; width: 150px; height: 40px; text-align: center; margin-top: 10px;">
                            View all
                        </a>
                    </div>
                    <table class="table custom-table" style="background-color: white; border-collapse: separate; border-spacing: 0;">
                        <thead style="height: 55px; background-color: #F2F7FD; overflow: hidden; border-bottom: none !important;">
                            <tr style="border-bottom: none !important;">
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-left: 1px solid #E5E7EB; border-top: 1px solid #E5E7EB; border-radius: 10px 0 0 10px;">ID</th>
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-top: 1px solid #E5E7EB;">Name</th>
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-top: 1px solid #E5E7EB;">Email</th>
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-top: 1px solid #E5E7EB;">Phone</th>
                                <th style="color: #9CA3AF; background-color: #F2F7FD; text-align: center; vertical-align: middle; border-top: 1px solid #E5E7EB; border-radius: 0 10px 10px 0;">Company</th>
                            </tr>
                        </thead>
                        <tbody style="height: 55px; justify-content: center; align-items: center;">
                            @foreach($recentStartups as $startup)
                                <tr style="border-bottom: 0.5px solid #E5E7EB;">
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $startup->id }}</td>
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $startup->name }}</td>
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $startup->email }}</td>
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $startup->phone_number }}</td>
                                    <td style="text-align: center; color: #374151; vertical-align: middle;">{{ $startup->company }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column: Investors by Budget Chart (1/3 width) -->
            <div class="col-md-4">
                <div class="card p-3 mb-0 custom-bottom-shadow w-100" style="border-radius: 7px; height: 490px;">
                    <h5 class="text-center mb-3" style="font-size: 20px; color: #444;">Investors by Budget</h5>
                    <div class="position-relative" style="min-height: 350px;">
                        <div id="budgetChart" style="height: 100%; width: 100%;"></div>
                        <div class="d-flex flex-column align-items-center justify-content-center position-absolute top-50 start-50 translate-middle"
                        style="pointer-events: none; transition: all 0.3s ease;">
                        <span
                            style="font-size: 20px; color: #374151; font-weight: 500;">{{ $estimatedBudgetFormatted }}</span>
                        <span style="font-size: 14px;  color: #6B7280; font-weight: 400;">Estimated Total</span>

                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Investors by Budget (Pie Chart)
        var budgetChart = new ApexCharts(document.querySelector("#budgetChart"), {
            chart: {
                type: 'donut',
                height: 350,

            },
            plotOptions: {
                pie: {
                    startAngle: -110,
                    endAngle: 110,
                    donut: {
                        size: '75%',
                    }
                }
            },
            stroke: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            labels: @json(array_keys($sortedBudgetCounts)),
            series: @json(array_values($sortedBudgetCounts)),
            colors: ['#4085FA', '#DBEAFE', '#7C3AED', '#FBBF24', '#10B981'],
            legend: {
                position: 'bottom',
                fontSize: '9px',
                formatter: function (seriesName, opts) {
                    let total = opts.w.globals.series.reduce((a, b) => a + b, 0);
                    let val = opts.w.globals.series[opts.seriesIndex];
                    let percentage = ((val / total) * 100).toFixed(1);
                    return `<span style="font-size: 8px; font-weight: 400; color: #9CA3AF;">${seriesName}</span><br><span style="font-size: 9px; font-weight: 500; color: #374151;">${percentage}%</span>`;
                }
            }
        });
        budgetChart.render();

    </script>

    <style>
        .custom-bottom-shadow {
            box-shadow: none;
        }
    </style>
@endsection