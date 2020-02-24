<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="fa fa-times"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav ">
            <li class="m-menu__section m-menu__section--first">
                <h4 class="m-menu__section-text">خدمات آلاء</h4>
                <i class="m-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class="m-menu__item  @if(isset($pageName) && strcmp($pageName , "dashboard")==0) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ route('web.index') }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-home"></i>
                    <span class="m-menu__link-text">صفحه اصلی</span>
                </a>
            </li>
            <li class="m-menu__item  @if(isset($pageName) && strcmp($pageName , "productsPortfolio")==0) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ action("Web\ShopPageController") }}" class="m-menu__link" title="دانلود جزوه، جمع بندی و همایش کنکور">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-chalkboard-teacher"></i>
                    <span class="m-menu__link-text">محصولات آموزشی</span>
                </a>
            </li>


            <li class="m-menu__item m-menu__item--submenu megamenuForMobiveInSidebar" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:" class="m-menu__link m-menu__toggle" title="فیلم های دهم، یازدهم، دوازدهم و کنکور نظام جدید و نظام قدیم آلاء">
                    <i class="m-menu__link-icon fa fa-film"></i>
                    <span class="m-menu__link-text">فیلم های پایه و کنکور آلاء</span>
                    <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                </a>
                <div class="m-menu__submenu" m-hidden-height="80" style="display: none; overflow: hidden;">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                            m-menu-submenu-toggle="hover">
                            <a href="javascript:" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon fa fa-chalkboard"><span></span></i>
                                <span class="m-menu__link-text">
                                    دوازدهم و کنکور
                                </span>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu " m-hidden-height="240">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس اختصاصی ریاضی و تجربی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=شیمی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            شیمی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=فیزیک')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            فیزیک
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_تجربی&tags[]=ریاضی_تجربی&tags[]=ریاضی_پایه')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضی تجربی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=زیست_شناسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            زیست شناسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=هندسه&tags[]=هندسه_کنکور')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            هندسه
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=گسسته&tags[]=آمار_و_احتمال')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضیات گسسته و آمار و احتمال
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=حسابان&tags[]=ریاضی_پایه')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            حسابان و ریاضی پایه
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس اختصاصی انسانی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_انسانی&tags[]=عربی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            عربی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=رشته_انسانی&tags[]=ریاضی_انسانی&tags[]=ریاضی_و_آمار')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضی
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس عمومی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=زبان_انگلیسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            انگلیسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=عربی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            عربی عمومی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=زبان_و_ادبیات_فارسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            فارسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دوازدهم&tags[]=کنکور&tags[]=دین_و_زندگی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            دین و زندگی
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                            m-menu-submenu-toggle="hover">
                            <a href="javascript:" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon fa fa-chalkboard"><span></span></i>
                                <span class="m-menu__link-text">یازدهم</span>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu " m-hidden-height="240">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس اختصاصی ریاضی و تجربی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=شیمی')) }}" class="m-menu__link ">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            شیمی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=فیزیک')) }}" class="m-menu__link ">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            فیزیک
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_تجربی&tags[]=ریاضی_تجربی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضی تجربی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_تجربی&tags[]=زیست_شناسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            زیست شناسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=هندسه&tags[]=هندسه_پایه')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            هندسه
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=آمار_و_احتمال')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            آمار و احتمال
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=رشته_ریاضی&tags[]=حسابان')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            حسابان
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس عمومی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=زبان_انگلیسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            انگلیسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=عربی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            عربی عمومی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=زبان_و_ادبیات_فارسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            فارسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=یازدهم&tags[]=دین_و_زندگی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            دین و زندگی
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                            m-menu-submenu-toggle="hover">
                            <a href="javascript:" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon fa fa-chalkboard"><span></span></i>
                                <span class="m-menu__link-text">
                                    دهم
                                </span>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu " m-hidden-height="240">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس اختصاصی ریاضی و تجربی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=شیمی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            شیمی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=فیزیک')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            فیزیک
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_تجربی&tags[]=زیست_شناسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            زیست شناسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_تجربی&tags[]=رشته_ریاضی&tags[]=هندسه&tags[]=هندسه_پایه')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            هندسه
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=ریاضی_پایه')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضی
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس اختصاصی انسانی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=رشته_انسانی&tags[]=ریاضی_و_آمار')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضی و آمار
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس عمومی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=زبان_انگلیسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            انگلیسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=عربی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            عربی عمومی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=زبان_و_ادبیات_فارسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            فارسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_جدید&tags[]=دهم&tags[]=دین_و_زندگی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            دین و زندگی
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                            m-menu-submenu-toggle="hover">
                            <a href="javascript:" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon fa fa-chalkboard"><span></span></i>
                                <span class="m-menu__link-text">
                                    کنکور نظام قدیم
                                </span>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu " m-hidden-height="240">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس اختصاصی ریاضی و تجربی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=شیمی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            شیمی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=فیزیک')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            فیزیک
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_تجربی&tags[]=ریاضی_تجربی&tags[]=ریاضی_پایه')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضیات تجربی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_تجربی&tags[]=زیست_شناسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            زیست شناسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=هندسه_پایه&tags[]=هندسه&tags[]=تحلیلی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            هندسه تحلیلی و هندسه پایه
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=گسسته&tags[]=آمار_و_مدلسازی&tags[]=جبر_و_احتمال')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضیات گسسته و آمار و احتمال
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_ریاضی&tags[]=رشته_تجربی&tags[]=حسابان&tags[]=دیفرانسیل&tags[]=ریاضی_پایه')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            دیفرانسیل، حسابان و ریاضی پایه
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس اختصاصی انسانی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_انسانی&tags[]=منطق')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            فلسفه و منطق
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=رشته_انسانی&tags[]=ریاضی_انسانی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            ریاضی
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"
                                        m-menu-submenu-toggle="hover">
                                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon fa fa-book"><span></span></i>
                                            <span class="m-menu__link-text">
                                                دروس عمومی
                                            </span>
                                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                                        </a>
                                        <div class="m-menu__submenu " m-hidden-height="240">
                                            <span class="m-menu__arrow"></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=زبان_انگلیسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            انگلیسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=عربی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            عربی عمومی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=زبان_و_ادبیات_فارسی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            زبان و ادبیات فارسی
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item " aria-haspopup="true">
                                                    <a class="m-menu__link" href="{{ urldecode(route('content.index', 'tags[]=نظام_آموزشی_قدیم&tags[]=کنکور&tags[]=دین_و_زندگی')) }}">
                                                        <i class="m-menu__link-icon fa fa-book-open"><span></span></i>
                                                        <span class="m-menu__link-text">
                                                            دین و زندگی
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item m-menu__item--submenu megamenuForMobiveInSidebar" aria-haspopup="true"
                m-menu-submenu-toggle="hover">
                <a href="javascript:" class="m-menu__link m-menu__toggle" title="همایش کنکوری آلاء">
                    <i class="m-menu__link-icon fa fa-video"></i>
                    <span class="m-menu__link-text">
                        همایش کنکوری آلاء
                    </span>
                    <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                </a>
                <div class="m-menu__submenu " m-hidden-height="240">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item " aria-haspopup="true">
                            <a class="m-menu__link" href="{{ route('web.landing.10') }}">
                                <i class="m-menu__link-icon fa fa-file-video"><span></span></i>
                                <span class="m-menu__link-text">
                                    گدار
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a class="m-menu__link" href="{{route('product.show' , 347)}}">
                                <i class="m-menu__link-icon fa fa-file-video"><span></span></i>
                                <span class="m-menu__link-text">
                                    راه ابریشم
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a class="m-menu__link" href="{{ route('web.landing.8') }}">
                                <i class="m-menu__link-icon fa fa-file-video"><span></span></i>
                                <span class="m-menu__link-text">
                                    طلایی
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a class="m-menu__link" href="{{ route('web.landing.9') }}">
                                <i class="m-menu__link-icon fa fa-file-video"><span></span></i>
                                <span class="m-menu__link-text">
                                    تفتان
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a class="m-menu__link" href="{{ route('web.landing.5') }}">
                                <i class="m-menu__link-icon fa fa-file-video"><span></span></i>
                                <span class="m-menu__link-text">
                                    همایش های نظام قدیم
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


