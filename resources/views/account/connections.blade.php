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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="mb-1">Connected Accounts</h3>
                            <p class="text-muted mb-0">Manage your external account connections and trading pairs</p>
                        </div>
                        <div class="connection-status">
                            <span class="badge bg-success">Connected</span>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Twitter Connection Card -->
                        <div class="col-lg-4 col-md-6">
                            <div class="connection-card twitter-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="connection-icon mb-3">
                                        <i class="fab fa-twitter fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="card-title mb-2">Twitter Account</h5>
                                    <p class="card-text text-muted mb-3">
                                        Connect your Twitter account to receive real-time crypto updates and social sentiment analysis
                                    </p>
                                    <div class="connection-status mb-3">
                                        <span class="badge bg-success">Connected</span>
                                        <small class="text-muted d-block mt-1">@cryptotrading</small>
                                    </div>
                                    <a href="{{ route('twitter.index') }}" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-cog me-2"></i>Manage Connection
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Telegram Connection Card -->
                        <div class="col-lg-4 col-md-6">
                            <div class="connection-card telegram-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="connection-icon mb-3">
                                        <i class="fab fa-telegram-plane fa-3x text-info"></i>
                                    </div>
                                    <h5 class="card-title mb-2">Telegram Account</h5>
                                    <p class="card-text text-muted mb-3">
                                        Link your Telegram account for instant notifications and crypto trading signals
                                    </p>
                                    <div class="connection-status mb-3">
                                        <span class="badge bg-success">Connected</span>
                                        <small class="text-muted d-block mt-1">@cryptotrading_bot</small>
                                    </div>
                                    <a href="{{ route('telegram.index') }}" class="btn btn-info btn-sm w-100">
                                        <i class="fas fa-cog me-2"></i>Manage Connection
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Trading Pairs Card -->
                        <div class="col-lg-4 col-md-6">
                            <div class="connection-card trading-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="connection-icon mb-3">
                                        <i class="fas fa-chart-line fa-3x text-success"></i>
                                    </div>
                                    <h5 class="card-title mb-2">Trading Pairs</h5>
                                    <p class="card-text text-muted mb-3">
                                        Configure your preferred trading pairs and market analysis preferences
                                    </p>
                                    <div class="connection-status mb-3">
                                        <span class="badge bg-warning">Configure</span>
                                        <small class="text-muted d-block mt-1">5 pairs configured</small>
                                    </div>
                                    <a href="{{ route('tradingPairs.index') }}" class="btn btn-success btn-sm w-100">
                                        <i class="fas fa-cog me-2"></i>Manage Pairs
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{--<!-- Exchange API Connections -->--}}
                        {{--<div class="col-lg-4 col-md-6">--}}
                            {{--<div class="connection-card exchange-card h-100">--}}
                                {{--<div class="card-body text-center p-4">--}}
                                    {{--<div class="connection-icon mb-3">--}}
                                        {{--<i class="fas fa-exchange-alt fa-3x text-warning"></i>--}}
                                    {{--</div>--}}
                                    {{--<h5 class="card-title mb-2">Exchange APIs</h5>--}}
                                    {{--<p class="card-text text-muted mb-3">--}}
                                        {{--Connect your exchange accounts for automated trading and portfolio tracking--}}
                                    {{--</p>--}}
                                    {{--<div class="connection-status mb-3">--}}
                                        {{--<span class="badge bg-secondary">Not Connected</span>--}}
                                        {{--<small class="text-muted d-block mt-1">0 exchanges connected</small>--}}
                                    {{--</div>--}}
                                    {{--<a href="{{ route('account.api_keys') }}" class="btn btn-warning btn-sm w-100">--}}
                                        {{--<i class="fas fa-plus me-2"></i>Add Exchange--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<!-- Portfolio Tracking -->--}}
                        {{--<div class="col-lg-4 col-md-6">--}}
                            {{--<div class="connection-card portfolio-card h-100">--}}
                                {{--<div class="card-body text-center p-4">--}}
                                    {{--<div class="connection-icon mb-3">--}}
                                        {{--<i class="fas fa-wallet fa-3x text-purple"></i>--}}
                                    {{--</div>--}}
                                    {{--<h5 class="card-title mb-2">Portfolio Tracking</h5>--}}
                                    {{--<p class="card-text text-muted mb-3">--}}
                                        {{--Track your crypto portfolio performance and set up automated alerts--}}
                                    {{--</p>--}}
                                    {{--<div class="connection-status mb-3">--}}
                                        {{--<span class="badge bg-info">Active</span>--}}
                                        {{--<small class="text-muted d-block mt-1">Portfolio monitored</small>--}}
                                    {{--</div>--}}
                                    {{--<button class="btn btn-purple btn-sm w-100" disabled>--}}
                                        {{--<i class="fas fa-eye me-2"></i>View Portfolio--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<!-- News & Alerts -->--}}
                        {{--<div class="col-lg-4 col-md-6">--}}
                            {{--<div class="connection-card news-card h-100">--}}
                                {{--<div class="card-body text-center p-4">--}}
                                    {{--<div class="connection-icon mb-3">--}}
                                        {{--<i class="fas fa-bell fa-3x text-danger"></i>--}}
                                    {{--</div>--}}
                                    {{--<h5 class="card-title mb-2">News & Alerts</h5>--}}
                                    {{--<p class="card-text text-muted mb-3">--}}
                                        {{--Stay updated with latest crypto news and price alerts--}}
                                    {{--</p>--}}
                                    {{--<div class="connection-status mb-3">--}}
                                        {{--<span class="badge bg-success">Active</span>--}}
                                        {{--<small class="text-muted d-block mt-1">Daily digest enabled</small>--}}
                                    {{--</div>--}}
                                    {{--<button class="btn btn-danger btn-sm w-100" disabled>--}}
                                        {{--<i class="fas fa-cog me-2"></i>Configure Alerts--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>

                    <!-- Connection Statistics -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Connection Overview</h6>
                                    <div class="row text-center">
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="stat-item">
                                                <h4 class="text-primary mb-1">3</h4>
                                                <small class="text-muted">Active Connections</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="stat-item">
                                                <h4 class="text-success mb-1">2</h4>
                                                <small class="text-muted">Fully Configured</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="stat-item">
                                                <h4 class="text-warning mb-1">1</h4>
                                                <small class="text-muted">Needs Setup</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <div class="stat-item">
                                                <h4 class="text-info mb-1">24/7</h4>
                                                <small class="text-muted">Monitoring</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Connection Cards Styling */
.connection-card {
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    transition: all 0.3s ease;
    background: #ffffff;
    overflow: hidden;
}

.connection-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    border-color: #667eea;
}

.connection-card .card-body {
    position: relative;
}

.connection-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.connection-status {
    margin: 1rem 0;
}

.connection-status .badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
}

