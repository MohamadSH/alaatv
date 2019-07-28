// function gtmEecImpressionViewProductBlocks() {
//     if ($('.scrollSensitiveOnScreen.targetInScreen.blockWraper-hasProduct').data('gtm-data-sent') == 1) {
//         return;
//     }
//     var bloks = [];
//     $('.scrollSensitiveOnScreen.targetInScreen.blockWraper-hasProduct').each(function () {
//         var owl = $(this);
//         gtmEecImpressionViewCarousel(owl);
//     });
//     $('.scrollSensitiveOnScreen.targetInScreen.blockWraper-hasProduct').data('gtm-data-sent', 1);
// }

// function gtmEecImpressionViewCarousel(owl) {
//     var carousel = owl.find('.a--owl-carousel-type-2').not('.a--owl-carousel-type-2-gridViewWarper').data('owl.carousel');
//     var isGridView = true;
//     var impressionViewCarousel = owl.find('.a--owl-carousel-type-2.a--owl-carousel-type-2-gridViewWarper').find('.block-product-item');
//     if (typeof carousel !== 'undefined') {
//         isGridView = false;
//         impressionViewCarousel = carousel._items.filter(function (e) {
//             if (e.hasClass('active')) {
//                 return e;
//             }
//         });
//     }
//     var gtmEecImpressionView = [];
//     for (let i = 0; i < impressionViewCarousel.length; i++) {
//         var childObjectItem = $(impressionViewCarousel[i]);
//         if (!isGridView) {
//             childObjectItem = $(impressionViewCarousel[i]).find('.block-product-item');
//         }
//         gtmEecImpressionView.push({
//             id:       childObjectItem.data('gtm-eec-product-id').toString(),
//             name:     childObjectItem.data('gtm-eec-product-name').toString(),
//             price:    childObjectItem.data('gtm-eec-product-price').toString(),
//             brand:    childObjectItem.data('gtm-eec-product-brand').toString(),
//             category: childObjectItem.data('gtm-eec-product-category').toString(),
//             variant:  childObjectItem.data('gtm-eec-product-variant').toString(),
//             list:     childObjectItem.data('gtm-eec-product-list').toString(),
//             position: childObjectItem.data('gtm-eec-product-position'),
//         });
//     }
//     if (GAEE.reportGtmEecOnConsole()) {
//         console.log('gtmEecImpressionViewCarousel: ', gtmEecImpressionView);
//     }
//     GAEE.impressionView(gtmEecImpressionView);
// }
//
// function gtmEecPromotionViewCarousel() {
//     if ($("#carouselMainSlideShow.targetInScreen").data('gtm-data-sent') == 1) {
//         return;
//     }
//     var activeCarousel = $("#carouselMainSlideShow.targetInScreen").find('.carousel-item.active');
//     if (activeCarousel.length === 0) {
//         return false;
//     }
//     var gtmEecPromotions = [
//         {
//             id: activeCarousel.data('gtm-eec-promotion-id').toString(),
//             name: activeCarousel.data('gtm-eec-promotion-name').toString(),
//             creative: activeCarousel.data('gtm-eec-promotion-creative').toString(),
//             position: activeCarousel.data('gtm-eec-promotion-position')
//         }
//     ];
//     if (GAEE.reportGtmEecOnConsole()) {
//         console.log('gtmEecPromotionViewCarousel: ', gtmEecPromotions);
//     }
//     GAEE.promotionView(gtmEecPromotions);
//     $("#carouselMainSlideShow.targetInScreen").data('gtm-data-sent', 1);
// }
//
// function gtmEecPromotionViewBanner() {
//     if ($('.a--gtm-eec-advertisement-click.scrollSensitiveOnScreen.targetInScreen').data('gtm-data-sent') == 1) {
//         return;
//     }
//     var ads = $('.a--gtm-eec-advertisement-click.scrollSensitiveOnScreen.targetInScreen').not('.gtm-eec-promotion-slideShow');
//     var adsLength = ads.length;
//     if (adsLength === 0) {
//         return false;
//     }
//     var gtmEecPromotionViewBanner = [];
//     for (let i = 0; i < adsLength; i++) {
//         gtmEecPromotionViewBanner.push({
//             id: $(ads[i]).data('gtm-eec-promotion-id').toString(),
//             name: $(ads[i]).data('gtm-eec-promotion-name').toString(),
//             creative: $(ads[i]).data('gtm-eec-promotion-creative').toString(),
//             position: $(ads[i]).data('gtm-eec-promotion-position')
//         });
//     }
//     if (GAEE.reportGtmEecOnConsole()) {
//         console.log('gtmEecPromotionViewBanner: ', gtmEecPromotionViewBanner);
//     }
//     GAEE.promotionView(gtmEecPromotionViewBanner);
//     $('.a--gtm-eec-advertisement-click.scrollSensitiveOnScreen.targetInScreen').data('gtm-data-sent', 1);
// }

