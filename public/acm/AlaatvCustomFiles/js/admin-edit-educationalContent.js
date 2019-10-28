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


$('#descriptionSummerNote').summernote({height: 300});
$('#descriptionSummerNote').summernote({height: 300});
$('#tempDescriptionSummerNote').summernote({height: 300});
function initialContentTypeSelect() {
    var selected = $("#rootContentTypes option:selected").text();
    if(selected == "آزمون")
    {
        $("#childContentTypes").prop("disabled" , false);
    }else{
        $("#childContentTypes").prop("disabled" , true);
    }

}

$(document).ready(function () {
    initialContentTypeSelect();
    /*
     validSince
     */
    $("#validSinceDate").persianDatepicker({
        altField: '#validSinceDateAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });

    $("#validSinceTime").inputmask("hh:mm", {
        placeholder: "",
        clearMaskOnLostFocus: true
    });


});

$('#rootContentTypes').on('change', function() {
    initialContentTypeSelect();
});

$(document).on("click", ".removeFile", function (){
    var file_id = $(this).data('id');
    var content_id = $(this).data('to');
    $("input[name=file_id]").val(file_id);
    $("input[name=educationalContent_id]").val(content_id);
});

$(document).on("click", "#removeFileSubmit", function (){
    var file_id = $("input[name=file_id]").val();
    var content_id = $("input[name=educationalContent_id]").val();
//            toastr.options = {
//                "closeButton": true,
//                "debug": false,
//                "positionClass": "toast-top-center",
//                "onclick": null,
//                "showDuration": "1000",
//                "hideDuration": "1000",
//                "timeOut": "5000",
//                "extendedTimeOut": "1000",
//                "showEasing": "swing",
//                "hideEasing": "linear",
//                "showMethod": "fadeIn",
//                "hideMethod": "fadeOut"
//            };
    $.ajax({
        type: 'POST',
        url: '/detachContentFile/'+content_id+'/'+file_id,
        data:{},
        statusCode: {
            200: function (response) {
                location.reload();
            },
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            422: function (response) {
                toastr["error"]("خطای ۴۲۲ . خطای ورودی ها", "پیام سیستم");
            },
            500: function (response) {
            },
            503: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
            }
        }
    });
});

$(document).on("click", ".fileCaptionSubmit", function (){
    var file_id = $(this).attr("id").split("_")[1];
    var content_id = $(this).data("to");
    var caption = $("#caption_"+file_id).val();
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
        type: 'POST',
        url: "/storeContentFileCaption"+"/"+content_id+"/"+file_id,
        data:{caption: caption },
        statusCode: {
            200: function (response) {
                location.reload();
            },
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            422: function (response) {
                toastr["error"]("خطای ۴۲۲ . خطای ورودی ها", "پیام سیستم");
            },
            500: function (response) {
            },
            503: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
//                    location.reload();
            },
            501: function (response) {
                toastr["warning"](response.responseText, "پیام سیستم");
            }
        },
    });
});
