@extends('layouts.app')
@section('page-title', 'Startup API Test')

@section('content')
<div class="container">

    <!-- Success & Error Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <h3 class="text-center" style="color: #2B37A0;">Startup API Test</h3>

    <!-- Flexbox to Arrange Table and JSON Side-by-Side -->
    <div class="d-flex flex-wrap justify-content-between">
        <!-- Startup Details Table -->
        <div class="table-container" style="overflow-x: auto; border-radius: 25px;">
            <table class="table" style="background-color: white; border-radius: 25px;">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>ID</strong></td><td>{{ $startup->id }}</td></tr>
                    <tr><td><strong>Name</strong></td><td>{{ $startup->name }}</td></tr>
                    <tr><td><strong>Email</strong></td><td>{{ $startup->email }}</td></tr>
                    <tr><td><strong>Phone</strong></td><td>{{ $startup->phone_number }}</td></tr>
                    <tr><td><strong>Company</strong></td><td>{{ $startup->company }}</td></tr>
                    <tr><td><strong>Website</strong></td><td>{{ $startup->website }}</td></tr>
                    <tr><td><strong>Product/Service Description</strong></td><td>{{ $startup->product_service_description }}</td></tr>
                    <tr><td><strong>Company Sector</strong></td><td>{{ optional($startup->companySector)->name }}</td></tr>
                    <tr><td><strong>Operational Phase</strong></td><td>{{ optional($startup->operationalPhase)->name }}</td></tr>
                    <tr><td><strong>Problem Solved</strong></td><td>{{ $startup->problem_solved }}</td></tr>
                    <tr><td><strong>Funding Amount</strong></td><td>{{ optional($startup->fundingAmount)->name }}</td></tr>
                    <tr><td><strong>Funding Used</strong></td><td>{{ $startup->funding_used }}</td></tr>
                    <tr><td><strong>Previous Funding Source</strong></td><td>{{ optional($startup->previousFundingSource)->name }}</td></tr>
                    <tr><td><strong>Target Market</strong></td><td>{{ optional($startup->targetMarket)->name }}</td></tr>
                    <tr><td><strong>Joint Investment</strong></td><td>{{ $startup->joint_invest ? 'Yes' : 'No' }}</td></tr>
                    <tr><td><strong>Existing Partners</strong></td><td>{{ $startup->existing_partners ? 'Yes' : 'No' }}</td></tr>
                    <tr><td><strong>Monthly Revenue</strong></td><td>{{ $startup->monthly_revenue }}</td></tr>
                    <tr><td><strong>Is Profitable</strong></td><td>{{ $startup->is_profitable ? 'Yes' : 'No' }}</td></tr>
                    <tr><td><strong>Revenue Growth</strong></td><td>{{ $startup->revenue_growth }}</td></tr>
                    <tr><td><strong>Revenue Goal</strong></td><td>{{ $startup->revenue_goal }}</td></tr>
                    <tr><td><strong>Have Debts</strong></td><td>{{ $startup->have_debts ? 'Yes' : 'No' }}</td></tr>
                    <tr><td><strong>Debt Amount</strong></td><td>{{ $startup->debt_amount }}</td></tr>
                    <tr><td><strong>Break-even Point</strong></td><td>{{ $startup->break_even_point }}</td></tr>
                    <tr><td><strong>Financial Goal</strong></td><td>{{ $startup->financial_goal }}</td></tr>
                    <tr><td><strong>Has Exit Strategy</strong></td><td>{{ $startup->has_exit_strategy ? 'Yes' : 'No' }}</td></tr>
                    <tr><td><strong>Exit Strategy Details</strong></td><td>{{ $startup->exit_strategy_details }}</td></tr>
                </tbody>
            </table>
        </div>

        <!-- JSON Box -->
        <div class="json-container">
            <h5 style="color: #2B37A0;">JSON Data for AI</h5>
            <pre>{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>

    <!-- Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <form action="{{ route('startup.api.test.send', $startup->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Send to AI</button>
        </form>
        <a href="{{ route('startups') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<script>
    var jsonData = {!! json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!};

    console.log("JSON Sent to AI:\n" + JSON.stringify(jsonData, null, 2));
</script>


<!-- Styles -->
<style>
    .table-container {
        flex: 1;
        overflow-x: auto;
    }

    .json-container {
        flex: 1;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 10px;
        overflow: auto;
        max-height: 945px;
        font-size: 18px;
        color: #2B37A0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .table th, .table td {
        text-align: left;
        color: #2B37A0;
        padding: 8px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 50px;
        transition: 0.3s;
    }
</style>
@endsection
