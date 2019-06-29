//for ios lower than 12
function lazyLoadBlocks_oldVersion() {
    let blocks = $('.OwlCarouselType2-shopPage');
    let inAdvance = 0;
    blocks.each(function () {
        if (parseInt($(this).attr('a-lazyload')) !== 1 && $(this).offset().top < window.innerHeight + window.pageYOffset + inAdvance) {

            $(this).OwlCarouselType2({
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

            $(this).attr('a-lazyload', 1);
        }
    });
}

function loadCarousels() {
    const owlCarousel = document.querySelectorAll('.OwlCarouselType2-shopPage');

    observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.intersectionRatio > 0 && parseInt($(entry.target).attr('data-isinit')) !== 1) {
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

    lazyLoadBlocks_oldVersion();
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