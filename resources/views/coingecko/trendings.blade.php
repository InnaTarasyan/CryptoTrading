@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/trendings.css') }}" rel="stylesheet">
    <style>
        .dark-mode-container {
            display: flex;
            align-items: center;
            margin-left: 1em;
        }
        .darkmode-switch {
            background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
            border: none;
            border-radius: 2em;
            padding: 0.4em 1.2em;
            color: #fff;
            font-weight: 600;
            font-size: 1em;
            display: flex;
            align-items: center;
            gap: 0.7em;
            cursor: pointer;
            transition: background 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 8px 0 rgba(255,106,136,0.10);
        }
        .darkmode-switch:active, .darkmode-switch:focus {
            outline: none;
            box-shadow: 0 0 0 2px #ff99ac;
        }
        .darkmode-switch-track {
            background: #fff2;
            border-radius: 1em;
            padding: 0.2em 0.5em;
            display: flex;
            align-items: center;
        }
        .darkmode-switch-thumb {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .darkmode-switch-icon {
            display: flex;
            align-items: center;
        }
        .darkmode-switch-label {
            margin-left: 0.5em;
            font-size: 1em;
        }
        .darkmode-status-indicator {
            margin-left: 0.5em;
            font-size: 0.9em;
        }
        body.dark-mode {
            background: #181a20 !important;
            color: #f1f1f1 !important;
        }
        body.dark-mode .modern-title-bar,
        body.dark-mode .modern-tabs-container,
        body.dark-mode .enhanced-table-container,
        body.dark-mode .m-portlet,
        body.dark-mode .modern-info-block-upgraded {
            background: #23272f !important;
            color: #f1f1f1 !important;
            box-shadow: 0 8px 32px 0 rgba(24, 26, 32, 0.18), 0 3px 12px 0 rgba(24, 26, 32, 0.13);
        }
        body.dark-mode .table {
            background: #23272f !important;
            color: #f1f1f1 !important;
        }
        body.dark-mode .enhanced-th, body.dark-mode .datatable-header-text {
            color: #ffd200 !important;
        }
        body.dark-mode .modern-tab.beautiful-tab.active {
            background: linear-gradient(90deg, #23272f 0%, #181a20 100%) !important;
            color: #ffd200 !important;
        }
        body.dark-mode .modern-tab {
            color: #ffd200 !important;
        }
        body.dark-mode .modern-title-icon svg,
        body.dark-mode .tab-icon svg {
            filter: brightness(0.8) contrast(1.2);
        }
        .modern-fullscreen-btn {
            background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
            color: #fff;
            border: none;
            border-radius: 2em;
            padding: 0.5em 1.5em;
            font-size: 1em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.7em;
            cursor: pointer;
            transition: background 0.3s, color 0.3s, box-shadow 0.2s;
            box-shadow: 0 2px 8px 0 rgba(255,106,136,0.10);
        }
        .modern-fullscreen-btn:active, .modern-fullscreen-btn:focus {
            outline: none;
            box-shadow: 0 0 0 2px #ff99ac;
        }
        .fullscreen-icon-bg {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fullscreen-switch-label {
            font-size: 1em;
            font-weight: 500;
        }
        .ripple-effect {
            display: none;
        }
        .fullscreen-active {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100vw !important;
            height: 100vh !important;
            background: #fff !important;
            z-index: 9999 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            overflow: auto !important;
            padding: 2vw 2vw 2vw 2vw !important;
            transition: all 0.3s;
        }
        body.dark-mode .fullscreen-active {
            background: #23272f !important;
        }
        .refresh-btn {
            background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
            color: #fff;
            border: none;
            border-radius: 2em;
            padding: 0.5em 1.5em;
            font-size: 1em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.7em;
            cursor: pointer;
            transition: background 0.3s, color 0.3s, box-shadow 0.2s;
            box-shadow: 0 2px 8px 0 rgba(255,106,136,0.10);
            position: relative;
            outline: none;
        }
        .refresh-btn:active, .refresh-btn:focus {
            outline: none;
            box-shadow: 0 0 0 2px #ff99ac;
        }
        .refresh-btn:hover {
            background: linear-gradient(90deg, #ff99ac 0%, #ff6a88 100%);
            color: #fff;
        }
        .refresh-btn[aria-busy="true"] {
            opacity: 0.7;
            pointer-events: none;
        }
        .refresh-btn-label {
            font-size: 1em;
            font-weight: 500;
        }
        .refresh-spinner {
            display: none;
            position: absolute;
            right: 1.5em;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }
        @media (max-width: 700px) {
            .refresh-btn {
                padding: 0.5em 1em;
                font-size: 0.95em;
            }
            .refresh-spinner {
                right: 0.7em;
            }
        }
    </style>
@endsection
@section('content')
    <div class="m-content">
        <!-- Modern Title Bar with Icon and Enhanced Dark Mode Button -->
        <div class="modern-title-bar" aria-labelledby="trendingsTitle" role="banner">
            <div class="modern-title-bar-row">
                <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
                    <span class="modern-title-icon" tabindex="0" title="Trendings Overview">
                        <!-- Trendings Icon SVG (Pink Gradient) -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="trendingsGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff6a88"/>
                                    <stop offset="1" stop-color="#ff99ac"/>
                                </linearGradient>
                            </defs>
                            <rect x="4" y="4" width="24" height="24" rx="8" fill="url(#trendingsGradient)"/>
                            <path d="M8 24l6-12 4 8 4-4" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="modern-title-text" id="trendingsTitle">Coingecko Trendings</span>
                </div>
                <div class="dark-mode-container" style="display: flex; gap: 1em; align-items: center;">
                    <button id="darkModeToggle" class="modern-tab darkmode-switch enhanced-darkmode" title="Toggle dark/light mode" role="switch" aria-checked="false" aria-label="Toggle dark mode" tabindex="0">
                        <div class="darkmode-switch-track">
                            <div class="darkmode-switch-thumb">
                                <span class="darkmode-switch-icon" id="darkModeIcon">
                                    <!-- Sun & Moon SVG -->
                                    <svg class="icon-moon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" fill="#ffd200"/>
                                        <circle cx="12" cy="12" r="3" fill="#fff" opacity="0.8"/>
                                    </svg>
                                    <svg class="icon-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none;">
                                        <circle cx="12" cy="12" r="5" fill="#ffb300"/>
                                        <g stroke="#ffb300" stroke-width="2" opacity="0.9">
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
                            </div>
                        </div>
                        <span id="darkModeText" class="darkmode-switch-label">Dark Mode</span>
                        <span class="darkmode-status-indicator" id="darkModeStatus" aria-live="polite"></span>
                    </button>
                    <button id="refreshTable" class="modern-tab refresh-btn" title="Refresh Table" aria-label="Refresh Table" aria-busy="false" aria-disabled="false" tabindex="0" style="overflow:hidden; position:relative;">
                        <span class="refresh-btn-icon" style="position:relative; display:inline-flex; align-items:center; justify-content:center;">
                            <span class="refresh-icon-bg">
                                <svg class="icon-refresh-upgraded" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="refreshGradientModernUpgradedPink" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#ff6a88"/>
                                            <stop offset="1" stop-color="#ff99ac"/>
                                        </linearGradient>
                                    </defs>
                                    <circle cx="16" cy="16" r="15" fill="#fff"/>
                                    <path d="M25 10A12 12 0 1 0 27 16h-2.5" stroke="url(#refreshGradientModernUpgradedPink)" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="24 4 24 11 31 11" stroke="url(#refreshGradientModernUpgradedPink)" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                            </span>
                            <span class="refresh-spinner" style="display:none; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); z-index:2;">
                                <svg width="28" height="28" viewBox="0 0 50 50">
                                    <circle cx="25" cy="25" r="20" fill="none" stroke="#ff6a88" stroke-width="5" stroke-linecap="round" stroke-dasharray="31.4 31.4" stroke-dashoffset="0">
                                        <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/>
                                    </circle>
                                </svg>
                            </span>
                        </span>
                        <span class="refresh-btn-label">Refresh</span>
                        <span class="ripple-effect"></span>
                    </button>
                    <button id="fullscreenToggle" class="modern-tab modern-fullscreen-btn" title="Toggle Fullscreen" aria-label="Toggle Fullscreen" aria-pressed="false" role="button" tabindex="0">
                        <span class="fullscreen-icon-bg">
                            <svg class="icon-fullscreen" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="7" height="2" rx="1" fill="#ff6a88"/>
                                <rect x="3" y="3" width="2" height="7" rx="1" fill="#ff6a88"/>
                                <rect x="14" y="3" width="7" height="2" rx="1" fill="#ff6a88"/>
                                <rect x="19" y="3" width="2" height="7" rx="1" fill="#ff6a88"/>
                                <rect x="3" y="19" width="7" height="2" rx="1" fill="#ff6a88"/>
                                <rect x="3" y="14" width="2" height="7" rx="1" fill="#ff6a88"/>
                                <rect x="14" y="19" width="7" height="2" rx="1" fill="#ff6a88"/>
                                <rect x="19" y="14" width="2" height="7" rx="1" fill="#ff6a88"/>
                            </svg>
                            <svg class="icon-exit-fullscreen" width="24" height="24" viewBox="0 0 24 24" fill="none" style="display:none;">
                                <rect x="5" y="11" width="14" height="2" rx="1" fill="#ff99ac"/>
                                <rect x="11" y="5" width="2" height="14" rx="1" fill="#ff99ac"/>
                            </svg>
                        </span>
                        <span id="fullscreenText" class="fullscreen-switch-label">Fullscreen</span>
                        <span class="ripple-effect"></span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Navigation Tabs -->
        <div class="modern-tabs-container gradient-tabs-bg">
            <nav class="modern-tabs beautiful-tabs" aria-label="Main navigation">
                <a href="/coingeckomarketsindex" class="modern-tab beautiful-tab {{ request()->is('coingeckomarketsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Markets Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff6a88"/><path d="M12 7v5l4 2" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    <span class="tab-label">Markets</span>
                </a>
                <a href="/coingeckoexchangesindex" class="modern-tab beautiful-tab {{ request()->is('coingeckoexchangesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Exchange Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        </span>
                    <span class="tab-label">Exchanges</span>
                </a>
                <a href="/coingeckotrendingsindex" class="modern-tab beautiful-tab {{ request()->is('coingeckotrendingsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Trendings Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"/><path d="M8 16l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        </span>
                    <span class="tab-label">Trendings</span>
                </a>
                <a href="/coingeckoexchangeratesindex" class="modern-tab beautiful-tab {{ request()->is('coingeckoexchangeratesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Exchange Rates Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"/><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>
                        </span>
                    <span class="tab-label">Exchange Rates</span>
                </a>
                <a href="/coingeckonftsindex" class="modern-tab beautiful-tab {{ request()->is('coingeckonftsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- NFTs Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"/><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">NFT</text></svg>
                        </span>
                    <span class="tab-label">NFTs</span>
                </a>
                <a href="/coingeckoderivativesindex" class="modern-tab beautiful-tab {{ request()->is('coingeckoderivativesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Derivatives Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        </span>
                    <span class="tab-label">Derivatives</span>
                </a>
                <a href="/coingeckoderivativesexchangesindex" class="modern-tab beautiful-tab {{ request()->is('coingeckoderivativesexchangesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Derivatives Exchanges Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"/><path d="M8 16l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        </span>
                    <span class="tab-label">Derivatives Exchanges</span>
                </a>
            </nav>
        </div>
        <!-- DataTable Section -->
        <div class="m-portlet enhanced-portlet">
            <div class="m-portlet__body mt-5 enhanced-portlet-body">
                <input type="hidden" id="coingecko_trendings_route" value="{{ route('datatable.coingecko.trendings') }}">
                <div class="action-buttons-row" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; margin-bottom: 1em; gap: 1em;">
                    <div class="action-buttons-left" id="trendings-export-buttons" style="flex: 1 1 auto; min-width: 220px;"></div>
                    <div class="action-buttons-right" style="flex: 0 0 auto; min-width: 220px; display: flex; align-items: center; justify-content: flex-end;">
                        <div id="trendings-search-container" style="width: 100%;"></div>
                    </div>
                </div>
                <div class="table-responsive enhanced-table-container">
                    <table id="coingecko_trendings" class="table table-hover table-condensed table-striped enhanced-table">
                        <thead class="enhanced-thead">
                            <tr>
                                <th class="datatable-highlight-first enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Name</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                        <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="trendingNameGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ff6a88"/>
                                                    <stop offset="1" stop-color="#ff99ac"/>
                                                </linearGradient>
                                            </defs>
                                            <circle cx="12" cy="12" r="11" fill="url(#trendingNameGradient)"/>
                                            <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                </th>
                                <th class="enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Image</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                        <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="trendingLogoGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ff99ac"/>
                                                    <stop offset="1" stop-color="#ff6a88"/>
                                                </linearGradient>
                                            </defs>
                                            <rect x="3" y="3" width="18" height="18" rx="6" fill="url(#trendingLogoGradient)"/>
                                            <circle cx="12" cy="12" r="6" fill="#fff"/>
                                            <circle cx="12" cy="12" r="3" fill="url(#trendingLogoGradient)"/>
                                        </svg>
                                    </span>
                                </th>
                                <th class="enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Market Cap Rank</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                        <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="trendingRankGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#f7971e"/>
                                                    <stop offset="1" stop-color="#ffd200"/>
                                                </linearGradient>
                                            </defs>
                                            <circle cx="12" cy="12" r="11" fill="url(#trendingRankGradient)"/>
                                            <path d="M8 6l2 4 3 1-2 2 1 3-4-2-4 2 1-3-2-2 3-1z" fill="#fff"/>
                                            <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">#</text>
                                        </svg>
                                    </span>
                                </th>
                                <th class="enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Slug</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                        <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="trendingSlugGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#43cea2"/>
                                                    <stop offset="1" stop-color="#185a9d"/>
                                                </linearGradient>
                                            </defs>
                                            <circle cx="12" cy="12" r="11" fill="url(#trendingSlugGradient)"/>
                                            <path d="M7 7h10M7 17h10M8 7c0 5 8 5 8 0M8 17c0-5 8-5 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                </th>
                                <th class="enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Price BTC</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                        <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="trendingPriceGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ffd200"/>
                                                    <stop offset="1" stop-color="#ffb300"/>
                                                </linearGradient>
                                            </defs>
                                            <circle cx="12" cy="12" r="11" fill="url(#trendingPriceGradient)"/>
                                            <text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">₿</text>
                                        </svg>
                                    </span>
                                </th>
                                <th class="enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Score</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                        <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="trendingScoreGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#ff6a88"/>
                                                    <stop offset="1" stop-color="#ff99ac"/>
                                                </linearGradient>
                                            </defs>
                                            <circle cx="12" cy="12" r="11" fill="url(#trendingScoreGradient)"/>
                                            <text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">★</text>
                                        </svg>
                                    </span>
                                </th>
                                <th class="enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Data</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                        <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient id="trendingDataGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#43cea2"/>
                                                    <stop offset="1" stop-color="#185a9d"/>
                                                </linearGradient>
                                            </defs>
                                            <circle cx="12" cy="12" r="11" fill="url(#trendingDataGradient)"/>
                                            <path d="M7 9h10M7 15h10M8 9c0 3 8 3 8 0M8 15c0-3 8-3 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </span>
                                </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="{{ url('js/coingecko/trendings.js') }}"></script>
    <script>
        // Responsive DataTable: Add data-labels to each td after table draw
        function setTrendingDataLabels() {
            var headers = [];
            document.querySelectorAll('#coingecko_trendings thead th').forEach(function(th) {
                headers.push(th.innerText.trim());
            });
            document.querySelectorAll('#coingecko_trendings tbody tr').forEach(function(tr) {
                tr.querySelectorAll('td').forEach(function(td, i) {
                    if (headers[i]) td.setAttribute('data-label', headers[i]);
                });
            });
        }
        // If using DataTables, hook into draw event
        $(document).ready(function() {
            var table = $('#coingecko_trendings').DataTable();
            setTrendingDataLabels();
            table.on('draw', function() {
                setTrendingDataLabels();
            });
        });

        function setDarkMode(enabled) {
            if (enabled) {
                document.body.classList.add('dark-mode');
                document.getElementById('darkModeText').textContent = 'Light Mode';
                document.getElementById('darkModeToggle').setAttribute('aria-checked', 'true');
                document.querySelector('.icon-moon').style.display = 'none';
                document.querySelector('.icon-sun').style.display = '';
            } else {
                document.body.classList.remove('dark-mode');
                document.getElementById('darkModeText').textContent = 'Dark Mode';
                document.getElementById('darkModeToggle').setAttribute('aria-checked', 'false');
                document.querySelector('.icon-moon').style.display = '';
                document.querySelector('.icon-sun').style.display = 'none';
            }
        }
        function getDarkModePref() {
            return localStorage.getItem('trendingsDarkMode') === 'true';
        }
        function setDarkModePref(val) {
            localStorage.setItem('trendingsDarkMode', val ? 'true' : 'false');
        }
        document.addEventListener('DOMContentLoaded', function() {
            setDarkMode(getDarkModePref());
            document.getElementById('darkModeToggle').addEventListener('click', function() {
                const enabled = !getDarkModePref();
                setDarkModePref(enabled);
                setDarkMode(enabled);
            });

            var refreshTableBtn = document.getElementById('refreshTable');
            var refreshSpinner = refreshTableBtn.querySelector('.refresh-spinner');
            var refreshIconBg = refreshTableBtn.querySelector('.refresh-icon-bg');
            var refreshIcon = refreshIconBg.querySelector('.icon-refresh-upgraded');
            var isRefreshing = false;

            refreshTableBtn.addEventListener('click', function() {
                if (!isRefreshing) {
                    isRefreshing = true;
                    refreshIcon.style.display = 'none';
                    refreshSpinner.style.display = 'block';
                    refreshTableBtn.setAttribute('aria-busy', 'true');
                    refreshTableBtn.setAttribute('aria-disabled', 'true');
                    refreshTableBtn.classList.add('refresh-btn-loading'); // Add a class for styling

                    // Simulate an async operation
                    setTimeout(() => {
                        isRefreshing = false;
                        refreshIcon.style.display = 'inline';
                        refreshSpinner.style.display = 'none';
                        refreshTableBtn.setAttribute('aria-busy', 'false');
                        refreshTableBtn.setAttribute('aria-disabled', 'false');
                        refreshTableBtn.classList.remove('refresh-btn-loading');
                    }, 1500); // Simulate 1.5 seconds refresh time
                }
            });

            var fullscreenToggle = document.getElementById('fullscreenToggle');
            var fullscreenContainer = document.querySelector('.enhanced-table-container');
            var iconEnter = fullscreenToggle.querySelector('.icon-fullscreen');
            var iconExit = fullscreenToggle.querySelector('.icon-exit-fullscreen');
            var fullscreenText = document.getElementById('fullscreenText');
            var isFullscreen = false;
            function enterFullscreen() {
                fullscreenContainer.classList.add('fullscreen-active');
                iconEnter.style.display = 'none';
                iconExit.style.display = 'inline';
                fullscreenToggle.setAttribute('aria-pressed', 'true');
                fullscreenText.textContent = 'Exit Fullscreen';
                isFullscreen = true;
            }
            function exitFullscreen() {
                fullscreenContainer.classList.remove('fullscreen-active');
                iconEnter.style.display = 'inline';
                iconExit.style.display = 'none';
                fullscreenToggle.setAttribute('aria-pressed', 'false');
                fullscreenText.textContent = 'Fullscreen';
                isFullscreen = false;
            }
            fullscreenToggle.addEventListener('click', function() {
                if (!isFullscreen) {
                    enterFullscreen();
                } else {
                    exitFullscreen();
                }
            });
            // ESC key to exit fullscreen
            document.addEventListener('keydown', function(e) {
                if (isFullscreen && (e.key === 'Escape' || e.key === 'Esc')) {
                    exitFullscreen();
                }
            });
        });
    </script>
@endsection