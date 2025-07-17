@extends('layouts.base')
@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link href="{{ asset('css/nfts.css') }}" rel="stylesheet">
    <style>
        .nfts-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 1.2em;
        }
        .nfts-toolbar-btn {
            display: flex;
            align-items: center;
            gap: 0.5em;
            background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
            color: #fff;
            border: none;
            border-radius: 0.7em;
            padding: 0.55em 1.2em;
            font-size: 1.05em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(255,106,136,0.08);
            transition: background 0.2s, box-shadow 0.2s, color 0.2s, transform 0.15s;
        }
        /* Modern and user-friendly Dark Mode button */
        #nftsDarkModeBtn {
            background: linear-gradient(90deg, #232526 0%, #414345 100%);
            color: #ffe6f0;
            box-shadow: 0 2px 12px rgba(34, 185, 255, 0.10), 0 1.5px 6px rgba(255, 106, 136, 0.08);
            border: 1.5px solid #232526;
            position: relative;
            overflow: hidden;
        }
        #nftsDarkModeBtn:hover, #nftsDarkModeBtn:focus {
            background: linear-gradient(90deg, #414345 0%, #232526 100%);
            color: #fff;
            box-shadow: 0 4px 24px 0 rgba(34, 185, 255, 0.18), 0 2px 8px rgba(255, 106, 136, 0.10);
            outline: none;
            transform: scale(1.045);
        }
        #nftsDarkModeBtn:active {
            transform: scale(0.98);
        }
        #nftsDarkModeBtn svg {
            filter: drop-shadow(0 0 4px #22b9ff33);
        }
        .nfts-toolbar-btn svg {
            width: 1.2em;
            height: 1.2em;
        }
        @media (max-width: 600px) {
            .nfts-toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 0.7em;
            }
            .nfts-toolbar-btn {
                width: 100%;
                justify-content: center;
            }
        }
        body.nfts-dark-mode, .nfts-dark-mode .m-content {
            background: #181a1b !important;
            color: #f3f3f3 !important;
        }
        .nfts-dark-mode .nfts-table, .nfts-dark-mode .dataTables_wrapper {
            background: #23272b !important;
            color: #f3f3f3 !important;
        }
        .nfts-dark-mode .nfts-table th, .nfts-dark-mode .nfts-table td {
            background: #23272b !important;
            color: #f3f3f3 !important;
        }
        .nfts-dark-mode .nfts-toolbar-btn {
            background: linear-gradient(90deg, #23272b 0%, #181a1b 100%);
            color: #ff6a88;
        }
        .nfts-dark-mode .nfts-toolbar-btn:hover, .nfts-dark-mode .nfts-toolbar-btn:focus {
            background: linear-gradient(90deg, #181a1b 0%, #23272b 100%);
            color: #ff99ac;
        }
        .nfts-dark-mode #nftsDarkModeBtn {
            background: linear-gradient(90deg, #181a1b 0%, #23272b 100%);
            color: #ffb6e6;
            border-color: #23272b;
        }
        .nfts-dark-mode #nftsDarkModeBtn:hover, .nfts-dark-mode #nftsDarkModeBtn:focus {
            background: linear-gradient(90deg, #23272b 0%, #181a1b 100%);
            color: #fff;
            box-shadow: 0 4px 24px 0 rgba(34, 185, 255, 0.18), 0 2px 8px rgba(255, 106, 136, 0.10);
        }
        .nfts-toggle-btn {
            background: none !important;
            box-shadow: none !important;
            border: none !important;
            padding: 0.2em 0.5em !important;
            min-width: 60px;
        }
        .toggle-switch {
            display: inline-block;
            vertical-align: middle;
        }
        .toggle-track {
            display: flex;
            align-items: center;
            background: linear-gradient(90deg, #232526 0%, #414345 100%);
            border-radius: 1.5em;
            width: 60px;
            height: 36px;
            position: relative;
            transition: background 0.3s;
            box-shadow: 0 2px 12px rgba(34,185,255,0.10);
            cursor: pointer;
            outline: none;
            justify-content: space-between;
            padding: 0 6px;
        }
        .toggle-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s, transform 0.3s, filter 0.3s;
            pointer-events: none;
            position: relative;
            z-index: 2;
        }
        .toggle-sun {
            opacity: 1;
            filter: drop-shadow(0 0 4px #FFD60055);
            transform: scale(1.08);
        }
        .toggle-moon {
            opacity: 0.45;
            filter: none;
            transform: scale(0.95);
        }
        .toggle-thumb {
            position: absolute;
            left: 6px;
            top: 7px;
            width: 22px;
            height: 22px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(34,185,255,0.10);
            transition: left 0.3s, background 0.3s;
            z-index: 1;
        }
        .nfts-dark-mode .toggle-track {
            background: linear-gradient(90deg, #181a1b 0%, #23272b 100%);
        }
        .nfts-dark-mode .toggle-sun {
            opacity: 0.45;
            filter: none;
            transform: scale(0.95);
        }
        .nfts-dark-mode .toggle-moon {
            opacity: 1;
            filter: drop-shadow(0 0 4px #FFD60055);
            transform: scale(1.08);
        }
        .nfts-dark-mode .toggle-thumb {
            left: 32px;
            background: #23272b;
        }
        .nfts-dark-mode .toggle-label {
            color: #ffb6e6;
        }
        .toggle-label {
            margin-left: 0.7em;
            font-weight: 600;
            color: #ffe6f0;
            transition: color 0.3s;
        }
        .beautiful-modern-title-bar {
            background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
            border-radius: 1.5em;
            box-shadow: 0 4px 32px rgba(255, 106, 136, 0.10), 0 1.5px 6px rgba(255, 153, 172, 0.08);
            padding: 1.5em 2em 1.2em 2em;
            margin-bottom: 1.2em;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-height: 70px;
            position: relative;
            z-index: 1;
        }
        .beautiful-modern-title-bar .modern-title-main {
            display: flex;
            align-items: center;
            gap: 1.2em;
        }
        .beautiful-modern-title-bar .modern-title-icon {
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(255, 106, 136, 0.10);
            padding: 0.4em;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .beautiful-modern-title-bar .modern-title-text {
            font-size: 2.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 2px 8px rgba(255, 106, 136, 0.10);
        }
        @media (max-width: 900px) {
            .beautiful-modern-title-bar {
                padding: 1.2em 1em 1em 1em;
            }
            .beautiful-modern-title-bar .modern-title-text {
                font-size: 1.5rem;
            }
        }
        @media (max-width: 600px) {
            .beautiful-modern-title-bar {
                padding: 1em 0.5em 0.8em 0.5em;
                min-height: 50px;
            }
            .beautiful-modern-title-bar .modern-title-main {
                gap: 0.7em;
            }
            .beautiful-modern-title-bar .modern-title-text {
                font-size: 1.1rem;
            }
        }
        .modern-title-bar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.2em;
        }
        @media (max-width: 700px) {
            .modern-title-bar-row {
                flex-direction: column;
                align-items: stretch;
                gap: 0.7em;
            }
            .nfts-toolbar {
                width: 100%;
                justify-content: flex-start;
            }
        }
        .modern-title-bar.beautiful-modern-title-bar {
            background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
            border-radius: 1.5em;
            box-shadow: 0 4px 32px rgba(255, 106, 136, 0.10), 0 1.5px 6px rgba(255, 153, 172, 0.08);
            padding: 1.5em 2em 1.2em 2em;
            margin-bottom: 1.2em;
            display: flex;
            align-items: center;
            min-height: 70px;
            position: relative;
            z-index: 1;
            transition: background 0.3s;
        }
        .modern-title-bar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.2em;
            width: 100%;
        }
        .modern-title-main {
            display: flex;
            align-items: center;
            gap: 1em;
            min-width: 0;
        }
        .modern-title-icon {
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(255, 106, 136, 0.10);
            padding: 0.4em;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            min-height: 40px;
        }
        .modern-title-text {
            font-size: 2.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 2px 8px rgba(255, 106, 136, 0.10);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .nfts-toolbar {
            display: flex;
            align-items: center;
            gap: 0.7em;
            flex-wrap: wrap;
            margin-left: auto;
        }
        .nfts-toolbar-btn {
            transition: background 0.2s, box-shadow 0.2s, color 0.2s, transform 0.15s;
        }
        .nfts-toolbar-btn:hover, .nfts-toolbar-btn:focus {
            background: linear-gradient(90deg, #ff99ac 0%, #ff6a88 100%) !important;
            color: #fff;
            box-shadow: 0 4px 16px rgba(255,106,136,0.15);
            outline: none;
            transform: scale(1.045);
        }
        @media (max-width: 900px) {
            .modern-title-bar.beautiful-modern-title-bar {
                padding: 1.2em 1em 1em 1em;
            }
            .modern-title-text {
                font-size: 1.5rem;
            }
        }
        @media (max-width: 700px) {
            .modern-title-bar-row {
                flex-direction: column;
                align-items: stretch;
                gap: 0.7em;
            }
            .nfts-toolbar {
                width: 100%;
                justify-content: flex-start;
            }
            .modern-title-main {
                margin-bottom: 0.5em;
            }
        }
        @media (max-width: 600px) {
            .modern-title-bar.beautiful-modern-title-bar {
                padding: 1em 0.5em 0.8em 0.5em;
                min-height: 50px;
            }
            .modern-title-main {
                gap: 0.7em;
            }
            .modern-title-text {
                font-size: 1.1rem;
            }
        }
        .dt-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.7em;
            margin-bottom: 1em;
        }
        .dt-button {
            background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 0.7em !important;
            padding: 0.55em 1.2em !important;
            font-size: 1.05em !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            box-shadow: 0 2px 8px rgba(255,106,136,0.08) !important;
            transition: background 0.2s, box-shadow 0.2s, color 0.2s, transform 0.15s;
        }
        .dt-button:hover, .dt-button:focus {
            background: linear-gradient(90deg, #ff99ac 0%, #ff6a88 100%) !important;
            color: #fff !important;
            box-shadow: 0 4px 16px rgba(255,106,136,0.15) !important;
            outline: none !important;
            transform: scale(1.045);
        }
        @media (max-width: 600px) {
            .dt-buttons {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5em;
            }
            .dt-button {
                width: 100%;
                justify-content: center;
            }
        }
        @media (max-width: 700px) {
            #coingecko_nfts td[data-label]:before {
                content: attr(data-label) ": ";
                font-weight: 700;
                color: #ff6a88;
                display: block;
                margin-bottom: 0.2em;
            }
            #coingecko_nfts td[data-label] {
                display: block;
                width: 100%;
                box-sizing: border-box;
                padding-left: 0.5em;
                padding-right: 0.5em;
                border-bottom: 1px solid #f3f3f3;
                background: #fff9fa;
            }
            #coingecko_nfts tr {
                display: block;
                margin-bottom: 1em;
                border-radius: 1em;
                box-shadow: 0 2px 8px rgba(255,106,136,0.06);
                background: #fff;
            }
            #coingecko_nfts thead {
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <div class="m-content">
        <div class="modern-title-bar beautiful-modern-title-bar" aria-labelledby="nftsTitle" role="banner">
            <div class="modern-title-bar-row" role="group" aria-label="NFTs header section">
                <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
                    <span class="modern-title-icon" tabindex="0" title="NFTs Overview" aria-label="NFTs Overview">
                        <!-- NFTs Icon SVG (Pink Gradient) -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="nftsGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff6a88"/>
                                    <stop offset="1" stop-color="#ff99ac"/>
                                </linearGradient>
                            </defs>
                            <circle cx="16" cy="16" r="16" fill="url(#nftsGradient)"/>
                            <text x="16" y="21" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">NFT</text>
                        </svg>
                    </span>
                    <span class="modern-title-text" id="nftsTitle">NFTs</span>
                </div>
                <div class="nfts-toolbar" id="nftsToolbar" role="toolbar" aria-label="NFTs actions toolbar">
                    <button class="nfts-toolbar-btn nfts-toggle-btn" id="nftsDarkModeBtn" title="Toggle Dark/Light Mode" type="button" aria-label="Toggle Dark/Light Mode">
                        <span class="toggle-switch" id="nftsDarkModeSwitch">
                            <span class="toggle-track" tabindex="0">
                                <span class="toggle-icon toggle-sun" aria-hidden="true">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><circle cx="14" cy="14" r="7" fill="#FFD600"/><g stroke="#FFD600" stroke-width="2"><line x1="14" y1="2" x2="14" y2="6"/><line x1="14" y1="22" x2="14" y2="26"/><line x1="2" y1="14" x2="6" y2="14"/><line x1="22" y1="14" x2="26" y2="14"/><line x1="5.22" y1="5.22" x2="8.34" y2="8.34"/><line x1="19.66" y1="19.66" x2="22.78" y2="22.78"/><line x1="5.22" y1="22.78" x2="8.34" y2="19.66"/><line x1="19.66" y1="8.34" x2="22.78" y2="5.22"/></g></svg>
                                </span>
                                <span class="toggle-icon toggle-moon" aria-hidden="true">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><path d="M26 15.59A11 11 0 1113.41 2A9 9 0 0026 15.59Z" fill="#FFD600" stroke="#FFD600" stroke-width="2"/></svg>
                                </span>
                                <span class="toggle-thumb"></span>
                            </span>
                        </span>
                        <span class="toggle-labels">
                            <span class="toggle-label toggle-label-light">Light</span>
                            <span class="toggle-label toggle-label-dark">Dark</span>
                        </span>
                    </button>
                    <div class="nfts-toolbar" id="nftsToolbar" role="toolbar" aria-label="NFTs actions toolbar">
                        <button class="nfts-toolbar-btn" id="nftsFullscreenBtn" title="Full Screen Table" type="button" aria-label="Full Screen Table">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8 3H5a2 2 0 00-2 2v3m0 8v3a2 2 0 002 2h3m8-16h3a2 2 0 012 2v3m0 8v3a2 2 0 01-2 2h-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span class="d-none d-sm-inline">Full Screen</span>
                        </button>
                        <button class="nfts-toolbar-btn" id="nftsRefreshBtn" title="Refresh Table" type="button" aria-label="Refresh Table">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 4v5h.582M20 20v-5h-.581M5.5 19A9 9 0 1021 12.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span class="d-none d-sm-inline">Refresh</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navigation Tabs -->
        <div class="modern-tabs-container gradient-tabs-bg">
            <nav class="modern-tabs beautiful-tabs" aria-label="Main navigation">
                <a href="/coingeckomarketsindex" class="modern-tab beautiful-tab" tabindex="0">
                    <span class="tab-icon">
                        <!-- Markets Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff6a88"></circle><path d="M12 7v5l4 2" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </span>
                    <span class="tab-label">Markets</span>
                </a>
                <a href="/coingeckoexchangesindex" class="modern-tab beautiful-tab" tabindex="0">
                    <span class="tab-icon">
                        <!-- Exchange Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"></rect><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"></path></svg>
                    </span>
                    <span class="tab-label">Exchanges</span>
                </a>
                <a href="/coingeckotrendingsindex" class="modern-tab beautiful-tab" tabindex="0">
                    <span class="tab-icon">
                        <!-- Trendings Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"></rect><path d="M8 16l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round"></path></svg>
                    </span>
                    <span class="tab-label">Trendings</span>
                </a>
                <a href="/coingeckoexchangeratesindex" class="modern-tab beautiful-tab" tabindex="0">
                    <span class="tab-icon">
                        <!-- Exchange Rates Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"></rect><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>
                    </span>
                    <span class="tab-label">Exchange Rates</span>
                </a>
                <a href="/coingeckonftsindex" class="modern-tab beautiful-tab active" tabindex="0">
                    <span class="tab-icon">
                        <!-- NFTs Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"></rect><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">NFT</text></svg>
                    </span>
                    <span class="tab-label">NFTs</span>
                </a>
                <a href="/coingeckoderivativesindex" class="modern-tab beautiful-tab" tabindex="0">
                    <span class="tab-icon">
                        <!-- Derivatives Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"></rect><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"></path></svg>
                    </span>
                    <span class="tab-label">Derivatives</span>
                </a>
                <a href="/coingeckoderivativesexchangesindex" class="modern-tab beautiful-tab" tabindex="0">
                    <span class="tab-icon">
                        <!-- Derivatives Exchanges Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"></rect><path d="M8 16l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round"></path></svg>
                    </span>
                    <span class="tab-label">Derivatives Exchanges</span>
                </a>
            </nav>
        </div>
        <!-- DataTable Section -->
        <div class="nfts-table-responsive">
            <input type="hidden" id="coingecko_nfts_route" value="{{ route('datatable.coingecko.nfts') }}">
            <!-- Enhanced Table -->
            <div class="table-wrapper" id="nftsTableWrapper">
                <table id="coingecko_nfts" class="nfts-table table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                    <thead>
                        <tr>
                            <th class="datatable-highlight-first enhanced-th">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Name</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <!-- NFT Icon SVG (Pink Gradient) -->
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="nftNameGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ff6a88"/>
                                                <stop offset="1" stop-color="#ff99ac"/>
                                            </linearGradient>
                                        </defs>
                                        <rect x="2" y="2" width="20" height="20" rx="6" fill="url(#nftNameGradient)"/>
                                        <text x="12" y="16" text-anchor="middle" font-size="10" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">NFT</text>
                                    </svg>
                                </span>
                            </th>
                            <th>
                                <span class="datatable-header-text">Asset Platform ID</span>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS and dependencies -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <!-- Your custom DataTable initialization -->
    <script src="{{ url('js/coingecko/nfts.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('nftsDarkModeBtn');
            var track = document.querySelector('.toggle-track');
            function setMode(isDark) {
                if(isDark) {
                    document.body.classList.add('nfts-dark-mode');
                } else {
                    document.body.classList.remove('nfts-dark-mode');
                }
            }
            function getMode() {
                return document.body.classList.contains('nfts-dark-mode');
            }
            btn.addEventListener('click', function() {
                var isDark = !getMode();
                setMode(isDark);
            });
            track.addEventListener('keydown', function(e) {
                if (e.key === ' ' || e.key === 'Enter') {
                    e.preventDefault();
                    btn.click();
                }
            });
            // Set initial state
            setMode(getMode());
        });
        // Refresh Table
        document.getElementById('nftsRefreshBtn').addEventListener('click', function() {
            if(window.nftsTable && typeof window.nftsTable.ajax === 'object') {
                window.nftsTable.ajax.reload();
            } else if ($ && $.fn.DataTable && $('#coingecko_nfts').length) {
                $('#coingecko_nfts').DataTable().ajax.reload();
            }
        });
        // Full Screen
        document.getElementById('nftsFullscreenBtn').addEventListener('click', function() {
            var elem = document.getElementById('nftsTableWrapper');
            if (!document.fullscreenElement) {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.mozRequestFullScreen) { /* Firefox */
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) { /* IE/Edge */
                    elem.msRequestFullscreen();
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        });
    </script>
@endsection