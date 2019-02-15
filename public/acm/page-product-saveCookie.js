
var UesrCart = function () {

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function getUserCartFromCookie() {
        let userCart = getCookie('UserCart');
        if(userCart.length>0) {
            return JSON.parse(userCart);
        } else {
            return [];
        }
    }
    function addToCartInCookie(data) {

        let userCart = getUserCartFromCookie();

        // let data = {
        //     'product_id':productId,
        //     'mainAttributeStates':mainAttributeStates,
        //     'extraAttributeStates':extraAttributeStates,
        //     'productSelectValues':productSelectValues,
        // };



        let userHaveThisProduct = false;
        for (var index in userCart) {
            if(userCart[index].product_id == data.product_id) {
                userHaveThisProduct = true;
                userCart[index] = data;
            } else {
                userHaveThisProduct = false;
            }
        }

        if(!userHaveThisProduct) {
            userCart.push(data);
        }

        setCookie('UserCart', JSON.stringify(userCart), 7);

        console.log('UserCartFromCookie: ', getUserCartFromCookie());
    }

    function disableBtnAddToCart() {
        $('.btnAddToCart').attr('disabled', true);
        $('.btnAddToCart').addClass('disabled');
        $('.btnAddToCart .flaticon-shopping-basket').fadeOut();
        $('.btnAddToCart .fas.fa-sync-alt.fa-spin').fadeIn();
    }
    function enableBtnAddToCart() {
        $('.btnAddToCart').attr('disabled', false);
        $('.btnAddToCart').removeClass('disabled');
        $('.btnAddToCart .flaticon-shopping-basket').fadeIn();
        $('.btnAddToCart .fas.fa-sync-alt.fa-spin').fadeOut();
    }

    return {
        addToCartInCookie: function (data) {
            addToCartInCookie(data);
        },

        disableBtnAddToCart: function () {
            disableBtnAddToCart();
        },

        enableBtnAddToCart: function () {
            enableBtnAddToCart();
        }
    };
}();

jQuery(document).ready(function() {

    $(document).on('click', '.btnAddToCart', function() {

        if($(this).attr('disabled')) {
            return false;
        }

        UesrCart.disableBtnAddToCart();
        var product = $("input[name=product_id]").val();
        let mainAttributeStates = getMainAttributeStates();
        let extraAttributeStates = getExtraAttributeStates();
        let productSelectValues = getProductSelectValues() ;

        if($('#js-var-userId').val()) {

            $.ajax({
                type: 'POST',
                url: '/orderproduct',
                data: {
                    product_id: product,
                    products: productSelectValues,
                    attribute: mainAttributeStates,
                    extraAttribute: extraAttributeStates
                },
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        // console.log(response);

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.success("محصول مورد نظر به سبد خرید اضافه شد.");

                        setTimeout(function() {
                            window.location.replace('/checkout/review');
                        }, 2000);

                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        // window.location.replace("/403");
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (response) {
                        // window.location.replace("/403");
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
                        Swal({
                            title: 'توجه!',
                            text: 'خطای سیستمی رخ داده است.',
                            type: 'danger',
                            confirmButtonText: 'بستن'
                        });
                        UesrCart.enableBtnAddToCart();
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        Swal({
                            title: 'توجه!',
                            text: 'خطای پایگاه داده!',
                            type: 'danger',
                            confirmButtonText: 'بستن'
                        });
                        UesrCart.enableBtnAddToCart();
                    }
                }
            });

        } else {

            let data = {
                'product_id':$('input[name="product_id"][type="hidden"]').val(),
                'mainAttributeStates':mainAttributeStates,
                'extraAttributeStates':extraAttributeStates,
                'productSelectValues':productSelectValues,
            };

            UesrCart.addToCartInCookie(data);

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            toastr.success("محصول مورد نظر به سبد خرید اضافه شد.");

            setTimeout(function() {
                window.location.replace('/checkout/review');
            }, 2000);
        }
    });
});

