@extends('layouts.app')
@section('page-title', 'Investor API Test')

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

    <h3 class="text-center" style="color: #2B37A0;">Investor API Test</h3>

    <!-- Flexbox to Arrange Table and JSON Side-by-Side -->
    <div class="d-flex flex-wrap justify-content-between">
        <!-- Investor Details Table -->
        <div class="table-container" style="overflow-x: auto; border-radius: 25px;">
            <table class="table" style="background-color: white; border-radius: 25px;">
                    <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>ID</strong></td><td>{{ $investor->id }}</td></tr>
                    <tr><td><strong>Name</strong></td><td>{{ $investor->name }}</td></tr>
                    <tr><td><strong>Email</strong></td><td>{{ $investor->email }}</td></tr>
                    <tr><td><strong>Phone</strong></td><td>{{ $investor->phone_number }}</td></tr>
                    <tr><td><strong>Company</strong></td><td>{{ $investor->company }}</td></tr>
                    <tr><td><strong>Investment Type</strong></td><td>{{ optional($investor->investmentType)->name }}</td></tr>
                    <tr><td><strong>Favourite Investment Stage</strong></td><td>{{ optional($investor->favouriteInvestmentStage)->name }}</td></tr>
                    <tr><td><strong>Budget Range</strong></td><td>{{ optional($investor->budgetRange)->name ?? 'N/A' }}</td></tr>
                    <tr><td><strong>Geographical Scope</strong></td><td>{{ optional($investor->geographicalScope)->name }}</td></tr>
                    <tr><td><strong>Co-Invest</strong></td><td>{{ optional($investor->coInvest)->name ?? 'N/A' }}</td></tr>
                    <tr><td><strong>Investment Privacy Option</strong></td><td>{{ optional($investor->investmentPrivacyOption)->name ?? 'N/A' }}</td></tr>
                    <tr><td><strong>Favourite Sectors</strong></td><td>{{ implode(', ', $investor->favouriteSectors->pluck('name')->toArray()) }}</td></tr>
                    <tr><td><strong>Additional Notes</strong></td><td>{{ $investor->additional_notes }}</td></tr>
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
        <form action="{{ route('investor.api.test.send', $investor->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Send to AI</button>
        </form>
        <a href="{{ route('investors') }}" class="btn btn-secondary">Back to List</a>
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
        max-height: 650px;
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
