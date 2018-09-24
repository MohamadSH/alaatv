/**
 * Set token for ajax request
 */
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken,
        }
    });
});


// Ajax of Modal forms
var $modal = $('#ajax-modal');

/**
 * Attributegroup Admin Ajax
 */
function removeAttributegroup(url){
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
            toastr["success"]("گروه صفت با موفقیت حذف شد!", "پیام سیستم");
            $("#attributegroup-portlet .reload").trigger("click");
        },
        error: function (result) {
            console.log(result);
            console.log(result.responseText);
        }
    });
}
$(document).on("click", "#attributegroupForm-submit", function (){

    $('body').modalmanager('loading');
    var el = $(this);


    //initializing form alerts
    $("#attributegroupName").parent().removeClass("has-error");
    $("#attributegroupNameAlert > strong").html("");
    $("#attributegroupDescription").parent().removeClass("has-error");
    $("#attributegroupDescriptionAlert > strong").html("");
    $("#group_attributes").parent().removeClass("has-error");
    $("#attributesAlert > strong").html("");


    var formData = new FormData($("#attributegroupForm")[0]);

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

    $.ajax({
        type: "POST",
        url: $("#attributegroupForm").attr("action"),
        data: formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                // console.log(result);
                // console.log(result.statusCode);
                toastr["success"]("درج گروه صفت با موفقیت انجام شد!", "پیام سیستم");
                $("#attributegroupForm-close").trigger("click");
                $("#attributegroup-portlet .reload").trigger("click");
                $('#attributegroupForm')[0].reset();
                $('#group_attributes').multiSelect('refresh');
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
                // console.log("error = "+errors);
                $.each(errors, function(index, value) {
                    switch(index){
                        case "name":
                            $("#attributegroupName").parent().addClass("has-error");
                            $("#attributegroupNameAlert > strong").html(value);
                            break;
                        case "description":
                            $("#attributegroupDescription").parent().addClass("has-error");
                            $("#attributegroupDescriptionAlert > strong").html(value);
                            break;
                        case "$attributes":
                            $("#group_attributes").parent().addClass("has-error");
                            $("#attributesAlert > strong").html(value);
                            break;
                    }
                });
            },
            //The status for when there is error php code
            500: function (response) {
                console.log(response.responseText);
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
$(document).on("click", "#attributegroup-portlet .reload", function (){
    $.ajax({
        type: "GET",
        url: "/attributegroup",
        data: {attributeset_id:$('#attributeset').val()},
        success: function (result) {
            // console.log(result);
            // console.log(result.responseText);
            var newDataTable =$("#attributegroup_table").DataTable();
            newDataTable.destroy();
            $('#attributegroup_table > tbody').html(result);
            makeDataTableWithoutButton("attributegroup_table");
        },
        error: function (result) {
            console.log(result);
            console.log(result.responseText);
        }
    });

    return false;
});

/**
 * Start up jquery
 */
jQuery(document).ready(function() {
    $("#loadingAjax").click();

    setTimeout(function(){
        $("#attributegroup-portlet .reload").trigger("click");
        $('#group_attributes').multiSelect();
        $("#attributegroup-expand").trigger("click");
    }, 250);

});
