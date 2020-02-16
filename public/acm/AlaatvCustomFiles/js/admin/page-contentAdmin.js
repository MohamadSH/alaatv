// Ajax of Modal forms
var $modal = $('#ajax-modal');

/**
 * Assignment Admin Ajax
 */
function removeAssignment(url){
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
            toastr["success"]("تمرین با موفقیت حذف شد!", "پیام سیستم");
            $("#assignment-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
$(document).on("click", "#assignmentForm-submit", function (){

    $('body').modalmanager('loading');
    var el = $(this);


    //initializing form alerts
    $("#assignmentName").parent().removeClass("has-error");
    $("#assignmentNameAlert > strong").html("");
    $("#assignmentstatus_id").parent().removeClass("has-error");
    $("#assignmentstatusAlert > strong").html("");
    $("#assignment_major").parent().removeClass("has-error");
    $("#assignmentMajorAlert > strong").html("");
    $("#assignmentAnalysisVideoLink").parent().removeClass("has-error");
    $("#assignmentAnalysisVideoLinkAlert > strong").html("");
    $("#assignmentNumberOfQuestions").parent().removeClass("has-error");
    $("#assignmentNumberOfQuestionsAlert > strong").html("");
    $("#assignmentQuestionFile").parent().removeClass("has-error");
    $("#assignmentQuestionFileAlert > strong").html("");
    $("#assignmentSolutionFile").parent().removeClass("has-error");
    $("#assignmentSolutionFileAlert > strong").html("");


    var formData = new FormData($("#assignmentForm")[0]);
    formData.append("description", $("#assignmentSummerNote").summernote('code'));

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
        url: $("#assignmentForm").attr("action"),
        data: formData,
        statusCode: {
            200: function (response) {
                toastr["success"]("درج تمرین با موفقیت انجام شد!", "پیام سیستم");
                $("#assignmentForm-close").trigger("click");
                $("#assignment-portlet .reload").trigger("click");
                $("#assignmentSolutionFile-remove").trigger("click");
                $("#assignmentQuestionFile-remove").trigger("click");
                $("#assignmentSummerNote").summernote('reset');
                $('#assignmentForm')[0].reset();
                $('#assignment_major').multiSelect('refresh');
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
                    switch(index){
                        case "name":
                            $("#assignmentName").parent().addClass("has-error");
                            $("#assignmentName_alert > strong").html(value);
                            break;
                        case "assignmentstatus_id":
                            $("#assignmentstatus_id").parent().addClass("has-error");
                            $("#assignmentstatusAlert > strong").html(value);
                            break;
                        case "majors":
                            $("#assignment_major").parent().addClass( "has-error");
                            $("#assignmentMajorAlert > strong").html(value);
                            break;
                        case "analysisVideoLink":
                            $("#assignmentAnalysisVideoLink").parent().addClass("has-error");
                            $("#assignmentAnalysisVideoLinkAlert > strong").html(value);
                            break;
                        case "numberOfQuestions":
                            $("#assignmentNumberOfQuestions").parent().addClass("has-error");
                            $("#assignmentNumberOfQuestionsAlert > strong").html(value);
                            break;
                        case "questionFile":
                            $("#assignmentQuestionFile-div").addClass("has-error");
                            $("#assignmentQuestionFileAlert").addClass("font-red");
                            break;
                        case "solutionFile":
                            $("#assignmentSolutionFile-div").addClass("has-error");
                            $("#assignmentSolutionFileAlert").addClass("font-red");
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
$(document).on("click", "#assignment-portlet .reload", function (){
    $("#assignment-portlet-loading").removeClass("d-none");
    $('#assignment_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/assignment",
        success: function (result) {
            var newDataTable =$("#assignment_table").DataTable();
            newDataTable.destroy();
            $('#assignment_table > tbody').html(result);
            makeDataTable("assignment_table");
            $("#assignment-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});


/**
 * Consultation Admin Ajax
 */
function removeConsultation(url){
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
            toastr["success"]("مشاوره با موفقیت حذف شد!", "پیام سیستم");
            $("#consultation-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
$(document).on("click", "#consultationForm-submit", function (){
    $('body').modalmanager('loading');
    var el = $(this);

    //initializing form alerts
    $("#consultationName").parent().removeClass("has-error");
    $("#consultationNameAlert > strong").html("");
    $("#consultationstatus_id").parent().removeClass("has-error");
    $("#consultationstatusAlert > strong").html("");
    $("#consultation_major").parent().removeClass("has-error");
    $("#consultationMajorAlert > strong").html("");
    $("#consultationVideoPageLink").parent().removeClass("has-error");
    $("#consultationVideoPageLinkAlert > strong").html("");
    $("#consultationTextScriptLink").parent().removeClass("has-error");
    $("#consultationTextScriptLinkAlert > strong").html("");
    $("#thumbnail-div").parent().removeClass("has-error");
    $("#thumbnailAlert > strong").html("");

    var formData = new FormData($("#consultationForm")[0]);
    formData.append("description", $("#consultationSummerNote").summernote('code'));

    $.ajax({
        type: "POST",
        url: $("#consultationForm").attr("action"),
        data: formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $("#consultationForm-close").trigger("click");
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
                toastr["success"]("درج مشاوره با موفقیت انجام شد!", "پیام سیستم");

                $("#consultation-portlet .reload").trigger("click");
                $("#consultationThumbnail-remove").trigger("click");
                $("#consultationSummerNote").summernote('reset');
                $('#consultationForm')[0].reset();
                $('#consultation_major').multiSelect('refresh');
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
                $.each(errors, function(index, value) {
                    switch (index) {
                        case "name":
                            $("#consultationName").parent().addClass("has-error");
                            $("#consultationNameAlert > strong").html(value);
                            break;
                        case "consultationstatus_id":
                            $("#consultationstatus_id").parent().addClass("has-error");
                            $("#consultationstatusAlert > strong").html(value);
                            break;
                        case "majors":
                            $("#consultation_major").parent().addClass("has-error");
                            $("#consultationMajorAlert > strong").html(value);
                            break;
                        case "videoPageLink":
                            $("#consultationVideoPageLink").parent().addClass("has-error");
                            $("#consultationVideoPageLinkAlert > strong").html(value);
                            break;
                        case "textScriptLink":
                            $("#consultationTextScriptLink").parent().addClass("has-error");
                            $("#consultationTextScriptLinkAlert > strong").html(value);
                            break;
                        case "thumbnail":
                            $("#thumbnail-div").addClass("has-error");
                            $("#thumbnailAlert").addClass("font-red");
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
        processData: false,
    });
    $modal.modal().hide();
    $modal.modal('toggle');
});
$(document).on("click", "#consultation-portlet .reload", function (){
    $("#consultation-portlet-loading").removeClass("d-none");
    $('#consultation_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/consultation",
        success: function (result) {
            var newDataTable =$("#consultation_table").DataTable();
            newDataTable.destroy();
            $('#consultation_table > tbody').html(result);
            makeDataTable("consultation_table");
            $("#consultation-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});


/**
 * Question Admin Ajax
 */
$(document).on("click", "#question-portlet .reload", function (){
    $("#question-portlet-loading").removeClass("d-none");
    $('#question_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/userupload",
        success: function (result) {
            var newDataTable =$("#question_table").DataTable();
            newDataTable.destroy();
            $('#question_table > tbody').html(result);
            makeDataTable("question_table");
            $("#question-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});
$(document).on("click", ".useruploadUpdate", function (e){
    e.preventDefault();
    var question_id = $(this).closest('tr').attr('id');
    var form = $("#useruploadForm_"+question_id);
    formData = form.serialize();
    url = form.attr("action");
    $.ajax({
        type: 'PUT',
        url: url,
        data:formData ,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
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
                $("#question-portlet .reload").trigger("click");
                toastr["success"]("اصلاح وضعیت سؤال  با موفقیت انجام شد!", "پیام سیستم");
                if(response == 200) toastr["success"]("پیامک تغییر وضعیت سوال با موفقیت به کاربر ارسال شد!", "پیام سیستم");
                else if(response == 451) toastr["error"]("کاربری برای ارسال پیامک انتخاب نشده است!", "پیام سیستم");
                else if(response == 503) toastr["error"]("خطای در ارسال پیامک!", "پیام سیستم");

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
                $.each(errors, function(index, value) {
                    switch (index) {
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
        // contentType: false,
        processData: false
    });
});


/**
 * Article Admin Ajax
 */
function removeArticle(url){
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
            toastr["success"]("مقاله با موفقیت حذف شد!", "پیام سیستم");
            $("#article-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
// $(document).on("click", "#articleForm-submit", function (){
//
//     $('body').modalmanager('loading');
//     var el = $(this);
//
//
//     //initializing form alerts
//     $("#articleTitle").parent().removeClass("has-error");
//     $("#articleTitleAlert > strong").html("");
//     $("#articleKeywordSummerNote").parent().removeClass("has-error");
//     $("#articleKeywordSummerNoteAlert > strong").html("");
//     $("#articleBriefSummerNote").parent().removeClass("has-error");
//     $("#articleBriefSummerNoteAlert > strong").html("");
//     $("#articleBodySummerNote").parent().removeClass("has-error");
//     $("#articleBodySummerNoteAlert > strong").html("");
//
//
//     var formData = new FormData($("#articleForm")[0]);
//     formData.append("keyword", $("#articleKeywordSummerNote").summernote('code'));
//     formData.append("brief", $("#articleBriefSummerNote").summernote('code'));
//     formData.append("body", $("#articleBodySummerNote").summernote('code'));
//
//     toastr.options = {
//         "closeButton": true,
//         "debug": false,
//         "positionClass": "toast-top-center",
//         "onclick": null,
//         "showDuration": "1000",
//         "hideDuration": "1000",
//         "timeOut": "5000",
//         "extendedTimeOut": "1000",
//         "showEasing": "swing",
//         "hideEasing": "linear",
//         "showMethod": "fadeIn",
//         "hideMethod": "fadeOut"
//     };
//
//     $.ajax({
//         type: "POST",
//         url: $("#articleForm").attr("action"),
//         data: formData,
//         statusCode: {
//             //The status for when action was successful
//             200: function (response) {
//                 toastr["success"]("درج محصول با موفقیت انجام شد!", "پیام سیستم");
//                 $("#articleForm-close").trigger("click");
//                 $("#article-portlet .reload").trigger("click");
//                 $("#articleImage-remove").trigger("click");
//                 $("#articleKeywordSummerNote").summernote('reset');
//                 $("#articleBriefSummerNote").summernote('reset');
//                 $("#articleBodySummerNote").summernote('reset');
//                 $('#articleForm')[0].reset();
//             },
//             //The status for when the user is not authorized for making the request
//             403: function (response) {
//                 window.location.replace("/403");
//             },
//             404: function (response) {
//                 window.location.replace("/404");
//             },
//             //The status for when form data is not valid
//             422: function (response) {
//                 var errors = $.parseJSON(response.responseText);
//                 $.each(errors, function(index, value) {
//                     switch(index){
//                         case "title":
//                             $("#articleTitle").parent().addClass("has-error");
//                             $("#articleTitleAlert > strong").html(value);
//                             break;
//
//                         case "image":
//                             $("#image-div").addClass("has-error");
//                             $("#articleImageAlert > strong").html(value);
//                             break;
//
//                         case "keyword":
//                             $("#articleKeywordSummerNote").parent().addClass("has-error");
//                             $("#articleKeywordSummerNoteAlert > strong").html(value);
//                             break;
//
//                         case "brief":
//                             $("#articleBriefSummerNote").parent().addClass("has-error");
//                             $("#articleBriefSummerNoteAlert > strong").html(value);
//                             break;
//
//                         case "body":
//                             $("#articleBodySummerNote").parent().addClass("has-error");
//                             $("#articleBodySummerNoteAlert > strong").html(value);
//                             break;
//
//                     }
//                 });
//             },
//             //The status for when there is error php code
//             500: function (response) {
//                 toastr["error"]("خطای برنامه!", "پیام سیستم");
//             },
//             //The status for when there is error php code
//             503: function (response) {
//                 toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
//             }
//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     });
//
//     $modal.modal().hide();
//     $modal.modal('toggle');
//
// });
$(document).on("click", "#article-portlet .reload", function (){
    $("#article-portlet-loading").removeClass("d-none");
    $('#article_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/article",
        success: function (result) {
            var newDataTable =$("#article_table").DataTable();
            newDataTable.destroy();
            $('#article_table > tbody').html(result);
            makeDataTable("article_table");
            $("#article-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});


/**
 * Articlecategory Admin Ajax
 */
function removeArticlecategory(url){
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
            toastr["success"]("دسته بندی با موفقیت حذف شد!", "پیام سیستم");
            $("#articlecategory-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
$(document).on("click", "#articlecategoryForm-submit", function (){

    $('body').modalmanager('loading');
    var el = $(this);


    //initializing form alerts
    $("#articlecategoryName").parent().removeClass("has-error");
    $("#articlecategoryNameAlert > strong").html("");
    $("#articlecategoryEnable").parent().removeClass("has-error");
    $("#articlecategoryEnableAlert > strong").html("");
    $("#articlecategoryOrder").parent().removeClass("has-error");
    $("#articlecategoryOrderAlert > strong").html("");
    $("#articlecategoryDescription").parent().removeClass("has-error");
    $("#articlecategoryDescriptionAlert > strong").html("");


    var formData = new FormData($("#articlecategoryForm")[0]);

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
        url: $("#articlecategoryForm").attr("action"),
        data: formData,
        statusCode: {
            200: function (response) {
                toastr["success"]("درج دسته با موفقیت انجام شد!", "پیام سیستم");
                $("#articlecategoryForm-close").trigger("click");
                $("#articlecategory-portlet .reload").trigger("click");
                $('#articlecategoryForm')[0].reset();
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
                    switch(index){
                        case "name":
                            $("#articlecategoryName").parent().addClass("has-error");
                            $("#articlecategoryNameAlert > strong").html(value);
                            break;
                        case "enable":
                            $("#articlecategoryEnable").parent().addClass("has-error");
                            $("#articlecategoryEnableAlert > strong").html(value);
                            break;
                        case "order":
                            $("#articlecategoryOrder").parent().addClass("has-error");
                            $("#articlecategoryOrderAlert > strong").html(value);
                            break;
                        case "description":
                            $("#articlecategoryDescription").parent().addClass("has-error");
                            $("#articlecategoryDescriptionAlert > strong").html(value);
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
$(document).on("click", "#articlecategory-portlet .reload", function (){
    $("#articlecategory-portlet-loading").removeClass("d-none");
    $('#articlecategory_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/articlecategory",
        success: function (result) {
            var newDataTable =$("#articlecategory_table").DataTable();
            newDataTable.destroy();
            $('#articlecategory_table > tbody').html(result);
            makeDataTable("articlecategory_table");
            $("#articlecategory-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});


/**
 * MBTIAnswer Admin Ajax
 */
$(document).on("click", "#mbtiAnswer-portlet .reload", function (){
    $("#mbtiAnswer-portlet-loading").removeClass("d-none");
    $('#mbtiAnswer_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/mbtianswer",
        success: function (result) {
            var newDataTable =$("#mbtiAnswer_table").DataTable();
            newDataTable.destroy();
            $('#mbtiAnswer_table > tbody').html(result);
            makeDataTable("mbtiAnswer_table");
            $("#mbtiAnswer-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});

/**
 * Educational Content Admin Ajax
 */
$(document).on("click", "#content-portlet .reload", function (){
    $("#content-portlet-loading").removeClass("d-none");
    $('#educationalContent_table > tbody').html("");
    var columns = ["name" ,  "enable",  "description" , "grade" , "major" , "contentType" , "file" , "created_at" , "updated_at" , "validSince" , "action"] ;
    var url = $("#content-portlet-action").text();
    $.ajax({
        type: "GET",
        url: url,
        data: {"columns":columns ,"controlPanel":true} ,
        success: function (result) {
            var newDataTable =$("#educationalContent_table").DataTable();
            newDataTable.destroy();
            $('#educationalContent_table > tbody').html(result);
            makeDataTable("educationalContent_table");
            $("#content-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});
function removeEducationalContent(url){
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
        url: url,
        data:{_method: 'delete'},
        statusCode: {
            200: function (response) {
                toastr["success"]("محتوای آموزشی با موفقیت حذف شد!", "پیام سیستم");
                $("#content-portlet .reload").trigger("click");
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
        },
    });
}
