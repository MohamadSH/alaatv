<!DOCTYPE html>
<!--[if IE 8]> <html lang="fa-IR" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="fa-IR" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fa-IR" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        @section("metadata")
            @include("partials.headMeta")
        @show
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        {{--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />--}}

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
        <link rel="shortcut icon" href="@if(isset($wSetting->site->favicon)) {{route('image', ['category'=>'11','w'=>'150' , 'h'=>'150' ,  'filename' =>  $wSetting->site->favicon ])}} @endif" />

        <!-- Document Title============================================= -->
        {{--@section('title')--}}
            {{--<title>@if(isset($wSetting->site->titleBar)) {{$wSetting->site->titleBar}} @else "نام سایت" @endif</title>--}}
        {{--@show--}}
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', '{{ Config('constants.google.analytics') }}', 'auto');
            ga('send', 'pageview');
            @if(Auth::check())
                ga('set', 'userId', '{{ Auth::user() ->id }}' ); // Set the user ID using signed-in user_id.
            @endif
        </script>
        <style >
            .margin-bottom-20{
                margin-bottom: 20px;
            }
            .margin-bottom-25{
                margin-bottom: 25px;
            }
            .margin-top-0{
                margin-top:  0px !important;
            }
            .margin-right-0{
                margin-right : 0px !important;
            }
            .dashboard-consultation-scroll-notEmpty{
                height: 331px;
            }
            .dashboard-consultation-scroll-empty{
                height: 165px ;
            }
            .dashboard-special-offer{
                width: 100%;
                max-height: 340px;
            }
            .no-padding{
                padding: 0px 0px 0px 0px ;
            }
            .no-margin{
                margin: 0px 0px 0px 0px ;
            }
            .product-potfolio-free{
                padding-bottom: 23px;
                font-size: inherit
            }
            .product-potfolio-no-cost{
                padding-bottom: 23px;
                font-size: inherit
            }
            .product-potfolio-no-discount{
                padding-bottom: 23px;
                font-size: inherit
            }
            .product-potfolio-real-cost{
                text-decoration: line-through;
                font-size: inherit
            }
        </style>
    </head>
<!-- END HEAD -->

    <body
            @section("bodyClass")
                class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md"
            @show
    >
        @section("header")
           @include("partials.header1")
        @show
        <!-- BEGIN CONTAINER -->
        <div class="page-container" >
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
                        @if(Session::has("customer_id"))
                            <div class="note bg-yellow-lemon">
                                <h3 class="block"><strong>توجه!</strong></h3>
                                <p><strong> شما در وضعیت درج سفارش برای {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}} می باشید.
                                <a href="{{action("OrderController@exitAdminInsertOrder")}}" class="btn btn-lg red">بیرون آمدن از وضعیت درج سفارش برای {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}}</a></strong></p>
                            </div>
                         @endif
                    <!-- BEGIN PAGE HEADER-->
                    {{--@section("themePanel")--}}
                        {{--@include("partials.themePanel")--}}
                    {{--@show--}}
                        {{--@if(strcmp(url()->current() , action("Auth\LoginController@showLoginForm")) != 0 &&--}}
                         {{--strcmp(url()->current() , action("HomeController@error403")) != 0 &&--}}
                         {{--strcmp(url()->current() , action("HomeController@error404")) != 0 &&--}}
                         {{--isset($pageName) &&--}}
                         {{--strcmp($pageName , "productLiveView") != 0 &&--}}
                         {{--strcmp($pageName , "admin") != 0)--}}
                            {{--@if(\App\Product::where('id',65)->first()->isHappening() === true || \App\Product::where('id',65)->first()->isHappening()< config::get("constants.HOURS_AFTER_HAMAYESH"))--}}
                                {{--<div class="row" >--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<a href="{{action("ProductController@showLiveView" , 65)}}">--}}
                                            {{--<div class="portlet light ">--}}
                                                {{--<div class="portlet-body">--}}
                                                        {{--<div id="pulsate-regular1" style="padding:5px;"><h4 class="text-center bold" >@if(\App\Product::where('id',65)->first()->isHappening() === true) برای پخش آنلاین همایش ریاضی تجربی کلیک کنید @else برای دانلود همایش ریاضی تجربی کلیک کنید @endif</h4></div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--@elseif(\App\Product::where('id',65)->first()->isHappening()<0)--}}
                                        {{--<div class="col-md-12 coming-soon-countdown" style="background: #67809f">--}}
                                            {{--<h3 class="text-center bg-font-dark bold">زمان باقی مانده تا آپلود همایش ریاضی تجربی</h3>--}}
                                                {{--<div class="col-md-4"></div>--}}
                                                {{--<div class="col-md-8">--}}
                                                {{--<div id="defaultCountdown" class="font-red"> </div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                {{--<script type="application/javascript">--}}
                                    {{--var ComingSoon = function () {--}}
                                        {{--return {--}}
                                            {{--//main function to initiate the module--}}
                                            {{--init: function () {--}}
                                                {{--var austDay = new Date("2017-05-12T07:30:00Z");--}}
                                                {{--$('#defaultCountdown').countdown({until: austDay});--}}
                                            {{--}--}}

                                        {{--};--}}

                                    {{--}();--}}
                                    {{--jQuery(document).ready(function() {--}}
                                        {{--ComingSoon.init();--}}
                                    {{--});--}}
                                {{--</script>--}}
                             {{--@endif--}}

                    @section("pageBar")
                        @include("partials.pageBar")
                    @show
                    <!-- END PAGE HEADER-->
                            {{--ADMIN NOTIFICATION--}}
                    {{--@if(isset($pageName) && strcmp($pageName , "admin") == 0 )--}}
                                {{--<div class="note note-warning">--}}
                                {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
                                {{--<strong class="font-red">ادمین محترم با توجه به تغییرات صورت گرفته در پنل ادمین ،لطفا کش مرورگر خود را خالی کنید!</strong>--}}
                                {{--</div>--}}
                    {{--@endif--}}
                    @yield("content")
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
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

</body>

</html>