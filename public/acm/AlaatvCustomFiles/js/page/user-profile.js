function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function updateUserCompletionProgress(percent) {
    $('.userCompletion-progress-bar').attr('aria-valuenow', percent);
    $('.userCompletion-progress-bar').css({'width': percent+'%'});
    $('.userCompletion-percent-text').html(percent);
    $('.userCompletion-progress-bar').removeClass('bg-danger').removeClass('bg-warning').removeClass('bg-info').removeClass('bg-success');

    percent = parseInt(percent);

    if (percent <= 25) {
        $('.userCompletion-progress-bar').addClass('bg-danger');
    } else if (percent > 25 && percent <= 50) {
        $('.userCompletion-progress-bar').addClass('bg-warning');
    } else if (percent > 50 && percent <= 75) {

    } else if (percent > 75 && percent < 100) {
        $('.userCompletion-progress-bar').addClass('bg-info');
    } else if (percent === 100) {
        $('.userCompletion-progress-bar').addClass('bg-success');
    }
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
            dataType: 'json',

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

                    toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);

                } else {
                    updateUserCompletionProgress(data.user.info.completion);
                    toastr.success('تصویر شما ویرایش شد.');
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

            toastr.warning('حجم عکس حداکثر 500 کیلوبایت باشد');

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
        changeStatus('ثبت_رتبه');
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
        changeStatus('اطلاعات_شخصی');
        $('.profileMenuPage.profileMenuPage-filmVaJozve').fadeOut(0);
        $('.profileMenuPage.profileMenuPage-sabteRotbe').fadeOut(0);
        $('.profileMenuPage.profileMenuPage-setting').fadeIn();
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.profileMenuPage.profileMenuPage-setting').offset().top - $('#m_header').height() - 30
        }, 500);
    }

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
        } else if ($postalCode.val().trim().length > 0 && $postalCode.val().trim().length !== 10) {
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
            message += 'ثبت_رتبه الزامی است.'+'<br>';
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

            toastr.warning(validation.message);

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
                    updateUserCompletionProgress(data.user.info.completion);
                    toastr.success('اطلاعات شما ثبت شد.');
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

                toastr.warning(message);

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

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: data,

            success: function (data) {
                if (data.error) {

                    // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                    let message = data.error.message;

                    toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);

                } else {
                    toastr.success('اطلاعات شما ثبت شد.');
                }
                mApp.unblock('.profileMenuPage.profileMenuPage-sabteRotbe');
            },
            error: function (jqXHR, textStatus, errorThrown) {

                toastr.error('خطای سیستمی رخ داده است.');

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
                    updateUserCompletionProgress(data.user.info.completion);
                    toastr.success('شماره موبایل شما تایید شد.');

                    if (data.user.lockProfile === 1) {
                        window.location.reload();
                    }
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

    $(document).on('submit', '#frmSabteRotbe', function(e){
        let validation = sabteRotbeFormValidation();

        if (!validation.status) {

            toastr.warning(validation.message);

            e.preventDefault();
            return false;
        }
    });

    let pageLoadState = decodeURIComponent(window.location.hash);
    if (pageLoadState === '#ثبت_رتبه') {
        showSabteRotbe();
    } else if (pageLoadState === '#اطلاعات_شخصی') {
        showSetting();
    } else {
        showSetting();
    }

    $(window).on('hashchange', function() {
        if (window.location.hash === '#ثبت_رتبه') {
            showSabteRotbe();
        } else if (window.location.hash === '#اطلاعات_شخصی') {
            showSetting();
        }
    });

});