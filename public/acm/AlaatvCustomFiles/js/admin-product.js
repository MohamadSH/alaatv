/*
    use in Create and Edit Product Form
 */
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
            // console.log(result);
            // console.log(result.responseText);
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
            console.log(result);
            location.reload();
        },
        error: function (result) {
            // console.log(result);
            // console.log(result.responseText);
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
    $("#remove-product-gift-loading-image").removeClass("hidden");
    $.ajax({
        type: 'DELETE',
        url: url,
        data:formData,
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                $('#removeProductGiftModal').modal('toggle');
                $("#remove-product-gift-loading-image").addClass("hidden");
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
                $("#remove-product-gift-loading-image").addClass("hidden");
                toastr["error"]("خطای 422 . خطای ورودی ها", "پیام سیستم");
            },
            //The status for when there is error php code
            500: function (response) {
                $('#removeProductGiftModal').modal('toggle');
                $("#remove-product-gift-loading-image").addClass("hidden");
                toastr["error"]("خطای 500", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
                $('#removeProductGiftModal').modal('toggle');
                $("#remove-product-gift-loading-image").addClass("hidden");
                var rasponseJson = $.parseJSON(response.responseText);
                toastr["error"](rasponseJson.message, "پیام سیستم");
            }
        },
        cache: false,
        // contentType: false,
        processData: false
    });
});