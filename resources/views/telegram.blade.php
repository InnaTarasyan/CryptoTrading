@extends('layouts.base')
@section('styles')
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" rel="stylesheet" />
    <!-- DataTables CSS with Responsive features -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet" />
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
    <link href="{{url('css/telegram.css')}}" rel="stylesheet">

    <style>
        /* Modern DataTable Styles for Telegram Page */
        .modern-datatable-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin: 20px 0;
            border: 1px solid #e2e8f0;
        }

        #telegram {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            background: transparent;
        }

        #telegram thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            font-size: 14px;
            padding: 18px 16px;
            border: none;
            text-align: left;
            position: relative;
            transition: all 0.3s ease;
        }

        #telegram thead th:first-child {
            border-top-left-radius: 16px;
        }

        #telegram thead th:last-child {
            border-top-right-radius: 16px;
        }

        #telegram thead th:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
        }

        #telegram tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        #telegram tbody tr:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        #telegram tbody tr:last-child {
            border-bottom: none;
        }

        #telegram tbody td {
            padding: 16px;
            font-size: 14px;
            color: #374151;
            border: none;
            vertical-align: middle;
        }

        /* Modern Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-edit, .btn-delete {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* DataTable Controls Styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            margin: 16px;
            color: #6b7280;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 12px;
            background: white;
            color: #374151;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 16px;
            background: white;
            color: #374151;
            font-size: 14px;
            transition: all 0.3s ease;
            width: 250px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: #9ca3af;
        }

        /* Pagination Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 16px;
            margin: 0 4px;
            background: white;
            color: #374151 !important;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background: #f3f4f6;
            color: #9ca3af !important;
            border-color: #e5e7eb;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Info Display */
        .dataTables_wrapper .dataTables_info {
            padding: 16px;
            background: #f8fafc;
            border-radius: 8px;
            margin: 16px;
            font-size: 14px;
            color: #6b7280;
        }

        /* Loading State */
        .dataTables_processing {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border-radius: 12px !important;
            padding: 20px 40px !important;
            font-weight: 600 !important;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3) !important;
        }

        /* Enhanced Mobile Responsive Design */
        @media (max-width: 768px) {
            .modern-datatable-container {
                margin: 10px 0;
                border-radius: 12px;
                overflow-x: auto;
            }

            #telegram thead th {
                padding: 12px 8px;
                font-size: 12px;
                white-space: nowrap;
            }

            #telegram tbody td {
                padding: 12px 8px;
                font-size: 12px;
            }

            .dataTables_wrapper .dataTables_filter input {
                width: 100%;
                max-width: 200px;
                padding: 8px 12px;
                font-size: 14px;
            }

            .dataTables_wrapper .dataTables_length select {
                padding: 6px 8px;
                font-size: 14px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
                min-width: 80px;
            }

            .btn-edit, .btn-delete {
                padding: 6px 12px;
                font-size: 11px;
                width: 100%;
                justify-content: center;
            }

            /* Mobile-specific table styling */
            .table-responsive {
                border: none;
                border-radius: 12px;
            }

            /* Ensure proper spacing on mobile */
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                margin: 8px;
                text-align: center;
            }

            /* Stack pagination buttons on mobile */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                margin: 2px;
                padding: 6px 12px;
                font-size: 12px;
            }
        }

        /* Extra small devices */
        @media (max-width: 576px) {
            .modern-datatable-container {
                margin: 5px 0;
                border-radius: 8px;
            }

            #telegram thead th {
                padding: 8px 4px;
                font-size: 11px;
            }

            #telegram tbody td {
                padding: 8px 4px;
                font-size: 11px;
            }

            .dataTables_wrapper .dataTables_filter input {
                max-width: 150px;
                padding: 6px 8px;
                font-size: 12px;
            }

            .dataTables_wrapper .dataTables_length select {
                padding: 4px 6px;
                font-size: 12px;
            }

            .btn-edit, .btn-delete {
                padding: 4px 8px;
                font-size: 10px;
            }

            /* Hide less important elements on very small screens */
            .dataTables_wrapper .dataTables_length {
                display: none;
            }
        }

        /* Responsive DataTables specific styling */
        .dtr-title {
            font-weight: 600;
            color: #374151;
            background: #f8fafc;
            padding: 4px 8px;
            border-radius: 4px;
            margin-right: 8px;
            font-size: 12px;
        }

        .dtr-data {
            color: #6b7280;
            font-size: 13px;
        }

        /* Mobile card-like layout for responsive rows */
        .dtr-bs-modal .modal-body {
            padding: 20px;
        }

        .dtr-bs-modal .dtr-title {
            display: block;
            width: 100%;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }

        .dtr-bs-modal .dtr-data {
            display: block;
            width: 100%;
            margin-bottom: 16px;
            padding: 8px 12px;
            background: #f8fafc;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .modern-datatable-container {
                background: #1f2937;
                border-color: #374151;
            }

            #telegram tbody tr {
                border-bottom-color: #374151;
            }

            #telegram tbody tr:hover {
                background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
            }

            #telegram tbody td {
                color: #d1d5db;
            }

            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input {
                background: #374151;
                border-color: #4b5563;
                color: #d1d5db;
            }

            .dataTables_wrapper .dataTables_info {
                background: #374151;
                color: #9ca3af;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                background: #374151;
                border-color: #4b5563;
                color: #d1d5db !important;
            }

            .dtr-title {
                background: #374151;
                color: #d1d5db;
            }

            .dtr-data {
                color: #9ca3af;
            }
        }

        /* Animation for table rows */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #telegram tbody tr {
            animation: fadeInUp 0.6s ease forwards;
        }

        #telegram tbody tr:nth-child(1) { animation-delay: 0.1s; }
        #telegram tbody tr:nth-child(2) { animation-delay: 0.2s; }
        #telegram tbody tr:nth-child(3) { animation-delay: 0.3s; }
        #telegram tbody tr:nth-child(4) { animation-delay: 0.4s; }
        #telegram tbody tr:nth-child(5) { animation-delay: 0.5s; }

        /* Enhanced Add Button */
        .m-content .btn.add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .m-content .btn.add:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        /* Status indicators */
        .status-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-inactive {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Empty state */
        .dataTables_empty {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
            font-style: italic;
        }

        /* Scrollbar styling */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        /* Mobile-first responsive utilities */
        .d-none-mobile {
            display: block;
        }

        .d-block-mobile {
            display: none;
        }

        @media (max-width: 768px) {
            .d-none-mobile {
                display: none;
            }
            
            .d-block-mobile {
                display: block;
            }
        }

        /* Touch-friendly mobile interactions */
        @media (max-width: 768px) {
            /* Ensure buttons are large enough for touch */
            .btn-edit, .btn-delete {
                min-height: 44px;
                min-width: 44px;
            }

            /* Improve table cell touch targets */
            #telegram tbody td {
                min-height: 44px;
                vertical-align: middle;
            }

            /* Better spacing for mobile */
            .modern-datatable-container {
                padding: 10px;
            }

            /* Optimize search input for mobile */
            .dataTables_wrapper .dataTables_filter input {
                font-size: 16px; /* Prevents zoom on iOS */
                -webkit-appearance: none;
                border-radius: 8px;
            }

            /* Mobile-friendly pagination */
            .dataTables_wrapper .dataTables_paginate {
                text-align: center;
                margin-top: 15px;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                margin: 3px;
                min-width: 44px;
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            /* Hide/show elements based on screen size */
            .dataTables_wrapper .dataTables_info {
                text-align: center;
                margin: 10px 0;
            }
        }

        /* Landscape mobile optimization */
        @media (max-width: 768px) and (orientation: landscape) {
            .modern-datatable-container {
                margin: 5px 0;
            }

            #telegram thead th,
            #telegram tbody td {
                padding: 8px 6px;
                font-size: 11px;
            }

            .action-buttons {
                flex-direction: row;
                gap: 6px;
            }

            .btn-edit, .btn-delete {
                padding: 4px 8px;
                font-size: 10px;
                min-height: 36px;
                min-width: 36px;
            }
        }

        /* High DPI mobile devices */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            #telegram thead th,
            #telegram tbody td {
                border-width: 0.5px;
            }
        }

        /* Print styles for mobile */
        @media print {
            .modern-datatable-container {
                box-shadow: none;
                border: 1px solid #000;
            }

            #telegram thead th {
                background: #f0f0f0 !important;
                color: #000 !important;
            }

            .action-buttons {
                display: none;
            }
        }

        /* Mobile-optimized class styles */
        .mobile-optimized .dataTables_wrapper {
            padding: 10px;
        }

        .mobile-optimized .dataTables_filter {
            margin-bottom: 15px;
        }

        .mobile-optimized .dataTables_length {
            margin-bottom: 10px;
        }

        /* Touch interaction styles */
        .touch-active {
            transform: scale(0.95);
            transition: transform 0.1s ease;
        }

        /* Mobile-specific table improvements */
        @media (max-width: 768px) {
            .mobile-optimized #telegram {
                font-size: 12px;
            }

            .mobile-optimized .dtr-title {
                font-size: 11px;
                padding: 3px 6px;
            }

            .mobile-optimized .dtr-data {
                font-size: 12px;
                padding: 6px 8px;
            }

            /* Improve modal display on mobile */
            .dtr-bs-modal .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .dtr-bs-modal .modal-body {
                padding: 15px;
            }
        }

        /* Accessibility improvements for mobile */
        @media (max-width: 768px) {
            /* Ensure sufficient color contrast */
            #telegram tbody td {
                color: #1f2937;
            }

            /* Improve focus indicators */
            .btn-edit:focus,
            .btn-delete:focus,
            .dataTables_filter input:focus,
            .dataTables_length select:focus {
                outline: 2px solid #667eea;
                outline-offset: 2px;
            }

            /* Better visual hierarchy */
            .dtr-title {
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                font-size: 10px;
            }
        }
    </style>
