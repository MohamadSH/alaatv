var LazyLoad = function () {

    function carousel_loadHeightOfImageAndLoading() {
        $('#carouselMainSlideShow img').each(function () {
            let dataWidth = $(this).data('width');
            let dataHeight = $(this).data('height');
            if (typeof dataWidth !== 'undefined' && typeof dataHeight !== 'undefined') {
                let carouselMainSlideShowWidth = $('#carouselMainSlideShow').width();
                let minHeight = (carouselMainSlideShowWidth * dataHeight) / dataWidth;
                $(this).parents('.carousel-item').css({'min-height':minHeight+'px', 'max-height':minHeight+'px'});
                $(this).parents('.carousel-inner').css({'min-height':minHeight+'px', 'max-height':minHeight+'px'});
            }
        });
    }

    function carousel_slidEvent() {
        $("#carouselMainSlideShow").on('slid.bs.carousel', function (e) {
            loadImage($(e.relatedTarget).find('img.imageSlideOfSlideshow'));
        });
    }

    function loadImage(element) {
        let w = Math.floor($(element).width()),
            h = Math.floor($(element).height()),
            attrW = $(element).attr('width'),
            attrH = $(element).attr('height'),
            imageDimension = '?w='+w+'&h='+h;
        if(typeof attrW !== 'undefined' && typeof attrH !== 'undefined') {
            h = Math.floor((attrH*w)/attrW);
        }
        if ($(element).attr('data-src').length > 0) {
            $(element).attr('src', $(element).attr('data-src').replace(/\?.*/g, '')+imageDimension);
        }
        changeLazyLoadStatus(element);
    }

    function canChangeLazyLoad(element) {
        let lazyLoadStatus = parseInt($(element).attr('a-lazyload'));
        if (lazyLoadStatus !== 1) {
            return true;
        }
        return false;
    }

    function changeLazyLoadStatus(element) {
        $(element).attr('a-lazyload', 1);
        $(element).addClass('lazy-done');
    }

    return {

        loadElementByQuerySelector: function(querySelector, callback) {
            let elementObserver = lozad(querySelector, {
                rootMargin: '10px 0px', // syntax similar to that of CSS Margin
                threshold: 0.1, // ratio of element convergence
                load: function(element) {
                    if (canChangeLazyLoad(element)) {
                        callback(element);
                        changeLazyLoadStatus(element);
                    }
                }
            });
            elementObserver.observe();
            return elementObserver;
        },

        image: function () {
            let imageObserver = lozad('.lazy-image:not(.lazy-done)', {
                rootMargin: '10px 0px', // syntax similar to that of CSS Margin
                threshold: 0.1, // ratio of element convergence
                load: function(element) {
                    if (canChangeLazyLoad(element)) {
                        loadImage(element);
                    }
                }
            });
            imageObserver.observe();
            return imageObserver;
        },

        carousel: function () {
            // Bootstrap 4 carousel lazy load
            carousel_loadHeightOfImageAndLoading();
            carousel_slidEvent();
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
