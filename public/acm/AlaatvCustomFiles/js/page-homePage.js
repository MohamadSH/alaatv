function loadCarousels() {

    LazyLoad.loadElementByQuerySelector('.dasboardLessons', function (element) {

        $(element).OwlCarouselType2({
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
                lazyLoad:false,
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
                        items: 6
                    }
                },
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                },
                onTranslatedEvent: function(event) {
                    imageObserver.observe();
                }
            },
            grid: {
                columnClass: 'col-12 col-sm-6 col-md-2 gridItem',
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                }
            },
            defaultView: 'grid', // OwlCarousel or grid
            childCountHideOwlCarousel: 4
        });

    });
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

// $(document).ready(function () {
    loadCarousels();
    loadStickeHeader();
// });
