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
                <div class="platform-overview">
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
        width: 100%;
        box-sizing: border-box;
    }

    .search-container {
        display: flex;
        gap: 1em;
        align-items: center;
        margin-bottom: 1em;
        width: 100%;
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

    /* Mobile responsive styles for coin search */
    @media (max-width: 768px) {
        .coin-search-section {
            padding: 1em;
            border-radius: 1em;
            margin-bottom: 1.5em;
        }

        .search-container {
            flex-direction: column;
            gap: 0.8em;
            align-items: stretch;
        }

        .coin-search-input {
            padding: 0.9em 1em;
            font-size: 1rem;
            border-radius: 0.8em;
            border-width: 1.5px;
        }

        .search-btn {
            padding: 0.9em 1em;
            font-size: 1rem;
            border-radius: 0.8em;
            width: 100%;
            min-width: auto;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .coin-search-section {
            padding: 0.8em;
            border-radius: 0.8em;
            margin-bottom: 1em;
        }

        .search-container {
            gap: 0.6em;
        }

        .coin-search-input {
            padding: 0.8em 0.9em;
            font-size: 0.95rem;
            border-radius: 0.7em;
        }

        .search-btn {
            padding: 0.8em 0.9em;
            font-size: 0.95rem;
            border-radius: 0.7em;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .coin-search-section {
            padding: 0.7em;
            border-radius: 0.7em;
        }

        .search-container {
            gap: 0.5em;
        }

        .coin-search-input {
            padding: 0.7em 0.8em;
            font-size: 0.9rem;
            border-radius: 0.6em;
        }

        .search-btn {
            padding: 0.7em 0.8em;
            font-size: 0.9rem;
            border-radius: 0.6em;
        }
    }

    /* Tablet responsive adjustments */
    @media (min-width: 769px) and (max-width: 1024px) {
        .coin-search-section {
            padding: 1.2em;
        }

        .search-container {
            gap: 0.8em;
        }

        .coin-search-input {
            padding: 0.7em 1em;
            font-size: 1rem;
        }

        .search-btn {
            padding: 0.7em 1.2em;
            font-size: 1rem;
        }
    }

    /* Large desktop screens */
    @media (min-width: 1200px) {
        .coin-search-section {
            padding: 2em;
            border-radius: 2em;
        }

        .search-container {
            gap: 1.2em;
        }

        .coin-search-input {
            padding: 1em 1.5em;
            font-size: 1.2em;
        }

        .search-btn {
            padding: 1em 2em;
            font-size: 1.2em;
        }
    }

    /* Touch-friendly improvements for mobile */
    @media (max-width: 768px) {
        .coin-search-input {
            touch-action: manipulation;
            -webkit-appearance: none;
            appearance: none;
        }

        .search-btn {
            touch-action: manipulation;
            -webkit-appearance: none;
            appearance: none;
            min-height: 44px; /* Minimum touch target size */
        }

        .coin-search-input:focus {
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }
    }

    /* Improve accessibility */
    .coin-search-input {
        position: relative;
    }

    .coin-search-input:focus {
        outline: none;
    }

    .search-btn:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* Ensure proper text sizing */
    .coin-search-input {
        font-family: inherit;
        line-height: 1.5;
    }

    /* Prevent zoom on iOS */
    @media screen and (-webkit-min-device-pixel-ratio: 0) {
        .coin-search-input {
            font-size: 16px;
        }
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
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5em;
        margin-bottom: 2em;
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
        width: 100% !important;
        height: 280px !important;
        position: relative;
        overflow: hidden;
        flex: 1;
        min-height: 280px;
        max-height: 280px;
    }

    .chart-container canvas {
        max-width: 100% !important;
        max-height: 100% !important;
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
    }

    /* Mobile-specific chart adjustments */
    @media (max-width: 768px) {
        .chart-grid {
            grid-template-columns: 1fr;
            gap: 1em;
        }

        .chart-card {
            padding: 1em;
            min-height: 300px;
            margin-bottom: 1em;
        }

        .chart-container {
            height: 250px !important;
            min-height: 250px;
            max-height: 250px;
        }

        .chart-card h4 {
            font-size: 1.1em;
            margin-bottom: 0.8em;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .chart-card {
            padding: 0.8em;
            min-height: 280px;
        }

        .chart-container {
            height: 220px !important;
            min-height: 220px;
            max-height: 220px;
        }

        .chart-card h4 {
            font-size: 1em;
            margin-bottom: 0.6em;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .chart-container {
            height: 200px !important;
            min-height: 200px;
            max-height: 200px;
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
    }

    /* Better chart responsiveness */
    .chart-container canvas {
        touch-action: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
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
    }

    .trend-value {
        font-weight: 700;
        font-size: 1.3em;
        color: #333;
        flex-shrink: 0;
        min-width: 60px;
        text-align: right;
    }

    /* Mobile responsive styles for trends summary */
    @media (max-width: 768px) {
        .trends-summary {
            grid-template-columns: 1fr;
            gap: 1em;
            margin-top: 0.8em;
        }

        .trend-item {
            padding: 1em;
            gap: 0.8em;
            border-radius: 0.8em;
        }

        .trend-icon {
            font-size: 1.5em;
        }

        .trend-label {
            font-size: 0.95rem;
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
        }

        .trend-item {
            padding: 0.8em;
            gap: 0.6em;
            flex-wrap: wrap;
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
        .trend-item {
            padding: 0.7em;
            gap: 0.5em;
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

    /* Tablet responsive adjustments */
    @media (min-width: 769px) and (max-width: 1024px) {
        .trends-summary {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.2em;
        }

        .trend-item {
            padding: 1em;
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
        }

        .trend-item {
            padding: 1.5em;
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

        // Load CoinPaprika data via AJAX
        function loadCoinPaprikaData() {
            fetch('/api/coinpaprika-data')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCoinPaprikaBlock(data.data);
                    } else {
                        console.error('Error loading CoinPaprika data:', data.message);
                        updateCoinPaprikaBlock({ error: true });
                    }
                })
                .catch(error => {
                    console.error('Error fetching CoinPaprika data:', error);
                    updateCoinPaprikaBlock({ error: true });
                });
        }

        // Load Cryptics data via AJAX
        function loadCrypticsData() {
            fetch('/api/cryptics-data')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCrypticsBlock(data.data);
                    } else {
                        console.error('Error loading Cryptics data:', data.message);
                        updateCrypticsBlock({ error: true });
                    }
                })
                .catch(error => {
                    console.error('Error fetching Cryptics data:', error);
                    updateCrypticsBlock({ error: true });
                });
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
            // Update platform overview cards (excluding coinpaprika and cryptics)
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

        });

    </script>
@endsection