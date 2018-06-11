@extends('layouts.base')
@section('styles')
@endsection
@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="m-content">
        <!--Begin::Section-->
        <div class="m-portlet" >
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div id="map" style="width:100%;height:400px;background:yellow"></div>
            </div>
        </div>
        <!--End::Section-->
    </div>

    <div class="m-content">
        <div class="row">
            <div class="col-xl-6">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                    <i class="la la-gear"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    About
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin::Section-->
                        <div class="m-section">
                            <span class="m-section__sub">
                                 <b>My Coin Trading Project</b> connects to the following Crypto-Currency Market
                                Capitalization sites via api:
                            </span>
                            <div class="m-section__content">
                                <ul>
                                    <li>coinbin.org</li>
                                    <li>worldcoinindex.com </li>
                                    <li>coindar.org</li>
                                    <li>solume.io</li>
                                    <li>coinmarketcap.org</li>
                                </ul>
                            </div>
                            <div class="m--space-30"></div>
                            <div class="m-section__content">
                                <b>General Information </b>
                                <ul>
                                    <li>
                                        Information is displayed in <i>Laravel Datatables</i>, which includes table
                                        views (datagrids) with <i>pagination</i>, <i>searching</i> and
                                        <i>sorting</i> capabilities.
                                    </li>
                                    <li>TradingView Charts</li>
                                    <li>
                                        Site includes basic <i>login/logout/register functionality</i>. <br/>
                                    </li>
                                    <li>
                                        <i>Metronic</i> theme is integrated.
                                    </li>
                                    <li>
                                        <i>Twitter</i> integration implemented. User can configure <i>Twitter account</i> </a>
                                        and the corresponding tweets will be retrieved.
                                    </li>
                                    <li>
                                        <i>Coin Events</i> are shown in the calendar.
                                    </li>
                                    <li>
                                        <i>select2.js JQuery plugin</i> is used to search for a coin.
                                    </li>
                                    <li>
                                        Project has a <i>chat</i> implemented using <i>node.js framework</i>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Section-->
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
            <div class="col-xl-6">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Feedback
                            </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                    <!--begin::Section-->
                        <div class="m-section">
                        <span class="m-section__sub">
                            Provide Your Feedback:
                        </span>
                        <div class="m-section__content">
                            <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                                <form action="{{route('about')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="m-demo__preview">
                                        <div class="form-group m-form__group">
                                            <input  class="form-control m-input m-input--square"  name="name" placeholder="Username">
                                        </div>

                                        <div class="form-group m-form__group">
                                            <div class="input-group m-input-group">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    @
                                                </span>
                                                </div>
                                                <input type="text" class="form-control m-input" placeholder="Email" name="email">
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12">
                                                <textarea name="text" class="form-control" data-provide="markdown" rows="10" placeholder="Text"></textarea>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn m-btn--pill  btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                        <!--end::Section-->
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        function myMap() {
            var myCenter = new google.maps.LatLng(40.177200, 44.503490);
            var mapCanvas = document.getElementById("map");
            var mapOptions = {center: myCenter, zoom: 5};
            var map = new google.maps.Map(mapCanvas, mapOptions);
            var marker = new google.maps.Marker({position:myCenter});
            marker.setMap(map);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$key}}&callback=myMap"></script>
@endsection