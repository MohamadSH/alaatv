var LazyLoad = function () {

    function image_getImages() {
        return document.querySelectorAll('.lazy-image');
    }

    function image_initIntersectionObserver() {
        return new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.intersectionRatio > 0) {
                    $(entry.target).attr('src', $(entry.target).data('src'));
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
                let windowWidth = $( window ).width();
                let minHeight = (windowWidth * dataHeight) / dataWidth;
                $(this).parents('.carousel-item').css({'min-height':minHeight+'px'});
            }
        });
    }

    function carousel_loadImageSrc() {
        $("#carouselMainSlideShow").on('slid.bs.carousel', function (e) {
            $(e.relatedTarget).find('img.imageSlideOfSlideshow').attr('src', $(e.relatedTarget).find('img.imageSlideOfSlideshow').data('src'));
        });
    }

    return {

        image: function () {
            let images = image_getImages();

            observer = image_initIntersectionObserver();

            image_disconnectObserver(observer);

            image_observerEachImage(images, observer);
        },

        carousel: function () {
            // Bootstrap 4 carousel lazy load
            carousel_loadHeightOfImageAndLoading();
            carousel_loadImageSrc();
        },


    };
}();