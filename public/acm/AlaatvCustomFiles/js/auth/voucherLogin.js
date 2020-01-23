var InitPage = function() {

    var isVerified,
        voucherCode,
        productData,
        mobile,
        loginActionUrl,
        sendVerificationCodeActionUrl,
        verifyActionUrl,
        verifyFormToken,
        voucherActionUrl,
        userProductFilesUrl;

    function showProperForm() {

        hideLoginForm();
        hideVoucherPageForm();

        if (!detectUserLogin()) {
            showLoginForm();
            return;
        }

        if (!isVerified) {
            showVerifyForm();
            return;
        }

        if (voucherCode.trim().length === 0) {
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
                url: voucherActionUrl,
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
                success: function (data) {
                    toastr.success('کد وارد شده معتبر است.');
                    applyGAEE(data.products);
                    window.location.href = userProductFilesUrl;
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
                    value: verifyFormToken,
                },
                {
                    type: 'text',
                    name: 'code',
                    value: voucherCode,
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
        $('.voucherPageFormWrapper .m-portlet__head-text').html('تایید شماره همراه: ' + mobile);
        toastr.info('کد تایید برای شماره همراه شما پیامک شد.');

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
                url: verifyActionUrl,
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
                success: function (data) {
                    if (data.error) {
                        var message = data.error.message;
                        toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);
                    } else {
                        isVerified = true;
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
                    value: verifyFormToken,
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
        AjaxLogin.showLogin(loginActionUrl, function (response) {
            afterLogin(response);
        });
    }

    function afterLogin(response) {
        // ToDo: check response
        GlobalJsVar.setVar('userId', response.data.data.user.id);
        mobile = response.data.data.user.mobile;
        isVerified = (response.data.data.user.mobile_verified_at !== null && response.data.data.user.mobile_verified_at !== '');
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
            url: sendVerificationCodeActionUrl,
            // dataType: 'text',
            dataType: 'json',
            data: {},
            success: function (data) {
                if (data.error) {
                    var message = data.error.message;
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
            url: voucherActionUrl,
            // dataType: 'text',
            dataType: 'json',
            data: {
                code: voucherCode
            },
            success: function (data) {
                toastr.success('کد وارد شده معتبر است.');
                applyGAEE(data.products);
                window.location.href = userProductFilesUrl;
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
        mobile = padeData.mobile;
        isVerified = padeData.isVerified;
        productData = padeData.productData;
        voucherCode = padeData.voucherCode;
        loginActionUrl = padeData.loginActionUrl;
        verifyActionUrl = padeData.verifyActionUrl;
        verifyFormToken = padeData.verifyFormToken;
        voucherActionUrl = padeData.voucherActionUrl;
        userProductFilesUrl = padeData.userProductFilesUrl;
        sendVerificationCodeActionUrl = padeData.sendVerificationCodeActionUrl;
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