{{--            <li class="m-menu__item  m-menu__item--submenu d-none @if(isset($pageName) && strcmp($pageName , "content")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-submenu-toggle="hover">--}}
{{--                <a href="javascript:" class="m-menu__link m-menu__toggle">--}}
{{--                    <span class="m-menu__item-here"></span>--}}
{{--                    <i class="m-menu__link-icon fa fa-film"></i>--}}
{{--                    <span class="m-menu__link-text">فیلم های آلاء</span>--}}
{{--                    <i class="m-menu__ver-arrow fa fa-angle-left"></i>--}}
{{--                </a>--}}
{{--                <div class="m-menu__submenu ">--}}
{{--                    <span class="m-menu__arrow"></span>--}}
{{--                    <ul class="m-menu__subnav">--}}
{{--                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">--}}
{{--                            <span class="m-menu__link">--}}
{{--                                <span class="m-menu__item-here"></span>--}}
{{--                                <span class="m-menu__link-text">فیلم های آلاء</span>--}}
{{--                            </span>--}}
{{--                        </li>--}}
{{--                        @foreach($sections as $section)--}}
{{--                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">--}}
{{--                                <a href="{{ urldecode(action("Web\ContentController@index" , ["tags" => $section["tags"]])) }}" class="m-menu__link ">--}}
{{--                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot">--}}
{{--                                        <span></span>--}}
{{--                                    </i>--}}
{{--                                    <span class="m-menu__link-text">{{ $section["displayName"] }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}

            <li class="m-menu__item @if(isset($pageName) && strcmp($pageName , "donate")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">
                <a href="{{ action("Web\DonateController") }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-donate"></i>
                    <span class="m-menu__link-text">کمک مالی به آلاء</span>
                </a>
            </li>
            @if(Auth::check())
                <li class="m-menu__item @if(isset($pageName) && strcmp($pageName , "submitKonkurResult")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">
                    <a href="{{route('web.user.konkurResult')}}" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-medal"></i>
                        <span class="m-menu__link-text">ثبت رتبه 98</span>
                    </a>
                </li>
            @endif
{{--            <li class="m-menu__item @if(isset($pageName) && strcmp($pageName , "rules")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">--}}
{{--                <a href="{{ action("Web\RulesPageController") }}" class="m-menu__link ">--}}
{{--                    <span class="m-menu__item-here"></span>--}}
{{--                    <i class="m-menu__link-icon fa fa-gavel"></i>--}}
{{--                    <span class="m-menu__link-text">قوانین</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item @if(isset($pageName) && strcmp($pageName , "contactUs")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">--}}
{{--                <a href="{{ action("Web\ContactUsController") }}" class="m-menu__link ">--}}
{{--                    <span class="m-menu__item-here"></span>--}}
{{--                    <i class="m-menu__link-icon fa fa-phone-volume"></i>--}}
{{--                    <span class="m-menu__link-text">@lang('page.contact us')</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                <a target="_blank" href="https://forum.alaatv.com" rel="noreferrer" class="m-menu__link " title="انجمن کنکور و دانش آموزی آلاء">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fab fa-hornbill"></i>
                    <span class="m-menu__link-text">انجمن کنکور و دانش آموزی آلاء</span>
                </a>
            </li>

            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                <a target="_blank" href="{{route('web.faq')}}" rel="noreferrer" class="m-menu__link " title="سؤالات متداول">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fab fa fa-question-circle"></i>
                    <span class="m-menu__link-text">سؤالات متداول</span>
                </a>
            </li>
{{--            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">--}}
{{--                <a target="_blank" href="https://telegram.me/alaa_sanatisharif" rel="noreferrer" class="m-menu__link ">--}}
{{--                    <span class="m-menu__item-here"></span>--}}
{{--                    <i class="m-menu__link-icon fab fa-telegram"></i>--}}
{{--                    <span class="m-menu__link-text">کانال تلگرام</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">--}}
{{--                <a target="_blank" href="https://www.instagram.com/alaa_sanatisharif" rel="noreferrer" class="m-menu__link ">--}}
{{--                    <span class="m-menu__item-here"></span>--}}
{{--                    <i class="m-menu__link-icon fab fa-instagram"></i>--}}
{{--                    <span class="m-menu__link-text">اینستاگرام</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            @if(Auth::check())
                @ability(config('constants.ROLE_ADMIN'),config('constants.ADMIN_PANEL_ACCESS'))
                    <li class="m-menu__section ">
                        <h4 class="m-menu__section-text">مدیریت</h4>
                        <i class="m-menu__section-icon flaticon-more-v2"></i>
                    </li>

                    @role((config("constants.ROLE_ADMIN")))
                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text m--font-bold m--font-focus">خالی کردن کش</span>
                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                        </a>
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ route('web.admin.cacheclear') }}" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text m--font-bold ">خالی کردن کل کش</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ route('web.admin.cacheclear') }}?product=1" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text m--font-bold ">خالی کردن کش محصول</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ route('web.admin.cacheclear') }}?order=1" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text m--font-bold ">خالی کردن کش سفارش</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ route('web.admin.cacheclear') }}?orderproduct=1" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text m--font-bold ">خالی کردن کش آیتم سبد</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ route('web.admin.cacheclear') }}?user=1" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text m--font-bold ">خالی کردن کش کاربر</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ route('web.admin.cacheclear') }}?transaction=1" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text m--font-bold ">خالی کردن کش تراکنش</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ route('web.admin.cacheclear') }}?content=1" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text m--font-bold ">خالی کردن کش کانتنت</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ route('web.admin.cacheclear') }}?set=1" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text m--font-bold ">خالی کردن کش ست</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endrole

                    @ability(config('constants.ROLE_ADMIN'),config('constants.USER_ADMIN_PANEL_ACCESS'))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\AdminController@admin") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">کاربران</span>
                        </a>
                    </li>
                    @endability

                    @permission((config('constants.SMS_ADMIN_PANEL_ACCESS')))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\AdminController@adminSMS") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-technology"></i>
                            <span class="m-menu__link-text">ارسال پیامک</span>
                        </a>
                    </li>
                    @endpermission

                    @permission((config('constants.ORDER_ADMIN_PANEL_ACCESS')))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\AdminController@adminOrder") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text"> سفارش ها</span>
                        </a>
                    </li>
                    @endpermission

                    @role((config("constants.ROLE_ADMIN")))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\AdminController@adminSalesReport") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text"> گزارش فروش</span>
                        </a>
                    </li>
                    @endrole

                    @permission((config('constants.REPORT_ADMIN_PANEL_ACCESS')))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\AdminController@adminReport") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-technology"></i>
                            <span class="m-menu__link-text">گزارش خاص</span>
                        </a>
                    </li>
                    @endpermission

                    @permission((config('constants.LIST_BLOCK_ACCESS')))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\AdminController@adminBlock") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text"> بلوک ها</span>
                        </a>
                    </li>
                    @endpermission

                    @permission((config('constants.PRODUCT_ADMIN_PANEL_ACCESS')))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\AdminController@adminProduct") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-technology"></i>
                            <span class="m-menu__link-text">محصولات</span>
                        </a>
                    </li>
                    @endpermission

                    @permission((config('constants.CONTENT_ADMIN_PANEL_ACCESS')))
                        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:" class="m-menu__link m-menu__toggle">
                                <span class="m-menu__item-here"></span>
                                <i class="m-menu__link-icon flaticon-network"></i>
                                <span class="m-menu__link-text">مدیریت محتوا</span>
                                <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                        <a href="{{ route('web.admin.sources') }}" class="m-menu__link ">
                                            <span class="m-menu__item-here"></span>
                                            <i class="m-menu__link-icon flaticon-technology"></i>
                                            <span class="m-menu__link-text">منبع</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                        <a href="{{ route('web.admin.content') }}" class="m-menu__link ">
                                            <span class="m-menu__item-here"></span>
                                            <i class="m-menu__link-icon flaticon-technology"></i>
                                            <span class="m-menu__link-text">محتوا</span>
                                        </a>
                                    </li>

                                    @permission((config('constants.LIST_CONTENT_SET_ACCESS')))
                                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                        <a href="{{ route('set.index') }}" class="m-menu__link ">
                                            <span class="m-menu__item-here"></span>
                                            <i class="m-menu__link-icon flaticon-technology"></i>
                                            <span class="m-menu__link-text">دسته محتوا</span>
                                        </a>
                                    </li>
                                    @endpermission
                                </ul>
                            </div>
                        </li>
                @endpermission

                    @permission((config('constants.LIST_EVENTRESULT_ACCESS')))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ route('web.admin.registrationList') }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">پنل لیستها</span>
                        </a>
                    </li>
                    @endpermission

                    @permission((config('constants.WALLET_ADMIN_PANEL')))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ route('web.admin.wallet') }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">پنل کیف پول</span>
                        </a>
                    </li>
                    @endpermission

                    @role((config("constants.ROLE_ADMIN")))
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ route('web.admin.bots') }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text m--font-bold m--font-accent">پنل بات ها</span>
                        </a>
                    </li>
                    @endrole

                    @role((config("constants.ROLE_ADMIN")))
                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">قرعه کشی ها</span>
                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                        </a>
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                                <span class="m-menu__link">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">مدیریت قرعه کشی</span>
                                </span>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\AdminController@adminLottery" , ["lottery"=>"hamyeshDey"]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">قرعه کشی همایش 1+5</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\AdminController@adminLottery" , ["lottery"=>"hamyeshTalai"]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">قرعه کشی همایش طلایی</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\AdminController@adminLottery" , ["lottery"=>"eideFetr"]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">قرعه کشی عید فطر 97</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\AdminController@adminLottery" , ["lottery"=>"eideFetr98"]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">قرعه کشی عید فطر 98</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\AdminController@adminLottery" , ["lottery"=>"konkur98"]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">قرعه کشی کنکور 98</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\AdminController@adminLottery" , ["lottery"=>"summer98"]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">قرعه کشی تابستان 98</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endrole

                    @permission((config('constants.SITE_CONFIG_ADMIN_PANEL_ACCESS')))
                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">پی کربندی سایت</span>
                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                        </a>
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                                <span class="m-menu__link">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">پی کربندی سایت</span>
                                </span>
                                </li>
                                @permission((config('constants.SHOW_SITE_CONFIG_ACCESS')))
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{ route('websiteSetting.show' , $setting) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">تنظیمات سایت</span>
                                    </a>
                                </li>
                                @endpermission
                                @permission((config('constants.SHOW_SITE_FAQ_ACCESS')))
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{route('web.setting.faq.show' , $setting)}}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">سؤالات متداول</span>
                                    </a>
                                </li>
                                @endpermission
                                @permission((config('constants.LIST_SLIDESHOW_ACCESS')))
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{ action("Web\AdminController@adminSlideShow") }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">اسلاید شو</span>
                                    </a>
                                </li>
                                @endpermission

                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{ action("Web\AfterLoginFormController@index") }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">فرم تکمیل ثبت نام</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endpermission

                    @permission((config('constants.PARTICULAR_ADMIN_PANELS')))
                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">پنل های خاص</span>
                            <i class="m-menu__ver-arrow fa fa-angle-left"></i>
                        </a>
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                @ability(config('constants.ROLE_ADMIN'),config('constants.TELEMARKETING_PANEL_ACCESS'))
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{action("Web\AdminController@adminTeleMarketing")}}" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-graphic"></i>
                                        <span class="m-menu__link-text">تله مارکتینگ</span>
                                    </a>
                                </li>
                                @endability
                                @role(config('constants.ROLE_ADMIN'))
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{ action("Web\AdminController@specialAddUser") }}" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text">درج کاربر با سفارش</span>
                                    </a>
                                </li>
                                @endability
                                @permission((config('constants.INSERT_COUPON_ACCESS')))
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{ action("Web\AdminController@adminGenerateRandomCoupon") }}" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text">تولید کپن تصادفی</span>
                                    </a>
                                </li>
                                @endpermission
                            </ul>
                        </div>
                    </li>
                    @endpermission
                @endability

                @permission((config('constants.ALAA_FAMILTY')))
                <li class="m-menu__section ">
                    <h4 class="m-menu__section-text">خانواده آلاء</h4>
                    <i class="m-menu__section-icon flaticon-more-v2"></i>
                </li>
                    @ability(config("constants.EMPLOYEE_ROLE"),config("constants.LIST_EMPLOPYEE_WORK_SHEET"),config("constants.INSERT_EMPLOPYEE_WORK_SHEET"))
                    <li class="m-menu__item  @if(isset($pageName) && strcmp($pageName , "time-staff")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\EmployeetimesheetController@create") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-clock"></i>
                            <span class="m-menu__link-text">ثبت ساعت کار</span>
                        </a>
                    </li>
                    @endability
                    @permission((config("constants.SHOW_SALES_REPORT")))
                    <li class="m-menu__item" aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\SalesReportController") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-clock"></i>
                            <span class="m-menu__link-text">گزارش فروش دبیران</span>
                        </a>
                    </li>
                    @endpermission
                    @permission((config("constants.UPLOAD_CENTER_ACCESS")))
                    <li class="m-menu__item" aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ route('web.uploadCenter') }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-clock"></i>
                            <span class="m-menu__link-text">آپلود سنتر</span>
                        </a>
                    </li>
                    @endpermission
                @endpermission
            @endif
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div><!-- END: Left Aside -->
