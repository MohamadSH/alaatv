jQuery(document).ready( function() {
    // var owl = jQuery('.a--owl-carousel-type-1.owl-carousel');
    // owl.each(function () {
    //     $(this).owlCarousel({
    //         stagePadding: 40,
    //         loop: false,
    //         rtl:true,
    //         nav: true,
    //         dots: false,
    //         margin:15,
    //         mouseDrag: true,
    //         touchDrag: true,
    //         pullDrag: true,
    //         responsiveClass:true,
    //         responsive:{
    //             0:{
    //                 items:1,
    //             },
    //             600:{
    //                 items:3,
    //             },
    //             1200:{
    //                 items:3
    //             },
    //             1600:{
    //                 items: 4
    //             }
    //         }
    //     });
    //     /*$(this).on('mousewheel', '.owl-stage', function (e) {
    //         if (e.deltaY>0) {
    //             $(this).trigger('next.owl');
    //         } else {
    //             $(this).trigger('prev.owl');
    //         }
    //         e.preventDefault();
    //     });*/
    // });

    /*
     * Google TagManager
     */
    var userIpDimensionValue = $('#js-var-userIp').val();
    var userIdDimensionValue = $('#js-var-userId').val();
    dataLayer.push(
        {
            'userIp': userIpDimensionValue,
            'dimension2': userIpDimensionValue,
            'userId': userIdDimensionValue,
            'user_id': userIdDimensionValue
        });


    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-full-width",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };


    $(document).on('click' ,'.gtm-eec-product-impression-click', function(e){
        var actionFieldList = $(this).data('gtm-eec-actionFieldList');
        var product = {
            id: $(this).data('gtm-eec-product-id'), // (String) The SKU of the product. Example: 'P12345'
            name: $(this).data('gtm-eec-product-name'), // (String) The name of the product. Example: 'T-Shirt'
            category: $(this).data('gtm-eec-product-category'), // (String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
            position: $(this).data('gtm-eec-product-position'), // (Integer) The position of the impression that was clicked. Example: 1
            // variant: $(this).data('gtm-eec-product-variant'), // (String) What variant of the main product this is. Example: 'Large'
            // brand: $(this).data('gtm-eec-product-brand'), // (String) The brand name of the product. Example: 'NIKE'
        };
        GAEE.impressionClick(actionFieldList, product);
    });

    $(document).on('click' ,'.gtm-eec-promotion-click', function(e){
        var promotion = {
            id: $(this).data('gtm-eec-promotion-id'), // (String) Unique identifier for the promotion. Example: 'summer_campaign'
            name: $(this).data('gtm-eec-promotion-name'), // (String) The name of the promotion. Example: 'Summer Campaign 2019'
            creative: $(this).data('gtm-eec-promotion-creative'), // (String) A name for the creative where the promotion was clicked. Example: 'front_page_banner_1'
            position: $(this).data('gtm-eec-promotion-position') // (String) Some way to distinguish the position of the promotion in the creative (e.g. second slide of a carousel). Example: 'slot_2'
        };
        GAEE.promotionClick(promotion);
    });

});