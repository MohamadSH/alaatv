let mix = require('laravel-mix');

mix.styles(
    [
        'public/acm/webFonts/css/fontiran.css',
        'public/assets/vendors/base/vendors.bundle.rtl.css',
        'public/assets/demo/demo12/base/style.bundle.rtl.css',
        'public/acm/custom-css-app.css',
        // 'public/acm/cubeportfolio/css/cubeportfolio.min.css'

        'public/acm/AlaatvCustomFiles/css/owl-carousel.css',
        'public/acm/AlaatvCustomFiles/css/customStyle.css',
        'public/acm/AlaatvCustomFiles/css/fixThemeStyle.css',



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

mix.scripts(
    [
        'public/acm/AlaatvCustomFiles/js/page-contactUs.js'
    ],
    'public/js/contactUs.js'
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
        // 'public/acm/AlaatvCustomFiles/js/page-product-show.js'
    ],
    'public/js/product-show.js'
).version();

mix.scripts(
    [
        'node_modules/jquery-sticky/jquery.sticky.js',
        // 'public/acm/AlaatvCustomFiles/js/page-checkout-review.js'
    ],
    'public/js/checkout-review.js'
).version();

mix.scripts(
    [
        'public/assets/demo/demo12/custom/crud/forms/widgets/bootstrap-switch.js',
        // 'public/acm/AlaatvCustomFiles/js/page-checkout-payment.js',
        // 'public/assets/demo/demo12/custom/crud/forms/widgets/nouislider.js',
    ],
    'public/js/checkout-payment.js'
).version();

mix.scripts(
    [
        'node_modules/bootstrap-fileinput/js/fileinput.js',
        'node_modules/persian-date/dist/persian-date.js',
        'node_modules/persian-datepicker/dist/js/persian-datepicker.js',

        // 'public/acm/AlaatvCustomFiles/js/page-user-profile.js'
    ],
    'public/js/user-profile.js'
).version();


mix.styles(
    [
        'node_modules/persian-datepicker/dist/css/persian-datepicker.css',
        'node_modules/bootstrap-fileinput/css/fileinput.css',
        'node_modules/bootstrap-fileinput/css/fileinput-rtl.css',

        // 'public/acm/AlaatvCustomFiles/css/page-user-profile.css',
    ],
    'public/css/user-profile.css'
).version();

mix.styles(
    [
        'node_modules/lightgallery/src/css/lightgallery.css',
        'public/acm/video-js/video-js.css',
        'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',
        'public/acm/AlaatvCustomFiles/css/page-product-show.css',
    ],
    'public/css/product-show/product-show.css'
).version();


mix.styles(
    [
        // 'public/acm/AlaatvCustomFiles/components/step/step.css',

        'public/acm/AlaatvCustomFiles/css/page-checkout-review.css',
    ],
    'public/css/checkout-review.css'
).version();
mix.styles(
    [
        'node_modules/slick-carousel/slick/slick.css',
        'node_modules/slick-carousel/slick/slick-theme.css',
    ],
    'public/css/user-dashboard.css'
).version();

mix.styles(
    [
        // 'public/acm/AlaatvCustomFiles/components/step/step.css',
        'public/acm/AlaatvCustomFiles/css/page-checkout-payment.css',
    ],
    'public/css/checkout-payment.css'
).version();

mix.scripts(
    [

    ],
    'public/js/user-dashboard.js'
);

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