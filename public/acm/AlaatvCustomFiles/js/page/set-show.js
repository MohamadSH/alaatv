var loadItems = function () {

    var perLoad = 5;

    function getVideoItem(data) {
        var badge = '<span class="m-badge m-badge--warning m-badge--wide">ویژه شما</span>';
        if (data.isFree === 1) {
            badge = '<span class="m-badge m-badge--accent m-badge--wide">رایگان</span>';
        }

        return Alist1.getItem({
            class: 'set_video_item',
            attr: 'data-section-id="' + data.section.id + '" data-section-name="' + data.section.name + '" data-item-order="' + data.order + '"',
            link: data.link,
            img: '<img class="img-fluid a--full-width lazy-image" width="453" height="254"  src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="' + data.photo + '" alt="' + data.name + '" data-container="body" data-toggle="m-tooltip" data-placement="top" title="دانلود یا تماشا فیلم">',
            title: data.name,
            info:
                '            \n' + badge +
                '            <span>|</span>\n' +
                '            <span class="a--list1__info-date m--font-info">آخرین به روز رسانی: ' + data.updatedAtJalali + '</span>\n' +
                '            <span>| آلاء</span>\n',
            desc: data.metaDescription + '...\n',
            action: '<button type="button" class="btn m-btn--pill  btn-primary btn-block"  onclick="window.location = \'' + data.link + '\';" data-container="body" data-toggle="m-tooltip" data-placement="top" title="دانلود یا تماشا فیلم"> <i class="fa fa-eye"></i> / <i class="fa fa-play"></i> </button>',
        });
    }

    function getPamphletsItem(data) {

        return Alist2.getItem({
            class: 'set_pamphlet_item',
            attr: 'data-section-id="' + data.section.id + '" data-section-name="' + data.section.name + '" data-item-order="' + data.order + '"',
            link: data.link,
            img:
                '            <svg width="50" height="50" viewBox="-79 0 512 512" xmlns="http://www.w3.org/2000/svg">\n' +
                '                <path d="m353.101562 485.515625h-353.101562v-485.515625h273.65625l79.445312 79.449219zm0 0" fill="#e3e4d8"/>\n' +
                '                <path d="m273.65625 0v79.449219h79.445312zm0 0" fill="#d0cebd"/>\n' +
                '                <path d="m0 353.101562h353.101562v158.898438h-353.101562zm0 0" fill="#b53438"/>\n' +
                '                <g fill="#fff">\n' +
                '                    <path d="m52.964844 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/>\n' +
                '                    <path d="m300.136719 397.242188h-52.964844c-4.871094 0-8.828125-3.957032-8.828125-8.828126 0-4.875 3.957031-8.828124 8.828125-8.828124h52.964844c4.875 0 8.828125 3.953124 8.828125 8.828124 0 4.871094-3.953125 8.828126-8.828125 8.828126zm0 0"/>\n' +
                '                    <path d="m300.136719 441.378906h-52.964844c-4.871094 0-8.828125-3.953125-8.828125-8.828125 0-4.871093 3.957031-8.828125 8.828125-8.828125h52.964844c4.875 0 8.828125 3.957032 8.828125 8.828125 0 4.875-3.953125 8.828125-8.828125 8.828125zm0 0"/>\n' +
                '                    <path d="m247.171875 485.515625c-4.871094 0-8.828125-3.953125-8.828125-8.824219v-88.277344c0-4.875 3.957031-8.828124 8.828125-8.828124 4.875 0 8.828125 3.953124 8.828125 8.828124v88.277344c0 4.871094-3.953125 8.824219-8.828125 8.824219zm0 0"/>\n' +
                '                </g>\n' +
                '                <path d="m170.203125 95.136719c-.863281.28125-11.695313 15.261719.847656 27.9375 8.351563-18.371094-.464843-28.054688-.847656-27.9375m5.34375 73.523437c-6.296875 21.496094-14.601563 44.703125-23.527344 65.710938 18.378907-7.042969 38.375-13.195313 57.140625-17.546875-11.871094-13.621094-23.738281-30.632813-33.613281-48.164063m65.710937 57.175782c7.167969 5.445312 8.914063 8.199218 13.613282 8.199218 2.054687 0 7.925781-.085937 10.636718-3.828125 1.316407-1.820312 1.828126-2.984375 2.019532-3.59375-1.074219-.574219-2.515625-1.710937-10.335938-1.710937-4.449218 0-10.027344.191406-15.933594.933594m-119.957031 38.601562c-18.804687 10.425781-26.464843 19-27.011719 23.835938-.089843.804687-.328124 2.90625 3.785157 6.011718 1.316406-.414062 8.96875-3.859375 23.226562-29.847656m-23.421875 44.527344c-3.0625 0-6-.980469-8.507812-2.832032-9.15625-6.796874-10.390625-14.347656-9.808594-19.492187 1.597656-14.132813 19.304688-28.945313 52.648438-44.03125 13.230468-28.636719 25.820312-63.921875 33.324218-93.398437-8.773437-18.871094-17.3125-43.351563-11.097656-57.714844 2.179688-5.03125 4.910156-8.894532 9.976562-10.566406 2.011719-.652344 7.078126-1.480469 8.941407-1.480469 4.617187 0 9.050781 5.507812 11.183593 9.089843 3.972657 6.648438 3.992188 14.390626 3.363282 21.859376-.609375 7.253906-1.84375 14.46875-3.265625 21.601562-1.039063 5.242188-2.214844 10.460938-3.46875 15.660156 11.855469 24.175782 28.644531 48.816406 44.746093 65.683594 11.539063-2.054688 21.460938-3.097656 29.546876-3.097656 13.761718 0 22.121093 3.167968 25.519531 9.691406 2.828125 5.402344 1.660156 11.726562-3.433594 18.769531-4.898437 6.769531-11.640625 10.34375-19.523437 10.34375-10.710938 0-23.15625-6.671875-37.050782-19.851562-24.957031 5.15625-54.097656 14.34375-77.65625 24.515625-7.355468 15.410156-14.398437 27.824218-20.964844 36.933594-8.996093 12.5-16.773437 18.316406-24.472656 18.316406" fill="#b53438"/>\n' +
                '                <path d="m79.449219 450.207031h-26.484375c-4.871094 0-8.828125-3.953125-8.828125-8.828125v-52.964844c0-4.875 3.957031-8.828124 8.828125-8.828124h26.484375c19.472656 0 35.308593 15.835937 35.308593 35.3125 0 19.472656-15.835937 35.308593-35.308593 35.308593zm-17.65625-17.65625h17.65625c9.734375 0 17.652343-7.917969 17.652343-17.652343 0-9.738282-7.917968-17.65625-17.652343-17.65625h-17.65625zm0 0" fill="#fff"/>\n' +
                '                <path d="m158.898438 485.515625h-8.828126c-4.875 0-8.828124-3.953125-8.828124-8.824219v-88.277344c0-4.875 3.953124-8.828124 8.828124-8.828124h8.828126c29.199218 0 52.964843 23.753906 52.964843 52.964843 0 29.210938-23.765625 52.964844-52.964843 52.964844zm0-17.652344h.085937zm0-70.621093v70.621093c19.472656 0 35.308593-15.839843 35.308593-35.3125 0-19.472656-15.835937-35.308593-35.308593-35.308593zm0 0" fill="#fff"/>\n' +
                '            </svg>\n',
            title: data.name,
            info: '',
            desc: '',
            action: ('<a href="'+data.link+'">' + ((parseInt(data.shouldPurchase) === 0) ? '<i class="fa fa-cloud-download-alt"></i>' : '<i class="fa fa-shopping-cart"></i>') + '</a>'),
        });
    }

    function loadMoreItem(items, type, loadAll) {
        for (var i = 0; ((loadAll || i < perLoad) && (typeof items[0] !== 'undefined')); i++) {
            if (type === 'video') {
                loadNewVideo(items[0]);
            } else if (type === 'pamphlet') {
                loadNewPamphlets(items[0]);
            }
            items.splice(0, 1);
        }
    }

    function loadNewVideo(data) {
        var itemHtmlData = getVideoItem(data);
        appendNewVideoItem(itemHtmlData);
    }

    function loadNewPamphlets(data) {
        var itemHtmlData = getPamphletsItem(data);
        appendNewPamphletItem(itemHtmlData);
    }

    function appendNewVideoItem(item) {
        $('.setVideo').append(item);
    }

    function appendNewPamphletItem(item) {
        $('.setPamphlet').append(item);
    }

    function addSensorItem(type) {
        var itemSensor = '<div class="itemSensor">\n' +
            '<div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div>\n' +
            '</div>';
        if (type === 'video') {
            appendNewVideoItem(itemSensor);
        } else if (type === 'pamphlet') {
            appendNewPamphletItem(itemSensor);
        }
    }

    function removeSensorItem(type) {
        if (type === 'video') {
            $('.setVideo .itemSensor').remove();
        } else if (type === 'pamphlet') {
            $('.setPamphlet .itemSensor').remove();
        }
    }

    function lazyLoadSensorItemVideo(videos) {
        LazyLoad.loadElementByQuerySelector('.setVideo .itemSensor', function () {
            removeSensorItem('video');
            loadMoreItem(videos, 'video', false);
            imageObserver.observe();
            if ((typeof videos[0] !== 'undefined')) {
                addSensorItem('video');
                lazyLoadSensorItemVideo(videos);
            }
        });
    }

    function lazyLoadSensorItemPamphlet(pamphlets) {
        LazyLoad.loadElementByQuerySelector('.setPamphlet .itemSensor', function () {
            removeSensorItem('pamphlet');
            loadMoreItem(pamphlets, 'pamphlet', false);
            imageObserver.observe();
            if ((typeof pamphlets[0] !== 'undefined')) {
                addSensorItem('pamphlet');
                lazyLoadSensorItemPamphlet(pamphlets);
            }
        });
    }

    function init(videos, pamphlets) {
        addSensorItem('video');
        addSensorItem('pamphlet');
        lazyLoadSensorItemVideo(videos);
        lazyLoadSensorItemPamphlet(pamphlets);
    }

    function showAll(videos, pamphlets) {
        if ((typeof videos[0] !== 'undefined')) {
            removeSensorItem('video');
            loadMoreItem(videos, 'video', true);
            imageObserver.observe();
        }
        if ((typeof pamphlets[0] !== 'undefined')) {
            removeSensorItem('pamphlet');
            loadMoreItem(pamphlets, 'pamphlet', true);
            imageObserver.observe();
        }
    }

    return {
        init: init,
        showAll: showAll,
    };

}();

