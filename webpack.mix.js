let mix = require('laravel-mix');

mix.styles(
    [
        'public/acm/webFonts/css/fontiran.css',
        'public/assets/vendors/base/vendors.bundle.rtl.css',
        'public/assets/demo/demo12/base/style.bundle.rtl.css'
    ],
    'public/css/all.css')
    .version();

mix.copyDirectory('public/assets/vendors/base','public/css');
// mix.copyDirectory('public/acm/webFonts/fonts','public/css/fonts');
