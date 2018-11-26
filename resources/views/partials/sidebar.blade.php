<!-- BEGIN: Left Aside -->
<button class = "m-aside-left-close  m-aside-left-close--skin-dark " id = "m_aside_left_close_btn">
    <i class = "la la-close"></i>
</button>
<div id = "m_aside_left" class = "m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id = "m_ver_menu" class = "m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical = "1" m-menu-scrollable = "1" m-menu-dropdown-timeout = "500">
        <ul class = "m-menu__nav ">
            <li class = "m-menu__section m-menu__section--first">
                <h4 class = "m-menu__section-text">خدمات آلاء</h4>
                <i class = "m-menu__section-icon flaticon-more-v2"></i>
            </li>
            <li class = "m-menu__item  @if(isset($pageName) && strcmp($pageName , "dashboard")==0) m-menu__item--active @endif" aria-haspopup = "true">
                <a href = "{{ action("HomeController@index") }}" class = "m-menu__link ">
                    <span class = "m-menu__item-here"></span>
                    <i class = "m-menu__link-icon flaticon-line-graph"></i>
                    <span class = "m-menu__link-text">صفحه اصلی</span>
                </a>
            </li>
            <li class = "m-menu__item  @if(isset($pageName) && strcmp($pageName , "productsPortfolio")==0) m-menu__item--active @endif" aria-haspopup = "true">
                <a href = "{{ action("ProductController@search") }}" class = "m-menu__link ">
                    <span class = "m-menu__item-here"></span>
                    <i class = "m-menu__link-icon flaticon-shopping-basket"></i>
                    <span class = "m-menu__link-text">محصولات آموزشی</span>
                </a>
            </li>


            <li class = "m-menu__item  m-menu__item--submenu @if(isset($pageName) && strcmp($pageName , "content")==0) m-menu__item--active @endif"  aria-haspopup = "true" m-menu-submenu-toggle = "hover">
                <a href = "javascript:" class = "m-menu__link m-menu__toggle">
                    <span class = "m-menu__item-here"></span>
                    <i class = "m-menu__link-icon fa fa-video"></i>
                    <span class = "m-menu__link-text">فیلم های آلاء</span>
                    <i class = "m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class = "m-menu__submenu ">
                    <span class = "m-menu__arrow"></span>
                    <ul class = "m-menu__subnav">
                        <li class = "m-menu__item  m-menu__item--parent" aria-haspopup = "true">
                            <span class = "m-menu__link">
                                <span class = "m-menu__item-here"></span>
                                <span class = "m-menu__link-text">فیلم های آلاء</span>
                            </span>
                        </li>
                        @foreach($sections as $section)
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a href = "{{ urldecode(action("ContentController@index" , ["tags" => $section["tags"]])) }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">{{ $section["displayName"] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            <li class = "m-menu__item @if(isset($pageName) && strcmp($pageName , "donate")==0) m-menu__item--active @endif" aria-haspopup = "true" m-menu-link-redirect = "1">
                <a href = "{{ action("HomeController@donate") }}" class = "m-menu__link ">
                    <span class = "m-menu__item-here"></span>
                    <i class = "m-menu__link-icon flaticon-suitcase"></i>
                    <span class = "m-menu__link-text">کمک مالی به آلاء</span>
                </a>
            </li>
            @if(Auth::check())
            <li class = "m-menu__item @if(isset($pageName) && strcmp($pageName , "submitKonkurResult")==0) m-menu__item--active @endif" aria-haspopup = "true" m-menu-link-redirect = "1">
                <a href = "{{ action("HomeController@submitKonkurResult") }}" class = "m-menu__link ">
                    <span class = "m-menu__item-here"></span>
                    <i class = "m-menu__link-icon fa fa-graduation-cap"></i>
                    <span class = "m-menu__link-text">ثبت رتبه 97</span>
                </a>
            </li>
            @endif
            <li class = "m-menu__item @if(isset($pageName) && strcmp($pageName , "rules")==0) m-menu__item--active @endif" aria-haspopup = "true" m-menu-link-redirect = "1">
                <a href = "{{ action("HomeController@rules") }}" class = "m-menu__link ">
                    <span class = "m-menu__item-here"></span>
                    <i class = "m-menu__link-icon flaticon-warning-sign"></i>
                    <span class = "m-menu__link-text">قوانین</span>
                </a>
            </li>
            <li class = "m-menu__item @if(isset($pageName) && strcmp($pageName , "contactUs")==0) m-menu__item--active @endif" aria-haspopup = "true" m-menu-link-redirect = "1">
                <a href = "{{ action("HomeController@contactUs") }}" class = "m-menu__link ">
                    <span class = "m-menu__item-here"></span>
                    <i class = "m-menu__link-icon flaticon-support"></i>
                    <span class = "m-menu__link-text">@lang('page.contact us')</span>
                </a>
            </li>
            <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                <a  target="_blank" href = "https://forum.sanatisharif.ir" class = "m-menu__link ">
                    <span class = "m-menu__item-here"></span>
                    <i class = "m-menu__link-icon flaticon-share"></i>
                    <span class = "m-menu__link-text">انجمن آلاء</span>
                </a>
            </li>

            @if(Auth::check())
                <li class = "m-menu__section ">
                    <h4 class = "m-menu__section-text">مدیریت</h4>
                    <i class = "m-menu__section-icon flaticon-more-v2"></i>
                </li>

                @role((Config::get("constants.ROLE_ADMIN")))
                <li class = "m-menu__item  m-menu__item--submenu"  aria-haspopup = "true" m-menu-submenu-toggle = "hover">
                    <a href = "javascript:" class = "m-menu__link m-menu__toggle">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-network"></i>
                        <span class = "m-menu__link-text">عملیات دسته جمعی</span>
                        <i class = "m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class = "m-menu__submenu ">
                        <span class = "m-menu__arrow"></span>
                        <ul class = "m-menu__subnav">
                            <li class = "m-menu__item  m-menu__item--parent" aria-haspopup = "true">
                            <span class = "m-menu__link">
                                <span class = "m-menu__item-here"></span>
                                <span class = "m-menu__link-text">عملیات دسته جمعی</span>
                            </span>
                            </li>
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a  target="_blank" href = "{{ action("HomeController@adminBot" , ["bot"=>"wallet"]) }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">هدیه کیف پول</span>
                                </a>
                            </li>
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a  target="_blank" href = "{{ action("HomeController@adminBot" , ["bot"=>"excel"]) }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">اکسل</span>
                                </a>
                            </li>
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a  target="_blank" href = "{{action("HomeController@bot" , ["voucherbot"=>1])}}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">وچر</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endrole

                @ability(Config::get('constants.ROLE_ADMIN'),Config::get('constants.TELEMARKETING_PANEL_ACCESS'))
                <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{action("HomeController@adminTeleMarketing")}}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-graphic"></i>
                        <span class = "m-menu__link-text">تله مارکتینگ</span>
                    </a>
                </li>
                @endability

                @role((Config::get("constants.ROLE_ADMIN")))
                <li class = "m-menu__item  m-menu__item--submenu"  aria-haspopup = "true" m-menu-submenu-toggle = "hover">
                    <a href = "javascript:" class = "m-menu__link m-menu__toggle">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-network"></i>
                        <span class = "m-menu__link-text">مدیریت قرعه کشی</span>
                        <i class = "m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class = "m-menu__submenu ">
                        <span class = "m-menu__arrow"></span>
                        <ul class = "m-menu__subnav">
                            <li class = "m-menu__item  m-menu__item--parent" aria-haspopup = "true">
                            <span class = "m-menu__link">
                                <span class = "m-menu__item-here"></span>
                                <span class = "m-menu__link-text">مدیریت قرعه کشی</span>
                            </span>
                            </li>
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a  target="_blank" href = "{{ action("HomeController@adminLottery" , ["lottery"=>"hamyeshDey"]) }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">قرعه کشی همایش 1+5</span>
                                </a>
                            </li>
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a  target="_blank" href = "{{ action("HomeController@adminLottery" , ["lottery"=>"hamyeshTalai"]) }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">قرعه کشی همایش طلایی</span>
                                </a>
                            </li>
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a  target="_blank" href = "{{ action("HomeController@adminLottery" , ["lottery"=>"eideFetr"]) }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">قرعه کشی عید فطر</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endrole
                @permission((Config::get('constants.SITE_CONFIG_ADMIN_PANEL_ACCESS')))
                <li class = "m-menu__item  m-menu__item--submenu"  aria-haspopup = "true" m-menu-submenu-toggle = "hover">
                    <a href = "javascript:" class = "m-menu__link m-menu__toggle">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-network"></i>
                        <span class = "m-menu__link-text">پی کربندی سایت</span>
                        <i class = "m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class = "m-menu__submenu ">
                        <span class = "m-menu__arrow"></span>
                        <ul class = "m-menu__subnav">
                            <li class = "m-menu__item  m-menu__item--parent" aria-haspopup = "true">
                            <span class = "m-menu__link">
                                <span class = "m-menu__item-here"></span>
                                <span class = "m-menu__link-text">پی کربندی سایت</span>
                            </span>
                            </li>
                            @permission((Config::get('constants.SHOW_SITE_CONFIG_ACCESS')))
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a href = "{{ action("HomeController@adminSiteConfig") }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">تنظیمات سایت</span>
                                </a>
                            </li>
                            @endpermission
                            @permission((Config::get('constants.LIST_SLIDESHOW_ACCESS')))
                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a href = "{{ action("HomeController@adminSlideShow") }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">اسلاید شو صفحه اصلی</span>
                                </a>
                            </li>
                            @endpermission

                            <li class = "m-menu__item " aria-haspopup = "true"  m-menu-link-redirect = "1">
                                <a href = "{{ action("AfterLoginFormController@index") }}" class = "m-menu__link ">
                                    <i class = "m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class = "m-menu__link-text">فرم تکمیل ثبت نام</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endpermission

                @ability(Config::get('constants.ROLE_ADMIN'),Config::get('constants.USER_ADMIN_PANEL_ACCESS'))
                <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{ action("HomeController@admin") }}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-network"></i>
                        <span class = "m-menu__link-text">کاربران</span>
                    </a>
                </li>
                <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{ action("HomeController@specialAddUser") }}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-network"></i>
                        <span class = "m-menu__link-text">درج کاربر با سفارش</span>
                    </a>
                </li>
                @endability
                @permission((Config::get('constants.ORDER_ADMIN_PANEL_ACCESS')))
                <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{ action("HomeController@adminOrder") }}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-network"></i>
                        <span class = "m-menu__link-text"> سفارش ها</span>
                    </a>
                </li>
                @endpermission

                @permission((Config::get('constants.PRODUCT_ADMIN_PANEL_ACCESS')))
                <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{ action("HomeController@adminProduct") }}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-technology"></i>
                        <span class = "m-menu__link-text">محصولات</span>
                    </a>
                </li>
                @endpermission

                @permission((Config::get('constants.CONTENT_ADMIN_PANEL_ACCESS')))
                <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{ action("HomeController@adminContent") }}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-technology"></i>
                        <span class = "m-menu__link-text">محتوا</span>
                    </a>
                </li>
                @endpermission

                @permission((Config::get('constants.SMS_ADMIN_PANEL_ACCESS')))
                <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{ action("HomeController@adminSMS") }}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-technology"></i>
                        <span class = "m-menu__link-text">ارسال پیامک</span>
                    </a>
                </li>
                @endpermission

                @permission((Config::get('constants.REPORT_ADMIN_PANEL_ACCESS')))
                <li class = "m-menu__item " aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{ action("HomeController@adminReport") }}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-technology"></i>
                        <span class = "m-menu__link-text">گزارش</span>
                    </a>
                </li>
                @endpermission

                @ability(Config::get("constants.EMPLOYEE_ROLE"),Config::get("constants.LIST_EMPLOPYEE_WORK_SHEET"),Config::get("constants.INSERT_EMPLOPYEE_WORK_SHEET"))
                <li class = "m-menu__section ">
                    <h4 class = "m-menu__section-text">خانواده آلاء</h4>
                    <i class = "m-menu__section-icon flaticon-more-v2"></i>
                </li>


                <li class = "m-menu__item  @if(isset($pageName) && strcmp($pageName , "time-staff")==0) m-menu__item--active @endif" aria-haspopup = "true" m-menu-link-redirect = "1">
                    <a href = "{{ action("EmployeetimesheetController@create") }}" class = "m-menu__link ">
                        <span class = "m-menu__item-here"></span>
                        <i class = "m-menu__link-icon flaticon-clock"></i>
                        <span class = "m-menu__link-text">ثبت ساعت کار</span>
                    </a>
                </li>
                @endability
            @endif
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->
