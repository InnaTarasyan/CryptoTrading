@extends('layouts.base')

@section('title', 'Security Settings - Crypto Trading')

@section('head')
<meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            @include('account._sidebar')
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <!-- Security Header -->
            <div class="security-header mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="security-title mb-2">Security Settings</h1>
                        <p class="security-subtitle text-white">Manage your account security and privacy</p>
                    </div>
                    <div class="security-status">
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-shield-check me-2"></i>
                            Account Secure
                        </span>
                    </div>
                </div>
            </div>

            <!-- Security Overview Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="security-card">
                        <div class="security-card-icon bg-primary">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="security-card-content">
                            <h5>Password</h5>
                            <p class="text-muted mb-0">Last changed {{ auth()->user()->password_changed_at ? auth()->user()->password_changed_at->diffForHumans() : 'Never' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="security-card">
                        <div class="security-card-icon bg-warning">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="security-card-content">
                            <h5>2FA Status</h5>
                            <p class="text-muted mb-0">
                                @if(auth()->user()->two_factor_enabled)
                                    <span class="text-success">Enabled</span>
                                @else
                                    <span class="text-danger">Disabled</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="security-card">
                        <div class="security-card-icon bg-info">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="security-card-content">
                            <h5>Last Login</h5>
                            <p class="text-muted mb-0">{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'Never' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="security-card">
                        <div class="security-card-icon bg-success">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="security-card-content">
                            <h5>Active Sessions</h5>
                            <p class="text-muted mb-0">{{ auth()->user()->active_sessions_count ?? 1 }} session</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Sections -->
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Password Change Section -->
                    <div class="security-section mb-4">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="section-content">
                                <h3>Change Password</h3>
                                <p>Update your password to keep your account secure</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('account.security.password') }}" method="POST" id="passwordForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="current_password" class="field-label">
                                        <i class="fas fa-lock"></i>
                                        <span>Current Password</span>
                                    </label>
                                    <div class="password-input-group">
                                        <input type="password" 
                                               class="form-input @error('current_password') is-invalid @enderror" 
                                               id="current_password" 
                                               name="current_password" 
                                               required>
                                        <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-field">
                                    <label for="new_password" class="field-label">
                                        <i class="fas fa-lock"></i>
                                        <span>New Password</span>
                                    </label>
                                    <div class="password-input-group">
                                        <input type="password" 
                                               class="form-input @error('new_password') is-invalid @enderror" 
                                               id="new_password" 
                                               name="new_password" 
                                               required 
                                               minlength="8">
                                        <button type="button" class="password-toggle" onclick="togglePassword('new_password')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                    <div class="password-strength" id="passwordStrength">
                                        <div class="strength-bar">
                                            <div class="strength-fill" id="strengthFill"></div>
                                        </div>
                                        <span class="strength-text" id="strengthText">Password strength</span>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <label for="new_password_confirmation" class="field-label">
                                        <i class="fas fa-lock"></i>
                                        <span>Confirm New Password</span>
                                    </label>
                                    <div class="password-input-group">
                                        <input type="password" 
                                               class="form-input @error('new_password_confirmation') is-invalid @enderror" 
                                               id="new_password_confirmation" 
                                               name="new_password_confirmation" 
                                               required>
                                        <button type="button" class="password-toggle" onclick="togglePassword('new_password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('new_password_confirmation')
                                        <div class="field-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Two-Factor Authentication Section -->
                    <div class="security-section mb-4">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="section-content">
                                <h3>Two-Factor Authentication</h3>
                                <p>Add an extra layer of security to your account</p>
                            </div>
                        </div>
                        
                        @if(auth()->user()->two_factor_enabled)
                            <div class="two-factor-status enabled">
                                <div class="status-content">
                                    <div class="status-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="status-text">
                                        <h5>Two-Factor Authentication is Enabled</h5>
                                        <p class="text-muted">Your account is protected with an additional security layer</p>
                                    </div>
                                </div>
                                <div class="status-actions">
                                    <button type="button" class="btn btn-outline-info me-2" onclick="viewRecoveryCodes()">
                                        <i class="fas fa-key me-2"></i>
                                        View Recovery Codes
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="disable2FA()">
                                        <i class="fas fa-times me-2"></i>
                                        Disable 2FA
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="two-factor-status disabled">
                                <div class="status-content">
                                    <div class="status-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="status-text">
                                        <h5>Two-Factor Authentication is Disabled</h5>
                                        <p class="text-muted">Enable 2FA to add an extra layer of security to your account</p>
                                    </div>
                                </div>
                                <div class="status-actions">
                                    <button type="button" class="btn btn-primary" onclick="setup2FA()">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        Enable 2FA
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Active Sessions Section -->
                    <div class="security-section mb-4">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <div class="section-content">
                                <h3>Active Sessions</h3>
                                <p>Manage your active login sessions across devices</p>
                            </div>
                        </div>
                        
                        <div class="sessions-list">
                            <div class="session-item current">
                                <div class="session-info">
                                    <div class="session-icon">
                                        <i class="fas fa-desktop"></i>
                                    </div>
                                    <div class="session-details">
                                        <h6>Current Session</h6>
                                        <p class="text-muted mb-1">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ request()->ip() }} • {{ request()->header('User-Agent') ?: 'Unknown Browser' }}
                                        </p>
                                        <small class="text-muted">Active now • This device</small>
                                    </div>
                                </div>
                                <div class="session-status">
                                    <span class="badge bg-success">Current</span>
                                </div>
                            </div>
                            
                            <!-- Example of other sessions -->
                            <div class="session-item">
                                <div class="session-info">
                                    <div class="session-icon">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="session-details">
                                        <h6>Mobile Device</h6>
                                        <p class="text-muted mb-1">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            192.168.1.100 • Chrome Mobile
                                        </p>
                                        <small class="text-muted">Last active 2 hours ago</small>
                                    </div>
                                </div>
                                <div class="session-actions">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="terminateSession(1)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="session-actions-global">
                            <button type="button" class="btn btn-outline-warning" onclick="terminateAllSessions()">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Terminate All Other Sessions
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Security Tips -->
                    <div class="security-tips mb-4">
                        <div class="tips-header">
                            <h5><i class="fas fa-lightbulb me-2"></i>Security Tips</h5>
                        </div>
                        <div class="tips-content">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="tip-text">
                                    <strong>Use a strong password</strong>
                                    <p>Include uppercase, lowercase, numbers, and symbols</p>
                                </div>
                            </div>
                            
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="tip-text">
                                    <strong>Enable two-factor authentication</strong>
                                    <p>Add an extra layer of security to your account</p>
                                </div>
                            </div>
                            
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="tip-text">
                                    <strong>Monitor active sessions</strong>
                                    <p>Regularly check and terminate suspicious sessions</p>
                                </div>
                            </div>
                            
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="tip-text">
                                    <strong>Keep software updated</strong>
                                    <p>Use the latest versions of browsers and apps</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Security Activity -->
                    <div class="security-activity">
                        <div class="activity-header">
                            <h5><i class="fas fa-history me-2"></i>Recent Activity</h5>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon bg-success">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Successful Login</h6>
                                    <p class="text-muted mb-0">2 hours ago</p>
                                </div>
                            </div>
                            
                            <div class="activity-item">
                                <div class="activity-icon bg-info">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Password Changed</h6>
                                    <p class="text-muted mb-0">1 week ago</p>
                                </div>
                            </div>
                            
                            <div class="activity-item">
                                <div class="activity-icon bg-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Failed Login Attempt</h6>
                                    <p class="text-muted mb-0">2 weeks ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2FA Setup Modal -->
