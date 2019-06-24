function gtmEecImpressionViewProductBlocks() {
    if ($('.scrollSensitiveOnScreen.targetInScreen.blockWraper-hasProduct').data('gtm-data-sent') == 1) {
        return;
    }
    var bloks = [];
    $('.scrollSensitiveOnScreen.targetInScreen.blockWraper-hasProduct').each(function () {
        var owl = $(this);
        gtmEecImpressionViewCarousel(owl);
    });
    $('.scrollSensitiveOnScreen.targetInScreen.blockWraper-hasProduct').data('gtm-data-sent', 1);
}

function gtmEecImpressionViewCarousel(owl) {
    var carousel = owl.find('.a--owl-carousel-type-2').not('.a--owl-carousel-type-2-gridViewWarper').data('owl.carousel');
    var isGridView = true;
    var impressionViewCarousel = owl.find('.a--owl-carousel-type-2.a--owl-carousel-type-2-gridViewWarper').find('.block-product-item');
    if (typeof carousel !== 'undefined') {
        isGridView = false;
        impressionViewCarousel = carousel._items.filter(function (e) {
            if (e.hasClass('active')) {
                return e;
            }
        });
    }
    var gtmEecImpressionView = [];
    for (let i = 0; i < impressionViewCarousel.length; i++) {
        var childObjectItem = $(impressionViewCarousel[i]);
        if (!isGridView) {
            childObjectItem = $(impressionViewCarousel[i]).find('.block-product-item');
        }
        gtmEecImpressionView.push({
            id:       childObjectItem.data('gtm-eec-product-id').toString(),
            name:     childObjectItem.data('gtm-eec-product-name').toString(),
            price:    childObjectItem.data('gtm-eec-product-price').toString(),
            brand:    childObjectItem.data('gtm-eec-product-brand').toString(),
            category: childObjectItem.data('gtm-eec-product-category').toString(),
            variant:  childObjectItem.data('gtm-eec-product-variant').toString(),
            list:     childObjectItem.data('gtm-eec-product-list').toString(),
            position: childObjectItem.data('gtm-eec-product-position'),
        });
    }
    if (GAEE.reportGtmEecOnConsole()) {
        console.log('gtmEecImpressionViewCarousel: ', gtmEecImpressionView);
    }
    GAEE.impressionView(gtmEecImpressionView);
}

function gtmEecPromotionViewCarousel() {
    if ($("#carouselMainSlideShow.targetInScreen").data('gtm-data-sent') == 1) {
        return;
    }
    var activeCarousel = $("#carouselMainSlideShow.targetInScreen").find('.carousel-item.active');
    if (activeCarousel.length === 0) {
        return false;
    }
    var gtmEecPromotions = [
        {
            id: activeCarousel.data('gtm-eec-promotion-id').toString(),
            name: activeCarousel.data('gtm-eec-promotion-name').toString(),
            creative: activeCarousel.data('gtm-eec-promotion-creative').toString(),
            position: activeCarousel.data('gtm-eec-promotion-position')
        }
    ];
    if (GAEE.reportGtmEecOnConsole()) {
        console.log('gtmEecPromotionViewCarousel: ', gtmEecPromotions);
    }
    GAEE.promotionView(gtmEecPromotions);
    $("#carouselMainSlideShow.targetInScreen").data('gtm-data-sent', 1);
}

function gtmEecPromotionViewBanner() {
    if ($('.gtm-eec-promotion-click.scrollSensitiveOnScreen.targetInScreen').data('gtm-data-sent') == 1) {
        return;
    }
    var ads = $('.gtm-eec-promotion-click.scrollSensitiveOnScreen.targetInScreen').not('.gtm-eec-promotion-slideShow');
    var adsLength = ads.length;
    if (adsLength === 0) {
        return false;
    }
    var gtmEecPromotionViewBanner = [];
    for (let i = 0; i < adsLength; i++) {
        gtmEecPromotionViewBanner.push({
            id: $(ads[i]).data('gtm-eec-promotion-id').toString(),
            name: $(ads[i]).data('gtm-eec-promotion-name').toString(),
            creative: $(ads[i]).data('gtm-eec-promotion-creative').toString(),
            position: $(ads[i]).data('gtm-eec-promotion-position')
        });
    }
    if (GAEE.reportGtmEecOnConsole()) {
        console.log('gtmEecPromotionViewBanner: ', gtmEecPromotionViewBanner);
    }
    GAEE.promotionView(gtmEecPromotionViewBanner);
    $('.gtm-eec-promotion-click.scrollSensitiveOnScreen.targetInScreen').data('gtm-data-sent', 1);
}

function detectElementScrollOnScreen(pageY, $target) {
    var window_height = $(window).height();
    var target_top = $target.offset().top;
    var target_bottom = $target.height() + target_top;
    $('.scrollTop_target_view').html(target_top + ' - ' + pageY + ' <br> ' + (pageY+window_height) + ' - ' + target_bottom);
    if (pageY < target_bottom && (pageY+window_height) > target_top) {
        $target.addClass('targetInScreen');
        return true;
    } else {
        $target.removeClass('targetInScreen');
        return false;
    }
}

