{{--<style>
    span,p,body,h1, h2, h3, h4, h5, h6,input, textarea {
        font-family: IRANSans !important;
    }
</style>--}}
<!-- BEGIN: Header -->
<header id="m_header" class="a--MegaMenu m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
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
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block1 d-none">
                            <span></span>
                        </a>
                        <!-- END -->


                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="fa fa-user-alt" style="color: white;"></i>
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

                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel a--MegaMenu-title">
                            <a href="javascript:" class="m-menu__link m-menu__toggle" title="فیلم های آلاء">
                                <i class="m-menu__link-icon flaticon-layers"></i>
                                <span class="m-menu__link-text">فیلم های آلاء</span>
                                <i class="m-menu__hor-arrow fa fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu1 m-menu__submenu--classic1 a-major-menu__submenu a--MegaMenu-dropDownRow">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-2 a--MegaMenu-categoryItemsCol">
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="davazdahomVaKonkur">
                                                <a dtat-cat-id="davazdahomVaKonkur" class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور')) }}">
                                                    دوازدهم و کنکور
                                                </a>
                                            </div>
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="yazdahom">
                                                <a dtat-cat-id="yazdahom" class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم')) }}">
                                                    یازدهم
                                                </a>
                                            </div>
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="dahom">
                                                <a dtat-cat-id="dahom" class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم')) }}">
                                                    دهم
                                                </a>
                                            </div>
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="nezameGhadim">
                                                <a dtat-cat-id="nezameGhadim" class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور')) }}">
                                                    کنکور نظام قدیم
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-10 a--MegaMenu-subCategoryItemsCol">

                                            <div class="a--MegaMenu-categorySubItems" style="background: #ffd6e6;" data-cat-id="davazdahomVaKonkur">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی')) }}" >
                                                                دروس اختصاصی ریاضی و تجربی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=شیمی')) }}" >
                                                                شیمی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=فیزیک')) }}" >
                                                                فیزیک
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_تجربی&tags[]=ریاضی_تجربی&tags[]=ریاضی_پایه')) }}" >
                                                                ریاضیات تجربی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=زیست_شناسی')) }}" >
                                                                زیست شناسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=هندسه&tags[]=هندسه_کنکور')) }}" >
                                                                هندسه
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=گسسته&tags[]=آمار_و_احتمال')) }}" >
                                                                ریاضیات گسسته و آمار و احتمال
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=حسابان&tags[]=ریاضی_پایه')) }}" >
                                                                حسابان و ریاضی پایه
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_انسانی')) }}" >
                                                                دروس اختصاصی انسانی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_انسانی&tags[]=عربی')) }}" >
                                                                عربی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_انسانی&tags[]=ریاضی_انسانی&tags[]=ریاضی_و_آمار')) }}" >
                                                                ریاضی
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=زبان_انگلیسی&tags[]=عربی&tags[]=زبان_و_ادبیات_فارسی&tags[]=دین_و_زندگی')) }}" >
                                                                دروس عمومی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=زبان_انگلیسی')) }}" >
                                                                انگلیسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=عربی')) }}" >
                                                                عربی عمومی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=زبان_و_ادبیات_فارسی')) }}" >
                                                                فارسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=دین_و_زندگی')) }}" >
                                                                دین و زندگی
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="a--MegaMenu-categorySubItems-background">
                                                        <div class="a--MegaMenu-categorySubItems-background-title">دوازدهم و کنکور</div>
                                                        <div class="a--MegaMenu-categorySubItems-background-image">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                 version="1.1" id="Capa_1" x="0px" y="0px"
                                                                 viewBox="0 0 455.431 455.431"
                                                                 xml:space="preserve" width="100" height="100">
                                                                <g>
                                                                    <path style="fill:#900C3F"
                                                                          d="M405.39,412.764c-69.689,56.889-287.289,56.889-355.556,0s-62.578-300.089,0-364.089  s292.978-64,355.556,0S475.079,355.876,405.39,412.764z"
                                                                          data-original="#5CA4DA" class=""
                                                                          data-old_color="#5CA4DA"></path>
                                                                    <path style="fill:#AA0F4A"
                                                                          d="M229.034,313.209c-62.578,49.778-132.267,75.378-197.689,76.8  C-17.01,307.52-7.055,106.987,49.834,48.676c51.2-52.622,211.911-62.578,304.356-29.867  C376.945,112.676,330.012,232.142,229.034,313.209z"
                                                                          data-original="#6DAFE0" class="active-path"
                                                                          data-old_color="#6DAFE0"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="a--MegaMenu-categorySubItems" style="background: #ffe0e9;" data-cat-id="yazdahom">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی')) }}" >
                                                                دروس اختصاصی ریاضی و تجربی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=شیمی')) }}" >
                                                                شیمی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=فیزیک')) }}" >
                                                                فیزیک
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_تجربی&tags[]=ریاضی_تجربی')) }}" >
                                                                ریاضی تجربی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_تجربی&tags[]=زیست_شناسی')) }}" >
                                                                زیست شناسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=هندسه&tags[]=هندسه_پایه')) }}" >
                                                                هندسه
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=آمار_و_احتمال')) }}" >
                                                                آمار و احتمال
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=حسابان')) }}" >
                                                                حسابان
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=زبان_انگلیسی&tags[]=عربی&tags[]=زبان_و_ادبیات_فارسی&tags[]=دین_و_زندگی')) }}" >
                                                                دروس عمومی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=زبان_انگلیسی')) }}" >
                                                                انگلیسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=عربی')) }}" >
                                                                عربی عمومی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=زبان_و_ادبیات_فارسی')) }}" >
                                                                فارسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=دین_و_زندگی')) }}" >
                                                                دین و زندگی
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="a--MegaMenu-categorySubItems-background">
                                                        <div class="a--MegaMenu-categorySubItems-background-title">یازدهم</div>
                                                        <div class="a--MegaMenu-categorySubItems-background-image">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                 version="1.1" id="Capa_1" x="0px" y="0px"
                                                                 viewBox="0 0 455.431 455.431"
                                                                 xml:space="preserve" width="100" height="100">
                                                                <g>
                                                                    <path style="fill:#C70039"
                                                                          d="M405.39,412.764c-69.689,56.889-287.289,56.889-355.556,0s-62.578-300.089,0-364.089  s292.978-64,355.556,0S475.079,355.876,405.39,412.764z"
                                                                          data-original="#5CA4DA" class=""
                                                                          data-old_color="#5CA4DA"></path>
                                                                    <path style="fill:#E90849"
                                                                          d="M229.034,313.209c-62.578,49.778-132.267,75.378-197.689,76.8  C-17.01,307.52-7.055,106.987,49.834,48.676c51.2-52.622,211.911-62.578,304.356-29.867  C376.945,112.676,330.012,232.142,229.034,313.209z"
                                                                          data-original="#6DAFE0" class="active-path"
                                                                          data-old_color="#6DAFE0"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="a--MegaMenu-categorySubItems" style="background: #ffe6dd;" data-cat-id="dahom">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی')) }}" >
                                                                دروس اختصاصی ریاضی و تجربی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=شیمی')) }}" >
                                                                شیمی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=فیزیک')) }}" >
                                                                فیزیک
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_تجربی&tags[]=زیست_شناسی')) }}" >
                                                                زیست شناسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_تجربی&tags[]=رشته_ریاضی&tags[]=هندسه&tags[]=هندسه_پایه')) }}" >
                                                                هندسه
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=ریاضی_پایه')) }}" >
                                                                ریاضی
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_انسانی')) }}" >
                                                                دروس اختصاصی انسانی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_انسانی&tags[]=ریاضی_و_آمار')) }}" >
                                                                ریاضی و آمار
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=زبان_انگلیسی&tags[]=عربی&tags[]=زبان_و_ادبیات_فارسی&tags[]=دین_و_زندگی')) }}" >
                                                                دروس عمومی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=زبان_انگلیسی')) }}" >
                                                                انگلیسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=عربی')) }}" >
                                                                عربی عمومی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=زبان_و_ادبیات_فارسی')) }}" >
                                                                فارسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=دین_و_زندگی')) }}" >
                                                                دین و زندگی
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="a--MegaMenu-categorySubItems-background">
                                                        <div class="a--MegaMenu-categorySubItems-background-title">دهم</div>
                                                        <div class="a--MegaMenu-categorySubItems-background-image">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                 version="1.1" id="Capa_1" x="0px" y="0px"
                                                                 viewBox="0 0 455.431 455.431"
                                                                 xml:space="preserve" width="100" height="100">
                                                                <g>
                                                                    <path style="fill:#FF5733"
                                                                          d="M405.39,412.764c-69.689,56.889-287.289,56.889-355.556,0s-62.578-300.089,0-364.089  s292.978-64,355.556,0S475.079,355.876,405.39,412.764z"
                                                                          data-original="#5CA4DA" class="active-path"
                                                                          data-old_color="#5CA4DA"></path>
                                                                    <path style="fill:#FF6F51"
                                                                          d="M229.034,313.209c-62.578,49.778-132.267,75.378-197.689,76.8  C-17.01,307.52-7.055,106.987,49.834,48.676c51.2-52.622,211.911-62.578,304.356-29.867  C376.945,112.676,330.012,232.142,229.034,313.209z"
                                                                          data-original="#6DAFE0" class=""
                                                                          data-old_color="#6DAFE0"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="a--MegaMenu-categorySubItems" style="background: #fff2e1;" data-cat-id="nezameGhadim">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4">

                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی')) }}" >
                                                                دروس اختصاصی ریاضی و تجربی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=شیمی')) }}" >
                                                                شیمی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=فیزیک')) }}" >
                                                                فیزیک
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_تجربی&tags[]=ریاضی_تجربی&tags[]=ریاضی_پایه')) }}" >
                                                                ریاضیات تجربی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_تجربی&tags[]=زیست_شناسی')) }}" >
                                                                زیست شناسی
                                                            </a>
                                                        </div>

                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=هندسه_پایه&tags[]=هندسه&tags[]=تحلیلی')) }}" >
                                                                هندسه تحلیلی و هندسه پایه
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=گسسته&tags[]=آمار_و_مدلسازی&tags[]=جبر_و_احتمال')) }}" >
                                                                ریاضیات گسسته و آمار و احتمال
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=حسابان&tags[]=دیفرانسیل&tags[]=ریاضی_پایه')) }}" >
                                                                دیفرانسیل، حسابان و ریاضی پایه
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_انسانی')) }}" >
                                                                دروس اختصاصی انسانی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_انسانی&tags[]=منطق')) }}" >
                                                                فلسفه و منطق
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_انسانی&tags[]=ریاضی_انسانی')) }}" >
                                                                ریاضی
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="subCategoryItem subCategoryItem-title">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=زبان_انگلیسی&tags[]=عربی&tags[]=زبان_و_ادبیات_فارسی&tags[]=دین_و_زندگی')) }}" >
                                                                دروس عمومی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=زبان_انگلیسی')) }}" >
                                                                انگلیسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=عربی')) }}" >
                                                                عربی عمومی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=زبان_و_ادبیات_فارسی')) }}" >
                                                                زبان و ادبیات فارسی
                                                            </a>
                                                        </div>
                                                        <div class="subCategoryItem">
                                                            <a class="m-link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=دین_و_زندگی')) }}" >
                                                                دین و زندگی
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="a--MegaMenu-categorySubItems-background">
                                                        <div class="a--MegaMenu-categorySubItems-background-title">کنکور نظام قدیم</div>
                                                        <div class="a--MegaMenu-categorySubItems-background-image">
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 455.431 455.431" xml:space="preserve" width="100" height="100" class="">
                                                                <g>
                                                                    <path style="fill:#FF9000" d="M405.39,412.764c-69.689,56.889-287.289,56.889-355.556,0s-62.578-300.089,0-364.089  s292.978-64,355.556,0S475.079,355.876,405.39,412.764z" data-original="#5CA4DA" class="" data-old_color="#5CA4DA"></path>
                                                                    <path style="fill:#FFA229" d="M229.034,313.209c-62.578,49.778-132.267,75.378-197.689,76.8  C-17.01,307.52-7.055,106.987,49.834,48.676c51.2-52.622,211.911-62.578,304.356-29.867  C376.945,112.676,330.012,232.142,229.034,313.209z" data-original="#6DAFE0" class="active-path" data-old_color="#6DAFE0"></path>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel a--MegaMenu-title">
                            <a href="javascript:" class="m-menu__link m-menu__toggle" title="فیلم های آلاء">
                                <i class="m-menu__link-icon flaticon-layers"></i>
                                <span class="m-menu__link-text">همایش های آلاء</span>
                                <i class="m-menu__hor-arrow fa fa-angle-down"></i>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu1 m-menu__submenu--classic1 a-major-menu__submenu a--MegaMenu-dropDownRow">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-2 a--MegaMenu-categoryItemsCol">
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="godar">
                                                <a dtat-cat-id="godar" class="m-link" href="{{ route('web.landing.10') }}">
                                                    گدار
                                                    <span class="m-badge m-badge--info m-badge--wide m-badge--rounded a--puls-gray">جدید</span>
                                                </a>
                                            </div>
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="raheAbrisham">
                                                <a dtat-cat-id="raheAbrisham" class="m-link" href="{{route('product.show' , 347)}}">
                                                    راه ابریشم
                                                </a>
                                            </div>
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="talaee">
                                                <a dtat-cat-id="talaee" class="m-link" href="{{ route('web.landing.8') }}">
                                                    طلایی
                                                </a>
                                            </div>
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="taftan">
                                                <a dtat-cat-id="taftan" class="m-link" href="{{ route('web.landing.9') }}">
                                                    تفتان
                                                </a>
                                            </div>
                                            <div class="a--MegaMenu-categoryItem" dtat-cat-id="nezameGhadim">
                                                <a dtat-cat-id="nezameGhadim" class="m-link" href="{{ route('web.landing.5') }}">
                                                    همایش های نظام قدیم
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-10 a--MegaMenu-subCategoryItemsCol">

                                            <div class="a--MegaMenu-categorySubItems" style="background: #ffe6dd;" data-cat-id="godar">
                                                <div class="row no-gutters">
                                                    <div class="col">
                                                        <a href="{{ route('web.landing.10') }}">
                                                            <img class="lazy-image" data-src="https://cdn.alaatv.com/upload/megamenuBackground-GODAR.jpg" style="width: 1083px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="a--MegaMenu-categorySubItems" style="background: #fff2e1;" data-cat-id="raheAbrisham">
                                                <div class="row no-gutters">
                                                    <div class="col">
                                                        <a href="{{route('product.show' , 347)}}">
                                                            <img class="lazy-image" data-src="https://cdn.alaatv.com/upload/megamenuBackground-raheAbrisham.jpg" style="width: 1083px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="a--MegaMenu-categorySubItems" style="background: #ffd6e6;" data-cat-id="talaee">
                                                <div class="row no-gutters">
                                                    <div class="col">
                                                        <a href="{{ route('web.landing.8') }}">
                                                            <img class="lazy-image" data-src="https://cdn.alaatv.com/upload/megamenuBackground-talaee.jpg" style="width: 1083px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="a--MegaMenu-categorySubItems" style="background: #ffe0e9;" data-cat-id="taftan">
                                                <div class="row no-gutters">
                                                    <div class="col">
                                                        <a href="{{ route('web.landing.9') }}">
                                                            <img class="lazy-image" data-src="https://cdn.alaatv.com/upload/megamenuBackground-taftan.jpg" style="width: 1083px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="a--MegaMenu-categorySubItems" style="background: #fff2e1;" data-cat-id="nezameGhadim">
                                                <div class="row no-gutters">
                                                    <div class="col">
                                                        <a href="{{ route('web.landing.5') }}">
                                                            <img class="lazy-image" data-src="https://cdn.alaatv.com/upload/megamenuBackground-ghadim.jpg" style="width: 1083px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                <a data-href="{{ route('live') }}" class="m-nav__link LoginBeforeClick" title="پخش زنده">
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
                                                        <i class="fa fa-times"></i>
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
                                    <a href="{{ route("login") }}" class="m-nav__link loginPageLinkInNav">
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
