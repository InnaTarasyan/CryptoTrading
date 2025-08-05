@extends('layouts.base')

{{-- ======================== Page Title Section ======================== --}}
@section('title')
    Livecoin History - Crypto Trading
@endsection

{{-- ======================== Styles Section ======================== --}}
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/history.css') }}" rel="stylesheet">
@endsection

{{-- ======================== Content Section ======================== --}}
@section('content')
    <div class="m-content">
        {{-- Modern Title Bar with Icon and Dark Mode Button --}}
        <div class="modern-title-bar">
            <div class="m-portlet__head-title custom-modern">
                <span class="modern-title-icon">
                    {{-- History Icon SVG --}}
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="16" fill="url(#historyGradient)"/>
                        <path d="M16 8v8l6 3" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <defs>
                            <linearGradient id="historyGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#ffd200"/>
                                <stop offset="1" stop-color="#43cea2"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>
                <span class="modern-title-text" data-lang-key="livecoin_history">Livecoin History</span>
            </div>
            <button id="darkModeToggle" class="modern-tab darkmode-switch" title="Toggle dark mode" role="switch" aria-checked="false">
                <span class="darkmode-switch-icon" id="darkModeIcon">
                    {{-- Sun & Moon SVG for animation --}}
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
                <span id="darkModeText" class="darkmode-switch-label" data-lang-key="dark_mode">Dark Mode</span>
            </button>
        </div>

        {{-- ======================== Navigation Tabs ======================== --}}
        <div class="modern-tabs-container">
            <nav class="modern-tabs beautiful-tabs" aria-label="Main navigation">
                <a href="/" class="modern-tab beautiful-tab {{ request()->is('/') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        {{-- History Icon --}}
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 7v5l4 2" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <span class="tab-label" data-lang-key="livecoin_history">History</span>
                </a>
                <a href="/livecoinexchangesindex" class="modern-tab beautiful-tab {{ request()->is('livecoinexchangesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        {{-- Exchange Icon --}}
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#43cea2"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                    </span>
                    <span class="tab-label" data-lang-key="exchanges">Exchanges</span>
                </a>
                <a href="/livecoinfiatsindex" class="modern-tab beautiful-tab {{ request()->is('livecoinfiatsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        {{-- Fiat Icon --}}
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff512f"/><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>
                    </span>
                    <span class="tab-label" data-lang-key="fiats">Fiats</span>
                </a>
            </nav>
        </div>

        {{-- ======================== Action Buttons ======================== --}}
        <div class="action-buttons-row" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="action-buttons-left">
                <button id="refreshTable" class="modern-tab fullscreen-switch" title="Refresh Table" aria-label="Refresh Table">
                    <span class="fullscreen-switch-icon">
                        {{-- Refresh SVG --}}
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M17.65 6.35A8 8 0 1 0 19 12h-1.5" stroke="#0d6efd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="17 2 17 7 22 7" stroke="#0d6efd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                    </span>
                    <span data-lang-key="refresh">Refresh</span>
                </button>
            </div>
            <div class="action-buttons-right">
                <button id="fullscreenToggle" class="modern-tab fullscreen-switch" title="Toggle Fullscreen" aria-label="Toggle Fullscreen" aria-pressed="false" role="button">
                    <span class="fullscreen-switch-icon" id="fullscreenIcon">
                        {{-- Enter Fullscreen SVG --}}
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
                        {{-- Exit Fullscreen SVG (hidden by default) --}}
                        <svg class="icon-exit-fullscreen" width="24" height="24" viewBox="0 0 24 24" fill="none" style="display:none;">
                            <rect x="5" y="11" width="14" height="2" rx="1" fill="#ff512f"/>
                            <rect x="11" y="5" width="2" height="14" rx="1" fill="#ff512f"/>
                        </svg>
                    </span>
                    <span id="fullscreenText" class="fullscreen-switch-label" data-lang-key="fullscreen">Fullscreen</span>
                    </button>
                </div>
            </div>

        {{-- ======================== DataTable Section ======================== --}}
        <div class="m-portlet">
            <div class="m-portlet__body mt-5">
                <input type="hidden" id="livecoin_history_route" value="{{ route('datatable.livecoin.history') }}">
                <div id="datatableFullscreenContainer" class="table-responsive">
                    <div id="datatableLoading" class="datatable-loading" style="display:none; text-align:center; margin:2em;">
                        <div class="spinner-border text-warning" role="status" style="width:3rem;height:3rem;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <table id="livecoin_history" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                            {{-- Table Headers with SVG Icons --}}
                            <th title="The cryptocurrency name">
                                <span class="datatable-header-icon">
                                    {{-- Coin SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="14" fill="#43cea2"/>
                                        <circle cx="16" cy="16" r="10" fill="#fff"/>
                                        <circle cx="16" cy="16" r="7" fill="#43cea2"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="coin">Coin</span>
                            </th>
                            <th title="Coin logo">
                                <span class="datatable-header-icon">
                                    {{-- Logo SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="6" fill="#ff512f"/>
                                        <circle cx="16" cy="16" r="8" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="logo">Logo</span>
                            </th>
                            <th title="Current price in USD">
                                <span class="datatable-header-icon">
                                    {{-- Dollar SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/>
                                        <text x="16" y="21" text-anchor="middle" font-size="16" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="rate">Rate</span>
                            </th>
                            <th title="How old the coin is">
                                <span class="datatable-header-icon">
                                    {{-- Hourglass SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#a8edea"/>
                                        <path d="M10 8h12M10 24h12M12 8c0 6 8 6 8 0M12 24c0-6 8-6 8 0" stroke="#185a9d" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="age">Age</span>
                            </th>
                            <th title="Number of trading pairs">
                                <span class="datatable-header-icon">
                                    {{-- Pairs SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#f7971e"/>
                                        <path d="M12 16h8M16 12v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="pairs">Pairs</span>
                            </th>
                            <th title="24h trading volume">
                                <span class="datatable-header-icon">
                                    {{-- Exchange SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#43cea2"/>
                                        <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="volume_24h">Volume (24h)</span>
                            </th>
                            <th title="Market capitalization">
                                <span class="datatable-header-icon">
                                    {{-- Pie Chart SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="12" fill="#ff512f"/>
                                        <path d="M16 16V8A8 8 0 1 1 8 24" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="market_cap">Market Cap</span>
                            </th>
                            <th title="Rank among all coins">
                                <span class="datatable-header-icon">
                                    {{-- Trophy SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/>
                                        <path d="M12 20h8M16 20v4M10 8h12v4a6 6 0 0 1-12 0V8z" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="rank">Rank</span>
                            </th>
                            <th title="Number of markets">
                                <span class="datatable-header-icon">
                                    {{-- List SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#6a11cb"/>
                                        <rect x="10" y="10" width="12" height="2" fill="#fff"/>
                                        <rect x="10" y="15" width="12" height="2" fill="#fff"/>
                                        <rect x="10" y="20" width="12" height="2" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="markets">Markets</span>
                            </th>
                            <th title="Total supply of the coin">
                                <span class="datatable-header-icon">
                                    {{-- Database SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <ellipse cx="16" cy="10" rx="10" ry="4" fill="#11998e"/>
                                        <rect x="6" y="10" width="20" height="12" rx="6" fill="#fff"/>
                                        <ellipse cx="16" cy="22" rx="10" ry="4" fill="#11998e"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="total_supply">Total Supply</span>
                            </th>
                            <th title="Maximum supply possible">
                                <span class="datatable-header-icon">
                                    {{-- Cubes SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="6" fill="#f7971e"/>
                                        <rect x="10" y="10" width="4" height="4" fill="#fff"/>
                                        <rect x="18" y="10" width="4" height="4" fill="#fff"/>
                                        <rect x="10" y="18" width="4" height="4" fill="#fff"/>
                                        <rect x="18" y="18" width="4" height="4" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="max_supply">Max Supply</span>
                            </th>
                            <th title="Currently circulating supply">
                                <span class="datatable-header-icon">
                                    {{-- Circle SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="12" fill="#43cea2"/>
                                        <circle cx="16" cy="16" r="7" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="circulating_supply">Circulating Supply</span>
                            </th>
                            <th title="All-time high price">
                                <span class="datatable-header-icon">
                                    {{-- Line Chart SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ff512f"/>
                                        <polyline points="8,24 14,18 18,22 24,10" stroke="#fff" stroke-width="2" fill="none"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="all_time_high">All-Time High</span>
                            </th>
                            <th title="Coin categories">
                                <span class="datatable-header-icon">
                                    {{-- Tags SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="8" fill="#6a11cb"/>
                                        <rect x="10" y="10" width="12" height="4" rx="2" fill="#fff"/>
                                        <rect x="10" y="18" width="8" height="4" rx="2" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text" data-lang-key="categories">Categories</span>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        {{-- ======================== End DataTable Section ======================== --}}

        {{-- ======================== Comparison Charts Section ======================== --}}
        <div class="comparison-section" style="margin-top: 3em;">
            <div class="modern-title-bar">
                <div class="m-portlet__head-title custom-modern">
                    <span class="modern-title-icon">
                        {{-- Comparison Icon SVG --}}
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="16" fill="url(#comparisonGradient)"/>
                            <path d="M8 12h4l2-4 2 4h4M8 20h4l2-4 2 4h4" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <defs>
                                <linearGradient id="comparisonGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff512f"/>
                                    <stop offset="1" stop-color="#f7971e"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                    <span class="modern-title-text" data-lang-key="market_comparison">Market Comparison Analysis</span>
                </div>
                <button id="refreshComparison" class="modern-tab darkmode-switch" title="Refresh Comparison Data" aria-label="Refresh Comparison Data">
                    <span class="darkmode-switch-icon">
                        {{-- Refresh SVG --}}
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17.65 6.35A8 8 0 1 0 19 12h-1.5" stroke="#ff512f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="17 2 17 7 22 7" stroke="#ff512f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                    </span>
                    <span data-lang-key="refresh">Refresh</span>
                </button>
            </div>

            {{-- Loading Spinner --}}
            <div id="comparisonLoading" class="datatable-loading" style="display:none; text-align:center; margin:2em;">
                <div class="spinner-border text-warning" role="status" style="width:3rem;height:3rem;">
                    <span class="sr-only">Loading comparison data...</span>
                </div>
            </div>

            {{-- Charts Container --}}
            <div id="comparisonCharts" class="charts-container" style="display:none;">

                {{-- Coin Search Section --}}
                <div class="coin-search-section">
                    <div class="search-container">
                        <input type="text" id="coinSearchInput" placeholder="Search for a coin (e.g., bitcoin, ethereum)" class="coin-search-input">
                        <button id="searchCoinBtn" class="search-btn">Search</button>
                    </div>
                    <div id="coinAnalysisResult" class="coin-analysis-result" style="display:none;">
                        <!-- Coin analysis will be displayed here -->
                    </div>
                </div>

                {{-- Platform Overview Cards --}}
                <div class="platform-overview">
                    <div class="platform-card livecoinwatch">
                        <div class="platform-header">
                            <h3>LiveCoinWatch</h3>
                            <div class="platform-icon">📊</div>
                        </div>
                        <div class="platform-stats">
                            <div class="stat">
                                <span class="stat-label">Total Coins</span>
                                <span class="stat-value" id="lcw-total-coins">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Total Market Cap</span>
                                <span class="stat-value" id="lcw-total-mcap">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Total Volume</span>
                                <span class="stat-value" id="lcw-total-volume">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="platform-card coingecko">
                        <div class="platform-header">
                            <h3>CoinGecko</h3>
                            <div class="platform-icon">🦎</div>
                        </div>
                        <div class="platform-stats">
                            <div class="stat">
                                <span class="stat-label">Total Coins</span>
                                <span class="stat-value" id="cg-total-coins">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Total Markets</span>
                                <span class="stat-value" id="cg-total-markets">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Total Exchanges</span>
                                <span class="stat-value" id="cg-total-exchanges">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="platform-card coinmarketcal">
                        <div class="platform-header">
                            <h3>CoinMarketCal</h3>
                            <div class="platform-icon">📅</div>
                        </div>
                        <div class="platform-stats">
                            <div class="stat">
                                <span class="stat-label">Total Coins</span>
                                <span class="stat-value" id="cmc-total-coins">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Total Events</span>
                                <span class="stat-value" id="cmc-total-events">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Top 10 Ranked</span>
                                <span class="stat-value" id="cmc-top-10">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chart Grid --}}
                <div class="chart-grid">
                    {{-- Market Cap Distribution Chart --}}
                    <div class="chart-card">
                        <h4>Market Cap Distribution</h4>
                        <div class="chart-container" style="height: 300px; position: relative;">
                            <canvas id="marketCapChart"></canvas>
                        </div>
                    </div>

                    {{-- Price Movement Trends --}}
                    <div class="chart-card">
                        <h4>24h Price Movement Trends</h4>
                        <div class="chart-container" style="height: 300px; position: relative;">
                            <canvas id="priceTrendsChart"></canvas>
                        </div>
                    </div>

                    {{-- Volume Analysis --}}
                    <div class="chart-card">
                        <h4>Volume Distribution</h4>
                        <div class="chart-container" style="height: 300px; position: relative;">
                            <canvas id="volumeChart"></canvas>
                        </div>
                    </div>

                    {{-- Cross-Platform Comparison --}}
                    <div class="chart-card">
                        <h4>Platform Coverage</h4>
                        <div class="chart-container" style="height: 300px; position: relative;">
                            <canvas id="platformChart"></canvas>
                        </div>
                    </div>

                    {{-- Top Performers --}}
                    <div class="chart-card full-width">
                        <h4>Top 10 Coins by Market Cap</h4>
                        <div class="top-performers-table">
                            <table id="topPerformersTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Symbol</th>
                                        <th>Market Cap</th>
                                        <th>Price</th>
                                        <th>24h Change</th>
                                    </tr>
                                </thead>
                                <tbody id="topPerformersBody">
                                    <!-- Data will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Market Trends Summary --}}
                    <div class="chart-card full-width">
                        <h4>Market Trends Summary</h4>
                        <div class="trends-summary">
                            <div class="trend-item positive">
                                <span class="trend-icon">📈</span>
                                <span class="trend-label">Gaining</span>
                                <span class="trend-value" id="trends-gaining">-</span>
                            </div>
                            <div class="trend-item negative">
                                <span class="trend-icon">📉</span>
                                <span class="trend-label">Losing</span>
                                <span class="trend-value" id="trends-losing">-</span>
                            </div>
                            <div class="trend-item neutral">
                                <span class="trend-icon">➡️</span>
                                <span class="trend-label">Stable</span>
                                <span class="trend-value" id="trends-stable">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
        .comparison-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2em;
            padding: 2em;
            margin: 2em 0;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.15);
        }

        .coin-search-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1.5em;
            padding: 1.5em;
            margin-bottom: 2em;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            display: flex;
            gap: 1em;
            align-items: center;
            margin-bottom: 1em;
        }

        .coin-search-input {
            flex: 1;
            padding: 0.8em 1.2em;
            border: 2px solid #667eea;
            border-radius: 1em;
            font-size: 1.1em;
            background: #fff;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .coin-search-input:focus {
            outline: none;
            border-color: #764ba2;
        }

        .search-btn {
            padding: 0.8em 1.5em;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 1em;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .search-btn:hover {
            transform: translateY(-2px);
        }

        .coin-analysis-result {
            background: #f8f9fa;
            border-radius: 1em;
            padding: 1.5em;
            margin-top: 1em;
        }

        .coin-analysis-header {
            display: flex;
            align-items: center;
            gap: 1em;
            margin-bottom: 1em;
            padding-bottom: 1em;
            border-bottom: 2px solid #e9ecef;
        }

        .coin-analysis-header h3 {
            margin: 0;
            font-size: 1.5em;
            font-weight: 700;
            color: #333;
        }

        .coin-analysis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5em;
        }

        .coin-analysis-card {
            background: #fff;
            border-radius: 1em;
            padding: 1.5em;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .coin-analysis-card h4 {
            margin: 0 0 1em 0;
            font-size: 1.2em;
            font-weight: 700;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5em;
        }

        .coin-analysis-data {
            display: flex;
            flex-direction: column;
            gap: 0.8em;
        }

        .coin-analysis-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5em 0;
            border-bottom: 1px solid #eee;
        }

        .coin-analysis-item:last-child {
            border-bottom: none;
        }

        .coin-analysis-label {
            font-weight: 600;
            color: #666;
        }

        .coin-analysis-value {
            font-weight: 700;
            color: #333;
        }

        .coin-analysis-value.positive {
            color: #28a745;
        }

        .coin-analysis-value.negative {
            color: #dc3545;
        }

        .platform-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5em;
            margin-bottom: 2em;
        }

        .platform-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1.5em;
            padding: 1.5em;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .platform-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .platform-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1em;
        }

        .platform-header h3 {
            margin: 0;
            font-size: 1.3em;
            font-weight: 700;
            color: #333;
        }

        .platform-icon {
            font-size: 2em;
        }

        .platform-stats {
            display: flex;
            flex-direction: column;
            gap: 0.8em;
        }

        .stat {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5em 0;
            border-bottom: 1px solid #eee;
        }

        .stat:last-child {
            border-bottom: none;
        }

        .stat-label {
            font-weight: 600;
            color: #666;
        }

        .stat-value {
            font-weight: 700;
            color: #333;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2em;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1.5em;
            padding: 1.5em;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            min-height: 400px;
            display: flex;
            flex-direction: column;
        }

        .chart-card.full-width {
            grid-column: 1 / -1;
            min-height: auto;
        }

        .chart-card h4 {
            margin: 0 0 1em 0;
            font-size: 1.2em;
            font-weight: 700;
            color: #333;
            text-align: center;
            flex-shrink: 0;
        }

        .chart-container {
            width: 100%;
            height: 300px !important;
            position: relative;
            overflow: hidden;
            flex: 1;
            min-height: 300px;
        }

        .chart-container canvas {
            max-height: 100% !important;
            max-width: 100% !important;
            height: 100% !important;
        }

        .top-performers-table {
            overflow-x: auto;
        }

        .top-performers-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .top-performers-table th,
        .top-performers-table td {
            padding: 0.8em;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .top-performers-table th {
            background: #f8f9fa;
            font-weight: 700;
            color: #333;
        }

        .trends-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5em;
            margin-top: 1em;
        }

        .trend-item {
            display: flex;
            align-items: center;
            gap: 1em;
            padding: 1em;
            border-radius: 1em;
            background: #f8f9fa;
        }

        .trend-item.positive {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
        }

        .trend-item.negative {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 4px solid #dc3545;
        }

        .trend-item.neutral {
            background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%);
            border-left: 4px solid #6c757d;
        }

        .trend-icon {
            font-size: 1.5em;
        }

        .trend-label {
            font-weight: 600;
            color: #333;
        }

        .trend-value {
            font-weight: 700;
            font-size: 1.2em;
            color: #333;
        }

        @media (max-width: 768px) {
            .platform-overview {
                grid-template-columns: 1fr;
            }

            .chart-grid {
                grid-template-columns: 1fr;
            }

            .trends-summary {
                grid-template-columns: 1fr;
            }
        }

        /* Prevent chart height changes during scroll */
        .comparison-section {
            transform: translateZ(0);
            will-change: auto;
        }

        .chart-card {
            transform: translateZ(0);
            will-change: auto;
        }

        .chart-container {
            transform: translateZ(0);
            will-change: auto;
        }
        </style>

        {{-- ======================== Live Coin Watch Info Section ======================== --}}
        <style>
        .lcw-info-card {
            width: 100%;
            box-sizing: border-box;
            padding: 2.5em 2em;
            background: linear-gradient(90deg, #ffd200 0%, #43cea2 100%);
            border-radius: 2em;
            box-shadow: 0 6px 32px rgba(67, 206, 162, 0.13), 0 1.5px 6px rgba(67, 206, 162, 0.08);
            color: #222;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 2em;
            transition: box-shadow 0.2s, transform 0.2s;
            margin: 2em 0;
        }
        .lcw-info-card:hover {
            box-shadow: 0 12px 48px rgba(67, 206, 162, 0.18), 0 3px 12px rgba(67, 206, 162, 0.12);
            transform: translateY(-2px) scale(1.01);
        }
        .lcw-info-card .lcw-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.18);
            border-radius: 50%;
            padding: 1em;
            box-shadow: 0 2px 8px rgba(67, 206, 162, 0.10);
        }
        .lcw-info-card .lcw-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.2em;
        }
        .lcw-info-card h2 {
            margin: 0;
            font-size: 2.1rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: #222;
        }
        .lcw-info-card p {
            font-size: 1.15rem;
            line-height: 1.7;
            margin: 0;
            max-width: 900px;
            color: #222;
        }
        .lcw-info-card a {
            display: inline-block !important;
            width: auto !important;
            min-width: 0 !important;
            max-width: none !important;
            align-self: flex-start;
            background: #222;
            color: #ffd200;
            padding: 0.85em 1.2em;
            border-radius: 2em;
            font-weight: 700;
            text-decoration: none;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(34,34,34,0.08);
            transition: background 0.2s, color 0.2s;
            box-sizing: border-box;
        }
        .lcw-info-card a:hover {
            background: #ffd200;
            color: #222;
        }
        @media (max-width: 900px) {
            .lcw-info-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 2em 1em;
                gap: 1.2em;
            }
            .lcw-info-card .lcw-icon {
                margin-bottom: 0.5em;
            }
        }
        </style>
        <div class="lcw-info-card">
            <div class="lcw-icon">
                <svg width="64" height="64" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="16" cy="16" r="16" fill="url(#lcwGradient)"/>
                    <path d="M16 8v8l6 3" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="lcwGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#ffd200"/>
                            <stop offset="1" stop-color="#43cea2"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="lcw-content">
                <h2 data-lang-key="about_live_coin_watch">About Live Coin Watch</h2>
                <p>
                    <strong>Live Coin Watch</strong> is a real-time cryptocurrency market tracking platform, offering a clean and convenient interface for monitoring prices, market capitalizations, trading volumes, and rankings of hundreds of digital assets. Unlike many competitors, Live Coin Watch updates information in real time, making it ideal for users who want to see price changes as they happen.<br><br>
                    The platform allows users to view prices in various fiat and cryptocurrencies, track the total market capitalization, and explore detailed data for each coin and exchange. Live Coin Watch also offers portfolio tracking features for registered users, all within a modern, easy-to-navigate layout.<br><br>
                    As a community-driven project, Live Coin Watch operates on donations and aims to provide a transparent, user-friendly alternative to other crypto market aggregators.
                </p>
                <p>
                    <strong>Change History:</strong> The table above provides a comprehensive record of historical changes for various cryptocurrencies as tracked by Live Coin Watch. Each entry reflects updates in price, market capitalization, trading volume, and other key metrics over time. This change history enables users to analyze trends, monitor market movements, and make informed decisions based on past performance and data transparency. The regularly updated datatable ensures that users always have access to the latest and most accurate historical information available.
                </p>
                <a href="https://www.livecoinwatch.com" target="_blank" rel="noopener" data-lang-key="visit_live_coin_watch">Visit Live Coin Watch</a>
            </div>
        </div>
    </div>
    {{-- ======================== Reviews Section ======================== --}}
    <style>
    .modern-reviews-section {
        margin-top: 3em;
        margin-bottom: 3em;
        background: linear-gradient(120deg, #ffd200 0%, #43cea2 100%);
        border-radius: 2em;
        box-shadow: 0 4px 32px rgba(67, 206, 162, 0.10), 0 1.5px 6px rgba(67, 206, 162, 0.08);
        padding: 2.5em 1.5em;
        max-width: 100%;
    }
    .modern-reviews-title {
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 1.5em;
        color: #222;
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
        background: linear-gradient(100deg, #fffbe6 0%, #eafff7 100%);
        border-radius: 1.2em;
        margin-bottom: 1.5em;
        padding: 1.5em 1.7em;
        box-shadow: 0 2px 12px rgba(67,206,162,0.08);
        display: flex;
        gap: 1.2em;
        align-items: flex-start;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .modern-review-card:hover {
        box-shadow: 0 6px 24px rgba(67,206,162,0.13);
        transform: translateY(-2px) scale(1.01);
    }
    .modern-review-avatar {
        width: 3.2em;
        height: 3.2em;
            border-radius: 50%;
        background: linear-gradient(135deg, #ffd200 0%, #43cea2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.5em;
            font-weight: 700;
        box-shadow: 0 2px 8px rgba(67,206,162,0.10);
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
        color: #43cea2;
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
        background: linear-gradient(100deg, #fffbe6 0%, #eafff7 100%);
        border-radius: 1.2em;
        box-shadow: 0 2px 12px rgba(67,206,162,0.08);
        padding: 2em 2em 1.5em 2em;
    }
    .modern-review-form-title {
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 1.2em;
        color: #222;
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
        color: #185a9d;
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
        border: 1.5px solid #43cea2;
        padding: 0.7em 1.1em;
        font-size: 1.05em;
        background: #fff;
        color: #222;
        transition: border 0.2s;
        box-shadow: 0 1px 4px rgba(67,206,162,0.04);
    }
    .modern-form-group input:focus,
    .modern-form-group select:focus,
    .modern-form-group textarea:focus {
        border: 1.5px solid #ffd200;
        outline: none;
    }
    .modern-review-form-btn {
        background: linear-gradient(90deg, #ffd200 0%, #43cea2 100%);
        color: #222;
            font-weight: 700;
        border: none;
        border-radius: 2em;
        padding: 0.7em 2em;
        font-size: 1.1em;
        box-shadow: 0 2px 8px rgba(34,34,34,0.08);
        transition: background 0.2s, color 0.2s;
    }
    .modern-review-form-btn:hover {
        background: #222;
        color: #ffd200;
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
            <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="16" fill="url(#reviewGradient)"/><path d="M10 22l2-2 4 4 8-8-2-2-6 6-2-2-2 2z" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><defs><linearGradient id="reviewGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse"><stop stop-color="#ffd200"/><stop offset="1" stop-color="#43cea2"/></linearGradient></defs></svg>
            <span data-lang-key="user_reviews">User Reviews</span>
        </h2>
        <div id="reviews-list" class="reviews-list"></div>
        <div class="modern-review-form-container">
            <h3 class="modern-review-form-title">
                <span data-lang-key="leave_a_review">Leave a Review</span>
            </h3>
            <form id="reviewForm" method="POST" action="{{ url('/livecoinwatch/history/reviews') }}">
                @csrf
                <div class="modern-form-group">
                    <label for="name">
                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" fill="#ffd200"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="#43cea2" stroke-width="2"/></svg>
                        <span data-lang-key="name">Name</span>
                    </label>
                    <input type="text" class="form-control" id="name" name="name" required maxlength="255">
            </div>
                <div class="modern-form-group">
                    <label for="email">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#43cea2"/><path d="M2 6l10 7 10-7" stroke="#ffd200" stroke-width="2"/></svg>
                        <span data-lang-key="email">Email</span>
                    </label>
                    <input type="email" class="form-control" id="email" name="email" required maxlength="255">
        </div>
                <div class="modern-form-group">
                    <label for="rating">
                        <svg viewBox="0 0 24 24" fill="none"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" fill="#ffd200"/></svg>
                        <span data-lang-key="rating">Rating</span>
                    </label>
                    <select class="form-control" id="rating" name="rating" required>
                        <option value="" data-lang-key="select">Select</option>
                        <option value="1" data-lang-key="poor">1 - Poor</option>
                        <option value="2" data-lang-key="fair">2 - Fair</option>
                        <option value="3" data-lang-key="good">3 - Good</option>
                        <option value="4" data-lang-key="very_good">4 - Very Good</option>
                        <option value="5" data-lang-key="excellent">5 - Excellent</option>
                    </select>
            </div>
                <div class="modern-form-group">
                    <label for="title">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ffd200"/><path d="M8 12h8M8 16h4" stroke="#43cea2" stroke-width="2"/></svg>
                        <span data-lang-key="title">Title</span>
                    </label>
                    <input type="text" class="form-control" id="title" name="title" required maxlength="255">
                </div>
                <div class="modern-form-group">
                    <label for="comment">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="4" fill="#43cea2"/><path d="M6 8h12M6 12h8" stroke="#ffd200" stroke-width="2"/></svg>
                        <span data-lang-key="comment">Comment</span>
                    </label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn modern-review-form-btn" data-lang-key="submit_review">Submit Review</button>
                <div id="reviewFormMsg" style="margin-top: 1em;"></div>
            </form>
        </div>
    </div>
@endsection

{{-- ======================== Scripts Section ======================== --}}
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ url('js/livecoin/history.js') }}"></script>
    <script>
        function getInitials(name) {
            if (!name) return '';
            const parts = name.trim().split(' ');
            if (parts.length === 1) return parts[0][0].toUpperCase();
            return (parts[0][0] + parts[parts.length-1][0]).toUpperCase();
        }
        function renderReviews(reviews) {
            let html = '';
            if (reviews.length === 0) {
                html = '<div class="alert alert-info">No reviews yet. Be the first to review!</div>';
                } else {
                html = reviews.map(r => `
                    <div class="modern-review-card">
                        <div class="modern-review-avatar">${getInitials(r.name)}</div>
                        <div class="modern-review-content">
                            <div class="modern-review-header">
                                <span class="modern-review-name">${r.name}</span>
                                <span class="modern-review-date"><svg style="width:1em;height:1em;vertical-align:middle;margin-right:0.2em;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 6v6l4 2" stroke="#43cea2" stroke-width="2" stroke-linecap="round"/></svg> ${new Date(r.created_at).toLocaleString()}</span>
                                <span class="modern-review-rating">${'★'.repeat(r.rating)}${'☆'.repeat(5 - r.rating)}</span>
                            </div>
                            <div class="modern-review-title">${r.title}</div>
                            <div class="modern-review-comment">${r.comment.replace(/\n/g, '<br>')}</div>
                        </div>
                    </div>
                `).join('');
            }
            document.getElementById('reviews-list').innerHTML = html;
        }

        function fetchReviews() {
            fetch('/livecoinwatch/history/reviews')
                .then(res => res.json())
                .then(data => renderReviews(data));
        }

        // Comparison Charts and Data Loading
        let comparisonCharts = {};

        function formatNumber(num) {
            if (num >= 1e12) return (num / 1e12).toFixed(2) + 'T';
            if (num >= 1e9) return (num / 1e9).toFixed(2) + 'B';
            if (num >= 1e6) return (num / 1e6).toFixed(2) + 'M';
            if (num >= 1e3) return (num / 1e3).toFixed(2) + 'K';
            return num.toFixed(2);
        }

        function formatCurrency(num) {
            return '$' + formatNumber(num);
        }

        function loadComparisonData() {
            const loadingEl = document.getElementById('comparisonLoading');
            const chartsEl = document.getElementById('comparisonCharts');
            
            loadingEl.style.display = 'block';
            chartsEl.style.display = 'none';

            fetch('/livecoinwatch/compare')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderComparisonData(data.data);
                        loadingEl.style.display = 'none';
                        chartsEl.style.display = 'block';
                    } else {
                        console.error('Error loading comparison data:', data.message);
                        loadingEl.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching comparison data:', error);
                    loadingEl.style.display = 'none';
                });
        }

        function renderComparisonData(data) {
            // Update platform overview cards
            updatePlatformCards(data);
            
            // Create charts
            createMarketCapChart(data.market_cap_distribution);
            createPriceTrendsChart(data.trends);
            createVolumeChart(data.volume_analysis);
            createPlatformChart(data.comparison);
            
            // Update top performers table
            updateTopPerformersTable(data.top_performers);
            
            // Update trends summary
            updateTrendsSummary(data.trends);
        }

        function updatePlatformCards(data) {
            // LiveCoinWatch
            document.getElementById('lcw-total-coins').textContent = data.livecoinwatch.total_coins.toLocaleString();
            document.getElementById('lcw-total-mcap').textContent = formatCurrency(data.livecoinwatch.total_market_cap);
            document.getElementById('lcw-total-volume').textContent = formatCurrency(data.livecoinwatch.total_volume);
            
            // CoinGecko
            document.getElementById('cg-total-coins').textContent = data.coingecko.total_coins.toLocaleString();
            document.getElementById('cg-total-markets').textContent = data.coingecko.total_markets.toLocaleString();
            document.getElementById('cg-total-exchanges').textContent = data.coingecko.total_exchanges.toLocaleString();
            
            // CoinMarketCal
            document.getElementById('cmc-total-coins').textContent = data.coinmarketcal.total_coins.toLocaleString();
            document.getElementById('cmc-total-events').textContent = data.coinmarketcal.total_events.toLocaleString();
            document.getElementById('cmc-top-10').textContent = data.coinmarketcal.rank_distribution.top_10.toLocaleString();
        }

        function createMarketCapChart(data) {
            const ctx = document.getElementById('marketCapChart').getContext('2d');
            
            if (comparisonCharts.marketCap) {
                comparisonCharts.marketCap.destroy();
            }

            comparisonCharts.marketCap = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Mega Cap (>$10B)', 'Large Cap ($1B-$10B)', 'Mid Cap ($100M-$1B)', 'Small Cap ($10M-$100M)', 'Micro Cap (<$10M)'],
                    datasets: [{
                        data: [
                            data.distribution.mega_cap,
                            data.distribution.large_cap,
                            data.distribution.mid_cap,
                            data.distribution.small_cap,
                            data.distribution.micro_cap
                        ],
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#9966FF'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                boxWidth: 12
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });
        }

        function createPriceTrendsChart(data) {
            const ctx = document.getElementById('priceTrendsChart').getContext('2d');
            
            if (comparisonCharts.priceTrends) {
                comparisonCharts.priceTrends.destroy();
            }

            comparisonCharts.priceTrends = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Gaining', 'Losing', 'Stable'],
                    datasets: [{
                        label: 'Price Movement (24h)',
                        data: [
                            data.price_movement.gaining,
                            data.price_movement.losing,
                            data.price_movement.stable
                        ],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(220, 53, 69, 0.8)',
                            'rgba(108, 117, 125, 0.8)'
                        ],
                        borderColor: [
                            'rgba(40, 167, 69, 1)',
                            'rgba(220, 53, 69, 1)',
                            'rgba(108, 117, 125, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });
        }

        function createVolumeChart(data) {
            const ctx = document.getElementById('volumeChart').getContext('2d');
            
            if (comparisonCharts.volume) {
                comparisonCharts.volume.destroy();
            }

            comparisonCharts.volume = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['High Volume (>$1B)', 'Medium Volume ($100M-$1B)', 'Low Volume (<$100M)'],
                    datasets: [{
                        data: [
                            data.volume_distribution.high,
                            data.volume_distribution.medium,
                            data.volume_distribution.low
                        ],
                        backgroundColor: [
                            '#28a745',
                            '#ffc107',
                            '#dc3545'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                boxWidth: 12
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });
        }

        function createPlatformChart(data) {
            const ctx = document.getElementById('platformChart').getContext('2d');
            
            if (comparisonCharts.platform) {
                comparisonCharts.platform.destroy();
            }

            comparisonCharts.platform = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['LiveCoinWatch Only', 'CoinGecko Only', 'Both Platforms'],
                    datasets: [{
                        label: 'Platform Coverage',
                        data: [
                            data.platform_coverage.livecoinwatch_only,
                            data.platform_coverage.coingecko_only,
                            data.platform_coverage.both_platforms
                        ],
                        backgroundColor: [
                            'rgba(255, 193, 7, 0.8)',
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(13, 110, 253, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 193, 7, 1)',
                            'rgba(40, 167, 69, 1)',
                            'rgba(13, 110, 253, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });
        }

        function updateTopPerformersTable(data) {
            const tbody = document.getElementById('topPerformersBody');
            let html = '';
            
            data.by_market_cap.forEach((coin, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${coin.name}</td>
                        <td><strong>${coin.symbol.toUpperCase()}</strong></td>
                        <td>${formatCurrency(coin.market_cap)}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                `;
            });
            
            tbody.innerHTML = html;
        }

        function updateTrendsSummary(data) {
            document.getElementById('trends-gaining').textContent = data.price_movement.gaining.toLocaleString();
            document.getElementById('trends-losing').textContent = data.price_movement.losing.toLocaleString();
            document.getElementById('trends-stable').textContent = data.price_movement.stable.toLocaleString();
        }

        // Coin Search Functionality
        function searchCoin() {
            const symbol = document.getElementById('coinSearchInput').value.trim();
            if (!symbol) {
                alert('Please enter a coin symbol');
                return;
            }

            const resultEl = document.getElementById('coinAnalysisResult');
            resultEl.style.display = 'block';
            resultEl.innerHTML = '<div style="text-align: center; padding: 2em;"><div class="spinner-border text-warning" role="status"></div><p>Searching for coin data...</p></div>';

            fetch(`/livecoinwatch/coin-analysis?symbol=${encodeURIComponent(symbol)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderCoinAnalysis(data);
                    } else {
                        resultEl.innerHTML = `<div class="alert alert-warning">No data found for ${symbol.toUpperCase()}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Error searching coin:', error);
                    resultEl.innerHTML = `<div class="alert alert-danger">Error searching for ${symbol.toUpperCase()}</div>`;
                });
        }

        function renderCoinAnalysis(data) {
            const resultEl = document.getElementById('coinAnalysisResult');
            const analysis = data.analysis;
            
            let html = `
                <div class="coin-analysis-header">
                    <h3>📊 Analysis for ${data.symbol}</h3>
                </div>
                <div class="coin-analysis-grid">
            `;

            // LiveCoinWatch Data
            if (analysis.livecoinwatch) {
                html += `
                    <div class="coin-analysis-card">
                        <h4>📈 LiveCoinWatch</h4>
                        <div class="coin-analysis-data">
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Price</span>
                                <span class="coin-analysis-value">$${formatNumber(analysis.livecoinwatch.price)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Market Cap</span>
                                <span class="coin-analysis-value">${formatCurrency(analysis.livecoinwatch.market_cap)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Volume</span>
                                <span class="coin-analysis-value">${formatCurrency(analysis.livecoinwatch.volume)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Last Updated</span>
                                <span class="coin-analysis-value">${new Date(analysis.livecoinwatch.last_updated).toLocaleString()}</span>
                            </div>
                        </div>
                    </div>
                `;
            }

            // CoinGecko Data
            if (analysis.coingecko) {
                const priceChangeClass = analysis.coingecko.price_change_percentage_24h >= 0 ? 'positive' : 'negative';
                const priceChangeSign = analysis.coingecko.price_change_percentage_24h >= 0 ? '+' : '';
                
                html += `
                    <div class="coin-analysis-card">
                        <h4>🦎 CoinGecko</h4>
                        <div class="coin-analysis-data">
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Name</span>
                                <span class="coin-analysis-value">${analysis.coingecko.name}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Price</span>
                                <span class="coin-analysis-value">$${formatNumber(analysis.coingecko.current_price)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Market Cap</span>
                                <span class="coin-analysis-value">${formatCurrency(analysis.coingecko.market_cap)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Rank</span>
                                <span class="coin-analysis-value">#${analysis.coingecko.market_cap_rank}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">24h Change</span>
                                <span class="coin-analysis-value ${priceChangeClass}">${priceChangeSign}${analysis.coingecko.price_change_percentage_24h.toFixed(2)}%</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Volume</span>
                                <span class="coin-analysis-value">${formatCurrency(analysis.coingecko.total_volume)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Circulating Supply</span>
                                <span class="coin-analysis-value">${formatNumber(analysis.coingecko.circulating_supply)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Max Supply</span>
                                <span class="coin-analysis-value">${analysis.coingecko.max_supply ? formatNumber(analysis.coingecko.max_supply) : 'N/A'}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">ATH</span>
                                <span class="coin-analysis-value">$${formatNumber(analysis.coingecko.ath)}</span>
                            </div>
                        </div>
                    </div>
                `;
            }

            // CoinMarketCal Data
            if (analysis.coinmarketcal) {
                html += `
                    <div class="coin-analysis-card">
                        <h4>📅 CoinMarketCal</h4>
                        <div class="coin-analysis-data">
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Name</span>
                                <span class="coin-analysis-value">${analysis.coinmarketcal.name}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Rank</span>
                                <span class="coin-analysis-value">#${analysis.coinmarketcal.rank}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Hot Index</span>
                                <span class="coin-analysis-value">${analysis.coinmarketcal.hot_index || 'N/A'}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Trending Index</span>
                                <span class="coin-analysis-value">${analysis.coinmarketcal.trending_index || 'N/A'}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">Significant Index</span>
                                <span class="coin-analysis-value">${analysis.coinmarketcal.significant_index || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                `;
            }

            html += '</div>';
            resultEl.innerHTML = html;
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchReviews();
            
            // Load comparison data on page load
            loadComparisonData();
            
            // Refresh comparison data button
            document.getElementById('refreshComparison').addEventListener('click', function() {
                loadComparisonData();
            });
            
            // Coin search functionality
            document.getElementById('searchCoinBtn').addEventListener('click', searchCoin);
            document.getElementById('coinSearchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchCoin();
                }
            });
            
            document.getElementById('reviewForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);
                const csrfToken = document.querySelector('input[name="_token"]').value;
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        form.reset();
                        document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-success">Thank you for your review!</div>';
                        fetchReviews();
                } else {
                        document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
                    }
                })
                .catch(() => {
                    document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
                });
            });
        });
    </script>
@endsection