$(document).ready(function () {
    $('.dasboardLessons').OwlCarouselType2({
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
                    items: 4
                }
            }
        },
        grid: {
            columnClass: 'col-12 col-sm-6 col-md-3 gridItem'
        },
        defaultView: 'OwlCarousel', // OwlCarousel or grid
        childCountHideOwlCarousel: 4
    });

    for (let section in sections) {
        $('.'+sections[section]+'.dasboardLessons .a--owl-carousel-head').sticky({
            container: '.'+sections[section]+'.dasboardLessons > .col > .m-portlet',
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });
    }
});
