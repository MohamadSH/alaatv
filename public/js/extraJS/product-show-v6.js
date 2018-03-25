/**
 * Set token for ajax request
 */
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    refreshPrice(refreshPriceType);
});

function refreshPrice(type) {
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

    var productsState = $('input[type=checkbox][name="products[]"]:enabled:checked').map(function(){
        if ($(this).val())
            return $(this).val();
    }).get();


    var c = $.merge($.merge(selectAttributeState , checkboxAttributeState) , staticAttributeState);
    var attributeState= c.filter(function (item, pos) {return c.indexOf(item) == pos});
    var product = $("input[name=product_id]").val();
    $.ajax({
        type: "POST",
        url: "/refreshPrice",
        data: { attributeState: attributeState ,  product: product , products:productsState ,  type:type  },
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                // console.log(response);

                response = $.parseJSON(response);
                console.log(response);
                if(response.productWarning)
                {
                    toastr["warning"]("توجه!",response.productWarning);
                }else {
                    cost = response.cost;
                    costForCustomer = response.costForCustomer;
                    // productShortDescription = response.shortDescription ;
                    // productLongDescription = response.longDescription ;

                    $("#price").text(cost).number(true).append("تومان");
                    $("#customerPrice").text(costForCustomer).number(true).append("تومان");
                    var discount = parseInt(cost) - parseInt(costForCustomer);
                    $("#discount").text(discount).number(true).append("تومان");
                    $("#price").attr("value" , cost);
                    // $("#productShortDescription").html(productShortDescription);
                    // $("#productLongDescription").html(productLongDescription);
                }

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
                // window.location.replace("/404");
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

var totalExtraCost = 0 ;
var bonDiscount = 0 ;
var productDiscount = 0 ;
// var productShortDescription = "";
// var productLongDescription = "";
$(document).on("ifChanged", ".attribute", function (){
    refreshPrice("mainAttribute");
});

$(document).on("change", ".attribute", function (){
    refreshPrice("mainAttribute");
});

$(document).on("change", ".extraAttribute", function (){
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

    var product = $("input[name=product_id]").val();

    $.ajax({
        type: "POST",
        url: "/refreshPrice",
        data: { attributeState: attributeState   ,   product: product  , type:"extraAttribute" },
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                // console.log(response);
                response = $.parseJSON(response);
                // console.log(response);
                totalExtraCost = parseInt(response.totalExtraCost);
                var currentPrice = parseInt($("#price").attr("value"));
                var currentCustomerPrice = parseInt($("#customerPrice").attr("value"));
                $("#price").text(currentPrice+parseInt(totalExtraCost)).number(true).append("تومان");
                $("#customerPrice").text(currentCustomerPrice+parseInt(totalExtraCost)).number(true).append("تومان");
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
        },
    });
});

$(document).on("ifChanged", ".childL1", function ()
{

    var parentId = $(this).attr("id");
    $('.'+parentId+'_childL2').each(function()
    {
        if($("#"+parentId).prop('checked')) {
            $(this).closest(".icheckbox_minimal-blue").addClass('checked');
            $(this).prop('checked', true);
            $(this).attr('disabled', true);
        }else{
            $(this).closest(".icheckbox_minimal-blue").removeClass('checked');
            $(this).prop('checked', false);
            $(this).attr('disabled', false);
        }

    });
    refreshPrice("selectProduct");

});

$(document).on("ifChanged", "[class^='productCheckList']", function ()
{
    var className = $(this).attr("class").split(' ')[0];
    var flag =true;
    $('.'+className).each(function()
    {
        if(!$(this).prop("checked")) {
            flag = false ;
            return false;
        }

    });
    if(flag)
    {
        var parentId = className.split('_')[0];
        $("#"+parentId).closest(".icheckbox_square-blue").addClass('checked');
        $("#"+parentId).prop('checked', true);
        $('.'+className).each(function()
        {
            $(this).closest(".icheckbox_minimal-blue").addClass('checked');
            $(this).prop('checked', true);
            $(this).prop('disabled', true);
        });
    }
    refreshPrice("selectProduct");
});


$(document).on("click", "#orderButton2", function (){
    $( "#orderButton1" ).trigger("click");
});

