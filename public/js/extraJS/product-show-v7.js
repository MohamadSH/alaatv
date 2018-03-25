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

                response = $.parseJSON(response);
                // console.log(response);
                if(response.productWarning)
                {
                    toastr["warning"]("توجه!",response.productWarning);
                }else {
                    cost = response.cost;
                    costForCustomer = response.costForCustomer;
                    // productShortDescription = response.shortDescription ;
                    // productLongDescription = response.longDescription ;

                    if(cost === 0 ) {
                        $("#price").text("پس از انتخاب محصول");
                        $("#customerPrice").text(0).number(true).append("تومان");
                    }
                    else {
                        $("#price").text(cost+totalExtraCost).number(true).append("تومان");
                        $("#customerPrice").text(costForCustomer+totalExtraCost).number(true).append("تومان");
                    }
                    $("#price").attr("value" , cost);
                    $("#customerPrice").attr("value" , costForCustomer);
                    var discount = parseInt(cost) - parseInt(costForCustomer);
                    $("#discount").text(discount).number(true).append("تومان");
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

$(document).on("ifChanged", ".extraAttribute", function (){
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
                console.log(response);
                totalExtraCost = parseInt(response.totalExtraCost);

                var currentPrice = parseInt($("#price").attr("value"));
                var currentCustomerPrice = parseInt($("#customerPrice").attr("value"));
                if(currentPrice>0){
                    if(currentPrice+parseInt(totalExtraCost) === 0 ) $("#price").text("پس از انتخاب محصول");
                    else $("#price").text(currentPrice+parseInt(totalExtraCost)).number(true).append("تومان");
                    $("#customerPrice").text(currentCustomerPrice+parseInt(totalExtraCost)).number(true).append("تومان");
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

function childClick( explicitClassName) {
    var className = explicitClassName.split(' ')[0];
    var parentId = className.split('_')[1];
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
        $('input[value='+parentId+']').closest(".icheckbox_minimal-blue").find(".iCheck-helper").click();
    }else{
        if( $('input[value='+parentId+']').prop("checked"))
        {
            $('input[value='+parentId+']').closest(".icheckbox_minimal-blue").removeClass('checked');
            $('input[value='+parentId+']').prop('checked', false);
            var parentClassName = $('input[value='+parentId+']').attr("class");
            childClick(parentClassName);
        }
    }
}

$(document).on("ifChanged", ".hasChildren", function ()
{
    var parentElement = $(this);
    var parentId = $(this).val();
    childElements = $(".children_"+parentId).find("input");
    childElements.each(function()
    {
        if(parentElement.prop('checked')) {
            $(this).closest(".icheckbox_minimal-blue").addClass('checked');
            $(this).prop('checked', true);
        }else{
            $(this).closest(".icheckbox_minimal-blue").removeClass('checked');
            $(this).prop('checked', false);
        }

    });
});

$(document).on("ifChanged", "[class^='hasParent']", function () {
    var className = $(this).attr("class");
    childClick(className);
});

$(document).on("ifChanged", ".product", function () {
    refreshPrice("productSelection");
});

$(document).on("click", "#orderButton2", function (){
    $( "#orderButton1" ).trigger("click");
});

