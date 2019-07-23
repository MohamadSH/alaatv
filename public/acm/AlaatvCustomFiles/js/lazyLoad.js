var LazyLoad = function () {

    let minInterval = 200;

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
                $(this).parents('.carousel-item').css({'min-height':minHeight+'px', 'max-height':minHeight+'px'});
                $(this).parents('.carousel-inner').css({'min-height':minHeight+'px', 'max-height':minHeight+'px'});
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
        loadElementByClassName('lazy-image', function (element, percentage) {
            $(element).attr('src', $(element).attr('data-src'));
        }, $('#m_header').height());
    }

    function loadElementByClassName(className, callback, topPadding) {

        let elements = document.getElementsByClassName(className),
            elementsLength = elements.length;
        for (let i = 0; i < elementsLength; i++) {

            let element = elements[i];

            let percent = calculateSeenPercentage(element, topPadding);
            runCallbackIfCan(element, percent, callback);

            loadObject(element, function (element, percentage) {
                runCallbackIfCan(element, percentage, callback);
            }, topPadding);
        }
    }

    function runCallbackIfCan(element, percentage, callback) {
        if (canChangeLazyLoad(element, percentage)) {
            changeLazyLoadStatus(element);
            callback(element, percentage);
        }
    }

    function canChangeLazyLoad(element, percentage) {
        let lazyLoadStatus = parseInt($(element).attr('a-lazyload'));
        if (percentage > 0 && lazyLoadStatus !== 1) {
            return true;
        }
        return false;
    }
    function changeLazyLoadStatus(element) {
        $(element).attr('a-lazyload', 1);
    }

    function loadObject(element, callback, topPadding) {
        let callbackThrottle = function() {
            let percentage = calculateSeenPercentage(element, topPadding);
            callback(element, percentage);
        };
        document.addEventListener('touchmove', throttle(minInterval, callbackThrottle), false);
        window.addEventListener('scroll', throttle(minInterval, callbackThrottle));
        window.addEventListener('resize', throttle(minInterval, callbackThrottle));

        let oldBodyHeight = document.body.clientHeight;
        let bodyResizeEvent = function () {
            let newBodyHeight = document.body.clientHeight;
            if (newBodyHeight !== oldBodyHeight) {
                oldBodyHeight = newBodyHeight;
                callbackThrottle();
            }
        };
        throttle(minInterval, bodyResizeEvent);

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

    function calculateSeenPercentage(element, topPadding) {
        // $('#m_header').height()
        // loadObject(lazyObject, callback);
        let objectHeight = element.offsetHeight,
            offsetTop = $(element).offset().top,
            offsetBottom = offsetTop + objectHeight,
            tp = window.pageYOffset + topPadding,
            bp = window.pageYOffset + window.innerHeight,
            calc1 = (bp-offsetTop)*100/objectHeight,
            calc2 = (offsetBottom-tp)*100/objectHeight,
            percentage = 0;
        if (calc1 >= 0 && calc2 >= 0) {
            if (calc1 > 100 && calc2 > 100) {
                percentage = 100;
            } else {
                percentage = Math.min(calc1, calc2);
            }
        } else {
            percentage = 0;
        }
        return percentage;
    }

    return {

        loadElementByClassName: function(className, callback, topPadding) {
            loadElementByClassName(className, callback, topPadding);
        },

        image: function () {
            loadImage_newVersion();
            loadImage_oldVersion();
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