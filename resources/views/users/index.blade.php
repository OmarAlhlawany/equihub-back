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
                <button type="button" class="btn btn-primary create-user" style="padding: 5px 10px; 
                                                            border-radius: 10px; 
                                                            background-color: #134DF4; 
                                                            color: white;
                                                            width: 160px;
                                                            height: 40px;
                                                            text-align: center;">
                    <i class="fas fa-plus"></i> Add Account
                </button>
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
                                                                                                            ">{{ $user->id }}
                            </td>
                            <td style="text-align: center; 
                                                                                                            color: #374151; 
                                                                                                            vertical-align: middle;
                                                                                                            ">{{ $user->name }}
                            </td>
                            <td style="text-align: center; 
                                                                                                            color: #374151; 
                                                                                                            vertical-align: middle;
                                                                                                            ">
                                {{ $user->email }}</td>
                            <td style="text-align: center; 
                                                                                                            color: #374151; 
                                                                                                            vertical-align: middle;
                                                                                                            ">
                                {{ $user->phone }}</td>
                            <td style="text-align: center; vertical-align: middle;">
                                <!-- Delete button -->
                                <button class="btn btn-sm"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;"
                                    onclick="confirmDelete({{ $user->id }})">
                                    <img src="{{ asset('images/trash-delete.svg') }}" alt="Delete"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#6B7280';">
                                </button>

                                <!-- Edit button with pencil icon -->
                                <button class="btn btn-sm edit-user" data-user-id="{{ $user->id }}"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;">
                                    <img src="{{ asset('images/pencil-edit.svg') }}" alt="Edit"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#6B7280';">
                                </button>

                                <!-- View button with eye icon -->
                                <button class="btn btn-sm show-user" data-user-id="{{ $user->id }}"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;">
                                    <img src="{{ asset('images/eye-view.svg') }}" alt="View"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#6B7280';">
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

        <!-- Dynamic Modal Container -->
        <div id="dynamicModalContainer"></div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Ensure DOM is fully loaded and scripts are initialized
        $(document).ready(function () {
            // Utility function to close modal
            function closeModal(modalId) {
                const modal = $(`#${modalId}`);

                // Try jQuery method
                try {
                    modal.modal('hide');
                } catch (error1) {
                    try {
                        // Vanilla JS fallback
                        const modalElement = document.getElementById(modalId);
                        if (modalElement) {
                            modalElement.classList.remove('show');
                            modalElement.style.display = 'none';

                            // Remove backdrop
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) {
                                backdrop.remove();
                            }

                            // Remove modal-open class
                            document.body.classList.remove('modal-open');
                        }
                    } catch (error2) {
                        console.error('Failed to close modal:', error1, error2);
                    }
                }
            }

            // Utility function to show modal
            function showModal(modalId) {
                const modal = $(`#${modalId}`);

                // Try jQuery method
                try {
                    modal.modal('show');
                } catch (error1) {
                    try {
                        // Vanilla JS fallback
                        const modalElement = document.getElementById(modalId);
                        if (modalElement) {
                            modalElement.classList.add('show');
                            modalElement.style.display = 'block';

                            // Add backdrop
                            const backdrop = document.createElement('div');
                            backdrop.classList.add('modal-backdrop', 'fade', 'show');
                            document.body.appendChild(backdrop);

                            // Add modal-open class
                            document.body.classList.add('modal-open');
                        }
                    } catch (error2) {
                        console.error('Failed to show modal:', error1, error2);
                    }
                }
            }

            // Create User Modal Trigger
            $('.create-user').on('click', function () {
                $.ajax({
                    url: "{{ route('users.create') }}",
                    method: 'GET',
                    dataType: 'html',
                    success: function (response) {
                        // Remove any existing modals
                        $('#dynamicModalContainer').empty();

                        // Append the new modal content
                        $('#dynamicModalContainer').html(response);

                        // Attach submit event handler
                        $(document).on('submit', '#createUserForm', function (e) {
                            e.preventDefault();

                            $.ajax({
                                url: $(this).attr('action'),
                                method: 'POST',
                                data: $(this).serialize(),
                                success: function (response) {
                                    // Close modal
                                    closeModal('createUserModal');

                                    // Show success message
                                    // Swal.fire({
                                    //     icon: 'success',
                                    //     title: 'Success',
                                    //     text: response.message || 'User created successfully'
                                    // });

                                    // Reload or update users list
                                    location.reload();
                                },
                                error: function (xhr) {
                                    // Handle validation errors
                                    if (xhr.status === 422) {
                                        let errors = xhr.responseJSON.errors;
                                        let errorMessage = '';

                                        $.each(errors, function (field, messages) {
                                            errorMessage += messages.join('\n') + '\n';
                                        });

                                        // Swal.fire({
                                        //     icon: 'error',
                                        //     title: 'Validation Error',
                                        //     text: errorMessage
                                        // });
                                    }
                                }
                            });
                        });

                        // Show modal
                        showModal('createUserModal');

                        // Attach close button event
                        $('#createUserModal .close').on('click', function () {
                            closeModal('createUserModal');
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load create user form!'
                        });
                    }
                });
            });

            // Edit User Modal Trigger
            $(document).on('click', '.edit-user', function () {
                const userId = $(this).data('user-id');

                $.ajax({
                    url: `/users/${userId}/edit`,
                    method: 'GET',
                    dataType: 'html',
                    success: function (response) {
                        // Remove any existing modals
                        $('#dynamicModalContainer').empty();

                        // Append the new modal content
                        $('#dynamicModalContainer').html(response);

                        // Attach submit event handler
                        $(document).on('submit', '#editUserForm', function (e) {
                            e.preventDefault();

                            $.ajax({
                                url: $(this).attr('action'),
                                method: 'POST',
                                data: $(this).serialize(),
                                success: function (response) {
                                    // Close modal
                                    closeModal('editUserModal');

                                    // Show success message
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message || 'User updated successfully'
                                    });

                                    // Reload or update users list
                                    location.reload();
                                },
                                error: function (xhr) {
                                    // Handle validation errors
                                    if (xhr.status === 422) {
                                        let errors = xhr.responseJSON.errors;
                                        let errorMessage = '';

                                        $.each(errors, function (field, messages) {
                                            errorMessage += messages.join('\n') + '\n';
                                        });

                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Validation Error',
                                            text: errorMessage
                                        });
                                    }
                                }
                            });
                        });

                        // Show modal
                        showModal('editUserModal');

                        // Attach close button event
                        $('#editUserModal .close').on('click', function () {
                            closeModal('editUserModal');
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load edit user form!'
                        });
                    }
                });
            });

            // Existing delete confirmation function
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

            // Show User Modal Trigger
            $(document).on('click', '.show-user', function () {
                const userId = $(this).data('user-id');

                $.ajax({
                    url: `/users/${userId}`,
                    method: 'GET',
                    dataType: 'html',
                    success: function (response) {
                        // Remove any existing modals
                        $('#dynamicModalContainer').empty();

                        // Append the new modal content
                        $('#dynamicModalContainer').html(response);

                        // Show modal
                        showModal('showUserModal');

                        // Attach close button event
                        $('#showUserModal .close-modal').on('click', function () {
                            closeModal('showUserModal');
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to load user details!'
                        });
                    }
                });
            });
        });
    </script>
@endpush

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