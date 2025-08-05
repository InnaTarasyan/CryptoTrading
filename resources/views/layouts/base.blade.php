<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    
    <!-- Primary Meta Tags -->
    <title>
        @yield('title', 'Crypto Trading - Live Cryptocurrency Tracking & Analysis Platform')
    </title>
    <meta name="title" content="@yield('meta_title', 'Crypto Trading - Live Cryptocurrency Tracking & Analysis Platform')">
    <meta name="description" content="@yield('meta_description', 'Track live cryptocurrency prices, social volume changes on Reddit and Twitter, and comprehensive crypto market analysis. Real-time data from CoinMarketCap, TradingView, and more.')">
    <meta name="keywords" content="@yield('meta_keywords', 'cryptocurrency, bitcoin, ethereum, crypto trading, live crypto prices, cryptocurrency tracking, crypto market analysis, bitcoin price, ethereum price, altcoins, crypto portfolio, trading view, coinmarketcap, crypto news, blockchain, digital currency, crypto investment, crypto signals, crypto charts, crypto trading platform')">
    <meta name="author" content="Inna Tarasyan">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    <meta name="rating" content="general">
    <meta name="distribution" content="global">
    <meta name="coverage" content="worldwide">
    <meta name="target" content="all">
    <meta name="HandheldFriendly" content="true">
    <meta name="MobileOptimized" content="width">
    <meta name="format-detection" content="telephone=no">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'Crypto Trading - Live Cryptocurrency Tracking & Analysis Platform')">
    <meta property="og:description" content="@yield('og_description', 'Track live cryptocurrency prices, social volume changes on Reddit and Twitter, and comprehensive crypto market analysis. Real-time data from CoinMarketCap, TradingView, and more.')">
    <meta property="og:image" content="@yield('og_image', url('assets/demo/demo7/media/img/logo/logo.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Crypto Trading Platform Logo">
    <meta property="og:site_name" content="Crypto Trading">
    <meta property="og:locale" content="en_US">
    <meta property="og:locale:alternate" content="ru_RU">
    <meta property="og:locale:alternate" content="hy_AM">
    <meta property="og:locale:alternate" content="fi_FI">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('twitter_title', 'Crypto Trading - Live Cryptocurrency Tracking & Analysis Platform')">
    <meta property="twitter:description" content="@yield('twitter_description', 'Track live cryptocurrency prices, social volume changes on Reddit and Twitter, and comprehensive crypto market analysis. Real-time data from CoinMarketCap, TradingView, and more.')">
    <meta property="twitter:image" content="@yield('twitter_image', url('assets/demo/demo7/media/img/logo/logo.png'))">
    <meta property="twitter:site" content="@cryptotrading">
    <meta property="twitter:creator" content="@cryptotrading">
    
    <!-- Additional SEO Meta Tags -->
    <meta name="application-name" content="Crypto Trading">
    <meta name="apple-mobile-web-app-title" content="Crypto Trading">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="msapplication-TileColor" content="#667eea">
    <meta name="msapplication-TileImage" content="{{ url('assets/demo/demo7/media/img/logo/favicon.ico') }}">
    <meta name="msapplication-config" content="{{ url('browserconfig.xml') }}">
    <meta name="theme-color" content="#667eea">
    <meta name="color-scheme" content="light dark">
    
    <!-- Viewport and Compatibility -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="_token" content="{{ csrf_token() }}">
    
    <!-- DNS Prefetch and Preconnect for Performance -->
    <link rel="dns-prefetch" href="//ajax.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Favicon and App Icons -->
    <link rel="shortcut icon" href="{{ url('assets/demo/demo7/media/img/logo/favicon.ico') }}" />
    <link rel="icon" type="image/x-icon" href="{{ url('assets/demo/default/media/img/logo/favicon.ico') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('assets/demo/demo7/media/img/logo/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('assets/demo/demo7/media/img/logo/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('assets/demo/demo7/media/img/logo/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ url('site.webmanifest') }}">
    
    <!-- Structured Data / JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Crypto Trading",
        "url": "{{ url('/') }}",
        "description": "Track live cryptocurrency prices, social volume changes on Reddit and Twitter, and comprehensive crypto market analysis.",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Crypto Trading",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ url('assets/demo/demo7/media/img/logo/logo.png') }}"
            }
        },
        "sameAs": [
            "https://twitter.com/cryptotrading",
            "https://t.me/cryptotrading"
        ]
    }
    </script>
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Crypto Trading",
        "url": "{{ url('/') }}",
        "logo": "{{ url('assets/demo/demo7/media/img/logo/logo.png') }}",
        "description": "Live cryptocurrency tracking and analysis platform",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "US"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "customer service",
            "availableLanguage": ["English", "Russian", "Armenian", "Finnish"]
        }
    }
    </script>
    
    <!-- begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <link href="{{url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors -->
    <link href="{{url('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/demo/demo7/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->
    <link href="{{url('css/language-switcher.css')}}" rel="stylesheet" type="text/css" />
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="{{url('assets/vendors/base/vendors.bundle.css')}}" as="style">
    <link rel="preload" href="{{url('assets/demo/demo7/base/style.bundle.css')}}" as="style">
    <link rel="preload" href="{{url('assets/vendors/base/vendors.bundle.js')}}" as="script">
    
    @yield('styles')
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--fixed m-aside-left--offcanvas m-aside-left--minimize m-brand--minimize m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    @include('layouts.header')
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        @include('layouts.menu')
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            @include('layouts.subheader')
            @yield('content')
        </div>
    </div>
    <!-- end:: Body -->
    @include('layouts.footer')
</div>
<!-- end:: Page -->
@include('layouts.quick_sidebar')
<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->
{{--@include('layouts.quick_nav')--}}
<!--begin::Base Scripts -->
    <script src="{{ url('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
    <script src=" {{  url('assets/demo/demo7/base/scripts.bundle.js')}}" type="text/javascript"></script>
    <!--end::Base Scripts -->
    <!--begin::Page Vendors -->
    <script src="{{  url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Snippets -->
    <script src="{{ url('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
    @yield('scripts')
    <script type="text/javascript">
        $(function(){

            $('.m-subheader__breadcrumbs a, .m-menu__subnav a'). each(function(){
                var current_page_URL = location.href;

                if ($(this).attr("href") !== "#") {
                    var target_URL = $(this).prop("href");
                    if (target_URL == current_page_URL) {
                        $(this).find('span:first').css('color', '#22b9ff');
                        $(this).find('i:first').css('color','#22b9ff');

                    }
                }
            });


        });
    </script>
    <script src="{{ url('js/base.js') }}"></script>
    <script src="{{ url('js/mobile-menu.js') }}"></script>
<!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>