/* Card-specific hover effects */
.twitter-card:hover {
    border-color: #1da1f2;
}

.telegram-card:hover {
    border-color: #0088cc;
}

.trading-card:hover {
    border-color: #10b981;
}

.exchange-card:hover {
    border-color: #f59e0b;
}

.portfolio-card:hover {
    border-color: #8b5cf6;
}

.news-card:hover {
    border-color: #ef4444;
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

.btn-purple {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    border: none;
    color: white;
}

.btn-purple:hover {
    background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
    color: white;
}

/* Statistics section */
.stat-item h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-item small {
    font-size: 0.875rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .connection-card {
        margin-bottom: 1rem;
    }
    
    .connection-icon {
        height: 60px;
    }
    
    .connection-icon i {
        font-size: 2rem !important;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .col-md-6 {
        margin-bottom: 1rem;
    }
    
    .connection-card .card-body {
        padding: 1rem !important;
    }
    
    .connection-icon {
        height: 50px;
        margin-bottom: 0.75rem;
    }
    
    .connection-icon i {
        font-size: 1.75rem !important;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .connection-card {
        background: #1f2937;
        border-color: #374151;
        color: #f9fafb;
    }
    
    .connection-card .card-text {
        color: #d1d5db !important;
    }
    
    .bg-light {
        background-color: #374151 !important;
        color: #f9fafb;
    }
}
</style>
@endsection 