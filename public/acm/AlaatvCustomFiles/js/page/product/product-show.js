var ProductSwitch = function () {

    function changeChildCheckStatus(parentId, status) {
        var items = $("input[name='products[]'].product.hasParent_" + parentId);
        for (var index in items) {
            if (!isNaN(index)) {
                var hasChildren = $(items[index]).hasClass('hasChildren');
                var defaultValue = items[index].defaultValue;
                $(items[index]).prop('checked', status);
                if (hasChildren) {
                    changeChildCheckStatus(defaultValue, status);
                }
            }
        }
    }

    function singleUpdateSelectedProductsStatus() {

        var items = $("input[name='products[]'].product");
        for (var index in items) {
            if (!isNaN(index)) {
                var hasChildren = $(items[index]).hasClass('hasChildren');
                var thisValue = items[index].defaultValue;
                var report1 = {
                    'allChildIsChecked': true,
                    'allChildIsNotChecked': true,
                    'counter': 0
                };
                var report = checkChildProduct(thisValue, report1);
                if (hasChildren) {
                    if (report.allChildIsChecked) {
                        $(items[index]).prop('checked', true);
                    } else {
                        $(items[index]).prop('checked', false);
                    }
                }
            }
        }
    }

    function checkChildProduct(parentId, report) {
        var items = $("input[name='products[]'].product.hasParent_" + parentId);
        report.counter++;
        for (var index in items) {
            if (isNaN(index)) {
                continue;
            }
            var defaultValue = items[index].defaultValue;
            var thisCheckBox = $("input[name='products[]'][value='" + defaultValue + "'].product");
            var hasChildren = thisCheckBox.hasClass('hasChildren');
            var thisExist = thisCheckBox.length;
            var thisIsChecked = thisCheckBox.prop('checked');
            if (thisExist > 0 && thisIsChecked !== true) {
                report.allChildIsChecked = false;
            }
            if (thisIsChecked === true) {
                report.allChildIsNotChecked = false;
            }
            if (hasChildren) {
                report = checkChildProduct(defaultValue, report);
            } else {
                report.allChildIsNotChecked = false;
            }
        }
        return report;
    }

    function getChildLevel() {
        if (typeof $("input[name='products[]'].product")[0] === "undefined") {
            return 1;
        }
        var firstDefaultValue = $("input[name='products[]'].product")[0].defaultValue;
        var report1 = {
            'allChildIsChecked': true,
            'allChildIsNotChecked': true,
            'counter': 0
        };
        var report = checkChildProduct(firstDefaultValue, report1);
        return report.counter;
    }

    function updateSelectedProductsStatus(childLevel, callback) {
        for (var i = 0; i < childLevel; i++) {
            singleUpdateSelectedProductsStatus();
        }
        callback();
    }

    function checkChildrenOfParentOnInit() {
        var items = $("input[name='products[]'].product.hasChildren:checked");
        for (var index in items) {
            if (isNaN(index)) {
                continue;
            }
            changeChildCheckStatus(items[index].defaultValue, true);
        }
    }

    return {
        init: function () {
            var childLevel = getChildLevel();
            checkChildrenOfParentOnInit();
            return childLevel;
        },
        updateSelectedProductsStatus: function (childLevel, callback) {
            updateSelectedProductsStatus(childLevel, callback);
        },
        changeChildCheckStatus: function (parentId, status) {
            changeChildCheckStatus(parentId, status);
        }
    };
}();

