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
            addScrollEvent(sliders[i]);
        }
        addNextAndPreviousBtnEvent();
    }

    function addNextAndPreviousBtnEvent() {
        $(document).on('click', '.ScrollCarousel .ScrollCarousel-previous', function () {
            swipe($(this).parents('.ScrollCarousel'), 'right');
        });
        $(document).on('click', '.ScrollCarousel .ScrollCarousel-next', function () {
            swipe($(this).parents('.ScrollCarousel'), 'left');
        });
    }

    function addScrollEvent(slider) {
        slider.onscroll = function(){
            checkSwipIcons($(this).parents('.ScrollCarousel'));
        };
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

    function appendSwipeIcons($scrollCarousel) {
        appendSwipeLeftIcon($scrollCarousel);
        appendSwipeRightIcon($scrollCarousel);
        checkSwipIcons($scrollCarousel);
    }

    function checkSwipIcons($scrollCarousel) {
        $scrollCarousel.each(function () {
            var scrollCarousel1Items = getScrollCarouselItems($(this)),
                scrollCarousel1ItemsLength = scrollCarousel1Items.length,
                firstItem = scrollCarousel1Items[0],
                lastItem = scrollCarousel1Items[scrollCarousel1ItemsLength-1],
                firstItemData = getData(firstItem),
                lastItemItemData = getData(lastItem);

            if (checkFirstItemIsFullyDisplayed(firstItemData)) {
                $(this).find('.ScrollCarousel-previous').fadeOut();
            } else {
                $(this).find('.ScrollCarousel-previous').fadeIn();
            }

            if (checkLastItemIsFullyDisplayed(lastItemItemData)) {
                $(this).find('.ScrollCarousel-next').fadeOut();
            } else {
                $(this).find('.ScrollCarousel-next').fadeIn();
            }

        });
    }

    function checkFirstItemIsFullyDisplayed(firstItemData) {
        if (firstItemData === false || firstItemData.pltrp===firstItemData.thisWidthWithMargin) {
            return true;
        } else {
            return false;
        }
    }

    function checkLastItemIsFullyDisplayed(lastItemItemData) {
        var lastItemLeftPosition = lastItemItemData.thisPositionLeft + lastItemItemData.thisMarginLeft;
        if (lastItemItemData !== false && lastItemLeftPosition < 0 && (Math.abs(lastItemItemData.thisPositionLeft)-lastItemItemData.thisMarginLeft) > 1) {
            return false;
        } else if(lastItemItemData === false || lastItemLeftPosition > 0 || (Math.abs(lastItemItemData.thisPositionLeft)-lastItemItemData.thisMarginLeft) <= 1) {
            return true;
        }
    }

    function getScrollCarouselItems($scrollCarousel) {
        return $scrollCarousel.find('.item').toArray();
    }

    function swipe($scrollCarousel, direction) {
        setScrollDirection($scrollCarousel, direction);
        var scrollCarousel1Items = getScrollCarouselItems($scrollCarousel),
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
        if (typeof item === 'undefined') {
            return false;
        }
        var $this = $(item),
            $parent = $this.parent(),
            thisWidth = parseInt($this.width()),
            thisMarginLeft = parseFloat($this.css('marginLeft')),
            thisPositionLeft = $this.position().left,
            parentWidth = $parent.width(),
            pltrp = Math.round((parentWidth - thisPositionLeft) * 1000) / 1000; // thisPositionLeftTowardsTheRightOfParent -> pltrp

        return {
            this: $this,
            thisWidth: thisWidth,
            thisPositionLeft: thisPositionLeft,
            thisMarginLeft: thisMarginLeft,
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
        $scrollCarousel.each(function () {
            $(this).find('.ScrollCarousel-Items').animate({scrollLeft: newScrollPosition}, 200);
        });
    }

    function animateScroll($scrollCarousel) {
        var counter = 0,
            directions = [];

        $scrollCarousel.each(function () {
            var scrollCarousel1Items = getScrollCarouselItems($(this)),
                scrollCarousel1ItemsLength = scrollCarousel1Items.length,
                firstItem = scrollCarousel1Items[0],
                lastItem = scrollCarousel1Items[scrollCarousel1ItemsLength-1];

            directions[counter] = 'left';


            var $that = $(this),
                newScrollPosition = 0,
                id = setInterval(function () {
                    var firstItemData = getData(firstItem),
                        lastItemItemData = getData(lastItem),
                        direction = getScrollDirection($that); //directions[counter]

                    if (direction === 'right' && checkFirstItemIsFullyDisplayed(firstItemData)) {
                        setScrollDirection($that, 'left');
                        newScrollPosition -= 1;
                    } else if (direction === 'right' ) {
                        newScrollPosition += 1;
                    }

                    if (direction === 'left' && checkLastItemIsFullyDisplayed(lastItemItemData)) {
                        setScrollDirection($that, 'right');
                        newScrollPosition += 1;
                    } else if (direction === 'left' ) {
                        newScrollPosition -= 1;
                    }

                    $that.find('.ScrollCarousel-Items').animate({scrollLeft: newScrollPosition}, 0);

                }, 1);

            counter++;
        });
    }

    function setScrollDirection($scrollCarousel, direction) {
        $scrollCarousel.attr('direction', direction);
    }

    function getScrollDirection($scrollCarousel) {
        return (typeof $scrollCarousel.attr('direction') !== 'undefined') ? $scrollCarousel.attr('direction') : 'left';
    }

    return {
        init: function() {
            sliders = document.getElementsByClassName('ScrollCarousel-Items');
            addEvents(sliders);
        },
        addSwipeIcons: function ($scrollCarousel) {
            appendSwipeIcons($scrollCarousel);
        },
        checkSwipIcons: function ($scrollCarousel) {
            checkSwipIcons($scrollCarousel)
        },
        animateScroll: function ($scrollCarousel) {
            animateScroll($scrollCarousel)
        }

    };
}();
ScrollCarousel.init();
// $('#ScrollCarousel1 .item:first-child').position().left + $('#ScrollCarousel1 .item:first-child').width()
// $('#ScrollCarousel1').scrollLeft(-$('#ScrollCarousel1 .item:first-child').width());
// $('#ScrollCarousel1').scrollLeft(-$('#ScrollCarousel1 .item:first-child').position().left + $('#ScrollCarousel1 .item:first-child').width());
