/**
 * Created by Ali on 17/01/28.
 */

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


// Ajax of Modal forms
var $modal = $('#ajax-modal');


/**
 * attributevalue Admin Ajax
 */
function removeattributevalues(url){
    $.ajax({
        type: 'POST',
        url: url,
        data:{_method: 'delete'},
        success: function (result) {
            // console.log(result);
            // console.log(result.responseText);
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
            toastr["success"]("دسته صفت با موفقیت حذف شد!", "پیام سیستم");
            location.reload();
        },
        error: function (result) {
            // console.log(result);
            // console.log(result.responseText);
        }
    });
}

$(document).on("click", "#attributevalueForm-submit", function (){
    $('body').modalmanager('loading');
    var el = $(this);

    //initializing form alerts
    $("#attributevalueName").parent().removeClass("has-error");
    $("#attributevalueNameAlert > strong").html("");


    $("#attributevalueDescription").parent().removeClass("has-error");
    $("#attributevalueDescriptionAlert > strong").html("");

    var formData = new FormData($("#attributevalueForm")[0]);
    $.ajax({
        type: "POST",
        url: $("#attributevalueForm").attr("action"),
        data: formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $("#attributevalueForm-close").trigger("click");
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
                location.reload();
                $('#attributevalueForm')[0].reset();
                toastr["success"]("درج مقدار صفت با موفقیت انجام شد!", "پیام سیستم");
                // console.log(result);
                // console.log(result.responseText);
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
                var errors = $.parseJSON(response.responseText);
                console.log(errors);
                $.each(errors, function(index, value) {
                    switch (index) {
                        case "name":
                            $("#attributevalueName").parent().addClass("has-error");
                            $("#attributevalueNameAlert > strong").html(value);
                            break;

                        case "description":
                            $("#attributevalueDescription").parent().addClass("has-error");
                            $("#attributevalueDescriptionAlert > strong").html(value);
                            break;
                    }
                });
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    $modal.modal().hide();
    $modal.modal('toggle');
});
