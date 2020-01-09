var InitPage = function() {

    function addEvents() {
        $(document).on('click', '.setVideoPamphletTabs .nav-item .nav-link', function () {
            var href = $(this).attr('data-state');
            // UrlParameter.setHash(href, {tab:href});
            UrlParameter.setHash(href);
        });

        $(window).on('popstate', function(e){
            // if (e.originalEvent.state !== null && typeof e.originalEvent.state.tab !== 'undefined') {
            //     showTabPage(e.originalEvent.state.tab);
            //     // UrlParameter.setHash(e.originalEvent.state.tab, {tab:e.originalEvent.state.tab});
            // }
            console.log('location', location);
            console.log('e.originalEvent.state', e.originalEvent.state);
        });
    }

    function showTabPage(dataState) {
        $('.setVideoPamphletTabs .nav .nav-item .nav-link').removeClass('active');
        $('.setVideoPamphletTabs .tab-content .tab-pane').removeClass('active');
        var tabId = $('.setVideoPamphletTabs .nav .nav-item .nav-link[data-state="'+dataState+'"]').addClass('active').attr('href');
        $(tabId).addClass('active');
    }

    function showTabpageOnInitPage() {

        var dataState = UrlParameter.getHash();
        if (dataState !== '') {
            showTabPage(dataState);
        } else {
            showTabPage('video');
        }
    }

    function initSticky() {
        $('.rightSideAdBanner a').sticky({
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });
    }

    function init() {
        showTabpageOnInitPage();
        addEvents();
        initSticky();
    }

    return {
        init: init
    }

}();

jQuery(document).ready( function() {
    InitPage.init();
});
