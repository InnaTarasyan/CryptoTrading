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
        /* Responsive and User-Friendly m-portlet__body */
        .m-portlet__body {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(67, 206, 162, 0.08);
            padding: 32px 32px 24px 32px;
            margin-bottom: 24px;
            transition: box-shadow 0.2s;
        }
        .m-portlet__body--no-padding {
            padding: 0 !important;
        }
        @media (max-width: 991px) {
            .m-portlet__body {
                padding: 18px 8px 12px 8px;
                border-radius: 12px;
            }
        }
        @media (max-width: 600px) {
            .m-portlet__body {
                padding: 8px 2px 6px 2px;
                border-radius: 8px;
                box-shadow: 0 1px 4px rgba(67, 206, 162, 0.10);
            }
        }
        /* Make table horizontally scrollable on small screens */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        @media (max-width: 767px) {
            .table-responsive {
                border-radius: 8px;
                box-shadow: 0 1px 4px rgba(67, 206, 162, 0.10);
                background: #fff;
                padding: 0.5rem 0.25rem;
            }
        }
        /* Add subtle hover effect for table rows */
        #livecoin_history tbody tr:hover {
            background: #fffbe7;
            transition: background 0.2s;
        }
    </style>
@endsection
@section('content')
    <div class="m-content">
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item">
                <a href="/" class="m-nav__link">
                        <span class="m-nav__link-text">
                           History
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/livecoinexchangesindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Exchanges
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/livecoinfiatsindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Fiats
                        </span>
                </a>
            </li>
        </ul>

        <!--Begin::Section-->
        <div class="m-portlet" >
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <input type="hidden" id="livecoin_history_route" value="{{ route('datatable.livecoin.history') }}">
                <div class="table-responsive">
                    <table id="livecoin_history" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                           <th>Code</th>
                           <th>Image</th>
                           <th>Rate</th>
                           <th>Age</th>
                           <th>Pairs</th>
                           <th>Volume</th>
                           <th>Cap</th>
                           <th>Rank</th>
                           <th>Markets</th>
                           <th>Total Supply</th>
                           <th>Max Supply</th>
                           <th>Circulating Supply</th>
                           <th>All Time High USD</th>
                           <th>Categories</th>
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
@endsection