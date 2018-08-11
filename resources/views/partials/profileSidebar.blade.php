<!-- PORTLET MAIN -->
<div class="portlet light profile-sidebar-portlet ">
    <!-- SIDEBAR USERPIC -->
    <div class="profile-userpic">
        <img @if(isset($user->photo))  src="{{ route('image', ['category'=>'1','w'=>'150' , 'h'=>'150' ,  'filename' => $user->photo ]) }}" @endif class="img-responsive" id="profilePhoto" alt="عکس پروفایل">
        @if(isset($withPhotoUpload) && $withPhotoUpload)
            <div class="row text-center margin-top-10">
                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['UserController@updatePhoto']  , 'id'=>'profilePhotoAjaxForm' ]) !!}
                    {!! Form::submit('بارگذاری', ['class' => 'btn blue' , 'id'=>'uploadProfilePhotoAjaxSubmit' , 'style'=>'display:none' ]) !!}
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <span class="btn green btn-file">
                                                                    <span class="fileinput-new"> انتخاب عکس </span>
                                                                    <span class="fileinput-exists"> تغییر </span>
                                                                    {!! Form::file('photo' , ['id'=>'profilePhotoFile']) !!}
                                                                </span>
                        <span class="fileinput-filename"> </span> &nbsp;
                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput" id="profilePhotoAjaxFileInputClose"> </a>
                    </div>
                    <img src="/img/loading-spinner-default.gif" style="width: 15px; display: none" id="profilePhotoAjaxLoadingSpinner">
                {!! Form::close() !!}
            </div>
            <div class="row " style="margin: auto">
                <div class="col-md-12">
                    <p class="font-red text-justify bold ">حجم عکس حداکثر 500 کیلوبایت و فرمت آن jpg یا png باشد</p>
                </div>
            </div>
            {{--<progress></progress>--}}
        @endif
    </div>
    <!-- END SIDEBAR  USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    @if(isset($withRegisterationDate) && $withRegisterationDate)
    <div class="profile-usertitle">
        <div class="profile-usertitle-name">@if(!isset($user->firstName) && !isset($user->lastName)) کاربر ناشناس @else @if(isset($user->firstName)) {{$user->firstName}} @endif @if(isset($user->lastName)){{$user->lastName}} @endif @endif</div>

        <div class="profile-usertitle-job "> تاریخ عضویت: {{$user->CreatedAt_Jalali()}} </div>
    </div>
    @endif
    <!-- END SIDEBAR USER TITLE -->
    <!-- SIDEBAR MENU -->
    @if(isset($withNavigation) && $withNavigation)
    <div class="profile-usermenu">
        <ul class="nav">
            <li @if(strcmp(url()->current() , action("UserController@show",$user)) == 0) class="active" @endif >
                <a href="{{ action("UserController@show",$user) }}">
                    <i class="icon-settings"></i> تنظیمات حساب کاربری </a>
            </li>
            <li @if(strcmp(url()->current() , action("UserController@userProductFiles")) == 0) class="active" @endif >
                <a href="{{action("UserController@userProductFiles")}}" class="font-yellow">
                    <i class="fa fa-cloud-download "></i> فیلم ها و جزوه ها </a></li>
            {{--<li class="@if(strcmp(url()->current() , action("UserController@showBelongings")) == 0) active @endif">--}}
                {{--<a  href="{{action("UserController@showBelongings")}}">--}}
                    {{--<i class="fa fa-address-card" aria-hidden="true"></i>پروفایل فنی من</a>--}}
            {{--</li>--}}
            @if(isset($hasCompleteProfile) && $hasCompleteProfile)
            <li @if(strcmp(url()->current() , action("UserController@information" , $user)) == 0) class="active" @endif >
                    <a href="{{action("UserController@information" , $user)}}" class="font-red">
                        <i class="fa fa-pencil"></i> تکمیل اطلاعات (مخصوص اردویی ها) </a>
            </li>
            @endif
            <li @if(strcmp(url()->current() , action("HomeController@submitKonkurResult")) == 0) class="active" @endif >
                <a href="{{action("HomeController@submitKonkurResult")}}">
                    <i class="fa fa-graduation-cap"></i> ثبت رتبه 97 </a>
            </li>
            {{--<li @if(strcmp(url()->current() , action("UserController@voucherRequest")) == 0) class="active" @endif >--}}
                {{--<a href="{{action("UserController@voucherRequest")}}">--}}
                    {{--<i class="fa fa-registered"></i>ثبت درخواست اینترنت آسیاتک</a>--}}
            {{--</li>--}}
        </ul>
    </div>
    @endif
    <!-- END MENU -->
