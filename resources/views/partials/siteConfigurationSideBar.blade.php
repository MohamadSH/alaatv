<style>
    .m-nav .m-nav__item.m-nav__item--active > .m-nav__link .m-nav__link-arrow, .m-nav .m-nav__item.m-nav__item--active > .m-nav__link .m-nav__link-icon, .m-nav .m-nav__item.m-nav__item--active > .m-nav__link .m-nav__link-text, .m-nav .m-nav__item:hover:not(.m-nav__item--disabled) > .m-nav__link .m-nav__link-arrow, .m-nav .m-nav__item:hover:not(.m-nav__item--disabled) > .m-nav__link .m-nav__link-icon, .m-nav .m-nav__item:hover:not(.m-nav__item--disabled) > .m-nav__link .m-nav__link-text {
        color: #ff9a17;
    }
</style>
<div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
    <div class = "m-portlet__head">
        <div class = "m-portlet__head-caption">
            <div class = "m-portlet__head-title">
                <h3 class = "m-portlet__head-text">
                    منو پیکر بندی
                </h3>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">

        <ul class="m-nav m-nav--inline">
            @permission((config('constants.SHOW_SITE_CONFIG_ACCESS')))
            <li class="m-nav__item @if(strcmp($section , "websiteSetting") == 0) m-nav__item--active @endif">
                <a href="{{route('websiteSetting.show' , $setting)}}" class="m-nav__link">
                    <i class="m-nav__link-icon fa fa-cogs"></i>
                    <span class="m-nav__link-text">
                        تنظیمات سایت
                    </span>
                </a>
            </li>
            @endpermission
            @permission((config('constants.SHOW_SITE_FAQ_ACCESS')))
            <li class="m-nav__item @if(strcmp($section , "faq") == 0) m-nav__item--active @endif">
                <a href="{{route('web.setting.faq.show' , $setting)}}" class="m-nav__link">
                    <i class="m-nav__link-icon fa fa-question"></i>
                    <span class="m-nav__link-text">
                        سؤالات متداول
                    </span>
                </a>
            </li>
            @endpermission

            @permission((config('constants.LIST_SLIDESHOW_ACCESS')))

            <li class="m-nav__item
                        {{--m-nav__item--disabled--}}@if(strcmp($section , "slideShow") == 0) m-nav__item--active @endif">
                <a href="{{action("Web\AdminController@adminSlideShow")}}" class="m-nav__link">
                    <i class="m-nav__link-icon fa fa-image"></i>
                    <span class="m-nav__link-text">
                        اسلاید شو صفحه اصلی
                    </span>
                </a>
            </li>
            @endpermission

            {{--@permission((config('constants.LIST_SLIDESHOW_ACCESS')))--}}
            {{--<li @if(strcmp($section , "articleSlideShow") == 0) class="active" @endif >--}}
            {{--<a href="{{action("Web\AdminController@adminArticleSlideShow")}}">--}}
            {{--<i class="fa fa-picture-o" aria-hidden="true"></i> اسلاید شو صفحه مقالات </a>--}}
            {{--</li>--}}
            {{--@endpermission--}}

            <li class = "m-nav__item @if(strcmp($section , "afterLoginForm") == 0) m-nav__item--active @endif">
                <a href = "{{action("Web\AfterLoginFormController@index")}}" class = "m-nav__link">
                    <i class = "m-nav__link-icon flaticon-browser"></i>
                    <span class = "m-nav__link-text">
                        فرم تکمیل ثبت نام
                    </span>
                </a>
            </li>
        </ul>

    </div>
</div>


