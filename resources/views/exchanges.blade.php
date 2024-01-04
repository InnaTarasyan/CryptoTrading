@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="m-content">

        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item">
                <a href="/livecoinwatch" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Live Coin Watch data
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/exchangesindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Exchanges data
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/fiatsindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Fiats
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/livecoinplatformsindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Platforms
                        </span>
                </a>
            </li>
        </ul>

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
    <script src="{{ url('js/exchanges.js') }}"></script>
@endsection