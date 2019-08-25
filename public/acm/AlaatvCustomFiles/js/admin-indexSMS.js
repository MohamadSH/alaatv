var user_id = [];
var fatherNumbers = 0;
var motherNumbers = 0;
// // Ajax of Modal forms
var $modal = $('#ajax-modal');

var userAjax;
$(document).on("click", "#filterButton", function (){
    $("#sms-portlet-loading").removeClass("d-none");
    $('#sms_table > tbody').html("");

    var formData = $("#filterUserForm").serialize();

    if(userAjax) {
        userAjax.abort();
    }

    userAjax = $.ajax({
        type: "GET",
        url: $("#filterUserForm").attr("action"),
        data: formData,
        statusCode: {
            200:function (response) {
                $("#allUsers").val(response.allUsers);
                $("#allUsersNumber").val(response.allUsersNumber);
                $("#numberOfFatherPhones").val(response.numberOfFatherPhones);
                $("#numberOfMotherPhones").val(response.numberOfMotherPhones);
                var newDataTable =$("#sms_table").DataTable();
                newDataTable.destroy();
                $('#sms_table > tbody').html(response.index);
                if (mUtil.isAngularVersion() === false) {
                    TableDatatablesManaged.init();
                }
                if(response === null || response === "" ) {
                    $('#sms_table > thead > tr').children('th:first').removeClass().addClass("none");
                }
                else{
                    $('#sms_table > thead > tr').children('th:first').removeClass("none");
                }
                makeDataTable("user_table");
                $("#sms-portlet-loading").addClass("d-none");
                $(".filter").each(function () {
                    if($(this).val() !== "" && $(this).val() !== null) {
                        $(this).addClass("font-red");
                    }
                });
            },
            401:function (ressponse) {
                location.reload();
            },
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
            },
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
            }
        }
    });

    return false;
});

$(document).on("change", ".checkboxes", function () {

        if ($(this).prop("checked") == true) {
            var id = $(this).closest('tr').attr('id');
            user_id.push(id);

            if($('#fatherNumbers'+id).val()){
                fatherNumbers += parseInt($('#fatherNumbers'+id).val());
            }
            if($('#matherNumbers'+id).val()){
                motherNumbers += parseInt($('#matherNumbers'+id).val());
            }
        }
        else if ($(this).prop("checked") == false){
            var id = ($(this).closest('tr').attr('id'));
            user_id.splice( $.inArray(id, user_id), 1 );

            if($('#fatherNumbers'+id).val()){
                fatherNumbers -= parseInt($('#fatherNumbers'+id).val());
            }
            if($('#matherNumbers'+id).val()){
                motherNumbers -= parseInt($('#matherNumbers'+id).val());
            }
        }
});

$(document).on("click", ".sendSMS", function () {
    smsStatus = $(this).attr('id');
    $("#smsHeaderText").text($(this).text());
});

$(document).on("click", "#sendSmsForm-submit", function (){
    mApp.block('#smsConformation', {
        type: "loader",
        state: "success",
    });
    $("#send-sms-loading").removeClass("d-none");

    //initializing form alerts
    $("#smsMessage").parent().removeClass("has-error");
    $("#smsMessageAlert > strong").html("");

    var formData = new FormData($("#sendSmsForm")[0]);
    formData.append('relatives', $('#relatives').val());
    formData.append('smsProviderNumber', $('#smsProviderNumber').val());
    if($('#smsStatus').val() == "selected"){formData.append('users', user_id);}
    else if($('#smsStatus').val() == "all"){
        var id = $('#allUsers').val();
        formData.append('users', id.substring(1, id.length-1));
    }

    $.ajax({
        type: "POST",
        url: $("#sendSmsForm").attr("action"),
        data: formData,
        statusCode: {
            200: function (response) {
                $("#send-sms-loading").addClass("d-none");
                $("#smsConformation").modal("hide");
                mApp.unblock('#smsConformation');
                var smsCredit = JSON.parse(parseInt(response));
                if(smsCredit == false){
                    $("#smsCredit").text("خطا در دریافت اطلاعات");
                    $("#smsCreditNumber_1").text("خطا در دریافت اطلاعات");
                    $("#smsCreditNumber_2").text("خطا در دریافت اطلاعات");
                    $("#smsCreditNumber_3").text("خطا در دریافت اطلاعات");
                }
                else
                {
                    $("#smsCredit").text(smsCredit).number(true);
                    $("#smsCreditNumber_1").text(Math.floor(smsCredit / $("#smsCost_1").val())).number(true);
                    $("#smsCreditNumber_2").text(Math.floor(smsCredit / $("#smsCost_2").val())).number(true);
                    $("#smsCreditNumber_3").text(Math.floor(smsCredit / $("#smsCost_3").val())).number(true);
                }

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
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
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
                $("#smsConformation").modal("hide");
                mApp.unblock('#smsConformation');
            },
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
                $("#smsConformation").modal("hide");
                mApp.unblock('#smsConformation');
            },
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                $("#smsConformation").modal("hide");
                mApp.unblock('#smsConformation');
            },
            451: function (response) {
                toastr["error"]("کاربری انتخاب نشده است!", "پیام سیستم");
                $("#smsConformation").modal("hide");
                mApp.unblock('#smsConformation');
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });

});

