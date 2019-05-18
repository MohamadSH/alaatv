var owl = jQuery('.a--owl-carousel-type-1');
owl.each(function () {
    $(this).owlCarousel({
        stagePadding: 0,
        loop: false,
        rtl:true,
        nav: true,
        dots: false,
        margin:10,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1200: {
                items: 3
            },
            1600: {
                items: 4
            }
        }
    });
});