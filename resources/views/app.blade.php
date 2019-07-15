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
                    {{--<!-- BEGIN: Right Aside -->
                        <div class = "m-grid__item m-aside-right">
        
                            <div>
                                <h6 class="m-badge m-badge--warning m-badge--wide m-badge--rounded">ترافیک رایگان آلاء</h6>
                                <p class="text-justify">
                                    دانلود آسیاتکی ها از سایت آلاء رایگان است.
                                    <br>
                                    اگر آسیاتک ندارید، از
                                    <a href = "/v/asiatech" class="m-link m--font-boldest">اینجا</a>
                                    کد تخفیف
                                    <span>
                                        100%
                                    </span>
                                    آسیاتک را <strong> رایگان </strong> دریافت کنید.
                                </p>
                            </div>
                            <div class = "m-separator m-separator--dashed m--space-10"></div>
                            <div>
                                <h6 class="m-badge m-badge--warning m-badge--wide m-badge--rounded"> کمک مالی به آلاء</h6>
                                    <p class="mb-0 text-justify">
                                        ما هرکاری که می کنیم، به تغییر وضعیت موجود اعتقاد داریم،
                                        ما به متفاوت فکر کردن اعتقاد داریم.
                                        <br>
                                        روش ما برای به چالش کشیدن وضعیت موجود، تولید محتواهای کامل، جامع و بررسی دقیق پیشنهادهای  شما و نظرات کارشناسان آموزشی است.
                                        <br>
                                        اینگونه هست که ما بهترین فیلم های آموزشی را تولید می کنیم.
                                        <br>
                                        <a href="{{ action("Web\DonateController") }}" class="m-link m--font-boldest">
                                            ما برای حفظ و توسعه خدمات، نیاز به کمک های مالی شما آلایی ها داریم.
                                        </a>
                                    </p>
                                    <footer class="blockquote-footer">سهراب ابوذرخانی فرد <cite title="موسسه غیرتجاری توسعه علمی آموزشی عدالت محور آلاء">موسسه غیرتجاری آلاء</cite></footer>
                            </div>
        
                        </div>
                    <!-- END: Right Aside -->--}}
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
            <i class="la la-arrow-up"></i>
        </div>
        <!-- end::Scroll Top -->
        {{--
        <!-- begin::Quick Nav -->
        <ul class = "m-nav-sticky" style = "margin-top: 30px;">
            <li class = "m-nav-sticky__item" data-toggle = "m-tooltip" title = "سبد خرید" data-placement = "left">
                <a href = "https://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target = "_blank">
                    <i class = "la la-cart-arrow-down"></i>
                </a>
            </li>
            <li class = "m-nav-sticky__item" data-toggle = "m-tooltip" title = "Documentation" data-placement = "left">
                <a href = "https://keenthemes.com/metronic/documentation.html" target = "_blank">
                    <i class = "la la-code-fork"></i>
                </a>
            </li>
            <li class = "m-nav-sticky__item" data-toggle = "m-tooltip" title = "انجمن" data-placement = "left">
                <a href = "https://keenthemes.com/forums/forum/support/metronic5/" target = "_blank">
                    <i class = "la la-life-ring"></i>
                </a>
            </li>
        </ul>
        <!-- begin::Quick Nav -->
        --}}
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
        <script src="{{ mix('/js/loadGtmEecForPages.js') }}" type="text/javascript"></script>
    </body>
    <!-- end::Body -->
</html>
