<!DOCTYPE html>
<html lang="fa" direction="rtl" style="direction: rtl">
    <!-- begin::Head -->
    <head>
        @include('partials.html-head')
        @yield('page-head')
    </head>
    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-aside-right--enabled m-footer--push m-aside--offcanvas-default {{ isset($closedSideBar) && $closedSideBar ? 'm-aside-left--hide':''  }}">
    @if(config('gtm.GTM'))
        @include('partials.gtm-body')
    @endif

        <input id="js-var-userIp" class="m--hide" type="hidden" value='{{ $userIpAddress }}'>
        <input id="js-var-userId" class="m--hide" type="hidden" value='{{ optional(Auth::user())->id }}'>
        <input id="js-var-loginActionUrl" class="m--hide" type="hidden" value='{{ action("Auth\LoginController@login") }}'>
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
        @section('body')
            <!-- BEGIN: Header -->
            @section("header")
                @include("partials.header1")
            @show
            <!-- END: Header -->
            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                @section("sidebar")
                    @include("partials.sidebar")
                @show

                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-content">
                        @yield('pageBar')
                        @yield('content')
                    </div>
                </div>

                @section('right-aside')

                @show
            </div>
            <!-- end:: Body -->
            @section("footer")
                @include("partials.footer1")
            @show
        @show
        </div>
        <!-- end:: Page -->

        @section('quick-sidebar')
            @include('partials.quickSidebar')
        @show
        <!-- begin::Scroll Top -->
        <div id="m_scroll_top" class="m-scroll-top">
            <i class="fa fa-angle-up"></i>
        </div>
        <!-- end::Scroll Top -->





        <!--begin::Global Theme Bundle -->
        <script src="{{ mix('/js/all.js') }}" type="text/javascript"></script>
        <!--end::Global Theme Bundle -->
        @yield('data-layer')

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

        @yield('page-js')





{{--    <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->--}}

{{--    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->--}}
{{--    <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-app.js"></script>--}}

{{--    <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->--}}
{{--    <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-analytics.js"></script>--}}

{{--    <!-- Add Firebase products that you want to use -->--}}
{{--    <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-auth.js"></script>--}}
{{--    <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-firestore.js"></script>--}}
{{--    <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-messaging.js"></script>--}}
{{--    <script src="{{ asset('/firebase-messaging-sw.js') }}" type="text/javascript"></script>--}}




    </body>
    <!-- end::Body -->
</html>
