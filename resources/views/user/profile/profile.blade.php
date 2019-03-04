@extends("app" , ["pageName" => "profile"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#"> پروفایل </a>
            </li>
        </ol>
    </nav>

@endsection

@section('page-css')
    <link href="{{ mix('/css/user-profile.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/css/page-user-profile.css') }}" rel="stylesheet" type="text/css"/>



@endsection

@section('content')

    @include('systemMessage.flash')

    <div class="row">
        <div class="col">
            {{--            Using this notification for some text at the top of the profile page        --}}
            {{--            @include("user.profile.topNotification")--}}

            @include("user.profile.lotteryNotification" , [                                                            "userPoints"=>$userPoints ,
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
        <div class="col-md-3">
            <!-- BEGIN PROFILE SIDEBAR -->
        @include('partials.profileSidebar',[
                                        'user'=>$user ,
                                        'withInfoBox'=>true ,
                                        'withCompletionBox'=>true ,
                                        'withRegisterationDate'=>true,
                                        'withNavigation' => true,
                                        'withPhotoUpload' => true ,
                                          ]
                                          )
        <!-- END BEGIN PROFILE SIDEBAR -->
        </div>
        <div class="col-md-9">
            @if(!$user->lockProfile)
                @include('user.profile.profileEditView' , ["withBio"=>true , "withBirthdate"=>false , "withIntroducer"=>false , "text2"=>"کاربر گرامی ، پس از تکمیل اطلاعات شخصی(فیلد های پایین) امکان اصلاح اطلاعات ثبت شده وجود نخواهد داشت. لذا خواهشمند هستیم این اطلاعات را در صحت و دقت کامل تکمیل نمایید . باتشکر"])
            @else
                @include('user.profile.profileView')
            @endif
            <div id="profileMenuPage-sabteRotbe" class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
							<i class="flaticon-statistics"></i>
						</span>
                            <h3 class="m-portlet__head-text">
                                فیلم ها و جزواتی که خریده اید:
                            </h3>
                            <h2 class="m-portlet__head-label m-portlet__head-label--success">
                                <span style="white-space: nowrap;">
                                    <i class="la la-trophy"></i>
                                    ثبت رتبه 97
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>
                <div class="m-portlet__body">
                    <form method="POST" action="{{ action('Web\EventresultController@store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        <input name="event_id" type="hidden" value="3">
                        <input name="eventresultstatus_id" type="hidden" value="1">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group">
                                                <label for="rank">رتبه شما(الزامی)</label>
                                                <div class="m-input-icon m-input-icon--left">
                                                    <input type="text" name="rank" id="rank" class="form-control m-input m-input--air" placeholder="رتبه شما">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                                        <span>
                                                            <i class="flaticon-placeholder"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group">
                                                <label for="participationCode">شماره داوطلبی شما</label>
                                                <div class="m-input-icon m-input-icon--left">
                                                    <input type="text" name="participationCode" id="participationCode" class="form-control m-input m-input--air" placeholder="شماره داوطلبی شما">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                                        <span>
                                                            <i class="flaticon-placeholder"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                                <span class="m-form__help">شماره داوطلبی شما به صورت رمز شده ذخیره می شود و فقط مدیر سایت می تواند آن را مشاهده کند(حتی شما هم نمی بینید)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group">
                                                <label for="customFile">فایل کارنامه(الزامی)</label>
                                                <div></div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input m-input m-input--air" id="customFile">
                                                    <label class="custom-file-label" for="customFile">انتخاب فایل</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group">
                                                <div class="m-input-icon m-input-icon--left">
                                                    <textarea rows="5" name="comment" placeholder="آلاء چه نقشی در نتیجه شما داشته و چطور به شما کمک کرده؟" class="form-control m-input m-input--air"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row margin-top-20">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="m-checkbox-list">
                                                <label class="m-checkbox m-checkbox--state-primary font-red bold">
                                                    <input name="enableReportPublish" type="checkbox">
                                                    اجازه انتشار رتبه خود را در سایت می دهم
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-alert m-alert--icon alert alert-accent" role="alert">
                                        <div class="m-alert__icon">
                                            <i class="la la-warning"></i>
                                        </div>
                                        <div class="m-alert__text">
                                            <strong>توضیح: </strong> با زدن تیک بالا شما به ما اجازه می دهید تا رتبه ی شما را در سایت آلاء اعلام کنیم. اگر تمایلی به این کار ندارید می توانید این تیک را نزنید. بدیهی است که با زدن تیک فوق ، درج شماره داوطلبی الزامی خواهد بود .
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions row">
                            <div class="col-md-12 margiv-top-10">
                                <button type="submit" class="btn m-btn--pill m-btn--air btn-primary">
                                    ثبت کارنامه
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="profileMenuPage-filmVaJozve" class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
							<i class="flaticon-statistics"></i>
						</span>
                            <h3 class="m-portlet__head-text">
                                فیلم ها و جزواتی که خریده اید:
                            </h3>
                            <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                <span style="white-space: nowrap;">
                                    <i class="flaticon-multimedia-4"></i>
                                    فیلم ها و جزوات
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>
                <div class="m-portlet__body">

                    {{--<div class="m-alert m-alert--icon alert alert-warning" role="alert">--}}
                        {{--<div class="m-alert__icon">--}}
                            {{--<i class="la la-warning"></i>--}}
                        {{--</div>--}}
                        {{--<div class="m-alert__text">--}}
                            {{--<strong>شما محصولی سفارش نداده اید!</strong>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="text-center">--}}
                        {{--<button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">--}}
                            {{--مشاهده اردوها و هایش ها--}}
                        {{--</button>--}}
                    {{--</div>--}}

                </div>
            </div>
        </div>
    </div>
@endsection



@section('page-js')
    <!-- the main fileinput plugin file -->
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/fileinput.min.js"></script>--}}
    <script src="{{ mix('/js/user-profile.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/page-user-profile.js') }}"></script>
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
    <script src="/js/extraJS/scripts/profileUploadPhoto4.js" type="text/javascript"></script>
    <script src="/js/extraJS/scripts/verificationCode.js" type="text/javascript"></script>
    <script>

        var userAjax;
        var SweetAlert = function () {

            return {
                //main function to initiate the module
                init: function () {
                    $('.mt-sweetalert').each(function () {
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

                        $(this).click(function () {
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
                                function (isConfirm) {
                                    if (isConfirm) {
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

                                        if (userAjax) {
                                            userAjax.abort();
                                        }
                                        userAjax = $.ajax({
                                            type: "POST",
                                            url: "{{action("Web\UserController@removeFromLottery")}}",
                                            contentType: "application/json",
                                            dataType: "json",
                                            statusCode: {
                                                200: function (response) {
                                                    // console.log(response.responseText);
                                                    location.reload();
                                                },
                                                //The status for when the user is not authorized for making the request
                                                401: function (ressponse) {
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

        jQuery(document).ready(function () {
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
        {{--url: "{{action("Web\OrderController@addToArabiHozouri")}}",--}}
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
        {{--url: "{{action("Web\OrderController@removeArabiHozouri")}}",--}}
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