<div class="modal fade" id="twoFactorModal" tabindex="-1" aria-labelledby="twoFactorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="twoFactorModalLabel">
                    <i class="fas fa-mobile-alt me-2"></i>
                    Setup Two-Factor Authentication
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="two-factor-setup">
                    <div class="setup-step active" id="step1">
                        <h6>Step 1: Install Authenticator App</h6>
                        <p class="text-muted">Download and install one of these authenticator apps:</p>
                        <div class="authenticator-apps">
                            <div class="app-item">
                                <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Google Play" class="app-badge">
                                <span>Google Authenticator</span>
                            </div>
                            <div class="app-item">
                                <img src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/en-us" alt="App Store" class="app-badge">
                                <span>Authy</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mt-3" onclick="nextStep()">
                            Next Step
                        </button>
                    </div>
                    
                    <div class="setup-step" id="step2">
                        <h6>Step 2: Scan QR Code</h6>
                        <p class="text-muted">Scan this QR code with your authenticator app:</p>
                        <div class="qr-code-container text-center">
                            <div class="qr-code-placeholder">
                                <i class="fas fa-qrcode fa-5x text-muted"></i>
                                <p class="mt-2 text-muted">QR Code will be generated here</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-secondary" onclick="prevStep()">
                                Previous
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">
                                Next Step
                            </button>
                        </div>
                    </div>
                    
                    <div class="setup-step" id="step3">
                        <h6>Step 3: Verify Setup</h6>
                        <p class="text-muted">Enter the 6-digit code from your authenticator app:</p>
                        <div class="verification-code">
                            <input type="text" class="form-control form-control-lg text-center" 
                                   id="verificationCode" 
                                   placeholder="000000" 
                                   maxlength="6" 
                                   pattern="[0-9]{6}">
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-secondary" onclick="prevStep()">
                                Previous
                            </button>
                            <button type="button" class="btn btn-success" onclick="verify2FA()">
                                <i class="fas fa-check me-2"></i>
                                Verify & Enable
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recovery Codes Modal -->
<div class="modal fade" id="recoveryCodesModal" tabindex="-1" aria-labelledby="recoveryCodesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recoveryCodesModalLabel">
                    <i class="fas fa-key me-2"></i>
                    Recovery Codes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Important:</strong> Store these recovery codes in a safe place. You can use them to access your account if you lose your authenticator device.
                </div>
                <div class="recovery-codes-container">
                    <div class="row" id="recoveryCodesList">
                        <!-- Recovery codes will be populated here -->
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-outline-secondary" onclick="downloadRecoveryCodes()">
                        <i class="fas fa-download me-2"></i>
                        Download as Text
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="printRecoveryCodes()">
                        <i class="fas fa-print me-2"></i>
                        Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="custom-toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Success!</strong>
            <button type="button" class="btn-close btn-close-white" onclick="hideToast()" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>
        <div class="toast-body" id="toastMessage">
            Security settings updated successfully!
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password strength checker
    const newPasswordInput = document.getElementById('new_password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            updatePasswordStrength(strength);
        });
    }
    
    // Form validation
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.classList.add('was-validated');
        });
    }
});