$(document).ready(function () {
    $('#smsMessage').keyup(function() {
        $('#smsWords').text(70 - ($('#smsMessage').val().length%71));
        $('#smsNumber').text(Math.floor(($('#smsMessage').val().length)/71)+1);
    });
});

// function getUserNumbers(str){
//     if(str.length <= 0) return 0;
//     else {
//         var numbers = 1;
//         for (var i = 0; i < str.length ; i++) {
//             if (str.charAt(i) == ',') numbers++;
//         }
//         return numbers;
//     }
// }

// function relativeSelected(id){
//     for(var i = 0; i < $('#relatives').val().length; i++){
//         if(id = $('#relatives').val()[i]) return true;
//     }
//     return false;
// }

$(document).on("click", ".filter" , function () {
    if($(this).has("font-red")){
        $(this).removeClass("font-red");
    }
});

$(document).on("click", "#sendSmsButton", function (){
    var smsNumbers = Math.floor(($('#smsMessage').val().length)/71)+1;
    var userNumbers = 0;

    var smsCost = $("#smsProviderCost").val($("#smsProviderNumber").val()).find("option:selected").text();
    smsCost = parseInt(smsCost);

    if($('#smsStatus').val() == "selected"){
        if(($.inArray("0", $('#relatives').val()) >= 0)){
            userNumbers += user_id.length;
        }
        if(($.inArray("1", $('#relatives').val()) >= 0)){
            userNumbers += fatherNumbers;
        }
        if(($.inArray("2", $('#relatives').val()) >= 0)){
            userNumbers += motherNumbers;
        }
    }
    else if($('#smsStatus').val() == "all"){
        // userNumbers = $('#allUsers').val().replace(/\D/g,"").length;
        // var id = $('#allUsers').val();
        // userNumbers = getUserNumbers(id.substring(1, id.length-1));
        if(($.inArray("0", $('#relatives').val()) >= 0)) {
            userNumbers += parseInt($('#allUsersNumber').val());
        }
        if(($.inArray("1", $('#relatives').val()) >= 0)){
            userNumbers += parseInt($('#numberOfFatherPhones').val());
        }
        if(($.inArray("2", $('#relatives').val()) >= 0)){
            userNumbers += parseInt($('#numberOfMotherPhones').val());
        }
    }
    $('#perSmsCost').text(smsCost);
    $('#userGetSms').text(userNumbers);
    $('#totalSmsCost').text(userNumbers*smsNumbers*smsCost);
    $('#showSmsNumber').text(smsNumbers);
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

$('#CreatedBasketEnable').click(function () {
    if($('#CreatedBasketEnable').prop('checked') == true) {
        $('#CreatedBasketSince').attr('disabled' ,false);
        $('#CreatedBasketTill').attr('disabled' ,false);
    }
    else {
        $('#CreatedBasketSince').attr('disabled' ,true);
        $('#CreatedBasketTill').attr('disabled' ,true);
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
    /*
     CreatedBasketSince
     */
    $("#CreatedBasketSince").persianDatepicker({
        altField: '#CreatedBasketSinceAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
    /*
     CreatedBasketTill
     */
    $("#CreatedBasketTill").persianDatepicker({
        altField: '#CreatedBasketTillAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
});