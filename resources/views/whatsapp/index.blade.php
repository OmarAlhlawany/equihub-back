@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px;">
    <div class="container-fluid">
        <!-- Debug Alert Container -->
        <div id="alertContainer" class="mb-4"></div>

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none;">
                    <div class="card-body text-center" style="background: linear-gradient(135deg, #374151 0%, #4B5563 100%); color: white; border-radius: 15px;">
                        <h2 class="mb-0"><i class="fab fa-whatsapp" style="color: #25D366;"></i> WhatsApp Reports</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $totalInvestors }}</h3>
                        <p>Total Investors</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $investorsWithPhone }}</h3>
                        <p>With Phone Numbers</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>{{ $investorsWithPhone }}</h3>
                        <p>Ready for WhatsApp</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Send Form -->
        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none;">
                    <div class="card-header bg-primary text-white">
                        <h4><i class="fas fa-paper-plane"></i> Send Investment Report</h4>
                    </div>
                    <div class="card-body" style="padding: 30px;">
                        <form id="whatsappForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="investor_id" class="form-label"><strong>Select Investor</strong></label>
                                    <select class="form-control" id="investor_id" name="investor_id" required>
                                        <option value="">Choose investor...</option>
                                        @foreach($investors as $investor)
                                            <option value="{{ $investor->id }}" data-phone="{{ $investor->phone_number ?? 'N/A' }}">
                                                {{ $investor->name }} ({{ $investor->phone_number ?? 'No Phone' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="language" class="form-label"><strong>Language</strong></label>
                                    <select class="form-control" id="language" name="language" required>
                                        <option value="en">English</option>
                                        <option value="ar">Arabic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="message" class="form-label"><strong>Custom Message (Optional)</strong></label>
                                    <textarea class="form-control" id="message" name="message" rows="3" maxlength="1000" placeholder="Enter custom message..."></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" id="sendBtn" class="btn btn-success btn-lg px-5">
                                        <i class="fab fa-whatsapp"></i>
                                        <span id="btnText">Send Report via WhatsApp</span>
                                        <span id="btnSpinner" class="spinner-border spinner-border-sm ml-2" style="display: none;"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Debug Panel -->
        <div id="debugPanel" class="row mt-4" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5><i class="fas fa-bug"></i> Debug Information</h5>
                    </div>
                    <div class="card-body">
                        <pre id="debugContent" style="background: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 400px; overflow-y: auto; font-size: 12px;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== WHATSAPP PAGE LOADED ===');
    
    const form = document.getElementById('whatsappForm');
    const sendBtn = document.getElementById('sendBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    const alertContainer = document.getElementById('alertContainer');
    const debugPanel = document.getElementById('debugPanel');
    const debugContent = document.getElementById('debugContent');

    function showAlert(type, title, message, debugInfo = null) {
        console.log('=== SHOWING ALERT ===');
        console.log('Type:', type);
        console.log('Title:', title);
        console.log('Message:', message);
        console.log('Debug Info:', debugInfo);
        
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';

        const iconClass = {
            'success': 'fas fa-check-circle',
            'error': 'fas fa-exclamation-triangle',
            'warning': 'fas fa-exclamation-circle',
            'info': 'fas fa-info-circle'
        }[type] || 'fas fa-info-circle';

        let debugSection = '';
        if (debugInfo) {
            debugSection = `
                <hr>
                <h6><i class="fas fa-bug"></i> Debug Information:</h6>
                <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 11px; max-height: 300px; overflow-y: auto;">
                    <pre>${JSON.stringify(debugInfo, null, 2)}</pre>
                </div>
            `;
            
            // Show debug panel
            debugContent.textContent = JSON.stringify(debugInfo, null, 2);
            debugPanel.style.display = 'block';
        }

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <h5 class="alert-heading">
                    <i class="${iconClass}"></i> ${title}
                </h5>
                <p class="mb-0">${message}</p>
                ${debugSection}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `;

        alertContainer.innerHTML = alertHtml;
        alertContainer.scrollIntoView({ behavior: 'smooth' });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('=== FORM SUBMISSION STARTED ===');
        
        const formData = new FormData(form);
        const investor = document.getElementById('investor_id');
        const selectedOption = investor.options[investor.selectedIndex];
        
        // Show loading
        sendBtn.disabled = true;
        btnText.textContent = 'Processing Request...';
        btnSpinner.style.display = 'inline-block';
        
        // Clear previous alerts
        alertContainer.innerHTML = '';
        debugPanel.style.display = 'none';
        
        // Log form data
        const formDataObj = {};
        formData.forEach((value, key) => {
            formDataObj[key] = value;
        });
        
        console.log('=== FORM DATA ===');
        console.log(formDataObj);
        
        showAlert('warning', 'Processing Request', 'Generating PDF and sending WhatsApp message...', {
            step: 'form_submitted',
            form_data: formDataObj,
            selected_investor: selectedOption.textContent,
            investor_phone: selectedOption.getAttribute('data-phone'),
            timestamp: new Date().toISOString()
        });

        // Update button text
        btnText.textContent = 'Generating PDF...';

        fetch('/whatsapp/send-report', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('=== RESPONSE RECEIVED ===');
            console.log('Status:', response.status);
            console.log('OK:', response.ok);
            console.log('Headers:', Object.fromEntries(response.headers.entries()));
            
            btnText.textContent = 'Processing Response...';
            
            return response.json().then(data => ({
                status: response.status,
                ok: response.ok,
                data: data
            }));
        })
        .then(({status, ok, data}) => {
            console.log('=== RESPONSE DATA PARSED ===');
            console.log('Status:', status);
            console.log('OK:', ok);
            console.log('Data:', data);
            
            if (ok && data.success) {
                showAlert('success', '🎉 SUCCESS! WhatsApp Message Sent!', data.message, {
                    step: 'success',
                    response: data,
                    debug_info: data.debug_info,
                    api_status: status,
                    timestamp: new Date().toISOString()
                });
                
                // Reset form
                form.reset();
                
            } else {
                showAlert('error', '❌ FAILED! Could Not Send WhatsApp Message', data.message || 'Unknown error occurred', {
                    step: 'error',
                    response: data,
                    debug_info: data.debug_info,
                    api_status: status,
                    timestamp: new Date().toISOString()
                });
            }
        })
        .catch(error => {
            console.error('=== REQUEST ERROR ===');
            console.error('Error:', error);
            console.error('Stack:', error.stack);
            
            showAlert('error', '🚨 NETWORK ERROR! Request Failed', 'Network error or server unavailable: ' + error.message, {
                step: 'network_error',
                error_type: 'Network/Server Error',
                error_message: error.message,
                error_stack: error.stack,
                timestamp: new Date().toISOString()
            });
        })
        .finally(() => {
            console.log('=== REQUEST COMPLETED ===');
            
            // Reset button state
            sendBtn.disabled = false;
            btnText.textContent = 'Send Report via WhatsApp';
            btnSpinner.style.display = 'none';
        });
    });
});
</script>

<style>
.btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.alert {
    animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
