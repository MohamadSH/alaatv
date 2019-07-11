var LazyLoad = function () {

    function image_getImages() {
        return document.querySelectorAll('.lazy-image');
    }

    function image_initIntersectionObserver() {
        return new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.intersectionRatio > 0) {
                    $(entry.target).attr('src', $(entry.target).data('src'));
                    $(entry.target).attr('a-lazyload', 1);
                }
            });
        });
    }

    function image_disconnectObserver(observer) {
        observer.disconnect();
    }

    function image_observerEachImage(images, observer) {
        images.forEach(image => {
            observer.observe(image);
        });
    }

    function carousel_loadHeightOfImageAndLoading() {
        $('#carouselMainSlideShow img').each(function () {
            let dataWidth = $(this).data('width');
            let dataHeight = $(this).data('height');
            if (typeof dataWidth !== 'undefined' && typeof dataHeight !== 'undefined') {
                // let windowWidth = $( window ).width();
                let carouselMainSlideShowWidth = $('#carouselMainSlideShow').width();
                let minHeight = (carouselMainSlideShowWidth * dataHeight) / dataWidth;
                $(this).parents('.carousel-item').css({'min-height':minHeight+'px'});
            }
        });
    }

    function carousel_loadImageSrc() {
        $("#carouselMainSlideShow").on('slid.bs.carousel', function (e) {
            $(e.relatedTarget).find('img.imageSlideOfSlideshow').attr('src', $(e.relatedTarget).find('img.imageSlideOfSlideshow').data('src'));
        });
    }

    function loadImage_newVersion() {

        let images = image_getImages();

        observer = image_initIntersectionObserver();

        image_disconnectObserver(observer);

        image_observerEachImage(images, observer);
    }

    function loadImage_oldVersion() {

        let lazyImages = $('.lazy-image');
        let inAdvance = 0;
        lazyImages.each(function () {
            if (parseInt($(this).attr('a-lazyload')) !== 1 && $(this).offset().top < window.innerHeight + window.pageYOffset + inAdvance) {
                $(this).attr('src', $(this).data('src'));
                $(this).attr('a-lazyload', 1);
            }
        });
    }

    function throttle(minimumInterval, callback) {
        var timeout = null;
        return function () {
            var that = this, args = arguments;
            if(timeout === null) {
                timeout = setTimeout(function () {
                    timeout = null;
                }, minimumInterval);
                callback.apply(that, args);
            }
        };
    }

    return {

        image: function () {
            loadImage_newVersion();
            window.addEventListener('scroll', throttle(50, loadImage_oldVersion));
            window.addEventListener('resize', throttle(50, loadImage_oldVersion));
        },

        carousel: function () {
            // Bootstrap 4 carousel lazy load
            carousel_loadHeightOfImageAndLoading();
            carousel_loadImageSrc();
            if ($('#carouselMainSlideShow').length === 1) {
                $('#m_aside_left_hide_toggle').on('click', function() {
                    carousel_loadHeightOfImageAndLoading();
                });
                $(window).on('resize', function() {
                    carousel_loadHeightOfImageAndLoading();
                });
            }
        },


    };
}();