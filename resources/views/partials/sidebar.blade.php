<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
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
                <a href="{{ action("Web\IndexPageController") }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-home"></i>
                    <span class="m-menu__link-text">صفحه اصلی</span>
                </a>
            </li>
            <li class="m-menu__item  @if(isset($pageName) && strcmp($pageName , "productsPortfolio")==0) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{ action("Web\ShopPageController") }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-chalkboard-teacher"></i>
                    <span class="m-menu__link-text">محصولات آموزشی</span>
                </a>
            </li>


            <li class="m-menu__item  m-menu__item--submenu @if(isset($pageName) && strcmp($pageName , "content")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-film"></i>
                    <span class="m-menu__link-text">فیلم های آلاء</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">فیلم های آلاء</span>
                            </span>
                        </li>
                        @foreach($sections as $section)
                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                <a href="{{ urldecode(action("Web\ContentController@index" , ["tags" => $section["tags"]])) }}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">{{ $section["displayName"] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            <li class="m-menu__item @if(isset($pageName) && strcmp($pageName , "donate")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">
                <a href="{{ action("Web\DonateController") }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-donate"></i>
                    <span class="m-menu__link-text">کمک مالی به آلاء</span>
                </a>
            </li>
            @if(Auth::check())
                <li class="m-menu__item @if(isset($pageName) && strcmp($pageName , "submitKonkurResult")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">
                    <a href="{{ action("Web\UserController@show",Auth::user()) }}#ثبت_رتبه" class="m-menu__link ">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fa fa-medal"></i>
                        <span class="m-menu__link-text">ثبت رتبه 97</span>
                    </a>
                </li>
            @endif
            <li class="m-menu__item @if(isset($pageName) && strcmp($pageName , "rules")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">
                <a href="{{ action("Web\RulesPageController") }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-gavel"></i>
                    <span class="m-menu__link-text">قوانین</span>
                </a>
            </li>
            <li class="m-menu__item @if(isset($pageName) && strcmp($pageName , "contactUs")==0) m-menu__item--active @endif" aria-haspopup="true" m-menu-link-redirect="1">
                <a href="{{ action("Web\ContactUsController") }}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-phone-volume"></i>
                    <span class="m-menu__link-text">@lang('page.contact us')</span>
                </a>
            </li>
            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                <a target="_blank" href="https://forum.sanatisharif.ir" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fab fa-hornbill"></i>
                    <span class="m-menu__link-text">انجمن آلاء</span>
                </a>
            </li>

            @if(Auth::check())
                @ability(Config::get('constants.ROLE_ADMIN'),Config::get('constants.ADMIN_PANEL_ACCESS'))
                    <li class="m-menu__section ">
                        <h4 class="m-menu__section-text">مدیریت</h4>
                        <i class="m-menu__section-icon flaticon-more-v2"></i>
                    </li>

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
                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                        <a href="{{ action("Web\AdminController@adminSalesReport") }}" class="m-menu__link ">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text"> گزارش فروش</span>
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
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu ">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                        <a href="{{ action("Web\AdminController@adminContent") }}" class="m-menu__link ">
                                            <span class="m-menu__item-here"></span>
                                            <i class="m-menu__link-icon flaticon-technology"></i>
                                            <span class="m-menu__link-text">محتوا</span>
                                        </a>
                                    </li>

                                    @permission((config('constants.LIST_CONTENT_SET_ACCESS')))
                                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                        <a href="{{ action("Web\SetController@index") }}" class="m-menu__link ">
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

{{--                    @permission((config('constants.REPORT_ADMIN_PANEL_ACCESS')))--}}
{{--                    <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">--}}
{{--                        <a href="{{ action("Web\AdminController@adminReport") }}" class="m-menu__link ">--}}
{{--                            <span class="m-menu__item-here"></span>--}}
{{--                            <i class="m-menu__link-icon flaticon-technology"></i>--}}
{{--                            <span class="m-menu__link-text">گزارش</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    @endpermission--}}

                    @role((config("constants.ROLE_ADMIN")))
                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">بات ها</span>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text">بررسی سفارش ها</span>
                                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                                    </a>
                                    <div class="m-menu__submenu ">
                                        <span class="m-menu__arrow"></span>
                                        <ul class="m-menu__subnav">
                                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                                <a target="_blank" href="{{ action("Web\BotsController@bot" , ['checkorderproducts'=>'1' , 'since'=>'2019-07-15' , 'till'=>'2019-07-17'])  }}" class="m-menu__link ">
                                                    <span class="m-menu__item-here"></span>
                                                    <i class="m-menu__link-icon flaticon-technology"></i>
                                                    <span class="m-menu__link-text">پاک شدن آیتم سبد</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                                <a target="_blank"  href="{{ action("Web\BotsController@bot" , ['checkghesdi'=>'1' , 'since'=>'2019-07-15' , 'till'=>'2019-07-17']) }}" class="m-menu__link ">
                                                    <span class="m-menu__item-here"></span>
                                                    <i class="m-menu__link-icon flaticon-technology"></i>
                                                    <span class="m-menu__link-text">قسطی ماندن سفارش</span>
                                                </a>
                                            </li>
                                            <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                                <a target="_blank" href="{{ action("Web\BotsController@bot" , ['checktransactions'=>'1']) }}" class="m-menu__link ">
                                                    <span class="m-menu__item-here"></span>
                                                    <i class="m-menu__link-icon flaticon-technology"></i>
                                                    <span class="m-menu__link-text">ناموفق ماندن تراکنش</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                                <span class="m-menu__link">
                                    <span class="m-menu__item-here"></span>
                                    <span class="m-menu__link-text">بات ها</span>
                                </span>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\BotsController@bot" , ["fixthumbnail"=>"1" , 'set'=>'']) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">تامبنیل ست</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\BotsController@adminBot" , ["bot"=>"wallet"]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">هدیه کیف پول</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{ action("Web\BotsController@adminBot" , ["bot"=>"excel"]) }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">اکسل</span>
                                    </a>
                                </li>
                               {{-- <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a target="_blank" href="{{action("Web\BotsController@bot" , ["voucherbot"=>1])}}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">وچر</span>
                                    </a>
                                </li>--}}
                            </ul>
                        </div>
                    </li>
                    @endrole
                    @role((config("constants.ROLE_ADMIN")))
                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">قرعه کشی ها</span>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
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
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
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
                                    <a href="{{ action("Web\AdminController@adminSiteConfig") }}" class="m-menu__link ">
                                        <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                            <span></span>
                                        </i>
                                        <span class="m-menu__link-text">تنظیمات سایت</span>
                                    </a>
                                </li>
                                @endpermission @permission((config('constants.LIST_SLIDESHOW_ACCESS')))
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

                    @permission((config('constants.SITE_CONFIG_ADMIN_PANEL_ACCESS')))
                    <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:" class="m-menu__link m-menu__toggle">
                            <span class="m-menu__item-here"></span>
                            <i class="m-menu__link-icon flaticon-network"></i>
                            <span class="m-menu__link-text">پنل های خاص</span>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>
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
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{ action("Web\AdminController@specialAddUser") }}" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text">درج کاربر با سفارش</span>
                                    </a>
                                </li>
                                <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1">
                                    <a href="{{ action("Web\AdminController@adminGenerateRandomCoupon") }}" class="m-menu__link ">
                                        <span class="m-menu__item-here"></span>
                                        <i class="m-menu__link-icon flaticon-network"></i>
                                        <span class="m-menu__link-text">تولید کپن تصادفی</span>
                                    </a>
                                </li>
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
                @endpermission
            @endif
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div><!-- END: Left Aside -->
