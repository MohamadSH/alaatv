function loadCarousels() {
    const owlCarousel = document.querySelectorAll('.OwlCarouselType2-shopPage');

    observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.intersectionRatio > 0 && parseInt($(entry.target).data('isinit')) !== 1) {
                $(entry.target).OwlCarouselType2({
                    OwlCarousel: {
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
                                items: 5
                            }
                        },
                        btnSwfitchEvent: function() {
                            LazyLoad.image();
                        }
                    },
                    grid: {
                        columnClass: 'col-12 col-sm-6 col-md-2 gridItem',
                        btnSwfitchEvent: function() {
                            LazyLoad.image();
                        }
                    },
                    defaultView: 'OwlCarousel', // OwlCarousel or grid
                    childCountHideOwlCarousel: 4
                });

                $(entry.target).attr('data-isinit', 1);
                console.log('$(entry.target): ', $(entry.target));
            } else {

            }
        });
    });

    owlCarousel.forEach(image => {
        observer.observe(image);
    });
}
function loadStickeHeader() {
    for (let carousel in carousels) {
        $('.'+carousels[carousel]+' .OwlCarouselType2-shopPage .m-portlet__head').sticky({
            container: '.'+carousels[carousel]+' .OwlCarouselType2-shopPage > .col > .m-portlet',
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });
    }
}
$(document).ready(function () {
    loadCarousels();
    loadStickeHeader();
});