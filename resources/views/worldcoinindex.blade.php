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
                <input type="hidden" id="worldcoinindex_route" value="{{ route('datatable.getworldcoinindex') }}">
                <div class="table-responsive">
                    <table id="worldcoinindex" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th>Name</th>
                                <th>Price BTC</th>
                                <th>Price USD</th>
                                <th>Price CNY</th>
                                <th>Price EUR</th>
                                <th>Price GBP</th>
                                <th>Price RUR</th>
                                <th>Volume (24h)</th>
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
    <script src="{{ url('js/worldcoinindex.js') }}"></script>
@endsection