var CheckoutPaymentUi = function () {

    var isInternalSwitch = false;
    var lockDonateAjax = false;
    var lockCouponAjax = false;

    function getFinalCost() {
        return parseInt($('#invoiceInfo-totalCost').html());
    }
    function setFinalCost(finalCost) {
        if (!isNaN(finalCost)) {
            $('.finalPriceValue').html(finalCost.toLocaleString('fa'));
            $('#invoiceInfo-totalCost').html(parseInt(finalCost));
        }
    }
    function refreshPrice(cost) {
        var userCredit = parseInt(window.userCredit);
        var useWalletValue = Math.min(cost.payableByWallet, userCredit);

        $('#baseCostValue').html(cost.base.toLocaleString('fa') + 'تومان');
        $('#yourProfitValue').html(cost.discount.toLocaleString('fa') + 'تومان');
        $('#finalPriceValue').html((parseInt(cost.final) - useWalletValue).toLocaleString('fa') + 'تومان');

        $('#useWalletValue').html(useWalletValue.toLocaleString('fa') + 'تومان');
    }

    function getCouponCode() {
        return $('#invoiceInfo-couponCode').val();
    }

    function setCouponCode(code) {
        $('#invoiceInfo-couponCode').val(code);
    }

    function refreshUiBasedOnPaymentType() {
        let selectedObject = $('input[type="radio"][name="radioPaymentType"]:checked');
        let radioPaymentType = selectedObject.val();

        $('.PaymentType').slideUp();
        $('#PaymentType-' + radioPaymentType).slideDown();

        GAEE.checkoutOption(4, 'checkout-payment-PaymentType-'+radioPaymentType);

        // if (radioPaymentType==1) {
        //     $('#PaymentType-online').slideDown();
        //     $('#PaymentType-hozoori').slideUp();
        //     $('#PaymentType-card2card').slideUp();
        // } else if (radioPaymentType==2) {
        //     $('#PaymentType-online').slideUp();
        //     $('#PaymentType-hozoori').slideDown();
        //     $('#PaymentType-card2card').slideUp();
        // } else if (radioPaymentType==3) {
        //     $('#PaymentType-online').slideUp();
        //     $('#PaymentType-hozoori').slideUp();
        //     $('#PaymentType-card2card').slideDown();
        // }

        let btntext = selectedObject.data('btntext');
        $('.btnSubmitOrder').html(btntext);

    }

    function donate(isInit) {
        isInternalSwitch = true;
        $("#hasntDonate").bootstrapSwitch('state', false);
        $('.face-sad').fadeOut(0);
        $('.face-happy').fadeIn(0);
        $('.visibleInDonate').css({'visibility': 'visible'});
        window.orderHasDonate = 1;
        if (!isInit) {
            UesrCart.increaseOneProductNumber();
        }
        isInternalSwitch = false;
    }

    function dontdonate(isInit) {
        isInternalSwitch = true;
        $("#hasntDonate").bootstrapSwitch('state', true);
        $('.face-sad').fadeIn(0);
        $('.face-happy').fadeOut(0);
        $('.visibleInDonate').css({'visibility': 'hidden'});
        window.orderHasDonate = 0;
        if (!isInit) {
            UesrCart.reduceOneProductNumber();
        }
        isInternalSwitch = false;
    }

    function orderHasDonate() {
        // let switchStatus = $('#hasntDonate').prop('checked');
        // if (switchStatus) {
        //     return false;
        // } else {
        //     return true;
        // }
        let switchStatus = parseInt(window.orderHasDonate);
        return switchStatus === 1;
    }

    function orderHasCoupon() {
        // let switchStatus = $('#hasntDonate').prop('checked');
        // if (switchStatus) {
        //     return false;
        // } else {
        //     return true;
        // }
        let status = parseInt(window.orderHasCoupon);
        return status === 1;
    }

    function setTotalCostWithDonate(donateValue) {
        let calcTotalCost = getFinalCost() + (parseInt(donateValue) * 1000);
        setFinalCost(calcTotalCost);
    }

    function refreshUiBasedOnDonateStatus(isInit) {
        if (isInternalSwitch) {
            return false;
        }
        let orderHasDonateValue = orderHasDonate();
        if (isInit) {
            orderHasDonateValue = !orderHasDonateValue;
        }
        if (!orderHasDonateValue) {
            donate(isInit);
            let donateValue = 5;
            if (lockDonateAjax) {
                return false;
            }
            mApp.block('.addDonateWarper, .a--userCartList, .btnGotoCheckoutPayment', {
                type: 'loader',
                state: 'info',
            });
            $.ajax({
                type: 'POST',
                url: window.addDonateUrl,
                data: {
                    mode: 'normal'
                },
                success: function (data) {
                    lockDonateAjax = true;
                    if (data.error) {
                        if (data.error.code === 503) {
                            // donate();
                        } else {
                            dontdonate(isInit);
                            donateValue = 0;
                            toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                        }
                    } else {
                        // donate();
                        setTotalCostWithDonate(donateValue);
                    }
                    // mApp.unblock('.addDonateWarper, .a--userCartList');
                    lockDonateAjax = false;
                    GAEE.checkoutOption(4, 'checkout-payment-HasDonate');
                    window.location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    lockDonateAjax = true;
                    dontdonate(isInit);
                    donateValue = 0;
                    toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                    mApp.unblock('.addDonateWarper, .a--userCartList');
                    lockDonateAjax = false;
                }
            });
        } else {
            dontdonate(isInit);
            let donateValue = -5;
            if (lockDonateAjax) {
                return false;
            }
            mApp.block('.addDonateWarper, .a--userCartList, .btnGotoCheckoutPayment', {
                type: 'loader',
                state: 'info',
            });
            $.ajax({
                type: 'DELETE',
                url: window.removeDonateUrl,
                data: {
                    mode: 'normal'
                },
                success: function (data) {
                    lockDonateAjax = true;
                    if (data.error) {
                        donate(isInit);
                        toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                    } else {
                        // dontdonate();
                        setTotalCostWithDonate(donateValue);
                    }
                    // mApp.unblock('.addDonateWarper, .a--userCartList');
                    lockDonateAjax = false;
                    GAEE.checkoutOption(4, "checkout-payment-Hasn'tDonate");
                    window.location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    lockDonateAjax = true;
                    donate(isInit);
                    toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                    mApp.unblock('.addDonateWarper, .a--userCartList');
                    lockDonateAjax = false;
                }
            });
        }
    }
    function setUiHasDiscountCode() {
        $("#hasntDiscountCode").bootstrapSwitch('state', false);
        // $('.discountCodeWraper').fadeIn();
        $('.discountCodeValueWarperCover').fadeOut();
        let discountCodeValue = $('#discountCodeValue');
        let btnSaveDiscountCodeValue = $('#btnSaveDiscountCodeValue');
        discountCodeValue.prop('disabled', false);
        btnSaveDiscountCodeValue.prop('disabled', false);
        discountCodeValue.prop('readonly', false);
        btnSaveDiscountCodeValue.prop('readonly', false);
        GAEE.checkoutOption(4, 'checkout-payment-HasDiscountCode-'+$('#discountCodeValue').val());
    }
    function setUiHasntDiscountCode() {
        $("#hasntDiscountCode").bootstrapSwitch('state', true);
        // $('.discountCodeWraper').fadeOut();
        $('.discountCodeValueWarperCover').fadeIn();
        let discountCodeValue = $('#discountCodeValue');
        let btnSaveDiscountCodeValue = $('#btnSaveDiscountCodeValue');
        discountCodeValue.prop('disabled', true);
        btnSaveDiscountCodeValue.prop('disabled', true);
        discountCodeValue.prop('readonly', true);
        btnSaveDiscountCodeValue.prop('readonly', true);
        discountCodeValue.val('');
        GAEE.checkoutOption(4, 'checkout-payment-HasntDiscountCode');
    }
    function initUiBasedOnHasntDiscountCodeStatus(notIncludedProductsInCoupon) {
        var strLen = $('#discountCodeValue').val().length;
        if (strLen > 0) {
            $('#btnSaveDiscountCodeValue').prop('disabled', false);
        } else {
            $('#btnSaveDiscountCodeValue').prop('disabled', true);
        }
        if (orderHasCoupon()) {
            PrintnotIncludedProductsInCoupon(notIncludedProductsInCoupon);
            $('#discountCodeValue').prop('disabled', true);
        }

    }

    function attachCoupon() {

        let discountCodeValue = $('#discountCodeValue').val();
        if (discountCodeValue.trim().length === 0) {
            toastr.warning('مقداری برای کد تخفیف وارد نشده است.');
            return false;
        }

        if (lockCouponAjax) {
            return false;
        }

        mApp.block('.discountCodeWraper', {
            type: 'loader',
            state: 'info',
        });
        $.ajax({
            type: 'POST',
            url: window.OrderControllerSubmitCoupon,
            data: {
                code: discountCodeValue
            },
            success: function (data) {
                if (data.error) {

                    $('#btnRemoveDiscountCodeValue').fadeOut(0);
                    $('#btnSaveDiscountCodeValue').fadeIn();

                    let message = 'کد وارد شده معتبر نیست.';
                    toastr.warning(message);
                    $('#discountCodeValue').prop('disabled', false);
                } else {

                    $('.couponReportWarper').fadeIn();
                    let couponReport = ' کپن تخفیف ' +
                        ' <strong>' + data.coupon.name + '</strong> ' +
                        ' (' + data.coupon.code + ') ' +
                        ' با ' +
                        data.coupon.discount;

                    if (data.coupon.discountType.name === 'percentage') {
                        couponReport += '% تخفیف برای سفارش شما ثبت شده است.';
                    } else if (data.coupon.discountType.name === 'cost') {
                        couponReport += ' تومان تخفیف برای سفارش شما ثبت شد. ';
                    }
                    $('.couponReport').html(couponReport);

                    $('#btnSaveDiscountCodeValue').fadeOut(0);
                    $('#btnRemoveDiscountCodeValue').fadeIn();
                    $('#discountCodeValue').prop('disabled', true);

                    // setFinalCost(data.price.final);
                    refreshPrice(data.price);
                    PrintnotIncludedProductsInCoupon(data.notIncludedProductsInCoupon);

                    toastr.success('کد تخفیف شما ثبت شد.');
                    GAEE.checkoutOption(4, 'checkout-payment-SaveDiscountCode-'+discountCodeValue);
                }
                mApp.unblock('.discountCodeWraper, .hasntDiscountCodeWraper');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let statusCode = jqXHR.status;
                // console.log('statusCode: ', statusCode);
                // console.log('jqXHR: ', jqXHR);
                // console.log('textStatus: ', textStatus);
                // console.log('errorThrown: ', errorThrown);

                let message = '';

                if (statusCode === 500) {
                    message = 'خطایی رخ داده است.';
                } else {
                    message = 'کد وارد شده معتبر نیست';
                }

                toastr.warning(message);

                mApp.unblock('.discountCodeWraper, .hasntDiscountCodeWraper');

            }
        });
    }

    function detachCoupon(showMessage) {

        if (lockCouponAjax) {
            return false;
        }

        mApp.block('.discountCodeWraper, .hasntDiscountCodeWraper', {
            type: 'loader',
            state: 'info',
        });
        $.ajax({
            type: 'GET',
            url: window.OrderControllerRemoveCoupon,
            data: {},
            success: function (data) {
                if (data.error) {
                    if (showMessage === true) {
                        // let message = response.error.message;
                        let message = 'مشکلی در حذف کد تخفیف رخ داده است.';
                        toastr.error(message);
                        $('#btnSaveDiscountCodeValue').fadeOut(0);
                        $('#btnRemoveDiscountCodeValue').fadeIn();
                    }
                    $('#discountCodeValue').prop('disabled', true);
                } else {
                    $('.couponReportWarper').fadeOut();
                    $('#btnRemoveDiscountCodeValue').fadeOut(0);
                    $('#btnSaveDiscountCodeValue').fadeIn();
                    $('#discountCodeValue').val('');

                    // setFinalCost(data.price.final);
                    refreshPrice(data.price);
                    PrintnotIncludedProductsInCoupon([]);
                    setCouponCode('');
                    if (showMessage === true) {
                        toastr.success('کد تخفیف شما حذف شد.');
                    }
                    $('#discountCodeValue').prop('disabled', false);
                    $('#btnSaveDiscountCodeValue').prop('disabled', true);
                    PrintnotIncludedProductsInCoupon([]);
                }
                mApp.unblock('.discountCodeWraper, .hasntDiscountCodeWraper');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                mApp.unblock('.discountCodeWraper, .hasntDiscountCodeWraper');
            }
        });
    }

    function PrintnotIncludedProductsInCoupon(notIncludedProductsInCoupon) {
        if (typeof notIncludedProductsInCoupon !== 'undefined' && notIncludedProductsInCoupon !== null && notIncludedProductsInCoupon !== '' && notIncludedProductsInCoupon.length>0) {
            for (let index in notIncludedProductsInCoupon) {
                $('.notIncludedProductsInCoupon-'+notIncludedProductsInCoupon[index].id).fadeIn();
            }
        } else {
            $('.notIncludedProductsInCoupon').fadeOut();
        }
    }

    function initUiBasedOnGateway() {
        let action = $('input[type="radio"][name="radioBankType"]:checked').val();
        let bankType = $('input[type="radio"][name="radioBankType"]:checked').data('bank-type');
        $('#frmGotoGateway').attr('action', action);
    }

    return {
        initUi: function (notIncludedProductsInCoupon) {
            lockDonateAjax = true;
            lockCouponAjax = true;
            // refreshUiBasedOnPaymentType();
            initUiBasedOnGateway();
            refreshUiBasedOnDonateStatus(true);
            initUiBasedOnHasntDiscountCodeStatus(notIncludedProductsInCoupon);
            lockDonateAjax = false;
            lockCouponAjax = false;
        },
        refreshUiBasedOnPaymentType:function () {
            refreshUiBasedOnPaymentType();
        },
        refreshUiBasedOnDonateStatus:function (donateValue) {
            refreshUiBasedOnDonateStatus(false);
        },
        attachCoupon:function () {
            attachCoupon();
        },
        detachCoupon:function (showMessage) {
            detachCoupon(showMessage);
        },
        PrintnotIncludedProductsInCoupon:function (notIncludedProductsInCoupon) {
            PrintnotIncludedProductsInCoupon(notIncludedProductsInCoupon);
        },
    };
}();

