//for ios lower than 12
function lazyLoadBlocks() {
    let blocks = $('.dasboardLessons');
    let inAdvance = 0;
    blocks.each(function () {
        if (parseInt($(this).attr('a-lazyload')) !== 1 && $(this).offset().top < window.innerHeight + window.pageYOffset + inAdvance) {

            $(this).OwlCarouselType2({
                OwlCarousel: {

                    // autoplay:true,
                    // autoplayTimeout:1000,
                    // autoplayHoverPause:true,


                    // animateOut: 'slideOutDown',
                    // animateIn: 'flipInX',

                    // transitionStyle : 'backSlide',


                    // loop: true,
                    // autoplay: true,
                    // slideTransition: 'linear',
                    // autoplayTimeout: 0,
                    // autoplaySpeed: 4000,
                    // autoplayHoverPause: true,


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
                            items: 4
                        }
                    },
                    btnSwfitchEvent: function() {
                        LazyLoad.image();
                    }
                },
                grid: {
                    columnClass: 'col-12 col-sm-6 col-md-3 gridItem',
                    btnSwfitchEvent: function() {
                        LazyLoad.image();
                    }
                },
                defaultView: 'OwlCarousel', // OwlCarousel or grid
                childCountHideOwlCarousel: 4
            });

            $(this).attr('a-lazyload', 1);
        }
    });
}

function loadCarousels() {

    window.addEventListener('scroll', throttle(50, lazyLoadBlocks));
    window.addEventListener('resize', throttle(50, lazyLoadBlocks));

    // const dasboardLessons = document.querySelectorAll('.dasboardLessons');
    //
    // observer = new IntersectionObserver((entries) => {
    //     entries.forEach(entry => {
    //         if (entry.intersectionRatio > 0 &&parseInt($(entry.target).attr('a-lazyload')) !== 1) {
    //
    //             console.log('$(entry.target).attr(a-lazyload): ', $(entry.target).attr('a-lazyload'));
    //
    //             $(entry.target).OwlCarouselType2({
    //                 OwlCarousel: {
    //                     center: false,
    //                     loop: false,
    //                     responsive: {
    //                         0: {
    //                             items: 1
    //                         },
    //                         400: {
    //                             items: 2
    //                         },
    //                         600: {
    //                             items: 3
    //                         },
    //                         800: {
    //                             items: 4
    //                         },
    //                         1000: {
    //                             items: 4
    //                         }
    //                     },
    //                     btnSwfitchEvent: function() {
    //                         LazyLoad.image();
    //                     }
    //                 },
    //                 grid: {
    //                     columnClass: 'col-12 col-sm-6 col-md-3 gridItem',
    //                     btnSwfitchEvent: function() {
    //                         LazyLoad.image();
    //                     }
    //                 },
    //                 defaultView: 'OwlCarousel', // OwlCarousel or grid
    //                 childCountHideOwlCarousel: 4
    //             });
    //
    //             $(entry.target).attr('a-lazyload', 1);
    //             console.log('$(entry.target): ', $(entry.target));
    //         } else {
    //
    //         }
    //     });
    // });
    //
    // dasboardLessons.forEach(block => {
    //     observer.observe(block);
    // });
}
function loadStickeHeader() {
    for (let section in sections) {
        $('.'+sections[section]+'.dasboardLessons .m-portlet__head').sticky({
            container: '.'+sections[section]+'.dasboardLessons > .col > .m-portlet',
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });
    }
}
$(document).ready(function () {
    loadCarousels();
    loadStickeHeader()
});
