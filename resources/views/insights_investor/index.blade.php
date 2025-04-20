@extends('layouts.app')

@section('content')
    <!-- First Row: Title -->
    <div class="text-left mb-4">
        <h2 style="color: #374151;font-size: 36px; font-weight: 500;">Investor Insights</h2>
        <p style="color: #9CA3AF; font-size: 21px; font-weight: 400;">An overview of investor distribution and analytics</p>
    </div>

    <!-- First Row: Cards & Pie Chart -->
    <div class="row d-flex align-items-stretch" style="min-height: 100%;">
        <!-- Left Column: 3 Cards -->
        <div class="col-md-8 d-flex flex-column justify-content-between">
            <!-- Total Investors -->
            <div class="card p-3 flex-fill custom-bottom-shadow">
                <div class="d-flex align-items-center">
                    <div class="me-3"
                        style="background-color: #F2F7FD; border-radius: 7px; height: 85px; width: 85px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ asset('images/insights-investors-icon.svg') }}" alt="Investor Logo" class="img-fluid"
                            style="height: 50px; width: 50px;">
                    </div>
                    <div>
                        <h2 style="color: #374151; font-size: 35px; font-weight: 600;">{{ $investorCount }}</h2>
                        <h4 style="color: #9CA3AF; font-size: 22px; font-weight: 500;">Total Investors</h4>
                    </div>
                </div>
            </div>

            <!-- Angel & Funding Investors -->
            <h2 style="color: #374151;font-size: 26px; font-weight: 500;">Investors by Investment Type</h2>

            <div class="row">
                <!-- Angel Investors Card -->
                <div class="col-md-6 mb-4 pr-1">
                    <div class="card p-3 custom-bottom-shadow  flex-fill" style="border-radius: 7px;">
                        <div class="d-flex align-items-center">
                            <div class="me-3"
                                style="background-color: #F2F7FD; border-radius: 7px; height: 85px; width: 85px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('images/angel-logo.svg') }}" alt="Angel Logo" class="img-fluid"
                                    style="height: 50px; width: 50px;">
                            </div>
                            <div>
                                <h2 style="color: #374151; font-size: 35px; font-weight: 600;">
                                    {{ $investmentCounts['Angel Investment'] ?? 0 }}</h2>
                                <h4 style="color: #9CA3AF; font-size: 22px; font-weight: 500;">Angel Investors</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Funding Investors Card -->
                <div class="col-md-6 mb-3 pl-1 ">
                    <div class="card p-3 flex-fill custom-bottom-shadow" style="border-radius: 7px;">
                        <div class="d-flex align-items-center">
                            <div class="me-3"
                                style="background-color: #F2F7FD; border-radius: 7px; height: 85px; width: 85px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('images/funding-logo.svg') }}" alt="Funding Logo" class="img-fluid"
                                    style="height: 50px; width: 50px;">
                            </div>
                            <div>
                                <h2 style="color: #374151; font-size: 35px; font-weight: 600;">
                                    {{ $investmentCounts['Investment Funding'] ?? 0 }}</h2>
                                <h4 style="color: #9CA3AF; font-size: 22px; font-weight: 500;">Funding Investors</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h2 style="color: #374151;font-size: 26px; font-weight: 500;">Investors by Geographical Scope</h2>

            <div class="row">
                @foreach (['United Arab Emirates' => 'Local (UAE)', 'GCC' => 'Gulf', 'Regional' => 'Regional'] as $key => $label)
                    <div class="col-md-4 mb-3 pl-0 ">
                        <div class="card p-3 custom-bottom-shadow  flex-fill" style="border-radius: 7px;">
                            <div class="d-flex align-items-center">
                            
                                <div>
                                <h4 style="color: #9CA3AF; font-size: 22px; font-weight: 500;">{{ $label }}</h4>
                                    <h2 style="color: #374151; font-size: 35px; font-weight: 600;">
                                        {{ $geographicalCounts[$key] ?? 0 }}</h2>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column: Budget Pie Chart -->
        <div class="col-md-4 d-flex">
            <div class="card p-3 mb-0 custom-bottom-shadow  w-100" style="border-radius: 7px; height: 490px;">
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

    <!-- Second & Third Rows: Sector Charts -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card p-3 custom-bottom-shadow " style="border-radius: 7px;">
                <h5 class="text-left" style="font-size: 20px; color: #444;">Investors by Sectors (Part 1)</h5>
                <p class="text-left" style="font-size: 15px; font-weight: 400; color: #9CA3AF;">Number of Investors</p>
                <div id="sectorChart1"></div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card p-3 custom-bottom-shadow " style="border-radius: 7px;">
                <h5 class="text-left" style="font-size: 20px; color: #444;">Investors by Sectors (Part 2)</h5>
                <p class="text-left" style="font-size: 15px; font-weight: 400; color: #9CA3AF;">Number of Investors</p>
                <div id="sectorChart2"></div>
            </div>
        </div>
    </div>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>

        // Function to wrap long labels with multiple words
    function wrapXAxisLabels(label) {
        // Split on common separators (space, &, comma, etc.)
        const parts = label.split(/(\s+|\s*&\s*|\s*,\s*)/);
        
        // Filter out empty strings and pure whitespace
        const filteredParts = parts.filter(part => part.trim().length > 0);
        
        // Join with line breaks
        return filteredParts.join('<br>');
    }
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




        var sectorChart1 = new ApexCharts(document.querySelector("#sectorChart1"), {
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
                categories: @json($sector2),
                labels: {
                    style: {
                        fontSize: '5.8px',
                        colors: '#374151',
                        cssClass: 'apexcharts-xaxis-label'
                    },
                    rotate: 0,
                    formatter: function(value) {
                        let wrappedValue = wrapXAxisLabels(value);
                        return wrappedValue.replace(/<br>/g, '\n');
                    }
                },
                tooltip: {
                    enabled: false
                }
            },
            series: [{ 
                name: "Investors", 
                data: @json($count2) 
            }],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " investors"
                    }
                }
            }
        });

        var style = document.createElement('style');
        style.innerHTML = `
            .apexcharts-xaxis-label tspan {
                white-space: normal !important;
                line-height: 1.2;
            }
        `;
        document.head.appendChild(style);

        sectorChart1.render();

        var sectorChart2 = new ApexCharts(document.querySelector("#sectorChart2"), {
            chart: { 
                type: 'bar', 
                height: 376,
                animations: {
                    enabled: false 
                }
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
            categories: @json($sector2),
            labels: {
                style: {
                    fontSize: '5.8px',
                    color: '#374151',
                    cssClass: 'apexcharts-xaxis-label'
                },
                rotate: 0,
                formatter: function(value) {
                        let wrappedValue = wrapXAxisLabels(value);
                        return wrappedValue.replace(/<br>/g, '\n');
                    }
            },
            tooltip: {
                enabled: false
            }
        },

            series: [{ 
                name: "Investors", 
                data: @json($count2) 
            }],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " investors"
                    }
                }
            }
        });

        var style = document.createElement('style');
        style.innerHTML = `
            .apexcharts-xaxis-label tspan {
                white-space: normal !important;
                line-height: 1.2;
            }
        `;
        document.head.appendChild(style);

        sectorChart2.render();

    </script>

    <style>
        .custom-bottom-shadow {
            box-shadow: none;
        }
    </style>
    
@endsection