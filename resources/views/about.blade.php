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
        <div class="row">
            <div class="col-xl-3">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide">
                                About
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <img src="{{ asset('img/inna.jpg') }}" alt="" style="width: 100%; height: 100%;">
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                                <span class="m-card-profile__name">
                                    Inna Tarasyan
                                </span>
                                <a href="" class="m-card-profile__email m-link">
                                    innatarasyanmail@gmail.com
                                </a>
                            </div>
                        </div>
                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                            <li class="m-nav__separator m-nav__separator--fit"></li>
                            <li class="m-nav__section m--hide">
                                <span class="m-nav__section-text">
                                    Section
                                </span>
                            </li>
                        </ul>
                        <div class="m-portlet__body-separator"></div>

                    </div>
                </div>
            </div>
            <div class="col-xl-9">
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
                                <i>Dear All,</i><br/>
                                 At first I want to introduce myself. I am Inna Tarasyan, I live in Armenia, in Yerevan, and I am web developer. <br/> <br/>
                                 <b>My Coin Trading Project</b> allows online tracking of the changes in key indicators of the Crypto-currency,
                                including the Social Volume Changes in the Reddit and Twitter, etc.
                                Site connects to the following Crypto-Currency Market
                                Capitalization sites via api:
                            </span>
                            <div class="m-section__content">
                                <ul>
                                    <li>worldcoinindex.com </li>
                                    <li>coindar.org</li>
                                    <li>solume.io</li>
                                    <li>coinmarketcap.org</li>
                                </ul>
                            </div>
                            <div class="m--space-30"></div>
                            <div class="m-section__content">
                                <b>These are the <i>Web Technologies</i> used for constructing the site: </b>
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
                                        Gravatar Service Integrated
                                    </li>
                                    <li>
                                        Laravel Email Integrated
                                    </li>
                                    <li>
                                        Project has a <i>chat</i> implemented using <i>node.js framework</i>
                                    </li>
                                </ul>
                                <br/>
                                On the other hand, I'm sure <b>My Coin Trading Project</b> site will help traders of  Cryptocurrency to better navigate the dynamics of market changes. <br/> <br/>
                                I will accept with gratitude all your remarks both in terms of  functional purpose of site and the software. Please write :) Welcome ! <br/>  <br/>
                                With Best Regards <br/>
                                Inna Tarasyan
                            </div>
                        </div>
                        <!--end::Section-->
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="row">
            <div class="col-xl-3">
                <!--Begin::Section-->
                <div class="m-portlet" >
                    <div class="m-portlet__body  m-portlet__body--no-padding">
                        <div id="map" style="width:100%;height:50em;background:yellow"></div>
                    </div>
                </div>
                <!--End::Section-->
            </div>
            <div class="col-xl-9">
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