@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row mt-4">
        <!-- Right Column: Counters & Investment Type (Now on the Left) -->
        <div class="col-md-6">
            <!-- Top Row: Investors & Startups Count -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3 text-center custom-bottom-shadow rounded-4">
                        <div class="row w-100">
                            <div class="col-5 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('images/investor-logo.svg') }}" alt="Investor Logo" class="img-fluid" style="max-width: 50px;">
                            </div>
                            <div class="col-7 text-left">
                                <h4 style="color: #333; font-size: 18px;">Total Investors</h4>
                                <h2 style="color: #2B37A0; font-size: 30px; font-weight: bold;">{{ $investorCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3 text-center custom-bottom-shadow rounded-4">
                        <div class="row w-100">
                            <div class="col-5 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('images/startup-logo.svg') }}" alt="Startup Logo" class="img-fluid" style="max-width: 50px;">
                            </div>
                            <div class="col-7 text-left">
                                <h4 style="color: #333; font-size: 18px;">Total Startups</h4>
                                <h2 style="color: #2B37A0; font-size: 30px; font-weight: bold;">{{ $startupCount }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investors by Investment Type -->
            <div class="card p-3 mt-3 custom-bottom-shadow rounded-4">
                <h5 class="text-center" style="font-size: 20px; color: #444;">Investors by Investment Type</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card p-3 text-center custom-bottom-shadow rounded-3">
                            <h5 style="font-size: 16px; color: #555;">Angel Investors</h5>
                            <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $investmentCounts['Angel Investment'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 text-center custom-bottom-shadow rounded-3">
                            <h5 style="font-size: 16px; color: #555;">Funding Investors</h5>
                            <h3 style="color: #2B37A0; font-size: 25px; font-weight: bold;">{{ $investmentCounts['Investment Funding'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Left Column: Budget Chart -->
        <div class="col-md-6">
            <div class="card p-3 custom-bottom-shadow rounded-4">
                <h5 class="text-center" style="font-size: 20px; color: #444;">Investors by Budget</h5>
                <div id="budgetChart"></div>
            </div>
        </div>
    </div>

    <!-- Overview of Investors -->
    <div class="mt-5">
        <div class="table-container" style="overflow-x: auto; height: auto; border-radius: 25px;">
            <table class="table" style="background-color: white; border-radius: 25px;">
                <thead>
                    <!-- Full-width header row -->
                    <tr>
                        <th colspan="100%" class="px-4 py-3"
                            style="border: 0; background-color: white; border-radius: 25px 25px 0 0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="ml-3" style="font-size: 18px; font-weight: bold; color: #333;">
                                    Overview of Investors
                                </span>
                                <a href="{{ route('investors') }}" class="btn btn-info btn-sm"
                                    style="padding: 5px 15px; font-size: 16px; border-radius: 50px; background-color: white; 
                                        color: #2B37A0; border: 1px solid #2B37A0; transition: background-color 0.3s, color 0.3s;" 
                                    onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" 
                                    onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';">
                                    View all
                                </a>
                            </div>
                        </th>
                    </tr>

                    <!-- Column headers -->
                    <tr>
                        <th style="color: #2B37A0; text-align: center;">ID</th>
                        <th style="color: #2B37A0; text-align: center;">Name</th>
                        <th style="color: #2B37A0; text-align: center;">Email</th>
                        <th style="color: #2B37A0; text-align: center;">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentInvestors as $investor)
                        <tr>
                            <td style="text-align: center">{{ $investor->id }}</td>
                            <td style="text-align: center">{{ $investor->name }}</td>
                            <td style="text-align: center">{{ $investor->email }}</td>
                            <td style="text-align: center">{{ $investor->phone_number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Overview of Startups -->
    <div class="mt-5">
        <div class="table-container" style="overflow-x: auto; height: auto; border-radius: 25px;">
            <table class="table" style="background-color: white; border-radius: 25px;">
                <thead>
                    <tr>
                        <th colspan="100%" class="px-4 py-3"
                        style="border: 0; background-color: white; border-radius: 25px 25px 0 0;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="ml-3" style="font-size: 18px; font-weight: bold; color: #333;">Overview of Startups</span>
                            <a href="{{ route('startups') }}" class="btn btn-info btn-sm"
                                style="padding: 5px 15px; font-size: 16px; border-radius: 50px; background-color: white; 
                                    color: #2B37A0; border: 1px solid #2B37A0; transition: background-color 0.3s, color 0.3s;" 
                                onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" 
                                onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';">
                                View all
                            </a>
                        </th>
                        
                    </tr>
                    <tr>
                        <th style="color: #2B37A0; text-align: center;">ID</th>
                        <th style="color: #2B37A0; text-align: center;">Name</th>
                        <th style="color: #2B37A0; text-align: center;">Email</th>
                        <th style="color: #2B37A0; text-align: center;">Phone</th>
                        <th style="color: #2B37A0; text-align: center;">Company</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentStartups as $startup)
                        <tr>
                            <td style="text-align: center">{{ $startup->id }}</td>
                            <td style="text-align: center">{{ $startup->name }}</td>
                            <td style="text-align: center">{{ $startup->email }}</td>
                            <td style="text-align: center">{{ $startup->phone_number}}</td>
                            <td style="text-align: center">{{ $startup->company}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Load ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // Investors by Budget (Pie Chart)
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
</script>
@endsection
