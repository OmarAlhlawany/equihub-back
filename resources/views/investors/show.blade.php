@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4" style="color: #2B37A0; font-weight: bold;">Investor Details</h2>

    <div class="card shadow-lg" style="max-width: 800px; margin: auto; border-radius: 15px;">
        <div class="card-body">
            <h5 class="card-title" style="color: #2B37A0; font-weight: bold; font-size: 24px;">{{ $investor->name }}</h5>
            <hr>
            <p class="card-text" style="color: #333; font-size: 16px;">
                <strong>Email:</strong> {{ $investor->email }} <br>
                <strong>Phone:</strong> {{ $investor->phone_number }} <br>
                <strong>Company:</strong> {{ $investor->company }} <br>
                
                <strong>Investment Type:</strong> {{ $investor->investmentType->name ?? 'N/A' }} <br>
                <strong>Favourite Investment Stage:</strong> {{ $investor->favouriteInvestmentStage->name ?? 'N/A' }} <br>
                
                <strong>Favourite Sectors:</strong> 
                <ul style="margin-top: 5px; padding-left: 20px;">
                    @forelse ($investor->favouriteSectors as $sector)
                        <li>{{ $sector->name }}</li>
                    @empty
                        <li>N/A</li>
                    @endforelse
                </ul>

                <strong>Budget:</strong> {{ $investor->budgetRange->name ?? 'N/A' }} <br>
                @if($investor->budget_range_id == 'other')
                    <strong>Other Budget:</strong> ${{ number_format($investor->other_budget, 2) }} <br>
                @endif
                
                <strong>Geographical Scope:</strong> {{ $investor->geographicalScope->name ?? 'N/A' }} <br>
                <strong>Co-Investment:</strong> {{ $investor->coInvest->name ?? 'N/A' }} <br>
                <strong>Investment Privacy:</strong> {{ $investor->investmentPrivacyOption->name ?? 'N/A' }} <br>
                
                <strong>Additional Notes:</strong> {{ $investor->additional_notes ?? 'No additional notes' }} <br>
            </p>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('investors.edit', $investor->id) }}" class="btn btn-warning"
                   style="height: 40px; padding: 5px 15px; font-size: 16px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000; transition: 0.3s;" 
                   onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" 
                   onmouseout="this.style.backgroundColor='white'; this.style.color='#000000';">
                    Edit
                </a>

                <form action="{{ route('investors.destroy', $investor->id) }}" method="POST" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $investor->id }})"
                        style="height: 40px; padding: 5px 15px; font-size: 16px; border-radius: 50px; background-color: white; color: #d9534f; border: 1px solid #d9534f; transition: 0.3s;" 
                        onmouseover="this.style.backgroundColor='#d9534f'; this.style.color='white';" 
                        onmouseout="this.style.backgroundColor='white'; this.style.color='#d9534f';">
                        Delete
                    </button>
                </form>

                <a href="{{ route('investors') }}" class="btn"
                   style="height: 40px; padding: 5px 15px; font-size: 16px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000; transition: 0.3s;" 
                   onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" 
                   onmouseout="this.style.backgroundColor='white'; this.style.color='#000000';">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(investorId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>

@endsection
