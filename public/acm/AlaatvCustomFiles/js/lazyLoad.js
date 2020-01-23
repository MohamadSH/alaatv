var LazyLoad = function () {

    function carousel_loadHeightOfImageAndLoading() {
        $('#carouselMainSlideShow img').each(function () {
            var dataWidth = $(this).data('width');
            var dataHeight = $(this).data('height');
            if (typeof dataWidth !== 'undefined' && typeof dataHeight !== 'undefined') {
                var carouselMainSlideShowWidth = $('#carouselMainSlideShow').width();
                var minHeight = (carouselMainSlideShowWidth * dataHeight) / dataWidth;
                $(this).parents('.carousel-item').css({'min-height':minHeight+'px', 'max-height':minHeight+'px'});
                $(this).parents('.carousel-inner').css({'min-height':minHeight+'px', 'max-height':minHeight+'px'});
            }
        });
    }

    function carousel_slidEvent(lazyObservers) {
        $("#carouselMainSlideShow").on('slid.bs.carousel', function (e) {
            var lazyObserversLength = lazyObservers.length;
            for(var i = 0; i < lazyObserversLength; i++) {
                lazyObservers[i].observe();
            }
        });
    }

    function loadImage(element) {
        var w = Math.floor($(element).width()),
            h = Math.floor($(element).height()),
            attrW = $(element).attr('width'),
            attrH = $(element).attr('height'),
            imageDimension;

        if(typeof attrW !== 'undefined' && typeof attrH !== 'undefined' && !isNaN(attrW) && !isNaN(attrH)) {
            h = Math.floor((attrH*w)/attrW);
        }

        imageDimension = '?w='+w+'&h='+h;

        if (typeof $(element).attr('data-src') !== 'undefined' && $(element).attr('data-src').length > 0) {
            $(element).attr('src', $(element).attr('data-src').replace(/\?.*/g, '') + imageDimension);
        }

        changeLazyLoadStatus(element);
    }

    function canChangeLazyLoad(element) {
        var lazyLoadStatus = parseInt($(element).attr('a-lazyload'));
        return lazyLoadStatus !== 1;
    }

    function changeLazyLoadStatus(element) {
        $(element).attr('a-lazyload', 1);
        $(element).addClass('lazy-done');
    }

    function loadElementByQuerySelector(querySelector, callback) {
        var elementObserver = lozad(querySelector, {
            rootMargin: '0px',
            threshold: 0.1,
            load: function(element) {
                if (canChangeLazyLoad(element)) {
                    callback(element);
                    changeLazyLoadStatus(element);
                }
            }
        });
        elementObserver.observe();
        return elementObserver;
    }

    return {

        loadElementByQuerySelector: function(querySelector, callback) {
            return loadElementByQuerySelector(querySelector, callback);
        },

        image: function () {
            return loadElementByQuerySelector('.lazy-image:not(.lazy-done)', function(element) {
                if (canChangeLazyLoad(element)) {
                    loadImage(element);
                }
            });
        },

        gtmEecProduct: function () {
            return loadElementByQuerySelector('.a--gtm-eec-product:not(.lazy-done)', function(element) {
                if (canChangeLazyLoad(element)) {
                    GAEE.impressionViewSingleItem($(element));
                }
            });
        },

        gtmEecAdvertisement: function () {
            return loadElementByQuerySelector('.a--gtm-eec-advertisement:not(.lazy-done)', function(element) {
                if (canChangeLazyLoad(element)) {
                    GAEE.promotionViewSingleItem($(element));
                }
            });
        },

        carousel: function (lazyObservers) {
            /* Bootstrap 4 carousel lazy load */
            if ($('#carouselMainSlideShow').length === 1) {
                carousel_loadHeightOfImageAndLoading();
                carousel_slidEvent(lazyObservers);
                // $('#m_aside_left_hide_toggle').on('click', function() {
                //     carousel_loadHeightOfImageAndLoading();
                // });
                // $(window).on('resize', function() {
                //     carousel_loadHeightOfImageAndLoading();
                // });
            }
        },

    };
}();