</div>
<!-- END PORTLET MAIN -->
@if(isset($withInfoBox) && $withInfoBox)
<!-- PORTLET MAIN -->
<div class="portlet light ">
    <div>
        <h4 class="profile-desc-title">اطلاعات ثبت شده</h4>
        <div class="margin-top-20 profile-desc-link">
            <i class="fa fa-user"></i> کد ملی:
            <span>@if(isset($user->nationalCode)) {{ $user->nationalCode }} @endif</span>
        </div>
        <div class="margin-top-20 profile-desc-link">
            <i class="fa fa-mobile"></i> شماره موبایل:
            <span>@if(isset($user->mobile)){{ $user->mobile }} @endif</span>
            @if(!$user->mobileNumberVerification)
                <span class="label label-danger"> توجه! شماره موبایل تایید نشده است. </span>
            @endif

        </div>
        <div class="margin-top-20 profile-desc-link">
            @if (Session::has('verificationSuccess'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {{ Session::pull('verificationSuccess') }}
                </div>
            @endif
        </div>
        @if(!$user->mobileNumberVerification )
            <div class="margin-top-20 profile-desc-link">
                <div class="form-group form-md-line-input">
                    {!! Form::open(['method' => 'POST','action' => ['UserController@submitVerificationCode']]) !!}
                    <input type="text" name="code" class="form-control" id="form_control_1"  placeholder="کد تایید شماره خود را وارد نمایید">
                    <label for="form_control_1"><span class="font-red-thunderbird">تایید شماره موبایل(حساب کاربری)</span></label>
                    <span class="help-block">برای دریافت کد روی دکمه درخواست کلیک کنید</span>
                </div>
                <div class="form-actions noborder" style="text-align: center;">
                    @if(isset($hasRequestedVerificationCode) && $hasRequestedVerificationCode)
                        <button type="submit" class="btn green">تایید کد</button>
                    @else
                        <a href="{{action("UserController@sendVerificationCode")}}" class="btn blue">درخواست ارسال کد</a>
                    @endif
                    {!! Form::close() !!}
                </div>
                <div class="form-group form-md-line-input" style="text-align: justify;">
                    @if (Session::has('getVerificationCodeSuccess'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ Session::pull('getVerificationCodeSuccess') }}
                        </div>
                    @endif
                    @if (Session::has('verificationCodeError'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ Session::pull('verificationCodeError') }}
                        </div>
                    @endif
                    @if (Session::has('verificationCodeInfo'))
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ Session::pull('verificationCodeInfo') }}
                        </div>
                    @endif
                    @if (Session::has('verificationCodeWarning'))
                        <div class="alert alert-warning alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ Session::pull('verificationCodeWarning') }}
                        </div>
                    @endif
                </div>
            </div>
        @endif
        {{--<div class="margin-top-20 profile-desc-link">--}}
        {{--<i class="fa fa-graduation-cap"></i> رشته:--}}
        {{--<span>@if(isset($user->major->name)){{ $user->major->name }}--}}
        {{--@else <span class="label label-danger"> درج نشده </span>--}}
        {{--@endif</span>--}}
        {{--</div>--}}
        {{--<div class="margin-top-20 profile-desc-link">--}}
        {{--<i class="fa fa-graduation-cap"></i> جنیست:--}}
        {{--<span>@if(isset($user->gender->name)){{ $user->gender->name }}--}}
        {{--@else <span class="label label-danger"> درج نشده </span>--}}
        {{--@endif</span>--}}
        {{--</div>--}}
    </div>
</div>
<!-- END PORTLET MAIN -->
@endif

@if(isset($withCompletionBox) && $withCompletionBox)
<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption" style="width: 100%; text-align: center">
            <span class="caption-subject font-dark bold uppercase">میزان تکمیل پروفایل</span>
            @if(!$user->mobileNumberVerification)
                <span class="label label-warning">توجه! یکی از موارد ، تایید شماره موبایل می باشد </span>
            @endif
        </div>
        {{--<div class="actions">--}}
        {{--<a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload">--}}
        {{--<i class="fa fa-repeat"></i> Reload </a>--}}
        {{--</div>--}}
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-4 ">

            </div>
            <div class="margin-bottom-10 visible-sm"> </div>
            <div class="col-md-4">
                <div class="easy-pie-chart">
                    <div class="number @if($userCompletion < 50) bounce @elseif($userCompletion >= 50 && $userCompletion < 90) transactions @elseif((int)$userCompletion >= 90) visits @endif" data-percent="{{ $userCompletion }}">
                        <span>{{ $userCompletion }}</span>% </div>
                </div>
            </div>
            <div class="margin-bottom-10 visible-sm"> </div>
        </div>
    </div>
</div>
@endif
