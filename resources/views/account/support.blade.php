@extends('layouts.base')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">@include('account._sidebar')</div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="support-icon mb-3">
                            <i class="fas fa-headset fa-4x text-primary"></i>
                        </div>
                        <h3 class="mb-2">Need Help?</h3>
                        <p class="text-muted mb-0">We're here to help you get the most out of your crypto trading experience</p>
                    </div>

                    <div class="row g-4 mb-4">
                        <!-- Quick Help Section -->
                        <div class="col-lg-6">
                            <div class="help-card">
                                <div class="card-body text-center p-4">
                                    <div class="help-icon mb-3">
                                        <i class="fas fa-question-circle fa-3x text-info"></i>
                                    </div>
                                    <h5 class="card-title mb-2">Quick Help</h5>
                                    <p class="card-text text-muted mb-3">
                                        Find answers to common questions and learn how to use our platform effectively
                                    </p>
                                    <div class="help-links">
                                        <a href="#" class="btn btn-outline-info btn-sm me-2 mb-2">
                                            <i class="fas fa-book me-1"></i>Documentation
                                        </a>
                                        <a href="#" class="btn btn-outline-info btn-sm me-2 mb-2">
                                            <i class="fas fa-video me-1"></i>Video Tutorials
                                        </a>
                                        <a href="#" class="btn btn-outline-info btn-sm mb-2">
                                            <i class="fas fa-question me-1"></i>FAQ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Support Section -->
                        <div class="col-lg-6">
                            <div class="help-card">
                                <div class="card-body text-center p-4">
                                    <div class="help-icon mb-3">
                                        <i class="fas fa-envelope fa-3x text-success"></i>
                                    </div>
                                    <h5 class="card-title mb-2">Contact Support</h5>
                                    <p class="card-text text-muted mb-3">
                                        Send us your feedback, report issues, or ask questions directly
                                    </p>
                                    <a href="{{ route('about', '#contactUs') }}" class="btn btn-success btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i>Send Feedback
                                    </a>
                                    <small class="text-muted d-block mt-2">You'll be redirected to our feedback form</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support Information -->
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                        Support Information
                                    </h6>
                                    <div class="row text-center">
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="support-stat">
                                                <h4 class="text-primary mb-1">24/7</h4>
                                                <small class="text-muted">Platform Monitoring</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="support-stat">
                                                <h4 class="text-success mb-1">Fast</h4>
                                                <small class="text-muted">Response Time</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="support-stat">
                                                <h4 class="text-info mb-1">Free</h4>
                                                <small class="text-muted">Support Included</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="support-stat">
                                                <h4 class="text-warning mb-1">Expert</h4>
                                                <small class="text-muted">Crypto Knowledge</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alternative Contact Methods -->
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="fas fa-phone-alt me-2 text-primary"></i>
                                        Other Ways to Reach Us
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="contact-method text-center">
                                                <div class="contact-icon mb-2">
                                                    <i class="fas fa-envelope fa-2x text-primary"></i>
                                                </div>
                                                <h6>Email</h6>
                                                <p class="text-muted mb-2">Direct email support</p>
                                                <a href="mailto:innatarasyanmail@gmail.com" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-envelope me-1"></i>Send Email
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="contact-method text-center">
                                                <div class="contact-icon mb-2">
                                                    <i class="fab fa-telegram fa-2x text-info"></i>
                                                </div>
                                                <h6>Telegram</h6>
                                                <p class="text-muted mb-2">Quick chat support</p>
                                                <a href="https://t.me/innatarasyan" target="_blank" class="btn btn-outline-info btn-sm">
                                                    <i class="fab fa-telegram me-1"></i>Message Us
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="contact-method text-center">
                                                <div class="contact-icon mb-2">
                                                    <i class="fab fa-github fa-2x text-dark"></i>
                                                </div>
                                                <h6>GitHub</h6>
                                                <p class="text-muted mb-2">Report technical issues</p>
                                                <a href="https://github.com/innatarasyan" target="_blank" class="btn btn-outline-dark btn-sm">
                                                    <i class="fab fa-github me-1"></i>View Repository
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Call to Action -->
                    <div class="text-center mt-4">
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Pro Tip:</strong> For the best support experience, use our feedback form which will take you directly to the contact section of our about page.
                        </div>
                        <a href="{{ route('about', '#contactUs') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-arrow-right me-2"></i>Go to Feedback Form
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Support Page Styling */
.support-icon {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.help-card {
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    transition: all 0.3s ease;
    background: #ffffff;
    height: 100%;
}

.help-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    border-color: #667eea;
}

.help-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.help-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
}

.contact-method {
    padding: 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.contact-method:hover {
    background: #f8fafc;
    transform: translateY(-2px);
}

.contact-icon {
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.support-stat h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.support-stat small {
    font-size: 0.875rem;
}

/* Button styling */
.btn {
    border-radius: 8px;
    font-weight: 600;
    text-transform: none;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .support-icon {
        height: 80px;
    }
    
    .support-icon i {
        font-size: 3rem !important;
    }
    
    .help-icon {
        height: 60px;
    }
    
    .help-icon i {
        font-size: 2rem !important;
    }
    
    .help-links {
        flex-direction: column;
        align-items: center;
    }
    
    .help-links .btn {
        width: 100%;
        max-width: 200px;
    }
}

@media (max-width: 576px) {
    .support-icon {
        height: 60px;
        margin-bottom: 1rem;
    }
    
    .support-icon i {
        font-size: 2.5rem !important;
    }
    
    .help-card .card-body {
        padding: 1.5rem !important;
    }
    
    .contact-method {
        padding: 0.75rem;
    }
    
    .btn-lg {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .help-card {
        background: #1f2937;
        border-color: #374151;
        color: #f9fafb;
    }
    
    .help-card .card-text {
        color: #d1d5db !important;
    }
    
    .bg-light {
        background-color: #374151 !important;
        color: #f9fafb;
    }
    
    .contact-method:hover {
        background: #4b5563;
    }
}
</style>
@endsection 