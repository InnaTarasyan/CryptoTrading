@extends('layouts.base')
@section('styles')
@endsection
@section('content')

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
                                    <img src="{{ asset('img/inna_photo.jpg') }}" alt="" style="width: 100%; height: 100%;">
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
                                 At first, I would lke to introduce myself. I am Inna Tarasyan and I am a web developer from Armenia.<br/> <br/>
                                 <b>Coin Trading Project</b> is designed to combine Crypto-currency information from different major sources.
                                 It allows online tracking of all changes in key indicators of the Crypto-currency,
                                 including the Social Volume Changes in Telegram, Live Coin Watch, CoinGecko, CoinMarketCal, and more.
                            </span>
                            On the main page you can see information from the following Crypto-Currency Market Capitalization sites:

                            <div class="m-section__content">
                                <ul>
                                    <li>livecoinwatch.com</li>
                                    <li>coingecko.com</li>
                                    <li>coinmarketcal.com</li>
                                </ul>
                            </div>
                            <div class="m--space-30"></div>
                            <div class="m-section__content">
                                Information is being updated automatically every 3 hours, however,
                                you can get the latest updates when you click "Update All Data" button on any page.
                                The system update will take about one minute and provide you with up-to-date
                                Crypto-currency capitalization results. You can see detailed information about a
                                particular crypto coin when you click on a row in data tables.
                            </div>
                            <div class="m--space-30"></div>
                            <div class="m-section__content">
                                On the Crypto-coin details page you can see trading view charts, tweets about
                                corresponding coin, ideas, coin events (the list of major events in the crypto and
                                blockchain ecosystems). Crypto charts are a series of lines and candlestick patterns
                                that illustrate the historic price performance of a cryptocurrency.
                                The time span is variable. Presented information can help you predict upcoming trends
                                and changes in market conditions, helping you make better investment decisions
                                along the way. This information is simple for beginners and is also effective for
                                technical analysis experts. It is good for traders and investors.
                            </div>
                            <div class="m--space-30"></div>
                            <div class="m-section__content">
                                This site is not responsible for your financial losses, if any.
                                Though I will be happy, if this site helps you make money.
                            </div>

                            <div class="m--space-30"></div>
                            <div class="m-section__content">
                                This site can also be considered as a tutorial of Laravel framework web
                                application and other major web technologies.
                            </div>

                            <div class="m--space-30"></div>
                            <div class="m-section__content">
                                <b> The following <i>Web Technologies</i> were used to construct this site:</b>
                                <ul>
                                    <li>
                                        Information is displayed in <i>Laravel Datatables</i>, which includes table
                                        views (datagrids) with <i>pagination</i>, <i>searching</i> and
                                        <i>sorting</i> capabilities.
                                    </li>
                                    <li>TradingView Charts</li>
                                    <li>
                                        <i>Metronic</i> theme is integrated
                                    </li>
                                    <li>
                                        <i>Telegram</i> integration implemented.
                                        User can configure Telegram account and the corresponding messages
                                        will be retrieved.
                                    </li>
                                    <li>
                                        <i>Coin Events</i> are shown in the calendar.
                                    </li>
                                    <li>
                                        <i>select2.js JQuery plugin</i> is used to search for a coin.

                                    </li>
                                </ul>
                                <div class="m--space-30"></div>
                                <div class="m-section__content">
                                    On the other hand, I'm sure <i>Coin Trading Project</i> site will help
                                    traders of <i>Cryptocurrency</i> to better navigate the dynamics of market
                                    changes.
                                </div>

                                <div class="m--space-30"></div>
                                <div class="m-section__content">
                                    I would highly appreciate it if this site becomes a
                                    reference book for financial analysts. With gratitude, I will accept all your
                                    remarks, both in terms of functional purposes of this site and the software.
                                    Please contact me via the “feedback” feature found in this website,
                                    if you have any questions.
                                </div>

                                With Best Regards,
                                <br/>
                                Inna Tarasyan <br/>
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
                        <div class="m-section__content" id="contactUs">
                            <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                                @if(session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action={{route('about','#contactUs')}} method="post">
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
            var myCenter = new google.maps.LatLng(40.182344, 44.513337);
            var mapCanvas = document.getElementById("map");
            var mapOptions = {center: myCenter, zoom: 5};
            var map = new google.maps.Map(mapCanvas, mapOptions);
            var marker = new google.maps.Marker({position:myCenter});
            marker.setMap(map);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$key}}&callback=myMap"></script>
@endsection