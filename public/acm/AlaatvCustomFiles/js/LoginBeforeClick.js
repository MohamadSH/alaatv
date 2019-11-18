var LoginBeforeClick = function () {

    return {
        init: function () {
            $(document).on('click', '.LoginBeforeClick', function () {
                var userId = GlobalJsVar.userId(),
                    link = $(this).attr('data-href');
                if (userId.length > 0) {
                    window.location.href = link;
                } else {
                    AjaxLogin.showLogin(GlobalJsVar.loginActionUrl(), link);
                }
            });
        },
    };
}();
LoginBeforeClick.init();