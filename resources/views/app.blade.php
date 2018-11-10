<!DOCTYPE html>
<!--[if IE 8]>
<html lang="fa-IR" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="fa-IR" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fa-IR" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    {!! SEO::generate(true) !!}
    @section("css")
        <link rel="stylesheet" href="{{ mix('/css/mandatory_all.css') }}">
        @yield("headPageLevelPlugin")
        <link rel="stylesheet" href="{{ mix('/css/basic_all.css') }}">
        @yield("headPageLevelStyle")
    @section("headThemeLayoutStyle")
        <link rel="stylesheet" href="{{ mix('/css/head_layout_all.css') }}">
    @show
    @show

<!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon"
          href="@if(isset($wSetting->site->favicon)) {{route('image', ['category'=>'11','w'=>'150' , 'h'=>'150' ,  'filename' =>  $wSetting->site->favicon ])}} @endif"/>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    @section("gtagJs")

    @show
    <link rel="stylesheet" href="/assets/extra/acm/custom-app.css">

    <!-- Google Tag Manager -->
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
    <!--gta-track-click-->
</head>
<!-- END HEAD -->

<body
        @section("bodyClass")
        class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md"
        @show
>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PNP8RDW"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
@section("header")
    @include("partials.header1")
@show
<!-- BEGIN CONTAINER -->
<div class="page-container">
@section("sidebar")
    @include("partials.sidebar")
@show
<!-- BEGIN CONTENT -->
    <div class="page-content-wrapper" xmlns="http://www.w3.org/1999/xhtml">

        <!-- BEGIN CONTENT BODY -->
        <div
                @section("contentClass")
                class="page-content"
                @show
        >
            @yield('custom-menu')
            @if(Session::has("customer_id"))
                <div class="note bg-yellow-lemon">
                    <h3 class="block"><strong>توجه!</strong></h3>
                    <p><strong> شما در وضعیت درج سفارش
                            برای {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}} می باشید.
                            <a href="{{action("OrderController@exitAdminInsertOrder")}}" class="btn btn-lg red">بیرون
                                آمدن از وضعیت درج سفارش
                                برای {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}}</a></strong>
                    </p>
                </div>
            @endif
        <!-- BEGIN PAGE HEADER-->
            @yield("content")
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <div style="display: none">
        <input id="js-var-userIp" type="hidden" value='{{ $userIpAddress }}'>
    </div>
    <!-- END CONTENT -->
    @yield('custom-menu-footer')
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
@section("footer")
    @include("partials.footer1")
@show
<!-- END FOOTER -->
<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->

<script>
    now = new Date();
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.type = 'text/javascript';
    var script_address = 'https://cdn.yektanet.com/rg_woebegone/scripts/1603/rg.complete.js';
    script.src = script_address + '?v=' + now.getFullYear().toString() + '0'
        + now.getMonth() + '0' + now.getDate() + '0' + now.getHours();
    script.async = true;
    head.appendChild(script);
</script>

@section("js")
    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ mix('/js/core_all.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    @yield("footerPageLevelPlugin")
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    @yield("footerPageLevelScript")
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
@section("footerThemeLayoutScript")
    <script src="{{ mix('/js/layout_.js') }}" type="text/javascript"></script>
@show
<!-- END THEME LAYOUT SCRIPTS -->
<!-- BEGIN DEVELOPER SCRIPTS -->
@show
@yield("extraJS")
<!-- END DEVELOPER SCRIPTS -->
<script>
    var userIpDimensionValue = $('#js-var-userIp').val();
    dataLayer.push(
        {
            'userIp': userIpDimensionValue,
            'dimension2': userIpDimensionValue
            @if(Auth::check())
            ,
            'userId': '{{ Auth::user() ->id }}',
            'user_id': '{{ Auth::user() ->id }}'
            @endif
        });
</script>
</body>
</html>