var InitPage = function() {

    var isVerified,
        voucherCode,
        voucherIsChecked,
        voucherIsValid,
        productData,
        mobile,
        loginActionUrl,
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

        if (voucherCode.length.trim() === 0) {
            showVoucherForm();
            return;
        }

        initGAEE();
        addToCartForGAEE();
        window.location.href = userProductFilesUrl;
    }

    function detectUserLogin() {
        return (GlobalJsVar.userId().length > 0);
    }

    function showVoucherForm() {

        if (voucherIsChecked && !voucherIsValid) {
            toastr.warning('کد تخفیف معتبر نیست.');
        }

        $('.voucherPageFormWrapper').removeClass('d-none');
        $('.voucherPageFormWrapper .m-portlet__head-text').html('کد تخفیف خود را وارد کنید: ');

        var validateForm = function(verifyVoucherForm) {

            var formData = verifyVoucherForm.getFormData(),
                status = true;

            if (formData.voucherNumber.trim().length > 0) {
                verifyVoucherForm.inputFeedback('voucherNumber', '', 'success');
            } else {
                status = false;
                verifyVoucherForm.inputFeedback('voucherNumber', 'کد را وارد کنید', 'danger');
            }

            verifyVoucherForm.setAjaxData(formData);

            return status;
        };

        var verifyVoucherForm = $('.voucherPageForm').FormGenerator({
            ajax: {
                type: 'POST',
                url: voucherActionUrl,
                data: {},
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
                    // ToDo: check response
                    voucherIsChecked = true;
                    voucherCode = data.voucherCode;
                    voucherIsValid = data.voucherIsValid;
                    showProperForm();
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
                    name: 'voucherNumber',
                    value: voucherCode,
                    placeholder: 'کد تخفیف خود را وارد کنید',
                    label: 'کد تخفیف',
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

        validateForm(verifyMobileForm);
    }

    function showVerifyForm() {

        $('.voucherPageFormWrapper').removeClass('d-none');
        $('.voucherPageFormWrapper .m-portlet__head-text').html('تایید شماره همراه: ' + mobile);
        toastr.info('کد تایید برای شماره همراه شما پیامک شد.');

        var validateForm = function(verifyMobileForm) {

            var formData = verifyMobileForm.getFormData(),
                status = true;

            if (formData.verifyNumber.trim().length > 0) {
                verifyMobileForm.inputFeedback('verifyNumber', '', 'success');
            } else {
                status = false;
                verifyMobileForm.inputFeedback('verifyNumber', 'کد تایید را وارد کنید', 'danger');
            }

            verifyMobileForm.setAjaxData(formData);

            return status;
        };

        var verifyMobileForm = $('.voucherPageForm').FormGenerator({
            ajax: {
                type: 'POST',
                url: verifyActionUrl,
                data: {},
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
                    // ToDo: check response
                    isVerified = data.isVerified;
                    showProperForm();
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
                    name: 'verifyNumber',
                    value: $('#js-var-userData-name').val(),
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
                    text: 'ویرایش شماره همراه',
                    class: 'btn btn-info editPhoneNumber',
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
        GlobalJsVar.setVar('userId', response.data.user.id);
        mobile = response.data.user.mobile;
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
    }

    function initGAEE() {
        // ToDo: check products data structure
        GAEE.productDetailViews('product.show', productData.parentProduct);
        if (GAEE.reportGtmEecOnConsole()) {
            console.log('product.show', productData.parentProduct);
        }
    }

    function addEvents() {
        $(document).on('click', '.editPhoneNumber', function (e) {
            e.preventDefault();
            e.stopPropagation();
            GlobalJsVar.setVar('userId', '');
            showProperForm();
        });
    }

    function getSelectedProductObject() {
        return $('input[type=checkbox][name="products[]"]:checked').map(function () {
            if ($(this).val()) {
                return {
                    id: $(this).data('gtm-eec-product-id').toString(),      // (String) The SKU of the product. Example: 'P12345'
                    name: $(this).data('gtm-eec-product-name').toString(),    // (String) The name of the product. Example: 'T-Shirt'
                    price: $(this).data('gtm-eec-product-price').toString(),
                    brand: $(this).data('gtm-eec-product-brand').toString(),   // (String) The brand name of the product. Example: 'NIKE'
                    category: $(this).data('gtm-eec-product-category').toString(),// (String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
                    variant: $(this).data('gtm-eec-product-variant').toString(), // (String) What variant of the main product this is. Example: 'Large'
                    quantity: $(this).data('gtm-eec-product-quantity'),
                };
            }
        }).get();
    }

    function addToCartForGAEE() {
        // ToDo: check products data structure
        var product = productData.productId;
        var selectedProductObject = getSelectedProductObject();

        selectedProductObject.push(productData.parentProduct);
        TotalQuantityAddedToCart = selectedProductObject.length;
        GAEE.productAddToCart('product.addToCart', selectedProductObject);
        if (GAEE.reportGtmEecOnConsole()) {
            console.log('product.addToCart', selectedProductObject);
        }
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
