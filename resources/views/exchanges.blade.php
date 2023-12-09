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
                <input type="hidden" id="exchanges_route" value="{{ route('datatable.exchanges') }}">
                <div class="table-responsive">
                    <table id="exchanges" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                           <th>Name</th>
                           <th>Code</th>
                           <th>Markets</th>
                           <th>Volume</th>
                           <th>BidTotal</th>
                           <th>AskTotal</th>
                           <th>Depth</th>
                           <th>Visitors</th>
                           <th>Volume Per Visitor</th>
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
    <script src="{{ url('js/exchanges.js') }}"></script>
@endsection