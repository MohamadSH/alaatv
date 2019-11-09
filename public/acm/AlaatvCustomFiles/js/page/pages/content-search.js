var Alaasearch = function () {

    var videoRepository = [],
        productRepository = [],
        videoRepositoryCounter = 4,
        productRepositoryCounter = 1,
        carouselHasItem = true,
        listTypeHasItem = true;

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

    function loadAjaxContent(contentData) {
        fillVideoRepositoryAndSetNextPage(contentData.video);
        fillProductRepositoryAndSetNextPage(contentData.product);
        appendToCarouselTypeAndSetNextPage(contentData.set);
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
        var videoRepositoryLength = videoRepository.length,
            counter = 0;
        for(var i = 0; i < videoRepositoryLength; i++) {
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
        $.each(data.data, function (index, value) {
            if (loadType === 'carouselType') {
                carouselHasItem = true;
                $('.searchResult .carouselType .ScrollCarousel').append(getSetCarouselItem(value));
            } else if (loadType === 'listType') {

            }
        });
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
            '<div class="item carousel a--block-item a--block-type-set '+loadingClass+' w-44333211">\n' +
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
            '                    <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" <g="" >\n' +
            '                        <path d="M3.67 8.67h14V11h-14V8.67zm0-4.67h14v2.33h-14V4zm0 9.33H13v2.34H3.67v-2.34zm11.66 0v7l5.84-3.5-5.84-3.5z" class="style-scope yt-icon"></path>\n' +
            '                    </svg>\n' +
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
        console.log('product data:', data);
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
            widgetLink: widgetActionLink,
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
                '<div class="productPriceWrapper">' +
                priceHtml+
                '</div>'+
                '<div class="m--margin-top-40">' +
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
            setName = (typeof data.set !== 'undefined') ? data.set.name : '-',
            setUrl = (typeof data.set !== 'undefined') ? data.set.contentUrl : '-',
            videoOrderHtml = '<div class="videoOrder"><div class="videoOrder-title">جلسه</div><div class="videoOrder-number">'+videoOrder+'</div><div class="videoOrder-om"> اُم </div></div>',
            widgetDetailes = '' +
                '<div class="videoDetaileWrapper">' +
                '   <span><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" <g class="style-scope yt-icon">\n' +
                '        <path d="M3.67 8.67h14V11h-14V8.67zm0-4.67h14v2.33h-14V4zm0 9.33H13v2.34H3.67v-2.34zm11.66 0v7l5.84-3.5-5.84-3.5z" class="style-scope yt-icon"></path>\n' +
                '      </g></svg></span>' +
                '   <span> از دوره </span>' +
                '   <span>'+setName+'</span>' +
                '   <br>' +
                '   <i class="fa fa-calendar-alt m--margin-right-5"></i>' +
                '   <span>تاریخ بروزرسانی: </span>' +
                '   <span>'+new persianDate(new Date(data.updated_at)).format('YYYY/MM/DD HH:mm:ss')+'</span>' +
                    videoOrderHtml +
                '</div>'+
                '<div class="videoDescription">'+truncatise(description.replace(/<a .*>.*<\/a>/i, ''), options)+'</div>';

        var itemData = {
            class: '',
            itemGtm:'',
            widgetLink: widgetLink,
            widgetPic:
                '        <a href="'+widgetLink+'" class="d-block">\n' +
                '            <img src="https://cdn.alaatv.com/loder.jpg?w=16&h=9" data-src="'+widgetPic+'" alt="'+widgetTitle+'" class="a--full-width lazy-image videoImage" width="253" height="142" />\n' +
                '        </a>\n',
            widgetTitle:
                '<a href="' + widgetLink + '" class="m-link">\n' +
                '    '+widgetTitle+'\n' +
                '</a>\n',
            widgetDetailes: widgetDetailes,
            ribbon: ''
        };
        return getListTypeItem(itemData);
    }

    function addLoadingItem(itemType) {
        var loadingHtml = '<div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div>';
        if (itemType === 'carouselType') {
            $('.searchResult .carouselType .ScrollCarousel').append('<div class="item loadingItem w-44333211">\n' + loadingHtml + '</div>');
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
            $('.searchResult .carouselType .ScrollCarousel .loadingItem').remove();
        } else if (itemType === 'listType') {
            $('.searchResult .listType .loadingItem').remove();
        }
    }

    function clearCarousel() {
        $('.searchResult .carouselType .ScrollCarousel .item').remove();
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
            $('.searchResult .carouselType .ScrollCarousel>.item:nth-child('+sensorPosition+')').after(sensorHtml);
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
            $('.searchResult .carouselType .ScrollCarousel .sensorItem').remove();
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

    function loadDataBasedOnNewFilter(urlAction) {
        cleatAllItems();
        addLoadingItem('carouselType');
        addLoadingItem('listType');
        // mApp.block('.SearchBoxFilter .GroupFilters .body', {
        //     type: "loader",
        //     state: "success",
        // });

        AlaaLoading.show();
        getAjaxContent(urlAction, function (response) {
            loadAjaxContent(response.result);
            // mApp.unblock('.SearchBoxFilter .GroupFilters .body');
            AlaaLoading.hide();
        });
    }

    function fetchNewCarousel() {
        var nextPageUrl = getNextPageUrl('set');
        if (nextPageUrl !== null && nextPageUrl.length > 0) {
            addLoadingItem('carouselType');
            getAjaxContent(nextPageUrl, function (response) {
                appendToCarouselTypeAndSetNextPage(response.result.set);
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
    function appendToCarouselTypeAndSetNextPage(data) {
        removeLoadingItem('carouselType');
        if (typeof data !== 'undefined' && data !== null && data.total>0) {
            appendToSet(data, 'carouselType');
            addSensorItem('carouselType');
            setNextPageUrl('set', data.next_page_url);
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
        if (typeof data !== 'undefined' && data !== null && data.total>0) {
            fillProductRepository(data.data);
            setNextPageUrl('product', data.next_page_url);
        } else {
            setNextPageUrl('product', '');
        }
    }
    function fillVideoRepositoryAndSetNextPage(data) {
        if (typeof data !== 'undefined' && data !== null && data.total > 0) {
            fillVideoRepository(data.data);
            setNextPageUrl('video', data.next_page_url);
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
            cleatAllItems();
            $('.searchResult').append(getInputOfAllNextPageUrl());
            loadAjaxContent(contentData);
        },
        loadDataBasedOnNewFilter: function (urlAction) {
            loadDataBasedOnNewFilter(urlAction);
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

    function refreshUrlBasedOnSelectedTags() {
        var selectedItems = getSelectedTags();
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

        return url;
    }

    function getSelectedTags() {
        var checkedItems = $('.GroupFilters-item input[type="checkbox"]:checked'),
            checkedItemsLength = checkedItems.length,
            tagsArray = [];
        for (var i = 0; i < checkedItemsLength; i++) {
            tagsArray.push($(checkedItems[i]).val());
        }
        return tagsArray;
    }

    function refreshPageTagsBadge() {
        var tags = getSelectedTags();
        var tagsLength = tags.length;
        $('.pageTags .m-badge').remove();
        if(tagsLength === 0) {
            $('.pageTags').fadeOut();
        } else {
            $('.pageTags').fadeIn();
            for(var i = 0; i < tagsLength; i++) {
                $('.pageTags .m-list-badge').append('<span class="m-badge m-badge--info m-badge--wide m-badge--rounded m--margin-left-10 tag_0"><a class="m-link m--font-light" href="http://192.168.5.30/c?tags[0]='+tags[i]+'">'+tags[i].split('_').join(' ')+'</a></span>');
            }
        }
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

        var tagsValue = refreshUrlBasedOnSelectedTags(contentSearchFilterData);


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
        refreshUrlBasedOnSelectedTags: function () {
            return refreshUrlBasedOnSelectedTags();
        },
        getSelectedTags: function () {
            return getSelectedTags();
        },
        refreshPageTagsBadge: function () {
            refreshPageTagsBadge();
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

    function checkFilterBasedOnUrlTags(urlTags) {
        $('.GroupFilters-item input[type="checkbox"]').each(function () {
            if (urlTags.indexOf($(this).val()) !== -1) {
                $(this).prop('checked', true);
            }
        });
    }

    function sortSelectedItems() {
        $('.GroupFilters').each(function () {
            var $groupFilter = $(this),
                $checkBoxWrapperArray = [];
            $groupFilter.find('input[type="checkbox"]:checked').each(function () {
                var mCheckbox = $(this).parents('.m-checkbox');
                $checkBoxWrapperArray.push(mCheckbox);
                mCheckbox.remove();
            });
            var checkBoxWrapperArrayLength = $checkBoxWrapperArray.length;
            for (var i = 0; i < checkBoxWrapperArrayLength; i++) {
                $groupFilter.find('.body .m-checkbox-list').prepend($checkBoxWrapperArray[i]);
            }
        });
    }

    return {
        init: function (data) {
            contentSearchFilterData = data.contentSearchFilterData;
            $(data.containerSelector).html(initGroupsField());

            $(document).on('change', '.GroupFilters-item input[type="checkbox"]', function () {
                // var thisCheckedStatus = $(this).is(':checked');
                // $(this).parents('.GroupFilters').find('input[type="checkbox"]').prop('checked', false);
                // if (thisCheckedStatus) {
                //     $(this).prop('checked', true);
                // } else {
                //     $(this).prop('checked', false);
                // }
                var newUrl = TagManager.refreshUrlBasedOnSelectedTags();
                TagManager.refreshPageTagsBadge();
                sortSelectedItems();
                Alaasearch.loadDataBasedOnNewFilter(newUrl);
            });

            $('.SearchBoxFilter').sticky({
                topSpacing: $('#m_header').height(),
                bottomSpacing: 60,
                scrollDirectionSensitive: true,
                unstickUnder: 1025,
                zIndex: 98
            });

            $('.showSearchBoxBtnWrapperColumn').sticky({
                topSpacing: $('#m_header').height(),
                unstickUnder: false,
                zIndex: 98
            });

            $(document).on('click', '#m_aside_left_hide_toggle', function () {
                $('.SearchBoxFilter').update();
            });

            checkFilterBasedOnUrlTags(data.tags);
            sortSelectedItems();
        }
    }
}();

$('.notFoundMessage').fadeOut(0);

jQuery(document).ready(function () {

    initFilterOptions.init({
        contentSearchFilterData: contentSearchFilterData,
        containerSelector: '.SearchBoxFilter',
        tags: tags
    });


    $(document).on('click',  '.btnShowSearchBoxInMobileView', function () {
        $('.SearchBoxFilterColumn').removeClass('filterStatus-close');
        $('.SearchBoxFilterColumn').addClass('filterStatus-open');
    });
    $(document).on('click',  '.btnHideSearchBoxInMobileView', function () {
        $('.SearchBoxFilterColumn').addClass('filterStatus-close');
        $('.SearchBoxFilterColumn').removeClass('filterStatus-open');
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
