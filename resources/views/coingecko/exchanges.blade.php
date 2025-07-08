@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/coingecko_exchanges.css') }}" rel="stylesheet">
@endsection
@section('content')
    <input type="hidden" id="coingecko_exchanges_route" value="{{ route('datatable.coingecko.exchanges') }}">
    <div class="m-content">
        <!-- Modern Title Bar with Icon -->
        <div class="modern-title-bar" aria-labelledby="exchangesTitle" role="banner">
            <div class="modern-title-bar-row">
                <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
                    <span class="modern-title-icon" tabindex="0" title="Exchanges Overview">
                        <!-- Exchanges Icon SVG (Pink Gradient) -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="exchangesGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#ff6a88"/>
                                    <stop offset="1" stop-color="#ff99ac"/>
                                </linearGradient>
                            </defs>
                            <rect x="4" y="4" width="24" height="24" rx="8" fill="url(#exchangesGradient)"/>
                            <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="modern-title-text" id="exchangesTitle">Coingecko Exchanges</span>
                </div>
            </div>
        </div>
        <!-- Enhanced Table Container -->
        <div id="datatableFullscreenContainer" class="table-responsive enhanced-table-container">
            <!-- Table Status Bar -->
            <div class="table-status-bar" id="tableStatusBar">
                <div class="status-info">
                    <span class="status-icon">🏦</span>
                    <span class="status-text">Ready to display exchange data</span>
                </div>
            </div>
            <!-- Enhanced Table -->
            <div class="table-wrapper">
                <table id="coingecko_exchanges" class="table table-hover table-condensed table-striped enhanced-table" style="width:100%; padding-top:1%">
                    <thead class="enhanced-thead">
                        <tr>
                            <th class="enhanced-th"><span class="datatable-header-text">Name</span></th>
                            <th class="enhanced-th"><span class="datatable-header-text">Image</span></th>
                            <th class="enhanced-th"><span class="datatable-header-text">URL</span></th>
                            <th class="enhanced-th"><span class="datatable-header-text">Year Established</span></th>
                            <th class="enhanced-th"><span class="datatable-header-text">Country</span></th>
                            <th class="enhanced-th"><span class="datatable-header-text">Description</span></th>
                            <th class="enhanced-th"><span class="datatable-header-text">Trust score</span></th>
                            <th class="enhanced-th"><span class="datatable-header-text">Trust score rank</span></th>
                            <th class="enhanced-th"><span class="datatable-header-text">Has trading incentive</span></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Info Block: About Coingecko Exchanges -->
        <div class="modern-info-block-upgraded upgraded-gradient-bg" style="border-radius: 1.5em; box-shadow: 0 8px 32px 0 rgba(255, 106, 136, 0.18), 0 3px 12px 0 rgba(255, 153, 172, 0.13); padding: 2.2em 2em 2.2em 2em; margin-top: 2.5em; margin-bottom: 2.5em; color: #fff; background: linear-gradient(90deg, #ff6a88 0%, #ff99ac 100%);">
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; margin-bottom: 2.2em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,106,136,0.10);">
                    <!-- Globe/Exchanges Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="12" width="26" height="16" rx="4" fill="#ff99ac" stroke="#fff" stroke-width="2"/>
                        <rect x="11" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="19" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="27" y="16" width="2" height="8" rx="1" fill="#fff"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.25em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#fff;">Coingecko Exchanges</span>: Your Real-Time Crypto Exchange Dashboard
                    </p>
                    <p class="info-desc" style="margin-bottom:0; font-size:1.08em; line-height:1.7;">
                        <span style="font-size:1.2em;">🌐</span> <b>Coingecko Exchanges</b> is a real-time dashboard for comparing and monitoring the world's top cryptocurrency exchanges. It offers a user-friendly interface, supports hundreds of exchanges, and provides up-to-date data on trust score, volume, and more.<br><br>
                        <span style="font-size:1.2em;">🔒</span> <b>Security & Transparency:</b> Robust security, transparent data, and competitive fees.<br>
                        <span style="font-size:1.2em;">🚀</span> <b>For Everyone:</b> Designed for both beginners and experienced traders to make informed decisions and discover the best exchanges for their crypto journey.<br>
                        <span style="font-size:1.2em;">🏦</span> <b>Global Access:</b> Access exchange data from anywhere, anytime, on any device.
                    </p>
                </div>
            </div>
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,106,136,0.10);">
                    <!-- Table/Analytics Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="12" width="26" height="16" rx="4" fill="#ff99ac" stroke="#fff" stroke-width="2"/>
                        <rect x="11" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="19" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="27" y="16" width="2" height="8" rx="1" fill="#fff"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.18em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#fff;">How to Use the Exchanges Table</span>
                    </p>
                    <p style="font-size:1.08em; line-height:1.7; margin-bottom:1em;">
                        The table above provides a comprehensive overview of each exchange's key statistics. Use the column explanations below to better understand the data and make smarter trading decisions.
                    </p>
                    <ul class="datatable-columns-list" style="margin-bottom:0; font-size:1.08em; line-height:1.7; padding-left:1.2em; list-style:none;">
                        <li><span style="font-size:1.2em;">🏦</span> <b>Name:</b> The official name of the exchange.</li>
                        <li><span style="font-size:1.2em;">🖼️</span> <b>Image:</b> The official logo or icon representing the exchange.</li>
                        <li><span style="font-size:1.2em;">🔗</span> <b>URL:</b> The official website of the exchange.</li>
                        <li><span style="font-size:1.2em;">📅</span> <b>Year Established:</b> The year the exchange was founded.</li>
                        <li><span style="font-size:1.2em;">🌍</span> <b>Country:</b> The country where the exchange is based.</li>
                        <li><span style="font-size:1.2em;">📝</span> <b>Description:</b> A brief description of the exchange.</li>
                        <li><span style="font-size:1.2em;">🔒</span> <b>Trust score:</b> The trust score assigned to the exchange.</li>
                        <li><span style="font-size:1.2em;">🏅</span> <b>Trust score rank:</b> The rank of the exchange by trust score.</li>
                        <li><span style="font-size:1.2em;">🎁</span> <b>Has trading incentive:</b> Whether the exchange offers trading incentives.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('js/coingecko/exchanges.js') }}"></script>
@endsection