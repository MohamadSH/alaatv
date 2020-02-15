var Alaasearch = function () {

    var videoRepository = [],
        productRepository = [],
        videoRepositoryCounter = 4,
        productRepositoryCounter = 1,
        carouselHasItem = true,
        listTypeHasItem = true,
        getAjaxContentErrorCounter = 0;

    function ajaxSetup() {
        $.ajaxSetup({
            cache: true,
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
            }
        });
    }

    function getAjaxContent(action, callback) {
        ajaxSetup();

        $.ajax({
                type: "GET",
                url: action,
                accept: "application/json; charset=utf-8",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    callback(data);
                    getAjaxContentErrorCounter = 0;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (getAjaxContentErrorCounter < 5) {
                        getAjaxContentErrorCounter++;
                        getAjaxContent(action, callback);
                    } else {
                        toastr.error('خطای سیستمی رخ داده است.');
                        window.location.reload();
                    }
                }
            }
        );
    }

    function loadAjaxContent(initContentData, paramsString) {
        if (typeof paramsString !== 'undefined') {
            UrlParameter.setParams(paramsString, {searchResult: initContentData, url: window.location.href, paramsString: paramsString});
        }
        TagManager.refreshPageTagsBadge();
        fillVideoRepositoryAndSetNextPage(initContentData.videos);
        fillProductRepositoryAndSetNextPage(initContentData.products);
        appendToCarouselTypeAndSetNextPage(initContentData.sets);
        appendToListType();
        checkToShowNotFoundMessage();
    }

    function appendToProduct() {
        var productRepositoryLength = productRepository.length,
            counter = 0;
        for(var i = 0; i < productRepositoryLength; i++) {
            if (productRepository[i] === null) {
                continue;
            }
            listTypeHasItem = true;
            $('.searchResult .listType').append(getProductItem(productRepository[i], i));
            productRepository[i] = null;
            counter++;
            if (counter === productRepositoryCounter) {
                counter = 0;
                break;
            }
        }
    }
    function appendToVideo() {
        var counter = 0;
        for(var i = 0; i < (typeof videoRepository[i] !== 'undefined'); i++) {
            if (videoRepository[i] === null) {
                continue;
            }
            listTypeHasItem = true;
            $('.searchResult .listType').append(getContentItem(videoRepository[i]));
            videoRepository[i] = null;
            counter++;
            if (counter === videoRepositoryCounter) {
                counter = 0;
                break;
            }
        }
    }
    function appendToSet(data, loadType) {
        $.each(data, function (index, value) {
            if (loadType === 'carouselType') {
                carouselHasItem = true;
                $('.searchResult .carouselType .ScrollCarousel .ScrollCarousel-Items').append(getSetCarouselItem(value));
            } else if (loadType === 'listType') {

            }
        });
    }

    function productItemAdapter(data) {
        return {
            gtmEecProductId: data.id,
            gtmEecProductName: data.title,
            // gtmEecProductCategory: ((data.category===null || data.category.trim().length===0)?'-':data.category), // *******************************************
            gtmEecProductCategory: 'gtmEecProductCategory',
            widgetActionLink: data.url.web,
            widgetPic: data.photo,
            widgetTitle: data.title,
            price: {
                base: data.price.base,
                discount: data.price.discount,
                final: data.price.final
            },
            // shortDescription: (data.shortDescription !== null) ? data.shortDescription : (data.longDescription !== null) ? data.longDescription : '', // *******
            shortDescription: 'shortDescription',
        };
    }
    function contentItemAdapter(data) {
        return {
            widgetPic: (typeof (data.photo) === 'undefined' || data.photo == null) ? data.thumbnail + '?w=444&h=250' : data.photo + '?w=444&h=250',
            widgetTitle: data.title,
            widgetLink: data.url.web,
            // description: data.description, // ******************************************************************************************************************
            description: 'description',
            videoOrder: data.order,
            // updatedAt: data.updated_at, // *********************************************************************************************************************
            updatedAt: '2020-01-02 10:23:14',
            // setName: (typeof data.set !== 'undefined') ? data.set.name : '-', // *******************************************************************************
            setName: 'setName',
            setUrl: 'setUrl'
        };
    }
    function setItemAdapter(data) {
        return {
            widgetPic: (typeof (data.photo) === 'undefined' || data.photo == null) ? data.thumbnail + '?w=253&h=142' : data.photo + '?w=253&h=142',
            widgetTitle: data.title,
            widgetAuthor: {
                photo : data.author.photo,
                name: data.author.first_name,
                full_name: data.author.first_name+ ' ' +data.author.last_name
            },
            widgetCount: data.contents_count,
            widgetLink: data.url.web
        };
    }

    function getSetCarouselItem(data) {

        var setItemData = setItemAdapter(data),
            loadingClass = (typeof data.loadingHtml !== 'undefined') ? 'loadingItem' : '';

        var htmlItemSet = '' +
            '<div class="item carousel a--block-item a--block-type-set ' + loadingClass + ' w-44333211">\n' +
            '    <div class="a--block-imageWrapper">\n' +
            '        \n' +
            '        <div class="a--block-detailesWrapper">\n' +
            '    \n' +
            '            <div class="a--block-set-count">\n' +
            '                <span class="a--block-set-count-number">' + setItemData.widgetCount + '</span>\n' +
            '                <br>\n' +
            '                <span class="a--block-set-count-title">محتوا</span>\n' +
            '                <br>\n' +
            '                <a href="' + setItemData.widgetLink + '" class="a--block-set-count-icon">\n' +
            '                    <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon">\n' +
            '                        <path d="M3.67 8.67h14V11h-14V8.67zm0-4.67h14v2.33h-14V4zm0 9.33H13v2.34H3.67v-2.34zm11.66 0v7l5.84-3.5-5.84-3.5z" class="style-scope yt-icon"></path>\n' +
            '                    </svg>\n' +
            '                </a>\n' +
            '            </div>\n' +
            '            \n' +
            '            <div class="a--block-set-author-pic">\n' +
            '                <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" class="lazy-image" data-src="' + setItemData.widgetAuthor.photo + '" alt="' + setItemData.widgetAuthor.full_name + '" width="40" height="40">\n' +
            '            </div>\n' +
            '            \n' +
            '    \n' +
            '        </div>\n' +
            '        \n' +
            '        <a href="' + setItemData.widgetLink + '" class="a--block-imageWrapper-image">\n' +
            (
                (typeof data.loadingHtml !== 'undefined') ?
                    data.loadingHtml
                    :
                    '            <img src="https://cdn.alaatv.com/loder.jpg?w=16&h=9" data-src="' + setItemData.widgetPic + '" alt="' + setItemData.widgetTitle + '" class="a--block-image lazy-image" width="453" height="254" />\n'
            )
            +
            '        </a>\n' +
            '    </div>\n' +
            '    \n' +
            '    <div class="a--block-infoWrapper">\n' +
            '        \n' +
            '        <div class="a--block-titleWrapper">\n' +
            '            <a href="' + setItemData.widgetLink + '" class="m-link">\n' +
            '                <span class="m-badge m-badge--info m-badge--dot"></span>\n' +
            '                ' + setItemData.widgetTitle + '\n' +
            '            </a>\n' +
            '        </div>\n' +
            '        \n' +
            '    </div>\n' +
            '    \n' +
            '</div>';

        return htmlItemSet;
    }
    function getListTypeItem(data) {
        return '\n' +
            '<div class="item '+data.class+'" '+data.itemGtm+'>\n' +
                    data.ribbon +
            '    <div class="pic">\n' +
                    data.widgetPic +
            '    </div>\n' +
            '    <div class="content">\n' +
            '        <div class="title">\n' +
            '            <h2>'+data.widgetTitle+'</h2>\n' +
            '        </div>\n' +
            '        <div class="detailes">\n' +
                        data.widgetDetailes +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="itemHover"></div>\n' +
            '</div>';
    }
    function getProductItem(data, itemKey) {
        var options = {
            TruncateLength: 80,
            TruncateBy : "words",
            Strict : false,
            StripHTML : true,
            Suffix : '...'
        };

        var productItemData = productItemAdapter(data);

        var price = productItemData.price,
            discount = Math.round((1 - (price.final / price.base)) * 100),
            discountRibbon = '',
            gtmEecProductVariant = '-',
            gtmEecProductPosition = itemKey,
            priceHtml = '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">';
        if (discount > 100) {
            discount = 100;
            price.final = 0;
        }

        if (price.base !== price.final) {
            priceHtml += '    <span class="m-badge m-badge--warning a--productRealPrice">' + price.base.toLocaleString('fa') + '</span>\n';
            priceHtml += '    <span class="m-badge m-badge--info a--productDiscount">' + discount + '%</span>\n';
            discountRibbon = '\n' +
                '        <div class="ribbon">\n' +
                '            <span>\n' +
                '                <div class="glow">&nbsp;</div>\n' +
                '                '+ discount +'%\n' +
                '                <span>تخفیف</span>\n' +
                '            </span>\n' +
                '        </div>';

        }
        priceHtml += '    ' + price.final.toLocaleString('fa') + ' تومان \n';
        priceHtml += '</span>';

        var gtmEec =
            '   data-gtm-eec-product-id="'+productItemData.gtmEecProductId+'"\n' +
            '   data-gtm-eec-product-name="'+productItemData.gtmEecProductName+'"\n' +
            '   data-gtm-eec-product-price="'+priceToStringWithTwoDecimal(price.final)+'"\n' +
            '   data-gtm-eec-product-brand="آلاء"\n' +
            '   data-gtm-eec-product-category="'+productItemData.gtmEecProductCategory+'"\n' +
            '   data-gtm-eec-product-variant="'+gtmEecProductVariant+'"\n' +
            '   data-gtm-eec-product-position="'+gtmEecProductPosition+'"\n' +
            '   data-gtm-eec-product-list="محصولات صفحه سرچ"\n';

        var itemData = {
            class: 'a--gtm-eec-product',
            widgetLink: productItemData.widgetActionLink,
            itemGtm:
                '     data-position="'+itemKey+'"\n ' + gtmEec,
            widgetPic: '<a href="' + productItemData.widgetActionLink + '"\n' +
                '   class="d-block a--gtm-eec-product-click"\n ' + gtmEec + ' >\n' +
                '    <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="'+productItemData.widgetPic+'" alt="'+productItemData.gtmEecProductName+'" class="a--full-width lazy-image productImage" width="400" height="400" />\n' +
                '</a>\n',
            widgetTitle:
                '<a href="' + productItemData.widgetActionLink + '"\n ' +
                '   class="m-link a--owl-carousel-type-2-item-subtitle a--gtm-eec-product-click"\n ' + gtmEec + ' >\n' +
                '    '+productItemData.widgetTitle+'\n' +
                '</a>\n',
            widgetDetailes: '' +
                '<div class="productPriceWrapper">' +
                priceHtml+
                '</div>'+
                '<div class="m--margin-top-40">' +
                truncatise(productItemData.shortDescription.replace(/<a .*>.*<\/a>/i, ''), options) +
                '</div>',
            ribbon: discountRibbon
        };
        return getListTypeItem(itemData);
    }
    function getContentItem(data) {
        var options = {
                TruncateLength: 40,
                TruncateBy: "words",
                Strict: false,
                StripHTML: true,
                Suffix: '...'
            },
            contentItemData = contentItemAdapter(data),
            videoOrderHtml = '<div class="videoOrder"><div class="videoOrder-title">جلسه</div><div class="videoOrder-number">' + contentItemData.videoOrder + '</div><div class="videoOrder-om"> اُم </div></div>',
            widgetDetailes = '' +
                '<div class="videoDetaileWrapper">' +
                '   <span><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" <g class="style-scope yt-icon">\n' +
                '        <path d="M3.67 8.67h14V11h-14V8.67zm0-4.67h14v2.33h-14V4zm0 9.33H13v2.34H3.67v-2.34zm11.66 0v7l5.84-3.5-5.84-3.5z" class="style-scope yt-icon"></path>\n' +
                '      </g></svg></span>' +
                '   <span> از دوره </span>' +
                '   <span>' + contentItemData.setName + '</span>' +
                '   <br>' +
                '   <i class="fa fa-calendar-alt m--margin-right-5"></i>' +
                '   <span>تاریخ بروزرسانی: </span>' +
                '   <span>' + new persianDate(new Date(contentItemData.updatedAt)).format('YYYY/MM/DD HH:mm:ss') + '</span>' +
                videoOrderHtml +
                '</div>' +
                '<div class="videoDescription">' + truncatise(contentItemData.description.replace(/<a .*>.*<\/a>/i, ''), options) + '</div>',
            itemData = {
                class: '',
                itemGtm: '',
                widgetLink: contentItemData.widgetLink,
                widgetPic:
                    '        <a href="' + contentItemData.widgetLink + '" class="d-block">\n' +
                    '            <img src="https://cdn.alaatv.com/loder.jpg?w=16&h=9" data-src="' + contentItemData.widgetPic + '" alt="' + contentItemData.widgetTitle + '" class="a--full-width lazy-image videoImage" width="253" height="142" />\n' +
                    '        </a>\n',
                widgetTitle:
                    '<a href="' + contentItemData.widgetLink + '" class="m-link">\n' +
                    '    ' + contentItemData.widgetTitle + '\n' +
                    '</a>\n',
                widgetDetailes: widgetDetailes,
                ribbon: ''
            };

        return getListTypeItem(itemData);
    }

    function addLoadingItem(itemType) {
        var loadingHtml = '<div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div>';
        if (itemType === 'carouselType') {
            $('.searchResult .carouselType .ScrollCarousel .ScrollCarousel-Items').append('<div class="item loadingItem w-44333211">\n' + loadingHtml + '</div>');
        } else if (itemType === 'listType') {
            $('.searchResult .listType').append('\n' +
                '<div class="item loadingItem">\n' +
                '    <div class="pic">\n' +
                '        <i class="fa fa-image"></i>' +
                '    </div>\n' +
                '    <div class="content">\n' +
                        loadingHtml +
                '    </div>\n' +
                '</div>');
        }
    }
    function removeLoadingItem(itemType) {
        if (itemType === 'carouselType') {
            $('.searchResult .carouselType .ScrollCarousel .ScrollCarousel-Items .loadingItem').remove();
        } else if (itemType === 'listType') {
            $('.searchResult .listType .loadingItem').remove();
        }
    }

    function clearCarousel() {
        $('.searchResult .carouselType .ScrollCarousel .ScrollCarousel-Items .item').remove();
    }
    function clearListType() {
        $('.searchResult .listType .item').remove();
    }
    function clearRepositories() {
        videoRepository = [];
        productRepository = [];
    }
    function cleatAllItems() {
        hideNotFoundMessage();
        clearRepositories();
        clearCarousel();
        clearListType();
        carouselHasItem = false;
        listTypeHasItem = false;
    }

    function addSensorItem(itemType) {
        var sensorHtml = '<div class="item sensorItem" style="width: 1px;height: 1px;"></div>',
            sensorPosition = 0;

        if (itemType === 'carouselType') {
            sensorPosition = getCarouselChildCount() - 3;
            if (sensorPosition < 3) {
                sensorPosition = 3;
            }
            $('.searchResult .carouselType .ScrollCarousel .ScrollCarousel-Items > .item:nth-child('+sensorPosition+')').after(sensorHtml);
            lazyLoadSensorItemCarousel();
        } else if (itemType === 'listType') {
            sensorPosition = getListTypeChildCount() - 3;
            if (sensorPosition < 3) {
                sensorPosition = 3;
            }
            $('.searchResult .listType>.item:nth-child('+sensorPosition+')').after(sensorHtml);
            lazyLoadSensorItemListType();
        }
    }
    function removeSensorItem(itemType) {
        if (itemType === 'carouselType') {
            $('.searchResult .carouselType .ScrollCarousel .ScrollCarousel-Items .sensorItem').remove();
        } else if (itemType === 'listType') {
            $('.searchResult .listType .sensorItem').remove();
        }
    }

    function setNextPageUrl(type, url) {
        // type : set - product - video
        $('.searchResult .InputOfAllNextPageUrl .nextPageUrl-'+type).val(url);
    }
    function getNextPageUrl(type) {
        // type : set - product - video
        return $('.searchResult .InputOfAllNextPageUrl .nextPageUrl-'+type).val();
    }

    function loadDataBasedOnNewFilter(contentSearchApi, paramsString) {
        cleatAllItems();
        addLoadingItem('carouselType');
        addLoadingItem('listType');
        // mApp.block('.SearchBoxFilter .GroupFilters .body', {
        //     type: "loader",
        //     state: "success",
        // });

        var urlAction = contentSearchApi + '?' + paramsString;
        AlaaLoading.show();
        getAjaxContent(urlAction, function (response) {
            // loadAjaxContent(response.result, paramsString);
            loadAjaxContent(response.data, paramsString);
            // mApp.unblock('.SearchBoxFilter .GroupFilters .body');
            AlaaLoading.hide();
        });
    }

    function loadNewDataBasedOnData(data) {
        cleatAllItems();
        addLoadingItem('carouselType');
        addLoadingItem('listType');
        loadAjaxContent(data);
        // mApp.unblock('.SearchBoxFilter .GroupFilters .body');
        AlaaLoading.hide();
    }

    function fetchNewCarousel() {
        var nextPageUrl = getNextPageUrl('set');
        if (nextPageUrl !== null && nextPageUrl.length > 0) {
            addLoadingItem('carouselType');
            getAjaxContent(nextPageUrl, function (response) {
                appendToCarouselTypeAndSetNextPage(response.result.sets);
            });
        }
        removeSensorItem('carouselType');
    }
    function fetchNewVideo(callback) {
        var nextPageUrlVideo = getNextPageUrl('video');
        if (nextPageUrlVideo !== null && nextPageUrlVideo.length > 0) {
            addLoadingItem('listType');
            getAjaxContent(nextPageUrlVideo, function (response) {
                fillVideoRepositoryAndSetNextPage(response.result.videos);
                callback();
            });
        }
    }
    function fetchNewProduct(callback) {
        var nextPageUrlProduct = getNextPageUrl('product');
        if (nextPageUrlProduct !== null && nextPageUrlProduct.length > 0) {
            getAjaxContent(nextPageUrlProduct, function (response) {
                fillProductRepositoryAndSetNextPage(response.result.products);
                callback();
            });
        }
    }

    function appendToListType() {
        removeSensorItem('listType');
        removeLoadingItem('listType');
        appendToVideo();
        appendToProduct();
        addSensorItem('listType');
        imageObserver.observe();
        gtmEecProductObserver.observe();
    }
    function appendToCarouselTypeAndSetNextPage(data) {
        removeLoadingItem('carouselType');
        if (typeof data !== 'undefined' && data !== null && data.meta.total>0) {
            appendToSet(data.data, 'carouselType');
            addSensorItem('carouselType');
            setNextPageUrl('set', data.links.next);
        } else {
            setNextPageUrl('set', '');
        }
        imageObserver.observe();
    }
    function checkToShowNotFoundMessage() {
        if (!carouselHasItem && !listTypeHasItem) {
            showNotFoundMessage();
        } else {
            hideNotFoundMessage();
        }
    }
    function showNotFoundMessage() {
        $('.notFoundMessage').fadeIn();
    }
    function hideNotFoundMessage() {
        $('.notFoundMessage').fadeOut();
    }

    function priceToStringWithTwoDecimal(price) {
        return parseFloat((Math.round(price * 100) / 100).toString()).toFixed(2);
    }

    function getRemainVideoRepository() {
        var videoRepositoryLength = videoRepository.length,
            counter = 0;
        for(var i = 0; i < videoRepositoryLength; i++) {
            if (videoRepository[i] === null) {
                continue;
            }
            counter++;
        }
        return counter;
    }
    function getRemainProductRepository() {
        var productRepositoryLength = productRepository.length,
            counter = 0;
        for(var i = 0; i < productRepositoryLength; i++) {
            if (productRepository[i] === null) {
                continue;
            }
            counter++;
        }
        return counter;
    }

    function fillProductRepository(data) {
        productRepository = productRepository.concat(data);
    }
    function fillVideoRepository(data) {
        videoRepository = videoRepository.concat(data);
    }

    function fillProductRepositoryAndSetNextPage(data) {
        if (typeof data !== 'undefined' && data !== null && data.meta.total>0) {
            fillProductRepository(data.data);
            setNextPageUrl('product', data.links.next);
        } else {
            setNextPageUrl('product', '');
        }
    }
    function fillVideoRepositoryAndSetNextPage(data) {
        if (typeof data !== 'undefined' && data !== null && data.meta.total > 0) {
            fillVideoRepository(data.data);
            setNextPageUrl('video', data.links.next);
        } else {
            setNextPageUrl('video', '');
        }
    }

    function updateListType() {
        if (getRemainProductRepository() < 10) {
            fetchNewProduct(function () {});
        }

        if (getRemainVideoRepository() < 15) {
            fetchNewVideo(function () {
                appendToListType();
            });
        } else {
            appendToListType();
        }
    }

    function lazyLoadSensorItemListType() {
        LazyLoad.loadElementByQuerySelector('.searchResult .listType .sensorItem', function () {
            updateListType();
        });
    }
    function lazyLoadSensorItemCarousel() {
        LazyLoad.loadElementByQuerySelector('.searchResult .carouselType .ScrollCarousel .ScrollCarousel-Items .sensorItem', function () {
            fetchNewCarousel();
        });
    }

    function getInputOfNextPageUrlProduct() {
        return '<input type="hidden" value="" class="nextPageUrl-product">';
    }
    function getInputOfNextPageUrlVideo() {
        return '<input type="hidden" value="" class="nextPageUrl-video">';
    }
    function getInputOfNextPageUrlSet() {
        return '<input type="hidden" value="" class="nextPageUrl-set">';
    }
    function getInputOfAllNextPageUrl() {
        return '<div class="InputOfAllNextPageUrl d-none">'+getInputOfNextPageUrlProduct()+getInputOfNextPageUrlVideo()+getInputOfNextPageUrlSet()+'</div>';
    }

    function getCarouselChildCount() {
        return $('.searchResult .carouselType .ScrollCarousel .ScrollCarousel-Items > .item').length;
    }
    function getListTypeChildCount() {
        return $('.searchResult .listType>.item').length;
    }

    function addEvents() {
        $(window).on('popstate', function(e){
            if (e.originalEvent.state !== null) {
                var urlTags = TagManager.convertParamsStringToArray(decodeURIComponent(e.originalEvent.state.paramsString));
                FilterOptions.checkFilterBasedOnUrlTags(urlTags);
                FilterOptions.sortSelectedItems();
                Alaasearch.loadNewDataBasedOnData(e.originalEvent.state.searchResult);
            }
            // console.log('location', location);
            // console.log('e.originalEvent.state', e.originalEvent.state);
        });
    }

    return {
        init: function (initContentData) {
            cleatAllItems();
            $('.searchResult').append(getInputOfAllNextPageUrl());
            loadAjaxContent(initContentData, window.location.search.substring(1));
            addEvents();
        },
        loadDataBasedOnNewFilter: loadDataBasedOnNewFilter,
        loadNewDataBasedOnData: loadNewDataBasedOnData
    }
}();

