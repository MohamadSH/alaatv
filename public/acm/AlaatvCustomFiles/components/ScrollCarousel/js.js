var ScrollCarousel = function () {

    let sliders,
        slidersRepository = [];

    function addEvents(sliders) {
        let slidersLength = sliders.length;
        for (let i = 0; i < slidersLength; i++) {
            slidersRepository[i] = {
                isDown: false,
                startX: null,
                scrollLeft: null
            };
            addMouseEvents(sliders[i], slidersRepository[i]);
        }

        $(document).on('click', '.ScrollCarousel .ScrollCarousel-previous', function () {
            swipe($(this).parents('.ScrollCarousel'), 'right');
        });
        $(document).on('click', '.ScrollCarousel .ScrollCarousel-next', function () {
            swipe($(this).parents('.ScrollCarousel'), 'left');
        });
    }

    function addMouseEvents(element, elementRepository) {
        addMouseEvent_mousedown(element, elementRepository);
        addMouseEvent__mouseleave(element, elementRepository);
        addMouseEvent__mouseup(element, elementRepository);
        addMouseEvent__mousemove(element, elementRepository);
    }

    function addMouseEvent_mousedown(element, elementRepository) {
        element.addEventListener('mousedown', function(e) {
            elementRepository.isDown = true;
            element.classList.add('active');
            elementRepository.startX = e.pageX - element.offsetLeft;
            elementRepository.scrollLeft = element.scrollLeft;
        });
    }

    function addMouseEvent__mouseleave(element, elementRepository) {
        element.addEventListener('mouseleave', function(e) {
            elementRepository.isDown = false;
            element.classList.remove('active');
        });
    }

    function addMouseEvent__mouseup(element, elementRepository) {
        element.addEventListener('mouseup', function(e) {
            elementRepository.isDown = false;
            element.classList.remove('active');
        });
    }

    function addMouseEvent__mousemove(element, elementRepository) {
        element.addEventListener('mousemove', function(e) {
            if(typeof elementRepository !== 'undefined' && elementRepository !== null && !elementRepository.isDown) return;
            e.preventDefault();
            const x = e.pageX - element.offsetLeft;
            const walk = (x - elementRepository.startX) * 3; //scroll-fast
            element.scrollLeft = elementRepository.scrollLeft - walk;
            // console.log(walk);
        });
    }

    /* swipe icons */
    function appendSwipeLeftIcon($ScrollCarousel) {
        $ScrollCarousel.append('<div class="ScrollCarousel-next"><i class="fa fa-chevron-left"></i></div>');
    }

    function appendSwipeRightIcon($ScrollCarousel) {
        $ScrollCarousel.append('<div class="ScrollCarousel-previous"><i class="fa fa-chevron-right"></i></div>');
    }

    function appendSwipeIcons($ScrollCarousel) {
        appendSwipeLeftIcon($ScrollCarousel);
        appendSwipeRightIcon($ScrollCarousel);
    }

    function swipe($scrollCarousel, direction) {
        var scrollCarousel1Items = $scrollCarousel.find('.item').toArray(),
            scrollCarousel1ItemsLength = scrollCarousel1Items.length;

        for (var i = 0; i < scrollCarousel1ItemsLength; i++) {

            var data = getData(scrollCarousel1Items[i]),
                scrollChange = false;

            if (direction === 'right' && canSelectItemForSwipeToRight(data)) {
                scrollChange = data.newScrollPositionToRight;
            } else if (direction === 'left' && canSelectItemForSwipeToLeft(data)) {
                scrollChange = data.newScrollPositionToLeft;
            }

            if (scrollChange !== false) {
                swipeWithAnimate($scrollCarousel, scrollChange);
                break;
            }
        }
    }

    function getData(item) {
        var $this = $(item),
            $parent = $this.parent(),
            thisWidth = parseInt($this.width()),
            thisMarginLeft = parseFloat($this.css('marginLeft')),
            thisPositionLeft = $this.position().left,
            parentWidth = $parent.width(),
            pltrp = Math.round((parentWidth - thisPositionLeft) * 1000) / 1000; // thisPositionLeftTowardsTheRightOfParent -> pltrp
        return {
            thisWidth: thisWidth,
            thisWidthWithMargin: Math.round($this.outerWidth(true) * 1000) / 1000,
            pltrp: pltrp, // thisPositionLeftTowardsTheRightOfParent -> pltrp
            newScrollPositionToRight: (pltrp - $parent.scrollLeft() - thisWidth - thisMarginLeft) * -1,
            newScrollPositionToLeft: Math.ceil(pltrp - $parent.scrollLeft()) * -1
        }
    }

    function canSelectItemForSwipeToLeft(data) {
        if (data.pltrp >= 1 && data.pltrp <= data.thisWidthWithMargin) {
            return true;
        } else {
            return false;
        }
    }

    function canSelectItemForSwipeToRight(data) {
        if (data.pltrp >= -1 && data.pltrp <= data.thisWidth) {
            return true;
        } else {
            return false;
        }
    }

    function swipeWithAnimate($scrollCarousel, newScrollPosition) {

        $scrollCarousel.find('.ScrollCarousel-Items').animate({scrollLeft: newScrollPosition}, 200);
    }

    return {
        init: function() {
            sliders = document.getElementsByClassName('ScrollCarousel-Items');
            addEvents(sliders);
        },
        addSwipeIcons: function ($ScrollCarousel) {
            appendSwipeIcons($ScrollCarousel);
        }
    };
}();
ScrollCarousel.init();
// $('#ScrollCarousel1 .item:first-child').position().left + $('#ScrollCarousel1 .item:first-child').width()
// $('#ScrollCarousel1').scrollLeft(-$('#ScrollCarousel1 .item:first-child').width());
// $('#ScrollCarousel1').scrollLeft(-$('#ScrollCarousel1 .item:first-child').position().left + $('#ScrollCarousel1 .item:first-child').width());