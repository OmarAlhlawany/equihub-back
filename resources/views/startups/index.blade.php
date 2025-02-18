@extends('layouts.app')
@section('page-title', 'Startups')

@section('content')
<div class="container">

    <!-- Search Form (Below Header) -->
    <div class="d-flex justify-content-center mb-4">
        <form action="{{ route('startups') }}" method="GET" class="d-flex" style="gap: 10px;">
            <!-- Dropdown Filter -->
            <select name="search_field" id="searchField" class="form-control"
            style="width: 180px; height: 40px; padding: 5px 10px; font-size: 16px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0; transition: background-color 0.3s, color 0.3s;"
            onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';"
            onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';"
            onchange="toggleSearchInput()">
            <option value="" selected>Search With</option>
            <option value="name" {{ request('search_field') == 'name' ? 'selected' : '' }}>Name</option>
            <option value="email" {{ request('search_field') == 'email' ? 'selected' : '' }}>Email</option>
            <option value="phone_number" {{ request('search_field') == 'phone_number' ? 'selected' : '' }}>Phone</option>
            <option value="company" {{ request('search_field') == 'company' ? 'selected' : '' }}>Company</option>
            </select>

            <!-- Search Input -->
            <input type="text" name="search_value" id="searchInput" class="form-control" placeholder="Search here..."
            value="{{ request('search_value') }}" disabled
            style="width: 250px; border-radius: 50px; border: 1px solid #2B37A0; color: #2B37A0; background-color: #f0f0f0; cursor: not-allowed;">

            <!-- Search Button -->
            <button type="submit" id="searchBtn" class="btn btn-primary" disabled
            style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0; transition: background-color 0.3s, color 0.3s; cursor: not-allowed;"
            onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';"
            onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';">
            Search
            </button>

            <!-- Reset Button (Reload Page) -->
            <button type="button" class="btn btn-secondary" onclick="resetSearch()"
            style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0; transition: background-color 0.3s, color 0.3s;"
            onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';"
            onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';">
            Reset
            </button>
        </form>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Startups Table -->
    <div class="table-container" style="overflow-x: auto; height: auto; border-radius: 25px;">
        <table class="table" style="background-color: white; border-radius: 25px;">
            <thead>
                <tr>
                    <th style="color: #2B37A0; text-align: center;">ID</th>
                    <th style="color: #2B37A0; text-align: center;">Name</th>
                    <th style="color: #2B37A0; text-align: center;">Email</th>
                    <th style="color: #2B37A0; text-align: center;">Phone</th>
                    <th style="color: #2B37A0; text-align: center;">Company</th>
                    <th style="color: #2B37A0; text-align: center;">
                        <div style="display: flex; justify-content: space-between; align-items: center; ">
                            <span>Actions</span>
                            <a href="{{ route('startups.create') }}" class="btn btn-primary" 
                            style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';">
                                Add Startup
                            </a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($startups as $startup)
                    <tr>
                        <td style="color: #2B37A0; text-align: center">{{ $startup->id }}</td>
                        <td style="color: #2B37A0; text-align: center">{{ $startup->name }}</td>
                        <td style="color: #2B37A0; text-align: center">{{ $startup->email }}</td>
                        <td style="color: #2B37A0; text-align: center">{{ $startup->phone_number }}</td>
                        <td style="color: #2B37A0; text-align: center">{{ $startup->company }}</td>
                        <td style="color: #2B37A0; text-align: center">
                            <!-- View button -->
                            <a href="{{ route('startups.show', $startup->id) }}" class="btn btn-info btn-sm" style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';">
                                View
                            </a>
                            <!-- Edit button -->
                            <a href="{{ route('startups.edit', $startup->id) }}" class="btn btn-warning btn-sm" style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" onmouseout="this.style.backgroundColor='white'; this.style.color='#000000';">
                                Edit
                            </a>
                            <!-- Delete button with SweetAlert confirmation -->
                            <button class="btn btn-danger btn-sm" style="padding: 5px 10px; font-size: 14px; background-color:transparent; color: #000000; border: 0px" onclick="confirmDelete({{ $startup->id }})">
                                <i class="fas fa-trash-alt" style="color: #2B37A0; font-size: 25px; transition: color 0.3s;" onmouseover="this.style.color='red';" onmouseout="this.style.color='#2B37A0';"></i>
                            </button>
                            <form action="{{ route('startup.api.test', $startup->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary"
                                    style="padding: 5px 20px; font-size: 16px;  margin-top: 10px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0;">
                                    Send to AI
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3" style="background-color: white; border-radius: 25px; height: 70px; padding-top: 10px; padding-bottom: 10px;">
        {{ $startups->links('pagination::bootstrap-4') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(startupId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('<form method="POST" action="/startups/' + startupId + '"></form>');
                form.append('@csrf');
                form.append('@method("DELETE")');
                form.appendTo('body').submit();
            }
        });
    }
    function toggleSearchInput() {
        var searchField = document.getElementById("searchField");
        var searchInput = document.getElementById("searchInput");
        var searchBtn = document.getElementById("searchBtn");

        if (searchField.value) {
            searchInput.disabled = false;
            searchInput.style.backgroundColor = "white";
            searchInput.style.cursor = "text";
            searchBtn.disabled = false;
            searchBtn.style.cursor = "pointer";
        } else {
            searchInput.disabled = true;
            searchInput.style.backgroundColor = "#f0f0f0";
            searchInput.style.cursor = "not-allowed";
            searchBtn.disabled = true;
            searchBtn.style.cursor = "not-allowed";
        }
    }


    function resetSearch() {
        window.location.href = "{{ url('startups') }}"; // Reload without search queries
    }
</script>

<style>
    /* Improve pagination appearance */
    .pagination {
            justify-content: center;
            margin-top: 0px;
            background-color: white ;
            padding: 5px 10px;
        }      
    
    .pagination .page-item {
        margin: 0 5px;
        }

    .pagination .page-link {
        padding: 8px 16px;
        border-radius: 4px;
        }

    .pagination .page-link:hover {
        background-color: #007bff;
        color: white;
    }
</style>
@endsection
