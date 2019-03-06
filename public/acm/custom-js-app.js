jQuery(document).ready( function() {
    var owl = jQuery('.a--owl-carousel-type-1.owl-carousel');
    owl.each(function () {
        $(this).owlCarousel({
            stagePadding: 40,
            loop: false,
            rtl:true,
            nav: true,
            dots: false,
            margin:15,
            mouseDrag: true,
            touchDrag: true,
            pullDrag: true,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                },
                600:{
                    items:2,
                },
                1200:{
                    items:3
                },
                1600:{
                    items:4
                }
            }
        });
        /*$(this).on('mousewheel', '.owl-stage', function (e) {
            if (e.deltaY>0) {
                $(this).trigger('next.owl');
            } else {
                $(this).trigger('prev.owl');
            }
            e.preventDefault();
        });*/
    });

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
});