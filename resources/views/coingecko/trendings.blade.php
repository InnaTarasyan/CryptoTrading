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
                                <th class="datatable-highlight-first enhanced-th" aria-label="Name" title="The official name of the cryptocurrency">
                                    <div class="datatable-header-flex">
                                        <span class="datatable-header-icon">
                                            <svg viewBox="0 0 24 24" fill="none" width="22" height="22" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="trendingNameGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ff99ac"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#trendingNameGradient)"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                                        </span>
                                        <span class="datatable-header-text">Name</span>
                                    </div>
                                </th>
                                <th class="enhanced-th" aria-label="Image" title="The logo or icon representing the cryptocurrency">
                                    <div class="datatable-header-flex">
                                        <span class="datatable-header-icon">
                                            <svg viewBox="0 0 24 24" fill="none" width="22" height="22" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="trendingLogoGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ff99ac"/><stop offset="1" stop-color="#ff6a88"/></linearGradient></defs><rect x="3" y="3" width="18" height="18" rx="6" fill="url(#trendingLogoGradient)"/><circle cx="12" cy="12" r="6" fill="#fff"/><circle cx="12" cy="12" r="3" fill="url(#trendingLogoGradient)"/></svg>
                                        </span>
                                        <span class="datatable-header-text">Image</span>
                                    </div>
                                </th>
                                <th class="enhanced-th" aria-label="Market Cap Rank" title="The ranking of the coin by total market capitalization">
                                    <div class="datatable-header-flex">
                                        <span class="datatable-header-icon">
                                            <svg viewBox="0 0 24 24" fill="none" width="22" height="22" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="trendingRankGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#f7971e"/><stop offset="1" stop-color="#ffd200"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#trendingRankGradient)"/><path d="M8 6l2 4 3 1-2 2 1 3-4-2-4 2 1-3-2-2 3-1z" fill="#fff"/><text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">#</text></svg>
                                        </span>
                                        <span class="datatable-header-text">Rank</span>
                                    </div>
                                </th>
                                <th class="enhanced-th" aria-label="Slug" title="The unique identifier or URL-friendly name for the cryptocurrency">
                                    <div class="datatable-header-flex">
                                        <span class="datatable-header-icon">
                                            <svg viewBox="0 0 24 24" fill="none" width="22" height="22" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="trendingSlugGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#43cea2"/><stop offset="1" stop-color="#185a9d"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#trendingSlugGradient)"/><path d="M7 7h10M7 17h10M8 7c0 5 8 5 8 0M8 17c0-5 8-5 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                                        </span>
                                        <span class="datatable-header-text">Slug</span>
                                    </div>
                                </th>
                                <th class="enhanced-th" aria-label="Price BTC" title="The current price of the cryptocurrency denominated in Bitcoin (BTC)">
                                    <div class="datatable-header-flex">
                                        <span class="datatable-header-icon">
                                            <svg viewBox="0 0 24 24" fill="none" width="22" height="22" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="trendingPriceGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ffd200"/><stop offset="1" stop-color="#ffb300"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#trendingPriceGradient)"/><text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">₿</text></svg>
                                        </span>
                                        <span class="datatable-header-text">BTC</span>
                                    </div>
                                </th>
                                <th class="enhanced-th" aria-label="Score" title="A composite score reflecting the trending status of the coin">
                                    <div class="datatable-header-flex">
                                        <span class="datatable-header-icon">
                                            <svg viewBox="0 0 24 24" fill="none" width="22" height="22" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="trendingScoreGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ff99ac"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#trendingScoreGradient)"/><text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">★</text></svg>
                                        </span>
                                        <span class="datatable-header-text">Score</span>
                                    </div>
                                </th>
                                <th class="enhanced-th" aria-label="Data" title="Additional relevant data or metrics about the cryptocurrency">
                                    <div class="datatable-header-flex">
                                        <span class="datatable-header-icon">
                                            <svg viewBox="0 0 24 24" fill="none" width="22" height="22" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="trendingDataGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse"><stop stop-color="#43cea2"/><stop offset="1" stop-color="#185a9d"/></linearGradient></defs><circle cx="12" cy="12" r="11" fill="url(#trendingDataGradient)"/><path d="M7 9h10M7 15h10M8 9c0 3 8 3 8 0M8 15c0-3 8-3 8 0" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                                        </span>
                                        <span class="datatable-header-text">Data</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Info Block: About CoinGecko Trendings and Datatable -->
        <div class="modern-info-block-upgraded upgraded-gradient-bg" style="border-radius: 1.5em; box-shadow: 0 8px 32px 0 rgba(255, 106, 136, 0.18), 0 3px 12px 0 rgba(255, 153, 172, 0.13); padding: 2.2em 2em 2.2em 2em; margin-top: 2.5em; margin-bottom: 2.5em; color: #fff; background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);">
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; margin-bottom: 2.2em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,106,136,0.10);">
                    <!-- Trending Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="12" width="26" height="16" rx="4" fill="#ff99ac" stroke="#fff" stroke-width="2"/>
                        <rect x="11" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="19" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="27" y="16" width="2" height="8" rx="1" fill="#fff"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.25em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#fff;">About CoinGecko Trendings</span>
                    </p>
                    <p class="info-desc" style="margin-bottom:0; font-size:1.08em; line-height:1.7;">
                        CoinGecko Trendings is a feature that highlights the most popular and rapidly rising cryptocurrencies based on real-time user interest, trading activity, and market momentum. It aggregates trending tokens and coins across multiple blockchains, providing traders and enthusiasts with a snapshot of what s hot in the crypto market. By tracking trending assets, users can discover new opportunities, monitor market sentiment, and stay ahead of emerging trends. The trending list is updated frequently, reflecting the dynamic nature of the cryptocurrency space and helping users make informed decisions in a fast-moving market.
                    </p>
                </div>
            </div>
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,106,136,0.10);">
                    <!-- Table/Analytics Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="12" width="26" height="16" rx="4" fill="#ff6a88" stroke="#fff" stroke-width="2"/>
                        <rect x="11" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="19" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="27" y="16" width="2" height="8" rx="1" fill="#fff"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.18em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#fff;">About the Trending Datatable</span>
                    </p>
                    <p style="font-size:1.08em; line-height:1.7; margin-bottom:1em;">
                        The datatable above provides a real-time overview of trending cryptocurrencies, allowing users to quickly compare key metrics and discover which coins are gaining traction. Each column in the table offers specific insights to help users analyze and act on market trends.
                    </p>
                    <ul class="datatable-columns-list" style="margin-bottom:0; font-size:1.08em; line-height:1.7; padding-left:1.2em; list-style:none;">
                        <li><span style="font-size:1.2em;">🔤</span> <b>Name:</b> The official name of the cryptocurrency.</li>
                        <li><span style="font-size:1.2em;">🖼️</span> <b>Image:</b> The logo or icon representing the cryptocurrency.</li>
                        <li><span style="font-size:1.2em;">🏅</span> <b>Market Cap Rank:</b> The ranking of the coin by total market capitalization, indicating its relative size in the market.</li>
                        <li><span style="font-size:1.2em;">🔗</span> <b>Slug:</b> The unique identifier or URL-friendly name for the cryptocurrency, often used for navigation or API queries.</li>
                        <li><span style="font-size:1.2em;">₿</span> <b>Price BTC:</b> The current price of the cryptocurrency denominated in Bitcoin (BTC), showing its value relative to the leading digital asset.</li>
                        <li><span style="font-size:1.2em;">★</span> <b>Score:</b> A composite score reflecting the trending status of the coin, based on factors like user interest, trading volume, and recent performance.</li>
                        <li><span style="font-size:1.2em;">📊</span> <b>Data:</b> Additional relevant data or metrics about the cryptocurrency, such as recent changes, volume, or other analytics.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Review Block for Trendings -->
    <div class="modern-reviews-section">
        <h2 class="modern-reviews-title">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:0.3em;"><circle cx="11" cy="11" r="11" fill="url(#reviewGradient)"/><path d="M7 15l2-2 3 3 6-6-2-2-4 4-2-2-2 2z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><defs><linearGradient id="reviewGradient" x1="0" y1="0" x2="22" y2="22" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ff99ac"/></linearGradient></defs></svg>
            Trending Reviews
        </h2>
        <div id="reviews-list" class="reviews-list"></div>
        <div class="modern-review-form-container">
            <h3 class="modern-review-form-title">Add Your Review</h3>
            <form id="reviewForm" method="POST" action="{{ url('/coingecko/trendings/reviews') }}">
                @csrf
                <input type="hidden" name="trending_code" value="all">
                <div class="modern-form-group">
                    <label for="name">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="5" r="3" fill="#ff6a88"/><path d="M2 14c0-3 6-3 6-3s6 0 6 3" stroke="#ff99ac" stroke-width="1.2"/></svg>
                        Name
                    </label>
                    <input type="text" class="form-control" id="name" name="name" required maxlength="255">
                </div>
                <div class="modern-form-group">
                    <label for="email">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="4" width="14" height="8" rx="3" fill="#ff99ac"/><path d="M1 4l7 5 7-5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                        Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" required maxlength="255">
                </div>
                <div class="modern-form-group">
                    <label for="rating">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><polygon points="8,1 10,6 15,6 11,9 12,15 8,12 4,15 5,9 1,6 6,6" fill="#ff6a88"/></svg>
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
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="2" y="2" width="12" height="12" rx="3" fill="#ff99ac"/><path d="M4 8h8M4 12h5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                        Title
                    </label>
                    <input type="text" class="form-control" id="title" name="title" required maxlength="255">
                </div>
                <div class="modern-form-group">
                    <label for="comment">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="2" width="14" height="12" rx="3" fill="#ff99ac"/><path d="M3 5h10M3 9h7" stroke="#ff6a88" stroke-width="1.2"/></svg>
                        Comment
                    </label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                </div>
                <div class="modern-form-group">
                    <label for="country">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="4" width="14" height="8" rx="3" fill="#ff99ac"/><path d="M1 4l7 5 7-5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                        Country
                    </label>
                    <input type="text" class="form-control" id="country" name="country" maxlength="255">
                </div>
                <div class="modern-form-group">
                    <label for="experience_level">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="2" y="2" width="8" height="8" rx="2" fill="#ff99ac"/><path d="M4 6h4M4 9h2.5" stroke="#ff6a88" stroke-width="1"/></svg>
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
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#ff99ac"/><path d="M4 8h8M4 12h5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                        Pros
                    </label>
                    <textarea class="form-control" id="pros" name="pros" rows="2"></textarea>
                </div>
                <div class="modern-form-group">
                    <label for="cons">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#ff6a88"/><path d="M4 8h8M4 12h5" stroke="#ff99ac" stroke-width="1.2"/></svg>
                        Cons
                    </label>
                    <textarea class="form-control" id="cons" name="cons" rows="2"></textarea>
                </div>
                <div class="modern-form-group">
                    <label for="recommend">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#ff99ac"/><path d="M4 8h8M4 12h5" stroke="#ff6a88" stroke-width="1.2"/></svg>
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
                                <span class="modern-review-date"><svg width="14" height="14" style="vertical-align:middle;margin-right:0.2em;" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="7" fill="#ff6a88"/><path d="M7 3v4l3 1.5" stroke="#ff99ac" stroke-width="1.2"/></svg> ${new Date(r.created_at).toLocaleDateString()}</span>
                                <span class="modern-review-rating">${'★'.repeat(r.rating)}${'☆'.repeat(5 - r.rating)}</span>
                            </div>
                            <div class="modern-review-title">${r.title}</div>
                            <div class="modern-review-comment">${r.comment.replace(/\n/g, '<br>')}</div>
                            <div class="modern-review-meta">
                                ${r.country ? `<span class="modern-review-country"><svg width="12" height="12" style="vertical-align:middle;margin-right:0.2em;" viewBox="0 0 12 12" fill="none"><rect x="1" y="3" width="10" height="6" rx="2" fill="#ff99ac"/><path d="M1 3l5 3.5 5-3.5" stroke="#ff6a88" stroke-width="1"/></svg> ${r.country}</span>` : ''}
                                ${r.experience_level ? `<span class="modern-review-experience"><svg width="12" height="12" style="vertical-align:middle;margin-right:0.2em;" viewBox="0 0 12 12" fill="none"><rect x="2" y="2" width="8" height="8" rx="2" fill="#ff99ac"/><path d="M4 6h4M4 9h2.5" stroke="#ff6a88" stroke-width="1"/></svg> ${r.experience_level}</span>` : ''}
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
            fetch('/coingecko/trendings/reviews')
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