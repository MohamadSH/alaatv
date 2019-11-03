var Alaasearch = function () {

    var productAjaxLock = 0;
    var videoAjaxLock = 0;
    var setAjaxLock = 0;
    var articleAjaxLock = 0;
    var pamphletAjaxLock = 0;

    var videoRepository = [];
    var productRepository = [];
    var videoRepositoryCounter = 5;
    var productRepositoryCounter = 1;

    var setLoadType = 'carouselType';

    function ajaxSetup() {
        $.ajaxSetup({
            cache: false,
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
                statusCode: {
                    200: function (response) {
                        callback(response);
                    },
                    403: function (response) {
                        // responseMessage = response.responseJSON.message;
                    },
                    404: function (response) {
                    },
                    422: function (response) {
                    },
                    429: function (response) {
                    },
                    //The status for when there is error php code
                    500: function () {
                        removeLoadingItem(owl, type);
                    }
                }
            }
        );
    }

    function loadAjaxContent(contentData, isInit) {

        var hasItem = false,
            hasSet = false,
            hasProduct = false,
            hasVideo = false;

        if (typeof contentData.product !== 'undefined' && contentData.product !== null && contentData.product.total>0) {
            hasProduct = true;
            hasItem = true;
        }
        if (typeof contentData.video !== 'undefined' && contentData.video !== null && contentData.video.total>0) {
            hasVideo = true;
            hasItem = true;
        }
        if (typeof contentData.set !== 'undefined' && contentData.set !== null && contentData.set.total>0) {
            hasSet = true;
            hasItem = true;
        }

        if (isInit && hasSet && (hasProduct || hasVideo)) {
            setLoadType = 'carouselType';
            $('.searchResult .carouselType').fadeIn();
        } else if (isInit && hasSet) {
            setLoadType = 'listType';
            $('.searchResult .carouselType').fadeOut();
        }

        if (hasSet) {
            appendToSet(contentData.set, setLoadType);
        }
        if (hasVideo) {
            videoRepository = videoRepository.concat(contentData.video.data);
            appendToVideo();
        }
        if (hasProduct) {
            productRepository = productRepository.concat(contentData.product.data);
            appendToProduct();
        }

        addSensorItem('carouselType');
        addSensorItem('listType');

        if (hasSet) {
            setNextPageUrl('set', contentData.set.next_page_url);
        }
        if (hasProduct) {
            setNextPageUrl('product', contentData.product.next_page_url);
        }
        if (hasVideo) {
            setNextPageUrl('video', contentData.video.next_page_url);
        }

        gtmEecProductObserver.observe();
        imageObserver.observe();
    }

    function appendToProduct() {
        var productRepositoryLength = productRepository.length,
            counter = 0;
        for(var i = 0; i < productRepositoryLength; i++) {
            if (productRepository[i] === null) {
                continue;
            }
            $('.searchResult .listType').append(makeWidgetFromJsonResponse(productRepository[i], 'product', i));
            productRepository[i] = null;
            counter++;
            if (counter === productRepositoryCounter) {
                counter = 0;
                break;
            }
        }
    }
    function appendToVideo() {
        var videoRepositoryLength = videoRepository.length,
            counter = 0;
        for(var i = 0; i < videoRepositoryLength; i++) {
            if (videoRepository[i] === null) {
                continue;
            }
            $('.searchResult .listType').append(makeWidgetFromJsonResponse(videoRepository[i], 'video', i));
            videoRepository[i] = null;
            counter++;
            if (counter === videoRepositoryCounter) {
                counter = 0;
                break;
            }
        }
    }
    function appendToSet(data, loadType) {
        $.each(data.data, function (index, value) {
            if (loadType === 'carouselType') {
                $('.searchResult .carouselType .ScrollCarousel').append(makeWidgetFromJsonResponse(value, 'set-carouselType', index));
            } else if (loadType === 'listType') {

            }
        });
    }

    function makeWidgetFromJsonResponse(data, type, itemKey) {
        switch (type) {
            case 'product':
                return getProductItem(data, itemKey);
            case 'video':
                return getContentItem(data);
            case 'set-carouselType':
                return getSetCarouselItem(data);
        }
    }
    function getSetCarouselItem(data) {
        let inputData = {
            widgetPic: (typeof (data.photo) === 'undefined' || data.photo == null) ? data.thumbnail + '?w=253&h=142' : data.photo + '?w=253&h=142',
            widgetTitle: data.name,
            widgetAuthor: {
                photo : data.author.photo,
                name: data.author.firstName,
                full_name: data.author.full_name
            },
            widgetCount: data.active_contents_count,
            widgetLink: '/set/'+data.id
        };

        let widgetPic = inputData.widgetPic,
            widgetTitle = inputData.widgetTitle,
            widgetAuthor = inputData.widgetAuthor,
            widgetCount = inputData.widgetCount,
            widgetLink = inputData.widgetLink,
            loadingClass = (typeof data.loadingHtml !== 'undefined') ? 'loadingItem' : '';

        var htmlItemSet = '' +
            '<div class="item carousel a--block-item a--block-type-set '+loadingClass+' w-66534321">\n' +
            '    <div class="a--block-imageWrapper">\n' +
            '        \n' +
            '        <div class="a--block-detailesWrapper">\n' +
            '    \n' +
            '            <div class="a--block-set-count">\n' +
            '                <span class="a--block-set-count-number">'+widgetCount+'</span>\n' +
            '                <br>\n' +
            '                <span class="a--block-set-count-title">محتوا</span>\n' +
            '                <br>\n' +
            '                <a href="'+widgetLink+'" class="a--block-set-count-icon">\n' +
            '                    <i class="fa fa-bars"></i>\n' +
            '                </a>\n' +
            '            </div>\n' +
            '            \n' +
            '            <div class="a--block-set-author-pic">\n' +
            '                <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" class="m-widget19__img lazy-image" data-src="'+widgetAuthor.photo+'" alt="'+widgetAuthor.full_name+'" width="40" height="40">\n' +
            '            </div>\n' +
            '            \n' +
            '    \n' +
            '        </div>\n' +
            '        \n' +
            '        <a href="'+widgetLink+'" class="a--block-imageWrapper-image">\n' +
        (

            (typeof data.loadingHtml !== 'undefined') ?
                data.loadingHtml
                :
                '            <img src="https://cdn.alaatv.com/loder.jpg?w=16&h=9" data-src="'+widgetPic+'" alt="'+widgetTitle+'" class="a--block-image lazy-image" width="453" height="254" />\n'


        )
            +
            '        </a>\n' +
            '    </div>\n' +
            '    \n' +
            '    <div class="a--block-infoWrapper">\n' +
            '        \n' +
            '        <div class="a--block-titleWrapper">\n' +
            '            <a href="'+widgetLink+'" class="m-link">\n' +
            '                <span class="m-badge m-badge--info m-badge--dot"></span>\n' +
            '                '+widgetTitle+'\n' +
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

        var widgetActionLink = data.url;
        var widgetActionName = '<i class="fa fa-cart-arrow-down"></i>' + ' / ' + '<i class="fa fa-eye"></i>';
        var widgetPic = data.photo;
        var widgetTitle = data.name;
        var price = data.price;
        var shortDescription = (data.shortDescription!==null) ? data.shortDescription : (data.longDescription!==null) ? data.longDescription : '';
        var discount = Math.round((1 - (price.final / price.base)) * 100);
        var discountRibbon = '';
        var countOfExistingProductInCarousel = $('#product-carousel.owl-carousel').find('.item').length;
        var gtmEecProductId = data.id;
        var gtmEecProductName = data.name;
        var gtmEecProductCategory = '-';
        var gtmEecProductVariant = '-';
        var gtmEecProductPosition = countOfExistingProductInCarousel;
        var priceHtml = '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">';
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

        var itemData = {
            class: 'a--gtm-eec-product',
            itemGtm:
                '     data-position="'+itemKey+'"\n' +
                '     data-gtm-eec-product-id="'+gtmEecProductId+'"\n' +
                '     data-gtm-eec-product-name="'+gtmEecProductName+'"\n' +
                '     data-gtm-eec-product-price="'+priceToStringWithTwoDecimal(price.final)+'"\n' +
                '     data-gtm-eec-product-brand="آلاء"\n' +
                '     data-gtm-eec-product-category="-"\n' +
                '     data-gtm-eec-product-variant="-"\n' +
                '     data-gtm-eec-product-position="'+itemKey+'"\n' +
                '     data-gtm-eec-product-list="محصولات صفحه سرچ"',
            widgetPic: '<a href="' + widgetActionLink + '"\n' +
                '   class="d-block a--gtm-eec-product-click"\n' +
                '   data-gtm-eec-product-id="'+gtmEecProductId+'"\n' +
                '   data-gtm-eec-product-name="'+gtmEecProductName+'"\n' +
                '   data-gtm-eec-product-price="'+priceToStringWithTwoDecimal(price.final)+'"\n' +
                '   data-gtm-eec-product-brand="آلاء"\n' +
                '   data-gtm-eec-product-category="-"\n' +
                '   data-gtm-eec-product-variant="-"\n' +
                '   data-gtm-eec-product-position="'+itemKey+'"\n' +
                '   data-gtm-eec-product-list="محصولات صفحه سرچ">\n' +
                '    <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="'+widgetPic+'" alt="'+gtmEecProductName+'" class="a--full-width lazy-image productImage" width="400" height="400" />\n' +
                '</a>\n',
            widgetTitle:
                '<a href="' + widgetActionLink + '"\n' +
                '   class="m-link a--owl-carousel-type-2-item-subtitle a--gtm-eec-product-click"\n' +
                '   data-gtm-eec-product-id="'+gtmEecProductId+'"\n' +
                '   data-gtm-eec-product-name="'+gtmEecProductName+'"\n' +
                '   data-gtm-eec-product-price="'+priceToStringWithTwoDecimal(price.final)+'"\n' +
                '   data-gtm-eec-product-brand="آلاء"\n' +
                '   data-gtm-eec-product-category="-"\n' +
                '   data-gtm-eec-product-variant="-"\n' +
                '   data-gtm-eec-product-position="'+itemKey+'"\n' +
                '   data-gtm-eec-product-list="محصولات صفحه سرچ">\n' +
                '    '+widgetTitle+'\n' +
                '</a>\n',
            widgetDetailes: '' +
                '<div>' +
                priceHtml+
                '</div>'+
                '<div class="m--margin-top-20">' +
                truncatise(shortDescription.replace(/<a .*>.*<\/a>/i, ''), options) +
                '</div>',
            ribbon: discountRibbon
        };
        return getListTypeItem(itemData);
    }
    function getContentItem(data) {
        var options = {
            TruncateLength: 40,
            TruncateBy : "words",
            Strict : false,
            StripHTML : true,
            Suffix : '...'
        };
        let widgetPic = (typeof (data.photo) === 'undefined' || data.photo == null) ? data.thumbnail + '?w=444&h=250' : data.photo + '?w=444&h=250',
            widgetTitle = data.name,
            widgetAuthor = {
                photo: (typeof (data.author.photo) === 'undefined' || data.author.photo == null) ? null : data.author.photo,
                name: data.author.firstName,
                full_name: data.author.full_name
            },
            widgetLink = data.url,
            description = data.description,
            videoOrder = data.order,
            setName = data.set.name,
            setUrl = data.set.contentUrl,
            widgetAuthorFullameHtml = '' +
                '<div>' +
                '   <span>جلسه </span>' +
                '   <span>'+videoOrder+'</span>' +
                '   <span> از دوره </span>' +
                '   <span>'+setName+'</span>' +
                '   <br>' +
                '   <span>تاریخ انتشار: </span>' +
                '   <span>'+new persianDate(new Date(data.updated_at)).format('LLLL')+'</span>' +
                '</div>' +
                '<div class="videoDescription m--margin-top-10">'+truncatise(description.replace(/<a .*>.*<\/a>/i, ''), options)+'</div>';

        var itemData = {
            class: '',
            itemGtm:'',
            widgetPic:
                '        <a href="'+widgetLink+'" class="d-block">\n' +
                '            <img src="https://cdn.alaatv.com/loder.jpg?w=16&h=9" data-src="'+widgetPic+'" alt="'+widgetTitle+'" class="a--full-width lazy-image videoImage" width="253" height="142" />\n' +
                '        </a>\n',
            widgetTitle: widgetTitle,
            widgetDetailes: widgetAuthorFullameHtml,
            ribbon: ''
        };
        return getListTypeItem(itemData);
    }

    function addLoadingItem(itemType) {
        var loadingHtml = '<div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div>';
        var itemData = {
            loadingHtml: loadingHtml,
            photo:'',
            name:'',
            author:{
                photo:'',
                firstName:'',
                full_name:''
            },
            active_contents_count:'',
            id:''
        };
        if (itemType === 'carouselType') {
            $('.searchResult .carouselType .ScrollCarousel').append(getSetCarouselItem(itemData));
        } else if (itemType === 'listType') {
             itemData = {
                class: 'loadingItem',
                itemGtm:'',
                widgetPic: loadingHtml,
                widgetTitle: '',
                widgetDetailes: loadingHtml,
                ribbon: ''
            };
            $('.searchResult .listType').append(getListTypeItem(itemData));
        }
    }
    function removeLoadingItem(itemType) {
        if (itemType === 'carouselType') {
            $('.searchResult .carouselType .ScrollCarousel .loadingItem').remove();
        } else if (itemType === 'listType') {
            $('.searchResult .listType .loadingItem').remove();
        }
    }

    function addSensorItem(itemType) {
        var sensorHtml = '<div class="item sensorItem" style="width: 1px;height: 1px;"></div>',
            sensorPosition = 0;

        if (itemType === 'carouselType') {
            sensorPosition = getCarouselChildCount() - 3;
            if (sensorPosition < 3) {
                sensorPosition = 3;
            }
            $('.searchResult .carouselType .ScrollCarousel>.item:nth-child('+sensorPosition+')').after(sensorHtml);
            lazyLoadSensorItemCarousel();
        } else if (itemType === 'listType') {
            sensorPosition = getListTypeChildCount() - 6;
            if (sensorPosition < 6) {
                sensorPosition = 6;
            }
            $('.searchResult .listType>.item:nth-child('+sensorPosition+')').after(sensorHtml);
            lazyLoadSensorItemListType();
        }
    }
    function removeSensorItem(itemType) {
        if (itemType === 'carouselType') {
            $('.searchResult .carouselType .ScrollCarousel .sensorItem').remove();
        } else if (itemType === 'listType') {
            $('.searchResult .listType .sensorItem').remove();
        }
    }

    function setNextPageUrl(type, url) {
        if (type === 'set') {
            $('.searchResult .InputOfAllNextPageUrl .nextPageUrl-set').val(url);
        } else if (type === 'product') {
            $('.searchResult .InputOfAllNextPageUrl .nextPageUrl-product').val(url);
        } else if (type === 'video') {
            $('.searchResult .InputOfAllNextPageUrl .nextPageUrl-video').val(url);
        }
    }
    function getNextPageUrl(type) {
        if (type === 'set') {
            return $('.searchResult .InputOfAllNextPageUrl .nextPageUrl-set').val();
        } else if (type === 'product') {
            return $('.searchResult .InputOfAllNextPageUrl .nextPageUrl-product').val();
        } else if (type === 'video') {
            return $('.searchResult .InputOfAllNextPageUrl .nextPageUrl-video').val();
        }
    }

    function loadDataBasedOnNewFilter(urlAction) {

        addLoadingItem('carouselType');
        getAjaxContent(nextPageUrl, function (response) {
            appendToCarouselType(response);
            fillVideoRepositoryAndSetNextPage(response.result.video);

        });


    }

    function fetchNewCarousel() {
        var nextPageUrl = getNextPageUrl('set');
        if (nextPageUrl !== null && nextPageUrl.length > 0) {
            addLoadingItem('carouselType');
            getAjaxContent(nextPageUrl, function (response) {
                appendToCarouselType(response);
            });
        }
        removeSensorItem('carouselType');
    }
    function fetchNewVideo(callback) {
        var nextPageUrlVideo = getNextPageUrl('video');
        if (nextPageUrlVideo !== null && nextPageUrlVideo.length > 0) {
            addLoadingItem('listType');
            getAjaxContent(nextPageUrlVideo, function (response) {
                fillVideoRepositoryAndSetNextPage(response.result.video);
                callback();
            });
        }
    }
    function fetchNewProduct(callback) {
        var nextPageUrlProduct = getNextPageUrl('product');
        if (nextPageUrlProduct !== null && nextPageUrlProduct.length > 0) {
            getAjaxContent(nextPageUrlProduct, function (response) {
                fillProductRepositoryAndSetNextPage(response.result.product);
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
    function appendToCarouselType(response) {
        if (typeof response.result.set !== 'undefined' && response.result.set !== null && response.result.set.total>0) {
            removeLoadingItem('carouselType');
            appendToSet(response.result.set, 'carouselType');
            addSensorItem('carouselType');
            setNextPageUrl('set', response.result.set.next_page_url);
        }
        imageObserver.observe();
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
        if (typeof data !== 'undefined' && data !== null && data.total>0) {
            fillProductRepository(data.data);
            setNextPageUrl('product', data.next_page_url);
        }
    }
    function fillVideoRepositoryAndSetNextPage(data) {
        if (typeof data !== 'undefined' && data !== null && data.total > 0) {
            fillVideoRepository(data.data);
            setNextPageUrl('video', data.next_page_url);
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
        LazyLoad.loadElementByQuerySelector('.searchResult .carouselType .ScrollCarousel .sensorItem', function () {
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
        return $('.searchResult .carouselType .ScrollCarousel>.item').length;
    }
    function getListTypeChildCount() {
        return $('.searchResult .listType>.item').length;
    }

    function clearOwlcarousel(owl) {
        var length = owl.find('.item').length;
        while (length > 0) {
            owl.trigger('remove.owl.carousel', 0)
                .trigger('refresh.owl.carousel');
            length = owl.find('.item').length;
        }
    }

    return {
        init: function (contentData) {
            $('.searchResult').append(getInputOfAllNextPageUrl());
            loadAjaxContent(contentData, true);
            $(document).on('change', '.GroupFilters-item input[type="checkbox"]', function () {
                TagManager.refreshTags();
            });
        },
        loadData: function (contentData) {
            loadAjaxContent(contentData, true);
        },
        clearFields: function () {
            clearOwlcarousel($('#product-carousel-warper .a--owl-carousel-type-1'));
            clearOwlcarousel($('#set-carousel-warper .a--owl-carousel-type-1'));
            clearOwlcarousel($('#video-carousel-warper .a--owl-carousel-type-1'));
            $('#pamphlet-vertical-widget').html('');
            $('#article-vertical-widget').html('');
        },
    }
}();

var CustomInitMultiLevelSearch = function () {

    var filterData = null;
    var tags = null;
    var tagsFromController = null;

    var selectedVlues = null;

    var emptyFields = null;

    function addUnderLine(string) {
        if (typeof string === 'undefined' || string === null) {
            return '';
        }
        return string.replace(/ /g, '_');
    }

    function removeUnderLine(string) {
        return string.replace(/_/g, ' ');
    }

    function getTags() {
        // var url = new URL(window.location.href);
        // var tags = url.searchParams.getAll("tags[]");
        var tags = getUrlParams(window.location.href, /(tags\[[0-9]*\])/g);
        var tagValue = [];
        for (var index in tags) {
            tagValue.push(tags[index].value);
        }
        return tagValue;
    }

    function getUrlParams(url, param) {
        var res = url.match(/(\?|\&)([^=]+)\=([^&]+)/g);
        var params = [];
        for (var index in res) {
            var tagItem = res[index];
            var paramValue = tagItem.replace(/(\?|\&)([^=]+)\=/g, '');
            var paramName = tagItem.replace('='+paramValue, '').replace('?', '').replace('&', '');
            if(typeof param !== 'undefined' && paramName.search(param) !== -1) {
                params.push({
                    name: paramName,
                    value: paramValue
                });
            } else {
                params.push({
                    name: paramName,
                    value: paramValue
                });
            }
        }
        return params;
    }

    function activeFilter(filterClass) {
        $('.selectorItem').attr('data-select-active', 'false');
        $('.selectorItem.'+filterClass).attr('data-select-active', 'true');
    }

    function getTagsFromControllerOrUrl() {
        var tags = [];
        if (tagsFromController !== null && typeof tagsFromController !== 'undefined') {
            tags = tagsFromController;
        } else {
            tags = getTags();
        }
        return tags;
    }

    function setSelectedNezamFromTags() {
        var selectedVal = filterData.nezam[1];
        var existInTags = false;

        var tags = getTagsFromControllerOrUrl();

        for (var tagsIndex in tags) {
            for (var nezamIndex in filterData.nezam) {
                var item = filterData.nezam[nezamIndex];
                if (item.value === decodeURI(tags[tagsIndex])) {
                    selectedVal = item;
                    activeFilter('maghtaSelector');
                    existInTags = true;
                    break;
                }
            }
        }
        selectedVlues.nezam = selectedVal;
        if (existInTags) {
            var name = removeUnderLine(selectedVal.value);
            $('.selectorItem.nezamSelector').attr('data-select-value', name);
            return name;
        } else {
            return false;
        }
    }

    function setSelectedMaghtaFromTags() {

        var selectedNezam = selectedVlues.nezam;
        var selectedMaghta = filterData[selectedNezam.maghtaKey][0];

        var existInTags = false;
        var tags = getTagsFromControllerOrUrl();

        for (var tagsIndex in tags) {
            for (var maghtaIndex in filterData[selectedNezam.maghtaKey]) {
                var item = filterData[selectedNezam.maghtaKey][maghtaIndex];
                if (item.value === decodeURI(tags[tagsIndex])) {
                    selectedMaghta = item;
                    activeFilter('majorSelector');
                    existInTags = true;
                    break;
                }
            }
        }
        selectedVlues[selectedNezam.maghtaKey] = selectedMaghta;
        if (existInTags) {
            var name = removeUnderLine(selectedMaghta.value);
            $('.selectorItem.maghtaSelector').attr('data-select-value', name);
            return name;
        } else {
            return false;
        }
    }

    function setSelectedMajorFromTags() {
        var selectedVal = filterData.major[0];
        var existInTags = false;

        var tags = getTagsFromControllerOrUrl();

        for (var tagsIndex in tags) {
            for (var majorIndex in filterData.major) {
                var value = filterData.major[majorIndex].value;
                if (value === decodeURI(tags[tagsIndex])) {
                    selectedVal = filterData.major[majorIndex];
                    activeFilter('lessonSelector');
                    existInTags = true;
                    break;
                }
            }
        }
        selectedVlues.major = selectedVal;
        if (existInTags) {
            var name = removeUnderLine(selectedVal.value);
            $('.selectorItem.majorSelector').attr('data-select-value', name);
            return name;
        } else {
            return false;
        }
    }

    function setSelectedLessonFromTags() {
        var selectedMajor = selectedVlues.major;
        var selectedLesson = filterData[selectedMajor.lessonKey][0];
        var existInTags = false;

        var tags = getTagsFromControllerOrUrl();

        for (var tagsIndex in tags) {
            for (var lessonIndex in filterData[selectedMajor.lessonKey]) {
                var item = filterData[selectedMajor.lessonKey][lessonIndex];
                if (item.value === decodeURI(tags[tagsIndex])) {
                    selectedLesson = item;
                    activeFilter('teacherSelector');
                    existInTags = true;
                    break;
                }
            }
        }
        selectedVlues.lesson = selectedLesson;
        if (existInTags) {
            var name = removeUnderLine(selectedLesson.index);
            $('.selectorItem.lessonSelector').attr('data-select-value', name);
            return name;
        } else {
            return false;
        }
    }

    function setSelectedTeacherFromTags() {
        var selectedLesson = selectedVlues.lesson.value;
        var selectedTeacher = filterData.lessonTeacher[selectedLesson][0];
        var existInTags = false;

        var tags = getTagsFromControllerOrUrl();

        for (var tagsIndex in tags) {
            for (var teacherIndex in filterData.lessonTeacher[selectedLesson]) {
                var item = filterData.lessonTeacher[selectedLesson][teacherIndex];
                if (item.value === decodeURI(tags[tagsIndex])) {
                    selectedTeacher = item;
                    activeFilter('teacherSelector');
                    existInTags = true;
                    break;
                }
            }
        }
        selectedVlues.teacher = selectedTeacher;
        if (existInTags) {
            var name = removeUnderLine(selectedTeacher.value);
            $('.selectorItem.teacherSelector').attr('data-select-value', name);
            return name;
        } else {
            return false;
        }
    }

    function initSelectorItem(selectorClass, selectedValue, filterDataArray) {
        $(selectorClass).find('.subItem').remove();
        appendSubItems(filterDataArray, selectorClass, selectedValue);
        fadeOutSubItemsIfDisplayTypeIsSelect2(selectorClass, filterDataArray, selectedValue);
    }

    function initNezam() {
        var selectorClass = '.nezamSelector';
        var selectedValue = setSelectedNezamFromTags();
        var filterDataArray = filterData.nezam;
        initSelectorItem(selectorClass, selectedValue, filterDataArray);
        setSelectedNezamFromTags();
    }

    function initMaghta() {
        var selectorClass = '.maghtaSelector';
        var selectedValue = setSelectedMaghtaFromTags();
        var maghta = selectedVlues.nezam.maghtaKey;
        var filterDataArray = filterData[maghta];
        initSelectorItem(selectorClass, selectedValue, filterDataArray);
        setSelectedMaghtaFromTags();
    }

    function initMajor() {
        var selectorClass = '.majorSelector';
        var selectedValue = setSelectedMajorFromTags();
        var filterDataArray = filterData.major;
        initSelectorItem(selectorClass, selectedValue, filterDataArray);
    }

    function initLessons() {
        var selectorClass = '.lessonSelector';
        var selectedValue = setSelectedLessonFromTags();
        var major = selectedVlues.major.lessonKey;
        var filterDataArray = filterData[major];
        initSelectorItem(selectorClass, selectedValue, filterDataArray);
    }

    function initTeacher() {
        var selectorClass = '.teacherSelector';
        var selectedValue = setSelectedTeacherFromTags();
        var lesson = selectedVlues.lesson.value;
        var filterDataArray = filterData.lessonTeacher[lesson];
        initSelectorItem(selectorClass, selectedValue, filterDataArray);
    }

    function fadeOutSubItemsIfDisplayTypeIsSelect2(selectorClass, filterDataArray, selectedValue) {
        var showType = getDisaplayType(selectorClass);
        if (showType === 'select2') {
            var selectorOrder = $(selectorClass).attr('data-select-order');
            if (selectedValue === false) {
                if ($('.filterNavigationStep[data-select-order="'+selectorOrder+'"]').hasClass('current')) {
                    selectedValue = null;
                } else {
                    selectedValue = $(selectorClass).attr('data-select-value');
                }
            }
            $(selectorClass).find('.subItem').fadeOut(0);
            $(selectorClass).find('.form-control.select2').empty();
            for (var index in filterDataArray) {
                var name = filterDataArray[index].value;
                name = removeUnderLine(name);
                if (selectedValue === name) {
                    $(selectorClass).find('.form-control.select2').append("<option value='"+name+"' selected>"+name+"</option>");
                } else {
                    $(selectorClass).find('.form-control.select2').append("<option value='"+name+"'>"+name+"</option>");
                }
            }
        } else if (showType === 'grid') {
            $(selectorClass).find('.subItem').fadeIn(0);
        }
    }

    function appendSubItems(filterDataArray, selectorClass, selectedValue) {
        for (var index in filterDataArray) {
            var name = filterDataArray[index].value;
            name = removeUnderLine(name);
            if (selectedValue === name) {
                $(selectorClass).append('<div class="col subItem" selected="selected">'+name+'</div>');
            } else {
                $(selectorClass).append('<div class="col subItem">'+name+'</div>');
            }
        }
    }

    function checkEmptyField(string) {
        for (var index in emptyFields) {
            var item = emptyFields[index];
            if (addUnderLine(item) === addUnderLine(string)) {
                return '';
            }
        }
        return addUnderLine(string);
    }

    function getDisaplayType(selectorClass) {
        var showType = $(selectorClass).data('select-display');
        if (typeof showType === 'undefined') {
            showType = 'grid';
        }
        return showType;
    }

    function initSelectedValues() {
        selectedVlues = {
            nezam: filterData.nezam[1],
            maghta: filterData.maghtaJadid[0],
            major: filterData.major[0],
            lesson: filterData.allLessons[0],
            teacher: filterData.lessonTeacher.همه_دروس[0].value
        };
    }

    function initEmptyFields() {
        emptyFields = [
            filterData.lessonTeacher.همه_دروس[0].value,
            filterData.allLessons[0].value,
            filterData.major[0].value,
            filterData.maghtaGhadim[0].value,
            filterData.maghtaJadid[0].value
        ];
    }

    return {
        initFilters: function (contentSearchFilterData, inputTags) {
            filterData = contentSearchFilterData;
            tagsFromController = inputTags;
            initSelectedValues();
            initNezam();
            initMaghta();
            initMajor();
            initLessons();
            initTeacher();
            tagsFromController = null;
        },
        checkEmptyField: function (contentSearchFilterData, string) {
            initEmptyFields();
            return checkEmptyField(string);
        },
        addUnderLine: function (string) {
            return addUnderLine(string);
        },
        removeUnderLine: function (string) {
            return removeUnderLine(string);
        }
    };
}();

var TagManager = function () {

    function refreshTags() {
        var selectedItems = getSelectedItems();
        var pageTagsListBadge = '.pageTags .m-list-badge__items';
        $(pageTagsListBadge).find('.m-list-badge__item').remove();

        // var searchFilterData = MultiLevelSearch.getSelectedData();
        var url = document.location.href.split('?')[0],
            tagsValue = '';
        for (var index in selectedItems) {
            var selectedText = selectedItems[index];
            if (typeof selectedText !== 'undefined' && selectedText !== null && selectedText !== '') {
                tagsValue += '&tags[]=' + selectedText;
            }
        }
        if (tagsValue !== '') {
            tagsValue = tagsValue.substr(1);
            url += '?' + tagsValue;
        }

        // window.history.pushState('data to be passed', 'Title of the page', url);
        // The above will add a new entry to the history so you can press Back button to go to the previous state.
        // To change the URL in place without adding a new entry to history use
        history.replaceState('data to be passed', 'Title of the page', url);

        return tagsValue;
    }

    function getSelectedItems() {
        var checkedItems = $('.GroupFilters-item input[type="checkbox"]:checked'),
            checkedItemsLength = checkedItems.length,
            tagsArray = [];
        for (var i = 0; i < checkedItemsLength; i++) {
            tagsArray.push($(checkedItems[i]).val());
        }
        return tagsArray;
    }


    function runWaiting() {
        Alaasearch.clearFields();
        $('.notFoundMessage').fadeOut();
        $('#product-carousel-warper').fadeIn();
        $('#video-carousel-warper').fadeIn();
        $('#set-carousel-warper').fadeIn();
        // $('#pamphlet-vertical-tabpanel').fadeIn();
        $('#pamphlet-vertical-tabpanel').removeClass('d-none');
        // $('#article-vertical-tabpanel').fadeIn();
        $('#article-vertical-tabpanel').removeClass('d-none');
        $('#pamphlet-vertical-tab').fadeIn();
        $('#article-vertical-tab').fadeIn();
        $('.ProductAndSetAndVideoWraper').removeClass('col').addClass('col-12 col-md-9');
        $('.PamphletAndArticleWraper').removeClass('d-none');
        mApp.block('#product-carousel-warper, #set-carousel-warper, #video-carousel-warper, #pamphlet-vertical-widget, #article-vertical-widget', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });
    }
    function stopWaiting() {
        mApp.unblock('#product-carousel-warper, #set-carousel-warper, #video-carousel-warper, #pamphlet-vertical-widget, #article-vertical-widget');
    }

    function getNewDataBaseOnTags(contentSearchFilterData) {

        runWaiting();

        // document.location.href

        var tagsValue = refreshTags(contentSearchFilterData);


        var originUrl = document.location.origin;
        var pathnameUrl = document.location.pathname;

        $.ajax({
            type: 'GET',
            // url: document.location.href,
            url: originUrl+pathnameUrl+'?'+tagsValue,
            data: {},
            dataType: 'json',
            success: function (data) {
                if (typeof data === 'undefined' || data.error) {

                    var message = '';
                    if (typeof data !== 'undefined') {
                        message = data.error.message;
                    }

                    toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);


                } else {
                    Alaasearch.loadData(data.result);
                }
                stopWaiting();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var message = '';
                // if (jqXHR.status === 403) {
                //     message = 'کد وارد شده اشتباه است.';
                // } else if (jqXHR.status === 422) {
                //     message = 'کد را وارد نکرده اید.';
                // } else {
                //     message = 'خطای سیستمی رخ داده است.';
                // }

                message = 'خطای سیستمی رخ داده است.';
                toastr.error(message);
                stopWaiting();
            }
        });
    }

    return {
        refreshTags: function () {
            refreshTags();
        },
        getNewDataBaseOnTags: function (contentSearchFilterData) {
            getNewDataBaseOnTags(contentSearchFilterData);
        }
    };
}();

var initFilterOptions = function () {

    var contentSearchFilterData = {};

    function getFilterOption(data) {
        return '\n' +
            '<label class="m-checkbox m-checkbox--bold m-checkbox--state-warning GroupFilters-item">\n' +
            '    <input type="checkbox" value="'+data.value+'"> '+data.name+'\n' +
            '    <span></span>\n' +
            '</label>';
    }

    function createFieldsOfGroupOptions(data) {
        var dataLength = data.length,
            optionsHtml = '';
        for (var i = 0; i < dataLength; i++) {
            optionsHtml += getFilterOption({
                name: data[i].value.split('_').join(' '),
                value: data[i].value
            });
        }
        return optionsHtml;
    }

    function initNezam() {
        return createFieldsOfGroupOptions(contentSearchFilterData["nezam"]);
    }

    function initMaghta() {
        return createFieldsOfGroupOptions(contentSearchFilterData["allMaghta"]);
    }

    function initMajor() {
        return createFieldsOfGroupOptions(contentSearchFilterData["major"]);
    }

    function initLessons() {
        return createFieldsOfGroupOptions(contentSearchFilterData["allLessons"]);
    }

    function initTeacher() {
        return createFieldsOfGroupOptions(contentSearchFilterData["lessonTeacher"]["همه_دروس"]);
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
            moreBtnHtml = '<button data-more="'+moreCounter+'" data-moretype="more" class="showMoreItems">نمایش بیشتر...</button>',
            sytleForMoreBtnHtml = 'style="max-height: '+( (moreCounter*29.5) + 20 )+'px;overflow: hidden;position: relative;"';

        if (moreCounter == 0) {
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
            '                <div class="m-checkbox-list" '+sytleForMoreBtnHtml+'>\n' +
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
            checkboxList: initNezam()
        });
        optionsHtml += getGroupFilters({
            title:'مقطع',
            openStatus:true,
            searchTool:false,
            checkboxList: initMaghta()
        });
        optionsHtml += getGroupFilters({
            title:'رشته',
            openStatus:true,
            checkboxList: initMajor()
        });
        optionsHtml += getGroupFilters({
            title:'درس',
            openStatus:true,
            searchTool:true,
            moreCounter:6,
            checkboxList: initLessons()
        });
        optionsHtml += getGroupFilters({
            title:'دبیر',
            openStatus:true,
            searchTool:true,
            moreCounter:19,
            checkboxList: initTeacher()
        });

        return optionsHtml;
    }

    return {
        init: function (data) {
            contentSearchFilterData = data.contentSearchFilterData;
            $(data.containerSelector).html(initGroupsField());
        }
    }
}();

$('.notFoundMessage').fadeOut(0);

jQuery(document).ready(function () {

    initFilterOptions.init({
        contentSearchFilterData: contentSearchFilterData,
        containerSelector: '.SearchBoxFilter'
    });

    $('.SearchBoxFilter').sticky({
        topSpacing: $('#m_header').height(),
        bottomSpacing: 60,
        scrollDirectionSensitive: true,
        zIndex: 98
    });


    let otherResponsive = {
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
    function slideChanged1(event) {
        gtmEecProductObserver.observe();
        imageObserver.observe();
    }
    function slideChanged2(event) {
        imageObserver.observe();
    }

    var owl = jQuery('.a--owl-carousel-type-1');
    owl.each(function () {
        let itemId = $(this).attr('id');
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


    Alaasearch.init(contentData);

    // CustomInitMultiLevelSearch.initFilters(contentSearchFilterData, tags);

    // MultiLevelSearch.init({
    //     selectorId: 'contentSearchFilter'
    // }, function () {
    //     GetAjaxData.refreshTags(contentSearchFilterData);
    //     CustomInitMultiLevelSearch.initFilters(contentSearchFilterData);
    //     GetAjaxData.getNewDataBaseOnTags(contentSearchFilterData);
    // },  function () {
    //     GetAjaxData.refreshTags(contentSearchFilterData);
    //     CustomInitMultiLevelSearch.initFilters(contentSearchFilterData);
    // });

});
