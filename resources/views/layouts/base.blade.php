<!DOCTYPE html>
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Crypto Trading
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{{ csrf_token() }}">
    <!--begin::Web font -->
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
    <link rel="shortcut icon" href="{{url('assets/demo/demo6/media/img/logo/favicon.ico')}}" />
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
<!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>