var ProductShowPage = function () {

    function disableBtnAddToCart() {
        mApp.block('.btnAddToCart', {
            type: "loader",
            state: "info",
        });
    }

    function enableBtnAddToCart() {
        mApp.unblock('.btnAddToCart');
    }

    function refreshPrice(mainAttributeState, productState, extraAttributeState) {
        var product = $("input[name=product_id]").val();

        $('#a_product-price').html('<div class="m-loader m-loader--success"></div>');
        $('#a_product-price_mobile').html('<div class="m-loader m-loader--success"></div>');
        if (mainAttributeState.length === 0 && productState.length === 0 && extraAttributeState.length === 0) {

            $('#a_product-price').html('قیمت محصول: ' + 'پس از انتخاب محصول');
            $('#a_product-price_mobile').html('قیمت پس از انتخاب محصول');

            toastr.warning("شما هیچ محصولی را انتخاب نکرده اید.", "توجه!");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "/api/v1/getPrice/" + product,
            data: {mainAttributeValues: mainAttributeState, products: productState, extraAttributeValues: extraAttributeState},
            statusCode: {
                //The status for when action was successful
                200: function (response) {
                    response = $.parseJSON(response);

                    if (response.error != null) {

                        toastr.warning(response.error.message + '(' + response.error.code + ')');

                        $('#a_product-price').html('قیمت محصول: ' + 'پس از انتخاب محصول');
                        $('#a_product-price_mobile').html('قیمت پس از انتخاب محصول');
                    }
                    if (response.cost != null) {
                        var response_cost = parseInt(response.cost.base);
                        var response_costForCustomer = parseInt(response.cost.final);

                        if (response_costForCustomer < response_cost) {
                            $('#a_product-price').html('قیمت محصول: <del>' + response_cost.toLocaleString('fa') + '</del> تومان <br>قیمت برای مشتری: ' + response_costForCustomer.toLocaleString('fa') + ' تومان ');
                            $('#a_product-price_mobile').html('<strike>' + response_cost.toLocaleString('fa') + ' تومان ' + '</strike>' +
                                '<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">' + response_costForCustomer.toLocaleString('fa') + ' تومان ' + '</span>');
                        } else {
                            $('#a_product-price').html('قیمت محصول: ' + response_costForCustomer.toLocaleString('fa') + ' تومان ');
                            $('#a_product-price_mobile').html('<span>' + response_costForCustomer.toLocaleString('fa') + ' تومان ' + '</span>');
                        }
                    } else {

                        toastr.error('خطایی رخ داده است.');

                        $('#a_product-price').html('-');
                        $('#a_product-price_mobile').html('-');
                    }
                },
                //The status for when the user is not authorized for making the request
                403: function (response) {
                    window.location.replace("/403");
                },
                //The status for when the user is not authorized for making the request
                401: function (response) {
                    window.location.replace("/403");
                },
                404: function (response) {
                    // window.location.replace("/404");
                },
                //The status for when form data is not valid
                422: function (response) {
                },
                //The status for when there is error php code
                500: function (response) {
                    toastr.error('خطایی رخ داده است.');
                    $('#a_product-price').html('-');
                    $('#a_product-price_mobile').html('-');
                },
                //The status for when there is error php code
                503: function (response) {
//                            toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                }
            }
        });
    }

    function getMainAttributeStates() {
        var staticAttributeState = $('input[type=hidden][name="attribute[]"]').map(function () {
            if ($(this).val())
                return $(this).val();
        }).get();
        var selectAttributeState = $('select[name="attribute[]"]').map(function () {
            if ($(this).val())
                return $(this).val();
        }).get();
        var checkboxAttributeState = $('input[type=checkbox][name="attribute[]"]:checked').map(function () {
            if ($(this).val())
                return $(this).val();
        }).get();

        var c = $.merge($.merge(selectAttributeState, checkboxAttributeState), staticAttributeState);
        var attributeState = c.filter(function (item, pos) {
            return c.indexOf(item) == pos
        });

        return attributeState;
    }

    function getExtraAttributeStates() {
        var selectAttributeState = $('select[name="extraAttribute[]"]').map(function () {
            if ($(this).val())
                return $(this).val();
        }).get();

        var checkboxAttributeState = $('input[type=checkbox][name="extraAttribute[]"]:checked').map(function () {
            if ($(this).val())
                return $(this).val();
        }).get();


        var c = $.merge(selectAttributeState, checkboxAttributeState);
        var attributeState = c.filter(function (item, pos) {
            return c.indexOf(item) == pos
        });

        var extraAttributes = [];

        for (var index in attributeState) {
            if (!isNaN(index)) {
                extraAttributes.push({
                    'id': attributeState[index]
                });
            }
        }
        return extraAttributes;
    }

    function getProductSelectValues() {
        // var productsState = $('input[type=checkbox][name="products[]"]:enabled:checked').map(function(){
        //     if ($(this).val())
        //         return $(this).val();
        // }).get();
        return $('input[type=checkbox][name="products[]"]:checked').map(function () {
            if ($(this).val())
                return $(this).val();
        }).get();
    }

    function getSelectedProductObject() {
        return $('input[type=checkbox][name="products[]"]:checked').map(function () {
            if ($(this).val()) {
                return {
                    id: $(this).data('gtm-eec-product-id').toString(),      // (String) The SKU of the product. Example: 'P12345'
                    name: $(this).data('gtm-eec-product-name').toString(),    // (String) The name of the product. Example: 'T-Shirt'
                    price: $(this).data('gtm-eec-product-price').toString(),
                    brand: $(this).data('gtm-eec-product-brand').toString(),   // (String) The brand name of the product. Example: 'NIKE'
                    category: $(this).data('gtm-eec-product-category').toString(),// (String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
                    variant: $(this).data('gtm-eec-product-variant').toString(), // (String) What variant of the main product this is. Example: 'Large'
                    quantity: $(this).data('gtm-eec-product-quantity'),
                };
            }
        }).get();
    }

    return {
        disableBtnAddToCart: disableBtnAddToCart,
        enableBtnAddToCart: enableBtnAddToCart,
        refreshPrice: refreshPrice,
        getMainAttributeStates: getMainAttributeStates,
        getExtraAttributeStates: getExtraAttributeStates,
        getProductSelectValues: getProductSelectValues,
        getSelectedProductObject: getSelectedProductObject
    };
}();

