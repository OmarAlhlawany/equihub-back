@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">AI Response for Investor: {{ $investor->name }}</h1>

    <!-- AI Response Card -->
    <div class="mb-4 shadow-lg card">
        <div class="card-body">
            <h5 class="card-title">AI Generated Response</h5>

            @if($responseData)
                <div class="json-container">
                    <h6>Full Prompt:</h6>
                    <pre>{{ $responseData['full_prompt'] ?? 'No full prompt available' }}</pre>
                </div>
            @else
                <p>No AI response found for this investor.</p>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <!-- Back to Investor Overview -->
        <a href="{{ route('investor.api.test', $investor->id) }}" class="btn btn-secondary">Back to Investor Overview</a>
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
</style>
