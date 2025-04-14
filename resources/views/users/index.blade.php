@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="text-left " style="color: #374151;
                    font-size: 36px;
                    font-weight: 500;">Accounts</h1>
            <p class="text-left" style="color: #9CA3AF;
                    font-size: 21px;
                    font-weight: 400;">Here you can find the List of accounts.</p>
        </div>

        <!-- User Table -->
        <div class="table-container" style="overflow-x: auto; 
                        max-height: 500px; 
                        border-radius: 10px; 
                        background-color: white; 
                        border: 0.91px  #E5E7EB; 
                        padding: 10px;
                        border: 1px solid #E5E7EB;">
            <div class="d-flex justify-content-between align-items-center mb-3"">
                                <text class=" m-0" style="color: #374151;
                                text-align: center;
                                font-size: 21px;
                                font-weight: 600;">Accounts</text>
                <a href="{{ route('users.create') }}" class="btn btn-primary" style="padding: 5px 10px; 
                                border-radius: 10px; 
                                background-color: #134DF4; 
                                color: white;
                                width: 160px;
                                height: 40px;
                                text-align: center;">
                    <i class="fas fa-plus"></i> Add Account
                </a>
            </div>
            <table class="table custom-table"
                style="background-color: white; border-collapse: separate; border-spacing: 0;">
                <thead style="height: 55px; 
                            background-color: #F2F7FD; 
                            overflow: hidden; 
                            border-bottom: none !important;">
                    <tr style="border-bottom: none !important;">
                        <th style="color: #9CA3AF; 
                                    background-color: #F2F7FD; 
                                    text-align: center; 
                                    vertical-align: middle; 
                                    border-left: 1px solid #E5E7EB; 
                                    border-top: 1px solid #E5E7EB; 
                                    border-radius: 10px 0 0 10px;">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                style="color: #9CA3AF; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                ID
                                <span style="margin-left: 5px;">
                                    @if(request('sort') === 'id')
                                        @if(request('direction') === 'asc')
                                            <i class="fas fa-sort-up" style="color: #374151;"></i>
                                        @else
                                            <i class="fas fa-sort-down" style="color: #374151;"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort" style="color: #9CA3AF;"></i>
                                    @endif
                                </span>
                            </a>
                        </th>
                        <th style="color: #9CA3AF; 
                                    background-color: #F2F7FD; 
                                    text-align: center; 
                                    vertical-align: middle; 
                                    border-top: 1px solid #E5E7EB;
                                    ">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                style="color: #9CA3AF; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                Name
                                <span style="margin-left: 5px;">
                                    @if(request('sort') === 'name')
                                        @if(request('direction') === 'asc')
                                            <i class="fas fa-sort-up" style="color: #374151;"></i>
                                        @else
                                            <i class="fas fa-sort-down" style="color: #374151;"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort" style="color: #9CA3AF;"></i>
                                    @endif
                                </span>
                            </a>
                        </th>
                        <th style="color: #9CA3AF; 
                                    background-color: #F2F7FD; 
                                    text-align: center; 
                                    vertical-align: middle; 
                                    border-top: 1px solid #E5E7EB;
                                    ">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                style="color: #9CA3AF; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                Email
                                <span style="margin-left: 5px;">
                                    @if(request('sort') === 'email')
                                        @if(request('direction') === 'asc')
                                            <i class="fas fa-sort-up" style="color: #374151;"></i>
                                        @else
                                            <i class="fas fa-sort-down" style="color: #374151;"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort" style="color: #9CA3AF;"></i>
                                    @endif
                                </span>
                            </a>
                        </th>
                        <th style="color: #9CA3AF; 
                                    background-color: #F2F7FD; 
                                    text-align: center; 
                                    vertical-align: middle; 
                                    border-top: 1px solid #E5E7EB;
                                    ">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'phone', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                style="color: #9CA3AF; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                Phone
                                <span style="margin-left: 5px;">
                                    @if(request('sort') === 'phone')
                                        @if(request('direction') === 'asc')
                                            <i class="fas fa-sort-up" style="color: #374151;"></i>
                                        @else
                                            <i class="fas fa-sort-down" style="color: #374151;"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort" style="color: #9CA3AF;"></i>
                                    @endif
                                </span>
                            </a>
                        </th>
                        <th style="color: #9CA3AF; 
                                    background-color: #F2F7FD; 
                                    text-align: center; 
                                    vertical-align: middle; 
                                    border-right: 1px solid #E5E7EB; 
                                    border-top: 1px solid #E5E7EB; 
                                    border-radius: 0 10px 10px 0;
                                    ">Actions</th>
                    </tr>
                </thead>
                <tbody style="height: 55px; 
                            justify-content: center; 
                            align-items: center;">
                    @foreach($users as $user)
                        <tr style="border-bottom: 0.5px solid #E5E7EB;">
                            <td style="text-align: center; 
                                                    color: #374151; 
                                                    vertical-align: middle;
                                                    ">{{ $user->id }}</td>
                            <td style="text-align: center; 
                                                    color: #374151; 
                                                    vertical-align: middle;
                                                    ">{{ $user->name }}</td>
                            <td style="text-align: center; 
                                                    color: #374151; 
                                                    vertical-align: middle;
                                                    ">{{ $user->email }}</td>
                            <td style="text-align: center; 
                                                    color: #374151; 
                                                    vertical-align: middle;
                                                    ">{{ $user->phone }}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                <!-- Delete button -->
                                <button class="btn btn-sm"
                                    style="background-color: #E5E7EB; border: 1px solid #E5E7EB; color: #374151;"
                                    onclick="confirmDelete({{ $user->id }})">
                                    <img src="{{ asset('images/trash-delete.svg') }}" alt="Delete"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#374151';" onmouseout="this.style.color='#6B7280';">
                                </button>

                                <!-- Edit button with pencil icon -->
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;">
                                    <img src="{{ asset('images/pencil-edit.svg') }}" alt="Edit"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#6B7280';">
                                </a>

                                <!-- View button with eye icon -->
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;">
                                    <img src="{{ asset('images/eye-view.svg') }}" alt="View"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#6B7280';">
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        window.confirmDelete = function (userId) {
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
                    var form = $('<form method="POST" action="/users/' + userId + '"></form>');
                    form.append('@csrf');
                    form.append('@method("DELETE")');
                    form.appendTo('body').submit();
                }
            });
        };
    });
</script>

<style>
    .pagination {
        justify-content: center;
        margin-top: 0px;
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

    /* Custom table styling */
    .custom-table thead th {
        border-top: 1px solid #E5E7EB !important;
    }

    .custom-table tbody tr {
        border-bottom: 0.5px solid #E5E7EB;
    }

    /* Remove border from first and last rows */
    .custom-table tbody tr:first-child {
        border-top: none !important;
    }

    /* Fix for potential Bootstrap interference */
    .custom-table td,
    .custom-table th {
        border-top: none !important;
    }
</style>