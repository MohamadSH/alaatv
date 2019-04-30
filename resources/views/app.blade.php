<!DOCTYPE html>
<html lang = "fa" direction = "rtl" style = "direction: rtl">
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

    @yield('page-css')

    <style>
        /*fix persian date picker show bug in modal*/
        .datepicker-plot-area {
            z-index: 1061;
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
<body class = "m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-aside-right--enabled m-footer--push m-aside--offcanvas-default {{ isset($closedSideBar) && $closedSideBar ? 'm-aside-left--hide':''  }}">

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src = "https://www.googletagmanager.com/ns.html?id=GTM-PNP8RDW" height = "0" width = "0" style = "display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- begin:: Page -->
<div class = "m-grid m-grid--hor m-grid--root m-page">
@section('body')
    <!-- BEGIN: Header -->
@section("header")
    @include("partials.header1")
@show
<!-- END: Header -->
    <!-- begin::Body -->
    <div class = "m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        @section("sidebar")
            @include("partials.sidebar")
        @show

        <div class = "m-grid__item m-grid__item--fluid m-wrapper">
            <div class = "m-content">
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
    <input id = "js-var-userIp" class = "m--hide" type = "hidden" value = '{{ $userIpAddress }}'>
    <input id = "js-var-userId" class = "m--hide" type = "hidden" value = '{{ optional(Auth::user())->id }}'>
</div>
<!-- end:: Page -->

@section('quick-sidebar')
    @include('partials.quickSidebar')
@show
<!-- begin::Scroll Top -->
<div id = "m_scroll_top" class = "m-scroll-top">
    <i class = "la la-arrow-up"></i>
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


    mLayout = function() {
        var header;
        var horMenu;
        var asideMenu;
        var asideMenuOffcanvas;
        var horMenuOffcanvas;
        var asideLeftToggle;
        var asideLeftHide;
        var scrollTop;
        var quicksearch;
        var mainPortlet;

        //== Header
        var initStickyHeader = function() {
            var tmp;
            var headerEl = mUtil.get('m_header');
            var options = {
                offset: {},
                minimize:{}
            };

            if (mUtil.attr(headerEl, 'm-minimize-mobile') == 'hide') {
                options.minimize.mobile = {};
                options.minimize.mobile.on = 'm-header--hide';
                options.minimize.mobile.off = 'm-header--show';
            } else {
                options.minimize.mobile = false;
            }

            if (mUtil.attr(headerEl, 'm-minimize') == 'hide') {
                options.minimize.desktop = {};
                options.minimize.desktop.on = 'm-header--hide';
                options.minimize.desktop.off = 'm-header--show';
            } else {
                options.minimize.desktop = false;
            }

            if (tmp = mUtil.attr(headerEl, 'm-minimize-offset')) {
                options.offset.desktop = tmp;
            }

            if (tmp = mUtil.attr(headerEl, 'm-minimize-mobile-offset')) {
                options.offset.mobile = tmp;
            }

            header = new mHeader('m_header', options);
        };

        //== Hor menu
        var initHorMenu = function() {
            // init aside left offcanvas
            horMenuOffcanvas = new mOffcanvas('m_header_menu', {
                overlay: true,
                baseClass: 'm-aside-header-menu-mobile',
                closeBy: 'm_aside_header_menu_mobile_close_btn',
                toggleBy: {
                    target: 'm_aside_header_menu_mobile_toggle',
                    state: 'm-brand__toggler--active'
                }
            });

            horMenu = new mMenu('m_header_menu', {
                submenu: {
                    desktop: 'dropdown',
                    tablet: 'accordion',
                    mobile: 'accordion'
                },
                accordion: {
                    slideSpeed: 200,  // accordion toggle slide speed in milliseconds
                    expandAll: false   // allow having multiple expanded accordions in the menu
                }
            });
        };

        //== Aside menu
        var initLeftAsideMenu = function() {
            //== Init aside menu
            var menu = mUtil.get('m_ver_menu');
            var menuDesktopMode = (mUtil.attr(menu, 'm-menu-dropdown') === '1' ? 'dropdown' : 'accordion');

            var scroll;
            if ( mUtil.attr(menu, 'm-menu-scrollable') === '1' ) {
                scroll = {
                    height: function() {
                        if (mUtil.isInResponsiveRange('desktop')) {
                            return mUtil.getViewPort().height - parseInt(mUtil.css('m_header', 'height'));
                        }
                    }
                };
            }

            asideMenu = new mMenu('m_ver_menu', {
                // vertical scroll
                scroll: scroll,

                // submenu setup
                submenu: {
                    desktop: {
                        // by default the menu mode set to accordion in desktop mode
                        default: menuDesktopMode,
                        // whenever body has this class switch the menu mode to dropdown
                        state: {
                            body: 'm-aside-left--minimize',
                            mode: 'dropdown'
                        }
                    },
                    tablet: 'accordion', // menu set to accordion in tablet mode
                    mobile: 'accordion'  // menu set to accordion in mobile mode
                },

                //accordion setup
                accordion: {
                    autoScroll: false, // enable auto scrolling(focus) to the clicked menu item
                    expandAll: false   // allow having multiple expanded accordions in the menu
                }
            });
        };

        //== Aside
        var initLeftAside = function() {
            // init aside left offcanvas
            var body = mUtil.get('body');
            var asideLeft = mUtil.get('m_aside_left');
            var asideOffcanvasClass = mUtil.hasClass(asideLeft, 'm-aside-left--offcanvas-default') ? 'm-aside-left--offcanvas-default' : 'm-aside-left';

            asideMenuOffcanvas = new mOffcanvas('m_aside_left', {
                baseClass: asideOffcanvasClass,
                overlay: true,
                closeBy: 'm_aside_left_close_btn',
                toggleBy: {
                    target: 'm_aside_left_offcanvas_toggle',
                    state: 'm-brand__toggler--active'
                }
            });

            //== Handle minimzied aside hover
            if (mUtil.hasClass(body, 'm-aside-left--fixed')) {
                var insideTm;
                var outsideTm;

                mUtil.addEvent(asideLeft, 'mouseenter', function() {
                    if (outsideTm) {
                        clearTimeout(outsideTm);
                        outsideTm = null;
                    }

                    insideTm = setTimeout(function() {
                        if (mUtil.hasClass(body, 'm-aside-left--minimize') && mUtil.isInResponsiveRange('desktop')) {
                            mUtil.removeClass(body, 'm-aside-left--minimize');
                            mUtil.addClass(body, 'm-aside-left--minimize-hover');
                            asideMenu.scrollerUpdate();
                            asideMenu.scrollerTop();
                        }
                    }, 300);
                });

                mUtil.addEvent(asideLeft, 'mouseleave', function() {
                    if (insideTm) {
                        clearTimeout(insideTm);
                        insideTm = null;
                    }

                    outsideTm = setTimeout(function() {
                        if (mUtil.hasClass(body, 'm-aside-left--minimize-hover') && mUtil.isInResponsiveRange('desktop')) {
                            mUtil.removeClass(body, 'm-aside-left--minimize-hover');
                            mUtil.addClass(body, 'm-aside-left--minimize');
                            asideMenu.scrollerUpdate();
                            asideMenu.scrollerTop();
                        }
                    }, 500);
                });
            }
        };

        //== Sidebar toggle
        var initLeftAsideToggle = function() {
            if ($('#m_aside_left_minimize_toggle').length === 0 ) {
                return;
            }

            asideLeftToggle = new mToggle('m_aside_left_minimize_toggle', {
                target: 'body',
                targetState: 'm-brand--minimize m-aside-left--minimize',
                togglerState: 'm-brand__toggler--active'
            });

            asideLeftToggle.on('toggle', function(toggle) {
                if (mUtil.get('main_portlet')) {
                    mainPortlet.updateSticky();
                }

                horMenu.pauseDropdownHover(800);
                asideMenu.pauseDropdownHover(800);

                //== Remember state in cookie
                Cookies.set('sidebar_toggle_state', toggle.getState());
                // to set default minimized left aside use this cookie value in your
                // server side code and add "m-brand--minimize m-aside-left--minimize" classes to
                // the body tag in order to initialize the minimized left aside mode during page loading.
            });
        };

        //== Sidebar hide
        var initLeftAsideHide = function() {
            if ($('#m_aside_left_hide_toggle').length === 0 ) {
                return;
            }

            initLeftAsideHide = new mToggle('m_aside_left_hide_toggle', {
                target: 'body',
                targetState: 'm-aside-left--hide',
                togglerState: 'm-brand__toggler--active'
            });

            initLeftAsideHide.on('toggle', function(toggle) {
                horMenu.pauseDropdownHover(800);
                asideMenu.pauseDropdownHover(800);

                //== Remember state in cookie
                Cookies.set('sidebar_hide_state', toggle.getState());
                // to set default minimized left aside use this cookie value in your
                // server side code and add "m-brand--minimize m-aside-left--minimize" classes to
                // the body tag in order to initialize the minimized left aside mode during page loading.
            });
        };

        //== Topbar
        var initTopbar = function() {
            $('#m_aside_header_topbar_mobile_toggle').click(function() {
                $('body').toggleClass('m-topbar--on');
            });
        };

        //== Quicksearch
        var initQuicksearch = function() {
            if ($('#m_quicksearch').length === 0 ) {
                return;
            }

            quicksearch = new mQuicksearch('m_quicksearch', {
                mode: mUtil.attr( 'm_quicksearch', 'm-quicksearch-mode' ), // quick search type
                minLength: 1
            });

            //<div class="m-search-results m-search-results--skin-light"><span class="m-search-result__message">Something went wrong</div></div>

            quicksearch.on('search', function(the) {
                the.showProgress();
                
                $.ajax({
                    url: 'inc/api/quick_search.php',
                    data: {query: the.query},
                    dataType: 'html',
                    success: function(res) {
                        the.hideProgress();
                        the.showResult(res);
                    },
                    error: function(res) {
                        the.hideProgress();
                        the.showError('Connection error. Pleae try again later.');
                    }
                });
            });
        };

        //== Scrolltop
        var initScrollTop = function() {
            var scrollTop = new mScrollTop('m_scroll_top', {
                offset: 300,
                speed: 600
            });
        };

        //== Main portlet(sticky portlet)
        var createMainPortlet = function() {
            return new mPortlet('main_portlet', {
                sticky: {
                    offset: parseInt(mUtil.css( mUtil.get('m_header'), 'height')) + parseInt(mUtil.css( mUtil.get('a_top_section'), 'height')),
                    zIndex: 90,
                    position: {
                        top: function() {
                            return parseInt(mUtil.css( mUtil.get('m_header'), 'height') );
                        },
                        left: function() {
                            var left = parseInt(mUtil.css( mUtil.getByClass('m-content'), 'paddingLeft'));

                            if (mUtil.isInResponsiveRange('desktop')) {
                                //left += parseInt(mUtil.css(mUtil.get('m_aside_left'), 'width') );
                                if (mUtil.hasClass(mUtil.get('body'), 'm-aside-left--minimize')) {
                                    left += 78; // need to use hardcoded width of the minimize aside
                                } else {
                                    left += 255; // need to use hardcoded width of the aside
                                }
                            }

                            return left;
                        },
                        right: function() {
                            return parseInt(mUtil.css( mUtil.getByClass('m-content'), 'paddingRight') );
                        }
                    }
                }
            });
        };

        return {
            init: function() {
                this.initHeader();
                this.initAside();
                this.initMainPortlet();
            },
            initMainPortlet: function() {
                if (!mUtil.get('main_portlet')) {
                    return;
                }

                mainPortlet = createMainPortlet();
                mainPortlet.initSticky();

                mUtil.addResizeHandler(function(){
                    mainPortlet.updateSticky();
                });
            },

            resetMainPortlet: function() {
                mainPortlet.destroySticky();
                mainPortlet = createMainPortlet();
                mainPortlet.initSticky();
            },

            initHeader: function() {
                initStickyHeader();
                initHorMenu();
                initTopbar();
                initQuicksearch();
                initScrollTop();
            },

            initAside: function() {
                initLeftAside();
                initLeftAsideMenu();
                initLeftAsideToggle();
                initLeftAsideHide();

                this.onLeftSidebarToggle(function(e) {
                    //== Update sticky portlet
                    if (mainPortlet) {
                        mainPortlet.updateSticky();
                    }

                    var datatables = $('.m-datatable');

                    $(datatables).each(function() {
                        $(this).mDatatable('redraw');
                    });
                });
            },

            getAsideMenu: function() {
                return asideMenu;
            },

            onLeftSidebarToggle: function(handler) {
                if (asideLeftToggle) {
                    asideLeftToggle.on('toggle', handler);
                }
            },

            closeMobileAsideMenuOffcanvas: function() {
                if (mUtil.isMobileDevice()) {
                    asideMenuOffcanvas.hide();
                }
            },

            closeMobileHorMenuOffcanvas: function() {
                if (mUtil.isMobileDevice()) {
                    horMenuOffcanvas.hide();
                }
            }
        };
    }();



</script>
@yield('page-js')
</body>
<!-- end::Body -->
</html>