// function detectElementScrollOnScreen(pageY, $target) {
//     var window_height = $(window).height();
//     var target_top = $target.offset().top;
//     var target_bottom = $target.height() + target_top;
//     $('.scrollTop_target_view').html(target_top + ' - ' + pageY + ' <br> ' + (pageY+window_height) + ' - ' + target_bottom);
//     if (pageY < target_bottom && (pageY+window_height) > target_top) {
//         $target.addClass('targetInScreen');
//         return true;
//     } else {
//         $target.removeClass('targetInScreen');
//         return false;
//     }
// }

jQuery(document).ready( function() {
    //
    // var headerHeight = $('#m_header').height();
    // var pageY = headerHeight + window.scrollY;
    // $('.scrollSensitiveOnScreen').each(function() {
    //     if (detectElementScrollOnScreen(pageY, $(this))) {
    //         // Impression View
    //         gtmEecImpressionViewProductBlocks();
    //         // Promotion View
    //         gtmEecPromotionViewBanner();
    //         gtmEecPromotionViewCarousel();
    //     } else {
    //         $(this).data('gtm-data-sent', 0);
    //     }
    // });
    //
    // window.addEventListener('scroll', function(e) {
    //     var headerHeight = $('#m_header').height();
    //     var pageY = headerHeight + e.pageY;
    //     $('.scrollSensitiveOnScreen').each(function() {
    //         if (detectElementScrollOnScreen(pageY, $(this))) {
    //             // Impression View
    //             gtmEecImpressionViewProductBlocks();
    //             // Promotion View
    //             gtmEecPromotionViewBanner();
    //             gtmEecPromotionViewCarousel();
    //         } else {
    //             $(this).data('gtm-data-sent', 0);
    //         }
    //     });
    // });
    //
    // // Impression View
    // $('.blockWraper-hasProduct').find('.a--owl-carousel-type-2').on('translated.owl.carousel', function(event) {
    //     let currentSlide_children = event.relatedTarget.$stage.children();
    //     var childObject = [];
    //     for (let i = event.item.index; i < event.item.index + event.page.size; i++) {
    //         childObject.push(currentSlide_children[i])
    //     }
    //     var gtmEecImpressionView = [];
    //     for (let i = 0; i < childObject.length; i++) {
    //         var childObjectItem = $(childObject[i]).find('.block-product-item');
    //         if (childObjectItem.length > 0) {
    //             gtmEecImpressionView.push({
    //                 id:       childObjectItem.data('gtm-eec-product-id').toString(),
    //                 name:     childObjectItem.data('gtm-eec-product-name').toString(),
    //                 price:    childObjectItem.data('gtm-eec-product-price').toString(),
    //                 brand:    childObjectItem.data('gtm-eec-product-brand').toString(),
    //                 category: childObjectItem.data('gtm-eec-product-category').toString(),
    //                 variant:  childObjectItem.data('gtm-eec-product-variant').toString(),
    //                 list:     childObjectItem.data('gtm-eec-product-list').toString(),
    //                 position: childObjectItem.data('gtm-eec-product-position'),
    //             });
    //         }
    //     }
    //     if (GAEE.reportGtmEecOnConsole()) {
    //         console.log('gtmEecImpressionViewCarousel: ', gtmEecImpressionView);
    //     }
    //     GAEE.impressionView(gtmEecImpressionView);
    // });


    // // Promotion View
    // $("#carouselMainSlideShow").on('slid.bs.carousel', function (e) {
    //     var gtmEecPromotions = [
    //         {
    //             id: $(e.relatedTarget).data('gtm-eec-promotion-id').toString(),
    //             name: $(e.relatedTarget).data('gtm-eec-promotion-name').toString(),
    //             creative: $(e.relatedTarget).data('gtm-eec-promotion-creative').toString(),
    //             position: $(e.relatedTarget).data('gtm-eec-promotion-position')
    //         }
    //     ];
    //
    //     var headerHeight = $('#m_header').height();
    //     var pageY = headerHeight + window.scrollY;
    //     if (detectElementScrollOnScreen(pageY, $("#carouselMainSlideShow"))) {
    //         GAEE.promotionView(gtmEecPromotions);
    //         if (GAEE.reportGtmEecOnConsole()) {
    //             console.log('gtmEecPromotionViewCarousel: ', gtmEecPromotions);
    //         }
    //     }
    // });


});