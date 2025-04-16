@extends('layouts.app')

@section('content')
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 10px; margin-top: 20px; background-color: #F9FAFB;">
                <div class="modal-header border-bottom-0" style="display: block; padding-bottom: 0;">
                    <h1 class="modal-title" id="createUserModalLabel"
                        style="margin-right: 10px; margin-bottom: 10px; color: #374151; font-weight: 500; font-size: 22px; line-height: 100%; letter-spacing: -2%;">
                        Create User
                    </h1>
                </div>
                <div class="modal-body" style="padding: 0px;">
                    <form id="createUserForm" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div style="border: none; border-radius: 8px; padding: 0px 20px 0px 20px;">
                            <div class="form-group mb-3">
                                <label for="name" style="color: #374151; font-weight: 500; font-size: 19.21px;">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 10px; color: #374151;">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email"
                                    style="color: #374151; font-weight: 500; font-size: 19.21px;">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 10px; color: #374151;">
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone"
                                    style="color: #374151; font-weight: 500; font-size: 19.21px;">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 10px; color: #374151;">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password"
                                    style="color: #374151; font-weight: 500; font-size: 19.21px;">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 10px; color: #374151;">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation"
                                    style="color: #374151; font-weight: 500; font-size: 19.21px;">
                                    Confirm Password
                                </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation"
                                    style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 10px; color: #374151;">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0" style="display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal"
                        style="width: 47%; height: 40.68px; border-radius: 9.63px; border: 0.96px solid #D1D5DB; padding: 13.31px 26.62px 13.98px 26.62px; background-color: #FBFDFF; color: #9CA3AF; font-weight: 600; font-size: 11.98px; line-height: 13.31px; text-align: center; margin-right: 10px;">
                        Cancel
                    </button>
                    <button type="submit" form="editUserForm"
                        style="width: 48%; height: 40.68px; border-radius: 9.63px; background-color: #134DF4; color: white; font-weight: 600; font-size: 11.98px; line-height: 13.31px; text-align: center; border: none;">
                        Create User
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                function closeCreateModal() {
                    const modal = document.getElementById('createUserModal');
                    if (modal) {
                        modal.classList.remove('show');
                        modal.style.display = 'none';

                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }

                        document.body.classList.remove('modal-open');
                    }
                }

                $(document).on('click', '#createUserModal .close-modal', function () {
                    try {
                        $('#createUserModal').modal('hide');
                    } catch (error) {
                        closeCreateModal();
                    }
                });

                $(document).on('click', function (event) {
                    var modal = $('#createUserModal');
                    if (
                        modal.is(':visible') &&
                        !$(event.target).closest('.modal-content').length &&
                        !$(event.target).is('.modal-content')
                    ) {
                        try {
                            modal.modal('hide');
                        } catch (error) {
                            closeCreateModal();
                        }
                    }
                });

                $('#createUserForm').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function (response) {
                            // Close the modal
                            try {
                                $('#createUserModal').modal('hide');
                            } catch (error) {
                                closeCreateModal();
                            }

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message || 'User created successfully'
                            });

                            // Reload the page or update the users list
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
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An unexpected error occurred'
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection