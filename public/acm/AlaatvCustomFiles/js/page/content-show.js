var SnippetContentShow = function(){
    var handlePlayerRelatedVideos = function (related_videos) {
        var contentId = $('#js-var-contentId').val();
        var contentUrl = $('#js-var-contentUrl').val();
        var contentEmbedUrl = $('#js-var-contentEmbedUrl').val();
        var contentDisplayName = $('#js-var-contentDName').val();
        var player = null;
        if ($('#video-' + contentId).length > 0) {

            player = videojs('video-' + contentId, {language: 'fa'});
            player.nuevo({
                // logotitle:"آموزش مجازی آلاء",
                // logo:"https://sanatisharif.ir/image/11/135/67/logo-150x22_20180430222256.png",
                logocontrolbar: 'https://cdn.alaatv.com/upload/alaa-logo-small.png',
                // logoposition:"RT", // logo position (LT - top left, RT - top right)
                logourl:'//alaatv.com',

                shareTitle: contentDisplayName,
                shareUrl: contentUrl,
                shareEmbed: '<iframe src="' + contentEmbedUrl + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>',



                videoInfo: true,
                // infoSize: 18,
                // infoIcon: "https://sanatisharif.ir/image/11/150/150/favicon_32_20180819090313.png",


                relatedMenu: true,
                zoomMenu: true,
                related: related_videos,
                mirrorButton: true,

                closeallow:false,
                mute:true,
                rateMenu:true,
                resume:true, // (false) enable/disable resume option to start video playback from last time position it was left
                // theaterButton: true,
                timetooltip: true,
                mousedisplay: true,
                endAction: 'related', // (undefined) If defined (share/related) either sharing panel or related panel will display when video ends.
                container: "inline",


                // limit: 20,
                // limiturl: "http://localdev.alaatv.com/videojs/examples/basic.html",
                // limitimage : "//cdn.nuevolab.com/media/limit.png", // limitimage or limitmessage
                // limitmessage: "اگه می خوای بقیه اش رو ببینی باید پول بدی :)",


                // overlay: "//domain.com/overlay.html" //(undefined) - overlay URL to display html on each pause event example: https://www.nuevolab.com/videojs/tryit/overlay

            });

            player.hotkeys({
                enableVolumeScroll: false,
                volumeStep: 0.1,
                seekStep: 5
            });

            player.pic2pic();
            player.on('resolutionchange', function () {
                var last_resolution = param.label;
            });
        }

    };
    var handleVideoPlayListScroll = function () {
        var contentId = $('#js-var-contentId').val();
        var container = $("#playListScroller"),
            scrollTo = $("#playlistItem_" + contentId);
        if (scrollTo.length > 0) {
            container.scrollTop(scrollTo.offset().top - 400);
        }
    };

    return {
      init: function (related_videos) {
          handleVideoPlayListScroll();
          handlePlayerRelatedVideos(related_videos);
      }
    };
}();

var RelatedItems = function() {

    var alpha = 530/942;

    function getProductItemObject() {
        return $('.RelatedItems .ScrollCarousel-Items .item.a--block-type-product2 img');
    }

    function getOtherItemObject() {
        return $('.RelatedItems .ScrollCarousel-Items .item:not(.a--block-type-product2) .a--block-imageWrapper .a--block-imageWrapper-image img');
    }

    function getProductCount() {
        return getProductItemObject().length;
    }

    function getOtherCount() {
        return getOtherItemObject().length;
    }

    function getTotlalWidth() {
        return $('.RelatedItems .ScrollCarousel-Items').width();
    }

    function getOuterSpace($object) {
        if ($object.length > 0) {
            return $object.outerWidth(true) - $object.width();
        } else {
            return 0;
        }
    }

    function responsiveConfig() {
        var sw = screen.width,
            minCountInPage = 0,
            maxCountInPage = 0;
        if (sw > 1701) {
            maxCountInPage = 6;
            minCountInPage = 5;
        } else if (sw > 1281) {
            maxCountInPage = 5;
            minCountInPage = 4;
        } else if (sw > 1025) {
            maxCountInPage = 4;
            minCountInPage = 3;
        } else if (sw > 768) {
            maxCountInPage = 3;
            minCountInPage = 2;
        } else if (sw > 481) {
            maxCountInPage = 2;
            minCountInPage = 1;
        } else {
            maxCountInPage = 1;
            minCountInPage = 1;
        }

         return {
             min: minCountInPage,
             max: maxCountInPage
         };
    }

    function getCountOfProductInScrollCarousel() {
        var pc = getProductCount(),
            rc = responsiveConfig();
        if (pc > rc.max) {
            pc = rc.max;
        }
        return pc;
    }

    function getCountOfOtherInScrollCarousel() {
        var pc = getCountOfProductInScrollCarousel(),
            noc = getOtherCount(),
            rc = responsiveConfig(),
            nocMax = rc.max - pc,
            nocMin = rc.min - pc;

        if (noc > nocMax) {
            noc = nocMax + 0.3;
        } else if (noc > nocMin) {
            noc = nocMin + 0.3;
        } else if (noc === nocMin) {

        } else if (noc < nocMin) {
            noc = nocMin;
        }

        return noc;
    }

    function setWidth($item, percent) {
        $item.css({
            'width': percent+'%',
            '-ms-flex-basis': percent+'%',
            'flex-basis': percent+'%'
        });
    }

    function calcProductItemWidth() {
        var w = getTotlalWidth(),
            oc = getCountOfOtherInScrollCarousel(),
            pc = getCountOfProductInScrollCarousel(),
            os = getOuterSpace(getOtherItemObject().parents('.item')),
            ps = getOuterSpace(getProductItemObject().parents('.item'));

        return (( w - (Math.floor(pc)*ps) - (Math.floor(oc)*os) ) / (pc+(oc/alpha)));
    }

    function calcOtherItemWidth(a) {
        return a/alpha;
    }

    function refreshImages() {
        $('.RelatedItems .ScrollCarousel-Items .item:first-child').css({'margin-right': '5px'});
        getOtherItemObject().attr('src', '').attr('a-lazyload', '').attr('data-loaded', '').removeClass('lazy-done');
        getProductItemObject().attr('src', '').attr('a-lazyload', '').attr('data-loaded', '').removeClass('lazy-done');
        imageObserver.observe();
    }

    function setRelatedItemsWidth() {
        var w = getTotlalWidth(),
            a = calcProductItemWidth(),
            pw = (a/w)*100,
            ow = (calcOtherItemWidth(a)/w)*100;

        setWidth(getProductItemObject().parents('.item'), pw);
        setWidth(getOtherItemObject().parents('.item'), ow);


        setTimeout(function () {
            refreshImages();
        }, 500);
    }

    function init() {
        setRelatedItemsWidth();
        $('.RelatedItems .SortItemsList').Sort({order:'shu'});
    }

    return {
        init: init,
    };
}();

