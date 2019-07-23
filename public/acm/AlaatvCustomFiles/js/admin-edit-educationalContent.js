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
$('#contextSummerNote').summernote({height: 300});
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

var u = Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element
    url:"/bigUpload",
    method:"POST",
    paramName: "file",
    autoProcessQueue: true,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFiles: 5 ,
    maxFilesize: 500,
    timeout: 3600000,
    dictFileTooBig:"حجم فایل شما حداکثر می تواند 500 مگابایت باشد",
    dictMaxFilesExceeded : "حداکثر تعداد مجاز انتخاب شما تمام شد",
    dictFallbackMessage:"مرورگر شما قابلیت درگ اند دراپ را پشتیبانی نمی کند!",
    dictInvalidFileType:"فرمت فایل معتبر نمی باشد.",
    dictResponseError : "خطا در آپلود",
    acceptedFiles:".pdf,.rar,.mp4,.jpg,.png,.jpeg",

    // The setting up of the dropzone
    init: function() {
        this.on("addedfile", function(file) {
            $("#editForm").find(':submit').prop("disabled" , true);

            // Create the remove button
            var removeButton = Dropzone.createElement("<a href='javascript:;' class='btn red btn-sm btn-block' style='border-radius: 18px;'>Remove</a>");

            // Capture the Dropzone instance as closure.
            var _this = this;

            // Listen to the click event
            removeButton.addEventListener("click", function(e) {
                // Make sure the button click doesn't submit the form:
                e.preventDefault();
                e.stopPropagation();

                // Remove the file preview.
                _this.removeFile(file);
                // If you want to the delete the file on the server as well,
                // you can do the AJAX request here.
            });

            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);

            var fileCaption = $('select[name=fileQuality] :selected').data("action");
            var fileCaptionHidden = "<input type='hidden' name='caption[]' value='"+fileCaption+"'>";
            $("#editForm").append(fileCaptionHidden);
            var fileLabel = $('select[name=fileQuality] :selected').data("role");
            var fileLabelHidden = "<input type='hidden' name='label[]' value='"+fileLabel+"'>";
            $("#editForm").append(fileLabelHidden);
        });

        var myDropzone = this;

        // First change the button to actually tell Dropzone to process the queue.
//                this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
//                    // Make sure that the form isn't actually being sent.
//                    e.preventDefault();
//                    e.stopPropagation();
//                });
//                this.on("uploadprogress", function(file, progress) {
//                });
        this.on("reset", function() {
            // Gets triggered when the form is actually being sent.
            // Hide the success button or the complete form.
        });
        this.on("maxfilesexceeded", function(file) {
            this.removeAllFiles();
            this.addFile(file);
            // Gets triggered when the form is actually being sent.
            // Hide the success button or the complete form.
        });
        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
        // of the sending event because uploadMultiple is set to true.
        this.on("sending", function(files, xhr, formData){
            var contentset = $('input[name=contentset]').val();
            if(contentset.length > 0)
            {
                var quality = $('select[name=fileQuality] :selected').val();
                if(quality.length > 0 )
                    if(quality == "thumbnail")
                    {
                        contentset = "thumbnails/"+contentset+"/";
                    }
                    else
                    {
                        contentset += "/"+quality+"/";
                    }
                xhr.setRequestHeader("X-Dataid", contentset);
            }
            xhr.setRequestHeader("X-Datatype",$('select[name=contenttype] :selected').attr("data-title"));
            xhr.setRequestHeader("X-Dataname",files.name );
        });


        this.on("success", function(files, response) {
            // Gets triggered when the files have successfully been sent.
            // Redirect user or notify of success
            $("#editForm").find(':submit').prop("disabled" , false);
            var fileNameHidden = "<input type='hidden' name='file[]' value='"+response.fileName+"'>";
            $("#editForm").append(fileNameHidden);

        });
        this.on("error", function(files, response) {
            // Gets triggered when there was an  error sending the files.
            // Maybe show form again, and notify user of error
            $("#editForm").find(':submit').prop("disabled" , false);
        });
    }
};

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