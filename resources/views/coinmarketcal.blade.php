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
        /* Reset and Base Styles */
        * {
            box-sizing: border-box;
        }

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
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.9);
            border-color: #667eea;
            transform: translateY(-1px);
        }

        .feature-icon {
            font-size: 1.25rem;
        }

        .feature-text {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .explanation-tip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #f59e0b;
            border-radius: 8px;
            color: #92400e;
        }

        .tip-icon {
            font-size: 1.125rem;
        }

        .tip-text {
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Dark mode support */
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

        /* Theme Toggle Button Styles - Moved outside portlet */
        .theme-toggle-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
            padding: 0 0.5rem;
        }

        #theme-toggle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #theme-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        #theme-toggle:active {
            transform: translateY(0);
        }

        /* Mobile-First Responsive Design */
        @media (max-width: 768px) {
            .navigation-explanation {
                margin-bottom: 1rem;
                border-radius: 12px;
            }

            .explanation-content {
                flex-direction: column;
                text-align: center;
                padding: 1rem;
                gap: 0.75rem;
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

            /* Mobile-optimized theme toggle */
            .theme-toggle-container {
                justify-content: center;
                margin-bottom: 1rem;
            }

            #theme-toggle {
                width: 100%;
                max-width: 300px;
                padding: 12px 16px;
                font-size: 16px;
                border-radius: 12px;
                justify-content: center;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            /* Mobile-optimized portlet */
            .m-portlet {
                margin: 0.5rem;
                border-radius: 16px;
            }

            .m-portlet__head {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
                text-align: center;
            }

            .m-portlet__head-title {
                font-size: 1.1rem;
                width: 100%;
                justify-content: center;
            }

            .m-portlet__body {
                padding: 0.5rem;
            }

            /* Enhanced Mobile Datatable */
            #coinmarketcal_wrapper {
                margin-top: 1rem;
            }

            #coinmarketcal {
                width: 100% !important;
                min-width: 100% !important;
                font-size: 14px;
                border-radius: 12px;
                overflow: hidden;
                border-collapse: collapse;
            }

            #coinmarketcal thead {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            #coinmarketcal thead th {
                padding: 12px 8px;
                font-size: 14px;
                font-weight: 600;
                text-align: center;
                border: none;
                position: relative;
            }

            #coinmarketcal thead th:first-child {
                border-top-left-radius: 12px;
            }

            #coinmarketcal thead th:last-child {
                border-top-right-radius: 12px;
            }

            #coinmarketcal thead th .icon {
                font-size: 1.2em;
                margin-right: 6px;
                display: inline-block;
            }

            #coinmarketcal tbody {
                background: white;
            }

            #coinmarketcal tbody tr {
                border-bottom: 1px solid #e2e8f0;
                transition: all 0.15s ease;
                cursor: pointer;
                min-height: 50px;
            }

            #coinmarketcal tbody tr:nth-child(even) {
                background-color: #f8fafc;
            }

            #coinmarketcal tbody tr:hover {
                background: linear-gradient(90deg, #e0c3fc 0%, #8ec5fc 100%);
                transform: translateY(-1px);
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            #coinmarketcal tbody tr.mobile-touch-active {
                background: linear-gradient(90deg, #d4b5f7 0%, #7db8f7 100%);
                transform: scale(0.98);
            }

            #coinmarketcal tbody td {
                padding: 12px 8px;
                font-size: 13px;
                text-align: center;
                vertical-align: middle;
                border: none;
            }

            /* Enhanced Symbol Column (First Column) */
            #coinmarketcal tbody td:first-child {
                font-size: 18px;
                font-weight: 700;
                padding: 12px 8px;
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                border-left: 4px solid #667eea;
                border-radius: 0 8px 8px 0;
                color: #1e293b;
                text-shadow: 0 1px 2px rgba(0,0,0,0.1);
            }

            #coinmarketcal tbody td:first-child:hover {
                background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
                transform: scale(1.02);
            }

            /* Mobile-optimized DataTables controls */
            .dataTables_wrapper .dataTables_length {
                float: none;
                text-align: center;
                margin-bottom: 15px;
                width: 100%;
                padding: 8px 12px;
            }

            .dataTables_wrapper .dataTables_length select {
                padding: 6px 12px;
                border: 2px solid #ddd;
                border-radius: 8px;
                font-size: 14px;
                background: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .dataTables_wrapper .dataTables_filter {
                text-align: center;
                margin-bottom: 15px;
                width: 100%;
            }

            /* Mobile-optimized DataTables search - NO ICON */
            .dataTables_filter {
                position: relative;
                margin-bottom: 1rem;
            }

            .dataTables_filter input[type="search"] {
                width: 100%;
                max-width: 300px;
                padding: 12px 16px;
                border: 2px solid #ddd;
                border-radius: 12px;
                font-size: 16px;
                background: #fff;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                box-sizing: border-box;
                text-align: center;
                transition: all 0.3s ease;
            }

            .dataTables_filter input[type="search"]:focus {
                border-color: #667eea;
                box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
                outline: none;
            }

            .dataTables_filter input[type="search"]::placeholder {
                color: #999;
                font-style: italic;
            }

            /* Hide search icon on mobile */
            .dataTables_filter::before {
                display: none !important;
            }

            .dataTables_info {
                text-align: center;
                margin-top: 15px;
                font-size: 13px;
                color: #666;
                padding: 8px;
                background: #f8fafc;
                border-radius: 8px;
                border: 1px solid #e2e8f0;
            }

            .dataTables_paginate {
                text-align: center;
                margin-top: 15px;
            }

            .dataTables_paginate .paginate_button {
                padding: 8px 12px;
                margin: 0 3px;
                font-size: 13px;
                min-width: 40px;
                min-height: 40px;
                border-radius: 8px;
                background: #f8f9fa;
                color: #333;
                border: 1px solid #dee2e6;
                cursor: pointer;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .dataTables_paginate .paginate_button:hover {
                background: #e9ecef;
                border-color: #adb5bd;
                transform: translateY(-1px);
            }

            .dataTables_paginate .paginate_button.current {
                background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
                color: white;
                border-color: #667eea;
                box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
            }

            .dataTables_paginate .paginate_button.disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            /* Mobile-optimized table layout */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 12px;
                margin: 0;
                background: white;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }

            /* Mobile-optimized processing indicator */
            .dataTables_processing {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 1001;
                background: rgba(255, 255, 255, 0.95);
                padding: 1rem;
                border-radius: 8px;
                box-shadow: 0 4px 16px rgba(0,0,0,0.1);
                font-size: 14px;
                color: #333;
            }

            /* Mobile-optimized beautiful info */
            .datatable-info-beautiful {
                text-align: center;
                padding: 0.5rem;
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                margin-top: 0.5rem;
                flex-direction: column;
                align-items: center;
                gap: 6px;
            }

            .datatable-info-icon {
                font-size: 1rem;
                margin-right: 0;
                margin-bottom: 4px;
            }

            .datatable-info-text {
                font-size: 0.875rem;
                color: #475569;
            }

            .datatable-info-text strong {
                color: #1e293b;
            }

            /* Force mobile layout for controls */
            .m-portlet__head {
                display: flex !important;
                flex-direction: column !important;
                gap: 1rem !important;
            }

            .m-portlet__head-title {
                order: 1;
                margin-bottom: 0.5rem;
            }

            .dataTables_filter {
                order: 2;
                margin-bottom: 1rem !important;
            }

            .dataTables_length {
                order: 3;
                margin-bottom: 1rem !important;
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

            /* Ultra-mobile optimizations */
            .m-portlet {
                margin: 0.25rem;
            }

            .m-portlet__head {
                padding: 0.75rem;
            }

            .m-portlet__head-title {
                font-size: 1rem;
            }

            #coinmarketcal {
                font-size: 13px;
                min-width: 100% !important;
            }

            #coinmarketcal thead th {
                padding: 10px 6px;
                font-size: 13px;
            }

            #coinmarketcal thead th .icon {
                font-size: 1em;
                margin-right: 4px;
            }

            #coinmarketcal tbody td {
                padding: 10px 6px;
                font-size: 12px;
            }

            #coinmarketcal tbody td:first-child {
                font-size: 16px;
                padding: 10px 6px;
                border-left-width: 3px;
            }

            .dataTables_wrapper .dataTables_length {
                padding: 6px 8px;
            }

            .dataTables_wrapper .dataTables_length select {
                font-size: 13px;
                padding: 4px 8px;
            }

            .dataTables_filter input[type="search"] {
                font-size: 16px;
                padding: 10px 14px;
                max-width: 100%;
            }

            #theme-toggle {
                font-size: 16px;
                padding: 10px 14px;
            }

            .dataTables_info {
                font-size: 12px;
                padding: 6px;
            }

            .dataTables_paginate .paginate_button {
                padding: 6px 10px;
                font-size: 12px;
                min-width: 36px;
                min-height: 36px;
                margin: 0 2px;
            }
        }

        /* Mobile-optimized responsive popup */
        @media (max-width: 768px) {
            .dtr-modal {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100% !important;
                height: 100% !important;
                max-width: none !important;
                max-height: none !important;
                margin: 0 !important;
                border-radius: 0 !important;
                z-index: 9999 !important;
                background: rgba(0, 0, 0, 0.8) !important;
            }

            .dtr-modal-content {
                padding: 1rem !important;
                max-height: 100vh !important;
                overflow-y: auto !important;
                background: white !important;
                border-radius: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                height: 100% !important;
            }

            .dtr-modal-header {
                padding: 0.5rem 0 !important;
                margin-bottom: 1rem !important;
                border-bottom: 1px solid #e2e8f0 !important;
                position: relative !important;
            }

            .dtr-modal-header h3 {
                font-size: 1.1em !important;
                margin: 0 !important;
                color: #1e293b !important;
            }

            .dtr-modal-close {
                position: absolute !important;
                top: 0.5rem !important;
                right: 0 !important;
                background: #667eea !important;
                color: white !important;
                border: none !important;
                border-radius: 50% !important;
                width: 30px !important;
                height: 30px !important;
                font-size: 16px !important;
                cursor: pointer !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .dtr-modal table {
                font-size: 12px !important;
                width: 100% !important;
            }

            .dtr-modal th,
            .dtr-modal td {
                padding: 6px 4px !important;
                font-size: 12px !important;
                border-bottom: 1px solid #e2e8f0 !important;
            }

            .dtr-modal th {
                background: #f8fafc !important;
                border-bottom: 1px solid #e2e8f0 !important;
                font-weight: 600 !important;
                color: #1e293b !important;
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
                            <span class="feature-icon">🔍</span>
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

        <!-- Theme Toggle Button - Moved outside portlet, above it -->
        <div class="theme-toggle-container">
            <button id="theme-toggle" class="modern-update-btn">
                <span id="theme-toggle-icon">🌙</span>
                <span id="theme-toggle-text">Dark Mode</span>
            </button>
        </div>

        <!-- Begin::Section -->
        <div class="" style="background-color: white">
            <div class="m-portlet__head custom-modern">
                <div class="m-portlet__head-title custom-modern">
                    <span class="icon">&#128202;</span>
                    <span>CoinMarketCal Events</span>
                </div>
                <div class="m-portlet__head-desc custom-modern">
                    <!-- Optional description -->
                </div>
            </div>

            <div class="">
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
                                    <span class="font-weight:900;">Fullname</span>
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