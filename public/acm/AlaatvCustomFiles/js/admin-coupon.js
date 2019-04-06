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
