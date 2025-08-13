@extends('layouts.base')
@section('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        .exchanges-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 1.2em;
        }
        .exchanges-toolbar-btn {
            display: flex;
            align-items: center;
            gap: 0.5em;
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            color: #fff;
            border: none;
            border-radius: 0.7em;
            padding: 0.55em 1.2em;
            font-size: 1.05em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(240,147,251,0.08);
            transition: background 0.2s, box-shadow 0.2s, color 0.2s, transform 0.15s;
        }
        .exchanges-toolbar-btn:hover, .exchanges-toolbar-btn:focus {
            background: linear-gradient(90deg, #f5576c 0%, #f093fb 100%);
            box-shadow: 0 4px 16px rgba(240,147,251,0.15);
            transform: translateY(-1px);
            outline: none;
        }
        .exchanges-toolbar-btn:active {
            transform: translateY(0);
        }
        .exchanges-toolbar-btn svg {
            width: 1.2em;
            height: 1.2em;
        }
        @media (max-width: 600px) {
            .exchanges-toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 0.7em;
            }
            .exchanges-toolbar-btn {
                width: 100%;
                justify-content: center;
            }
        }
        body.exchanges-dark-mode, .exchanges-dark-mode .m-content {
            background: #181a1b !important;
            color: #f3f3f3 !important;
        }
        .exchanges-dark-mode .exchanges-table, .exchanges-dark-mode .dataTables_wrapper {
            background: #23272b !important;
            color: #f3f3f3 !important;
        }
        .exchanges-dark-mode .exchanges-table th, .exchanges-dark-mode .exchanges-table td {
            background: #23272b !important;
            color: #f3f3f3 !important;
        }
        .exchanges-dark-mode .exchanges-toolbar-btn {
            background: linear-gradient(90deg, #23272b 0%, #181a1b 100%);
            color: #f093fb;
        }
        .exchanges-dark-mode .exchanges-toolbar-btn:hover, .exchanges-dark-mode .exchanges-toolbar-btn:focus {
            background: linear-gradient(90deg, #181a1b 0%, #23272b 100%);
            color: #f5576c;
        }
        .beautiful-modern-title-bar {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            border-radius: 1.5em;
            box-shadow: 0 4px 32px rgba(240,147,251,0.10), 0 1.5px 6px rgba(245,87,108,0.08);
            padding: 1.5em 2em 1.2em 2em;
            margin-bottom: 1.2em;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-height: 70px;
            position: relative;
            z-index: 1;
        }
        .beautiful-modern-title-bar .modern-title-main {
            display: flex;
            align-items: center;
            gap: 1.2em;
        }
        .beautiful-modern-title-bar .modern-title-icon {
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(240,147,251,0.10);
            padding: 0.4em;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .beautiful-modern-title-bar .modern-title-text {
            font-size: 2.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 2px 8px rgba(240,147,251,0.10);
        }
        @media (max-width: 900px) {
            .beautiful-modern-title-bar {
                padding: 1.2em 1em 1em 1em;
            }
            .beautiful-modern-title-bar .modern-title-text {
                font-size: 1.5rem;
            }
        }
        @media (max-width: 600px) {
            .beautiful-modern-title-bar {
                padding: 1em 0.5em 0.8em 0.5em;
                min-height: 50px;
            }
            .beautiful-modern-title-bar .modern-title-main {
                gap: 0.7em;
            }
            .beautiful-modern-title-bar .modern-title-text {
                font-size: 1.1rem;
            }
        }
        .modern-title-bar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.2em;
        }
        @media (max-width: 700px) {
            .modern-title-bar-row {
                flex-direction: column;
                align-items: stretch;
                gap: 0.7em;
            }
            .exchanges-toolbar {
                width: 100%;
                justify-content: flex-start;
            }
        }
        .modern-title-bar.beautiful-modern-title-bar {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            border-radius: 1.5em;
            box-shadow: 0 4px 32px rgba(240,147,251,0.10), 0 1.5px 6px rgba(245,87,108,0.08);
            padding: 1.5em 2em 1.2em 2em;
            margin-bottom: 1.2em;
            display: flex;
            align-items: center;
            min-height: 70px;
            position: relative;
            z-index: 1;
            transition: background 0.3s;
        }
        .modern-title-bar-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.2em;
            width: 100%;
        }
        .modern-title-main {
            display: flex;
            align-items: center;
            gap: 1em;
            min-width: 0;
        }
        .modern-title-icon {
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(240,147,251,0.10);
            padding: 0.4em;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            min-height: 40px;
        }
        .modern-title-text {
            font-size: 2.1rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
            text-shadow: 0 2px 8px rgba(240,147,251,0.10);
        }
        .modern-title-actions {
            display: flex;
            align-items: center;
            gap: 1em;
        }
        .modern-title-actions-group {
            display: flex;
            align-items: center;
            gap: 0.8em;
        }
        .modern-tab {
            display: flex;
            align-items: center;
            gap: 0.5em;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: none;
            border-radius: 0.7em;
            padding: 0.55em 1.2em;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .modern-tab:hover, .modern-tab:focus {
            background: rgba(255,255,255,0.25);
            transform: translateY(-1px);
            outline: none;
        }
        .modern-tab:active {
            transform: translateY(0);
        }
        .exchanges-table-responsive {
            background: #fff;
            border-radius: 1.5em;
            box-shadow: 0 4px 24px rgba(240,147,251,0.08), 0 1.5px 6px rgba(245,87,108,0.06);
            padding: 2em;
            margin-top: 1.5em;
        }
        .exchanges-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 1em;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(240,147,251,0.06);
            background: #fff;
        }
        .exchanges-table th {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            color: #fff;
            font-weight: 700;
            padding: 1.2em 1em;
            text-align: left;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            position: relative;
        }
        .exchanges-table th:first-child {
            border-top-left-radius: 1em;
        }
        .exchanges-table th:last-child {
            border-top-right-radius: 1em;
        }
        .exchanges-table td {
            padding: 1em;
            border-bottom: 1px solid #f3f3f3;
            background: #fff;
            transition: background 0.2s;
        }
        .exchanges-table tr:hover td {
            background: #fef7ff;
        }
        .exchanges-table tr:last-child td:first-child {
            border-bottom-left-radius: 1em;
        }
        .exchanges-table tr:last-child td:last-child {
            border-bottom-right-radius: 1em;
        }
        .success {
            color: #28a745;
            font-weight: 600;
        }
        .warning {
            color: #ffc107;
            font-weight: 600;
        }
        .danger {
            color: #dc3545;
            font-weight: 600;
        }
        .info {
            color: #17a2b8;
            font-weight: 600;
        }
        .text-muted {
            color: #6c757d;
        }
        .badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }
        .badge-success {
            color: #fff;
            background-color: #28a745;
        }
        .badge-danger {
            color: #fff;
            background-color: #dc3545;
        }
        .badge-warning {
            color: #212529;
            background-color: #ffc107;
        }
        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }
        .badge-secondary {
            color: #fff;
            background-color: #6c757d;
        }
        .previewable-img {
            border-radius: 0.5em;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .previewable-img:hover {
            transform: scale(1.1);
        }
        .text-primary {
            color: #007bff !important;
            text-decoration: none;
        }
        .text-primary:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .exchanges-table-responsive {
                padding: 1em;
            }
            .exchanges-table th, .exchanges-table td {
                padding: 0.8em 0.5em;
            }
            #cryptocompare_exchanges td[data-label] {
                display: block;
                width: 100%;
                box-sizing: border-box;
                padding-left: 0.5em;
                padding-right: 0.5em;
                border-bottom: 1px solid #f3f3f3;
                background: #f8f9ff;
                position: relative;
            }
            #cryptocompare_exchanges td[data-label]:before {
                content: attr(data-label) ": ";
                font-weight: 700;
                color: #ff6b6b;
                display: block;
                margin-bottom: 0.2em;
            }
        }
        /* Navigation Tabs Styles */
        .modern-tabs-container {
            background: linear-gradient(90deg, #ff6b6b 0%, #ee5a24 100%);
            border-radius: 1.5em;
            box-shadow: 0 4px 24px rgba(255,107,107,0.08), 0 1.5px 6px rgba(238,90,36,0.06);
            padding: 1.5em;
            margin-bottom: 1.5em;
        }
        .modern-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8em;
            justify-content: center;
        }
        .beautiful-tab {
            display: flex;
            align-items: center;
            gap: 0.5em;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: none;
            border-radius: 0.7em;
            padding: 0.8em 1.2em;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            backdrop-filter: blur(10px);
        }
        .beautiful-tab:hover, .beautiful-tab:focus {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
            outline: none;
            box-shadow: 0 4px 16px rgba(255,255,255,0.2);
        }
        .beautiful-tab.active {
            background: rgba(255,255,255,0.3);
            box-shadow: 0 4px 16px rgba(255,255,255,0.3);
        }
        .beautiful-tab:active {
            transform: translateY(0);
        }
        .tab-icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .tab-label {
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .modern-tabs {
                flex-direction: column;
                align-items: stretch;
            }
            .beautiful-tab {
                justify-content: center;
            }
        }
    </style>
