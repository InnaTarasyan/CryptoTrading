@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/markets.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="m-content">
        <!-- Modern Title Bar with Icon and Enhanced Dark Mode Button -->
        <div class="modern-title-bar" aria-labelledby="marketsTitle" role="banner">
            <div class="modern-title-bar-row">
                <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
                    <span class="modern-title-icon" tabindex="0" title="Markets Overview">
                        <!-- Markets Icon SVG (Pink Gradient) -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="marketsGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff6a88"/>
                                    <stop offset="1" stop-color="#ff99ac"/>
                                </linearGradient>
                            </defs>
                            <circle cx="16" cy="16" r="16" fill="url(#marketsGradient)"/>
                            <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="modern-title-text" id="marketsTitle">Coingecko Markets</span>
                </div>
                <div class="dark-mode-container">
                    <button id="darkModeToggle" class="modern-tab darkmode-switch enhanced-darkmode" title="Toggle dark/light mode" role="switch" aria-checked="false" aria-label="Toggle dark mode" tabindex="0">
                        <div class="darkmode-switch-track">
                            <div class="darkmode-switch-thumb">
                                <span class="darkmode-switch-icon" id="darkModeIcon">
                                    <!-- Enhanced Sun & Moon SVG with smooth transitions -->
                                    <svg class="icon-moon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" fill="#ffd200"/>
                                        <circle cx="12" cy="12" r="3" fill="#fff" opacity="0.8"/>
                                    </svg>
                                    <svg class="icon-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <!-- Status indicator -->
                        <span class="darkmode-status-indicator" id="darkModeStatus" aria-live="polite"></span>
                    </button>
                    <!-- Quick theme preview tooltip -->
                    <div class="theme-preview-tooltip" id="themePreviewTooltip">
                        <div class="tooltip-content">
                            <span class="tooltip-icon">🌙</span>
                            <span class="tooltip-text">Switch to Dark Mode</span>
                        </div>
                    </div>
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
        <!-- Action Buttons -->
        <div class="action-buttons-row">
            <div class="action-buttons-left">
                <button id="refreshTable" class="modern-tab refresh-btn" title="Refresh Table" aria-label="Refresh Table" aria-busy="false" aria-disabled="false" tabindex="0" style="overflow:hidden; position:relative;">
                    <span class="refresh-btn-icon" style="position:relative; display:inline-flex; align-items:center; justify-content:center;">
                        <!-- Modern Bold Refresh SVG (Pink) -->
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
            </div>
            <div class="action-buttons-right">
                <button id="fullscreenToggle" class="modern-tab modern-fullscreen-btn" title="Toggle Fullscreen" aria-label="Toggle Fullscreen" aria-pressed="false" role="button" tabindex="0">
                    <span class="fullscreen-icon-bg">
                        <!-- Enter Fullscreen SVG -->
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
                        <!-- Exit Fullscreen SVG (hidden by default) -->
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
        <!-- DataTable Section -->
        <div class="m-portlet enhanced-portlet">
            <div class="m-portlet__body mt-5 enhanced-portlet-body">
                <input type="hidden" id="coingecko_markets_route" value="{{ route('datatable.coingecko.markets') }}">
                
                <!-- Enhanced Loading State -->
                <div id="datatableLoading" class="datatable-loading enhanced-loading" style="display:none;">
                    <div class="loading-container">
                        <div class="loading-spinner">
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="loadingGradient" x1="0" y1="0" x2="60" y2="60" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#ff6a88"/>
                                        <stop offset="1" stop-color="#ff99ac"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="30" cy="30" r="25" fill="none" stroke="url(#loadingGradient)" stroke-width="4" stroke-linecap="round" stroke-dasharray="157 157" stroke-dashoffset="0">
                                    <animateTransform attributeName="transform" type="rotate" from="0 30 30" to="360 30 30" dur="1.5s" repeatCount="indefinite"/>
                                </circle>
                                <circle cx="30" cy="30" r="15" fill="none" stroke="url(#loadingGradient)" stroke-width="3" stroke-linecap="round" stroke-dasharray="94 94" stroke-dashoffset="0" opacity="0.7">
                                    <animateTransform attributeName="transform" type="rotate" from="360 30 30" to="0 30 30" dur="1s" repeatCount="indefinite"/>
                                </circle>
                            </svg>
                        </div>
                        <div class="loading-text">
                            <h3>Loading Market Data</h3>
                            <p>Fetching the latest cryptocurrency information...</p>
                        </div>
                    </div>
                </div>
                
                <!-- Enhanced Table Container -->
                <div id="datatableFullscreenContainer" class="table-responsive enhanced-table-container">
                    <!-- Table Status Bar -->
                    <div class="table-status-bar" id="tableStatusBar">
                        <div class="status-info">
                            <span class="status-icon">📊</span>
                            <span class="status-text">Ready to display market data</span>
                        </div>
                        <div class="status-actions">
                            <button class="status-action-btn" id="exportData" title="Export Data">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="#ff6a88" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="7,10 12,15 17,10" stroke="#ff6a88" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="12" y1="15" x2="12" y2="3" stroke="#ff6a88" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Export
                            </button>
                            <button class="status-action-btn" id="printTable" title="Print Table">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <polyline points="6,9 6,2 18,2 18,9" stroke="#ff6a88" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" stroke="#ff6a88" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="6" y="14" width="12" height="8" rx="1" fill="none" stroke="#ff6a88" stroke-width="2"/>
                                </svg>
                                Print
                            </button>
                        </div>
                    </div>
                    
                    <!-- Enhanced Table -->
                    <div class="table-wrapper">
                        <table id="coingecko_markets" class="table table-hover table-condensed table-striped enhanced-table" style="width:100%; padding-top:1%">
                            <thead class="enhanced-thead">
                                <tr>
                                    <th class="datatable-highlight-first enhanced-th">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Coin</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                            <!-- Modern Cryptocurrency Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="cryptoGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#cryptoGradient)"/>
                                                <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <circle cx="12" cy="12" r="2" fill="#fff" opacity="0.3"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Official logo or icon of the cryptocurrency" class="enhanced-th">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Logo</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                            <!-- Modern Logo Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="logoGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff99ac"/>
                                                        <stop offset="1" stop-color="#ff6a88"/>
                                                    </linearGradient>
                                                </defs>
                                                <rect x="3" y="3" width="18" height="18" rx="6" fill="url(#logoGradient)"/>
                                                <circle cx="12" cy="12" r="6" fill="#fff"/>
                                                <circle cx="12" cy="12" r="3" fill="url(#logoGradient)"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Current market price in USD" class="enhanced-th">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Price</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                            <!-- Modern Price Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="priceGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ffd200"/>
                                                        <stop offset="1" stop-color="#ffb300"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#priceGradient)"/>
                                                <text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text>
                                                <circle cx="12" cy="12" r="3" fill="#fff" opacity="0.2"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Total market value of all circulating coins" class="enhanced-th">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Market Cap</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                            <!-- Modern Market Cap Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="marketCapGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#43cea2"/>
                                                        <stop offset="1" stop-color="#185a9d"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#marketCapGradient)"/>
                                                <path d="M7 7h10M7 17h10M8 7c0 5 8 5 8 0M8 17c0-5 8-5 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M12 4v16" stroke="#fff" stroke-width="1.5" stroke-dasharray="2 2"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Rank by market capitalization (1 = highest)" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Rank Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="rankGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#f7971e"/>
                                                        <stop offset="1" stop-color="#ffd200"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#rankGradient)"/>
                                                <path d="M8 6l2 4 3 1-2 2 1 3-4-2-4 2 1-3-2-2 3-1z" fill="#fff"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">#</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">Rank</span>
                                    </th>
                                    <th title="Market cap if all coins were in circulation" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Fully Diluted Value Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="fdvGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#fdvGradient)"/>
                                                <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <circle cx="12" cy="12" r="4" fill="#fff" opacity="0.3"/>
                                                <text x="12" y="15" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">FDV</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">Fully Diluted</span>
                                    </th>
                                    <th title="Total trading volume in the last 24 hours" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Volume Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="volumeGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ffd200"/>
                                                        <stop offset="1" stop-color="#ffb300"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#volumeGradient)"/>
                                                <path d="M7 9h10M7 15h10M8 9c0 3 8 3 8 0M8 15c0-3 8-3 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M12 6v12" stroke="#fff" stroke-width="1.5" stroke-dasharray="1 1"/>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">24h Volume</span>
                                    </th>
                                    <th title="Highest price reached in the last 24 hours" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern High Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="highGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#43cea2"/>
                                                        <stop offset="1" stop-color="#185a9d"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#highGradient)"/>
                                                <path d="M8 14l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">H</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">24h High</span>
                                    </th>
                                    <th title="Lowest price reached in the last 24 hours" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Low Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="lowGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff512f"/>
                                                        <stop offset="1" stop-color="#ff6a88"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#lowGradient)"/>
                                                <path d="M8 10l4 8 4-8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">L</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">24h Low</span>
                                    </th>
                                    <th title="Absolute price change in the last 24 hours" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Change Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="changeGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#changeGradient)"/>
                                                <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <circle cx="12" cy="12" r="2" fill="#fff"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">Δ</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">24h Change</span>
                                    </th>
                                    <th title="Percentage price change in the last 24 hours" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Change % Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="changePercentGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ffd200"/>
                                                        <stop offset="1" stop-color="#ffb300"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#changePercentGradient)"/>
                                                <text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">%</text>
                                                <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">24h %</span>
                                    </th>
                                    <th title="Market cap change in the last 24 hours" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Market Cap Change Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="mcapChangeGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#43cea2"/>
                                                        <stop offset="1" stop-color="#185a9d"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#mcapChangeGradient)"/>
                                                <path d="M7 7h10M7 17h10M8 7c0 5 8 5 8 0M8 17c0-5 8-5 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M12 4v16" stroke="#fff" stroke-width="1.5" stroke-dasharray="2 2"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">Δ</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">MCap Change</span>
                                    </th>
                                    <th title="Percentage market cap change in the last 24 hours" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Market Cap Change % Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="mcapChangePercentGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#mcapChangePercentGradient)"/>
                                                <text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">%</text>
                                                <path d="M7 7h10M7 17h10" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">MCap %</span>
                                    </th>
                                    <th title="Number of coins currently in circulation" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Circulating Supply Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="circSupplyGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#f7971e"/>
                                                        <stop offset="1" stop-color="#ffd200"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#circSupplyGradient)"/>
                                                <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <circle cx="12" cy="12" r="3" fill="#fff" opacity="0.5"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">C</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">Circulating</span>
                                    </th>
                                    <th title="Total number of coins that will ever exist" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Total Supply Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="totalSupplyGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ffd200"/>
                                                        <stop offset="1" stop-color="#ffb300"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#totalSupplyGradient)"/>
                                                <path d="M7 7h10M7 17h10M8 7c0 5 8 5 8 0M8 17c0-5 8-5 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <circle cx="12" cy="12" r="2" fill="#fff"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">T</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">Total Supply</span>
                                    </th>
                                    <th title="Maximum number of coins that can ever exist" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Max Supply Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="maxSupplyGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff512f"/>
                                                        <stop offset="1" stop-color="#ff6a88"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#maxSupplyGradient)"/>
                                                <path d="M7 7h10M7 17h10M8 7c0 5 8 5 8 0M8 17c0-5 8-5 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M12 4v16" stroke="#fff" stroke-width="1.5"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">M</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">Max Supply</span>
                                    </th>
                                    <th title="All-time highest price ever reached" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern ATH Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="athGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#43cea2"/>
                                                        <stop offset="1" stop-color="#185a9d"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#athGradient)"/>
                                                <path d="M8 14l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6 6l12 12" stroke="#fff" stroke-width="1" stroke-dasharray="1 1"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">H</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">All-Time High</span>
                                    </th>
                                    <th title="Percentage change from all-time high price" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern ATH Change % Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="athChangePercentGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#athChangePercentGradient)"/>
                                                <text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">%</text>
                                                <path d="M8 14l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">ATH %</span>
                                    </th>
                                    <th title="All-time lowest price ever reached" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern ATL Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="atlGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff512f"/>
                                                        <stop offset="1" stop-color="#ff6a88"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#atlGradient)"/>
                                                <path d="M8 10l4 8 4-8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6 6l12 12" stroke="#fff" stroke-width="1" stroke-dasharray="1 1"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">L</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">All-Time Low</span>
                                    </th>
                                    <th title="Percentage change from all-time low price" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern ATL Change % Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="atlChangePercentGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ffd200"/>
                                                        <stop offset="1" stop-color="#ffb300"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#atlChangePercentGradient)"/>
                                                <text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">%</text>
                                                <path d="M8 10l4 8 4-8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">ATL %</span>
                                    </th>
                                    <th title="Return on investment data" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern ROI Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="roiGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#43cea2"/>
                                                        <stop offset="1" stop-color="#185a9d"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#roiGradient)"/>
                                                <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <path d="M7 7l10 10M17 7l-10 10" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">R</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">ROI</span>
                                    </th>
                                    <th title="Date when the all-time high was reached" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern ATH Date Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="athDateGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#athDateGradient)"/>
                                                <rect x="6" y="6" width="12" height="12" rx="2" fill="#fff" opacity="0.2"/>
                                                <path d="M6 10h12M10 6v12" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">D</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">ATH Date</span>
                                    </th>
                                    <th title="Last time the data was updated" class="enhanced-th">
                                        <span class="datatable-header-icon">
                                            <!-- Modern Last Updated Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="lastUpdatedGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#f7971e"/>
                                                        <stop offset="1" stop-color="#ffd200"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#lastUpdatedGradient)"/>
                                                <circle cx="12" cy="12" r="6" fill="none" stroke="#fff" stroke-width="2"/>
                                                <path d="M12 8v4l3 3" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">U</text>
                                            </svg>
                                        </span>
                                        <span class="datatable-header-text">Updated</span>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                
                <!-- Enhanced Table Footer -->
                <div class="table-footer enhanced-footer">
                    <div class="footer-info">
                        <span class="footer-icon">📈</span>
                        <span class="footer-text">Real-time cryptocurrency market data powered by CoinGecko</span>
                    </div>
                    <div class="footer-actions">
                        <button class="footer-action-btn" id="scrollToTop" title="Scroll to Top">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M18 15l-6-6-6 6" stroke="#ff6a88" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Top
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Info Block: About Coingecko Markets -->
        <div class="modern-info-block-upgraded upgraded-gradient-bg" style="border-radius: 1.5em; box-shadow: 0 8px 32px 0 rgba(255, 106, 136, 0.18), 0 3px 12px 0 rgba(255, 153, 172, 0.13); padding: 2.2em 2em 2.2em 2em; margin-top: 2.5em; margin-bottom: 2.5em; color: #fff; background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);">
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; margin-bottom: 2.2em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,106,136,0.10);">
                    <!-- Globe/Markets Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="19" fill="#ff6a88" stroke="#ff99ac" stroke-width="2"/>
                        <path d="M12 20h16M20 12v16" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.25em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#fff;">Coingecko Markets</span>: Your Real-Time Crypto Market Dashboard
                    </p>
                    <p class="info-desc" style="margin-bottom:0; font-size:1.08em; line-height:1.7;">
                        <span style="font-size:1.2em;">🌐</span> <b>Coingecko Markets</b> is a powerful, real-time dashboard for comparing and monitoring the world's top cryptocurrencies. It offers a user-friendly interface, supports hundreds of cryptocurrencies, and provides up-to-date data on price, market cap, volume, and more.<br><br>
                        <span style="font-size:1.2em;">🔒</span> <b>Security & Transparency:</b> Robust security, transparent data, and competitive fees.<br>
                        <span style="font-size:1.2em;">🚀</span> <b>For Everyone:</b> Designed for both beginners and experienced traders to make informed decisions and discover the best coins for their crypto journey.<br>
                        <span style="font-size:1.2em;">📊</span> <b>Global Access:</b> Access market data from anywhere, anytime, on any device.
                    </p>
                </div>
            </div>
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,106,136,0.10);">
                    <!-- Table/Analytics Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="12" width="26" height="16" rx="4" fill="#ff99ac" stroke="#fff" stroke-width="2"/>
                        <rect x="11" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="19" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="27" y="16" width="2" height="8" rx="1" fill="#fff"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.18em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#fff;">How to Use the Markets Table</span>
                    </p>
                    <p style="font-size:1.08em; line-height:1.7; margin-bottom:1em;">
                        The table above provides a comprehensive overview of each coin's key statistics. Use the column explanations below to better understand the data and make smarter trading decisions.
                    </p>
                    <ul class="datatable-columns-list" style="margin-bottom:0; font-size:1.08em; line-height:1.7; padding-left:1.2em; list-style:none;">
                        <li><span style="font-size:1.2em;">🔤</span> <b>Cryptocurrency:</b> The official name and symbol of the cryptocurrency.</li>
                        <li><span style="font-size:1.2em;">🖼️</span> <b>Logo:</b> The official logo or icon representing the cryptocurrency.</li>
                        <li><span style="font-size:1.2em;">💲</span> <b>Price (USD):</b> The current market price in US dollars.</li>
                        <li><span style="font-size:1.2em;">💰</span> <b>Market Cap:</b> The total market value of all circulating coins.</li>
                        <li><span style="font-size:1.2em;">🏆</span> <b>Rank:</b> The rank by market capitalization (1 = highest).</li>
                        <li><span style="font-size:1.2em;">💎</span> <b>Fully Diluted Value:</b> The market cap if all coins were in circulation.</li>
                        <li><span style="font-size:1.2em;">🔊</span> <b>24h Volume:</b> The total trading volume in the last 24 hours.</li>
                        <li><span style="font-size:1.2em;">📈</span> <b>24h High:</b> The highest price reached in the last 24 hours.</li>
                        <li><span style="font-size:1.2em;">📉</span> <b>24h Low:</b> The lowest price reached in the last 24 hours.</li>
                        <li><span style="font-size:1.2em;">🔺</span> <b>24h Change:</b> The absolute price change in the last 24 hours.</li>
                        <li><span style="font-size:1.2em;">📊</span> <b>24h Change %:</b> The percentage price change in the last 24 hours.</li>
                        <li><span style="font-size:1.2em;">💹</span> <b>Market Cap Change:</b> The market cap change in the last 24 hours.</li>
                        <li><span style="font-size:1.2em;">📈</span> <b>Market Cap Change %:</b> The percentage market cap change in the last 24 hours.</li>
                        <li><span style="font-size:1.2em;">🔄</span> <b>Circulating Supply:</b> The number of coins currently in circulation.</li>
                        <li><span style="font-size:1.2em;">🔢</span> <b>Total Supply:</b> The total number of coins that will ever exist.</li>
                        <li><span style="font-size:1.2em;">🔝</span> <b>Max Supply:</b> The maximum number of coins that can ever exist.</li>
                        <li><span style="font-size:1.2em;">🚀</span> <b>All-Time High:</b> The highest price ever reached.</li>
                        <li><span style="font-size:1.2em;">📉</span> <b>ATH Change %:</b> The percentage change from all-time high.</li>
                        <li><span style="font-size:1.2em;">📉</span> <b>All-Time Low:</b> The lowest price ever reached.</li>
                        <li><span style="font-size:1.2em;">📉</span> <b>ATL Change %:</b> The percentage change from all-time low.</li>
                        <li><span style="font-size:1.2em;">💹</span> <b>ROI:</b> Return on investment data.</li>
                        <li><span style="font-size:1.2em;">📅</span> <b>ATH Date:</b> The date when the all-time high was reached.</li>
                        <li><span style="font-size:1.2em;">⏰</span> <b>Last Updated:</b> The last time the data was updated.</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Help Modal -->
        <div id="helpInfoModal" class="modern-help-modal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="helpInfoTitle">
            <div class="modern-help-modal-content">
                <button class="modern-help-modal-close" id="closeHelpModal" aria-label="Close Info">&times;</button>
                <h2 id="helpInfoTitle">About This Page</h2>
                <p>This page provides real-time cryptocurrency market data, including prices, market caps, and trends. Use the navigation tabs to explore different market sections. Toggle dark mode for a comfortable viewing experience.</p>
            </div>
        </div>

        <!-- ======================== Reviews Section ======================== -->
        <style>
        .modern-reviews-section {
            margin-top: 3em;
            margin-bottom: 3em;
            background: linear-gradient(120deg, #ff6a88 0%, #ff99ac 100%);
            border-radius: 2em;
            box-shadow: 0 4px 32px rgba(255, 106, 136, 0.10), 0 1.5px 6px rgba(255, 153, 172, 0.08);
            padding: 2.5em 1.5em;
            max-width: 100%;
        }
        .modern-reviews-title {
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 1.5em;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.7em;
        }
        .modern-reviews-title svg {
            width: 2.2em;
            height: 2.2em;
            flex-shrink: 0;
        }
        .modern-review-card {
            background: linear-gradient(100deg, #fffbe6 0%, #ffe6f0 100%);
            border-radius: 1.2em;
            margin-bottom: 1.5em;
            padding: 1.5em 1.7em;
            box-shadow: 0 2px 12px rgba(255,106,136,0.08);
            display: flex;
            gap: 1.2em;
            align-items: flex-start;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .modern-review-card:hover {
            box-shadow: 0 6px 24px rgba(255,106,136,0.13);
            transform: translateY(-2px) scale(1.01);
        }
        .modern-review-avatar {
            width: 3.2em;
            height: 3.2em;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6a88 0%, #ff99ac 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5em;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(255,106,136,0.10);
            flex-shrink: 0;
        }
        .modern-review-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.3em;
        }
        .modern-review-header {
            display: flex;
            align-items: center;
            gap: 0.7em;
            margin-bottom: 0.2em;
        }
        .modern-review-name {
            font-weight: 700;
            color: #ff6a88;
            font-size: 1.1em;
        }
        .modern-review-date {
            color: #888;
            font-size: 0.98em;
        }
        .modern-review-rating {
            margin-left: auto;
            color: #ffd200;
            font-size: 1.2em;
            display: flex;
            align-items: center;
            gap: 0.1em;
        }
        .modern-review-title {
            font-weight: 600;
            font-size: 1.15em;
            margin-bottom: 0.2em;
            color: #222;
        }
        .modern-review-comment {
            color: #222;
            font-size: 1.05em;
            line-height: 1.6;
        }
        .modern-review-form-container {
            max-width: 600px;
            margin: 2.5em auto 0 auto;
            background: linear-gradient(100deg, #fffbe6 0%, #ffe6f0 100%);
            border-radius: 1.2em;
            box-shadow: 0 2px 12px rgba(255,106,136,0.08);
            padding: 2em 2em 1.5em 2em;
        }
        .modern-review-form-title {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 1.2em;
            color: #ff6a88;
            display: flex;
            align-items: center;
            gap: 0.5em;
        }
        .modern-form-group {
            margin-bottom: 1.1em;
            position: relative;
        }
        .modern-form-group label {
            font-weight: 600;
            color: #ff6a88;
            margin-bottom: 0.3em;
            display: flex;
            align-items: center;
            gap: 0.4em;
        }
        .modern-form-group svg {
            width: 1.1em;
            height: 1.1em;
            vertical-align: middle;
        }
        .modern-form-group input,
        .modern-form-group select,
        .modern-form-group textarea {
            width: 100%;
            border-radius: 1.2em;
            border: 1.5px solid #ff6a88;
            padding: 0.7em 1.1em;
            font-size: 1.05em;
            background: #fff;
            color: #222;
            transition: border 0.2s;
            box-shadow: 0 1px 4px rgba(255,106,136,0.04);
        }
        .modern-form-group input:focus,
        .modern-form-group select:focus,
        .modern-form-group textarea:focus {
            border: 1.5px solid #ffd200;
            outline: none;
        }
        .modern-review-form-btn {
            background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 2em;
            padding: 0.7em 2em;
            font-size: 1.1em;
            box-shadow: 0 2px 8px rgba(34,34,34,0.08);
            transition: background 0.2s, color 0.2s;
        }
        .modern-review-form-btn:hover {
            background: #fff;
            color: #ff6a88;
        }
        @media (max-width: 700px) {
            .modern-reviews-section {
                padding: 1.2em 0.3em;
                border-radius: 1em;
            }
            .modern-review-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.1em 1em;
                gap: 0.7em;
            }
            .modern-review-avatar {
                width: 2.2em;
                height: 2.2em;
                font-size: 1.1em;
            }
            .modern-review-form-container {
                padding: 1.2em 0.7em 1em 0.7em;
                border-radius: 1em;
            }
        }
        </style>
        <div class="modern-reviews-section">
            <h2 class="modern-reviews-title">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="16" fill="url(#reviewGradient)"/><path d="M10 22l2-2 4 4 8-8-2-2-6 6-2-2-2 2z" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><defs><linearGradient id="reviewGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ff99ac"/></linearGradient></defs></svg>
                User Reviews
            </h2>
            <div id="reviews-list" class="reviews-list"></div>
            <div class="modern-review-form-container">
                <h3 class="modern-review-form-title">
                    Leave a Review
                </h3>
                <form id="reviewForm" method="POST" action="/coingecko/markets/reviews">
                    @csrf
                    <input type="hidden" id="coin_id" name="coin_id" value="{{ $coin_id ?? '' }}">
                    <div class="modern-form-group">
                        <label for="name">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" fill="#ff6a88"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="#ff99ac" stroke-width="2"/></svg>
                            Name
                        </label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="email">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ff99ac"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg>
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
                            <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ffd200"/><path d="M8 12h8M8 16h4" stroke="#ff6a88" stroke-width="2"/></svg>
                            Title
                        </label>
                        <input type="text" class="form-control" id="title" name="title" required maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="comment">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="4" fill="#ff99ac"/><path d="M6 8h12M6 12h8" stroke="#ff6a88" stroke-width="2"/></svg>
                            Comment
                        </label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="country">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ffd200"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg>
                            Country
                        </label>
                        <input type="text" class="form-control" id="country" name="country" maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="experience_level">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff99ac"/><path d="M12 6v6l4 2" stroke="#ff6a88" stroke-width="2" stroke-linecap="round"/></svg>
                            Experience Level
                        </label>
                        <select class="form-control" id="experience_level" name="experience_level">
                            <option value="">Select</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <div class="modern-form-group">
                        <label for="pros">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M8 12h8M12 8v8" stroke="#ff6a88" stroke-width="2"/></svg>
                            Pros
                        </label>
                        <textarea class="form-control" id="pros" name="pros" rows="2"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="cons">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff99ac"/><path d="M8 12h8" stroke="#ff6a88" stroke-width="2"/></svg>
                            Cons
                        </label>
                        <textarea class="form-control" id="cons" name="cons" rows="2"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="recommend">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M8 12l2 2 4-4" stroke="#ff6a88" stroke-width="2"/></svg>
                            Recommend?
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
    <script src="{{ url('js/coingecko/markets.js') }}"></script>
@endsection