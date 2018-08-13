<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu @if(isset($sideBarMode) && strcmp($sideBarMode,"closed") == 0) page-sidebar-menu-closed @endif" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item @if(isset($pageName) && strcmp($pageName , "dashboard")==0)start active open @endif">
                <a href="{{action("HomeController@index")}}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">صفحه اصلی</span>
                    @if(isset($pageName) && strcmp($pageName , "dashboard")==0)<span class="selected"></span> @endif
                    <span class="arrow "></span>
                </a>
            </li>
            {{--<li class="nav-item @if(isset($pageName) && strcmp($pageName , "schoolRegisterLanding")==0)start active open @endif">--}}
                {{--<a href="{{action("HomeController@schoolRegisterLanding")}}" class="nav-link nav-toggle font-red bold">--}}
                    {{--<i class="fa fa-pencil" aria-hidden="true"></i>--}}
                    {{--<span class="title">پیش ثبت نام دبیرستان دانشگاه شریف</span>--}}
                    {{--@if(isset($pageName) && strcmp($pageName , "schoolRegisterLanding")==0)<span class="selected"></span> @endif--}}
                    {{--<span class="arrow "></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="nav-item @if(isset($pageName) && strcmp($pageName , "productsPortfolio")==0)start active open @endif">
                <a href="{{action("ProductController@search")}}" class="nav-link nav-toggle font-yellow bold">
                    <i class="icon-basket"></i>
                    <span class="title">همایش های آلاء</span>
                    @if(isset($pageName) && strcmp($pageName , "productsPortfolio")==0)<span class="selected"></span> @endif
                    <span class="arrow "></span>
                </a>
            </li>
            <li class="nav-item @if(isset($pageName) && strcmp($pageName , "educationalContent")==0)start active open @endif nav-toggle">
                <a href="{{action("EducationalContentController@search")}}" class="nav-link nav-toggle font-yellow bold">
                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                    <span class="title">فیلم های آلاء</span>
                    @if(isset($pageName) && strcmp($pageName , "educationalContent")==0)<span class="selected"></span> @endif
                    <span class="arrow "></span>
                    <ul class="sub-menu">
                        @foreach($sections as $section)
                            <li class="nav-item  ">
                                <a href="{{urldecode(action("HomeController@search" , ["tags" => $section["tags"]]))}}" class="nav-link ">
                                    <span class="title">{{$section["displayName"]}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </a>
            </li>
            <li class="nav-item @if(isset($pageName) && strcmp($pageName , "donate")==0)start active open @endif">
                <a href="{{action("HomeController@donate")}}" class="nav-link nav-toggle font-yellow bold">
                    <i class="fa fa-credit-card"></i>
                    <span class="title">کمک مالی به آلاء</span>
                    @if(isset($pageName) && strcmp($pageName , "donate")==0)<span class="selected"></span> @endif
                    <span class="arrow "></span>
                </a>
            </li>
            <li class="nav-item ">
                <a target="_blank" href="https://forum.sanatisharif.ir" class="nav-link nav-toggle bold">
                    <i class="fa fa-comment"></i>
                    <span class="title">انجمن آلاء</span>
                    <span class="arrow "></span>
                </a>
            </li>
            @if(Auth::check())

                {{--<li class="nav-item @if(isset($pageName) && strcmp($pageName , "certificates")==0)start active open @endif">--}}
                    {{--<a href="{{action("HomeController@certificates")}}" class="nav-link nav-toggle">--}}
                        {{--<i class="fa fa-certificate" aria-hidden="true"></i>--}}
                        {{--<span class="title">مجوزها</span>--}}
                        {{--@if(isset($pageName) && strcmp($pageName , "certificates")==0)<span class="selected"></span> @endif--}}
                        {{--<span class="arrow "></span>--}}
                    {{--</a>--}}
                {{--</li>--}}

                @ability(Config::get("constants.EMPLOYEE_ROLE"),Config::get("constants.LIST_EMPLOPYEE_WORK_SHEET"),Config::get("constants.INSERT_EMPLOPYEE_WORK_SHEET"))
                <li class="nav-item  @if(strcmp(url()->current() , action("EmployeetimesheetController@create")) == 0)start active open @endif">
                    <a href="{{action("EmployeetimesheetController@create")}}" class="nav-link ">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <span class="title">ثبت ساعت کار</span>
                        @if(strcmp(url()->current() , action("EmployeetimesheetController@create")) == 0)<span class="selected"></span> @endif
                        <span class="arrow "></span>
                    </a>
                </li>
                @endability
                @ability(Config::get('constants.ROLE_ADMIN'),Config::get('constants.ADMIN_PANEL_ACCESS'))
                <li class="nav-item @if(isset($pageName) && strcmp($pageName , "admin")==0)start active open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-cogs"></i>
                        <span class="title">پنل مدیریتی</span>
                        @if(isset($pageName) && strcmp($pageName , "admin")==0)<span class="selected"></span> @endif
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        @role((Config::get("constants.ROLE_ADMIN")))
                        <li class="nav-item  ">
                            <a href="#" class="nav-link nav-toggle">
                                <span class="title">بات</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminBot" , ["bot"=>"wallet"])}}" class="nav-link ">
                                        <span class="title">هدیه کیف پول</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminBot" , ["bot"=>"excel"])}}" class="nav-link ">
                                        <span class="title">اکسل</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a target="_blank" href="{{action("HomeController@bot" , ["voucherbot"=>1])}}" class="nav-link ">
                                        <span class="title">وچر</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                        @ability(Config::get('constants.ROLE_ADMIN'),Config::get('constants.TELEMARKETING_PANEL_ACCESS'))
                        <li class="nav-item  ">
                            <a href="{{action("HomeController@adminTeleMarketing")}}" class="nav-link ">
                                <span class="title">تله مارکتینگ</span>
                            </a>
                        </li>
                        @endability
                        @role((Config::get("constants.ROLE_ADMIN")))
                        <li class="nav-item  ">
                            <a href="#" class="nav-link nav-toggle">
                                <span class="title">مدیریت قرعه کشی</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminLottery" , ["lottery"=>"hamyeshDey"])}}" class="nav-link ">
                                        <span class="title">قرعه کشی همایش 1+5</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminLottery" , ["lottery"=>"hamyeshTalai"])}}" class="nav-link ">
                                        <span class="title">قرعه کشی همایش طلایی</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminLottery" , ["lottery"=>"eideFetr"])}}" class="nav-link ">
                                        <span class="title">قرعه کشی عید فطر</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                        @permission((Config::get('constants.INSERT_MAJOR')))
                        <li class="nav-item  ">
                            <a href="#" class="nav-link nav-toggle">
                                <span class="title">درج رشته</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminMajor" , ["parent"=>"ریاضی"])}}" class="nav-link ">
                                        <span class="title">ریاضی</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminMajor" , ["parent"=>"تجربی"])}}" class="nav-link ">
                                        <span class="title">تجربی</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminMajor" , ["parent"=>"انسانی"])}}" class="nav-link ">
                                        <span class="title">انسانی</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminMajor" , ["parent"=>"هنر"])}}" class="nav-link ">
                                        <span class="title">هنر</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{action("HomeController@adminMajor" , ["parent"=>"زبان"])}}" class="nav-link ">
                                        <span class="title">زبان</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.SITE_CONFIG_ADMIN_PANEL_ACCESS')))
                        <li class="nav-item  ">
                            <a href="#" class="nav-link  nav-toggle">
                                <i class="fa fa-cogs"></i>
                                <span class="title">پیکربندی سایت</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                @permission((Config::get('constants.SHOW_SITE_CONFIG_ACCESS')))
                                <li class="nav-item  ">
                                    <a href="{{action("HomeController@adminSiteConfig")}}" class="nav-link ">
                                        <span class="title">تنظیمات سایت</span>
                                    </a>
                                </li>
                                @endpermission
                                @permission((Config::get('constants.LIST_SLIDESHOW_ACCESS')))
                                <li class="nav-item  ">
                                    <a href="{{action("HomeController@adminSlideShow")}}" class="nav-link ">
                                        <span class="title">اسلاید شو صفحه اصلی</span>
                                    </a>
                                </li>
                                @endpermission
                                {{--@permission((Config::get('constants.LIST_SLIDESHOW_ACCESS')))--}}
                                {{--<li class="nav-item  ">--}}
                                    {{--<a href="{{action("HomeController@adminArticleSlideShow")}}" class="nav-link ">--}}
                                        {{--<span class="title">اسلاید شو صفحه مقالات</span>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--@endpermission--}}
                                <li class="nav-item  ">
                                    <a href="{{action("AfterLoginFormController@index")}}" class="nav-link ">
                                        <span class="title">فرم تکمیل ثبت نام</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endpermission
                        @ability(Config::get('constants.ROLE_ADMIN'),Config::get('constants.USER_ADMIN_PANEL_ACCESS'))
                        <li class="nav-item  ">
                            <a href="{{action("HomeController@admin")}}" class="nav-link ">
                                <span class="title">مدیریت کاربران</span>
                            </a>
                        </li>
                        <li class="nav-item  ">
                            <a href="{{action("HomeController@specialAddUser")}}" class="nav-link ">
                                <span class="title">درج کاربر با سفارش</span>
                            </a>
                        </li>
                        @endability
                        @permission((Config::get('constants.ORDER_ADMIN_PANEL_ACCESS')))
                        <li class="nav-item  ">
                            <a href="{{action("HomeController@adminOrder")}}" class="nav-link ">
                                <span class="title">مدیریت سفارش ها</span>
                            </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.PRODUCT_ADMIN_PANEL_ACCESS')))
                        <li class="nav-item  ">
                            <a href="{{action("HomeController@adminProduct")}}" class="nav-link ">
                                <span class="title">مدیریت محصولات</span>
                            </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.CONTENT_ADMIN_PANEL_ACCESS')))
                        <li class="nav-item  ">
                            <a href="{{action("HomeController@adminContent")}}" class="nav-link ">
                                <span class="title">مدیریت محتوا</span>
                            </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.SMS_ADMIN_PANEL_ACCESS')))
                        <li class="nav-item  ">
                            <a href="{{action("HomeController@adminSMS")}}" class="nav-link ">
                                <span class="title">ارسال پیامک</span>
                            </a>
                        </li>
                        @endpermission
                        @permission((Config::get('constants.REPORT_ADMIN_PANEL_ACCESS')))
                        <li class="nav-item  ">
                            <a href="{{action("HomeController@adminReport")}}" class="nav-link ">
                                <span class="title">گزارش</span>
                            </a>
                        </li>
                        @endability
                    </ul>
                </li>
                @endability
                @permission((Config::get('constants.CONSULTANT_PANEL_ACCESS')))
                <li class="nav-item @if(isset($pageName) && strcmp($pageName , "consultantAdmin")==0)start active open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-cogs"></i>
                        <span class="title">پنل مشاور</span>
                        @if(isset($pageName) && strcmp($pageName , "consultantAdmin")==0)<span class="selected"></span> @endif
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{action("HomeController@consultantAdmin")}}" class="nav-link ">
                                <span class="title">سوال مشاوره ای</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{action("HomeController@consultantEntekhabReshteList")}}" class="nav-link ">
                                <span class="title">انتخاب رشته</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endpermission


                @if(!Auth::user()->hasRole(Config::get('constants.ROLE_CONSULTANT')))
                    <li class="nav-item @if(isset($pageName) && strcmp($pageName , "ConsultingQuestion")==0)start active open @endif">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            {{--<i class="icon-question"></i>--}}
                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                            <span class="title">سؤال مشاوره ای</span>
                            @if(isset($pageName) && strcmp($pageName , "ConsultingQuestion")==0)<span class="selected"></span> @endif
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item  ">
                                <a href="{{action("UserController@uploadConsultingQuestion")}}" class="nav-link ">
                                    <span class="title">آپلود سؤال</span>
                                </a>
                            </li>
                            @if(Auth::user()->completion() == 100)
                                <li class="nav-item  ">
                                    <a href="{{action("UserController@uploads")}}" class="nav-link ">
                                        <span class="title">سؤالهای مشاوره ای من</span>
                                    </a>
                                </li>
                            @endif
                        </ul>

                    </li>
                @endif
            @endif

            {{--<li class="nav-item @if(isset($pageName) && strcmp($pageName , "articles")==0)start active open @endif">--}}
                {{--<a href="{{action("ArticleController@showList")}}" class="nav-link nav-toggle">--}}
                    {{--<i class="fa fa-book" aria-hidden="true"></i>--}}
                    {{--<span class="title">مقالات و مطالب علمی</span>--}}
                    {{--@if(isset($pageName) && strcmp($pageName , "articles")==0)<span class="selected"></span> @endif--}}
                    {{--<span class="arrow "></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item @if(isset($pageName) && strcmp($pageName , "articles")==0)start active open @endif">--}}
            {{--<a href="{{action("ArticleController@showList")}}" class="nav-link nav-toggle">--}}
            {{--<i class="fa fa-book" aria-hidden="true"></i>--}}
            {{--<span class="title">مقالات</span>--}}
            {{--@if(isset($pageName) && strcmp($pageName , "articles")==0)<span class="selected"></span> @endif--}}
            {{--<span class="arrow "></span>--}}
            {{--</a>--}}
            {{--</li>--}}

            {{--<li class="nav-item @if(isset($pageName) && strcmp($pageName , "aboutUs")==0)start active open @endif">--}}
                {{--<a href="{{action("HomeController@aboutUs")}}" class="nav-link nav-toggle">--}}
                    {{--<i class="icon-info"></i>--}}
                    {{--<i class="icon-info"></i>--}}
                    {{--<i class="fa fa-info-circle" aria-hidden="true"></i>--}}
                    {{--<span class="title">درباره ما</span>--}}
                    {{--@if(isset($pageName) && strcmp($pageName , "aboutUs")==0)<span class="selected"></span> @endif--}}
                    {{--<span class="arrow "></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="nav-item @if(isset($pageName) && strcmp($pageName , "contactUs")==0)start active open @endif">
                <a href="{{action("HomeController@contactUs")}}" class="nav-link nav-toggle">
                    <i class="icon-call-end"></i>
                    <span class="title">تماس با ما</span>
                    @if(isset($pageName) && strcmp($pageName , "contactUs")==0)<span class="selected"></span> @endif
                    <span class="arrow "></span>
                </a>
            </li>
            @if(Auth::check())
                <li class="nav-item @if(isset($pageName) && strcmp($pageName , "submitKonkurResult")==0)start active open @endif">
                    <a href="{{action("HomeController@submitKonkurResult")}}" class="nav-link nav-toggle  bold">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        <span class="title">ثبت رتبه 97</span>
                        @if(isset($pageName) && strcmp($pageName , "submitKonkurResult")==0)<span class="selected"></span> @endif
                        <span class="arrow "></span>
                    </a>
                </li>
            @endif
            <li class="nav-item @if(isset($pageName) && strcmp($pageName , "rules")==0)start active open @endif">
                <a href="{{action("HomeController@rules")}}" class="nav-link nav-toggle">
                    <i class="fa fa-server" aria-hidden="true"></i>
                    <span class="title">قوانین و مقررات</span>
                    @if(isset($pageName) && strcmp($pageName , "rules")==0)<span class="selected"></span> @endif
                    <span class="arrow "></span>
                </a>
            </li>
            {{--<li class="nav-item @if(isset($pageName) && strcmp($pageName , "siteMap")==0)start active open @endif">--}}
                {{--<a href="{{action("HomeController@siteMap")}}" class="nav-link nav-toggle">--}}
                    {{--<i class="fa fa-sitemap" aria-hidden="true"></i>--}}
                    {{--<span class="title">نقشه سایت</span>--}}
                    {{--@if(isset($pageName) && strcmp($pageName , "siteMap")==0)<span class="selected"></span> @endif--}}
                    {{--<span class="arrow "></span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item @if(isset($pageName) && strcmp($pageName , "rules")==0)start active open @endif">--}}
            {{--<a href="{{action("HomeController@rules")}}" class="nav-link nav-toggle">--}}
            {{--<i class="fa fa-server" aria-hidden="true"></i>--}}
            {{--<span class="title">قوانین و مقررات</span>--}}
            {{--@if(isset($pageName) && strcmp($pageName , "rules")==0)<span class="selected"></span> @endif--}}
            {{--<span class="arrow "></span>--}}
            {{--</a>--}}
            {{--</li>--}}
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
