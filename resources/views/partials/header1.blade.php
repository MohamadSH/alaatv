{{--<style>
    span,p,body,h1, h2, h3, h4, h5, h6,input, textarea {
        font-family: IRANSans !important;
    }
</style>--}}
<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{route('web.index')}}" class="m-brand__logo-wrapper">
                            <img alt="لوگوی سایت آلاء" src="{{$wLogoUrl}}"  width="135" height="22"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="{{ route('live') }}" class="m-brand__toggler--left m--visible-tablet-and-mobile-inline-block liveIconOnMobile" title="پخش زنده">
                            <img class="a--full-width lazy-image
                                @if($live)
                                liveOn
                                @else
                                liveOff
                                @endif "
                                src="https://cdn.alaatv.com/loder.jpg?w=1&h=1"
                                @if($live)
                                data-src="https://cdn.alaatv.com/upload/live-on.png"
                                @else
                                data-src="https://cdn.alaatv.com/upload/live-off-mobile.png"
                                @endif
                                width="35"
                                height="40"
                                alt="livePageIcon"
                            >
                        </a>
                        <!-- END -->

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->

                        <!-- BEGIN: Aside Hide Toggle -->
                        <a href="javascript:" id="m_aside_left_hide_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--hidden-tablet-and-mobile">
                            <span></span>
                        </a>
                        <!-- END -->


                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->


                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                    <i class="fa fa-times"></i>
                </button>
                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                    <ul class="m-menu__nav ">
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:" class="m-menu__link m-menu__toggle" title="فیلم و جزوه دهم آلاء">
                                <i class="m-menu__link-icon flaticon-layers"></i>
                                <span class="m-menu__link-text">دهم</span>
                                <i class="m-menu__hor-arrow fa fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left a-major-menu__submenu">
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=دهم&tags[]=رشته_ریاضی')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/riazi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته ریاضی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=دهم&tags[]=رشته_تجربی')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/tajrobi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته تجربی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=دهم&tags[]=رشته_انسانی')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/ensani.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته انسانی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:" class="m-menu__link m-menu__toggle" title="فیلم و جزوه یازدهم آلاء">
                                <i class="m-menu__link-icon flaticon-layers"></i>
                                <span class="m-menu__link-text">یازدهم</span>
                                <i class="m-menu__hor-arrow fa fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left a-major-menu__submenu">
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=یازدهم&tags[]=رشته_ریاضی')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/riazi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته ریاضی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=یازدهم&tags[]=رشته_تجربی')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/tajrobi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته تجربی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=یازدهم&tags[]=رشته_انسانی')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/ensani.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته انسانی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:" class="m-menu__link m-menu__toggle" title="فیلم و جزوه کنکور آلاء">
                                <i class="m-menu__link-icon flaticon-medal"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">کنکور</span>
                                        <span class="m-menu__link-badge">
                                            <span class="m-badge m-badge--brand m-badge--wide">نظام جدید</span>
                                        </span>
                                    </span>
                                </span>
                                <i class="m-menu__hor-arrow fa fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left a-major-menu__submenu">
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=نظام_آموزشی_جدید')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/riazi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته ریاضی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=کنکور&tags[]=رشته_تجربی&tags[]=نظام_آموزشی_جدید')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/tajrobi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته تجربی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=کنکور&tags[]=رشته_انسانی&tags[]=نظام_آموزشی_جدید')) }}" class="m-menu__link ">
{{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/ensani.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته انسانی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ route('web.shop') }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/ensani.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">جمع بندی و جزوه</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:" class="m-menu__link m-menu__toggle" title="فیلم و جزوه کنکور آلاء">
                                <i class="m-menu__link-icon flaticon-medal"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">کنکور</span>
                                        <span class="m-menu__link-badge">
                                            <span class="m-badge m-badge--brand m-badge--wide">نظام قدیم</span>
                                        </span>
                                    </span>
                                </span>
                                <i class="m-menu__hor-arrow fa fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left a-major-menu__submenu">
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=نظام_آموزشی_قدیم')) }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/riazi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته ریاضی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=کنکور&tags[]=رشته_تجربی&tags[]=نظام_آموزشی_قدیم')) }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/tajrobi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته تجربی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ urldecode(route('content.index', 'tags[]=کنکور&tags[]=رشته_انسانی&tags[]=نظام_آموزشی_قدیم')) }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/ensani.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">رشته انسانی</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ route('web.landing.5') }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/ensani.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">جمع بندی و جزوه</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                            <a href="javascript:" class="m-menu__link m-menu__toggle" title="همایش های آلاء">
                                <i class="m-menu__link-icon flaticon-medal"></i>
                                <span class="m-menu__link-title">
                                    <span class="m-menu__link-wrap">
                                        <span class="m-menu__link-text">همایش دانلودی</span>
                                        <span class="m-menu__link-badge">
                                        </span>
                                    </span>
                                </span>
                                <i class="m-menu__hor-arrow fa fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left a-major-menu__submenu">
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ route('web.landing.8') }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/riazi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">
                                                        <b>طلایی</b>
                                                        -
                                                        80% کنکور
                                                        -
                                                        جمع بندی کامل
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ route('web.landing.9') }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/tajrobi.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">
                                                        <b>تفتان</b>
                                                        -
                                                        60% کنکور
                                                        -
                                                        دروس پایه
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ route('web.landing.10') }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/ensani.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">
                                                        <b>5+1</b>
                                                        -
                                                        33% کنکور
                                                        -
                                                        نیم سال اول دوازدهم
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true">
                                        <a href="{{ route('web.landing.5') }}" class="m-menu__link ">
                                            {{--                                            <i class="m-menu__link-icon majorIcon"><img src="{{ asset('/acm/extra/ensani.gif') }}" alt="riazi" > </i>--}}
                                            <span class="m-menu__link-title">
                                                <span class="m-menu__link-wrap">
                                                    <span class="m-badge a-badge--square m-badge--warning m-badge--dot m--margin-right-5"></span>
                                                    <span class="m-menu__link-text">
                                                        <b>همایش های نظام قدیم</b>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- END: Horizontal Menu -->
                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">

                            <li class="m-nav__item m--hidden-tablet-and-mobile">
                                <a href="{{ route('live') }}" class="m-nav__link" title="پخش زنده">
                                    <span class="m-nav__link-icon nav__link-icon-livePage">
                                        <span class="m-nav__link-icon-wrapper">
                                            <img class="a--full-width lazy-image
                                                 @if($live)
                                                    liveOn
                                                 @else
                                                    liveOff
                                                 @endif "
                                                 src="https://cdn.alaatv.com/loder.jpg?w=1&h=1"
                                                 @if($live)
                                                 data-src="https://cdn.alaatv.com/upload/live-on.png"
                                                 @else
                                                 data-src="https://cdn.alaatv.com/upload/live-off.png"
                                                 @endif
                                                 width="35"
                                                 height="40"
                                                 alt="livePageIcon"
                                            >
                                        </span>
                                    </span>
                                </a>
                            </li>

                            <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="m_quicksearch" m-quicksearch-mode="dropdown" m-dropdown-persistent="1">

                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-nav__link-icon">
                                        <span class="m-nav__link-icon-wrapper">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper a-quick-search">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                    <div class="m-dropdown__inner ">
                                        <div class="m-dropdown__header">
                                            <form class="m-list-search__form">
                                                <div class="m-list-search__form-wrapper">
                                                    <span class="m-list-search__form-input-wrapper">
                                                        <input id="m_quicksearch_input" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="دنبال چی می گردی ؟....">
                                                    </span>
                                                    <span class="m-list-search__form-icon-close" id="m_quicksearch_close">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="300" data-mobile-height="200">
                                                <div class="m-dropdown__content"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if(Auth::check())
                                @if(isset($bonName))
                                    <li class="m-nav__item">
                                        <a href="{{ action("Web\UserController@userOrders") }}" class="m-nav__link">
                                            <span class="m-nav__link-icon">
                                                <span class="m-nav__link-icon-wrapper">{{ $bonName }}</span>
                                                @if(Auth::user()->userHasBon() > 0)
                                                <span class="m-nav__link-badge m-badge m-badge--accent">{{ Auth::user()->userHasBon() }}</span>
                                                @endif
                                            </span>
                                        </a>
                                    </li>
                                @endif
                                <li class="m-nav__item">
                                    <a href="{{ action("Web\UserController@userOrders") }}" class="m-nav__link">
                                        <span class="m-nav__link-icon">
                                            <span class="m-nav__link-icon-wrapper"><i class="fa fa-wallet"></i></span>
                                            @if(Auth::user()->getTotalWalletBalance() > 0)
                                            <span class="m-nav__link-badge m-badge  m-badge--accent">{{ number_format(Auth::user()->getTotalWalletBalance()) }}</span>
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                <li class="m-nav__item">
                                    <a href="{{ action("Web\OrderController@checkoutReview") }}" class="m-nav__link">
                                        <span class="m-nav__link-icon">
                                            <span class="m-nav__link-icon-wrapper"><i class="fa fa-shopping-cart"></i></span>
                                            @if(Auth::user()->numberOfProductsInBasket > 0)
                                                <span class="shoppingBasketOfUserNumber m-nav__link-badge m-badge m-badge--danger">{{ Auth::user()->numberOfProductsInBasket }}</span>
                                            @endif
                                        </span>
                                    </a>
                                </li>

                                <li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
                                        <span class="m-topbar__userpic">
                                            <img src="{{ $profileImage }}" class="m--img-rounded m--marginless m--img-centered" alt="عکس پروفایل" width="41" height="41"/>
                                        </span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center">
                                                <div class="m-card-user m-card-user--skin-light">
                                                    <div class="m-card-user__pic">
                                                        <img src="{{ $profileImage }}" class="m--img-rounded m--marginless" alt="عکس پروفایل"/>
                                                    </div>
                                                    <div class="m-card-user__details">
                                                        <span class="m-card-user__name m--font-weight-500">{{ Auth::user()->fullName }}</span>
                                                        <a href="" class="m-card-user__email m--font-weight-300 m-link">{{ Auth::user()->email }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__section m--hide">
                                                            <span class="m-nav__section-text"> ---- </span>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="{{ action("Web\UserController@show",Auth::user()) }}" class="m-nav__link">
                                                                <i class="m-nav__link-icon fa fa-user-circle"></i>
                                                                <span class="m-nav__link-title">
                                                                    <span class="m-nav__link-wrap">
                                                                        <span class="m-nav__link-text">پروفایل</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="{{ action("Web\UserController@userProductFiles")  }}" class="m-nav__link">
                                                                <i class="m-nav__link-icon fa fa-cloud-download-alt"></i>
                                                                <span class="m-nav__link-text">فیلم ها و جزوه های من</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="{{ action("Web\UserController@userOrders")  }}" class="m-nav__link">
                                                                <i class="m-nav__link-icon fa fa-receipt"></i>
                                                                <span class="m-nav__link-text">سفارشهای من</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__separator m-nav__separator--fit"></li>
                                                        <li class="m-nav__item">
                                                            <a href="{{ url('/logout') }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                                <i class="fa fa-sign-out-alt"></i>
                                                                خروج
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            @else
                                <li class="a--login-item m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img">
                                    <a href="{{ route("login") }}" class="m-nav__link">
                                        <span class="a--login-title">ورود/ثبت نام</span>
                                        <span class="m-nav__link-icon">
                                        <i class="fa fa-sign-in-alt"></i>
                                    </span>
                                    </a>
                                </li>
                            @endif



                            {{--<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"--}}
                            {{--m-dropdown-toggle="click" aria-expanded="true">--}}
                            {{--<a href="#" class="m-nav__link m-dropdown__toggle">--}}
                            {{--<span class="m-topbar__userpic">--}}
                            {{--<img src="/assets/app/media/img/users/user4.jpg--}}
                            {{--{{ $profileImage }}--}}
                            {{--" class="m--img-rounded m--marginless" alt="عکس پروفایل">--}}
                            {{--</span>--}}
                            {{--<span class="m-topbar__username m--hide">--}}
                            {{--@if (Auth::check())--}}
                            {{--{{ Auth::user()->shortName }}--}}
                            {{--@endif--}}
                            {{--</span>--}}
                            {{--</a>--}}
                            {{--<div class="m-dropdown__wrapper" style="z-index: 101;">--}}
                            {{--<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"--}}
                            {{--style="right: auto; left: 199.047px; margin-left: auto; margin-right: auto;"></span>--}}
                            {{--<div class="m-dropdown__inner">--}}
                            {{--<div class="m-dropdown__header m--align-center"--}}
                            {{--style="background: url(/assets/app/media/img/misc/quick_actions_bg.jpg); background-size: cover;">--}}
                            {{--<div class="m-card-user m-card-user--skin-dark">--}}
                            {{--<div class="m-card-user__pic">--}}
                            {{--<img src="{{ $profileImage }}"--}}
                            {{--class="m--img-rounded m--marginless" alt="">--}}
                            {{--<!----}}
                            {{--<span class="m-type m-type--lg m--bg-danger"><span class="m--font-light">S<span><span>--}}
                            {{---->--}}
                            {{--</div>--}}
                            {{--@if( Auth::check() )--}}
                            {{--<div class="m-card-user__details">--}}
                            {{--<span class="m-card-user__name m--font-weight-500">{{ Auth::user()->fullName }}</span>--}}
                            {{--<a href="" class="m-card-user__email m--font-weight-300 m-link">{{ Auth::user()->email }}</a>--}}
                            {{--</div>--}}
                            {{--@endif--}}

                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="m-dropdown__body">--}}
                            {{--<div class="m-dropdown__content">--}}
                            {{--<ul class="m-nav m-nav--skin-light">--}}
                            {{--<li class="m-nav__section m--hide">--}}
                            {{--<span class="m-nav__section-text">----</span>--}}
                            {{--</li>--}}
                            {{--@if( Auth::check() )--}}
                            {{--<li class="m-nav__item">--}}
                            {{--<a href="{{ action("Web\UserController@show",Auth::user()) }}" class="m-nav__link">--}}
                            {{--<i class="m-nav__link-icon flaticon-profile-1"></i>--}}
                            {{--<span class="m-nav__link-title">--}}
                            {{--<span class="m-nav__link-wrap">--}}
                            {{--<span class="m-nav__link-text">پروفایل</span>--}}
                            {{--</span>--}}
                            {{--</span>--}}
                            {{--</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="m-nav__item">--}}
                            {{--<a href="{{ action("Web\UserController@userProductFiles")  }}" class="m-nav__link">--}}
                            {{--<i class="m-nav__link-icon flaticon-share"></i>--}}
                            {{--<span class="m-nav__link-text">فیلم ها و جزوه های من</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="m-nav__item">--}}
                            {{--<a href="{{ action("Web\UserController@userOrders")  }}" class="m-nav__link">--}}
                            {{--<i class="m-nav__link-icon flaticon-chat-1"></i>--}}
                            {{--<span class="m-nav__link-text">سفارشهای من</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--@endif--}}
                            {{--<li class="m-nav__separator m-nav__separator--fit"></li>--}}
                            {{--<li class="m-nav__item">--}}
                            {{--@if( Auth::check() )--}}
                            {{--<a href="{{ url('/logout') }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">خروج</a>--}}
                            {{--@else--}}

                            {{--<a href="{{ route("login") }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">ورود / ثبت نام</a>--}}
                            {{--@endif--}}
                            {{--</li>--}}
                            {{--</ul>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</li>--}}



                            <li id="m_quick_sidebar_toggle" class="m-nav__item d-none">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-nav__link-icon"><i class="flaticon-grid-menu"></i></span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header><!-- END: Header -->