// Password strength calculation
function calculatePasswordStrength(password) {
    let score = 0;
    
    if (password.length >= 8) score += 1;
    if (password.match(/[a-z]/)) score += 1;
    if (password.match(/[A-Z]/)) score += 1;
    if (password.match(/[0-9]/)) score += 1;
    if (password.match(/[^a-zA-Z0-9]/)) score += 1;
    
    return score;
}

// Update password strength display
function updatePasswordStrength(strength) {
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    if (!strengthFill || !strengthText) return;
    
    const percentage = (strength / 5) * 100;
    let color = '#dc3545';
    let text = 'Very Weak';
    
    if (strength >= 4) {
        color = '#28a745';
        text = 'Strong';
    } else if (strength >= 3) {
        color = '#ffc107';
        text = 'Good';
    } else if (strength >= 2) {
        color = '#fd7e14';
        text = 'Weak';
    }
    
    strengthFill.style.width = percentage + '%';
    strengthFill.style.backgroundColor = color;
    strengthText.textContent = text;
    strengthText.style.color = color;
}

// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Two-Factor Authentication
let currentStep = 1;
let qrCodeData = null;

function setup2FA() {
    // Show the modal and start with step 1
    currentStep = 1;
    showStep(1);
    showModal('twoFactorModal');
    
    // Initialize 2FA setup
    fetch('/account/security/2fa/setup', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qrCodeData = data;
            // Store the secret temporarily for verification
            localStorage.setItem('temp_2fa_secret', data.secret);
            showToast('2FA setup initiated successfully', 'success');
        } else {
            showToast(data.message || 'Failed to initiate 2FA setup', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while setting up 2FA', 'error');
    });
}

function nextStep() {
    if (currentStep < 3) {
        document.getElementById(`step${currentStep}`).classList.remove('active');
        currentStep++;
        showStep(currentStep);
        
        // If moving to step 2, generate QR code
        if (currentStep === 2 && qrCodeData) {
            generateQRCode(qrCodeData.qr_code_url);
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        document.getElementById(`step${currentStep}`).classList.remove('active');
        currentStep--;
        showStep(currentStep);
    }
}

function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.setup-step').forEach(s => s.classList.remove('active'));
    // Show current step
    document.getElementById(`step${step}`).classList.add('active');
}

