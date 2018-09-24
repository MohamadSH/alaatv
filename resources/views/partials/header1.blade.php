<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">

            <a href="{{action("HomeController@index")}}">
                <img @if(isset($wSetting->site->siteLogo))src="{{route('image', ['category'=>'11','w'=>'135' , 'h'=>'67' ,  'filename' =>  $wSetting->site->siteLogo ])}}" @endif alt="لوگو سایت" class="logo-default img-responsive" style="width: 100%" /> </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <div class="page-actions">
            <div class="btn-group">
                <a target="_blank" href="{{isset($wSetting->socialNetwork->telegram->channel->link) ? $wSetting->socialNetwork->telegram->channel->link : ""}}" class="btn btn-circle btn-outline blue dropdown-toggle" >
                    <i class="fa fa-telegram fa-lg" aria-hidden="true"></i>&nbsp;
                    <span >کانال تلگرام</span>
                    {{--<i class="fa fa-angle-down"></i>--}}
                </a>
            </div>
            {{--<div class="btn-group" style="margin-top: 10%;">--}}
                {{--<a target="_blank" href="{{isset($wSetting->socialNetwork->telegram->channel->link) ? $wSetting->socialNetwork->telegram->channel->link : ""}}"  >--}}
                    {{--<i class="fa fa-telegram dropdown-toggle" aria-hidden="true" style="font-size: 30px" ></i>--}}
                {{--</a>--}}
                {{--<a target="_blank" href="{{isset($wSetting->socialNetwork->instagram->page->link) ? $wSetting->socialNetwork->instagram->page->link: ""}}"  >--}}
                    {{--<i class="fa fa-instagram fa-lg dropdown-toggle" aria-hidden="true" style="font-size: 35px"></i>--}}
                {{--</a>--}}
            {{--</div>--}}
        </div>
        <!-- DOC: Remove "hide" class to enable the page header actions -->
        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN HEADER SEARCH BOX -->
            <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
            <form class="search-form search-form-expanded" action="{{ action("ContentController@index") }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="جستجو ..." name="search">
                    <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                </div>
            </form>
            <!-- END HEADER SEARCH BOX -->
            {{--<div class="col-md-2 col-md-offset-1" style="margin-top: 0.5%;">--}}
                {{--<a href="#" ><img style="width: 45px;height: 45px;" src="/assets/extra/namad.jpg" alt="نماد اعتماد الکترونیکی" onclick='window.open("https://trustseal.enamad.ir/Verify.aspx?id=58663&p=yncraqgwhwmbhwmbfuix", "Popup","toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30")' height="60" width="60"></a>--}}
                {{--<a href="#" ><img style="width: 45px;height: 45px;" src="/assets/extra/samandehi.png" alt="ستاد ساماندهی" onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=75951&p=jyoedshwpfvldshwrfth", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' height="60" width="60"></a>--}}
                {{--<img style="width: 45px;height: 45px;" src="/assets/extra/asnaf.jpg" alt="اتاق اصناف"  height="45" width="45">--}}
            {{--</div>--}}
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    @if(Auth::check())
                        @if(isset($bonName))
                            <li class="dropdown dropdown-extended dropdown-notification">
                                <a href="javascript:;" class="dropdown-toggle" >
                                    <span > {{$bonName}} </span>
                                    <span class="badge badge-default"> {{Auth::user()->userHasBon(Config::get("constants.BON1"))}} </span>
                                </a>
                                <ul class="dropdown-menu">
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown dropdown-extended dropdown-notification">
                            <a href="javascript:;" class="dropdown-toggle" >
                                <span >کیف پول</span>
                                <span class="badge badge-default"> {{number_format(Auth::user()->getTotalWalletBalance())}} تومان </span>
                            </a>
                            <ul class="dropdown-menu">
                            </ul>
                        </li>
                        <li class="dropdown dropdown-extended dropdown-notification" >
                            <a href="{{action("OrderController@checkoutReview")}}" class="dropdown-toggle" >
                                <i class="icon-basket"></i>
                                @if(!Auth::user()->orders->where("orderstatus_id" , 1)->isEmpty())
                                    <span class="badge badge-default">
                                        {{Auth::user()->orders->where("orderstatus_id" , Config::get("constants.ORDER_STATUS_OPEN"))->first()->orderproducts->count()}}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                            </ul>
                        </li>

                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                @if(isset(Auth::user()->photo) && strlen(Auth::user()->photo)>0)
                                    <img alt="عکس پروفایل" class="img-circle"  src="{{ route('image', ['category'=>'1','w'=>'39' , 'h'=>'39' ,  'filename' =>  Auth::user()->photo ]) }}" />
                                @endif
                                <span class="username username-hide-on-mobile">@if(!isset(Auth::user()->firstName) && !isset(Auth::user()->lastName)) کاربر ناشناس @else @if(isset(Auth::user()->firstName)) {{Auth::user()->firstName }} @endif @if(isset(Auth::user()->lastName)){{Auth::user()->lastName}} @endif @endif</span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{ action("UserController@show",Auth::user())  }}">
                                        <i class="icon-user"></i> پروفایل </a>
                                </li>
                                <li>
                                    <a href="{{ action("UserController@userProductFiles")  }}">
                                        <i class="fa fa-cloud-download "></i> فیلم ها و جزوه های من </a>
                                </li>
                                <li>
                                    <a href="{{ action("UserController@userOrders")  }}">
                                        <i class="fa fa-list-alt "></i>سفارشهای من </a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        <i class="icon-key"></i> خروج
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="dropdown dropdown-user">
                            <a href="{{route("login")}}" class="dropdown-toggle" >
                                <span class="username font-blue">ورود / ثبت نام</span>
                            </a>
                        </li>
                    @endif
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    {{--<li class="dropdown dropdown-extended quick-sidebar-toggler">--}}
                        {{--<span class="sr-only">Toggle Quick Sidebar</span>--}}
                        {{--<i class="icon-logout"></i>--}}
                    {{--</li>--}}
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->