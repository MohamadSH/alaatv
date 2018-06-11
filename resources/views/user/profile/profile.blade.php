@extends("app" , ["pageName" => "profile"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("headPageLevelStyle")
    <link rel="stylesheet" href="{{ mix('/css/page_level_style_all.css') }}">
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("metadata")
    @parent()
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>پروفایل</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    {{--EXCHANGE LOTTERY--}}
    <div class="row">
        <div class="col-md-12">
            @if(isset($hasHamayeshHozouriArabi) && $hasHamayeshHozouriArabi)
                <div class="alert alert-block bg-blue bg-font-blue fade in">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <h4 class="alert-heading text-center" style="line-height: normal;">شما در همایش حضوری عربی آقای ناصح زاده روز 27 خرداد ثبت نام کرده اید</h4>
                </div>
            @elseif(isset($hasHamayeshTalaiArabi) && $hasHamayeshTalaiArabi)
                <div class="alert alert-block bg-purple bg-font-purple fade in">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <h4 class="alert-heading text-center" style="line-height: normal;">برای ثبت نام در همایش حضوری عربی آقای ناصح زاده روز 27 خرداد کلیک کنید</h4>
                    <p style="text-align: center;">
                        <button class="btn mt-sweetalert-hamayesh-arabi" data-title="آیا از ثبت نام خود مطمئنید؟" data-type="warning" data-allow-outside-click="true" data-show-confirm-button="true" data-show-cancel-button="true" data-cancel-button-class="btn-danger" data-cancel-button-text="خیر" data-confirm-button-text="بله ثبت نام می کنم" data-confirm-button-class="btn-info" style="background: #d6af18;">ثبت نام در همایش حضوری</button>
                    </p>
                </div>
            @endif
            @if(isset($userPoints) && $userPoints)
                <div class="alert alert-block bg-purple bg-font-purple fade in">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <h4 class="alert-heading text-center" style="line-height: normal;">برای انصرف از قرعه کشی همایش طلایی ، روی دکمه زیر کلیک کنید</h4>
                    <h4 class="alert-heading text-center" style="line-height: normal;">در صورت انصراف مبلغ {{(isset($exchangeAmount))?number_format($exchangeAmount):""}} تومان اعتبار هدیه به رسم یاد بود به شما اهدا خواهد شد.</h4>
                    <p style="text-align: center;">
                        <button class="btn mt-sweetalert" data-title="آیا از انصراف خود مطمئنید؟" data-type="warning" data-allow-outside-click="true" data-show-confirm-button="true" data-show-cancel-button="true" data-cancel-button-class="btn-danger" data-cancel-button-text="خیر انصراف نمی دهم" data-confirm-button-text="بله انصراف می دهم" data-confirm-button-class="btn-info" style="background: #d6af18;">انصراف از قرعه کشی و دریافت مبلغ هدبه</button>
                    </p>
                </div>
            @elseif(isset($userLottery))
                @if(isset($prizeCollection))
                    <div class="alert alert-block bg-blue bg-font-blue fade in">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <h4 class="alert-heading text-center" style="line-height: normal;">{{$lotteryMessage}} {{($lotteryRank>0)?" جایزه شما:":""}}</h4>
                        @foreach($prizeCollection as $prize )
                            <h5 class="text-center bold" style="font-size: large">{{$prize["name"]}}</h5>
                        @endforeach
                        <h4 class="alert-heading text-center" style="line-height: normal;"> از طرف آلاء به شما تقدیم شده است. به امید موفقیت شما</h4>
                    </div>
                @else
                    <div class="alert alert-block bg-blue bg-font-blue fade in">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <h4 class="alert-heading text-center" style="line-height: normal;">{{$lotteryMessage}}</h4>

                        <h4 class="alert-heading text-center" style="line-height: normal;">از شرکت شما در قرعه کشی سپاس گزاریم . با امید موفقیت شما.</h4>
                    </div>
                @endif

            @endif
        </div>
    </div>

    {{--LOTTERY PRIZE--}}
    {{--@if(isset($userlottery) && isset($userlottery->pivot->rank))--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-12">--}}
                    {{--<div class="alert alert-block bg-blue bg-font-blue fade in">--}}
                        {{--<button type="button" class="close" data-dismiss="alert"></button>--}}
                        {{--@if($userlottery->pivot->rank > 0)--}}
                            {{--<h4 class="alert-heading text-center" style="line-height: normal;">ضمن عرض تبریک ، شما نفر {{$userlottery->pivot->rank}} قرعه کشی {{$userlottery->displayName}}   شده اید </h4>--}}
                            {{--@if(isset($prizeCollection) && $prizeCollection->isNotEmpty())--}}
                                {{--<h4 class="alert-heading text-center" style="line-height: normal;">جایزه شما--}}
                                    {{--@foreach($prizeCollection as $prize )--}}
                                        {{--<span class="bold" style="font-size:larger">{{$prize["name"]}}@if(isset($prize["validUntil"]))( معتبر تا بامداد {{$prize["validUntil"]}} )@endif</span>--}}
                                    {{--@endforeach--}}
                                {{--می باشد.</h4>--}}
                            {{--@endif--}}
                        {{--@elseif($userlottery->pivot->rank == 0)--}}
                            {{--<h4 class="alert-heading text-center" style="line-height: normal;">شما از قرعه کشی {{$userlottery->displayName}} انصراف داده اید </h4>--}}
                            {{--@if(isset($prizeCollection) && $prizeCollection->isNotEmpty())--}}
                                    {{--@foreach($prizeCollection as $prize )--}}
                                        {{--<h5 class="bold text-center" style="font-size:larger">{{$prize["name"]}}@if(isset($prize["validUntil"]))( معتبر تا بامداد {{$prize["validUntil"]}} )@endif</h5>--}}
                                    {{--@endforeach--}}
                                    {{--<h4 class="alert-heading text-center" style="line-height: normal;">هدیه آلاء به شماست . به امید موفقیت شما .</h4>--}}
                            {{--@endif--}}
                        {{--@endif--}}
                    {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--@endif--}}

    <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PROFILE SIDEBAR -->
                        <div class="profile-sidebar">
                            @include('partials.profileSidebar',['user'=>$user])
                        </div>
                        <!-- END BEGIN PROFILE SIDEBAR -->
                        <!-- BEGIN PROFILE CONTENT -->
                        <div class="profile-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet light ">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption caption-md">
                                                <i class="icon-globe theme-font hide"></i>
                                                <span class="caption-subject font-blue-madison bold uppercase">
                                                    @if( ( !$user->lockProfile and $user->id == Auth::id()))
                                                        اصلاح پروفایل
                                                    @else
                                                        پروفایل
                                                    @endif
                                                </span>
                                            </div>
                                            <ul class="nav nav-tabs">
                                                <li @if(Empty(session('tabPane')) || strcmp(session('tabPane') , "tab_1_1") == 0) {{ "class=active" }} @endif>
                                                    <a href="#tab_1_1" data-toggle="tab">
                                                        @if( ( !$user->lockProfile and $user->id == Auth::id()))

                                                            ویرایش اطلاعات شخصی
                                                        @else
                                                            نمایش اطلاعات شخصی
                                                        @endif

                                                    </a>
                                                </li>
                                                @if(($user->id == Auth::id()))
                                                <li @if(strcmp(session('tabPane') , "tab_1_2") == 0) {{ "class=active" }} @endif>
                                                    <a href="#tab_1_2" data-toggle="tab">تغییر عکس</a>
                                                </li>
                                                @endif
                                                @permission((Config::get('constants.EDIT_USER_ACCESS')))
                                                @if($user->id == Auth::id())
                                                    <li @if(strcmp(session('tabPane') , "tab_1_3") == 0) {{ "class=active" }} @endif>
                                                        <a href="#tab_1_3" data-toggle="tab">تغییر رمز عبور</a>
                                                    </li>
                                                @endif
                                                @endpermission
                                            </ul>
                                        </div>

                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <!-- PERSONAL INFO TAB -->
                                                <div class="tab-pane @if(Empty(session('tabPane')) || strcmp(session('tabPane') , "tab_1_1") == 0) active @endif" id="tab_1_1">
                                                    @if(
                                                         (!$user->lockProfile and $user->id == Auth::id()))

                                                        @include('user.profile.profileEditView')
                                                    @else
                                                        @include('user.profile.profileView')
                                                    @endif
                                                    @if(Session::has('belongsTo') && strcmp(Session::get('belongsTo'),"moreInfo")==0)
                                                        @include("systemMessage.flash")
                                                    @endif
                                                </div>
                                                <!-- END PERSONAL INFO TAB -->
                                                <!-- CHANGE AVATAR TAB -->
                                                @if(($user->id == Auth::id()))
                                                <div class="tab-pane @if(strcmp(session('tabPane') , "tab_1_2") == 0) active @endif" id="tab_1_2">
                                                    <p> می توانید عکس پروفایل خود را با استفاده از فرم زیر تغییر دهید . </p>
                                                    <form method="post" role="form" action="{{ action("UserController@updatePhoto" ) }}" enctype="multipart/form-data">
                                                        <input type="hidden" name="_method" value="PUT">
                                                        {{ csrf_field() }}
                                                        <div class="form-group {{ $errors->has('photo') ? ' has-error' : '' }}">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                       <img  @if(isset($user->photo)) src="{{ route('image', ['category'=>'1','w'=>'140' , 'h'=>'140' ,  'filename' =>  $user->photo ]) }}" @endif  alt="عکس پروفایل" />
                                                                </div>
                                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                                <div>
                                                                        <span class="btn default btn-file">
                                                                            <span class="fileinput-new"> انتخاب عکس </span>
                                                                            <span class="fileinput-exists"> تغییر </span>
                                                                            <input type="file" name="photo"> </span>
                                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> حذف </a>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix margin-top-10">
                                                                <span class="label label-danger">توجه! </span>
                                                                <span> دقت نمایید که حجم عکس مورد نظر باید حداکثر 500 کیلوبایت و فرمت آن jpg و یا png باشد. </span>
                                                            </div>
                                                        </div>
                                                        <div class="margin-top-10">
                                                            <button type="submit"  class="btn green"> ذخیره </button>
                                                        </div>
                                                        @if($errors->has('photo'))
                                                            @include("systemMessage.flash",array("error"=>$errors->first('photo')))
                                                        @else
                                                            @if(Session::has('belongsTo') && strcmp(Session::get('belongsTo'),"photo")==0)
                                                                @include("systemMessage.flash")
                                                            @endif
                                                        @endif
                                                    </form>
                                                </div>
                                                <!-- END CHANGE AVATAR TAB -->
                                                <!-- CHANGE PASSWORD TAB -->
                                                <div class="tab-pane @if(strcmp(session('tabPane') , "tab_1_3") == 0) active @endif" id="tab_1_3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <!-- BEGIN Portlet PORTLET-->
                                                            <div class="portlet light bg-inverse">
                                                                <div class="portlet-title">
                                                                    <div class="caption font-purple-plum">
                                                                        <span class="caption-subject bold uppercase"> درخواست رمز عبور اتوماتیک</span>
                                                                        <span class="caption-helper">ارسال از طریق پیامک</span>
                                                                    </div>
                                                                </div>
                                                                <div class="portlet-body">
																	<div class="row">
																		<form  action="{{ action("UserController@sendGeneratedPassword") }}" method="post" >
																			{{ csrf_field() }}
																			<div class="form-actions">
																			برای ارسال پیامک رمز عبور جدید بر روی این دکمه کلیک کنید
																				<button type="submit" class="btn yellow">ارسال پیامک رمز عبور</button>
																			</div>
																		</form>
																	</div>
                                                                </div>
                                                            </div>
                                                            <!-- END Portlet PORTLET-->
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <!-- BEGIN Portlet PORTLET-->
                                                            <div class="portlet light bg-inverse">
                                                                <div class="portlet-title">
                                                                    <div class="caption font-purple-plum">
                                                                        <span class="caption-subject bold uppercase"> رمز عبور دلخواه</span>
                                                                        <span class="caption-helper">تنظیم رمز عبور دلخواه</span>
                                                                    </div>
                                                                </div>
                                                                <div class="portlet-body">
                                                                    <form action="{{action("UserController@updatePassword" )}}" method="post">
                                                                        <input type="hidden" name="_method" value="PUT">
                                                                        {{ csrf_field() }}
                                                                        <div class="form-group {{ $errors->has('oldPassword') ? ' has-error' : '' }}">
                                                                            <label class="control-label">رمز عبور فعلی</label>
                                                                            <input type="password" class="form-control" name="oldPassword" />
                                                                            @if ($errors->has('oldPassword'))
                                                                                <span class="help-block">
                                                                <strong>{{ $errors->first('oldPassword') }}</strong>
                                                              </span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                                                            <label class="control-label">رمز عبور جدید</label>
                                                                            <input type="password" class="form-control" name="password" />
                                                                            @if ($errors->has('password'))
                                                                                <span class="help-block">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                              </span>
                                                                            @endif
                                                                        </div>

                                                                        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                                            <label class="control-label">تکرار رمز عبور جدید</label>
                                                                            <input type="password" class="form-control" name="password_confirmation" />
                                                                            @if ($errors->has('password_confirmation'))
                                                                                <span class="help-block">
                                                                 <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                            </span>
                                                                            @endif
                                                                        </div>

                                                                        <div class="margin-top-10">
                                                                            <button type="submit" class="btn green"> تغییر </button>
                                                                        </div>
                                                                        @if(Session::has('belongsTo') && strcmp(Session::get('belongsTo'),"password")==0)
                                                                            @include("systemMessage.flash")
                                                                        @endif
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <!-- END Portlet PORTLET-->
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- END CHANGE PASSWORD TAB -->
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    @if($user->bio != null)
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">درباره من</span>
                                                </div>
                                             </div>
                                            <div class="portlet-body">
                                                <div class="content">
                                                    <p style=" text-align: justify; line-height: initial;">
                                                        {!! $user->bio !!}
                                                    </p>
                                                </div>
                                            </div>
                                         </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- END PROFILE CONTENT -->

                </div>
            </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/profile.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script>
        /**
         * Set token for ajax request
         */
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });

        var userAjax;
        var SweetAlert = function () {

            return {
                //main function to initiate the module
                init: function () {
                    $('.mt-sweetalert').each(function(){
                        var sa_title = $(this).data('title');
                        var sa_message = $(this).data('message');
                        var sa_type = $(this).data('type');
                        var sa_allowOutsideClick = $(this).data('allow-outside-click');
                        var sa_showConfirmButton = $(this).data('show-confirm-button');
                        var sa_showCancelButton = $(this).data('show-cancel-button');
                        var sa_closeOnConfirm = $(this).data('close-on-confirm');
                        var sa_closeOnCancel = $(this).data('close-on-cancel');
                        var sa_confirmButtonText = $(this).data('confirm-button-text');
                        var sa_cancelButtonText = $(this).data('cancel-button-text');
                        var sa_popupTitleSuccess = $(this).data('popup-title-success');
                        var sa_popupMessageSuccess = $(this).data('popup-message-success');
                        var sa_popupTitleCancel = $(this).data('popup-title-cancel');
                        var sa_popupMessageCancel = $(this).data('popup-message-cancel');
                        var sa_confirmButtonClass = $(this).data('confirm-button-class');
                        var sa_cancelButtonClass = $(this).data('cancel-button-class');

                        $(this).click(function(){
                            //console.log(sa_btnClass);
                            swal({
                                    title: sa_title,
                                    text: sa_message,
                                    type: sa_type,
                                    allowOutsideClick: sa_allowOutsideClick,
                                    showConfirmButton: sa_showConfirmButton,
                                    showCancelButton: sa_showCancelButton,
                                    confirmButtonClass: sa_confirmButtonClass,
                                    cancelButtonClass: sa_cancelButtonClass,
                                    closeOnConfirm: sa_closeOnConfirm,
                                    closeOnCancel: sa_closeOnCancel,
                                    confirmButtonText: sa_confirmButtonText,
                                    cancelButtonText: sa_cancelButtonText,
                                },
                                function(isConfirm){
                                    if (isConfirm){
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "positionClass": "toast-top-center",
                                            "onclick": null,
                                            "showDuration": "1000",
                                            "hideDuration": "1000",
                                            "timeOut": "5000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                        };

                                        if(userAjax) {
                                            userAjax.abort();
                                        }
                                        userAjax = $.ajax({
                                            type: "POST",
                                            url: "{{action("UserController@removeFromLottery")}}",
                                            contentType: "application/json",
                                            dataType: "json",
                                            statusCode: {
                                                200:function (response) {
                                                    // console.log(response.responseText);
                                                    location.reload();
                                                },
                                                //The status for when the user is not authorized for making the request
                                                401:function (ressponse) {
                                                },
                                                403: function (response) {
                                                },
                                                404: function (response) {
                                                },
                                                //The status for when form data is not valid
                                                422: function (response) {
                                                    //
                                                },
                                                //The status for when there is error php code
                                                500: function (response) {
                                                    console.log(response);
                                                },
                                                //The status for when there is error php code
                                                503: function (response) {
                                                    // console.log("503 Error");
                                                    toastr["error"]($.parseJSON(response.responseText).message, "پیام سیستم");
                                                }
                                            }
                                        });
                                        // swal(sa_popupTitleSuccess, sa_popupMessageSuccess, "success");
                                    } else {
                                        // swal(sa_popupTitleCancel, sa_popupMessageCancel, "error");
                                    }
                                });
                        });
                    });

                    $('.mt-sweetalert-hamayesh-arabi').each(function(){
                        var sa_title = $(this).data('title');
                        var sa_message = $(this).data('message');
                        var sa_type = $(this).data('type');
                        var sa_allowOutsideClick = $(this).data('allow-outside-click');
                        var sa_showConfirmButton = $(this).data('show-confirm-button');
                        var sa_showCancelButton = $(this).data('show-cancel-button');
                        var sa_closeOnConfirm = $(this).data('close-on-confirm');
                        var sa_closeOnCancel = $(this).data('close-on-cancel');
                        var sa_confirmButtonText = $(this).data('confirm-button-text');
                        var sa_cancelButtonText = $(this).data('cancel-button-text');
                        var sa_popupTitleSuccess = $(this).data('popup-title-success');
                        var sa_popupMessageSuccess = $(this).data('popup-message-success');
                        var sa_popupTitleCancel = $(this).data('popup-title-cancel');
                        var sa_popupMessageCancel = $(this).data('popup-message-cancel');
                        var sa_confirmButtonClass = $(this).data('confirm-button-class');
                        var sa_cancelButtonClass = $(this).data('cancel-button-class');

                        $(this).click(function(){
                            //console.log(sa_btnClass);
                            swal({
                                    title: sa_title,
                                    text: sa_message,
                                    type: sa_type,
                                    allowOutsideClick: sa_allowOutsideClick,
                                    showConfirmButton: sa_showConfirmButton,
                                    showCancelButton: sa_showCancelButton,
                                    confirmButtonClass: sa_confirmButtonClass,
                                    cancelButtonClass: sa_cancelButtonClass,
                                    closeOnConfirm: sa_closeOnConfirm,
                                    closeOnCancel: sa_closeOnCancel,
                                    confirmButtonText: sa_confirmButtonText,
                                    cancelButtonText: sa_cancelButtonText,
                                },
                                function(isConfirm){
                                    if (isConfirm){
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "positionClass": "toast-top-center",
                                            "onclick": null,
                                            "showDuration": "1000",
                                            "hideDuration": "1000",
                                            "timeOut": "5000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                        };

                                        if(userAjax) {
                                            userAjax.abort();
                                        }
                                        userAjax = $.ajax({
                                            type: "POST",
                                            url: "{{action("OrderController@addToArabiHozouri")}}",
                                            contentType: "application/json",
                                            dataType: "json",
                                            statusCode: {
                                                200:function (response) {
                                                    location.reload();
                                                },
                                                //The status for when the user is not authorized for making the request
                                                401:function (ressponse) {
                                                },
                                                403: function (response) {
                                                },
                                                404: function (response) {
                                                },
                                                //The status for when form data is not valid
                                                422: function (response) {
                                                    //
                                                },
                                                //The status for when there is error php code
                                                500: function (response) {
                                                    console.log(response);
                                                },
                                                //The status for when there is error php code
                                                503: function (response) {
                                                    // console.log("503 Error");
                                                    console.log(response);
                                                    toastr["error"]("خطا", "پیام سیستم");
                                                }
                                            }
                                        });
                                        // swal(sa_popupTitleSuccess, sa_popupMessageSuccess, "success");
                                    } else {
                                        // swal(sa_popupTitleCancel, sa_popupMessageCancel, "error");
                                    }
                                });
                        });
                    });

                }
            }

        }();

        jQuery(document).ready(function() {
            SweetAlert.init();
        });

    </script>
@endsection
