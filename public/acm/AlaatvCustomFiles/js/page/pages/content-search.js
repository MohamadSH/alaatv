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
        var counter = 0;
        for(var i = 0; (typeof productRepository[i] !== 'undefined'); i++) {
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
        for(var i = 0; (typeof videoRepository[i] !== 'undefined'); i++) {
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
    function appendVideoOrProduct(type) {
        var counter = 0;
        for(var i = 0; ((type === 'product' && typeof productRepository[i] !== 'undefined') || (type === 'video' && typeof videoRepository[i] !== 'undefined')); i++) {
            if ((type === 'product' && productRepository[i] === null) || (type === 'video' && videoRepository[i] === null)) {
                continue;
            }
            listTypeHasItem = true;
            var listItem;
            if (type === 'product') {
                listItem = getProductItem(productRepository[i], i);
                productRepository[i] = null;
            } else if (type === 'video') {
                listItem = getContentItem(videoRepository[i]);
                videoRepository[i] = null;
            }
            $('.searchResult .listType').append(listItem);

            counter++;
            if ((type === 'product' && counter === productRepositoryCounter) || (type === 'video' && counter === videoRepositoryCounter)) {
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
            gtmEecProductCategory: ((data.category===null || data.category.trim().length===0)?'-':data.category),
            widgetActionLink: data.url.web,
            widgetPic: data.photo,
            widgetTitle: data.title,
            price: {
                base: data.price.base,
                discount: data.price.discount,
                final: data.price.final
            },
            attributes: {
                productionYear: data.attributes.info.productionYear,
                major: data.attributes.info.major,
                educationalSystem: data.attributes.info.educationalSystem,
                shippingMethod: data.attributes.info.shippingMethod,
                teacher: data.attributes.info.teacher,
                services: data.attributes.info.services.join(', '),
            }
        };
    }
    function contentItemAdapter(data) {
        return {
            widgetPic: data.photo + '?w=444&h=250',
            widgetTitle: data.title,
            widgetLink: data.url.web,
            description: data.body,
            videoOrder: data.order,
            updatedAt: data.updated_at,
            setName: (typeof data.set !== 'undefined') ? data.set.short_title : '-'
        };
    }
    function setItemAdapter(data) {
        return {
            widgetPic: (typeof (data.photo) === 'undefined' || data.photo === null) ? 'https://cdn.alaatv.com/loder.jpg?w=253&h=142' : data.photo + '?w=253&h=142',
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

        var shortDescription = '' +
            '<div class="productAttributes">' +
            '  <div class="productAttributes-item">' +
            '    <div class="productAttributes-item-icon">' +
            '      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">' +
            '        <polygon style="fill:#FF9000" points="145.454,209.709 249.289,483.58 261.634,483.58 365.468,209.709 " data-original="#70BBEF" class="active-path" data-old_color="#70BBEF"></polygon>' +
            '        <path style="fill:#FF9E20" d="M232.914,474.449c4.335,4.886,10.17,7.927,16.375,9.132L145.454,209.71L0.322,163.994  C0.983,168.9-14.703,145.691,232.914,474.449z" data-original="#9CD7F2" data-old_color="#9CD7F2"></path>' +
            '        <path style="fill:#FF9409" d="M51.695,180.177L0.322,163.995c0.661,4.905-15.024-18.304,232.592,310.453  c3.21,3.618,7.245,6.219,11.642,7.817L51.695,180.177z" data-original="#71C5DB" class="" data-old_color="#71C5DB"></path>' +
            '        <path style="fill:#FF9E20" d="M86.074,51.099l59.38,158.611L255.461,84.212L88.081,50.102   C87.354,50.418,86.681,50.753,86.074,51.099z" data-original="#9CD7F2" class="" data-old_color="#9CD7F2"></path>\n' +
            '        <path style="fill:#FF9E20" d="M365.468,209.71L261.634,483.58c6.205-1.205,12.039-4.246,16.375-9.132   c64.394-85.292,233.353-308.79,233.863-310.854L365.468,209.71z" data-original="#9CD7F2" class="" data-old_color="#9CD7F2"></path>\n' +
            '        <path style="fill:#FF9E20" d="M365.468,209.71l59.361-158.56c-0.7-0.398-1.396-0.735-2.074-1.03L255.461,84.212L365.468,209.71z" data-original="#9CD7F2" class="" data-old_color="#9CD7F2"></path>\n' +
            '        <polygon style="fill:#E98400" points="145.454,209.709 365.468,209.709 255.461,84.212 " data-original="#57ADDD" class="" data-old_color="#57ADDD"></polygon>' +
            '        <path style="fill:#FF9000" d="M86.074,51.099c-3.916,2.227-4.52,3.544-10.676,11.438C-4.743,165.306-0.551,157.536,0.322,163.994  l145.132,45.715L86.074,51.099z" data-original="#70BBEF" class="active-path" data-old_color="#70BBEF"></path>' +
            '        <path style="fill:#E98400" d="M51.695,180.177L87.063,53.74l-0.989-2.642c-3.915,2.227-4.52,3.544-10.676,11.438  c-80.142,102.77-75.949,95-75.077,101.458L51.695,180.177L51.695,180.177z" data-original="#57ADDD" class="" data-old_color="#57ADDD"></path>' +
            '        <path style="fill:#FF9000" d="M365.468,209.71l146.403-46.115c0.413-2.149-0.209-3.422-1.25-4.756  C438.018,65.634,427.949,51.909,424.829,51.15L365.468,209.71z" data-original="#70BBEF" class="active-path" data-old_color="#70BBEF"></path>' +
            '        <path style="fill:#E98400" d="M255.461,84.212L422.756,50.12c-3.521-1.527-6.327-1.748-6.433-1.767l0,0l-134.829-18.16  c-42.419-5.714-60.701,2.923-187.247,18.208c-0.195,0.042-2.915,0.287-6.166,1.702L255.461,84.212z" data-original="#57ADDD" class="" data-old_color="#57ADDD"></path>' +
            '      </svg>' +
            '    </div>' +
            '    <div class="productAttributes-item-value">'+productItemData.attributes.services+'</div>' +
            '  </div>' +
            '  <div class="productAttributes-item">' +
            '    <div class="productAttributes-item-icon">' +
            '      <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" class="">' +
            '        <g>' +
            '          <g id="Direction">' +
            '            <g fill="#c49a6c">' +
            '              <path d="m27 21h10v6h-10z" data-original="#C49A6C" class=""></path>' +
            '              <path d="m27 3h10v6h-10z" data-original="#C49A6C" class=""></path>' +
            '              <path d="m27 39h10v22h-10z" data-original="#C49A6C" class=""></path>' +
            '            </g>' +
            '            <path d="m27 39h10v2h-10z" fill="#a97c50" data-original="#A97C50"></path>' +
            '            <path d="m27 21h10v2h-10z" fill="#a97c50" data-original="#A97C50"></path>' +
            '            <path d="m37 9h-10-14l-10 6 10 6h14 10 14v-6-6z" fill="#ffda44" data-original="#FFDA44" class="active-path" style="fill:#FFDA44"></path>' +
            '            <path d="m3 15 10 6h14 10 14v-6z" fill="#ffcd00" data-original="#FFCD00"></path>' +
            '            <path d="m53 27h-16-10-14v6 6h14 10 16l8-6z" fill="#ff3051" data-original="#FF3051" class="" data-old_color="#ff3051" style="fill:#000000"></path>' +
            '            <path d="m13 39h14 10 16l8-6h-48z" fill="#e52b49" data-original="#E52B49" class="" data-old_color="#e52b49" style="fill:#000000"></path>' +
            '            <path d="m61.6 32.2-8-6a1 1 0 0 0 -.6-.2h-15v-4h13a1 1 0 0 0 1-1v-12a1 1 0 0 0 -1-1h-13v-5a1 1 0 0 0 -1-1h-10a1 1 0 0 0 -1 1v5h-13a1 1 0 0 0 -.515.143l-10 6a1 1 0 0 0 0 1.714l10 6a1 1 0 0 0 .515.143h13v4h-13a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h13v21a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-21h15a1 1 0 0 0 .6-.2l8-6a1 1 0 0 0 0-1.6zm-33.6-28.2h8v4h-8zm-23.056 11 8.333-5h36.723v10h-36.723zm23.056 7h8v4h-8zm8 38h-8v-20h8zm16.667-22h-38.667v-10h38.667l6.666 5z" data-original="#000000" class=""></path>' +
            '          </g>' +
            '        </g>' +
            '      </svg>' +
            '    </div>' +
            '    <div class="productAttributes-item-value">'+productItemData.attributes.educationalSystem+'</div>' +
            '  </div>' +
            '  <div class="productAttributes-item">' +
            '    <div class="productAttributes-item-icon">' +
            '<svg viewBox="0 0 423 423" xmlns="http://www.w3.org/2000/svg">\n' +
            '    <path fill="#FFC107" d="m368.809,81.922v327.68h-268.098c-25.367,0 -45.93,-20.566 -45.93,-45.93v-309.059"/>\n' +
            '    <path fill="#000" d="m368.809,423.254h-268.102c-32.855,0 -59.582,-26.727 -59.582,-59.582v-309.059c0,-7.539 6.113,-13.652 13.656,-13.652 7.539,0 13.652,6.113 13.652,13.652v309.059c0,17.797 14.48,32.273 32.273,32.273h254.445v-314.023c0,-7.543 6.113,-13.656 13.656,-13.656 7.539,0 13.652,6.113 13.652,13.656v327.68c0,7.539 -6.113,13.652 -13.652,13.652zM368.809,423.254"/>\n' +
            '    <path fill="#000" d="m286.887,81.922v150.184l-40.961,-27.305 -40.961,27.305v-150.184"/>\n' +
            '    <path fill="#000" d="m286.887,245.762c-2.648,0 -5.289,-0.77 -7.574,-2.297l-33.387,-22.258 -33.387,22.258c-4.199,2.789 -9.59,3.047 -14.012,0.68 -4.441,-2.379 -7.215,-7.004 -7.215,-12.039v-150.184c0,-7.543 6.113,-13.656 13.652,-13.656 7.543,0 13.656,6.113 13.656,13.656v124.672l19.73,-13.152c4.59,-3.055 10.563,-3.055 15.148,0l19.734,13.152v-124.672c0,-7.543 6.113,-13.656 13.652,-13.656 7.539,0 13.652,6.113 13.652,13.656v150.184c0,5.035 -2.773,9.66 -7.215,12.043 -2.012,1.078 -4.23,1.613 -6.438,1.613zM286.887,245.762"/>\n' +
            '    <path fill="#fff" d="m334.672,47.785c0,-18.852 15.281,-34.133 34.137,-34.133h-279.895c-18.852,0 -34.133,15.281 -34.133,34.133 0,18.852 15.281,34.137 34.133,34.137h279.895c-18.855,0 -34.137,-15.285 -34.137,-34.137zM334.672,47.785"/>\n' +
            '    <path fill="#000" d="m368.809,95.574h-279.895c-26.348,0 -47.789,-21.441 -47.789,-47.789s21.441,-47.785 47.789,-47.785h279.895c7.539,0 13.652,6.113 13.652,13.652 0,7.543 -6.113,13.656 -13.652,13.656 -11.297,0 -20.48,9.184 -20.48,20.477 0,11.293 9.184,20.48 20.48,20.48 7.539,0 13.652,6.113 13.652,13.656 0,7.539 -6.113,13.652 -13.652,13.652zM88.914,27.309c-11.293,0 -20.48,9.184 -20.48,20.477 0,11.293 9.188,20.48 20.48,20.48h236.719c-2.953,-6.215 -4.613,-13.152 -4.613,-20.48 0,-7.324 1.66,-14.266 4.613,-20.477zM88.914,27.309"/>\n' +
            '</svg>' +
            '    </div>' +
            '    <div class="productAttributes-item-value">'+productItemData.attributes.major+'</div>' +
            '  </div>' +
            '  <div class="productAttributes-item">' +
            '    <div class="productAttributes-item-icon">' +
            '<svg  viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">\n' +
            '    <path fill="#E6000000" d="m57,9h-50a4,4 0,0 0,-4 4v10h58v-10a4,4 0,0 0,-4 -4z"/>\n' +
            '    <path fill="#FFC107" d="m3,23v34a4,4 0,0 0,4 4h50a4,4 0,0 0,4 -4v-34z"/>\n' +
            '    <path fill="#000" d="m61,13a4,4 0,0 0,-4 -4h-2v14h6z"/>\n' +
            '    <path fill="#FFA500" d="m55,23v30a4,4 0,0 1,-4 4h-48a4,4 0,0 0,4 4h50a4,4 0,0 0,4 -4v-34z"/>\n' +
            '    <path fill="#FFAB00" d="m14,15a3,3 0,0 0,3 -3v-6a3,3 0,0 0,-6 0v6a3,3 0,0 0,3 3z"/>\n' +
            '    <path fill="#FFAB00" d="m50,15a3,3 0,0 0,3 -3v-6a3,3 0,0 0,-6 0v6a3,3 0,0 0,3 3z"/>\n' +
            '    <path fill="#231f20" d="m57,8h-3v-2a4,4 0,0 0,-8 0v2h-28v-2a4,4 0,0 0,-8 0v2h-3a5.006,5.006 0,0 0,-5 5v44a5.006,5.006 0,0 0,5 5h50a5.006,5.006 0,0 0,5 -5v-44a5.006,5.006 0,0 0,-5 -5zM48,6a2,2 0,0 1,4 0v6a2,2 0,0 1,-4 0zM12,6a2,2 0,0 1,4 0v6a2,2 0,0 1,-4 0zM4,13a3,3 0,0 1,3 -3h3v2a4,4 0,0 0,8 0v-2h28v2a4,4 0,0 0,8 0v-2h3a3,3 0,0 1,3 3v9h-56zM60,57a3,3 0,0 1,-3 3h-50a3,3 0,0 1,-3 -3v-33h56z"/>\n' +
            '    <path fill="#231f20" d="m37,53a0.986,0.986 0,0 1,-0.4 -0.084,1 1,0 0,1 -0.516,-1.317l6.916,-15.808v-0.791h-9a1,1 0,0 1,0 -2h10a1,1 0,0 1,1 1v2a0.991,0.991 0,0 1,-0.084 0.4l-7,16a1,1 0,0 1,-0.916 0.6z"/>\n' +
            '    <path fill="#231f20" d="m30,53h-10a1,1 0,0 1,-1 -1v-3.3a4.022,4.022 0,0 1,1.941 -3.43l6.6,-3.961a3.017,3.017 0,0 0,1.459 -2.574v-0.735a3,3 0,0 0,-3 -3h-2a3,3 0,0 0,-3 3v2a1,1 0,0 1,-2 0v-2a5.006,5.006 0,0 1,5 -5h2a5.006,5.006 0,0 1,5 5v0.735a5.023,5.023 0,0 1,-2.428 4.287l-6.6,3.961a2.012,2.012 0,0 0,-0.972 1.717v2.3h9a1,1 0,0 1,0 2z"/>\n' +
            '</svg>' +
            '    </div>' +
            '    <div class="productAttributes-item-value">'+productItemData.attributes.productionYear+'</div>' +
            '  </div>' +
            '  <div class="productAttributes-item">' +
            '    <div class="productAttributes-item-icon">' +
            '<svg  viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">\n' +
            '    <path fill="#FFFFFF" d="m9,15h46v6h-46z"/>\n' +
            '    <path fill="#FFC107" d="M7,21L57,21A4,4 0,0 1,61 25L61,57A4,4 0,0 1,57 61L7,61A4,4 0,0 1,3 57L3,25A4,4 0,0 1,7 21z"/>\n' +
            '    <path fill="#FFAB00" d="m57,21h-2v30a4,4 0,0 1,-4 4h-48v2a4,4 0,0 0,4 4h50a4,4 0,0 0,4 -4v-32a4,4 0,0 0,-4 -4z"/>\n' +
            '    <path fill="#FFAB00" d="m57,11h-25v-2a4,4 0,0 0,-4 -4h-12a4,4 0,0 0,-4 4v2h-5a4,4 0,0 0,-4 4v10a4,4 0,0 1,4 -4h2v-6h46v6h2a4,4 0,0 1,4 4v-10a4,4 0,0 0,-4 -4z"/>\n' +
            '    <path fill="#000" d="m39,21v6h-6l11.94,14 12.06,-14h-6v-6,-6 -4,-8h-12v8,4z"/>\n' +
            '    <path fill="#FFFFFF" d="m9,43h24v12h-24z"/>\n' +
            '    <path fill="#231f20" d="m57,10h-5v-7a1,1 0,0 0,-1 -1h-12a1,1 0,0 0,-1 1v7h-5v-1a5.006,5.006 0,0 0,-5 -5h-12a5.006,5.006 0,0 0,-5 5v1h-4a5.006,5.006 0,0 0,-5 5v42a5.006,5.006 0,0 0,5 5h50a5.006,5.006 0,0 0,5 -5v-42a5.006,5.006 0,0 0,-5 -5zM57,12a3,3 0,0 1,3 3v6.026a4.948,4.948 0,0 0,-3 -1.026h-1v-5a1,1 0,0 0,-1 -1h-3v-2zM52,20v-4h2v4zM40,4h10v23a1,1 0,0 0,1 1h3.819l-9.875,11.463 -9.777,-11.463h3.833a1,1 0,0 0,1 -1zM38,20h-28v-4h28zM7,12h5a1,1 0,0 0,1 -1v-2a3,3 0,0 1,3 -3h12a3,3 0,0 1,3 3v2a1,1 0,0 0,1 1h6v2h-29a1,1 0,0 0,-1 1v5h-1a4.948,4.948 0,0 0,-3 1.026v-6.026a3,3 0,0 1,3 -3zM60,57a3,3 0,0 1,-3 3h-50a3,3 0,0 1,-3 -3v-32a3,3 0,0 1,3 -3h31v4h-5a1,1 0,0 0,-0.761 1.649l11.94,14a1.048,1.048 0,0 0,0.761 0.351,1 1,0 0,0 0.758,-0.347l12.06,-14a1,1 0,0 0,-0.758 -1.653h-5v-4h5a3,3 0,0 1,3 3z"/>\n' +
            '    <path fill="#231f20" d="m33,56h-24a1,1 0,0 1,-1 -1v-12a1,1 0,0 1,1 -1h24a1,1 0,0 1,1 1v12a1,1 0,0 1,-1 1zM10,54h22v-10h-22z"/>\n' +
            '    <path fill="#231f20" d="m14,48h-1a1,1 0,0 1,0 -2h1a1,1 0,0 1,0 2z"/>\n' +
            '    <path fill="#231f20" d="m29,48h-11a1,1 0,0 1,0 -2h11a1,1 0,0 1,0 2z"/>\n' +
            '    <path fill="#231f20" d="m14,52h-1a1,1 0,0 1,0 -2h1a1,1 0,0 1,0 2z"/>\n' +
            '    <path fill="#231f20" d="m29,52h-11a1,1 0,0 1,0 -2h11a1,1 0,0 1,0 2z"/>\n' +
            '</svg>' +
            '    </div>' +
            '    <div class="productAttributes-item-value">'+productItemData.attributes.shippingMethod+'</div>' +
            '  </div>' +
            '  <div class="productAttributes-item">' +
            '    <div class="productAttributes-item-icon">' +
            '<svg viewBox="0 0 510 510" xmlns="http://www.w3.org/2000/svg">\n' +
            '    <path fill="#fff5f5" d="m27.62,50.38h454.76v364.85h-454.76z"/>\n' +
            '    <path fill="#ebe1dc" d="m255,50.38h227.38v364.85h-227.38z"/>\n' +
            '    <path fill="#000" d="m510,10.2v55.32c0,5.52 -4.48,10 -10,10h-490c-5.52,0 -10,-4.48 -10,-10v-55.32c0,-5.52 4.48,-10 10,-10h490c5.52,0 10,4.48 10,10z"/>\n' +
            '    <path fill="#000" d="m510,10.2v55.32c0,5.52 -4.48,10 -10,10h-245v-75.32h245c5.52,0 10,4.48 10,10z"/>\n' +
            '    <path fill="#000" d="m99.206,264.8c-3.864,-7.327 -12.938,-10.135 -20.265,-6.271 -7.328,3.864 -10.135,12.938 -6.271,20.265l75.644,143.438 26.536,-13.994z"/>\n' +
            '    <path fill="#FFC107" d="m495,369.61v130.19c0,5.523 -4.477,10 -10,10h-195.02c-2.761,0 -5,-2.239 -5,-5v-84.58c0,16.005 -12.971,29.06 -29.06,29.06h-85.52c-18.172,0 -32.96,-14.716 -32.96,-32.96 0,-18.2 14.75,-32.96 32.96,-32.96h46.53c2.761,0 5,-2.239 5,-5v-8.75c0,-30.321 24.58,-54.9 54.9,-54.9h163.27c30.32,0 54.9,24.579 54.9,54.9z"/>\n' +
            '    <path fill="#ff9000" d="m495,369.61v130.19c0,5.52 -4.48,10 -10,10h-131.69v-195.09h86.79c30.32,0 54.9,24.58 54.9,54.9z"/>\n' +
            '    <path fill="#ffbfab" d="m418.418,181.718v38.047c0,35.957 -29.159,65.115 -65.115,65.115s-65.101,-29.159 -65.101,-65.115v-38.047c0,-35.957 29.145,-65.115 65.101,-65.115 35.913,-0.001 65.115,29.13 65.115,65.115z"/>\n' +
            '    <path fill="#ffa78f" d="m418.418,181.718v38.047c0,35.957 -29.159,65.115 -65.115,65.115v-168.278c35.913,0 65.115,29.131 65.115,65.116z"/>\n' +
            '    <path fill="#000" d="m217.404,158.291h-145.188c-8.284,0 -15,-6.716 -15,-15s6.716,-15 15,-15h145.188c8.284,0 15,6.716 15,15s-6.716,15 -15,15z"/>\n' +
            '    <path fill="#000" d="m217.404,224.276h-145.188c-8.284,0 -15,-6.716 -15,-15s6.716,-15 15,-15h145.188c8.284,0 15,6.716 15,15s-6.716,15 -15,15z"/>\n' +
            '    <path fill="#FFC107" d="m436.647,509.797h-30v-96.305c0,-8.284 6.716,-15 15,-15 8.284,0 15,6.716 15,15z"/>\n' +
            '</svg>' +
            '    </div>' +
            '    <div class="productAttributes-item-value">'+productItemData.attributes.teacher+'</div>' +
            '  </div>' +
            '</div>';
        // attributes: {
        //     productionYear: data.attributes.productionYear,
        //         major: data.attributes.major,
        //         educationalSystem: data.attributes.educationalSystem,
        //         shippingMethod: data.attributes.shippingMethod,
        //         teacher: data.attributes.teacher,
        //         services: data.attributes.services.join(', '),
        // }

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
                '<div class="m--margin-top-30">' +
                // truncatise(productItemData.shortDescription.replace(/<a .*>.*<\/a>/i, ''), options) +
                shortDescription +
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
                '   <i class="fa fa-calendar-alt m--margin-right-5" data-toggle="m-tooltip" data-placement="top" data-original-title="تاریخ بروزرسانی"></i>' +
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
                appendToCarouselTypeAndSetNextPage(response.data.sets);
            });
        }
        removeSensorItem('carouselType');
    }
    function fetchNewVideo(callback) {
        var nextPageUrlVideo = getNextPageUrl('video');
        if (nextPageUrlVideo !== null && nextPageUrlVideo.length > 0) {
            addLoadingItem('listType');
            getAjaxContent(nextPageUrlVideo, function (response) {
                fillVideoRepositoryAndSetNextPage(response.data.videos);
                callback();
            });
        }
    }
    function fetchNewProduct(callback) {
        var nextPageUrlProduct = getNextPageUrl('product');
        if (nextPageUrlProduct !== null && nextPageUrlProduct.length > 0) {
            getAjaxContent(nextPageUrlProduct, function (response) {
                fillProductRepositoryAndSetNextPage(response.data.products);
                callback();
            });
        }
    }

    function appendToListType() {
        removeSensorItem('listType');
        removeLoadingItem('listType');
        appendVideoOrProduct('video');
        appendVideoOrProduct('product');
        $('[data-toggle="m-tooltip"]').tooltip();
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
        if (typeof data !== 'undefined' && data !== null && typeof data.meta !== 'undefined' && data.meta.total > 0) {
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
