@extends('layouts.base')
@section('styles')
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="{{ url('css/datatables.css') }}" rel="stylesheet">
<link href="{{ url('css/exchanges_rates.css') }}" rel="stylesheet">
<style>
    .modern-toolbar-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff6fa;
        background: none;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        box-shadow: 0 2px 8px rgba(255, 106, 136, 0.10);
        transition: box-shadow 0.2s, transform 0.2s, background 0.2s, border-color 0.2s;
        cursor: pointer;
        outline: none;
        position: relative;
        z-index: 10;
    }
    .modern-toolbar-btn:focus, .modern-toolbar-btn:hover {
        box-shadow: 0 4px 16px 0 rgba(255, 106, 136, 0.18), 0 1.5px 6px 0 rgba(255, 0, 128, 0.13);
        background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);
        border-color: #ffd200;
        transform: translateY(-2px) scale(1.07);
    }
    .modern-toolbar-btn:focus {
        outline: 2.5px solid #ffd200;
        outline-offset: 2px;
    }
    .modern-toolbar-btn:active {
        transform: scale(0.97);
    }
    .modern-toolbar-btn:focus svg circle,
    .modern-toolbar-btn:hover svg circle {
        filter: brightness(1.1) drop-shadow(0 0 6px #ff99ac88);
    }
    .toolbar-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
    }
    .refresh-spinner {
        animation: spin 0.8s linear infinite;
        transform-origin: 50% 50%;
    }
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
    .responsive-toolbar {
        background: rgba(255,255,255,0.92);
        border-radius: 1.5em;
        box-shadow: 0 4px 24px rgba(255, 106, 136, 0.13), 0 1.5px 6px rgba(252, 177, 227, 0.10);
        border: 2px solid #ffdde1;
        padding: 0.3em 1.1em;
        z-index: 20;
        position: relative;
    }
    @media (max-width: 600px) {
        .responsive-toolbar {
            gap: 0.3em !important;
            padding: 0.2em 0.3em;
        }
        .modern-toolbar-btn {
            width: 38px;
            height: 38px;
        }
        .toolbar-icon {
            width: 20px;
            height: 20px;
        }
    }
    body.dark-mode .responsive-toolbar {
        background: rgba(35,39,47,0.98);
        border: 2px solid #ff6a88;
    }
    body.dark-mode .modern-toolbar-btn {
        border: 2px solid #23272f;
        background: none;
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
                <button id="darkModeToggle" class="modern-toolbar-btn" title="Toggle Dark Mode" aria-label="Toggle Dark Mode">
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
                </button>
                <button id="refreshTable" class="modern-toolbar-btn" title="Refresh Table" aria-label="Refresh Table">
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
                </button>
                <button id="fullscreenToggle" class="modern-toolbar-btn" title="Full Screen Table" aria-label="Full Screen Table">
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
                </button>
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
                <div class="table-wrapper">
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
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="{{ url('js/coingecko/exchange_rates.js') }}"></script>
<script>
// Dark Mode Toggle
const darkModeToggle = document.getElementById('darkModeToggle');
const darkModeSvg = document.getElementById('darkModeSvg');
darkModeToggle && darkModeToggle.addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
    // Optionally persist mode
    if(document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', '1');
        // Change moon to sun
        darkModeSvg.querySelector('circle').setAttribute('fill', 'url(#moonGradient)');
        darkModeSvg.querySelector('#moonPath').setAttribute('d', 'M13 7a6 6 0 1 1 0 12 6 6 0 0 1 0-12z');
    } else {
        localStorage.removeItem('darkMode');
        // Change sun to moon
        darkModeSvg.querySelector('circle').setAttribute('fill', 'url(#moonGradient)');
        darkModeSvg.querySelector('#moonPath').setAttribute('d', 'M18 13c0 3.31-2.69 6-6 6a6 6 0 0 1 0-12c.34 0 .67.03 1 .08A5 5 0 0 0 18 13z');
    }
});
// On load, restore dark mode
if(localStorage.getItem('darkMode')) {
    document.body.classList.add('dark-mode');
    // Change moon to sun
    if(darkModeSvg) {
        darkModeSvg.querySelector('circle').setAttribute('fill', 'url(#moonGradient)');
        darkModeSvg.querySelector('#moonPath').setAttribute('d', 'M13 7a6 6 0 1 1 0 12 6 6 0 0 1 0-12z');
    }
}

// Refresh DataTable
const refreshBtn = document.getElementById('refreshTable');
refreshBtn && refreshBtn.addEventListener('click', function() {
    if(window.$ && $.fn.DataTable) {
        $('#coingecko_exchange_rates').DataTable().ajax.reload(null, false);
    }
});

// Fullscreen Toggle
const fullscreenBtn = document.getElementById('fullscreenToggle');
const fsContainer = document.getElementById('datatableFullscreenContainer');
const fullscreenSvg = document.getElementById('fullscreenSvg');
fullscreenBtn && fullscreenBtn.addEventListener('click', function() {
    if (!document.fullscreenElement) {
        fsContainer.requestFullscreen();
        // Change icon to exit fullscreen
        fullscreenSvg.querySelector('#fullscreenIconGroup').innerHTML = `
            <polyline points="8 11 8 8 11 8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <polyline points="15 8 18 8 18 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <polyline points="8 15 8 18 11 18" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <polyline points="15 18 18 18 18 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        `;
    } else {
        document.exitFullscreen();
        // Change icon to enter fullscreen
        fullscreenSvg.querySelector('#fullscreenIconGroup').innerHTML = `
            <polyline points="8 8 8 11 11 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <polyline points="18 8 15 8 15 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <polyline points="8 18 8 15 11 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            <polyline points="18 18 15 18 15 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
        `;
    }
});
document.addEventListener('fullscreenchange', function() {
    if (!document.fullscreenElement) {
        // Change icon to enter fullscreen
        if(fullscreenSvg) {
            fullscreenSvg.querySelector('#fullscreenIconGroup').innerHTML = `
                <polyline points="8 8 8 11 11 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <polyline points="18 8 15 8 15 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <polyline points="8 18 8 15 11 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <polyline points="18 18 15 18 15 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            `;
        }
    } else {
        // Change icon to exit fullscreen
        if(fullscreenSvg) {
            fullscreenSvg.querySelector('#fullscreenIconGroup').innerHTML = `
                <polyline points="8 11 8 8 11 8" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <polyline points="15 8 18 8 18 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <polyline points="8 15 8 18 11 18" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <polyline points="15 18 18 18 18 15" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            `;
        }
    }
});
</script>
@endsection