
// $('#order_table > thead > tr').children('th:first').removeClass().addClass("none");
$("#order_table thead tr th").each(function () {
    if (!$(this).hasClass("none")) {
        thText = $(this).text().trim();
        $("#orderTableColumnFilter > option").each(function () {
            if ($(this).val() === thText) {
                $(this).prop("selected", true);
            }
        });
    }
});

$('#transaction_table > thead > tr').children('th:first').removeClass().addClass("none");
$("#transaction_table thead tr th").each(function () {
    if (!$(this).hasClass("none")) {
        thText = $(this).text().trim();
        $("#transactionTableColumnFilter > option").each(function () {
            if ($(this).val() === thText) {
                $(this).prop("selected", true);
            }
        });
    }
});

$("#userBon_table thead tr th").each(function () {
    if (!$(this).hasClass("none")) {
        thText = $(this).text().trim();
        $("#userBonTableColumnFilter > option").each(function () {
            if ($(this).val() === thText) {
                $(this).prop("selected", true);
            }
        });
    }
});

$(document).on("click", "#orderSpecialFilterEnable", function () {
    if ($("#orderProduct option:selected").length === 0) {
        alert("لطفا ابتدا محصولی را انتخاب کنید");
        $(this).attr('checked', false);
    }
});



// Ajax of Modal forms
var $modal = $('#ajax-modal');

/**
 * Order Admin Ajax
 */
$(document).on("click", ".deleteOrder", function (){
    // var order_id = $(this).parent().find('.order_id').attr('id');
    var remove_link = $(this).attr('remove-link');
    var fullname = $(this).attr('fullname');
    $("input[name=order_id]").val(remove_link);
    $("#deleteOrderTitle").text(fullname + " مربوط به ");
});
function removeOrder(){
    mApp.block('#deleteOrderConfirmationModal', {
        type: "loader",
        state: "success",
    });
    var remove_link = $("input[name=order_id]").val();
    $.ajax({
        type: 'POST',
        url: remove_link,
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
            toastr["success"]("سفارش با موفقیت حذف شد!", "پیام سیستم");
            // $("#order-portlet .reload").trigger("click");
            $('#deleteOrderConfirmationModal').modal('hide');
            mApp.unblock('#deleteOrderConfirmationModal');

            var newDataTable =$("#order_table").DataTable();
            newDataTable.destroy();
            makeDataTable_loadWithAjax_orders();
        },
        error: function (result) {
            mApp.unblock('#deleteOrderConfirmationModal');

            var newDataTable =$("#order_table").DataTable();
            newDataTable.destroy();
            makeDataTable_loadWithAjax_orders();
        }
    });
}

var orderAjax;
var myOrderproducts ;
$(document).on("click", "#order-portlet .reload", function (){
    // var formData = new FormData($("#filterOrderForm")[0]);
    // var formData = $("#filterOrderForm").serialize();
    // $("#order-portlet-loading").removeClass("d-none");
    $('#order_table > tbody').html("");


    if($("#orderTableColumnFilter").val() !== null) {
        var columns = $("#orderTableColumnFilter").val();
        $("#order_table thead tr th").each(function() {
            if(columns.includes($(this).text().trim())){
                $(this).removeClass().addClass("all");
            }
            else if($(this).text() !== "") {
                $(this).removeClass().addClass("none");
            }
        });
    }
    else {
        $("#order_table thead tr th").each(function() {
            $(this).removeClass().addClass("none");
        });
    }

    $("#checkOutButton").addClass("d-none") ;
    if(orderAjax) {
        orderAjax.abort();
    }

    var newDataTable =$("#order_table").DataTable();
    newDataTable.destroy();
    makeDataTable_loadWithAjax_orders();
    //
    // orderAjax = $.ajax({
    //     type: "GET",
    //     url: "/order",
    //     data: formData,
    //     contentType: "application/json",
    //     dataType: "json",
    //     statusCode: {
    //         200:function (response) {
    //             myOrderproducts = response.myOrderproducts;
    //             if(myOrderproducts.length > 0 ) {
    //                 $("#checkOutButton").removeClass("d-none") ;
    //             }
    //             var newDataTable =$("#order_table").DataTable();
    //             newDataTable.destroy();
    //             $('#order_table > tbody').html(response.index);
    //             if(response === null || response === "" ) {
    //                 $('#order_table > thead > tr').children('th:first').removeClass().addClass("none");
    //             }
    //             else{
    //                 $('#order_table > thead > tr').children('th:first').removeClass("none");
    //             }
    //             makeDataTable("order_table");
    //             $("#order-portlet-loading").addClass("d-none");
    //             $("#orderEmptyTableMessage").hide();
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

    return false;
});
$(document).on("click", ".filter" , function () {
    if($(this).has("font-red")){
        $(this).removeClass("font-red");
    }
});

