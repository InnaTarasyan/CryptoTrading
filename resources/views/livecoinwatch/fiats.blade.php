@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/fiats.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="m-content">
        <!-- Modern Title Bar with Icon and Dark Mode Button -->
        <div class="modern-title-bar">
            <div class="m-portlet__head-title custom-modern">
                <span class="modern-title-icon">
                    <!-- Fiat Icon SVG -->
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="4" width="24" height="24" rx="8" fill="#ff512f"/>
                        <text x="16" y="22" text-anchor="middle" font-size="16" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text>
                    </svg>
                </span>
                <span class="modern-title-text">Livecoin Fiats</span>
            </div>
            <button id="darkModeToggle" class="modern-tab darkmode-switch" title="Toggle dark mode" role="switch" aria-checked="false" aria-label="Toggle dark mode" tabindex="0">
                <span class="darkmode-switch-icon" id="darkModeIcon">
                    <!-- Sun & Moon SVG for animation -->
                    <svg class="icon-moon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none;">
                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" fill="#ffd200"/>
                    </svg>
                    <svg class="icon-sun" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none;">
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
                <span class="darkmode-switch-toggle" aria-hidden="true"></span>
            </button>
        </div>
        <!-- Navigation Tabs -->
        <div class="modern-tabs-container gradient-tabs-bg">
            <nav class="modern-tabs beautiful-tabs" aria-label="Main navigation">
                <a href="/" class="modern-tab beautiful-tab {{ request()->is('/') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- History Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#ffd200"/><path d="M12 7v5l4 2" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                    <span class="tab-label">History</span>
                </a>
                <a href="/livecoinexchangesindex" class="modern-tab beautiful-tab {{ request()->is('livecoinexchangesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Exchange Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#43cea2"/><path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                        </span>
                    <span class="tab-label">Exchanges</span>
                </a>
                <a href="/livecoinfiatsindex" class="modern-tab beautiful-tab {{ request()->is('livecoinfiatsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Fiat Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="5" fill="#ff512f"/><text x="12" y="17" text-anchor="middle" font-size="12" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>
                        </span>
                    <span class="tab-label">Fiats</span>
                </a>
            </nav>
        </div>
        <!-- Action Buttons -->
        <div class="action-buttons-row" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="action-buttons-left">
                <button id="refreshTable" class="modern-tab refresh-btn modern-refresh-btn-upgraded" title="Refresh Table" aria-label="Refresh Table" aria-busy="false" aria-disabled="false" tabindex="0" style="overflow:hidden; position:relative;">
                    <span class="refresh-btn-icon" style="position:relative; display:inline-flex; align-items:center; justify-content:center;">
                        <!-- Modern Bold Refresh SVG (upgraded) with white background -->
                        <span class="refresh-icon-bg">
                            <svg class="icon-refresh-upgraded" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="refreshGradientModernUpgraded" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#43cea2"/>
                                        <stop offset="1" stop-color="#185a9d"/>
                                    </linearGradient>
                                </defs>
                                <circle cx="16" cy="16" r="15" fill="#fff"/>
                                <path d="M25 10A12 12 0 1 0 27 16h-2.5" stroke="url(#refreshGradientModernUpgraded)" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <polyline points="24 4 24 11 31 11" stroke="url(#refreshGradientModernUpgraded)" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        </span>
                        <span class="refresh-spinner" style="display:none; position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); z-index:2;">
                            <svg width="28" height="28" viewBox="0 0 50 50">
                                <circle cx="25" cy="25" r="20" fill="none" stroke="#43cea2" stroke-width="5" stroke-linecap="round" stroke-dasharray="31.4 31.4" stroke-dashoffset="0">
                                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/>
                                </circle>
                            </svg>
                        </span>
                    </span>
                    <span class="refresh-btn-label">Refresh</span>
                    <span class="ripple-effect"></span>
                </button>
            </div>
            <div class="action-buttons-right">
                <button id="fullscreenToggle" class="modern-tab fullscreen-switch modern-fullscreen-btn" title="Toggle Fullscreen" aria-label="Toggle Fullscreen" aria-pressed="false" role="button" tabindex="0">
                    <span class="fullscreen-icon-bg">
                        <!-- Enter Fullscreen SVG -->
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
                        <!-- Exit Fullscreen SVG (hidden by default) -->
                        <svg class="icon-exit-fullscreen" width="24" height="24" viewBox="0 0 24 24" fill="none" style="display:none;">
                            <rect x="5" y="11" width="14" height="2" rx="1" fill="#ff512f"/>
                            <rect x="11" y="5" width="2" height="14" rx="1" fill="#ff512f"/>
                        </svg>
                    </span>
                    <span id="fullscreenText" class="fullscreen-switch-label">Fullscreen</span>
                </button>
            </div>
        </div>
        <!-- DataTable Section -->
        <div class="m-portlet fiat-gradient-bg">
            <div class="m-portlet__body mt-5">
                <input type="hidden" id="livecoin_fiats_route" value="{{ route('datatable.livecoin.fiats') }}">
                <div id="datatableFullscreenContainer" class="table-responsive">
                    <div id="datatableLoading" class="datatable-loading" style="display:none; text-align:center; margin:2em;">
                        <div class="spinner-border text-warning" role="status" style="width:3rem;height:3rem;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <table id="livecoin_fiats" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                            <th title="Fiat name">
                                <span class="datatable-header-icon">
                                    <!-- Coin SVG (match style from history.blade.php) -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="16" cy="16" r="14" fill="#43cea2"/>
                                        <circle cx="16" cy="16" r="10" fill="#fff"/>
                                        <text x="16" y="21" text-anchor="middle" font-size="16" fill="#43cea2" font-family="Arial, sans-serif" font-weight="bold">F</text>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Fiat</span>
                            </th>
                            <th title="Flag">
                                <span class="datatable-header-icon">
                                    <!-- Logo SVG (match style from history.blade.php) -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="6" fill="#ff512f"/>
                                        <circle cx="16" cy="16" r="8" fill="#fff"/>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Flag</span>
                            </th>
                            <th title="Countries">
                                <span class="datatable-header-icon">
                                    <!-- Countries SVG (match style from history.blade.php) -->
                                    <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/>
                                        <text x="16" y="21" text-anchor="middle" font-size="16" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">🌍</text>
                                    </svg>
                                </span>
                                <span class="datatable-header-text">Countries</span>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- BEGIN: Info Block for Live Coin Watch Fiats -->
        <div class="fiats-info-block upgraded-gradient-bg">
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; margin-bottom: 2.2em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,81,47,0.10);">
                    <!-- Globe/Fiat Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="19" fill="#ff512f" stroke="#ffd200" stroke-width="2"/>
                        <text x="20" y="27" text-anchor="middle" font-size="22" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.25em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#ff512f;">Live Coin Watch Fiats</span>: Your Real-Time Fiat Currency Dashboard
                    </p>
                    <p class="info-desc" style="margin-bottom:0; font-size:1.08em; line-height:1.7;">
                        <span style="font-size:1.2em;">💱</span> <b>Live Coin Watch Fiats</b> provides real-time information and analytics on a wide range of fiat currencies used in the cryptocurrency ecosystem. Track fiat values, compare exchange rates, and monitor the global impact of fiat currencies on crypto markets.<br><br>
                        <span style="font-size:1.2em;">🔍</span> <b>Transparency & Accuracy:</b> Aggregated data from multiple sources for reliability.<br>
                        <span style="font-size:1.2em;">🌍</span> <b>Global Coverage:</b> Supports all major and minor fiat currencies worldwide.<br>
                        <span style="font-size:1.2em;">📊</span> <b>For Everyone:</b> Designed for traders, investors, and researchers.
                    </p>
                </div>
            </div>
            <div class="info-paragraph" style="display: flex; align-items: flex-start; gap: 1.5em; flex-wrap: wrap;">
                <span style="flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.13); border-radius:50%; width:3.5em; height:3.5em; box-shadow:0 2px 8px 0 rgba(255,81,47,0.10);">
                    <!-- Table/Analytics Icon -->
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="12" width="26" height="16" rx="4" fill="#ffd200" stroke="#fff" stroke-width="2"/>
                        <rect x="11" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="19" y="16" width="6" height="8" rx="2" fill="#fff"/>
                        <rect x="27" y="16" width="2" height="8" rx="1" fill="#fff"/>
                    </svg>
                </span>
                <div style="min-width: 220px; flex: 1;">
                    <p class="info-title" style="margin-bottom:0.5em; font-size:1.18em; font-weight:700; letter-spacing:0.01em;">
                        <span style="color:#ffd200;">How to Use the Fiat Table</span>
                    </p>
                    <p style="font-size:1.08em; line-height:1.7; margin-bottom:1em;">
                        The table above provides a comprehensive overview of each fiat currency's key details. Use the column explanations below to better understand the data and make smarter trading decisions.
                    </p>
                    <ul class="fiats-datatable-columns-list" style="margin-bottom:0; font-size:1.08em; line-height:1.7; padding-left:1.2em; list-style:none;">
                        <li><span style="font-size:1.2em;">🔤</span> <b>Fiat:</b> The official name or code of the fiat currency (e.g., USD, EUR, JPY).</li>
                        <li><span style="font-size:1.2em;">🏳️</span> <b>Flag:</b> The flag of the country or region associated with the fiat currency.</li>
                        <li><span style="font-size:1.2em;">🌍</span> <b>Countries:</b> The list of countries where the fiat currency is officially used or recognized as legal tender.</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END: Info Block for Live Coin Watch Fiats -->
        <!-- BEGIN: Review Block for Live Coin Watch Fiats -->
        <div class="modern-reviews-section">
            <h2 class="modern-reviews-title">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="16" fill="url(#reviewGradientFiat)"/><path d="M10 22l2-2 4 4 8-8-2-2-6 6-2-2-2 2z" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><defs><linearGradient id="reviewGradientFiat" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse"><stop stop-color="#ffd200"/><stop offset="1" stop-color="#ff512f"/></linearGradient></defs></svg>
                Fiat Reviews
            </h2>
            <div id="fiat-reviews-list" class="reviews-list"></div>
            <div class="modern-review-form-container">
                <h3 class="modern-review-form-title">
                    Add Your Review
                </h3>
                <form id="fiatReviewForm" method="POST" action="{{ url('/livecoinwatch/fiats/reviews') }}">
                    @csrf
                    <input type="hidden" name="fiat_code" value="all">
                    <div class="modern-form-group">
                        <label for="name">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" fill="#ffd200"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4" stroke="#ff512f" stroke-width="2"/></svg>
                            Name
                        </label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="email">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#43cea2"/><path d="M2 6l10 7 10-7" stroke="#ffd200" stroke-width="2"/></svg>
                            Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" required maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="rating">
                            <svg viewBox="0 0 24 24" fill="none"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" fill="#ffd200"/></svg>
                            Rating
                        </label>
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="">Select</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                    <div class="modern-form-group">
                        <label for="title">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#ffd200"/><path d="M8 12h8M8 16h4" stroke="#ff512f" stroke-width="2"/></svg>
                            Title
                        </label>
                        <input type="text" class="form-control" id="title" name="title" required maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="comment">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="16" rx="4" fill="#43cea2"/><path d="M6 8h12M6 12h8" stroke="#ffd200" stroke-width="2"/></svg>
                            Comment
                        </label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="country">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="6" width="20" height="12" rx="4" fill="#ffd200"/><path d="M2 6l10 7 10-7" stroke="#43cea2" stroke-width="2"/></svg>
                            Country
                        </label>
                        <input type="text" class="form-control" id="country" name="country" maxlength="255">
                    </div>
                    <div class="modern-form-group">
                        <label for="experience_level">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="4" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg>
                            Experience Level
                        </label>
                        <select class="form-control" id="experience_level" name="experience_level">
                            <option value="">Select</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Professional">Professional</option>
                        </select>
                    </div>
                    <div class="modern-form-group">
                        <label for="pros">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg>
                            Pros
                        </label>
                        <textarea class="form-control" id="pros" name="pros" rows="2"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="cons">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#ffd200"/><path d="M8 12h8M8 16h4" stroke="#43cea2" stroke-width="2"/></svg>
                            Cons
                        </label>
                        <textarea class="form-control" id="cons" name="cons" rows="2"></textarea>
                    </div>
                    <div class="modern-form-group">
                        <label for="recommend">
                            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#43cea2"/><path d="M8 12h8M8 16h4" stroke="#ffd200" stroke-width="2"/></svg>
                            Would you recommend?
                        </label>
                        <select class="form-control" id="recommend" name="recommend">
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn modern-review-form-btn">Submit Review</button>
                    <div id="fiatReviewFormMsg" style="margin-top: 1em;"></div>
                </form>
            </div>
        </div>
        <!-- END: Review Block for Live Coin Watch Fiats -->
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
    <script src="{{ url('js/livecoin/fiats.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var refreshBtn = document.getElementById('refreshTable');
            var spinner = refreshBtn.querySelector('.refresh-spinner');
            var icon = refreshBtn.querySelector('.icon-refresh-upgraded');
            var label = refreshBtn.querySelector('.refresh-btn-label');
            refreshBtn.addEventListener('click', function() {
                refreshBtn.classList.add('spinning');
                spinner.style.display = 'block';
                icon.style.display = 'none';
                refreshBtn.setAttribute('aria-busy', 'true');
                refreshBtn.setAttribute('aria-disabled', 'true');
                refreshBtn.disabled = true;
                setTimeout(function() {
                    refreshBtn.classList.remove('spinning');
                    spinner.style.display = 'none';
                    icon.style.display = '';
                    refreshBtn.setAttribute('aria-busy', 'false');
                    refreshBtn.setAttribute('aria-disabled', 'false');
                    refreshBtn.disabled = false;
                }, 700);
            });
            // Dark Mode Toggle Logic
            var darkModeToggle = document.getElementById('darkModeToggle');
            var darkModeIcon = document.getElementById('darkModeIcon');
            var iconMoon = darkModeIcon.querySelector('.icon-moon');
            var iconSun = darkModeIcon.querySelector('.icon-sun');
            var darkModeText = document.getElementById('darkModeText');
            var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            function setDarkMode(enabled) {
                if (enabled) {
                    document.body.classList.add('dark-mode');
                    iconMoon.style.display = 'none';
                    iconSun.style.display = 'inline';
                    darkModeToggle.setAttribute('aria-checked', 'true');
                    darkModeText.textContent = 'Light Mode';
                } else {
                    document.body.classList.remove('dark-mode');
                    iconMoon.style.display = 'inline';
                    iconSun.style.display = 'none';
                    darkModeToggle.setAttribute('aria-checked', 'false');
                    darkModeText.textContent = 'Dark Mode';
                }
            }
            // Initial state
            var darkMode = localStorage.getItem('darkMode');
            if (darkMode === null) {
                setDarkMode(prefersDark);
                localStorage.setItem('darkMode', prefersDark ? '1' : '0');
            } else {
                setDarkMode(darkMode === '1');
            }
            darkModeToggle.addEventListener('click', function() {
                var enabled = !document.body.classList.contains('dark-mode');
                setDarkMode(enabled);
                localStorage.setItem('darkMode', enabled ? '1' : '0');
            });
            // Fullscreen logic for datatable
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
        });
    </script>
@endsection