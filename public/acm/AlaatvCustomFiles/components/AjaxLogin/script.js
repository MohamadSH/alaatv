var AjaxLogin = function () {

    var loginUrlAction;

    function ajaxSetup() {
        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
            }
        });
    }

    function getLoginUrlAction() {
        return loginUrlAction
    }

    function setLoginUrlAction(url) {
        loginUrlAction = url;
    }

    function getModalTemplate() {
        return '' +
            '<div class="modal" tabindex="-1" role="dialog" id="AlaaAjaxLoginModal">\n' +
            '  <div class="modal-dialog modal-dialog-centered" role="document">\n' +
            '    <div class="modal-content">\n' +
            '      <div class="modal-header">\n' +
            '        <h5 class="modal-title">ورود به آلاء</h5>\n' +
            '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
            '          <span aria-hidden="true">&times;</span>\n' +
            '        </button>\n' +
            '      </div>\n' +
            '      <div class="modal-body">\n' +
            'با کد ملی ایران نیازی به ثبت نام نیست.' +
            '        <br>' +
            '        <br>' +
                     getLoginTemplate() +
            '        <div class="AjaxLoginMessage"></div>' +
            '      </div>\n' +
            '      <div class="modal-footer">\n' +
            '        <button type="button" class="btn btn-lg m-btn--air btn-accent m-btn m-btn--custom AjaxLoginSubmit">ورود</button>\n' +
            '        <button type="button" class="btn btn-secondary d-none" data-dismiss="modal">انصراف</button>\n' +
            '      </div>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</div>';
    }

    function getLoginTemplate() {
        return '' +
            '<form class="m-login__form m-form" action="'+getLoginUrlAction()+'" method="post">' +
            '<div class="form-group m-form__group">\n' +
            '  <label>شماره موبایل: </label>\n' +
            '  <div class="m-input-icon m-input-icon--left m-input-icon--right">\n' +
            '    <input type="text" class="form-control m-input m-input--air" placeholder="09---------" name="mobile" autocomplete="off">\n' +
            '    <div class="form-control-feedback"></div>\n' +
            '    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-mobile-alt"></i></span></span>\n' +
            '  </div>\n' +
            '</div>' +
            '<div class="form-group m-form__group">\n' +
            '  <label>کد ملی: </label>\n' +
            '  <div class="m-input-icon m-input-icon--left m-input-icon--right">\n' +
            '    <input type="password" class="form-control m-input m-input--air" placeholder="----------" name="password">\n' +
            '    <div class="form-control-feedback"></div>\n' +
            '    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-lock"></i></span></span>\n' +
            '  </div>\n' +
            '</div>'+
            '</form>';
    }

    function checkExistLoginModal() {
        return ($('#AlaaAjaxLoginModal').length !== 0);
    }

    function appendLoginModalToBody() {
        $('body').append(getModalTemplate());
    }

    function showLoginModal() {
        hideMessage();
        $('#AlaaAjaxLoginModal').modal('show');
    }

    function getUsernameObject() {
        return $('#AlaaAjaxLoginModal input[name="mobile"]');
    }

    function getPasswordObject() {
        return $('#AlaaAjaxLoginModal input[name="password"]');
    }

    function changeInputFeedback($input, message) {
        if (message === '') {
            $input.parents('.form-group').removeClass('has-danger');
            $input.parents('.form-group').addClass('has-success');
        } else {
            $input.parents('.form-group').removeClass('has-success');
            $input.parents('.form-group').addClass('has-danger');
        }
        $input.parents('.form-group').find('.form-control-feedback').html(message);
    }

    function validateForm() {
        var usernameObject = getUsernameObject(),
            passwordObject = getPasswordObject(),
            status = true,
            message,
            regexMobile = RegExp('^09[0-9]{9}$'),
            regexMelliCode = RegExp('^\\d{10}$');

        if (usernameObject.val().trim().length === 0) {
            status = false;
            message = 'شماره همراه خود را وارد کنید.';
            changeInputFeedback(usernameObject, message);
        } else if (!regexMobile.test(usernameObject.val().trim())) {
            status = false;
            message = 'شماره همراه خود را به درستی وارد نکرده اید.';
            changeInputFeedback(usernameObject, message);
        } else {
            changeInputFeedback(usernameObject, '');
        }

        if (passwordObject.val().trim().length === 0) {
            status = false;
            message = 'کد ملی خود را وارد کنید.';
            changeInputFeedback(passwordObject, message);
        } else if (passwordObject.val().trim().length !== 10) {
            status = false;
            message = 'کد ملی می بایست ده رقم باشد.';
            changeInputFeedback(passwordObject, message);
        } else if (!regexMelliCode.test(passwordObject.val().trim())) {
            status = false;
            message = 'کد ملی خود را به درستی وارد نکرده اید.';
            changeInputFeedback(passwordObject, message);
        } else {
            changeInputFeedback(passwordObject, '');
        }

        return status
    }

    function showLoading() {
        mApp.block('#AlaaAjaxLoginModal .modal-content', {
            type: "loader",
            state: "success",
        });
    }

    function hideLoading() {
        mApp.unblock('#AlaaAjaxLoginModal .modal-content');
    }

    function ajaxLoginRequest(callbackOrRedirectLink, status) {

        hideMessage();
        showLoading();
        ajaxSetup();

        var usernameObject = getUsernameObject(),
            passwordObject = getPasswordObject();

        $.ajax({
            type: 'POST',
            url : getLoginUrlAction(),
            dataType: 'json',
            data: {
                mobile: getUsernameObject().val().trim(),
                password: getPasswordObject().val().trim(),
            },
            success: function (data) {
                hideLoading();
                showMessage('success', 'به آلاء خوش آمدید');
                changeInputFeedback(usernameObject, '');
                changeInputFeedback(passwordObject, '');
                if (typeof callbackOrRedirectLink === 'function') {
                    callbackOrRedirectLink({
                        data: data,
                        status: status
                    });
                } else if (typeof callbackOrRedirectLink === 'string') {
                    window.location.href = callbackOrRedirectLink;
                }
            },
            error: function (data) {

                var errors = data.responseJSON.errors; // An array with all errors.
                if(typeof errors.nationalCode !== 'undefined'){
                    changeInputFeedback(passwordObject, errors.nationalCode[0]);
                }
                if(typeof errors.mobile !== 'undefined'){
                    if (data.status === 422) {
                        changeInputFeedback(usernameObject, errors.mobile[0]);
                    } else {
                        showMessage('danger', errors.mobile[0]);
                    }
                }
                hideLoading();
            }

        });
    }

    function showMessage(status, message) {
        var template = '<div class="alert alert-'+status+'" role="alert"><strong>'+message+'</strong></div>';
        $('#AlaaAjaxLoginModal .AjaxLoginMessage').html(template);
    }

    function hideMessage() {
        $('#AlaaAjaxLoginModal .AjaxLoginMessage').html('');
    }

    function validateAndSendRequest(callbackOrRedirectLink) {
        if (validateForm() === true) {
            ajaxLoginRequest(callbackOrRedirectLink, 'LoginSubmit');
        }
    }

    return {
        showLogin: function (loginUrlAction, callbackOrRedirectLink) {
            setLoginUrlAction(loginUrlAction);
            if (!checkExistLoginModal()) {
                appendLoginModalToBody();
            }
            $(document).off('click', '#AlaaAjaxLoginModal .AjaxLoginSubmit').on('click', '#AlaaAjaxLoginModal .AjaxLoginSubmit', function () {
                validateAndSendRequest(callbackOrRedirectLink);
            });
            $(document).off('keypress', '#AlaaAjaxLoginModal input').on('keypress', '#AlaaAjaxLoginModal input', function () {
                validateAndSendRequest(callbackOrRedirectLink);
            });
            showLoginModal();
        },
        showLoginLoading: function (status, message) {
            showLoading();
            showMessage(status, message);
        },
    };
}();
