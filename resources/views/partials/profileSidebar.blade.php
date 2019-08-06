<div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force">

    <div class="m-portlet__head m-portlet__head--fit">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-action">

                @if(isset($withPhotoUpload) && $withPhotoUpload && !$user->lockProfile)
                    <button type="button" id="btnEditUserPhoto" class="btn btn-sm m-btn--pill btn-info btnEditProfilePic" data-toggle="m-tooltip" {{--data-placement="left"--}}data-original-title="حجم عکس حداکثر 500 کیلوبایت و فرمت آن jpg یا png باشد">
                        ویرایش
                    </button>

                    <button type="button" id="uploadProfilePhotoAjaxSubmit" class="btn btn-sm m-btn--pill m-btn--gradient-from-info m-btn--gradient-to-warning submitProfilePic" style="display: none;">
                        ثبت
                    </button>
                @endif

            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-widget19">
            <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides userProfilePicWraper">

                <div class="progress profilePhotoUploadProgressBar">
                    <div class="progress-bar progress-bar-striped progress-bar-animated  bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                @if(isset($withPhotoUpload) && $withPhotoUpload)
                    {!! Form::open(['route' => 'web.authenticatedUser.profile.update', 'method' => 'POST', 'id'=>'profilePhotoAjaxForm' ]) !!}
                    @csrf
                    <input type="hidden" name="updateType" value="photo">
                    {{--<input type="hidden" id="profilePhotoAjaxUploadActionUrl" value="{{ action('Web\UserController@update' , Auth::user()) }}">--}}
                    <input type="file" name="photo" id="UserProfilePhoto" accept=".jpg,.gif,.png">
                    {!! Form::close() !!}
                @endif

                <img src="{{$user->getCustomSizePhoto(250,250)}}" class="imgUserProfileImage" id="profilePhoto" alt="عکس پروفایل">

                <h3 class="m-widget19__title m--font-light userFullname">
                    @if(isset($withRegisterationDate) && $withRegisterationDate)
                        @if(!isset($user->firstName) && !isset($user->lastName))
                            کاربر
                            ناشناس
                        @else
                            @if(isset($user->firstName))
                                {{$user->firstName}}
                            @endif
                            @if(isset($user->lastName))
                                {{$user->lastName}}
                            @endif
                        @endif
                    @endif
                </h3>
                <div class="m-widget19__shadow"></div>
            </div>
            <div class="m-widget19__content">
                <div class="m-widget19__header a--full-width">

                    @if(isset($withCompletionBox) && $withCompletionBox)
                        @if(isset($userCompletion))
                            میزان تکمیل پروفایل (
                            <span class="userCompletion-percent-text">{{ $userCompletion }}</span>%)
                            <br>
                            {{--@if(!$user->hasVerifiedMobile())--}}
                            {{--<span class="m-badge m-badge--wide m-badge--warning">توجه! یکی از موارد ، تایید شماره موبایل می باشد </span>--}}
                            {{--<br>--}}
                            {{--@endif--}}
                            <div class="progress" style="height: 3px;" aria-valuenow="50">
                                <div class="progress-bar progress-bar-animated progress-bar-striped userCompletion-progress-bar
                                        @if($userCompletion<=25)bg-danger
                                        @elseif($userCompletion>25 && $userCompletion<=50)bg-warning
                                        @elseif($userCompletion>50 && $userCompletion<=75)

                                @elseif($userCompletion>75 && $userCompletion<100)bg-info
                                        @elseif($userCompletion==100)bg-success
                                        @endif" role="progressbar" style="width: {{ $userCompletion }}%;" aria-valuenow="{{ $userCompletion }}" aria-valuemin="0" aria-valuemax="100">

                                </div>
                            </div>
                        @endif
                    @endif

                    <i class="flaticon-user-ok"></i>
                            تاریخ عضویت: {{$user->CreatedAt_Jalali()}}
                </div>
                <div class="m-widget19__body">
                    @if(isset($withInfoBox) && $withInfoBox)

                        <hr>

                        <br>
                        <i class="la la-barcode"></i>
                        کد ملی:
                        @if(isset($user->nationalCode)) {{ $user->nationalCode }} @endif
                        <br>
                        <i class="la la-mobile"></i>
                        شماره موبایل:
                        @if(isset($user->mobile)){{ $user->mobile }} @endif
                        <br>

                        <span class="m-badge m-badge--success mobileVerifyMessage @if(!$user->hasVerifiedMobile()) d-none @endif">شماره موبایل تایید شده است.</span>
                        <span class="m-badge m-badge--danger mobileUnVerifyMessage @if($user->hasVerifiedMobile()) d-none @endif"> توجه! شماره موبایل تایید نشده است.</span>

                        <div class="margin-top-20 profile-desc-link">
                            @if (Session::has('verificationSuccess'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    {{ Session::pull('verificationSuccess') }}
                                </div>
                            @endif
                        </div>

                        @if(!$user->hasVerifiedMobile() )
                            <div class="row SendMobileVerificationCodeWarper">
                                <div class="col-12 text-center">
                                    <input type="hidden" id="SendMobileVerificationCodeActionUrl" value="{{ action('Web\MobileVerificationController@resend') }}">
                                    <button type="button" id="btnSendMobileVerificationCode" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent m--margin-top-10">تایید شماره موبایل</button>
                                </div>
                                <div class="col-12 text-center inputVerificationWarper d-none">
                                    <div class="form-group m-form__group">
                                        <label for="txtMobileVerificationCode">کد تاییدیه ارسال شده:</label>
                                        <div class="m-input-icon m-input-icon--left">
                                            <input type="text" name="postalCode" id="txtMobileVerificationCode" class="form-control m-input m-input--air" placeholder="کد تایید">
                                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                                    <span>
                                                        <i class="la la-mobile"></i>
                                                    </span>
                                                </span>
                                        </div>
                                    </div>
                                    <input type="hidden" id="VerifyMobileVerificationCodeActionUrl" value="{{ action('Web\MobileVerificationController@verify') }}">
                                    <button type="button" id="btnVerifyMobileVerificationCode" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">تایید کد</button>
                                </div>
                            </div>


                            {{--<div class="margin-top-20 profile-desc-link">--}}
                            {{--<div class="form-group form-md-line-input">--}}
                            {{--{!! Form::open(['method' => 'POST','action' => ['Web\MobileVerificationController@verify'] , 'id'=>'submitVerificationCodeForm']) !!}--}}
                            {{--<fieldset--}}
                            {{--class="hasRequestedVerificationCode {{(!isset($mobileVerificationCode) || is_null($mobileVerificationCode))?"hidden":""}}">--}}
                            {{--<input type="text" name="code" class="form-control" id="form_control_1"--}}
                            {{--placeholder="کد تایید شماره خود را وارد نمایید">--}}
                            {{--<label for="form_control_1"><span class="m--font-danger-thunderbird">تایید شماره موبایل(حساب کاربری)</span></label>--}}
                            {{--<span class="form-control-feedback">برای دریافت کد روی دکمه درخواست کلیک کنید</span>--}}
                            {{--</fieldset>--}}
                            {{--</div>--}}
                            {{--<div class="form-actions noborder" style="text-align: center;">--}}
                            {{--<fieldset class="hasRequestedVerificationCode {{(!isset($mobileVerificationCode) || is_null($mobileVerificationCode))?"hidden":""}}">--}}
                            {{--<button type="submit" class="btn green">تایید کد</button>--}}
                            {{--</fieldset>--}}
                            {{--<fieldset id="hasntRequestedVerificationCode" class="">--}}
                            {{--<a href="{{action("Web\MobileVerificationController@resend")}}" class="btn blue"--}}
                            {{--id="sendVerificationCodeButton">@if(isset($mobileVerificationCode)) درخواست مجدد کد @else--}}
                            {{--درخواست ارسال کد@endif</a>--}}
                            {{--</fieldset>--}}
                            {{--<img src="/img/loading-spinner-default.gif" style="width: 15px; display: none"--}}
                            {{--id="verificationCodeAjaxLoadingSpinner">--}}
                            {{--{!! Form::close() !!}--}}
                            {{--</div>--}}
                            {{--<div class="form-group form-md-line-input" style="text-align: justify;">--}}
                            {{--<div class="alert alert-success alert-dismissable hidden" id="verificationCodeSuccess">--}}
                            {{--<button type="button" class="close" aria-hidden="true"></button>--}}
                            {{--<span></span>--}}
                            {{--</div>--}}
                            {{--<div class="alert alert-danger alert-dismissable hidden" id="verificationCodeError">--}}
                            {{--<button type="button" class="close" aria-hidden="true"></button>--}}
                            {{--<span></span>--}}
                            {{--</div>--}}
                            {{--<div class="alert alert-info alert-dismissable hidden" id="verificationCodeInfo">--}}
                            {{--<button type="button" class="close" aria-hidden="true"></button>--}}
                            {{--<span></span>--}}
                            {{--</div>--}}
                            {{--<div class="alert alert-warning alert-dismissable hidden" id="verificationCodeWarning">--}}
                            {{--<button type="button" class="close" aria-hidden="true"></button>--}}
                            {{--<span></span>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        @endif

                    @endif
                </div>
            </div>
            <div class="m-widget19__action">
                @if(isset($withNavigation) && $withNavigation)
                    <hr>
                    <div class="profile-usermenu">

                        @if(isset($hasCompleteProfile) && $hasCompleteProfile)
                            <li @if(strcmp(url()->current() , action("Web\UserController@information" , $user)) == 0) class="active" @endif >
                                <a href="{{action("Web\UserController@information" , $user)}}" class="m--font-danger">
                                    <i class="fa fa-pencil"></i>
                                    تکمیل اطلاعات (مخصوص اردویی ها)
                                </a>
                            </li>
                        @endif

                        <button type="button" class="btn m-btn--air btn-outline-warning btn-block" menu="profileMenuPage-setting">
                            <i class="flaticon-cogwheel"></i>
                            ویرایش اطلاعات شخصی
                        </button>
                        <button type="button" class="btn m-btn--air btn-info btn-block animated infinite rubberBand" menu="profileMenuPage-filmVaJozve" onclick="window.location.href='{{ route('web.user.dashboard', Auth::user()) }}';">
                            <i class="flaticon-multimedia-4"></i>
                            دریافت فیلم های و جزوات
                        </button>
                        <button type="button" class="btn m-btn--air btn-outline-success btn-block" menu="profileMenuPage-sabteRotbe">
                            <i class="la la-trophy"></i>
                            ثبت رتبه 98
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- PORTLET MAIN -->{{--<div class="portlet light profile-sidebar-portlet ">--}}{{--<!-- SIDEBAR USERPIC -->--}}{{--<div class="profile-userpic">--}}{{----}}{{----}}{{--<img @if(isset($user->photo))  src="{{ $user->photo }}" @endif class="img-responsive" id="profilePhoto" alt="عکس پروفایل">--}}{{----}}{{----}}{{----}}{{----}}{{--@if(isset($withPhotoUpload) && $withPhotoUpload)--}}{{----}}{{----}}{{----}}{{----}}{{--<div class="row text-center margin-top-10">--}}{{----}}{{----}}{{----}}{{----}}{{--{!! Form::open(['action' => ['Web\UserController@update' , Auth::user()]  , 'id'=>'profilePhotoAjaxForm' ]) !!}--}}{{----}}{{----}}{{----}}{{----}}{{--{!! Form::submit('بارگذاری', ['class' => 'btn blue' , 'id'=>'uploadProfilePhotoAjaxSubmit' , 'style'=>'display:none' ]) !!}--}}{{----}}{{----}}{{----}}{{----}}{{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}{{----}}{{----}}{{----}}{{----}}{{--<span class="btn green btn-file">--}}{{----}}{{----}}{{----}}{{----}}{{--<span class="fileinput-new"> انتخاب عکس </span>--}}{{----}}{{----}}{{----}}{{----}}{{--<span class="fileinput-exists"> تغییر </span>--}}{{----}}{{----}}{{----}}{{----}}{{--{!! Form::file('photo' , ['id'=>'profilePhotoFile' , 'data-action'=>action("Web\UserController@updateProfile")]) !!}--}}{{----}}{{----}}{{----}}{{----}}{{--</span>--}}{{----}}{{----}}{{----}}{{----}}{{--<span class="fileinput-filename"> </span> &nbsp;--}}{{----}}{{----}}{{----}}{{----}}{{--<a href="javascript:" class="close fileinput-exists" data-dismiss="fileinput" id="profilePhotoAjaxFileInputClose"></a>--}}{{----}}{{----}}{{----}}{{----}}{{--</div>--}}{{----}}{{----}}{{----}}{{----}}{{--<img src="/img/loading-spinner-default.gif" style="width: 15px; display: none" id="profilePhotoAjaxLoadingSpinner">--}}{{----}}{{----}}{{----}}{{----}}{{--{!! Form::close() !!}--}}{{----}}{{----}}{{----}}{{----}}{{--</div>--}}{{----}}{{----}}{{----}}{{----}}{{--<progress></progress>--}}{{----}}{{----}}{{----}}{{----}}{{--@endif--}}{{----}}{{----}}{{--</div>--}}{{--<!-- END SIDEBAR  USERPIC -->--}}{{--<!-- SIDEBAR USER TITLE -->--}}

{{--<!-- END SIDEBAR USER TITLE -->--}}{{--<!-- SIDEBAR MENU -->--}}{{--@if(isset($withNavigation) && $withNavigation)--}}{{--<div class="profile-usermenu">--}}{{--<ul class="nav">--}}{{--<li @if(strcmp(url()->current() , action("Web\UserController@show",$user)) == 0) class="active" @endif >--}}{{--<a href="{{ action("Web\UserController@show",$user) }}">--}}{{--<i class="icon-settings"></i> تنظیمات حساب کاربری </a>--}}{{--</li>--}}{{--<li @if(strcmp(url()->current() , action("Web\UserController@userProductFiles")) == 0) class="active" @endif >--}}{{--<a href="{{action("Web\UserController@userProductFiles")}}" class="font-yellow">--}}{{--<i class="fa fa-cloud-download "></i> فیلم ها و جزوه ها </a></li>--}}{{--<li class="@if(strcmp(url()->current() , action("Web\UserController@showBelongings")) == 0) active @endif">--}}{{--<a  href="{{action("Web\UserController@showBelongings")}}">--}}{{--<i class="fa fa-address-card" aria-hidden="true"></i>پروفایل فنی من</a>--}}{{--</li>--}}

{{--<li @if(strcmp(url()->current() , action("Web\UserController@voucherRequest")) == 0) class="active" @endif >--}}{{--<a href="{{action("Web\UserController@voucherRequest")}}">--}}{{--<i class="fa fa-registered"></i>ثبت درخواست اینترنت آسیاتک</a>--}}{{--</li>--}}{{--</ul>--}}{{--</div>--}}{{--@endif--}}{{--<!-- END MENU -->--}}{{--</div><!-- END PORTLET MAIN -->--}}{{--@if(isset($withInfoBox) && $withInfoBox)--}}{{----}}{{--<!-- PORTLET MAIN -->--}}{{----}}{{--<div class="portlet light ">--}}{{----}}{{--<div>--}}{{----}}{{--<h4 class="profile-desc-title">اطلاعات ثبت شده</h4>--}}{{----}}{{--<div class="margin-top-20 profile-desc-link">--}}{{----}}{{--<i class="fa fa-user"></i> کد ملی:--}}{{----}}{{--<span>@if(isset($user->nationalCode)) {{ $user->nationalCode }} @endif</span>--}}{{----}}{{--</div>--}}{{----}}{{--<div class="margin-top-20 profile-desc-link">--}}{{----}}{{--<i class="fa fa-mobile"></i> شماره موبایل:--}}{{----}}{{--<span>@if(isset($user->mobile)){{ $user->mobile }} @endif</span>--}}{{----}}{{--@if($user->hasVerifiedMobile())--}}{{----}}{{--<span class="m-badge m-badge--wide m-badge--success">شماره موبایل تایید شده است. </span>--}}{{----}}{{--@else--}}{{----}}{{--<span class="m-badge m-badge--wide m-badge--danger"> توجه! شماره موبایل تایید نشده است. </span>--}}{{----}}{{--@endif--}}

{{--</div>--}}{{--<div class="margin-top-20 profile-desc-link">--}}{{--@if (Session::has('verificationSuccess'))--}}{{--<div class="alert alert-success alert-dismissable">--}}{{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}{{--{{ Session::pull('verificationSuccess') }}--}}{{--</div>--}}{{--@endif--}}{{--</div>--}}{{--@if(!$user->hasVerifiedMobile() )--}}{{--<div class="margin-top-20 profile-desc-link">--}}{{--<div class="form-group form-md-line-input">--}}{{--{!! Form::open(['method' => 'POST','action' => ['Web\MobileVerificationController@verify'] , 'id'=>'submitVerificationCodeForm']) !!}--}}{{--<fieldset--}}{{--class="hasRequestedVerificationCode {{(!isset($mobileVerificationCode) || is_null($mobileVerificationCode))?"hidden":""}}">--}}{{--<input type="text" name="code" class="form-control" id="form_control_1"--}}{{--placeholder="کد تایید شماره خود را وارد نمایید">--}}{{--<label for="form_control_1"><span class="font-red-thunderbird">تایید شماره موبایل(حساب کاربری)</span></label>--}}{{--<span class="form-control-feedback">برای دریافت کد روی دکمه درخواست کلیک کنید</span>--}}{{--</fieldset>--}}{{--</div>--}}{{--<div class="form-actions noborder" style="text-align: center;">--}}{{--<fieldset--}}{{--class="hasRequestedVerificationCode {{(!isset($mobileVerificationCode) || is_null($mobileVerificationCode))?"hidden":""}}">--}}{{--<button type="submit" class="btn green">تایید کد</button>--}}{{--</fieldset>--}}{{--<fieldset id="hasntRequestedVerificationCode" class="">--}}{{--<a href="{{action("Web\MobileVerificationController@resend")}}" class="btn blue"--}}{{--id="sendVerificationCodeButton">@if(isset($mobileVerificationCode)) درخواست مجدد کد @else--}}{{--درخواست ارسال کد@endif</a>--}}{{--</fieldset>--}}{{--<img src="/img/loading-spinner-default.gif" style="width: 15px; display: none"--}}{{--id="verificationCodeAjaxLoadingSpinner">--}}{{--{!! Form::close() !!}--}}{{--</div>--}}{{--<div class="form-group form-md-line-input" style="text-align: justify;">--}}{{--<div class="alert alert-success alert-dismissable hidden" id="verificationCodeSuccess">--}}{{--<button type="button" class="close" aria-hidden="true"></button>--}}{{--<span></span>--}}{{--</div>--}}{{--<div class="alert alert-danger alert-dismissable hidden" id="verificationCodeError">--}}{{--<button type="button" class="close" aria-hidden="true"></button>--}}{{--<span></span>--}}{{--</div>--}}{{--<div class="alert alert-info alert-dismissable hidden" id="verificationCodeInfo">--}}{{--<button type="button" class="close" aria-hidden="true"></button>--}}{{--<span></span>--}}{{--</div>--}}{{--<div class="alert alert-warning alert-dismissable hidden" id="verificationCodeWarning">--}}{{--<button type="button" class="close" aria-hidden="true"></button>--}}{{--<span></span>--}}{{--</div>--}}{{--</div>--}}{{--</div>--}}{{--@endif--}}{{--<div class="margin-top-20 profile-desc-link">--}}{{--<i class="fa fa-graduation-cap"></i> رشته:--}}{{--<span>@if(isset($user->major->name)){{ $user->major->name }}--}}{{--@else <span class="m-badge m-badge--wide m-badge--danger"> درج نشده </span>--}}{{--@endif</span>--}}{{--</div>--}}{{--<div class="margin-top-20 profile-desc-link">--}}{{--<i class="fa fa-graduation-cap"></i> جنیست:--}}{{--<span>@if(isset($user->gender->name)){{ $user->gender->name }}--}}{{--@else <span class="m-badge m-badge--wide m-badge--danger"> درج نشده </span>--}}{{--@endif</span>--}}{{--</div>--}}{{--</div>--}}{{--</div>--}}{{--<!-- END PORTLET MAIN -->--}}{{--@endif--}}

{{--@if(isset($withCompletionBox) && $withCompletionBox)--}}{{--<div class="portlet light ">--}}{{--<div class="portlet-title">--}}{{--<div class="caption" style="width: 100%; text-align: center">--}}{{--<span class="caption-subject font-dark bold uppercase">میزان تکمیل پروفایل</span>--}}{{--@if(!$user->hasVerifiedMobile())--}}{{--<span class="m-badge m-badge--wide m-badge--warning">توجه! یکی از موارد ، تایید شماره موبایل می باشد </span>--}}{{--@endif--}}{{--</div>--}}{{--<div class="actions">--}}{{--<a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload">--}}{{--<i class="fa fa-repeat"></i> Reload </a>--}}{{--</div>--}}{{--</div>--}}{{--<div class="portlet-body">--}}{{--<div class="row">--}}{{--<div class="col-md-4 ">--}}

{{--</div>--}}{{--<div class="margin-bottom-10 visible-sm"></div>--}}{{--<div class="col-md-4">--}}{{--<div class="easy-pie-chart">--}}{{--@if(isset($userCompletion))--}}{{--<div class="number @if($userCompletion < 50) bounce @elseif($userCompletion >= 50 && $userCompletion < 90) transactions @elseif((int)$userCompletion >= 90) visits @endif"--}}{{--data-percent="{{ $userCompletion }}">--}}{{--<span>{{ $userCompletion }}</span>%--}}{{--</div>--}}{{--@endif--}}{{--</div>--}}{{--</div>--}}{{--<div class="margin-bottom-10 visible-sm"></div>--}}{{--</div>--}}{{--</div>--}}{{--</div>--}}{{--@endif--}}
