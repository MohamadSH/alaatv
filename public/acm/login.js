//== Class Definition
var SnippetLogin = function() {

    var login = $('#m_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        mUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    };

    var showValidationError = function(div,msg){
        div.removeClass('has-danger');
        div.addClass('has-danger');
        var message = $('<div class = "form-control-feedback">' + msg + '</div>');
        div.find('.form-control-feedback').remove();
        message.appendTo(div);
        mUtil.animateClass(message[0], 'fadeIn animated');
    };

    var redirect = function (path) {
        // similar behavior as an HTTP redirect
        window.location.replace(path);
    };

    var handleSignInFormSubmit = function() {
        $('#m_login_signin_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            var mobileDiv = $('#m-login__form_mobile');
            var nCodeDiv = $('#m-login__form_code');

            form.validate({
                rules: {
                    mobile: {
                        required: true,
                    },
                    password: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            // btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            let $form = $('form.m-login__form');

            console.log('clicked');
            console.log('url: ', $form.attr('action'));
            mApp.block('#m_login_signin_submit', {
                type: "loader",
                state: "success",
            });

            $.ajax({
                type: $form.attr('method'),
                url : $form.attr('action'),
                dataType: 'json',
                data: {
                    mobile: $form.find('input[name="mobile"]').val(),
                    password: $form.find('input[name="password"]').val(),
                },
                success: function (data) {
                    console.log('success data: ', data);
                    setTimeout(function() {
                        mApp.unblock('#m_login_signin_submit');
                        if(data.status === 1){
                            redirect(data.redirectTo);
                        }
                    }, 2000);
                },
                error: function (data) {
                    console.log('error data: ', data);
                    // console.log(errors);
                    // similate 2s delay
                    setTimeout(function() {

                        mApp.unblock('#m_login_signin_submit');
                        // btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);

                        showErrorMsg(form, 'danger', 'خطا در ورود اطلاعات!');
                        // console.debug(errors.nationalCode);
                        var errors = data.responseJSON.errors; // An array with all errors.
                        if(typeof errors.nationalCode !== 'undefined'){
                            showValidationError(nCodeDiv,errors.nationalCode[0]);
                        }
                        if(typeof errors.mobile !== 'undefined'){
                            showValidationError(mobileDiv,errors.mobile[0]);
                        }
                    }, 2000);
                }

            });
        });
    };

    //== Public Functions
    return {
        // public functions
        init: function() {
            handleSignInFormSubmit();
        }
    };
}();

//== Class Initialization
jQuery(document).ready(function() {
    SnippetLogin.init();
});