@extends('layouts.base')
@section('styles')
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="{{ url('css/datatables.css') }}" rel="stylesheet">
<link href="{{ url('css/exchanges_rates.css') }}" rel="stylesheet">
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
                            <th class="enhanced-th">Symbol</th>
                            <th class="enhanced-th">Name</th>
                            <th class="enhanced-th">Unit</th>
                            <th class="enhanced-th">Value</th>
                            <th class="enhanced-th">Type</th>
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
@endsection