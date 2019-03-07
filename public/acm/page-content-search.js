var Alaasearch = function () {

    var productAjaxLock = 0;
    var videoAjaxLock = 0;
    var setAjaxLock = 0;
    var pamphletAjaxLock = 0;

    function getProductCarouselItem(data) {
        let widgetActionLink = data.url;
        let widgetActionName = 'مشاهده و خرید';
        let widgetPic = data.photo;
        let widgetTitle = data.name;
        let price = data.price;
        let priceHtml = '';
        if (price.base !== price.final) {
            priceHtml =
                '                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">\n' +
                '                                    <span class = "m-badge m-badge--warning a--productRealPrice">' + price.base.toLocaleString('fa') + '</span>\n' +
                '                                    ' + price.final.toLocaleString('fa') + ' تومان \n' +
                '                                    <span class = "m-badge m-badge--info a--productDiscount">' + ((1 - (price.final / price.base)) * 100) + '%</span>\n' +
                '                                </span>';
        } else {
            priceHtml =
                '                                <span class = "m-widget6__text m--align-right m--font-boldest m--font-primary">\n' +
                '                                    ' + price.final.toLocaleString('fa') + ' تومان \n' +
                '                                </span>';
        }
        return '<div class = "item">\n' +
            '    <!--begin:: Widgets/Blog-->\n' +
            '    <div class = "m-portlet m-portlet--bordered-semi m-portlet--rounded-force">\n' +
            '        <div class = "m-portlet__head m-portlet__head--fit">\n' +
            '            <div class = "m-portlet__head-caption">\n' +
            '                <div class = "m-portlet__head-action">\n' +
            '                    <a href="' + widgetActionLink + '" class = "btn btn-sm m-btn--pill btn-brand">' + widgetActionName + '</a>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '        <div class = "m-portlet__body">\n' +
            '            <div class = "m-widget19">\n' +
            '                <div class = "m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" >\n' +
            '                    <img src = "' + widgetPic + '" alt = "' + widgetTitle + '"/>\n' +
            '                    <div class = "m-widget19__shadow"></div>\n' +
            '                </div>\n' +
            '                <div class = "m-widget19__content">\n' +
            '                    <div class="owl-carousel-fileTitle">\n' +
            '                        <a href = "' + widgetActionLink + '" class = "m-link">\n' +
            '                            <h6>\n' +
            '                                <span class="m-badge m-badge--info m-badge--dot"></span> ' + widgetTitle + '\n' +
            '                            </h6>\n' +
            '                        </a>\n' +
            '                    </div>\n' +
            '                    <div class = "m-widget19__header">\n' +
            '                        <div class = "m-widget19__info">\n' +
            priceHtml +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <!--end:: Widgets/Blog-->\n' +
            '</div>';
    }

    function getVideoCarouselItem(data) {

        let widgetActionLink = data.url;
        let widgetActionName = 'پخش / دانلود';
        let widgetPic = (typeof (data.photo) === 'undefined' || data.photo == null) ? data.thumbnail : data.photo;
        let widgetTitle = data.name;
        let widgetAuthor = {
            photo: data.author.photo,
            name: data.author.firstName,
            full_name: data.author.full_name
        };

        var widgetLink = data.url;
        return '<div class = \"item\"> \
    <!--begin:: Widgets/Blog--> \
    <div class = \"m-portlet m-portlet--bordered-semi m-portlet--rounded-force\"> \
        <div class = \"m-portlet__head m-portlet__head--fit\"> \
            <div class = \"m-portlet__head-caption\"> \
                <div class = \"m-portlet__head-action\"> \
                    <a href=\"' + widgetActionLink + '\" class = \"btn btn-sm m-btn--pill btn-brand\">' + widgetActionName + '</a> \
                </div> \
            </div> \
        </div> \
        <div class = \"m-portlet__body\"> \
            <div class = \"m-widget19\"> \
                <div class = \"m-widget19__pic m-portlet-fit--top m-portlet-fit--sides\" > \
                    <img src = \"' + widgetPic + '\" alt = \" ' + widgetTitle + '\"/> \
                    <div class = \"m-widget19__shadow\"></div> \
                </div> \
                <div class = \"m-widget19__content\"> \n' +
            '                    <div class="owl-carousel-fileTitle">\n' +
            '                        <a href = "' + widgetActionLink + '" class = "m-link">\n' +
            '                            <h6>\n' +
            '                                <span class="m-badge m-badge--info m-badge--dot"></span> ' + widgetTitle + '\n' +
            '                            </h6>\n' +
            '                        </a>\n' +
            '                    </div>\
                    <div class = \"m-widget19__header\"> \
                        <div class = \"m-widget19__user-img\"> \
                            <img class = \"m-widget19__img\" src = \" ' + widgetAuthor.photo + '\" alt = \"' + widgetAuthor.name + '\"> \
                        </div> \
                        <div class = \"m-widget19__info\"> \
                            <span class = \"m-widget19__username\"> \
                            ' + widgetAuthor.full_name + ' \
                            </span> \
                            <br> \
                            <span class = \"m-widget19__time\"> \
                            موسسه غیرتجاری آلاء \
                            </span> \
                        </div> \
                    </div> \
                </div> \
                <!--<div class = \"m-widget19__action\"> \
                    <a href = \"' + widgetLink + '\" class = \"btn m-btn--pill    btn-outline-warning m-btn m-btn--outline-2x \">نمایش فیلم های این دوره</a> \
                </div> --> \
            </div> \
        </div> \
    </div> \
    <!--end:: Widgets/Blog--> \
</div>';
    }

    function getSetCarouselItem(data) {

        let widgetActionLink = data.url;
        let widgetActionName = 'نمایش این دوره';
        let widgetPic = (typeof (data.photo) === 'undefined' || data.photo == null) ? data.thumbnail : data.photo;
        let widgetTitle = data.name;
        let widgetAuthor = {
            photo : data.author.photo,
            name: data.author.firstName,
            full_name: data.author.full_name
        };

        var widgetCount = data.contents_count;
        var widgetLink = data.url;
        return '<div class = \"item\"> \
    <!--begin:: Widgets/Blog--> \
    <div class = \"m-portlet m-portlet--bordered-semi m-portlet--rounded-force\"> \
        <div class = \"m-portlet__head m-portlet__head--fit\"> \
            <div class = \"m-portlet__head-caption\"> \
                <div class = \"m-portlet__head-action\"> \
                    <a href=\"' + widgetActionLink +'\" class = \"btn btn-sm m-btn--pill btn-brand\">' + widgetActionName + '</a> \
                </div> \
            </div> \
        </div> \
        <div class = \"m-portlet__body\"> \
            <div class = \"m-widget19\"> \
                <div class = \"m-widget19__pic m-portlet-fit--top m-portlet-fit--sides\" > \
                    <img src = \"'+ widgetPic +'\" alt = \" ' + widgetTitle +'\"/> \
                    <div class = \"m-widget19__shadow\"></div> \
                </div> \
                <div class = \"m-widget19__content\"> \n' +
            '                    <div class="owl-carousel-fileTitle">\n' +
            '                        <a href = "' + widgetActionLink + '" class = "m-link">\n' +
            '                            <h6>\n' +
            '                                <span class="m-badge m-badge--info m-badge--dot"></span> ' + widgetTitle + '\n' +
            '                            </h6>\n' +
            '                        </a>\n' +
            '                    </div>\
                    <div class = \"m-widget19__header\"> \
                        <div class = \"m-widget19__user-img\"> \
                            <img class = \"m-widget19__img\" src = \" ' + widgetAuthor.photo + '\" alt = \"' + widgetAuthor.name + '\"> \
                        </div> \
                        <div class = \"m-widget19__info\"> \
                            <span class = \"m-widget19__username\"> \
                            ' + widgetAuthor.full_name + ' \
                            </span> \
                            <br> \
                            <span class = \"m-widget19__time\"> \
                            موسسه غیرتجاری آلاء \
                            </span> \
                        </div> \
                        <div class = \"m-widget19__stats\"> \
                            <span class = \"m-widget19__number m--font-brand\"> \
                            ' + widgetCount + ' \
                            </span> \
                            <span class = \"m-widget19__comment\"> \
                            محتوا  \
                            </span> \
                        </div> \
                    </div> \
                </div> \
                <!--<div class = \"m-widget19__action\"> \
                    <a href = \"' + widgetLink +'\" class = \"btn m-btn--pill    btn-outline-warning m-btn m-btn--outline-2x \">نمایش فیلم های این دوره</a> \
                </div> --> \
            </div> \
        </div> \
    </div> \
    <!--end:: Widgets/Blog--> \
</div>';
    }

    function getSetPamphletItem(data) {

        let widgetActionLink = data.url;
        let widgetTitle = data.name;
        let widgetThumbnail = data.thumbnail;
        let widgetAuthor = {
            photo: data.author.photo,
            name: data.author.firstName,
            full_name: data.author.full_name
        };
        if (widgetThumbnail !== null && widgetThumbnail.length !== 0) {
            widgetThumbnail =
                '                                                    <div class="m-widget4__img m-widget4__img--pic">\n' +
                '                                                        <img src="{{ $content->thumbnail }}" alt="' + widgetTitle + '">\n' +
                '                                                    </div>\n';
        } else {
            widgetThumbnail = '';
        }
        return '\n' +
            '                                            <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">\n' +
            '                                                <div class="m-widget4__img m-widget4__img--pic">\n' +
            '                                                    <img src="' + widgetAuthor.photo + '" alt="">\n' +
            '                                                </div>\n' +
            '                                                <div class="m-widget4__info">\n' +
            '                                                        <span class="m-widget4__title">\n' +
            '                                                            <a href="' + widgetActionLink + '" class="m-link">\n' +
            '                                                                ' + widgetTitle + '\n' +
            '                                                            </a>\n' +
            '                                                        </span>\n' +
            '                                                    <br>\n' +
            '                                                    <span class="m-widget4__sub">\n' +
            '                                                            <a href="' + widgetActionLink + '" class="m-link">\n' +
            '                                                                ' + widgetAuthor.full_name + '\n' +
            '                                                            </a>\n' +
            '                                                        </span>\n' +
            '                                                </div>\n' +
            widgetThumbnail +
            '                                            </div>';
    }


    function makeWidgetFromJsonResponse(data, type) {
        switch (type) {
            case 'product':
                return getProductCarouselItem(data);
            case 'video':
                return getVideoCarouselItem(data);
            case 'set':
                return getSetCarouselItem(data);
            case 'pamphlet':
                return getSetPamphletItem(data);
            case 'article':
                return getSetPamphletItem(data);
        }
    }

    function addContentToVerticalWidget(vw, data, type) {
        $.each(data, function (index, value) {
            vw.append(makeWidgetFromJsonResponse(value, type));
        });
    }
    function addContentToOwl(owl, data, type) {
        $.each(data, function (index, value) {
            owl.trigger('add.owl.carousel',
                [
                    // jQuery('<div class="owl-item">' + makeWidgetFromJsonResponse(value) + '</div>');
                    jQuery(makeWidgetFromJsonResponse(value, type))
                ]
            );
        });
        owl.trigger('refresh.owl.carousel');
    }
    function ajaxSetup() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
            }
        });
    }
    function loadData(owl , action,type,callback) {
        ajaxSetup();

        var fetchMoreData = $.ajax({
                type: "GET",
                url: action,
            accept: "application/json; charset=utf-8",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                statusCode: {
                    200:function (response) {
                        removeLoadingItem(owl, type);

                        if (type === 'product' || type === 'video' || type === 'set') {
                            addContentToOwl(owl, response.result[type].data, type);
                        } else if (type === 'pamphlet' || type === 'article') {
                            addContentToVerticalWidget(owl, response.result[type].data, type);
                        }

                        // responseMessage = response.responseText;
                        callback(response.result[type].next_page_url);
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
                    500: function (response) {
                        console.log(response);
                        removeLoadingItem(owl, type);
                    }
                }
            }
        );
    }

    function lockAjax(type) {
        switch (type) {
            case 'product':
                productAjaxLock = 1;
                break;
            case 'video':
                videoAjaxLock = 1;
                break;
            case 'set':
                setAjaxLock = 1;
                break;
            case 'pamphlet':
                pamphletAjaxLock = 1;
                break;
            case 'article':
                pamphletAjaxLock = 1;
                break;
        }
    }
    function unLockAjax(type) {
        switch (type) {
            case 'product':
                productAjaxLock = 0;
                break;
            case 'video':
                videoAjaxLock = 0;
                break;
            case 'set':
                setAjaxLock = 0;
                break;
            case 'pamphlet':
                pamphletAjaxLock = 0;
                break;
            case 'article':
                pamphletAjaxLock = 0;
                break;
        }
    }

    function load(event, nextPageUrl, owl, owlType, callback) {


        if (owlType === 'product' || owlType === 'video' || owlType === 'set') {
            var perPage = typeof (owl.data("per-page")) === "number" ? owl.data("per-page") : 6;

            // console.log('per page:' + perPage);
            // console.log('nextPageUrl:' + nextPageUrl);
            // console.log('event.property.name',event.property.name);
            // console.log('event.property.value',event.property.value);
            // console.log('event.relatedTarget.items().length - perPage',event.relatedTarget.items().length - perPage);
            if (nextPageUrl !== null && nextPageUrl.length !== 0
                && event.namespace && event.property.name === 'position'
                && event.property.value >= event.relatedTarget.items().length - perPage) {
                lockAjax(owlType);
                addLoadingItem(owl, owlType);
                // load, add and update
                // console.log("next page Url: " + nextPageUrl);
                loadData(owl, nextPageUrl, owlType, callback);
                // console.log([currentPage,lastPage,nextPage]);
            }
        } else if (owlType === 'pamphlet' || owlType === 'article') {
            lockAjax(owlType);
            addLoadingItem(owl, owlType);
            loadData(owl, nextPageUrl, owlType, callback);
        }

    }

    function loadProductFromJson(data) {
        addContentToOwl($('#product-carousel.owl-carousel'), data.data, 'product');
        $('#owl--js-var-next-page-product-carousel-url').val(decodeURI(data.next_page_url));
    }

    function initProduct(data) {
        loadProductFromJson(data);
        $('#product-carousel.owl-carousel').on('change.owl.carousel', function (event) {
            let owlType = 'product';
            let nextPageUrl = $('#owl--js-var-next-page-product-carousel-url');
            let owl = $(this);
            // console.log("productAjaxLock:" + productAjaxLock);
            if (!productAjaxLock) {
                load(event, nextPageUrl.val(), owl, owlType, function (newPageUrl) {
                    // console.log("PRE:" + $('#owl--js-var-next-page-product-carousel-url').val());
                    if (newPageUrl === null) {
                        newPageUrl = '';
                    }
                    $('#owl--js-var-next-page-product-carousel-url').val(decodeURI(newPageUrl));
                    // console.log("NEW:" + $('#owl--js-var-next-page-product-carousel-url').val());
                    unLockAjax(owlType);
                    // console.log("productAjaxLock:" + productAjaxLock);
                });
            }
        });
    }

    function loadVideoFromJson(data) {
        addContentToOwl($('#video-carousel.owl-carousel'), data.data, 'video');
        $('#owl--js-var-next-page-video-url').val(decodeURI(data.next_page_url));
    }

    function initVideo(data) {
        loadVideoFromJson(data);
        $('#video-carousel.owl-carousel').on('change.owl.carousel', function(event) {
            var owlType = "video";
            var nextPageUrl = $('#owl--js-var-next-page-video-url');
            var owl = $(this);

            if( !videoAjaxLock ) {

                load(event, nextPageUrl.val(), owl, owlType,function (newPageUrl) {
                    // console.log("PRE:" + nextPageUrl.val());
                    $('#owl--js-var-next-page-video-url').val(decodeURI(newPageUrl));
                    // console.log("NEW:" + nextPageUrl.val());
                    unLockAjax(owlType);
                });
            }
        });
    }

    function loadSetFromJson(data) {
        addContentToOwl($('#set-carousel.owl-carousel'), data.data, 'video');
        $('#owl--js-var-next-page-set-url').val(decodeURI(data.next_page_url));
    }

    function initSet(data) {
        loadSetFromJson(data);
        $('#set-carousel.owl-carousel').on('change.owl.carousel', function(event) {
            var owlType = "set";
            var nextPageUrl = $('#owl--js-var-next-page-set-url');
            var owl = $(this);
            // console.log("nextPageUrl:"+nextPageUrl.val());
            if( !setAjaxLock ) {
                // console.log("se Ajax is not lock!");
                load(event, nextPageUrl.val(), owl, owlType,function (newPageUrl) {
                    // console.log("PRE:" + nextPageUrl.val());
                    $('#owl--js-var-next-page-set-url').val(decodeURI(newPageUrl));
                    // console.log("NEW:" + nextPageUrl.val());
                    unLockAjax(owlType);
                });
            }
        });
    }

    function loadPamphletFromJson(data) {
        $('#pamphlet-vertical-widget').find('.pamphlet-lastITemSensor').remove();
        addContentToVerticalWidget($('#pamphlet-vertical-widget'), data.data, 'pamphlet');
        $('#vertical-widget--js-var-next-page-pamphlet-url').val(decodeURI(data.next_page_url));
        $('#pamphlet-vertical-widget').append('<div class="pamphlet-lastITemSensor"></div>');
    }

    function initPamphlet(data) {
        loadPamphletFromJson(data);

        $(window).scroll(function () {
            if (isScrolledIntoView($('.pamphlet-lastITemSensor'))) {

                let vwType = 'pamphlet';
                let nextPageUrl = $('#vertical-widget--js-var-next-page-pamphlet-url');
                let vw = $('#pamphlet-vertical-widget');

                if (!pamphletAjaxLock) {
                    load(event, nextPageUrl.val(), vw, vwType, function (newPageUrl) {
                        $('#vertical-widget--js-var-next-page-pamphlet-url').val(decodeURI(newPageUrl));
                        unLockAjax(vwType);
                    });
                }

            }
        });
    }

    function loadArticleFromJson(data) {
        $('#pamphlet-vertical-widget').find('.article-lastITemSensor').remove();
        addContentToVerticalWidget($('#article-vertical-widget'), data.data, 'article');
        $('#vertical-widget--js-var-next-page-article-url').val(decodeURI(data.next_page_url));
        $('#pamphlet-vertical-widget').append('<div class="article-lastITemSensor"></div>');
    }

    function initArticle(data) {
        loadArticleFromJson(data);

        $(window).scroll(function () {
            if (isScrolledIntoView($('.article-lastITemSensor'))) {

                let vwType = 'pamphlet';
                let nextPageUrl = $('#vertical-widget--js-var-next-page-article-url');
                let vw = $('#article-vertical-widget');

                if (!pamphletAjaxLock) {
                    load(event, nextPageUrl.val(), vw, vwType, function (newPageUrl) {
                        $('#vertical-widget--js-var-next-page-article-url').val(decodeURI(newPageUrl));
                        unLockAjax(vwType);
                    });
                }

            }
        });
    }

    function loadAjaxContent(contentData) {
        if (typeof contentData.product !== 'undefined') {
            initProduct(contentData.product);
        } else {
            $('#product-carousel-warper').fadeOut();
        }
        if (typeof contentData.video !== 'undefined') {
            initVideo(contentData.video);
        } else {
            $('#video-carousel-warper').fadeOut();
        }
        if (typeof contentData.set !== 'undefined') {
            initSet(contentData.set);
        } else {
            $('#set-carousel-warper').fadeOut();
        }
        if (typeof contentData.pamphlet !== 'undefined') {
            initPamphlet(contentData.pamphlet);
        } else {
            $('#set-carousel-warper').fadeOut();
        }
        if (typeof contentData.article !== 'undefined') {
            initArticle(contentData.article);
        } else {
            $('#set-carousel-warper').fadeOut();
        }
    }

    function addLoadingItem(owl, owlType) {
        if (owlType === 'product' || owlType === 'video' || owlType === 'set') {
            let loadingHtml = '<div class="a--owlCarouselLoading"><div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div></div>';
            owl.trigger('add.owl.carousel',
                [
                    jQuery(loadingHtml)
                ]
            );
        } else if (owlType === 'pamphlet' || owlType === 'article') {
            owl.append('<div class="a--vw-Loading"><div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div></div>');
        }
    }

    function removeLoadingItem(owl, owlType) {
        if (owlType === 'product' || owlType === 'video' || owlType === 'set') {
            let lastIndex = owl.find('.owl-item').length;
            owl.trigger('remove.owl.carousel', [lastIndex - 1])
                .trigger('refresh.owl.carousel');
        } else if (owlType === 'pamphlet' || owlType === 'article') {
            owl.find('.a--vw-Loading').remove();
        }
    }

    function isScrolledIntoView(elem) {
        if (elem.length === 0) {
            return false;
        }
        let docViewTop = $(window).scrollTop();
        let docViewBottom = docViewTop + $(window).height();
        let elemTop = $(elem).offset().top;
        let elemBottom = elemTop + $(elem).height();
        return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom) && (elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }



    return {
        init: function (contentData) {
            loadAjaxContent(contentData);
        }
    }
}();

jQuery(document).ready( function() {
    console.log(contentData);
    Alaasearch.init(contentData);
});