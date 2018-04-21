@extends('layouts.base')
@section('styles')
    <link href="{{url('css/coindetails.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="m-content">
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
                                    General Information
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
                        <!--begin::Section-->
                        <div class="m-section">
                            <div class="m-section__content">
                                <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                                    <div class="m-demo__preview">
                                        <div class="m-stack m-stack--ver m-stack--desktop m-stack--demo">
                                            <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                Price
                                                @if(isset($coinmarketcap))
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            BTC
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$coinmarketcap->price_btc}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            USD
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$coinmarketcap->price_usd}}
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(isset($worldcoinindex))
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            CNY
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$worldcoinindex->Price_cny}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            EUR
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{ number_format($worldcoinindex->Price_eur, 2, '.', ',')}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            GBP
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{ number_format($worldcoinindex->Price_gbp, 2, '.', ',')}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            RUR
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{ number_format($worldcoinindex->Price_rur, 2, '.', ',')}}
                                                        </div>
                                                    </div>
                                                 @endif
                                            </div>
                                            @if(isset($coinmarketcap))
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    Percent Changes
                                                    @if(isset($coinmarketcap->percent_change_1h))
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                1h
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{$coinmarketcap->percent_change_1h}} %
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(isset($coinmarketcap->percent_change_24h))
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                24h
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{$coinmarketcap->percent_change_24h}} %
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(isset($coinmarketcap->percent_change_7d))
                                                        <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                7d
                                                            </div>
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                {{$coinmarketcap->percent_change_7d}} %
                                                            </div>
                                                        </div>
                                                     @endif
                                                </div>
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    Trade volume (24 h)
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                           USD
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{ number_format($coinmarketcap->{'24h_volume_usd'}) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    General information
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
                                                    Solume.io Data
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            24h
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$solume->change_24h}} %
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Reddit (24h)
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$solume->reddit_change_24h}} %
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Reddit Vol.(24h)
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$solume->reddit_volume_24h}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Sentiment (24h)
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$solume->sentiment_24h}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Sentiment (24h)
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$solume->sentiment_change_24h}} %
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Twitter (24h)
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$solume->twitter_change_24h}} %
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Twitter Vol. (24h)
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$solume->twitter_volume_24h }}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            Vol. (24h)
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$solume->volume_24h}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if(isset($coinbin))
                                                <div class="m-stack__item m-stack__item--center m-stack__item--top">
                                                    Coinbin.org data
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            BTC
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$coinbin->btc}}
                                                        </div>
                                                    </div>
                                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            USD
                                                        </div>
                                                        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                            {{$coinbin->usd}}
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
           <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
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

           <div class="col-xl-6 col-lg-12">
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
                                                        {{\Carbon\Carbon::parse($tweet['created_at'])->format('y, M, d, H:i:s')}}
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