@endsection
@section('content')
    <div class="m-content">
        <!-- Modern Title Bar with Icon -->
        <div class="beautiful-modern-title-bar">
            <div class="modern-title-bar-row">
                <div class="modern-title-main">
                    <div class="modern-title-icon">
                        <!-- Exchanges Icon SVG -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="exchangesGradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#f093fb"/>
                                    <stop offset="1" stop-color="#f5576c"/>
                                </linearGradient>
                            </defs>
                            <rect x="4" y="4" width="24" height="24" rx="8" fill="url(#exchangesGradient)"/>
                            <path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="modern-title-text">CryptoCompare Exchanges</div>
                </div>
                <div class="exchanges-toolbar">
                    <!-- Dark Mode Toggle -->
                    <button id="exchangesDarkModeBtn" class="exchanges-toolbar-btn" title="Toggle dark/light mode">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" fill="currentColor"/>
                        </svg>
                        <span>Dark Mode</span>
                    </button>
                    <!-- Refresh Button -->
                    <button id="refreshExchangesBtn" class="exchanges-toolbar-btn" title="Refresh data">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <defs>
                                <linearGradient id="refreshGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#f093fb"/>
                                    <stop offset="1" stop-color="#f5576c"/>
                                </linearGradient>
                            </defs>
                            <circle cx="12" cy="12" r="10" fill="#fff"/>
                            <path d="M19 8A8 8 0 1 0 20 12h-1.5" stroke="url(#refreshGradient)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="18 2 18 9 25 9" stroke="url(#refreshGradient)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                        <span>Refresh</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="modern-tabs-container gradient-tabs-bg">
            <nav class="modern-tabs beautiful-tabs" aria-label="CryptoCompare navigation">
                <a href="/cryptocomparecoinsindex" class="modern-tab beautiful-tab {{ request()->is('cryptocomparecoinsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Coins Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="#667eea"/>
                            <circle cx="12" cy="12" r="6" fill="#fff" opacity="0.9"/>
                            <text x="12" y="16" text-anchor="middle" font-size="8" fill="#667eea" font-family="Arial, sans-serif" font-weight="bold">₿</text>
                        </svg>
                    </span>
                    <span class="tab-label">Coins</span>
                </a>
                <a href="/cryptocomparemarketsindex" class="modern-tab beautiful-tab {{ request()->is('cryptocomparemarketsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Markets Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" fill="#11998e"/>
                            <path d="M12 7v5l4 2" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="tab-label">Markets</span>
                </a>
                <a href="/cryptocompareexchangesindex" class="modern-tab beautiful-tab {{ request()->is('cryptocompareexchangesindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Exchanges Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="5" fill="#ff6b6b"/>
                            <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="tab-label">Exchanges</span>
                </a>
                <a href="/cryptocomparenewsindex" class="modern-tab beautiful-tab {{ request()->is('cryptocomparenewsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- News Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="5" fill="#764ba2"/>
                            <path d="M8 8h8M8 12h8M8 16h5" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="tab-label">News</span>
                </a>
                <a href="/cryptocomparetopairsindex" class="modern-tab beautiful-tab {{ request()->is('cryptocomparetopairsindex') ? 'active' : '' }}" tabindex="0">
                    <span class="tab-icon">
                        <!-- Top Pairs Icon -->
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="5" fill="#667eea"/>
                            <path d="M8 8h8M8 12h8M8 16h8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="tab-label">Top Pairs</span>
                </a>
            </nav>
        </div>

        <!-- DataTable Section -->
        <div class="exchanges-table-responsive">
            <input type="hidden" id="cryptocompare_exchanges_route" value="{{ route('datatable.cryptocompare.exchanges') }}">
            <!-- Enhanced Table -->
            <div class="table-wrapper" id="exchangesTableWrapper">
                <table id="cryptocompare_exchanges" class="exchanges-table table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                    <thead>
                        <tr>
                            <th class="datatable-highlight-first enhanced-th">
                                <span class="datatable-header-text" style="display:block; text-align:center;">Name</span>
                                <span class="datatable-header-icon" style="display:block; text-align:center; margin-top:2px;">
                                    <!-- Exchange Icon SVG -->
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="exchangeSymbolGradient" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#f093fb"/>
                                                <stop offset="1" stop-color="#f5576c"/>
                                            </linearGradient>
                                        </defs>
                                        <rect x="2" y="2" width="20" height="20" rx="6" fill="url(#exchangeSymbolGradient)"/>
                                        <path d="M8 12h8M12 8v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                            </th>
                            <th>Internal Name</th>
                            <th>Logo</th>
                            <th>URL</th>
                            <th>Country</th>
                            <th>Centralized</th>
                            <th>Grade</th>
                            <th>Grade Points</th>
                            <th>Sort Order</th>
                            <th>Sponsored</th>
                            <th>Recommended</th>
                            <th>Description</th>
                            <th>Data Symbols Count</th>
                            <th>Volume 1hr USD</th>
                            <th>Volume 1day USD</th>
                            <th>Volume 1mth USD</th>
                            <th>Item Type</th>
                            <th>Features</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var exchangesTable = $('#cryptocompare_exchanges').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: $('#cryptocompare_exchanges_route').val(),
                    type: 'GET'
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'internal_name', name: 'internal_name'},
                    {data: 'logo_url', name: 'logo_url'},
                    {data: 'url', name: 'url'},
                    {data: 'country', name: 'country'},
                    {data: 'centralized', name: 'centralized'},
                    {data: 'grade', name: 'grade'},
                    {data: 'grade_points', name: 'grade_points'},
                    {data: 'sort_order', name: 'sort_order'},
                    {data: 'sponsored', name: 'sponsored'},
                    {data: 'recommended', name: 'recommended'},
                    {data: 'description', name: 'description'},
                    {data: 'data_symbols_count', name: 'data_symbols_count'},
                    {data: 'volume_1hrs_usd', name: 'volume_1hrs_usd'},
                    {data: 'volume_1day_usd', name: 'volume_1day_usd'},
                    {data: 'volume_1mth_usd', name: 'volume_1mth_usd'},
                    {data: 'item_type', name: 'item_type'},
                    {data: 'features', name: 'features'}
                ],
                responsive: true,
                order: [[7, 'desc']], // Sort by grade points by default
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                language: {
                    search: "Search exchanges:",
                    lengthMenu: "Show _MENU_ exchanges per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ exchanges",
                    infoEmpty: "Showing 0 to 0 of 0 exchanges",
                    infoFiltered: "(filtered from _MAX_ total exchanges)",
                    zeroRecords: "No exchanges found"
                }
            });

            // Dark Mode Toggle
            $('#exchangesDarkModeBtn').click(function() {
                $('body').toggleClass('exchanges-dark-mode');
                var isDark = $('body').hasClass('exchanges-dark-mode');
                $(this).find('span').text(isDark ? 'Light Mode' : 'Dark Mode');
            });

            // Refresh Button
            $('#refreshExchangesBtn').click(function() {
                exchangesTable.ajax.reload();
            });
        });
    </script>
@endsection 