var ProductResponsivePage = function () {


    function fx(a, b, x) {
        return (a * x) + b;
    }

    function fxModel1(windowWidth) {
        return 15.423 + (50.13612 - 15.423)/(1 + Math.pow(windowWidth/1416.28, 3.255731));
    }

    function setColuimnWidth($column, width) {
        $column.css({'flex': '0 0 ' + width + '%', 'max-width': width + '%'});
    }

    function removeColuimnWidth($column) {
        $column.css({'flex': '', 'max-width': ''});
    }

    function getColumnWidthInPercent($column) {
        return parseFloat($column.css('max-width'));
    }

    // model 1
    function setVideoColumnWidthModel1() {
        var productPicColumnWidth = getColumnWidthInPercent($('.productPicColumn')),
            productAttributesColumnWidth = getColumnWidthInPercent($('.productAttributesColumn')),
            PicAttributesIntroVideoRowWidth = 100 - productPicColumnWidth - productAttributesColumnWidth;

        setColuimnWidth($('.productIntroVideoColumn'), PicAttributesIntroVideoRowWidth);
    }

    function applyModel1(windowWidth) {

        //reset
        $('.servicesRows .servicesRow').css({'max-height': '', 'min-height': ''});
        removeColuimnWidth($('.productAttributesColumn'));
        $('.productIntroVideoColumn').css({'margin-top': ''});
        $('.productAttributesColumn').css({'margin-top': '', 'order': ''});
        removeColuimnWidth($('.attributeRow .col'));
        $('.attributeRow').css({'justify-content': ''});
        $('.attributeRow .col').css({'margin-top': ''});
        $('.priceAndAddToCartRow .btnAddToCart').fadeIn(0);


        // var picColumnWidth = fx(a, b, windowWidth);
        var picColumnWidth = fxModel1(windowWidth);
        setColuimnWidth($('.productPicColumn'), picColumnWidth);
        setVideoColumnWidthModel1();
        $('.productAttributesRows .videoInformation').fadeOut(0);
        $('.productIntroVideoColumn .videoInformation').fadeIn(0);
        $('.servicesRows').css({'padding-bottom': '8px'});

    }

    // model 2
    function setProductAttributesColumnWidthModel2() {
        var productPicColumnWidth = getColumnWidthInPercent($('.productPicColumn')),
            productAttributesColumnwWidth = 100 - productPicColumnWidth;
        setColuimnWidth($('.productAttributesColumn'), productAttributesColumnwWidth);
    }

    function applyModel2(a, b, windowWidth) {

        // console.log('applyModel2');

        $('.servicesRows .servicesRow').css({'max-height': '', 'min-height': ''});
        $('.productAttributesColumn').css({'margin-top': '', 'order': ''});
        removeColuimnWidth($('.attributeRow .col'));
        $('.attributeRow').css({'justify-content': ''});
        $('.attributeRow .col').css({'margin-top': ''});
        $('.priceAndAddToCartRow .btnAddToCart').fadeIn(0);


        var picColumnWidth = fx(a, b, windowWidth);
        setColuimnWidth($('.productPicColumn'), picColumnWidth);
        setColuimnWidth($('.productIntroVideoColumn'), picColumnWidth);
        $('.productAttributesRows .videoInformation').fadeIn(0);
        $('.productIntroVideoColumn .videoInformation').fadeOut(0);
        setProductAttributesColumnWidthModel2();
        $('.productIntroVideoColumn').css({'margin-top': '0'});
        if (typeof $('.PicAttributesIntroVideoRow img').offset() !== 'undefined') {
            var marginTop = -1 * ($('.productIntroVideoColumn').offset().top - ($('.PicAttributesIntroVideoRow img').width() + $('.PicAttributesIntroVideoRow img').offset().top) - 15);
            $('.productIntroVideoColumn').css({'margin-top': marginTop + 'px'});
        }
    }

    // model 3
    function applyModel3() {

        // console.log('applyModel3');

        $('.productIntroVideoColumn').css({'margin-top': ''});
        setColuimnWidth($('.productPicColumn'), 37.1);
        setColuimnWidth($('.productIntroVideoColumn'), 62.9);
        setColuimnWidth($('.productAttributesColumn'), 100);
        $('.productAttributesRows .videoInformation').fadeIn(0);
        $('.productIntroVideoColumn .videoInformation').fadeOut(0);
        $('.servicesRows .servicesRow').css({'max-height': 'unset', 'min-height': 'unset'});
        $('.productAttributesColumn').css({'margin-top': '10px', 'order': '2'});


        $('.priceAndAddToCartRow .btnAddToCart').fadeIn(0);
        removeColuimnWidth($('.attributeRow .col'));
        $('.attributeRow').css({'justify-content': ''});
        $('.attributeRow .col').css({'margin-top': ''});
    }

    // model 4
    function applyModel4() {

        // console.log('applyModel4');

        $('.productIntroVideoColumn').css({'margin-top': ''});
        setColuimnWidth($('.productPicColumn'), 36.5);
        setColuimnWidth($('.productIntroVideoColumn'), 63.5);
        setColuimnWidth($('.productAttributesColumn'), 100);
        $('.productAttributesRows .videoInformation').fadeIn(0);
        $('.productIntroVideoColumn .videoInformation').fadeOut(0);
        $('.servicesRows .servicesRow').css({'max-height': 'unset', 'min-height': 'unset'});
        $('.productAttributesColumn').css({'margin-top': '10px', 'order': '2'});

        $('.priceAndAddToCartRow .btnAddToCart').fadeIn(0);
        removeColuimnWidth($('.attributeRow .col'));
        $('.attributeRow').css({'justify-content': ''});
        $('.attributeRow .col').css({'margin-top': ''});
    }

    // model 5
    function applyModel5() {

        // console.log('applyModel5');

        $('.productIntroVideoColumn').css({'margin-top': ''});
        setColuimnWidth($('.productPicColumn'), 100);
        setColuimnWidth($('.productIntroVideoColumn'), 100);
        setColuimnWidth($('.productAttributesColumn'), 100);
        setColuimnWidth($('.attributeRow .col'), 50);
        $('.productAttributesRows .videoInformation').fadeIn(0);
        $('.productIntroVideoColumn .videoInformation').fadeOut(0);
        $('.priceAndAddToCartRow .btnAddToCart').fadeOut(0);
        $('.productAttributesColumn').css({'margin-top': '10px', 'order': '2'});
        $('.servicesRows .servicesRow').css({'max-height': 'unset', 'min-height': 'unset'});
        $('.attributeRow').css({'justify-content': 'center'});
        $('.attributeRow .col').css({'margin-top': '5px'});
    }

    function getWindowWidth() {
        return $(window).width();
    }

    function apply() {
        var windowWidth = getWindowWidth();
        applyModel(windowWidth);
    }

    function addWindowResizeEvent() {
        $(window).resize(function () {
            apply()
        });
    }

    function applyModel(windowWidth) {

        // if (windowWidth >= 1900) {
        //     applyModel1((-101.0 / 10000), (43.79), windowWidth);
        // } else if (windowWidth >= 1800) {
        //     applyModel1((-13.0 / 1000), (49.3), windowWidth);
        // } else if (windowWidth >= 1700) {
        //     applyModel1((-13.0 / 1000), (49.3), windowWidth);
        // } else if (windowWidth >= 1600) {
        //     applyModel1((-3.0 / 200), (52.7), windowWidth);
        // } else if (windowWidth >= 1500) {
        //     applyModel1((-9.0 / 500), (115.0 / 2), windowWidth);
        // } else if (windowWidth >= 1400) {
        //     applyModel1((-87.0 / 2500), (82.7), windowWidth);
        // }

        if (windowWidth >= 1400) {
            applyModel1(windowWidth);
        } else if (windowWidth >= 1300) {
            applyModel2((-2.0 / 125), (249 / 5), windowWidth);
        } else if (windowWidth >= 1200) {
            applyModel2((-3.0 / 125), (301.0 / 5), windowWidth);
        } else if (windowWidth >= 1100) {
            applyModel2((-1.0 / 40), (307.0 / 5), windowWidth);
        } else if (windowWidth >= 1000) {
            applyModel2((-13.0 / 500), (125.0 / 2), windowWidth);
        } else if (windowWidth >= 768) {
            applyModel3((9 / 2500), (-540 / 2500), windowWidth);
        } else if (windowWidth >= 500) {
            applyModel4((9 / 2500), (-540 / 2500), windowWidth);
        } else if (windowWidth >= 0) {
            applyModel5((9 / 2500), (-540 / 2500), windowWidth);
        }
    }

    return {
        apply: function () {
            apply();
            addWindowResizeEvent();
        },
    };
}();

