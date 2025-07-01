@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
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
                <input type="hidden" id="livecoin_fiats_route" value="{{ route('datatable.livecoin.fiats') }}">
                <div class="table-responsive">
                    <table id="livecoin_fiats" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Countries</th>
                            <th>Flag</th>
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
    <script src="{{ url('js/livecoin/fiats.js') }}"></script>
@endsection