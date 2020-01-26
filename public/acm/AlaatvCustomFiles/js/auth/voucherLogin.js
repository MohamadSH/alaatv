var InitPage = function () {

    var data = {
        login: {
            enable: false,
            loginActionUrl: '',
        },
        verifyMobile: {
            enable: false,
            sendVerificationCodeActionUrl: '',
            verifyActionUrl: '',
            verifyFormToken: '',
            isVerified: false
        },
        voucher: {
            enable: true,
            voucherActionUrl: '',
            voucherCode: ''
        },
        redirectUrl: '',
        user: {
            mobile: ''
        }
    };

    function showProperForm() {

        hideLoginForm();
        hideVoucherPageForm();

        if (!detectUserLogin() && data.login.enable) {
            showLoginForm();
            return;
        }

        if (!data.verifyMobile.isVerified && data.login.enable && data.verifyMobile.enable) {
            sendVerificationCode('.btnResendVerificationCode');
            showVerifyForm();
            return;
        }

        if (!data.voucher.enable) {
            window.location.href = (data.redirectUrl.trim().length > 0) ? data.redirectUrl : '/';
            return;
        }

        if (data.voucher.voucherCode.trim().length === 0) {
            showVoucherForm();
        } else {
            submitVoucherCode();
        }
    }

    function detectUserLogin() {
        return (GlobalJsVar.userId().length > 0);
    }

    function showVoucherForm() {

        $('.voucherPageFormWrapper').removeClass('d-none');
        $('.voucherPageFormWrapper .m-portlet__head-text').html('کد خود را وارد کنید: ');

        var validateForm = function(verifyVoucherForm) {

            var formData = verifyVoucherForm.getFormData(),
                status = true;

            if (formData.code.trim().length > 0) {
                verifyVoucherForm.inputFeedback('code', '', 'success');
            } else {
                status = false;
                verifyVoucherForm.inputFeedback('code', 'کد را وارد کنید', 'danger');
            }

            verifyVoucherForm.setAjaxData(formData);

            return status;
        };

        var verifyVoucherForm = $('.voucherPageForm').FormGenerator({
            ajax: {
                type: 'POST',
                url: data.voucher.voucherActionUrl,
                data: {
                    code: ''
                },
                accept: 'application/json; charset=utf-8',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                beforeSend: function () {
                    var status = validateForm(verifyVoucherForm);

                    if (status) {
                        AlaaLoading.show();
                    }

                    return status;
                },
                success: function (response) {
                    toastr.success('کد وارد شده معتبر است.');
                    applyGAEE(response.products);
                    window.location.href = data.redirectUrl;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    AlaaLoading.hide();
                    toastr.warning('کد معتبر نیست.');
                },
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            },
            inputData: [
                {
                    type: 'hidden',
                    name: '_token',
                    value: data.verifyMobile.verifyFormToken,
                },
                {
                    type: 'text',
                    name: 'code',
                    value: data.voucher.voucherCode,
                    placeholder: 'کد خود را وارد کنید',
                    label: 'کد',
                    iconsRight: '<i class="fa fa-ticket-alt"></i>',
                    id: 'voucherNumber'
                },
                {
                    type: 'sendAjax',
                    text: 'ثبت کد',
                    class: 'btn btn-primary',
                    id: null
                }
            ]
        });
    }

    function showVerifyForm() {

        $('.voucherPageFormWrapper').removeClass('d-none');
        $('.voucherPageFormWrapper .m-portlet__head-text').html('تایید شماره همراه: ' + data.user.mobile);

        var validateForm = function(verifyMobileForm) {

                var formData = verifyMobileForm.getFormData(),
                    status = true;

                if (formData.code.trim().length > 0) {
                    verifyMobileForm.inputFeedback('code', '', 'success');
                } else {
                    status = false;
                    verifyMobileForm.inputFeedback('code', 'کد تایید را وارد کنید', 'danger');
                }

                verifyMobileForm.setAjaxData(formData);

                return status;
            },
            verificationCode = function () {
                if ($('#verifyNumber').length === 1) {
                    return $('#verifyNumber').val().trim();
                } else {
                    return '';
                }
            };

        var verifyMobileForm = $('.voucherPageForm').FormGenerator({
            ajax: {
                type: 'POST',
                url: data.verifyMobile.verifyActionUrl,
                data: {
                    code: verificationCode
                },
                accept: 'application/json; charset=utf-8',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                beforeSend: function () {
                    var status = validateForm(verifyMobileForm);
                    if (status) {
                        AlaaLoading.show();
                    }

                    return status;
                },
                success: function (response) {
                    if (response.error) {
                        var message = response.error.message;
                        toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);
                    } else {
                        data.verifyMobile.isVerified = true;
                        AlaaLoading.hide();
                        toastr.success('شماره موبایل شما تایید شد.');
                        showProperForm();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    AlaaLoading.hide();
                    toastr.warning('خطایی رخ داده است.');
                },
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            },
            inputData: [
                {
                    type: 'hidden',
                    name: '_token',
                    value: data.verifyMobile.verifyFormToken,
                },
                {
                    type: 'text',
                    name: 'code',
                    placeholder: 'کد تایید شماره همراه',
                    label: 'کد تایید شماره همراه',
                    iconsRight: '<i class="fa fa-check-circle"></i>',
                    id: 'verifyNumber'
                },
                {
                    type: 'sendAjax',
                    text: 'تایید شماره همراه',
                    class: 'btn btn-primary',
                    id: null
                },
                {
                    type: 'btn',
                    text: 'ارسال مجدد کد',
                    class: 'btn btn-info btnResendVerificationCode',
                    id: null
                }
            ]
        });

        // validateForm(verifyMobileForm);
    }

    function showLoginForm() {
        showLoginModal();
        preventCloseLoginModal();
        showInitMessage();
    }

    function hideVoucherPageForm() {
        $('.voucherPageFormWrapper').addClass('d-none');
        cleanVoucherPageForm();
    }

    function hideLoginForm() {
        $('#AlaaAjaxLoginModal').off('hide.bs.modal');
        $('#AlaaAjaxLoginModal').modal('hide');
    }

    function cleanVoucherPageForm() {
        $('.voucherPageForm').html('');
    }

    function showLoginModal() {
        AjaxLogin.showLogin(data.login.loginActionUrl, function (response) {
            afterLogin(response);
        });
    }

    function afterLogin(response) {
        // ToDo: check response
        GlobalJsVar.setVar('userId', response.data.data.user.id);
        data.user.mobile = response.data.data.user.mobile;
        data.verifyMobile.isVerified = (typeof response.data.data.user.mobile_verified_at !== 'undefined' && response.data.data.user.mobile_verified_at !== null && response.data.data.user.mobile_verified_at !== '');
        showProperForm();
    }

    function preventCloseLoginModal() {
        $('#AlaaAjaxLoginModal').on('hide.bs.modal', function (e) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
    }

    function showInitMessage() {
        var $usernameObject = AjaxLogin.getUsernameObject(),
            $passwordObject = AjaxLogin.getPasswordObject(),
            userMessage = 'شماره همراه دانش آموز وارد شود.',
            passMessage = 'کد ملی دانش آموز وارد شود.';
        AjaxLogin.changeInputFeedback($usernameObject, userMessage, 'info');
        AjaxLogin.changeInputFeedback($passwordObject, passMessage, 'info');
    }

    function sendVerificationCode(btnSelector) {

        mApp.block(btnSelector, {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        $.ajax({
            type: 'GET',
            url: data.verifyMobile.sendVerificationCodeActionUrl,
            // dataType: 'text',
            dataType: 'json',
            data: {},
            success: function (response) {
                if (response.error) {
                    var message = response.error.message;
                    toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);
                } else {
                    toastr.info('کد تایید برای شماره همراه شما پیامک شد.');
                }
                mApp.unblock(btnSelector);
            },
            error: function (jqXHR, textStatus, errorThrown) {

                var message = '';
                if (jqXHR.status === 429) {
                    message = 'پیش از این کد فعال سازی برای شما ارسال شده است. یک دقیقه تا درخواست بعدی صبر کنید.';
                } else {
                    message = 'خطای سیستمی رخ داده است.';
                }

                toastr.warning(message);

                mApp.unblock(btnSelector);
            }
        });
    }

    function submitVoucherCode() {

        AlaaLoading.show();

        $.ajax({
            type: 'POST',
            url: data.voucher.voucherActionUrl,
            // dataType: 'text',
            dataType: 'json',
            data: {
                code: data.voucher.voucherCode
            },
            success: function (response) {
                toastr.success('کد وارد شده معتبر است.');
                applyGAEE(response.products);
                window.location.href = data.redirectUrl;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                hideLoginForm();
                hideVoucherPageForm();
                showVoucherForm();
                AlaaLoading.hide();
                toastr.warning('کد معتبر نیست.');
            },
        });
    }

    function initData(padeData) {
        data = $.extend(true, {}, data, padeData);
    }

    function applyGAEE(products) {
        var impressions = getProducts(products);
        GAEE.impressionView(impressions);
        GAEE.productAddToCart('product.addToCart', impressions);
    }

    function addEvents() {
        $(document).on('click', '.btnResendVerificationCode', function (e) {
            e.preventDefault();
            e.stopPropagation();
            sendVerificationCode('.btnResendVerificationCode');
        });
    }

    function priceToStringWithTwoDecimal(price) {
        return parseFloat((Math.round(price * 100) / 100).toString()).toFixed(2);
    }

    function getProducts(products) {
        var productsArray = [];
        for (var i = 0; (typeof products[i] !== 'undefined'); i++) {
            productsArray.push({
                id: products[i].id.toString(),      // (String) The SKU of the product. Example: 'P12345'
                name: products[i].name.toString(),    // (String) The name of the product. Example: 'T-Shirt'
                price: priceToStringWithTwoDecimal(products[i].price.final).toString(),
                brand: 'آلاء',   // (String) The brand name of the product. Example: 'NIKE'
                category: products[i].category.toString(),// (String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
                variant: (typeof products[i].variant !== 'undefined') ? products[i].variant.toString() : '-', // (String) What variant of the main product this is. Example: 'Large'
                quantity: 1,
            });
        }
        return productsArray;
    }

    function addToCartForGAEE(products) {

    }

    function init(padeData) {
        initData(padeData);
        showProperForm();
        addEvents();
    }

    return {
        init: init
    };
}();

jQuery(document).ready( function() {
    InitPage.init(padeData);
});
