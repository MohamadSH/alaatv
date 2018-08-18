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
    userAjax = $.ajax({
        type: "GET",
        url: action,
        statusCode: {
            200:function (response) {
                $(".hasRequestedVerificationCode").removeClass("hidden");
                $("#hasntRequestedVerificationCode").addClass("hidden");
                $("#getVerificationCodeSuccess > span").html(response.message);
                $("#getVerificationCodeSuccess").removeClass("hidden");
            },
            //The status for when the user is not authorized for making the request
            401:function (ressponse) {
            },
            403: function (response) {
            },
            404: function (response) {
            },
            //The status for when form data is not valid
            422: function (response) {
                toastr["error"]("خطای 422 . خطای ورودی ها", "پیام سیستم");
            },
            //The status for when there is error php code
            500: function (response) {
                console.log(response.responseText);
                toastr["error"]("خطای 500", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
                var text = $.parseJSON(response.responseText);
                $("#verificationCodeError > span").html(text.message);
                $("#verificationCodeError").removeClass("hidden");
            },
            406: function (response) {
                var text = $.parseJSON(response.responseText);
                $("#verificationCodeWarning > span").html(text.message);
                $("#verificationCodeWarning").removeClass("hidden");
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
    $.ajax({
        type: 'POST',
        url: url,
        data:formData ,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                // console.log(response);
                // console.log(response.responseText);
                $("#verificationCodeAjaxLoadingSpinner").hide();
                location.reload();
            },
            //The status for when the user is not authorized for making the request
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            //The status for when form data is not valid
            422: function (response) {
                toastr["error"]("خطای 422 . خطای ورودی ها", "پیام سیستم");
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای 500", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
                var text = $.parseJSON(response.responseText);
                $("#verificationCodeError > span").html(text.message);
                $("#verificationCodeError").removeClass("hidden");
            },
            406: function (response) {
                var text = $.parseJSON(response.responseText);
                $("#verificationCodeWarning > span").html(text.message);
                $("#verificationCodeWarning").removeClass("hidden");
            }
        },
        cache: false,
        // contentType: false,
        processData: false
    });
});

$(document).on("click", ".close", function (e){
    var parentId = $(this).closest('div').attr('id');
    $("#"+ parentId).addClass("hidden");
});