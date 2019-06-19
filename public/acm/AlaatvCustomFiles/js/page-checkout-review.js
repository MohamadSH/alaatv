$(document).ready(function () {

    GAEE.checkout(3, 'review', checkoutReviewProducts);

    if ($('#js-var-userId').val()) {
        $('.Step-warper').fadeIn();
    }


    $('.a--userCartList .m-portlet__head').sticky({
        topSpacing: $('#m_header').height(),
        zIndex: 98
    });

    $(document).on('click', '.btnRemoveOrderproduct', function () {

        mApp.block('.a--userCartList', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });
        mApp.block('.CheckoutReviewTotalPriceWarper', {
            type: "loader",
            state: "success",
        });

        var products = [{
            id : $(this).data('productid'),
            name : $(this).data('name'),
            quantity: 1,
            category : $(this).data('category'),
            variant : $(this).data('variant')
        }];

        GAEE.productRemoveFromCart('order.checkoutReview', products);

        if ($('#js-var-userId').val()) {
            $.ajax({
                type: 'DELETE',
                url: $(this).data('action'),
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        // console.log(response);
                        location.reload();
                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        window.location.replace("/403");
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (response) {
                        window.location.replace("/403");
                    },
                    //Method Not Allowed
                    405: function (response) {
                        // console.log(response);
                        // console.log(response.responseText);
                        location.reload();
                    },
                    404: function (response) {
                        window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        // console.log(response);
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        // console.log(response.responseText);
//                            toastr["error"]("خطای برنامه!", "پیام سیستم");
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                    }
                }
            });
        } else {

            let data = {
                'simpleProductId': $(this).data('productid')
            };
            UesrCart.removeFromCartInCookie(data);
            location.reload();
        }
    });
});