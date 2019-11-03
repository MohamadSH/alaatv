@extends('app' , ['pageName' => 'profile'])

@section('page-css')
    <link href="{{ mix('/css/user-completeInfo.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="m-alert m-alert--outline m-alert--outline-2x alert alert-success alert-dismissible fade show" role="alert">
                <strong>
                    هدیه آلاء به دانش‌آموز امروز، دانشجوی فردا
                    ۱۳ آبان تا ۱۶ آذر                </strong>
            </div>
        </div>
    </div>
    @include('systemMessage.flash')
    @if(!$hadGotGiftBefore &&  !$hasGotGiftBefore)
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="m-alert m-alert--outline m-alert--outline-2x alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>
                <strong>
                    قبل از دریافت هدیه هویت خودتو تایید کن
                </strong>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        @if(!$hadGotGiftBefore &&  !$hasGotGiftBefore)
        <div class="col-md-6 mx-auto">


            <div class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-setting">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
							<i class="fa fa-chart-line"></i>
						</span>
                            <h2 class="m-portlet__head-label m-portlet__head-label--warning">
                                <span>
                                    <i class="fa fa-cogs"></i>
                                    تایید اطلاعات شخصی
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>
                <div class="m-portlet__body">

                    {!! Form::model($user,['method' => 'POST','url' => route('web.user.update.partial') , 'role'=>'form' , 'id' => 'profileForm-setting']) !!}
                    {!! Form::hidden('updateType',"profile") !!}

                        <div class="row">
                            <div class="col-md-6">

                                    <div class="form-group m-form__group {{ $errors->has('firstName') ? ' has-danger' : '' }}">
                                        <label for="firstName">نام</label>
                                        <div class="m-input-icon m-input-icon--left">
                                            <input type="text" name="firstName" id="firstName" class="form-control m-input m-input--air" placeholder="نام" @if(isset($user->firstName))value="{{ $user->firstName }}"@endif @if(isset($user->firstName)) disabled="disabled" @endif>
                                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class="fa fa-user"></i>
                                    </span>
                                </span>
                                        </div>
                                    </div>

                            </div>
                            <div class="col-md-6">

                                    <div class="form-group m-form__group {{ $errors->has('lastName') ? ' has-danger' : '' }}">
                                        <label for="lastName">نام خانوادگی</label>
                                        <div class="m-input-icon m-input-icon--left">
                                            <input type="text" name="lastName" id="lastName" class="form-control m-input m-input--air" placeholder="نام خانوادگی" @if(isset($user->lastName))value="{{ $user->lastName }}"@endif @if(isset($user->lastName)) disabled="disabled" @endif>
                                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class="fa fa-user"></i>
                                    </span>
                                </span>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group m-form__group {{ $errors->has('province') ? ' has-danger' : '' }}">
                                    <label for="province">استان</label>
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" name="province" id="province" class="form-control m-input m-input--air" placeholder="استان" @if(isset($user->province))value="{{ $user->province }}"@endif @if(isset($user->province)) disabled="disabled" @endif>
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="fa fa-location-arrow"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group m-form__group {{ $errors->has('city') ? ' has-danger' : '' }}">
                                    <label for="city">شهر</label>
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" name="city" id="city" class="form-control m-input m-input--air" placeholder="شهر" @if(isset($user->city))value="{{ $user->city }}"@endif @if(isset($user->city)) disabled="disabled" @endif>
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="fa fa-location-arrow"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">


                                <div class="form-group m-form__group {{ $errors->has('gender_id') ? ' has-danger' : '' }}">
                                    <label for="gender_id">جنسیت</label>
                                    <div class="m-input-icon m-input-icon--left">
                                        @if(isset($user->gender_id))
                                        {!! Form::select('gender_id',$genders,null,['class' => 'form-control m-input m-input--air', 'id' => 'gender_id', 'disabled' => 'disabled']) !!}
                                        @else
                                        {!! Form::select('gender_id',$genders,null,['class' => 'form-control m-input m-input--air', 'id' => 'gender_id']) !!}
                                        @endif
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">


                                <div class="form-group m-form__group {{ $errors->has('major_id') ? ' has-danger' : '' }}">
                                    <label for="major_id">رشته</label>
                                    <div class="m-input-icon m-input-icon--left">
                                        @if(isset($user->major_id))
                                        {!! Form::select('major_id',$majors,null,['class' => 'form-control m-input m-input--air', 'id' => 'major_id', 'disabled' => 'disabled']) !!}
                                        @else
                                        {!! Form::select('major_id',$majors,null,['class' => 'form-control m-input m-input--air', 'id' => 'major_id']) !!}
                                        @endif
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="fa fa-graduation-cap"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class = "form-group m-form__group {{ $errors->has('birthdate') ? ' has-danger' : '' }}>
                                    <label for = "birthdate">تاریخ تولد</label>
                                    <div class = "m-input-icon m-input-icon--left">
                                        <input class = "form-control m-input m-input--air" name = "birthdate" id = "birthdate" @if(isset($user->birthdate)) value="{{$user->birthdate}}" disabled="disabled" @endif/>
                                        <input name = "birthdateAlt" id = "birthdateAlt" type = "hidden" @if(isset($user->birthdate)) value="{{$user->birthdate}}" disabled="disabled" @endif/>
                                        <span class = "m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class = "fa fa-calendar-alt"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="text-center">
                                    <span class="m-badge m-badge--success mobileVerifyMessage @if(!$user->hasVerifiedMobile()) d-none @endif">
                                        شماره موبایل تایید شده است.
                                        <br>
                                        @if(isset($user->mobile)){{ $user->mobile }} @endif
                                    </span>
                                    <span class="m-badge m-badge--danger mobileUnVerifyMessage @if($user->hasVerifiedMobile()) d-none @endif">
                                        توجه! شماره موبایل تایید نشده است.
                                        <br>
                                        @if(isset($user->mobile)){{ $user->mobile }} @endif
                                    </span>
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
                                                    <input type="text" name="txtMobileVerificationCode" id="txtMobileVerificationCode" class="form-control m-input m-input--air" placeholder="کد تایید">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                                    <span>
                                                        <i class="fa fa-mobile-alt"></i>
                                                    </span>
                                                </span>
                                                </div>
                                            </div>
                                            <input type="hidden" id="VerifyMobileVerificationCodeActionUrl" value="{{ action('Web\MobileVerificationController@verify') }}">
                                            <button type="button" id="btnVerifyMobileVerificationCode" class="btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-info m-btn--gradient-to-accent">تایید کد</button>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <input type="hidden" id="userUpdateProfileUrl" value="{{ action((isset($formAction))?$formAction:'Web\UserController@update' , Auth::user()) }}">

                    {!! Form::close() !!}


                    <button type="button" class="btn m-btn--pill m-btn--air btn-primary btnSubmitCompleteInfo">
                        تایید اطلاعات
                    </button>

                </div>
            </div>


        </div>
        @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>تبریک!</strong>
                @if($hadGotGiftBefore)
                شما هدیه ۱۴ هزار تومانی را پیش از این دریافت کرده اید
                @else
                    مبلغ 14 هزار تومان هدیه به کیف پول شما افزوده شد.
                @endif
                <strong>این هدیه تا تاریخ 16 آذر اعتبار دارد.</strong>
            </div>
        @endif
    </div>

    <div class="modal" id="completeRegisterMessage" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">

                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>تبریک!</strong>
                        مبلغ 14000 تومان هدیه به کیف پول شما افزوده شد.
                        <strong>این هدیه تا 16 آذر دیگر اعتبار دارد.</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script src = "{{ mix('/js/user-completeInfo.js') }}"></script>
    <script>
        var todayBirthDay = '';

        function getFormData($form) {
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function (n, i) {
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        }

        function getErrorMessage(errors) {
            let message = '';
            for (let index in errors) {
                for (let errorIndex in errors[index]) {
                    if(!isNaN(errorIndex)) {
                        message += errors[index][errorIndex]+'<br>';
                    }
                }
            }
            return message;
        }

        function settingFormValidation() {
            let status = true;
            let message = '';

            let $name = $('#firstName');
            let $lastname = $('#lastName');
            let $province = $('#province');
            let $city = $('#city');
            let $gender_id = $('#gender_id');
            let $major_id = $('#major_id');
            let $birthdate = $('#birthdate');


            if(typeof $name.val() !== 'undefined' && $name.val().trim().length === 0) {
                status = false;
                message += 'نام خود را وارد کنید.'+'<br>';
                $name.parents('.form-group').addClass('has-danger');
            } else {
                $name.parents('.form-group').removeClass('has-danger');
            }
            if(typeof $lastname.val() !== 'undefined' && $lastname.val().trim().length === 0) {
                status = false;
                message += 'نام خانوادگی خود را وارد کنید.'+'<br>';
                $lastname.parents('.form-group').addClass('has-danger');
            } else {
                $lastname.parents('.form-group').removeClass('has-danger');
            }
            if(typeof $province.val() !== 'undefined' && $province.val().trim().length === 0) {
                status = false;
                message += 'استان خود را مشخص کنید.'+'<br>';
                $province.parents('.form-group').addClass('has-danger');
            } else {
                $province.parents('.form-group').removeClass('has-danger');
            }
            if(typeof $city.val() !== 'undefined' && $city.val().trim().length === 0) {
                status = false;
                message += 'شهر خود را مشخص کنید.'+'<br>';
                $city.parents('.form-group').addClass('has-danger');
            } else {
                $city.parents('.form-group').removeClass('has-danger');
            }
            if(typeof $gender_id.val() !== 'undefined' && $gender_id.val() == 0) {
                status = false;
                message += 'جنسیت را مشخص کنید.'+'<br>';
                $gender_id.parents('.form-group').addClass('has-danger');
            } else {
                $gender_id.parents('.form-group').removeClass('has-danger');
            }
            if(typeof $major_id.val() !== 'undefined' && $major_id.val() == 0) {
                status = false;
                message += 'رشته خود را مشخص کنید.'+'<br>';
                $major_id.parents('.form-group').addClass('has-danger');
            } else {
                $major_id.parents('.form-group').removeClass('has-danger');
            }
            if(typeof $birthdate.val() !== 'undefined' && $birthdate.val().trim().length === 0) {
                status = false;
                message += 'تاریخ تولد خود را مشخص کنید.'+'<br>';
                $birthdate.parents('.form-group').addClass('has-danger');
            } else {
                $birthdate.parents('.form-group').removeClass('has-danger');
            }
            // if(typeof $birthdate.val() !== 'undefined' && $birthdate.val().trim() === todayBirthDay) {
            //     status = false;
            //     message += 'تاریخ تولد خود را مشخص کنید.'+'<br>';
            //     $birthdate.parents('.form-group').addClass('has-danger');
            // } else {
            //     $birthdate.parents('.form-group').removeClass('has-danger');
            // }

            return {
                status: status,
                message: message
            }
        }

        $(document).ready(function () {

            @if($hasGotGiftBefore)
                    $('#completeRegisterMessage').modal('show');
            @endif

            @if(!$user->hasVerifiedMobile() )
                $('.btnSubmitCompleteInfo').fadeOut();
            @endif

            $("#birthdate").persianDatepicker({
                altField: '#birthdateAlt',
                altFormat: "YYYY-MM-DD",
                observer: true,
                format: 'YYYY/MM/DD',
                // initialValue: false,
                // altFieldFormatter: function (unixDate) {
                //     // var d = new Date(unixDate).toISOString();
                //     let targetDatetime = new Date(unixDate);
                //     let formatted_date = targetDatetime.getFullYear() + "-" + (targetDatetime.getMonth() + 1) + "-" + targetDatetime.getDate();
                //     return formatted_date;
                // }
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    d = d.substring(0, d.indexOf('T'));
                    return d;
                }
            });

            todayBirthDay =  $('#birthdate').val();

            $(document).on('click', '.btnSubmitCompleteInfo', function () {

                let validation = settingFormValidation();

                if (!validation.status) {

                    toastr.warning(validation.message);

                    return false;
                }

                var $form = $("#profileForm-setting");
                var data = getFormData($form);
                data['birthdate'] = data['birthdateAlt'];
                mApp.block('.profileMenuPage.profileMenuPage-setting', {
                    overlayColor: "#000000",
                    type: "loader",
                    state: "success",
                    message: "کمی صبر کنید..."
                });

                $.ajax({
                    type: $form.attr('method'),
                    url : $form.attr('action'),
                    data: data,
                    dataType: 'json',

                    success: function (data) {
                        if (data.error) {

                            // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                            let message = data.error.message;

                            toastr.warning('خطای سیستمی رخ داده است.' + '<br>' + message);

                        } else {
                            $('#completeRegisterMessage').modal('show');
                        }
                        mApp.unblock('.profileMenuPage.profileMenuPage-setting');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        let message = '';
                        if (jqXHR.responseJSON.message === 'The given data was invalid.') {
                            message = getErrorMessage(jqXHR.responseJSON.errors);
                        } else {
                            message = 'خطای سیستمی رخ داده است.';
                        }

                        toastr.warning(message);

                        mApp.unblock('.profileMenuPage.profileMenuPage-setting');
                    }

                });


            });

            $(document).on('click', '#btnSendMobileVerificationCode', function () {

                mApp.block('.SendMobileVerificationCodeWarper', {
                    overlayColor: "#000000",
                    type: "loader",
                    state: "success",
                    message: "کمی صبر کنید..."
                });

                $.ajax({
                    type: 'GET',
                    url: $('#SendMobileVerificationCodeActionUrl').val(),
                    // dataType: 'text',
                    dataType: 'json',
                    data: {},
                    success: function (data) {
                        if (data.error) {

                            // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                            let message = data.error.message;

                            toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);

                        } else {

                            $('#btnSendMobileVerificationCode').fadeOut();
                            $('.inputVerificationWarper').fadeIn();

                            toastr.info('کد تایید برای شماره همراه شما پیامک شد.');

                            $('.inputVerificationWarper').removeClass('d-none');

                        }
                        mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);
                        mApp.unblock('.SendMobileVerificationCodeWarper');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        let message = '';
                        if (jqXHR.status === 429) {
                            message = 'پیش از این کد فعال سازی برای شما ارسال شده است. یک دقیقه تا درخواست بعدی صبر کنید.';
                        } else {
                            message = 'خطای سیستمی رخ داده است.';
                        }

                        toastr.warning(message);

                        mApp.unblock('.SendMobileVerificationCodeWarper');
                    }
                });
            });

            $(document).on('click', '#btnVerifyMobileVerificationCode', function () {

                let verificationCode = $('#txtMobileVerificationCode').val();
                if (verificationCode.trim().length === 0) {

                    toastr.warning('کد را وارد نکرده اید.');

                    return false;
                }

                mApp.block('.SendMobileVerificationCodeWarper', {
                    overlayColor: "#000000",
                    type: "loader",
                    state: "success",
                    message: "کمی صبر کنید..."
                });


                $.ajax({
                    type: 'POST',
                    url: $('#VerifyMobileVerificationCodeActionUrl').val(),
                    data: {
                        code: verificationCode
                    },
                    // dataType: 'text',
                    dataType: 'json',
                    success: function (data) {
                        if (data.error) {

                            // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                            let message = data.error.message;

                            toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);


                        } else {
                            $('.inputVerificationWarper').fadeOut();
                            $('.SendMobileVerificationCodeWarper').fadeOut();
                            $('.mobileUnVerifyMessage').removeClass('d-block');
                            $('.mobileUnVerifyMessage').addClass('d-none');
                            $('.mobileVerifyMessage').removeClass('d-none');
                            $('.mobileVerifyMessage').addClass('d-block');
                            $('.btnSubmitCompleteInfo').fadeIn();
                            updateUserCompletionProgress(data.user.info.completion);
                            toastr.success('شماره موبایل شما تایید شد.');
                        }

                        mApp.unblock('.SendMobileVerificationCodeWarper');
                        mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        let message = '';
                        if (jqXHR.status === 403) {
                            message = 'کد وارد شده اشتباه است.';
                        } else if (jqXHR.status === 422) {
                            message = 'کد را وارد نکرده اید.';
                        } else {
                            message = 'خطای سیستمی رخ داده است.';
                        }

                        toastr.error(message);

                        mApp.unblock('.SendMobileVerificationCodeWarper');
                    }
                });
            });
        });
    </script>
@endsection
