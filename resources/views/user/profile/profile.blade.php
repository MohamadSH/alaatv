@extends("app" , ["pageName" => "profile"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("headPageLevelStyle")
    {{--<link rel="stylesheet" href="{{ mix('/css/page_level_style_all.css') }}">--}}
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("metadata")
    @parent()
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("pageBar")
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2"></i>
                <a href="{{action("Web\IndexPageController")}}">خانه</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                پروفایل
            </li>
        </ol>
    </nav>

@endsection

@section('page-css')
    <link href = "{{ mix('/css/user-profile.css') }}" rel = "stylesheet" type = "text/css"/>
    <style>
        .datepicker-plot-area.datepicker-persian {
            font-family: IRANSans !important;
        }
        .userFullname {
            text-shadow: 1px 1px 2px black, 0 0 1em blue, 0 0 0.2em darkblue;
        }
        .btnEditProfilePic {
            box-shadow: 0px 0px 11px 0px #8EACED !important;
        }
        .profile-usermenu {
            margin-right: -29px;
            margin-left: -29px;
        }
        .profile-usermenu button {
            text-align: right;
            padding-right: 30px;
        }
    </style>
    <style>
        #UserProfilePhoto,
        .file-input.theme-fas,
        .fileinput-btnBrowseUserImage,
        .fileinput-btnRemoveUserImage,
        .fileinput-previewClass .fileinput-remove,
        .fileinput-frameClass .file-footer-caption,
        .fileinput-frameClass .file-upload-indicator,
        .fileinput-frameClass .file-actions {
            display: none;
        }
        .fileinput-previewClass,
        .fileinput-previewClass .file-drop-zone {
            margin: 0px;
            padding: 0px;
            border: none;
        }
        .fileinput-previewClass .file-drop-zone {
        }
    </style>
@endsection

@section('content')
    @include("systemMessage.flash")


    <div class="row">
        <div class="col-12">
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
                    <form method="POST" action="https://sanatisharif.ir/eventresult" accept-charset="UTF-8" enctype="multipart/form-data"><input name="_token" type="hidden" value="Govi5kySbPo5DBVL0bg7X6ajjxwS5q1oNrKytqvU">
                        <input type="hidden" name="_token" value="Govi5kySbPo5DBVL0bg7X6ajjxwS5q1oNrKytqvU">
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

                    <div class="m-alert m-alert--icon alert alert-warning" role="alert">
                        <div class="m-alert__icon">
                            <i class="la la-warning"></i>
                        </div>
                        <div class="m-alert__text">
                            <strong>شما محصولی سفارش نداده اید!</strong>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">
                            مشاهده اردوها و هایش ها
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{--<input id="input-id" type="file" class="file" data-preview-file-type="text" >--}}

    {{--@if($user->bio != null)--}}
        {{--<div class="portlet light ">--}}
            {{--<div class="portlet-title tabbable-line">--}}
                {{--<div class="caption caption-md">--}}
                    {{--<i class="icon-globe theme-font hide"></i>--}}
                    {{--<span class="caption-subject font-blue-madison bold uppercase">درباره من</span>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="portlet-body">--}}
                {{--<div class="content">--}}
                    {{--<p style=" text-align: justify; line-height: initial;">--}}
                        {{--{!! $user->bio !!}--}}
                    {{--</p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--@endif--}}
















    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
            {{--<!-- BEGIN PROFILE CONTENT -->--}}
            {{--<div class="profile-content">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<div class="portlet light ">--}}
                            {{--<div class="portlet-title tabbable-line">--}}
                                {{--<div class="caption caption-md">--}}
                                    {{--<i class="icon-globe theme-font hide"></i>--}}
                                    {{--<span class="caption-subject font-blue-madison bold uppercase">--}}
                                        {{--اصلاح پروفایل--}}
                                    {{--</span>--}}
                                {{--</div>--}}
                                {{--<ul class="nav nav-tabs">--}}
                                    {{--<li class="active">--}}
                                        {{--<a href="#tab_1_1" data-toggle="tab">--}}
                                            {{--اطلاعات شخصی--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    {{--For re-enabling first you need to complete updating password in UserController@update (using the existed snippet)--}}
                                    {{--@permission((Config::get('constants.EDIT_USER_ACCESS')))--}}
                                    {{--<li @if(strcmp(session('tabPane') , "tab_1_3") == 0) {{ "class=active" }} @endif>--}}
                                        {{--<a href="#tab_1_3" data-toggle="tab">تغییر رمز عبور</a>--}}
                                    {{--</li>--}}
                                    {{--@endpermission--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                            {{--<div class="portlet-body">--}}
                                {{--<div class="tab-content">--}}
                                    {{--<!-- PERSONAL INFO TAB -->--}}
                                    {{--<div class="tab-pane active" id="tab_1_1">--}}
                                        {{--@if(!$user->lockProfile)--}}
                                            {{--@include('user.profile.profileEditView' , ["withBio"=>true , "withBirthdate"=>false , "withIntroducer"=>false , "text2"=>"کاربر گرامی ، پس از تکمیل اطلاعات شخصی(فیلد های پایین) امکان اصلاح اطلاعات ثبت شده وجود نخواهد داشت. لذا خواهشمند هستیم این اطلاعات را در صحت و دقت کامل تکمیل نمایید . باتشکر"])--}}
                                        {{--@else--}}
                                            {{--@include('user.profile.profileView')--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                    {{--<!-- END PERSONAL INFO TAB -->--}}
                                    {{--<!-- CHANGE PASSWORD TAB -->--}}
                                    {{--<div class="tab-pane" id="tab_1_3">--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-12">--}}
                                                {{--<!-- BEGIN Portlet PORTLET-->--}}
                                                {{--<div class="portlet light bg-inverse">--}}
                                                    {{--<div class="portlet-title">--}}
                                                        {{--<div class="caption font-purple-plum">--}}
                                                            {{--<span class="caption-subject bold uppercase"> درخواست رمز عبور اتوماتیک</span>--}}
                                                            {{--<span class="caption-helper">ارسال از طریق پیامک</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="portlet-body">--}}
                                                        {{--<div class="row">--}}
                                {{--<form action="{{ action("Web\UserController@sendGeneratedPassword") }}"--}}
                                                                  {{--method="post">--}}
                                                                {{--{{ csrf_field() }}--}}
                                                                {{--<div class="form-actions">--}}
                                                                    {{--برای ارسال پیامک رمز عبور جدید بر روی این دکمه کلیک--}}
                                                                    {{--کنید--}}
                                                                    {{--<button type="submit" class="btn yellow">ارسال پیامک--}}
                                                                        {{--رمز عبور--}}
                                                                    {{--</button>--}}
                                                                {{--</div>--}}
                                                            {{--</form>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<!-- END Portlet PORTLET-->--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-12">--}}
                                                {{--<!-- BEGIN Portlet PORTLET-->--}}
                                                {{--<div class="portlet light bg-inverse">--}}
                                                    {{--<div class="portlet-title">--}}
                                                        {{--<div class="caption font-purple-plum">--}}
                                                            {{--<span class="caption-subject bold uppercase"> رمز عبور دلخواه</span>--}}
                                                            {{--<span class="caption-helper">تنظیم رمز عبور دلخواه</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="portlet-body">--}}
                                                        {{--{!! Form::open(['method' => 'PUT', 'action' => ['UserController@update' , Auth::user()]]) !!}--}}
                                                            {{--{!! Form::hidden('updateType',"password") !!}--}}
                                                            {{--<div class="form-group {{ $errors->has('oldPassword') ? ' has-error' : '' }}">--}}
                                                                {{--<label class="control-label">رمز عبور فعلی</label>--}}
                                                                {{--<input type="password" class="form-control"--}}
                                                                       {{--name="oldPassword"/>--}}
                                                                {{--@if ($errors->has('oldPassword'))--}}
                                                                    {{--<span class="help-block">--}}
                                                                {{--<strong>{{ $errors->first('oldPassword') }}</strong>--}}
                                                              {{--</span>--}}
                                                                {{--@endif--}}
                                                            {{--</div>--}}
                                                            {{--<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">--}}
                                                                {{--<label class="control-label">رمز عبور جدید</label>--}}
                                                                {{--<input type="password" class="form-control"--}}
                                                                       {{--name="password"/>--}}
                                                                {{--@if ($errors->has('password'))--}}
                                                                    {{--<span class="help-block">--}}
                                                                {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                                              {{--</span>--}}
                                                                {{--@endif--}}
                                                            {{--</div>--}}

                                                            {{--<div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">--}}
                                                                {{--<label class="control-label">تکرار رمز عبور جدید</label>--}}
                                                                {{--<input type="password" class="form-control"--}}
                                                                       {{--name="password_confirmation"/>--}}
                                                                {{--@if ($errors->has('password_confirmation'))--}}
                                                                    {{--<span class="help-block">--}}
                                                                 {{--<strong>{{ $errors->first('password_confirmation') }}</strong>--}}
                                                            {{--</span>--}}
                                                                {{--@endif--}}
                                                            {{--</div>--}}

                                                            {{--<div class="margin-top-10">--}}
                                                                {{--<button type="submit" class="btn green"> تغییر</button>--}}
                                                            {{--</div>--}}
                                                        {{--{!! Form::close() !!}--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<!-- END Portlet PORTLET-->--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                    {{--</div>--}}
                                    {{--<!-- END CHANGE PASSWORD TAB -->--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--@if($user->bio != null)--}}
                            {{--<div class="portlet light ">--}}
                                {{--<div class="portlet-title tabbable-line">--}}
                                    {{--<div class="caption caption-md">--}}
                                        {{--<i class="icon-globe theme-font hide"></i>--}}
                                        {{--<span class="caption-subject font-blue-madison bold uppercase">درباره من</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="portlet-body">--}}
                                    {{--<div class="content">--}}
                                        {{--<p style=" text-align: justify; line-height: initial;">--}}
                                            {{--{!! $user->bio !!}--}}
                                        {{--</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- END PROFILE CONTENT -->--}}
        {{--</div>--}}
    {{--</div>--}}

@endsection



@section('page-js')
    <!-- the main fileinput plugin file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/fileinput.min.js"></script>
    <script src="{{ mix('/js/user-profile.js') }}"></script>

    <script type="text/javascript">

        function getFormData($form){
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }

        $(document).ready(function() {

            $(document).on('click', '#btnEditUserPhoto', function() {
                $('#UserProfilePhoto').trigger('click');
            });

            // $("#input-id").fileinput();


            $('#UserProfilePhoto').fileinput({
                theme: 'fas',
                showUpload: false,
                showCaption: false,
                browseClass: "fileinput-btnBrowseUserImage",
                removeClass: "fileinput-btnRemoveUserImage",
                captionClass: "fileinput-captionClass",
                previewClass: "fileinput-previewClass",
                frameClass: "fileinput-frameClass",
                mainClass: "fileinput-mainClass",
                fileType: "any",
                // previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
                overwriteInitial: true,
                initialPreviewAsData: true,
                // initialPreview: [
                //     "http://lorempixel.com/1920/1080/transport/1",
                //     "http://lorempixel.com/1920/1080/transport/2",
                //     "http://lorempixel.com/1920/1080/transport/3"
                // ],
                // initialPreviewConfig: [
                //     {caption: "transport-1.jpg", size: 329892, width: "120px", url: "{$url}", key: 1},
                //     {caption: "transport-2.jpg", size: 872378, width: "120px", url: "{$url}", key: 2},
                //     {caption: "transport-3.jpg", size: 632762, width: "120px", url: "{$url}", key: 3}
                // ]
            });

            $(document).on('change', '#UserProfilePhoto', function(event) {

                var files = $(this)[0].files; // puts all files into an array

                var filesize = ((files[0].size/1024)).toFixed(4); // KB

                if (filesize < 500) {

                    $('.imgUserProfileImage').fadeOut(0);
                    $('.file-input.theme-fas').fadeIn();
                    $('.submitProfilePic').fadeIn();
                } else {
                    Swal({
                        title: '',
                        text: 'حجم عکس حداکثر 500 کیلوبایت باشد',
                        type: 'dabger',
                        confirmButtonText: 'بستن'
                    });

                    mUtil.scrollTop();
                }
            });

            function showSabteRotbe() {
                $('#profileMenuPage-sabteRotbe').slideDown();
                $('#profileMenuPage-filmVaJozve').slideUp();
                $('#profileMenuPage-setting').slideUp();
            }
            function showFilmVaJozve() {
                $('#profileMenuPage-filmVaJozve').slideDown();
                $('#profileMenuPage-sabteRotbe').slideUp();
                $('#profileMenuPage-setting').slideUp();
            }
            function showSetting() {
                $('#profileMenuPage-setting').slideDown();
                $('#profileMenuPage-filmVaJozve').slideUp();
                $('#profileMenuPage-sabteRotbe').slideUp();
            }
            showSetting();

            $('#birthdate').persianDatepicker({
                observer: true,
                format: 'YYYY/MM/DD',
                altField: '#birthdateAlt'
            });


            {{--$(document).on('click', '#btnUpdateProfileInfoForm', function(){--}}


                {{--var $form = $("#profileForm-setting");--}}
                {{--var data = getFormData($form);--}}
                {{--console.log(data);--}}
                {{--mApp.block('#profileMenuPage-setting', {--}}
                    {{--overlayColor: "#000000",--}}
                    {{--type: "loader",--}}
                    {{--state: "success",--}}
                    {{--message: "کمی صبر کنید..."--}}
                {{--});--}}

                {{--setTimeout(function() {--}}

                    {{--mApp.unblock('#profileMenuPage-setting');--}}

                    {{--Swal({--}}
                        {{--title: '',--}}
                        {{--text: 'اطلاعات شما ویرایش شد.',--}}
                        {{--type: 'success',--}}
                        {{--confirmButtonText: 'بستن'--}}
                    {{--});--}}

                {{--}, 2e3);--}}

                {{--$.ajax({--}}
                    {{--type: 'PUT',--}}
                    {{--url: {{ [(isset($formAction))?$formAction:'Web\UserController@update' , Auth::user()] }},--}}
                    {{--data: {},--}}
                    {{--statusCode: {--}}
                        {{--//The status for when action was successful--}}
                        {{--200: function (response) {--}}
                            {{--// console.log(response);--}}

                            {{--$('.inputVerificationWarper').fadeIn();--}}
                            {{--mApp.unblock('.SendMobileVerificationCodeWarper');--}}

                            {{--Swal({--}}
                                {{--title: '',--}}
                                {{--text: 'کد تایید برای شماره همراه شما پیامک شد.',--}}
                                {{--type: 'success',--}}
                                {{--confirmButtonText: 'بستن'--}}
                            {{--});--}}
                        {{--},--}}
                        {{--//The status for when the user is not authorized for making the request--}}
                        {{--403: function (response) {--}}
                            {{--// window.location.replace("/403");--}}
                        {{--},--}}
                        {{--//The status for when the user is not authorized for making the request--}}
                        {{--401: function (response) {--}}
                            {{--// window.location.replace("/403");--}}
                        {{--},--}}
                        {{--404: function (response) {--}}
                            {{--// window.location.replace("/404");--}}
                        {{--},--}}
                        {{--//The status for when form data is not valid--}}
                        {{--422: function (response) {--}}
                            {{--console.log(response);--}}
                        {{--},--}}
                        {{--//The status for when there is error php code--}}
                        {{--500: function (response) {--}}
                            {{--Swal({--}}
                                {{--title: 'توجه!',--}}
                                {{--text: 'خطای سیستمی رخ داده است.',--}}
                                {{--type: 'danger',--}}
                                {{--confirmButtonText: 'بستن'--}}
                            {{--});--}}
                        {{--},--}}
                        {{--//The status for when there is error php code--}}
                        {{--503: function (response) {--}}
                            {{--Swal({--}}
                                {{--title: 'توجه!',--}}
                                {{--text: 'خطای پایگاه داده!',--}}
                                {{--type: 'danger',--}}
                                {{--confirmButtonText: 'بستن'--}}
                            {{--});--}}
                        {{--}--}}
                    {{--}--}}
                {{--});--}}



            {{--});--}}

            $(document).on('click', '#btnSendMobileVerificationCode', function(){

                mApp.block('.SendMobileVerificationCodeWarper', {
                    overlayColor: "#000000",
                    type: "loader",
                    state: "success",
                    message: "کمی صبر کنید..."
                });

                setTimeout(function() {

                    $('#btnSendMobileVerificationCode').fadeOut();
                    $('.inputVerificationWarper').fadeIn();
                    mApp.unblock('.SendMobileVerificationCodeWarper');

                    Swal({
                        title: '',
                        text: 'کد تایید برای شماره همراه شما پیامک شد.',
                        type: 'info',
                        confirmButtonText: 'بستن'
                    });

                    $('.inputVerificationWarper').removeClass('d-none');

                    mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);

                }, 2e3);

                {{--$.ajax({--}}
                {{--type: 'POST',--}}
                {{--url: {{ action('Web\MobileVerificationController@verify') }},--}}
                {{--data: {},--}}
                {{--statusCode: {--}}
                {{--//The status for when action was successful--}}
                {{--200: function (response) {--}}
                {{--// console.log(response);--}}

                {{--$('.inputVerificationWarper').fadeIn();--}}
                {{--mApp.unblock('.SendMobileVerificationCodeWarper');--}}

                {{--Swal({--}}
                {{--title: '',--}}
                {{--text: 'کد تایید برای شماره همراه شما پیامک شد.',--}}
                {{--type: 'success',--}}
                {{--confirmButtonText: 'بستن'--}}
                {{--});--}}
                {{--},--}}
                {{--//The status for when the user is not authorized for making the request--}}
                {{--403: function (response) {--}}
                {{--// window.location.replace("/403");--}}
                {{--},--}}
                {{--//The status for when the user is not authorized for making the request--}}
                {{--401: function (response) {--}}
                {{--// window.location.replace("/403");--}}
                {{--},--}}
                {{--404: function (response) {--}}
                {{--// window.location.replace("/404");--}}
                {{--},--}}
                {{--//The status for when form data is not valid--}}
                {{--422: function (response) {--}}
                {{--console.log(response);--}}
                {{--},--}}
                {{--//The status for when there is error php code--}}
                {{--500: function (response) {--}}
                {{--Swal({--}}
                {{--title: 'توجه!',--}}
                {{--text: 'خطای سیستمی رخ داده است.',--}}
                {{--type: 'danger',--}}
                {{--confirmButtonText: 'بستن'--}}
                {{--});--}}
                {{--},--}}
                {{--//The status for when there is error php code--}}
                {{--503: function (response) {--}}
                {{--Swal({--}}
                {{--title: 'توجه!',--}}
                {{--text: 'خطای پایگاه داده!',--}}
                {{--type: 'danger',--}}
                {{--confirmButtonText: 'بستن'--}}
                {{--});--}}
                {{--}--}}
                {{--}--}}
                {{--});--}}



            });
            $(document).on('click', '#btnVerifyMobileVerificationCode', function(){

                mApp.block('.SendMobileVerificationCodeWarper', {
                    overlayColor: "#000000",
                    type: "loader",
                    state: "success",
                    message: "کمی صبر کنید..."
                });

                setTimeout(function() {

                    $('.inputVerificationWarper').fadeOut();
                    $('.SendMobileVerificationCodeWarper').fadeOut();
                    $('.mobileUnVerifyMessage').removeClass('d-block');
                    $('.mobileUnVerifyMessage').addClass('d-none');
                    $('.mobileVerifyMessage').removeClass('d-none');
                    $('.mobileVerifyMessage').addClass('d-block');

                    mApp.unblock('.SendMobileVerificationCodeWarper');

                    Swal({
                        title: '',
                        text: 'شماره موبایل شما تایید شد.',
                        type: 'success',
                        confirmButtonText: 'بستن'
                    });

                    mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);

                }, 2e3);

                {{--$.ajax({--}}
                {{--type: 'POST',--}}
                {{--url: {{ action('Web\MobileVerificationController@verify') }},--}}
                {{--data: {},--}}
                {{--statusCode: {--}}
                {{--//The status for when action was successful--}}
                {{--200: function (response) {--}}
                {{--// console.log(response);--}}

                {{--$('.inputVerificationWarper').fadeIn();--}}
                {{--mApp.unblock('.SendMobileVerificationCodeWarper');--}}

                {{--Swal({--}}
                {{--title: '',--}}
                {{--text: 'کد تایید برای شماره همراه شما پیامک شد.',--}}
                {{--type: 'success',--}}
                {{--confirmButtonText: 'بستن'--}}
                {{--});--}}
                {{--},--}}
                {{--//The status for when the user is not authorized for making the request--}}
                {{--403: function (response) {--}}
                {{--// window.location.replace("/403");--}}
                {{--},--}}
                {{--//The status for when the user is not authorized for making the request--}}
                {{--401: function (response) {--}}
                {{--// window.location.replace("/403");--}}
                {{--},--}}
                {{--404: function (response) {--}}
                {{--// window.location.replace("/404");--}}
                {{--},--}}
                {{--//The status for when form data is not valid--}}
                {{--422: function (response) {--}}
                {{--console.log(response);--}}
                {{--},--}}
                {{--//The status for when there is error php code--}}
                {{--500: function (response) {--}}
                {{--Swal({--}}
                {{--title: 'توجه!',--}}
                {{--text: 'خطای سیستمی رخ داده است.',--}}
                {{--type: 'danger',--}}
                {{--confirmButtonText: 'بستن'--}}
                {{--});--}}
                {{--},--}}
                {{--//The status for when there is error php code--}}
                {{--503: function (response) {--}}
                {{--Swal({--}}
                {{--title: 'توجه!',--}}
                {{--text: 'خطای پایگاه داده!',--}}
                {{--type: 'danger',--}}
                {{--confirmButtonText: 'بستن'--}}
                {{--});--}}
                {{--}--}}
                {{--}--}}
                {{--});--}}



            });

            $(document).on('click', '.profile-usermenu button', function(){
                let menu = $(this).attr('menu');
                if(menu=='profileMenuPage-sabteRotbe') {
                    showSabteRotbe();
                } else if(menu=='profileMenuPage-filmVaJozve') {
                    showFilmVaJozve();
                } else if(menu=='profileMenuPage-setting') {
                    showSetting();
                }
                mUtil.scrollTop();
            });

        });

    </script>
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
