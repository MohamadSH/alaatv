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
        $('#orderHasDonate').val(1);
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
        $('#orderHasDonate').val(0);
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
        let switchStatus = parseInt($('#orderHasDonate').val());
        return switchStatus === 1;
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
            mApp.block('.addDonateWarper', {
                type: 'loader',
                state: 'info',
            });
            $.ajax({
                type: 'POST',
                url: $('#addDonateUrl').val(),
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
                    mApp.unblock('.addDonateWarper');
                    lockDonateAjax = false;
                    GAEE.checkoutOption(4, 'checkout-payment-HasDonate');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    lockDonateAjax = true;
                    dontdonate(isInit);
                    donateValue = 0;
                    toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                    mApp.unblock('.addDonateWarper');
                    lockDonateAjax = false;
                }
            });
        } else {
            dontdonate(isInit);
            let donateValue = -5;
            if (lockDonateAjax) {
                return false;
            }
            mApp.block('.addDonateWarper', {
                type: 'loader',
                state: 'info',
            });
            $.ajax({
                type: 'DELETE',
                url: $('#removeDonateUrl').val(),
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
                    mApp.unblock('.addDonateWarper');
                    lockDonateAjax = false;
                    GAEE.checkoutOption(4, "checkout-payment-Hasn'tDonate");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    lockDonateAjax = true;
                    donate(isInit);
                    toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                    mApp.unblock('.addDonateWarper');
                    lockDonateAjax = false;
                }
            });
        }
    }
    function setUiHasDiscountCode() {
        $("#hasntDiscountCode").bootstrapSwitch('state', false);
        // $('.discountCodeValueWarper').fadeIn();
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
        // $('.discountCodeValueWarper').fadeOut();
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
    function refreshUiBasedOnHasntDiscountCodeStatus() {
        $('#discountCodeValue').val((getCouponCode()));
        if(!$('#hasntDiscountCode').prop('checked')) {
            setUiHasDiscountCode();
        } else {
            if (getCouponCode().trim().length > 0) {
                detachCoupon(false);
            }
            setUiHasntDiscountCode();
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

        mApp.block('.discountCodeValueWarper, .hasntDiscountCodeWraper', {
            type: 'loader',
            state: 'info',
        });
        $.ajax({
            type: 'POST',
            url: $('#OrderController-submitCoupon').val(),
            data: {
                code: discountCodeValue
            },
            success: function (data) {
                if (data.error) {

                    $('#btnRemoveDiscountCodeValue').fadeOut(0);
                    $('#btnSaveDiscountCodeValue').fadeIn();

                    // let message = data.error.message;
                    let message = 'کد وارد شده معتبر نیست.';
                    toastr.warning(message);
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

                    setFinalCost(data.price.final);
                    PrintnotIncludedProductsInCoupon(data.notIncludedProductsInCoupon);

                    toastr.success('کد تخفیف شما ثبت شد.');
                    GAEE.checkoutOption(4, 'checkout-payment-SaveDiscountCode-'+discountCodeValue);
                }
                mApp.unblock('.discountCodeValueWarper, .hasntDiscountCodeWraper');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let statusCode = jqXHR.status;

                let message = '';

                if (statusCode === 500) {
                    message = 'خطایی رخ داده است.';
                } else {
                    message = 'کد وارد شده معتبر نیست';
                }

                toastr.warning(message);

                mApp.unblock('.discountCodeValueWarper, .hasntDiscountCodeWraper');

            }
        });
    }

    function detachCoupon(showMessage) {

        if (lockCouponAjax) {
            return false;
        }

        mApp.block('.discountCodeValueWarper, .hasntDiscountCodeWraper', {
            type: 'loader',
            state: 'info',
        });
        $.ajax({
            type: 'GET',
            url: $('#OrderController-removeCoupon').val(),
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
                } else {
                    $('.couponReportWarper').fadeOut();
                    $('#btnRemoveDiscountCodeValue').fadeOut(0);
                    $('#btnSaveDiscountCodeValue').fadeIn();
                    $('#discountCodeValue').val('');

                    setFinalCost(data.price.final);
                    PrintnotIncludedProductsInCoupon([]);
                    setCouponCode('');
                    if (showMessage === true) {
                        toastr.success('کد تخفیف شما حذف شد.');
                    }
                }
                mApp.unblock('.discountCodeValueWarper, .hasntDiscountCodeWraper');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                mApp.unblock('.discountCodeValueWarper, .hasntDiscountCodeWraper');
            }
        });
    }

    function PrintnotIncludedProductsInCoupon(notIncludedProductsInCoupon) {
        let html = '';
        if (typeof notIncludedProductsInCoupon !== 'undefined' && notIncludedProductsInCoupon !== null && notIncludedProductsInCoupon !== '' && notIncludedProductsInCoupon.length>0) {
            html += '' +
                '<div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-warning alert-dismissible fade show" role="alert">\n' +
                '  <div class="m-alert__icon">\n' +
                '    <i class="fa fa-exclamation-triangle"></i>\n' +
                '    <span></span>\n' +
                '  </div>\n' +
                '  <div class="m-alert__text">\n' +
                '    <strong>توجه!</strong> کد تخفیف وارد شده شامل محصولات زیر نمی شود:\n' +
                '  </div>\n' +
                '  <div class="m-alert__close">\n' +
                '  </div>\n' +
                '</div>' +
                '<div class="row">';
            for (let index in notIncludedProductsInCoupon) {
                let item = notIncludedProductsInCoupon[index];
                html += '' +
                    '<div class="col">' +
                    '  <div class="alert alert-accent alert-dismissible fade show m-alert m-alert--square m-alert--air notIncludedProductsInCoupon" role="alert">\n' +
                    '    <div>' +
                    item.name +
                    '    </div>' +
                    '  </div>' +
                    '</div>';
            }
            html += '</div>';
        }
        $('.notIncludedProductsInCouponReportArea').html(html);
    }

    return {
        initUi: function () {
            lockDonateAjax = true;
            lockCouponAjax = true;
            refreshUiBasedOnPaymentType();
            refreshUiBasedOnDonateStatus(true);
            refreshUiBasedOnHasntDiscountCodeStatus();
            lockDonateAjax = false;
            lockCouponAjax = false;
        },
        refreshUiBasedOnHasntDiscountCodeStatus:function () {
            refreshUiBasedOnHasntDiscountCodeStatus();
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

var lockDonateAjaxForSliderInit = true;

$(document).ready(function () {

    CheckoutPaymentUi.PrintnotIncludedProductsInCoupon(notIncludedProductsInCoupon);

    let n = document.getElementById('m_nouislider_1_input');
    let e = document.getElementById('m_nouislider_1');

    let action = $('input[type="radio"][name="radioBankType"]:checked').val();

    GAEE.checkout(4, 'payment', []);
    $('#frmGotoGateway').attr('action', action);

    CheckoutPaymentUi.initUi();

    $(document).on('click', '#btnSaveDiscountCodeValue', function () {
        CheckoutPaymentUi.attachCoupon();
    });

    $(document).on('click', '#btnRemoveDiscountCodeValue', function() {
        CheckoutPaymentUi.detachCoupon(true);
        GAEE.checkoutOption(4, 'checkout-payment-RemoveDiscountCode');
    });

    $(document).on('change', 'input[type="radio"][name="radioPaymentType"]', function () {
        CheckoutPaymentUi.refreshUiBasedOnPaymentType();
    });

    $(document).on('switchChange.bootstrapSwitch', '#hasntDiscountCode', function () {
        CheckoutPaymentUi.refreshUiBasedOnHasntDiscountCodeStatus();
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

    noUiSlider.create(e, {
        start: [5],
        // connect: [!0, !1],
        step: 1,
        range: {min: [1], max: [50]},
        format: wNumb({decimals: 0})
    });


    e.noUiSlider.on('update', function (e, t) {
        n.value = e[t];
        // if (!lockDonateAjaxForSliderInit) {
        //     CheckoutPaymentUi.refreshUiBasedOnDonateStatus(n.value);
        // }
        // lockDonateAjaxForSliderInit = false;
    });

    n.addEventListener('change', function () {
        e.noUiSlider.set(this.value)
    });
});