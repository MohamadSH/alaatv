var AlaaAdBanner = function () {

    function addEvents() {
        $(document).on('click', '.AlaadBanner', function () {
            setUserSeenBanner();
        });
    }

    function getImage(data) {
        var src = (mUtil.getViewPort().width > 1024) ? data.srcDeskTop : (mUtil.getViewPort().width > 600) ? data.srcTablet : data.srcMobile,
            width = (mUtil.getViewPort().width > 1024) ? data.widthDeskTop : (mUtil.getViewPort().width > 600) ? data.widthTablet : data.widthMobile,
            height = (mUtil.getViewPort().width > 1024) ? data.heightDeskTop : (mUtil.getViewPort().width > 600) ? data.heightTablet : data.heightMobile;
        return '<img class="lazy-image a--full-width" src="https://cdn.alaatv.com/loder.jpg?w='+width+'&h='+height+'"  data-src="'+src+'" alt="'+data.alt+'" width="'+width+'" height="'+height+'">';
    }

    function getLinkAttr(data) {
        var tooltip = getTooltipAttr(data.tooltip),
            gtmEec = getGtmEecAttr(data.gtmEec),
            link = ' href="'+data.link.href+'" target="'+data.link.target+'" class="AlaadBanner a--full-width" ';

        return link + tooltip + gtmEec;
    }

    function getTooltipAttr(data) {
        return '\n' +
            ' data-toggle="m-tooltip"' +
            ' data-placement="'+data.placement+'"' +
            ' data-original-title="'+data.title+'" ';
    }

    function getGtmEecAttr(data) {
        return '\n' +
            ' class="a--gtm-eec-advertisement a--gtm-eec-advertisement-click"\n' +
            ' data-gtm-eec-promotion-id="'+data.id+'"' +
            ' data-gtm-eec-promotion-name="'+data.name+'"\n' +
            ' data-gtm-eec-promotion-creative="'+data.creative+'"\n' +
            ' data-gtm-eec-promotion-position="'+data.position+'" ';
    }

    function getBanner(data) {
        return '<a '+getLinkAttr(data)+'">'+getImage(data.image)+'</a>';
    }

    function printBanner(data) {
        $('.m-body').prepend(getBanner(data));
        window.imageObserver.observe();
    }

    function isBannerExist() {
        return ($('a.AlaadBanner').length > 0);
    }

    function setUserSeenBanner() {
        localStorage.setItem('AlaaAdBanner-lastSeenTime', Date.now().toString());
    }

    function getUserLastSeenBannerTime() {
        return localStorage.getItem('AlaaAdBanner-lastSeenTime');
    }

    function getTimeElapsedSinceLastVisit() {
        var userLastSeenBannerTime = getUserLastSeenBannerTime(),
            diffTime = Date.now() - userLastSeenBannerTime;
        return diffTime;
    }

    function canShowBanner() {
        if (typeof getUserLastSeenBannerTime() === 'undefined') {
            return true;
        }

        var diffTime = getTimeElapsedSinceLastVisit(),
            diffTimeInDay = diffTime/(1000*60*60*24);
        return diffTimeInDay > 2;
    }

    function showBanner(data) {
        printBanner(data);
        addEvents();
    }

    function canBrowserSupportLocalStorage() {
        return typeof(Storage) !== "undefined";
    }

    function promote(data) {
        if (data === null) {
            return;
        }
        if (!canBrowserSupportLocalStorage()) {
            showBanner(data);
            return;
        }
        if (!canShowBanner()) {
            return;
        }
        if (!isBannerExist()) {
            showBanner(data);
        }
    }

    return {
        promote: promote
    };
}();