function generateQRCode(qrCodeUrl) {
    const qrContainer = document.querySelector('.qr-code-container');
    qrContainer.innerHTML = `
        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(qrCodeUrl)}" 
                 alt="QR Code" class="img-fluid">
            <p class="mt-2 text-muted">Scan this QR code with your authenticator app</p>
        </div>
    `;
}

function verify2FA() {
    const code = document.getElementById('verificationCode').value;
    if (code.length === 6 && /^\d{6}$/.test(code)) {
        // Verify the code with the backend
        fetch('/account/security/2fa/verify', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                verification_code: code
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Two-factor authentication enabled successfully!', 'success');
                hideModal('twoFactorModal');
                // Clear temporary data
                localStorage.removeItem('temp_2fa_secret');
                location.reload(); // Refresh to show updated status
            } else {
                showToast(data.message || 'Invalid verification code', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while verifying 2FA', 'error');
        });
    } else {
        showToast('Please enter a valid 6-digit code', 'error');
    }
}

function disable2FA() {
    if (confirm('Are you sure you want to disable two-factor authentication? This will make your account less secure.')) {
        fetch('/account/security/2fa/disable', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Two-factor authentication disabled successfully!', 'success');
                location.reload(); // Refresh to show updated status
            } else {
                showToast(data.message || 'Failed to disable 2FA', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while disabling 2FA', 'error');
        });
    }
}

function viewRecoveryCodes() {
    fetch('/account/security/2fa/recovery-codes', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayRecoveryCodes(data.recovery_codes);
            showModal('recoveryCodesModal');
        } else {
            showToast(data.message || 'Failed to retrieve recovery codes', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while retrieving recovery codes', 'error');
    });
}

function displayRecoveryCodes(codes) {
    const container = document.getElementById('recoveryCodesList');
    container.innerHTML = '';
    
    codes.forEach((code, index) => {
        const col = document.createElement('div');
        col.className = 'col-md-auto mb-2';
        col.innerHTML = `
            <button type="button" class="btn btn-outline-secondary recovery-code-btn" 
                    onclick="copyToClipboard('${code}')" 
                    title="Click to copy">
                <code>${code}</code>
            </button>
        `;
        container.appendChild(col);
    });
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Recovery code copied to clipboard!', 'success');
    }).catch(() => {
        showToast('Failed to copy to clipboard', 'error');
    });
}

