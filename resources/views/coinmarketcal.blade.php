@extends('layouts.base')

@section('styles')
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{ url('css/datatables.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
    <!-- Dark Mode CSS (disabled by default) -->
    <link id="dark-theme-css" href="{{ url('css/darkmode.css') }}" rel="stylesheet" disabled>
    <!-- Custom CoinMarketCal CSS -->
    <link href="{{ url('css/coinmarketcal.css') }}" rel="stylesheet">
    <style>
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

        <!-- Begin::Section -->
        <div class="m-portlet custom-modern">
            <div class="m-portlet__head custom-modern">
                <div class="m-portlet__head-title custom-modern">
                    <span class="icon">&#128202;</span>
                    <span>CoinMarketCal Events</span>
                </div>
                <div class="m-portlet__head-desc custom-modern">
                    <!-- Optional description -->
                </div>
                <button id="theme-toggle" class="modern-update-btn" style="margin-left:auto;">
                    <span id="theme-toggle-icon">🌙</span>
                    <span id="theme-toggle-text">Dark Mode</span>
                </button>
            </div>

            <div class="m-portlet__body">
                <!-- Hidden route for AJAX -->
                <input type="hidden" id="coinmarketcal_route" value="{{ route('datatable.coinmarketcal') }}">
                <div id="coinmarketcal_wrapper" class="table-responsive mt-5">
                    <table id="coinmarketcal" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                            <tr>
                                <th>
                                    <span style="font-weight:900; font-size:20px;">&#128181;</span>
                                    <span style="font-weight:900;">Symbol</span>
                                </th>
                                <th>
                                    <span style="font-weight:900; font-size:20px;">&#128202;</span>
                                    <span style="font-weight:900;">Name</span>
                                </th>
                                <th>
                                    <span style="font-weight:900; font-size:20px;">&#11088;</span>
                                    <span style="font-weight:900;">Rank</span>
                                </th>
                                <th>
                                    <span style="font-weight:900; font-size:20px;">&#128196;</span>
                                    <span style="font-weight:900;">Fullname</span>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- End::Section -->
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('js/coinmarketcal.js') }}"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- Theme Switcher -->
    <script src="{{ url('js/theme-switcher.js') }}"></script>
    <!-- Highlight Plugin -->
    <script src="https://bartaz.github.io/sandbox.js/jquery.highlight.js"></script>
@endsection