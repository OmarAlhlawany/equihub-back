@extends('layouts.app')

@section('content')
    <div class="modal fade" id="showUserModal" tabindex="-1" role="dialog" aria-labelledby="showUserModalLabel"
        aria-hidden="true"">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 10px; margin-top: 100px;">
                <div class="modal-header border-bottom-0" style="display: block; padding-bottom: 0;">
                    <h1 class="modal-title" id="showUserModalLabel"
                        style="margin-right: 10px; margin-bottom: 10px; color: #374151;  font-weight: 500; font-size: 33.69px; line-height: 100%; letter-spacing: -2%;">
                        Accounts </h1>
                    <p
                        style="color: #9CA3AF;  font-weight: 400; font-size: 19.33px; line-height: 100%; letter-spacing: -2%;">
                        View, Edit Accounts you want.</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <h2
                                        style=" font-weight: 600; font-size: 19.21px; color: #374151; margin: 0;">
                                        {{ $user->name }}
                                    </h2>
                                    <div>
                                        <button class="btn btn-sm edit-user" data-user-id="{{ $user->id }}"
                                            style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151; margin-left: 5px;">
                                            <img src="{{ asset('images/pencil-edit.svg') }}" alt="Edit"
                                                style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                                onmouseover="this.style.color='#000000';"
                                                onmouseout="this.style.color='#6B7280';">
                                        </button>

                                        <button class="btn btn-sm show-user" data-user-id="{{ $user->id }}"
                                            style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151; margin-left: 5px;">
                                            <img src="{{ asset('images/eye-view.svg') }}" alt="View"
                                                style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                                onmouseover="this.style.color='#000000';"
                                                onmouseout="this.style.color='#6B7280';">
                                        </button>
                                    </div>
                                </div>

                                <div style="margin-top: 15px;">
                                <p
                                    style="margin: 0;  font-weight: 500; font-size: 19.21px; line-height: 100%; letter-spacing: -2%; color: #374151;">
                                    Email:
                                    <span
                                        style="font-weight: 400;">
                                        {{ $user->email }}
                                    </span>
                                </p>
                                <p
                                    style="margin: 0;  font-weight: 500; font-size: 19.21px; line-height: 100%; letter-spacing: -2%; color: #374151;">
                                    Phone:
                                    <span
                                        style="font-weight: 400;">
                                        {{ $user->phone }}
                                    </span>
                                </p>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0" style="display: flex; justify-content: center;">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal"
                        style="width: 276.03px; height: 40.68px; border-radius: 9.63px; border: 0.96px solid #D1D5DB; padding: 13.31px 26.62px 13.98px 26.62px; background-color: #FBFDFF; color: #9CA3AF;  font-weight: 600; font-size: 11.98px; line-height: 13.31px; text-align: center;">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                function closeShowModal() {
                    const modal = document.getElementById('showUserModal');
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

                $(document).on('click', '#showUserModal .close-modal', function () {
                    try {
                        $('#showUserModal').modal('hide');
                    } catch (error) {
                        closeShowModal();
                    }
                });
            

            $(document).on('click', function (event) {
                var modal = $('#showUserModal');
                if (
                    modal.is(':visible') &&
                    !$(event.target).closest('.modal-content').length &&
                    !$(event.target).is('.modal-content')
                ) {
                    try {
                        modal.modal('hide');
                    } catch (error) {
                        closeShowModal();
                    }
                }
            });
        });
    </script>
    @endpush
@endsection
