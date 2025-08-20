@extends('layouts.base')

{{-- ======================== Page Title Section ======================== --}}
@section('title')
    Markets Comparizon - Crypto Trading
@endsection

{{-- ======================== Styles Section ======================== --}}
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/history.css') }}" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet'>
    <style>
        .charts-grid { display: block; }
        .chart-block canvas { width: 100% !important; height: 100% !important; }
        @media (max-width: 640px) {
            .chart-row { grid-template-columns: 1fr !important; }
            .chart-block h4 { font-size: 14px; }
        }
        /* Lighten comparison section background */
        .comparison-section {
            background-color: #f9fafb;
            border-radius: 12px;
            padding: 1.25em;
        }
        /* Give charts a light card background */
        #comparisonCharts .chart-block {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px;
        }
        /* Target mobile screens */
        @media (max-width: 768px) {
            td.fc-list-event-title {
                color: black; /* Change this to your desired text color */
            }

            /* Optionally, target the inner div or span if needed */
            td.fc-list-event-title div {
                color: black;
            }
        }
    </style>
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
                <span class="modern-title-text" data-lang-key="platforms_comparison_title">{{ __('menu.platforms_comparison_title') }}</span>
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
                    {{--<span class="modern-title-text" data-lang-key="platforms_comparison_title">{{ __('menu.platforms_comparison_title') }}</span>--}}
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

            {{-- Enhanced Loading Interface --}}
            <div id="enhancedLoading" class="enhanced-loading" style="display:block;">
                <div class="loading-container">
                    <div class="loading-header">
                        <div class="loading-spinner">
                            <div class="spinner-ring"></div>
                            <div class="spinner-ring"></div>
                            <div class="spinner-ring"></div>
                        </div>
                        <h2 class="loading-title">Loading CryptoTrading Data</h2>
                        <p class="loading-subtitle">Fetching comprehensive market data from multiple sources...</p>
                    </div>
                    
                    <div class="loading-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" id="progressFill"></div>
                        </div>
                        <div class="progress-text" id="progressText">Initializing...</div>
                    </div>
                    
                    <div class="loading-sources">
                        <div class="source-item" data-source="livecoinwatch">
                            <div class="source-icon">📊</div>
                            <div class="source-info">
                                <span class="source-name">LiveCoinWatch</span>
                                <span class="source-status" id="livecoinwatch-status">Waiting...</span>
                            </div>
                        </div>
                        
                        <div class="source-item" data-source="coingecko">
                            <div class="source-icon">🦎</div>
                            <div class="source-info">
                                <span class="source-name">CoinGecko</span>
                                <span class="source-status" id="coingecko-status">Waiting...</span>
                            </div>
                        </div>
                        
                        <div class="source-item" data-source="coinmarketcal">
                            <div class="source-icon">📅</div>
                            <div class="source-info">
                                <span class="source-name">CoinMarketCal</span>
                                <span class="source-status" id="coinmarketcal-status">Waiting...</span>
                            </div>
                        </div>
                        
                        <div class="source-item" data-source="cryptocompare">
                            <div class="source-icon">🔍</div>
                            <div class="source-info">
                                <span class="source-name">CryptoCompare</span>
                                <span class="source-status" id="cryptocompare-status">Waiting...</span>
                            </div>
                        </div>
                        
                        <div class="source-item" data-source="coinpaprika">
                            <div class="source-icon">🌶️</div>
                            <div class="source-info">
                                <span class="source-name">CoinPaprika</span>
                                <span class="source-status" id="coinpaprika-status">Waiting...</span>
                            </div>
                        </div>
                        
                        <div class="source-item" data-source="cryptics">
                            <div class="source-icon">🔮</div>
                            <div class="source-info">
                                <span class="source-name">Cryptics.tech</span>
                                <span class="source-status" id="cryptics-status">Waiting...</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="loading-tips">
                        <div class="tip-item">
                            <span class="tip-icon">💡</span>
                            <span class="tip-text">Data is being fetched from multiple cryptocurrency platforms</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-icon">⚡</span>
                            <span class="tip-text">This ensures you get the most comprehensive market overview</span>
                        </div>
                        <div class="tip-item">
                            <span class="tip-icon">🔄</span>
                            <span class="tip-text">Data refreshes automatically every few minutes</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Container --}}
            <div id="comparisonCharts" class="charts-container" style="display:none;">

                {{-- Coin Search Section --}}
                <div class="coin-search-section">
                    <div class="search-container">
                        <input type="text" id="coinSearchInput" placeholder="{{ __('menu.search_for_coin') }}" class="coin-search-input" data-lang-key="search_for_coin">
                        <button id="searchCoinBtn" class="search-btn" data-lang-key="search">{{ __('menu.search') }}</button>
                    </div>
                    <div id="coinAnalysisResult" class="coin-analysis-result" style="display:none;">
                        <!-- Coin analysis will be displayed here -->
                    </div>
                </div>



                {{-- Platform Overview Cards --}}
                <div class="platform-overview mt-5">
                    <div class="platform-card livecoinwatch">
                        <div class="platform-header">
                            <h3>LiveCoinWatch</h3>
                            <div class="platform-icon">📊</div>
                        </div>
                        <div class="platform-stats">
                            <div class="stat">
                                <span class="stat-label" data-lang-key="total_coins">{{ __('menu.total_coins') }}</span>
                                <span class="stat-value" id="lcw-total-coins">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label" data-lang-key="total_market_cap">{{ __('menu.total_market_cap') }}</span>
                                <span class="stat-value" id="lcw-total-mcap">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label" data-lang-key="total_volume">{{ __('menu.total_volume') }}</span>
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
                                <span class="stat-label" data-lang-key="total_coins">{{ __('menu.total_coins') }}</span>
                                <span class="stat-value" id="cg-total-coins">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label" data-lang-key="total_markets">{{ __('menu.total_markets') }}</span>
                                <span class="stat-value" id="cg-total-markets">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label" data-lang-key="total_exchanges">{{ __('menu.total_exchanges') }}</span>
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
                                <span class="stat-label" data-lang-key="total_coins">{{ __('menu.total_coins') }}</span>
                                <span class="stat-value" id="cmc-total-coins">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label" data-lang-key="total_events">{{ __('menu.total_events') }}</span>
                                <span class="stat-value" id="cmc-total-events">-</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label" data-lang-key="top_10_ranked">{{ __('menu.top_10_ranked') }}</span>
                                <span class="stat-value" id="cmc-top-10">-</span>
                            </div>
                        </div>
                    </div>



            {{-- CryptoCompare Platform --}}
            <div class="platform-card cryptocompare">
                <div class="platform-header">
                    <h3 data-lang-key="cryptocompare">{{ __('menu.cryptocompare') }}</h3>
                    <div class="platform-icon">🔍</div>
                </div>
                <div class="platform-stats">
                    <div class="stat">
                        <span class="stat-label" data-lang-key="total_coins">{{ __('menu.total_coins') }}</span>
                        <span class="stat-value" id="cc-total-coins">-</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label" data-lang-key="total_market_cap">{{ __('menu.total_market_cap') }}</span>
                        <span class="stat-value" id="cc-total-mcap">-</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label" data-lang-key="total_volume">{{ __('menu.total_volume') }}</span>
                        <span class="stat-value" id="cc-total-volume">-</span>
                    </div>
                </div>
            </div>

            {{-- CoinPaprika Platform --}}
            <div class="platform-card coinpaprika">
                <div class="platform-header">
                    <h3 data-lang-key="coinpaprika">{{ __('menu.coinpaprika') }}</h3>
                    <div class="platform-icon">🌶️</div>
                </div>
                <div class="platform-stats">
                    <div class="stat">
                        <span class="stat-label" data-lang-key="total_coins">{{ __('menu.total_coins') }}</span>
                        <span class="stat-value" id="cp-total-coins">
                            <div class="loader-spinner"></div>
                        </span>
                    </div>
                    <div class="stat">
                        <span class="stat-label" data-lang-key="active_coins">{{ __('menu.active_coins') }}</span>
                        <span class="stat-value" id="cp-active-coins">
                            <div class="loader-spinner"></div>
                        </span>
                    </div>
                    <div class="stat">
                        <span class="stat-label" data-lang-key="new_coins">{{ __('menu.new_coins') }}</span>
                        <span class="stat-value" id="cp-new-coins">
                            <div class="loader-spinner"></div>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Cryptics.tech Platform --}}
            <div class="platform-card cryptics">
                <div class="platform-header">
                    <h3 data-lang-key="cryptics_tech">{{ __('menu.cryptics_tech') }}</h3>
                    <div class="platform-icon">🔮</div>
                </div>
                <div class="platform-stats">
                    <div class="stat">
                        <span class="stat-label" data-lang-key="total_predictions">{{ __('menu.total_predictions') }}</span>
                        <span class="stat-value" id="ct-total-predictions">
                            <div class="loader-spinner"></div>
                        </span>
                    </div>
                    <div class="stat">
                        <span class="stat-label" data-lang-key="prediction_accuracy">{{ __('menu.prediction_accuracy') }}</span>
                        <span class="stat-value" id="ct-accuracy">
                            <div class="loader-spinner"></div>
                        </span>
                    </div>
                    <div class="stat">
                        <span class="stat-label" data-lang-key="trending_up">{{ __('menu.trending_up') }}</span>
                        <span class="stat-value" id="ct-trending-up">
                            <div class="loader-spinner"></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>

                {{-- Coin Event Calendar Section --}}
                <div class="coin-event-calendar mb-5" style="margin-top: 2em;">
                    <div class="modern-title-bar">
                        <div class="m-portlet__head-title custom-modern">
                            <span class="modern-title-text">Coin Event Calendar</span>
                        </div>
                    </div>
                    <div class="calendar-wrapper">
                        <div id="calendarLoading" style="display:none;text-align:center;padding:12px;">
                            <div class="loader-spinner"></div>
                        </div>
                        <div id="coinEventCalendar"></div>
                        <div id="eventModal" class="event-modal" style="display:none;">
                            <div class="event-modal__backdrop" onclick="(function(){ const m=document.getElementById('eventModal'); if(m) m.style.display='none'; })()"></div>
                            <div class="event-modal__content">
                                <div class="event-modal__header">
                                    <h3 id="eventModalTitle">Event</h3>
                                    <button type="button" class="event-modal__close" aria-label="Close" onclick="(function(){ const m=document.getElementById('eventModal'); if(m) m.style.display='none'; })()">×</button>
                                </div>
                                <div class="event-modal__body">
                                    <div class="event-modal__row" id="eventModalDate"></div>
                                    <div class="event-modal__row" id="eventModalCoins"></div>
                                    <div class="event-modal__row" id="eventModalCategories"></div>
                                    <div class="event-modal__row" id="eventModalProof"></div>
                                </div>
                                <div class="event-modal__footer">
                                    <a id="eventModalLink" href="#" target="_blank" rel="noopener" class="event-modal__btn" style="display:none;">Open Source</a>
                                    <button type="button" class="event-modal__btn secondary" onclick="(function(){ const m=document.getElementById('eventModal'); if(m) m.style.display='none'; })()">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


        {{-- Chart Grid --}}
        <div class="chart-grid">
            {{-- Market Cap Distribution Chart --}}
            <div class="chart-card">
                <h4 data-lang-key="market_cap_distribution">{{ __('menu.market_cap_distribution') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="marketCapChart"></canvas>
                </div>
            </div>

            {{-- Price Movement Trends --}}
            <div class="chart-card">
                <h4 data-lang-key="price_movement_trends">{{ __('menu.price_movement_trends') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="priceTrendsChart"></canvas>
                </div>
            </div>

            {{-- Volume Analysis --}}
            <div class="chart-card">
                <h4 data-lang-key="volume_distribution">{{ __('menu.volume_distribution') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="volumeChart"></canvas>
                </div>
            </div>

            {{-- Cross-Platform Comparison --}}
            <div class="chart-card">
                <h4 data-lang-key="platform_coverage">{{ __('menu.platform_coverage') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="platformChart"></canvas>
                </div>
            </div>

            {{-- ======================== NEW PLATFORM COMPARISON CHARTS ======================== --}}
            
            {{-- Platform Data Comparison Chart --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="platform_data_comparison">{{ __('menu.platform_data_comparison') }}</h4>
                <div class="chart-container" style="height: 400px; position: relative;">
                    <canvas id="platformComparisonChart"></canvas>
                </div>
            </div>

            {{-- Market Cap Comparison by Platform --}}
            <div class="chart-card">
                <h4 data-lang-key="market_cap_comparison">{{ __('menu.market_cap_comparison') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="marketCapComparisonChart"></canvas>
                </div>
            </div>

            {{-- Volume Comparison by Platform --}}
            <div class="chart-card">
                <h4 data-lang-key="volume_comparison">{{ __('menu.volume_comparison') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="volumeComparisonChart"></canvas>
                </div>
            </div>

            {{-- Coin Count Comparison by Platform --}}
            <div class="chart-card">
                <h4 data-lang-key="coin_count_comparison">{{ __('menu.coin_count_comparison') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="coinCountComparisonChart"></canvas>
                </div>
            </div>

            {{-- Price Movement Comparison --}}
            <div class="chart-card">
                <h4 data-lang-key="price_movement_comparison">{{ __('menu.price_movement_comparison') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="priceMovementComparisonChart"></canvas>
                </div>
            </div>

            {{-- Platform Performance Summary Table --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="platform_performance_summary">{{ __('menu.platform_performance_summary') }}</h4>
                <div class="platform-performance-table">
                    <div class="table-responsive">
                        <table id="platformPerformanceTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th data-lang-key="platform">{{ __('menu.platform') }}</th>
                                <th data-lang-key="total_coins">{{ __('menu.total_coins') }}</th>
                                <th data-lang-key="total_market_cap">{{ __('menu.total_market_cap') }}</th>
                                <th data-lang-key="total_volume">{{ __('menu.total_volume') }}</th>
                                <th data-lang-key="gaining_coins">{{ __('menu.gaining_coins') }}</th>
                                <th data-lang-key="losing_coins">{{ __('menu.losing_coins') }}</th>
                                <th data-lang-key="last_updated">{{ __('menu.last_updated') }}</th>
                            </tr>
                            </thead>
                            <tbody id="platformPerformanceBody">
                            <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Top Performers --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="top_10_coins_by_market_cap">{{ __('menu.top_10_coins_by_market_cap') }}</h4>
                <div class="top-performers-table">
                    <div class="table-responsive">
                        <table id="topPerformersTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th data-lang-key="rank">{{ __('menu.rank') }}</th>
                                <th data-lang-key="name">{{ __('menu.name') }}</th>
                                <th data-lang-key="symbol">{{ __('menu.symbol') }}</th>
                                <th data-lang-key="market_cap">{{ __('menu.market_cap') }}</th>
                                <th data-lang-key="price">{{ __('menu.price') }}</th>
                                <th data-lang-key="24h_change">{{ __('menu.24h_change') }}</th>
                            </tr>
                            </thead>
                            <tbody id="topPerformersBody">
                            <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





            {{-- Market Trends Summary --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="market_trends_summary">{{ __('menu.market_trends_summary') }}</h4>
                <div class="trends-summary">
                    <div class="trend-item positive">
                        <span class="trend-icon">📈</span>
                        <span class="trend-label" data-lang-key="gaining">{{ __('menu.gaining') }}</span>
                        <span class="trend-value" id="trends-gaining">-</span>
                    </div>
                    <div class="trend-item negative">
                        <span class="trend-icon">📉</span>
                        <span class="trend-label" data-lang-key="losing">{{ __('menu.losing') }}</span>
                        <span class="trend-value" id="trends-losing">-</span>
                    </div>
                    <div class="trend-item neutral">
                        <span class="trend-icon">➡️</span>
                        <span class="trend-label" data-lang-key="stable">{{ __('menu.stable') }}</span>
                        <span class="trend-value" id="trends-stable">-</span>
                    </div>
                </div>
            </div>

            {{-- ======================== NEW COMPREHENSIVE CRYPTO CHARTS ======================== --}}

            {{-- Market Sentiment Analysis Chart --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="market_sentiment_analysis">{{ __('menu.market_sentiment_analysis') }}</h4>
                <div class="chart-container" style="height: 400px; position: relative;">
                    <canvas id="marketSentimentChart"></canvas>
                </div>
            </div>

            {{-- Price Correlation Matrix Chart --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="price_correlation_matrix">{{ __('menu.price_correlation_matrix') }}</h4>
                <div class="chart-container" style="height: 400px; position: relative;">
                    <canvas id="priceCorrelationChart"></canvas>
                </div>
            </div>

            {{-- Exchange Performance Comparison --}}
            <div class="chart-card">
                <h4 data-lang-key="exchange_performance_comparison">{{ __('menu.exchange_performance_comparison') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="exchangePerformanceChart"></canvas>
                </div>
            </div>

            {{-- Market Cap vs Volume Scatter Plot --}}
            <div class="chart-card">
                <h4 data-lang-key="market_cap_vs_volume">{{ __('menu.market_cap_vs_volume') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="marketCapVolumeChart"></canvas>
                </div>
            </div>

            {{-- Top Coins Performance Timeline --}}
            <div class="chart-card">
                <h4 data-lang-key="top_coins_performance_timeline">{{ __('menu.top_coins_performance_timeline') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="topCoinsTimelineChart"></canvas>
                </div>
            </div>

            {{-- Platform Data Coverage Chart --}}
            <div class="chart-card">
                <h4 data-lang-key="platform_data_coverage">{{ __('menu.platform_data_coverage') }}</h4>
                <div class="chart-container" style="height: 300px; position: relative;">
                    <canvas id="platformCoverageChart"></canvas>
                </div>
            </div>

            {{-- ======================== NEW DATA TABLES ======================== --}}

            {{-- Comprehensive Market Analysis Table --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="comprehensive_market_analysis">{{ __('menu.comprehensive_market_analysis') }}</h4>
                <div class="market-analysis-table">
                    <div class="table-responsive">
                        <table id="marketAnalysisTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th data-lang-key="coin">{{ __('menu.coin') }}</th>
                                <th data-lang-key="symbol">{{ __('menu.symbol') }}</th>
                                <th data-lang-key="current_price">{{ __('menu.current_price') }}</th>
                                <th data-lang-key="market_cap">{{ __('menu.market_cap') }}</th>
                                <th data-lang-key="volume_24h">{{ __('menu.volume_24h') }}</th>
                                <th data-lang-key="price_change_24h">{{ __('menu.price_change_24h') }}</th>
                                <th data-lang-key="platforms_available">{{ __('menu.platforms_available') }}</th>
                                <th data-lang-key="sentiment_score">{{ __('menu.sentiment_score') }}</th>
                            </tr>
                            </thead>
                            <tbody id="marketAnalysisBody">
                            <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Exchange Comparison Table --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="exchange_comparison_table">{{ __('menu.exchange_comparison_table') }}</h4>
                <div class="exchange-comparison-table">
                    <div class="table-responsive">
                        <table id="exchangeComparisonTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th data-lang-key="exchange_name">{{ __('menu.exchange_name') }}</th>
                                <th data-lang-key="trust_score">{{ __('menu.trust_score') }}</th>
                                <th data-lang-key="volume_24h_btc">{{ __('menu.volume_24h_btc') }}</th>
                                <th data-lang-key="year_established">{{ __('menu.year_established') }}</th>
                                <th data-lang-key="country">{{ __('menu.country') }}</th>
                                <th data-lang-key="exchange_type">{{ __('menu.exchange_type') }}</th>
                                <th data-lang-key="trading_pairs">{{ __('menu.trading_pairs') }}</th>
                            </tr>
                            </thead>
                            <tbody id="exchangeComparisonBody">
                            <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Price Prediction Accuracy Table --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="price_prediction_accuracy">{{ __('menu.price_prediction_accuracy') }}</h4>
                <div class="prediction-accuracy-table">
                    <div class="table-responsive">
                        <table id="predictionAccuracyTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th data-lang-key="coin_pair">{{ __('menu.coin_pair') }}</th>
                                <th data-lang-key="predicted_price">{{ __('menu.predicted_price') }}</th>
                                <th data-lang-key="actual_price">{{ __('menu.actual_price') }}</th>
                                <th data-lang-key="prediction_accuracy">{{ __('menu.prediction_accuracy') }}</th>
                                <th data-lang-key="prediction_date">{{ __('menu.prediction_date') }}</th>
                                <th data-lang-key="confidence_level">{{ __('menu.confidence_level') }}</th>
                                <th data-lang-key="trend_direction">{{ __('menu.trend_direction') }}</th>
                            </tr>
                            </thead>
                            <tbody id="predictionAccuracyBody">
                            <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Market Trends Summary Table --}}
            <div class="chart-card full-width">
                <h4 data-lang-key="market_trends_summary">{{ __('menu.market_trends_summary') }}</h4>
                <div class="trends-summary">
                    <div class="trend-item positive">
                        <span class="trend-icon">📈</span>
                        <span class="trend-label" data-lang-key="gaining">{{ __('menu.gaining') }}</span>
                        <span class="trend-value" id="trends-gaining">-</span>
                    </div>
                    <div class="trend-item negative">
                        <span class="trend-icon">📉</span>
                        <span class="trend-label" data-lang-key="losing">{{ __('menu.losing') }}</span>
                        <span class="trend-value" id="trends-losing">-</span>
                    </div>
                    <div class="trend-item neutral">
                        <span class="trend-icon">➡️</span>
                        <span class="trend-label" data-lang-key="stable">{{ __('menu.stable') }}</span>
                        <span class="trend-value" id="trends-stable">-</span>
                    </div>
                </div>
            </div>
        </div>


                {{-- Main DB-backed Charts --}}
                <div class="main-db-charts" style="margin-top: 2em;">
                    <div class="modern-title-bar">
                        <div class="m-portlet__head-title custom-modern">
                            <span class="modern-title-text">Market Overview Charts</span>
                        </div>
                    </div>

                    <div class="charts-grid">
                        <div class="chart-block" style="margin-bottom: 1.5em;">
                            <h4 style="margin-bottom: 0.5em;">Time Series Prices</h4>
                            <div style="position: relative; height: 360px;">
                                <canvas id="tsPricesChart"></canvas>
                            </div>
                        </div>

                        <div class="chart-row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5em;">
                            <div class="chart-block">
                                <h4 style="margin-bottom: 0.5em;">Market Dominance</h4>
                                <div style="position: relative; height: 320px;">
                                    <canvas id="marketDominanceChart"></canvas>
                                </div>
                            </div>
                            <div class="chart-block">
                                <h4 style="margin-bottom: 0.5em;">Top Volume Markets</h4>
                                <div style="position: relative; height: 320px;">
                                    <canvas id="topVolumeMarketsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


    </div>
</div>

<style>
    /* Ensure the main comparison section doesn't overflow on any device */
    .comparison-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2em;
        padding: 2em;
        margin: 2em 0;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.15);
        transform: translateZ(0);
        will-change: auto;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .comparison-section * {
        box-sizing: border-box;
    }

    /* Prevent horizontal scrolling on mobile */
    @media (max-width: 768px) {
        body {
            overflow-x: hidden;
        }
        
        .comparison-section {
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }
        
        .comparison-section > * {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }
    }

    /* Additional mobile constraints */
    @media (max-width: 480px) {
        .comparison-section {
            padding: 1.2em 0.8em;
        }
    }

    @media (max-width: 360px) {
        .comparison-section {
            padding: 1em 0.6em;
        }
    }

    @media (max-width: 320px) {
        .comparison-section {
            padding: 0.8em 0.4em;
        }
    }

    .coin-search-section {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 1.5em;
        padding: 1.5em;
        margin-bottom: 2em;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .search-container {
        display: flex;
        gap: 1em;
        align-items: center;
        margin-bottom: 1em;
        width: 100%;
        box-sizing: border-box;
    }

    .coin-search-input {
        flex: 1;
        padding: 0.8em 1.2em;
        border: 2px solid #667eea;
        border-radius: 1em;
        font-size: 1.1em;
        background: #fff;
        color: #333;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        min-width: 0;
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
    }

    .coin-search-input:focus {
        outline: none;
        border-color: #764ba2;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        white-space: nowrap;
        flex-shrink: 0;
        min-width: 80px;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .search-btn:active {
        transform: translateY(0);
    }

    /* ===== MOBILE-FIRST RESPONSIVE DESIGN ===== */
    
    /* Base mobile styles (default) */
    @media (max-width: 768px) {
        .comparison-section .coin-search-section {
            /* Inherit parent constraints */
            width: 100%;
            max-width: 100%;
            margin: 0 0 1.5em 0;
            padding: 1em;
            border-radius: 1em;
            box-sizing: border-box;
            /* Prevent horizontal overflow */
            overflow: hidden;
            /* Ensure proper sizing */
            min-width: 0;
        }

        .comparison-section .search-container {
            flex-direction: column;
            gap: 0.8em;
            align-items: stretch;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .comparison-section .coin-search-input {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            padding: 0.9em 1em;
            font-size: 1rem;
            border-radius: 0.8em;
            border-width: 1.5px;
            box-sizing: border-box;
        }

        .comparison-section .search-btn {
            width: 100%;
            max-width: 100%;
            min-width: auto;
            padding: 0.9em 1em;
            font-size: 1rem;
            border-radius: 0.8em;
            box-sizing: border-box;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .comparison-section .coin-search-section {
            padding: 0.8em;
            border-radius: 0.8em;
            margin: 0 0 1.2em 0;
        }

        .comparison-section .search-container {
            gap: 0.6em;
        }

        .comparison-section .coin-search-input {
            padding: 0.8em 0.9em;
            font-size: 0.95rem;
            border-radius: 0.7em;
        }

        .comparison-section .search-btn {
            padding: 0.8em 0.9em;
            font-size: 0.95rem;
            border-radius: 0.7em;
        }
    }

    /* Extra small mobile devices */
    @media (max-width: 360px) {
        .comparison-section .coin-search-section {
            padding: 0.7em;
            border-radius: 0.7em;
            margin: 0 0 1em 0;
        }

        .comparison-section .search-container {
            gap: 0.5em;
        }

        .comparison-section .coin-search-input {
            padding: 0.7em 0.8em;
            font-size: 0.9rem;
            border-radius: 0.6em;
        }

        .comparison-section .search-btn {
            padding: 0.7em 0.8em;
            font-size: 0.9rem;
            border-radius: 0.6em;
        }
    }

    /* Very small mobile devices */
    @media (max-width: 320px) {
        .comparison-section .coin-search-section {
            padding: 0.6em;
            border-radius: 0.6em;
            margin: 0 0 0.8em 0;
        }

        .comparison-section .search-container {
            gap: 0.4em;
        }

        .comparison-section .coin-search-input {
            padding: 0.6em 0.7em;
            font-size: 0.85rem;
            border-radius: 0.5em;
        }

        .comparison-section .search-btn {
            padding: 0.6em 0.7em;
            font-size: 0.85rem;
            border-radius: 0.5em;
        }
    }

    /* ===== TABLET AND DESKTOP STYLES ===== */
    
    /* Tablet responsive adjustments */
    @media (min-width: 769px) and (max-width: 1024px) {
        .comparison-section .coin-search-section {
            padding: 1.2em;
            margin: 0 0 1.8em 0;
        }

        .comparison-section .search-container {
            gap: 0.8em;
        }

        .comparison-section .coin-search-input {
            padding: 0.7em 1em;
            font-size: 1rem;
        }

        .comparison-section .search-btn {
            padding: 0.7em 1.2em;
            font-size: 1rem;
        }
    }

    /* Large desktop screens */
    @media (min-width: 1200px) {
        .comparison-section .coin-search-section {
            padding: 2em;
            border-radius: 2em;
            margin: 0 0 2.5em 0;
        }

        .comparison-section .search-container {
            gap: 1.2em;
            flex-direction: row;
        }

        .comparison-section .coin-search-input {
            padding: 1em 1.5em;
            font-size: 1.2em;
            width: auto;
            flex: 1;
        }

        .comparison-section .search-btn {
            padding: 1em 2em;
            font-size: 1.2em;
            width: auto;
            min-width: 80px;
        }
    }

    /* ===== SPECIAL MOBILE CASES ===== */
    
    /* Landscape mobile orientation */
    @media (max-width: 768px) and (orientation: landscape) {
        .comparison-section .coin-search-section {
            padding: 0.8em 1em;
        }

        .comparison-section .search-container {
            flex-direction: row;
            gap: 0.6em;
        }

        .comparison-section .coin-search-input {
            flex: 1;
            min-width: 0;
        }

        .comparison-section .search-btn {
            width: auto;
            min-width: 80px;
            flex-shrink: 0;
        }
    }

    /* High DPI mobile devices */
    @media (-webkit-min-device-pixel-ratio: 2) and (max-width: 768px) {
        .comparison-section .coin-search-input {
            border-width: 1px;
        }

        .comparison-section .search-btn {
            border-width: 1px;
        }
    }

    /* ===== TOUCH AND INTERACTION IMPROVEMENTS ===== */
    
    /* Touch-friendly improvements for mobile */
    @media (max-width: 768px) {
        .comparison-section .coin-search-input {
            touch-action: manipulation;
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            /* Prevent zoom on iOS */
            font-size: 16px;
        }

        .comparison-section .search-btn {
            touch-action: manipulation;
            -webkit-appearance: none;
            appearance: none;
            min-height: 44px; /* Minimum touch target size */
            width: 100%;
            max-width: 100%;
        }

        .comparison-section .coin-search-input:focus {
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }
    }

    /* ===== ACCESSIBILITY AND FOCUS STATES ===== */
    
    /* Improve accessibility */
    .comparison-section .coin-search-input {
        position: relative;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .comparison-section .coin-search-input:focus {
        outline: none;
    }

    .comparison-section .search-btn:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* ===== UTILITY AND OVERFLOW PREVENTION ===== */
    
    /* Ensure proper text sizing */
    .comparison-section .coin-search-input {
        font-family: inherit;
        line-height: 1.5;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Prevent zoom on iOS */
    @media screen and (-webkit-min-device-pixel-ratio: 0) {
        .comparison-section .coin-search-input {
            font-size: 16px;
        }
    }

    /* Ensure the section doesn't overflow on any device */
    .comparison-section .coin-search-section {
        overflow: hidden;
        word-wrap: break-word;
        overflow-wrap: break-word;
        /* Inherit parent width constraints */
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* ===== MOBILE-SPECIFIC CONSTRAINTS ===== */
    
    /* Ensure coin-search-section fits within comparison-section */
    @media (max-width: 768px) {
        .comparison-section {
            /* Parent container constraints */
            width: calc(100% - 1em);
            max-width: calc(100% - 1em);
            margin: 1.5em 0.5em;
            padding: 1.5em;
            box-sizing: border-box;
            overflow: hidden;
        }

        .comparison-section .coin-search-section {
            /* Child container - inherit parent constraints */
            width: 100%;
            max-width: 100%;
            margin: 0 0 1.5em 0;
            padding: 1em;
            border-radius: 1em;
            box-sizing: border-box;
            overflow: hidden;
            /* Ensure it doesn't exceed parent */
            min-width: 0;
        }

        .comparison-section .search-container {
            /* Search container - inherit parent constraints */
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }

        .comparison-section .coin-search-input,
        .comparison-section .search-btn {
            /* Input and button - inherit parent constraints */
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }
    }

    /* Very small screen constraints */
    @media (max-width: 480px) {
        .comparison-section {
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
            margin: 1.2em 0.3em;
            padding: 1.2em;
        }

        .comparison-section .coin-search-section {
            padding: 0.8em;
        }
    }

    @media (max-width: 360px) {
        .comparison-section {
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
            margin: 1em 0.2em;
            padding: 1em;
        }

        .comparison-section .coin-search-section {
            padding: 0.7em;
        }
    }

    @media (max-width: 320px) {
        .comparison-section {
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
            margin: 0.8em 0.1em;
            padding: 0.8em;
        }

        .comparison-section .coin-search-section {
            padding: 0.6em;
        }
    }

    .coin-analysis-result {
        background: #f8f9fa;
        border-radius: 1em;
        padding: 1.5em;
        margin-top: 1em;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .coin-analysis-header {
        display: flex;
        align-items: center;
        gap: 1em;
        margin-bottom: 1em;
        padding-bottom: 1em;
        border-bottom: 2px solid #e9ecef;
        width: 100%;
        box-sizing: border-box;
    }

    .coin-analysis-header h3 {
        margin: 0;
        font-size: 1.5em;
        font-weight: 700;
        color: #333;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .coin-analysis-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5em;
        width: 100%;
        box-sizing: border-box;
    }

    .coin-analysis-card {
        background: #fff;
        border-radius: 1em;
        padding: 1.5em;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .coin-analysis-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .coin-analysis-card h4 {
        margin: 0 0 1em 0;
        font-size: 1.2em;
        font-weight: 700;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5em;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .coin-analysis-data {
        display: flex;
        flex-direction: column;
        gap: 0.8em;
        width: 100%;
        box-sizing: border-box;
    }

    .coin-analysis-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5em 0;
        border-bottom: 1px solid #eee;
        width: 100%;
        box-sizing: border-box;
        flex-wrap: wrap;
        gap: 0.5em;
    }

    .coin-analysis-item:last-child {
        border-bottom: none;
    }

    .coin-analysis-label {
        font-weight: 600;
        color: #666;
        flex: 1;
        min-width: 0;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .coin-analysis-value {
        font-weight: 700;
        color: #333;
        text-align: right;
        flex-shrink: 0;
        word-wrap: break-word;
        overflow-wrap: break-word;
        max-width: 50%;
    }

    .coin-analysis-value.positive {
        color: #28a745;
    }

    .coin-analysis-value.negative {
        color: #dc3545;
    }

    /* ===== MOBILE-FIRST RESPONSIVE DESIGN ===== */
    
    /* Base mobile styles (default) */
    .coin-analysis-result {
        padding: 1em;
        border-radius: 0.8em;
        margin: 0.8em 0.5em;
        width: calc(100% - 1em);
        max-width: calc(100% - 1em);
        box-sizing: border-box;
    }

    .coin-analysis-header {
        flex-direction: column;
        align-items: center;
        gap: 0.8em;
        padding-bottom: 0.8em;
        margin-bottom: 0.8em;
        text-align: center;
    }

    .coin-analysis-header h3 {
        font-size: 1.3em;
        text-align: center;
        width: 100%;
    }

    .coin-analysis-grid {
        display: flex;
        flex-direction: column;
        gap: 1em;
        width: 100%;
        max-width: 100%;
    }

    .coin-analysis-card {
        padding: 1em;
        border-radius: 0.8em;
        width: 100%;
        max-width: 100%;
        margin: 0;
        box-sizing: border-box;
        /* Ensure card doesn't exceed parent width */
        min-width: 0;
        overflow: hidden;
    }

    .coin-analysis-card h4 {
        font-size: 1.1em;
        margin-bottom: 0.8em;
        text-align: center;
        justify-content: center;
    }

    .coin-analysis-data {
        gap: 0.6em;
        width: 100%;
        max-width: 100%;
    }

    .coin-analysis-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.3em;
        padding: 0.6em 0;
        text-align: left;
        width: 100%;
        max-width: 100%;
    }

    .coin-analysis-label {
        font-size: 0.9rem;
        color: #555;
        font-weight: 600;
        width: 100%;
        text-align: left;
        max-width: 100%;
    }

    .coin-analysis-value {
        font-size: 1rem;
        text-align: left;
        width: 100%;
        max-width: 100%;
        font-weight: 700;
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .coin-analysis-result {
            padding: 0.8em;
            border-radius: 0.7em;
            margin: 0.6em 0.3em;
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
        }

        .coin-analysis-header {
            gap: 0.6em;
            padding-bottom: 0.6em;
            margin-bottom: 0.6em;
        }

        .coin-analysis-header h3 {
            font-size: 1.2em;
        }

        .coin-analysis-grid {
            gap: 0.8em;
        }

        .coin-analysis-card {
            padding: 0.8em;
            border-radius: 0.7em;
        }

        .coin-analysis-card h4 {
            font-size: 1rem;
            margin-bottom: 0.6em;
        }

        .coin-analysis-data {
            gap: 0.5em;
        }

        .coin-analysis-item {
            gap: 0.2em;
            padding: 0.5em 0;
        }

        .coin-analysis-label {
            font-size: 0.85rem;
        }

        .coin-analysis-value {
            font-size: 0.95rem;
        }
    }

    /* Extra small mobile devices */
    @media (max-width: 360px) {
        .coin-analysis-result {
            padding: 0.7em;
            border-radius: 0.6em;
            margin: 0.5em 0.2em;
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
        }

        .coin-analysis-header {
            gap: 0.5em;
            padding-bottom: 0.5em;
            margin-bottom: 0.5em;
        }

        .coin-analysis-header h3 {
            font-size: 1.1em;
        }

        .coin-analysis-grid {
            gap: 0.7em;
        }

        .coin-analysis-card {
            padding: 0.7em;
            border-radius: 0.6em;
        }

        .coin-analysis-card h4 {
            font-size: 0.95rem;
            margin-bottom: 0.5em;
        }

        .coin-analysis-data {
            gap: 0.4em;
        }

        .coin-analysis-item {
            gap: 0.2em;
            padding: 0.4em 0;
        }

        .coin-analysis-label {
            font-size: 0.8rem;
        }

        .coin-analysis-value {
            font-size: 0.9rem;
        }
    }

    /* Very small mobile devices */
    @media (max-width: 320px) {
        .coin-analysis-result {
            padding: 0.6em;
            border-radius: 0.5em;
            margin: 0.4em 0.1em;
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
        }

        .coin-analysis-header {
            gap: 0.4em;
            padding-bottom: 0.4em;
            margin-bottom: 0.4em;
        }

        .coin-analysis-header h3 {
            font-size: 1rem;
        }

        .coin-analysis-grid {
            gap: 0.6em;
        }

        .coin-analysis-card {
            padding: 0.6em;
            border-radius: 0.5em;
        }

        .coin-analysis-card h4 {
            font-size: 0.9rem;
            margin-bottom: 0.4em;
        }

        .coin-analysis-data {
            gap: 0.3em;
        }

        .coin-analysis-item {
            gap: 0.1em;
            padding: 0.3em 0;
        }

        .coin-analysis-label {
            font-size: 0.75rem;
        }

        .coin-analysis-value {
            font-size: 0.85rem;
        }
    }

    /* ===== TABLET AND DESKTOP STYLES ===== */
    
    /* Tablet responsive adjustments */
    @media (min-width: 769px) {
        .coin-analysis-result {
            padding: 1.5em;
            border-radius: 1em;
            margin: 1em 0;
            width: 100%;
            max-width: 100%;
        }

        .coin-analysis-header {
            flex-direction: row;
            align-items: center;
            gap: 1em;
            padding-bottom: 1em;
            margin-bottom: 1em;
            text-align: left;
        }

        .coin-analysis-header h3 {
            font-size: 1.5em;
            text-align: left;
        }

        .coin-analysis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5em;
        }

        .coin-analysis-card {
            padding: 1.5em;
            border-radius: 1em;
        }

        .coin-analysis-card h4 {
            font-size: 1.2em;
            margin-bottom: 1em;
            text-align: left;
            justify-content: flex-start;
        }

        .coin-analysis-data {
            gap: 0.8em;
        }

        .coin-analysis-item {
            flex-direction: row;
            align-items: center;
            gap: 0.5em;
            padding: 0.5em 0;
            text-align: left;
        }

        .coin-analysis-label {
            font-size: 1rem;
            color: #666;
            text-align: left;
            max-width: 50%;
        }

        .coin-analysis-value {
            font-size: 1rem;
            text-align: right;
            max-width: 50%;
        }
    }

    /* Large tablet and small desktop */
    @media (min-width: 1025px) {
        .coin-analysis-grid {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2em;
        }

        .coin-analysis-card {
            padding: 2em;
            border-radius: 1.2em;
        }

        .coin-analysis-header h3 {
            font-size: 1.6em;
        }

        .coin-analysis-card h4 {
            font-size: 1.3em;
        }
    }

    /* Large desktop screens */
    @media (min-width: 1200px) {
        .coin-analysis-result {
            padding: 2em;
            border-radius: 1.5em;
        }

        .coin-analysis-grid {
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2em;
        }

        .coin-analysis-card {
            padding: 2em;
            border-radius: 1.5em;
        }

        .coin-analysis-header h3 {
            font-size: 1.7em;
        }

        .coin-analysis-card h4 {
            font-size: 1.4em;
        }

        .coin-analysis-data {
            gap: 1em;
        }

        .coin-analysis-item {
            padding: 0.7em 0;
        }
    }

    /* ===== SPECIAL MOBILE CASES ===== */
    
    /* Landscape mobile orientation */
    @media (max-width: 768px) and (orientation: landscape) {
        .coin-analysis-result {
            padding: 0.8em 1em;
        }

        .coin-analysis-grid {
            gap: 0.8em;
        }

        .coin-analysis-card {
            padding: 0.8em;
        }
    }

    /* High DPI mobile devices */
    @media (-webkit-min-device-pixel-ratio: 2) and (max-width: 768px) {
        .coin-analysis-card {
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
    }

    /* Dark mode support for mobile */
    @media (prefers-color-scheme: dark) and (max-width: 768px) {
        .coin-analysis-result {
            background: rgba(30, 30, 30, 0.95);
            color: #fff;
        }

        .coin-analysis-card {
            background: #2a2a2a;
            color: #fff;
        }

        .coin-analysis-header h3,
        .coin-analysis-card h4 {
            color: #fff;
        }

        .coin-analysis-label {
            color: #ccc;
        }

        .coin-analysis-value {
            color: #fff;
        }

        .coin-analysis-item {
            border-bottom-color: #444;
        }
    }

    /* ===== ACCESSIBILITY AND INTERACTION ===== */
    
    /* Focus states for mobile accessibility */
    @media (max-width: 768px) {
        .coin-analysis-card:focus-within {
            outline: 2px solid #667eea;
            outline-offset: 2px;
            transform: scale(1.01);
        }
    }

    /* Loading states for mobile */
    @media (max-width: 768px) {
        .coin-analysis-result.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .coin-analysis-result.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #667eea;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
    }

    /* Touch-friendly improvements */
    @media (max-width: 768px) {
        .coin-analysis-card {
            touch-action: manipulation;
            -webkit-user-select: none;
            user-select: none;
            /* Ensure proper touch targets */
            min-height: 44px;
        }

        .coin-analysis-item {
            touch-action: manipulation;
            min-height: 44px;
        }
    }

    /* ===== UTILITY CLASSES ===== */
    
    /* Ensure proper text wrapping and overflow handling */
    .coin-analysis-result,
    .coin-analysis-card,
    .coin-analysis-header,
    .coin-analysis-grid,
    .coin-analysis-data,
    .coin-analysis-item {
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }

    /* Improve accessibility */
    .coin-analysis-card {
        position: relative;
    }

    .coin-analysis-card:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* ===== MOBILE-SPECIFIC CONSTRAINTS ===== */
    
    /* Ensure cards are properly constrained within comparison-section */
    @media (max-width: 768px) {
        .comparison-section .coin-analysis-result {
            /* Inherit parent constraints */
            width: 100%;
            max-width: 100%;
            margin: 0.8em 0.5em;
            box-sizing: border-box;
        }

        .comparison-section .coin-analysis-grid {
            /* Single column layout on mobile */
            display: flex;
            flex-direction: column;
            gap: 1em;
            width: 100%;
            max-width: 100%;
        }

        .comparison-section .coin-analysis-card {
            /* Full width within parent, but with proper margins */
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 1em;
            box-sizing: border-box;
            /* Prevent horizontal overflow */
            overflow: hidden;
            /* Ensure proper sizing */
            min-width: 0;
        }
    }

    /* Very small screen constraints */
    @media (max-width: 480px) {
        .comparison-section .coin-analysis-result {
            margin: 0.6em 0.3em;
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
        }

        .comparison-section .coin-analysis-card {
            padding: 0.8em;
        }
    }

    @media (max-width: 360px) {
        .comparison-section .coin-analysis-result {
            margin: 0.5em 0.2em;
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
        }

        .comparison-section .coin-analysis-card {
            padding: 0.7em;
        }
    }

    @media (max-width: 320px) {
        .comparison-section .coin-analysis-result {
            margin: 0.4em 0.1em;
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
        }

        .comparison-section .coin-analysis-card {
            padding: 0.6em;
        }
    }

    .platform-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5em;
        margin-bottom: 2em;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .platform-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 1.5em;
        padding: 1.5em;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
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
        width: 100%;
        box-sizing: border-box;
    }

    .platform-header h3 {
        margin: 0;
        font-size: 1.3em;
        font-weight: 700;
        color: #333;
        word-wrap: break-word;
        overflow-wrap: break-word;
        flex: 1;
        min-width: 0;
    }

    .platform-icon {
        font-size: 2em;
        flex-shrink: 0;
        margin-left: 0.5em;
    }

    .platform-stats {
        display: flex;
        flex-direction: column;
        gap: 0.8em;
        width: 100%;
        box-sizing: border-box;
    }

    .stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5em 0;
        border-bottom: 1px solid #eee;
        width: 100%;
        box-sizing: border-box;
    }

    .stat:last-child {
        border-bottom: none;
    }

    .stat-label {
        font-weight: 600;
        color: #666;
        flex: 1;
        min-width: 0;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .stat-value {
        font-weight: 700;
        color: #333;
        flex-shrink: 0;
        margin-left: 0.5em;
        word-wrap: break-word;
        overflow-wrap: break-word;
        text-align: right;
    }

    /* Mobile responsive styles for platform overview */
    @media (max-width: 768px) {
        .platform-overview {
            grid-template-columns: 1fr;
            gap: 1em;
            margin: 1em 0.5em;
            width: calc(100% - 1em);
            max-width: calc(100% - 1em);
        }

        .platform-card {
            padding: 1em;
            margin-bottom: 0.8em;
            border-radius: 1.2em;
        }

        .platform-header {
            margin-bottom: 0.8em;
        }

        .platform-header h3 {
            font-size: 1.2em;
        }

        .platform-icon {
            font-size: 1.6em;
        }

        .platform-stats {
            gap: 0.6em;
        }

        .stat {
            padding: 0.4em 0;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .platform-overview {
            margin: 0.8em 0.3em;
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
            gap: 0.8em;
        }

        .platform-card {
            padding: 0.8em;
            margin-bottom: 0.6em;
            border-radius: 1em;
        }

        .platform-header h3 {
            font-size: 1.1em;
        }

        .platform-icon {
            font-size: 1.4em;
        }

        .stat-label {
            font-size: 0.9rem;
        }

        .stat-value {
            font-size: 0.9rem;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .platform-overview {
            margin: 0.6em 0.2em;
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
            gap: 0.6em;
        }

        .platform-card {
            padding: 0.7em;
            margin-bottom: 0.5em;
            border-radius: 0.8em;
        }

        .platform-header h3 {
            font-size: 1rem;
        }

        .platform-icon {
            font-size: 1.2em;
        }

        .stat-label {
            font-size: 0.85rem;
        }

        .stat-value {
            font-size: 0.85rem;
        }
    }

    /* Very small devices */
    @media (max-width: 320px) {
        .platform-overview {
            margin: 0.5em 0.1em;
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
            gap: 0.5em;
        }

        .platform-card {
            padding: 0.6em;
            margin-bottom: 0.4em;
            border-radius: 0.7em;
        }

        .platform-header h3 {
            font-size: 0.95rem;
        }

        .platform-icon {
            font-size: 1.1em;
        }

        .stat-label {
            font-size: 0.8rem;
        }

        .stat-value {
            font-size: 0.8rem;
        }
    }

    /* Tablet responsive adjustments */
    @media (min-width: 769px) and (max-width: 1024px) {
        .platform-overview {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.2em;
        }

        .platform-card {
            padding: 1.2em;
        }
    }

    /* Large desktop screens */
    @media (min-width: 1200px) {
        .platform-overview {
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2em;
        }

        .platform-card {
            padding: 2em;
        }
    }

    .chart-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5em;
        margin-bottom: 2em;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 1.5em;
        padding: 1.5em;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        min-height: 350px;
        display: flex;
        flex-direction: column;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .chart-card.full-width {
        grid-column: 1 / -1;
        min-height: auto;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .chart-card h4 {
        margin: 0 0 1em 0;
        font-size: 1.2em;
        font-weight: 700;
        color: #333;
        text-align: center;
        flex-shrink: 0;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .chart-container {
        width: 100% !important;
        height: 280px !important;
        position: relative;
        overflow: hidden;
        flex: 1;
        min-height: 280px;
        max-height: 280px;
        box-sizing: border-box;
    }

    .chart-container canvas {
        max-width: 100% !important;
        max-height: 100% !important;
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
        box-sizing: border-box;
    }

    /* Mobile-specific chart adjustments */
    @media (max-width: 768px) {
        .chart-grid {
            grid-template-columns: 1fr;
            gap: 1em;
            margin: 1em 0.5em;
            width: calc(100% - 1em);
            max-width: calc(100% - 1em);
            box-sizing: border-box;
        }

        .chart-card {
            padding: 1em;
            min-height: 300px;
            margin-bottom: 1em;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }

        .chart-card.full-width {
            width: 100%;
            max-width: 100%;
            margin: 0 0 1em 0;
            box-sizing: border-box;
        }

        .chart-container {
            height: 250px !important;
            min-height: 250px;
            max-height: 250px;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box;
        }

        .chart-card h4 {
            font-size: 1.1em;
            margin-bottom: 0.8em;
            padding: 0 0.5em;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .chart-grid {
            margin: 0.8em 0.3em;
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
            gap: 0.8em;
        }

        .chart-card {
            padding: 0.8em;
            min-height: 280px;
            margin-bottom: 0.8em;
            border-radius: 1.2em;
        }

        .chart-container {
            height: 220px !important;
            min-height: 220px;
            max-height: 220px;
        }

        .chart-card h4 {
            font-size: 1em;
            margin-bottom: 0.6em;
            padding: 0 0.3em;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .chart-grid {
            margin: 0.6em 0.2em;
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
            gap: 0.6em;
        }

        .chart-card {
            padding: 0.7em;
            min-height: 260px;
            margin-bottom: 0.6em;
            border-radius: 1em;
        }

        .chart-container {
            height: 200px !important;
            min-height: 200px;
            max-height: 200px;
        }

        .chart-card h4 {
            font-size: 0.95rem;
            margin-bottom: 0.5em;
            padding: 0 0.2em;
        }
    }

    /* Very small devices */
    @media (max-width: 320px) {
        .chart-grid {
            margin: 0.5em 0.1em;
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
            gap: 0.5em;
        }

        .chart-card {
            padding: 0.6em;
            min-height: 240px;
            margin-bottom: 0.5em;
            border-radius: 0.8em;
        }

        .chart-container {
            height: 180px !important;
            min-height: 180px;
            max-height: 180px;
        }

        .chart-card h4 {
            font-size: 0.9rem;
            margin-bottom: 0.4em;
            padding: 0 0.1em;
        }
    }

    /* Touch-friendly improvements for mobile */
    @media (max-width: 768px) {
        .chart-container {
            touch-action: pan-x pan-y;
            -webkit-overflow-scrolling: touch;
        }

        .chart-card {
            touch-action: manipulation;
        }
    }

    /* Ensure charts don't overflow on any device */
    .chart-container {
        overflow: hidden !important;
        position: relative !important;
        box-sizing: border-box !important;
    }

    /* Better chart responsiveness */
    .chart-container canvas {
        touch-action: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        box-sizing: border-box !important;
    }

    /* Improve chart grid layout on different screen sizes */
    @media (min-width: 1200px) {
        .chart-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 768px) and (max-width: 1199px) {
        .chart-grid {
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        }
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

    /* Mobile-responsive table styles */
    @media (max-width: 768px) {
        .top-performers-table {
            overflow-x: visible;
        }

        .top-performers-table table {
            display: block;
            width: 100%;
        }

        .top-performers-table thead {
            display: none;
        }

        .top-performers-table tbody {
            display: block;
            width: 100%;
        }

        .top-performers-table tr {
            display: block;
            width: 100%;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            position: relative;
        }

        .top-performers-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border: none;
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
            position: relative;
        }

        .top-performers-table td:last-child {
            border-bottom: none;
        }

        .top-performers-table td:before {
            content: attr(data-label);
            font-weight: 700;
            color: #666;
            min-width: 80px;
            margin-right: 1rem;
            font-size: 0.9rem;
        }

        /* Special styling for rank column */
        .top-performers-table td[data-label="Rank"] {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
            background: linear-gradient(135deg, #ffd200 0%, #43cea2 100%);
            margin: -1rem -1rem 0.5rem -1rem;
            padding: 0.75rem 1rem;
            border-radius: 12px 12px 0 0;
            border-bottom: 2px solid #e9ecef;
        }

        .top-performers-table td[data-label="Rank"]:before {
            display: none;
        }

        /* Special styling for symbol */
        .top-performers-table td[data-label="Symbol"] {
            font-weight: 700;
            color: #667eea;
        }

        /* Special styling for market cap */
        .top-performers-table td[data-label="Market Cap"] {
            font-weight: 600;
            color: #28a745;
        }

        /* Special styling for price */
        .top-performers-table td[data-label="Price"] {
            font-weight: 600;
            color: #333;
        }

        /* Special styling for 24h change */
        .top-performers-table td[data-label="24h Change"] {
            font-weight: 700;
        }

        .top-performers-table td[data-label="24h Change"].positive {
            color: #28a745;
        }

        .top-performers-table td[data-label="24h Change"].negative {
            color: #dc3545;
        }

        .top-performers-table td[data-label="24h Change"].neutral {
            color: #6c757d;
        }
    }

    /* Tablet responsive adjustments */
    @media (min-width: 769px) and (max-width: 1024px) {
        .top-performers-table {
            overflow-x: auto;
        }

        .top-performers-table th,
        .top-performers-table td {
            padding: 0.6em;
            font-size: 0.9rem;
        }
    }

    /* Additional mobile improvements */
    @media (max-width: 480px) {
        .top-performers-table tr {
            margin-bottom: 0.8rem;
            padding: 0.8rem;
        }

        .top-performers-table td {
            padding: 0.4rem 0;
            font-size: 0.9rem;
        }

        .top-performers-table td:before {
            font-size: 0.8rem;
            min-width: 70px;
        }

        .top-performers-table td[data-label="Rank"] {
            font-size: 1rem;
            padding: 0.6rem 0.8rem;
        }
    }

    /* Touch-friendly improvements */
    @media (max-width: 768px) {
        .top-performers-table tr {
            touch-action: manipulation;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .top-performers-table tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .top-performers-table tr:active {
            transform: translateY(0);
        }
    }

    .trends-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5em;
        margin-top: 1em;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .trend-item {
        display: flex;
        align-items: center;
        gap: 1em;
        padding: 1.2em;
        border-radius: 1em;
        background: #f8f9fa;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .trend-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
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
        font-size: 1.8em;
        flex-shrink: 0;
    }

    .trend-label {
        font-weight: 600;
        color: #333;
        flex: 1;
        font-size: 1rem;
        word-wrap: break-word;
        overflow-wrap: break-word;
        min-width: 0;
    }

    .trend-value {
        font-weight: 700;
        font-size: 1.3em;
        color: #333;
        flex-shrink: 0;
        min-width: 60px;
        text-align: right;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    /* Mobile responsive styles for trends summary */
    @media (max-width: 768px) {
        .trends-summary {
            grid-template-columns: 1fr;
            gap: 1em;
            margin-top: 0.8em;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .trend-item {
            padding: 1em;
            gap: 0.8em;
            border-radius: 0.8em;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .trend-icon {
            font-size: 1.5em;
        }

        .trend-label {
            font-size: 0.95rem;
            flex: 1;
            min-width: 0;
        }

        .trend-value {
            font-size: 1.1em;
            min-width: 50px;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .trends-summary {
            gap: 0.8em;
            margin: 0.6em 0.3em;
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
        }

        .trend-item {
            padding: 0.8em;
            gap: 0.6em;
            flex-wrap: wrap;
            margin-bottom: 0.5em;
        }

        .trend-icon {
            font-size: 1.3em;
        }

        .trend-label {
            font-size: 0.9rem;
            flex: 1;
            min-width: 0;
        }

        .trend-value {
            font-size: 1rem;
            min-width: 40px;
            text-align: right;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .trends-summary {
            margin: 0.5em 0.2em;
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
            gap: 0.6em;
        }

        .trend-item {
            padding: 0.7em;
            gap: 0.5em;
            margin-bottom: 0.4em;
        }

        .trend-icon {
            font-size: 1.2em;
        }

        .trend-label {
            font-size: 0.85rem;
        }

        .trend-value {
            font-size: 0.95rem;
            min-width: 35px;
        }
    }

    /* Very small devices */
    @media (max-width: 320px) {
        .trends-summary {
            margin: 0.4em 0.1em;
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
            gap: 0.5em;
        }

        .trend-item {
            padding: 0.6em;
            gap: 0.4em;
            margin-bottom: 0.3em;
        }

        .trend-icon {
            font-size: 1.1em;
        }

        .trend-label {
            font-size: 0.8rem;
        }

        .trend-value {
            font-size: 0.9rem;
            min-width: 30px;
        }
    }

    /* Tablet responsive adjustments */
    @media (min-width: 769px) and (max-width: 1024px) {
        .trends-summary {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.2em;
            width: 100%;
            max-width: 100%;
        }

        .trend-item {
            padding: 1em;
            width: 100%;
            max-width: 100%;
        }

        .trend-icon {
            font-size: 1.6em;
        }

        .trend-label {
            font-size: 0.95rem;
        }

        .trend-value {
            font-size: 1.2em;
        }
    }

    /* Large desktop screens */
    @media (min-width: 1200px) {
        .trends-summary {
            grid-template-columns: repeat(3, 1fr);
            gap: 2em;
            width: 100%;
            max-width: 100%;
        }

        .trend-item {
            padding: 1.5em;
            width: 100%;
            max-width: 100%;
        }

        .trend-icon {
            font-size: 2em;
        }

        .trend-label {
            font-size: 1.1rem;
        }

        .trend-value {
            font-size: 1.4em;
        }
    }

    /* Touch-friendly improvements for mobile */
    @media (max-width: 768px) {
        .trend-item {
            touch-action: manipulation;
            cursor: pointer;
            user-select: none;
        }

        .trend-item:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    }

    /* Ensure proper text wrapping and overflow handling */
    .trend-item {
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }

    .trend-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Improve accessibility */
    .trend-item {
        position: relative;
    }

    .trend-item:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
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

    /* Loader spinner styles */
    .loader-spinner {
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .stat-value {
        min-height: 20px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .chart-container {
        width: 100% !important;
        height: 280px !important;
        position: relative;
        overflow: hidden;
    }

    .chart-container canvas {
        max-width: 100% !important;
        height: auto !important;
    }

    .chart-container.full-width {
        height: 350px !important;
    }

    .platform-performance-table {
        margin-top: 1em;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .platform-performance-table .table {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 1em;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .platform-performance-table .table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1em;
        font-weight: 600;
        text-align: center;
        word-wrap: break-word;
        overflow-wrap: break-word;
        font-size: 0.9rem;
    }

    .platform-performance-table .table tbody td {
        padding: 1em;
        border-bottom: 1px solid #eee;
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word;
        overflow-wrap: break-word;
        font-size: 0.9rem;
    }

    .platform-performance-table .table tbody tr:last-child td {
        border-bottom: none;
    }

    .platform-performance-table .table tbody tr:hover {
        background: rgba(102, 126, 234, 0.1);
    }

    /* Mobile responsive styles for platform performance table */
    @media (max-width: 768px) {
        .platform-performance-table {
            margin: 0.8em 0.5em;
            width: calc(100% - 1em);
            max-width: calc(100% - 1em);
        }

        .platform-performance-table .table {
            border-radius: 0.8em;
            font-size: 0.85rem;
        }

        .platform-performance-table .table thead {
            display: none; /* Hide headers on mobile */
        }

        .platform-performance-table .table tbody {
            display: block;
            width: 100%;
        }

        .platform-performance-table .table tbody tr {
            display: block;
            width: 100%;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            position: relative;
        }

        .platform-performance-table .table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border: none;
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
            position: relative;
            font-size: 0.9rem;
        }

        .platform-performance-table .table tbody td:last-child {
            border-bottom: none;
        }

        .platform-performance-table .table tbody td:before {
            content: attr(data-label);
            font-weight: 700;
            color: #666;
            min-width: 100px;
            margin-right: 1rem;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        /* Special styling for platform name */
        .platform-performance-table .table tbody td[data-label="Platform"] {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: -1rem -1rem 0.5rem -1rem;
            padding: 0.75rem 1rem;
            border-radius: 12px 12px 0 0;
            border-bottom: 2px solid #e9ecef;
        }

        .platform-performance-table .table tbody td[data-label="Platform"]:before {
            display: none;
        }

        /* Special styling for gaining coins */
        .platform-performance-table .table tbody td[data-label="Gaining Coins"] {
            font-weight: 600;
            color: #28a745;
        }

        /* Special styling for losing coins */
        .platform-performance-table .table tbody td[data-label="Losing Coins"] {
            font-weight: 600;
            color: #dc3545;
        }

        /* Special styling for market cap and volume */
        .platform-performance-table .table tbody td[data-label="Total Market Cap"],
        .platform-performance-table .table tbody td[data-label="Total Volume"] {
            font-weight: 600;
            color: #667eea;
        }

        /* Special styling for total coins */
        .platform-performance-table .table tbody td[data-label="Total Coins"] {
            font-weight: 600;
            color: #333;
        }

        /* Special styling for last updated */
        .platform-performance-table .table tbody td[data-label="Last Updated"] {
            font-weight: 500;
            color: #666;
            font-size: 0.8rem;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .platform-performance-table {
            margin: 0.6em 0.3em;
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
        }

        .platform-performance-table .table tbody tr {
            margin-bottom: 0.8rem;
            padding: 0.8rem;
        }

        .platform-performance-table .table tbody td {
            padding: 0.4rem 0;
            font-size: 0.85rem;
        }

        .platform-performance-table .table tbody td:before {
            font-size: 0.8rem;
            min-width: 90px;
        }

        .platform-performance-table .table tbody td[data-label="Platform"] {
            font-size: 1rem;
            padding: 0.6rem 0.8rem;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .platform-performance-table {
            margin: 0.5em 0.2em;
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
        }

        .platform-performance-table .table tbody tr {
            margin-bottom: 0.6rem;
            padding: 0.6rem;
        }

        .platform-performance-table .table tbody td {
            padding: 0.3rem 0;
            font-size: 0.8rem;
        }

        .platform-performance-table .table tbody td:before {
            font-size: 0.75rem;
            min-width: 80px;
        }

        .platform-performance-table .table tbody td[data-label="Platform"] {
            font-size: 0.95rem;
            padding: 0.5rem 0.6rem;
        }
    }

    /* Very small devices */
    @media (max-width: 320px) {
        .platform-performance-table {
            margin: 0.4em 0.1em;
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
        }

        .platform-performance-table .table tbody tr {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
        }

        .platform-performance-table .table tbody td {
            padding: 0.25rem 0;
            font-size: 0.75rem;
        }

        .platform-performance-table .table tbody td:before {
            font-size: 0.7rem;
            min-width: 70px;
        }

        .platform-performance-table .table tbody td[data-label="Platform"] {
            font-size: 0.9rem;
            padding: 0.4rem 0.5rem;
        }
    }

    /* Tablet responsive adjustments */
    @media (min-width: 769px) and (max-width: 1024px) {
        .platform-performance-table .table thead th,
        .platform-performance-table .table tbody td {
            padding: 0.8em;
            font-size: 0.85rem;
        }
    }

    /* Large desktop screens */
    @media (min-width: 1200px) {
        .platform-performance-table .table thead th,
        .platform-performance-table .table tbody td {
            padding: 1.2em;
            font-size: 1rem;
        }
    }

    .text-success {
        color: #28a745 !important;
        font-weight: 600;
    }

    .text-danger {
        color: #dc3545 !important;
        font-weight: 600;
    }

    .top-performers-table {
        margin-top: 1em;
    }

    /* Enhanced table styling for better visual hierarchy */
    .platform-performance-table .table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
    }

    /* Desktop table enhancements */
    @media (min-width: 769px) {
        .platform-performance-table .table tbody tr {
            transition: all 0.2s ease;
        }

        .platform-performance-table .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .platform-performance-table .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }
    }

    /* Touch-friendly improvements for mobile */
    @media (max-width: 768px) {
        .platform-performance-table .table tbody tr {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .platform-performance-table .table tbody tr:active {
            transform: scale(0.98);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        /* Improve touch targets */
        .platform-performance-table .table tbody td {
            min-height: 44px;
            display: flex;
            align-items: center;
        }
    }

    /* ======================== ENHANCED LOADING INTERFACE ======================== */
    
    .enhanced-loading {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2em;
        padding: 3em 2em;
        margin: 2em 0;
        text-align: center;
        color: white;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.15);
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .loading-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .loading-header {
        margin-bottom: 2em;
    }

    .loading-spinner {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5em;
    }

    .spinner-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 4px solid transparent;
        border-top: 4px solid rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        animation: spin 1.5s linear infinite;
    }

    .spinner-ring:nth-child(2) {
        width: 70%;
        height: 70%;
        top: 15%;
        left: 15%;
        border-top-color: rgba(255, 255, 255, 0.6);
        animation-delay: 0.5s;
    }

    .spinner-ring:nth-child(3) {
        width: 60%;
        height: 60%;
        top: 20%;
        left: 20%;
        border-top-color: rgba(255, 255, 255, 0.4);
        animation-delay: 1s;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-title {
        font-size: 2.5em;
        font-weight: 800;
        margin: 0 0 0.5em 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .loading-subtitle {
        font-size: 1.2em;
        margin: 0;
        opacity: 0.9;
        font-weight: 400;
    }

    .loading-progress {
        margin: 2em 0;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 1em;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #ffd200, #43cea2);
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 4px;
    }

    .progress-text {
        font-size: 1.1em;
        font-weight: 600;
        opacity: 0.9;
    }

    .loading-sources {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1em;
        margin: 2em 0;
    }

    .source-item {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 1em;
        padding: 1.2em;
        display: flex;
        align-items: center;
        gap: 1em;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .source-item.loading {
        background: rgba(255, 193, 7, 0.2);
        border-color: rgba(255, 193, 7, 0.4);
    }

    .source-item.success {
        background: rgba(40, 167, 69, 0.2);
        border-color: rgba(40, 167, 69, 0.4);
    }

    .source-item.error {
        background: rgba(220, 53, 69, 0.2);
        border-color: rgba(220, 53, 69, 0.4);
    }

    .source-icon {
        font-size: 2em;
        flex-shrink: 0;
    }

    .source-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        flex: 1;
    }

    .source-name {
        font-weight: 700;
        font-size: 1.1em;
        margin-bottom: 0.3em;
    }

    .source-status {
        font-size: 0.9em;
        opacity: 0.8;
        font-weight: 500;
    }

    .loading-tips {
        margin-top: 2em;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1em;
    }

    .tip-item {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 1em;
        padding: 1em;
        display: flex;
        align-items: center;
        gap: 0.8em;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .tip-icon {
        font-size: 1.5em;
        flex-shrink: 0;
    }

    .tip-text {
        font-size: 0.95em;
        opacity: 0.9;
        text-align: left;
    }

    /* Mobile responsive styles for loading interface */
    @media (max-width: 768px) {
        .enhanced-loading {
            padding: 2em 1em;
            border-radius: 1.5em;
            margin: 1.5em 0.5em;
            width: calc(100% - 1em);
            max-width: calc(100% - 1em);
        }

        .loading-title {
            font-size: 2em;
        }

        .loading-subtitle {
            font-size: 1.1em;
        }

        .loading-sources {
            grid-template-columns: 1fr;
            gap: 0.8em;
        }

        .source-item {
            padding: 1em;
        }

        .loading-tips {
            grid-template-columns: 1fr;
            gap: 0.8em;
        }

        .tip-item {
            padding: 0.8em;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .enhanced-loading {
            padding: 1.5em 0.8em;
            border-radius: 1.2em;
            margin: 1.2em 0.3em;
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
        }

        .loading-title {
            font-size: 1.8em;
        }

        .loading-subtitle {
            font-size: 1em;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
        }

        .source-item {
            padding: 0.8em;
        }

        .source-icon {
            font-size: 1.6em;
        }

        .source-name {
            font-size: 1em;
        }

        .source-status {
            font-size: 0.85em;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .enhanced-loading {
            padding: 1.2em 0.6em;
            border-radius: 1em;
            margin: 1em 0.2em;
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
        }

        .loading-title {
            font-size: 1.6em;
        }

        .loading-subtitle {
            font-size: 0.95em;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
        }

        .source-item {
            padding: 0.7em;
        }

        .source-icon {
            font-size: 1.4em;
        }

        .tip-item {
            padding: 0.7em;
        }

        .tip-text {
            font-size: 0.9em;
        }
    }

    /* Very small devices */
    @media (max-width: 320px) {
        .enhanced-loading {
            padding: 1em 0.5em;
            border-radius: 0.8em;
            margin: 0.8em 0.1em;
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
        }

        .loading-title {
            font-size: 1.4em;
        }

        .loading-subtitle {
            font-size: 0.9em;
        }

        .loading-spinner {
            width: 45px;
            height: 45px;
        }

        .source-item {
            padding: 0.6em;
        }

        .source-icon {
            font-size: 1.2em;
        }

        .tip-item {
            padding: 0.6em;
        }

        .tip-text {
            font-size: 0.85em;
        }
    }

    /* ======================== NEW TABLE STYLES ======================== */
    
    .market-analysis-table,
    .exchange-comparison-table,
    .prediction-accuracy-table {
        margin-top: 1em;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        overflow: hidden;
    }

    .market-analysis-table .table,
    .exchange-comparison-table .table,
    .prediction-accuracy-table .table {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 1em;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .market-analysis-table .table thead th,
    .exchange-comparison-table .table thead th,
    .prediction-accuracy-table .table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1em;
        font-weight: 600;
        text-align: center;
        word-wrap: break-word;
        overflow-wrap: break-word;
        font-size: 0.9rem;
    }

    .market-analysis-table .table tbody td,
    .exchange-comparison-table .table tbody td,
    .prediction-accuracy-table .table tbody td {
        padding: 1em;
        border-bottom: 1px solid #eee;
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word;
        overflow-wrap: break-word;
        font-size: 0.9rem;
    }

    .market-analysis-table .table tbody tr:last-child td,
    .exchange-comparison-table .table tbody tr:last-child td,
    .prediction-accuracy-table .table tbody tr:last-child td {
        border-bottom: none;
    }

    .market-analysis-table .table tbody tr:hover,
    .exchange-comparison-table .table tbody tr:hover,
    .prediction-accuracy-table .table tbody tr:hover {
        background: rgba(102, 126, 234, 0.1);
    }

    /* Mobile responsive styles for new tables */
    @media (max-width: 768px) {
        .market-analysis-table,
        .exchange-comparison-table,
        .prediction-accuracy-table {
            margin: 0.8em 0.5em;
            width: calc(100% - 1em);
            max-width: calc(100% - 1em);
        }

        .market-analysis-table .table,
        .exchange-comparison-table .table,
        .prediction-accuracy-table .table {
            border-radius: 0.8em;
            font-size: 0.85rem;
        }

        .market-analysis-table .table thead,
        .exchange-comparison-table .table thead,
        .prediction-accuracy-table .table thead {
            display: none; /* Hide headers on mobile */
        }

        .market-analysis-table .table tbody,
        .exchange-comparison-table .table tbody,
        .prediction-accuracy-table .table tbody {
            display: block;
            width: 100%;
        }

        .market-analysis-table .table tbody tr,
        .exchange-comparison-table .table tbody tr,
        .prediction-accuracy-table .table tbody tr {
            display: block;
            width: 100%;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            position: relative;
        }

        .market-analysis-table .table tbody td,
        .exchange-comparison-table .table tbody td,
        .prediction-accuracy-table .table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border: none;
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
            position: relative;
            font-size: 0.9rem;
        }

        .market-analysis-table .table tbody td:last-child,
        .exchange-comparison-table .table tbody td:last-child,
        .prediction-accuracy-table .table tbody td:last-child {
            border-bottom: none;
        }

        .market-analysis-table .table tbody td:before,
        .exchange-comparison-table .table tbody td:before,
        .prediction-accuracy-table .table tbody td:before {
            content: attr(data-label);
            font-weight: 700;
            color: #666;
            min-width: 120px;
            margin-right: 1rem;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        /* Special styling for coin/symbol columns */
        .market-analysis-table .table tbody td[data-label="Coin"],
        .market-analysis-table .table tbody td[data-label="Symbol"],
        .exchange-comparison-table .table tbody td[data-label="Exchange Name"],
        .prediction-accuracy-table .table tbody td[data-label="Coin Pair"] {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: -1rem -1rem 0.5rem -1rem;
            padding: 0.75rem 1rem;
            border-radius: 12px 12px 0 0;
            border-bottom: 2px solid #e9ecef;
        }

        .market-analysis-table .table tbody td[data-label="Coin"]:before,
        .market-analysis-table .table tbody td[data-label="Symbol"]:before,
        .exchange-comparison-table .table tbody td[data-label="Exchange Name"]:before,
        .prediction-accuracy-table .table tbody td[data-label="Coin Pair"]:before {
            display: none;
        }

        /* Special styling for price change columns */
        .market-analysis-table .table tbody td[data-label="Price Change (24h)"] {
            font-weight: 600;
        }

        .market-analysis-table .table tbody td[data-label="Price Change (24h)"].positive {
            color: #28a745;
        }

        .market-analysis-table .table tbody td[data-label="Price Change (24h)"].negative {
            color: #dc3545;
        }

        /* Special styling for sentiment score */
        .market-analysis-table .table tbody td[data-label="Sentiment Score"] {
            font-weight: 600;
            color: #667eea;
        }

        /* Special styling for trust score */
        .exchange-comparison-table .table tbody td[data-label="Trust Score"] {
            font-weight: 600;
            color: #28a745;
        }

        /* Special styling for prediction accuracy */
        .prediction-accuracy-table .table tbody td[data-label="Prediction Accuracy"] {
            font-weight: 600;
            color: #ffc107;
        }

        /* Special styling for confidence level */
        .prediction-accuracy-table .table tbody td[data-label="Confidence Level"] {
            font-weight: 600;
            color: #17a2b8;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .market-analysis-table,
        .exchange-comparison-table,
        .prediction-accuracy-table {
            margin: 0.6em 0.3em;
            width: calc(100% - 0.6em);
            max-width: calc(100% - 0.6em);
        }

        .market-analysis-table .table tbody tr,
        .exchange-comparison-table .table tbody tr,
        .prediction-accuracy-table .table tbody tr {
            margin-bottom: 0.8rem;
            padding: 0.8rem;
        }

        .market-analysis-table .table tbody td,
        .exchange-comparison-table .table tbody td,
        .prediction-accuracy-table .table tbody td {
            padding: 0.4rem 0;
            font-size: 0.85rem;
        }

        .market-analysis-table .table tbody td:before,
        .exchange-comparison-table .table tbody td:before,
        .prediction-accuracy-table .table tbody td:before {
            font-size: 0.8rem;
            min-width: 100px;
        }

        .market-analysis-table .table tbody td[data-label="Coin"],
        .market-analysis-table .table tbody td[data-label="Symbol"],
        .exchange-comparison-table .table tbody td[data-label="Exchange Name"],
        .prediction-accuracy-table .table tbody td[data-label="Coin Pair"] {
            font-size: 1rem;
            padding: 0.6rem 0.8rem;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .market-analysis-table,
        .exchange-comparison-table,
        .prediction-accuracy-table {
            margin: 0.5em 0.2em;
            width: calc(100% - 0.4em);
            max-width: calc(100% - 0.4em);
        }

        .market-analysis-table .table tbody tr,
        .exchange-comparison-table .table tbody tr,
        .prediction-accuracy-table .table tbody tr {
            margin-bottom: 0.6rem;
            padding: 0.6rem;
        }

        .market-analysis-table .table tbody td,
        .exchange-comparison-table .table tbody td,
        .prediction-accuracy-table .table tbody td {
            padding: 0.3rem 0;
            font-size: 0.8rem;
        }

        .market-analysis-table .table tbody td:before,
        .exchange-comparison-table .table tbody td:before,
        .prediction-accuracy-table .table tbody td:before {
            font-size: 0.75rem;
            min-width: 90px;
        }

        .market-analysis-table .table tbody td[data-label="Coin"],
        .market-analysis-table .table tbody td[data-label="Symbol"],
        .exchange-comparison-table .table tbody td[data-label="Exchange Name"],
        .prediction-accuracy-table .table tbody td[data-label="Coin Pair"] {
            font-size: 0.95rem;
            padding: 0.5rem 0.6rem;
        }
    }

    /* Very small devices */
    @media (max-width: 320px) {
        .market-analysis-table,
        .exchange-comparison-table,
        .prediction-accuracy-table {
            margin: 0.4em 0.1em;
            width: calc(100% - 0.2em);
            max-width: calc(100% - 0.2em);
        }

        .market-analysis-table .table tbody tr,
        .exchange-comparison-table .table tbody tr,
        .prediction-accuracy-table .table tbody tr {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
        }

        .market-analysis-table .table tbody td,
        .exchange-comparison-table .table tbody td,
        .prediction-accuracy-table .table tbody td {
            padding: 0.25rem 0;
            font-size: 0.75rem;
        }

        .market-analysis-table .table tbody td:before,
        .exchange-comparison-table .table tbody td:before,
        .prediction-accuracy-table .table tbody td:before {
            font-size: 0.7rem;
            min-width: 80px;
        }

        .market-analysis-table .table tbody td[data-label="Coin"],
        .market-analysis-table .table tbody td[data-label="Symbol"],
        .exchange-comparison-table .table tbody td[data-label="Exchange Name"],
        .prediction-accuracy-table .table tbody td[data-label="Coin Pair"] {
            font-size: 0.9rem;
            padding: 0.4rem 0.5rem;
        }
    }

    /* Desktop table enhancements */
    @media (min-width: 769px) {
        .market-analysis-table .table tbody tr,
        .exchange-comparison-table .table tbody tr,
        .prediction-accuracy-table .table tbody tr {
            transition: all 0.2s ease;
        }

        .market-analysis-table .table tbody tr:hover,
        .exchange-comparison-table .table tbody tr:hover,
        .prediction-accuracy-table .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .market-analysis-table .table thead th,
        .exchange-comparison-table .table thead th,
        .prediction-accuracy-table .table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }
    }

    /* Touch-friendly improvements for mobile */
    @media (max-width: 768px) {
        .market-analysis-table .table tbody tr,
        .exchange-comparison-table .table tbody tr,
        .prediction-accuracy-table .table tbody tr {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .market-analysis-table .table tbody tr:active,
        .exchange-comparison-table .table tbody tr:active,
        .prediction-accuracy-table .table tbody tr:active {
            transform: scale(0.98);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }

        /* Improve touch targets */
        .market-analysis-table .table tbody td,
        .exchange-comparison-table .table tbody td,
        .prediction-accuracy-table .table tbody td {
            min-height: 44px;
            display: flex;
            align-items: center;
        }
    }

    /* Calendar styles */
    .calendar-wrapper {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px;
        overflow: hidden;
    }
    #coinEventCalendar .fc-toolbar-title {
        font-size: 1.2em;
        font-weight: 700;
        color: #333;
    }
    #coinEventCalendar .fc-daygrid-event, 
    #coinEventCalendar .fc-list-event {
        font-size: 0.9rem;
    }
    @media (max-width: 768px) {
        .calendar-wrapper { padding: 8px; border-radius: 10px; }
        #coinEventCalendar .fc-toolbar-title { font-size: 1em; }
    }
    /* Improve toolbar touch targets on mobile */
    #coinEventCalendar .fc .fc-button {
        padding: 0.5em 0.8em;
    }
    /* Coin and category badges */
    .badge {
        display: inline-block;
        padding: 2px 8px;
        font-size: 0.75rem;
        border-radius: 9999px;
        background: #eef2ff;
        color: #3730a3;
        margin-right: 6px;
        margin-bottom: 4px;
        white-space: nowrap;
    }
    .badge.cat-listing { background:#ecfdf5; color:#065f46; }
    .badge.cat-airdrop { background:#eff6ff; color:#1e40af; }
    .badge.cat-partnership { background:#fffbeb; color:#92400e; }
    .badge.cat-ama { background:#f5f3ff; color:#5b21b6; }
    .badge.coin { background:#f1f5f9; color:#0f172a; }

    /* Event modal */
    .event-modal { position: fixed; inset: 0; z-index: 1000; }
    .event-modal__backdrop { position: absolute; inset:0; background: rgba(0,0,0,0.5); }
    .event-modal__content { position: relative; max-width: 520px; margin: 10vh auto; background:#fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); overflow: hidden; }
    .event-modal__header { display:flex; align-items:center; justify-content:space-between; padding: 12px 16px; border-bottom:1px solid #eee; }
    .event-modal__body { padding: 12px 16px; }
    .event-modal__footer { padding: 12px 16px; border-top:1px solid #eee; display:flex; gap:8px; justify-content:flex-end; }
    .event-modal__close { background: none; border: none; font-size: 20px; cursor: pointer; line-height: 1; }
    .event-modal__btn { background:#4f46e5; color:#fff; border:none; border-radius:8px; padding:8px 12px; text-decoration:none; display:inline-block; }
    .event-modal__btn.secondary { background:#e5e7eb; color:#111827; }
    .event-modal__row { margin: 6px 0; font-size: 0.95rem; }

    @media (max-width: 768px) {
        .calendar-wrapper { padding: 8px; border-radius: 10px; }
        #coinEventCalendar .fc-toolbar-title { font-size: 1em; }
        #coinEventCalendar .fc .fc-button { padding: 0.45em 0.7em; }
        .event-modal__content { margin: 0; position: absolute; bottom: 0; left:0; right:0; max-width: 100%; border-bottom-left-radius:0; border-bottom-right-radius:0; }
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="{{ url('js/livecoin/history.js') }}"></script>
    <script>
        function getInitials(name) {
            if (!name) return '';
            const parts = name.trim().split(' ');
            if (parts.length === 1) return parts[0][0].toUpperCase();
            return (parts[0][0] + parts[parts.length-1][0]).toUpperCase();
        }

        // Global chart objects for language switching
        window.comparisonCharts = {
            marketCap: null,
            priceTrends: null,
            volume: null,
            platform: null
        };

        // Initialize new platform comparison chart variables
        window.platformComparisonChart = null;
        window.marketCapComparisonChart = null;
        window.volumeComparisonChart = null;
        window.coinCountComparisonChart = null;
        window.priceMovementComparisonChart = null;

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
            const enhancedLoadingEl = document.getElementById('enhancedLoading');

            if (!loadingEl || !chartsEl || !enhancedLoadingEl) {
                console.error('Required DOM elements not found for comparison data loading');
                return;
            }

            // Show enhanced loading interface
            enhancedLoadingEl.style.display = 'block';
            chartsEl.style.display = 'none';
            loadingEl.style.display = 'none';

            // Initialize progress tracking
            let totalSources = 6; // Total data sources
            let completedSources = 0;
            let progressPercentage = 0;

            // Update progress function
            function updateProgress(sourceName, status, isComplete = false) {
                const statusElement = document.getElementById(`${sourceName}-status`);
                const sourceItem = document.querySelector(`[data-source="${sourceName}"]`);
                
                if (statusElement) {
                    statusElement.textContent = status;
                }
                
                if (sourceItem) {
                    sourceItem.className = `source-item ${status.toLowerCase()}`;
                }
                
                if (isComplete) {
                    completedSources++;
                    progressPercentage = Math.round((completedSources / totalSources) * 100);
                    
                    const progressFill = document.getElementById('progressFill');
                    const progressText = document.getElementById('progressText');
                    
                    if (progressFill) {
                        progressFill.style.width = `${progressPercentage}%`;
                    }
                    
                    if (progressText) {
                        progressText.textContent = `${completedSources} of ${totalSources} sources loaded`;
                    }
                }
            }

            // Start loading sequence
            updateProgress('livecoinwatch', 'Loading...', false);
            updateProgress('coingecko', 'Loading...', false);
            updateProgress('coinmarketcal', 'Loading...', false);
            updateProgress('cryptocompare', 'Loading...', false);
            updateProgress('coinpaprika', 'Loading...', false);
            updateProgress('cryptics', 'Loading...', false);

            // Load main comparison data
            fetch('/livecoinwatch/compare')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateProgress('livecoinwatch', 'Loaded', true);
                        updateProgress('coingecko', 'Loaded', true);
                        updateProgress('coinmarketcal', 'Loaded', true);
                        updateProgress('cryptocompare', 'Loaded', true);
                        
                        // Render the main comparison data
                        renderComparisonData(data.data);
                        
                        // Load additional data sources
                        loadCoinPaprikaData();
                        loadCrypticsData();
                        
                        // Hide loading and show charts after a short delay
                        setTimeout(() => {
                            enhancedLoadingEl.style.display = 'none';
                            chartsEl.style.display = 'block';
                            // Now that charts are visible, load DB-backed charts to avoid zero-size rendering
                            try { loadMainDbCharts(); } catch (e) { console.error('Failed to load main DB charts after show', e); }
                            // Initialize Coin Event Calendar
                            try { initCoinEventCalendar(); } catch (e) { console.error('Failed to init Coin Event Calendar', e); }
                        }, 1000);
                    } else {
                        console.error('Error loading comparison data:', data.message);
                        updateProgress('livecoinwatch', 'Error', true);
                        updateProgress('coingecko', 'Error', true);
                        updateProgress('coinmarketcal', 'Error', true);
                        updateProgress('cryptocompare', 'Error', true);
                    }
                })
                .catch(error => {
                    console.error('Error fetching comparison data:', error);
                    updateProgress('livecoinwatch', 'Error', true);
                    updateProgress('coingecko', 'Error', true);
                    updateProgress('coinmarketcal', 'Error', true);
                    updateProgress('cryptocompare', 'Error', true);
                });
        }

        // Load CoinPaprika data via AJAX
        function loadCoinPaprikaData() {
            updateSourceStatus('coinpaprika', 'Loading...', 'loading');
            
            fetch('/api/coinpaprika-data')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCoinPaprikaBlock(data.data);
                        updateSourceStatus('coinpaprika', 'Loaded', 'success');
                    } else {
                        console.error('Error loading CoinPaprika data:', data.message);
                        updateCoinPaprikaBlock({ error: true });
                        updateSourceStatus('coinpaprika', 'Error', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error fetching CoinPaprika data:', error);
                    updateCoinPaprikaBlock({ error: true });
                    updateSourceStatus('coinpaprika', 'Error', 'error');
                });
        }

        // Load Cryptics data via AJAX
        function loadCrypticsData() {
            updateSourceStatus('cryptics', 'Loading...', 'loading');
            
            fetch('/api/cryptics-data')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCrypticsBlock(data.data);
                        updateSourceStatus('cryptics', 'Loaded', 'success');
                    } else {
                        console.error('Error loading Cryptics data:', data.message);
                        updateCrypticsBlock({ error: true });
                        updateSourceStatus('cryptics', 'Error', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error fetching Cryptics data:', error);
                    updateCrypticsBlock({ error: true });
                    updateSourceStatus('cryptics', 'Error', 'error');
                });
        }

        // Helper function to update source status
        function updateSourceStatus(sourceName, status, className) {
            const statusElement = document.getElementById(`${sourceName}-status`);
            const sourceItem = document.querySelector(`[data-source="${sourceName}"]`);
            
            if (statusElement) {
                statusElement.textContent = status;
            }
            
            if (sourceItem) {
                sourceItem.className = `source-item ${className}`;
            }
        }

        // Update CoinPaprika block with data
        function updateCoinPaprikaBlock(data) {
            if (data.error) {
                $('#cp-total-coins').text('Error');
                $('#cp-active-coins').text('Error');
                $('#cp-new-coins').text('Error');
                return;
            }

            $('#cp-total-coins').text(data.total_coins?.toLocaleString() || '-');
            $('#cp-active-coins').text(data.active_coins?.toLocaleString() || '-');
            $('#cp-new-coins').text(data.new_coins?.toLocaleString() || '-');
        }

        // Update Cryptics block with data
        function updateCrypticsBlock(data) {
            if (data.error) {
                $('#ct-total-predictions').text('Error');
                $('#ct-accuracy').text('Error');
                $('#ct-trending-up').text('Error');
                return;
            }

            // Check if this is demo data
            const isDemo = data.demo_data || false;
            
            // Update the values
            $('#ct-total-predictions').text(data.total_predictions?.toLocaleString() || '-');
            $('#ct-accuracy').text((data.prediction_accuracy * 100).toFixed(1) + '%');
            $('#ct-trending-up').text(data.prediction_trends?.trending_up || '-');
            
            // Add visual indicator for demo data
            if (isDemo) {
                // Add a small indicator that this is demo data
                const accuracyEl = document.getElementById('ct-accuracy');
                if (accuracyEl) {
                    accuracyEl.title = 'Demo data - API temporarily unavailable';
                    accuracyEl.style.opacity = '0.7';
                    accuracyEl.style.fontStyle = 'italic';
                }
                
                // Log info about demo data
                console.log('Cryptics.tech: Using demo data due to API connectivity issues');
            } else {
                // Remove demo data styling if it exists
                const accuracyEl = document.getElementById('ct-accuracy');
                if (accuracyEl) {
                    accuracyEl.title = '';
                    accuracyEl.style.opacity = '1';
                    accuracyEl.style.fontStyle = 'normal';
                }
            }
        }

        function renderComparisonData(data) {
            // Check if Chart.js is available
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded. Cannot create charts.');
                return;
            }

            // Update platform overview cards (excluding coinpaprika and cryptics)
            updatePlatformCards(data);

            // Create charts
            createMarketCapChart(data.market_cap_distribution);
            createPriceTrendsChart(data.trends);
            createVolumeChart(data.volume_analysis);
            createPlatformChart(data.comparison);

            // Create new platform comparison charts
            createPlatformComparisonChart(data);
            createMarketCapComparisonChart(data);
            createVolumeComparisonChart(data);
            createCoinCountComparisonChart(data);
            createPriceMovementComparisonChart(data);

            // Create new comprehensive charts
            createMarketSentimentChart(data);
            createPriceCorrelationChart(data);
            createExchangePerformanceChart(data);
            createMarketCapVolumeChart(data);
            createTopCoinsTimelineChart(data);
            createPlatformCoverageChart(data);

            // Update platform performance table
            updatePlatformPerformanceTable(data);

            // Update new data tables
            updateMarketAnalysisTable(data);
            updateExchangeComparisonTable(data);
            updatePredictionAccuracyTable(data);

            // Update top performers table
            updateTopPerformersTable(data.top_performers);

            // Update trends summary
            updateTrendsSummary(data.trends);
        }

        // ======================== NEW PLATFORM COMPARISON CHART FUNCTIONS ========================

        function createPlatformComparisonChart(data) {
            const canvas = document.getElementById('platformComparisonChart');
            if (!canvas) {
                console.warn('Platform comparison chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            // Properly check if the chart exists and is a valid Chart.js instance
            if (window.platformComparisonChart && typeof window.platformComparisonChart.destroy === 'function') {
                window.platformComparisonChart.destroy();
            }

            const chartData = {
                labels: ['LiveCoinWatch', 'CoinGecko', 'CoinMarketCal', 'CryptoCompare'],
                datasets: [
                    {
                        label: 'Total Coins',
                        data: [
                            data.livecoinwatch?.total_coins || 0,
                            data.coingecko?.total_coins || 0,
                            data.coinmarketcal?.total_coins || 0,
                            data.cryptocompare?.total_coins || 0
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Total Market Cap (Billion USD)',
                        data: [
                            (data.livecoinwatch?.total_market_cap || 0) / 1e9,
                            (data.coingecko?.market_cap_stats?.total || 0) / 1e9,
                            (data.coinmarketcal?.market_cap_stats?.total || 0) / 1e9,
                            (data.cryptocompare?.market_cap_stats?.total || 0) / 1e9
                        ],
                        backgroundColor: 'rgba(255, 206, 86, 0.8)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Total Volume (Billion USD)',
                        data: [
                            (data.livecoinwatch?.total_volume || 0) / 1e9,
                            (data.coingecko?.volume_stats?.total || 0) / 1e9,
                            (data.coinmarketcal?.volume_stats?.total || 0) / 1e9,
                            (data.cryptocompare?.volume_stats?.total || 0) / 1e9
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }
                ]
            };

            try {
                window.platformComparisonChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Value'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Platform Data Comparison'
                            },
                            legend: {
                                position: 'top'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating platform comparison chart:', error);
                window.platformComparisonChart = null;
            }
        }

        function createMarketCapComparisonChart(data) {
            const canvas = document.getElementById('marketCapComparisonChart');
            if (!canvas) {
                console.warn('Market cap comparison chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            // Properly check if the chart exists and is a valid Chart.js instance
            if (window.marketCapComparisonChart && typeof window.marketCapComparisonChart.destroy === 'function') {
                window.marketCapComparisonChart.destroy();
            }

            const chartData = {
                labels: ['LiveCoinWatch', 'CoinGecko', 'CoinMarketCal', 'CryptoCompare'],
                datasets: [{
                    data: [
                        (data.livecoinwatch?.total_market_cap || 0) / 1e9,
                        (data.coingecko?.market_cap_stats?.total || 0) / 1e9,
                        (data.coinmarketcal?.market_cap_stats?.total || 0) / 1e9,
                        (data.cryptocompare?.market_cap_stats?.total || 0) / 1e9
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 2
                }]
            };

            try {
                window.marketCapComparisonChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Market Cap Distribution by Platform'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating market cap comparison chart:', error);
                window.marketCapComparisonChart = null;
            }
        }

        function createVolumeComparisonChart(data) {
            const canvas = document.getElementById('volumeComparisonChart');
            if (!canvas) {
                console.warn('Volume comparison chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            // Properly check if the chart exists and is a valid Chart.js instance
            if (window.volumeComparisonChart && typeof window.volumeComparisonChart.destroy === 'function') {
                window.volumeComparisonChart.destroy();
            }

            const chartData = {
                labels: ['LiveCoinWatch', 'CoinGecko', 'CoinMarketCal', 'CryptoCompare'],
                datasets: [{
                    data: [
                        (data.livecoinwatch?.total_volume || 0) / 1e9,
                        (data.coingecko?.volume_stats?.total || 0) / 1e9,
                        (data.coinmarketcal?.volume_stats?.total || 0) / 1e9,
                        (data.cryptocompare?.volume_stats?.total || 0) / 1e9
                    ],
                    backgroundColor: [
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 2
                }]
            };

            try {
                window.volumeComparisonChart = new Chart(ctx, {
                    type: 'pie',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Volume Distribution by Platform'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating volume comparison chart:', error);
                window.volumeComparisonChart = null;
            }
        }

        function createCoinCountComparisonChart(data) {
            const canvas = document.getElementById('coinCountComparisonChart');
            if (!canvas) {
                console.warn('Coin count comparison chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            // Properly check if the chart exists and is a valid Chart.js instance
            if (window.coinCountComparisonChart && typeof window.coinCountComparisonChart.destroy === 'function') {
                window.coinCountComparisonChart.destroy();
            }

            const chartData = {
                labels: ['LiveCoinWatch', 'CoinGecko', 'CoinMarketCal', 'CryptoCompare'],
                datasets: [{
                    label: 'Total Coins',
                    data: [
                        data.livecoinwatch?.total_coins || 0,
                        data.coingecko?.total_coins || 0,
                        data.coinmarketcal?.total_coins || 0,
                        data.cryptocompare?.total_coins || 0
                    ],
                    backgroundColor: 'rgba(153, 102, 255, 0.8)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2
                }]
            };

            try {
                window.coinCountComparisonChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Coins'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Coin Count by Platform'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating coin count comparison chart:', error);
                window.coinCountComparisonChart = null;
            }
        }

        function createPriceMovementComparisonChart(data) {
            const canvas = document.getElementById('priceMovementComparisonChart');
            if (!canvas) {
                console.warn('Price movement comparison chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            // Properly check if the chart exists and is a valid Chart.js instance
            if (window.priceMovementComparisonChart && typeof window.priceMovementComparisonChart.destroy === 'function') {
                window.priceMovementComparisonChart.destroy();
            }

            const chartData = {
                labels: ['LiveCoinWatch', 'CoinGecko', 'CoinMarketCal', 'CryptoCompare'],
                datasets: [
                    {
                        label: 'Gaining Coins',
                        data: [
                            data.livecoinwatch?.gaining_coins || 0,
                            data.coingecko?.price_change_24h?.positive || 0,
                            data.coinmarketcal?.gaining_coins || 0,
                            data.cryptocompare?.price_change_24h?.positive || 0
                        ],
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Losing Coins',
                        data: [
                            data.livecoinwatch?.losing_coins || 0,
                            data.coingecko?.price_change_24h?.negative || 0,
                            data.coinmarketcal?.losing_coins || 0,
                            data.cryptocompare?.price_change_24h?.negative || 0
                        ],
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2
                    }
                ]
            };

            try {
                window.priceMovementComparisonChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Coins'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Price Movement Analysis by Platform'
                            },
                            legend: {
                                position: 'top'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating price movement comparison chart:', error);
                window.priceMovementComparisonChart = null;
            }
        }

        function updatePlatformPerformanceTable(data) {
            const tbody = document.getElementById('platformPerformanceBody');
            if (!tbody) return;

            const now = new Date().toLocaleString();
            
            const platformData = [
                {
                    name: 'LiveCoinWatch',
                    coins: data.livecoinwatch?.total_coins || 0,
                    marketCap: data.livecoinwatch?.total_market_cap || 0,
                    volume: data.livecoinwatch?.total_volume || 0,
                    gaining: data.livecoinwatch?.gaining_coins || 0,
                    losing: data.livecoinwatch?.losing_coins || 0
                },
                {
                    name: 'CoinGecko',
                    coins: data.coingecko?.total_coins || 0,
                    marketCap: data.coingecko?.market_cap_stats?.total || 0,
                    volume: data.coingecko?.volume_stats?.total || 0,
                    gaining: data.coingecko?.price_change_24h?.positive || 0,
                    losing: data.coingecko?.price_change_24h?.negative || 0
                },
                {
                    name: 'CoinMarketCal',
                    coins: data.coinmarketcal?.total_coins || 0,
                    marketCap: data.coinmarketcal?.market_cap_stats?.total || 0,
                    volume: data.coinmarketcal?.volume_stats?.total || 0,
                    gaining: data.coinmarketcal?.gaining_coins || 0,
                    losing: data.coinmarketcal?.losing_coins || 0
                },
                {
                    name: 'CryptoCompare',
                    coins: data.cryptocompare?.total_coins || 0,
                    marketCap: data.cryptocompare?.market_cap_stats?.total || 0,
                    volume: data.cryptocompare?.volume_stats?.total || 0,
                    gaining: data.cryptocompare?.price_change_24h?.positive || 0,
                    losing: data.cryptocompare?.price_change_24h?.negative || 0
                }
            ];

            let html = '';
            platformData.forEach(platform => {
                html += `
                    <tr>
                        <td data-label="Platform"><strong>${platform.name}</strong></td>
                        <td data-label="Total Coins">${platform.coins.toLocaleString()}</td>
                        <td data-label="Total Market Cap">${formatCurrency(platform.marketCap)}</td>
                        <td data-label="Total Volume">${formatCurrency(platform.volume)}</td>
                        <td data-label="Gaining Coins" class="text-success">+${platform.gaining.toLocaleString()}</td>
                        <td data-label="Losing Coins" class="text-danger">-${platform.losing.toLocaleString()}</td>
                        <td data-label="Last Updated">${now}</td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
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

            // CryptoCompare
            if (data.cryptocompare) {
                $('#cc-total-coins').text(data.cryptocompare.total_coins?.toLocaleString() || '-');
                $('#cc-total-mcap').text('$' + (data.cryptocompare.market_cap_stats?.total / 1e9).toFixed(2) + 'B');
                $('#cc-total-volume').text('$' + (data.cryptocompare.volume_stats?.total / 1e9).toFixed(2) + 'B');
            }

            // Note: CoinPaprika and Cryptics data are loaded separately via AJAX
        }

        function createMarketCapChart(data) {
            const ctx = document.getElementById('marketCapChart').getContext('2d');

            if (window.comparisonCharts.marketCap) {
                window.comparisonCharts.marketCap.destroy();
            }

            window.comparisonCharts.marketCap = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['{{ __("menu.mega_cap") }}', '{{ __("menu.large_cap") }}', '{{ __("menu.mid_cap") }}', '{{ __("menu.small_cap") }}', '{{ __("menu.micro_cap") }}'],
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
                            position: window.innerWidth < 768 ? 'bottom' : 'bottom',
                            labels: {
                                padding: window.innerWidth < 768 ? 10 : 20,
                                usePointStyle: true,
                                boxWidth: window.innerWidth < 768 ? 8 : 12,
                                font: {
                                    size: window.innerWidth < 768 ? 11 : 14
                                }
                            }
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#fff',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || context.raw;
                                    return `${label}: ${value.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: window.innerWidth < 768 ? 5 : 10,
                            bottom: window.innerWidth < 768 ? 5 : 10,
                            left: window.innerWidth < 768 ? 5 : 10,
                            right: window.innerWidth < 768 ? 5 : 10
                        }
                    },
                    elements: {
                        arc: {
                            borderWidth: window.innerWidth < 768 ? 1 : 2
                        }
                    }
                }
            });
        }

        function createPriceTrendsChart(data) {
            const ctx = document.getElementById('priceTrendsChart').getContext('2d');

            if (window.comparisonCharts.priceTrends) {
                window.comparisonCharts.priceTrends.destroy();
            }

            window.comparisonCharts.priceTrends = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['{{ __("menu.gaining") }}', '{{ __("menu.losing") }}', '{{ __("menu.stable") }}'],
                    datasets: [{
                        label: '{{ __("menu.price_movement_24h") }}',
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
                        borderWidth: 1,
                        borderRadius: 4
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
                                },
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#fff',
                            borderWidth: 1,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y;
                                    return `${context.dataset.label}: ${value.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: window.innerWidth < 768 ? 5 : 10,
                            bottom: window.innerWidth < 768 ? 5 : 10,
                            left: window.innerWidth < 768 ? 5 : 10,
                            right: window.innerWidth < 768 ? 5 : 10
                        }
                    }
                }
            });
        }

        function createVolumeChart(data) {
            const ctx = document.getElementById('volumeChart').getContext('2d');

            if (window.comparisonCharts.volume) {
                window.comparisonCharts.volume.destroy();
            }

            window.comparisonCharts.volume = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['{{ __("menu.high_volume") }}', '{{ __("menu.medium_volume") }}', '{{ __("menu.low_volume") }}'],
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
                            position: window.innerWidth < 768 ? 'bottom' : 'bottom',
                            labels: {
                                padding: window.innerWidth < 768 ? 10 : 20,
                                usePointStyle: true,
                                boxWidth: window.innerWidth < 768 ? 8 : 12,
                                font: {
                                    size: window.innerWidth < 768 ? 11 : 14
                                }
                            }
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#fff',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || context.raw;
                                    return `${label}: ${value.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: window.innerWidth < 768 ? 5 : 10,
                            bottom: window.innerWidth < 768 ? 5 : 10,
                            left: window.innerWidth < 768 ? 5 : 10,
                            right: window.innerWidth < 768 ? 5 : 10
                        }
                    },
                    elements: {
                        arc: {
                            borderWidth: window.innerWidth < 768 ? 1 : 2
                        }
                    }
                }
            });
        }

        function createPlatformChart(data) {
            const ctx = document.getElementById('platformChart').getContext('2d');

            if (window.comparisonCharts.platform) {
                window.comparisonCharts.platform.destroy();
            }

            window.comparisonCharts.platform = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['{{ __("menu.livecoinwatch_only") }}', '{{ __("menu.coingecko_only") }}', '{{ __("menu.both_platforms") }}'],
                    datasets: [{
                        label: '{{ __("menu.platform_coverage") }}',
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
                        borderWidth: 1,
                        borderRadius: 4
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
                                },
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: window.innerWidth < 768 ? 10 : 12
                                },
                                maxRotation: window.innerWidth < 768 ? 45 : 0,
                                minRotation: window.innerWidth < 768 ? 45 : 0
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#fff',
                            borderWidth: 1,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y;
                                    return `${context.dataset.label}: ${value.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: window.innerWidth < 768 ? 5 : 10,
                            bottom: window.innerWidth < 768 ? 5 : 10,
                            left: window.innerWidth < 768 ? 5 : 10,
                            right: window.innerWidth < 768 ? 5 : 10
                        }
                    }
                }
            });
        }

        function updateTopPerformersTable(data) {
            const tbody = document.getElementById('topPerformersBody');
            let html = '';

            data.by_market_cap.forEach((coin, index) => {
                // Determine 24h change class for mobile styling
                const changeClass = coin.price_change_24h > 0 ? 'positive' : 
                                  coin.price_change_24h < 0 ? 'negative' : 'neutral';
                
                html += `
                    <tr>
                        <td data-label="{{ __('menu.rank') }}">${index + 1}</td>
                        <td data-label="{{ __('menu.name') }}">${coin.name}</td>
                        <td data-label="{{ __('menu.symbol') }}"><strong>${coin.symbol.toUpperCase()}</strong></td>
                        <td data-label="{{ __('menu.market_cap') }}">${formatCurrency(coin.market_cap)}</td>
                        <td data-label="{{ __('menu.price') }}">${coin.price ? '$' + formatNumber(coin.price) : '-'}</td>
                        <td data-label="{{ __('menu.24h_change') }}" class="${changeClass}">${coin.price_change_24h ? (coin.price_change_24h > 0 ? '+' : '') + coin.price_change_24h.toFixed(2) + '%' : '-'}</td>
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
                alert('{{ __("menu.please_enter_coin_symbol") }}');
                return;
            }

            const resultEl = document.getElementById('coinAnalysisResult');
            resultEl.style.display = 'block';
            resultEl.innerHTML = '<div style="text-align: center; padding: 2em;"><div class="spinner-border text-warning" role="status"></div><p>{{ __("menu.searching_for_coin_data") }}</p></div>';

            fetch(`/livecoinwatch/coin-analysis?symbol=${encodeURIComponent(symbol)}`)
                .then(response => response.json())
        .then(data => {
                if (data.success) {
                renderCoinAnalysis(data);
            } else {
                resultEl.innerHTML = `<div class="alert alert-warning">{{ __("menu.no_data_found_for") }} ${symbol.toUpperCase()}</div>`;
            }
        })
        .catch(error => {
                console.error('Error searching coin:', error);
            resultEl.innerHTML = `<div class="alert alert-danger">{{ __("menu.error_searching_for") }} ${symbol.toUpperCase()}</div>`;
        });
        }

        function renderCoinAnalysis(data) {
            const resultEl = document.getElementById('coinAnalysisResult');
            const analysis = data.analysis;

            let html = `
                <div class="coin-analysis-header">
                    <h3>📊 {{ __('menu.analysis_for') }} ${data.symbol}</h3>
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
                                <span class="coin-analysis-label">{{ __('menu.price') }}</span>
                                <span class="coin-analysis-value">$${formatNumber(analysis.livecoinwatch.price)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.market_cap') }}</span>
                                <span class="coin-analysis-value">${formatCurrency(analysis.livecoinwatch.market_cap)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.volume') }}</span>
                                <span class="coin-analysis-value">${formatCurrency(analysis.livecoinwatch.volume)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.last_updated') }}</span>
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
                                <span class="coin-analysis-label">{{ __('menu.name') }}</span>
                                <span class="coin-analysis-value">${analysis.coingecko.name}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.price') }}</span>
                                <span class="coin-analysis-value">$${formatNumber(analysis.coingecko.current_price)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.market_cap') }}</span>
                                <span class="coin-analysis-value">${formatCurrency(analysis.coingecko.market_cap)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.rank') }}</span>
                                <span class="coin-analysis-value">#${analysis.coingecko.market_cap_rank}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.24h_change') }}</span>
                                <span class="coin-analysis-value ${priceChangeClass}">${priceChangeSign}${analysis.coingecko.price_change_percentage_24h.toFixed(2)}%</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.volume') }}</span>
                                <span class="coin-analysis-value">${formatCurrency(analysis.coingecko.total_volume)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.circulating_supply') }}</span>
                                <span class="coin-analysis-value">${formatNumber(analysis.coingecko.circulating_supply)}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.max_supply') }}</span>
                                <span class="coin-analysis-value">${analysis.coingecko.max_supply ? formatNumber(analysis.coingecko.max_supply) : 'N/A'}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.ath') }}</span>
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
                                <span class="coin-analysis-label">{{ __('menu.name') }}</span>
                                <span class="coin-analysis-value">${analysis.coinmarketcal.name}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.rank') }}</span>
                                <span class="coin-analysis-value">#${analysis.coinmarketcal.rank}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.hot_index') }}</span>
                                <span class="coin-analysis-value">${analysis.coinmarketcal.hot_index || 'N/A'}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.trending_index') }}</span>
                                <span class="coin-analysis-value">${analysis.coinmarketcal.trending_index || 'N/A'}</span>
                            </div>
                            <div class="coin-analysis-item">
                                <span class="coin-analysis-label">{{ __('menu.significant_index') }}</span>
                                <span class="coin-analysis-value">${analysis.coinmarketcal.significant_index || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                `;
            }

            html += '</div>';
            resultEl.innerHTML = html;
        }

        // Global function for external language switcher scripts to call
        window.updateMarketsComparisonTranslations = function() {
            if (typeof updatePlatformTranslations === 'function') {
                updatePlatformTranslations();
                console.log('External language switcher called - updating platform translations');
            }
        };

        document.addEventListener('DOMContentLoaded', function() {

            // Load comparison data on page load
            loadComparisonData();

            // Load individual block data via AJAX
            loadCoinPaprikaData();
            loadCrypticsData();

            // Refresh comparison data button
            document.getElementById('refreshComparison').addEventListener('click', function() {
                // Show enhanced loading interface
                const enhancedLoadingEl = document.getElementById('enhancedLoading');
                const chartsEl = document.getElementById('comparisonCharts');
                
                if (enhancedLoadingEl && chartsEl) {
                    enhancedLoadingEl.style.display = 'block';
                    chartsEl.style.display = 'none';
                }
                
                // Cleanup existing charts before loading new data
                cleanupAllCharts();
                
                // Reset progress
                const progressFill = document.getElementById('progressFill');
                const progressText = document.getElementById('progressText');
                if (progressFill) progressFill.style.width = '0%';
                if (progressText) progressText.textContent = 'Initializing...';
                
                // Reset all source statuses
                const sources = ['livecoinwatch', 'coingecko', 'coinmarketcal', 'cryptocompare', 'coinpaprika', 'cryptics'];
                sources.forEach(source => {
                    updateSourceStatus(source, 'Waiting...', '');
                });
                
                loadComparisonData();
                // Also refresh individual blocks
                loadCoinPaprikaData();
                loadCrypticsData();
            });

            // Coin search functionality
            document.getElementById('searchCoinBtn').addEventListener('click', searchCoin);
            document.getElementById('coinSearchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchCoin();
                }
            });

            // Mobile-specific enhancements for coin search
            function enhanceMobileSearch() {
                const searchSection = document.querySelector('.coin-search-section');
                const searchInput = document.getElementById('coinSearchInput');
                const searchBtn = document.getElementById('searchCoinBtn');

                if (!searchSection || !searchInput || !searchBtn) return;

                // Add mobile-specific classes
                if (window.innerWidth <= 768) {
                    searchSection.classList.add('mobile-view');
                    
                    // Prevent zoom on input focus (iOS)
                    searchInput.addEventListener('focus', function() {
                        if (window.innerWidth <= 768) {
                            this.style.fontSize = '16px';
                        }
                    });

                    // Restore font size on blur
                    searchInput.addEventListener('blur', function() {
                        if (window.innerWidth <= 768) {
                            this.style.fontSize = '';
                        }
                    });

                    // Add touch feedback
                    searchBtn.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.95)';
                    });

                    searchBtn.addEventListener('touchend', function() {
                        this.style.transform = 'scale(1)';
                    });

                    // Prevent double-tap zoom on mobile
                    let lastTouchEnd = 0;
                    searchSection.addEventListener('touchend', function(event) {
                        const now = (new Date()).getTime();
                        if (now - lastTouchEnd <= 300) {
                            event.preventDefault();
                        }
                        lastTouchEnd = now;
                    }, false);
                }

                // Handle orientation changes
                window.addEventListener('orientationchange', function() {
                    setTimeout(function() {
                        // Recalculate mobile view after orientation change
                        if (window.innerWidth <= 768) {
                            searchSection.classList.add('mobile-view');
                        } else {
                            searchSection.classList.remove('mobile-view');
                        }
                    }, 100);
                });

                // Handle window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth <= 768) {
                        searchSection.classList.add('mobile-view');
                    } else {
                        searchSection.classList.remove('mobile-view');
                    }
                });
            }

            // Initialize mobile enhancements
            enhanceMobileSearch();

            // Handle window resize for responsive charts
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    // Resize all charts when window size changes
                    if (window.comparisonCharts.marketCap) {
                        window.comparisonCharts.marketCap.resize();
                    }
                    if (window.comparisonCharts.priceTrends) {
                        window.comparisonCharts.priceTrends.resize();
                    }
                    if (window.comparisonCharts.volume) {
                        window.comparisonCharts.volume.resize();
                    }
                    if (window.comparisonCharts.platform) {
                        window.comparisonCharts.platform.resize();
                    }
                    
                    // Resize new platform comparison charts
                    if (window.platformComparisonChart && typeof window.platformComparisonChart.resize === 'function') {
                        window.platformComparisonChart.resize();
                    }
                    if (window.marketCapComparisonChart && typeof window.marketCapComparisonChart.resize === 'function') {
                        window.marketCapComparisonChart.resize();
                    }
                    if (window.volumeComparisonChart && typeof window.volumeComparisonChart.resize === 'function') {
                        window.volumeComparisonChart.resize();
                    }
                    if (window.coinCountComparisonChart && typeof window.coinCountComparisonChart.resize === 'function') {
                        window.coinCountComparisonChart.resize();
                    }
                    if (window.priceMovementComparisonChart && typeof window.priceMovementComparisonChart.resize === 'function') {
                        window.priceMovementComparisonChart.resize();
                    }
                }, 250); // Debounce resize events
            });

            // Language switcher functionality for platform data
            function updatePlatformTranslations() {
                // Update platform names
                const platformNames = {
                    'cryptocompare': '{{ __("menu.cryptocompare") }}',
                    'coinpaprika': '{{ __("menu.coinpaprika") }}',
                    'cryptics_tech': '{{ __("menu.cryptics_tech") }}'
                };

                // Update platform headers
                document.querySelectorAll('[data-lang-key="cryptocompare"]').forEach(el => {
                    el.textContent = platformNames.cryptocompare;
                });
                document.querySelectorAll('[data-lang-key="coinpaprika"]').forEach(el => {
                    el.textContent = platformNames.coinpaprika;
                });
                document.querySelectorAll('[data-lang-key="cryptics_tech"]').forEach(el => {
                    el.textContent = platformNames.cryptics_tech;
                });

                // Update stat labels - including the specific ones you mentioned
                const statLabels = {
                    'total_coins': '{{ __("menu.total_coins") }}',
                    'total_market_cap': '{{ __("menu.total_market_cap") }}',
                    'total_volume': '{{ __("menu.total_volume") }}',
                    'active_coins': '{{ __("menu.active_coins") }}',
                    'new_coins': '{{ __("menu.new_coins") }}',
                    'total_predictions': '{{ __("menu.total_predictions") }}',
                    'prediction_accuracy': '{{ __("menu.prediction_accuracy") }}',
                    'trending_up': '{{ __("menu.trending_up") }}'
                };

                // Update all stat labels
                Object.keys(statLabels).forEach(key => {
                    document.querySelectorAll(`[data-lang-key="${key}"]`).forEach(el => {
                        el.textContent = statLabels[key];
                    });
                });

                // Update chart labels and legends
                updateChartTranslations();
            }

            function updateChartTranslations() {
                // Update chart labels if charts exist
                if (window.comparisonCharts.marketCap) {
                    window.comparisonCharts.marketCap.data.labels = [
                        '{{ __("menu.mega_cap") }}',
                        '{{ __("menu.large_cap") }}',
                        '{{ __("menu.mid_cap") }}',
                        '{{ __("menu.small_cap") }}',
                        '{{ __("menu.micro_cap") }}'
                    ];
                    window.comparisonCharts.marketCap.update();
                }

                if (window.comparisonCharts.priceTrends) {
                    window.comparisonCharts.priceTrends.data.labels = [
                        '{{ __("menu.gaining") }}',
                        '{{ __("menu.losing") }}',
                        '{{ __("menu.stable") }}'
                    ];
                    window.comparisonCharts.priceTrends.data.datasets[0].label = '{{ __("menu.price_movement_24h") }}';
                    window.comparisonCharts.priceTrends.update();
                }

                if (window.comparisonCharts.volume) {
                    window.comparisonCharts.volume.data.labels = [
                        '{{ __("menu.high_volume") }}',
                        '{{ __("menu.medium_volume") }}',
                        '{{ __("menu.low_volume") }}'
                    ];
                    window.comparisonCharts.volume.update();
                }

                if (window.comparisonCharts.platform) {
                    window.comparisonCharts.platform.data.labels = [
                        '{{ __("menu.livecoinwatch_only") }}',
                        '{{ __("menu.coingecko_only") }}',
                        '{{ __("menu.both_platforms") }}'
                    ];
                    window.comparisonCharts.platform.data.datasets[0].label = '{{ __("menu.platform_coverage") }}';
                    window.comparisonCharts.platform.update();
                }
            }

            // Enhanced language switcher event handling
            function setupLanguageSwitcher() {
                const languageSwitcher = document.getElementById('languageSwitcher');
                if (languageSwitcher) {
                    // Remove existing listeners to prevent duplicates
                    languageSwitcher.removeEventListener('change', handleLanguageChange);
                    languageSwitcher.addEventListener('change', handleLanguageChange);
                }
            }

            function handleLanguageChange() {
                // Wait for the page to reload with new language
                setTimeout(function() {
                    updatePlatformTranslations();
                    console.log('Language switched - updating platform translations');
                }, 100);
            }

            // Listen for language switcher changes
            setupLanguageSwitcher();

            // Also listen for custom language change events
            document.addEventListener('languageChanged', function() {
                setTimeout(function() {
                    updatePlatformTranslations();
                    console.log('Language changed event detected - updating translations');
                }, 100);
            });

            // Initial translation update
            updatePlatformTranslations();

            // Initialize mobile enhancements
            enhanceMobileSearch();

            // Load DB-backed main charts
            loadMainDbCharts();

        });

        // Function to cleanup all charts
        function cleanupAllCharts() {
            // Cleanup existing comparison charts
            if (window.comparisonCharts.marketCap && typeof window.comparisonCharts.marketCap.destroy === 'function') {
                window.comparisonCharts.marketCap.destroy();
                window.comparisonCharts.marketCap = null;
            }
            if (window.comparisonCharts.priceTrends && typeof window.comparisonCharts.priceTrends.destroy === 'function') {
                window.comparisonCharts.priceTrends.destroy();
                window.comparisonCharts.priceTrends = null;
            }
            if (window.comparisonCharts.volume && typeof window.comparisonCharts.volume.destroy === 'function') {
                window.comparisonCharts.volume.destroy();
                window.comparisonCharts.volume = null;
            }
            if (window.comparisonCharts.platform && typeof window.comparisonCharts.platform.destroy === 'function') {
                window.comparisonCharts.platform.destroy();
                window.comparisonCharts.platform = null;
            }

            // Cleanup new platform comparison charts
            if (window.platformComparisonChart && typeof window.platformComparisonChart.destroy === 'function') {
                window.platformComparisonChart.destroy();
                window.platformComparisonChart = null;
            }
            if (window.marketCapComparisonChart && typeof window.marketCapComparisonChart.destroy === 'function') {
                window.marketCapComparisonChart.destroy();
                window.marketCapComparisonChart = null;
            }
            if (window.volumeComparisonChart && typeof window.volumeComparisonChart.destroy === 'function') {
                window.volumeComparisonChart.destroy();
                window.volumeComparisonChart = null;
            }
            if (window.coinCountComparisonChart && typeof window.coinCountComparisonChart.destroy === 'function') {
                window.coinCountComparisonChart.destroy();
                window.coinCountComparisonChart = null;
            }
            if (window.priceMovementComparisonChart && typeof window.priceMovementComparisonChart.destroy === 'function') {
                window.priceMovementComparisonChart.destroy();
                window.priceMovementComparisonChart = null;
            }

            // Cleanup new comprehensive charts
            if (window.marketSentimentChart && typeof window.marketSentimentChart.destroy === 'function') {
                window.marketSentimentChart.destroy();
                window.marketSentimentChart = null;
            }
            if (window.priceCorrelationChart && typeof window.priceCorrelationChart.destroy === 'function') {
                window.priceCorrelationChart.destroy();
                window.priceCorrelationChart = null;
            }
            if (window.exchangePerformanceChart && typeof window.exchangePerformanceChart.destroy === 'function') {
                window.exchangePerformanceChart.destroy();
                window.exchangePerformanceChart = null;
            }
            if (window.marketCapVolumeChart && typeof window.marketCapVolumeChart.destroy === 'function') {
                window.marketCapVolumeChart.destroy();
                window.marketCapVolumeChart = null;
            }
            if (window.topCoinsTimelineChart && typeof window.topCoinsTimelineChart.destroy === 'function') {
                window.topCoinsTimelineChart.destroy();
                window.topCoinsTimelineChart = null;
            }
            if (window.platformCoverageChart && typeof window.platformCoverageChart.destroy === 'function') {
                window.platformCoverageChart.destroy();
                window.platformCoverageChart = null;
            }
        }

        // ======================== NEW CHART CREATION FUNCTIONS ========================

        function createMarketSentimentChart(data) {
            const canvas = document.getElementById('marketSentimentChart');
            if (!canvas) {
                console.warn('Market sentiment chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            if (window.marketSentimentChart && typeof window.marketSentimentChart.destroy === 'function') {
                window.marketSentimentChart.destroy();
            }

            const chartData = {
                labels: ['Bullish', 'Neutral', 'Bearish'],
                datasets: [{
                    label: 'Market Sentiment Distribution',
                    data: [
                        data.market_sentiment?.overall_sentiment === 'bullish' ? 60 : 30,
                        data.market_sentiment?.overall_sentiment === 'neutral' ? 50 : 40,
                        data.market_sentiment?.overall_sentiment === 'bearish' ? 70 : 20
                    ],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(108, 117, 125, 0.8)',
                        'rgba(220, 53, 69, 0.8)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(108, 117, 125, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 2
                }]
            };

            try {
                window.marketSentimentChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Market Sentiment Analysis'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating market sentiment chart:', error);
                window.marketSentimentChart = null;
            }
        }

        function createPriceCorrelationChart(data) {
            const canvas = document.getElementById('priceCorrelationChart');
            if (!canvas) {
                console.warn('Price correlation chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            if (window.priceCorrelationChart && typeof window.priceCorrelationChart.destroy === 'function') {
                window.priceCorrelationChart.destroy();
            }

            const chartData = {
                labels: ['BTC', 'ETH', 'BNB', 'SOL', 'ADA'],
                datasets: [{
                    label: 'Price Correlation with BTC',
                    data: [1.0, 0.85, 0.72, 0.68, 0.65],
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            };

            try {
                window.priceCorrelationChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 1,
                                title: {
                                    display: true,
                                    text: 'Correlation Coefficient'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Price Correlation Matrix'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating price correlation chart:', error);
                window.priceCorrelationChart = null;
            }
        }

        function createExchangePerformanceChart(data) {
            const canvas = document.getElementById('exchangePerformanceChart');
            if (!canvas) {
                console.warn('Exchange performance chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            if (window.exchangePerformanceChart && typeof window.exchangePerformanceChart.destroy === 'function') {
                window.exchangePerformanceChart.destroy();
            }

            const chartData = {
                labels: ['Binance', 'Coinbase', 'Kraken', 'KuCoin', 'OKX'],
                datasets: [{
                    label: 'Trust Score',
                    data: [9.5, 9.0, 8.5, 8.0, 7.5],
                    backgroundColor: 'rgba(75, 192, 192, 0.8)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            };

            try {
                window.exchangePerformanceChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 10,
                                title: {
                                    display: true,
                                    text: 'Trust Score'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Exchange Performance Comparison'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating exchange performance chart:', error);
                window.exchangePerformanceChart = null;
            }
        }

        function createMarketCapVolumeChart(data) {
            const canvas = document.getElementById('marketCapVolumeChart');
            if (!canvas) {
                console.warn('Market cap volume chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            if (window.marketCapVolumeChart && typeof window.marketCapVolumeChart.destroy === 'function') {
                window.marketCapVolumeChart.destroy();
            }

            const chartData = {
                datasets: [{
                    label: 'Market Cap vs Volume',
                    data: [
                        { x: 1000000000, y: 500000000 },   // 1B market cap, 500M volume
                        { x: 50000000000, y: 2000000000 }, // 50B market cap, 2B volume
                        { x: 200000000000, y: 8000000000 }, // 200B market cap, 8B volume
                        { x: 500000000000, y: 15000000000 }, // 500B market cap, 15B volume
                        { x: 1000000000000, y: 25000000000 } // 1T market cap, 25B volume
                    ],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            };

            try {
                window.marketCapVolumeChart = new Chart(ctx, {
                    type: 'scatter',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                type: 'logarithmic',
                                title: {
                                    display: true,
                                    text: 'Market Cap (USD)'
                                }
                            },
                            y: {
                                type: 'logarithmic',
                                title: {
                                    display: true,
                                    text: '24h Volume (USD)'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Market Cap vs Volume Scatter Plot'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating market cap volume chart:', error);
                window.marketCapVolumeChart = null;
            }
        }

        function createTopCoinsTimelineChart(data) {
            const canvas = document.getElementById('topCoinsTimelineChart');
            if (!canvas) {
                console.warn('Top coins timeline chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            if (window.topCoinsTimelineChart && typeof window.topCoinsTimelineChart.destroy === 'function') {
                window.topCoinsTimelineChart.destroy();
            }

            const chartData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Bitcoin (BTC)',
                        data: [42000, 45000, 38000, 50000, 48000, 52000],
                        borderColor: 'rgba(255, 193, 7, 1)',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Ethereum (ETH)',
                        data: [2800, 3200, 2600, 3500, 3300, 3800],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        tension: 0.4
                    }
                ]
            };

            try {
                window.topCoinsTimelineChart = new Chart(ctx, {
                    type: 'line',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: false,
                                title: {
                                    display: true,
                                    text: 'Price (USD)'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Top Coins Performance Timeline'
                            },
                            legend: {
                                position: 'top'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating top coins timeline chart:', error);
                window.topCoinsTimelineChart = null;
            }
        }

        function createPlatformCoverageChart(data) {
            const canvas = document.getElementById('platformCoverageChart');
            if (!canvas) {
                console.warn('Platform coverage chart canvas not found');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            if (window.platformCoverageChart && typeof window.platformCoverageChart.destroy === 'function') {
                window.platformCoverageChart.destroy();
            }

            const chartData = {
                labels: ['LiveCoinWatch', 'CoinGecko', 'CoinMarketCal', 'CryptoCompare', 'CoinPaprika', 'Cryptics.tech'],
                datasets: [{
                    label: 'Data Coverage (%)',
                    data: [95, 98, 85, 90, 88, 75],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(108, 117, 125, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 193, 7, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(108, 117, 125, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 2
                }]
            };

            try {
                window.platformCoverageChart = new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Coverage Percentage'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Platform Data Coverage'
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating platform coverage chart:', error);
                window.platformCoverageChart = null;
            }
        }

        // ======================== NEW TABLE POPULATION FUNCTIONS ========================

        function updateMarketAnalysisTable(data) {
            const tbody = document.getElementById('marketAnalysisBody');
            if (!tbody) return;

            // Sample market analysis data - in real implementation, this would come from API
            const marketData = [
                {
                    coin: 'Bitcoin',
                    symbol: 'BTC',
                    currentPrice: 52000,
                    marketCap: 1000000000000,
                    volume24h: 25000000000,
                    priceChange24h: 2.5,
                    platformsAvailable: 'All Platforms',
                    sentimentScore: 'Bullish (8.5/10)'
                },
                {
                    coin: 'Ethereum',
                    symbol: 'ETH',
                    currentPrice: 3800,
                    marketCap: 450000000000,
                    volume24h: 15000000000,
                    priceChange24h: 1.8,
                    platformsAvailable: 'All Platforms',
                    sentimentScore: 'Neutral (6.2/10)'
                },
                {
                    coin: 'Binance Coin',
                    symbol: 'BNB',
                    currentPrice: 320,
                    marketCap: 48000000000,
                    volume24h: 800000000,
                    priceChange24h: -0.5,
                    platformsAvailable: 'Most Platforms',
                    sentimentScore: 'Bearish (4.1/10)'
                },
                {
                    coin: 'Solana',
                    symbol: 'SOL',
                    currentPrice: 95,
                    marketCap: 42000000000,
                    volume24h: 1200000000,
                    priceChange24h: 3.2,
                    platformsAvailable: 'All Platforms',
                    sentimentScore: 'Bullish (7.8/10)'
                },
                {
                    coin: 'Cardano',
                    symbol: 'ADA',
                    currentPrice: 0.45,
                    marketCap: 16000000000,
                    volume24h: 400000000,
                    priceChange24h: -1.2,
                    platformsAvailable: 'Most Platforms',
                    sentimentScore: 'Neutral (5.5/10)'
                }
            ];

            let html = '';
            marketData.forEach(coin => {
                const changeClass = coin.priceChange24h > 0 ? 'positive' : coin.priceChange24h < 0 ? 'negative' : 'neutral';
                const changeSign = coin.priceChange24h > 0 ? '+' : '';
                
                html += `
                    <tr>
                        <td data-label="Coin">${coin.coin}</td>
                        <td data-label="Symbol"><strong>${coin.symbol}</strong></td>
                        <td data-label="Current Price">$${coin.currentPrice.toLocaleString()}</td>
                        <td data-label="Market Cap">${formatCurrency(coin.marketCap)}</td>
                        <td data-label="Volume (24h)">${formatCurrency(coin.volume24h)}</td>
                        <td data-label="Price Change (24h)" class="${changeClass}">${changeSign}${coin.priceChange24h.toFixed(2)}%</td>
                        <td data-label="Platforms Available">${coin.platformsAvailable}</td>
                        <td data-label="Sentiment Score">${coin.sentimentScore}</td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
        }

        function updateExchangeComparisonTable(data) {
            const tbody = document.getElementById('exchangeComparisonBody');
            if (!tbody) return;

            // Sample exchange data - in real implementation, this would come from API
            const exchangeData = [
                {
                    name: 'Binance',
                    trustScore: 9.5,
                    volume24hBtc: 125000,
                    yearEstablished: 2017,
                    country: 'Global',
                    exchangeType: 'Centralized',
                    tradingPairs: 1500
                },
                {
                    name: 'Coinbase',
                    trustScore: 9.0,
                    volume24hBtc: 45000,
                    yearEstablished: 2012,
                    country: 'United States',
                    exchangeType: 'Centralized',
                    tradingPairs: 250
                },
                {
                    name: 'Kraken',
                    trustScore: 8.5,
                    volume24hBtc: 35000,
                    yearEstablished: 2011,
                    country: 'United States',
                    exchangeType: 'Centralized',
                    tradingPairs: 180
                },
                {
                    name: 'KuCoin',
                    trustScore: 8.0,
                    volume24hBtc: 28000,
                    yearEstablished: 2017,
                    country: 'Seychelles',
                    exchangeType: 'Centralized',
                    tradingPairs: 700
                },
                {
                    name: 'OKX',
                    trustScore: 7.5,
                    volume24hBtc: 95000,
                    yearEstablished: 2017,
                    country: 'Malta',
                    exchangeType: 'Centralized',
                    tradingPairs: 350
                }
            ];

            let html = '';
            exchangeData.forEach(exchange => {
                html += `
                    <tr>
                        <td data-label="Exchange Name"><strong>${exchange.name}</strong></td>
                        <td data-label="Trust Score">${exchange.trustScore}/10</td>
                        <td data-label="Volume (24h BTC)">${exchange.volume24hBtc.toLocaleString()}</td>
                        <td data-label="Year Established">${exchange.yearEstablished}</td>
                        <td data-label="Country">${exchange.country}</td>
                        <td data-label="Exchange Type">${exchange.exchangeType}</td>
                        <td data-label="Trading Pairs">${exchange.tradingPairs.toLocaleString()}</td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
        }

        function updatePredictionAccuracyTable(data) {
            const tbody = document.getElementById('predictionAccuracyBody');
            if (!tbody) return;

            // Sample prediction data - in real implementation, this would come from API
            const predictionData = [
                {
                    coinPair: 'BTC/USD',
                    predictedPrice: 52000,
                    actualPrice: 51850,
                    predictionAccuracy: 99.7,
                    predictionDate: '2024-01-15',
                    confidenceLevel: 'High (85%)',
                    trendDirection: 'Bullish'
                },
                {
                    coinPair: 'ETH/USD',
                    predictedPrice: 3800,
                    actualPrice: 3750,
                    predictionAccuracy: 98.7,
                    predictionDate: '2024-01-15',
                    confidenceLevel: 'Medium (70%)',
                    trendDirection: 'Neutral'
                },
                {
                    coinPair: 'SOL/USD',
                    predictedPrice: 95,
                    actualPrice: 92,
                    predictionAccuracy: 96.8,
                    predictionDate: '2024-01-15',
                    confidenceLevel: 'High (80%)',
                    trendDirection: 'Bullish'
                },
                {
                    coinPair: 'ADA/USD',
                    predictedPrice: 0.45,
                    actualPrice: 0.42,
                    predictionAccuracy: 93.3,
                    predictionDate: '2024-01-15',
                    confidenceLevel: 'Low (60%)',
                    trendDirection: 'Bearish'
                },
                {
                    coinPair: 'BNB/USD',
                    predictedPrice: 320,
                    actualPrice: 315,
                    predictionAccuracy: 98.4,
                    predictionDate: '2024-01-15',
                    confidenceLevel: 'Medium (75%)',
                    trendDirection: 'Bearish'
                }
            ];

            let html = '';
            predictionData.forEach(prediction => {
                const accuracyClass = prediction.predictionAccuracy >= 95 ? 'text-success' : 
                                    prediction.predictionAccuracy >= 90 ? 'text-warning' : 'text-danger';
                
                html += `
                    <tr>
                        <td data-label="Coin Pair"><strong>${prediction.coinPair}</strong></td>
                        <td data-label="Predicted Price">$${prediction.predictedPrice.toLocaleString()}</td>
                        <td data-label="Actual Price">$${prediction.actualPrice.toLocaleString()}</td>
                        <td data-label="Prediction Accuracy" class="${accuracyClass}">${prediction.predictionAccuracy.toFixed(1)}%</td>
                        <td data-label="Prediction Date">${prediction.predictionDate}</td>
                        <td data-label="Confidence Level">${prediction.confidenceLevel}</td>
                        <td data-label="Trend Direction">${prediction.trendDirection}</td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
        }

        // === New: fetch DB-backed main charts ===
        async function loadMainDbCharts() {
            try {

                const safeParseJson = async (res, label) => {
                    const contentType = res.headers.get('content-type') || '';
                    if (!res.ok || contentType.indexOf('application/json') === -1) {
                        const body = await res.text();
                        console.error(`${label} endpoint returned non-JSON`, res.status, body.slice(0, 500));
                        return null;
                    }
                    try {
                        return await res.json();
                    } catch (err) {
                        const body = await res.text();
                        console.error(`${label} JSON parse failed`, err, body.slice(0, 500));
                        return null;
                    }
                };

                // Time series prices
                const tsRes = await fetch(`/api/main/timeseries-prices?symbols=BTC,ETH&days=60`, { headers: { 'Accept': 'application/json' }});
                const tsJson = await safeParseJson(tsRes, 'timeseries-prices');
                if (tsJson && tsJson.success) {
                    renderTsPricesChart(tsJson.data);
                }

                // Market dominance
                const domRes = await fetch(`/api/main/market-dominance?top=5`, { headers: { 'Accept': 'application/json' }});
                const domJson = await safeParseJson(domRes, 'market-dominance');
                if (domJson && domJson.success) {
                    renderMarketDominance(domJson.data.labels, domJson.data.values);
                } else {
                    // Render an explicit empty state if API fails
                    renderMarketDominance([], []);
                }

                // Top volume markets
                const topRes = await fetch(`/api/main/top-volume-markets?limit=10`, { headers: { 'Accept': 'application/json' }});
                const topJson = await safeParseJson(topRes, 'top-volume-markets');
                if (topJson && topJson.success) {
                    renderTopVolumeMarkets(topJson.data.labels, topJson.data.volumes, topJson.data.prices);
                } else {
                    // Render an explicit empty state if API fails
                    renderTopVolumeMarkets([], [], []);
                }
            } catch (e) {
                console.error('Error loading main DB charts', e);
            }
        }

        // Chart instances
        let tsPricesChart, marketDominanceChart, topVolumeMarketsChart;

        function renderTsPricesChart(series) {
            const ctx = document.getElementById('tsPricesChart');
            if (!ctx) return;
            if (tsPricesChart && typeof tsPricesChart.destroy === 'function') tsPricesChart.destroy();

            const labels = [];
            const datasets = [];
            const palette = ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6'];
            let colorIndex = 0;
            Object.keys(series).forEach(symbol => {
                const points = series[symbol] || [];
                if (points.length) {
                    if (labels.length === 0) {
                        points.forEach(p => labels.push(p.t));
                    }
                    const color = palette[colorIndex++ % palette.length];
                    datasets.push({
                        label: symbol,
                        data: points.map(p => p.y),
                        borderColor: color,
                        backgroundColor: color + '33',
                        tension: 0.3,
                        pointRadius: 0,
                        borderWidth: 2
                    });
                }
            });

            // Empty-state guard
            if (!datasets.length) {
                ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No time series data available</div>';
                return;
            }

            tsPricesChart = new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: { labels, datasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', labels: { boxWidth: 12 } },
                        tooltip: {
                            mode: 'index', intersect: false,
                            callbacks: { label: (ctx) => `${ctx.dataset.label}: ${Number(ctx.parsed.y).toLocaleString()}` }
                        }
                    },
                    scales: {
                        x: {
                            type: 'time',
                            time: { unit: 'day', tooltipFormat: 'yyyy-MM-dd' },
                            adapters: { date: {} },
                            ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 8 },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: false,
                            title: { display: true, text: 'Price (USD)' },
                            grid: { color: 'rgba(0,0,0,0.06)' }
                        }
                    },
                    layout: { padding: { left: 8, right: 8, top: 8, bottom: 8 } }
                }
            });
        }

        function renderMarketDominance(labels, values) {
            const ctx = document.getElementById('marketDominanceChart');
            if (!ctx) return;
            if (marketDominanceChart && typeof marketDominanceChart.destroy === 'function') marketDominanceChart.destroy();

            // Empty-state guard
            if (!Array.isArray(labels) || !Array.isArray(values)) {
                ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No dominance data</div>';
                return;
            }

            // Sanitize data: ensure same length, numeric and non-negative, and sum > 0
            const sanitized = [];
            const len = Math.min(labels.length, values.length);
            for (let i = 0; i < len; i++) {
                const v = Number(values[i]);
                if (Number.isFinite(v) && v >= 0 && labels[i]) sanitized.push({ label: String(labels[i]), value: v });
            }
            if (!sanitized.length) {
                ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No dominance data</div>';
                return;
            }
            const domLabels = sanitized.map(s => s.label);
            const domValues = sanitized.map(s => s.value);

            // If everything is zero, render empty-state
            const total = domValues.reduce((a,b)=>a+b,0);
            if (total <= 0) {
                ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No dominance data</div>';
                return;
            }

            try {
                marketDominanceChart = new Chart(ctx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: domLabels,
                        datasets: [{
                            data: domValues,
                            backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#94a3b8'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom', labels: { boxWidth: 12 } } },
                        layout: { padding: { left: 8, right: 8, top: 8, bottom: 8 } }
                    }
                });
            } catch (err) {
                console.error('Failed to render Market Dominance chart', err);
                ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No dominance data</div>';
            }
        }

        function renderTopVolumeMarkets(labels, volumes, prices) {
            const ctx = document.getElementById('topVolumeMarketsChart');
            if (!ctx) return;
            if (topVolumeMarketsChart && typeof topVolumeMarketsChart.destroy === 'function') topVolumeMarketsChart.destroy();

            // Empty-state guard
            if (!Array.isArray(labels) || !Array.isArray(volumes) || !Array.isArray(prices)) {
                ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No top markets data</div>';
                return;
            }

            // Sanitize data: align lengths and ensure numbers are finite and non-negative for volumes
            const len = Math.min(labels.length, volumes.length, prices.length);
            const sLabels = [];
            const sVolumes = [];
            const sPrices = [];
            for (let i = 0; i < len; i++) {
                const vol = Number(volumes[i]);
                const price = Number(prices[i]);
                const name = labels[i];
                if (!name) continue;
                if (!Number.isFinite(vol) || vol < 0) continue;
                if (!Number.isFinite(price)) continue;
                sLabels.push(String(name));
                sVolumes.push(vol);
                sPrices.push(price);
            }
            if (!sLabels.length) {
                ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No top markets data</div>';
                return;
            }

            try {
                topVolumeMarketsChart = new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: sLabels,
                        datasets: [
                            {
                                type: 'bar',
                                label: '24h Volume',
                                data: sVolumes.map(v => v / 1e9),
                                yAxisID: 'y',
                                backgroundColor: 'rgba(59,130,246,0.7)',
                                borderColor: '#3b82f6',
                                borderWidth: 1
                            },
                            {
                                type: 'line',
                                label: 'Price',
                                data: sPrices,
                                yAxisID: 'y1',
                                borderColor: '#10b981',
                                backgroundColor: '#10b98133',
                                tension: 0.3,
                                pointRadius: 0,
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: { beginAtZero: true, title: { display: true, text: 'Volume (B USD)' }, grid: { color: 'rgba(0,0,0,0.06)' } },
                            y1: { position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: 'Price (USD)' } },
                            x: { grid: { display: false }, ticks: { autoSkip: true, maxRotation: 0 } }
                        },
                        plugins: { legend: { position: 'top', labels: { boxWidth: 12 } } },
                        layout: { padding: { left: 8, right: 8, top: 8, bottom: 8 } }
                    }
                });
            } catch (err) {
                console.error('Failed to render Top Volume Markets chart', err);
                ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#6b7280;">No top markets data</div>';
            }
        }

        // ======================== Coin Event Calendar ========================
        function initCoinEventCalendar() {
            const el = document.getElementById('coinEventCalendar');
            if (!el) return;
            // Clear existing if reinitializing
            el.innerHTML = '';

            const isMobile = window.innerWidth < 768;
            const calendar = new FullCalendar.Calendar(el, {
                initialView: isMobile ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: isMobile ? 'listDay,listWeek,dayGridMonth' : 'dayGridMonth,listWeek,listMonth'
                },
                buttonText: { today: 'Today', month: 'Month', week: 'Week', day: 'Day', list: 'List' },
                stickyHeaderDates: true,
                height: 'auto',
                contentHeight: 'auto',
                aspectRatio: 1.6,
                navLinks: true,
                dayMaxEvents: true,
                displayEventTime: false,
                loading: function(isLoading) {
                    const l = document.getElementById('calendarLoading');
                    if (l) l.style.display = isLoading ? 'block' : 'none';
                },
                eventSources: [
                    {
                        url: '/api/main/events-calendar',
                        method: 'GET',
                        failure: function() {
                            console.error('Failed to load events');
                        }
                    }
                ],
                eventContent: function(arg) {
                    try {
                        const coins = (arg.event.extendedProps && Array.isArray(arg.event.extendedProps.coins)) ? arg.event.extendedProps.coins : [];
                        const cats = (arg.event.extendedProps && arg.event.extendedProps.categories) ? JSON.stringify(arg.event.extendedProps.categories).toLowerCase() : '';
                        const catClass = cats.includes('listing') ? 'cat-listing' : cats.includes('airdrop') ? 'cat-airdrop' : cats.includes('partnership') ? 'cat-partnership' : cats.includes('ama') ? 'cat-ama' : '';
                        const wrapper = document.createElement('div');
                        wrapper.style.display = 'flex';
                        wrapper.style.flexDirection = 'column';
                        const title = document.createElement('div');
                        title.textContent = arg.event.title;
                        title.style.fontWeight = '600';
                        title.style.fontSize = '0.9rem';
                        const row = document.createElement('div');
                        row.style.marginTop = '4px';
                        // category badge
                        if (catClass) {
                            const b = document.createElement('span');
                            b.className = 'badge ' + catClass;
                            b.textContent = catClass.replace('cat-','');
                            row.appendChild(b);
                        }
                        // coin badges (max 3)
                        coins.slice(0,3).forEach(c => {
                            const b = document.createElement('span');
                            b.className = 'badge coin';
                            b.textContent = c;
                            row.appendChild(b);
                        });
                        wrapper.appendChild(title);
                        wrapper.appendChild(row);
                        return { domNodes: [wrapper] };
                    } catch (e) {
                        return { text: arg.event.title };
                    }
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    const modal = document.getElementById('eventModal');
                    if (!modal) return;
                    // Populate modal
                    const ex = info.event.extendedProps || {};
                    document.getElementById('eventModalTitle').textContent = info.event.title || 'Event';
                    document.getElementById('eventModalDate').innerHTML = '<strong>Date:</strong> ' + (ex.displayed_date || new Date(info.event.start).toLocaleString());
                    const coins = Array.isArray(ex.coins) ? ex.coins : [];
                    document.getElementById('eventModalCoins').innerHTML = coins.length ? ('<strong>Coins:</strong> ' + coins.map(c => '<span class="badge coin">' + c + '</span>').join(' ')) : '';
                    const catsStr = ex.categories ? JSON.stringify(ex.categories) : '';
                    document.getElementById('eventModalCategories').innerHTML = catsStr ? ('<strong>Categories:</strong> ' + catsStr) : '';
                    document.getElementById('eventModalProof').innerHTML = ex.proof ? ('<strong>Proof:</strong> ' + ex.proof) : '';
                    const link = document.getElementById('eventModalLink');
                    if (info.event.url) { link.href = info.event.url; link.style.display = 'inline-block'; } else { link.removeAttribute('href'); link.style.display = 'none'; }
                    modal.style.display = 'block';
                },
                eventDidMount: function(arg) {
                    const coins = (arg.event.extendedProps && arg.event.extendedProps.coins) ? arg.event.extendedProps.coins.join(', ') : '';
                    const date = (arg.event.extendedProps && arg.event.extendedProps.displayed_date) ? arg.event.extendedProps.displayed_date : '';
                    arg.el.title = [arg.event.title, coins, date].filter(Boolean).join('\n');
                }
            });
            calendar.render();

            // Responsive switch on resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    const wantMobile = window.innerWidth < 768;
                    const current = calendar.view.type;
                    const target = wantMobile ? 'listWeek' : 'dayGridMonth';
                    if (current !== target) {
                        calendar.changeView(target);
                    }
                    calendar.updateSize();
                }, 200);
            });
        }
    </script>
@endsection