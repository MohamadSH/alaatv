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
            if(!isNaN(index)) {
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

    return {
        init:function () {
            return getChildLevel();
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
                            $('#a_product-price').html('قیمت محصول: <strike>' + response_cost + '</strike> تومان <br>قیمت برای مشتری: ' + response_costForCustomer + ' تومان ');
                        } else {
                            $('#a_product-price').html('قیمت محصول: ' + response_costForCustomer + ' تومان ');
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
        var productsState = $('input[type=checkbox][name="products[]"]:checked').map(function(){
            if ($(this).val())
                return $(this).val();
        }).get();
        return productsState;
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
    };
}();

jQuery(document).ready(function() {

    let childLevel = ProductSwitch.init();

    var player = null;

    var player = videojs('videoPlayer');
    player.nuevo({
        // plugin options here
        logocontrolbar: '/acm/extra/Alaa-logo.gif',
        logourl: '//sanatisharif.ir',

        videoInfo: true,
        relatedMenu: true,
        zoomMenu: true,
        mirrorButton: true,
        // related: related_videos,
        // endAction: 'related',
    });

    console.log('player: ', player);

    let callBack = function () {
        let productsState = ProductShowPage.getProductSelectValues();
        ProductShowPage.refreshPrice([], productsState, []);
    };

    $("#lightgallery").lightGallery();

    $('.productDetailes .m-portlet__head').sticky({
        topSpacing: $('#m_header').height(),
        zIndex: 99
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

    $(document).on('change', "input[name='products[]'].product", function() {
        let thisValue = this.defaultValue;
        let hasChildren = $(this).hasClass('hasChildren');
        if(hasChildren) {
            ProductSwitch.changeChildCheckStatus(thisValue, $(this).prop('checked'));
        }
        ProductSwitch.updateSelectedProductsStatus(childLevel,callBack );
    });

    $(document).on('click', '.btnAddToCart', function () {

        ProductShowPage.disableBtnAddToCart();
        var product = $("input[name=product_id]").val();
        let mainAttributeStates = ProductShowPage.getMainAttributeStates();
        let extraAttributeStates = ProductShowPage.getExtraAttributeStates();
        let productSelectValues = ProductShowPage.getProductSelectValues() ;

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
});
