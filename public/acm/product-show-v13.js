$(function() {
    /**
     * Set token for ajax request
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': window.Laravel.csrfToken,
        }
    });
});

var totalExtraCost = 0 ;
var bonDiscount = 0 ;
var productDiscount = 0 ;
/*
var productShortDescription = "";
var productLongDescription = "";
*/

function refreshPrice(mainAttributeState , productState , extraAttributeState) {
    var product = $("input[name=product_id]").val();

    $('#a_product-price').html('<div class="m-loader m-loader--success" style="width: 30px; display: inline-block;"></div>');
    $.ajax({
        type: "POST",
        url: "/refreshPrice/"+product,
        data: { mainAttributeValues: mainAttributeState , products: productState , extraAttributeValues: extraAttributeState },
        statusCode: {
            //The status for when action was successful
            200: function (response) {

                // console.log(response);

                response = $.parseJSON(response);


                // {"cost":136000,"costForCustomer":136000,"totalExtraCost":0}
                totalExtraCost = parseInt(response.totalExtraCost);
                let response_cost = parseInt(response.cost);
                let response_costForCustomer = parseInt(response.costForCustomer);

                if(response_costForCustomer<response_cost) {
                    $('#a_product-price').html('قیمت محصول: <strike>'+response_cost+'</strike> تومان <br>قیمت برای مشتری: '+response_costForCustomer+' تومان ');
                } else {
                    $('#a_product-price').html('قیمت محصول: '+response_costForCustomer+' تومان ');
                }

                // var currentPrice = parseInt($("#price").attr("value"));
                // var currentCustomerPrice = parseInt($("#customerPrice").attr("value"));
                // if(currentPrice>0)
                // {
                //     if(currentPrice+parseInt(totalExtraCost) === 0 )
                //         $("#price").text("پس از انتخاب محصول");
                //     else
                //         $("#price").text(currentPrice+parseInt(totalExtraCost)).number(true).append("تومان");
                //
                //     $("#customerPrice").text(currentCustomerPrice+parseInt(totalExtraCost)).number(true).append("تومان");
                // }
                //
                if(response.productWarning)
                {

                    Swal({
                        title: 'توجه!',
                        text: response.productWarning,
                        type: 'warning',
                        confirmButtonText: 'بستن'
                    });
                    // toastr["warning"]("توجه!",response.productWarning);
                }
                // else {
                //     cost = response.cost;
                //     costForCustomer = response.costForCustomer;
                //     // productShortDescription = response.shortDescription ;
                //     // productLongDescription = response.longDescription ;
                //
                //     if(cost === 0 ) {
                //         $("#price").text("پس از انتخاب محصول");
                //         $("#customerPrice").text(0).number(true).append("تومان");
                //     }
                //     else {
                //         // $("#price").text(cost+totalExtraCost).number(true).append("تومان");
                //         // $("#customerPrice").text(costForCustomer+totalExtraCost).number(true).append("تومان");
                //     }
                //     $("#price").attr("value" , cost);
                //     $("#customerPrice").attr("value" , costForCustomer);
                //     var discount = parseInt(cost) - parseInt(costForCustomer);
                //     // $("#discount").text(discount).number(true).append("تومان");
                //     // $("#productShortDescription").html(productShortDescription);
                //     // $("#productLongDescription").html(productLongDescription);
                // }


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
                console.log(response);
            },
            //The status for when there is error php code
            500: function (response) {
                console.log(response.responseText);
//                            toastr["error"]("خطای برنامه!", "پیام سیستم");
            },
            //The status for when there is error php code
            503: function (response) {
//                            toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
            }
        }
    });
}

function getMainAttributeStates()
{
    var staticAttributeState = $('input[type=hidden][name="attribute[]"]').map(function(){
        if ($(this).val())
            return $(this).val();
    }).get();
    var selectAttributeState = $('select[name="attribute[]"]').map(function(){
        if ($(this).val())
            return $(this).val();
    }).get();
    var checkboxAttributeState = $('input[type=checkbox][name="attribute[]"]:checked').map(function(){
        if ($(this).val())
            return $(this).val();
    }).get();

    var c = $.merge($.merge(selectAttributeState , checkboxAttributeState) , staticAttributeState);
    var attributeState= c.filter(function (item, pos) {return c.indexOf(item) == pos});

    return attributeState ;
}

function getExtraAttributeStates()
{
    var selectAttributeState = $('select[name="extraAttribute[]"]').map(function(){
        if ($(this).val())
            return $(this).val();
    }).get();

    var checkboxAttributeState = $('input[type=checkbox][name="extraAttribute[]"]:checked').map(function(){
        if ($(this).val())
            return $(this).val();
    }).get();


    var c = $.merge(selectAttributeState , checkboxAttributeState);
    var attributeState= c.filter(function (item, pos) {return c.indexOf(item) == pos});

    return attributeState;
}

function getProductSelectValues()
{
    // var productsState = $('input[type=checkbox][name="products[]"]:enabled:checked').map(function(){
    //     if ($(this).val())
    //         return $(this).val();
    // }).get();
    var productsState = $('input[type=checkbox][name="products[]"]:checked').map(function(){
        if ($(this).val())
            return $(this).val();
    }).get();
    return productsState;
}

$(document).on("ifChanged change", ".attribute", function ()
{
    var attributeState = getMainAttributeStates();
    refreshPrice(attributeState , [] ,[]);
});

$(document).on("ifChanged change", ".extraAttribute", function ()
{
    var attributeState = getExtraAttributeStates();
    refreshPrice([] , [] , attributeState);
});

$(document).on("ifChanged switchChange.bootstrapSwitch", ".product", function ()
{
    var productsState = getProductSelectValues() ;
    refreshPrice([] , productsState , []);
});