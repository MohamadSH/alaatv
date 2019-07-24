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
            },
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            422: function (response) {
                var errors = $.parseJSON(response.responseText);
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
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
            },
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
