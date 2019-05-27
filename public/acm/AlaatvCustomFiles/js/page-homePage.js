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

$('.alaaAlert').fadeOut(0);
$('.hightschoolAlert').fadeOut(0);
$(document).on('click', '.certificatesLogo', function(){
    let logoName = $(this).data('name');
    console.log(logoName);
    if (logoName === 'alaa') {
        $('.hightschoolAlert').fadeOut(0);
        $('.alaaAlert').slideDown();
    } else if (logoName === 'sharif-school') {
        $('.alaaAlert').fadeOut(0);
        $('.hightschoolAlert').slideDown();
    } else {
        $('.alaaAlert').fadeOut(0);
        $('.hightschoolAlert').fadeOut(0);
    }
});