{{--<div class="portlet light profile-sidebar-portlet ">--}}{{--<!-- SIDEBAR USERPIC -->--}}{{--<div class="profile-userpic"></div>--}}{{--<!-- END SIDEBAR USERPIC -->--}}{{--<!-- SIDEBAR USER TITLE -->--}}{{--<div class="profile-usertitle">--}}{{--<div class="profile-usertitle-name bold">منو پیکر بندی</div>--}}{{--</div>--}}{{--<!-- END SIDEBAR USER TITLE -->--}}{{--<!-- SIDEBAR BUTTONS -->--}}{{--<div class="profile-userbuttons">--}}{{--{!! Form::open(['files'=>true,'method' => 'PUT' , 'action' => ['WebsiteSettingController@update', $setting]])  !!}--}}{{--<div class="list-group">--}}{{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}{{--<div class="profile-userpic">--}}{{--<div class="fileinput-new">--}}{{--<img src="{{isset($wSetting->site->logo) && strlen($wSetting->site->logo) > 0  ? route('image', ['category'=>'11','w'=>'140' , 'h'=>'140' ,  'filename' =>  $wSetting->site->logo ]) : "../assets/pages/media/works/img1.jpg"}}" class="img-responsive" alt="لوگو سایت" />--}}{{--</div>--}}{{--<div class="fileinput-preview fileinput-exists"> </div>--}}{{--</div>--}}{{--<br>--}}{{--<div>--}}{{--<span class="btn-file">--}}{{--<span class="fileinput-new btn btn-success"><i class="fa fa-plus"></i>انتخاب عکس</span>--}}{{--<span class="fileinput-exists btn"> تغییر </span>--}}{{--<input type="file" name="siteLogo"> </span>--}}{{--<a href="javascript:;" class="btn red fileinput-exists" id="siteLogo-remove" data-dismiss="fileinput"> حذف </a>--}}{{--</div>--}}{{--<div class="clearfix margin-top-10">--}}{{--<span class="m-badge m-badge--wide m-badge--danger">توجه</span> فرمت های مجاز: jpg , png - حداکثر حجم مجاز: ۲۰۰KB </div>--}}{{--</div>--}}{{--<br>--}}{{--<br>--}}{{--{!! Form::submit("آپلود" , ['class' => 'btn  blue btn-sm']) !!}--}}{{--</div>--}}{{--{!! Form::close() !!}--}}{{--</div>--}}{{--<!-- END SIDEBAR BUTTONS -->--}}{{--<!-- SIDEBAR MENU -->--}}{{--<div class="profile-usermenu">--}}{{--<ul class="nav">--}}{{--@permission((config('constants.SHOW_SITE_CONFIG_ACCESS')))--}}{{--<li @if(strcmp($section , "websiteSetting") == 0) class="active" @endif >--}}{{--<a href = "{{route('websiteSetting.show' , $setting)}}">--}}{{--<i class="icon-settings"></i> تنظیمات سایت </a>--}}{{--</li>--}}{{--@endpermission--}}{{--@permission((config('constants.LIST_SLIDESHOW_ACCESS')))--}}{{--<li @if(strcmp($section , "slideShow") == 0) class="active" @endif >--}}{{--<a href = "{{action("Web\AdminController@adminSlideShow")}}">--}}{{--<i class="fa fa-picture-o" aria-hidden="true"></i> اسلاید شو صفحه اصلی </a>--}}{{--</li>--}}{{--@endpermission--}}{{--@permission((config('constants.LIST_SLIDESHOW_ACCESS')))--}}{{--<li @if(strcmp($section , "articleSlideShow") == 0) class="active" @endif >--}}{{--<a href="{{action("Web\AdminController@adminArticleSlideShow")}}">--}}{{--<i class="fa fa-picture-o" aria-hidden="true"></i> اسلاید شو صفحه مقالات </a>--}}{{--</li>--}}{{--@endpermission--}}{{--<li @if(strcmp($section , "afterLoginForm") == 0) class="active" @endif >--}}{{--<a href = "{{action("Web\AfterLoginFormController@index")}}">--}}{{--<i class="icon-info"></i> فرم تکمیل ثبت نام </a>--}}{{--</li>--}}{{--</ul>--}}{{--</div>--}}{{--<!-- END MENU -->--}}{{--</div>--}}