var SwitchShowType = function() {

    function addEvents(videos, pamphlets) {
        $(document).on('click', '.setVideoPamphletTabs .nav-item .nav-link', function () {
            var href = $(this).attr('data-state');
            // UrlParameter.setHash(href, {tab:href});
            UrlParameter.setHash(href);
        });

        $(document).on('click', '#btnShowSectionView', function () {
            showSectionView(videos, pamphlets);
        });

        $(document).on('click', '#btnShowListView', function () {
            showListView();
        });
    }

    function iterateItems(itemClass, callback) {
        var items = document.getElementsByClassName('set_' + itemClass + '_item');
        for(var i=0; typeof(items[i])!='undefined'; i++) {
            callback(items[i]);
        }
    }

    function getSectionIds(itemClass) {
        var sectionIds = [];
        iterateItems(itemClass, function (item) {
            var sectionId = item.getAttribute('data-section-id');
            if (sectionId !== '') {
                sectionIds.push(sectionId);
            }
        });
        sectionIds = sectionIds.filter((x, i, a) => a.indexOf(x) == i)
        return sectionIds;
    }

    function getSections(itemClass) {
        var sectionIds = getSectionIds(itemClass),
            sections = {};

        iterateItems(itemClass, function (item) {
            var sectionId = item.getAttribute('data-section-id');
            if (sectionId !== '') {
                for(var i=0; typeof(sectionIds[i])!='undefined'; i++) {
                    if (sectionId === sectionIds[i]) {
                        if (typeof sections[sectionId] === 'undefined') {
                            sections[sectionId] = {
                                sectionName: item.getAttribute('data-section-name'),
                                listItems: [item]
                            };
                        } else {
                            sections[sectionId].listItems.push(item);
                        }
                    }
                }
            }
        });

        return sections;
    }

    function getAccordionItem(sectionName, key, type, items) {
        return '' +
            '<div class="m-accordion__item m-accordion__item--focus">\n' +
            '    <div class="m-accordion__item-head collapsed" srole="tab" id="m_accordion_'+type+'_item_'+key+'_head" data-toggle="collapse" href="#m_accordion_'+type+'_item_'+key+'_body" aria-expanded="false">\n' +
            '        <span class="m-accordion__item-icon"><i class="fa fa-folder-open"></i></span>\n' +
            '        <span class="m-accordion__item-title">' + sectionName + '</span>\n' +
            '        <span class="m-accordion__item-mode"></span>\n' +
            '    </div>\n' +
            '    <div class="m-accordion__item-body collapse" id="m_accordion_'+type+'_item_'+key+'_body" role="tabpanel" aria-labelledby="m_accordion_'+type+'_item_'+key+'_head" data-parent="#m_accordion_'+type+'">\n' +
            '        <div class="m-accordion__item-content">\n' +
            '           ' + items +
            '        </div>\n' +
            '    </div>\n' +
            '</div>';
    }

    function createSections(itemClass) {
        var sections = getSections(itemClass),
            sectionsHtml = '';

        for(var index in sections) {
            var itemsHtml = '',
                sectionName = sections[index].sectionName;
            for(var i=0; typeof(sections[index].listItems[i])!='undefined'; i++) {
                itemsHtml += sections[index].listItems[i].outerHTML;
            }
            sectionsHtml += getAccordionItem(sectionName, itemClass+'-'+index, itemClass, itemsHtml);
        }

        return sectionsHtml;
    }

    function getNotSegmentedItems(itemClass) {
        return $('.set_' + itemClass + '_item:not([data-section-id=""])');
    }

    function hideSectionItems(itemClass) {
        getNotSegmentedItems(itemClass).fadeOut(0);
    }

    function showSectionItems(itemClass) {
        getNotSegmentedItems(itemClass).fadeIn(0);
    }

    function showSectionApplyTab(type) {
        var sections = createSections(type);
        hideSectionItems(type);
        $('#m_accordion_'+type).html(sections);
    }

    function showSectionView(videos, pamphlets) {
        loadItems.showAll(videos, pamphlets);
        showSectionApplyTab('video');
        showSectionApplyTab('pamphlet');

        $('#btnShowSectionView').fadeOut(0, function () {
            $('#btnShowListView').css('display', 'inline-block');
        });
    }

    function showListApplyTab(type) {
        $('#m_accordion_'+type).html('');
        showSectionItems(type);
    }

    function showListView() {
        showListApplyTab('video');
        showListApplyTab('pamphlet');
        $('#btnShowListView').fadeOut(0, function () {
            $('#btnShowSectionView').css('display', 'inline-block');
        });
    }

    function checkShowSectionViewBtn(videos, pamphlets) {
        var i;
        for (i = 0; (typeof videos[i] !== 'undefined'); i++) {
            if (videos[i].section.id !== '') {
                $('#btnShowSectionView').css('display', 'inline-block');
                return true;
            }
        }
        for (i = 0; (typeof pamphlets[i] !== 'undefined'); i++) {
            if (pamphlets[i].section.id !== '') {
                $('#btnShowSectionView').css('display', 'inline-block');
                return true;
            }
        }
        return false;
        // if (getNotSegmentedItems('video').length > 0 || getNotSegmentedItems('pamphlet').length > 0) {
        //     $('#btnShowSectionView').css('display', 'inline-block');
        // }
    }

    function init(videos, pamphlets) {
        checkShowSectionViewBtn(videos, pamphlets);
        addEvents(videos, pamphlets);
    }

    return {
        init: init
    };

}();

var InitPage = function() {

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

    function addEvents() {
        $(document).on('click', '.setVideoPamphletTabs .nav-item .nav-link', function () {
            var href = $(this).attr('data-state');
            // UrlParameter.setHash(href, {tab:href});
            UrlParameter.setHash(href);
        });
    }

    function initSticky() {
        $('.rightSideAdBanner a').sticky({
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });
    }

    function init(videos, pamphlets) {
        showTabpageOnInitPage();
        loadItems.init(videos, pamphlets);
        addEvents();
        initSticky();
        SwitchShowType.init(videos, pamphlets);
    }

    return {
        init: init
    }

}();

jQuery(document).ready( function() {
    InitPage.init(videos, pamphlets);
});
