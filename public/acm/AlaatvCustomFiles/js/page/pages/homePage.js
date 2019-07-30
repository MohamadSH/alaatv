function loadCarousels() {

    LazyLoad.loadElementByQuerySelector('.dasboardLessons', function (element) {

        // let selector = '#'+$(element).attr('id')+' .owl-carousel';
        // $(element).find('.a--owl-carousel-init-loading').fadeOut();
        // $(selector).fadeIn();
        //
        // console.log('selector: ', selector);



        // // ---------------------------------------------------------------------- = Siema
        // new Siema({
        //     selector: selector,
        //     duration: 200,
        //     easing: 'ease-out',
        //     perPage: {
        //         1: 1,
        //         576: 2,
        //         768: 3,
        //         992: 4,
        //         1200: 5,
        //     },
        //     startIndex: 0,
        //     draggable: true,
        //     multipleDrag: true,
        //     threshold: 20,
        //     loop: false,
        //     rtl: true,
        //     onInit: () => {},
        //     onChange: () => {},
        // });

        // // ---------------------------------------------------------------------- = Slick
        // $(selector).slick({
        //
        //     // normal options...
        //     slidesToShow: 5,
        //     infinite: false,
        //     dots: true,
        //     rtl: true,
        //     swipe: true,
        //
        //     // the magic
        //     responsive: [{
        //
        //         breakpoint: 1024,
        //         settings: {
        //             slidesToShow: 5,
        //         }
        //
        //     }, {
        //
        //         breakpoint: 600,
        //         settings: {
        //             slidesToShow: 1,
        //             dots: false
        //         }
        //
        //     }, {
        //
        //         breakpoint: 300,
        //         settings: "unslick" // destroys slick
        //
        //     }]
        // });



        // // ---------------------------------------------------------------------- = lightSlider
        // $(selector).lightSlider({
        //     item: 5,
        //     autoWidth: false,
        //     slideMove: 1, // slidemove will be 1 if loop is true
        //     slideMargin: 10,
        //
        //     addClass: '',
        //     mode: "slide",
        //     useCSS: true,
        //     cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        //     easing: 'linear', //'for jquery animation',////
        //
        //     speed: 400, //ms'
        //     auto: false,
        //     pauseOnHover: false,
        //     loop: false,
        //     slideEndAnimation: true,
        //     pause: 2000,
        //
        //     keyPress: false,
        //     controls: true,
        //     prevHtml: '',
        //     nextHtml: '',
        //
        //     rtl:true,
        //     adaptiveHeight:true,
        //
        //     vertical:false,
        //     verticalHeight:500,
        //     vThumbWidth:100,
        //
        //     thumbItem:10,
        //     pager: true,
        //     gallery: true,
        //     galleryMargin: 5,
        //     thumbMargin: 5,
        //     currentPagerPosition: 'middle',
        //
        //     enableTouch:true,
        //     enableDrag:true,
        //     freeMove:true,
        //     swipeThreshold: 40,
        //
        //     responsive : [
        //         {
        //             breakpoint:800,
        //             settings: {
        //                 item:3,
        //                 slideMove:1,
        //                 slideMargin:6,
        //             }
        //         },
        //         {
        //             breakpoint:480,
        //             settings: {
        //                 item:1,
        //                 slideMove:1
        //             }
        //         }
        //     ],
        //
        //     onBeforeStart: function (el) {},
        //     onSliderLoad: function (el) {},
        //     onBeforeSlide: function (el) {},
        //     onAfterSlide: function (el) {},
        //     onBeforeNextSlide: function (el) {},
        //     onBeforePrevSlide: function (el) {}
        // });


        // // ---------------------------------------------------------------------- = Glider
        // new Glider(document.querySelector(selector), {
        //
        //     // // `auto` allows automatic responsive
        //     // // width calculations
        //     // slidesToShow: 'auto',
        //     // slidesToScroll: 'auto',
        //     //
        //     // // should have been named `itemMinWidth`
        //     // // slides grow to fit the container viewport
        //     // // ignored unless `slidesToShow` is set to `auto`
        //     // itemWidth: undefined,
        //     //
        //     // if true, slides wont be resized to fit viewport
        //     // requires `itemWidth` to be set
        //     // * this may cause fractional slides
        //     exactWidth: false,
        //
        //     // speed aggravator - higher is slower
        //     duration: .5,
        //
        //     // // dot container element or selector
        //     // dots: 'CSS Selector',
        //     //
        //     // // arrow container elements or selector
        //     // arrows: {
        //     //     prev: 'CSS Selector',
        //     //     // may also pass element directly
        //     //     next: document.querySelector('CSS Selector')
        //     // },
        //     //
        //     // allow mouse dragging
        //     draggable: true,
        //     // how much to scroll with each mouse delta
        //     dragVelocity: 3.3,
        //     //
        //     // use any custom easing function
        //     // compatible with most easing plugins
        //     easing: function (x, t, b, c, d) {
        //         return c*(t/=d)*t + b;
        //     },
        //
        //     // // event control
        //     // scrollPropagate: true,
        //     // eventPropagate: true,
        //
        //     // Force centering slide after scroll event
        //     scrollLock: true,
        //     // // how long to wait after scroll event before locking
        //     // // if too low, it might interrupt normal scrolling
        //     // scrollLockDelay: 150,
        //     //
        //     // // Force centering slide after resize event
        //     // resizeLock: true,
        //     //
        //     // Glider.js breakpoints are mobile-first
        //     responsive: [
        //         {
        //             breakpoint: 900,
        //             settings: {
        //                 slidesToShow: 5,
        //                 slidesToScroll: 1
        //             }
        //         },
        //         {
        //             breakpoint: 575,
        //             settings: {
        //                 slidesToShow: 1,
        //                 slidesToScroll: 1
        //             }
        //         }
        //     ]
        // });





        $(element).OwlCarouselType2({
            OwlCarousel: {

                // autoplay:true,
                // autoplayTimeout:1000,
                // autoplayHoverPause:true,


                // animateOut: 'slideOutDown',
                // animateIn: 'flipInX',

                // transitionStyle : 'backSlide',


                // loop: true,
                // autoplay: true,
                // slideTransition: 'linear',
                // autoplayTimeout: 0,
                // autoplaySpeed: 4000,
                // autoplayHoverPause: true,


                center: false,
                loop: false,
                lazyLoad:false,
                responsive: {
                    0: {
                        items: 1
                    },
                    400: {
                        items: 2
                    },
                    600: {
                        items: 3
                    },
                    800: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                },
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                },
                onTranslatedEvent: function(event) {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            grid: {
                columnClass: 'col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 gridItem',
                btnSwfitchEvent: function() {
                    imageObserver.observe();
                    gtmEecProductObserver.observe();
                }
            },
            defaultView: 'grid', // OwlCarousel or grid
            childCountHideOwlCarousel: 4
        });

    });
}

function loadStickeHeader() {
    for (let section in sections) {
        $('.'+sections[section]+'.dasboardLessons .m-portlet__head').sticky({
            container: '.'+sections[section]+'.dasboardLessons > .col > .m-portlet',
            topSpacing: $('#m_header').height(),
            zIndex: 98
        });
    }
}

loadCarousels();
loadStickeHeader();

    // function initSiema(selector) {
    //     new Siema({
    //         selector: selector,
    //         duration: 200,
    //         easing: 'ease-out',
    //         perPage: {
    //             1: 1,
    //             576: 2,
    //             768: 3,
    //             992: 4,
    //             1200: 5,
    //         },
    //         startIndex: 0,
    //         draggable: true,
    //         multipleDrag: true,
    //         threshold: 20,
    //         loop: false,
    //         rtl: true,
    //         onInit: () => {},
    //         onChange: () => {},
    //     });
    // }


// initSiema('#sectionId-nahaee .owl-carousel1');
// initSiema('#sectionId-talaee .owl-carousel1');
// initSiema('#sectionId-sampleContentBlock .owl-carousel1');
// initSiema('#sectionId-konkoor1 .owl-carousel1');
// initSiema('#sectionId-yazdahom .owl-carousel1');
// initSiema('#sectionId-dahom .owl-carousel1');
// initSiema('#sectionId-hamayesh .owl-carousel1');


// var viewPortWidth;
// var viewPortHeight;
//
// // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
// if (typeof window.innerWidth != 'undefined') {
//     viewPortWidth = window.innerWidth,
//         viewPortHeight = window.innerHeight
// }
//
// // IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
// else if (typeof document.documentElement != 'undefined'
//     && typeof document.documentElement.clientWidth !=
//     'undefined' && document.documentElement.clientWidth != 0) {
//     viewPortWidth = document.documentElement.clientWidth,
//         viewPortHeight = document.documentElement.clientHeight
// }
//
// // older versions of IE
// else {
//     viewPortWidth = document.getElementsByTagName('body')[0].clientWidth,
//         viewPortHeight = document.getElementsByTagName('body')[0].clientHeight
// }
//
//
// $(document).ready(function () {
//     window.addEventListener('scroll', function (e) {
//         $('.dasboardLessons').each(function() {
//
//             let bounding = this.getBoundingClientRect(),
//                 detectOutOfViewport = ((bounding.top < 0 && bounding.bottom < 0) || (bounding.top > viewPortHeight && bounding.bottom > viewPortHeight));
//
//             if (detectOutOfViewport) {
//
//
//                 let loadingHeight = $(this).attr('inviewport_height') + 15;
//                 $(this).find('.m-widget_head-owlcarousel-items').addClass('d-none');
//                 $(this).find('.a--owl-carousel-init-loading').css({
//                     'max-height': loadingHeight+'px',
//                     'min-height': loadingHeight+'px'
//                 }).fadeIn(0);
//
//                 // $(this).removeClass('a----inViewport');
//                 // $(this).attr('inviewport', 0);
//             } else {
//
//                 $(this).find('.a--owl-carousel-init-loading').fadeOut(0);
//                 $(this).find('.m-widget_head-owlcarousel-items').removeClass('d-none');
//
//
//                 $(this).attr('inviewport_height', $(this).find('.m-widget_head-owlcarousel-items').height());
//
//                 // $(this).attr('inviewport', 1);
//                 // $(this).addClass('a----inViewport');
//             }
//         });
//     });
// });