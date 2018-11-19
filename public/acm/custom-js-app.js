jQuery(document).ready( function() {
    var owl = jQuery('.owl-carousel');
    owl.each(function () {
        $(this).owlCarousel({
            stagePadding: 40,
            loop: true,
            rtl:true,
            nav:false,
            margin:15,
            touchDrag  : true,
            mouseDrag  : true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1200:{
                    items:3
                },
                1600:{
                    items:4
                }
            }
        });
        $(this).on('mousewheel', '.owl-stage', function (e) {
            if (e.deltaY>0) {
                $(this).trigger('next.owl');
            } else {
                $(this).trigger('prev.owl');
            }
            e.preventDefault();
        });
    });
});