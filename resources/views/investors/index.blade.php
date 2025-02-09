@extends('layouts.app')
@section('page-title', 'Investors')

@section('content')
<div class="container">

    <!-- Search Form -->
    <div class="d-flex justify-content-center mb-4">
        <form action="{{ route('investors') }}" method="GET" class="d-flex" style="gap: 10px;">
            <select name="search_field" id="searchField" class="form-control"
                style="width: 180px; padding: 5px 10px; font-size: 16px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0;"
                onchange="toggleSearchInput()">
                <option value="" selected>Search With</option>
                <option value="name" {{ request('search_field') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="email" {{ request('search_field') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="phone_number" {{ request('search_field') == 'phone_number' ? 'selected' : '' }}>Phone</option>
                <option value="company" {{ request('search_field') == 'company' ? 'selected' : '' }}>Company</option>
            </select>

            <input type="text" name="search_value" id="searchInput" class="form-control"
                placeholder="Search here..." value="{{ request('search_value') }}" disabled
                style="width: 250px; border-radius: 50px; border: 1px solid #2B37A0; color: #2B37A0;">

            <button type="submit" id="searchBtn" class="btn btn-primary" disabled
                style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0;">
                Search
            </button>

            <button type="button" class="btn btn-secondary" onclick="resetSearch()"
                style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0;">
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

    <!-- Investors Table -->
    <div class="table-container" style="overflow-x: auto; border-radius: 25px;">
        <table class="table" style="background-color: white; border-radius: 25px;">
            <thead>
                <tr>
                    <th style="color: #2B37A0; text-align: center;">ID</th>
                    <th style="color: #2B37A0; text-align: center;">Name</th>
                    <th style="color: #2B37A0; text-align: center;">Email</th>
                    <th style="color: #2B37A0; text-align: center;">Phone</th>
                    <th style="color: #2B37A0; text-align: center;">Company</th>
                    <th style="color: #2B37A0; text-align: center;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Actions</span>
                            <a href="{{ route('investors.create') }}" class="btn btn-primary"
                                style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0;">
                                Add Investor
                            </a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($investors as $investor)
                <tr>
                    <td style="text-align: center">{{ $investor->id }}</td>
                    <td style="text-align: center">{{ $investor->name }}</td>
                    <td style="text-align: center">{{ $investor->email }}</td>
                    <td style="text-align: center">{{ $investor->phone_number }}</td>
                    <td style="text-align: center">{{ $investor->company }}</td>
                    <td style="text-align: center">
                        <a href="{{ route('investors.show', $investor->id) }}" class="btn btn-info btn-sm"
                            style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0;">
                            View
                        </a>
                        <a href="{{ route('investors.edit', $investor->id) }}" class="btn btn-warning btn-sm"
                            style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000;">
                            Edit
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $investor->id }})"
                            style="padding: 5px 10px; font-size: 14px; background-color: transparent; color: #000000; border: 0px">
                            <i class="fas fa-trash-alt" style="color: #2B37A0; font-size: 25px;"
                                onmouseover="this.style.color='red';" onmouseout="this.style.color='#2B37A0';"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3" style="background-color: white; border-radius: 25px; height: 70px; padding-top: 10px; padding-bottom: 10px;">
        {{ $investors->links('pagination::bootstrap-4') }}
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
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('<form method="POST" action="/investors/' + investorId + '"></form>');
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
            searchBtn.disabled = false;
        } else {
            searchInput.disabled = true;
            searchInput.style.backgroundColor = "#f0f0f0";
            searchBtn.disabled = true;
        }
    }

    function resetSearch() {
        window.location.href = "{{ url('investors') }}"; 
    }
</script>

<style>
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
