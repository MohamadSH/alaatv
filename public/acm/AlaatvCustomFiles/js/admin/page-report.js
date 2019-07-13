//should run at first
$("#report_table thead tr th").each(function () {
    if (!$(this).hasClass("none")) {
        thText = $(this).text().trim();
        $("#reportTableColumnFilter > option").each(function () {
            if ($(this).val() === thText) {
                $(this).prop("selected", true);
            }
        });
    }
});

// Ajax of Modal forms
var $modal = $('#ajax-modal');
var reportTable = '<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="report_table">\n' +
    '                        <thead>\n' +
    '                        <tr>\n' +
    '                            <th></th>\n' +
    '                            <th class="all"> نام خانوادگی </th>\n' +
    '                            <th class="all"> نام کوچک </th>\n' +
    '                            <th class="none"> رشته </th>\n' +
    '                            <th class="none"> کد ملی </th>\n' +
    '                            <th class="desktop"> موبایل </th>\n' +
    '                            <th class="none"> ایمیل </th>\n' +
    '                            <th class="none"> شهر </th>\n' +
    '                            <th class="none"> استان </th>\n' +
    '                            <th class="none">وضعیت شماره موبایل </th>\n' +
    '                            <th class="none"> کد پستی </th>\n' +
    '                            <th class="none"> آدرس </th>\n' +
    '                            <th class="none"> مدرسه </th>\n' +
    '                            <th class="none"> وضعیت </th>\n' +
    '                            <th class="none"> زمان ثبت نام </th>\n' +
    '                            <th class="none"> زمان اصلاح </th>\n' +
    '                            <th class="none"> تعداد بن </th>\n' +
    '                        </tr>\n' +
    '                        </thead>\n' +
    '                        <tbody>\n' +
    '                        </tbody>\n' +
    '                    </table>' ;
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
    completedSince
    */
    $("#bookCompletedSince").persianDatepicker({
        altField: '#bookCompletedSinceAlt',
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
    $("#bookCompletedTill").persianDatepicker({
        altField: '#bookCompletedTillAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function(unixDate){
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
});

/**
 * report Admin Ajax
 */
var reportAjax;
$(document).on("click", "#report-portlet .reload", function (){
    $("#report-portlet-loading").removeClass("d-none");
    $('#report_table > tbody').html("");

    var formData = $("#filterReportForm").serialize();

    $("#report_table_wrapper").remove();
    $("#report-portlet > .portlet-body").append(reportTable) ;

    if(reportAjax) {
        reportAjax.abort();
    }
    reportAjax = $.ajax({
        type: "GET",
        url: $("#filterReportForm").attr("action"),
        data: formData,
        contentType: "application/json",
        dataType: "json",
        statusCode: {
            200:function (response) {

                var selectedProducts = response.products;
                $(selectedProducts).map(function()
                {
                    $('#report_table thead th:last-child').after('<th class="all">'+this.name+'</th>');
                });

                var selectedLotteries = response.lotteries;
                $(selectedLotteries).map(function()
                {
                    $('#report_table thead th:last-child').after('<th class="all">قرعه کشی '+this.displayName+'</th>');
                });
                // console.log(selectedProducts) ;
                // if($("#orderProducts option:selected").length >0 && $('#orderProductEnable').prop('checked') == true){
                //     var allFlag = false ;
                //     $("#orderProducts option:selected").map(function()
                //     {
                //         if(this.value == 0){
                //             allFlag = true;
                //             return false;
                //         }
                //         $('#report_table thead th:last-child').after('<th class="all">'+this.text+'</th>');
                //     });
                //
                // }

                var responseJson = response;
                var newDataTable =$("#report_table").DataTable();
                newDataTable.destroy();

                $('#report_table > tbody').html(responseJson.index);
                if(response === null || response === "" ) {
                    $('#report_table > thead > tr').children('th:first').removeClass().addClass("none");
                }
                else{
                    $('#report_table > thead > tr').children('th:first').removeClass("none");
                }
                makeDataTable("report_table");
                $("#report-portlet-loading").addClass("d-none");
                $(".filter").each(function () {
                    if($(this).val() !== "" && $(this).val() !== null) {
                        $(this).addClass("font-red");
                    }
                });
            },
            //The status for when the report is not authorized for making the request
            401:function (ressponse) {
                location.reload();
            },
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            //The status for when form data is not valid
            422: function (response) {
                //
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
        }
    });

    return false;
});
$(document).on("click", ".filter" , function () {
    if($(this).has("font-red")){
        $(this).removeClass("font-red");
    }
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

$('#bookCompletedTimeEnable').click(function () {
    if($('#bookCompletedTimeEnable').prop('checked') == true) {
        $('#bookCompletedSince').attr('disabled' ,false);
        $('#bookCompletedTill').attr('disabled' ,false);
    }
    else {
        $('#bookCompletedSince').attr('disabled' ,true);
        $('#bookCompletedTill').attr('disabled' ,true);
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

$('#bookProductEnable').click(function () {
    if($('#bookProductEnable').prop('checked') == true) {
        $('#bookProducts').prop('disabled' ,false);
        $("#bookProductsButton").prop('disabled' ,false);
        $("#bookProductsButton").removeClass('disabled');
    }
    else {
        $('#bookProducts').prop('disabled' ,true);
        $("#bookProductsButton").prop('disabled' ,true);
        $("#bookProductsButton").addClass('disabled');
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

$('#userReportLotteryCheckbox').click(function () {
    if($('#userReportLotteryCheckbox').prop('checked') == true) {
        $('#userReportLottery').attr('disabled' ,false);
    }
    else {
        $('#userReportLottery').attr('disabled' ,true);
    }
});


/**
 * report Admin Ajax
 */
var bookSellingReportAjax;
$(document).on("click", "#bookSellingReport-portlet .reload", function (){
    $("#bookSellingReport-portlet-loading").removeClass("d-none");
    $('#report_div > tbody').html("");

    var formData = $("#filterBookSellingReportForm").serialize();

    if(bookSellingReportAjax) {
        bookSellingReportAjax.abort();
    }
    bookSellingReportAjax = $.ajax({
        type: "GET",
        url: $("#filterBookSellingReportForm").attr("action"),
        data: formData,
        contentType: "application/json",
        dataType: "json",
        statusCode: {
            200:function (response) {

                $('#report_div').html(response.index);

                $("#bookSellingReport-portlet-loading").addClass("d-none");
                $(".filter").each(function () {
                    if($(this).val() !== "" && $(this).val() !== null) {
                        $(this).addClass("font-red");
                    }
                });
            },
            //The status for when the report is not authorized for making the request
            401:function (ressponse) {
                location.reload();
            },
            403: function (response) {
                window.location.replace("/403");
            },
            404: function (response) {
                window.location.replace("/404");
            },
            //The status for when form data is not valid
            422: function (response) {
                //
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
        }
    });

    return false;
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