$(document).on("click", ".sendSms", function (){
    var userFullname = $(this).parent().find('.userFullname').val();
    var user_id = $(this).parent().find('.userId').val();
    $("#users").val(user_id);
    $("#smsUserFullName").text(userFullname);
});
$(document).on("click", "#sendSmsForm-submit", function (){

    // $('body').modalmanager('loading');
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
                $('#sendSmsModal').modal('hide');
                $("#send-sms-loading").addClass("d-none");
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
                $('#sendSmsModal').modal('hide');
            },
            //The status for when there is error php code
            500: function (response) {
                $('#sendSmsModal').modal('hide');
                toastr["error"]("خطای برنامه!", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
                $('#sendSmsModal').modal('hide');
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
            },

            //The status for Unavailable For Legal Reasons
            451: function (response) {
                $('#sendSmsModal').modal('hide');
                toastr["error"]("کاربری انتخاب نشده است!", "پیام سیستم");
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


/**
 * transaction Admin Ajax
 */
var transactionAjax;
$(document).on("click", "#transaction-portlet .reload", function (){
    var formData = $("#filterTransactionForm").serialize();

    $("#transaction-portlet-loading").removeClass("d-none");

    $('#transaction_table > tbody').html("");

    if($("#transactionTableColumnFilter").val() !== null) {
        var columns = $("#transactionTableColumnFilter").val();
        $("#transaction_table thead tr th").each(function() {
            if(columns.includes($(this).text().trim())){
                $(this).removeClass().addClass("all");
            }
            else if($(this).text() !== "") {
                $(this).removeClass().addClass("none");
            }
        });
    }
    else {
        $("#transaction_table thead tr th").each(function() {
            $(this).removeClass().addClass("none");
        });
    }

    if(transactionAjax) {
        transactionAjax.abort();
    }

    transactionAjax = $.ajax({
        type: "GET",
        data: formData,
        url: "/transaction",
        success: function (result) {
            result = $.parseJSON(result);
            $("#totalCost").text(result.totalCost);
            $("#totalFilteredCost").text(result.orderproductTotalCost);
            $("#totalFilteredExtraCost").text(result.orderproductTotalExtraCost);
            var newDataTable =$("#transaction_table").DataTable();
            newDataTable.destroy();
            $('#transaction_table > tbody').html(result.index);
            if(result.index === null || result.index === "" ) {
                $('#transaction_table > thead > tr').children('th:first').removeClass().addClass("none");
            }
            else{
                $('#transaction_table > thead > tr').children('th:first').removeClass("none");
            }
            makeDataTable("transaction_table");
            $("#transaction-portlet-loading").addClass("d-none");
            $(".filter").each(function () {
                if($(this).val() !== "" && $(this).val() !== null) {
                    $(this).addClass("font-red");
                }
            });
        },
        error: function (result) {
        }
    });

    return false;
});

/**
 * UserBon Admin Ajax
 */
$(document).on("click", ".deleteUserBon", function (){
    var userbon_id = $(this).closest('ul').attr('id');
    $("input[name=userbon_id]").val(userbon_id);
    $("#deleteUserBonFullName").text($("#userBonFullName_"+userbon_id).text());
});
function removeUserBon(){
    var userbon_id = $("input[name=userbon_id]").val();
    $.ajax({
        type: 'POST',
        url: 'userbon/'+userbon_id,
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
            toastr["success"]("بن کاربر با موفقیت حذف شد!", "پیام سیستم");
            $("#userBon-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
// $(document).on("click", "#roleForm-submit", function (){
//     $('body').modalmanager('loading');
//     var el = $(this);
//
//     //initializing form alerts
//     $("#roleName").parent().removeClass("has-error");
//     $("#roleNameAlert > strong").html("");
//
//     $("#roleDisplayName").parent().removeClass("has-error");
//     $("#roleDisplayNameAlert > strong").html("");
//
//     $("#roleDescription").parent().removeClass("has-error");
//     $("#roleDescriptionAlert > strong").html("");
//
//     $("#role_permission").parent().removeClass("has-error");
//     $("#PermissionAlert > strong").html("");
//
//     var formData = new FormData($("#roleForm")[0]);
//
//     $.ajax({
//         type: "POST",
//         url: $("#roleForm").attr("action"),
//         data: formData,
//         statusCode: {
//             //The status for when action was successful
//             200: function (response) {
//                 $("#roleForm-close").trigger("click");
//                 toastr.options = {
//                     "closeButton": true,
//                     "debug": false,
//                     "positionClass": "toast-top-center",
//                     "onclick": null,
//                     "showDuration": "1000",
//                     "hideDuration": "1000",
//                     "timeOut": "5000",
//                     "extendedTimeOut": "1000",
//                     "showEasing": "swing",
//                     "hideEasing": "linear",
//                     "showMethod": "fadeIn",
//                     "hideMethod": "fadeOut"
//                 };
//                 $("#role-portlet .reload").trigger("click");
//                 $('#roleForm')[0].reset();
//                 $('#role_permission').multiSelect('refresh');
//                 toastr["success"]("درج نقش با موفقیت انجام شد!", "پیام سیستم");
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
//                     switch (index) {
//                         case "name":
//                             $("#roleName").parent().addClass("has-error");
//                             $("#roleNameAlert > strong").html(value);
//                             break;
//                         case "display_name":
//                             $("#roleDisplayName").parent().addClass("has-error");
//                             $("#roleDisplayNameAlert > strong").html(value);
//                             break;
//                         case "description":
//                             $("#roleDescription").parent().addClass("has-error");
//                             $("#roleDescriptionAlert > strong").html(value);
//                             break;
//                         case "permissions[]":
//                             $("#role_permission").parent().addClass( "has-error");
//                             $("#permissionAlert > strong").html(value);
//                             break;
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
//     $modal.modal().hide();
//     $modal.modal('toggle');
// });
var userBonAjax;
$(document).on("click", "#userBon-portlet .reload", function (){
    var formData = $("#filterUserBonForm").serialize();

    $("#userBon-portlet-loading").removeClass("d-none");

    $('#userBon_table > tbody').html("");

    if($("#userBonTableColumnFilter").val() !== null) {
        var columns = $("#userBonTableColumnFilter").val();
        $("#userBon_table thead tr th").each(function() {
            if(columns.includes($(this).text().trim())){
                $(this).removeClass().addClass("all");
            }
            else if($(this).text() !== "") {
                $(this).removeClass().addClass("none");
            }
        });
    }
    else {
        $("#userBon_table thead tr th").each(function() {
            $(this).removeClass().addClass("none");
        });
    }

    if(userBonAjax) {
        userBonAjax.abort();
    }

    userBonAjax = $.ajax({
        type: "GET",
        data: formData,
        url: "/userbon",
        success: function (result) {
            var newDataTable =$("#userBon_table").DataTable();
            newDataTable.destroy();
            $('#userBon_table > tbody').html(result);
            if(result === null || result === "" ) {
                $('#userBon_table > thead > tr').children('th:first').removeClass().addClass("none");
            }
            else{
                $('#userBon_table > thead > tr').children('th:first').removeClass("none");
            }
            makeDataTable("userBon_table");
            $("#userBon-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});

$('#orderCreatedTimeEnable').click(function () {
    if($('#orderCreatedTimeEnable').prop('checked') == true) {
        $('#orderCreatedSince').attr('disabled' ,false);
        $('#orderCreatedTill').attr('disabled' ,false);
    }
    else {
        $('#orderCreatedSince').attr('disabled' ,true);
        $('#orderCreatedTill').attr('disabled' ,true);
    }
});
$('#transactionCreatedTimeEnable').click(function () {
    if($('#transactionCreatedTimeEnable').prop('checked') == true) {
        $('#transactionCreatedSince').attr('disabled' ,false);
        $('#transactionCreatedTill').attr('disabled' ,false);
    }
    else {
        $('#transactionCreatedSince').attr('disabled' ,true);
        $('#transactionCreatedTill').attr('disabled' ,true);
    }
});
$('#userBonCreatedTimeEnable').click(function () {
    if($('#userBonCreatedTimeEnable').prop('checked') == true) {
        $('#userBonCreatedSince').attr('disabled' ,false);
        $('#userBonCreatedTill').attr('disabled' ,false);
    }
    else {
        $('#userBonCreatedSince').attr('disabled' ,true);
        $('#userBonCreatedTill').attr('disabled' ,true);
    }
});

$('#orderUpdatedTimeEnable').click(function () {
    if($('#orderUpdatedTimeEnable').prop('checked') == true) {
        $('#orderUpdatedSince').attr('disabled' ,false);
        $('#orderUpdatedTill').attr('disabled' ,false);
    }
    else {
        $('#orderUpdatedSince').attr('disabled' ,true);
        $('#orderUpdatedTill').attr('disabled' ,true);
    }
});
$('#orderCompletedTimeEnable').click(function () {
    if($('#orderCompletedTimeEnable').prop('checked') == true) {
        $('#orderCompletedSince').attr('disabled' ,false);
        $('#orderCompletedTill').attr('disabled' ,false);
    }
    else {
        $('#orderCompletedSince').attr('disabled' ,true);
        $('#orderCompletedTill').attr('disabled' ,true);
    }
});

$('#transactionDeadlineTimeEnable').click(function () {
    if($('#transactionDeadlineTimeEnable').prop('checked') == true) {
        $('#transactionDeadlineSinceDate').attr('disabled' ,false);
        $('#transactionDeadlineTillDate').attr('disabled' ,false);
    }
    else {
        $('#transactionDeadlineSinceDate').attr('disabled' ,true);
        $('#transactionDeadlineTillDate').attr('disabled' ,true);
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

$('#transactionStatusEnable').click(function () {
    if($('#transactionStatusEnable').prop('checked') == true) {
        $('#transactionStatuses').prop('disabled' ,false);
        $("#transactionStatusesButton").prop('disabled' ,false);
        $("#transactionStatusesButton").removeClass('disabled');
    }
    else {
        $('#transactionStatuses').prop('disabled' ,true);
        $("#transactionStatusesButton").prop('disabled' ,true);
        $("#transactionStatusesButton").addClass('disabled');
    }
});

$('#checkoutStatusEnable').click(function () {
    if($('#checkoutStatusEnable').prop('checked') == true) {
        $('#checkoutStatuses').prop('disabled' ,false);
        $("#checkoutStatusesButton").prop('disabled' ,false);
        $("#checkoutStatusesButton").removeClass('disabled');
    }
    else {
        $('#checkoutStatuses').prop('disabled' ,true);
        $("#checkoutStatusesButton").prop('disabled' ,true);
        $("#checkoutStatusesButton").addClass('disabled');
    }
});

$('#transactionCheckoutStatusEnable').click(function () {
    if($('#transactionCheckoutStatusEnable').prop('checked') == true) {
        $('#transactionCheckoutStatus').prop('disabled' ,false);
        $("#transactionCheckoutStatusButton").prop('disabled' ,false);
        $("#transactionCheckoutStatusButton").removeClass('disabled');
    }
    else {
        $('#transactionCheckoutStatus').prop('disabled' ,true);
        $("#transactionCheckoutStatusButton").prop('disabled' ,true);
        $("#transactionCheckoutStatusButton").addClass('disabled');
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

// $('#withoutAddress').click(function () {
//     if($('#withoutAddress').prop('checked') == true) {
//         $('#addressFilter').attr('disabled' ,true);
//         $('#addressFilter').val(null);
//     }
//     else {
//         $('#addressFilter').attr('disabled' ,false);
//     }
// });

$('#addressSpecialFilter').click(function () {
    if($(this).val() == 1 || $(this).val() == 2) {
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

$('#withoutOrderCustomerDescription').click(function () {
    if($('#withoutOrderCustomerDescription').prop('checked') == true) {
        $('#orderCustomerDescriptionFilter').attr('disabled' ,true);
        $('#orderCustomerDescriptionFilter').val(null);
    }
    else {
        $('#orderCustomerDescriptionFilter').attr('disabled' ,false);
    }
});

$('#withoutOrderManagerComments').click(function () {
    if($('#withoutOrderManagerComments').prop('checked') == true) {
        $('#orderManagerComments').attr('disabled' ,true);
        $('#orderManagerComments').val(null);
    }
    else {
        $('#orderManagerComments').attr('disabled' ,false);
    }
});

$('#checkout-submit').click(function () {
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
        url: "orderproduct/checkout",
        data: {checkoutStatus:2 , orderproducts:myOrderproducts},
        // contentType: "application/json",
        // dataType: "json",
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                toastr["success"]("آیتم ها با موفقیت تسویه شدند!", "پیام سیستم");
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
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
            },

            //The status for Unavailable For Legal Reasons
            451: function (response) {
                toastr["error"]("کاربری انتخاب نشده است!", "پیام سیستم");
            }

        },
        // cache: false,
        // processData: false
    });
    $("#checkoutModal-close").trigger("click");
});

$(document).on('click', '.transactionToDonateButton', function(e){
    var loadingImage = "<img src = '/assets/extra/loading-arrow.gif' style='height: 20px;'>";
    var transctionId = $(this).data("role");
    url = $(this).data("action");
    var submitButton = $(this);
    var buttonCaption = submitButton.html();
    submitButton.html(loadingImage);
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
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $(".transactionSpecialButton_"+transctionId).remove();
                $("#transactionUser_"+transctionId).addClass("font-red");
                toastr["success"](response.message, "پیام سیستم");
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
                $(this).html(buttonCaption);
                toastr["error"]("خطای ۴۲۲ . خطای ورودی ها", "پیام سیستم");
            },
            //The status for when there is error php code
            500: function (response) {
            },
            //The status for when there is error php code
            503: function (response) {
                submitButton.html(buttonCaption);
                toastr["error"](response.message, "پیام سیستم");
            }
        },
        cache: false,
        // contentType: false,
        processData: false
    });

});

$(document).on('click', '.completeTransactionInfo', function(e){
    var url = $(this).data("action");
    var transactionId = $(this).data("role");
    $(".completeTransactionInfoForm").attr("action" , url);
    $("#completeTransactionInfoForm_transactionId").val(transactionId);
});

$(document).on('submit', '.completeTransactionInfoForm', function(e){
    e.preventDefault();
    $("#complete-transaction-info-loading").removeClass("d-none");
    var form = $(this);
    formData = form.serialize();
    var url = form.attr("action");
    var transctionId = $("#completeTransactionInfoForm_transactionId").val() ;
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
        data:formData ,
        statusCode: {
            200: function (response) {
                $(".transactionSpecialButton_"+transctionId).remove();
                $("#transactionUser_"+transctionId).addClass("font-red");
                toastr["success"](response.message, "پیام سیستم");
            },
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            422: function (response) {
                toastr["error"]("خطای 422 . خطای ورودی ها", "پیام سیستم");
            },
            500: function (response) {
                toastr["error"]("خطای 500", "پیام سیستم");
            },
            503: function (response) {
                var rasponseJson = $.parseJSON(response.responseText);
                toastr["error"](rasponseJson.message, "پیام سیستم");
            }
        },
        cache: false,
        processData: false
    });
    $('#completeTransactionInfo').modal('toggle');
    $("#complete-transaction-info-loading").addClass("d-none");
    $("#completeTransactionInfoTraceNumber").val('');
    $("#completeTransactionInfoCardNumber").val('');
});

//date picker jquery
$(document).ready(function () {
    /*
     registeredSince
     */
    $("#orderCreatedSince").persianDatepicker({
        altField: '#orderCreatedSinceAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    $("#transactionCreatedSince").persianDatepicker({
        altField: '#transactionCreatedSinceAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    $("#transactionDeadlineSinceDate").persianDatepicker({
        altField: '#transactionDeadlineSinceDateAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    $("#userBonCreatedSince").persianDatepicker({
        altField: '#userBonCreatedSinceAlt',
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
    $("#orderCreatedTill").persianDatepicker({
        altField: '#orderCreatedTillAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    $("#transactionCreatedTill").persianDatepicker({
        altField: '#transactionCreatedTillAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    $("#transactionDeadlineTillDate").persianDatepicker({
        altField: '#transactionDeadlineTillDateAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    $("#userBonCreatedTill").persianDatepicker({
        altField: '#userBonCreatedTillAlt',
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
    $("#orderUpdatedSince").persianDatepicker({
        altField: '#orderUpdatedSinceAlt',
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
    $("#orderUpdatedTill").persianDatepicker({
        altField: '#orderUpdatedTillAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    /*
     completedSince
     */
    $("#orderCompletedSince").persianDatepicker({
        altField: '#orderCompletedSinceAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    /*
     completedTill
     */
    $("#orderCompletedTill").persianDatepicker({
        altField: '#orderCompletedTillAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
});
