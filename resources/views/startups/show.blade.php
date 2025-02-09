@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Startup Details</h2>

    <div class="card" style="max-width: 800px; margin: auto;">
        <div class="card-body">
            <h5 class="card-title" style="color: #2B37A0; font-weight: bold;">{{ $startup->name }}</h5>
            <p class="card-text" style="color: #333;">
                <strong>Email:</strong> {{ $startup->email }} <br>
                <strong>Phone:</strong> {{ $startup->phone_number }} <br>
                <strong>Company:</strong> {{ $startup->company }} <br>
                <strong>Website:</strong> <a href="{{ $startup->website }}" target="_blank">{{ $startup->website }}</a> <br>
                <strong>Product/Service Description:</strong> {{ $startup->product_service_description }} <br>
                <strong>Company Sector:</strong> {{ $startup->companySector->name ?? 'N/A' }} <br>
                <strong>Operational Phase:</strong> {{ $startup->operationalPhase->name ?? 'N/A' }} <br>
                <strong>Problem Solved:</strong> {{ $startup->problem_solved }} <br>
                <strong>Funding Amount:</strong> {{ $startup->fundingAmount->name ?? 'N/A' }} <br>
                <strong>Funding Used:</strong> {{ $startup->funding_used }} <br>
                <strong>Previous Funding Source:</strong> {{ $startup->previousFundingSource->name ?? 'N/A' }} <br>
                <strong>Target Market:</strong> {{ $startup->targetMarket->name ?? 'N/A' }} <br>
                <strong>Joint Investment:</strong> {{ $startup->jointInvestment->name ?? 'N/A' }} <br>
                <strong>Existing Partners:</strong> {{ $startup->existingPartners->name ?? 'N/A' }} <br>
                <strong>Monthly Revenue:</strong> {{ number_format($startup->monthly_revenue, 2) }} <br>
                <strong>Is Profitable:</strong> {{ $startup->isProfitable->name ?? 'N/A' }} <br>
                <strong>Revenue Growth:</strong> {{ $startup->revenue_growth }}% <br>
                <strong>Revenue Goal:</strong> {{ number_format($startup->revenue_goal, 2) }} <br>
                <strong>Have Debts:</strong> {{ $startup->haveDebts->name ?? 'N/A' }} <br>
                @if(optional($startup->haveDebts)->name == 'Yes')
                    <strong>Debt Amount:</strong> {{ number_format($startup->debt_amount, 2) }} <br>
                @endif
                <strong>Break-even Point:</strong> {{ $startup->break_even_point }} <br>
                <strong>Financial Goal:</strong> {{ $startup->financial_goal }} <br>
                <strong>Has Exit Strategy:</strong> {{ $startup->hasExitStrategy->name ?? 'N/A' }} <br>
                @if(optional($startup->hasExitStrategy)->name == 'Yes')
                    <strong>Exit Strategy Details:</strong> {{ $startup->exit_strategy_details }} <br>
                @endif
            </p>

            <a href="{{ route('startups.edit', $startup->id) }}" class="btn btn-warning"
                style="height: 35px; width: 100px; padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000; transition: background-color 0.3s, color 0.3s;"
                onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='white'; this.style.color='#000000';">
                Edit
            </a>
            <a href="{{ route('startups') }}" class="btn"
                style="height: 35px; width: 100px; padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000; transition: background-color 0.3s, color 0.3s;"
                onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';"
                onmouseout="this.style.backgroundColor='white'; this.style.color='#000000';">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection
