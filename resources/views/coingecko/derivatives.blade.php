@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{ asset('css/derivatives.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="m-content">
        <!-- Modern Title Bar with Icon -->
        <div class="modern-title-bar" aria-labelledby="derivativesTitle" role="banner">
            <div class="modern-title-bar-row">
                <div class="modern-title-main">
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
                    <span class="modern-title-text enhanced-title-highlight" id="derivativesTitle">Coingecko Derivatives</span>
                </div>
                <div class="modern-title-actions">
                    <div class="modern-title-actions-group">
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
    </script>
@endsection