var GlobalJsVar = function () {

    function userIp() {
        return getVar('userIp');
    }

    function userId() {
        return getVar('userId');
    }

    function loginActionUrl() {
        return getVar('loginActionUrl');
    }

    function getVar(key) {
        return $('input[type="hidden"][name="js-var-'+key+'"]').val().trim();
    }

    function favoriteActionUrl() {
        return getUrl('input[type="hidden"][name="favoriteActionUrl"]');
    }

    function unFavoriteActionUrl() {
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


    return {
        userIp: userIp,
        userId: userId,
        loginActionUrl: loginActionUrl,
        favoriteActionUrl: favoriteActionUrl,
        unFavoriteActionUrl: unFavoriteActionUrl,
        getVar: getVar,
    };
}();
