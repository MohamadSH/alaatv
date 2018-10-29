function addSubmitButton() {
    $(".hasRequestedVerificationCode").removeClass("hidden");
}

function removeCodeRequestButton() {
    $("#hasntRequestedVerificationCode").addClass("hidden");
}

function showVerificationResponseMessage(selector, message) {
    $("#verificationCode" + selector + " > span").html(message);
    $("#verificationCode" + selector).removeClass("hidden");
}

$(document).on("click", "#sendVerificationCodeButton", function (e){
    e.preventDefault();
    var action = $(this).attr("href");
    if(userAjax) {
        userAjax.abort();
    }
    $("#verificationCodeAjaxLoadingSpinner").show();
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
    var responseMessage = "";
    userAjax = $.ajax({
        type: "GET",
        url: action,
        accepts: "application/json; charset=utf-8",
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        statusCode: {
            200:function (response) {
                responseMessage = response.responseText;
                showVerificationResponseMessage("Success", responseMessage);
                addSubmitButton();
                removeCodeRequestButton();
            },
            403: function (response) {
                responseMessage = response.responseJSON.message;
                showVerificationResponseMessage("Error", responseMessage);
            },
            404: function (response) {
                toastr["error"]("Not Found", "پیام سیستم");
            },
            //The status for when form data is not valid
            422: function (response) {
                toastr["error"]("خطای ورودی ها", "پیام سیستم");
            },
            //Too many attempts
            429: function (response) {
                responseMessage = "شما به سقف تعداد درخواست رسیده اید لطفا چند لحظه صبر کنید";
                showVerificationResponseMessage("Warning", responseMessage);
            },
            //The status for when there is error php code
            500: function (response) {
                console.log(response);
                toastr["error"]("خطای 500", "پیام سیستم");
            }
        }
    });

    $("#verificationCodeAjaxLoadingSpinner").hide();
});

$(document).on('submit', '#submitVerificationCodeForm', function(e){
    e.preventDefault();
    var form = $(this);
    formData = form.serialize();
    var url = form.attr("action");
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
    $("#verificationCodeAjaxLoadingSpinner").show();
    var responseMessage = "";
    $.ajax({
        type: 'POST',
        url: url,
        data:formData ,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                // console.log(response);
                location.reload();

                // responseMessage = response.responseText ;
                //
                // $(".hasRequestedVerificationCode").removeClass("hidden");
                // $("#hasntRequestedVerificationCode").addClass("hidden");
                // $("#verificationCodeSuccess > span").html(responseMessage);
                // $("#verificationCodeSuccess").removeClass("hidden");
            },
            //The status for when the user is not authorized for making the request
            403: function (response) {
                responseMessage = response.responseJSON.message;
                showVerificationResponseMessage("Error", responseMessage);
            },
            404: function (response) {
                toastr["error"]("Not Found", "پیام سیستم");
            },
            //The status for when form data is not valid
            422: function (response) {
                toastr["error"]("خطای ورودی ها", "پیام سیستم");
            },
            //Too many attempts
            429: function (response) {
                responseMessage = "شما به سقف تعداد تایید کد رسیده اید لطفا چند لحظه صبر کنید";
                showVerificationResponseMessage("Warning", responseMessage);
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای 500", "پیام سیستم");
            }
        }
    });
    $("#verificationCodeAjaxLoadingSpinner").hide();
});

$(document).on("click", ".close", function (e){
    var parentId = $(this).closest('div').attr('id');
    $("#"+ parentId).addClass("hidden");
});