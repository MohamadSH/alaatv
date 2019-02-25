var CheckoutPaymentUi = function () {

    let totalCost = $('#invoiceInfo-totalCost').val();
    let couponCode = $('#invoiceInfo-couponCode').val();

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
        $('.face-sad').fadeOut(0);
        $('.face-happy').fadeIn(0);
        $('.visibleInDonate').css({'visibility': 'visible'});
    }

    function dontdonate() {
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
        } else {
            dontdonate();
            donateValue = 0;
        }
        let calcTotalCost = totalCost + (donateValue * 1000);
        $('.finalPriceValue').html(calcTotalCost.toLocaleString('fa'));
    }
    function setUiHasDiscountCode() {
        // $('.discountCodeValueWarper').fadeIn();
        $('.discountCodeValueWarperCover').fadeOut();
        $('#discountCodeValue').prop('disabled', false);
        $('#btnSaveDiscountCodeValue').prop('disabled', false);
        $('#discountCodeValue').prop('readonly', false);
        $('#btnSaveDiscountCodeValue').prop('readonly', false);
    }
    function setUiHasntDiscountCode() {
        // $('.discountCodeValueWarper').fadeOut();
        $('.discountCodeValueWarperCover').fadeIn();
        $('#discountCodeValue').prop('disabled', true);
        $('#btnSaveDiscountCodeValue').prop('disabled', true);
        $('#discountCodeValue').prop('readonly', true);
        $('#btnSaveDiscountCodeValue').prop('readonly', true);
    }
    function refreshUiBasedOnHasntDiscountCodeStatus() {
        $('#discountCodeValue').val(couponCode);
        if(!$('#hasntDiscountCode').prop('checked')) {
            setUiHasDiscountCode();
        } else {
            setUiHasntDiscountCode();
        }
    }

    return {
        refreshUi:function () {
            refreshUiBasedOnPaymentType();
            refreshUiBasedOnDonateStatus();
            refreshUiBasedOnHasntDiscountCodeStatus();
        },
        refreshUiBasedOnHasntDiscountCodeStatus:function () {
            refreshUiBasedOnHasntDiscountCodeStatus();
        },
        refreshUiBasedOnPaymentType:function () {
            refreshUiBasedOnPaymentType();
        },
        refreshUiBasedOnDonateStatus:function () {
            refreshUiBasedOnDonateStatus();
        },
    };
}();


jQuery(document).ready(function () {
    let n = document.getElementById('m_nouislider_1_input');
    let e = document.getElementById('m_nouislider_1');

    CheckoutPaymentUi.refreshUi();

    $(document).on('click', '#btnSaveDiscountCodeValue', function () {
        $.ajax({
            type: 'POST',
            url: $('#OrderController-submitCoupon').val(),
            data: {
            coupon: $('#discountCodeValue').val()
            },
            statusCode: {
                //The status for when action was successful
                200: function (response) {
                        console.log('submitCoupon: ' + response);
                        alert('hi!');
                        if (false) {
                            console.log('submitCoupon: '+response);

                            if (response.error) {

                                $('#btnRemoveDiscountCodeValue').fadeOut(0);
                                $('#btnSaveDiscountCodeValue').fadeIn();

                                $.notify(response.message, {
                                    type: 'danger',
                                    allow_dismiss: true,
                                    newest_on_top: false,
                                    mouse_over: false,
                                    showProgressbar: false,
                                    spacing: 10,
                                    timer: 2000,
                                    placement: {
                                        from: 'top',
                                        align: 'center'
                                    },
                                    offset: {
                                        x: 30,
                                        y: 30
                                    },
                                    delay: 1000,
                                    z_index: 10000,
                                    animate: {
                                        enter: "animated flip",
                                        exit: "animated hinge"
                                    }
                                });
                            } else {

                                $('#btnSaveDiscountCodeValue').fadeOut(0);
                                $('#btnRemoveDiscountCodeValue').fadeIn();

                                $.notify(response.message, {
                                    type: 'success',
                                    allow_dismiss: true,
                                    newest_on_top: false,
                                    mouse_over: false,
                                    showProgressbar: false,
                                    spacing: 10,
                                    timer: 2000,
                                    placement: {
                                        from: 'top',
                                        align: 'center'
                                    },
                                    offset: {
                                        x: 30,
                                        y: 30
                                    },
                                    delay: 1000,
                                    z_index: 10000,
                                    animate: {
                                        enter: "animated flip",
                                        exit: "animated hinge"
                                    }
                                });
                            }
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
                //Method Not Allowed
                405: function (response) {
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
                },
                //The status for when there is error php code
                503: function (response) {
                    // toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                }
            }
        });
    });

    $(document).on('click', '#btnRemoveDiscountCodeValue', function() {
        $.ajax({
            type: 'GET',
            url: $('#OrderController-removeCoupon').val(),
            data: {
                coupon: $('#discountCodeValue').val()
            },
        statusCode: {
            //The status for when action was successful
            200: function (response) {
                console.log('removeCoupon: '+response);

                if (response.error) {

                    $('#btnRemoveDiscountCodeValue').fadeIn();
                    $('#btnSaveDiscountCodeValue').fadeOut(0);

                    $.notify(response.message, {
                        type: 'danger',
                        allow_dismiss: true,
                        newest_on_top: false,
                        mouse_over: false,
                        showProgressbar: false,
                        spacing: 10,
                        timer: 2000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                        offset: {
                            x: 30,
                            y: 30
                        },
                        delay: 1000,
                        z_index: 10000,
                        animate: {
                            enter: "animated flip",
                            exit: "animated hinge"
                        }
                    });

                } else {

                    $('#btnRemoveDiscountCodeValue').fadeOut(0);
                    $('#btnSaveDiscountCodeValue').fadeIn();

                    $.notify(response.message, {
                        type: 'success',
                        allow_dismiss: true,
                        newest_on_top: false,
                        mouse_over: false,
                        showProgressbar: false,
                        spacing: 10,
                        timer: 2000,
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                        offset: {
                            x: 30,
                            y: 30
                        },
                        delay: 1000,
                        z_index: 10000,
                        animate: {
                            enter: "animated flip",
                            exit: "animated hinge"
                        }
                    });
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
            //Method Not Allowed
            405: function (response) {
//                        console.log(response);
//                        console.log(response.responseText);
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
                // toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
            }
        }
    });
    });

    $(document).on('change', 'input[type="radio"][name="radioPaymentType"]', function () {
        CheckoutPaymentUi.refreshUiBasedOnPaymentType();
    });

    $(document).on('switchChange.bootstrapSwitch', '#hasntDiscountCode', function () {
        CheckoutPaymentUi.refreshUiBasedOnHasntDiscountCodeStatus();
    });

    $(document).on('switchChange.bootstrapSwitch', '#hasntDonate', function () {
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
        CheckoutPaymentUi.refreshUiBasedOnDonateStatus(n.value);
    });

    n.addEventListener('change', function () {
        e.noUiSlider.set(this.value)
    });
});