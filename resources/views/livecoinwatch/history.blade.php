@extends('layouts.base')

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
                <span class="modern-title-text">Livecoin History</span>
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
                <span id="darkModeText" class="darkmode-switch-label">Dark Mode</span>
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
                    <span class="tab-label">History</span>
                </a>
                <a href="/livecoinexchangesindex" class="modern-tab beautiful-tab {{ request()->is('livecoinexchangesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        {{-- Exchange Icon --}}
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#43cea2"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                    </span>
                    <span class="tab-label">Exchanges</span>
                </a>
                <a href="/livecoinfiatsindex" class="modern-tab beautiful-tab {{ request()->is('livecoinfiatsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        {{-- Fiat Icon --}}
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff512f"/><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>
                    </span>
                    <span class="tab-label">Fiats</span>
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
                    <span>Refresh</span>
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
                    <span id="fullscreenText" class="fullscreen-switch-label">Fullscreen</span>
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
                                <span class="datatable-header-text">Coin</span>
                            </th>
                            <th title="Coin logo">
                                <span class="datatable-header-icon">
                                    {{-- Logo SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="6" fill="#ff512f"/>
                                        <circle cx="16" cy="16" r="8" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Logo</span>
                            </th>
                            <th title="Current price in USD">
                                <span class="datatable-header-icon">
                                    {{-- Dollar SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/>
                                        <text x="16" y="21" text-anchor="middle" font-size="16" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Price</span>
                            </th>
                            <th title="How old the coin is">
                                <span class="datatable-header-icon">
                                    {{-- Hourglass SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#a8edea"/>
                                        <path d="M10 8h12M10 24h12M12 8c0 6 8 6 8 0M12 24c0-6 8-6 8 0" stroke="#185a9d" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Age</span>
                            </th>
                            <th title="Number of trading pairs">
                                <span class="datatable-header-icon">
                                    {{-- Pairs SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#f7971e"/>
                                        <path d="M12 16h8M16 12v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Pairs</span>
                            </th>
                            <th title="24h trading volume">
                                <span class="datatable-header-icon">
                                    {{-- Exchange SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#43cea2"/>
                                        <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Volume (24h)</span>
                            </th>
                            <th title="Market capitalization">
                                <span class="datatable-header-icon">
                                    {{-- Pie Chart SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="12" fill="#ff512f"/>
                                        <path d="M16 16V8A8 8 0 1 1 8 24" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Market Cap</span>
                            </th>
                            <th title="Rank among all coins">
                                <span class="datatable-header-icon">
                                    {{-- Trophy SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/>
                                        <path d="M12 20h8M16 20v4M10 8h12v4a6 6 0 0 1-12 0V8z" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Rank</span>
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
                                <span class="datatable-header-text">Markets</span>
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
                                <span class="datatable-header-text">Total Supply</span>
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
                                <span class="datatable-header-text">Max Supply</span>
                            </th>
                            <th title="Currently circulating supply">
                                <span class="datatable-header-icon">
                                    {{-- Circle SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="12" fill="#43cea2"/>
                                        <circle cx="16" cy="16" r="7" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Circulating Supply</span>
                            </th>
                            <th title="All-time high price">
                                <span class="datatable-header-icon">
                                    {{-- Line Chart SVG --}}
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ff512f"/>
                                        <polyline points="8,24 14,18 18,22 24,10" stroke="#fff" stroke-width="2" fill="none"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">All-Time High</span>
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
                                <span class="datatable-header-text">Categories</span>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        {{-- ======================== End DataTable Section ======================== --}}
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
@endsection