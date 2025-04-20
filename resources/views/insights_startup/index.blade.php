@extends('layouts.app')
@section('page-title', 'Startup Insights')

@section('content')
    <!-- First Row: Title -->
    <div class="text-left mb-4">
        <h2 style="color: #374151;font-size: 36px; font-weight: 500;">Startup Insights</h2>
        <p style="color: #9CA3AF; font-size: 21px; font-weight: 400;">Overview The Startups Numbers</p>
    </div>

    <!-- First Row: Cards & Pie Chart -->
    <div class="row d-flex align-items-stretch" style="min-height: 100%;">
        <!-- Left Column: 3 Cards -->
        <div class="col-md-8 d-flex flex-column justify-content-between">
            <!-- Total Startups -->
            <div class="card p-3 flex-fill custom-bottom-shadow">
                <div class="d-flex align-items-center">
                    <div class="me-3"
                        style="background-color: #F2F7FD; border-radius: 7px; height: 85px; width: 85px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('images/insights-startups-icon.svg') }}" alt="Startup Logo" class="img-fluid"
                            style="height: 50px; width: 50px;">
                    </div>
                    <div>
                        <h2 style="color: #374151; font-size: 35px; font-weight: 600;">{{ $startupCount }}</h2>
                        <h4 style="color: #9CA3AF; font-size: 22px; font-weight: 500;">Total Startups</h4>
                    </div>
                </div>
            </div>

            <!-- Startups by Target Market -->
            <h2 style="color: #374151;font-size: 26px; font-weight: 500;">Startups by Target Market</h2>

            <div class="row">
                @foreach (['Local (UAE)' => 'UAE', 'Gulf' => 'Gulf', 'Regional' => 'Regional'] as $key => $label)
                    <div class="col-md-4 mb-3 pl-0">
                        <div class="card p-3 custom-bottom-shadow flex-fill" style="border-radius: 7px;">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 style="color: #4B5563; font-size: 19px; font-weight: 500;">{{ $label }}</h4>
                                    <h2 style="color: #374151; font-size: 27px; font-weight: 500;">
                                        {{ $targetMarketCounts[$key] ?? 0 }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Startups by Operational Phase -->
            <h2 style="color: #374151;font-size: 26px; font-weight: 500;">Startups by Operational Phase</h2>

            <div class="row" style="margin:0px 0px 0px 0px; gap: 28px;">
                @foreach (['Pre-Seed', 'Seed', 'Pre-Series A', 'Series A', 'Series B'] as $phase)
                    <div class="col-md-2 mb-1 pl-0">
                        <div class="card p-2 custom-bottom-shadow flex-fill" style="border-radius: 7px; width: 160px;">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 style="color: #4B5563; font-size: 19px; font-weight: 500;">{{ $phase }}</h4>
                                    <h2 style="color: #374151; font-size: 27px; font-weight: 500;">
                                        {{ $startupPhaseCounts[$phase] ?? 0 }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column: Funding Chart -->
        <div class="col-md-4 d-flex">
            <div class="card p-3 mb-0 custom-bottom-shadow w-100" style="border-radius: 7px; height: 440px;">
                <h5 class="text-center mb-3" style="font-size: 20px; color: #444;">Startups by Funding Amount</h5>

                <div class="position-relative" style="min-height: 350px;">
                    <div id="fundingChart" style="height: 100%; width: 100%;"></div>

                    <div class="d-flex flex-column align-items-center justify-content-center position-absolute top-50 start-50 translate-middle"
                        style="pointer-events: none; transition: all 0.3s ease;">
                        <span style="font-size: 20px; color: #374151; font-weight: 500;">{{ $estimatedFundingFormatted }}</span>
                            <span style="font-size: 14px; color: #6B7280; font-weight: 400;">Estimated Total</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row: Sector Charts -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card p-3 custom-bottom-shadow" style="border-radius: 7px;">
                <h5 class="text-left" style="font-size: 20px; color: #444;">Startups by Sectors</h5>
                <p class="text-left" style="font-size: 15px; font-weight: 400; color: #9CA3AF;">Number of Startups</p>
                <div id="sectorChart"></div>
            </div>
        </div>
    </div>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Startups by Funding Amount (Pie Chart)
        var fundingChart = new ApexCharts(document.querySelector("#fundingChart"), {
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
            labels: @json(array_keys($fundingCounts)),
            series: @json(array_values($fundingCounts)),
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
        fundingChart.render();

        // Startups by Sectors (Bar Chart)
        var sectorChart = new ApexCharts(document.querySelector("#sectorChart"), {
            chart: {
                type: 'bar',
                height: 420,
                animations: {
                    enabled: false
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'last',
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
                categories: @json(array_keys($sectorCounts)),
                labels: {
                    style: {
                        fontSize: '5.8px',
                        colors: '#374151',
                        cssClass: 'apexcharts-xaxis-label'
                    },
                    rotate: 0,
                }
            },
            series: [{
                name: "Startups",
                data: @json(array_values($sectorCounts))
            }],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " startups"
                    }
                }
            }
        });
        sectorChart.render();
    </script>

    <style>
        .custom-bottom-shadow {
            box-shadow: none;
        }
    </style>
@endsection