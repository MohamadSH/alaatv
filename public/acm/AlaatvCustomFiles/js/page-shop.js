function loadCarousels() {
    LazyLoad.loadElementByQuerySelector('.OwlCarouselType2-shopPage', function (element) {
        $(element).OwlCarouselType2({
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
    for (let carousel in carousels) {
        $('.'+carousels[carousel]+' .OwlCarouselType2-shopPage .m-portlet__head').sticky({
            container: '.'+carousels[carousel]+' .OwlCarouselType2-shopPage > .col > .m-portlet',
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });
    }
}

loadCarousels();
loadStickeHeader();