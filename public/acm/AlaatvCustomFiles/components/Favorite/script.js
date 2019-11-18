var Favorite = function () {

    var favoriteActionUrl,
        unFavoriteActionUrl;

    function ajaxRequest($btnObject, reload = false) {
        mApp.block('.btnFavorite', {
            // overlayColor: "#000000",
            type: "loader",
            state: "success",
        });
        if ($btnObject.hasClass('btnFavorite-off')) {
            actionUrl = favoriteActionUrl;
        } else if ($btnObject.hasClass('btnFavorite-on')) {
            actionUrl = unFavoriteActionUrl;
        }
        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: {},
            dataType: 'json',
            success: function (data) {
                if (typeof data === 'undefined' || data.error) {
                    toastr.error('خطای سیستمی رخ داده است.');
                } else {
                    if ($btnObject.hasClass('btnFavorite-off')) {
                        $('.btnFavorite-off').fadeOut(0);
                        $('.btnFavorite-on').fadeIn();
                        toastr.success('به علاقه مندی شما افزوده شد.');
                    } else if ($btnObject.hasClass('btnFavorite-on')) {
                        $('.btnFavorite-on').fadeOut(0);
                        $('.btnFavorite-off').fadeIn();
                        toastr.success('از علاقه مندی شما حذف شد.');
                    }
                }
                mApp.unblock('.btnFavorite');

                if (reload) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 401) {
                    message = 'ابتدا وارد شوید!';
                    toastr.warning(message);
                    AjaxLogin.showLogin(function (status) {
                        if (status === 'LoginSubmit') {
                            AjaxLogin.showLoginLoading('info', 'به آلاء خوش آمدید.<br>در حال ثبت علاقه مندی شما هستیم...');
                            ajaxRequest($btnObject, true);
                        }
                    });
                } else {
                    message = 'خطای سیستمی رخ داده است.';
                    toastr.error(message);
                }
                mApp.unblock('.btnFavorite');
            }
        });
    }

    return {
        init: function (favActionUrl, unFavActionUrl) {

            favoriteActionUrl = favActionUrl;
            unFavoriteActionUrl = unFavActionUrl;

            $(document).on('click', '.btnFavorite-on, .btnFavorite-off', function () {
                if (GlobalJsVar.userId().length > 0) {
                    ajaxRequest($(this));
                } else {
                    var $btnObject = $(this);
                    toastr.warning('ابتدا وارد شوید!');
                    AjaxLogin.showLogin(GlobalJsVar.loginActionUrl(), function (data) {
                        if (data.status === 'LoginSubmit') {
                            AjaxLogin.showLoginLoading('info', 'به آلاء خوش آمدید.<br>در حال ثبت علاقه مندی شما هستیم...');
                            ajaxRequest($btnObject, true);
                        }
                    });
                }
            });
        }
    };
}();
Favorite.init(GlobalJsVar.favoriteActionUrl(), GlobalJsVar.unFavoriteActionUrl());