var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};
Upload.prototype.doUpload = function () {
    var formData = new FormData();
    $("#profilePhotoAjaxLoadingSpinner").show();
    // add assoc key values, this will be posts values
    if(this.file == undefined)
    {
        $("#profilePhotoAjaxLoadingSpinner").hide();
        return false;
    }
    formData.append("photo", this.file, this.getName());
    formData.append("updateType", "photo");
    formData.append("_method", "put");
    // formData.append("upload_file", true);
    var action = $("#profilePhotoAjaxForm").attr("action");

    $.ajax({
        type: "POST",
        url: action,
        data: formData,
        xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                // For handling the progress of the upload
                myXhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        $('progress').attr({
                            value: e.loaded,
                            max: e.total,
                        });
                    }
                } , false);
            }
            return myXhr;
        },
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                // console.log(response);
                $("#profilePhoto").attr("src" , response.newPhoto);
                $("#profilePhotoAjaxFileInputClose").trigger("click");
                $("#profileEditViewText3-span2").hide();
                if(mobileVerification != undefined && mobileVerification)
                {
                    $("#profileEditViewText3").hide();
                    $("#updateProfileInfoFormButton").prop("disabled" , false);
                }
                $("#profilePhotoAjaxLoadingSpinner").hide();
            },
            //The status for when the user is not authorized for making the request
            403: function (response) {
                window.location.replace("/403");
            },
            //The status for when the user is not authorized for making the request
            401: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            //The status for when form data is not valid
            422: function (response) {
                var responseJson = $.parseJSON(response.responseText);
                var errors = responseJson.errors;
                var errorMessage = "";
                $.each(errors, function(index, value) {
                    errorMessage += value;
                });
                toastr["error"]( errorMessage , "پیام سیستم");
                // console.log(errors);
            },
            //The status for when there is error php code
            500: function (response) {
                console.log(response);
            },
            //The status for when there is error php code
            503: function (response) {
                console.log(response);
            }
        },
        async: true,
        cache: false,
        contentType: false,
        processData: false
        // timeout: 60000,
    });

    $("#profilePhotoAjaxLoadingSpinner").hide();
};

Upload.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .status").text(percent + "%");
};

//Change id to your id
$("#profilePhotoAjaxForm").on("submit", function (e) {
    e.preventDefault();
    var file = $("#profilePhotoFile")[0].files[0];
    var upload = new Upload(file);

    // maby check size or type here with upload.getSize() and upload.getType()

    // execute upload
    upload.doUpload();
});

$("#profilePhotoFile").change(function (){

    var fileName = $(this).val();
    if(fileName.length > 0)
    {
        $("#uploadProfilePhotoAjaxSubmit").show();
    }
    else
    {
        $("#uploadProfilePhotoAjaxSubmit").hide();
    }
});