@extends('layouts.base')
@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="{{url('css/datatables.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="m-content">

        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item">
                <a href="/coingeckomarketsindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                           Markets
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/coingeckoexchangesindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                           Exchanges
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/coingeckotrendingsindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                           Trendings
                        </span>
                </a>
            </li>

            <li class="m-nav__item">
                <a href="/coingeckoexchangeratesindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                           Exchange Rates
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/coingeckonftsindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Nfts
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/coingeckoderivativesindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Derivatives
                        </span>
                </a>
            </li>
            <li class="m-nav__item">
                <a href="/coingeckoderivativesexchangesindex" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Derivatives Exchanges
                        </span>
                </a>
            </li>
        </ul>

        <!--Begin::Section-->
        <div class="m-portlet" >
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <input type="hidden" id="coingecko_nfts_route" value="{{ route('datatable.coingecko.nfts') }}">
                <div class="table-responsive">
                    <table id="coingecko_nfts" class="table table-hover table-condensed table-striped" style="width:100%; padding-top:1%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Asset platform id</th>
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
    <script src="{{ url('js/coingecko/nfts.js') }}"></script>
@endsection