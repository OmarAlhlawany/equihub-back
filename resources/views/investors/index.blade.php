@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="text-left" style="color: #374151;
                                                        font-size: 36px;
                                                        font-weight: 500;">Investors</h1>
                <p class="text-left" style="color: #9CA3AF;
                                                        font-size: 21px;
                                                        font-weight: 400;">Here you can find the List of investors.</p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('investors') }}" method="GET" class="d-flex align-items-center"
                style="gap: 10px; max-width: 600px;">
                <div style="position: relative; width: 180px;">
                    <select name="search_field" id="searchField" class="form-control" style="
                        width: 100%; 
                        padding: 8px 12px; 
                        font-size: 16px; 
                        border-radius: 10px; 
                        background-color: white; 
                        color: #374151; 
                        border: 1px solid #E5E7EB;
                        transition: border-color 0.3s;
                        appearance: none;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        padding-right: 36px;">
                        <option value="" selected disabled hidden>Search with</option>
                        <option value="name" {{ request('search_field') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('search_field') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="phone_number" {{ request('search_field') == 'phone_number' ? 'selected' : '' }}>Phone
                        </option>
                        <option value="company" {{ request('search_field') == 'company' ? 'selected' : '' }}>Company</option>
                    </select>

                    <i class="fas fa-chevron-down" style="
                        position: absolute;
                        top: 50%;
                        right: 12px;
                        transform: translateY(-50%);
                        color: #6B7280;
                        pointer-events: none;"></i>
                </div>


                <input type="text" name="search_value" id="searchInput" class="form-control" placeholder="Search here..."
                    value="{{ request('search_value') }}" style="
                                                        width: 250px; 
                                                        padding: 8px 12px;
                                                        font-size: 16px;
                                                        border-radius: 10px; 
                                                        border: 1px solid #E5E7EB;
                                                        color: #374151;">

                <button type="submit" class="btn btn-primary" style="
                                                        padding: 8px 16px; 
                                                        border-radius: 10px; 
                                                        background-image: linear-gradient(to left, #1D03B5, #3F81F8);
                                                        color: white;
                                                        border: none;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                        gap: 8px;
                                                        width: 180px;">Search</button>

                <button type="button" onclick="resetSearch()" class="btn btn-secondary" style="
                                                        padding: 8px 16px; 
                                                        border-radius: 10px; 
                                                        background-color: white; 
                                                        color: #4A4A4A; 
                                                        border: 1px solid #E5E7EB;
                                                        display: flex;
                                                        align-items: center;
                                                        gap: 8px;
                                                        transition: background-color 0.3s, color 0.3s;"
                    onmouseover="this.style.backgroundColor='#2B37A0'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='white'; this.style.color='#2B37A0';">
                    <i class="fas fa-sync-alt"></i>
                </button>


            </form>
        </div>

        <!-- Investors Table -->
        <div class="table-container" style="overflow-x: auto; 
                                                        border-radius: 10px; 
                                                        background-color: white; 
                                                        border: 0.91px  #E5E7EB; 
                                                        padding: 10px;
                                                        border: 1px solid #E5E7EB;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <text class="m-0" style="color: #374151;
                                                        text-align: center;
                                                        font-size: 21px;
                                                        font-weight: 600;">Investors</text>
                <a href="{{ route('investors.create') }}" class="btn btn-primary" style="padding: 5px 10px; 
                                                                border-radius: 10px; 
                                                                background-color: #134DF4; 
                                                                color: white;
                                                                width: 150px;
                                                                height: 40px;
                                                                text-align: center;
                                                                margin-top: 10px;">
                    <i class="fas fa-plus"></i> Add Investor
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
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'phone_number', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                style="color: #9CA3AF; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                Phone
                                <span style="margin-left: 5px;">
                                    @if(request('sort') === 'phone_number')
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
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'company', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                style="color: #9CA3AF; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                                Company
                                <span style="margin-left: 5px;">
                                    @if(request('sort') === 'company')
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
                        <th style="
                                                                    color: #9CA3AF; 
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
                    @foreach($investors as $investor)
                        <tr style="border-bottom: 0.5px solid #E5E7EB;">
                            <td style="text-align: center; 
                                                                                                                    color: #374151; 
                                                                                                                    vertical-align: middle;
                                                                                                                    ">
                                {{ $investor->id }}
                            </td>
                            <td style="text-align: center; 
                                                                                                                    color: #374151; 
                                                                                                                    vertical-align: middle;
                                                                                                                    ">
                                {{ $investor->name }}
                            </td>
                            <td style="text-align: center; 
                                                                                                                    color: #374151; 
                                                                                                                    vertical-align: middle;
                                                                                                                    ">
                                {{ $investor->email }}
                            </td>
                            <td style="text-align: center; 
                                                                                                                    color: #374151; 
                                                                                                                    vertical-align: middle;
                                                                                                                    ">
                                {{ $investor->phone_number }}
                            </td>
                            <td style="text-align: center; 
                                                                                                                    color: #374151; 
                                                                                                                    vertical-align: middle;
                                                                                                                    ">
                                {{ $investor->company }}
                            </td>
                            <td style="text-align: center; 
                                                                vertical-align: middle;
                                                                ">
                                <button class="btn btn-sm"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;"
                                    onclick="confirmDelete({{ $investor->id }})">
                                    <img src="{{ asset('images/trash-delete.svg') }}" alt="Delete"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#374151';" onmouseout="this.style.color='#6B7280';">
                                </button>

                                <!-- Edit button with pencil icon -->
                                <a href="{{ route('investors.edit', $investor->id) }}" class="btn btn-sm"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;">
                                    <img src="{{ asset('images/pencil-edit.svg') }}" alt="Edit"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#6B7280';">
                                </a>

                                <!-- View button with eye icon -->
                                <a href="{{ route('investors.show', $investor->id) }}" class="btn btn-sm"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;">
                                    <img src="{{ asset('images/eye-view.svg') }}" alt="View"
                                        style="color: #6B7280; font-size: 15px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#6B7280';">
                                </a>

                                <!-- API Test button -->
                                <button class="btn btn-sm api-test" data-investor-id="{{ $investor->id }}"
                                    style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;"
                                    onclick="console.log('API Test clicked for investor: {{ $investor->id }}'); window.location.href='{{ route('investor.api.test', $investor->id) }}'">
                                    <i class="fas fa-brain" alt="API Test"
                                        style="color: #6B7280; font-size: 12px; transition: color 0.3s;"
                                        onmouseover="this.style.color='#000000';" onmouseout="this.style.color='#6B7280';"></i>
                                </button>

                                <!-- WhatsApp Send button -->
                                @if($investor->phone_number)
                                    <button class="btn btn-sm whatsapp-send" data-investor-id="{{ $investor->id }}"
                                        data-investor-name="{{ $investor->name }}"
                                        style="background-color: #FBFDFF; border: 1px solid #E5E7EB; color: #374151;"
                                        onclick="showWhatsAppModal({{ $investor->id }}, '{{ $investor->name }}')">
                                        <i class="fab fa-whatsapp" alt="Send WhatsApp"
                                            style="color: #25D366; font-size: 12px; transition: color 0.3s;"
                                            onmouseover="this.style.color='#128C7E';" onmouseout="this.style.color='#25D366';"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm" disabled
                                        style="background-color: #F9F9F9; border: 1px solid #E5E7EB; color: #9CA3AF; cursor: not-allowed;"
                                        title="No phone number available">
                                        <i class="fab fa-whatsapp" alt="No Phone" style="color: #9CA3AF; font-size: 12px;"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $investors->appends(request()->input())->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

<!-- WhatsApp Send Modal -->
<div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel">
                    <i class="fab fa-whatsapp" style="color: #25D366;"></i>
                    Send Report to WhatsApp
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"
                    onclick="hideWhatsAppModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="whatsappForm">
                    @csrf
                    <input type="hidden" id="modalInvestorId" name="investor_id">

                    <div class="mb-3">
                        <label for="modalInvestorName" class="form-label">Investor:</label>
                        <input type="text" id="modalInvestorName" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modalLanguage" class="form-label">Language:</label>
                        <select id="modalLanguage" name="language" class="form-select" required>
                            <option value="en">English</option>
                            <option value="ar">Arabic</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="modalMessage" class="form-label">Custom Message (Optional):</label>
                        <textarea id="modalMessage" name="message" class="form-control" rows="3"
                            placeholder="Add a custom message to send with the report..."></textarea>
                        <div class="form-text">Leave empty to use default message</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal"
                    onclick="hideWhatsAppModal()">Cancel</button>
                <button type="button" class="btn btn-success" onclick="sendWhatsAppReport()" id="sendBtn">
                    <i class="fab fa-whatsapp"></i> Send Report
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        window.confirmDelete = function (investorId) {
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
        };

        window.resetSearch = function () {
            // Reset search field and value
            $('#searchField').val('');
            $('#searchInput').val('');

            // Redirect to the investors index page
            window.location.href = "{{ route('investors') }}";
        };

        // WhatsApp Modal Functions
        window.showWhatsAppModal = function (investorId, investorName) {
            console.log('showWhatsAppModal called with:', investorId, investorName);

            try {
                $('#modalInvestorId').val(investorId);
                $('#modalInvestorName').val(investorName);
                $('#modalLanguage').val('en'); // Default to English
                $('#modalMessage').val(''); // Clear message

                console.log('About to show modal...');
                // Try Bootstrap 5 first, fallback to Bootstrap 4
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = new bootstrap.Modal(document.getElementById('whatsappModal'));
                    modal.show();
                } else if (typeof $.fn.modal !== 'undefined') {
                    $('#whatsappModal').modal('show');
                } else {
                    // Fallback - show modal manually
                    document.getElementById('whatsappModal').style.display = 'block';
                    document.getElementById('whatsappModal').classList.add('show');
                }
                console.log('Modal show command executed');
            } catch (error) {
                console.error('Error in showWhatsAppModal:', error);
                alert('Error opening WhatsApp modal: ' + error.message);
            }
        };

        // Helper function to hide modal (works with both Bootstrap versions)
        window.hideWhatsAppModal = function () {
            try {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('whatsappModal'));
                    if (modal) modal.hide();
                } else if (typeof $.fn.modal !== 'undefined') {
                    $('#whatsappModal').modal('hide');
                } else {
                    // Fallback - hide modal manually
                    document.getElementById('whatsappModal').style.display = 'none';
                    document.getElementById('whatsappModal').classList.remove('show');
                }
            } catch (error) {
                console.error('Error hiding modal:', error);
            }
        };

        window.sendWhatsAppReport = function () {
            const investorId = $('#modalInvestorId').val();
            const language = $('#modalLanguage').val();
            const message = $('#modalMessage').val();
            const investorName = $('#modalInvestorName').val();

            // Disable send button and show loading
            const sendBtn = $('#sendBtn');
            const originalText = sendBtn.html();
            sendBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');

            // Send AJAX request
            $.ajax({
                url: '{{ route("whatsapp.send.report") }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    investor_id: investorId,
                    language: language,
                    message: message
                },
                success: function (response) {
                    hideWhatsAppModal();

                    if (response.success) {
                        Swal.fire({
                            title: '🎉 SUCCESS!',
                            html: `WhatsApp report sent successfully to <strong>${investorName}</strong>!<br><br>
                                   <small>📱 Text message and 📄 PDF report have been sent.</small>`,
                            icon: 'success',
                            confirmButtonColor: '#25D366',
                            confirmButtonText: 'Great!'
                        });
                    } else {
                        Swal.fire({
                            title: '❌ Failed!',
                            text: response.message || 'Failed to send WhatsApp report',
                            icon: 'error',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function (xhr) {
                    hideWhatsAppModal();

                    let errorMessage = 'An error occurred while sending the report';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: '❌ Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function () {
                    // Re-enable send button
                    sendBtn.prop('disabled', false).html(originalText);
                }
            });
        };

        // Add event listeners for modal closing
        $(document).ready(function () {
            // Handle backdrop click
            $('#whatsappModal').on('click', function (e) {
                if (e.target === this) {
                    hideWhatsAppModal();
                }
            });

            // Handle escape key
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape' && $('#whatsappModal').hasClass('show')) {
                    hideWhatsAppModal();
                }
            });
        });
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
  
    .custom-table tbody tr:first-child {
                border-top: none !important;
            }
        
      .custom-table td,
            .custom-table th {
        border-top: none !important;
    }
</style>