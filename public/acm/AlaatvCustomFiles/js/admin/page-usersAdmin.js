
function makeDataTable_loadWithAjax_users() {
    $("#user-portlet-loading").removeClass("d-none");
    $('#user_table > tbody').html("");
    let defaultContent="<span class=\"m-badge m-badge--wide label-sm m-badge--danger\"> درج نشده </span>";
    let columns = [
        {
            "data": "row_child",
            "defaultContent": ""
        },
        {"data": "lastName", "title": "نام خانوادگی", "defaultContent": defaultContent},
        {"data": "firstName", "title": "نام کوچک", "defaultContent": defaultContent},
        {"data": "info.major.name", "title": "رشته", "defaultContent": defaultContent},
        {"data": "nationalCode", "title": "کد ملی", "defaultContent": defaultContent},
        {"data": "mobile", "title": "موبایل", "defaultContent": defaultContent},
        {"data": "email", "title": "ایمیل", "defaultContent": defaultContent},
        {"data": "city", "title": "شهر", "defaultContent": defaultContent},
        {"data": "province", "title": "استان", "defaultContent": defaultContent},
        {
            "data": null,
            "name": "mobile_verify_status",
            "title": "وضعیت شماره موبایل",
            "render": function ( data, type, row ) {
                if (row.mobile_verified_at === null) {
                    return '<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">تایید نشده</span>';
                }
                return '<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">تایید شده</span>';
            },
        },
        {"data": "postalCode", "title": "کد پستی", "defaultContent": defaultContent},
        {"data": "address", "title": "آدرس", "defaultContent": defaultContent},
        {"data": "school", "title": "مدرسه", "defaultContent": defaultContent},
        {"data": "userstatus.displayName", "title": "وضعیت", "defaultContent": defaultContent},
        {"data": "jalaliCreatedAt", "title": "زمان ثبت نام", "defaultContent": defaultContent},
        {"data": "jalaliUpdatedAt", "title": "زمان اصلاح", "defaultContent": defaultContent},
        {
            "data": null,
            "name": "roles",
            "title": "نقش های کاربر",
            defaultContent: '<span class="m-badge m-badge--metal m-badge--wide m-badge--rounded">ندارد</span>',
            "render": function ( data, type, row ) {
                if (row.roles  == null ||  row.roles.length === 0) {
                    return '<span class="m-badge m-badge--metal m-badge--wide m-badge--rounded">ندارد</span>';
                }

                let rolesHtml = '';
                for (let index in row.roles) {
                    if(isNaN(index)) {
                        continue;
                    }
                    let role = row.roles[index];
                    rolesHtml += '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded">'+role.display_name+'</span>';
                }
                return rolesHtml;
            },
        },
        {"data": "totalBonNumber", "title": "تعداد بن", "defaultContent": defaultContent},
        {
            "data": null,
            "name": "functions",
            "title": "عملیات",
            defaultContent: '',
            "render": function (data, type, row) {
                return '\n' +
                    '            <div class="btn-group">\n' +
                    '                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات</button>\n' +
                    '                <ul class="dropdown-menu" role="menu" id="' + row.id + '">\n' +
                    '                    <li>\n' +
                    '                        <a target="_blank" href="'+row.editLink+'">\n' +
                    '                            <i class="flaticon-edit" aria-hidden="true"></i> ویرایش\n' +
                    '                        </a>\n' +
                    '                    </li>\n' +
                    '                    <li>\n' +
                    '                        <a class="deleteUser" data-target="#deleteUserConfirmationModal" data-toggle="modal" data-link="'+row.removeLink+'" data-fullname="'+row.firstName+' '+row.lastName+'">\n' +
                    '                            <i class="flaticon-delete" aria-hidden="true"></i> حذف\n' +
                    '                        </a>\n' +
                    '                    </li>\n' +
                    '                    <li>\n' +
                    '                        <a class="addBon" data-target="#addBonModal" data-toggle="modal">\n' +
                    '                            <i class="fa fa-plus" aria-hidden="true"></i> تخصیص بن\n' +
                    '                        </a>\n' +
                    '                    </li>\n' +
                    '                    <li>\n' +
                    '                        <a class="sendSms" data-target="#smsModal" data-toggle="modal">\n' +
                    '                            <i class="fa fa-envelope" aria-hidden="true"></i> ارسال پیامک\n' +
                    '                        </a>\n' +
                    '                    </li>\n' +
                    '                    <li>\n' +
                    '                        <a href="'+$('#contactUrl').val()+row.id+'" target="_blank">\n' +
                    '                            <i class="flaticon-book" aria-hidden="true"></i> دفترچه تلفن\n' +
                    '                        </a>\n' +
                    '                    </li>\n' +
                    '                </ul>\n' +
                    '                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>\n' +
                    '            </div>';
            },
            // function ( api, rowIdx, columns ) {
            //     return 'hi';
            //     // var data = $.map( columns, function ( col, i ) {
            //     //     return col.hidden ?
            //     //         '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
            //     //         '<td>'+col.title+':'+'</td> '+
            //     //         '<td>'+col.data+'</td>'+
            //     //         '</tr>' :
            //     //         '';
            //     // } ).join('');
            //     //
            //     // return data ?
            //     //     $('<table/>').append( data ) :
            //     //     false;
            // }

        },
    ];
    let dataFilter = function (data) {
        var json = jQuery.parseJSON(data);
        json.recordsTotal = json.total;
        json.recordsFiltered = json.total;
        return JSON.stringify(json); // return JSON string
    };
    let ajaxData = function (data) {
        mApp.block('#user_table_wrapper', {
            type: "loader",
            state: "info",
        });
        data.orders = getNextPageParam(data.start, data.length);
        delete data.columns;
        let $form = $("#filterUserForm");
        let formData = getFormData($form);
        /* Merge data and formData, without modifying data */
        data = $.extend({}, data, formData);
        return data;
    };
    let dataSrc = function (json) {
        $("#user-portlet-loading").addClass("d-none");
        mApp.unblock('#user_table_wrapper');
        return json.data;
    };
    makeDataTable_loadWithAjax("user_table", $("#filterUserForm").attr("action"), columns, dataFilter, ajaxData, dataSrc);
}

