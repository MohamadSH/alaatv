@extends("app" , ["pageName" => "submitRequest"])

@section("headPageLevelPlugin")
    <link href = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/persian-datepicker/dist/css/persian-datepicker-1.1.3.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link rel = "stylesheet" href = "{{ mix('/css/page_level_style_all.css') }}">
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed page-md"
@endsection

@section("metadata")
    @parent()
    <meta name = "_token" content = "{{ csrf_token() }}">
@endsection

@section("pageBar")
    <div class = "page-bar">
        <ul class = "page-breadcrumb">
            <li>
                <i class = "icon-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>زندگی آلایی </span>
                <i class = "fa fa-angle-left"></i>
            </li>
            <li>
                <span>ثبت درخواست اینترنت آسیاتک</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    {{--EXCHANGE LOTTERY--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<div class="alert alert-block bg-blue bg-font-blue fade in">--}}
    {{--<button type="button" class="close" data-dismiss="alert"></button>--}}
    {{--<h4 class="alert-heading text-center" style="line-height: normal;">نام شما در شرکت کنندگان همایش رایگان حضوری عربی آقای ناصح زاده روز 27 خرداد ثبت شده است</h4>--}}
    {{--<h4 class="alert-heading text-center" style="line-height: normal;">برای انصراف از شرکت در همایش بر روی دکمه زیر کلیک کنید</h4>--}}
    {{--<p style="text-align: center;">--}}
    {{--<button class="btn mt-sweetalert-hamayesh-arabi" data-title="آیا از شرکت خود مطمئنید؟" data-type="warning" data-allow-outside-click="true" data-show-confirm-button="true" data-show-cancel-button="true" data-cancel-button-class="btn-danger" data-cancel-button-text="خیر" data-confirm-button-text="بله شرکت می کنم" data-confirm-button-class="btn-info" style="background: #d6af18;">ثبت نام در همایش حضوری</button>--}}
    {{--<button class="btn btn-lg" id="bt-cancel-hamayesh-arabi"  style="background: #d6af18;">انصراف می دهم</button>--}}
    {{--</p>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    @include("systemMessage.flash")
    <div class = "row">
        <div class = "col-md-12">
            <img src = "/img/extra/asiatech_internet_raygan_rsz.jpg" width = "100%">
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12">
            <div class = "portlet light ">
                <div class = "portlet-body">
                    <p>
                        آلایی هایی که اینترنت آسیاتک دارند، هم اکنون ترافیک آن ها از سایت آلاء رایگان می باشد.
                    </p>
                    <p>
                        بقیه دوستان هم می تونند از طریق فرم زیر درخواست کد تخفیف 100% آسیاتک بدهند و رایگان ADSL آسیاتک را دریافت کنند.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class = "profile-sidebar">
                {{--ToDo: customzing photo layout for supporting jquery upload--}}
                @include('partials.profileSidebar',[
                                            'user'=>$user ,
                                            'withInfoBox'=>true ,
                                              'withPhotoUpload' => ($userHasRegistered)?false:true
                                             ]
                         )

            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class = "profile-content">
                @if($userHasRegistered)
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "portlet light ">
                                <div class = "portlet-title tabbable-line">
                                    <div class = "caption caption-md">
                                        <i class = "icon-globe theme-font hide"></i>
                                        <span class = "caption-subject font-purple-intense bold uppercase">
                                                    درخواست اینترنت رایگان آسیاتک
                                    </span>
                                    </div>
                                </div>

                                <div class = "portlet-body">
                                    @if(isset($userVoucher))
                                        <p class = "list-group-item  bg-green-haze bg-font-green margin-bottom-10" style = "text-align: justify; line-height: normal">
                                            درخواست شما برای دریافت اینترنت رایگان آسیاتک تایید شده است
                                            @if(isset($userVoucher))
                                                <br>
                                            کد تخفیف شما:
                                                <br>
                                                <label class = "font-dark bold" dir = "ltr" style = "font-size: larger">{{$userVoucher->code}}</label>
                                                <br>
                                            برای اطلاع از نحوه ثبت نام و استفاده از کد تخفیف فایل زیر را دانلود
                                            نمایید
                                            @else
                                            هنوز کد تخفیف به شما اختصاص داده نشده است . در اسرع وقت کد شما داده
                                            خواهد شد و در همین صفحه قابل مشاهده خواهد بود
                                            @endif
                                        </p>
                                    @else
                                        <p class = "list-group-item  bg-blue-soft bg-font-blue-soft margin-bottom-10" style = "text-align: justify; line-height: normal">
                                            در خواست شما برای اینترنت رایگان آسیاتک در صف بررسی قرار گرفته است .
                                            @if(isset($rank))
                                                <br>
                                                <span class = "bold" style = "font-size: larger">شما نفر <label class = "font-yellow-saffron bold">{{$rank}}</label> صف هستید</span>
                                            @else
                                                <br>
                                            نوبت شما در صف مشخص نمی باشد
                                            @endif
                                        </p>
                                    @endif
                                    <div class = "alert alert-info alert-dismissable" style = "text-align: justify">
                                        <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true"></button>
                                        <strong>
                                            <a href = "https://cdn.alaatv.com/upload/rahnamaye_sabtename_asiatech.pdf?download=1">برای دانلود راهنمای استفاده از کد تخفیف آسیاتک کلیک کنید</a>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "portlet light ">
                                <div class = "portlet-title tabbable-line">
                                    <div class = "caption caption-md">
                                        <i class = "icon-globe theme-font hide"></i>
                                        <span class = "caption-subject font-green bold uppercase">
                                                    اطلاعات ثبت شده شما
                                    </span>
                                    </div>
                                </div>

                                <div class = "portlet-body">
                                    @include('user.profile.profileView' , ["user" => $user])
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class = "row">
                        <div class = "col-md-12">
                            <div class = "portlet light ">
                                <div class = "portlet-title tabbable-line">
                                    <div class = "caption caption-md">
                                        <i class = "icon-globe theme-font hide"></i>
                                        <span class = "caption-subject font-purple-intense bold uppercase">
                                                    ثبت درخواست اینترنت رایگان آسیاتک
                                    </span>
                                    </div>
                                </div>

                                <div class = "portlet-body">
                                    @include('user.profile.profileEditView' , ["withBio"=>false,
                                                                                "withBirthdate"=>true ,
                                                                                "withIntroducer"=>true ,
                                                                                "submitCaption" => "ثبت درخواست" ,
                                                                                "disableSubmit" =>(!$user->hasVerifiedMobile() || !isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)?true:false ,
                                                                                "text1p1"=>"قسمت‌های ستاره دار ضروری است." ,
                                                                                "text1p2"=>"پس از تکمیل فرم زیر، درخواست شما در صف بررسی اینترنت رایگان آسیاتک قرار خواهد گرفت." ,
                                                                                "text2" =>" اطلاعات وارد شده پس از ثبت درخواست قابل تغییر نیستند.",
                                                                                "formAction" => "Web\VoucherController@submitVoucherRequest",
                                                                                "text3" =>1,
                                                                                "requiredFields"=>["province" ,
                                                                                                    "city" ,
                                                                                                    "address" ,
                                                                                                    "postalCode" ,
                                                                                                    "gender" ,
                                                                                                    "birthdate" ,
                                                                                                    "school",
                                                                                                    "major",
                                                                                                    "introducedBy",
                                                                                                    "email",
                                                                                                    ],
                                                                                ]
                                                                    )
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/bootstrap-toastr/toastr.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/jquery.sparkline.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/morris/morris.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/lib/persian-date-1.0.5.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/profile.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/dashboard.min.js" type = "text/javascript"></script>
    <script src = "/assets/pages/scripts/ui-toastr.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/dist/js/persian-datepicker-1.1.3.min.js" type = "text/javascript"></script>
    <script src = "/js/extraJS/scripts/profileUploadPhoto4.js" type = "text/javascript"></script>
    <script src = "/js/extraJS/scripts/verificationCode.js" type = "text/javascript"></script>
@endsection

@section("extraJS")
    <script type = "text/javascript">
        var mobileVerification = {{($user->hasVerifiedMobile())?1:0}};
        /**
         * Set token for ajax request
         */
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            });
        });
        var userAjax;
        jQuery(document).ready(function () {
            $("#birthdate").persianDatepicker({
                altField: '#birthdateAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });
        });

    </script>
@endsection
