@extends("app" , ["pageName" => "submitRequest"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet" type="text/css"/>
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
                <span>زندگی آلایی </span>
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
    <div class="row">
        <div class="col-md-12">
            <img src="/img/extra/asiatech_internet_raygan_rsz.jpg" width="100%">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-body">
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
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
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
            <div class="profile-content">
                @if($userHasRegistered)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-purple-intense bold uppercase">
                                                    درخواست اینترنت رایگان آسیاتک
                                    </span>
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    @if(isset($userVoucher))
                                        <p class="list-group-item  bg-green-haze bg-font-green margin-bottom-10" style="text-align: justify; line-height: normal">
                                            درخواست شما برای دریافت اینترنت رایگان آسیاتک تایید شده است
                                            @if(isset($userVoucher))
                                                <br>
                                                کد تخفیف شما:
                                                <br>
                                                <label class="font-dark bold" dir="ltr" style="font-size: larger">{{$userVoucher->code}}</label>
                                                <br>
                                                برای اطلاع از نحوه ثبت نام و استفاده از کد تخفیف فایل زیر را دانلود نمایید
                                            @else
                                                هنوز کد تخفیف به شما اختصاص داده نشده است . در اسرع وقت کد شما داده خواهد شد و در همین صفحه قابل مشاهده خواهد بود
                                            @endif
                                        </p>
                                    @else
                                        <p class="list-group-item  bg-blue-soft bg-font-blue-soft margin-bottom-10" style="text-align: justify; line-height: normal">
                                            در خواست شما برای اینترنت رایگان آسیاتک در صف بررسی قرار گرفته است .
                                            @if(isset($rank))
                                                <br>
                                                <span class="bold" style="font-size: larger">شما نفر <label class="font-yellow-saffron bold">{{$rank}}</label> صف هستید</span>
                                            @else
                                                <br>
                                                نوبت شما در صف مشخص نمی باشد
                                            @endif
                                        </p>
                                    @endif
                                        <div class="alert alert-info alert-dismissable" style="text-align: justify">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <strong><a href="https://cdn.sanatisharif.ir/upload/rahnamaye_sabtename_asiatech.pdf?download=1">برای دانلود راهنمای استفاده از کد تخفیف آسیاتک کلیک کنید</a></strong>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-green bold uppercase">
                                                    اطلاعات ثبت شده شما
                                    </span>
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    @include('user.profile.profileView' , ["user" => $user])
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-purple-intense bold uppercase">
                                                    ثبت درخواست اینترنت رایگان آسیاتک
                                    </span>
                                    </div>
                                </div>

                                <div class="portlet-body">
                                    @include('user.profile.profileEditView' , ["withBio"=>false,
                                                                                "withBirthdate"=>true ,
                                                                                "withIntroducer"=>true ,
                                                                                "submitCaption" => "ثبت درخواست" ,
                                                                                "disableSubmit" =>(!$user->mobileNumberVerification || !isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)?true:false ,
                                                                                "text1p1"=>"قسمت‌های ستاره دار ضروری است." ,
                                                                                "text1p2"=>"پس از تکمیل فرم زیر، درخواست شما در صف بررسی اینترنت رایگان آسیاتک قرار خواهد گرفت." ,
                                                                                "text2" =>" اطلاعات وارد شده پس از ثبت درخواست قابل تغییر نیستند.",
                                                                                "formAction" => "UserController@submitVoucherRequest",
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
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/lib/persian-date.js" type="text/javascript" ></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/profile.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript" ></script>
@endsection

@section("extraJS")
    <script type="text/javascript">
        var mobileVerification = {{$user->mobileNumberVerification}};
        var profileHasPhto = {{(strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)?0:1}}
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
        jQuery(document).ready(function() {
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

        var Upload = function (file) {
            this.file = file;
        };

        Upload.prototype.getType = function() {
            return this.file.type;
        };
        Upload.prototype.getSize = function() {
            return this.file.size;
        };
        Upload.prototype.getName = function() {
            return this.file.name;
        };
        Upload.prototype.doUpload = function () {
            var formData = new FormData();
            $("#profilePhotoAjaxLoadingSpinner").show();
            // add assoc key values, this will be posts values
            if(this.file == undefined)
            {
                $("#profilePhotoAjaxLoadingSpinner").hide();
                return false;
            }
            formData.append("photo", this.file, this.getName());
            // formData.append("upload_file", true);
            $.ajax({
                type: "POST",
                url: "{{action("UserController@updatePhoto")}}",
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        // For handling the progress of the upload
                        myXhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                $('progress').attr({
                                    value: e.loaded,
                                    max: e.total,
                                });
                            }
                        } , false);
                    }
                    return myXhr;
                },
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        // console.log(response);
                        $("#profilePhoto").attr("src" , response.newPhoto);
                        $("#profilePhotoAjaxFileInputClose").trigger("click");
                        $("#profileEditViewText3-span2").hide();
                        if(mobileVerification)
                        {
                            $("#profileEditViewText3").hide();
                            $("#updateProfileInfoFormButton").prop("disabled" , false);
                        }
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (response) {
                        window.location.replace("/403");
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        console.log(response);
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        console.log(response.responseText);
//                            toastr["error"]("خطای برنامه!", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    503: function (response) {
//                            toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                    }
                },
                async: true,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                // timeout: 60000,
            });

            $("#profilePhotoAjaxLoadingSpinner").hide();
        };

        Upload.prototype.progressHandling = function (event) {
            var percent = 0;
            var position = event.loaded || event.position;
            var total = event.total;
            var progress_bar_id = "#progress-wrp";
            if (event.lengthComputable) {
                percent = Math.ceil(position / total * 100);
            }
            // update progressbars classes so it fits your code
            $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
            $(progress_bar_id + " .status").text(percent + "%");
        };

        //Change id to your id
        $("#profilePhotoAjaxForm").on("submit", function (e) {
            e.preventDefault();
            var file = $("#profilePhotoFile")[0].files[0];
            var upload = new Upload(file);

            // maby check size or type here with upload.getSize() and upload.getType()

            // execute upload
            upload.doUpload();
        });

        $("#profilePhotoFile").change(function (){

            var fileName = $(this).val();
            if(fileName.length > 0)
            {
                $("#uploadProfilePhotoAjaxSubmit").show();
            }
            else
            {
                $("#uploadProfilePhotoAjaxSubmit").hide();
            }
        });
    </script>
@endsection
