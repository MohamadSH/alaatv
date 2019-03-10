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
        var $form = $("#profilePhotoAjaxForm");
        $.ajax({
            // Your server script to process the upload
            url: $form.attr('action'),
            type: $form.attr('method'),

            // Form data
            data: new FormData($('#profilePhotoAjaxForm')[0]),

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
                        type: 'danger',
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
                mApp.unblock('#profileMenuPage-setting');
            },

            // Custom XMLHttpRequest
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    // For handling the progress of the upload
                    myXhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            let valuePercent = (e.loaded / e.total) * 100;
                            $('.profilePhotoUploadProgressBar .progress-bar').css('width', valuePercent + '%');
                            // $('progress').attr({
                            //     value: e.loaded,
                            //     max: e.total,
                            // });
                        }
                    }, false);
                }
                return myXhr;
            }
        });

    });

    $('#UserProfilePhoto').fileinput({
        theme: 'fas',
        showUpload: false,
        showCaption: false,

        uploadAsync: false,
        uploadUrl: $('#profilePhotoAjaxUploadActionUrl').val(), // your upload server url
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

    function showSabteRotbe() {
        $('#profileMenuPage-filmVaJozve').fadeOut(0);
        $('#profileMenuPage-setting').fadeOut(0);
        $('#profileMenuPage-sabteRotbe').fadeIn();
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#profileMenuPage-sabteRotbe').offset().top - $('#m_header').height() - 30
        }, 500);
    }

    function showFilmVaJozve() {
        $('#profileMenuPage-filmVaJozve').slideDown();
        $('#profileMenuPage-sabteRotbe').slideUp();
        $('#profileMenuPage-setting').slideUp();
    }

    function showSetting() {
        $('#profileMenuPage-filmVaJozve').fadeOut(0);
        $('#profileMenuPage-sabteRotbe').fadeOut(0);
        $('#profileMenuPage-setting').fadeIn();
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#profileMenuPage-setting').offset().top - $('#m_header').height() - 30
        }, 500);
    }

    showSetting();

    $('#birthdate').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '#birthdateAlt'
    });

    $(document).on('click', '#btnUpdateProfileInfoForm', function () {

        var $form = $("#profileForm-setting");
        var data = getFormData($form);

        mApp.block('#profileMenuPage-setting', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        // setTimeout(function () {
        //
        //     mApp.unblock('#profileMenuPage-setting');
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
                        text: 'خطای سیستمی رخ داده است.' + '<br>' + message,
                        type: 'danger',
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
                mApp.unblock('#profileMenuPage-setting');
            },
            error: function (jqXHR, textStatus, errorThrown) {

                Swal({
                    title: 'توجه!',
                    text: 'خطای سیستمی رخ داده است.',
                    type: 'danger',
                    confirmButtonText: 'بستن'
                });
                mApp.unblock('#profileMenuPage-setting');
            }

        });


    });

    $(document).on('click', '#btnSabteRotbe1', function () {

        var $form = $("#frmSabteRotbe");
        var data = getFormData($form);

        mApp.block('#profileMenuPage-sabteRotbe', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        // setTimeout(function () {
        //
        //     mApp.unblock('#profileMenuPage-setting');
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
                        type: 'danger',
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
                mApp.unblock('#profileMenuPage-sabteRotbe');
            },
            error: function (jqXHR, textStatus, errorThrown) {

                Swal({
                    title: 'توجه!',
                    text: 'خطای سیستمی رخ داده است.',
                    type: 'danger',
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
                        type: 'danger',
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
                type: 'danger',
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

                    Swal({
                        title: 'توجه!',
                        text: 'خطای سیستمی رخ داده است.' + '<br>' + message,
                        type: 'danger',
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
                    type: 'danger',
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
            showFilmVaJozve();
        } else if (menu === 'profileMenuPage-setting') {
            showSetting();
        }
        // mUtil.getScroll(document.getElementById('profileMenuPage-sabteRotbe'), 'Top');
        //
        // mUtil.scrollTop();
    });
});