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
    'public/js/landing5_alljs.min.js'
);

mix.styles(
    [
            'public/acm/extra/landing5/css/bootstrap4.min.css',
            'public/acm/extra/landing5/css/animate.css',
            'public/acm/extra/landing5/css/style.css',
            'public/acm/extra/landing5/css/fonts.css'
    ],
    'public/css/landing5_allcss.min.css'
);