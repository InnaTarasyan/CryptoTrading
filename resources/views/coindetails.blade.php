@extends('layouts.base')
@section('styles')
    <link href="{{url('css/coindetails.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="m-content" >
        <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_4">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                   <i class="flaticon-coins"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    {{ $coin }} {{ $symbol }}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="" data-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" title="" data-original-title="Collapse">
                                        <i class="la la-angle-down"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body" style="padding: 0rem;">
                        <!--begin::Section-->
                        <div class="m-section">
                            <div class="m-section__content">
                                <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                                    <div class="m-demo__preview">
                                        <div class="m-stack m-stack--ver m-stack--desktop m-stack--demo">
                                            @if(isset($coinmarketcap) or isset($worldcoinindex))
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    <i>
                                                        <u>Price</u>
                                                    </i>
                                                    @if(isset($coinmarketcap))
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                <b> BTC </b>
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{$coinmarketcap->price_btc}}
                                                            </div>
                                                        </div>
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                <b> USD </b>
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{$coinmarketcap->price_usd}}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(isset($worldcoinindex))
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                <b> CNY </b>
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{$worldcoinindex->Price_cny}}
                                                            </div>
                                                        </div>
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                <b> EUR </b>
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{ number_format($worldcoinindex->Price_eur, 2, '.', ',')}}
                                                            </div>
                                                        </div>
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                <b> GBP </b>
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{ number_format($worldcoinindex->Price_gbp, 2, '.', ',')}}
                                                            </div>
                                                        </div>
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                <b> RUR </b>
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{ number_format($worldcoinindex->Price_rur, 2, '.', ',')}}
                                                            </div>
                                                        </div>
                                                     @endif
                                                </div>
                                            @endif
                                            @if(isset($coinmarketcap))
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    <i>
                                                        <u>Percent Changes</u>
                                                    </i>
                                                    @if(isset($coinmarketcap->percent_change_1h))
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                1h
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$coinmarketcap->percent_change_1h < 0 ? "m--font-danger" : "m--font-success"}} ">
                                                                {{$coinmarketcap->percent_change_1h}} %
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(isset($coinmarketcap->percent_change_24h))
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                24h
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$coinmarketcap->percent_change_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                                {{$coinmarketcap->percent_change_24h}} %
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(isset($coinmarketcap->percent_change_7d))
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                7d
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$coinmarketcap->percent_change_7d < 0 ? "m--font-danger" : "m--font-success"}}">
                                                                {{$coinmarketcap->percent_change_7d}} %
                                                            </div>
                                                        </div>
                                                     @endif
                                                </div>
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    <i>
                                                        <u>Trade volume (24 h)</u>
                                                    </i>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            <b> USD </b>
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{ number_format($coinmarketcap->{'24h_volume_usd'}) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    <i>
                                                        <u>General information</u>
                                                    </i>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Max Supply
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{ number_format($coinmarketcap->max_supply) }}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Total Supply
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{ number_format($coinmarketcap->total_supply) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isset($solume))
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    <i>
                                                        <u>Solume.io Data (24h)</u>
                                                    </i>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Change
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$solume->change_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                            {{$solume->change_24h}} %
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Reddit
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$solume->reddit_change_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                            {{$solume->reddit_change_24h}} %
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Reddit Vol.
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$solume->reddit_volume_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                            {{$solume->reddit_volume_24h}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Sentiment
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$solume->sentiment_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                            {{$solume->sentiment_24h}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Sentiment Change
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle  {{$solume->sentiment_change_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                            {{$solume->sentiment_change_24h}} %
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Twitter
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$solume->twitter_change_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                            {{$solume->twitter_change_24h}} %
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Twitter Vol.
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$solume->twitter_volume_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                            {{$solume->twitter_volume_24h }}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Vol.
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle {{$solume->volume_24h < 0 ? "m--font-danger" : "m--font-success"}}">
                                                            {{$solume->volume_24h}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Section-->
                    </div>
                </div>
            </div>
        </div>
        <!--End::Section-->
    </div>


    <div class="m-content">
    <!--Begin::Section-->
       <div class="row">
           <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12">
               <!--begin::Portlet-->
               <div class="m-portlet" id="m_portlet_calendar">
                   <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_1">
                       <div class="m-portlet__head">
                           <div class="m-portlet__head-caption">
                               <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon">
                                        <i class="flaticon-map-location"></i>
                                    </span>
                                   <h3 class="m-portlet__head-text">
                                       Coin Events
                                   </h3>
                               </div>
                           </div>
                           <div class="m-portlet__head-tools">
                               <ul class="m-portlet__nav">
                                   <li class="m-portlet__nav-item">
                                       <a href="" data-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" title="" data-original-title="Collapse">
                                           <i class="la la-angle-down"></i>
                                       </a>
                                   </li>
                               </ul>
                           </div>
                       </div>
                       <div class="m-portlet__body">
                       </div>
                   </div>
               </div>
               <!--end::Portlet-->
           </div>

           <div class="col-xl-8 col-lg-12">
               <!--Begin::Portlet-->
               <div class="m-portlet ">
                   <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_2">
                       <div class="m-portlet__head">
                           <div class="m-portlet__head-caption">
                               <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon">
                                        <i class="fa fa-bar-chart-o"></i>
                                    </span>
                                   <h3 class="m-portlet__head-text">
                                       Trading View Chart
                                   </h3>
                               </div>
                           </div>
                           <div class="m-portlet__head-tools">
                               <ul class="m-portlet__nav">
                                   <li class="m-portlet__nav-item">
                                       <a href="" data-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" title="" data-original-title="Collapse">
                                           <i class="la la-angle-down"></i>
                                       </a>
                                   </li>
                                   <li class="m-portlet__nav-item">
                                       <a href="#" data-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" title="" data-original-title="Fullscreen">
                                           <i class="la la-expand"></i>
                                       </a>
                                   </li>
                               </ul>
                           </div>
                       </div>
                       <div class="m-portlet__body" style="padding: 0rem;">
                           @if(!isset($tradingPair))
                               <div style="padding-top: 10px; padding-bottom: 10px;">
                                   Please add a Trading Pair <a href="/tradingPairs">Here</a>:
                               </div>
                               <script type="text/javascript">
                                   var symbol = '';
                               </script>
                           @else
                               <script type="text/javascript">
                                   var symbol = '{{$tradingPair}}';
                               </script>
                           @endif
                           <!-- TradingView Widget BEGIN -->
                           <div class="tradingview-widget-container">
                               <div id="tradingview_ffbfc" ></div>
                               <div class="tradingview-widget-copyright">
                                   <a href="https://www.tradingview.com/symbols/BITFINEX-BTCUSD/" rel="noopener" target="_blank"><span class="blue-text">BTCUSD chart</span></a> by TradingView</div>
                               <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                               <script type="text/javascript">
                                   new TradingView.widget(
                                       {
                                           "width": '100%',
                                           "height": '100%',
                                           "symbol": symbol ? symbol: "BITFINEX:BTCUSD",
                                           "interval": "D",
                                           "timezone": "Etc/UTC",
                                           "theme": "Light",
                                           "style": "1",
                                           "locale": "en",
                                           "toolbar_bg": "#f1f3f6",
                                           "enable_publishing": true,
                                           "allow_symbol_change": true,
                                           "container_id": "tradingview_ffbfc"
                                       }
                                   );
                               </script>
                           </div>
                           <!-- TradingView Widget END -->
                       </div>
                   </div>
               </div>
               <!--end::Portlet-->
           </div>
       </div>
    <!--End::Section-->
    </div>


    <div class="m-content">
        <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-4 col-lg-12">
                <!--Begin::Portlet-->
                <div class="m-portlet ">
                    <div class="m-portlet m-portlet--accent m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_2">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon">
                                        <i class="socicon-twitter"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        Tweets
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a href="" data-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" title="" data-original-title="Collapse">
                                            <i class="la la-angle-down"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            @if(isset($tweets))
                                <div class="m-scrollable mCustomScrollbar _mCS_5 mCS-autoHide" data-scrollbar-shown="true" data-scrollable="true" data-max-height="380" style="overflow: visible; height: 380px; max-height: 380px; position: relative;">
                                    <!--Begin::Timeline 2 -->
                                    <div class="m-timeline-2">
                                        @foreach($tweets as $tweet)
                                            <div class="m-timeline-2__items  m--padding-top-25 m--padding-bottom-30">
                                                <div class="m-timeline-2__item">
                                                    <span class="m-timeline-2__item-time">
                                                        {{\Carbon\Carbon::parse($tweet['created_at'])->format('d-M-Y, H:i:s')}}
                                                    </span>
                                                    <div class="m-timeline-2__item-cricle">
                                                        <i class="fa fa-genderless m--font-danger"></i>
                                                    </div>
                                                    <div class="m-timeline-2__item-text  m--padding-top-5">
                                                        {!! $tweet['text'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!--End::Timeline 2 -->
                                </div>
                            @else
                                <i>Twitter Account</i> has not been added.
                                Please configure it <a href="{{ url('twitter') }}">here...</a>
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
            <div class="col-xl-8 col-lg-12" >
                @if(!isset($tradingPair))
                <div style="padding-top: 10px; padding-bottom: 10px;">
                    Please add a Trading Pair <a href="/tradingPairs">Here</a>:
                </div>
                @else
                <!-- TradingView Widget BEGIN -->
                <div id="tv-chatwidget" ></div>
                <script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
                <script type="text/javascript" >
                    new TradingView.IdeasStreamWidget({
                        "container_id": "tv-ideas-stream-9ecf7",
                        "startingCount": 1,
                        "width": '100%',
                        "height": '100%',
                        "mode": "integrate",
                        "bgColor": "#f2f5f8",
                        "headerColor": "#4BC2E9",
                        "borderColor": "#dce1e6",
                        "symbol": symbol ? symbol: "BITFINEX:BTCUSD",
                    });
                </script>
                <!-- TradingView Widget END -->
                @endif
            </div>
        </div>
        <!--End::Section-->
    </div>

@endsection
@section('scripts')
    <script>
        var events = {!! $events !!};
    </script>
    <script src="{{ url('js/details.js') }}"></script>
@endsection