var PreviewSets = function () {

    function showContentOfSetFromServer(setId, sectionId) {

        if (typeof setId === 'undefined' || setId === null || setId === 'null' || setId.trim().length === 0) {
            toastr.info('این فرسنگ هنوز منتشر نشده است.');
            return;
        }

        $('.selectSetOfProductTopreview').AnimateScrollTo();
        getSetData(setId, sectionId, showSetData);
    }

    function showSetData(data, sectionId) {
        initSectionList(data.files);
        $('#selectSet .select-selected').html((data.set.short_title === null) ? data.set.title : data.set.short_title).attr('data-option-value', data.set.id);
        setLists(data.files);
        setBtnMoreLink(data.set.url.web);
        checkNoData();
        refreshScrollCarouselSwipIcons();
        showLists();
        imageObserver.observe();
        if (typeof sectionId !== 'undefined') {
            showSection(sectionId);
        } else {
            showSection('all');
        }

        this.showPreviewSetDataCallback(data, sectionId);

        hideLoading();
    }

    function getSetData(setId, sectionId, callback) {
        showLoading();
        getAjaxContent('/set/' + setId, function (data) {
            callback(data, sectionId);
        })
    }

    function refreshScrollCarouselSwipIcons() {
        ScrollCarousel.checkSwipIcons($('.ScrollCarousel'));
    }

    function checkNoData() {
        var noVideo = checkNoVideo(),
            noPamphlet = checkNoPamphlet();

        if (noVideo && !noPamphlet) {
            $('.previewSetsOfProduct .m_tabs_pamphlet').trigger('click')
        } else if (!noVideo && noPamphlet) {
            $('.previewSetsOfProduct .m_tabs_video').trigger('click')
        }

    }

    function checkNoVideo() {
        if (getVideoListHtml().trim().length === 0 && getVideoListHtml().trim() !== noDataMessage('فیلمی وجود ندارد.')) {
            $('.previewSetsOfProduct .m_tabs_video').html('بدون فیلم');
            setVideoMessage(noDataMessage('فیلمی وجود ندارد.'));
            getBtnMoreVideo().fadeOut();
            return true;
        } else {
            $('.previewSetsOfProduct .m_tabs_video').html('فیلم ها');
            setVideoMessage('');
            getBtnMoreVideo().fadeIn();
            return false;
        }
    }

    function checkNoPamphlet() {
        if (getPamphletList().trim().length === 0 && getPamphletList().trim() !== noDataMessage('جزوه ای وجود ندارد.')) {
            $('.previewSetsOfProduct .m_tabs_pamphlet').html('بدون جزوه');
            setPamphletMessage(noDataMessage('جزوه ای وجود ندارد.'));
            getBtnMorePamphlet().fadeOut();
            return true;
        } else {
            $('.previewSetsOfProduct .m_tabs_pamphlet').html('جزوات');
            setPamphletMessage('');
            getBtnMorePamphlet().fadeIn();
            return false;
        }
    }

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
                data: {
                    raheAbrisham: true
                },
                accept: "application/json; charset=utf-8",
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    callback(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    hideLoading();
                    checkNoData();
                    toastr.warning('خطایی رخ داده است.');
                }
            }
        );
    }

    function showLists() {
        $('.previewSetsOfProduct').parents('.row').fadeIn();
    }

    function createVideoList(data) {
        if (typeof data === 'undefined') {
            return '';
        }
        var htmlData = '';
        for (var key in data){
            htmlData += createVideoItem({
                section: (typeof data[key].section !== 'undefined' && data[key].section !== null) ? data[key].section : {id: '', name: ''},
                photo: (typeof data[key].photo !== 'undefined') ? data[key].photo : data[key].thumbnail,
                title: (typeof data[key].name !== 'undefined') ? data[key].name : data[key].title,
                link: data[key].url.web
            });
        }
        return htmlData;
    }

    function createPamphletList(data) {
        if (typeof data === 'undefined') {
            return '';
        }

        var htmlData = '';
        for (var key in data){
            htmlData += createPamphletItem({
                section: (typeof data[key].section !== 'undefined' && data[key].section !== null) ? data[key].section : {id: '', name: ''},
                title: (typeof data[key].title !== 'undefined') ? data[key].title : data[key].name,
                link: (typeof data[key].file !== 'undefined' && data[key].file !== null) ? data[key].file.pamphlet[0].link : '#'
            });

        }

        // var dataLength = data.length,
        //     htmlData = '';
        // for (var i = 0; i < dataLength; i++) {
        //     htmlData += createPamphletItem({
        //         section: (typeof data[i].section !== 'undefined') ? data[i].section : {id: '', name: ''},
        //         title: (typeof data[i].title !== 'undefined') ? data[i].title : data[i].name,
        //         link: data[i].file.pamphlet[0].link
        //     });
        // }
        return htmlData;
    }

    function createVideoItem(data) {
        return '' +
            '<div class="item w-55443211" data-section-id="'+data.section.id+'" data-section-name="'+data.section.name+'" data-tooltip-content="' + data.title + '">\n' +
            '  <a href="' + data.link + '">' +
            '    <img class="lazy-image a--full-width"\n' +
            '         src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"\n' +
            '         data-src="' + data.photo + '"\n' +
            '         alt="' + data.title + '"\n' +
            '         width="253" height="142">\n' +
            '  </a>' +
            '</div>';
    }

    function createPamphletItem(data) {
        return '' +
            '<div class="item w-55443211" data-section-id="'+data.section.id+'" data-section-name="'+data.section.name+'">\n' +
            '  <a href="' + data.link + '" class="m-link">' +
            '    <div class="pamphletItem">\n' +
            '        <div class="pamphletItem-thumbnail">\n' +
            '            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">\n' +
            '                <path style="fill:#F4A14E;" d="M512,256c0,19.508-2.184,38.494-6.311,56.738c-6.416,28.348-17.533,54.909-32.496,78.817  c-0.637,1.024-1.285,2.048-1.943,3.072C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627  c-19.822-30.699-33.249-65.912-38.4-103.769c-1.191-8.735-1.933-17.617-2.215-26.624C0.042,261.496,0,258.759,0,256  c0-24.9,3.553-48.964,10.177-71.722c2.654-9.101,5.799-17.993,9.415-26.645c5.862-14.106,12.967-27.564,21.159-40.26  C86.319,46.749,165.7,0,256,0s169.681,46.749,215.249,117.373c10.365,16.06,18.986,33.353,25.59,51.618  c3.124,8.673,5.81,17.565,8.004,26.645c2.111,8.714,3.772,17.607,4.953,26.645c1.16,8.746,1.86,17.638,2.111,26.645  C511.969,251.277,512,253.628,512,256z"/>\n' +
            '                <path style="fill:#F9EED7;" d="M471.249,127.76v266.867C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627V22.8  c0-12.591,10.209-22.8,22.8-22.8h279.939L471.249,127.76z"/>\n' +
            '                <path style="fill:#E8DBC4;" d="M343.489,104.958V0l127.76,127.76H366.291C353.698,127.76,343.489,117.551,343.489,104.958z"/>\n' +
            '                <path style="fill:#FF525D;" d="M471.249,330.961v63.666C425.681,465.251,346.3,512,256,512S86.319,465.251,40.751,394.627v-63.666  L471.249,330.961L471.249,330.961z"/>\n' +
            '                <path style="fill:#5C5E70;" d="M157.375,292.967c-3.474,0-6.921-0.547-10.187-1.678c-8.463-2.934-13.871-9.302-14.841-17.473  c-1.317-11.103,5.306-29.586,44.334-54.589c11.285-7.229,22.837-12.976,34.413-17.492c1.162-2.198,2.351-4.438,3.558-6.711  c8.945-16.848,19.331-36.411,27.596-55.402c-15.258-30.061-21.671-58.182-21.671-66.936c0-15.46,8.68-27.819,20.639-29.387  c4.811-0.632,21.117-0.425,28.887,28.714c4.785,17.942-1.38,41.91-11.673,66.958c2.814,5.151,5.964,10.429,9.479,15.702  c7.666,11.499,16.328,22.537,25.247,32.441c37.765,0.227,67.003,9.163,74.427,13.943c10.572,6.809,14.857,18.342,10.662,28.7  c-5.549,13.703-20.603,15.948-31.812,13.707c-16.191-3.238-34.248-17.427-46.544-28.758c-4.367-4.024-8.712-8.328-12.978-12.842  c-18.743,0.422-41.758,3.244-65.516,11.696c-1.971,3.754-3.836,7.355-5.553,10.76c-2.391,5.244-21.103,45.772-33.678,58.348  C175.52,289.313,166.357,292.967,157.375,292.967z M200.593,222.43c-5.368,2.695-10.724,5.722-16.02,9.116  c-37.601,24.088-38,38.004-37.699,40.549c0.296,2.493,2.014,4.302,5.105,5.373c5.426,1.88,13.981,0.718,19.841-5.141  C180.051,264.094,193.9,236.627,200.593,222.43z M308.038,202.364c15.452,14.531,30.458,24.596,41.264,26.756  c9.163,1.835,14.013-1.469,15.385-4.854c1.497-3.698-0.474-7.981-5.025-10.91C355.383,210.602,335.446,204.274,308.038,202.364z   M251.13,155.566c-6.247,13.416-13.238,26.834-19.949,39.513c14.801-4.077,29.376-6.35,43.204-7.348  c-6.683-8.035-12.988-16.454-18.647-24.943C254.142,160.395,252.605,157.983,251.13,155.566z M243.624,57.773  c-0.172,0-0.342,0.01-0.508,0.032c-3.806,0.498-7.911,6.33-7.911,14.881c0,3.494,2.029,14.9,7.474,30.631  c1.746,5.042,4.037,11.087,6.957,17.737c6.246-17.614,9.422-33.685,6.332-45.271C252.619,63.225,247.458,57.773,243.624,57.773z"/>\n' +
            '                <g>\n' +
            '                    <path style="fill:#F9EED7;" d="M135.128,366.165c0-3.319,3.053-6.239,7.7-6.239h27.479c17.523,0,31.328,8.231,31.328,30.532v0.664   c0,22.302-14.337,30.798-32.656,30.798h-13.142v28.673c0,4.248-5.177,6.372-10.355,6.372c-5.176,0-10.354-2.124-10.354-6.372   V366.165z M155.838,377.979v28.011h13.142c7.433,0,11.947-4.247,11.947-13.275v-1.46c0-9.027-4.513-13.275-11.947-13.275   L155.838,377.979L155.838,377.979z"/>\n' +
            '                    <path style="fill:#F9EED7;" d="M256.464,359.926c18.319,0,32.656,8.496,32.656,31.328v34.382c0,22.833-14.337,31.328-32.656,31.328   h-23.497c-5.442,0-9.027-2.921-9.027-6.239v-84.56c0-3.319,3.585-6.239,9.027-6.239L256.464,359.926L256.464,359.926z    M244.65,377.979v60.932h11.815c7.433,0,11.947-4.248,11.947-13.275v-34.382c0-9.027-4.513-13.275-11.947-13.275H244.65V377.979z"/>\n' +
            '                    <path style="fill:#F9EED7;" d="M315.541,366.297c0-4.247,4.513-6.372,9.027-6.372h46.064c4.38,0,6.239,4.646,6.239,8.894   c0,4.912-2.256,9.16-6.239,9.16h-34.381v22.435h20.045c3.983,0,6.239,3.85,6.239,8.098c0,3.584-1.858,7.833-6.239,7.833h-20.045   v34.249c0,4.247-5.177,6.372-10.355,6.372c-5.176,0-10.354-2.124-10.354-6.372v-84.296H315.541z"/>\n' +
            '                </g>\n' +
            '            </svg>\n' +
            '        </div>\n' +
            '        <div class="pamphletItem-name">\n' +
            '           ' + data.title + '\n' +
            '        </div>\n' +
            '    </div>\n' +
            '  </a>' +
            '</div>';
    }

    function setBtnMoreLink(link) {
        setBtnMoreContentsLink(link);
        // setBtnMoreVideoLink(link);
        // setBtnMorePamphletLink(link);
    }

    function setBtnMoreContentsLink(link) {
        getBtnMoreContents().parents('a').attr('href', link);
    }

    function setVideoTooltip() {
        ScrollCarousel.addTooltip($('#m_tabs_video .ScrollCarousel'));

        // $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items .item img').each(function () {
        //     $(this).parents('a').attr('data-toggle', 'm-tooltip').attr('data-placement', 'top').attr('data-original-title', $(this).attr('alt'));
        // });
        // $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items .item a').tooltip();


        // $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items .item img').each(function () {
        //     $(this).attr('data-toggle', 'm-tooltip').attr('data-placement', 'top').attr('data-original-title', $(this).attr('alt'));
        // });
        // $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items .item img').tooltip();


        // $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items .item img').each(function () {
        //     $(this).parents('.item').attr('data-toggle', 'm-tooltip').attr('data-placement', 'top').attr('data-original-title', $(this).attr('alt'));
        // });
        // $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items .item').tooltip();


        // $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items .item img').each(function () {
        //     $(this).parents('.item').attr('data-toggle', 'm-tooltip').attr('data-placement', 'top').attr('data-original-title', $(this).attr('alt'));
        // });
        // $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items .item').tooltip();

    }

    function setLists(data) {
        setVideoList(createVideoList(data.videos));
        setVideoTooltip();
        setPamphletList(createPamphletList(data.pamphlets));
    }

    function setVideoList(html) {
        $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items').html(html);
    }

    function getVideoListHtml() {
        return $('#m_tabs_video .ScrollCarousel .ScrollCarousel-Items').html();
    }

    function setPamphletList(html) {
        $('#m_tabs_pamphlet .ScrollCarousel .ScrollCarousel-Items').html(html);
    }

    function getPamphletList() {
        return $('#m_tabs_pamphlet .ScrollCarousel .ScrollCarousel-Items').html();
    }

    function setPamphletMessage(html) {
        $('.showPamphletMessage').html(html);
    }

    function setVideoMessage(html) {
        $('.showVideoMessage').html(html);
    }

    function getBtnMoreContents() {
        return $('.btnShowMoreContents');
    }

    function getBtnMoreVideo() {
        return $('.btnShowMoreVideo');
    }

    function getBtnMorePamphlet() {
        return $('.btnShowMorePamphlet');
    }

    function showLoading() {
        var loadingHtml = '<div class="m-loader m-loader--warning" style="width: 100px;height: 100px;margin: auto;"></div>';
        setVideoList('');
        setPamphletList('');
        setVideoMessage(loadingHtml);
        setPamphletMessage(loadingHtml);
        AlaaLoading.show();
    }

    function hideLoading() {
        AlaaLoading.hide();
    }

    function noDataMessage(message) {
        return '<div class="alert alert-info text-center" role="alert" style="width: 100%;margin: auto;">' + message + '</div>';
    }

    function getTotalSectionList() {
        return [
            {
                id: 1,
                enable: false,
                name: 'تابلو راهنما'
            },
            {
                id: 2,
                enable: false,
                name: 'تورق سریع'
            },
            {
                id: 3,
                enable: false,
                name: 'حل تست'
            },
            {
                id: 4,
                enable: false,
                name: 'کنکورچه'
            },
            {
                id: 5,
                enable: false,
                name: 'پیش آزمون'
            }
        ];
    }

    function getSectionListFromContent(data) {
        var totalSectionList = getTotalSectionList();

        checkSections(data.pamphlets, totalSectionList);
        checkSections(data.videos, totalSectionList);

        return totalSectionList;
    }

    function checkSections(data, totalSectionList) {
        if (typeof data === 'undefined') {
            return;
        }
        for (var key in data){
            if (typeof data[key].section !== 'undefined' && data[key].section !== null) {
                checkInTotalSectionList(data[key].section, totalSectionList);
            }
        }

        // var dataLength = data.length;
        // for (var i = 0; i < dataLength; i++) {
        //     if (typeof data[i].section !== 'undefined') {
        //         checkInTotalSectionList(data[i].section, totalSectionList);
        //     }
        // }
    }

    function checkInTotalSectionList(itemSection, totalSectionList) {
        for (var j = 0; (typeof totalSectionList[j] !== 'undefined'); j++) {
            if (itemSection.id.toString() === totalSectionList[j].id.toString()) {
                totalSectionList[j].enable = true;
            }
        }
    }

    function initSectionList(data) {
        var listHtml = '',
            sectionList = getSectionListFromContent(data),
            activrSectionCount = 0;

        for (var i = 0; (typeof sectionList[i] !== 'undefined'); i++) {
            if (sectionList[i].enable) {
                activrSectionCount++;
                listHtml += createSectionItem(sectionList[i]);
            }
        }

        if (activrSectionCount>0) {
            $('.previewSetsOfProduct .tab-content').css({'padding-right':''});
        } else {
            $('.previewSetsOfProduct .tab-content').css({'padding-right':'0'});
        }
        $('.sectionFilterCol').html(listHtml);
    }

    function createSectionItem(data) {
        return '<div class="sectionFilter-item" data-section-id="'+data.id+'" data-section-name="'+data.name+'">'+data.name+'</div>';
    }

    function showSection(sectionId) {
        var animateSpeed = 0;
        $('.sectionFilterCol .sectionFilter-item').removeClass('selected');
        $('.previewSetsOfProduct .tab-content .ScrollCarousel .ScrollCarousel-Items .item').fadeIn(animateSpeed);
        if (typeof sectionId === 'undefined' || sectionId === 'all') {
        } else {
            $('.sectionFilterCol .sectionFilter-item[data-section-id="'+sectionId+'"]').addClass('selected');
            $('.previewSetsOfProduct .tab-content .ScrollCarousel .ScrollCarousel-Items .item').each(function () {
                var thisSectionId = $(this).attr('data-section-id');
                if (parseInt(thisSectionId) !== parseInt(sectionId)) {
                    $(this).fadeOut(animateSpeed);
                }
            });
        }

        setTimeout(function () {
            refreshScrollCarouselSwipIcons();
        }, animateSpeed + 10);

    }

    function addClickEvents() {
        $(document).on('click', '.sectionFilterCol .sectionFilter-item', function () {
            var sectionId = $(this).attr('data-section-id');
            showSection(sectionId);
        });
        $(document).on('click', '.setStepProgressBar-step', function () {
            var setId = $(this).attr('data-content-id');
            showContentOfSetFromServer(setId);
        });
    }

    function cleanSelectSets() {
        $('#selectSet select option').remove();
    }

    function feedSelectSets(data) {
        for (var i = 0; (typeof data[i] !== 'undefined'); i++) {
            var selected = (i === 0) ? 'selected' : '';
            $('#selectSet select').append('<option value="'+data[i].id+'" '+selected+'>'+data[i].name+'</option>');
        }
    }

    function getSetsOfProduct(allProductsSets, productId) {
        for (var i = 0; (typeof allProductsSets[i] !== 'undefined'); i++) {
            if (allProductsSets[i].id.toString() === productId.toString()) {
                return allProductsSets[i].sets;
            }
        }

        return null;
    }

    function showSetsOfProduct(allProductsSets, productId) {
        var sets = getSetsOfProduct(allProductsSets, productId);
        cleanSelectSets();
        feedSelectSets(sets);

        $('.CustomDropDown').CustomDropDown({
            onChanged: function (item) {
                var CustomDropDownId = $(item.selectObject).parent('.CustomDropDown').attr('id');
                if (CustomDropDownId === 'selectProduct') {
                    showSetsOfProduct(allProductsSets, item.value);
                    if ($('#selectSet select').val().toString() !== sets[0].id.toString()) {
                        showContentOfSetFromServer(sets[0].id.toString());
                    }
                } else if (CustomDropDownId === 'selectSet') {
                    showContentOfSetFromServer(item.value);
                }
                // { index: 2, totalCount: 5, value: "3", text: "فرسنگ سوم" }
            }
        });
    }

    function initCustomDropDown(data) {
        showSetsOfProduct(data.allProductsSets, data.allProductsSets[0].id);
    }

    function showPreviewSetDataCallback() {

    }

    return {
        init: function (data) {
            if (data.allProductsSets === null || data.lastSetData === null) {
                return;
            }



            window.showPreviewSetDataCallback = function (data, sectionId) {};
            data.showPreviewSetDataCallback = window.showPreviewSetDataCallback;



            initCustomDropDown(data);
            showSetData(data.lastSetData);
            addClickEvents();
        },
        showContentOfSetFromServer: showContentOfSetFromServer,
        showSetData: function (data) {

        },
        showPreviewSetDataCallback: showPreviewSetDataCallback
    };

}();

