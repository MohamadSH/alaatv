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
        console.log('mousedown');
    });
    sliders[i].addEventListener('mouseleave', () => {
        slidersRepository[i].isDown = false;
        sliders[i].classList.remove('active');
        console.log('mouseleave');
    });
    sliders[i].addEventListener('mouseup', () => {
        slidersRepository[i].isDown = false;
        sliders[i].classList.remove('active');
        console.log('mouseup');
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


// slider.addEventListener('mousedown', (e) => {
//     isDown = true;
//     slider.classList.add('active');
//     startX = e.pageX - slider.offsetLeft;
//     scrollLeft = slider.scrollLeft;
//     console.log('mousedown');
// });
// slider.addEventListener('mouseleave', () => {
//     isDown = false;
//     slider.classList.remove('active');
//     console.log('mouseleave');
// });
// slider.addEventListener('mouseup', () => {
//     isDown = false;
//     slider.classList.remove('active');
//     console.log('mouseup');
// });
// slider.addEventListener('mousemove', (e) => {
//     if(!isDown) return;
//     e.preventDefault();
//     const x = e.pageX - slider.offsetLeft;
//     const walk = (x - startX) * 3; //scroll-fast
//     slider.scrollLeft = scrollLeft - walk;
//     console.log(walk);
//     console.log('mousemove');
// });
