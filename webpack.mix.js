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

mix.copyDirectory('public/assets/vendors/base','public/css');
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