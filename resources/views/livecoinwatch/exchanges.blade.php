@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/exchanges.css') }}" rel="stylesheet">
    <style>
        .modern-refresh-btn-upgraded {
            padding: 0.5em 1.2em 0.5em 0.8em;
            border: none;
            border-radius: 2.2em;
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
            font-weight: 700;
            font-size: 1.15em;
            box-shadow: 0 6px 24px 0 rgba(67, 206, 162, 0.18), 0 2px 8px 0 rgba(24, 90, 157, 0.13);
            display: flex;
            align-items: center;
            gap: 1em;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            cursor: pointer;
            outline: none;
        }
        .modern-refresh-btn-upgraded:hover, .modern-refresh-btn-upgraded:focus {
            background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
            box-shadow: 0 8px 32px 0 rgba(67, 206, 162, 0.25), 0 3px 12px 0 rgba(24, 90, 157, 0.18);
            transform: translateY(-2px) scale(1.04);
        }
        .modern-refresh-btn-upgraded:active {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            box-shadow: 0 2px 8px 0 rgba(67, 206, 162, 0.10);
            transform: scale(0.97);
        }
        .modern-refresh-btn-upgraded:focus-visible {
            outline: 3px solid #ffd200;
            outline-offset: 2px;
        }
        .icon-refresh-upgraded {
            width: 2.1em;
            height: 2.1em;
            stroke-width: 4.5;
            filter: drop-shadow(0 2px 4px rgba(24,90,157,0.18));
            transition: transform 0.3s cubic-bezier(.4,2,.6,1), stroke 0.2s;
        }
        .modern-refresh-btn-upgraded.spinning .icon-refresh-upgraded {
            animation: spin-refresh 0.7s linear;
        }
        @keyframes spin-refresh {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .refresh-btn-label {
            font-size: 1.13em;
            font-weight: 700;
            letter-spacing: 0.01em;
        }
        .refresh-icon-bg {
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.7em;
            height: 2.7em;
            box-shadow: 0 2px 8px 0 rgba(24, 90, 157, 0.10);
            margin-right: 0.5em;
        }
        .ripple-effect.show {
            transform: scale(4);
            opacity: 0;
            animation: ripple-animate 0.5s linear;
        }
        /* Modern Fullscreen Button Styles */
        .modern-fullscreen-btn {
            padding: 0.5em 1.1em 0.5em 0.7em;
            border: none;
            border-radius: 2.2em;
            background: linear-gradient(90deg, #0d6efd 0%, #43cea2 100%);
            color: #fff;
            font-weight: 700;
            font-size: 1.08em;
            box-shadow: 0 6px 24px 0 rgba(13, 110, 253, 0.13), 0 2px 8px 0 rgba(67, 206, 162, 0.10);
            display: flex;
            align-items: center;
            gap: 1em;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            cursor: pointer;
            outline: none;
            position: relative;
        }
        .modern-fullscreen-btn:hover, .modern-fullscreen-btn:focus {
            background: linear-gradient(90deg, #43cea2 0%, #0d6efd 100%);
            box-shadow: 0 8px 32px 0 rgba(13, 110, 253, 0.18), 0 3px 12px 0 rgba(67, 206, 162, 0.18);
            transform: translateY(-2px) scale(1.04);
        }
        .modern-fullscreen-btn:active {
            background: linear-gradient(90deg, #0d6efd 0%, #43cea2 100%);
            box-shadow: 0 2px 8px 0 rgba(13, 110, 253, 0.10);
            transform: scale(0.97);
        }
        .modern-fullscreen-btn:focus-visible {
            outline: 3px solid #ffd200;
            outline-offset: 2px;
        }
        .fullscreen-btn-label {
            font-size: 1.08em;
            font-weight: 700;
            letter-spacing: 0.01em;
        }
        .fullscreen-icon-bg {
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5em;
            height: 2.5em;
            box-shadow: 0 2px 8px 0 rgba(13, 110, 253, 0.10);
            margin-right: 0.5em;
            transition: background 0.2s;
        }
        .modern-fullscreen-btn[aria-pressed="true"] .fullscreen-icon-bg {
            background: #ff512f;
        }
        .icon-fullscreen, .icon-exit-fullscreen {
            width: 2em;
            height: 2em;
            transition: opacity 0.2s, transform 0.2s;
        }
        .icon-exit-fullscreen {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            pointer-events: none;
        }
        .modern-fullscreen-btn[aria-pressed="true"] .icon-fullscreen {
            opacity: 0;
            pointer-events: none;
        }
        .modern-fullscreen-btn[aria-pressed="true"] .icon-exit-fullscreen {
            opacity: 1;
            pointer-events: auto;
            position: static;
        }
        @media (max-width: 600px) {
            .modern-fullscreen-btn {
                font-size: 0.98em;
                padding: 0.4em 0.7em 0.4em 0.5em;
            }
            .fullscreen-btn-label {
                display: none;
            }
            .fullscreen-icon-bg {
                margin-right: 0;
            }
        }
    </style>
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