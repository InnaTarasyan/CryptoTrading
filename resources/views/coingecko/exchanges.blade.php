@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/coingecko_exchanges.css') }}" rel="stylesheet">
    <style>
        /* --- Navigation Explanation Styles --- */
        .navigation-explanation {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .navigation-explanation:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            border-color: #667eea;
        }

        .explanation-content {
            display: flex;
            align-items: flex-start;
            padding: 1.5rem;
            gap: 1rem;
        }

        .explanation-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            flex-shrink: 0;
        }

        .explanation-icon svg {
            width: 24px;
            height: 24px;
            stroke: #ffffff;
            stroke-width: 2;
        }

        .explanation-text {
            flex: 1;
            min-width: 0;
        }

        .explanation-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.75rem 0;
            font-family: 'Poppins', 'Segoe UI', 'Roboto', Arial, sans-serif;
            letter-spacing: 0.025em;
        }

        .explanation-description {
            font-size: 1rem;
            color: #475569;
            line-height: 1.6;
            margin: 0 0 1rem 0;
            font-weight: 400;
        }

        .explanation-description strong {
            color: #1e293b;
            font-weight: 600;
        }

        .explanation-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 8px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.2s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.9);
            border-color: #667eea;
            transform: translateX(4px);
        }

        .feature-icon {
            font-size: 1.25rem;
            line-height: 1;
        }

        .feature-text {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            white-space: nowrap;
        }

        .explanation-tip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 12px;
            margin-top: 0.5rem;
        }

        .tip-icon {
            font-size: 1.125rem;
            line-height: 1;
        }

        .tip-text {
            font-size: 0.875rem;
            font-weight: 500;
            color: #92400e;
            line-height: 1.4;
        }

        /* Dark mode support for navigation explanation */
        body.dark-mode .navigation-explanation {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            border-color: #4b5563;
        }

        body.dark-mode .explanation-title {
            color: #f9fafb;
        }

        body.dark-mode .explanation-description {
            color: #d1d5db;
        }

        body.dark-mode .explanation-description strong {
            color: #f9fafb;
        }

        body.dark-mode .feature-item {
            background: rgba(55, 65, 81, 0.7);
            border-color: rgba(75, 85, 99, 0.8);
        }

        body.dark-mode .feature-item:hover {
            background: rgba(55, 65, 81, 0.9);
            border-color: #667eea;
        }

        body.dark-mode .feature-text {
            color: #e5e7eb;
        }

        body.dark-mode .explanation-tip {
            background: linear-gradient(135deg, #78350f 0%, #92400e 100%);
            border-color: #f59e0b;
        }

        body.dark-mode .tip-text {
            color: #fef3c7;
        }

        /* Responsive design for navigation explanation */
        @media (max-width: 768px) {
            .explanation-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 1.25rem;
                gap: 1rem;
            }

            .explanation-icon {
                width: 40px;
                height: 40px;
            }

            .explanation-icon svg {
                width: 20px;
                height: 20px;
            }

            .explanation-title {
                font-size: 1.125rem;
                margin-bottom: 0.5rem;
            }

            .explanation-description {
                font-size: 0.875rem;
                margin-bottom: 0.75rem;
            }

            .explanation-features {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .feature-item {
                padding: 0.375rem 0.5rem;
                justify-content: center;
            }

            .feature-text {
                font-size: 0.75rem;
            }

            .explanation-tip {
                padding: 0.5rem 0.75rem;
                text-align: left;
            }

            .tip-text {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .navigation-explanation {
                margin-bottom: 1rem;
            }

            .explanation-content {
                padding: 1rem;
            }

            .explanation-features {
                grid-template-columns: 1fr;
                gap: 0.375rem;
            }

            .feature-item {
                padding: 0.5rem;
                justify-content: flex-start;
            }

            .explanation-tip {
                flex-direction: column;
                text-align: center;
                gap: 0.375rem;
            }
        }
    </style>
@endsection
@section('content')
    <input type="hidden" id="coingecko_exchanges_route" value="{{ route('datatable.coingecko.exchanges') }}">
    <div class="m-content">
        <!-- Modern Title Bar with Icon -->
        <div class="modern-title-bar" aria-labelledby="exchangesTitle" role="banner">
            <div class="modern-title-bar-row">
                <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
                    <span class="modern-title-icon" tabindex="0" title="Exchanges Overview">
                        <!-- Exchanges Icon SVG (Pink Gradient) -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="exchangesGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff6a88"/>
                                    <stop offset="1" stop-color="#ff99ac"/>
                                </linearGradient>
                            </defs>
                            <rect x="4" y="4" width="24" height="24" rx="8" fill="url(#exchangesGradient)"/>
                            <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="modern-title-text" id="exchangesTitle">Coingecko Exchanges</span>
                </div>
                <div class="modern-title-actions" style="display: flex; gap: 1em; align-items: center;">
                    <!-- Dark Mode Toggle -->
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
                    <!-- Refresh Button -->
                    <button id="refreshTable" class="modern-tab refresh-btn" title="Refresh Table" aria-label="Refresh Table" aria-busy="false" aria-disabled="false" tabindex="0" style="overflow:hidden; position:relative;">
                        <span class="refresh-btn-icon" style="position:relative; display:inline-flex; align-items:center; justify-content:center;">
                            <svg class="icon-refresh-upgraded" width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <span class="refresh-btn-label">Refresh</span>
                    </button>
                    <!-- Fullscreen Button -->
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
                    </button>
                </div>
            </div>
        </div>

        {{-- User-Friendly Navigation Explanation --}}
        <div class="navigation-explanation">
            <div class="explanation-content">
                <div class="explanation-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <div class="explanation-text">
                    <h4 class="explanation-title">💡 Interactive Table Navigation</h4>
                    <p class="explanation-description">
                        <strong>Click on any row</strong> in the table below to explore detailed information about that cryptocurrency.
                        You'll be taken to a comprehensive details page featuring:
                    </p>
                    <div class="explanation-features">
                        <div class="feature-item">
                            <span class="feature-icon">📊</span>
                            <span class="feature-text">TradingView Charts</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">📅</span>
                            <span class="feature-text">Events Calendar</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">💬</span>
                            <span class="feature-text">Telegram Messages</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🐦</span>
                            <span class="feature-text">Twitter Sentiment</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">📈</span>
                            <span class="feature-text">Market Analysis</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🔍</span>
                            <span class="feature-text">Technical Indicators</span>
                        </div>
                    </div>
                    <div class="explanation-tip">
                        <span class="tip-icon">💡</span>
                        <span class="tip-text">Pro tip: Use the search and filter options above to find specific cryptocurrencies quickly!</span>
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
        <!-- Enhanced Table Container -->
        <div id="datatableFullscreenContainer" class="table-responsive enhanced-table-container">
            <!-- Table Status Bar -->
            <div class="table-status-bar" id="tableStatusBar">
                <div class="status-info">
                    <span class="status-icon">🏦</span>
                    <span class="status-text">Ready to display exchange data</span>
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
                <table id="coingecko_exchanges" class="table table-hover table-condensed table-striped enhanced-table" style="width:100%; padding-top:1%">
                    <thead class="enhanced-thead">
                        <tr>
                            <th class="datatable-highlight-first enhanced-th" title="Official name of the exchange">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Name</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exNameGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ff99ac"/></linearGradient></defs><rect x="3" y="3" width="18" height="18" rx="6" fill="url(#exNameGradient)"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                                </span>
                            </th>
                            <th class="enhanced-th" title="Official logo or icon of the exchange">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Image</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exImgGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ff99ac"/><stop offset="1" stop-color="#ff6a88"/></linearGradient></defs><rect x="3" y="3" width="18" height="18" rx="6" fill="url(#exImgGradient)"/><circle cx="12" cy="12" r="6" fill="#fff"/><circle cx="12" cy="12" r="3" fill="url(#exImgGradient)"/></svg>
                                </span>
                            </th>
                            <th class="enhanced-th" title="Official website of the exchange">
                                <span class="datatable-header-text" style="display:block; text-align:center;">URL</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exUrlGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ffd200"/><stop offset="1" stop-color="#ffb300"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#exUrlGradient)"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                                </span>
                            </th>
                            <th class="enhanced-th" title="Year the exchange was founded">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Year Established</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exYearGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#43cea2"/><stop offset="1" stop-color="#185a9d"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#exYearGradient)"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">📅</text></svg>
                                </span>
                            </th>
                            <th class="enhanced-th" title="Country where the exchange is based">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Country</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exCountryGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ff99ac"/></linearGradient></defs><rect x="3" y="3" width="18" height="18" rx="6" fill="url(#exCountryGradient)"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">🌍</text></svg>
                                </span>
                            </th>
                            <th class="enhanced-th" title="Brief description of the exchange">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Description</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exDescGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ffd200"/><stop offset="1" stop-color="#ffb300"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#exDescGradient)"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">📝</text></svg>
                                </span>
                            </th>
                            <th class="enhanced-th" title="Trust score assigned to the exchange">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Trust score</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exTrustGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#43cea2"/><stop offset="1" stop-color="#ffd200"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#exTrustGradient)"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">🔒</text></svg>
                                </span>
                            </th>
                            <th class="enhanced-th" title="Rank of the exchange by trust score">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Trust score rank</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exRankGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ff99ac"/><stop offset="1" stop-color="#ff6a88"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#exRankGradient)"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">🏅</text></svg>
                                </span>
                            </th>
                            <th class="enhanced-th" title="Whether the exchange offers trading incentives">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Has trading incentive</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><defs><linearGradient id="exIncentiveGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ffd200"/><stop offset="1" stop-color="#ffb300"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#exIncentiveGradient)"/><text x="12" y="16" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">🎁</text></svg>
                                </span>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Info Block: About Coingecko Exchanges -->
        <div class="modern-info-block-upgraded upgraded-gradient-bg" style="border-radius: 1.5em; box-shadow: 0 8px 32px 0 rgba(255, 106, 136, 0.18), 0 3px 12px 0 rgba(255, 153, 172, 0.13); padding: 2.2em 2em 2.2em 2em; margin-top: 2.5em; margin-bottom: 2.5em; color: #fff; background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);">
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; margin-bottom: 2.2em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,106,136,0.10);">
                    <!-- Globe/Exchanges Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="12" width="26" height="16" rx="4" fill="#ff99ac" stroke="#fff" stroke-width="2"/>
                        <rect x="11" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="19" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="27" y="16" width="2" height="8" rx="1" fill="#fff"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.25em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#fff;">Coingecko Exchanges</span>: Your Real-Time Crypto Exchange Dashboard
                    </p>
                    <p class="info-desc" style="margin-bottom:0; font-size:1.08em; line-height:1.7;">
                        <span style="font-size:1.2em;">🌐</span> <b>Coingecko Exchanges</b> is a real-time dashboard for comparing and monitoring the world's top cryptocurrency exchanges. It offers a user-friendly interface, supports hundreds of exchanges, and provides up-to-date data on trust score, volume, and more.<br><br>
                        <span style="font-size:1.2em;">🔒</span> <b>Security & Transparency:</b> Robust security, transparent data, and competitive fees.<br>
                        <span style="font-size:1.2em;">🚀</span> <b>For Everyone:</b> Designed for both beginners and experienced traders to make informed decisions and discover the best exchanges for their crypto journey.<br>
                        <span style="font-size:1.2em;">🏦</span> <b>Global Access:</b> Access exchange data from anywhere, anytime, on any device.
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
                        <span style="color:#fff;">How to Use the Exchanges Table</span>
                    </p>
                    <p style="font-size:1.08em; line-height:1.7; margin-bottom:1em;">
                        The table above provides a comprehensive overview of each exchange's key statistics. Use the column explanations below to better understand the data and make smarter trading decisions.
                    </p>
                    <ul class="datatable-columns-list" style="margin-bottom:0; font-size:1.08em; line-height:1.7; padding-left:1.2em; list-style:none;">
                        <li><span style="font-size:1.2em;">🏦</span> <b>Name:</b> The official name of the exchange.</li>
                        <li><span style="font-size:1.2em;">🖼️</span> <b>Image:</b> The official logo or icon representing the exchange.</li>
                        <li><span style="font-size:1.2em;">🔗</span> <b>URL:</b> The official website of the exchange.</li>
                        <li><span style="font-size:1.2em;">📅</span> <b>Year Established:</b> The year the exchange was founded.</li>
                        <li><span style="font-size:1.2em;">🌍</span> <b>Country:</b> The country where the exchange is based.</li>
                        <li><span style="font-size:1.2em;">📝</span> <b>Description:</b> A brief description of the exchange.</li>
                        <li><span style="font-size:1.2em;">🔒</span> <b>Trust score:</b> The trust score assigned to the exchange.</li>
                        <li><span style="font-size:1.2em;">🏅</span> <b>Trust score rank:</b> The rank of the exchange by trust score.</li>
                        <li><span style="font-size:1.2em;">🎁</span> <b>Has trading incentive:</b> Whether the exchange offers trading incentives.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Review Block for Exchanges -->
    <div class="modern-reviews-section">
        <h2 class="modern-reviews-title">
            Exchange Reviews
        </h2>
        <div id="reviews-list" class="reviews-list"></div>
        <hr style="border: none; border-top: 1.5px solid #ff99ac33; margin: 2em 0 2em 0;">
        <div class="modern-review-form-container">
            <h3 class="modern-review-form-title">Add Your Review</h3>
            <p style="text-align:center; color:#ff6a88; font-size:1.05em; margin-bottom:1.5em;">Share your experience with this exchange. Your feedback helps others make informed decisions!</p>
            <form id="reviewForm" method="POST" action="{{ url('/coingecko/exchanges/reviews') }}" autocomplete="off" aria-label="Add your review">
                @csrf
                <input type="hidden" name="exchange_code" value="all">
                <div class="modern-form-group">
                    <label for="name">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" fill="#ff6a88"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="#ff99ac" stroke-width="2"/></svg>
                        Name <span style="color:#ff6a88;">*</span>
                    </label>
                    <input type="text" class="form-control" id="name" name="name" required maxlength="255" placeholder="Your name" aria-required="true">
                </div>
                <div class="modern-form-group">
                    <label for="email">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ff99ac"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg>
                        Email <span style="color:#ff6a88;">*</span>
                    </label>
                    <input type="email" class="form-control" id="email" name="email" required maxlength="255" placeholder="you@email.com" aria-required="true">
                </div>
                <div class="modern-form-group">
                    <label for="rating">
                        <svg viewBox="0 0 24 24" fill="none"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" fill="#ff6a88"/></svg>
                        Rating <span style="color:#ff6a88;">*</span>
                    </label>
                    <select class="form-control" id="rating" name="rating" required aria-required="true">
                        <option value="">Select rating</option>
                        <option value="1">1 - Poor</option>
                        <option value="2">2 - Fair</option>
                        <option value="3">3 - Good</option>
                        <option value="4">4 - Very Good</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                </div>
                <div class="modern-form-group">
                    <label for="title">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ff99ac"/><path d="M8 12h8M8 16h4" stroke="#ff6a88" stroke-width="2"/></svg>
                        Review Title <span style="color:#ff6a88;">*</span>
                    </label>
                    <input type="text" class="form-control" id="title" name="title" required maxlength="255" placeholder="Short summary (e.g. 'Great support')" aria-required="true">
                </div>
                <div class="modern-form-group">
                    <label for="comment">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="4" fill="#ff99ac"/><path d="M6 8h12M6 12h8" stroke="#ff6a88" stroke-width="2"/></svg>
                        Your Review <span style="color:#ff6a88;">*</span>
                    </label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" required placeholder="Write your detailed experience here..." aria-required="true"></textarea>
                </div>
                <div class="modern-form-group">
                    <label for="country">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ff99ac"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg>
                        Country
                    </label>
                    <input type="text" class="form-control" id="country" name="country" maxlength="255" placeholder="Your country (optional)">
                </div>
                <div class="modern-form-group">
                    <label for="experience_level">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ff99ac"/><path d="M8 12h8M8 16h4" stroke="#ff6a88" stroke-width="2"/></svg>
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
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#ff99ac"/><path d="M8 12h8M8 16h4" stroke="#ff6a88" stroke-width="2"/></svg>
                        Pros
                    </label>
                    <textarea class="form-control" id="pros" name="pros" rows="2" placeholder="What did you like? (optional)"></textarea>
                </div>
                <div class="modern-form-group">
                    <label for="cons">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#ff6a88"/><path d="M8 12h8M8 16h4" stroke="#ff99ac" stroke-width="2"/></svg>
                        Cons
                    </label>
                    <textarea class="form-control" id="cons" name="cons" rows="2" placeholder="What could be improved? (optional)"></textarea>
                </div>
                <div class="modern-form-group">
                    <label for="recommend">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#ff99ac"/><path d="M8 12h8M8 16h4" stroke="#ff6a88" stroke-width="2"/></svg>
                        Would you recommend?
                    </label>
                    <select class="form-control" id="recommend" name="recommend">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <button type="submit" class="btn modern-review-form-btn" aria-label="Submit your review">Submit Review</button>
                <div id="reviewFormMsg" style="margin-top: 1em;"></div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="{{ url('js/coingecko/exchanges.js') }}"></script>
    <script>
        function renderReviews(reviews) {
            let html = '';
            if (reviews.length === 0) {
                html = '<div class="alert alert-info">No reviews yet. Be the first to review!</div>';
            } else {
                html = reviews.map(r => `
                    <div class="modern-review-card">
                        <div class="modern-review-avatar">${r.name ? r.name.charAt(0).toUpperCase() : '?'}</div>
                        <div class="modern-review-content">
                            <div class="modern-review-header">
                                <span class="modern-review-name">${r.name}</span>
                                <span class="modern-review-date"><svg style="width:1em;height:1em;vertical-align:middle;margin-right:0.2em;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff6a88"/><path d="M12 6v6l4 2" stroke="#ff99ac" stroke-width="2"/></svg> ${new Date(r.created_at).toLocaleDateString()}</span>
                                <span class="modern-review-rating">${'★'.repeat(r.rating)}${'☆'.repeat(5 - r.rating)}</span>
                            </div>
                            <div class="modern-review-title">${r.title}</div>
                            <div class="modern-review-comment">${r.comment.replace(/\n/g, '<br>')}</div>
                            <div class="modern-review-meta">
                                ${r.country ? `<span class="modern-review-country"><svg style="width:1em;height:1em;vertical-align:middle;margin-right:0.2em;" viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ff99ac"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg> ${r.country}</span>` : ''}
                                ${r.experience_level ? `<span class="modern-review-experience"><svg style="width:1em;height:1em;vertical-align:middle;margin-right:0.2em;" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ff99ac"/><path d="M8 12h8M8 16h4" stroke="#ff6a88" stroke-width="2"/></svg> ${r.experience_level}</span>` : ''}
                                ${r.pros ? `<span class="modern-review-pros"><b>Pros:</b> ${r.pros}</span>` : ''}
                                ${r.cons ? `<span class="modern-review-cons"><b>Cons:</b> ${r.cons}</span>` : ''}
                                ${typeof r.recommend !== 'undefined' && r.recommend !== null ? `<span class="modern-review-recommend">${r.recommend ? '👍 Recommended' : '👎 Not recommended'}</span>` : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
            }
            document.getElementById('reviews-list').innerHTML = html;
        }
        function fetchReviews() {
            fetch('/coingecko/exchanges/reviews')
                .then(res => res.json())
                .then(data => renderReviews(data));
        }
        fetchReviews();
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('[name=_token]').value
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-success">Thank you for your review!</div>';
                    form.reset();
                    fetchReviews();
                } else {
                    document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
                }
            })
            .catch(() => {
                document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
            });
        });
    </script>
@endsection