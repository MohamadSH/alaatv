var AlaaLoading = function () {

    function appendLoading() {
        $('body').append('<div class="AlaaLoadingWrapper"><img src="acm/image/alaaLoading.gif"></div>');
    }
    function removeLoading() {
        $('.AlaaLoadingWrapper').remove();
    }


    return {
        show: function () {
            removeLoading();
            appendLoading();
        },
        hide: function () {
            removeLoading();
        }
    };
}();