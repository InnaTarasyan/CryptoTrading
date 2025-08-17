@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/derivatives_exchanges.css') }}" rel="stylesheet">
    <style>
        /* Floating Dark Mode Toggle */
        .darkmode-toggle {
            position: fixed;
            top: 32px;
            right: 32px;
            z-index: 1001;
            background: linear-gradient(135deg, #232946 0%, #6366f1 100%);
            color: #fff;
            border: none;
            border-radius: 2em;
            box-shadow: 0 4px 24px rgba(80,80,200,0.18);
            padding: 0.6em 1.3em 0.6em 1em;
            font-size: 1.1em;
            display: flex;
            align-items: center;
            gap: 0.7em;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
        }
        .darkmode-toggle:focus {
            outline: 2px solid #6366f1;
        }
        .darkmode-toggle:hover {
            background: linear-gradient(135deg, #6366f1 0%, #232946 100%);
            color: #ffd200;
            transform: scale(1.04);
        }
        .darkmode-toggle .toggle-icon {
            font-size: 1.3em;
            display: flex;
            align-items: center;
        }
        @media (max-width: 600px) {
            .darkmode-toggle {
                top: 12px;
                right: 12px;
                font-size: 1em;
                padding: 0.5em 1em 0.5em 0.8em;
            }
        }
        /* Dark Mode Styles */
        body.dark-mode {
            background: #181a20 !important;
            color: #e5e7eb !important;
            transition: background 0.3s, color 0.3s;
        }
        body.dark-mode .m-content,
        body.dark-mode .modern-portlet,
        body.dark-mode .modern-portlet-body,
        body.dark-mode .table-wrapper,
        body.dark-mode .enhanced-portlet {
            background: linear-gradient(135deg, #232946 0%, #181a20 100%) !important;
            color: #e5e7eb !important;
            box-shadow: 0 4px 32px rgba(20,20,40,0.18) !important;
            border-color: #232946 !important;
        }
        body.dark-mode .modern-title-bar,
        body.dark-mode .modern-tabs-container,
        body.dark-mode .modern-tabs,
        body.dark-mode .modern-table-wrapper {
            background: #232946 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode .modern-title-text,
        body.dark-mode .tab-label {
            color: #ffd200 !important;
        }
        body.dark-mode .modern-tab.beautiful-tab.active {
            background: linear-gradient(90deg, #6366f1 0%, #232946 100%) !important;
            color: #ffd200 !important;
        }
        body.dark-mode .modern-tab.beautiful-tab {
            background: #232946 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode .enhanced-table,
        body.dark-mode .modern-table {
            background: #232946 !important;
            color: #e5e7eb !important;
        }
        body.dark-mode .enhanced-thead,
        body.dark-mode .modern-thead {
            background: linear-gradient(135deg, #232946 0%, #181a20 100%) !important;
            color: #ffd200 !important;
        }
        body.dark-mode .enhanced-th,
        body.dark-mode .datatable-header-text {
            color: #ffd200 !important;
        }
        body.dark-mode .datatable-header-icon svg {
            filter: brightness(0.9) drop-shadow(0 0 2px #ffd200);
        }
        body.dark-mode .dataTables_wrapper,
        body.dark-mode .dataTables_paginate,
        body.dark-mode .dataTables_info,
        body.dark-mode .dataTables_length,
        body.dark-mode .dataTables_filter {
            color: #e5e7eb !important;
        }
        body.dark-mode .dataTables_filter input,
        body.dark-mode .dataTables_length select {
            background: #232946 !important;
            color: #ffd200 !important;
            border: 1px solid #6366f1 !important;
        }
        body.dark-mode .table-hover tbody tr:hover {
            background: #232946 !important;
            color: #ffd200 !important;
        }
        body.dark-mode .modern-refresh-btn-upgraded,
        body.dark-mode .modern-fullscreen-btn {
            background: linear-gradient(135deg, #232946 0%, #6366f1 100%) !important;
            color: #ffd200 !important;
        }
        body.dark-mode .modern-refresh-btn-upgraded:hover,
        body.dark-mode .modern-fullscreen-btn:hover {
            background: linear-gradient(135deg, #6366f1 0%, #232946 100%) !important;
            color: #ffd200 !important;
        }
        body.dark-mode .enhanced-loading {
            background: #232946 !important;
            color: #ffd200 !important;
        }
        body.dark-mode .loading-container {
            background: #232946 !important;
            color: #ffd200 !important;
        }
        body.dark-mode .datatable-header-icon svg,
        body.dark-mode .datatable-header-icon svg * {
            filter: brightness(1.2) drop-shadow(0 0 2px #ffd200);
        }
        body.dark-mode .datatable-btn {
            background: #232946 !important;
            color: #ffd200 !important;
            border: 1px solid #6366f1 !important;
        }
        body.dark-mode .datatable-btn:hover {
            background: #6366f1 !important;
            color: #fff !important;
        }
        body.dark-mode .alert,
        body.dark-mode .alert-success,
        body.dark-mode .alert-danger {
            background: #232946 !important;
            color: #ffd200 !important;
            border-color: #6366f1 !important;
        }
        body.dark-mode .modern-title-bar-row svg {
            filter: brightness(1.2) drop-shadow(0 0 2px #ffd200);
        }
        body.dark-mode .gradient-tabs-bg {
            background: linear-gradient(90deg, #232946 0%, #6366f1 100%) !important;
        }
        body.dark-mode .modern-title-bar {
            border-bottom: 2px solid #6366f1 !important;
        }
        body.dark-mode .m-portlet {
            border: 1px solid #232946 !important;
        }
        body.dark-mode .table-wrapper {
            background: #232946 !important;
        }
        body.dark-mode .enhanced-table td, body.dark-mode .enhanced-table th {
            border-color: #6366f1 !important;
        }
        body.dark-mode .enhanced-table tr {
            border-bottom: 1px solid #232946 !important;
        }
        body.dark-mode .enhanced-table tr:last-child {
            border-bottom: none !important;
        }
        body.dark-mode .enhanced-table .datatable-header-text {
            color: #ffd200 !important;
        }
        body.dark-mode .enhanced-table .datatable-header-icon svg {
            filter: brightness(1.2) drop-shadow(0 0 2px #ffd200);
        }
        .custom-tooltip-box {
            position: fixed;
            background: #232946;
            color: #ffd200;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 1em;
            z-index: 99999;
            max-width: 350px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            pointer-events: none;
            white-space: pre-line;
        }
        /* Custom DataTable font styles */
        table.dataTable, table.dataTable th, table.dataTable td {
            font-size: 0.92em !important;
            font-family: 'Poppins', 'Roboto', Arial, Helvetica, sans-serif !important;
            font-style: italic !important;
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
    <button class="darkmode-toggle" id="darkModeToggle" aria-label="Toggle dark mode" title="Toggle dark mode">
        <span class="toggle-icon" id="darkModeIcon">
            <!-- Sun/Moon SVG will be injected by JS -->
        </span>
        <span class="toggle-label" id="darkModeLabel">Dark Mode</span>
    </button>
    <div class="m-content">
        <!-- Modern Title Bar with Icon and Enhanced Dark Mode Button -->
        <div class="modern-title-bar" aria-labelledby="derivativesExchangesTitle" role="banner">
            <div class="modern-title-bar-row">
                <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
                    <span class="modern-title-icon" tabindex="0" title="Derivatives Exchanges Overview">
                        <!-- Derivatives Exchanges Icon SVG (Pink Gradient) -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="derivativesExchangesGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff6a88"/>
                                    <stop offset="1" stop-color="#ff99ac"/>
                                </linearGradient>
                            </defs>
                            <circle cx="16" cy="16" r="16" fill="url(#derivativesExchangesGradient)"/>
                            <path d="M8 12h16M12 8v16M20 8v16" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="modern-title-text" id="derivativesExchangesTitle">Derivatives Exchanges</span>
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

        <!-- Action Buttons -->
        <div class="action-buttons-row">
            <div class="action-buttons-left">
                <button id="refreshTable" class="modern-refresh-btn-upgraded" title="Refresh Table" aria-label="Refresh Table" aria-busy="false" aria-disabled="false" tabindex="0">
                    <span class="refresh-btn-icon">
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

        <style>
            /* Enhanced Action Buttons Styling */
            .modern-action-btn {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
                border: none;
                border-radius: 12px;
                padding: 12px 20px;
                color: white;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
                min-width: 140px;
                justify-content: center;
            }

            .modern-action-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
                background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 50%, #e085e8 100%);
            }

            .modern-action-btn:active {
                transform: translateY(0);
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }

            .modern-action-btn:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3), 0 8px 25px rgba(102, 126, 234, 0.4);
            }

            .btn-gradient-bg {
                display: flex;
                align-items: center;
                gap: 8px;
                position: relative;
                z-index: 1;
            }

            .refresh-btn-enhanced {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            }

            .refresh-btn-enhanced:hover {
                background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 50%, #e085e8 100%);
            }

            .fullscreen-btn-enhanced {
                background: linear-gradient(135deg, #ff6a88 0%, #ff99ac 50%, #ff6a88 100%);
            }

            .fullscreen-btn-enhanced:hover {
                background: linear-gradient(135deg, #ff5a78 0%, #ff89ac 50%, #ff5a78 100%);
            }

            .ripple-effect {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }

            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            /* Enhanced Dark Mode Button */
            .enhanced-darkmode {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
                border: none;
                border-radius: 25px;
                padding: 12px 24px;
                color: white;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
                display: flex;
                align-items: center;
                gap: 12px;
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.25);
                min-width: 180px;
                justify-content: center;
                user-select: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
            }

            .enhanced-darkmode:hover {
                transform: translateY(-3px) scale(1.02);
                box-shadow: 0 12px 30px rgba(102, 126, 234, 0.35);
                background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 50%, #e085e8 100%);
            }

            .enhanced-darkmode:active {
                transform: translateY(-1px) scale(0.98);
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
                transition: all 0.1s ease;
            }

            .enhanced-darkmode:focus {
                outline: none;
                box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.3), 0 12px 30px rgba(102, 126, 234, 0.35);
            }

            .enhanced-darkmode:focus-visible {
                outline: 2px solid rgba(255, 255, 255, 0.8);
                outline-offset: 2px;
            }

            /* Dark Mode Switch Track */
            .darkmode-switch-track {
                background: rgba(255, 255, 255, 0.25);
                border-radius: 25px;
                width: 48px;
                height: 24px;
                position: relative;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                border: 2px solid rgba(255, 255, 255, 0.3);
                backdrop-filter: blur(10px);
            }

            .enhanced-darkmode:hover .darkmode-switch-track {
                background: rgba(255, 255, 255, 0.35);
                border-color: rgba(255, 255, 255, 0.5);
            }

            /* Dark Mode Switch Thumb */
            .darkmode-switch-thumb {
                background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                border-radius: 50%;
                width: 18px;
                height: 18px;
                position: absolute;
                top: 1px;
                left: 1px;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.8);
            }

            .enhanced-darkmode:hover .darkmode-switch-thumb {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2), 0 2px 6px rgba(0, 0, 0, 0.15);
                transform: scale(1.05);
            }

            /* Dark Mode Switch Icon */
            .darkmode-switch-icon {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
            }

            .darkmode-switch-icon svg {
                transition: all 0.3s ease;
            }

            .enhanced-darkmode:hover .darkmode-switch-icon svg {
                transform: scale(1.1);
            }

            /* Dark Mode Text Label */
            .darkmode-switch-label {
                font-weight: 600;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            .enhanced-darkmode:hover .darkmode-switch-label {
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            }

            /* Status Indicator */
            .darkmode-status-indicator {
                position: absolute;
                top: -8px;
                right: -8px;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
                border: 2px solid white;
                box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
                opacity: 0;
                transform: scale(0);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .darkmode-status-indicator.active {
                opacity: 1;
                transform: scale(1);
            }

            /* Ripple Effect for Dark Mode Button */
            .enhanced-darkmode::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: translate(-50%, -50%);
                transition: width 0.6s ease, height 0.6s ease;
            }

            .enhanced-darkmode:active::before {
                width: 300px;
                height: 300px;
            }

            /* Tooltip Enhancement */
            .theme-preview-tooltip {
                position: absolute;
                top: -45px;
                left: 50%;
                transform: translateX(-50%);
                background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
                color: white;
                padding: 8px 12px;
                border-radius: 8px;
                font-size: 12px;
                font-weight: 500;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                z-index: 1000;
            }

            .theme-preview-tooltip::after {
                content: '';
                position: absolute;
                top: 100%;
                left: 50%;
                transform: translateX(-50%);
                border: 6px solid transparent;
                border-top-color: #1f2937;
            }

            .enhanced-darkmode:hover + .theme-preview-tooltip {
                opacity: 1;
                visibility: visible;
                transform: translateX(-50%) translateY(-5px);
            }

            /* Responsive Design for Dark Mode Button */
            @media (max-width: 768px) {
                .enhanced-darkmode {
                    min-width: auto;
                    width: 100%;
                    justify-content: center;
                    padding: 15px 24px;
                    font-size: 16px;
                    border-radius: 20px;
                }

                .darkmode-switch-track {
                    width: 44px;
                    height: 22px;
                }

                .darkmode-switch-thumb {
                    width: 16px;
                    height: 16px;
                }
            }

            @media (max-width: 480px) {
                .enhanced-darkmode {
                    padding: 18px 24px;
                    font-size: 16px;
                    gap: 10px;
                }

                .darkmode-switch-track {
                    width: 40px;
                    height: 20px;
                }

                .darkmode-switch-thumb {
                    width: 14px;
                    height: 14px;
                }
            }

            /* High Contrast Mode Support */
            @media (prefers-contrast: high) {
                .enhanced-darkmode {
                    border: 2px solid currentColor;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
                }

                .darkmode-switch-track {
                    border: 2px solid currentColor;
                    background: rgba(255, 255, 255, 0.9);
                }
            }

            /* Reduced Motion Support */
            @media (prefers-reduced-motion: reduce) {
                .enhanced-darkmode,
                .darkmode-switch-track,
                .darkmode-switch-thumb,
                .darkmode-switch-icon,
                .darkmode-switch-label {
                    transition: none;
                }

                .enhanced-darkmode:hover {
                    transform: none;
                }
            }

            /* Fullscreen Table Styles */
            .table-wrapper:fullscreen {
                background: #fff !important;
                padding: 20px !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: flex-start !important;
                align-items: stretch !important;
                width: 100vw !important;
                height: 100vh !important;
                overflow: auto !important;
            }

            .table-wrapper:-webkit-full-screen {
                background: #fff !important;
                padding: 20px !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: flex-start !important;
                align-items: stretch !important;
                width: 100vw !important;
                height: 100vh !important;
                overflow: auto !important;
            }

            .table-wrapper:-moz-full-screen {
                background: #fff !important;
                padding: 20px !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: flex-start !important;
                align-items: stretch !important;
                width: 100vw !important;
                height: 100vh !important;
                overflow: auto !important;
            }

            .table-wrapper:-ms-fullscreen {
                background: #fff !important;
                padding: 20px !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: flex-start !important;
                align-items: stretch !important;
                width: 100vw !important;
                height: 100vh !important;
                overflow: auto !important;
            }

            /* Fullscreen DataTables wrapper */
            .table-wrapper:fullscreen .dataTables_wrapper {
                width: 100% !important;
                max-width: none !important;
                height: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                flex: 1 !important;
            }

            .table-wrapper:-webkit-full-screen .dataTables_wrapper {
                width: 100% !important;
                max-width: none !important;
                height: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                flex: 1 !important;
            }

            .table-wrapper:-moz-full-screen .dataTables_wrapper {
                width: 100% !important;
                max-width: none !important;
                height: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                flex: 1 !important;
            }

            .table-wrapper:-ms-fullscreen .dataTables_wrapper {
                width: 100% !important;
                max-width: none !important;
                height: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                flex: 1 !important;
            }

            /* Fullscreen table styling */
            .table-wrapper:fullscreen .enhanced-table {
                width: 100% !important;
                max-width: none !important;
                font-size: 16px !important;
                flex: 1 !important;
            }

            .table-wrapper:-webkit-full-screen .enhanced-table {
                width: 100% !important;
                max-width: none !important;
                font-size: 16px !important;
                flex: 1 !important;
            }

            .table-wrapper:-moz-full-screen .enhanced-table {
                width: 100% !important;
                max-width: none !important;
                font-size: 16px !important;
                flex: 1 !important;
            }

            .table-wrapper:-ms-fullscreen .enhanced-table {
                width: 100% !important;
                max-width: none !important;
                font-size: 16px !important;
                flex: 1 !important;
            }

            /* Fullscreen header styling */
            .table-wrapper:fullscreen .enhanced-thead {
                background: linear-gradient(135deg, rgba(99,102,241,0.15) 0%, rgba(96,165,250,0.15) 100%) !important;
                font-weight: bold !important;
                font-size: 18px !important;
            }

            .table-wrapper:-webkit-full-screen .enhanced-thead {
                background: linear-gradient(135deg, rgba(99,102,241,0.15) 0%, rgba(96,165,250,0.15) 100%) !important;
                font-weight: bold !important;
                font-size: 18px !important;
            }

            .table-wrapper:-moz-full-screen .enhanced-thead {
                background: linear-gradient(135deg, rgba(99,102,241,0.15) 0%, rgba(96,165,250,0.15) 100%) !important;
                font-weight: bold !important;
                font-size: 18px !important;
            }

            .table-wrapper:-ms-fullscreen .enhanced-thead {
                background: linear-gradient(135deg, rgba(99,102,241,0.15) 0%, rgba(96,165,250,0.15) 100%) !important;
                font-weight: bold !important;
                font-size: 18px !important;
            }

            /* Fullscreen DataTables controls - ensure they're visible */
            .table-wrapper:fullscreen .dataTables_length,
            .table-wrapper:fullscreen .dataTables_filter,
            .table-wrapper:fullscreen .dataTables_info,
            .table-wrapper:fullscreen .dataTables_paginate,
            .table-wrapper:fullscreen .datatable-toolbar {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                margin: 10px 0 !important;
                position: static !important;
            }

            .table-wrapper:-webkit-full-screen .dataTables_length,
            .table-wrapper:-webkit-full-screen .dataTables_filter,
            .table-wrapper:-webkit-full-screen .dataTables_info,
            .table-wrapper:-webkit-full-screen .dataTables_paginate,
            .table-wrapper:-webkit-full-screen .datatable-toolbar {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                margin: 10px 0 !important;
                position: static !important;
            }

            .table-wrapper:-moz-full-screen .dataTables_length,
            .table-wrapper:-moz-full-screen .dataTables_filter,
            .table-wrapper:-moz-full-screen .dataTables_info,
            .table-wrapper:-moz-full-screen .dataTables_paginate,
            .table-wrapper:-moz-full-screen .datatable-toolbar {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                margin: 10px 0 !important;
                position: static !important;
            }

            .table-wrapper:-ms-fullscreen .dataTables_length,
            .table-wrapper:-ms-fullscreen .dataTables_filter,
            .table-wrapper:-ms-fullscreen .dataTables_info,
            .table-wrapper:-ms-fullscreen .dataTables_paginate,
            .table-wrapper:-ms-fullscreen .datatable-toolbar {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                margin: 10px 0 !important;
                position: static !important;
            }

            /* Fullscreen pagination styling */
            .table-wrapper:fullscreen .dataTables_paginate {
                font-size: 16px !important;
                margin-top: 20px !important;
                text-align: center !important;
            }

            .table-wrapper:-webkit-full-screen .dataTables_paginate {
                font-size: 16px !important;
                margin-top: 20px !important;
                text-align: center !important;
            }

            .table-wrapper:-moz-full-screen .dataTables_paginate {
                font-size: 16px !important;
                margin-top: 20px !important;
                text-align: center !important;
            }

            .table-wrapper:-ms-fullscreen .dataTables_paginate {
                font-size: 16px !important;
                margin-top: 20px !important;
                text-align: center !important;
            }

            /* Fullscreen buttons styling */
            .table-wrapper:fullscreen .datatable-btn {
                font-size: 14px !important;
                padding: 8px 16px !important;
                margin: 2px !important;
            }

            .table-wrapper:-webkit-full-screen .datatable-btn {
                font-size: 14px !important;
                padding: 8px 16px !important;
                margin: 2px !important;
            }

            .table-wrapper:-moz-full-screen .datatable-btn {
                font-size: 14px !important;
                padding: 8px 16px !important;
                margin: 2px !important;
            }

            .table-wrapper:-ms-fullscreen .datatable-btn {
                font-size: 14px !important;
                padding: 8px 16px !important;
                margin: 2px !important;
            }

            /* Fullscreen search and length controls */
            .table-wrapper:fullscreen .dataTables_filter input,
            .table-wrapper:fullscreen .dataTables_length select {
                font-size: 16px !important;
                padding: 8px !important;
            }

            .table-wrapper:-webkit-full-screen .dataTables_filter input,
            .table-wrapper:-webkit-full-screen .dataTables_length select {
                font-size: 16px !important;
                padding: 8px !important;
            }

            .table-wrapper:-moz-full-screen .dataTables_filter input,
            .table-wrapper:-moz-full-screen .dataTables_length select {
                font-size: 16px !important;
                padding: 8px !important;
            }

            .table-wrapper:-ms-fullscreen .dataTables_filter input,
            .table-wrapper:-ms-fullscreen .dataTables_length select {
                font-size: 16px !important;
                padding: 8px !important;
            }
        </style>

        <!-- DataTable Section -->
        {{--<div class="m-portlet enhanced-portlet modern-portlet" style="--}}
            {{--background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(240,248,255,0.8) 100%);--}}
            {{--border-radius: 1.5em;--}}
            {{--box-shadow: 0 8px 32px rgba(80,80,200,0.12);--}}
            {{--backdrop-filter: blur(10px);--}}
            {{--border: 1px solid rgba(99,102,241,0.1);--}}
            {{--margin: 2em 0;--}}
            {{--overflow: hidden;--}}
            {{--position: relative;--}}
        {{--">--}}
            <!-- Decorative gradient overlay -->
            <div style="
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 50%, #43cea2 100%);
                z-index: 1;
            "></div>

            <div class=" mt-5" style="
                padding: 2.5em 2em;
                position: relative;
                z-index: 2;
            ">
                <input type="hidden" id="coingecko_derivatives_exchanges_route" value="{{ route('datatable.coingecko.derivatives_exchanges') }}">

                <!-- Enhanced Loading State -->
                <div id="datatableLoading" class="datatable-loading enhanced-loading modern-loading" style="display:none;">
                    <div class="loading-container" style="
                        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,248,255,0.9) 100%);
                        border-radius: 1.2em;
                        padding: 3em 2em;
                        text-align: center;
                        box-shadow: 0 4px 20px rgba(80,80,200,0.1);
                        backdrop-filter: blur(8px);
                    ">
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
                        <div class="loading-text" style="margin-top: 1.5em;">
                            <h3 style="color: #3730a3; font-weight: 700; margin-bottom: 0.5em;">Loading Derivatives Exchanges Data</h3>
                            <p style="color: #6366f1; font-size: 1.1em;">Please wait while we fetch the latest market information...</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Table Container -->
                <div id="datatableFullscreenContainer" class="table-responsive enhanced-table-container modern-table-container" style="
                    background: linear-gradient(135deg, rgba(255,255,255,0.8) 0%, rgba(248,250,252,0.9) 100%);
                    border-radius: 1.2em;
                    padding: 1.5em;
                    box-shadow: 0 2px 16px rgba(80,80,200,0.08);
                    backdrop-filter: blur(5px);
                    border: 1px solid rgba(99,102,241,0.05);
                ">
                    <!-- Table Status Bar -->
                    {{--<div class="table-status-bar modern-status-bar" id="tableStatusBar" style="--}}
                        {{--background: linear-gradient(90deg, rgba(99,102,241,0.1) 0%, rgba(96,165,250,0.1) 100%);--}}
                        {{--border-radius: 1em;--}}
                        {{--padding: 1em 1.5em;--}}
                        {{--margin-bottom: 1.5em;--}}
                        {{--display: flex;--}}
                        {{--justify-content: space-between;--}}
                        {{--align-items: center;--}}
                        {{--border: 1px solid rgba(99,102,241,0.1);--}}
                    {{--">--}}
                        {{--<div class="status-info" style="display: flex; align-items: center; gap: 0.8em;">--}}
                            {{--<span class="status-icon" style="font-size: 1.2em;">📊</span>--}}
                            {{--<span class="status-text" style="color: #3730a3; font-weight: 600;">Ready to display derivatives exchanges data</span>--}}
                        {{--</div>--}}
                        {{--<div class="status-actions" style="display: flex; gap: 0.8em;">--}}
                            {{--<button class="status-action-btn modern-action-btn" id="exportData" title="Export Data" style="--}}
                                {{--background: linear-gradient(135deg, #ff6a88 0%, #ff99ac 100%);--}}
                                {{--border: none;--}}
                                {{--border-radius: 0.8em;--}}
                                {{--padding: 0.6em 1.2em;--}}
                                {{--color: white;--}}
                                {{--font-weight: 600;--}}
                                {{--display: flex;--}}
                                {{--align-items: center;--}}
                                {{--gap: 0.5em;--}}
                                {{--transition: all 0.2s;--}}
                                {{--box-shadow: 0 2px 8px rgba(255,106,136,0.2);--}}
                            {{--">--}}
                                {{--<svg width="16" height="16" viewBox="0 0 24 24" fill="none">--}}
                                    {{--<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
                                    {{--<polyline points="7,10 12,15 17,10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
                                    {{--<line x1="12" y1="15" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
                                {{--</svg>--}}
                                {{--Export--}}
                            {{--</button>--}}
                            {{--<button class="status-action-btn modern-action-btn" id="printTable" title="Print Table" style="--}}
                                {{--background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);--}}
                                {{--border: none;--}}
                                {{--border-radius: 0.8em;--}}
                                {{--padding: 0.6em 1.2em;--}}
                                {{--color: white;--}}
                                {{--font-weight: 600;--}}
                                {{--display: flex;--}}
                                {{--align-items: center;--}}
                                {{--gap: 0.5em;--}}
                                {{--transition: all 0.2s;--}}
                                {{--box-shadow: 0 2px 8px rgba(67,206,162,0.2);--}}
                            {{--">--}}
                                {{--<svg width="16" height="16" viewBox="0 0 24 24" fill="none">--}}
                                    {{--<polyline points="6,9 6,2 18,2 18,9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
                                    {{--<path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
                                    {{--<rect x="6" y="14" width="12" height="8" rx="1" fill="none" stroke="currentColor" stroke-width="2"/>--}}
                                {{--</svg>--}}
                                {{--Print--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <!-- Enhanced Table -->
                    <div class="table-wrapper modern-table-wrapper" style="background: rgba(255,255,255,0.7); border-radius: 1em; overflow: hidden; box-shadow: 0 2px 12px rgba(80,80,200,0.06); border: 1px solid rgba(99,102,241,0.05);">
                        <div style="overflow-x: auto; width: 100%;">
                            <table id="coingecko_derivatives_exchanges" class="table table-hover table-condensed table-striped enhanced-table modern-table text-center" style="width:100%; padding-top:1%; table-layout: fixed;">
                                <thead class="enhanced-thead modern-thead" style="background: linear-gradient(135deg, rgba(99,102,241,0.1) 0%, rgba(96,165,250,0.1) 100%); border-bottom: 2px solid rgba(99,102,241,0.2);">
                                <tr>
                                    <th class="datatable-highlight-first enhanced-th" style="text-align:left; width: 160px; min-width: 120px; max-width: 220px;">
                                        <span class="datatable-header-text" style="display:block; text-align:left;">Exchange</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:left; margin-top:4px;">
                                            <!-- Modern Exchange Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="exchangeGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <rect x="3" y="3" width="18" height="18" rx="5" fill="url(#exchangeGradient)"/>
                                                <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Official logo or icon of the exchange" class="enhanced-th" style="width:72px;min-width:72px;max-width:72px;text-align:left;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Logo</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
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
                                    <th title="Description of the exchange" class="enhanced-th" style="text-align:left; width: 260px; min-width: 180px; max-width: 340px;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Description</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
                                            <!-- Modern Description Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="descGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#43cea2"/>
                                                        <stop offset="1" stop-color="#185a9d"/>
                                                    </linearGradient>
                                                </defs>
                                                <rect x="2" y="4" width="20" height="16" rx="4" fill="url(#descGradient)"/>
                                                <path d="M6 8h12M6 12h8" stroke="#fff" stroke-width="2"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Open interest in Bitcoin" class="enhanced-th" style="text-align:left; width: 120px; min-width: 100px; max-width: 160px;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Open Interest BTC</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
                                            <!-- Modern BTC Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="btcGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#f7931a"/>
                                                        <stop offset="1" stop-color="#ffd200"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#btcGradient)"/>
                                                <text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">₿</text>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="24-hour trading volume in Bitcoin" class="enhanced-th" style="text-align:left; width: 120px; min-width: 100px; max-width: 160px;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">24h Volume BTC</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
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
                                    </th>
                                    <th title="Number of perpetual trading pairs" class="enhanced-th" style="text-align:left; width: 100px; min-width: 80px; max-width: 120px;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Perpetual Pairs</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
                                            <!-- Modern Pairs Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="pairsGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#pairsGradient)"/>
                                                <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                                <circle cx="12" cy="12" r="3" fill="#fff" opacity="0.3"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Number of futures trading pairs" class="enhanced-th" style="text-align:left; width: 100px; min-width: 80px; max-width: 120px;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Futures Pairs</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
                                            <!-- Modern Futures Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="futuresGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#43cea2"/>
                                                        <stop offset="1" stop-color="#185a9d"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#futuresGradient)"/>
                                                <path d="M8 10l4 8 4-8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <text x="12" y="20" text-anchor="middle" font-size="8" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">F</text>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Year the exchange was established" class="enhanced-th" style="text-align:left; width: 90px; min-width: 70px; max-width: 110px;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Established</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
                                            <!-- Modern Year Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="yearGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ffd200"/>
                                                        <stop offset="1" stop-color="#ffb300"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#yearGradient)"/>
                                                <text x="12" y="17" text-anchor="middle" font-size="10" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">Y</text>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Country where the exchange is based" class="enhanced-th" style="text-align:left; width: 110px; min-width: 80px; max-width: 140px;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Country</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
                                            <!-- Modern Country Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="countryGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#ff6a88"/>
                                                        <stop offset="1" stop-color="#ff99ac"/>
                                                    </linearGradient>
                                                </defs>
                                                <circle cx="12" cy="12" r="11" fill="url(#countryGradient)"/>
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" stroke="#fff" stroke-width="1.5" fill="none"/>
                                                <path d="M12 6v6l4 2" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </span>
                                    </th>
                                    <th title="Website URL of the exchange" class="enhanced-th" style="text-align:left; width: 180px; min-width: 120px; max-width: 240px;">
                                        <span class="datatable-header-text" style="display:block; text-align:center;">Website</span>
                                        <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:4px;">
                                            <!-- Modern URL Icon with Gradient -->
                                            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                                <defs>
                                                    <linearGradient id="urlGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#43cea2"/>
                                                        <stop offset="1" stop-color="#185a9d"/>
                                                    </linearGradient>
                                                </defs>
                                                <rect x="3" y="3" width="18" height="18" rx="4" fill="url(#urlGradient)"/>
                                                <path d="M10 6h4M6 10v4h12v-4" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                        </span>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Info Block: About Coingecko Derivatives Exchanges and Table Columns -->
                <section class="derivatives-info-block">
                    <h2 class="derivatives-info-title">About Coingecko Derivatives Exchanges</h2>
                    <p class="derivatives-info-paragraph">
                        Coingecko Derivatives Exchanges are platforms where users can trade cryptocurrency derivatives, such as perpetual contracts and futures. These exchanges allow traders to speculate on the price movements of cryptocurrencies without owning the underlying assets. Coingecko provides a comprehensive overview of these exchanges, including their trading volumes, open interest, and the variety of derivative products offered. The platform helps users compare exchanges based on transparency, liquidity, and the number of available trading pairs, making it easier to choose a suitable venue for derivatives trading.
                    </p>
                    <h3 class="derivatives-info-subtitle">About the Table Above</h3>
                    <p class="derivatives-info-paragraph">
                        The datatable above presents a detailed comparison of major cryptocurrency derivatives exchanges, highlighting key metrics and features to help users make informed trading decisions.
                    </p>
                    <ul class="derivatives-info-list">
                        <li><b>Exchange:</b> The name of the derivatives exchange.</li>
                        <li><b>Logo:</b> The official logo or icon representing the exchange.</li>
                        <li><b>Description:</b> A brief summary of the exchange, including its unique features or focus.</li>
                        <li><b>Open Interest BTC:</b> The total value of outstanding derivative contracts (open interest) on the exchange, denominated in Bitcoin. This metric indicates the level of activity and liquidity.</li>
                        <li><b>24h Volume BTC:</b> The total trading volume of derivatives on the exchange in the past 24 hours, measured in Bitcoin. Higher volume suggests greater liquidity and user participation.</li>
                        <li><b>Perpetual Pairs:</b> The number of perpetual swap trading pairs available on the exchange. Perpetual swaps are a type of derivative contract with no expiry date.</li>
                        <li><b>Futures Pairs:</b> The number of futures trading pairs offered. Futures contracts are agreements to buy or sell an asset at a predetermined price at a specified time in the future.</li>
                    </ul>
                </section>
                <style>
                .derivatives-info-block {
                    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
                    border-radius: 1.2em;
                    box-shadow: 0 2px 16px rgba(80,80,200,0.08);
                    padding: 2em 1.5em;
                    margin: 2.5em 0 1.5em 0;
                    max-width: 900px;
                    margin-left: auto;
                    margin-right: auto;
                    font-family: 'Poppins', 'Roboto', Arial, Helvetica, sans-serif;
                }
                .derivatives-info-title {
                    font-size: 1.5em;
                    font-weight: 700;
                    color: #3730a3;
                    margin-bottom: 0.7em;
                    text-align: center;
                }
                .derivatives-info-subtitle {
                    font-size: 1.15em;
                    font-weight: 600;
                    color: #6366f1;
                    margin-top: 1.5em;
                    margin-bottom: 0.5em;
                }
                .derivatives-info-paragraph {
                    font-size: 1.08em;
                    color: #232946;
                    margin-bottom: 1em;
                    line-height: 1.7;
                    text-align: justify;
                }
                .derivatives-info-list {
                    font-size: 1em;
                    color: #232946;
                    margin: 0 0 0 1.2em;
                    padding: 0;
                    list-style: disc inside;
                }
                .derivatives-info-list li {
                    margin-bottom: 0.7em;
                    line-height: 1.6;
                }
                @media (max-width: 700px) {
                    .derivatives-info-block {
                        padding: 1.2em 0.7em;
                    }
                    .derivatives-info-title {
                        font-size: 1.18em;
                    }
                    .derivatives-info-paragraph, .derivatives-info-list {
                        font-size: 0.98em;
                    }
                }
                @media (max-width: 480px) {
                    .derivatives-info-block {
                        padding: 0.7em 0.2em;
                    }
                    .derivatives-info-title {
                        font-size: 1em;
                    }
                }
                </style>
                <!-- Derivatives Exchanges Reviews Block -->
                <div class="modern-reviews-section" style="margin-top:2.5em;">
                    <h2 class="modern-reviews-title">
                        <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:0.3em;"><circle cx="16" cy="16" r="16" fill="url(#reviewGradient)"/><path d="M10 22l2-2 4 4 8-8-2-2-6 6-2-2-2 2z" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><defs><linearGradient id="reviewGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ff99ac"/></linearGradient></defs></svg>
                        User Reviews
                    </h2>
                    <div id="reviews-list" class="reviews-list"></div>
                    <hr style="border: none; border-top: 1.5px solid #ff99ac33; margin: 2em 0 2em 0;">
                    <div class="modern-review-form-container">
                        <h3 class="modern-review-form-title">Add Your Review</h3>
                        <p style="text-align:center; color:#ff6a88; font-size:1.05em; margin-bottom:1.5em;">Share your experience with derivatives exchanges. Your feedback helps others make informed decisions!</p>
                        <form id="reviewForm" method="POST" action="{{ url('/coingecko/derivatives_exchanges/reviews') }}" autocomplete="off" aria-label="Add your review">
                            @csrf
                            <input type="hidden" name="exchange_code" value="all">
                            <div class="modern-form-group">
                                <label for="name">
                                    <svg viewBox="0 0 24 24" fill="none" width="18" height="18"><circle cx="12" cy="8" r="4" fill="#ff6a88"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="#ff99ac" stroke-width="2"/></svg>
                                    Name <span style="color:#ff6a88;">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" name="name" required maxlength="255" placeholder="Your name" aria-required="true">
                            </div>
                            <div class="modern-form-group">
                                <label for="email">
                                    <svg viewBox="0 0 24 24" fill="none" width="18" height="18"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ff99ac"/><path d="M2 6l10 7 10-7" stroke="#ff6a88" stroke-width="2"/></svg>
                                    Email <span style="color:#ff6a88;">*</span>
                                </label>
                                <input type="email" class="form-control" id="email" name="email" required maxlength="255" placeholder="you@email.com" aria-required="true">
                            </div>
                            <div class="modern-form-group">
                                <label for="rating">
                                    <svg viewBox="0 0 24 24" fill="none" width="18" height="18"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 6v6l4 2" stroke="#ff99ac" stroke-width="2"/></svg>
                                    Rating <span style="color:#ff6a88;">*</span>
                                </label>
                                <select class="form-control" id="rating" name="rating" required aria-required="true">
                                    <option value="">Select rating</option>
                                    <option value="5">★★★★★</option>
                                    <option value="4">★★★★☆</option>
                                    <option value="3">★★★☆☆</option>
                                    <option value="2">★★☆☆☆</option>
                                    <option value="1">★☆☆☆☆</option>
                                </select>
                            </div>
                            <div class="modern-form-group">
                                <label for="title">
                                    <svg viewBox="0 0 24 24" fill="none" width="18" height="18"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ff99ac"/><path d="M8 12h8M8 16h4" stroke="#ff6a88" stroke-width="2"/></svg>
                                    Review Title <span style="color:#ff6a88;">*</span>
                                </label>
                                <input type="text" class="form-control" id="title" name="title" required maxlength="255" placeholder="Short summary" aria-required="true">
                            </div>
                            <div class="modern-form-group">
                                <label for="comment">
                                    <svg viewBox="0 0 24 24" fill="none" width="18" height="18"><rect x="2" y="4" width="20" height="16" rx="4" fill="#43cea2"/><path d="M6 8h12M6 12h8" stroke="#fff" stroke-width="2"/></svg>
                                    Your Review <span style="color:#ff6a88;">*</span>
                                </label>
                                <textarea class="form-control" id="comment" name="comment" required maxlength="2000" rows="4" placeholder="Share your experience..." aria-required="true"></textarea>
                            </div>
                            <div class="modern-form-group">
                                <label for="country">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff99ac"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" stroke="#fff" stroke-width="1.5" fill="none"/><path d="M12 6v6l4 2" stroke="#fff" stroke-width="2"/></svg>
                                    Country
                                </label>
                                <input type="text" class="form-control" id="country" name="country" maxlength="100" placeholder="Your country (optional)">
                            </div>
                            <div class="modern-form-group">
                                <label for="experience_level">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ff99ac"/><path d="M8 12h8M8 16h4" stroke="#ff6a88" stroke-width="2"/></svg>
                                    Experience Level
                                </label>
                                <select class="form-control" id="experience_level" name="experience_level">
                                    <option value="">Select level</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Professional">Professional</option>
                                </select>
                            </div>
                            <div class="modern-form-group">
                                <label for="pros">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#43cea2"/><path d="M8 12l2 2 4-4" stroke="#fff" stroke-width="2"/></svg>
                                    Pros
                                </label>
                                <input type="text" class="form-control" id="pros" name="pros" maxlength="1000" placeholder="What did you like? (optional)">
                            </div>
                            <div class="modern-form-group">
                                <label for="cons">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff6a88"/><path d="M16 10l-4 4-2-2" stroke="#fff" stroke-width="2"/></svg>
                                    Cons
                                </label>
                                <input type="text" class="form-control" id="cons" name="cons" maxlength="1000" placeholder="What could be improved? (optional)">
                            </div>
                            <div class="modern-form-group">
                                <label for="recommend">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M8 12l2 2 4-4" stroke="#43cea2" stroke-width="2"/></svg>
                                    Would you recommend?
                                </label>
                                <select class="form-control" id="recommend" name="recommend">
                                    <option value="">Select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <button type="submit" class="modern-action-btn" style="margin-top:1.2em; background: linear-gradient(90deg, #ff6a88 0%, #43cea2 100%); color: #fff; font-weight: 600; font-size: 1.1em; border: none; border-radius: 1em; box-shadow: 0 2px 8px rgba(255,106,136,0.12);">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="vertical-align:middle;margin-right:0.3em;"><circle cx="12" cy="12" r="10" fill="#43cea2"/><path d="M8 12l2 2 4-4" stroke="#fff" stroke-width="2"/></svg>
                                Submit Review
                            </button>
                        </form>
                    </div>
                </div>
                <style>
                .modern-reviews-section {
                    margin-top: 2.5em;
                    margin-bottom: 2.5em;
                    background: linear-gradient(120deg, #ff6a88 0%, #ff99ac 100%);
                    border-radius: 2em;
                    box-shadow: 0 4px 32px rgba(255, 106, 136, 0.10), 0 1.5px 6px rgba(255, 153, 172, 0.08);
                    padding: 2.5em 1.5em;
                    max-width: 900px;
                    margin-left: auto;
                    margin-right: auto;
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
                .modern-review-form-container {
                    background: #fff;
                    border-radius: 1.2em;
                    box-shadow: 0 2px 12px rgba(80,80,200,0.06);
                    padding: 2em 1.5em;
                    margin-top: 2em;
                }
                .modern-review-form-title {
                    font-size: 1.3em;
                    font-weight: 700;
                    color: #ff6a88;
                    margin-bottom: 0.5em;
                    text-align: center;
                }
                .modern-form-group {
                    margin-bottom: 1.2em;
                }
                .modern-form-group label {
                    font-weight: 600;
                    color: #232946;
                    display: flex;
                    align-items: center;
                    gap: 0.5em;
                    margin-bottom: 0.3em;
                }
                .modern-form-group input,
                .modern-form-group select,
                .modern-form-group textarea {
                    width: 100%;
                    padding: 0.7em 1em;
                    border-radius: 0.7em;
                    border: 1.5px solid #ff99ac;
                    font-size: 1em;
                    font-family: inherit;
                    background: #f8fafc;
                    color: #232946;
                    transition: border 0.2s;
                }
                .modern-form-group input:focus,
                .modern-form-group select:focus,
                .modern-form-group textarea:focus {
                    border-color: #43cea2;
                    outline: none;
                }
                .modern-action-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5em;
                    background: linear-gradient(90deg, #ff6a88 0%, #43cea2 100%);
                    color: #fff;
                    font-weight: 600;
                    font-size: 1.1em;
                    border: none;
                    border-radius: 1em;
                    box-shadow: 0 2px 8px rgba(255,106,136,0.12);
                    padding: 0.8em 2em;
                    cursor: pointer;
                    transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
                }
                .modern-action-btn:hover {
                    background: linear-gradient(90deg, #43cea2 0%, #ff6a88 100%);
                    color: #fff;
                    transform: scale(1.04);
                }
                .reviews-list {
                    margin-bottom: 2em;
                }
                .modern-review-card {
                    background: #fff;
                    border-radius: 1.2em;
                    box-shadow: 0 2px 12px rgba(80,80,200,0.06);
                    padding: 1.5em 1.2em;
                    margin-bottom: 1.5em;
                    display: flex;
                    gap: 1.2em;
                    align-items: flex-start;
                }
                .modern-review-avatar {
                    width: 48px;
                    height: 48px;
                    border-radius: 50%;
                    background: linear-gradient(135deg, #ff6a88 0%, #43cea2 100%);
                    color: #fff;
                    font-size: 1.7em;
                    font-weight: 700;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 2px 8px rgba(255,106,136,0.10);
                }
                .modern-review-content {
                    flex: 1;
                }
                .modern-review-header {
                    display: flex;
                    align-items: center;
                    gap: 1em;
                    margin-bottom: 0.3em;
                }
                .modern-review-name {
                    font-weight: 700;
                    color: #ff6a88;
                    font-size: 1.1em;
                }
                .modern-review-date {
                    color: #bbb;
                    font-size: 0.98em;
                    display: flex;
                    align-items: center;
                    gap: 0.2em;
                }
                .modern-review-rating {
                    color: #ffd200;
                    font-size: 1.1em;
                    font-weight: 700;
                }
                .modern-review-title {
                    font-weight: 600;
                    color: #232946;
                    margin-bottom: 0.2em;
                }
                .modern-review-comment {
                    color: #232946;
                    margin-bottom: 0.5em;
                    font-size: 1.05em;
                }
                .modern-review-meta {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 1em;
                    font-size: 0.98em;
                    color: #6366f1;
                }
                .modern-review-pros {
                    color: #43cea2;
                }
                .modern-review-cons {
                    color: #ff6a88;
                }
                .modern-review-recommend {
                    color: #ffd200;
                    font-weight: 600;
                }
                @media (max-width: 700px) {
                    .modern-reviews-section {
                        padding: 1.2em 0.7em;
                    }
                    .modern-reviews-title {
                        font-size: 1.3em;
                    }
                    .modern-review-form-container {
                        padding: 1.2em 0.7em;
                    }
                    .modern-review-card {
                        flex-direction: column;
                        gap: 0.7em;
                        padding: 1em 0.7em;
                    }
                    .modern-review-avatar {
                        width: 38px;
                        height: 38px;
                        font-size: 1.2em;
                    }
                }
                @media (max-width: 480px) {
                    .modern-reviews-section {
                        padding: 0.7em 0.2em;
                    }
                    .modern-reviews-title {
                        font-size: 1em;
                    }
                }
                </style>
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
                    fetch('/coingecko/derivatives_exchanges/reviews?exchange_code=all')
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
                            form.reset();
                            fetchReviews();
                            alert('Thank you for your review!');
                        } else {
                            alert('There was an error submitting your review. Please try again.');
                        }
                    })
                    .catch(() => alert('There was an error submitting your review. Please try again.'));
                });
                </script>
            </div>
        {{--</div>--}}
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
    <script src="{{ url('js/coingecko/derivatives_exchanges.js') }}"></script>
    <script>
        // Modern Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');
        const darkModeLabel = document.getElementById('darkModeLabel');
        function setDarkMode(enabled) {
            if (enabled) {
                document.body.classList.add('dark-mode');
                darkModeIcon.innerHTML = `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" stroke="#232946" stroke-width="2" stroke-linecap="round"/></svg>`;
                darkModeLabel.textContent = 'Light Mode';
            } else {
                document.body.classList.remove('dark-mode');
                darkModeIcon.innerHTML = `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" fill="#232946"/><path d="M15.5 12A3.5 3.5 0 0 1 12 15.5 3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5c.2 0 .4.01.59.04A5.5 5.5 0 1 0 18 17.41c.03-.19.04-.39.04-.59A5.5 5.5 0 0 0 15.5 12Z" fill="#ffd200"/></svg>`;
                darkModeLabel.textContent = 'Dark Mode';
            }
        }
        // On load, set mode from localStorage or system preference
        (function() {
            let dark = localStorage.getItem('darkMode');
            if (dark === null) {
                dark = window.matchMedia('(prefers-color-scheme: dark)').matches ? '1' : '0';
            }
            setDarkMode(dark === '1');
        })();
        darkModeToggle.addEventListener('click', function() {
            const isDark = document.body.classList.toggle('dark-mode');
            setDarkMode(isDark);
            localStorage.setItem('darkMode', isDark ? '1' : '0');
        });
    </script>
    <script>
        // Robust custom tooltip logic for description column
        $(document).off('.descTooltip');
        $(document).on('mouseenter.descTooltip', '.desc-tooltip', function(e) {
            const text = $(this).attr('data-tooltip');
            if (!text) return;
            $('.custom-tooltip-box').remove();
            const tooltip = $('<div class="custom-tooltip-box"></div>').text(text).appendTo('body');
            tooltip.css({
                display: 'block',
                top: e.clientY + 12,
                left: e.clientX + 12
            });
        });
        $(document).on('mousemove.descTooltip', '.desc-tooltip', function(e) {
            $('.custom-tooltip-box').css({
                top: e.clientY + 12,
                left: e.clientX + 12
            });
        });
        $(document).on('mouseleave.descTooltip', '.desc-tooltip', function() {
            $('.custom-tooltip-box').remove();
        });
    </script>
@endsection