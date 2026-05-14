@extends('layouts.base')

{{-- ======================== Page Title Section ======================== --}}
@section('title')
    Advanced Markets Comparison - Crypto Trading
@endsection

{{-- ======================== Styles Section ======================== --}}
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/history.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .platform-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 20px;
            margin: 15px 0;
            color: white;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .platform-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .platform-card.livecoinwatch { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); }
        .platform-card.coingecko { background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%); }
        .platform-card.coinmarketcal { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; }
        .platform-card.cryptocompare { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333; }
        .platform-card.coinpaprika { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .platform-card.cryptics { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .metric-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        }

        .metric-value {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
        }

        .metric-label {
            color: #666;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .sentiment-indicator {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8em;
        }

        .sentiment-bullish { background: #4ade80; color: white; }
        .sentiment-bearish { background: #f87171; color: white; }
        .sentiment-neutral { background: #9ca3af; color: white; }

        .fear-greed-meter {
            width: 100%;
            height: 20px;
            background: linear-gradient(to right, #ef4444, #f59e0b, #10b981);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .fear-greed-indicator {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 4px;
            background: #1f2937;
            border-radius: 2px;
            transition: left 0.5s ease;
        }

        .correlation-matrix {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin: 20px 0;
        }

        .correlation-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .correlation-value {
            font-size: 1.5em;
            font-weight: bold;
            margin: 10px 0;
        }

        .high-correlation { color: #10b981; }
        .medium-correlation { color: #f59e0b; }
        .low-correlation { color: #ef4444; }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .responsive-chart {
            position: relative;
            height: 400px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .comparison-grid {
                grid-template-columns: 1fr;
            }

            .responsive-chart {
                height: 300px;
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
                    {{-- Advanced Comparison Icon SVG --}}
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="16" cy="16" r="16" fill="url(#advancedGradient)"/>
                        <path d="M8 8h4l2-4 2 4h4M8 16h4l2-4 2 4h4M8 24h4l2-4 2 4h4" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <defs>
                            <linearGradient id="advancedGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#667eea"/>
                                <stop offset="1" stop-color="#764ba2"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>
                <span class="modern-title-text" data-lang-key="advanced_platforms_comparison">Advanced Multi-Platform Comparison</span>
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

        {{-- ======================== Platform Overview Section ======================== --}}
        <div class="platform-overview-section" style="margin-top: 2em;">
            <div class="modern-title-bar">
                <div class="m-portlet__head-title custom-modern">
                    <span class="modern-title-icon">
                        <i class="fas fa-chart-line" style="font-size: 24px; color: #667eea;"></i>
                    </span>
                    <span class="modern-title-text">Multi-Platform Data Sources</span>
                </div>
                <button id="refreshComparison" class="modern-tab darkmode-switch" title="Refresh Comparison Data" aria-label="Refresh Comparison Data">
                    <span class="darkmode-switch-icon">
                        <i class="fas fa-sync-alt" style="font-size: 18px; color: #667eea;"></i>
                    </span>
                    <span data-lang-key="refresh">Refresh Data</span>
                </button>
            </div>

            {{-- Loading Spinner --}}
            <div id="comparisonLoading" class="loading-overlay" style="display:none;">
                <div class="spinner"></div>
            </div>

            {{-- Platform Cards Grid --}}
            <div class="comparison-grid">
                {{-- LiveCoinWatch Platform --}}
                <div class="platform-card livecoinwatch">
                    <h3><i class="fas fa-eye"></i> LiveCoinWatch</h3>
                    <div class="metric-value" id="lcw-total-coins">-</div>
                    <div class="metric-label">Total Coins</div>
                    <div class="metric-value" id="lcw-total-mcap">-</div>
                    <div class="metric-label">Total Market Cap</div>
                    <div class="metric-value" id="lcw-total-volume">-</div>
                    <div class="metric-label">Total Volume</div>
                </div>

                {{-- CoinGecko Platform --}}
                <div class="platform-card coingecko">
                    <h3><i class="fas fa-coins"></i> CoinGecko</h3>
                    <div class="metric-value" id="cg-total-coins">-</div>
                    <div class="metric-label">Total Coins</div>
                    <div class="metric-value" id="cg-total-mcap">-</div>
                    <div class="metric-label">Total Market Cap</div>
                    <div class="metric-value" id="cg-total-volume">-</div>
                    <div class="metric-label">Total Volume</div>
                </div>

                {{-- CoinMarketCal Platform --}}
                <div class="platform-card coinmarketcal">
                    <h3><i class="fas fa-calendar-alt"></i> CoinMarketCal</h3>
                    <div class="metric-value" id="cmc-total-coins">-</div>
                    <div class="metric-label">Total Coins</div>
                    <div class="metric-value" id="cmc-total-events">-</div>
                    <div class="metric-label">Total Events</div>
                    <div class="metric-value" id="cmc-avg-hot-index">-</div>
                    <div class="metric-label">Avg Hot Index</div>
                </div>

                {{-- CryptoCompare Platform --}}
                <div class="platform-card cryptocompare">
                    <h3><i class="fas fa-exchange-alt"></i> CryptoCompare</h3>
                    <div class="metric-value" id="cc-total-coins">-</div>
                    <div class="metric-label">Total Coins</div>
                    <div class="metric-value" id="cc-total-mcap">-</div>
                    <div class="metric-label">Total Market Cap</div>
                    <div class="metric-value" id="cc-total-volume">-</div>
                    <div class="metric-label">Total Volume</div>
                </div>

                {{-- CoinPaprika Platform --}}
                <div class="platform-card coinpaprika">
                    <h3><i class="fas fa-paprika"></i> CoinPaprika</h3>
                    <div class="metric-value" id="cp-total-coins">-</div>
                    <div class="metric-label">Total Coins</div>
                    <div class="metric-value" id="cp-active-coins">-</div>
                    <div class="metric-label">Active Coins</div>
                    <div class="metric-value" id="cp-new-coins">-</div>
                    <div class="metric-label">New Coins</div>
                </div>

                {{-- Cryptics.tech Platform --}}
                <div class="platform-card cryptics">
                    <h3><i class="fas fa-crystal-ball"></i> Cryptics.tech</h3>
                    <div class="metric-value" id="ct-total-predictions">-</div>
                    <div class="metric-label">Total Predictions</div>
                    <div class="metric-value" id="ct-accuracy">-</div>
                    <div class="metric-label">Prediction Accuracy</div>
                    <div class="metric-value" id="ct-trending-up">-</div>
                    <div class="metric-label">Trending Up</div>
                </div>
            </div>
        </div>

        {{-- ======================== Advanced Charts Section ======================== --}}
        <div class="advanced-charts-section" style="margin-top: 3em;">
            <div class="modern-title-bar">
                <div class="m-portlet__head-title custom-modern">
                    <span class="modern-title-icon">
                        <i class="fas fa-chart-area" style="font-size: 24px; color: #667eea;"></i>
                    </span>
                    <span class="modern-title-text">Advanced Analytics & Charts</span>
                </div>
            </div>

            {{-- Market Sentiment Chart --}}
            <div class="chart-container">
                <h4><i class="fas fa-brain"></i> Market Sentiment Analysis</h4>
                <div class="metric-card">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="metric-value" id="overall-sentiment">-</div>
                            <div class="metric-label">Overall Sentiment</div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-value" id="fear-greed-score">-</div>
                            <div class="metric-label">Fear & Greed Index</div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-value" id="large-cap-sentiment">-</div>
                            <div class="metric-label">Large Cap Sentiment</div>
                        </div>
                        <div class="col-md-3">
                            <div class="metric-value" id="mid-cap-sentiment">-</div>
                            <div class="metric-label">Mid Cap Sentiment</div>
                        </div>
                    </div>
                </div>
                <div class="fear-greed-meter">
                    <div class="fear-greed-indicator" id="fear-greed-indicator"></div>
                </div>
                <div class="responsive-chart">
                    <canvas id="sentimentChart"></canvas>
                </div>
            </div>

            {{-- Price Correlation Matrix --}}
            <div class="chart-container">
                <h4><i class="fas fa-project-diagram"></i> Cross-Platform Price Correlation</h4>
                <div class="correlation-matrix" id="correlation-matrix">
                    <!-- Dynamic correlation data will be inserted here -->
                </div>
                <div class="responsive-chart">
                    <canvas id="correlationChart"></canvas>
                </div>
            </div>

            {{-- Market Cap Distribution --}}
            <div class="chart-container">
                <h4><i class="fas fa-chart-pie"></i> Market Cap Distribution</h4>
                <div class="responsive-chart">
                    <canvas id="marketCapChart"></canvas>
                </div>
            </div>

            {{-- Volume Analysis --}}
            <div class="chart-container">
                <h4><i class="fas fa-chart-bar"></i> Trading Volume Analysis</h4>
                <div class="responsive-chart">
                    <canvas id="volumeChart"></canvas>
                </div>
            </div>

            {{-- Top Performers --}}
            <div class="chart-container">
                <h4><i class="fas fa-trophy"></i> Top Performers Analysis</h4>
                <div class="responsive-chart">
                    <canvas id="performersChart"></canvas>
                </div>
            </div>

            {{-- Exchange Performance --}}
            <div class="chart-container">
                <h4><i class="fas fa-building"></i> Exchange Performance</h4>
                <div class="responsive-chart">
                    <canvas id="exchangeChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ======================== Data Quality Metrics Section ======================== --}}
        <div class="data-quality-section" style="margin-top: 3em;">
            <div class="modern-title-bar">
                <div class="m-portlet__head-title custom-modern">
                    <span class="modern-title-icon">
                        <i class="fas fa-shield-alt" style="font-size: 24px; color: #667eea;"></i>
                    </span>
                    <span class="modern-title-text">Data Quality & Reliability Metrics</span>
                </div>
            </div>

            <div class="comparison-grid">
                <div class="metric-card">
                    <h5>Price Consistency Score</h5>
                    <div class="metric-value" id="price-consistency">-</div>
                    <div class="metric-label">Across All Platforms</div>
                </div>
                <div class="metric-card">
                    <h5>Market Cap Correlation</h5>
                    <div class="metric-value" id="mcap-correlation">-</div>
                    <div class="metric-label">Cross-Platform Accuracy</div>
                </div>
                <div class="metric-card">
                    <h5>Volume Correlation</h5>
                    <div class="metric-value" id="volume-correlation">-</div>
                    <div class="metric-label">Data Consistency</div>
                </div>
                <div class="metric-card">
                    <h5>Platform Coverage</h5>
                    <div class="metric-value" id="platform-coverage">-</div>
                    <div class="metric-label">Cross-Platform Data</div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- ======================== Scripts Section ======================== --}}
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <script>
        // Global variables for charts
        let sentimentChart, correlationChart, marketCapChart, volumeChart, performersChart, exchangeChart;
        let comparisonData = {};

        // Initialize the page
        $(document).ready(function() {
            loadComparisonData();
            setupEventListeners();
            setupDarkMode();
        });

        // Setup event listeners
        function setupEventListeners() {
            $('#refreshComparison').on('click', function() {
                loadComparisonData();
            });
        }

        // Load comparison data from API
        function loadComparisonData() {
            $('#comparisonLoading').show();

            $.ajax({
                url: '{{ route("livecoinwatch.compare") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        comparisonData = response.data;
                        updatePlatformMetrics();
                        updateCharts();
                        updateDataQualityMetrics();
                    } else {
                        console.error('Failed to load comparison data:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading comparison data:', error);
                    console.error('XHR Status:', xhr.status);
                    console.error('Response Text:', xhr.responseText);
                },
                complete: function() {
                    $('#comparisonLoading').hide();
                }
            });
        }

        // Update platform metrics display
        function updatePlatformMetrics() {
            // LiveCoinWatch
            if (comparisonData.livecoinwatch) {
                $('#lcw-total-coins').text(comparisonData.livecoinwatch.total_coins?.toLocaleString() || '-');
                $('#lcw-total-mcap').text('$' + (comparisonData.livecoinwatch.total_market_cap / 1e9).toFixed(2) + 'B');
                $('#lcw-total-volume').text('$' + (comparisonData.livecoinwatch.total_volume / 1e9).toFixed(2) + 'B');
            }

            // CoinGecko
            if (comparisonData.coingecko) {
                $('#cg-total-coins').text(comparisonData.coingecko.total_coins?.toLocaleString() || '-');
                $('#cg-total-mcap').text('$' + (comparisonData.coingecko.market_cap_stats?.total / 1e9).toFixed(2) + 'B');
                $('#cg-total-volume').text('$' + (comparisonData.coingecko.volume_stats?.total / 1e9).toFixed(2) + 'B');
            }

            // CoinMarketCal
            if (comparisonData.coinmarketcal) {
                $('#cmc-total-coins').text(comparisonData.coinmarketcal.total_coins?.toLocaleString() || '-');
                $('#cmc-total-events').text(comparisonData.coinmarketcal.total_events?.toLocaleString() || '-');
                $('#cmc-avg-hot-index').text(comparisonData.coinmarketcal.index_stats?.hot_index_avg?.toFixed(2) || '-');
            }

            // CryptoCompare
            if (comparisonData.cryptocompare) {
                $('#cc-total-coins').text(comparisonData.cryptocompare.total_coins?.toLocaleString() || '-');
                $('#cc-total-mcap').text('$' + (comparisonData.cryptocompare.market_cap_stats?.total / 1e9).toFixed(2) + 'B');
                $('#cc-total-volume').text('$' + (comparisonData.cryptocompare.volume_stats?.total / 1e9).toFixed(2) + 'B');
            }

            // CoinPaprika
            if (comparisonData.coinpaprika) {
                $('#cp-total-coins').text(comparisonData.coinpaprika.total_coins?.toLocaleString() || '-');
                $('#cp-active-coins').text(comparisonData.coinpaprika.active_coins?.toLocaleString() || '-');
                $('#cp-new-coins').text(comparisonData.coinpaprika.new_coins?.toLocaleString() || '-');
            }

            // Cryptics.tech
            if (comparisonData.cryptics) {
                $('#ct-total-predictions').text(comparisonData.cryptics.total_predictions?.toLocaleString() || '-');
                $('#ct-accuracy').text((comparisonData.cryptics.prediction_accuracy * 100).toFixed(1) + '%');
                $('#ct-trending-up').text(comparisonData.cryptics.prediction_trends?.trending_up || '-');
            }
        }

        // Update data quality metrics
        function updateDataQualityMetrics() {
            if (comparisonData.comparison?.data_quality_metrics) {
                const metrics = comparisonData.comparison.data_quality_metrics;

                $('#price-consistency').text(metrics.price_consistency?.toFixed(2) + '%');
                $('#mcap-correlation').text(metrics.market_cap_correlation?.toFixed(3));
                $('#volume-correlation').text(metrics.volume_correlation?.toFixed(3));
                $('#platform-coverage').text(comparisonData.comparison.common_coins_count || 0);
            }

            // Update sentiment indicators
            if (comparisonData.market_sentiment) {
                const sentiment = comparisonData.market_sentiment;

                $('#overall-sentiment').html(getSentimentHTML(sentiment.overall_sentiment));
                $('#fear-greed-score').text(sentiment.fear_greed_index?.toFixed(0) || '-');
                $('#large-cap-sentiment').html(getSentimentHTML(sentiment.sentiment_by_market_cap?.large_cap));
                $('#mid-cap-sentiment').html(getSentimentHTML(sentiment.sentiment_by_market_cap?.mid_cap));

                // Update fear & greed indicator position
                if (sentiment.fear_greed_index) {
                    const position = (sentiment.fear_greed_index / 100) * 100;
                    $('#fear-greed-indicator').css('left', position + '%');
                }
            }
        }

        // Get sentiment HTML with appropriate styling
        function getSentimentHTML(sentiment) {
            if (!sentiment) return '-';

            const sentimentClass = sentiment === 'bullish' ? 'sentiment-bullish' :
                sentiment === 'bearish' ? 'sentiment-bearish' : 'sentiment-neutral';

            return `<span class="sentiment-indicator ${sentimentClass}">${sentiment}</span>`;
        }

        // Update all charts
        function updateCharts() {
            try {
                console.log('Starting chart updates...');
                console.log('Available data:', Object.keys(comparisonData));

                updateSentimentChart();
                updateCorrelationChart();
                updateMarketCapChart();
                updateVolumeChart();
                updatePerformersChart();
                updateExchangeChart();
                updateCorrelationMatrix();

                console.log('All charts updated successfully');
            } catch (error) {
                console.error('Error updating charts:', error);
            }
        }

        // Update sentiment chart
        function updateSentimentChart() {
            const ctx = document.getElementById('sentimentChart').getContext('2d');

            if (sentimentChart) {
                sentimentChart.destroy();
            }

            if (comparisonData.market_sentiment?.market_momentum) {
                const momentum = comparisonData.market_sentiment.market_momentum;

                // Provide fallback values for null data
                const shortTerm = momentum.short_term || 0;
                const mediumTerm = momentum.medium_term || shortTerm; // Use short term as fallback
                const longTerm = momentum.long_term || shortTerm;     // Use short term as fallback

                sentimentChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['24h', '7d', '30d'],
                        datasets: [{
                            label: 'Market Momentum (%)',
                            data: [shortTerm, mediumTerm, longTerm],
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Market Momentum Over Time'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }

        // Update correlation chart
        function updateCorrelationChart() {
            const ctx = document.getElementById('correlationChart').getContext('2d');

            if (correlationChart) {
                correlationChart.destroy();
            }

            if (comparisonData.price_correlation?.correlation_matrix) {
                const correlations = comparisonData.price_correlation.correlation_matrix;
                const symbols = Object.keys(correlations);
                const values = Object.values(correlations);

                correlationChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: symbols,
                        datasets: [{
                            label: 'Price Correlation',
                            data: values,
                            backgroundColor: values.map(v => v > 0.7 ? '#10b981' : v > 0.4 ? '#f59e0b' : '#ef4444'),
                    borderColor: '#1f2937',
                    borderWidth: 1
            }]
            },
                options: {
                    responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                        title: {
                            display: true,
                                text: 'Price Correlation Across Platforms'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                                max: 1
                        }
                    }
                }
            });
            }
        }

        // Update market cap chart
        function updateMarketCapChart() {
            const ctx = document.getElementById('marketCapChart').getContext('2d');

            if (marketCapChart) {
                marketCapChart.destroy();
            }

            if (comparisonData.market_cap_distribution?.distribution) {
                const distribution = comparisonData.market_cap_distribution.distribution;

                marketCapChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Mega Cap (>$10B)', 'Large Cap ($1B-$10B)', 'Mid Cap ($100M-$1B)', 'Small Cap ($10M-$100M)', 'Micro Cap (<$10M)'],
                        datasets: [{
                            data: [
                                distribution.mega_cap || 0,
                                distribution.large_cap || 0,
                                distribution.mid_cap || 0,
                                distribution.small_cap || 0,
                                distribution.micro_cap || 0
                            ],
                            backgroundColor: [
                                '#10b981',
                                '#3b82f6',
                                '#f59e0b',
                                '#ef4444',
                                '#8b5cf6'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Market Cap Distribution'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }

        // Update volume chart
        function updateVolumeChart() {
            const ctx = document.getElementById('volumeChart').getContext('2d');

            if (volumeChart) {
                volumeChart.destroy();
            }

            if (comparisonData.volume_analysis) {
                const analysis = comparisonData.volume_analysis;

                volumeChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['LiveCoinWatch', 'CoinGecko', 'CryptoCompare'],
                            datasets: [{
                                label: 'Total Volume ($)',
                                data: [
                                    analysis.livecoinwatch_volume?.total || 0,
                                analysis.coingecko_volume?.total || 0,
                            analysis.cryptocompare_volume?.total || 0
            ],
                backgroundColor: ['#ff6b6b', '#4ecdc4', '#ffecd2'],
                    borderColor: '#1f2937',
                    borderWidth: 1
            }]
            },
                options: {
                    responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                        title: {
                            display: true,
                                text: 'Trading Volume Comparison'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            }
        }

        // Update performers chart
        function updatePerformersChart() {
            const ctx = document.getElementById('performersChart').getContext('2d');

            if (performersChart) {
                performersChart.destroy();
            }

            if (comparisonData.top_performers?.by_market_cap) {
                const performers = comparisonData.top_performers.by_market_cap.slice(0, 10);
                const names = performers.map(p => p.symbol);
                const marketCaps = performers.map(p => p.market_cap / 1e9);

                performersChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: names,
                        datasets: [{
                            label: 'Market Cap (Billions $)',
                            data: marketCaps,
                            backgroundColor: '#667eea',
                            borderColor: '#1f2937',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        plugins: {
                            title: {
                                display: true,
                                text: 'Top 10 Coins by Market Cap'
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }

        // Update exchange chart
        function updateExchangeChart() {
            const ctx = document.getElementById('exchangeChart').getContext('2d');

            if (exchangeChart) {
                exchangeChart.destroy();
            }

            if (comparisonData.exchange_performance?.top_exchanges_by_volume) {
                const exchanges = comparisonData.exchange_performance.top_exchanges_by_volume.slice(0, 10);
                const names = exchanges.map(e => e.name);
                const volumes = exchanges.map(e => e.volume_24h_btc);

                exchangeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: names,
                        datasets: [{
                            label: '24h Volume (BTC)',
                            data: volumes,
                            backgroundColor: '#764ba2',
                            borderColor: '#1f2937',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Top Exchanges by Volume'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }

        // Update correlation matrix display
        function updateCorrelationMatrix() {
            if (comparisonData.comparison?.average_price_differences) {
                const differences = comparisonData.comparison.average_price_differences;
                const matrix = $('#correlation-matrix');
                matrix.empty();

                Object.entries(differences).forEach(([key, value]) => {
                    const platforms = key.split('_vs_');
                const platform1 = platforms[0].toUpperCase();
                const platform2 = platforms[1].toUpperCase();

                const correlationClass = value < 1 ? 'high-correlation' :
                    value < 5 ? 'medium-correlation' : 'low-correlation';

                matrix.append(`
                        <div class="correlation-item">
                            <div class="metric-label">${platform1} vs ${platform2}</div>
                            <div class="correlation-value ${correlationClass}">${value.toFixed(2)}%</div>
                            <div class="metric-label">Price Difference</div>
                        </div>
                    `);
            });
            }
        }

        // Dark mode functionality
        function setupDarkMode() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const darkModeIcon = document.getElementById('darkModeIcon');
            const darkModeText = document.getElementById('darkModeText');

            darkModeToggle.addEventListener('click', function() {
                const isDark = document.body.classList.toggle('dark-mode');
                darkModeToggle.setAttribute('aria-checked', isDark);

                if (isDark) {
                    darkModeText.textContent = 'Light Mode';
                    darkModeIcon.classList.add('dark');
                } else {
                    darkModeText.textContent = 'Dark Mode';
                    darkModeIcon.classList.remove('dark');
                }

                // Update charts for dark mode
                updateChartsForDarkMode(isDark);
            });
        }

        // Update charts for dark mode
        function updateChartsForDarkMode(isDark) {
            const textColor = isDark ? '#ffffff' : '#000000';
            const gridColor = isDark ? '#333333' : '#e5e7eb';

            // Update all charts with new colors
            [sentimentChart, correlationChart, marketCapChart, volumeChart, performersChart, exchangeChart].forEach(chart => {
                if (chart) {
                    chart.options.plugins.title.color = textColor;
                    chart.options.scales.x.grid.color = gridColor;
                    chart.options.scales.y.grid.color = gridColor;
                    chart.options.scales.x.ticks.color = textColor;
                    chart.options.scales.y.ticks.color = textColor;
                    chart.update();
                }
            });
        }
    </script>
@endsection