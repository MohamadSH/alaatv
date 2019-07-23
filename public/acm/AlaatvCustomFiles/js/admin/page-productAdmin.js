// ------------------------------------- page ------------------------------------- //

/**
 * Start up jquery
 */
function showLongDescription(LongDescriptionId) {
    let txtLongDescription = $('#txtLongDescription-'+LongDescriptionId).html();
    $('#static-longDescription .modal-body').html(txtLongDescription);
    $('#static-longDescription').modal('show');
}
function showCopyProductModal(productId, productName) {
    $('#productIdForCopy').val(productId);
    $('#copyProductModalModalLabel').html(productName);
    $('#copyProductModal').modal('show');
}

jQuery(document).ready(function () {

    $(document).on('click', '.imgShowProductPhoto', function () {
        let src = $(this).attr('src');
        let alt = $(this).attr('src');
        let name = $(this).data('product-name');
        $('#showProductPhotoInModalLabel').html(name);
        $('#showProductPhotoInModal .modal-body img').attr('src', src);
        $('#showProductPhotoInModal .modal-body img').attr('alt', alt);
        $('#showProductPhotoInModal').modal('show');
    });

    $(document).on('click', '.btnDeleteOrder', function (e) {
        e.preventDefault();
        let removeLink = $(this).attr('remove-link');
        let name = $(this).data('product-name');

        $('#removeProductModalLabel').html(name);
        $('#product-removeLink').val(removeLink);
        $('#removeProductModal').modal('show');
    });
    /*
     validdSince
     */
    $("#couponValidSince").persianDatepicker({
        altField: '#couponValidSinceAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function (unixDate) {
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });

    /*
     validUntil
     */
    $("#couponValidUntil").persianDatepicker({
        altField: '#couponValidUntilAlt',
        altFormat: "YYYY MM DD",
        observer: true,
        format: 'YYYY/MM/DD',
        altFieldFormatter: function (unixDate) {
            var d = new Date(unixDate).toISOString();
            return d;
        }
    });
});


// Ajax of Modal forms
var $modal = $('#ajax-modal');


/**
 * Product Admin Ajax
 */
