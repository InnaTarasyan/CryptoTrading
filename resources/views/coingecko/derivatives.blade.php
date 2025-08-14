@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/derivatives.css') }}" rel="stylesheet">
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
        <!-- Modern Title Bar with Icon -->
        <div class="modern-title-bar" aria-labelledby="derivativesTitle" role="banner">
            <div class="modern-title-bar-row">
                <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
                    <span class="modern-title-icon" tabindex="0" title="Derivatives Overview">
                        <!-- Derivatives Icon SVG (Pink Gradient) -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="derivativesGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff6a88"/>
                                    <stop offset="1" stop-color="#ff99ac"/>
                                </linearGradient>
                            </defs>
                            <rect x="4" y="4" width="24" height="24" rx="8" fill="url(#derivativesGradient)"/>
                            <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="modern-title-text" id="derivativesTitle">Coingecko Derivatives</span>
                </div>
                <div class="modern-title-actions">
                    <div class="modern-title-actions-group">
                        <!-- Dark Mode Toggle (already present) -->
                        <button id="darkModeToggle" class="modern-tab darkmode-switch enhanced-darkmode" title="Toggle dark/light mode" role="switch" aria-checked="false" aria-label="Toggle dark mode" tabindex="0">
                            <div class="darkmode-switch-track">
                                <div class="darkmode-switch-thumb">
                                    <span class="darkmode-switch-icon" id="darkModeIcon">
                                        <!-- Sun & Moon SVG with smooth transitions -->
                                        <svg class="icon-moon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" fill="#ffd200"/>
                                            <circle cx="12" cy="12" r="3" fill="#fff" opacity="0.8"/>
                                        </svg>
                                        <svg class="icon-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none;">
                                            <circle cx="12" cy="12" r="5" fill="#ffb300"/>
                                            <g stroke="#ffb300" stroke-width="2" opacity="0.9">
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
                                </div>
                            </div>
                            <span id="darkModeText" class="darkmode-switch-label">Dark Mode</span>
                            <span class="darkmode-status-indicator" id="darkModeStatus" aria-live="polite"></span>
                        </button>
                        <!-- Reload Button -->
                        <button id="reloadTableBtn" class="modern-tab modern-reload-btn" title="Reload Table" aria-label="Reload Table" tabindex="0" type="button">
                            <span class="reload-icon-bg">
                                <svg class="icon-reload" width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <defs>
                                        <linearGradient id="reloadGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#ff6a88"/>
                                            <stop offset="1" stop-color="#ff99ac"/>
                                        </linearGradient>
                                    </defs>
                                    <circle cx="12" cy="12" r="10" fill="#fff"/>
                                    <path d="M19 8A7 7 0 1 0 20 12h-1.5" stroke="url(#reloadGradient)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <polyline points="18 2 18 9 25 9" stroke="url(#reloadGradient)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                                <span class="reload-spinner" style="display:none;">
                                    <svg width="22" height="22" viewBox="0 0 50 50"><circle cx="25" cy="25" r="20" fill="none" stroke="#ff6a88" stroke-width="4" stroke-linecap="round" stroke-dasharray="31.4 31.4" stroke-dashoffset="0"><animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.8s" repeatCount="indefinite"/></circle></svg>
                                </span>
                            </span>
                            <span class="reload-switch-label">Reload</span>
                        </button>
                        <!-- Full Screen Button (already present) -->
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


        <!-- Navigation Tabs BELOW Title Bar -->
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
        <!-- DataTable Section -->
        <div class="m-portlet enhanced-portlet">
            <div class="m-portlet__body mt-5 enhanced-portlet-body">
                <input type="hidden" id="coingecko_derivatives_route" value="{{ route('datatable.coingecko.derivatives') }}">
                <div id="datatableFullscreenContainer" class="table-responsive enhanced-table-container">
                    <table id="coingecko_derivatives" class="table table-hover table-condensed table-striped enhanced-table" style="width:100%; padding-top:1%">
                        <thead class="enhanced-thead">
                        <tr>
                            <th class="enhanced-th">Market</th>
                            <th class="enhanced-th">Index Id</th>
                            <th class="enhanced-th">Price</th>
                            <th class="enhanced-th">Price % Change 24h</th>
                            <th class="enhanced-th">Contract Type</th>
                            <th class="enhanced-th">Index</th>
                            <th class="enhanced-th">Basis</th>
                            <th class="enhanced-th">Spread</th>
                            <th class="enhanced-th">Funding Rate</th>
                            <th class="enhanced-th">Open Interest</th>
                            <th class="enhanced-th">Volume 24h</th>
                            <th class="enhanced-th">Last Traded At</th>
                            <th class="enhanced-th">Expired At</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- Info Block: About Coingecko Derivatives and This DataTable -->
        <div class="derivatives-info-block">
            <div class="derivatives-info-section">
                <div class="info-icon-bg">
                    <!-- Derivatives Icon -->
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <defs>
                            <linearGradient id="derivInfoGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#ff6a88"/>
                                <stop offset="1" stop-color="#ff99ac"/>
                            </linearGradient>
                        </defs>
                        <rect x="4" y="4" width="24" height="24" rx="8" fill="url(#derivInfoGradient)"/>
                        <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h3 class="info-title">What are Coingecko Derivatives?</h3>
                    <p>
                        <strong>Coingecko Derivatives</strong> provide real-time data and analytics for crypto derivatives markets, including futures and options. These instruments allow traders to hedge, speculate, and manage risk on cryptocurrencies. Coingecko aggregates data from top exchanges, offering insights into open interest, funding rates, contract types, and more, empowering both institutional and retail traders to make informed decisions in the fast-evolving crypto derivatives landscape.
                    </p>
                </div>
            </div>
            <div class="derivatives-info-section">
                <div class="info-icon-bg">
                    <!-- DataTable Icon -->
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <defs>
                            <linearGradient id="tableInfoGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#ffd200"/>
                                <stop offset="1" stop-color="#ff99ac"/>
                            </linearGradient>
                        </defs>
                        <rect x="4" y="4" width="24" height="24" rx="8" fill="url(#tableInfoGradient)"/>
                        <rect x="8" y="10" width="16" height="2" rx="1" fill="#fff"/>
                        <rect x="8" y="16" width="16" height="2" rx="1" fill="#fff"/>
                        <rect x="8" y="22" width="10" height="2" rx="1" fill="#fff"/>
                    </svg>
                </div>
                <div>
                    <h3 class="info-title">About the Derivatives DataTable</h3>
                    <p>
                        <strong>This DataTable</strong> provides a comprehensive, real-time overview of key metrics for crypto derivatives contracts. Each row represents a specific contract, and each column offers a unique insight:
                    </p>
                    <ul class="datatable-columns-list">
                        <li><span class="col-icon">💹</span> <b>Market:</b> The exchange or platform where the derivative is traded.</li>
                        <li><span class="col-icon">🆔</span> <b>Index Id:</b> The identifier for the underlying index or asset.</li>
                        <li><span class="col-icon">💲</span> <b>Price:</b> The current price of the derivative contract.</li>
                        <li><span class="col-icon">📈</span> <b>Price % Change 24h:</b> The percentage change in price over the last 24 hours.</li>
                        <li><span class="col-icon">📄</span> <b>Contract Type:</b> The type of derivative (e.g., perpetual, futures, options).</li>
                        <li><span class="col-icon">🔗</span> <b>Index:</b> The reference index used for pricing the contract.</li>
                        <li><span class="col-icon">🔀</span> <b>Basis:</b> The difference between the derivative price and the spot price of the underlying asset.</li>
                        <li><span class="col-icon">📊</span> <b>Spread:</b> The bid-ask spread for the contract.</li>
                        <li><span class="col-icon">💸</span> <b>Funding Rate:</b> The periodic payment exchanged between long and short positions (for perpetuals).</li>
                        <li><span class="col-icon">📦</span> <b>Open Interest:</b> The total number of outstanding contracts.</li>
                        <li><span class="col-icon">🔄</span> <b>Volume 24h:</b> The total trading volume in the last 24 hours.</li>
                        <li><span class="col-icon">⏰</span> <b>Last Traded At:</b> The timestamp of the most recent trade for the contract.</li>
                        <li><span class="col-icon">📅</span> <b>Expired At:</b> The expiration date/time of the contract (if applicable).</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Add Review Block -->
        <section class="derivatives-review-block">
            <div class="review-block-header">
                <span class="review-block-icon">
                    <!-- Review Icon SVG -->
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="reviewGradient" x1="0" y1="0" x2="28" y2="28" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ffd200"/></linearGradient></defs><circle cx="14" cy="14" r="14" fill="url(#reviewGradient)"/><path d="M9 12h10M9 16h6" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                </span>
                <h3 class="review-block-title">Add Your Review</h3>
            </div>
            <form id="reviewForm" class="modern-review-form" method="POST" action="{{ route('coingecko.derivatives.reviews.store') }}">
                @csrf
                <div class="review-form-row">
                    <div class="review-form-group">
                        <label for="reviewName"><span class="form-icon">👤</span> Name</label>
                        <input type="text" id="reviewName" name="name" required maxlength="255" placeholder="Your name">
                    </div>
                    <div class="review-form-group">
                        <label for="reviewEmail"><span class="form-icon">✉️</span> Email</label>
                        <input type="email" id="reviewEmail" name="email" required maxlength="255" placeholder="Your email">
                    </div>
                </div>
                <div class="review-form-row">
                    <div class="review-form-group">
                        <label for="reviewRating"><span class="form-icon">⭐</span> Rating</label>
                        <select id="reviewRating" name="rating" required>
                            <option value="">Select</option>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>
                        </select>
                    </div>
                    <div class="review-form-group">
                        <label for="reviewCountry"><span class="form-icon">🌍</span> Country</label>
                        <input type="text" id="reviewCountry" name="country" maxlength="100" placeholder="Country (optional)">
                    </div>
                </div>
                <div class="review-form-row">
                    <div class="review-form-group">
                        <label for="reviewExperience"><span class="form-icon">🎓</span> Experience Level</label>
                        <select id="reviewExperience" name="experience_level">
                            <option value="">Select</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Professional">Professional</option>
                        </select>
                    </div>
                    <div class="review-form-group">
                        <label for="reviewTitle"><span class="form-icon">📝</span> Title</label>
                        <input type="text" id="reviewTitle" name="title" required maxlength="255" placeholder="Review title">
                    </div>
                </div>
                <div class="review-form-row">
                    <div class="review-form-group review-form-group-full">
                        <label for="reviewComment"><span class="form-icon">💬</span> Comment</label>
                        <textarea id="reviewComment" name="comment" required maxlength="2000" rows="3" placeholder="Share your experience..."></textarea>
                    </div>
                </div>
                <div class="review-form-row">
                    <div class="review-form-group">
                        <label for="reviewPros"><span class="form-icon">👍</span> Pros</label>
                        <input type="text" id="reviewPros" name="pros" maxlength="1000" placeholder="Pros (optional)">
                    </div>
                    <div class="review-form-group">
                        <label for="reviewCons"><span class="form-icon">👎</span> Cons</label>
                        <input type="text" id="reviewCons" name="cons" maxlength="1000" placeholder="Cons (optional)">
                    </div>
                </div>
                <div class="review-form-row">
                    <div class="review-form-group">
                        <label for="reviewRecommend"><span class="form-icon">🤝</span> Would you recommend?</label>
                        <select id="reviewRecommend" name="recommend">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="review-form-group review-form-group-submit">
                        <button type="submit" class="modern-review-submit">
                            <span class="submit-icon">➕</span> Submit Review
                        </button>
                    </div>
                </div>
                <div id="reviewFormMsg"></div>
            </form>
            <div class="reviews-list-block">
                <h4 class="reviews-list-title"><span class="form-icon">🗂️</span> Previous User Reviews</h4>
                <div id="reviews-list"></div>
            </div>
        </section>
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
    <script src="{{ url('js/coingecko/derivatives.js') }}"></script>
    <script>
        // Enhanced Dark Mode Toggle Logic
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');
        const darkModeText = document.getElementById('darkModeText');
        const darkModeStatus = document.getElementById('darkModeStatus');
        function setDarkMode(enabled) {
            if (enabled) {
                document.body.classList.add('dark-mode');
                darkModeIcon.querySelector('.icon-moon').style.display = 'none';
                darkModeIcon.querySelector('.icon-sun').style.display = '';
                darkModeText.textContent = 'Light Mode';
                darkModeToggle.setAttribute('aria-checked', 'true');
                darkModeStatus.classList.add('active');
                darkModeStatus.title = 'Dark mode enabled';
            } else {
                document.body.classList.remove('dark-mode');
                darkModeIcon.querySelector('.icon-moon').style.display = '';
                darkModeIcon.querySelector('.icon-sun').style.display = 'none';
                darkModeText.textContent = 'Dark Mode';
                darkModeToggle.setAttribute('aria-checked', 'false');
                darkModeStatus.classList.remove('active');
                darkModeStatus.title = 'Dark mode disabled';
            }
        }
        // On load, set mode from localStorage or system preference
        (function() {
            let dark = localStorage.getItem('derivativesDarkMode');
            if (dark === null) {
                dark = window.matchMedia('(prefers-color-scheme: dark)').matches ? '1' : '0';
            }
            setDarkMode(dark === '1');
        })();
        darkModeToggle.addEventListener('click', function() {
            const isDark = !document.body.classList.contains('dark-mode');
            setDarkMode(isDark);
            localStorage.setItem('derivativesDarkMode', isDark ? '1' : '0');
        });
        darkModeToggle.addEventListener('keydown', function(e) {
            if (e.key === ' ' || e.key === 'Enter') {
                e.preventDefault();
                darkModeToggle.click();
            }
        });

        // Fullscreen Functionality for DataTable
        var fullscreenToggle = document.getElementById('fullscreenToggle');
        var fullscreenContainer = document.getElementById('datatableFullscreenContainer');
        var iconEnter = fullscreenToggle.querySelector('.icon-fullscreen');
        var iconExit = fullscreenToggle.querySelector('.icon-exit-fullscreen');
        var fullscreenText = document.getElementById('fullscreenText');
        var isFullscreen = false;
        function enterFullscreen() {
            fullscreenContainer.classList.add('fullscreen-active');
            iconEnter.style.display = 'none';
            iconExit.style.display = 'inline';
            fullscreenToggle.setAttribute('aria-pressed', 'true');
            fullscreenText.textContent = 'Exit Fullscreen';
            isFullscreen = true;
        }
        function exitFullscreen() {
            fullscreenContainer.classList.remove('fullscreen-active');
            iconEnter.style.display = 'inline';
            iconExit.style.display = 'none';
            fullscreenToggle.setAttribute('aria-pressed', 'false');
            fullscreenText.textContent = 'Fullscreen';
            isFullscreen = false;
        }
        fullscreenToggle.addEventListener('click', function() {
            if (!isFullscreen) {
                enterFullscreen();
            } else {
                exitFullscreen();
            }
        });
        // ESC key to exit fullscreen
        document.addEventListener('keydown', function(e) {
            if (isFullscreen && (e.key === 'Escape' || e.key === 'Esc')) {
                exitFullscreen();
            }
        });

        // Reload Button Functionality
        const reloadBtn = document.getElementById('reloadTableBtn');
        const reloadIcon = reloadBtn.querySelector('.icon-reload');
        const reloadSpinner = reloadBtn.querySelector('.reload-spinner');
        reloadBtn.addEventListener('click', function() {
            reloadBtn.setAttribute('aria-busy', 'true');
            reloadIcon.style.display = 'none';
            reloadSpinner.style.display = 'inline-block';
            // Reload DataTable
            if (window.$ && $('#coingecko_derivatives').length && $.fn.dataTable) {
                $('#coingecko_derivatives').DataTable().ajax.reload(function() {
                    reloadBtn.removeAttribute('aria-busy');
                    reloadIcon.style.display = '';
                    reloadSpinner.style.display = 'none';
                }, false);
            } else {
                setTimeout(function() {
                    reloadBtn.removeAttribute('aria-busy');
                    reloadIcon.style.display = '';
                    reloadSpinner.style.display = 'none';
                }, 800);
            }
        });

        // Enhance Last Traded At and Expired At columns with icons after DataTable draw
        function enhanceDateColumns() {
            $('#coingecko_derivatives tbody tr').each(function() {
                var $tds = $(this).find('td');
                // Last Traded At is the 12th column (index 11)
                var $lastTraded = $tds.eq(11);
                var lastTradedVal = $lastTraded.text().trim();
                if (lastTradedVal && !$lastTraded.hasClass('iconified')) {
                    $lastTraded.html('<span class="date-icon" title="Last Traded At" aria-label="Last Traded At">\
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="vertical-align:middle; margin-right:4px;"><circle cx="12" cy="12" r="10" fill="#ffdde1"/><circle cx="12" cy="12" r="8" fill="#fff"/><path d="M12 7v5l3 3" stroke="#ff6a88" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>\
                    </span>' + lastTradedVal);
                    $lastTraded.addClass('iconified');
                }
                // Expired At is the 13th column (index 12)
                var $expiredAt = $tds.eq(12);
                var expiredAtVal = $expiredAt.text().trim();
                if (expiredAtVal && !$expiredAt.hasClass('iconified')) {
                    $expiredAt.html('<span class="date-icon" title="Expired At" aria-label="Expired At">\
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="vertical-align:middle; margin-right:4px;"><rect x="3" y="5" width="18" height="16" rx="4" fill="#ffdde1"/><rect x="6" y="8" width="12" height="10" rx="2" fill="#fff"/><rect x="9" y="11" width="6" height="2" rx="1" fill="#ff6a88"/></svg>\
                    </span>' + expiredAtVal);
                    $expiredAt.addClass('iconified');
                }
            });
        }
        // Run after DataTable draw
        $(document).ready(function() {
            var table = $('#coingecko_derivatives').DataTable();
            table.on('draw', enhanceDateColumns);
            enhanceDateColumns();
        });
    </script>
@endsection