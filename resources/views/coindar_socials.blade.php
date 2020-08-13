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
                <input type="hidden" id="coindar_socials_route" value="{{ route('datatable.getcoindarsocials') }}">
                <div class="table-responsive">
                    <table id="coindar_socials" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                            <tr>
                                <th> Coin Name </th>
                                <th> Website </th>
                                <th> Bitcointalk </th>
                                <th> Twitter </th>
                                <th> Reddit </th>
                                <th> Telegram </th>
                                <th> Facebook </th>
                                <th> Github </th>
                                <th> Explorer </th>
                                <th> Youtube </th>
                                <th> Twitter Count </th>
                                <th> Reddit Count </th>
                                <th> Telegram Count </th>
                                <th> Facebook Count </th>
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
    <script src="{{ url('js/coindar_socials.js') }}"></script>
@endsection