function downloadRecoveryCodes() {
    const codes = Array.from(document.querySelectorAll('.recovery-code-btn code')).map(code => code.textContent);
    const content = `Recovery Codes for ${window.location.hostname}\n\n${codes.join('\n')}\n\nGenerated on: ${new Date().toLocaleString()}`;
    
    const blob = new Blob([content], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'recovery-codes.txt';
    a.click();
    URL.revokeObjectURL(url);
}

function printRecoveryCodes() {
    const codes = Array.from(document.querySelectorAll('.recovery-code-btn code')).map(code => code.textContent);
    const content = `Recovery Codes for ${window.location.hostname}\n\n${codes.join('\n')}\n\nGenerated on: ${new Date().toLocaleString()}`;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Recovery Codes</title>
                <style>
                    body { font-family: monospace; padding: 20px; }
                    .code { font-size: 18px; margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
                </style>
            </head>
            <body>
                <h2>Recovery Codes</h2>
                <p><strong>Website:</strong> ${window.location.hostname}</p>
                <p><strong>Generated:</strong> ${new Date().toLocaleString()}</p>
                <hr>
                ${codes.map(code => `<div class="code">${code}</div>`).join('')}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Session management
function terminateSession(sessionId) {
    if (confirm('Are you sure you want to terminate this session?')) {
        // Here you would make an AJAX call to terminate the session
        showToast('Session terminated successfully', 'success');
    }
}

function terminateAllSessions() {
    if (confirm('Are you sure you want to terminate all other sessions? You will remain logged in on this device.')) {
        fetch('/account/security/sessions/terminate-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('All other sessions terminated successfully', 'success');
                location.reload(); // Refresh to show updated status
            } else {
                showToast(data.message || 'Failed to terminate sessions', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while terminating sessions', 'error');
        });
    }
}

// Show toast notification
function showToast(message, type = 'info') {
    const toast = document.getElementById('successToast');
    const toastMessage = document.getElementById('toastMessage');
    
    if (toast && toastMessage) {
        toastMessage.textContent = message;
        
        if (type === 'error') {
            toast.querySelector('.toast-header').className = 'toast-header bg-danger text-white';
        } else if (type === 'success') {
            toast.querySelector('.toast-header').className = 'toast-header bg-success text-white';
        } else if (type === 'info') {
            toast.querySelector('.toast-header').className = 'toast-header bg-info text-white';
        }
        
        // Show the toast
        toast.style.display = 'block';
        toast.classList.add('show');
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            hideToast();
        }, 5000);
    }
}

// Hide toast notification
function hideToast() {
    const toast = document.getElementById('successToast');
    if (toast) {
        toast.classList.add('hiding');
        setTimeout(() => {
            toast.classList.remove('show', 'hiding');
            toast.style.display = 'none';
        }, 300);
    }
}

// Custom Modal Functions
function showModal(modalId) {
    const modalElement = document.getElementById(modalId);
    if (modalElement) {
        modalElement.style.display = 'block';
        modalElement.classList.add('show');
        document.body.classList.add('modal-open');
        
        // Add backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop';
        backdrop.id = 'modalBackdrop';
        document.body.appendChild(backdrop);
        
        // Close modal when clicking backdrop
        backdrop.addEventListener('click', () => hideModal(modalId));
        
        // Close modal when pressing Escape
        const escapeHandler = (e) => {
            if (e.key === 'Escape') {
                hideModal(modalId);
            }
        };
        document.addEventListener('keydown', escapeHandler);
        modalElement.dataset.escapeHandler = escapeHandler;
    }
}

function hideModal(modalId) {
    const modalElement = document.getElementById(modalId);
    if (modalElement) {
        modalElement.classList.remove('show');
        setTimeout(() => {
            modalElement.style.display = 'none';
        }, 300);
        
        document.body.classList.remove('modal-open');
        
        // Remove backdrop
        const backdrop = document.getElementById('modalBackdrop');
        if (backdrop) {
            backdrop.remove();
        }
        
        // Remove escape handler
        if (modalElement.dataset.escapeHandler) {
            document.removeEventListener('keydown', modalElement.dataset.escapeHandler);
            delete modalElement.dataset.escapeHandler;
        }
    }
}
</script>
@endsection 

<style>
/* Security Page Styles */

/* Security Header */
.security-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
}

.security-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.security-subtitle {
    font-size: 1.1rem;
    margin: 0;
    opacity: 0.9;
}

.security-status .badge {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
}

/* Security Overview Cards */
.security-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f1f3f4;
    transition: all 0.3s ease;
    height: 100%;
}

.security-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.security-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-bottom: 1rem;
}

.security-card-content h5 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #1a1a1a;
}

.security-card-content p {
    font-size: 0.9rem;
    margin: 0;
    line-height: 1.4;
}

/* Security Sections */
.security-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f3f4;
}

.section-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.section-content h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.2;
}

.section-content p {
    margin: 0.25rem 0 0 0;
    color: #5f6368;
    font-size: 0.95rem;
    line-height: 1.4;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* Form Fields */
.form-field {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.field-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: #1a1a1a;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.field-label i {
    color: #5f6368;
    font-size: 0.9rem;
    width: 16px;
    text-align: center;
}

/* Password Input Group */
.password-input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.password-input-group .form-input {
    padding-right: 3rem;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    background: none;
    border: none;
    color: #5f6368;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.password-toggle:hover {
    background: #f1f3f4;
    color: #1a1a1a;
}

/* Form Inputs */
.form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e8eaed;
    border-radius: 12px;
    font-size: 1rem;
    line-height: 1.5;
    color: #1a1a1a;
    background: #ffffff;
    transition: all 0.2s ease;
    font-family: inherit;
}

.form-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.form-input:hover {
    border-color: #dadce0;
}

/* Password Strength */
.password-strength {
    margin-top: 0.75rem;
}

.strength-bar {
    width: 100%;
    height: 8px;
    background: #f1f3f4;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.strength-fill {
    height: 100%;
    width: 0%;
    background: #dc3545;
    transition: all 0.3s ease;
    border-radius: 4px;
}

.strength-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: #5f6368;
}

/* Field Errors */
.field-error {
    color: #d93025;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.field-error::before {
    content: "⚠️";
    font-size: 0.75rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-start;
    gap: 1rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.5rem;
    border: 2px solid transparent;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: inherit;
    line-height: 1.5;
}

