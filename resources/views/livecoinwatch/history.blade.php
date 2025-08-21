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

        {{-- User-Friendly Navigation Explanation --}}
        <div class="navigation-explanation">
            <div class="explanation-content">
                <div class="explanation-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <div class="explanation-text">
                    <h4 class="explanation-title" data-lang-key="interactive_table_navigation_title">💡 Interactive Table Navigation</h4>
                    <p class="explanation-description">
                        <strong data-lang-key="interactive_table_navigation_click_on_any_row">Click on any row</strong> <span data-lang-key="interactive_table_navigation_desc_tail">in the table below to explore detailed information about that cryptocurrency.</span>
                        <span data-lang-key="interactive_table_navigation_youll_be_taken">You'll be taken to a comprehensive details page featuring:</span>
                    </p>
                    <div class="explanation-features">
                        <div class="feature-item">
                            <span class="feature-icon">📊</span>
                            <span class="feature-text" data-lang-key="interactive_feature_tradingview_charts">TradingView Charts</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">📅</span>
                            <span class="feature-text" data-lang-key="interactive_feature_events_calendar">Events Calendar</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">💬</span>
                            <span class="feature-text" data-lang-key="interactive_feature_telegram_messages">Telegram Messages</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🐦</span>
                            <span class="feature-text" data-lang-key="interactive_feature_twitter_sentiment">Twitter Sentiment</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">📈</span>
                            <span class="feature-text" data-lang-key="interactive_feature_market_analysis">Market Analysis</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🔍</span>
                            <span class="feature-text" data-lang-key="interactive_feature_technical_indicators">Technical Indicators</span>
                        </div>
                    </div>
                    <div class="explanation-tip">
                        <span class="tip-icon">💡</span>
                        <span class="tip-text" data-lang-key="interactive_pro_tip">Pro tip: Use the search and filter options above to find specific cryptocurrencies quickly!</span>
                    </div>
                </div>
            </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            fetchReviews();
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