function removeProduct(){
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
    $('#remove-product-loading-image').removeClass('d-none');
    $.ajax({
        type: 'POST',
        url: $('#product-removeLink').val(),
        data:{_method: 'delete'},
        success: function (result) {
            toastr["success"]("محصول با موفقیت حذف شد!", "پیام سیستم");
            $('#remove-product-loading-image').addClass('d-none');
            $("#product-portlet .reload").trigger("click");
            $('#removeProductModal').modal('hide');
        },
        error: function (result) {
            $('#remove-product-loading-image').addClass('d-none');
            $('#removeProductModal').modal('hide');
        }
    });
}
$(document).on("click", "#productForm-submit", function (){

    mApp.block('#productForm-submit', {
        type: "loader",
        state: "info",
    });
    var el = $(this);

    //initializing form alerts
    $("#productName").parent().removeClass("has-error");
    $("#productNameAlert > strong").html("");
    $("#productBasePrice").parent().removeClass("has-error");
    $("#productBasePriceAlert > strong").html("");
    $("#productDiscount").parent().removeClass("has-error");
    $("#productDiscountAlert > strong").html("");
    $("#productEnable").parent().removeClass("has-error");
    $("#productEnableAlert > strong").html("");
    $("#productAmount").parent().removeClass("has-error");
    $("#productAmountAlert > strong").html("");
    $("#productAttributesetID").parent().removeClass("has-error");
    $("#productAttributesetIDAlert > strong").html("");
    $("#productSlogan").parent().removeClass("has-error");
    $("#productSloganAlert > strong").html("");
    $("#productBonPlus").parent().removeClass("has-error");
    $("#productBonPlusAlert > strong").html("");
    $("#productBonDiscount").parent().removeClass("has-error");
    $("#productBonDiscountAlert > strong").html("");
    $("#productFile").parent().removeClass("has-error");
    $("#productFileAlert > strong").html("");
    $("#image-div").parent().removeClass("has-error");
    $("#productimageAlert > strong").html("");
    $("#productShortDescriptionSummerNote").parent().removeClass("has-error");
    $("#productShortDescriptionSummerNoteAlert > strong").html("");
    $("#productLongDescriptionSummerNote").parent().removeClass("has-error");
    $("#productLongDescriptionSummerNoteAlert > strong").html("");
    $("#productIntroVideo").parent().removeClass("has-error");
    $("#productIntroVideoAlert > strong").html("");
    $("#producttypeId").parent().removeClass("has-error");
    $("#producttypeIdAlert > strong").html("");
    $("#productOrder").parent().removeClass("has-error");
    $("#productOrderAlert > strong").html("");


    var formData = new FormData($("#productForm")[0]);
    formData.append("shortDescription", $("#productShortDescriptionSummerNote").summernote('code'));
    formData.append("longDescription", $("#productLongDescriptionSummerNote").summernote('code'));

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
        url: $("#productForm").attr("action"),
        data: formData,
        statusCode: {
            200: function (response) {
                toastr["success"]("درج محصول با موفقیت انجام شد!", "پیام سیستم");
                $("#productForm-close").trigger("click");
                $("#product-portlet .reload").trigger("click");
                $("#productFile-remove").trigger("click");
                $("#productImage-remove").trigger("click");
                $("#productShortDescriptionSummerNote").summernote('reset');
                $("#productLongDescriptionSummerNote").summernote('reset');
                $('#productForm')[0].reset();
                mApp.unblock('#productForm-submit');
                $('#responsive-product').modal('hide');
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
                            $("#productName").parent().addClass("has-error");
                            $("#productNameAlert > strong").html(value);
                            break;
                        case "basePrice":
                            $("#productBasePrice").parent().addClass("has-error");
                            $("#productBasePriceAlert > strong").html(value);
                            break;
                        case "discount":
                            $("#productDiscount").parent().addClass("has-error");
                            $("#productDiscountAlert > strong").html(value);
                            break;
                        case "enable":
                            $("#productEnable").parent().addClass("has-error");
                            $("#productEnableAlert > strong").html(value);
                            break;
                        case "amount":
                            $("#productAmount").parent().addClass("has-error");
                            $("#productAmountAlert > strong").html(value);
                            break;
                        case "attributeset_id":
                            $("#productAttributeSetID").parent().addClass("has-error");
                            $("#productAttributeSetIDAlert > strong").html(value);
                            break;
                        case "slogan":
                            $("#productSlogan").parent().addClass("has-error");
                            $("#productSloganAlert > strong").html(value);
                            break;
                        case "bonPlus":
                            $("#productBonPlus").parent().addClass("has-error");
                            $("#productBonPlusAlert > strong").html(value);
                            break;
                        case "bonDiscount":
                            $("#productBonDiscount").parent().addClass("has-error");
                            $("#productBonDiscountAlert > strong").html(value);
                            break;
                        case "file":
                            $("#productFile-div").addClass("has-error");
                            $("#productFileAlert").addClass("font-red");
                        case "image":
                            $("#image-div").addClass("has-error");
                            $("#productImageAlert > strong").html(value);
                            break;
                        case "introVideo":
                            $("#productIntroVideo").parent().addClass("has-error");
                            $("#productIntroVideoAlert > strong").html(value);
                            break;
                        case "producttype_id":
                            $("#producttypeId").parent().addClass("has-error");
                            $("#producttypeIdAlert > strong").html(value);
                            break;
                        case "isFree":
                            $("#productOrder").parent().addClass("has-error");
                            $("#productOrderAlert > strong").html(value);
                            break;

                    }
                });
                toastr["error"]("خطای کاربر!", "اطلاعات وارد شده صحیح نیست.");
                mApp.unblock('#productForm-submit');
                $('#responsive-product').modal('hide');
            },
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
                mApp.unblock('#productForm-submit');
                $('#responsive-product').modal('hide');
            },
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                mApp.unblock('#productForm-submit');
                $('#responsive-product').modal('hide');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
