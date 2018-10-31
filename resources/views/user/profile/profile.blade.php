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
    @include("systemMessage.flash")
    <div class="row">
        <div class="col-md-12">
            {{--            Using this notification for some text at the top of the profile page        --}}
            {{--            @include("user.profile.topNotification")--}}

            @include("user.profile.lotteryNotification" , [
                                                            "userPoints"=>$userPoints ,
                                                            "lotteryName"=>$lotteryName ,
                                                            "exchangeAmount" => $exchangeAmount ,
                                                            "userLottery" => $userLottery ,
                                                            "prizeCollection" => $prizeCollection,
                                                            "lotteryMessage" => $lotteryMessage,
                                                            "lotteryRank" => $lotteryRank,
                                                            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                @include('partials.profileSidebar',[
                                                'user'=>$user ,
                                                'withInfoBox'=>true ,
                                                'withCompletionBox'=>true ,
                                                'withRegisterationDate'=>true,
                                                'withNavigation' => true,
                                                'withPhotoUpload' => true ,
                                                  ]
                                                  )
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
                                        اصلاح پروفایل
                                    </span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active" >
                                        <a href="#tab_1_1" data-toggle="tab">
                                            اطلاعات شخصی
                                        </a>
                                    </li>
                                    @permission((Config::get('constants.EDIT_USER_ACCESS')))
                                    <li @if(strcmp(session('tabPane') , "tab_1_3") == 0) {{ "class=active" }} @endif>
                                        <a href="#tab_1_3" data-toggle="tab">تغییر رمز عبور</a>
                                    </li>
                                    @endpermission
                                </ul>
                            </div>

                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane" id="tab_1_1">
                                        @if(!$user->lockProfile)
                                            @include('user.profile.profileEditView' , ["withBio"=>true , "withBirthdate"=>false , "withIntroducer"=>false , "text2"=>"کاربر گرامی ، پس از تکمیل اطلاعات شخصی(فیلد های پایین) امکان اصلاح اطلاعات ثبت شده وجود نخواهد داشت. لذا خواهشمند هستیم این اطلاعات را در صحت و دقت کامل تکمیل نمایید . باتشکر"])
                                        @else
                                            @include('user.profile.profileView')
                                        @endif
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                    <!-- CHANGE PASSWORD TAB -->
                                    <div class="tab-pane" id="tab_1_3">
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
    <script src="/js/extraJS/scripts/profileUploadPhoto.js" type="text/javascript"></script>
    <script src="/js/extraJS/scripts/verificationCode.js" type="text/javascript"></script>
    <script>
        /**
         * Set token for ajax request
         */
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
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
                }
            }

        }();

        jQuery(document).ready(function() {
            SweetAlert.init();
        });

        {{--$(document).on("click", "#bt-register-hamayesh-arabi", function (){--}}
        {{--toastr.options = {--}}
        {{--"closeButton": true,--}}
        {{--"debug": false,--}}
        {{--"positionClass": "toast-top-center",--}}
        {{--"onclick": null,--}}
        {{--"showDuration": "1000",--}}
        {{--"hideDuration": "1000",--}}
        {{--"timeOut": "5000",--}}
        {{--"extendedTimeOut": "1000",--}}
        {{--"showEasing": "swing",--}}
        {{--"hideEasing": "linear",--}}
        {{--"showMethod": "fadeIn",--}}
        {{--"hideMethod": "fadeOut"--}}
        {{--};--}}

        {{--if(userAjax) {--}}
        {{--userAjax.abort();--}}
        {{--}--}}
        {{--userAjax = $.ajax({--}}
        {{--type: "POST",--}}
        {{--url: "{{action("OrderController@addToArabiHozouri")}}",--}}
        {{--contentType: "application/json",--}}
        {{--dataType: "json",--}}
        {{--statusCode: {--}}
        {{--200:function (response) {--}}
        {{--location.reload();--}}
        {{--},--}}
        {{--//The status for when the user is not authorized for making the request--}}
        {{--401:function (ressponse) {--}}
        {{--},--}}
        {{--403: function (response) {--}}
        {{--},--}}
        {{--404: function (response) {--}}
        {{--},--}}
        {{--//The status for when form data is not valid--}}
        {{--422: function (response) {--}}
        {{--//--}}
        {{--},--}}
        {{--//The status for when there is error php code--}}
        {{--500: function (response) {--}}
        {{--console.log(response);--}}
        {{--},--}}
        {{--//The status for when there is error php code--}}
        {{--503: function (response) {--}}
        {{--// console.log("503 Error");--}}
        {{--console.log(response);--}}
        {{--toastr["error"]("خطا", "پیام سیستم");--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}

        {{--$(document).on("click", "#bt-cancel-hamayesh-arabi", function (){--}}
        {{--toastr.options = {--}}
        {{--"closeButton": true,--}}
        {{--"debug": false,--}}
        {{--"positionClass": "toast-top-center",--}}
        {{--"onclick": null,--}}
        {{--"showDuration": "1000",--}}
        {{--"hideDuration": "1000",--}}
        {{--"timeOut": "5000",--}}
        {{--"extendedTimeOut": "1000",--}}
        {{--"showEasing": "swing",--}}
        {{--"hideEasing": "linear",--}}
        {{--"showMethod": "fadeIn",--}}
        {{--"hideMethod": "fadeOut"--}}
        {{--};--}}

        {{--if(userAjax) {--}}
        {{--userAjax.abort();--}}
        {{--}--}}
        {{--userAjax = $.ajax({--}}
        {{--type: "POST",--}}
        {{--url: "{{action("OrderController@removeArabiHozouri")}}",--}}
        {{--contentType: "application/json",--}}
        {{--dataType: "json",--}}
        {{--statusCode: {--}}
        {{--200:function (response) {--}}
        {{--location.reload();--}}
        {{--},--}}
        {{--//The status for when the user is not authorized for making the request--}}
        {{--401:function (ressponse) {--}}
        {{--},--}}
        {{--403: function (response) {--}}
        {{--},--}}
        {{--404: function (response) {--}}
        {{--},--}}
        {{--//The status for when form data is not valid--}}
        {{--422: function (response) {--}}
        {{--//--}}
        {{--},--}}
        {{--//The status for when there is error php code--}}
        {{--500: function (response) {--}}
        {{--console.log(response);--}}
        {{--},--}}
        {{--//The status for when there is error php code--}}
        {{--503: function (response) {--}}
        {{--// console.log("503 Error");--}}
        {{--console.log(response);--}}
        {{--toastr["error"]("خطا", "پیام سیستم");--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}
    </script>
@endsection
