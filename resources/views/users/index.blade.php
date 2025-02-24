@extends('layouts.app')
@section('page-title', 'Accounts')

@section('content')
<div class="container">

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- User Table -->
    <div class="table-container" style="overflow-x: auto; max-height: 500px;  border-radius: 25px;">
        <table class="table  " style="background-color: white; border-radius: 25px; ">
            <thead>
                <tr>
                    <th style="color: #2B37A0; text-align: center;">ID</th>
                    <th style="color: #2B37A0; text-align: center;">Name</th>
                    <th style="color: #2B37A0; text-align: center;">Email</th>
                    <th style="color: #2B37A0; text-align: center;">Phone</th>
                    <th style="color: #2B37A0; text-align: center;">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <span>Actions</span>
                            <a href="{{ route('users.create') }}" class="btn btn-primary" 
                            style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: #2B37A0; color: white;">
                                Add Account
                            </a>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td style="text-align: center">{{ $user->id }}</td>
                        <td style="text-align: center">{{ $user->name }}</td>
                        <td style="text-align: center">{{ $user->email }}</td>
                        <td style="text-align: center">{{ $user->phone }}</td>
                        <td style="text-align: center">
                            <!-- View button with text -->
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm" style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #2B37A0; border: 1px solid #2B37A0; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';">
                                View
                            </a>
                            <!-- Edit button with text -->
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" style="padding: 5px 10px; font-size: 14px; border-radius: 50px; background-color: white; color: #000000; border: 1px solid #000000; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';" onmouseout="this.style.backgroundColor='white'; this.style.color='#000000';">
                                Edit
                            </a>
                            <!-- Delete button with SweetAlert confirmation -->
                            <button class="btn btn-danger btn-sm" style ="padding: 5px 10px; font-size: 14px;   background-color:transparent; color: #000000; border: 0px " onclick="confirmDelete({{ $user->id }})">
                                <i class="fas fa-trash-alt " style="color: #2B37A0; font-size: 25px; transition: color 0.3s;" onmouseover="this.style.color='red';" onmouseout="this.style.color='#2B37A0';"></i>
                            </button>
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
    // Use $(document).ready to ensure the script runs after the DOM is ready
    $(document).ready(function() {
        // Use SweetAlert for the delete confirmation
        window.confirmDelete = function(userId) {
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
                    // Redirect to the delete route using a form submit
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


 /* Improve pagination appearance */
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

</style>
