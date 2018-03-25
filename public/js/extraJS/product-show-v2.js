/**
 * Set token for ajax request
 */
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    attributeChange();
});

function attributeChange() {
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
    var product = $("input[name=product_id]").val();
    $.ajax({
        type: "POST",
        url: "/refreshPrice",
        data: { attributeState: attributeState ,  product: product  },
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                // console.log(response);

                response = $.parseJSON(response);
                if(response.productWarning)
                {
                    toastr["warning"]("توجه!",response.productWarning);
                }else {
                    cost = response.cost;
                    discount = response.discount;

                    $.each( extraCostMap, function( key, value ) {
                        cost += value;
                    });

                    $("#price").text(cost).number(true).append("تومان");
                    $("#discount").text(((discount) / 100) * parseInt(cost)).number(true).append("تومان");
                    $("#customerPrice").text((1 - (discount) / 100) * parseInt(cost) ).number(true).append("تومان");
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
        }
    });
}

var cost = 0 ;
var discount = 0 ;
$(document).on("change", ".attribute", function (){
    attributeChange();

});


var extraCostMap = [] ;
$(document).on("change", ".overallAttribute", function (){
    var attributeState = $('select[name="overallAttribute[]"]').map(function(){
        if ($(this).val())
            return $(this).val();
    }).get();

    var id = $(this).val();
    var product = $("input[name=product_id]").val();

    $.ajax({
        type: "POST",
        url: "/refreshPrice",
        data: { attributeState: attributeState ,extraCostMap : extraCostMap , value: id ,  product: product , totalCost:cost },
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                // console.log(response);
                response = $.parseJSON(response);
                // console.log(response);
                cost = parseInt(response.newTotalCost);
                var value = (1-(discount/100))*(cost);
                extraCostMap = response.extraCostMap ;
                $("#price").text(cost).number(true).append("تومان");
                $("#customerPrice").text(value).number(true).append("تومان");
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