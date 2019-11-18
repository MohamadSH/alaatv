var GlobalJsVar = function () {

    function userIp() {
        return $('#js-var-userIp').val().trim();
    }

    function userId() {
        return $('#js-var-userId').val().trim();
    }

    function loginActionUrl() {
        return $('#js-var-loginActionUrl').val().trim();
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
        userIp: function () {
            return userIp();
        },
        userId: function () {
            return userId();
        },
        loginActionUrl: function () {
            return loginActionUrl();
        },
        favoriteActionUrl: function () {
            return favoriteActionUrl();
        },
        unFavoriteActionUrl: function () {
            return unFavoriteActionUrl();
        },
    };
}();