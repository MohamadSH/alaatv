
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
        $.ajax({
            // Your server script to process the upload
            url: $('#profilePhotoAjaxUploadActionUrl').val(),
            type: 'PUT',

            // Form data
            data: new FormData($('#profilePhotoAjaxForm')[0]),

            // Tell jQuery not to process data or worry about content-type
            // You *must* include these options!
            cache: false,
            contentType: false,
            processData: false,

            // Custom XMLHttpRequest
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    // For handling the progress of the upload
                    myXhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            let valuePercent = (e.loaded/e.total)*100;
                            $('.profilePhotoUploadProgressBar .progress-bar').css('width', valuePercent+'%');
                            // $('progress').attr({
                            //     value: e.loaded,
                            //     max: e.total,
                            // });
                        }
                    } , false);
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
        uploadExtraData: function() {
            return {
                userid: $("#userid").val(),
                username: $("#username").val()
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


    $(document).on('click', '#btnUpdateProfileInfoForm', function () {


        var $form = $("#profileForm-setting");
        var data = getFormData($form);
        console.log(data);
        mApp.block('#profileMenuPage-setting', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        setTimeout(function () {

            mApp.unblock('#profileMenuPage-setting');

            Swal({
                title: '',
                text: 'اطلاعات شما ویرایش شد.',
                type: 'success',
                confirmButtonText: 'بستن'
            });

        }, 2e3);

        // return false;

        // $.ajax({
        //     type: 'PUT',
        //     url: $('#userUpdateProfileUrl').val(),
        //     data: {},
        //
        //     success: function (data) {
        //         if (data.error) {
        //
        //             // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
        //             let message = data.error.message;
        //
        //             Swal({
        //                 title: 'توجه!',
        //                 text:  'خطای سیستمی رخ داده است.' + '<br>' + message,
        //                 type: 'danger',
        //                 confirmButtonText: 'بستن'
        //             });
        //
        //         } else {
        //             $('.inputVerificationWarper').fadeIn();
        //
        //             Swal({
        //                 title: '',
        //                 text: 'کد تایید برای شماره همراه شما پیامک شد.',
        //                 type: 'success',
        //                 confirmButtonText: 'بستن'
        //             });
        //         }
        //         mApp.unblock('.SendMobileVerificationCodeWarper');
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
        //
        //         Swal({
        //             title: 'توجه!',
        //             text: 'خطای سیستمی رخ داده است.',
        //             type: 'danger',
        //             confirmButtonText: 'بستن'
        //         });
        //         mApp.unblock('.SendMobileVerificationCodeWarper');
        //     }
        //
        // });


    });

    $(document).on('click', '#btnSendMobileVerificationCode', function () {

        mApp.block('.SendMobileVerificationCodeWarper', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        setTimeout(function () {

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

        return false;

        $.ajax({
            type: 'POST',
            url: $('#SendMobileVerificationCodeActionUrl').val(),
            data: {},
            success: function (data) {
                if (data.error) {

                    // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                    let message = data.error.message;

                    Swal({
                        title: 'توجه!',
                        text:  'خطای سیستمی رخ داده است.' + '<br>' + message,
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
                    type: 'danger',
                    confirmButtonText: 'بستن'
                });
                mApp.unblock('.SendMobileVerificationCodeWarper');
            }
        });
    });

    $(document).on('click', '#btnVerifyMobileVerificationCode', function () {

        mApp.block('.SendMobileVerificationCodeWarper', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        setTimeout(function () {

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

        return false;

        $.ajax({
            type: 'POST',
            url: $('#VerifyMobileVerificationCodeActionUrl').val(),
            data: {},
            success: function (data) {
                if (data.error) {

                    // let message = 'مشکلی رخ داده است. لطفا مجدد سعی کنید';
                    let message = data.error.message;

                    Swal({
                        title: 'توجه!',
                        text:  'خطای سیستمی رخ داده است.' + '<br>' + message,
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
                }

                mApp.unblock('.SendMobileVerificationCodeWarper');
                mUtil.scrollTo('.SendMobileVerificationCodeWarper', 300);
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

    $(document).on('click', '.profile-usermenu button', function () {
        let menu = $(this).attr('menu');
        if (menu === 'profileMenuPage-sabteRotbe') {
            showSabteRotbe();
        } else if (menu === 'profileMenuPage-filmVaJozve') {
            showFilmVaJozve();
        } else if (menu === 'profileMenuPage-setting') {
            showSetting();
        }
        mUtil.scrollTop();
    });

});