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

    return {
        init: function() {
            sliders = document.getElementsByClassName('ScrollCarousel');
            addEvents(sliders);
        },
    };
}();
ScrollCarousel.init();