function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

$(document).ready(function () {

    $(document).on('click', '#btnEditUserPhoto', function () {
        $('#UserProfilePhoto').trigger('click');
    });
    $(document).on('click', '#uploadProfilePhotoAjaxSubmit', function () {
        // $('.fileinput-previewClass .kv-file-upload').trigger('click');
        $('.profilePhotoUploadProgressBar').fadeIn();
        mApp.block('.userProfilePicWraper', {
            type: "loader",
            state: "success",
        });

        let $form = $('#profilePhotoAjaxForm');
        let formData = new FormData($form[0]);

        $.ajax({
            // Your server script to process the upload
            url: $form.attr('action'),
            type: 'POST',

            // Form data
            data: formData,

            mimeType:"multipart/form-data",

            // Tell jQuery not to process data or worry about content-type
            // You *must* include these options!
            cache: false,
            contentType: false,
            processData: false,

            success: function (data) {
                if (data.error) {

                    // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                    let message = data.error.message;

                    Swal({
                        title: 'توجه!',
                        text: 'خطای سیستمی رخ داده است.' + '<br>' + message,
                        type: 'error',
                        confirmButtonText: 'بستن'
                    });

                } else {

                    Swal({
                        title: '',
                        text: 'تصویر شما ویرایش شد.',
                        type: 'success',
                        confirmButtonText: 'بستن'
                    });

                    if (data.user.lockProfile === 1) {
                        window.location.reload();
                    }
                }
                mApp.unblock('.userProfilePicWraper');
            },

            // Custom XMLHttpRequest
            xhr: function () {
                let myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    // For handling the progress of the upload
                    myXhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            let valuePercent = (e.loaded / e.total) * 100;
                            $('.profilePhotoUploadProgressBar .progress-bar').css('width', valuePercent + '%');
                        }
                    }, false);
                }
                return myXhr;
            }
        });

    });

    let $form = $('#profilePhotoAjaxForm');
    $('#UserProfilePhoto').fileinput({
        theme: 'fas',
        showUpload: false,
        showCaption: false,

        uploadAsync: false,
        uploadUrl: $form.attr('action'), // your upload server url
        uploadExtraData: function () {
            return {
                updateType: 'photo',
                // username: $("#username").val()
            };
        },

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

    $(document).on('change', '#UserProfilePhoto', function (event) {

        let files = $(this)[0].files; // puts all files into an array

        let filesize = ((files[0].size / 1024)).toFixed(4); // KB

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

    function changeStatus(status) {

        let url = document.location.href.split('#')[0];

        url += '#' + status;

        history.pushState('data to be passed', 'Title of the page', url);
        // The above will add a new entry to the history so you can press Back button to go to the previous state.
        // To change the URL in place without adding a new entry to history use
        // history.replaceState('data to be passed', 'Title of the page', '');
    }

    function showSabteRotbe() {
        // changeStatus('ثبت رتبه');
        $('.profileMenuPage.profileMenuPage-filmVaJozve').fadeOut(0);
        $('.profileMenuPage.profileMenuPage-setting').fadeOut(0);
        $('.profileMenuPage.profileMenuPage-sabteRotbe').fadeIn();
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.profileMenuPage.profileMenuPage-sabteRotbe').offset().top - $('#m_header').height() - 30
        }, 500);
    }

    function showFilmVaJozve() {
        $('.profileMenuPage.profileMenuPage-filmVaJozve').slideDown();
        $('.profileMenuPage.profileMenuPage-sabteRotbe').slideUp();
        $('.profileMenuPage.profileMenuPage-setting').slideUp();
    }

    function showSetting() {
        // changeStatus('اطلاعات شخصی');
        $('.profileMenuPage.profileMenuPage-filmVaJozve').fadeOut(0);
        $('.profileMenuPage.profileMenuPage-sabteRotbe').fadeOut(0);
        $('.profileMenuPage.profileMenuPage-setting').fadeIn();
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.profileMenuPage.profileMenuPage-setting').offset().top - $('#m_header').height() - 30
        }, 500);
    }

    showSetting();

    $('#birthdate').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '#birthdateAlt'
    });

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

        let $postalCode = $('#profileForm-setting input[name="postalCode"]');
        let $email = $('#profileForm-setting input[name="email"]');
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(isNaN($postalCode.val())) {
            status = false;
            message += 'برای کد پستی عدد وارد کنید.'+'<br>';
            $postalCode.parents('.form-group').addClass('has-danger');
        } else if ($postalCode.val().trim().length !== 10) {
            status = false;
            message += 'کد پستی می بایست ده رقم باشد.'+'<br>';
            $postalCode.parents('.form-group').addClass('has-danger');
        } else {
            $postalCode.parents('.form-group').removeClass('has-danger');
        }
        if (re.test($email.val()) || $email.val().trim().length===0) {
            $email.parents('.form-group').removeClass('has-danger');
        } else {
            status = false;
            message += 'ایمیل وارد شده نامعتبر است.'+'<br>';
            $email.parents('.form-group').addClass('has-danger');
        }
        return {
            status: status,
            message: message
        }
    }

    function sabteRotbeFormValidation() {
        let status = true;
        let message = '';

        let $rank = $('#frmSabteRotbe input[name="rank"]');
        let $reportFile = $('#frmSabteRotbe input[name="reportFile"]');

        if ($rank.val().trim().length === 0) {
            status = false;
            message += 'ثبت رتبه الزامی است.'+'<br>';
            $rank.parents('.form-group').addClass('has-danger');
        } else if(isNaN(parseInt($rank.val().toLocaleString('en').replace(',', ''))) || isNaN($rank.val())) {
            status = false;
            message += 'برای رتبه عدد وارد کنید.'+'<br>';
            $rank.parents('.form-group').addClass('has-danger');
        } else {
            $rank.parents('.form-group').removeClass('has-danger');
        }
        if (document.getElementById('reportFile').files.length === 0) {
            status = false;
            message += 'ارسال فایل کارنامه الزامی است.'+'<br>';
            $reportFile.parents('.form-group').addClass('has-danger');
        } else {
            $reportFile.parents('.form-group').removeClass('has-danger');
        }
        return {
            status: status,
            message: message
        }
    }

    $(document).on('click', '#btnUpdateProfileInfoForm', function () {

        let validation = settingFormValidation();

        if (!validation.status) {
            Swal({
                title: 'توجه!',
                html: validation.message,
                type: 'warning',
                confirmButtonText: 'بستن'
            });
            return false;
        }

        var $form = $("#profileForm-setting");
        var data = getFormData($form);

        mApp.block('.profileMenuPage.profileMenuPage-setting', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        // setTimeout(function () {
        //
        //     mApp.unblock('.profileMenuPage.profileMenuPage-setting');
        //
        //     Swal({
        //         title: '',
        //         text: 'اطلاعات شما ویرایش شد.',
        //         type: 'success',
        //         confirmButtonText: 'بستن'
        //     });
        //
        // }, 2e3);
        //
        // return false;

        $.ajax({
            type: $form.attr('method'),
            url : $form.attr('action'),
            data: data,
            dataType: 'json',

            success: function (data) {
                if (data.error) {

                    // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                    let message = data.error.message;

                    Swal({
                        title: 'توجه!',
                        html: 'خطای سیستمی رخ داده است.' + '<br>' + message,
                        type: 'warning',
                        confirmButtonText: 'بستن'
                    });

                } else {


                    Swal({
                        title: '',
                        text: 'اطلاعات شما ثبت شد.',
                        type: 'success',
                        confirmButtonText: 'بستن'
                    });

                    if (data.user.lockProfile === 1) {
                        window.location.reload();
                    }
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
                Swal({
                    title: 'توجه!',
                    html: message,
                    type: 'warning',
                    confirmButtonText: 'بستن'
                });
                mApp.unblock('.profileMenuPage.profileMenuPage-setting');
            }

        });


    });

    $(document).on('click', '#btnSabteRotbe1', function () {

        var $form = $("#frmSabteRotbe");
        var data = getFormData($form);

        mApp.block('.profileMenuPage.profileMenuPage-sabteRotbe', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        // setTimeout(function () {
        //
        //     mApp.unblock('.profileMenuPage.profileMenuPage-setting');
        //
        //     Swal({
        //         title: '',
        //         text: 'اطلاعات شما ویرایش شد.',
        //         type: 'success',
        //         confirmButtonText: 'بستن'
        //     });
        //
        // }, 2e3);
        //
        // return false;

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: data,

            success: function (data) {
                if (data.error) {

                    // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                    let message = data.error.message;

                    Swal({
                        title: 'توجه!',
                        text: 'خطای سیستمی رخ داده است.' + '<br>' + message,
                        type: 'error',
                        confirmButtonText: 'بستن'
                    });

                } else {


                    Swal({
                        title: '',
                        text: 'اطلاعات شما ثبت شد.',
                        type: 'success',
                        confirmButtonText: 'بستن'
                    });
                }
                mApp.unblock('.profileMenuPage.profileMenuPage-sabteRotbe');
            },
            error: function (jqXHR, textStatus, errorThrown) {

                Swal({
                    title: 'توجه!',
                    text: 'خطای سیستمی رخ داده است.',
                    type: 'error',
                    confirmButtonText: 'بستن'
                });
                mApp.unblock('.SendMobileVerificationCodeWarper');
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

        // setTimeout(function () {
        //
        //     $('#btnSendMobileVerificationCode').fadeOut();
        //     $('.inputVerificationWarper').fadeIn();
        //     mApp.unblock('.SendMobileVerificationCodeWarper');
        //
        //     Swal({
        //         title: '',
        //         text: 'کد تایید برای شماره همراه شما پیامک شد.',
        //         type: 'info',
        //         confirmButtonText: 'بستن'
        //     });
        //
        //     $('.inputVerificationWarper').removeClass('d-none');
        //
        //     mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);
        //
        // }, 2e3);
        //
        // return false;
        console.log('veri clicked!');

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

                    Swal({
                        title: 'توجه!',
                        text: 'خطای سیستمی رخ داده است.' + '<br>' + message,
                        type: 'error',
                        confirmButtonText: 'بستن'
                    });

                } else {

                    $('#btnSendMobileVerificationCode').fadeOut();
                    $('.inputVerificationWarper').fadeIn();

                    Swal({
                        title: '',
                        text: 'کد تایید برای شماره همراه شما پیامک شد.',
                        type: 'info',
                        confirmButtonText: 'بستن'
                    });

                    $('.inputVerificationWarper').removeClass('d-none');

                }
                mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);
                mApp.unblock('.SendMobileVerificationCodeWarper');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal({
                    title: 'توجه!',
                    text: 'خطای سیستمی رخ داده است.',
                    type: 'warning',
                    confirmButtonText: 'بستن'
                });
                mApp.unblock('.SendMobileVerificationCodeWarper');
            }
        });
    });

    $(document).on('click', '#btnVerifyMobileVerificationCode', function () {

        let verificationCode = $('#txtMobileVerificationCode').val();
        if (verificationCode.trim().length === 0) {
            Swal({
                title: 'توجه!',
                text: 'کد را وارد نکرده اید.',
                type: 'error',
                confirmButtonText: 'بستن'
            });
            return false;
        }

        mApp.block('.SendMobileVerificationCodeWarper', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        // setTimeout(function () {
        //
        //     $('.inputVerificationWarper').fadeOut();
        //     $('.SendMobileVerificationCodeWarper').fadeOut();
        //     $('.mobileUnVerifyMessage').removeClass('d-block');
        //     $('.mobileUnVerifyMessage').addClass('d-none');
        //     $('.mobileVerifyMessage').removeClass('d-none');
        //     $('.mobileVerifyMessage').addClass('d-block');
        //
        //     mApp.unblock('.SendMobileVerificationCodeWarper');
        //
        //     Swal({
        //         title: '',
        //         text: 'شماره موبایل شما تایید شد.',
        //         type: 'success',
        //         confirmButtonText: 'بستن'
        //     });
        //
        //     mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);
        //
        // }, 2e3);
        //
        // return false;

        $.ajax({
            type: 'GET',
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

                    Swal({
                        title: 'توجه!',
                        html: 'خطای سیستمی رخ داده است.' + '<br>' + message,
                        type: 'error',
                        confirmButtonText: 'بستن'
                    });

                } else {
                    $('.inputVerificationWarper').fadeOut();
                    $('.SendMobileVerificationCodeWarper').fadeOut();
                    $('.mobileUnVerifyMessage').removeClass('d-block');
                    $('.mobileUnVerifyMessage').addClass('d-none');
                    $('.mobileVerifyMessage').removeClass('d-none');
                    $('.mobileVerifyMessage').addClass('d-block');

                    Swal({
                        title: '',
                        text: 'شماره موبایل شما تایید شد.',
                        type: 'success',
                        confirmButtonText: 'بستن'
                    });

                    if (data.user.lockProfile === 1) {
                        window.location.reload();
                    }
                }

                mApp.unblock('.SendMobileVerificationCodeWarper');
                mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.status);
                let message = '';
                if (jqXHR.status === 403) {
                    message = 'کد وارد شده اشتباه است.';
                } else if (jqXHR.status === 422) {
                    message = 'کد را وارد نکرده اید.';
                } else {
                    message = 'خطای سیستمی رخ داده است.';
                }
                Swal({
                    title: 'توجه!',
                    text: message,
                    type: 'error',
                    confirmButtonText: 'بستن'
                });
                mApp.unblock('.SendMobileVerificationCodeWarper');
            }
        });
    });

    $(document).on('click', '.profile-usermenu button', function () {
        let menu = $(this).attr('menu');
        if (menu === 'profileMenuPage-sabteRotbe') {
            showSabteRotbe();
        } else if (menu === 'profileMenuPage-filmVaJozve') {
            // showFilmVaJozve();
        } else if (menu === 'profileMenuPage-setting') {
            showSetting();
        }
        // mUtil.getScroll(document.getElementById('profileMenuPage-sabteRotbe'), 'Top');
        //
        // mUtil.scrollTop();
    });

    $(document).on('submit', '#frmSabteRotbe', function(e){
        let validation = sabteRotbeFormValidation();

        if (!validation.status) {
            Swal({
                title: 'توجه!',
                html: validation.message,
                type: 'warning',
                confirmButtonText: 'بستن'
            });
            e.preventDefault();
            return false;
        }
    });

    // if (window.location.hash === '#ثبت رتبه') {
    //     showSabteRotbe();
    // } else if (window.location.hash === '#اطلاعات شخصی') {
    //     showSetting();
    // } else {
    //     // showSetting();
    // }
    //
    // $(window).on('hashchange', function() {
    //     if (window.location.hash === '#ثبت رتبه') {
    //         showSabteRotbe();
    //     } else if (window.location.hash === '#اطلاعات شخصی') {
    //         showSetting();
    //     }
    // });

});