var SameHeight = function() {

    function calcSetContentsList() {
        $('#playListScroller').css({'height': 0});
        return $('.top-right-section').outerHeight(true) - $('.top-left-section .m-portlet').outerHeight(true) - $('.top-left-section .top-left-section-ad').outerHeight(true);
    }

    function setContentsList() {
        $('#playListScroller').css({'height': calcSetContentsList()});
    }

    function setPamphletMaxHeightList() {
        if ($('.downloadLinkColumn').length > 0) {
            var height = $('.downloadLinkColumn .m-portlet .m-portlet__body > .row').height() - 30;
            $('#m_tabs_1_1').css({'max-height':  height + 'px', 'overflow': 'auto'});
            $('#m_tabs_1_2').css({'max-height':  height + 'px', 'overflow': 'auto'});
        }
    }

    function init() {
        setContentsList();
        setPamphletMaxHeightList();
    }

    return {
        init: init
    }
}();

var InitPage = function() {

    function initOwlCarouselType2() {
        $('#owlCarouselParentProducts').OwlCarouselType2({
            OwlCarousel: {
                center: false,
                loop: false,
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            grid: {
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
        });

        $('.contentBlock').OwlCarouselType2({
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
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            grid: {
                columnClass: 'col-12 col-sm-6 col-md-3 gridItem',
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            defaultView: 'OwlCarousel', // OwlCarousel or grid
            childCountHideOwlCarousel: 4
        });
    }

    function addEvents() {
        $(document).on('click', '.scrollToOwlCarouselParentProducts', function(){
            // $("#owlCarouselParentProducts").AnimateScrollTo();
            $('.downloadLinkColumn').AnimateScrollTo();
        });
        $(document).on('click', '.btnAddToCart', function () {
            mApp.block('.btnAddToCart', {
                type: "loader",
                state: "info",
            });

            let productId = $(this).data('pid');

            let selectedProductObject = {
                id:       $(this).data('gtm-eec-product-id').toString(),      // (String) The SKU of the product. Example: 'P12345'
                name:     $(this).data('gtm-eec-product-name').toString(),    // (String) The name of the product. Example: 'T-Shirt'
                price:    $(this).data('gtm-eec-product-price').toString(),
                brand:    $(this).data('gtm-eec-product-brand').toString(),   // (String) The brand name of the product. Example: 'NIKE'
                category: $(this).data('gtm-eec-product-category').toString(),// (String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
                variant:  $(this).data('gtm-eec-product-variant').toString(), // (String) What variant of the main product this is. Example: 'Large'
                quantity: $(this).data('gtm-eec-product-quantity')
            };
            GAEE.productAddToCart('sampleVideo.addToCart', selectedProductObject);
            if (GAEE.reportGtmEecOnConsole()) {
                console.log('product.addToCart', selectedProductObject);
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

                            let successMessage = 'محصول مورد نظر به سبد خرید اضافه شد.';

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

                let data = {
                    'product_id': productId,
                    'attribute': [],
                    'extraAttribute': [],
                    'products': [],
                };

                UesrCart.addToCartInCookie(data);

                let successMessage = 'محصول مورد نظر به سبد خرید اضافه شد.';


                toastr.success(successMessage);

                setTimeout(function () {
                    window.location.replace('/checkout/review');
                }, 2000);
            }

        });
    }

    function init() {
        RelatedItems.init();
        SnippetContentShow.init(related_videos);
        SameHeight.init();
        initOwlCarouselType2();
        addEvents();
    }

    return {
        init: init
    };

}();

jQuery(document).ready( function() {
    InitPage.init();
});
