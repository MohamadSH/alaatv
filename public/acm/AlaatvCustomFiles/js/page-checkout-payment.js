var CheckoutPaymentUi = function () {

    let totalCost = $('#invoiceInfo-totalCost').val();
    let couponCode = $('#invoiceInfo-couponCode').val();
    var lockDonateAjax = false;
    var lockCouponAjax = false;

    function refreshUiBasedOnPaymentType() {
        let selectedObject = $('input[type="radio"][name="radioPaymentType"]:checked');
        let radioPaymentType = selectedObject.val();

        $('.PaymentType').slideUp();
        $('#PaymentType-' + radioPaymentType).slideDown();

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

    function donate() {
        $("#hasntDonate").bootstrapSwitch('state', false);
        $('.face-sad').fadeOut(0);
        $('.face-happy').fadeIn(0);
        $('.visibleInDonate').css({'visibility': 'visible'});
    }

    function dontdonate() {
        $("#hasntDonate").bootstrapSwitch('state', true);
        $('.face-sad').fadeIn(0);
        $('.face-happy').fadeOut(0);
        $('.visibleInDonate').css({'visibility': 'hidden'});
    }

    function getDonateStatus() {
        let switchStatus = $('#hasntDonate').prop('checked');
        if (switchStatus) {
            return false;
        } else {
            return true;
        }
    }

    function refreshUiBasedOnDonateStatus(donateValue) {
        if (getDonateStatus()) {
            donate();
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
                            donate();
                        } else {
                            dontdonate();
                            donateValue = 0;
                            toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                        }
                    } else {
                        donate();
                    }
                    mApp.unblock('.addDonateWarper');
                    lockDonateAjax = false;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    lockDonateAjax = true;
                    dontdonate();
                    donateValue = 0;
                    toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                    mApp.unblock('.addDonateWarper');
                    lockDonateAjax = false;
                }
            });
        } else {
            dontdonate();
            donateValue = 0;
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
                        donate();
                        toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                    } else {
                        dontdonate();
                        donateValue = 0;
                    }
                    mApp.unblock('.addDonateWarper');
                    lockDonateAjax = false;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    lockDonateAjax = true;
                    donate();
                    toastr.warning('مشکلی رخ داده است. مجدد سعی کنید.');
                    mApp.unblock('.addDonateWarper');
                    lockDonateAjax = false;
                }
            });
        }
        let calcTotalCost = parseInt(totalCost) + (parseInt(donateValue) * 1000);
        $('.finalPriceValue').html(calcTotalCost.toLocaleString('fa'));
    }
    function setUiHasDiscountCode() {
        // $('.discountCodeValueWarper').fadeIn();
        $('.discountCodeValueWarperCover').fadeOut();
        let discountCodeValue = $('#discountCodeValue');
        let btnSaveDiscountCodeValue = $('#btnSaveDiscountCodeValue');
        discountCodeValue.prop('disabled', false);
        btnSaveDiscountCodeValue.prop('disabled', false);
        discountCodeValue.prop('readonly', false);
        btnSaveDiscountCodeValue.prop('readonly', false);
    }
    function setUiHasntDiscountCode() {
        // $('.discountCodeValueWarper').fadeOut();
        $('.discountCodeValueWarperCover').fadeIn();
        let discountCodeValue = $('#discountCodeValue');
        let btnSaveDiscountCodeValue = $('#btnSaveDiscountCodeValue');
        discountCodeValue.prop('disabled', true);
        btnSaveDiscountCodeValue.prop('disabled', true);
        discountCodeValue.prop('readonly', true);
        btnSaveDiscountCodeValue.prop('readonly', true);
    }
    function refreshUiBasedOnHasntDiscountCodeStatus() {
        $('#discountCodeValue').val(couponCode);
        if(!$('#hasntDiscountCode').prop('checked')) {
            setUiHasDiscountCode();
        } else {
            setUiHasntDiscountCode();
            detachCoupon(false);
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

        mApp.block('.discountCodeValueWarper', {
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
                        ' <strong>' + data[0].name + '</strong> ' +
                        ' (' + data[0].code + ') ' +
                        ' با ' +
                        data[0].discount;

                    if (data[0].discountType.name === 'percentage') {
                        couponReport += '% تخفیف برای سفارش شما ثبت شده است.';
                    } else if (data[0].discountType.name === 'cost') {
                        couponReport += ' تومان تخفیف برای سفارش شما ثبت شد. ';
                    }
                    $('.couponReport').html(couponReport);

                    $('#btnSaveDiscountCodeValue').fadeOut(0);
                    $('#btnRemoveDiscountCodeValue').fadeIn();

                    toastr.success('کد تخفیف شما ثبت شد.');
                }
                mApp.unblock('.discountCodeValueWarper');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                let statusCode = jqXHR.status;
                // console.log('statusCode: ', statusCode);
                // console.log('jqXHR: ', jqXHR);
                // console.log('textStatus: ', textStatus);
                // console.log('errorThrown: ', errorThrown);

                let message = '';

                if (statusCode == 500) {
                    message = 'خطایی رخ داده است.';
                } else {
                    message = 'کد وارد شده معتبر نیست';
                }

                toastr.warning(message);

                mApp.unblock('.discountCodeValueWarper');

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

    return {
        refreshUi:function () {
            lockDonateAjax = true;
            lockCouponAjax = true;
            refreshUiBasedOnPaymentType();
            refreshUiBasedOnDonateStatus();
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
            refreshUiBasedOnDonateStatus(donateValue);
        },
        attachCoupon:function () {
            attachCoupon();
        },
        detachCoupon:function (showMessage) {
            detachCoupon(showMessage);
        },
    };
}();

var lockDonateAjaxForSliderInit = true;
jQuery(document).ready(function () {
    let n = document.getElementById('m_nouislider_1_input');
    let e = document.getElementById('m_nouislider_1');

    CheckoutPaymentUi.refreshUi();

    $(document).on('click', '#btnSaveDiscountCodeValue', function () {
        CheckoutPaymentUi.attachCoupon();
    });

    $(document).on('click', '#btnRemoveDiscountCodeValue', function() {
        CheckoutPaymentUi.detachCoupon(true);
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

    noUiSlider.create(e, {
        start: [5],
        connect: [!0, !1],
        step: 1,
        range: {min: [1], max: [50]},
        format: wNumb({decimals: 0})
    });

    e.noUiSlider.on('update', function (e, t) {
        n.value = e[t];
        if (!lockDonateAjaxForSliderInit) {
            CheckoutPaymentUi.refreshUiBasedOnDonateStatus(n.value);
        }
        lockDonateAjaxForSliderInit = false;
    });

    n.addEventListener('change', function () {
        e.noUiSlider.set(this.value)
    });
});