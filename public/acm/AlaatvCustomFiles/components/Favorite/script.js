function getFavoriteActionUrl() {
    return getUrl('input[type="hidden"][name="favoriteActionUrl"]');
}
function getUnFavoriteActionUrl() {
    return getUrl('input[type="hidden"][name="unFavoriteActionUrl"]');
}

function getUrl(selector) {
    var url = $(selector).val();
    if (typeof url !== 'undefined') {
        return url;
    } else {
        return '';
    }
}

$(document).on('click', '.btnFavorite-on, .btnFavorite-off', function () {
    if ($(this).hasClass('btnFavorite-off')) {
        actionUrl = getFavoriteActionUrl();
    } else if ($(this).hasClass('btnFavorite-on')) {
        actionUrl = getUnFavoriteActionUrl();
    }
    mApp.block('.btnFavorite', {
        overlayColor: "#000000",
        type: "loader",
        state: "success",
    });
    $.ajax({
        type: 'POST',
        url: actionUrl,
        data: {},
        dataType: 'json',
        success: function (data) {
            if (typeof data === 'undefined' || data.error) {
                toastr.error('خطای سیستمی رخ داده است.');
            } else {
                toastr.success('علاقه مندی شما ثبت شد.');
                if ($(this).hasClass('btnFavorite-off')) {
                    $('.btnFavorite-off').fadeOut(0);
                    $('.btnFavorite-on').fadeIn();
                } else if ($(this).hasClass('btnFavorite-on')) {
                    $('.btnFavorite-on').fadeOut(0);
                    $('.btnFavorite-off').fadeIn();
                }
            }
            mApp.unblock('.btnFavorite');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            message = 'خطای سیستمی رخ داده است.';
            toastr.error(message);
            mApp.unblock('.btnFavorite');
        }
    });

});