$(document).on("click", "#product-portlet .reload", function (){
    $("#product-portlet-loading").removeClass("d-none");
    $('#product_table > tbody').html("");
    // $.ajax({
    //     type: "GET",
    //     url: "/product",
    //     // success: function (result) {
    //         // var newDataTable =$("#product_table").DataTable();
    //         // newDataTable.destroy();
    //         // $('#product_table > tbody').html(result);
    //         // makeDataTable("product_table");
    //         // $("#product-portlet-loading").addClass("d-none");
    //     // },
    //     // error: function (result) {
    //     // }
    //     statusCode: {
    //         200:function (response) {
    //             var newDataTable =$("#product_table").DataTable();
    //             newDataTable.destroy();
    //             $('#product_table > tbody').html(response);
    //             makeDataTable("product_table");
    //             $("#product-portlet-loading").addClass("d-none");
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
    makeDataTable_loadWithAjax_products();
    return false;
});

function copyProductInModal() {
    let productId = $('#productIdForCopy').val();
    let url = 'product/'+productId+'/copy';

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
    $("#copy-product-loading-image").removeClass("d-none");
    $.ajax({
        type: 'POST',
        url: url,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $('#copyProductModal').modal('toggle');
                $("#copy-product-loading-image").addClass("d-none");
                $("#product-portlet .reload").trigger("click");
                // var rasponseJson = $.parseJSON(response.responseText);
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
                $('#copyProductModal').modal('toggle');
                $("#copy-product-loading-image").addClass("d-none");
                toastr["error"]("خطای 422 . خطای ورودی ها", "پیام سیستم");
            },
            //The status for when there is error php code
            500: function (response) {
                $('#copyProductModal').modal('toggle');
                $("#copy-product-loading-image").addClass("d-none");
                toastr["error"]("خطای 500", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
                $('#copyProductModal').modal('toggle');
                $("#copy-product-loading-image").addClass("d-none");
                var rasponseJson = $.parseJSON(response.responseText);
                toastr["error"](rasponseJson.message, "پیام سیستم");
            }
        },
        cache: false,
        // contentType: false,
        processData: false
    });
}


/**
 * Coupon Admin Ajax
 */