.btn:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-outline-danger {
    background: transparent;
    color: #dc3545;
    border-color: #dc3545;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
    transform: translateY(-1px);
}

.btn-outline-warning {
    background: transparent;
    color: #ffc107;
    border-color: #ffc107;
}

.btn-outline-warning:hover {
    background: #ffc107;
    color: #1a1a1a;
    transform: translateY(-1px);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Two-Factor Authentication */
.two-factor-status {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-radius: 16px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.two-factor-status.enabled {
    background: #f0f9ff;
    border-color: #0ea5e9;
}

.two-factor-status.disabled {
    background: #fef2f2;
    border-color: #ef4444;
}

.status-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.two-factor-status.enabled .status-icon {
    background: #10b981;
}

.two-factor-status.disabled .status-icon {
    background: #f59e0b;
}

.status-text h5 {
    margin: 0 0 0.25rem 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
}

.status-text p {
    margin: 0;
    font-size: 0.9rem;
    color: #5f6368;
}

/* Active Sessions */
.sessions-list {
    margin-bottom: 1.5rem;
}

.session-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border: 1px solid #f1f3f4;
    border-radius: 12px;
    margin-bottom: 1rem;
    background: #fafbfc;
    transition: all 0.2s ease;
}

.session-item:hover {
    background: #f1f3f4;
    border-color: #dadce0;
}

.session-item.current {
    background: #f0f9ff;
    border-color: #0ea5e9;
}

.session-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.session-icon {
    width: 40px;
    height: 40px;
    background: #e8eaed;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5f6368;
    font-size: 1rem;
}

.session-details h6 {
    margin: 0 0 0.25rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
}

.session-details p {
    margin: 0 0 0.25rem 0;
    font-size: 0.875rem;
    color: #5f6368;
}

.session-details small {
    font-size: 0.8rem;
    color: #9aa0a6;
}

.session-status .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
}

.session-actions-global {
    text-align: center;
}

/* Security Tips */
.security-tips {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f1f3f4;
}

.tips-header h5 {
    margin: 0 0 1rem 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    display: flex;
    align-items: center;
}