var InitProductPagePage = function () {

    function initGAEE() {
        GAEE.productDetailViews('product.show', parentProduct);
        if (GAEE.reportGtmEecOnConsole()) {
            console.log('product.show', parentProduct);
        }
    }

    function initProductSwitchForSelectableProducts() {
        var childLevel = ProductSwitch.init();

        var callBack = function () {
            var productsState = ProductShowPage.getProductSelectValues();
            ProductShowPage.refreshPrice([], productsState, []);
        };
        $(document).on('change', "input[name='products[]'].product", function () {
            var thisValue = this.defaultValue;
            var hasChildren = $(this).hasClass('hasChildren');
            if (hasChildren) {
                ProductSwitch.changeChildCheckStatus(thisValue, $(this).prop('checked'));
            }
            ProductSwitch.updateSelectedProductsStatus(childLevel, callBack);
        });
    }

    function initLightGallery() {
        $("#lightgallery").lightGallery();
    }

    function initSticky() {
        $('.sampleVideo .m-portlet__head').sticky({
            container: '.sampleVideo',
            hidePosition: {
                element: '.productPamphletWarper .productPamphletTitle',
                topSpace: $('#m_header').height()
            },
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });

        $('.productPamphletWarper .productPamphletTitle').sticky({
            container: '.productPamphletWarper',
            hidePosition: {
                element: '.productDetailes .m-portlet__head',
                topSpace: $('#m_header').height()
            },
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });

        $('.productDetailes .m-portlet__head').sticky({
            container: '.productDetailes',
            hidePosition: {
                element: '.productLiveDescription .m-portlet__head',
                topSpace: $('#m_header').height()
            },
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });

        $('.productLiveDescription .m-portlet__head').sticky({
            container: '.productLiveDescription',
            hidePosition: {
                element: '.relatedProduct .m-portlet__head',
                topSpace: $('#m_header').height()
            },
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });

        $('.relatedProduct .m-portlet__head').sticky({
            container: '.relatedProduct',
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });

        $(document).on('click', '.productInfoNav', function () {
            var targetId = $(this).data('tid');
            $('#' + targetId).AnimateScrollTo();
            // $([document.documentElement, document.body]).animate({
            //     scrollTop: $('#'+targetId).offset().top - $('#m_header').height() + 5
            // }, 1000);
        });
    }

    function initAddToCartEvent() {
        $(document).on('click', '.btnAddToCart', function (e) {

            ProductShowPage.disableBtnAddToCart();
            var product = $("input[name=product_id]").val();
            var mainAttributeStates = ProductShowPage.getMainAttributeStates();
            var extraAttributeStates = ProductShowPage.getExtraAttributeStates();
            var productSelectValues = ProductShowPage.getProductSelectValues();
            var selectedProductObject = ProductShowPage.getSelectedProductObject();

            selectedProductObject.push(parentProduct);
            TotalQuantityAddedToCart = selectedProductObject.length;
            GAEE.productAddToCart('product.addToCart', selectedProductObject);
            if (GAEE.reportGtmEecOnConsole()) {
                console.log('product.addToCart', selectedProductObject);
            }

            if ($('#js-var-userId').val()) {

                $.ajax({
                    type: 'POST',
                    url: '/orderproduct',
                    data: {
                        product_id: product,
                        products: productSelectValues,
                        attribute: mainAttributeStates,
                        extraAttribute: extraAttributeStates
                    },
                    success: function (data) {
                        var successMessage = 'محصول مورد نظر به سبد خرید اضافه شد.';

                        toastr.success(successMessage);

                        window.location.replace('/checkout/review');
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

                        toastr.error('خطای سیستمی رخ داده است.');

                        ProductShowPage.enableBtnAddToCart();
                    }
                });

            } else {

                var data = {
                    'product_id': $('input[name="product_id"][type="hidden"]').val(),
                    'attribute': mainAttributeStates,
                    'extraAttribute': extraAttributeStates,
                    'products': productSelectValues,
                };

                UesrCart.addToCartInCookie(data);

                var successMessage = 'محصول مورد نظر به سبد خرید اضافه شد.';


                toastr.success(successMessage);

                setTimeout(function () {
                    window.location.replace('/checkout/review');
                }, 2000);
            }

        });



        $(document).on('click', '.btnAddSingleProductToCart', function () {
            mApp.block('.btnAddSingleProductToCart', {
                type: "loader",
                state: "info",
            });

            var productId = $(this).data('pid');

            var selectedProductObject = {
                id:       $(this).data('gtm-eec-product-id').toString(),      // (String) The SKU of the product. Example: 'P12345'
                name:     $(this).data('gtm-eec-product-name').toString(),    // (String) The name of the product. Example: 'T-Shirt'
                price:    $(this).data('gtm-eec-product-price').toString(),
                brand:    $(this).data('gtm-eec-product-brand').toString(),   // (String) The brand name of the product. Example: 'NIKE'
                category: $(this).data('gtm-eec-product-category').toString(),// (String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
                variant:  $(this).data('gtm-eec-product-variant').toString(), // (String) What variant of the main product this is. Example: 'Large'
                quantity: $(this).data('gtm-eec-product-quantity')
            };
            GAEE.productAddToCart('PurchasedEssentialProduct.addToCart', selectedProductObject);
            if (GAEE.reportGtmEecOnConsole()) {
                console.log('PurchasedEssentialProduct.addToCart', selectedProductObject);
            }

            if ($('#js-var-userId').val()) {

                $.ajax({
                    type: 'POST',
                    url: '/orderproduct',
                    data: {
                        product_id: productId,
                        products: [],
                        attribute: [],
                        extraAttribute: []
                    },
                    statusCode: {
                        200: function (response) {

                            var successMessage = 'محصول مورد نظر به سبد خرید اضافه شد.';

                            toastr.success(successMessage);

                            window.location.replace('/checkout/review');

                        },
                        500: function (response) {

                            toastr.error('خطای سیستمی رخ داده است.');

                            ProductShowPage.enableBtnAddToCart();
                        },
                        503: function (response) {
                            toastr.error('خطای پایگاه داده!');
                            ProductShowPage.enableBtnAddToCart();
                        }
                    }
                });

            } else {

                var data = {
                    'product_id': productId,
                    'attribute': [],
                    'extraAttribute': [],
                    'products': [],
                };

                UesrCart.addToCartInCookie(data);

                var successMessage = 'محصول مورد نظر به سبد خرید اضافه شد.';


                toastr.success(successMessage);

                setTimeout(function () {
                    window.location.replace('/checkout/review');
                }, 2000);
            }

        });
    }

    function initRefreshPriceEvents() {
        $(document).on("ifChanged change", ".attribute", function () {
            var attributeState = ProductShowPage.getMainAttributeStates();
            ProductShowPage.refreshPrice(attributeState, [], []);
        });

        $(document).on("ifChanged change", ".extraAttribute", function () {
            var attributeState = ProductShowPage.getExtraAttributeStates();
            ProductShowPage.refreshPrice([], [], attributeState);
        });

        $(document).on("ifChanged switchChange.bootstrapSwitch", ".product", function () {
            var productsState = ProductShowPage.getProductSelectValues();
            ProductShowPage.refreshPrice([], productsState, []);
        });
    }

    function initSampleVideoBlock() {
        $('.sampleVideo').OwlCarouselType2({
            OwlCarousel: {
                center: false,
                loop: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    400: {
                        items: 2
                    },
                    600: {
                        items: 3
                    },
                    800: {
                        items: 4
                    },
                    1000: {
                        items: 5
                    }
                },
                btnSwfitchEvent: function () {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            grid: {
                columnClass: 'col-12 col-sm-6 col-md-3 gridItem',
                btnSwfitchEvent: function () {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            defaultView: 'OwlCarousel', // OwlCarousel or grid
            childCountHideOwlCarousel: 4
        });
    }

    function initVideoPlayer() {
        var player;
        if ($('#videoPlayer').length > 0) {
            player = videojs('videoPlayer', {language: 'fa'});

            if ($('input[type="hidden"][name="introVideo"]').length > 0) {
                player.src([
                    {type: "video/mp4", src: $('input[type="hidden"][name="introVideo"]').val()}
                ]);
            }

            player.nuevo({
                // logotitle:"آموزش مجازی آلاء",
                // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
                logocontrolbar: 'https://cdn.alaatv.com/upload/footer-alaaLogo.png?w=18&h=24',
                // logoposition:"RT", // logo position (LT - top left, RT - top right)
                logourl: '//alaatv.com',
                // related: related_videos,
                // shareUrl:"https://www.nuevolab.com/videojs/",
                // shareTitle: "Nuevo plugin for VideoJs Player",
                // slideImage:"//cdn.nuevolab.com/media/sprite.jpg",

                // videoInfo: true,
                // infoSize: 18,
                // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",

                closeallow: false,
                mute: true,
                rateMenu: true,
                resume: true, // (false) enable/disable resume option to start video playback from last time position it was left
                // theaterButton: true,
                // timetooltip: true,
                // mousedisplay: true,
                endAction: 'related', // (undefined) If defined (share/related) either sharing panel or related panel will display when video ends.
                container: "inline",


                // limit: 20,
                // limiturl: "http://localdev.alaatv.com/videojs/examples/basic.html",
                // limitimage : "//cdn.nuevolab.com/media/limit.png", // limitimage or limitmessage
                // limitmessage: "اگه می خوای بقیه اش رو ببینی باید پول بدی :)",


                // overlay: "//domain.com/overlay.html" //(undefined) - overlay URL to display html on each pause event example: https://www.nuevolab.com/videojs/tryit/overlay

            });

            player.hotkeys({
                volumeStep: 0.1,
                seekStep: 5,
                alwaysCaptureHotkeys: true
            });

            player.pic2pic();

            VideoJsHealthCheck.handle(player);
        }
        $(document).on('click', '.btnShowVideoLink', function () {

            $('#videoPlayer').AnimateScrollTo();
            // $([document.documentElement, document.body]).animate({
            //     scrollTop: $("#videoPlayer").offset().top - $('#m_header').height()
            // }, 'slow');

            $('.videoPlayerPortlet').fadeOut().removeClass('m--hide').fadeIn();

            mApp.block('.videoPlayerPortlet', {
                overlayColor: "#000000",
                type: "loader",
                state: "success"
            });

            var videoSrc = $(this).attr('data-videosrc');
            var videoTitle = $(this).attr('data-videotitle');
            var videoDescription = $(this).attr('data-videodes');
            var sources = [{"type": "video/mp4", "src": videoSrc}];

            $("#videoPlayer").find("#videosrc").attr("src", videoSrc);
            $("#videoPlayerTitle").html(videoTitle);
            $("#videoPlayerDescription").html(videoDescription);

            mApp.unblock('.videoPlayerPortlet');

            player.pause();
            player.src(sources);
            player.load();
            // $("html, body").animate({ scrollTop: 0 }, "slow");
        });
    }

    function handleProductInformationMultiColumn() {
        if ($('#productInformation .summernote-row .summernote-col').length > 0) {
            $('#productInformation').css('column-count', '1');
        }
    }

    function initResponsivePage() {
        ProductResponsivePage.apply();
    }

    function initPreviewSets(data) {
        var previewSetsObject = new PreviewSets.init(data);
        previewSetsObject.showPreviewSetDataCallback = function() {};
        return previewSetsObject;
    }

    function init(data) {
        initGAEE();
        initProductSwitchForSelectableProducts();
        initLightGallery();
        initSticky();
        initAddToCartEvent();
        initRefreshPriceEvents();
        initSampleVideoBlock();
        initVideoPlayer();
        handleProductInformationMultiColumn();
        initResponsivePage();
        var previewSetsObject = initPreviewSets(data);

        return previewSetsObject;
    }

    return {
        init: init
    };
}();

$(document).ready(function () {
    var previewSetsObject = InitProductPagePage.init({
        lastSetData: (typeof lastSetData !== 'undefined') ? lastSetData : null,
        allProductsSets: (typeof allProductsSets !== 'undefined') ? allProductsSets : null,
    });

    window.previewSetsObject = previewSetsObject;
});
