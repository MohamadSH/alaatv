var AlaaLoading = function () {

    function appendLoading(selector = '') {
        var $selector = getSelectorObject(selector),
            loadingUrl = '';
        if (selector === '') {
            loadingUrl = '/acm/image/alaaLoading-small.gif';
        } else {
            loadingUrl = '/acm/image/alaaLoading.gif';
        }
        $selector.append('<div class="AlaaLoadingWrapper"><img src="'+loadingUrl+'"></div>');
    }
    function removeLoading(selector = '') {
        var $selector = getSelectorObject(selector);
        $selector.find('.AlaaLoadingWrapper').remove();
    }

    function getSelectorObject(selector) {
        var $selector;
        if (selector === '') {
            $selector = $('body');
        } else {
            $selector = $(selector);
        }
        return $selector;
    }

    return {
        show: function (selector) {
            removeLoading(selector);
            appendLoading(selector);
        },
        hide: function (selector) {
            removeLoading(selector);
        }
    };
}();