let mix = require('laravel-mix');

mix.styles(
    [
        'public/acm/webFonts/css/fontiran.css',
        'public/assets/vendors/base/vendors.bundle.rtl.css',
        'public/assets/demo/demo12/base/style.bundle.rtl.css',
        'public/acm/custom-css-app.css'
        // 'public/acm/cubeportfolio/css/cubeportfolio.min.css'

    ],
    'public/css/all.css')
    .version();

mix.copyDirectory('public/assets/vendors/base', 'public/css');
// mix.copyDirectory('public/acm/webFonts/fonts','public/css/fonts');

mix.scripts(
    [
        'public/assets/vendors/base/vendors.bundle.js',
        'public/assets/demo/demo12/base/scripts.bundle.js',
        // 'public/acm/cubeportfolio/js/jquery.cubeportfolio.min.js',
        'public/acm/custom-js-app.js'
    ],
    'public/js/all.js'
).version();

mix.scripts(
    ['public/acm/login.js'],
    'public/js/login.js'
).version();

mix.scripts(
    [
        'public/acm/video-js/video.min.js',
        'public/acm/video-js/nuevo/nuevo.min.js',
        'public/acm/page-content-show.js'
    ],
    'public/js/content-show.js'
).version();


// TODO : must convert to mix.script
mix.babel(
    [
        'node_modules/lightgallery/src/js/lightgallery.js',
        'node_modules/lightgallery/modules/lg-thumbnail.min.js',
        'node_modules/lightgallery/modules/lg-autoplay.min.js',
        'node_modules/lightgallery/modules/lg-fullscreen.min.js',
        'node_modules/lightgallery/modules/lg-pager.min.js',
        'node_modules/lightgallery/modules/lg-hash.min.js',
        'node_modules/lightgallery/modules/lg-share.min.js',
        'node_modules/lightgallery/modules/lg-video.min.js',
        'node_modules/lightgallery/modules/lg-zoom.min.js',
        'node_modules/jquery-sticky/jquery.sticky.js',
        'public/assets/demo/demo12/custom/components/base/bootstrap-notify.js',
        'public/acm/video-js/video.js',
        'public/acm/video-js/videojs-ie8.min.js',
        'public/acm/video-js/nuevo/nuevo.min.js',
            'public/acm/product-show-v13.js',
        'public/acm/page-product-show.js',
        'public/acm/page-product-saveCookie.js'
    ],
    'public/js/product-show.js'
).version();

//scripts
mix.scripts(
    [
        'node_modules/jquery-sticky/jquery.sticky.js'
    ],
    'public/js/checkout-review.js'
).version();

mix.scripts(
    [
        'public/assets/demo/demo12/custom/crud/forms/widgets/bootstrap-switch.js',
        // 'public/assets/demo/demo12/custom/crud/forms/widgets/nouislider.js',
    ],
    'public/js/checkout-payment.js'
).version();
mix.scripts(
    [
        'node_modules/persian-date/dist/persian-date.js',
        'node_modules/persian-datepicker/dist/js/persian-datepicker.js'
    ],
    'public/js/user-profile.js'
).version();


mix.styles(
    [
        'node_modules/persian-datepicker/dist/css/persian-datepicker.css',
        'node_modules/bootstrap-fileinput/css/fileinput.css',
        'node_modules/bootstrap-fileinput/css/fileinput-rtl.css',
    ],
    'public/css/user-profile.css'
).version();

mix.styles(
    [
        'node_modules/lightgallery/src/css/lightgallery.css',
        'public/acm/video-js/video-js.css',
    ],
    'public/css/product-show/product-show.css'
).version();

mix.scripts(
    [
            'public/acm/extra/landing5/js/jquery.min.js',
            'public/acm/extra/landing5/js/jquery-migrate-3.0.1.min.js',
            'public/acm/extra/landing5/js/jquery.easing.1.3.js',
            'public/acm/extra/landing5/js/jquery.waypoints.min.js',
            'public/acm/extra/landing5/js/particles.js-master/dist/particles.js',
            'public/acm/extra/landing5/js/modernizr-2.6.2.min.js',
            'public/acm/extra/landing5/js/ninjaScroll.js',
            'public/acm/extra/landing5/js/jquery.mousewheel.js',
            'public/acm/extra/landing5/js/main.js'
    ],
    'public/js/landing5-alljs.min.js'
);

mix.styles(
    [
            'public/acm/extra/landing5/css/bootstrap4.min.css',
            'public/acm/extra/landing5/css/animate.css',
            'public/acm/extra/landing5/css/style.css',
            'public/acm/extra/landing5/css/fonts.css'
    ],
    'public/css/landing5-allcss.min.css'
);