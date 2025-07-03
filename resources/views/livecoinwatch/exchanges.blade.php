@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/exchanges.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="m-content">
        <!-- Modern Title Bar with Icon and Dark Mode Button -->
        <div class="modern-title-bar">
            <div class="m-portlet__head-title custom-modern">
                <span class="modern-title-icon">
                    <!-- Exchange Icon SVG -->
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="4" width="24" height="24" rx="8" fill="#43cea2"/>
                        <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="modern-title-text">Livecoin Exchanges</span>
            </div>
            <button id="darkModeToggle" class="modern-tab darkmode-switch" title="Toggle dark mode" role="switch" aria-checked="false">
                <span class="darkmode-switch-icon" id="darkModeIcon">
                    <!-- Sun & Moon SVG for animation -->
                    <svg class="icon-moon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" fill="#ffd200"/>
                    </svg>
                    <svg class="icon-sun" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="5" fill="#ffb300"/>
                        <g stroke="#ffb300" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="3"/>
                            <line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/>
                            <line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </g>
                    </svg>
                </span>
                <span id="darkModeText" class="darkmode-switch-label">Dark Mode</span>
            </button>
        </div>
        <!-- Navigation Tabs -->
        <div class="modern-tabs-container gradient-tabs-bg">
            <nav class="modern-tabs beautiful-tabs" aria-label="Main navigation">
                <a href="/" class="modern-tab beautiful-tab {{ request()->is('/') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- History Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 7v5l4 2" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    <span class="tab-label">History</span>
                </a>
                <a href="/livecoinexchangesindex" class="modern-tab beautiful-tab {{ request()->is('livecoinexchangesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Exchange Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#43cea2"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        </span>
                    <span class="tab-label">Exchanges</span>
                </a>
                <a href="/livecoinfiatsindex" class="modern-tab beautiful-tab {{ request()->is('livecoinfiatsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Fiat Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff512f"/><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>
                        </span>
                    <span class="tab-label">Fiats</span>
                </a>
            </nav>
        </div>
        <!-- Action Buttons -->
        <div class="action-buttons-row" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="action-buttons-left">
                <button id="refreshTable" class="modern-tab refresh-btn modern-refresh-btn-upgraded" title="Refresh Table" aria-label="Refresh Table" aria-busy="false" aria-disabled="false" tabindex="0" style="overflow:hidden; position:relative;">
                    <span class="refresh-btn-icon" style="position:relative; display:inline-flex; align-items:center; justify-content:center;">
                        <!-- Modern Bold Refresh SVG (upgraded) with white background -->
                        <span class="refresh-icon-bg">
                            <svg class="icon-refresh-upgraded" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="refreshGradientModernUpgraded" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#43cea2"/>
                                        <stop offset="1" stop-color="#185a9d"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="16" cy="16" r="15" fill="#fff"/>
                                <path d="M25 10A12 12 0 1 0 27 16h-2.5" stroke="url(#refreshGradientModernUpgraded)" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <polyline points="24 4 24 11 31 11" stroke="url(#refreshGradientModernUpgraded)" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        </span>
                        <span class="refresh-spinner" style="display:none; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); z-index:2;">
                            <svg width="28" height="28" viewBox="0 0 50 50">
                                <circle cx="25" cy="25" r="20" fill="none" stroke="#43cea2" stroke-width="5" stroke-linecap="round" stroke-dasharray="31.4 31.4" stroke-dashoffset="0">
                                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/>
                                </circle>
                            </svg>
                        </span>
                    </span>
                    <span class="refresh-btn-label">Refresh</span>
                    <span class="ripple-effect"></span>
                </button>
            </div>
            <div class="action-buttons-right">
                <button id="fullscreenToggle" class="modern-tab fullscreen-switch modern-fullscreen-btn" title="Toggle Fullscreen" aria-label="Toggle Fullscreen" aria-pressed="false" role="button" tabindex="0">
                    <span class="fullscreen-icon-bg">
                        <!-- Enter Fullscreen SVG -->
                        <svg class="icon-fullscreen" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="7" height="2" rx="1" fill="#0d6efd"/>
                            <rect x="3" y="3" width="2" height="7" rx="1" fill="#0d6efd"/>
                            <rect x="14" y="3" width="7" height="2" rx="1" fill="#0d6efd"/>
                            <rect x="19" y="3" width="2" height="7" rx="1" fill="#0d6efd"/>
                            <rect x="3" y="19" width="7" height="2" rx="1" fill="#0d6efd"/>
                            <rect x="3" y="14" width="2" height="7" rx="1" fill="#0d6efd"/>
                            <rect x="14" y="19" width="7" height="2" rx="1" fill="#0d6efd"/>
                            <rect x="19" y="14" width="2" height="7" rx="1" fill="#0d6efd"/>
                        </svg>
                        <!-- Exit Fullscreen SVG -->
                        <svg class="icon-exit-fullscreen" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <!-- Exit Fullscreen SVG (hidden by default) -->
                        <svg class="icon-exit-fullscreen" width="24" height="24" viewBox="0 0 24 24" fill="none" style="display:none;">
                            <rect x="5" y="11" width="14" height="2" rx="1" fill="#ff512f"/>
                            <rect x="11" y="5" width="2" height="14" rx="1" fill="#ff512f"/>
                        </svg>
                    </span>
                    <span id="fullscreenText" class="fullscreen-switch-label">Fullscreen</span>
                </button>
            </div>
        </div>
        <!-- DataTable Section -->
        <div class="m-portlet">
            <div class="m-portlet__body mt-5">
                <input type="hidden" id="livecoin_exchanges_route" value="{{ route('datatable.livecoin.exchanges') }}">
                <div id="datatableFullscreenContainer" class="table-responsive">
                    <div id="datatableLoading" class="datatable-loading" style="display:none; text-align:center; margin:2em;">
                        <div class="spinner-border text-warning" role="status" style="width:3rem;height:3rem;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <table id="livecoin_exchanges" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                            <th class="datatable-highlight-first">
                                <span class="datatable-header-icon">
                                    <!-- Exchange SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="8" fill="#43cea2"/>
                                        <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Name</span>
                            </th>
                            <th title="Exchange logo">
                                <span class="datatable-header-icon">
                                    <!-- Logo SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="6" fill="#ff512f"/>
                                        <circle cx="16" cy="16" r="8" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Image</span>
                            </th>
                            <th title="Number of markets">
                                <span class="datatable-header-icon">
                                    <!-- Markets SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#f7971e"/>
                                        <path d="M12 16h8M16 12v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Markets</span>
                            </th>
                            <th title="24h trading volume">
                                <span class="datatable-header-icon">
                                    <!-- Volume SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/>
                                        <text x="16" y="21" text-anchor="middle" font-size="16" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Volume</span>
                            </th>
                            <th title="Bid total">
                                <span class="datatable-header-icon">
                                    <!-- Bid SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#a8edea"/>
                                        <path d="M10 8h12M10 24h12M12 8c0 6 8 6 8 0M12 24c0-6 8-6 8 0" stroke="#185a9d" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">BidTotal</span>
                            </th>
                            <th title="Ask total">
                                <span class="datatable-header-icon">
                                    <!-- Ask SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#a8edea"/>
                                        <path d="M10 8h12M10 24h12M12 8c0 6 8 6 8 0M12 24c0-6 8-6 8 0" stroke="#185a9d" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">AskTotal</span>
                            </th>
                            <th title="Order book depth">
                                <span class="datatable-header-icon">
                                    <!-- Depth SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#43cea2"/>
                                        <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Depth</span>
                            </th>
                            <th title="Centralized">
                                <span class="datatable-header-icon">
                                    <!-- Centralized SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="14" fill="#ffd200"/>
                                        <circle cx="16" cy="16" r="10" fill="#fff"/>
                                        <circle cx="16" cy="16" r="7" fill="#ffd200"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Centralized</span>
                            </th>
                            <th title="US Compliant">
                                <span class="datatable-header-icon">
                                    <!-- US Compliant SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#43cea2"/>
                                        <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">UsCompliant</span>
                            </th>
                            <th title="Visitors">
                                <span class="datatable-header-icon">
                                    <!-- Visitors SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#f7971e"/>
                                        <path d="M12 16h8M16 12v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Visitors</span>
                            </th>
                            <th title="Volume per visitor">
                                <span class="datatable-header-icon">
                                    <!-- Volume per visitor SVG -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/>
                                        <text x="16" y="21" text-anchor="middle" font-size="16" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Volume Per Visitor</span>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Responsive Info Block: Live Coin Watch Exchanges -->
        <div class="modern-info-block-upgraded upgraded-gradient-bg" style="border-radius: 1.5em; box-shadow: 0 8px 32px 0 rgba(67, 206, 162, 0.18), 0 3px 12px 0 rgba(24, 90, 157, 0.13); padding: 2.2em 2em 2.2em 2em; margin-top: 2.5em; margin-bottom: 2.5em; color: #fff;">
            <!-- Paragraph 1: About Live Coin Watch Exchanges -->
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; margin-bottom: 2.2em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(24,90,157,0.10);">
                    <!-- Globe/Exchange Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="19" fill="#43cea2" stroke="#ffd200" stroke-width="2"/>
                        <path d="M12 20h16M20 12v16" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.25em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#ffd200;">Live Coin Watch Exchanges</span>: Your Real-Time Crypto Exchange Dashboard
                    </p>
                    <p class="info-desc" style="margin-bottom:0; font-size:1.08em; line-height:1.7;">
                        <span style="font-size:1.2em;">🌐</span> <b>Live Coin Watch Exchanges</b> is a powerful, real-time dashboard for comparing and monitoring the world's top cryptocurrency exchanges. Founded in 2013, it offers a user-friendly interface, supports 150+ cryptocurrencies and multiple fiat currencies, and provides up-to-date data on trading volume, liquidity, number of markets, and more.<br><br>
                        <span style="font-size:1.2em;">🔒</span> <b>Security & Transparency:</b> Robust security, transparent data, and competitive fees.<br>
                        <span style="font-size:1.2em;">🚀</span> <b>For Everyone:</b> Designed for both beginners and experienced traders to make informed decisions and discover the best platforms for their crypto journey.<br>
                        <span style="font-size:1.2em;">📊</span> <b>Global Access:</b> Access exchange data from anywhere, anytime, on any device.
                    </p>
                </div>
            </div>
            <!-- Paragraph 2: Datatable Explanation and Column Details -->
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(24,90,157,0.10);">
                    <!-- Table/Analytics Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="12" width="26" height="16" rx="4" fill="#ffd200" stroke="#fff" stroke-width="2"/>
                        <rect x="11" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="19" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="27" y="16" width="2" height="8" rx="1" fill="#fff"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.18em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#ffd200;">How to Use the Exchange Table</span>
                    </p>
                    <p style="font-size:1.08em; line-height:1.7; margin-bottom:1em;">
                        The table above provides a comprehensive overview of each exchange's key statistics. Use the column explanations below to better understand the data and make smarter trading decisions.
                    </p>
                    <ul class="datatable-columns-list" style="margin-bottom:0; font-size:1.08em; line-height:1.7; padding-left:1.2em; list-style:none;">
                        <li><span style="font-size:1.2em;">🔤</span> <b>Name:</b> The official name of the exchange.</li>
                        <li><span style="font-size:1.2em;">🖼️</span> <b>Image:</b> The logo or icon representing the exchange.</li>
                        <li><span style="font-size:1.2em;">📈</span> <b>Markets:</b> The number of active trading pairs or markets available on the exchange.</li>
                        <li><span style="font-size:1.2em;">💸</span> <b>Volume:</b> The total 24-hour trading volume on the exchange, usually in USD or selected currency.</li>
                        <li><span style="font-size:1.2em;">🟢</span> <b>BidTotal:</b> The total value of buy orders (bids) within 2% of the mid price in the order book, indicating liquidity on the buy side.</li>
                        <li><span style="font-size:1.2em;">🔴</span> <b>AskTotal:</b> The total value of sell orders (asks) within 2% of the mid price in the order book, indicating liquidity on the sell side.</li>
                        <li><span style="font-size:1.2em;">🌊</span> <b>Depth:</b> The combined value of bids and asks within 2% of the mid price, representing the order book depth and overall liquidity.</li>
                        <li><span style="font-size:1.2em;">🏢</span> <b>Centralized:</b> Indicates whether the exchange is centralized (true) or decentralized (false).</li>
                        <li><span style="font-size:1.2em;">🇺🇸</span> <b>UsCompliant:</b> Shows if the exchange complies with US regulations and is available to US users.</li>
                        <li><span style="font-size:1.2em;">👥</span> <b>Visitors:</b> The estimated number of daily visitors to the exchange platform.</li>
                        <li><span style="font-size:1.2em;">📊</span> <b>Volume Per Visitor:</b> The average trading volume per daily visitor, showing user activity and engagement.</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Add Review Block for Exchanges -->
        <div class="modern-reviews-section">
            <h2 class="modern-reviews-title">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="16" fill="url(#reviewGradient)"/><path d="M10 22l2-2 4 4 8-8-2-2-6 6-2-2-2 2z" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><defs><linearGradient id="reviewGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse"><stop stop-color="#ffd200"/><stop offset="1" stop-color="#43cea2"/></linearGradient></defs></svg>
                Exchange Reviews
            </h2>
            <div id="reviews-list" class="reviews-list"></div>
            <div class="modern-review-form-container">
                <h3 class="modern-review-form-title">
                    Add Your Review
                </h3>
                <form id="reviewForm" method="POST" action="{{ url('/livecoinwatch/exchanges/reviews') }}">
                    @csrf
                    <input type="hidden" name="exchange_code" value="all">
                    <div class="modern-form-group">
                        <label for="name">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" fill="#ffd200"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="#43cea2" stroke-width="2"/></svg>
                            Name
                        </label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="email">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#43cea2"/><path d="M2 6l10 7 10-7" stroke="#ffd200" stroke-width="2"/></svg>
                            Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" required maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="rating">
                            <svg viewBox="0 0 24 24" fill="none"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" fill="#ffd200"/></svg>
                            Rating
                        </label>
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="">Select</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                    <div class="modern-form-group">
                        <label for="title">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ffd200"/><path d="M8 12h8M8 16h4" stroke="#43cea2" stroke-width="2"/></svg>
                            Title
                        </label>
                        <input type="text" class="form-control" id="title" name="title" required maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="comment">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="4" fill="#43cea2"/><path d="M6 8h12M6 12h8" stroke="#ffd200" stroke-width="2"/></svg>
                            Comment
                        </label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="country">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ffd200"/><path d="M2 6l10 7 10-7" stroke="#43cea2" stroke-width="2"/></svg>
                            Country
                        </label>
                        <input type="text" class="form-control" id="country" name="country" maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="experience_level">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg>
                            Experience Level
                        </label>
                        <select class="form-control" id="experience_level" name="experience_level">
                            <option value="">Select</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Professional">Professional</option>
                        </select>
                    </div>
                    <div class="modern-form-group">
                        <label for="pros">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg>
                            Pros
                        </label>
                        <textarea class="form-control" id="pros" name="pros" rows="2"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="cons">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#ffd200"/><path d="M8 12h8M8 16h4" stroke="#43cea2" stroke-width="2"/></svg>
                            Cons
                        </label>
                        <textarea class="form-control" id="cons" name="cons" rows="2"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="recommend">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg>
                            Would you recommend?
                        </label>
                        <select class="form-control" id="recommend" name="recommend">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn modern-review-form-btn">Submit Review</button>
                    <div id="reviewFormMsg" style="margin-top: 1em;"></div>
                </form>
            </div>
        </div>
        <!-- Review JS moved to public/js/livecoin/exchanges.js -->
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="{{ url('js/livecoin/exchanges.js') }}"></script>
    <script>
        // Add spin animation to refresh icon on click
        document.addEventListener('DOMContentLoaded', function() {
            var refreshBtn = document.getElementById('refreshTable');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    refreshBtn.classList.add('spinning');
                    setTimeout(function() {
                        refreshBtn.classList.remove('spinning');
                    }, 700);
                });
            }
        });
    </script>
@endsection