jQuery(document).ready( function() {

    var headerHeight = $('#m_header').height();
    var pageY = headerHeight + window.scrollY;
    $('.scrollSensitiveOnScreen').each(function() {
        if (detectElementScrollOnScreen(pageY, $(this))) {
            // Impression View
            gtmEecImpressionViewProductBlocks();
            // Promotion View
            gtmEecPromotionViewBanner();
            gtmEecPromotionViewCarousel();
        } else {
            $(this).data('gtm-data-sent', 0);
        }
    });

    window.addEventListener('scroll', function(e) {
        var headerHeight = $('#m_header').height();
        var pageY = headerHeight + e.pageY;
        $('.scrollSensitiveOnScreen').each(function() {
            if (detectElementScrollOnScreen(pageY, $(this))) {
                // Impression View
                gtmEecImpressionViewProductBlocks();
                // Promotion View
                gtmEecPromotionViewBanner();
                gtmEecPromotionViewCarousel();
            } else {
                $(this).data('gtm-data-sent', 0);
            }
        });
    });

    // Impression View
    $('.blockWraper-hasProduct').find('.a--owl-carousel-type-2').on('translated.owl.carousel', function(event) {
        let currentSlide_children = event.relatedTarget.$stage.children();
        var childObject = [];
        for (let i = event.item.index; i < event.item.index + event.page.size; i++) {
            childObject.push(currentSlide_children[i])
        }
        var gtmEecImpressionView = [];
        for (let i = 0; i < childObject.length; i++) {
            var childObjectItem = $(childObject[i]).find('.block-product-item');
            gtmEecImpressionView.push({
                id:       childObjectItem.data('gtm-eec-product-id').toString(),
                name:     childObjectItem.data('gtm-eec-product-name').toString(),
                price:    childObjectItem.data('gtm-eec-product-price').toString(),
                brand:    childObjectItem.data('gtm-eec-product-brand').toString(),
                category: childObjectItem.data('gtm-eec-product-category').toString(),
                variant:  childObjectItem.data('gtm-eec-product-variant').toString(),
                list:     childObjectItem.data('gtm-eec-product-list').toString(),
                position: childObjectItem.data('gtm-eec-product-position'),
            });
        }
        if (GAEE.reportGtmEecOnConsole()) {
            console.log('gtmEecImpressionViewCarousel: ', gtmEecImpressionView);
        }
        GAEE.impressionView(gtmEecImpressionView);
    });

    // Impression Click
    $(document).on('click' ,'.gtm-eec-product-impression-click', function(e){
        var actionFieldList = $(this).data('gtm-eec-actionFieldList');
        var product = {
            id:       $(this).data('gtm-eec-product-id').toString(),      // (String) The SKU of the product. Example: 'P12345'
            name:     $(this).data('gtm-eec-product-name').toString(),    // (String) The name of the product. Example: 'T-Shirt'
            price:    $(this).data('gtm-eec-product-price').toString(),
            brand:    $(this).data('gtm-eec-product-brand').toString(),   // (String) The brand name of the product. Example: 'NIKE'
            category: $(this).data('gtm-eec-product-category').toString(),// (String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
            variant:  $(this).data('gtm-eec-product-variant').toString(), // (String) What variant of the main product this is. Example: 'Large'
            list:     $(this).data('gtm-eec-product-list').toString(),
            position: $(this).data('gtm-eec-product-position'),           // (Integer) The position of the impression that was clicked. Example: 1
        };
        GAEE.impressionClick(actionFieldList, product);
    });

    // Promotion View
    $("#carouselMainSlideShow").on('slid.bs.carousel', function (e) {
        var gtmEecPromotions = [
            {
                id: $(e.relatedTarget).data('gtm-eec-promotion-id').toString(),
                name: $(e.relatedTarget).data('gtm-eec-promotion-name').toString(),
                creative: $(e.relatedTarget).data('gtm-eec-promotion-creative').toString(),
                position: $(e.relatedTarget).data('gtm-eec-promotion-position')
            }
        ];

        var headerHeight = $('#m_header').height();
        var pageY = headerHeight + window.scrollY;
        if (detectElementScrollOnScreen(pageY, $("#carouselMainSlideShow"))) {
            GAEE.promotionView(gtmEecPromotions);
            if (GAEE.reportGtmEecOnConsole()) {
                console.log('gtmEecPromotionViewCarousel: ', gtmEecPromotions);
            }
        }
    });

    // Promotion Click
    $(document).on('click' ,'.gtm-eec-promotion-click', function(e){
        var promotion = {
            id: $(this).data('gtm-eec-promotion-id').toString(),             // (String) Unique identifier for the promotion. Example: 'summer_campaign'
            name: $(this).data('gtm-eec-promotion-name').toString(),         // (String) The name of the promotion. Example: 'Summer Campaign 2019'
            creative: $(this).data('gtm-eec-promotion-creative').toString(), // (String) A name for the creative where the promotion was clicked. Example: 'front_page_banner_1'
            position: $(this).data('gtm-eec-promotion-position')             // (String) Some way to distinguish the position of the promotion in the creative (e.g. second slide of a carousel). Example: 'slot_2'
        };
        GAEE.promotionClick(promotion);
    });

});