// Ajax of Modal forms
var $modal = $('#ajax-modal');

/**
 * User Admin Ajax
 */
$(document).on("click", ".deleteUser", function (){
    var removeLink = $(this).data('link');
    var fullname = $(this).data('fullname');
    $("input[name=user_remove_link]").val(removeLink);
    $("#deleteUserFullName").text(fullname);
});
function removeUser(){
    mApp.block('#deleteUserConfirmationModal', {
        type: "loader",
        state: "success",
    });
    var removeLink = $("input[name=user_remove_link]").val();
    $.ajax({
        type: 'POST',
        url: removeLink,
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
            toastr["success"]("کاربر با موفقیت حذف شد!", "پیام سیستم");
            // $("#user-portlet .reload").trigger("click");
            mApp.unblock('#deleteUserConfirmationModal');
            $('#deleteUserConfirmationModal').modal('hide');

            var newDataTable =$("#user_table").DataTable();
            newDataTable.destroy();
            makeDataTable_loadWithAjax_users();
        },
        error: function (result) {
            mApp.unblock('#deleteUserConfirmationModal');
            $('#deleteUserConfirmationModal').modal('hide');

            var newDataTable =$("#user_table").DataTable();
            newDataTable.destroy();
            makeDataTable_loadWithAjax_users();
        }
    });
}
$(document).on("click", "#userForm-submit", function (){
    mApp.block('#responsive-user', {
        type: "loader",
        state: "success",
    });
    var el = $(this);

    //initializing form alerts
    $("#firstName").parent().removeClass("has-error");
    $("#firstNameAlert > strong").html("");
    $("#lastName").parent().removeClass("has-error");
    $("#lastNameAlert > strong").html("");
    $("#mobile").parent().removeClass("has-error");
    $("#mobileAlert > strong").html("");
    $("#password").parent().removeClass("has-error");
    $("#passwordAlert > strong").html("");
    $("#nationalCode").parent().removeClass("has-error");
    $("#nationalCodeAlert > strong").html("");
    $("#userMajor").parent().removeClass("has-error");
    $("#userMajorAlert > strong").html("");
    $("#userGender").parent().removeClass("has-error");
    $("#userGenderAlert > strong").html("");
    $("#photo-div").parent().removeClass("has-error");
    $("#photoAlert > strong").html("");
    $("#userstatus_id").parent().removeClass("has-error");
    $("#userstatusAlert > strong").html("");
    $("#postalcode").parent().removeClass("has-error");
    $("#postalCodeAlert > strong").html("");
    $("#email").parent().removeClass("has-error");
    $("#emailAlert > strong").html("");

    var formData = new FormData($("#userForm")[0]);
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
        url: $("#userForm").attr("action"),
        data: formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $("#userForm-close").trigger("click");
                $("#user-portlet .reload").trigger("click");
                $("#userPhoto-remove").trigger("click");
                $('#userForm')[0].reset();
                $('#user_role').multiSelect('refresh');
                var message ="";
                if(response.message != undefined && response.message!= null)
                    message += "<br />"+response.message;
                toastr["success"](message, "پیام سیستم");
                mApp.unblock('#responsive-user');
                $('#responsive-user').modal('hide');

                var newDataTable =$("#user_table").DataTable();
                newDataTable.destroy();
                makeDataTable_loadWithAjax_users();
            },
            //The status for when the user is not authorized for making the request
            403: function (response) {
                toastr["error"]("کد 403!", "پیام سیستم");
                mApp.unblock('#responsive-user');
                $('#responsive-user').modal('hide');

                var newDataTable =$("#user_table").DataTable();
                newDataTable.destroy();
                makeDataTable_loadWithAjax_users();
            },
            404: function (response) {
                toastr["error"]("کد 404!", "پیام سیستم");
                mApp.unblock('#responsive-user');
                $('#responsive-user').modal('hide');

                var newDataTable =$("#user_table").DataTable();
                newDataTable.destroy();
                makeDataTable_loadWithAjax_users();
            },
            //The status for when form data is not valid
            422: function (response) {
                toastr["error"]("خطای ورودی ها!", "پیام سیستم");
                var errors = $.parseJSON(response.responseText);
                $.each(errors.errors, function(index, value) {
                    switch (index) {
                        case "firstName":
                            $("#firstName").parent().addClass("has-error");
                            $("#firstNameAlert > strong").html(value);
                            break;
                        case "lastName":
                            $("#lastName").parent().addClass("has-error");
                            $("#lastNameAlert > strong").html(value);
                            break;
                        case "mobile":
                            $("#mobile").parent().addClass("has-error");
                            $("#mobileAlert > strong").html(value);
                            break;
                        case "password":
                            $("#password").parent().addClass("has-error");
                            $("#passwordAlert > strong").html(value);
                            break;
                        case "nationalCode":
                            $("#nationalCode").parent().addClass("has-error");
                            $("#nationalCodeAlert > strong").html(value);
                            break;
                        case "major_id":
                            $("#userMajor").parent().addClass("has-error");
                            $("#userMajorAlert > strong").html(value);
                            break;
                        case "gender_id":
                            $("#userGender").parent().addClass("has-error");
                            $("#userGenderAlert > strong").html(value);
                            break;
                        case "photo":
                            $("#photo-div").addClass("has-error");
                            $("#photoAlert").addClass("font-red");
                            break;
                        case "userstatus_id":
                            $("#userstatus_id").parent().addClass("has-error");
                            $("#userstatusAlert > strong").html(value);
                            break;
                        case "postalCode":
                            $("#postalCode").parent().addClass("has-error");
                            $("#postalCodeAlert > strong").html(value);
                            break;
                        case "email":
                            $("#email").parent().addClass("has-error");
                            $("#emailAlert > strong").html(value);
                            break;
                    }
                });
                mApp.unblock('#responsive-user');
                $('#responsive-user').modal('hide');

                var newDataTable =$("#user_table").DataTable();
                newDataTable.destroy();
                makeDataTable_loadWithAjax_users();
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
                mApp.unblock('#responsive-user');
                $('#responsive-user').modal('hide');

                var newDataTable =$("#user_table").DataTable();
                newDataTable.destroy();
                makeDataTable_loadWithAjax_users();
            },
            //The status for when there is error php code
            503: function (response) {
                var errors = $.parseJSON(response.responseText);
                if(errors.message != undefined && errors.message!= null)
                    toastr["error"](errors.message, "پیام سیستم");
                else
                    toastr["error"]("خطای غیر منتظره", "پیام سیستم");
                mApp.unblock('#responsive-user');
                $('#responsive-user').modal('hide');

                var newDataTable =$("#user_table").DataTable();
                newDataTable.destroy();
                makeDataTable_loadWithAjax_users();
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


/**
 * Event Result Admin Ajax
 */
$(document).on("click", ".eventResult-portlet .reload", function (){
    var identifier = $(this).data("role");
    var formData = $("#filter"+identifier+"Form").serialize();
    $("#"+identifier+"-portlet-loading").removeClass("hidden");
    $('#'+identifier+'_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/eventresult",
        data : formData ,
        success: function (result) {
            var newDataTable =$("#"+identifier+"_table").DataTable();
            newDataTable.destroy();
            $('#'+identifier+'_table > tbody').html(result);
            makeDataTable(identifier+"_table");
            $("#"+identifier+"-portlet-loading").addClass("hidden");
        },
        error: function (result) {
        }
    });

    return false;
});

var userAjax;
$(document).on("click", "#user-portlet .reload", function (){
    $("#user-portlet-loading").removeClass("d-none");
    $('#user_table > tbody').html("");


    var formData = $("#filterUserForm").serialize();

    if ($("#userTableColumnFilter").val() !== null) {
        var columns = $("#userTableColumnFilter").val();
        $("#user_table thead tr th").each(function () {
            if (columns.includes($(this).text().trim())) {
                $(this).removeClass().addClass("all");
            } else if ($(this).text() !== "") {
                $(this).removeClass().addClass("none");
            }
        });
    } else {
        $("#user_table thead tr th").each(function () {
            $(this).removeClass().addClass("none");
        });
    }


    var newDataTable = $("#user_table").DataTable();
    newDataTable.destroy();
    makeDataTable_loadWithAjax_users();


    // if(userAjax) {
    //     userAjax.abort();
    // }
    // userAjax = $.ajax({
    //     type: "GET",
    //     url: $("#filterUserForm").attr("action"),
    //     data: formData,
    //     contentType: "application/json",
    //     dataType: "json",
    //     statusCode: {
    //         200:function (response) {
    //             var responseJson = response;
    //             var newDataTable =$("#user_table").DataTable();
    //             newDataTable.destroy();
    //             $('#user_table > tbody').html(responseJson.index);
    //             if(response === null || response === "" ) {
    //                 $('#user_table > thead > tr').children('th:first').removeClass().addClass("none");
    //             }
    //             else{
    //                 $('#user_table > thead > tr').children('th:first').removeClass("none");
    //             }
    //             makeDataTable("user_table");
    //
    //             $("#user-portlet-loading").addClass("d-none");
    //             $(".filter").each(function () {
    //                 if($(this).val() !== "" && $(this).val() !== null) {
    //                     $(this).addClass("font-red");
    //                 }
    //             });
    //         },
    //         //The status for when the user is not authorized for making the request
    //         401:function (ressponse) {
    //             location.reload();
    //         },
    //         403: function (response) {
    //             window.location.replace("/403");
    //         },
    //         404: function (response) {
    //             window.location.replace("/404");
    //         },
    //         //The status for when form data is not valid
    //         422: function (response) {
    //             //
    //         },
    //         //The status for when there is error php code
    //         500: function (response) {
    //             toastr["error"]("خطای برنامه!", "پیام سیستم");
    //         },
    //         //The status for when there is error php code
    //         503: function (response) {
    //             toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
    //         }
    //     }
    // });

    // return false;
});
$(document).on("click", ".addBon", function (){
    var user_id = $(this).closest('ul').attr('id');
    $("input[name=user_id]").val(user_id);
    $("#bonUserFullName").text($("#userFullName_"+user_id).text());
});
$(document).on("click", "#userAttachBonForm-submit", function (){

    //initializing form alerts
    $("#userBonNumber").parent().removeClass("has-error");
    $("#userBonNumberAlert > strong").html("");

    var formData = new FormData($("#userAttachBonForm")[0]);

    $.ajax({
        type: "POST",
        url: $("#userAttachBonForm").attr("action"),
        data: formData,
        statusCode: {
            200: function (response) {
                $("#userAttachBonForm-close").trigger("click");
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
                $('#userAttachBonForm')[0].reset();
                $("#Bonuser-portlet .reload").trigger("click");
                toastr["success"]("بن با موفقیت تخصیص داده شد!", "پیام سیستم");
            },
            201: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
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
                        case "totalNumber":
                            $("#userBonNumber").parent().addClass("has-error");
                            $("#userBonNumberAlert > strong").html(value);
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
});
$(document).on("click", ".OrderFilteradio", function (){
    var radioValue = $(this).val();
    if(radioValue == "selectHasOrder")
    {
        $('#hasOrder').prop('disabled', false);
        $('#orderStatuses').prop('disabled', true);
        $('#orderStatuses').val(0);
    }else if(radioValue == "selectOrderStatus")
    {
        $('#orderStatuses').prop('disabled', false);
        $('#hasOrder').prop('disabled', true);
        $('#hasOrder').val(0);
    }
});
$(document).on("click", ".sendSms", function (){
    var user_id = $(this).closest('ul').attr('id');
    $("#users").val(user_id);
    $("#smsUserFullName").text($("#userFullName_"+user_id).text());
});
$(document).on("click", "#sendSmsForm-submit", function (){

    mApp.block('#smsModal', {
        type: "loader",
        state: "success",
    });

    $("#send-sms-loading").removeClass("d-none");

    //initializing form alerts
    $("#smsMessage").parent().removeClass("has-error");
    $("#smsMessageAlert > strong").html("");

    var formData = new FormData($("#sendSmsForm")[0]);

    $.ajax({
        type: "POST",
        url: $("#sendSmsForm").attr("action"),
        data: formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $("#send-sms-loading").addClass("d-none");
                $("#sendSmsForm-close").trigger("click");
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
                $("#sendSmsForm")[0].reset();
                toastr["success"]("پیامک با موفقیت ارسال شد!", "پیام سیستم");
                mApp.unblock('#smsModal');
                $('#smsModal').modal('hide');
                $("#send-sms-loading").addClass("d-none");
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
                $("#send-sms-loading").addClass("d-none");
                var errors = $.parseJSON(response.responseText);
                $.each(errors, function(index, value) {
                    switch (index) {
                        case "message":
                            $("#smsMessage").parent().addClass("has-error");
                            $("#smsMessageAlert > strong").html(value);
                            break;
                    }
                });
                mApp.unblock('#smsModal');
                $('#smsModal').modal('hide');
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
                mApp.unblock('#smsModal');
                $('#smsModal').modal('hide');
                $("#send-sms-loading").addClass("d-none");
            },
            //The status for when there is error php code
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                mApp.unblock('#smsModal');
                $('#smsModal').modal('hide');
                $("#send-sms-loading").addClass("d-none");
            },

            //The status for Unavailable For Legal Reasons
            451: function (response) {
                toastr["error"]("کاربری انتخاب نشده است!", "پیام سیستم");
                mApp.unblock('#smsModal');
                $('#smsModal').modal('hide');
                $("#send-sms-loading").addClass("d-none");
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });
});
$(document).ready(function () {

    $('#smsMessage').keyup(function() {
        var smsNumber = Math.floor(($('#smsMessage').val().length)/71)+1;
        $('#smsWords').text(70 - ($('#smsMessage').val().length%71));
        $('#smsNumber').text(smsNumber);
        $('#totalSmsCost').text(smsNumber*110);
    });
});
$(document).on("click", ".filter" , function () {
    if($(this).has("font-red")){
        $(this).removeClass("font-red");
    }
});


/**
 * Permission Admin Ajax
 */
function removePermission(url){
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
            toastr["success"]("دسترسی با موفقیت حذف شد!", "پیام سیستم");
            $("#permission-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
$(document).on("click", "#permissionForm-submit", function (){

    mApp.block('#responsive-permission', {
        type: "loader",
        state: "success",
    });

    var el = $(this);

    //initializing form alerts
    $("#permissionName").parent().removeClass("has-error");
    $("#permissionNameAlert > strong").html("");

    $("#permissionDisplayName").parent().removeClass("has-error");
    $("#permissionDisplayNameAlert > strong").html("");

    $("#permissionDescription").parent().removeClass("has-error");
    $("#permissionDescriptionAlert > strong").html("");

    var formData = new FormData($("#permissionForm")[0]);

    $.ajax({
        type: "POST",
        url: $("#permissionForm").attr("action"),
        data: formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $("#permissionForm-close").trigger("click");
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
                $("#permission-portlet .reload").trigger("click");
                $('#permissionForm')[0].reset();
                $('#responsive-permission').modal('hide');
                mApp.unblock('#responsive-permission');
                toastr["success"]("درج دسترسی با موفقیت انجام شد!", "پیام سیستم");
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
                            $("#permissionName").parent().addClass("has-error");
                            $("#permissionNameAlert > strong").html(value);
                            break;
                        case "display_name":
                            $("#permissionDisplayName").parent().addClass("has-error");
                            $("#permissionDisplayNameAlert > strong").html(value);
                            break;
                        case "description":
                            $("#permissionDescription").parent().addClass("has-error");
                            $("#permissionDescriptionAlert > strong").html(value);
                            break;

                    }
                });
                $('#responsive-permission').modal('hide');
                mApp.unblock('#responsive-permission');
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
                $('#responsive-permission').modal('hide');
                mApp.unblock('#responsive-permission');
            },
            //The status for when there is error php code
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                $('#responsive-permission').modal('hide');
                mApp.unblock('#responsive-permission');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    $('#responsive-permission').modal('hide');
    mApp.unblock('#responsive-permission');
});
$(document).on("click", "#permission-portlet .reload", function (){
    $("#permission-portlet-loading").removeClass("d-none");
    $('#permission_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/permission",
        success: function (result) {
            var newDataTable =$("#permission_table").DataTable();
            newDataTable.destroy();
            $('#permission_table > tbody').html(result);
            makeDataTable("permission_table");
            $("#permission-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});


/**
 * Role Admin Ajax
 */
function removeRole(url){
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
            toastr["success"]("نقش با موفقیت حذف شد!", "پیام سیستم");
            $("#role-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
$(document).on("click", "#roleForm-submit", function (){
    var el = $(this);

    //initializing form alerts
    $("#roleName").parent().removeClass("has-error");
    $("#roleNameAlert > strong").html("");

    $("#roleDisplayName").parent().removeClass("has-error");
    $("#roleDisplayNameAlert > strong").html("");

    $("#roleDescription").parent().removeClass("has-error");
    $("#roleDescriptionAlert > strong").html("");

    $("#role_permission").parent().removeClass("has-error");
    $("#PermissionAlert > strong").html("");

    var formData = new FormData($("#roleForm")[0]);

    $.ajax({
        type: "POST",
        url: $("#roleForm").attr("action"),
        data: formData,
        statusCode: {
            200: function (response) {
                $("#roleForm-close").trigger("click");
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
                $("#role-portlet .reload").trigger("click");
                $('#roleForm')[0].reset();
                $('#role_permission').multiSelect('refresh');
                toastr["success"]("درج نقش با موفقیت انجام شد!", "پیام سیستم");
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
                            $("#roleName").parent().addClass("has-error");
                            $("#roleNameAlert > strong").html(value);
                            break;
                        case "display_name":
                            $("#roleDisplayName").parent().addClass("has-error");
                            $("#roleDisplayNameAlert > strong").html(value);
                            break;
                        case "description":
                            $("#roleDescription").parent().addClass("has-error");
                            $("#roleDescriptionAlert > strong").html(value);
                            break;
                        case "permissions[]":
                            $("#role_permission").parent().addClass( "has-error");
                            $("#permissionAlert > strong").html(value);
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
});
$(document).on("click", "#role-portlet .reload", function (){
    $("#role-portlet-loading").removeClass("d-none");
    $('#role_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/role",
        success: function (result) {
            var newDataTable =$("#role_table").DataTable();
            newDataTable.destroy();
            $('#role_table > tbody').html(result);
            makeDataTable("role_table");
            $("#role-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});

$('#userCreatedTimeEnable').click(function () {
    if($('#userCreatedTimeEnable').prop('checked') == true) {
        $('#userCreatedSince').attr('disabled' ,false);
        $('#userCreatedTill').attr('disabled' ,false);
    }
    else {
        $('#userCreatedSince').attr('disabled' ,true);
        $('#userCreatedTill').attr('disabled' ,true);
    }
});

$('#userUpdatedTimeEnable').click(function () {
    if($('#userUpdatedTimeEnable').prop('checked') == true) {
        $('#userUpdatedSince').attr('disabled' ,false);
        $('#userUpdatedTill').attr('disabled' ,false);
    }
    else {
        $('#userUpdatedSince').attr('disabled' ,true);
        $('#userUpdatedTill').attr('disabled' ,true);
    }
});


$('#roleEnable').click(function () {
    if($('#roleEnable').prop('checked') == true) {
        $('#roles').prop('disabled' ,false);
        $("#rolesButton").prop('disabled' ,false);
        $("#rolesButton").removeClass('disabled');
    }
    else {
        $('#roles').prop('disabled' ,true);
        $("#rolesButton").prop('disabled' ,true);
        $("#rolesButton").addClass('disabled');
    }
});

$('#majorEnable').click(function () {
    if($('#majorEnable').prop('checked') == true) {
        $('#majors').prop('disabled' ,false);
        $("#majorsButton").prop('disabled' ,false);
        $("#majorsButton").removeClass('disabled');
    }
    else {
        $('#majors').prop('disabled' ,true);
        $("#majorsButton").prop('disabled' ,true);
        $("#majorsButton").addClass('disabled');
    }
});

$('#couponEnable').click(function () {
    if($('#couponEnable').prop('checked') == true) {
        $('#coupons').prop('disabled' ,false);
        $("#couponsButton").prop('disabled' ,false);
        $("#couponsButton").removeClass('disabled');
    }
    else {
        $('#coupons').prop('disabled' ,true);
        $("#couponsButton").prop('disabled' ,true);
        $("#couponsButton").addClass('disabled');
    }
});

$('#productEnable').click(function () {
    if($('#productEnable').prop('checked') == true) {
        $('#products').prop('disabled' ,false);
        $("#productsButton").prop('disabled' ,false);
        $("#productsButton").removeClass('disabled');
    }
    else {
        $('#products').prop('disabled' ,true);
        $("#productsButton").prop('disabled' ,true);
        $("#productsButton").addClass('disabled');
    }
});

$('#orderProductEnable').click(function () {
    if($('#orderProductEnable').prop('checked') == true) {
        $('#orderProducts').prop('disabled' ,false);
        $("#orderProductsButton").prop('disabled' ,false);
        $("#orderProductsButton").removeClass('disabled');
    }
    else {
        $('#orderProducts').prop('disabled' ,true);
        $("#orderProductsButton").prop('disabled' ,true);
        $("#orderProductsButton").addClass('disabled');
    }
});


$('#withoutPostalCode').click(function () {
    if($('#withoutPostalCode').prop('checked') == true) {
        $('#postalCodeFilter').attr('disabled' ,true);
        $('#postalCodeFilter').val(null);
    }
    else {
        $('#postalCodeFilter').attr('disabled' ,false);
    }
});


$('#withoutProvince').click(function () {
    if($('#withoutProvince').prop('checked') == true) {
        $('#provinceFilter').attr('disabled' ,true);
        $('#provinceFilter').val(null);
    }
    else {
        $('#provinceFilter').attr('disabled' ,false);
    }
});

$('#withoutCity').click(function () {
    if($('#withoutCity').prop('checked') == true) {
        $('#cityFilter').attr('disabled' ,true);
        $('#cityFilter').val(null);
    }
    else {
        $('#cityFilter').attr('disabled' ,false);
    }
});

$('#withoutAddress').click(function () {
    if($('#withoutAddress').prop('checked') == true) {
        $('#addressFilter').attr('disabled' ,true);
        $('#addressFilter').val(null);
    }
    else {
        $('#addressFilter').attr('disabled' ,false);
    }
});

$('#withoutSchool').click(function () {
    if($('#withoutSchool').prop('checked') == true) {
        $('#schoolFilter').attr('disabled' ,true);
        $('#schoolFilter').val(null);
    }
    else {
        $('#schoolFilter').attr('disabled' ,false);
    }
});

$('#withoutEmail').click(function () {
    if($('#withoutEmail').prop('checked') == true) {
        $('#emailFilter').attr('disabled' ,true);
        $('#emailFilter').val(null);
    }
    else {
        $('#emailFilter').attr('disabled' ,false);
    }
});

$('#addressSpecialFilter').change(function () {
    if($(this).val() == "1" || $(this).val() == "2") {
        $('#addressFilter').attr('disabled' ,true);
    }
    else {
        $('#addressFilter').attr('disabled' ,false);
    }
});

//should run at first
$("#user_table thead tr th").each(function () {
    if (!$(this).hasClass("none")) {
        thText = $(this).text().trim();
        $("#userTableColumnFilter > option").each(function () {
            if ($(this).val() === thText) {
                $(this).prop("selected", true);
            }
        });
    }
});

//date picker jquery
$(document).ready(function () {
    /*
     registeredSince
     */
    $("#userCreatedSince").persianDatepicker({
        altField: '#userCreatedSinceAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    /*
     registeredTill
     */
    $("#userCreatedTill").persianDatepicker({
        altField: '#userCreatedTillAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    /*
     updatedSince
     */
    $("#userUpdatedSince").persianDatepicker({
        altField: '#userUpdatedSinceAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    /*
     updatedTill
     */
    $("#userUpdatedTill").persianDatepicker({
        altField: '#userUpdatedTillAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
});


