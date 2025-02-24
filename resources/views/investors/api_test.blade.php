@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Investor Overview</h1>

    <!-- Investor Details Card -->
    <div class="card mb-4 shadow-lg">
        <div class="card-body">
            <h5 class="card-title">Investor Information</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name:</strong> Dr. Woodrow Greenfelder Sr.</li>
                <li class="list-group-item"><strong>Email:</strong> fahey.kristoffer@example.org</li>
                <li class="list-group-item"><strong>Phone:</strong> +971832371426</li>
                <li class="list-group-item"><strong>Company:</strong> Bernhard-Schimmel</li>
                <li class="list-group-item"><strong>Investment Type:</strong> Angel Investment</li>
                <li class="list-group-item"><strong>Favourite Investment Stage:</strong> Pre-Seed</li>
                <li class="list-group-item"><strong>Budget Range:</strong> $100K to $500K</li>
                <li class="list-group-item"><strong>Geographical Scope:</strong> Regional</li>
                <li class="list-group-item"><strong>Co-Invest:</strong> Yes</li>
                <li class="list-group-item"><strong>Investment Privacy Option:</strong> Keep my investments private</li>
                <li class="list-group-item"><strong>Favourite Sectors:</strong> General Trade, Gaming, Healthcare & HealthTech, Social Innovation, Sports & Entertainment</li>
            </ul>
        </div>
    </div>

    

    <!-- AI Response Card -->
    @if(session('api_response'))
        <div class="card mb-4 shadow-lg">
            <div class="card-body">
                <h5 class="card-title">AI Generated Response</h5>
                <pre class="json-container">{{ print_r(session('api_response'), true) }}</pre>
            </div>
        </div>
    @endif

    <!-- Send Data Button -->
    <form action="{{ route('investor.api.test.send', $investor->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Send Data to AI</button>
    </form>
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
        color: #5a5a5a;
    }
</style>
