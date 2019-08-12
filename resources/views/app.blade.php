<!DOCTYPE html>
<html lang="fa" direction="rtl" style="direction: rtl">
    <!-- begin::Head -->
    <head>
        @include('partials.html-head')
    </head>
    <!-- end::Head -->
    
    <!-- begin::Body -->
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-aside-right--enabled m-footer--push m-aside--offcanvas-default {{ isset($closedSideBar) && $closedSideBar ? 'm-aside-left--hide':''  }}">
    @if(config('gtm.GTM'))
        @include('partials.gtm-body')
    @endif

        <input id="js-var-userIp" class="m--hide" type="hidden" value='{{ $userIpAddress }}'>
        <input id="js-var-userId" class="m--hide" type="hidden" value='{{ optional(Auth::user())->id }}'>
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
    </body>
    <!-- end::Body -->
</html>
