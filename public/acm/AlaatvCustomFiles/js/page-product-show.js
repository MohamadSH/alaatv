var ProductSwitch = function () {

    function changeChildCheckStatus(parentId, status) {
        let items = $("input[name='products[]'].product.hasParent_"+parentId);
        for (let index in items) {
            if(!isNaN(index)) {
                let hasChildren = $(items[index]).hasClass('hasChildren');
                let defaultValue = items[index].defaultValue;
                $(items[index]).prop('checked', status);
                if (hasChildren) {
                    changeChildCheckStatus(defaultValue, status);
                }
            }
        }
    }

    function singleUpdateSelectedProductsStatus() {

        let items = $("input[name='products[]'].product");
        for (let index in items) {
            if(!isNaN(index)) {
                let hasChildren = $(items[index]).hasClass('hasChildren');
                let thisValue = items[index].defaultValue;
                let report1 = {
                    'allChildIsChecked': true,
                    'allChildIsNotChecked': true,
                    'counter': 0
                };
                let report = checkChildProduct(thisValue, report1);
                if(hasChildren) {
                    if(report.allChildIsChecked) {
                        $(items[index]).prop('checked', true);
                    } else {
                        $(items[index]).prop('checked', false);
                    }
                }
            }
        }
    }

    function checkChildProduct(parentId, report) {
        let items = $("input[name='products[]'].product.hasParent_"+parentId);
        report.counter++;
        for (let index in items) {
            if(isNaN(index)) {
               continue;
            }
            let defaultValue = items[index].defaultValue;
            let thisCheckBox = $("input[name='products[]'][value='" + defaultValue + "'].product");
            let hasChildren = thisCheckBox.hasClass('hasChildren');
            let thisExist = thisCheckBox.length;
            let thisIsChecked = thisCheckBox.prop('checked');
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
        let firstDefaultValue = $("input[name='products[]'].product")[0].defaultValue;
        let report1 = {
            'allChildIsChecked': true,
            'allChildIsNotChecked': true,
            'counter': 0
        };
        let report = checkChildProduct(firstDefaultValue, report1);
        return report.counter;
    }

    function updateSelectedProductsStatus(childLevel, callback) {
        for (let i=0; i<childLevel; i++) {
            singleUpdateSelectedProductsStatus();
        }
        callback();
    }

    function checkChildrenOfParentOnInit() {
        let items = $("input[name='products[]'].product.hasChildren:checked");
        for (let index in items) {
            if(isNaN(index)) {
                continue;
            }
            changeChildCheckStatus(items[index].defaultValue, true);
        }
    }

    return {
        init:function () {
            let childLevel = getChildLevel();
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

    function refreshPrice(mainAttributeState , productState , extraAttributeState) {
        var product = $("input[name=product_id]").val();

        $('#a_product-price').html('<div class="m-loader m-loader--success"></div>');
        if (mainAttributeState.length === 0 && productState.length === 0 && extraAttributeState.length === 0) {

            $('#a_product-price').html('قیمت محصول: ' + 'پس از انتخاب محصول');

            toastr.warning("شما هیچ محصولی را انتخاب نکرده اید.", "توجه!");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "/api/v1/getPrice/"+product,
            data: { mainAttributeValues: mainAttributeState , products: productState , extraAttributeValues: extraAttributeState },
            statusCode: {
                //The status for when action was successful
                200: function (response) {
                    response = $.parseJSON(response);

                    if (response.error != null) {

                        toastr.warning(response.error.message + '(' + response.error.code + ')');

                        $('#a_product-price').html('قیمت محصول: ' + 'پس از انتخاب محصول');
                    }
                    if (response.cost != null) {
                        let response_cost = parseInt(response.cost.base);
                        let response_costForCustomer = parseInt(response.cost.final);

                        if (response_costForCustomer < response_cost) {
                            $('#a_product-price').html('قیمت محصول: <del>' + response_cost.toLocaleString('fa') + '</del> تومان <br>قیمت برای مشتری: ' + response_costForCustomer.toLocaleString('fa') + ' تومان ');
                        } else {
                            $('#a_product-price').html('قیمت محصول: ' + response_costForCustomer.toLocaleString('fa') + ' تومان ');
                        }
                    } else {

                        toastr.error('خطایی رخ داده است.');

                        $('#a_product-price').html('-');
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
                },
                //The status for when there is error php code
                503: function (response) {
//                            toastr["error"]("خطای پایگاه داده!", "پیام سیستم");
                }
            }
        });
    }

    function getMainAttributeStates()
    {
        var staticAttributeState = $('input[type=hidden][name="attribute[]"]').map(function(){
            if ($(this).val())
                return $(this).val();
        }).get();
        var selectAttributeState = $('select[name="attribute[]"]').map(function(){
            if ($(this).val())
                return $(this).val();
        }).get();
        var checkboxAttributeState = $('input[type=checkbox][name="attribute[]"]:checked').map(function(){
            if ($(this).val())
                return $(this).val();
        }).get();

        var c = $.merge($.merge(selectAttributeState , checkboxAttributeState) , staticAttributeState);
        var attributeState= c.filter(function (item, pos) {return c.indexOf(item) == pos});

        return attributeState ;
    }

    function getExtraAttributeStates()
    {
        var selectAttributeState = $('select[name="extraAttribute[]"]').map(function(){
            if ($(this).val())
                return $(this).val();
        }).get();

        var checkboxAttributeState = $('input[type=checkbox][name="extraAttribute[]"]:checked').map(function(){
            if ($(this).val())
                return $(this).val();
        }).get();


        var c = $.merge(selectAttributeState , checkboxAttributeState);
        var attributeState= c.filter(function (item, pos) {return c.indexOf(item) == pos});

        let extraAttributes = [];

        for (let index in attributeState) {
            if (!isNaN(index)) {
                extraAttributes.push({
                    'id': attributeState[index]
                });
            }
        }
        return extraAttributes;
    }

    function getProductSelectValues()
    {
        // var productsState = $('input[type=checkbox][name="products[]"]:enabled:checked').map(function(){
        //     if ($(this).val())
        //         return $(this).val();
        // }).get();
        return $('input[type=checkbox][name="products[]"]:checked').map(function () {
            if ($(this).val())
                return $(this).val();
        }).get();
    }

    function getSelectedProductObject()
    {
        return $('input[type=checkbox][name="products[]"]:checked').map(function () {
            if ($(this).val()) {
                var name = $('.childProductName-'+$(this).val()).html();
                name = name.replace('\n', '').trim();
                return {
                    id: $(this).val(),
                    name: name,
                    quantity: 1
                };
            }
        }).get();
    }

    return {
        disableBtnAddToCart: function () {
            disableBtnAddToCart();
        },

        enableBtnAddToCart: function () {
            enableBtnAddToCart();
        },

        refreshPrice: function (mainAttributeState , productState , extraAttributeState) {
            refreshPrice(mainAttributeState , productState , extraAttributeState);
        },

        getMainAttributeStates: function () {
            return getMainAttributeStates();
        },

        getExtraAttributeStates: function () {
            return getExtraAttributeStates();
        },

        getProductSelectValues: function () {
            return getProductSelectValues();
        },

        getSelectedProductObject: function () {
            return getSelectedProductObject();
        },
    };
}();

jQuery(document).ready(function() {

    GAEE.productDetailViews('product.show', parentProduct);

    let childLevel = ProductSwitch.init();

    let callBack = function () {
        let productsState = ProductShowPage.getProductSelectValues();
        ProductShowPage.refreshPrice([], productsState, []);
    };

    $("#lightgallery").lightGallery();

    $('.sampleVideo .m-portlet__head').sticky({
        // container: '.sampleVideo',
        hidePosition: {
            element: '.productPamphletWarper .productPamphletTitle',
            topSpace: $('#m_header').height()
        },
        topSpacing: $('#m_header').height(),
        zIndex: 98
    });

    $('.productPamphletWarper .productPamphletTitle').sticky({
        // container: '.productPamphletWarper',
        hidePosition: {
            element: '.productDetailes .m-portlet__head',
            topSpace: $('#m_header').height()
        },
        topSpacing: $('#m_header').height(),
        zIndex: 98
    });

    $('.productDetailes .m-portlet__head').sticky({
        // container: '.productDetailes',
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
        $([document.documentElement, document.body]).animate({
            scrollTop: $('#'+targetId).offset().top - $('#m_header').height() + 5
        }, 1000);
    });

    $(document).on('click', '.btnShowVideoLink', function () {

        $([document.documentElement, document.body]).animate({
            scrollTop: $("#videoPlayer").offset().top - $('#m_header').height()
        }, 'slow');

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

    $(document).on('click', '.btnAddToCart', function (e) {

        ProductShowPage.disableBtnAddToCart();
        var product = $("input[name=product_id]").val();
        let mainAttributeStates = ProductShowPage.getMainAttributeStates();
        let extraAttributeStates = ProductShowPage.getExtraAttributeStates();
        let productSelectValues = ProductShowPage.getProductSelectValues() ;
        let selectedProductObject = ProductShowPage.getSelectedProductObject() ;

        for (var index in selectedProductObject) {
            selectedProductObject[index].category = parentProductTags;
            selectedProductObject[index].variant = 'simple';
        }
        selectedProductObject.push(parentProduct);
        TotalQuantityAddedToCart = selectedProductObject.length;
        GAEE.productAddToCart('product.addToCart', selectedProductObject);


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
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        // console.log(response);

                        let successMessage = 'محصول مورد نظر به سبد خرید اضافه شد.';

                        toastr.success(successMessage);

                        setTimeout(function () {
                            window.location.replace('/checkout/review');
                        }, 1000);

                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        // window.location.replace("/403");
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (response) {
                        // window.location.replace("/403");
                    },
                    404: function (response) {
                        // window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                    },
                    //The status for when there is error php code
                    500: function (response) {

                        toastr.error('خطای سیستمی رخ داده است.');

                        ProductShowPage.enableBtnAddToCart();
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        toastr.error('خطای پایگاه داده!');
                        ProductShowPage.enableBtnAddToCart();
                    }
                }
            });

        } else {

            let data = {
                'product_id': $('input[name="product_id"][type="hidden"]').val(),
                'attribute': mainAttributeStates,
                'extraAttribute': extraAttributeStates,
                'products': productSelectValues,
            };

            UesrCart.addToCartInCookie(data);

            let successMessage = 'محصول مورد نظر به سبد خرید اضافه شد.';


            toastr.success(successMessage);

            setTimeout(function () {
                window.location.replace('/checkout/review');
            }, 2000);
        }

    });

    $(document).on('change', "input[name='products[]'].product", function() {
        let thisValue = this.defaultValue;
        let hasChildren = $(this).hasClass('hasChildren');
        if(hasChildren) {
            ProductSwitch.changeChildCheckStatus(thisValue, $(this).prop('checked'));
        }
        ProductSwitch.updateSelectedProductsStatus(childLevel,callBack );
    });

    $(document).on("ifChanged change", ".attribute", function () {
        var attributeState = ProductShowPage.getMainAttributeStates();
        ProductShowPage.refreshPrice(attributeState , [] ,[]);
    });

    $(document).on("ifChanged change", ".extraAttribute", function () {
        var attributeState = ProductShowPage.getExtraAttributeStates();
        ProductShowPage.refreshPrice([] , [] , attributeState);
    });

    $(document).on("ifChanged switchChange.bootstrapSwitch", ".product", function () {
        var productsState = ProductShowPage.getProductSelectValues() ;
        ProductShowPage.refreshPrice([] , productsState , []);
    });

    $('.productShowBlock').OwlCarouselType2({
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
            }
        },
        grid: {
            columnClass: 'col-12 col-sm-6 col-md-3 gridItem'
        },
        defaultView: 'OwlCarousel', // OwlCarousel or grid
        childCountHideOwlCarousel: 4
    });

    var player = videojs('videoPlayer', {language: 'fa'});


    if ($('input[type="hidden"][name="introVideo"]').length > 0) {
        player.src([
            {type: "video/mp4", src: $('input[type="hidden"][name="introVideo"]').val()}
        ]);
    }

    player.nuevo({
        // logotitle:"آموزش مجازی آلاء",
        // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
        logocontrolbar: '/acm/extra/Alaa-logo.gif',
        // logoposition:"RT", // logo position (LT - top left, RT - top right)
        logourl: '//sanatisharif.ir',
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

    // player.on('mode',function(event,mode) {
    //     console.log('mode: ', mode);
    //     let width = '100%';
    //     if(mode=='large') {
    //         // $('.productDetailesColumns .column1').addClass('order-2');
    //         // $('.productDetailesColumns .column2').addClass('order-3');
    //         $('.productDetailesColumns .column3').addClass('order-first');
    //         $('.productDetailesColumns .column3').removeClass('col-lg-4');
    //         $('.productDetailesColumns .column3').addClass('col-lg-12');
    //         $('.productDetailesColumns .column3 .videoPlayerPortlet').css({'width':'60%'});
    //     } else {
    //         // $('.productDetailesColumns .column1').removeClass('order-2');
    //         // $('.productDetailesColumns .column2').removeClass('order-3');
    //         $('.productDetailesColumns .column3').removeClass('order-first');
    //         $('.productDetailesColumns .column3').removeClass('col-lg-12');
    //         $('.productDetailesColumns .column3').addClass('col-lg-4');
    //         $('.productDetailesColumns .column3 .videoPlayerPortlet').css({'width':'100%'});
    //     }
    // });

});



