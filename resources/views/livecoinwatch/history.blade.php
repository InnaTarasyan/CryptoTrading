@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <style>
        /* Responsive DataTable for mobile */
        @media (max-width: 767px) {
            #livecoin_history thead {
            display: none;
        }
            #livecoin_history tbody, #livecoin_history tr, #livecoin_history td {
            display: block;
                width: 100%;
            }
            #livecoin_history tr {
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.03);
                background: #fff;
                padding: 0.5rem 0.75rem;
            }
            #livecoin_history td {
                text-align: left;
                padding-left: 50%;
            position: relative;
                border: none;
                border-bottom: 1px solid #eee;
                min-height: 40px;
                box-sizing: border-box;
            }
            #livecoin_history td:last-child {
                border-bottom: none;
            }
            #livecoin_history td:before {
                content: attr(data-label);
            position: absolute;
                left: 0.75rem;
            top: 0;
                width: 45%;
                white-space: nowrap;
                font-weight: bold;
                color: #333;
                font-size: 0.95em;
            }
        }
        /* Custom DataTable Search Bar (like CoinMarketCal) */
        .dataTables_filter {
            width: 100%;
            max-width: 400px;
            margin-bottom: 18px;
            float: right;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            background: none;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
        }
        .dataTables_filter .search-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            position: relative;
        }
        .dataTables_filter .search-icon {
            position: absolute;
            left: 16px;
            width: 22px;
            height: 22px;
            pointer-events: none;
            top: 50%;
            transform: translateY(-50%);
        }
        .dataTables_filter input[type="search"] {
            border-radius: 24px;
            border: 1.5px solid #ffd200;
            padding: 8px 44px 8px 44px;
            background: #fffbe7;
            transition: border 0.2s, box-shadow 0.2s;
            font-size: 15px;
            outline: none;
            color: #333;
            width: 100%;
            box-shadow: 0 2px 8px rgba(255,215,0,0.08);
        }
        .dataTables_filter input[type="search"]:focus {
            border: 1.5px solid #f7971e;
            background: #fff;
            box-shadow: 0 2px 8px rgba(247,151,30,0.08);
        }
        .dataTables_filter #clear-search {
            margin-left: 8px;
            border: none;
            background: linear-gradient(90deg, #ff512f 0%, #dd2476 100%);
            color: #fff;
            border-radius: 16px;
            padding: 8px 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(221,36,118,0.12);
        }
        .dataTables_filter #clear-search:hover {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
        }
        /* --- CoinMarketCal-style DataTables Length Selector --- */
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 18px;
            float: left;
            background: linear-gradient(90deg, #f7971e 0%, #ffd200 100%);
            padding: 8px 18px;
            border-radius: 24px;
            box-shadow: 0 2px 8px rgba(255,215,0,0.08);
            font-weight: 500;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dataTables_wrapper .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0;
        }
        .dataTables_wrapper .dataTables_length select {
            border-radius: 16px;
            border: 1.5px solid #ffd200;
            padding: 6px 32px 6px 16px;
            background: #fffbe7 url("data:image/svg+xml,%3Csvg width='16' height='16' fill='orange' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4 6l4 4 4-4' stroke='%23f7971e' stroke-width='2' fill='none'/%3E%3C/svg%3E") no-repeat right 10px center/18px 18px;
            color: #333;
            font-size: 15px;
            margin-left: 8px;
            outline: none;
            transition: border 0.2s, box-shadow 0.2s;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
        .dataTables_wrapper .dataTables_length select:focus {
            border: 1.5px solid #f7971e;
            box-shadow: 0 2px 8px rgba(247,151,30,0.08);
        }
        @media (max-width: 600px) {
            .dataTables_wrapper .dataTables_length {
                width: 100%;
                justify-content: center;
                padding: 8px 8px;
                font-size: 14px;
            }
            .dataTables_wrapper .dataTables_length select {
                font-size: 14px;
                padding: 6px 28px 6px 12px;
            }
        }
        /* --- CoinMarketCal-style DataTables Pagination --- */
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 18px;
            float: right;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            border: none;
                border-radius: 8px;
            margin: 0 4px;
            color: #fff !important;
            padding: 8px 18px;
            font-weight: 600;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(67,206,162,0.08);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(90deg, #ff512f 0%, #dd2476 100%);
            color: #fff !important;
            box-shadow: 0 4px 16px rgba(221,36,118,0.12);
        }
        /* --- CoinMarketCal-style DataTables Info Box --- */
        .datatable-info-beautiful {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            background: linear-gradient(90deg, #e0eafc 0%, #cfdef3 100%);
            color: #4a4e69;
            border-radius: 18px;
            padding: 12px 28px;
            margin: 18px 0 0 0;
            font-size: 1.15rem;
            font-family: 'Poppins', 'Segoe UI', 'Roboto', Arial, sans-serif;
            box-shadow: 0 2px 12px rgba(106,17,203,0.08);
            font-weight: 500;
            gap: 16px;
            min-height: 48px;
        }
        .datatable-info-beautiful .datatable-info-icon {
            font-size: 1.7rem;
            margin-right: 10px;
            color: #6a11cb;
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 8px rgba(106,17,203,0.10);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .datatable-info-beautiful .datatable-info-text {
            color: #5f6caf;
            font-size: 1.15rem;
            font-weight: 600;
        }
        .datatable-info-beautiful strong {
            color: #f7971e;
            font-weight: 700;
            font-size: 1.1em;
        }
        @media (max-width: 600px) {
            .datatable-info-beautiful {
                font-size: 1rem;
                padding: 10px 8px;
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
            .datatable-info-beautiful .datatable-info-icon {
            font-size: 1.2rem;
                padding: 6px;
                margin-right: 0;
                margin-bottom: 4px;
            }
        }

        /* Beautiful DataTable Headers */
            #livecoin_history thead th {
            background-color: #f4f6f9;
            color: #525f7f;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            border-top: 1px solid #e9ecef;
            padding: 1rem 1.25rem;
                font-size: 1.15rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }
        .datatable-header-icon {
            display: inline-flex;
            align-items: center;
                justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffd200 0%, #f7971e 100%);
            box-shadow: 0 2px 8px rgba(255,215,0,0.10);
            margin-right: 0.5em;
            font-size: 1.35em;
            color: #fff;
            border: 2px solid #fffbe7;
            transition: background 0.2s, box-shadow 0.2s;
        }
        #livecoin_history thead th .datatable-header-icon {
            vertical-align: middle;
        }
        #livecoin_history thead th .datatable-header-icon i {
            color: #fff;
            font-size: 1.25em;
        }
        .datatable-header-text {
            font-size: 1.15em;
            vertical-align: middle;
            margin-left: 0.35em;
        }
        #livecoin_history thead th.sorting,
        #livecoin_history thead th.sorting_asc,
        #livecoin_history thead th.sorting_desc {
            cursor: pointer;
        }

        #livecoin_history thead th.sorting:hover,
        #livecoin_history thead th.sorting_asc:hover,
        #livecoin_history thead th.sorting_desc:hover {
            background-color: #e9ecef;
        }

        /* Modern Tabs Navigation */
        .modern-tabs-container {
            margin-bottom: 1.5rem;
        }

        .modern-tabs {
            display: flex;
            flex-wrap: wrap;
                gap: 8px;
            border-bottom: 1px solid #dee2e6;
        }

        .modern-tab {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            text-decoration: none;
            background-color: transparent;
            border: 1px solid transparent;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
            transition: all 0.2s ease-in-out;
            position: relative;
            bottom: -1px;
        }

        .modern-tab:hover {
            background-color: #f8f9fa;
            border-color: #e9ecef #e9ecef #dee2e6;
            color: #0d6efd;
        }

        .modern-tab.active {
            color: #0d6efd;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        /* Responsive Styles */
        @media (max-width: 767px) {
            .modern-tabs {
                flex-direction: column;
                border-bottom: none;
                gap: 5px;
            }
            .modern-tab {
                width: 100%;
            text-align: center;
                border: 1px solid #dee2e6;
                border-radius: 8px;
            bottom: 0;
            }
            .modern-tab.active {
                background: linear-gradient(90deg, #0d6efd 0%, #007bff 100%);
                color: #fff;
                border-color: transparent;
            }
            }

            #livecoin_history tbody td {
            font-style: italic;
        }

        #livecoin_history th:first-child,
        #livecoin_history td:first-child {
            background: linear-gradient(90deg, #fffbe7 0%, #ffd200 100%);
            color: #333;
            font-weight: bold;
            border-right: 2px solid #ffd200;
        }

        /* --- DARK MODE OVERRIDES --- */
        body.dark-mode, .dark-mode .m-content {
            background: #181a20 !important;
            color: #eaeaea !important;
        }
        .dark-mode .m-portlet, .dark-mode .table-responsive, .dark-mode #livecoin_history tr {
            background: #23272f !important;
            color: #eaeaea !important;
        }
        .dark-mode #livecoin_history thead th {
            background-color: #23272f !important;
            color: #ffd200 !important;
            border-bottom: 2px solid #23272f !important;
            border-top: 1px solid #23272f !important;
        }
        .dark-mode #livecoin_history tbody td {
            background: #23272f !important;
            color: #eaeaea !important;
            border-bottom: 1px solid #23272f !important;
        }
        .dark-mode #livecoin_history th:first-child,
        .dark-mode #livecoin_history td:first-child {
            background: linear-gradient(90deg, #23272f 0%, #ffd200 100%) !important;
            color: #ffd200 !important;
            border-right: 2px solid #ffd200 !important;
        }
        .dark-mode .modern-tab {
            background: #23272f !important;
            color: #ffd200 !important;
            border-color: #23272f !important;
        }
        .dark-mode .modern-tab.active {
            background: linear-gradient(90deg, #23272f 0%, #181a20 100%) !important;
            color: #ffd200 !important;
            border-color: #ffd200 #ffd200 #23272f !important;
        }
        .dark-mode .dataTables_filter input[type="search"] {
            background: #23272f !important;
            color: #ffd200 !important;
            border: 1.5px solid #ffd200 !important;
        }
        .dark-mode .dataTables_filter input[type="search"]:focus {
            background: #181a20 !important;
            border: 1.5px solid #f7971e !important;
        }
        .dark-mode .dataTables_filter #clear-search {
            background: linear-gradient(90deg, #23272f 0%, #ffd200 100%) !important;
            color: #ffd200 !important;
        }
        .dark-mode .dataTables_filter #clear-search:hover {
            background: linear-gradient(90deg, #ffd200 0%, #23272f 100%) !important;
            color: #23272f !important;
        }
        .dark-mode .dataTables_wrapper .dataTables_length {
            background: linear-gradient(90deg, #23272f 0%, #ffd200 100%) !important;
            color: #ffd200 !important;
        }
        .dark-mode .dataTables_wrapper .dataTables_length select {
            background: #23272f !important;
            color: #ffd200 !important;
            border: 1.5px solid #ffd200 !important;
        }
        .dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: linear-gradient(90deg, #23272f 0%, #ffd200 100%) !important;
            color: #ffd200 !important;
        }
        .dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(90deg, #ffd200 0%, #23272f 100%) !important;
            color: #23272f !important;
        }
        .dark-mode .datatable-info-beautiful {
            background: linear-gradient(90deg, #23272f 0%, #181a20 100%) !important;
            color: #ffd200 !important;
        }
        .dark-mode .datatable-info-beautiful .datatable-info-icon {
            background: linear-gradient(135deg, #23272f 0%, #ffd200 100%) !important;
            color: #ffd200 !important;
        }
        .dark-mode .datatable-info-beautiful .datatable-info-text {
            color: #ffd200 !important;
        }
        .dark-mode .datatable-info-beautiful strong {
            color: #f7971e !important;
        }
        /* SVG color tweaks for dark mode */
        .dark-mode #livecoin_history thead th .datatable-header-icon svg {
            filter: brightness(0.8) contrast(1.2);
        }
        .darkmode-switch {
            display: flex !important;
            align-items: center;
            gap: 10px;
            background: linear-gradient(90deg, #ffd200 0%, #f7971e 100%);
            color: #333;
            border: none;
            border-radius: 999px;
            padding: 8px 24px 8px 12px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(255,215,0,0.10);
            cursor: pointer;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            position: relative;
                min-width: 120px;
            outline: none;
        }
        .darkmode-switch:focus {
            box-shadow: 0 0 0 3px #ffd20055;
        }
        .darkmode-switch:hover {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
        }
        .darkmode-switch .darkmode-switch-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #fffbe7;
            box-shadow: 0 2px 8px rgba(255,215,0,0.10);
            margin-right: 8px;
            transition: background 0.2s;
            position: relative;
                overflow: hidden;
        }
        .darkmode-switch .icon-moon,
        .darkmode-switch .icon-sun {
            position: absolute;
            left: 0;
            top: 0;
                width: 100%;
            height: 100%;
                opacity: 0;
            transition: opacity 0.3s, transform 0.3s;
            }
        .darkmode-switch .icon-moon {
                opacity: 1;
            transform: scale(1);
        }
        .darkmode-switch.active .icon-moon {
            opacity: 0;
            transform: scale(0.7);
        }
        .darkmode-switch .icon-sun {
            opacity: 0;
            transform: scale(0.7);
        }
        .darkmode-switch.active .icon-sun {
            opacity: 1;
                transform: scale(1);
            }
        .darkmode-switch .darkmode-switch-label {
            transition: color 0.2s;
        }
        .dark-mode .darkmode-switch {
            background: linear-gradient(90deg, #23272f 0%, #ffd200 100%) !important;
            color: #ffd200 !important;
        }
        .dark-mode .darkmode-switch .darkmode-switch-icon {
            background: #23272f !important;
        }
        .dark-mode .darkmode-switch:focus {
            box-shadow: 0 0 0 3px #ffd20055;
        }
        .dark-mode .darkmode-switch:hover {
            background: linear-gradient(90deg, #ffd200 0%, #23272f 100%) !important;
            color: #23272f !important;
        }
        #datatableFullscreenContainer:fullscreen {
            background: #fff;
            z-index: 9999;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100vw;
            height: 100vh;
            padding: 2vw;
            overflow: auto;
        }
        body.dark-mode #datatableFullscreenContainer:fullscreen {
            background: #181a20;
        }
        #datatableFullscreenContainer:fullscreen table {
            width: 100% !important;
            font-size: 1.1em;
        }
        .fullscreen-switch {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
            border: none;
            border-radius: 24px;
            padding: 10px 28px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(67,206,162,0.12);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.1s;
            outline: none;
            position: relative;
            min-width: 160px;
        }
        .fullscreen-switch:focus {
            box-shadow: 0 0 0 3px #43cea255;
        }
        .fullscreen-switch:hover {
            background: linear-gradient(90deg, #ff512f 0%, #dd2476 100%);
            color: #fff;
            transform: translateY(-2px) scale(1.03);
        }
        .fullscreen-switch.active {
            background: linear-gradient(90deg, #ff512f 0%, #dd2476 100%);
            color: #fff;
        }
        .fullscreen-switch-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fffbe7;
            box-shadow: 0 2px 8px rgba(255,215,0,0.10);
            margin-right: 8px;
            transition: background 0.2s;
            position: relative;
            overflow: hidden;
        }
        .fullscreen-switch-label {
            font-size: 1.1em;
            font-weight: 600;
            transition: color 0.2s;
        }
        @media (max-width: 600px) {
            .fullscreen-switch {
            width: 100%;
                justify-content: center;
                font-size: 0.98rem;
                padding: 10px 10px;
            }
            .fullscreen-switch-label {
                font-size: 1em;
            }
        }
        /* Highlight search results (CoinMarketCal style) */
        .dataTables_wrapper .highlight {
            background: #fffbe7 !important;
            color: #ff512f !important;
            font-weight: bold;
            border-radius: 4px;
            padding: 2px 2px;
            box-shadow: 0 1px 4px rgba(255,215,0,0.08);
            transition: background 0.2s, color 0.2s;
        }
        body.dark-mode .dataTables_wrapper .highlight {
            background: #333 !important;
            color: #ffd200 !important;
        }
        /* --- Beautiful Tabs Redesign --- */
        .beautiful-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            border-bottom: none;
            background: linear-gradient(90deg, #fffbe7 0%, #ffd200 100%);
            border-radius: 16px;
            padding: 8px 10px;
            box-shadow: 0 2px 12px rgba(255,215,0,0.08);
            justify-content: flex-start;
        }
        .beautiful-tab {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 26px;
            font-size: 1.08rem;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            background: #fff;
            border: none;
            border-radius: 12px 12px 0 0;
            position: relative;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.1s;
            box-shadow: 0 1px 4px rgba(255,215,0,0.04);
            outline: none;
        }
        .beautiful-tab .tab-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: #fffbe7;
            border-radius: 50%;
            box-shadow: 0 1px 4px rgba(255,215,0,0.08);
        }
        .beautiful-tab .tab-label {
            margin-left: 2px;
        }
        .beautiful-tab.active, .beautiful-tab:focus {
            background: linear-gradient(90deg, #ffd200 0%, #f7971e 100%);
            color: #fff;
            box-shadow: 0 4px 16px rgba(247,151,30,0.12);
            z-index: 2;
            transform: translateY(-2px) scale(1.04);
        }
        .beautiful-tab.active .tab-icon, .beautiful-tab:focus .tab-icon {
            background: #fff;
        }
        .beautiful-tab:hover:not(.active) {
            background: #fffbe7;
            color: #0d6efd;
            transform: translateY(-1px) scale(1.02);
        }
        @media (max-width: 767px) {
            .beautiful-tabs {
                flex-direction: column;
                gap: 8px;
                padding: 6px 2px;
                border-radius: 12px;
            }
            .beautiful-tab {
                width: 100%;
                border-radius: 10px;
                justify-content: flex-start;
                font-size: 1rem;
                padding: 12px 12px;
            }
            .beautiful-tab .tab-icon {
                width: 24px;
                height: 24px;
            }
        }
        /* Dark mode for beautiful tabs */
        body.dark-mode .beautiful-tabs {
            background: linear-gradient(90deg, #23272f 0%, #ffd200 100%) !important;
        }
        body.dark-mode .beautiful-tab {
            background: #23272f !important;
            color: #ffd200 !important;
        }
        body.dark-mode .beautiful-tab.active, body.dark-mode .beautiful-tab:focus {
            background: linear-gradient(90deg, #ffd200 0%, #23272f 100%) !important;
            color: #23272f !important;
        }
        body.dark-mode .beautiful-tab .tab-icon {
            background: #23272f !important;
        }
        body.dark-mode .beautiful-tab.active .tab-icon, body.dark-mode .beautiful-tab:focus .tab-icon {
            background: #ffd200 !important;
        }
    </style>
@endsection
@section('content')
    <div class="m-content">
        <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 1rem;">
            <button id="darkModeToggle" class="modern-tab darkmode-switch" style="margin-left: auto;" title="Toggle dark mode" role="switch" aria-checked="false">
                <span class="darkmode-switch-icon" id="darkModeIcon">
                    <!-- Sun & Moon SVG for animation -->
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
        <div class="modern-tabs-container">
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

        <!-- Fullscreen Button -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: 0.5rem;">
            <button id="fullscreenToggle"
                    class="modern-tab fullscreen-switch"
                    style="margin-left: auto;"
                    title="Toggle Fullscreen"
                    aria-label="Toggle Fullscreen"
                    aria-pressed="false"
                    role="button">
                <span class="fullscreen-switch-icon" id="fullscreenIcon">
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
        <!--Begin::Section-->
        <div class="m-portlet" >
            <div class="m-portlet__body mt-5">
                <input type="hidden" id="livecoin_history_route" value="{{ route('datatable.livecoin.history') }}">
                <!-- Fullscreen Container Start -->
                <div id="datatableFullscreenContainer" class="table-responsive">
                    <table id="livecoin_history" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                           <th><span class="datatable-header-icon">  
                              <!-- Coin SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="14" fill="#43cea2"/><circle cx="16" cy="16" r="10" fill="#fff"/><circle cx="16" cy="16" r="7" fill="#43cea2"/></svg>
                           </span> <span class="datatable-header-text">Coin</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Logo SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="6" fill="#ff512f"/><circle cx="16" cy="16" r="8" fill="#fff"/></svg>
                           </span> <span class="datatable-header-text">Logo</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Dollar SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/><text x="16" y="21" text-anchor="middle" font-size="16" fill="#fff" font-family="Arial, sans-serif" font-weight="bold">$</text></svg>
                           </span> <span class="datatable-header-text">Price</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Hourglass SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="12" fill="#a8edea"/><path d="M10 8h12M10 24h12M12 8c0 6 8 6 8 0M12 24c0-6 8-6 8 0" stroke="#185a9d" stroke-width="2" stroke-linecap="round"/></svg>
                           </span> <span class="datatable-header-text">Age</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Pairs SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="12" fill="#f7971e"/><path d="M12 16h8M16 12v8" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                           </span> <span class="datatable-header-text">Pairs</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Exchange SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="12" fill="#43cea2"/><path d="M10 16h12M16 10v12" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                           </span> <span class="datatable-header-text">Volume (24h)</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Pie Chart SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="12" fill="#ff512f"/><path d="M16 16V8A8 8 0 1 1 8 24" fill="#fff"/></svg>
                           </span> <span class="datatable-header-text">Market Cap</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Trophy SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="12" fill="#ffd200"/><path d="M12 20h8M16 20v4M10 8h12v4a6 6 0 0 1-12 0V8z" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
                           </span> <span class="datatable-header-text">Rank</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- List SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="12" fill="#6a11cb"/><rect x="10" y="10" width="12" height="2" fill="#fff"/><rect x="10" y="15" width="12" height="2" fill="#fff"/><rect x="10" y="20" width="12" height="2" fill="#fff"/></svg>
                           </span> <span class="datatable-header-text">Markets</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Database SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><ellipse cx="16" cy="10" rx="10" ry="4" fill="#11998e"/><rect x="6" y="10" width="20" height="12" rx="6" fill="#fff"/><ellipse cx="16" cy="22" rx="10" ry="4" fill="#11998e"/></svg>
                           </span> <span class="datatable-header-text">Total Supply</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Cubes SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="6" fill="#f7971e"/><rect x="10" y="10" width="4" height="4" fill="#fff"/><rect x="18" y="10" width="4" height="4" fill="#fff"/><rect x="10" y="18" width="4" height="4" fill="#fff"/><rect x="18" y="18" width="4" height="4" fill="#fff"/></svg>
                           </span> <span class="datatable-header-text">Max Supply</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Circle SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="12" fill="#43cea2"/><circle cx="16" cy="16" r="7" fill="#fff"/></svg>
                           </span> <span class="datatable-header-text">Circulating Supply</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Line Chart SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="12" fill="#ff512f"/><polyline points="8,24 14,18 18,22 24,10" stroke="#fff" stroke-width="2" fill="none"/></svg>
                           </span> <span class="datatable-header-text">All-Time High</span></th>
                           <th><span class="datatable-header-icon">
                              <!-- Tags SVG -->
                              <svg viewBox="0 0 32 32" fill="none" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="24" height="24" rx="8" fill="#6a11cb"/><rect x="10" y="10" width="12" height="4" rx="2" fill="#fff"/><rect x="10" y="18" width="8" height="4" rx="2" fill="#fff"/></svg>
                           </span> <span class="datatable-header-text">Categories</span></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!--End::Section-->
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('js/livecoin/history.js') }}"></script>
    <script>
        // Dark mode toggle logic
        function setDarkMode(enabled) {
            if (enabled) {
                document.body.classList.add('dark-mode');
                document.getElementById('darkModeToggle').classList.add('active');
                document.getElementById('darkModeToggle').setAttribute('aria-checked', 'true');
                document.getElementById('darkModeText').textContent = 'Light Mode';
                } else {
                document.body.classList.remove('dark-mode');
                document.getElementById('darkModeToggle').classList.remove('active');
                document.getElementById('darkModeToggle').setAttribute('aria-checked', 'false');
                document.getElementById('darkModeText').textContent = 'Dark Mode';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const darkModePref = localStorage.getItem('darkMode') === 'true';
            setDarkMode(darkModePref);
            document.getElementById('darkModeToggle').addEventListener('click', function() {
                const isDark = !document.body.classList.contains('dark-mode');
                setDarkMode(isDark);
                localStorage.setItem('darkMode', isDark);
            });

            // Fullscreen logic
            const fsBtn = document.getElementById('fullscreenToggle');
            const fsContainer = document.getElementById('datatableFullscreenContainer');
            const fsIconEnter = fsBtn.querySelector('.icon-fullscreen');
            const fsIconExit = fsBtn.querySelector('.icon-exit-fullscreen');
            const fsText = document.getElementById('fullscreenText');

            function isFullscreen() {
                return document.fullscreenElement === fsContainer;
            }

            function toggleFullscreen() {
                if (!isFullscreen()) {
                    if (fsContainer.requestFullscreen) {
                        fsContainer.requestFullscreen();
                    } else if (fsContainer.webkitRequestFullscreen) { /* Safari */
                        fsContainer.webkitRequestFullscreen();
                    } else if (fsContainer.msRequestFullscreen) { /* IE11 */
                        fsContainer.msRequestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) { /* Safari */
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) { /* IE11 */
                        document.msExitFullscreen();
                    }
                }
            }

            fsBtn.addEventListener('click', toggleFullscreen);

            document.addEventListener('fullscreenchange', function() {
                if (isFullscreen()) {
                    fsBtn.classList.add('active');
                    fsBtn.setAttribute('aria-pressed', 'true');
                    fsText.textContent = 'Exit Fullscreen';
                    fsIconEnter.style.display = 'none';
                    fsIconExit.style.display = '';
                        } else {
                    fsBtn.classList.remove('active');
                    fsBtn.setAttribute('aria-pressed', 'false');
                    fsText.textContent = 'Fullscreen';
                    fsIconEnter.style.display = '';
                    fsIconExit.style.display = 'none';
                }
            });
        });
    </script>
@endsection