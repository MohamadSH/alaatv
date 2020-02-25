var initPage = function() {

    function lazyLoad() {
        // Bootstrap 4 carousel lazy load
        LazyLoad.carousel([window.imageObserver, window.gtmEecAdvertisementObserver]);
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
                        gtmEecProductObserver.observe();
                    }
                },
                grid: {
                    columnClass: 'col-12 col-sm-6 col-md-2 gridItem',
                    btnSwfitchEvent: function() {
                        imageObserver.observe();
                        gtmEecProductObserver.observe();
                    }
                },
                defaultView: 'OwlCarousel', // OwlCarousel or grid
                childCountHideOwlCarousel: 4
            });
        });
    }

    function loadStickeHeader(carousels) {
        for (var carousel in carousels) {
            if (carousels[carousel].trim().length > 0) {
                $('.' + carousels[carousel] + ' .OwlCarouselType2-shopPage .m-portlet__head').sticky({
                    container: '.' + carousels[carousel] + ' .OwlCarouselType2-shopPage > .col > .m-portlet',
                    topSpacing: $('#m_header').height(),
                    zIndex: 98
                });
            }
        }
    }

    function addEvents() {
        $(document).on('click', '#m_aside_left_hide_toggle', function () {
            window.LazyLoad.bootstrap4CarouselLoadHeight();
        });
    }

    function init(carousels) {
        lazyLoad();
        loadStickeHeader(carousels);
        addEvents();
    }

    return {
        init: init
    };
}();


$(document).ready(function () {
    initPage.init(carousels);
});


