const sliders = document.getElementsByClassName('ScrollCarousel');
let slidersLength = sliders.length,
    slidersRepository = [];

for (let i = 0; i < slidersLength; i++) {
    slidersRepository[i] = {
        isDown: false,
        startX: null,
        scrollLeft: null
    };
    sliders[i].addEventListener('mousedown', (e) => {
        slidersRepository[i].isDown = true;
        sliders[i].classList.add('active');
        slidersRepository[i].startX = e.pageX - sliders[i].offsetLeft;
        slidersRepository[i].scrollLeft = sliders[i].scrollLeft;
        // console.log('mousedown');
    });
    sliders[i].addEventListener('mouseleave', () => {
        slidersRepository[i].isDown = false;
        sliders[i].classList.remove('active');
        // console.log('mouseleave');
    });
    sliders[i].addEventListener('mouseup', () => {
        slidersRepository[i].isDown = false;
        sliders[i].classList.remove('active');
        // console.log('mouseup');
    });
    sliders[i].addEventListener('mousemove', (e) => {
        if(!slidersRepository[i].isDown) return;
        e.preventDefault();
        const x = e.pageX - sliders[i].offsetLeft;
        const walk = (x - slidersRepository[i].startX) * 3; //scroll-fast
        sliders[i].scrollLeft = slidersRepository[i].scrollLeft - walk;
        // console.log(walk);
    });
}