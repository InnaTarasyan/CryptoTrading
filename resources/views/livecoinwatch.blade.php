@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="m-content">
        <!--Begin::Section-->
        <div class="m-portlet" >
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <input type="hidden" id="livecoin_route" value="{{ route('datatable.getlivecoin') }}">
                <div class="table-responsive">
                    <table id="livecoin" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                           <th>Code</th>
                           <th>Symbol</th>
                           <th>Rate</th>
                           <th>Volume</th>
                           <th>Cap</th>
                           <th>Rank</th>
                           <th>Markets</th>
                           <th>Total Supply</th>
                           <th>Max Supply</th>
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
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('js/livecoin.js') }}"></script>
@endsection