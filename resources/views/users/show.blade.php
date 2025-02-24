@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card" style="max-width: 800px; margin: auto;">
        <div class="card-body">
            <h5 class="card-title" style="color: #2B37A0;  font-weight: bold;">{{ $user->name }}</h5>
            <p class="card-text" style="color: #333;">
                <strong>Email:</strong> {{ $user->email }} <br>
                <strong>Phone:</strong> {{ $user->phone }} <br>
            </p>
            
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning" 
                style="height: 35px; width: 100px; padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" onmouseout="this.style.backgroundColor='white'; this.style.color='#000000';">
                Edit
            </a>
            <a href="{{ route('users') }}" class="btn btn-secondary" style="height: 35px; width: 100px; padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" onmouseout="this.style.backgroundColor='white'; this.style.color='#000000';">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection
