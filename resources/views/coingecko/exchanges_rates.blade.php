@extends('layouts.base')
@section('styles')
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
<link href="{{ url('css/datatables.css') }}" rel="stylesheet">
<link href="{{ url('css/exchanges_rates.css') }}" rel="stylesheet">
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
    <div class="modern-title-bar" aria-labelledby="exchangeRatesTitle" role="banner">
        <div class="modern-title-bar-row">
            <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
                <span class="modern-title-icon" tabindex="0" title="Exchange Rates Overview">
                    <!-- Exchange Rates Icon SVG (Pink Gradient) -->
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="exchangeRatesGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#ff6a88"/>
                                <stop offset="1" stop-color="#ff99ac"/>
                            </linearGradient>
                        </defs>
                        <circle cx="16" cy="16" r="16" fill="url(#exchangeRatesGradient)"/>
                        <text x="16" y="22" text-anchor="middle" font-size="16" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text>
                    </svg>
                </span>
                <span class="modern-title-text" id="exchangeRatesTitle">Coingecko Exchange Rates</span>
            </div>
            <!-- Toolbar Buttons -->
            <div class="datatable-toolbar responsive-toolbar" style="gap: 0.7em; display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end;">
                <button id="darkModeToggle" class="modern-toolbar-btn toolbar-btn-with-label" title="Toggle Dark Mode" aria-label="Toggle Dark Mode" tabindex="0">
                    <span class="toolbar-icon">
                        <svg id="darkModeSvg" width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <radialGradient id="moonGradient" cx="50%" cy="50%" r="50%">
                                    <stop offset="0%" stop-color="#ffd200"/>
                                    <stop offset="100%" stop-color="#ff6a88"/>
                                </radialGradient>
                            </defs>
                            <circle cx="13" cy="13" r="11" fill="url(#moonGradient)"/>
                            <path id="moonPath" d="M18 13c0 3.31-2.69 6-6 6a6 6 0 0 1 0-12c.34 0 .67.03 1 .08A5 5 0 0 0 18 13z" fill="#fff"/>
                        </svg>
                    </span>
                    <span class="toolbar-label">Dark</span>
                    <span class="ripple"></span>
                </button>
                <button id="refreshTable" class="modern-toolbar-btn toolbar-btn-with-label" title="Refresh Table" aria-label="Refresh Table" tabindex="0">
                    <span class="toolbar-icon">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="refreshGradient" x1="0" y1="0" x2="26" y2="26" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#43cea2"/>
                                    <stop offset="1" stop-color="#185a9d"/>
                                </linearGradient>
                            </defs>
                            <circle cx="13" cy="13" r="11" fill="url(#refreshGradient)"/>
                            <path d="M19 13a6 6 0 1 1-2.47-4.85" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            <polyline points="17 7 20 8 19 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                    </span>
                    <span class="toolbar-label">Reload</span>
                    <span class="ripple"></span>
                </button>
                <button id="fullscreenToggle" class="modern-toolbar-btn toolbar-btn-with-label" title="Full Screen Table" aria-label="Full Screen Table" tabindex="0">
                    <span class="toolbar-icon">
                        <svg id="fullscreenSvg" width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="fullscreenGradient" x1="0" y1="0" x2="26" y2="26" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff6a88"/>
                                    <stop offset="1" stop-color="#ff99ac"/>
                                </linearGradient>
                            </defs>
                            <circle cx="13" cy="13" r="11" fill="url(#fullscreenGradient)"/>
                            <g id="fullscreenIconGroup">
                                <polyline points="8 8 8 11 11 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                <polyline points="18 8 15 8 15 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                <polyline points="8 18 8 15 11 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                <polyline points="18 18 15 18 15 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </g>
                        </svg>
                    </span>
                    <span class="toolbar-label">Full</span>
                    <span class="ripple"></span>
                </button>
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


    <!-- Navigation Tabs -->
    <div class="modern-tabs-container gradient-tabs-bg">
        <nav class="modern-tabs beautiful-tabs" aria-label="Main navigation">
            <a href="/coingeckomarketsindex" class="modern-tab beautiful-tab" tabindex="0">
                <span class="tab-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ff6a88"/><path d="M12 7v5l4 2" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <span class="tab-label">Markets</span>
            </a>
            <a href="/coingeckoexchangesindex" class="modern-tab beautiful-tab" tabindex="0">
                <span class="tab-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                </span>
                <span class="tab-label">Exchanges</span>
            </a>
            <a href="/coingeckotrendingsindex" class="modern-tab beautiful-tab" tabindex="0">
                <span class="tab-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"/><path d="M8 16l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                </span>
                <span class="tab-label">Trendings</span>
            </a>
            <a href="/coingeckoexchangeratesindex" class="modern-tab beautiful-tab active" tabindex="0">
                <span class="tab-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"/><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>
                </span>
                <span class="tab-label">Exchange Rates</span>
            </a>
            <a href="/coingeckonftsindex" class="modern-tab beautiful-tab" tabindex="0">
                <span class="tab-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"/><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">NFT</text></svg>
                </span>
                <span class="tab-label">NFTs</span>
            </a>
            <a href="/coingeckoderivativesindex" class="modern-tab beautiful-tab" tabindex="0">
                <span class="tab-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff99ac"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                </span>
                <span class="tab-label">Derivatives</span>
            </a>
            <a href="/coingeckoderivativesexchangesindex" class="modern-tab beautiful-tab" tabindex="0">
                <span class="tab-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6a88"/><path d="M8 16l4-8 4 8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                </span>
                <span class="tab-label">Derivatives Exchanges</span>
            </a>
        </nav>
    </div>
    <!-- DataTable Section -->
    <div class="m-portlet enhanced-portlet">
        <div class="m-portlet__body mt-5 enhanced-portlet-body">
            <input type="hidden" id="coingecko_exchange_rates_route" value="{{ route('datatable.coingecko.exchange_rates') }}">
            <!-- Enhanced Table Container -->
            <div id="datatableFullscreenContainer" class="table-responsive enhanced-table-container">
                <!-- DataTable Search Bar -->
                <!-- Removed duplicate search bar markup here. Let DataTables/JS handle the search bar. -->
                <div class="">
                    <table id="coingecko_exchange_rates" class="table table-hover table-condensed table-striped enhanced-table" style="width:100%; padding-top:1%">
                        <thead class="enhanced-thead">
                        <tr>
                            <th class="datatable-highlight-first enhanced-th">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Symbol</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <!-- Modern Symbol Icon with Gradient -->
                                    <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="symbolGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ff6a88"/>
                                                <stop offset="1" stop-color="#ff99ac"/>
                                            </linearGradient>
                                        </defs>
                                        <circle cx="12" cy="12" r="11" fill="url(#symbolGradient)"/>
                                        <text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">S</text>
                                    </svg>
                                </span>
                            </th>
                            <th class="enhanced-th">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Name</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <!-- Modern Name Icon with Gradient -->
                                    <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="nameGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#43cea2"/>
                                                <stop offset="1" stop-color="#185a9d"/>
                                            </linearGradient>
                                        </defs>
                                        <circle cx="12" cy="12" r="11" fill="url(#nameGradient)"/>
                                        <text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">N</text>
                                    </svg>
                                </span>
                            </th>
                            <th class="enhanced-th">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Unit</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <!-- Modern Unit Icon with Gradient -->
                                    <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="unitGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ffd200"/>
                                                <stop offset="1" stop-color="#ffb300"/>
                                            </linearGradient>
                                        </defs>
                                        <circle cx="12" cy="12" r="11" fill="url(#unitGradient)"/>
                                        <text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">U</text>
                                    </svg>
                                </span>
                            </th>
                            <th class="enhanced-th">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Value</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <!-- Modern Value Icon with Gradient -->
                                    <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="valueGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ff6a88"/>
                                                <stop offset="1" stop-color="#ff99ac"/>
                                            </linearGradient>
                                        </defs>
                                        <circle cx="12" cy="12" r="11" fill="url(#valueGradient)"/>
                                        <text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">V</text>
                                    </svg>
                                </span>
                            </th>
                            <th class="enhanced-th">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Type</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <!-- Modern Type Icon with Gradient -->
                                    <svg viewBox="0 0 24 24" fill="none" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="typeGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#ff99ac"/>
                                                <stop offset="1" stop-color="#ff6a88"/>
                                            </linearGradient>
                                        </defs>
                                        <circle cx="12" cy="12" r="11" fill="url(#typeGradient)"/>
                                        <text x="12" y="16" text-anchor="middle" font-size="14" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">T</text>
                                    </svg>
                                </span>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN: Info Block Below DataTable -->
<div class="enhanced-table-container info-block">
    <h2 class="info-title">🌐 What Are Coingecko Exchange Rates?</h2>
    <p class="info-desc">
        <b>Coingecko Exchange Rates</b> provide real-time conversion rates for cryptocurrencies and fiat currencies, powered by CoinGecko—the world’s largest independent crypto data aggregator. With data from over 14,000 assets and 1,200+ exchanges, you get a 360° view of the market to make smarter trading and investment decisions. <a href="https://www.coingecko.com/" target="_blank" rel="noopener">Learn more</a>.
    </p>
    <h2 class="info-title">📊 How to Use the Table Above</h2>
    <p class="info-desc">
        The interactive <b>DataTable</b> lets you search, sort, and filter exchange rates instantly. Click on any column to sort, use the search box to find specific assets, and enjoy a responsive design that works on any device. <a href="https://datatables.net/" target="_blank" rel="noopener">About DataTables</a>
    </p>
    <h3 class="info-columns-title">📝 What Each Column Means:</h3>
    <ul class="datatable-columns-list">
        <li><span class="datatable-columns-icon" aria-hidden="true">🔤</span> <b>Symbol:</b> Ticker symbol for the asset (e.g., BTC, USD).</li>
        <li><span class="datatable-columns-icon" aria-hidden="true">🏷️</span> <b>Name:</b> Full name of the asset (e.g., Bitcoin, US Dollar).</li>
        <li><span class="datatable-columns-icon" aria-hidden="true">💱</span> <b>Unit:</b> The denomination unit (e.g., BTC, USD, EUR).</li>
        <li><span class="datatable-columns-icon" aria-hidden="true">💲</span> <b>Value:</b> The current exchange rate, usually with two decimals.</li>
        <li><span class="datatable-columns-icon" aria-hidden="true">📦</span> <b>Type:</b> Asset category (cryptocurrency, fiat, commodity).</li>
    </ul>
