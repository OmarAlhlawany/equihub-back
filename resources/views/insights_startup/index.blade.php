@extends('layouts.app')
@section('page-title', 'Startup Insights')

@section('content')
<div class="container">
    <div class="row mt-4">
        <!-- Right Column: Counters & Company Sector (Now on the Left) -->
        <div class="col-md-6">
            <!-- Top Row: Startups Count -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3 text-center custom-bottom-shadow rounded-4" style="border-radius: 25px;">
                        <div class="row w-100">
                            <!-- Left: Icon -->
                            <div class="col-5 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('images/startup-logo.svg') }}" alt="Startup Logo" class="img-fluid" style="max-width: 50px;">
                            </div>
                            <!-- Right: Text & Count -->
                            <div class="col-7 ">
                                <h4 style="color: #333; font-size: 18px;">Total Startups</h4>
                                <h2 style="color: #2B37A0; font-size: 30px; font-weight: bold;">{{ $startupCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Startups by Target Market -->
            <div class="card p-3 mt-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
                <h5 class="text-center" style="font-size: 20px; color: #444;">Startups by Target Market</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3 text-center custom-bottom-shadow rounded-3" style="border-radius: 25px;">
                            <h5 style="font-size: 16px; color: #555;">Angel Investors</h5>
                            <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $targetMarketCounts['Local (UAE)'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 text-center custom-bottom-shadow rounded-3" style="border-radius: 25px;">
                            <h5 style="font-size: 16px; color: #555;">Gulf</h5>
                            <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $targetMarketCounts['Gulf'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 text-center custom-bottom-shadow rounded-3" style="border-radius: 25px;">
                            <h5 style="font-size: 16px; color: #555;">Regional</h5>
                            <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $targetMarketCounts['Regional'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Column: Circle Chart (Now on the Right) -->
        <div class="col-md-6">
            <div class="card p-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
                <h5 class="text-center" style="font-size: 20px; color: #444;">Startups by Funding Amount</h5>
                <div id="fundingChart"></div>
            </div>
        </div>
    </div>

    <!-- Startups by Operational Phase -->
    <div class="card p-3 mt-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
        <h5 class="text-center" style="font-size: 20px; color: #444;">Startups by Operational Phase</h5>
        <div class="row justify-content-between">
            @foreach (['Pre-Seed', 'Seed', 'Pre-Series A', 'Series A', 'Series B'] as $phase)
            <div class="col-md-2">
                <div class="card p-3 text-center custom-bottom-shadow rounded-3" style="border-radius: 25px;">
                    <h5 style="font-size: 16px; color: #555;">{{ $phase }}</h5>
                    <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $startupPhaseCounts[$phase] ?? 0 }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <!-- Startups by Company Sector -->
    <div class="card p-3 mt-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
        <h5 class="text-center" style="font-size: 20px; color: #444;">Startups by Company Sector</h5>
        <div id="sectorChart"></div>
    </div>
</div>

<!-- Load ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // Startups by Funding Amount (Circle Chart)
    var fundingChart = new ApexCharts(document.querySelector("#fundingChart"), {
        chart: { type: 'pie', height: 350 },
        labels: @json(array_keys($fundingCounts)),
        series: @json(array_values($fundingCounts)),
        colors: ['#4C78FF', '#2B37A0', '#16DBCC', '#FF82AC', '#FFBB38']
    });
    fundingChart.render();

    // Startups by Company Sector (Bar Chart)
    var sectorChart = new ApexCharts(document.querySelector("#sectorChart"), {
        chart: { type: 'bar', height: 350 },
        xaxis: { categories: @json(array_keys($sectorCounts)) },
        series: [{ name: "Startups", data: @json(array_values($sectorCounts)) }],
        colors: ['#16DBCC']
    });
    sectorChart.render();
</script>

<style>
    .custom-bottom-shadow {
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
