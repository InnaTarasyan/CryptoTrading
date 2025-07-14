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
        <div class="m-portlet enhanced-portlet modern-portlet" style="
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(240,248,255,0.8) 100%);
            border-radius: 1.5em;
            box-shadow: 0 8px 32px rgba(80,80,200,0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(99,102,241,0.1);
            margin: 2em 0;
            overflow: hidden;
            position: relative;
        ">
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

            <div class="m-portlet__body mt-5 enhanced-portlet-body modern-portlet-body" style="
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
                    <div class="table-status-bar modern-status-bar" id="tableStatusBar" style="
                        background: linear-gradient(90deg, rgba(99,102,241,0.1) 0%, rgba(96,165,250,0.1) 100%);
                        border-radius: 1em;
                        padding: 1em 1.5em;
                        margin-bottom: 1.5em;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        border: 1px solid rgba(99,102,241,0.1);
                    ">
                        <div class="status-info" style="display: flex; align-items: center; gap: 0.8em;">
                            <span class="status-icon" style="font-size: 1.2em;">📊</span>
                            <span class="status-text" style="color: #3730a3; font-weight: 600;">Ready to display derivatives exchanges data</span>
                        </div>
                        <div class="status-actions" style="display: flex; gap: 0.8em;">
                            <button class="status-action-btn modern-action-btn" id="exportData" title="Export Data" style="
                                background: linear-gradient(135deg, #ff6a88 0%, #ff99ac 100%);
                                border: none;
                                border-radius: 0.8em;
                                padding: 0.6em 1.2em;
                                color: white;
                                font-weight: 600;
                                display: flex;
                                align-items: center;
                                gap: 0.5em;
                                transition: all 0.2s;
                                box-shadow: 0 2px 8px rgba(255,106,136,0.2);
                            ">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="7,10 12,15 17,10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="12" y1="15" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Export
                            </button>
                            <button class="status-action-btn modern-action-btn" id="printTable" title="Print Table" style="
                                background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
                                border: none;
                                border-radius: 0.8em;
                                padding: 0.6em 1.2em;
                                color: white;
                                font-weight: 600;
                                display: flex;
                                align-items: center;
                                gap: 0.5em;
                                transition: all 0.2s;
                                box-shadow: 0 2px 8px rgba(67,206,162,0.2);
                            ">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <polyline points="6,9 6,2 18,2 18,9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="6" y="14" width="12" height="8" rx="1" fill="none" stroke="currentColor" stroke-width="2"/>
                                </svg>
                                Print
                            </button>
                        </div>
                    </div>

                    <!-- Enhanced Table -->
                    <div class="table-wrapper modern-table-wrapper" style="
                        background: rgba(255,255,255,0.7);
                        border-radius: 1em;
                        overflow: hidden;
                        box-shadow: 0 2px 12px rgba(80,80,200,0.06);
                        border: 1px solid rgba(99,102,241,0.05);
                    ">
                        <table id="coingecko_derivatives_exchanges" class="table table-hover table-condensed table-striped enhanced-table modern-table" style="width:100%; padding-top:1%">
                            <thead class="enhanced-thead modern-thead" style="
                                background: linear-gradient(135deg, rgba(99,102,241,0.1) 0%, rgba(96,165,250,0.1) 100%);
                                border-bottom: 2px solid rgba(99,102,241,0.2);
                            ">
                            <tr>
                                <th class="datatable-highlight-first enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Exchange</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
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
                                <th title="Official logo or icon of the exchange" class="enhanced-th">
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
                                <th title="Description of the exchange" class="enhanced-th">
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Description</span>
                                    <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
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
                                <th title="Open interest in Bitcoin" class="enhanced-th">
                                    <span class="datatable-header-icon">
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
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Open Interest BTC</span>
                                </th>
                                <th title="24-hour trading volume in Bitcoin" class="enhanced-th">
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
                                    <span class="datatable-header-text" style="display:block; text-align:center;">24h Volume BTC</span>
                                </th>
                                <th title="Number of perpetual trading pairs" class="enhanced-th">
                                    <span class="datatable-header-icon">
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
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Perpetual Pairs</span>
                                </th>
                                <th title="Number of futures trading pairs" class="enhanced-th">
                                    <span class="datatable-header-icon">
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
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Futures Pairs</span>
                                </th>
                                <th title="Year the exchange was established" class="enhanced-th">
                                    <span class="datatable-header-icon">
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
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Established</span>
                                </th>
                                <th title="Country where the exchange is based" class="enhanced-th">
                                    <span class="datatable-header-icon">
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
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Country</span>
                                </th>
                                <th title="Website URL of the exchange" class="enhanced-th">
                                    <span class="datatable-header-icon">
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
                                    <span class="datatable-header-text" style="display:block; text-align:center;">Website</span>
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
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
@endsection