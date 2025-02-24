@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Investor Overview</h1>

    <!-- Investor Details Card -->
    <div class="mb-4 shadow-lg card">
        <div class="card-body">
            <h5 class="card-title">Investor Information</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name:</strong> {{ $investor->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $investor->email }}</li>
                <li class="list-group-item"><strong>Phone:</strong> {{ $investor->phone_number }}</li>
                <li class="list-group-item"><strong>Company:</strong> {{ $investor->company }}</li>
                <li class="list-group-item"><strong>Investment Type:</strong> {{ $investor->investmentType->name }}</li>
                <li class="list-group-item"><strong>Favourite Investment Stage:</strong> {{ $investor->favouriteInvestmentStage->name }}</li>
                <li class="list-group-item"><strong>Budget Range:</strong> {{ $investor->budgetRange->name }}</li>
                <li class="list-group-item"><strong>Geographical Scope:</strong> {{ $investor->geographicalScope->name }}</li>
                <li class="list-group-item"><strong>Co-Invest:</strong> {{ $investor->coInvest->name }}</li>
                <li class="list-group-item"><strong>Investment Privacy Option:</strong> {{ $investor->investmentPrivacyOption->name }}</li>
                <li class="list-group-item"><strong>Favourite Sectors:</strong> {{ implode(', ', $investor->favouriteSectors->pluck('name')->toArray()) }}</li>
                <li class="list-group-item"><strong>Additional Notes:</strong> {{ $investor->additional_notes ?? 'No additional notes' }}</li>
                <li class="list-group-item"><strong>Created At:</strong> {{ $investor->created_at->format('Y-m-d H:i:s') }}</li>
            </ul>
        </div>
    </div>
{{-- 
    <!-- AI Response Card -->
    @if(session('api_response') || $aiResponse)
        <div class="mb-4 shadow-lg card">
            <div class="card-body">
                <h5 class="card-title">AI Generated Response</h5>
                <pre class="json-container">
                    {{ json_encode(session('api_response') ?? $aiResponse->response_data, JSON_PRETTY_PRINT) }}
                </pre>
            </div>
        </div>
    @endif --}}

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between">
        <form action="{{ route('investor.api.test.send', $investor->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Send Data to AI</button>
        </form>

        <!-- Back to Index Button -->
        <a href="{{ route('investors') }}" class="btn btn-secondary">Back to Investors List</a>

        <!-- View Response Button -->
        @if($aiResponse)
            <a href="{{ route('investor.response.view', $investor->id) }}" class="btn btn-success">View Response</a>
        @endif
    </div>
</div>
@endsection

<!-- Styles -->
<style>
    .json-container {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 10px;
        font-size: 16px;
        color: #2B37A0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
    }
    .btn {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 50px;
        background-color: #6c63ff;
        border: none;
        color: white;
        transition: all 0.3s ease-in-out;
    }
    .btn:hover {
        background-color: #4e47d1;
    }
    .list-group-item {
        font-size: 16px;
        color: #333;
    }
    .list-group-item strong {
        color: #007bff;
    }
</style>