</div>
<!-- END: Info Block Below DataTable -->
<!-- BEGIN: Reviews Section Below Info Block -->
<div class="modern-reviews-section">
    <h2 class="modern-reviews-title">
        <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:0.3em;"><circle cx="16" cy="16" r="16" fill="url(#reviewGradient)"/><path d="M10 22l2-2 4 4 8-8-2-2-6 6-2-2-2 2z" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><defs><linearGradient id="reviewGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse"><stop stop-color="#ff6a88"/><stop offset="1" stop-color="#ff99ac"/></linearGradient></defs></svg>
        User Reviews
    </h2>
    <div id="reviews-list" class="reviews-list"></div>
    <div class="modern-review-form-container">
        <h3 class="modern-review-form-title">Add Your Review</h3>
        <form id="reviewForm" method="POST" action="{{ url('/coingecko/exchanges_rates/reviews') }}" autocomplete="off">
            @csrf
            <div class="modern-form-group">
                <label for="user_name">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="5" r="3" fill="#ff6a88"/><path d="M2 14c0-3 6-3 6-3s6 0 6 3" stroke="#ff99ac" stroke-width="1.2"/></svg>
                    Name <span style="color:#ff6a88;">*</span>
                </label>
                <input type="text" class="form-control" id="user_name" name="user_name" required maxlength="100" placeholder="Your name">
            </div>
            <div class="modern-form-group">
                <label for="user_email">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="4" width="14" height="8" rx="3" fill="#ff99ac"/><path d="M1 4l7 5 7-5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                    Email <span style="color:#ff6a88;">*</span>
                </label>
                <input type="email" class="form-control" id="user_email" name="user_email" required maxlength="100" placeholder="you@email.com">
            </div>
            <div class="modern-form-group">
                <label for="rating">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><polygon points="8,1 10,6 15,6 11,9 12,15 8,12 4,15 5,9 1,6 6,6" fill="#ff6a88"/></svg>
                    Rating <span style="color:#ff6a88;">*</span>
                </label>
                <select class="form-control" id="rating" name="rating" required>
                    <option value="">Select rating</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
            <div class="modern-form-group">
                <label for="review_title">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="2" y="2" width="12" height="12" rx="3" fill="#ff99ac"/><path d="M4 8h8M4 12h5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                    Review Title <span style="color:#ff6a88;">*</span>
                </label>
                <input type="text" class="form-control" id="review_title" name="review_title" required maxlength="150" placeholder="Short summary (e.g. 'Great support')">
            </div>
            <div class="modern-form-group">
                <label for="review_body">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="2" width="14" height="12" rx="3" fill="#ff99ac"/><path d="M3 5h10M3 9h7" stroke="#ff6a88" stroke-width="1.2"/></svg>
                    Your Review <span style="color:#ff6a88;">*</span>
                </label>
                <textarea class="form-control" id="review_body" name="review_body" rows="4" required placeholder="Write your detailed experience here..."></textarea>
            </div>
            <div class="modern-form-group">
                <label for="exchange_symbol">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#ff99ac"/><path d="M4 8h8M4 12h5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                    Exchange Symbol
                </label>
                <input type="text" class="form-control" id="exchange_symbol" name="exchange_symbol" maxlength="20" placeholder="e.g. BTC, ETH">
            </div>
            <div class="modern-form-group">
                <label for="exchange_name">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#ff6a88"/><path d="M4 8h8M4 12h5" stroke="#ff99ac" stroke-width="1.2"/></svg>
                    Exchange Name
                </label>
                <input type="text" class="form-control" id="exchange_name" name="exchange_name" maxlength="100" placeholder="e.g. Binance, Coinbase">
            </div>
            <div class="modern-form-group">
                <label for="country">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="4" width="14" height="8" rx="3" fill="#ff99ac"/><path d="M1 4l7 5 7-5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                    Country
                </label>
                <input type="text" class="form-control" id="country" name="country" maxlength="100" placeholder="Your country (optional)">
            </div>
            <div class="modern-form-group">
                <label for="pros">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#ff99ac"/><path d="M4 8h8M4 12h5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                    Pros
                </label>
                <textarea class="form-control" id="pros" name="pros" rows="2" placeholder="What did you like? (optional)"></textarea>
            </div>
            <div class="modern-form-group">
                <label for="cons">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#ff6a88"/><path d="M4 8h8M4 12h5" stroke="#ff99ac" stroke-width="1.2"/></svg>
                    Cons
                </label>
                <textarea class="form-control" id="cons" name="cons" rows="2" placeholder="What could be improved? (optional)"></textarea>
            </div>
            <div class="modern-form-group">
                <label for="would_recommend">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="#ff99ac"/><path d="M4 8h8M4 12h5" stroke="#ff6a88" stroke-width="1.2"/></svg>
                    Would you recommend?
                </label>
                <select class="form-control" id="would_recommend" name="would_recommend" required>
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="submit" class="btn modern-review-form-btn" aria-label="Submit your review">Submit Review</button>
            <div id="reviewFormMsg" style="margin-top: 1em;"></div>
        </form>
    </div>
</div>
<!-- END: Reviews Section -->

<style>
    .modern-reviews-section { margin-top: 3em; margin-bottom: 3em; background: linear-gradient(120deg, #ff6a88 0%, #ff99ac 100%); border-radius: 2em; box-shadow: 0 4px 32px rgba(255, 106, 136, 0.10), 0 1.5px 6px rgba(255, 153, 172, 0.08); padding: 2.5em 1.5em; max-width: 100%; }
    .modern-reviews-title { font-weight: 800; font-size: 2.2rem; margin-bottom: 1.5em; color: #fff; display: flex; align-items: center; gap: 0.7em; }
    .modern-reviews-title svg { width: 2.2em; height: 2.2em; flex-shrink: 0; }
    .modern-review-card { background: linear-gradient(100deg, #fffbe6 0%, #ffe6f0 100%); border-radius: 1.2em; margin-bottom: 1.5em; padding: 1.5em 1.7em; box-shadow: 0 2px 12px rgba(255,106,136,0.08); display: flex; gap: 1.2em; align-items: flex-start; transition: box-shadow 0.2s, transform 0.2s; }
    .modern-review-card:hover { box-shadow: 0 6px 24px rgba(255,106,136,0.13); transform: translateY(-2px) scale(1.01); }
    .modern-review-avatar { width: 3.2em; height: 3.2em; border-radius: 50%; background: linear-gradient(135deg, #ff6a88 0%, #ff99ac 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5em; font-weight: 700; box-shadow: 0 2px 8px rgba(255,106,136,0.10); flex-shrink: 0; }
    .modern-review-content { flex: 1; display: flex; flex-direction: column; gap: 0.3em; }
    .modern-review-header { display: flex; align-items: center; gap: 0.7em; margin-bottom: 0.2em; }
    .modern-review-name { font-weight: 700; color: #ff6a88; font-size: 1.1em; }
    .modern-review-date { color: #888; font-size: 0.98em; }
    .modern-review-rating { margin-left: auto; color: #ffd200; font-size: 1.2em; display: flex; align-items: center; gap: 0.1em; }
    .modern-review-title { font-weight: 600; font-size: 1.15em; margin-bottom: 0.2em; color: #222; }
    .modern-review-comment { color: #222; font-size: 1.05em; line-height: 1.6; }
    .modern-review-form-container { max-width: 600px; margin: 2.5em auto 0 auto; background: linear-gradient(100deg, #fffbe6 0%, #ffe6f0 100%); border-radius: 1.2em; box-shadow: 0 2px 12px rgba(255,106,136,0.08); padding: 2em 2em 1.5em 2em; }
    .modern-review-form-title { font-weight: 700; font-size: 1.3rem; margin-bottom: 1.2em; color: #ff6a88; display: flex; align-items: center; gap: 0.5em; }
    .modern-form-group { margin-bottom: 1.1em; position: relative; }
    .modern-form-group label { font-weight: 600; color: #ff6a88; margin-bottom: 0.3em; display: flex; align-items: center; gap: 0.4em; }
    .modern-form-group svg { width: 1.1em; height: 1.1em; vertical-align: middle; }
    .modern-form-group input, .modern-form-group select, .modern-form-group textarea { width: 100%; border-radius: 1.2em; border: 1.5px solid #ff6a88; padding: 0.7em 1.1em; font-size: 1.05em; background: #fff; color: #222; transition: border 0.2s; box-shadow: 0 1px 4px rgba(255,106,136,0.04); }
    .modern-form-group input:focus, .modern-form-group select:focus, .modern-form-group textarea:focus { border: 1.5px solid #ffd200; outline: none; }
    .modern-review-form-btn { background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%); color: #fff; font-weight: 700; border: none; border-radius: 2em; padding: 0.7em 2em; font-size: 1.1em; box-shadow: 0 2px 8px rgba(34,34,34,0.08); transition: background 0.2s, color 0.2s; }
    .modern-review-form-btn:hover { background: #fff; color: #ff6a88; }
    @media (max-width: 700px) { .modern-reviews-section { padding: 1.2em 0.3em; border-radius: 1em; } .modern-review-card { flex-direction: column; align-items: flex-start; padding: 1.1em 1em; gap: 0.7em; } .modern-review-avatar { width: 2.2em; height: 2.2em; font-size: 1.1em; } .modern-review-form-container { padding: 1.2em 0.7em 1em 0.7em; border-radius: 1em; } }
</style>
<script>
function renderReviews(reviews) {
    let html = '';
    if (!reviews.length) {
        html = '<div class="alert alert-info">No reviews yet. Be the first to review!</div>';
    } else {
        html = reviews.map(review => `
            <div class="modern-review-card">
                <div class="modern-review-avatar">${review.user_name ? review.user_name.charAt(0).toUpperCase() : '?'}</div>
                <div class="modern-review-content">
                    <div class="modern-review-header">
                        <span class="modern-review-name">${review.user_name}</span>
                        <span class="modern-review-date">
                            <svg width="14" height="14" style="vertical-align:middle;margin-right:0.2em;" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="7" fill="#ff6a88"/><path d="M7 3v4l3 1.5" stroke="#ff99ac" stroke-width="1.2"/></svg>
                            ${new Date(review.created_at).toLocaleDateString()}
                        </span>
                        <span class="modern-review-rating">${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}</span>
                    </div>
                    <div class="modern-review-title">${review.review_title}</div>
                    <div class="modern-review-comment">${review.review_body.replace(/\n/g, '<br>')}</div>
                    <div class="modern-review-meta">
                        ${review.country ? `<span class="modern-review-country"><svg width="12" height="12" style="vertical-align:middle;margin-right:0.2em;" viewBox="0 0 12 12" fill="none"><rect x="1" y="3" width="10" height="6" rx="2" fill="#ff99ac"/><path d="M1 3l5 3.5 5-3.5" stroke="#ff6a88" stroke-width="1"/></svg> ${review.country}</span>` : ''}
                        ${review.pros ? `<span class="modern-review-pros"><b>Pros:</b> ${review.pros}</span>` : ''}
                        ${review.cons ? `<span class="modern-review-cons"><b>Cons:</b> ${review.cons}</span>` : ''}
                        <span class="modern-review-recommend">${review.would_recommend ? '👍 Recommended' : '👎 Not recommended'}</span>
                    </div>
                </div>
            </div>
        `).join('');
    }
    document.getElementById('reviews-list').innerHTML = html;
}

function fetchReviews() {
    fetch('/coingecko/exchanges_rates/reviews/list')
        .then(res => res.json())
        .then(data => renderReviews(data));
}

// On page load
fetchReviews();

document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': form.querySelector('[name=_token]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-success">Thank you for your review!</div>';
            form.reset();
            fetchReviews();
        } else {
            document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
        }
    })
    .catch(() => {
        document.getElementById('reviewFormMsg').innerHTML = '<div class="alert alert-danger">There was an error submitting your review.</div>';
    });
});
</script>
<!-- END: Reviews Section -->
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
<script src="{{ url('js/coingecko/exchange_rates.js') }}"></script>
@endsection