var TagManager = function () {

    function refreshUrlBasedOnSelectedTags() {
        var selectedItems = FilterOptions.getSelectedItemsInArray(),
            pageTagsListBadge = '.pageTags .m-list-badge__items',
            paramsString = '';
        $(pageTagsListBadge).find('.m-list-badge__item').remove();

        for (var index in selectedItems) {
            var selectedText = selectedItems[index];
            if (typeof selectedText !== 'undefined' && selectedText !== null && selectedText !== '') {
                paramsString += 'tags[]=' + selectedText + '&';
            }
        }

        if (paramsString.length > 0) {
            paramsString = paramsString.substring(0, paramsString.length - 1);
        }

        return paramsString;
    }

    function refreshPageTagsBadge() {
        var tags = FilterOptions.getSelectedItemsInArray();
        var tagsLength = tags.length;
        $('.pageTags .m-badge').remove();
        if(tagsLength === 0) {
            $('.pageTags').fadeOut();
        } else {
            $('.pageTags').fadeIn();
            for(var i = 0; i < tagsLength; i++) {
                $('.pageTags .m-list-badge').append(getBadgeHtml(tags[i]));
            }
        }
    }

    function getBadgeHtml(tagValue) {
        var badgeName = tagValue.split('_').join(' '),
            badgeValue = tagValue;
        return '' +
            '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-left-10 tag_0">' +
            '    <a class="removeTagLabel m--padding-right-10"><i class="fa fa-times"></i></a>' +
            '    <a class="m-link m--font-light" href="http://192.168.5.30/c?tags[0]='+badgeValue+'">' +
            '        '+badgeName+'' +
            '    </a>' +
            '    <input class="m--hide" name="tags[]" type="hidden" value="'+badgeValue+'">' +
            '</span>';
    }

    function addTagBadgeEvents(callback) {
        $(document).on('click', '.removeTagLabel', function() {
            var itemValue = $(this).parents('.m-badge').find('input[type="hidden"][name="tags[]"]').val();
            FilterOptions.uncheckItem(itemValue);
            callback();
        });
    }

    function convertParamsStringToArray(paramsString) {
        var paramsArray = paramsString.split('&'),
            paramsArrayLength = paramsArray.length;
        for (var i = 0; i < paramsArrayLength; i++) {
            var item = paramsArray[i].split('=');
            paramsArray[i] = item[1].replace(/ /g, '_');
        }
        return paramsArray;
    }

    return {
        refreshUrlBasedOnSelectedTags: refreshUrlBasedOnSelectedTags,
        refreshPageTagsBadge: refreshPageTagsBadge,
        addTagBadgeEvents: addTagBadgeEvents,
        convertParamsStringToArray: convertParamsStringToArray,
    };
}();

