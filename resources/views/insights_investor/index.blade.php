@extends('layouts.app')
@section('page-title', 'Investor Insights')

@section('content')
<div class="container">
    <div class="row mt-4">
        <!-- Right Column: Counters & Investment Type (Now on the Left) -->
        <div class="col-md-6">
            <!-- Top Row: Investors & Startups Count -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3 text-center custom-bottom-shadow rounded-4" style="border-radius: 25px;">
                        <div class="row w-100">
                            <!-- Left: Icon -->
                            <div class="col-5 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('images/investor-logo.svg') }}" alt="Investor Logo" class="img-fluid" style="max-width: 50px;">
                            </div>
                            <!-- Right: Text & Count -->
                            <div class="col-7 ">
                                <h4 style="color: #333; font-size: 18px;">Total Investors</h4>
                                <h2 style="color: #2B37A0; font-size: 30px; font-weight: bold;">{{ $investorCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
    
            <!-- Investors by Investment Type (Angel & Funding) -->
            <div class="card p-3 mt-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
                <h5 class="text-center" style="font-size: 20px; color: #444;">Investors by Investment Type</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card p-3 text-center custom-bottom-shadow rounded-3" style="border-radius: 25px;">
                            <h5 style="font-size: 16px; color: #555;">Angel Investors</h5>
                            <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $investmentCounts['Angel Investment'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 text-center custom-bottom-shadow rounded-3" style="border-radius: 25px;">
                            <h5 style="font-size: 16px; color: #555;">Funding Investors</h5>
                            <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $investmentCounts['Investment Funding'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Left Column: Circle Chart (Now on the Right) -->
        <div class="col-md-6">
            <div class="card p-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
                <h5 class="text-center" style="font-size: 20px; color: #444;">Investors by Budget</h5>
                <div id="budgetChart"></div>
            </div>
        </div>
    </div>
    
    

        
            
        <!-- Investors by Geographical Scope -->
    <div class="card p-3 mt-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
        <h5 class="text-center" style="font-size: 20px; color: #444;">Investors by Geographical Scope</h5>
        <div class="row justify-content-between">
            @foreach (['United Arab Emirates' => 'Local (UAE)', 'GCC' => 'Gulf', 'Regional' => 'Regional'] as $key => $label)
            <div class="col-md-4">
                <div class="card p-3 text-center custom-bottom-shadow rounded-3" style="border-radius: 25px;">
                    <h5 style="font-size: 16px; color: #555;">{{ $label }} Investors</h5>
                    <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $geographicalCounts[$key] ?? 0 }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Investors by Sector -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card p-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
                <h5 class="text-center" style="font-size: 20px; color: #444;">Investors by Sectors (Part 1)</h5>
                <div id="sectorChart1"></div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card p-3 custom-bottom-shadow rounded-4" style="border-radius: 25px;">
                <h5 class="text-center" style="font-size: 20px; color: #444;">Investors by Sectors (Part 2)</h5>
                <div id="sectorChart2"></div>
            </div>
        </div>
    </div>
</div>

<!-- Load ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // Investors by Budget (Circle Chart)
    var budgetChart = new ApexCharts(document.querySelector("#budgetChart"), {
        chart: {
            type: 'pie',
            height: 350
        },
        labels: @json(array_keys($sortedBudgetCounts)),
        series: @json(array_values($sortedBudgetCounts)),
        colors: ['#4C78FF', '#2B37A0', '#16DBCC', '#FF82AC', '#FFBB38'],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    });
    budgetChart.render();

    // Investors by Sector (Part 1) - Bar Chart
    var sectorChart1 = new ApexCharts(document.querySelector("#sectorChart1"), {
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($sector1),
        },
        series: [{
            name: "Investors",
            data: @json($count1)
        }],
        yaxis: {
            title: {
                text: 'Number of Investors'
            }
        },
        fill: {
            opacity: 1
        },
        colors: ['#33A6FF'],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " investors"
                }
            }
        }
    });
    sectorChart1.render();

    // Investors by Sector (Part 2) - Bar Chart
    var sectorChart2 = new ApexCharts(document.querySelector("#sectorChart2"), {
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($sector2),
        },
        series: [{
            name: "Investors",
            data: @json($count2)
        }],
        yaxis: {
            title: {
                text: 'Number of Investors'
            }
        },
        fill: {
            opacity: 1
        },
        colors: ['#FF8C33'],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " investors"
                }
            }
        }
    });
    sectorChart2.render();
</script>
<style>
    .custom-bottom-shadow {
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
