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
                <div class="modern-title-main" style="display: flex; align-items: center; gap: 1em;">
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
                    <span class="modern-title-text" id="derivativesTitle">Coingecko Derivatives</span>
                </div>
            </div>
        </div>
        <!-- DataTable Section -->
        <div class="m-portlet enhanced-portlet">
            <div class="m-portlet__body mt-5 enhanced-portlet-body">
                <input type="hidden" id="coingecko_derivatives_route" value="{{ route('datatable.coingecko.derivatives') }}">
                <div class="enhanced-table-container table-responsive">
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
@endsection