var FilterOptions = function () {

    var contentSearchFilterData = {};

    function getFilterOption(data) {

        return '' +
            '<div class="GroupFilters-item">\n' +
            '    <div class="pretty p-icon p-plain p-toggle">\n' +
            '        <input type="checkbox" value="'+data.value+'" />\n' +
            '        <div class="state p-on">\n' +
            '            <svg version="1.1" width="25" height="25" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 341.1 341.8" style="enable-background:new 0 0 341.1 341.8;" xml:space="preserve">\n' +
            '<style type="text/css">\n' +
            '\t.st0{fill:#FF9000;}\n' +
            '\t.st1{opacity:0.2;}\n' +
            '\t.st2{fill:#FFFFFF;}\n' +
            '</style>\n' +
            '<sodipodi:namedview bordercolor="#666666" borderopacity="1.0" id="base" inkscape:current-layer="layer1" inkscape:cx="100" inkscape:cy="560" inkscape:document-units="mm" inkscape:pageopacity="0.0" inkscape:pageshadow="2" inkscape:window-height="1017" inkscape:window-maximized="1" inkscape:window-width="1920" inkscape:window-x="-8" inkscape:window-y="-8" inkscape:zoom="0.35" pagecolor="#ffffff" showgrid="false">\n' +
            '\t</sodipodi:namedview>\n' +
            '<g id="layer1" inkscape:groupmode="layer" inkscape:label="Layer 1">\n' +
            '\t<g id="g74" transform="matrix(0.26458333,0,0,0.26458333,7.7861212,7.6966924)">\n' +
            '\t\t<path id="path10" inkscape:connector-curvature="0" class="st0" d="M1119.1,1141.9c-197.5,161.3-814.4,161.3-1007.9,0    c-197.5-161.3-177.4-850.6,0-1032.1s830.5-181.4,1007.9,0S1316.7,980.6,1119.1,1141.9z"/>\n' +
            '\t\t<g id="g14" class="st1">\n' +
            '\t\t\t<path id="path12" inkscape:connector-curvature="0" class="st2" d="M619.2,859.7c-177.4,141.1-374.9,213.7-560.4,217.7     C-78.2,843.6-50,275.1,111.3,109.8C256.4-39.3,712-67.5,974,25.2C1038.5,291.3,905.5,629.9,619.2,859.7L619.2,859.7z"/>\n' +
            '\t\t</g>\n' +
            '\t\t<path id="path16" inkscape:connector-curvature="0" class="st2" d="M441.7,1157.1c-39.2,0-78.4-16.8-100.8-50.4L27.2,703.3    c-44.8-56-33.6-134.4,22.4-179.3s134.4-33.6,179.3,22.4l212.9,274.5l470.6-610.6c44.8-56,123.2-67.2,179.3-22.4    s67.2,123.2,22.4,179.3l-571.4,739.5C514.6,1134.7,481,1157.1,441.7,1157.1z"/>\n' +
            '\t</g>\n' +
            '</g>\n' +
            '</svg>\n' +
            '            <label>'+data.name+'</label>\n' +
            '        </div>\n' +
            '        <div class="state p-off">\n' +
            '            <svg version="1.1" width="25" height="25" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 341.1 341.6" style="enable-background:new 0 0 341.1 341.6;" xml:space="preserve">\n' +
            '<style type="text/css">\n' +
            '\t.st0{fill:#FF9000;}\n' +
            '\t.st1{opacity:0.2;}\n' +
            '\t.st2{fill:#FFFFFF;}\n' +
            '</style>\n' +
            '<sodipodi:namedview bordercolor="#666666" borderopacity="1.0" id="base" inkscape:current-layer="g26" inkscape:cx="784.15556" inkscape:cy="394.26437" inkscape:document-units="mm" inkscape:pageopacity="0.0" inkscape:pageshadow="2" inkscape:window-height="1017" inkscape:window-maximized="1" inkscape:window-width="1920" inkscape:window-x="-8" inkscape:window-y="-8" inkscape:zoom="0.7" pagecolor="#ffffff" scale-x="0.9" showgrid="false">\n' +
            '\t</sodipodi:namedview>\n' +
            '<g id="layer1" inkscape:groupmode="layer" inkscape:label="Layer 1">\n' +
            '\t<g id="g26" transform="matrix(0.26458333,0,0,0.26458333,51.253383,19.413955)">\n' +
            '\t\t<path id="path10" inkscape:connector-curvature="0" class="st0" d="M954.9,1096.7c-197.5,161.3-814.4,161.3-1007.9,0    C-250.6,935.4-230.4,246-53,64.6s830.5-181.4,1007.9,0S1152.4,935.4,954.9,1096.7z"/>\n' +
            '\t\t<g id="g14" transform="translate(-192.85715,594.28572)" class="st1">\n' +
            '\t\t\t<path id="path12" inkscape:connector-curvature="0" class="st2" d="M647.8,220.2C470.4,361.3,272.9,433.8,87.4,437.9     C-49.6,204-21.4-364.4,139.8-529.7c145.1-149.2,600.7-177.4,862.7-84.7C1067.1-348.3,934.1-9.6,647.8,220.2L647.8,220.2z"/>\n' +
            '\t\t</g>\n' +
            '\t\t<path id="path10-0" inkscape:connector-curvature="0" class="st2" d="M840.1,963.3C690.7,1085,224.3,1085,78,963.3    c-149.4-121.7-134.1-642.1,0-779s628-136.9,762.1,0S989.4,841.6,840.1,963.3z"/>\n' +
            '\t</g>\n' +
            '</g>\n' +
            '</svg>\n' +
            '            <label>'+data.name+'</label>\n' +
            '        </div>\n' +
            '    </div>\n'+
            '</div>\n';

        // return '\n' +
        //     '<div class="GroupFilters-item">\n' +
        //     '    <label class="m-checkbox m-checkbox--bold m-checkbox--state-warning">\n' +
        //     '        <input type="checkbox" value="'+data.value+'"> '+data.name+'\n' +
        //     '        <span></span>\n' +
        //     '    </label>\n'+
        //     '</div>\n';
    }

    function createFieldsOfGroupOptions(data) {
        var dataLength = data.length,
            optionsHtml = '';
        for (var i = 0; i < dataLength; i++) {
            optionsHtml += getFilterOption({
                name: (typeof data[i].name !== 'undefined') ? data[i].name.split('_').join(' ') : data[i].value.split('_').join(' '),
                value: data[i].value.split(' ').join('_')
            });
        }
        return optionsHtml;
    }

    function getGroupFilters(data) {

        var openStatus = (typeof data.openStatus !== 'undefined' && data.openStatus) ? 'status-open' : 'status-close',
            moreCounter = (typeof data.moreCounter !== 'undefined') ? data.moreCounter : 0,
            searchTool = (typeof data.searchTool !== 'undefined' && data.searchTool) ?
            '            <div class="m-input-icon m-input-icon--left m-input-icon--right">\n' +
            '                <input type="text" class="form-control m-input GroupFilters-Search" placeholder="جستجو..">\n' +
            '                <span class="m-input-icon__icon m-input-icon__icon--left">\n' +
            '                    <span>\n' +
            '                        <i class="fa fa-search" aria-hidden="true"></i>\n' +
            '                    </span>\n' +
            '                </span>\n' +
            '            </div>\n' : '',
            moreBtnHtml = '<button data-more="'+moreCounter+'" data-moretype="more" class="showMoreItems"><i class="fa fa-plus"></i>نمایش بیشتر...</button>',
            sytleForMoreBtnHtml = 'style="max-height: '+( (moreCounter*29.5) + 20 )+'px;overflow: hidden;position: relative;"';

        if (moreCounter === 0) {
            moreBtnHtml = '';
            sytleForMoreBtnHtml = '';
        }

        return '\n' +
            '<div class="GroupFilters '+openStatus+'">\n' +
            '    <div class="head">\n' +
            '        <div class="title">\n' +
            '            '+data.title+'\n' +
            '        </div>\n' +
            '        <div class="tools">\n' +
            '            <div class="openMode">\n' +
            '                <i class="fa fa-angle-up" aria-hidden="true"></i>\n' +
            '            </div>\n' +
            '            <div class="closeMode">\n' +
            '                <i class="fa fa-angle-down" aria-hidden="true"></i>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="body">\n' +
            '        <div class="tools">\n' +
                         searchTool +
            '        </div>\n' +
            '        <div class="m-form">\n' +
            '            <div class="m-form__group form-group">\n' +
            '                <div class="GroupFilters-list" '+sytleForMoreBtnHtml+'>\n' +
                                data.checkboxList +
                                moreBtnHtml +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    \n' +
            '    </div>\n' +
            '</div>';
    }

    function initGroupsField() {
        var optionsHtml = '';

        optionsHtml += getGroupFilters({
            title:'نظام آموزشی',
            openStatus:true,
            checkboxList: createFieldsOfGroupOptions(contentSearchFilterData["nezam"])
        });
        optionsHtml += getGroupFilters({
            title:'مقطع',
            openStatus:true,
            searchTool:false,
            checkboxList: createFieldsOfGroupOptions(contentSearchFilterData["allMaghta"])
        });
        optionsHtml += getGroupFilters({
            title:'رشته',
            openStatus:true,
            checkboxList: createFieldsOfGroupOptions(contentSearchFilterData["major"])
        });
        optionsHtml += getGroupFilters({
            title:'درس',
            openStatus:true,
            searchTool:true,
            moreCounter:6,
            checkboxList: createFieldsOfGroupOptions(contentSearchFilterData["allLessons"])
        });
        optionsHtml += getGroupFilters({
            title:'دبیر',
            openStatus:true,
            searchTool:true,
            moreCounter:19,
            checkboxList: createFieldsOfGroupOptions(contentSearchFilterData["lessonTeacher"]["همه_دروس"])
        });

        return optionsHtml;
    }

    function checkFilterBasedOnUrlTags(urlTags) {
        $('.GroupFilters-item input[type="checkbox"]').each(function () {
            if (urlTags.indexOf($(this).val()) !== -1) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });
    }

    function sortSelectedItems() {
        $('.GroupFilters').each(function () {
            var $groupFilter = $(this),
                $checkBoxWrapperArray = [];
            $groupFilter.find('input[type="checkbox"]:checked').each(function () {
                var mCheckbox = $(this).parents('.GroupFilters-item');
                $checkBoxWrapperArray.push(mCheckbox);
                mCheckbox.remove();
            });
            var checkBoxWrapperArrayLength = $checkBoxWrapperArray.length;
            for (var i = 0; i < checkBoxWrapperArrayLength; i++) {
                $groupFilter.find('.body .GroupFilters-list').prepend($checkBoxWrapperArray[i]);
            }
        });
    }

    function getCheckedItems() {
        return $('.GroupFilters-item input[type="checkbox"]:checked');
    }

    function editSelectedItemsBeforeReport(reportArray) {
        // if (
        //     (reportArray.includes('نظام_آموزشی_قدیم') || reportArray.includes('نظام_آموزشی_جدید')) &&
        //     !reportArray.includes('کنکور')
        // ) {
        //     reportArray.push('کنکور');
        // } else if (
        //     (reportArray.includes('دهم') || reportArray.includes('یازدهم') || reportArray.includes('دوازدهم') || reportArray.includes('المپیاد')) &&
        //     !reportArray.includes('نظام_آموزشی_جدید')
        // ) {
        //     reportArray.push('نظام_آموزشی_جدید');
        // }
    }

    function getSelectedItemsInArray() {
        var checkedItems = getCheckedItems(),
            checkedItemsLength = checkedItems.length,
            tagsArray = [];
        for (var i = 0; i < checkedItemsLength; i++) {
            tagsArray.push($(checkedItems[i]).val());
        }
        editSelectedItemsBeforeReport(tagsArray);

        return tagsArray;
    }

    function uncheckItem(itemValue) {
        $('.GroupFilters-item input[type="checkbox"][value="'+itemValue+'"]').prop('checked', false);
    }

    function filterItemChangeEvent(contentSearchApi) {
        var paramsString = TagManager.refreshUrlBasedOnSelectedTags();
        sortSelectedItems();
        Alaasearch.loadDataBasedOnNewFilter(contentSearchApi, paramsString);
    }

    function showFilterMenuForMobile() {
        $('.SearchBoxFilterColumn').removeClass('filterStatus-close');
        $('.SearchBoxFilterColumn').addClass('filterStatus-open');
    }

    function hideFilterMenuForMobile() {
        $('.SearchBoxFilterColumn').addClass('filterStatus-close');
        $('.SearchBoxFilterColumn').removeClass('filterStatus-open');
    }

    function createFields(data) {
        AlaaLoading.show();
        contentSearchFilterData = data.contentSearchFilterData;
        $(data.containerSelector).html(initGroupsField());
        AlaaLoading.hide();
    }

    function addEvents(contentSearchApi) {
        $(document).on('click',  '.btnShowSearchBoxInMobileView', function () {
            showFilterMenuForMobile();
        });
        $(document).on('click',  '.btnHideSearchBoxInMobileView', function () {
            hideFilterMenuForMobile();
        });
        $(document).on('change', '.GroupFilters-item input[type="checkbox"]', function () {
            // var thisCheckedStatus = $(this).is(':checked');
            // $(this).parents('.GroupFilters').find('input[type="checkbox"]').prop('checked', false);
            // if (thisCheckedStatus) {
            //     $(this).prop('checked', true);
            // } else {
            //     $(this).prop('checked', false);
            // }
            if ($(this).parents('.filterStatus-open').length === 0) {
                filterItemChangeEvent(contentSearchApi);
            }
        });
        $(document).on('click', '.btnApplyFilterInMobileView', function () {
            filterItemChangeEvent(contentSearchApi);
            hideFilterMenuForMobile();
        });
        $(document).on('click', '#m_aside_left_hide_toggle', function () {
            if ($('body').hasClass('m-aside-left--hide')) {
                $('.SearchColumnsWrapper').removeClass('maxWidth');
            } else {
                $('.SearchColumnsWrapper').addClass('maxWidth');
            }
            $('.SearchBoxFilter').update();
        });
    }

    function sticky() {
        $('.SearchBoxFilter').sticky({
            topSpacing: $('#m_header').height(),
            bottomSpacing: 200,
            scrollDirectionSensitive: true,
            unstickUnder: 1025,
            zIndex: 98
        });
        $('.showSearchBoxBtnWrapperColumn').sticky({
            topSpacing: $('#m_header').height(),
            unstickUnder: false,
            zIndex: 98
        });
    }

    function init(data) {
        createFields(data);
        addEvents(data.contentSearchApi);
        sticky();
        checkFilterBasedOnUrlTags(data.tags);
        sortSelectedItems();
        TagManager.addTagBadgeEvents(function () {
            filterItemChangeEvent(data.contentSearchApi);
        });
    }

    return {
        init: init,
        getSelectedItemsInArray: getSelectedItemsInArray,
        uncheckItem: uncheckItem,
        checkFilterBasedOnUrlTags: checkFilterBasedOnUrlTags,
        sortSelectedItems: sortSelectedItems
    }
}();

