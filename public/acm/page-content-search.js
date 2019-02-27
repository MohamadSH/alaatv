var Alaasearch = function () {

    var videoAjaxLock = 0;
    var setAjaxLock = 0;

    function getProductCarouselItem(data) {
        let widgetActionLink = data.url;
        let widgetActionName = 'مشاهده و خرید';
        let widgetPic = data.photo;
        let widgetTitle = data.name;
        let price = data.price;
        let priceHtml = '';
        if (price.base !== price.final) {
            priceHtml =
                '                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">\n'+
                '                                    <span class = "m-badge m-badge--warning a--productRealPrice">'+price.base.toLocaleString('fa')+'</span>\n' +
                '                                    '+price.final.toLocaleString('fa')+' تومان \n' +
                '                                    <span class = "m-badge m-badge--info a--productDiscount">'+((1-(price.final/price.base))*100)+'%</span>\n' +
                '                                </span>';
        } else {
            priceHtml =
                '                                <span class = "m-widget6__text m--align-right m--font-boldest m--font-primary">\n'+
                '                                    '+price.final.toLocaleString('fa')+' تومان \n' +
                '                                </span>';
        }
        return '<div class = "item">\n' +
            '    <!--begin:: Widgets/Blog-->\n' +
            '    <div class = "m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force" style="min-height-: 286px">\n' +
            '        <div class = "m-portlet__head m-portlet__head--fit">\n' +
            '            <div class = "m-portlet__head-caption">\n' +
            '                <div class = "m-portlet__head-action">\n' +
            '                    <a href="'+widgetActionLink+'" class = "btn btn-sm m-btn--pill btn-brand">'+widgetActionName+'</a>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '        <div class = "m-portlet__body">\n' +
            '            <div class = "m-widget19">\n' +
            '                <div class = "m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" >\n' +
            '                    <img src = "'+widgetPic+'" alt = "'+widgetTitle+'"/>\n' +
            '                    <div class = "m-widget19__shadow"></div>\n' +
            '                </div>\n' +
            '                <div class = "m-widget19__content">\n' +
            '                    <div class="m--margin-top-10">\n' +
            '                        <a href = "'+widgetActionLink+'" class = "m-link">\n' +
            '                            <h6>\n' +
            '                                <span class="m-badge m-badge--info m-badge--dot"></span> '+widgetTitle+'\n' +
            '                            </h6>\n' +
            '                        </a>\n' +
            '                    </div>\n' +
            '                    <div class = "m-widget19__header m--margin-top-10">\n' +
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

        var widgetCount = data.contents_count ;
        var widgetLink = data.url;
        return '<div class = \"item\"> \
    <!--begin:: Widgets/Blog--> \
    <div class = \"m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force\" style=\"min-height-: 286px\"> \
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
            '                    <div class="m--margin-top-10">\n' +
            '                        <a href = "'+widgetActionLink+'" class = "m-link">\n' +
            '                            <h6>\n' +
            '                                <span class="m-badge m-badge--info m-badge--dot"></span> '+widgetTitle+'\n' +
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

    function getVideoCarouselItem(data) {

        let widgetActionLink = data.url;
        let widgetActionName = 'پخش / دانلود';
        let widgetPic = (typeof (data.photo) === 'undefined' || data.photo == null) ? data.thumbnail : data.photo;
        let widgetTitle = data.name;
        let widgetAuthor = {
            photo : data.author.photo,
            name: data.author.firstName,
            full_name: data.author.full_name
        };

        var widgetLink = data.url;
        return '<div class = \"item\"> \
    <!--begin:: Widgets/Blog--> \
    <div class = \"m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force\" style=\"min-height-: 286px\"> \
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
            '                    <div class="m--margin-top-10">\n' +
            '                        <a href = "'+widgetActionLink+'" class = "m-link">\n' +
            '                            <h6>\n' +
            '                                <span class="m-badge m-badge--info m-badge--dot"></span> '+widgetTitle+'\n' +
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
                    <a href = \"' + widgetLink +'\" class = \"btn m-btn--pill    btn-outline-warning m-btn m-btn--outline-2x \">نمایش فیلم های این دوره</a> \
                </div> --> \
            </div> \
        </div> \
    </div> \
    <!--end:: Widgets/Blog--> \
</div>';
    }

    function makeWidgetFromJsonResponse(data, type) {
        if (type === 'product') {
            return getProductCarouselItem(data);
        } else if (type === 'video') {
            return getVideoCarouselItem(data);
        } else if (type === 'set') {
            return getSetCarouselItem(data);
        }
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
                        addContentToOwl(owl, response.result[type].data, type);
                        // responseMessage = response.responseText;
                        callback(response.result[type].next_page_url);
                        removeLoadingItem(owl);
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
                        removeLoadingItem(owl);
                    }
                }
            }
        );
    }

    function lockAjax(type) {
        switch (type) {
            case 'video':
                videoAjaxLock = 1;
                break;
            case 'set':
                setAjaxLock = 1;
        }
    }
    function unLockAjax(type) {
        switch (type) {
            case 'video':
                videoAjaxLock = 0;
                break;
            case 'set':
                setAjaxLock = 0;
        }
    }

    function load(event, nextPageUrl, owl, owlType, callback) {

        var perPage = typeof (owl.data("per-page")) === "number" ? owl.data("per-page") : 6;

        // console.log('per page:' + perPage);
        // console.log('nextPageUrl:' + nextPageUrl);
        // console.log('event.property.name',event.property.name);
        // console.log('event.property.value',event.property.value);
        // console.log('event.relatedTarget.items().length - perPage',event.relatedTarget.items().length - perPage);
        if (nextPageUrl
            && event.namespace && event.property.name === 'position'
            && event.property.value >= event.relatedTarget.items().length - perPage) {
            lockAjax(owlType);
            // load, add and update
            // console.log("next page Url: " + nextPageUrl);
            loadData(owl, nextPageUrl, owlType,callback);
            // console.log([currentPage,lastPage,nextPage]);
        }
    }

    function loadAjaxVideo() {
        $('#video-carousel.owl-carousel').on('change.owl.carousel', function(event) {
            var owlType = "video";
            var nextPageUrl = $('#owl--js-var-next-page-video-url');
            var owl = $(this);

            if( !videoAjaxLock ) {

                load(event, nextPageUrl.val(), owl, owlType,function (newPageUrl) {
                    // console.log("PRE:" + nextPageUrl.val());
                    nextPageUrl.val(decodeURI(newPageUrl));
                    // console.log("NEW:" + nextPageUrl.val());
                    unLockAjax(owlType);
                });
            }
        });
    }
    function loadAjaxProduct() {
        $('#product-carousel.owl-carousel').on('change.owl.carousel', function(event) {
            var owlType = 'product';
            var nextPageUrl = $('#owl--js-var-next-page-product-carousel-url');
            var owl = $(this);

            if( !videoAjaxLock ) {
                load(event, nextPageUrl.val(), owl, owlType,function (newPageUrl) {
                    // console.log("PRE:" + nextPageUrl.val());
                    nextPageUrl.val(decodeURI(newPageUrl));
                    // console.log("NEW:" + nextPageUrl.val());
                    unLockAjax(owlType);
                });
            }
        });
    }
    function loadAjaxSet() {
        $('#set-carousel.owl-carousel').on('change.owl.carousel', function(event) {
            var owlType = "set";
            var nextPageUrl = $('#owl--js-var-next-page-set-url');
            var owl = $(this);
            // console.log("nextPageUrl:"+nextPageUrl.val());
            if( !setAjaxLock ) {
                // console.log("se Ajax is not lock!");
                load(event, nextPageUrl.val(), owl, owlType,function (newPageUrl) {
                     // console.log("PRE:" + nextPageUrl.val());
                    nextPageUrl.val(decodeURI(newPageUrl));
                     // console.log("NEW:" + nextPageUrl.val());
                    unLockAjax(owlType);
                });
            }
        });
    }
    function loadAjaxPamphlet(callback) {

    }
    function loadAjaxContent() {
        addLoadingItem($(this));
        loadAjaxProduct();
        loadAjaxVideo();
        loadAjaxSet();
    }

    function addLoadingItem(owl) {
        // owl.owlCarousel('add', '<div><div style="width: 30px; display: inline-block;" class="m-loader m-loader--warning m-loader--lg"></div></div>')
        //     .owlCarousel('update');
    }

    function removeLoadingItem(owl) {
        // let lastIndex = owl.find('.owl-item').length;
        // $(".owl-carousel").trigger('remove.owl.carousel', [lastIndex]).trigger('refresh.owl.carousel');
    }

    return {
        init: function () {
            loadAjaxContent();
        }
    }
}();

jQuery(document).ready( function() {
    Alaasearch.init();
});