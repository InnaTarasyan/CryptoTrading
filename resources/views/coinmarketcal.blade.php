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
@endsection

@section('content')
    <div class="m-content">
        <!-- Begin::Section -->
        <div class="m-portlet custom-modern">
            <div class="m-portlet__head custom-modern">
                <div class="m-portlet__head-title custom-modern">
                    <span class="icon">&#128202;</span>
                    <span>CoinMarketCal Events</span>
                </div>
                <div class="m-portlet__head-desc custom-modern">
                    <!-- Optional description -->
                </div>
                <button id="theme-toggle" class="modern-update-btn" style="margin-left:auto;">
                    <span id="theme-toggle-icon">🌙</span>
                    <span id="theme-toggle-text">Dark Mode</span>
                </button>
            </div>
            <div class="m-portlet__body">
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
                                    <span style="font-weight:900;">Fullname</span>
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