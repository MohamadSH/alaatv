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
        if ($('input[type="hidden"][name="js-var-'+key+'"]').length > 0) {
            return $('input[type="hidden"][name="js-var-'+key+'"]').val().trim();
        }
        return null;
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

    function setVar(key, value) {
        return $('input[type="hidden"][name="js-var-'+key+'"]').val(value);
    }


    return {
        userIp: userIp,
        userId: userId,
        loginActionUrl: loginActionUrl,
        favoriteActionUrl: favoriteActionUrl,
        unFavoriteActionUrl: unFavoriteActionUrl,
        getVar: getVar,
        setVar: setVar,
    };
}();