$(document).ready(function () {

    GAEE.checkout(3, 'review', checkoutReviewProducts);

    if ($('#js-var-userId').val()) {
        $('.Step-warper').fadeIn();
    }

    CheckoutPaymentUi.initUi(notIncludedProductsInCoupon);

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

    $(document).on('click', '#btnSaveDiscountCodeValue', function () {
        CheckoutPaymentUi.attachCoupon();
    });

    $(document).on('click', '#btnRemoveDiscountCodeValue', function() {
        CheckoutPaymentUi.detachCoupon(true);
        GAEE.checkoutOption(4, 'checkout-payment-RemoveDiscountCode');
    });

    $(document).on('keyup', '#discountCodeValue', function(){
        var strLen = $(this).val().length;
        if (strLen > 0) {
            $('#btnSaveDiscountCodeValue').prop('disabled', false);
        } else {
            $('#btnSaveDiscountCodeValue').prop('disabled', true);
        }
    });

    $(document).on('switchChange.bootstrapSwitch', '#hasntDonate', function (e) {
        CheckoutPaymentUi.refreshUiBasedOnDonateStatus($('#m_nouislider_1_input').val());
    });

    $(document).on('change', 'input[type="radio"][name="radioBankType"]', function (e) {
        let action = $('input[type="radio"][name="radioBankType"]:checked').val();
        let bankType = $('input[type="radio"][name="radioBankType"]:checked').data('bank-type');
        $('#frmGotoGateway').attr('action', action);
        GAEE.checkoutOption(4, "checkout-payment-BankType-"+bankType);
    });
});
