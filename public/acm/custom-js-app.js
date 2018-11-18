jQuery(document).ready( function() {
    var owl = jQuery('.owl-carousel');
    owl.children().each(function(e) {
        $(this).attr("data-position", e)
    });
    owl.owlCarousel({
        stagePadding: 40,
        loop: true,
        rtl:true,
        nav:true,
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
            1000:{
                items:3
            },
            1600: {
                items:4
            }
        }
    });
    $(document).on("click", ".carousel", function() {
        owl.trigger("to.owl.carousel", $(this).data("position"))
    });
    console.log(owl.data);
});