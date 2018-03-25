<div class="portlet light profile-sidebar-portlet ">
    <!-- SIDEBAR USERPIC -->
    {{--<div class="profile-userpic"></div>--}}
    <!-- END SIDEBAR USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    <div class="profile-usertitle">
        <div class="profile-usertitle-name bold">منو پیکر بندی</div>
    </div>
    <!-- END SIDEBAR USER TITLE -->
    <!-- SIDEBAR BUTTONS -->
    {{--<div class="profile-userbuttons">--}}
        {{--{!! Form::open(['files'=>true,'method' => 'PUT' , 'action' => ['WebsiteSettingController@update', $setting]])  !!}--}}
            {{--<div class="list-group">--}}
                {{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}
                    {{--<div class="profile-userpic">--}}
                        {{--<div class="fileinput-new">--}}
                            {{--<img src="{{isset($wSetting->site->logo) && strlen($wSetting->site->logo) > 0  ? route('image', ['category'=>'11','w'=>'140' , 'h'=>'140' ,  'filename' =>  $wSetting->site->logo ]) : "../assets/pages/media/works/img1.jpg"}}" class="img-responsive" alt="لوگو سایت" />--}}
                        {{--</div>--}}
                        {{--<div class="fileinput-preview fileinput-exists"> </div>--}}
                    {{--</div>--}}
                    {{--<br>--}}
                    {{--<div>--}}
                        {{--<span class="btn-file">--}}
                            {{--<span class="fileinput-new btn btn-success"><i class="fa fa-plus"></i>انتخاب عکس</span>--}}
                            {{--<span class="fileinput-exists btn"> تغییر </span>--}}
                            {{--<input type="file" name="siteLogo"> </span>--}}
                        {{--<a href="javascript:;" class="btn red fileinput-exists" id="siteLogo-remove" data-dismiss="fileinput"> حذف </a>--}}
                    {{--</div>--}}
                    {{--<div class="clearfix margin-top-10">--}}
                        {{--<span class="label label-danger">توجه</span> فرمت های مجاز: jpg , png - حداکثر حجم مجاز: ۲۰۰KB </div>--}}
                {{--</div>--}}
                {{--<br>--}}
                {{--<br>--}}
                {{--{!! Form::submit("آپلود" , ['class' => 'btn  blue btn-sm']) !!}--}}
            {{--</div>--}}
        {{--{!! Form::close() !!}--}}
    {{--</div>--}}
    <!-- END SIDEBAR BUTTONS -->
    <!-- SIDEBAR MENU -->
    <div class="profile-usermenu">
        <ul class="nav">
            @permission((Config::get('constants.SHOW_SITE_CONFIG_ACCESS')))
            <li @if(strcmp($section , "websiteSetting") == 0) class="active" @endif >
                <a href="{{action("HomeController@adminSiteConfig")}}">
                    <i class="icon-settings"></i> تنظیمات سایت </a>
            </li>
            @endpermission
            @permission((Config::get('constants.LIST_SLIDESHOW_ACCESS')))
            <li @if(strcmp($section , "slideShow") == 0) class="active" @endif >
                <a href="{{action("HomeController@adminSlideShow")}}">
                    <i class="fa fa-picture-o" aria-hidden="true"></i> اسلاید شو صفحه اصلی </a>
            </li>
            @endpermission
            {{--@permission((Config::get('constants.LIST_SLIDESHOW_ACCESS')))--}}
            {{--<li @if(strcmp($section , "articleSlideShow") == 0) class="active" @endif >--}}
                {{--<a href="{{action("HomeController@adminArticleSlideShow")}}">--}}
                    {{--<i class="fa fa-picture-o" aria-hidden="true"></i> اسلاید شو صفحه مقالات </a>--}}
            {{--</li>--}}
            {{--@endpermission--}}
            <li @if(strcmp($section , "afterLoginForm") == 0) class="active" @endif >
                <a href="{{action("AfterLoginFormController@index")}}">
                    <i class="icon-info"></i> فرم تکمیل ثبت نام </a>
            </li>
        </ul>
    </div>
    <!-- END MENU -->
</div>