var initPage = function() {

    function slideChanged1(event) {
        gtmEecProductObserver.observe();
        imageObserver.observe();
    }

    function slideChanged2(event) {
        imageObserver.observe();
    }

    function initScrollCarousel() {
        var otherResponsive = {
                0:{
                    items:1,
                },
                400:{
                    items:2,
                },
                600:{
                    items:3,
                },
                800:{
                    items:4,
                },
                1190:{
                    items:5
                },
                1400:{
                    items:5
                }
            },
            productResponsive = {
                0:{
                    items:1,
                },
                400:{
                    items:2,
                },
                600:{
                    items:3,
                },
                800:{
                    items:5,
                },
                1190:{
                    items:6
                },
                1400:{
                    items:8
                }
            },
            config = {
                stagePadding: 30,
                loop: false,
                rtl:true,
                nav: true,
                dots: false,
                margin:10,
                mouseDrag: true,
                touchDrag: true,
                pullDrag: true,
                lazyLoad:false,
                responsiveClass:true,
                responsive: otherResponsive
            };

        var owl = jQuery('.a--owl-carousel-type-1');
        owl.each(function () {
            var itemId = $(this).attr('id');
            if (itemId === 'product-carousel') {
                config.responsive = productResponsive;
                config.onTranslated = slideChanged1;
            } else {
                config.responsive = otherResponsive;
                config.onTranslated = slideChanged2;
            }
            $(this).owlCarousel(config);
            $(this).trigger('refresh.owl.carousel');
        });
    }

    function initFilterOptions(contentSearchFilterData, tags, contentSearchApi) {
        FilterOptions.init({
            contentSearchFilterData: contentSearchFilterData,
            containerSelector: '.SearchBoxFilter',
            tags: tags,
            contentSearchApi: contentSearchApi
        });
    }

    function initAlaasearch(contentData) {
        Alaasearch.init(contentData);
    }

    function init(contentSearchFilterData, tags, contentData, contentSearchApi) {
        $('.m-body .m-content').addClass('boxed');
        initFilterOptions(contentSearchFilterData, tags, contentSearchApi);
        initScrollCarousel();
        initAlaasearch(contentData);
    }

    return {
        init: init
    };

}();

jQuery(document).ready(function () {
    initPage.init(contentSearchFilterData, tags, contentData.data, contentSearchApi);
});
