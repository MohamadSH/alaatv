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
    window.dataLayer = window.dataLayer || [];
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


    const images = document.querySelectorAll('.lazy-image');

    observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.intersectionRatio > 0) {
                // console.log('in the view', entry.target);
                $(entry.target).attr('src', $(this).data('src'));
                // entry.target.classList.add('fancy');
            } else {
                // entry.target.classList.remove('fancy');
            }
        });
    });

    images.forEach(image => {
        observer.observe(image);
    });




    //
    //
    // let lazyImages = $('.lazy-image');
    // let inAdvance = 300;
    // function lazyLoad() {
    //     lazyImages.each(function () {
    //         if ($(this).offset().top < window.innerHeight + window.pageYOffset + inAdvance) {
    //             $(this).attr('src', $(this).data('src'));
    //         }
    //     });
    // }
    // window.addEventListener('scroll', throttle(50, lazyLoad));
    // window.addEventListener('resize', throttle(50, lazyLoad));
});