@endsection
@section('content')

    <div class="m-content">
        <button type="button" class="btn m-btn--pill btn-primary m-btn m-btn--custom add" data-toggle="modal" data-target="#m_modal_1">
            Add Telegram Account
        </button>
    </div>

    <div class="m-content">
        <!--Begin::Section-->
        <div class="modern-datatable-container">
            <div class="m-portlet__body m-portlet__body--no-padding">
                <input type="hidden" id="telegram_route" value="{{ route('datatable.gettelegram') }}">
                <div class="table-responsive">
                    <table id="telegram" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                            <tr>
                                <th>Coin</th>
                                <th>Account</th>
                                <th>Related Coins</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!--End::Section-->
    </div>


    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Telegram Account
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="coin_id" >
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label for="recipient-name" class="form-control-label">
                                    Coin: *
                                </label>
                            </div>
                            <div class="col-lg-12">
                                <input type="hidden" id="coin" style="width: 100%" class="input-xlarge" />
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="recipient-name" class="form-control-label">
                                    Related Coins:
                                </label>
                            </div>
                            <div class="col-lg-12">
                                <input type="hidden" style="width: 100%" class="coins-multiple" name="states" multiple="multiple" id="rel_coins" />
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="message-text" class="form-control-label">
                                        Telegram Account: *
                                    </label>
                                    <textarea class="form-control" id="telegram_account"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary account_action">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
    <script src="{{ url('assets/demo/default/custom/components/base/sweetalert2.js') }}" type="text/javascript" defer></script>
    <!-- DataTables JavaScript with Responsive features -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="{{ url('js/telegram.js') }}"></script>
@endsection