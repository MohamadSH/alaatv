<!DOCTYPE html><!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang = "en">
<!-- begin::Head -->
<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name = "csrf-token" content = "{{ csrf_token() }}">

    <!-- begin::seo meta tags -->
{!! SEO::generate(true) !!}
<!-- end:: seo meta tags -->


    <!--begin::Web font -->
    <script src = "https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    <link href = "{{ mix('/css/all.css') }}" rel = "stylesheet" type = "text/css"/>
    <!--end::Global Theme Styles -->
    <style>
        .m-login__container {
            background: #ffffff40;
            padding: 10px;
        }
    </style>

    <link rel = "shortcut icon" href = "@if(isset($wSetting->site->favicon)) {{route('image', ['category'=>'11','w'=>'150' , 'h'=>'150' ,  'filename' =>  $wSetting->site->favicon ])}} @endif"/>
    <!--begin: csrf token -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <!--end: csrf token -->
    <!--begin Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PNP8RDW');
    </script>
    <!-- End Google Tag Manager -->

</head>
<!-- end::Head -->


<!-- begin::Body -->
<body class = "m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">


<!-- begin:: Page -->
<div class = "m-grid m-grid--hor m-grid--root m-page">


    <div class = "m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id = "m_login" style = "background-image: url({{ asset('/assets/app/media/img//bg/bg-1.jpg') }});">
        <div class = "m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class = "m-login__container">

                <div class = "m-login__signin">
                    <div class = "m-login__head">
                        <h3 class = "m-login__title">تکمیل ثبت نام</h3>
                    </div>
                    @include("user.form", ["formID"=>1 , "noteFontColor"=>"m--font-brand" , "hasHomeButton"=>1])
                </div>
            </div>
        </div>
    </div>


</div>
<!-- end:: Page -->

<!--begin::Global Theme Bundle -->
<script src = "{{ mix('/js/all.js') }}" type = "text/javascript"></script>
<!--end::Global Theme Bundle -->
<script>
    $(function () {
        /**
         * Set token for ajax request
         */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
            }
        });
    });
</script>

</body>
<!-- end::Body -->
</html>


{{--@extends('app')--}}

{{--@section("headPageLevelStyle")--}}{{--<link href="/assets/pages/css/login-4-rtl.min.css" rel="stylesheet" type="text/css"/>--}}{{--@endsection--}}

{{--@section("headThemeLayoutStyle")--}}

{{--@endsection--}}

{{--@section("header")--}}{{--@endsection--}}{{--@section("sidebar")--}}{{--@endsection--}}{{--@section("themePanel")--}}{{--@endsection--}}{{--@section("pageBar")--}}{{--@endsection--}}{{--@section('content')--}}


{{--<div class="m-portlet m-portlet--tab">--}}{{--<div class="m-portlet__head">--}}{{--<div class="m-portlet__head-caption">--}}{{--<div class="m-portlet__head-title">--}}                        {{--<span class="m-portlet__head-icon m--hide">--}}                        {{--<i class="fa fa-cog"></i>--}}                        {{--</span>--}}{{--<h3 class="m-portlet__head-text">--}}{{--تکمیل ثبت نام--}}{{--</h3>--}}{{--</div>--}}{{--</div>--}}{{--</div>--}}

{{--@include("user.form", ["formID"=>1 , "noteFontColor"=>"m--font-brand" , "hasHomeButton"=>1])--}}

{{--</div>--}}


{{--@endsection--}}

{{--@section("footer")--}}

{{--@endsection--}}

{{--@section("footerPageLevelPlugin")--}}{{--<script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>--}}{{--<script src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>--}}{{--<script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>--}}{{--<script src="/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>--}}{{--<script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>--}}{{--<script src="/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>--}}{{--@endsection--}}

{{--@section("footerPageLevelScript")--}}{{--<script src="/assets/pages/scripts/login-4.min.js" type="text/javascript"></script>--}}{{--<script src="/assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>--}}{{--@endsection--}}
