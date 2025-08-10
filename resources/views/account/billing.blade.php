@extends('layouts.base')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">@include('account._sidebar')</div>
        </div>
        <div class="col-md-9">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-1">Billing & Subscription</h2>
                    <p class="text-muted mb-0">Manage your subscription, payment methods, and billing history</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="downloadInvoice()">
                        <i class="fas fa-download me-2"></i>Download Invoice
                    </button>
                    <button class="btn btn-primary" onclick="updatePaymentMethod()">
                        <i class="fas fa-credit-card me-2"></i>Update Payment
                    </button>
                </div>
            </div>

            <!-- Current Plan Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Current Plan</h5>
                            <p class="mb-0 text-white-50">{{ $billingData['current_plan']['name'] }}</p>
                        </div>
                        <div class="text-end">
                            <div class="h4 mb-0">${{ number_format($billingData['current_plan']['price'], 2) }}</div>
                            <small class="text-white-50">{{ ucfirst($billingData['current_plan']['billing_cycle']) }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <span class="badge bg-success me-2">
                                    <i class="fas fa-check-circle me-1"></i>{{ ucfirst($billingData['current_plan']['status']) }}
                                </span>
                                <span class="text-muted">Next billing: {{ $billingData['current_plan']['next_billing_date'] }}</span>
                            </div>
                            <div class="row">
                                @foreach($billingData['current_plan']['features'] as $feature)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <span>{{ $feature }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-outline-danger btn-sm" onclick="cancelSubscription()">
                                <i class="fas fa-times me-1"></i>Cancel Plan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Payment Method -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-credit-card me-2 text-primary"></i>Payment Method
                            </h6>
                        </div>
                        <div class="card-body">
                            @if(isset($billingData['payment_method']))
                            <div class="d-flex align-items-center mb-3">
                                <div class="payment-card me-3">
                                    <i class="fab fa-cc-{{ strtolower($billingData['payment_method']['brand']) }} fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $billingData['payment_method']['brand'] }} ending in {{ $billingData['payment_method']['last4'] }}</h6>
                                    <p class="text-muted mb-0">Expires {{ $billingData['payment_method']['expiry'] }}</p>
                                </div>
                                @if($billingData['payment_method']['is_default'])
                                <span class="badge bg-success">Default</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="editPaymentMethod()">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="addPaymentMethod()">
                                    <i class="fas fa-plus me-1"></i>Add New
                                </button>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-3">No payment method added</p>
                                <button class="btn btn-primary" onclick="addPaymentMethod()">
                                    <i class="fas fa-plus me-1"></i>Add Payment Method
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Usage Statistics -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-line me-2 text-primary"></i>Usage This Month
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>API Calls</span>
                                    <span class="text-muted">{{ number_format($billingData['usage']['api_calls']) }} / {{ number_format($billingData['usage']['api_limit']) }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    @php
                                        $apiUsagePercent = ($billingData['usage']['api_calls'] / $billingData['usage']['api_limit']) * 100;
                                    @endphp
                                    <div class="progress-bar bg-{{ $apiUsagePercent > 80 ? 'warning' : 'success' }}" 
                                         style="width: {{ min($apiUsagePercent, 100) }}%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Storage</span>
                                    <span class="text-muted">{{ $billingData['usage']['storage_used'] }} / {{ $billingData['usage']['storage_limit'] }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    @php
                                        $storageUsed = (float) str_replace(' GB', '', $billingData['usage']['storage_used']);
                                        $storageLimit = (float) str_replace(' GB', '', $billingData['usage']['storage_limit']);
                                        $storageUsagePercent = ($storageUsed / $storageLimit) * 100;
                                    @endphp
                                    <div class="progress-bar bg-{{ $storageUsagePercent > 80 ? 'warning' : 'success' }}" 
                                         style="width: {{ min($storageUsagePercent, 100) }}%"></div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-outline-primary btn-sm" onclick="viewDetailedUsage()">
                                    <i class="fas fa-chart-bar me-1"></i>View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing History -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>Billing History
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($billingData['billing_history'] as $invoice)
                                <tr>
                                    <td>{{ $invoice['date'] }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $invoice['invoice_number'] }}</span>
                                    </td>
                                    <td>${{ number_format($invoice['amount'], 2) }} {{ $invoice['currency'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $invoice['status'] === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($invoice['status']) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" onclick="downloadInvoice('{{ $invoice['invoice_number'] }}')">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" onclick="viewInvoice('{{ $invoice['invoice_number'] }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Method Modal -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="paymentMethodForm">
                    <div class="mb-3">
                        <label class="form-label">Card Number</label>
                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Expiry Date</label>
                            <input type="text" class="form-control" placeholder="MM/YY" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CVV</label>
                            <input type="text" class="form-control" placeholder="123" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cardholder Name</label>
                        <input type="text" class="form-control" placeholder="John Doe" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="cancelPaymentMethod()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="savePaymentMethod()">Save Payment Method</button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Subscription Modal -->
<div class="modal fade" id="cancelSubscriptionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Cancel Subscription
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel your subscription?</p>
                <ul class="text-muted">
                    <li>You'll lose access to premium features immediately</li>
                    <li>Your account will be downgraded to the free plan</li>
                    <li>You can reactivate anytime</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeSubscriptionModal()">Keep Subscription</button>
                <button type="button" class="btn btn-danger" onclick="confirmCancelSubscription()">Yes, Cancel</button>
            </div>
        </div>
    </div>
</div>

<style>
.payment-card {
    width: 60px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.progress {
    border-radius: 10px;
    background-color: #f8f9fa;
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.6s ease;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
    background-color: #f8f9fa;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        align-items: stretch !important;
        gap: 1rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        border-radius: 0.375rem !important;
        margin-bottom: 0.25rem;
    }
}

@media (max-width: 576px) {
    .card-header .d-flex {
        flex-direction: column;
        text-align: center;
    }
    
    .card-header .text-end {
        text-align: center !important;
        margin-top: 1rem;
    }
}
</style>

<script>
// Store modal instances globally
let paymentMethodModal;
let cancelSubscriptionModal;

// Initialize modals when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing modals...');
    
    // Initialize modal instances
    const paymentMethodModalElement = document.getElementById('paymentMethodModal');
    const cancelSubscriptionModalElement = document.getElementById('cancelSubscriptionModal');
    
    // Check if Bootstrap is available
    if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
        console.error('Bootstrap Modal is not available. Make sure Bootstrap JS is loaded.');
        console.log('Bootstrap object:', typeof bootstrap);
        if (typeof bootstrap !== 'undefined') {
            console.log('Bootstrap properties:', Object.keys(bootstrap));
        }
        return;
    }
    
    console.log('Bootstrap Modal is available:', typeof bootstrap.Modal);
    console.log('Bootstrap version info:', bootstrap.Modal.VERSION || 'Version not available');
    
    if (paymentMethodModalElement) {
        try {
            paymentMethodModal = new bootstrap.Modal(paymentMethodModalElement, {
                backdrop: true,  // Close when clicking outside
                keyboard: true,  // Close when pressing ESC
                focus: true      // Focus on first focusable element
            });
            console.log('Payment method modal initialized');
            
            // Add event listener for the Cancel button as a fallback
            const cancelButton = paymentMethodModalElement.querySelector('button[data-bs-dismiss="modal"]');
            if (cancelButton) {
                cancelButton.addEventListener('click', function() {
                    console.log('Cancel button clicked');
                    if (paymentMethodModal) {
                        paymentMethodModal.hide();
                    }
                });
            }
            
            // Add event listener for modal hidden event
            paymentMethodModalElement.addEventListener('hidden.bs.modal', function () {
                console.log('Payment method modal hidden');
                // Reset form when modal is closed
                const form = document.getElementById('paymentMethodForm');
                if (form) {
                    form.reset();
                }
            });
        } catch (error) {
            console.error('Error initializing payment method modal:', error);
        }
    } else {
        console.error('Payment method modal element not found');
    }
    
    if (cancelSubscriptionModalElement) {
        try {
            cancelSubscriptionModal = new bootstrap.Modal(cancelSubscriptionModalElement, {
                backdrop: true,  // Close when clicking outside
                keyboard: true,  // Close when pressing ESC
                focus: true      // Focus on first focusable element
            });
            console.log('Cancel subscription modal initialized');
            
            // Add event listener for modal hidden event
            cancelSubscriptionModalElement.addEventListener('hidden.bs.modal', function () {
                console.log('Cancel subscription modal hidden');
            });
        } catch (error) {
            console.error('Error initializing cancel subscription modal:', error);
        }
    } else {
        console.error('Cancel subscription modal element not found');
    }
    
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add hover effects to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

function updatePaymentMethod() {
    // Implementation for updating payment method
    showNotification('Payment method update feature coming soon!', 'info');
}

function addPaymentMethod() {
    if (paymentMethodModal) {
        paymentMethodModal.show();
    } else {
        console.error('Payment method modal not initialized');
    }
}

function editPaymentMethod() {
    // Implementation for editing payment method
    showNotification('Payment method edit feature coming soon!', 'info');
}

function savePaymentMethod() {
    // Implementation for saving payment method
    showNotification('Payment method saved successfully!', 'success');
    if (paymentMethodModal) {
        paymentMethodModal.hide();
    }
}

function cancelPaymentMethod() {
    // Manual cancel function
    console.log('Manual cancel called');
    
    // Method 1: Use Bootstrap modal instance
    if (paymentMethodModal) {
        try {
            paymentMethodModal.hide();
        } catch (error) {
            console.error('Error hiding modal with Bootstrap instance:', error);
            // Fallback to DOM method
            closeModalWithDOM('paymentMethodModal');
        }
    } else {
        // Fallback to DOM method
        closeModalWithDOM('paymentMethodModal');
    }
}

function cancelSubscription() {
    if (cancelSubscriptionModal) {
        cancelSubscriptionModal.show();
    } else {
        console.error('Cancel subscription modal not initialized');
    }
}

function confirmCancelSubscription() {
    showNotification('Subscription cancelled successfully!', 'success');
    if (cancelSubscriptionModal) {
        cancelSubscriptionModal.hide();
    }
    setTimeout(() => location.reload(), 1500);
}

function closeSubscriptionModal() {
    // Manual close function for subscription modal
    console.log('Manual close subscription modal called');
    
    // Method 1: Use Bootstrap modal instance
    if (cancelSubscriptionModal) {
        try {
            cancelSubscriptionModal.hide();
        } catch (error) {
            console.error('Error hiding modal with Bootstrap instance:', error);
            // Fallback to DOM method
            closeModalWithDOM('cancelSubscriptionModal');
        }
    } else {
        // Fallback to DOM method
        closeModalWithDOM('cancelSubscriptionModal');
    }
}

// Fallback function to close modal using DOM manipulation
function closeModalWithDOM(modalId) {
    const modalElement = document.getElementById(modalId);
    if (modalElement) {
        // Remove modal classes
        modalElement.classList.remove('show');
        modalElement.style.display = 'none';
        
        // Remove backdrop
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
        
        // Re-enable body scrolling
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        console.log(`Modal ${modalId} closed using DOM fallback`);
    }
}

function downloadInvoice(invoiceNumber = null) {
    // Implementation for downloading invoice
    const invoice = invoiceNumber || 'latest';
    showNotification(`Downloading invoice ${invoice}...`, 'info');
}

function viewInvoice(invoiceNumber) {
    // Implementation for viewing invoice
    showNotification(`Opening invoice ${invoiceNumber}...`, 'info');
}

function viewDetailedUsage() {
    // Implementation for viewing detailed usage
    showNotification('Detailed usage view coming soon!', 'info');
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endsection 