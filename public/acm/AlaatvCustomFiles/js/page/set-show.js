var SwitchShowType = function() {

    function addEvents() {
        $(document).on('click', '.setVideoPamphletTabs .nav-item .nav-link', function () {
            var href = $(this).attr('data-state');
            // UrlParameter.setHash(href, {tab:href});
            UrlParameter.setHash(href);
        });

        $(document).on('click', '#btnShowSectionView', function () {
            showSectionView();
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

    function showSectionView() {
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

    function checkShowSectionViewBtn() {
        if (getNotSegmentedItems('video').length > 0 || getNotSegmentedItems('pamphlet').length > 0) {
            $('#btnShowSectionView').css('display', 'inline-block');
        }
    }


    function init() {
        checkShowSectionViewBtn();
        addEvents();
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

    function init() {
        showTabpageOnInitPage();
        addEvents();
        initSticky();
        SwitchShowType.init();
    }

    return {
        init: init
    }

}();

jQuery(document).ready( function() {
    InitPage.init();
});