.tips-content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.tip-icon {
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.tip-text strong {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.25rem;
}

.tip-text p {
    margin: 0;
    font-size: 0.8rem;
    color: #5f6368;
    line-height: 1.4;
}

/* Security Activity */
.security-activity {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f1f3f4;
}

.activity-header h5 {
    margin: 0 0 1rem 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    display: flex;
    align-items: center;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 8px;
    background: #fafbfc;
    transition: all 0.2s ease;
}

.activity-item:hover {
    background: #f1f3f4;
}

.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.activity-content h6 {
    margin: 0 0 0.25rem 0;
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a1a1a;
}

.activity-content p {
    margin: 0;
    font-size: 0.8rem;
    color: #5f6368;
}

/* Two-Factor Setup Modal */
.two-factor-setup {
    padding: 1rem 0;
}

.setup-step {
    display: none;
    text-align: center;
}

.setup-step.active {
    display: block;
}

.setup-step h6 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.setup-step p {
    color: #5f6368;
    margin-bottom: 1.5rem;
}

.authenticator-apps {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.app-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.app-badge {
    height: 40px;
    width: auto;
}

.app-item span {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a1a1a;
}

.qr-code-container {
    margin: 2rem 0;
}

.qr-code-placeholder {
    padding: 2rem;
    background: #fafbfc;
    border-radius: 12px;
    border: 2px dashed #dadce0;
}

.verification-code {
    margin: 2rem 0;
}

.verification-code input {
    font-size: 1.5rem;
    letter-spacing: 0.5rem;
    text-align: center;
    font-weight: 700;
}

/* Recovery Codes Modal */
.recovery-codes-container {
    margin-top: 1.5rem;
}

.recovery-codes-container .row {
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.recovery-codes-container .row .col-md-auto {
    flex: 0 0 auto;
}

.recovery-codes-container .row .col-md-auto .btn {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}

.recovery-code-btn {
    font-family: 'Courier New', monospace;
    min-width: 140px;
    transition: all 0.2s ease;
}

.recovery-code-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.recovery-code-btn code {
    font-size: 0.8rem;
    color: #495057;
}

.recovery-code-btn:hover code {
    color: #212529;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .security-header {
        padding: 1.5rem;
    }
    
    .security-title {
        font-size: 2rem;
    }
    
    .security-card {
        padding: 1.25rem;
    }
    
    .security-section {
        padding: 1.5rem;
    }
}

@media (max-width: 768px) {
    .security-header {
        padding: 1rem;
        text-align: center;
    }
    
    .security-title {
        font-size: 1.75rem;
    }
    
    .security-status {
        margin-top: 1rem;
    }
    
    .section-header {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .section-content h3 {
        font-size: 1.25rem;
    }
    
    .two-factor-status {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .status-content {
        flex-direction: column;
        text-align: center;
    }
    
    .session-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .session-info {
        width: 100%;
    }
    
    .session-status,
    .session-actions {
        align-self: flex-end;
    }
    
    .form-actions {
        justify-content: center;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .security-header {
        padding: 1rem 0.5rem;
    }
    
    .security-title {
        font-size: 1.5rem;
    }
    
    .security-card {
        padding: 1rem;
    }
    
    .security-section {
        padding: 1rem;
    }
    
    .authenticator-apps {
        flex-direction: column;
        gap: 1rem;
    }
    
    .app-item {
        flex-direction: row;
        justify-content: center;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .security-card,
    .security-section,
    .security-tips,
    .security-activity {
        background: #1a1a1a;
        border-color: #2d2d2d;
    }
    
    .security-card:hover {
        background: #2d2d2d;
    }
    
    .security-card-content h5,
    .section-content h3,
    .tips-header h5,
    .activity-header h5,
    .status-text h5,
    .session-details h6,
    .tip-text strong {
        color: #ffffff;
    }
    
    .security-card-content p,
    .section-content p,
    .tip-text p,
    .activity-content p {
        color: #9aa0a6;
    }
    
    .session-item {
        background: #2d2d2d;
        border-color: #3c4043;
    }
    
    .session-item:hover {
        background: #3c4043;
    }
    
    .session-item.current {
        background: #0f172a;
        border-color: #0ea5e9;
    }
    
    .two-factor-status.enabled {
        background: #0f172a;
        border-color: #0ea5e9;
    }
    
    .two-factor-status.disabled {
        background: #1f1f1f;
        border-color: #ef4444;
    }
    
    .activity-item {
        background: #2d2d2d;
    }
    
    .activity-item:hover {
        background: #3c4043;
    }
    
    .qr-code-placeholder {
        background: #2d2d2d;
        border-color: #3c4043;
    }
}

/* Accessibility Improvements */
@media (prefers-reduced-motion: reduce) {
    .security-card,
    .security-section,
    .btn,
    .session-item {
        transition: none;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    .form-input,
    .btn {
        border-width: 3px;
    }
    
    .security-card,
    .security-section {
        border-width: 3px;
    }
}

/* Custom Toast Styles */
.toast-container {
    z-index: 9999;
}

.custom-toast {
    display: none;
    min-width: 300px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    border: 1px solid #e8eaed;
    overflow: hidden;
    transform: translateX(100%);
    transition: transform 0.3s ease;
}

.custom-toast.show {
    transform: translateX(0);
}

.toast-header {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
}

.toast-header .btn-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0;
    margin-left: auto;
    line-height: 1;
}

.toast-header .btn-close:hover {
    opacity: 0.8;
}

.toast-body {
    padding: 1rem;
    color: #1a1a1a;
    font-size: 0.95rem;
    line-height: 1.4;
}

/* Toast Animation */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.custom-toast.show {
    animation: slideInRight 0.3s ease forwards;
}

.custom-toast.hiding {
    animation: slideOutRight 0.3s ease forwards;
}

/* Custom Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal.show {
    opacity: 1;
}

.modal-dialog {
    position: relative;
    width: auto;
    margin: 1.75rem auto;
    max-width: 500px;
    transform: translateY(-50px);
    transition: transform 0.3s ease;
}

.modal.show .modal-dialog {
    transform: translateY(0);
}

.modal-content {
    position: relative;
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

.modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #212529;
}

.modal-body {
    padding: 1rem;
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
}

.modal-open {
    overflow: hidden;
}

/* Modal Close Button */
.btn-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    font-weight: bold;
    color: #000;
    cursor: pointer;
    padding: 0;
    line-height: 1;
    opacity: 0.5;
    transition: opacity 0.15s ease;
}

.btn-close:hover {
    opacity: 0.75;
}

.btn-close-white {
    color: #fff;
}
</style> 