function removeCoupon(url){
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
        success: function (result) {

            toastr["success"]("کپن با موفقیت حذف شد!", "پیام سیستم");
            $("#coupon-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
$(document).on("click", "#couponForm-submit", function (){

    mApp.block('#couponForm-submit', {
        type: "loader",
        state: "info",
    });

    var el = $(this);

    //initializing form alerts
    $("#couponName").parent().removeClass("has-error");
    $("#couponNameAlert > strong").html("");

    $("#couponCode").parent().removeClass("has-error");
    $("#couponCodeNameAlert > strong").html("");

    $("#couponDescription").parent().removeClass("has-error");
    $("#couponDescriptionAlert > strong").html("");

    $("#couponDiscount").parent().removeClass("has-error");
    $("#couponDiscountAlert > strong").html("");

    $("#couponUsageLimit").parent().removeClass("has-error");
    $("#couponUsageLimitAlert > strong").html("");

    $("#coupontypeId").parent().removeClass("has-error");
    $("#coupontypeIdAlert > strong").html("");

    $("#coupon_product").parent().removeClass("has-error");
    $("#couponProductAlert > strong").html("");

    $("#couponValidSinceAlt").parent().removeClass("has-error");
    $("#couponValidSinceAltAlert > strong").html("");

    $("#couponValidUntilAlt").parent().removeClass("has-error");
    $("#couponValidUntilAltAlert > strong").html("");

    var formData = new FormData($("#couponForm")[0]);

    $.ajax({
        type: "POST",
        url: $("#couponForm").attr("action"),
        data: formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $("#couponForm-close").trigger("click");
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
                $("#coupon-portlet .reload").trigger("click");
                $('#couponForm')[0].reset();
                toastr["success"]("درج کپن با موفقیت انجام شد!", "پیام سیستم");
                mApp.unblock('#couponForm-submit');
                $('#responsive-coupon').modal('hide');
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
                            $("#couponName").parent().addClass("has-error");
                            $("#couponNameAlert > strong").html(value);
                            break;
                        case "code":
                            $("#couponCode").parent().addClass("has-error");
                            $("#couponCodeAlert > strong").html(value);
                            break;
                        case "description":
                            $("#couponDescription").parent().addClass("has-error");
                            $("#couponDescriptionAlert > strong").html(value);
                            break;
                        case "discount":
                            $("#couponDiscount").parent().addClass("has-error");
                            $("#couponDiscountAlert > strong").html(value);
                            break;
                        case "usageLimit":
                            $("#couponUsageLimit").parent().addClass("has-error");
                            $("#couponUsageLimitAlert > strong").html(value);
                            break;
                        case "coupontype_id":
                            $("#coupontypeId").parent().addClass("has-error");
                            $("#coupontypeIdAlert > strong").html(value);
                            break;
                        case "products":
                            $("#coupon_product").parent().addClass("has-error");
                            $("#couponProductAlert > strong").html(value);
                            break;
                        case "validSince":
                            $("#couponValidSinceAlt").parent().addClass("has-error");
                            $("#couponValidSinceAltAlert > strong").html(value);
                            break;
                        case "validUntil":
                            $("#couponValidUntilAlt").parent().addClass("has-error");
                            $("#couponValidUntilAltAlert > strong").html(value);
                            break;
                    }
                });
                mApp.unblock('#couponForm-submit');
                $('#responsive-coupon').modal('hide');
            },
            //The status for when there is error php code
            500: function (response) {
                toastr["error"]("خطای برنامه!", "پیام سیستم");
                mApp.unblock('#couponForm-submit');
                $('#responsive-coupon').modal('hide');
            },
            //The status for when there is error php code
            503: function (response) {
                toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                mApp.unblock('#couponForm-submit');
                $('#responsive-coupon').modal('hide');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
$(document).on("click", "#coupon-portlet .reload", function (){
    $("#coupon-portlet-loading").removeClass("d-none");
    $('#coupon_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/coupon",
        success: function (result) {
            var newDataTable =$("#coupon_table").DataTable();
            newDataTable.destroy();
            $('#coupon_table > tbody').html(result);
            makeDataTable("coupon_table");
            $("#coupon-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });

    return false;
});


/**
 * Attribute Admin Ajax
 */
function removeAttributes(url){
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
        success: function (result) {
            toastr["success"]("صفت با موفقیت حذف شد!", "پیام سیستم");
            $("#attribute-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
$(document).on("click", "#attributeForm-submit", function (){
    $('body').modalmanager('loading');
    var el = $(this);

    //initializing form alerts
    $("#attributeName").parent().removeClass("has-error");
    $("#attributeNameAlert > strong").html("");

    $("#attributeDisplayName").parent().removeClass("has-error");
    $("#attributeDisplayNameAlert > strong").html("");

    $("#attributeDescription").parent().removeClass("has-error");
    $("#attributeDescriptionAlert > strong").html("");

    $("#attributeControlID").parent().removeClass("has-error");
    $("#attributeControlIDAlert > strong").html("");

    var formData = new FormData($("#attributeForm")[0]);

    $.ajax({
        type: "POST",
        url: $("#attributeForm").attr("action"),
        data: formData,
        statusCode: {
            200: function (response) {
                $("#attributeForm-close").trigger("click");
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
                $("#attribute-portlet .reload").trigger("click");
                $('#attributeForm')[0].reset();
                toastr["success"]("درج صفت با موفقیت انجام شد!", "پیام سیستم");
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
                            $("#attributeName").parent().addClass("has-error");
                            $("#attributeNameAlert > strong").html(value);
                            break;
                        case "displayName":
                            $("#attributeDisplayName").parent().addClass("has-error");
                            $("#attributeDisplayNameAlert > strong").html(value);
                            break;
                        case "description":
                            $("#attributeDescription").parent().addClass("has-error");
                            $("#attributeDescriptionAlert > strong").html(value);
                            break;
                        case "attributecontrol_id":
                            $("#attributeControlID").parent().addClass("has-error");
                            $("#attributeControlIDAlert > strong").html(value);
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
$(document).on("click", "#attribute-portlet .reload", function (){
    $("#attribute-portlet-loading").removeClass("d-none");
    $('#attribute_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/attribute",
        success: function (result) {
            var newDataTable =$("#attribute_table").DataTable();
            newDataTable.destroy();
            $('#attribute_table > tbody').html(result);
            makeDataTable("attribute_table");
            $("#attribute-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });
    return false;
});

/**
 * attributeset Admin Ajax
 */
function removeAttributesets(url){
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
            $("#attributeset-portlet .reload").trigger("click");
        },
        error: function (result) {
        }
    });
}
$(document).on("click", "#attributesetForm-submit", function (){
    $('body').modalmanager('loading');
    var el = $(this);

    //initializing form alerts
    $("#attributesetName").parent().removeClass("has-error");
    $("#attributesetNameAlert > strong").html("");


    $("#attributesetDescription").parent().removeClass("has-error");
    $("#attributesetDescriptionAlert > strong").html("");

    var formData = new FormData($("#attributesetForm")[0]);

    $.ajax({
        type: "POST",
        url: $("#attributesetForm").attr("action"),
        data: formData,
        statusCode: {
            200: function (response) {
                $("#attributesetForm-close").trigger("click");
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
                $("#attributeset-portlet .reload").trigger("click");
                $('#attributesetForm')[0].reset();
                toastr["success"]("درج دسته صفت با موفقیت انجام شد!", "پیام سیستم");
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
                            $("#attributesetName").parent().addClass("has-error");
                            $("#attributesetNameAlert > strong").html(value);
                            break;

                        case "description":
                            $("#attributesetDescription").parent().addClass("has-error");
                            $("#attributesetDescriptionAlert > strong").html(value);
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
$(document).on("click", "#attributeset-portlet .reload", function (){
    $("#attributeset-portlet-loading").removeClass("d-none");
    $('#attributeset_table > tbody').html("");
    $.ajax({
        type: "GET",
        url: "/attributeset",
        success: function (result) {
            var newDataTable =$("#attributeset_table").DataTable();
            newDataTable.destroy();
            $('#attributeset_table > tbody').html(result);
            makeDataTable("attributeset_table");
            $("#attributeset-portlet-loading").addClass("d-none");
        },
        error: function (result) {
        }
    });
    return false;
});

$('#couponValidSinceEnable').change(function () {
    if($(this).prop('checked') === true) {
        $('#couponValidSince').attr('disabled' ,false);
        $('#couponValidSinceTime').attr('disabled' ,false);
    }
    else {
        $('#couponValidSince').attr('disabled' ,true);
        $('#couponValidSinceTime').attr('disabled' ,true);
    }
});

$('#couponValidUntilEnable').change(function () {
    if($(this).prop('checked') === true) {
        $('#couponValidUntil').attr('disabled' ,false);
        $('#couponValidUntilTime').attr('disabled' ,false);
    }
    else {
        $('#couponValidUntil').attr('disabled' ,true);
        $('#couponValidUntilTime').attr('disabled' ,true);
    }
});






// ------------------------------------- coupon ------------------------------------- //

/*
    use in Create and Edit Coupon Form
 */
$('#coupontypeId').change(function () {

    if ($('#coupontypeId').val() == 1) {
        $('#coupon_product').prop('disabled', true);
        $('#coupon_product').multiSelect('refresh');
    }
    else if ($('#coupontypeId').val() == 2) {
        $('#coupon_product').prop('disabled', false);
        $('#coupon_product').multiSelect('refresh');
    }
});

$('#limitStatus').change(function () {
    if($('#limitStatus').val() == 0){
        $('#usageLimit').attr('disabled', true);
        $('#usageLimit').val(null);
        $('#couponUsageLimit').attr('disabled', true);
        $('#couponUsageLimit').val(null);
    }
    else{
        $('#usageLimit').attr('disabled', false);
        $('#couponUsageLimit').attr('disabled', false);
    }
});

$(document).ready(function(){
    $('#coupon_product').multiSelect();


    if ($('#coupontypeId').val() == 1) {
        $('#coupon_product').prop('disabled', true);
        $('#coupon_product').multiSelect('refresh');
    }
    else if ($('#coupontypeId').val() == 2) {
        $('#coupon_product').prop('disabled', false);
        $('#coupon_product').multiSelect('refresh');
    }


    if($('#limitStatus').val() == 0){
        $('#usageLimit').attr('disabled', true);
        $('#couponUsageLimit').attr('disabled', true);
    }
    else{
        $('#usageLimit').attr('disabled', false);
        $('#couponUsageLimit').attr('disabled', false);
    }


});






// ------------------------------------- product ------------------------------------- //
/*
    use in Create and Edit Product Form
 */

$(document).ready(function(){
    if($('#amountLimit').val() == 0){
        $('#amount').attr('disabled', true);
        $('#productAmount').attr('disabled', true);
    }
    else{
        $('#amount').attr('disabled', false);
        $('#productAmount').attr('disabled', false);
    }
    $('#amountLimit').change(function () {
        if($('#amountLimit').val() == 0){
            $('#amount').attr('disabled', true);
            $('#amount').val(null);
            $('#productAmount').attr('disabled', true);
            $('#productAmount').val(null);
        }
        else{
            $('#amount').attr('disabled', false);
            $('#productAmount').attr('disabled', false);
        }
    });
});

/**
 * Product Complimentary
 */
function removeComplimentary(url){
    var productId = $("#productId").val();
    $.ajax({
        type: 'PUT',
        url: url,
        data: {productId: productId},
        success: function (result) {
            location.reload();
        },
        error: function (result) {
        }
    });
}

/**
 * Product Photo
 */
function removePhoto(url){
    var photoID = $(this).data("id") ;
    $.ajax({
        type: 'DELETE',
        url: url,
        data: {_method:"POST",productphoto: photoID},
        success: function (result) {
            location.reload();
        },
        error: function (result) {
        }
    });
}

/**
 *  Product Gift
 */
$(document).on("click", ".removeProductGift", function (e){
    $(".removeProductGiftForm input[name=giftId]").val($(this).data("role"));
});
$(document).on("submit", ".removeProductGiftForm", function (e){
    e.preventDefault();
    var url = $(this).attr("action");
    var formData = $(this).serialize();
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
    $("#remove-product-gift-loading-image").removeClass("d-none");
    $.ajax({
        type: 'DELETE',
        url: url,
        data:formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $('#removeProductGiftModal').modal('toggle');
                $("#remove-product-gift-loading-image").addClass("d-none");
                // var rasponseJson = $.parseJSON(response.responseText);
                toastr["success"](response.message, "پیام سیستم");
                window.location.reload();
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
                $('#removeProductGiftModal').modal('toggle');
                $("#remove-product-gift-loading-image").addClass("d-none");
                toastr["error"]("خطای 422 . خطای ورودی ها", "پیام سیستم");
            },
            //The status for when there is error php code
            500: function (response) {
                $('#removeProductGiftModal').modal('toggle');
                $("#remove-product-gift-loading-image").addClass("d-none");
                toastr["error"]("خطای 500", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
                $('#removeProductGiftModal').modal('toggle');
                $("#remove-product-gift-loading-image").addClass("d-none");
                var rasponseJson = $.parseJSON(response.responseText);
                toastr["error"](rasponseJson.message, "پیام سیستم");
            }
        },
        cache: false,
        // contentType: false,
        processData: false
    });
});