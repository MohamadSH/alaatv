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
jQuery(document).ready( function() {
    SnippetContentShow.init(related_videos);
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
    $(document).on('click', '.scrollToOwlCarouselParentProducts', function(){
        $("#owlCarouselParentProducts").AnimateScrollTo();
        // $([document.documentElement, document.body]).animate({
        //     scrollTop: ($("#owlCarouselParentProducts").offset().top - 80)
        // }, 500);
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
});
