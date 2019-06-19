
let mix = require('laravel-mix');

mix.styles(
    [
        /*'public/acm/webFonts/css/fontiran.css',*/
        'public/acm/webFonts/IRANSans/css/fontiran.css',
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

mix.babel(
    [
        // 'public/assets/vendors/base/vendors.bundle.js',
        'public/assets/vendors/base/vendors.bundle.edited.js',
        // 'public/assets/demo/demo12/base/scripts.bundle.js',
        'public/assets/demo/demo12/base/scripts.bundle.edited.js',

        // 'public/acm/cubeportfolio/js/jquery.cubeportfolio.min.js',

        'public/acm/AlaatvCustomFiles/js/GoogleAnalyticsEnhancedEcommerce.js',
        'public/acm/custom-js-app.js',
        'public/acm/AlaatvCustomFiles/js/mLayout.js'
    ],
    'public/js/all.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/js/loadGtmEecForPages.js',
    ],
    'public/js/loadGtmEecForPages.js'
).version();

mix.scripts(
    ['public/acm/login.js'],
    'public/js/login.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',

        'public/acm/videojs/video.min.js',
        'public/acm/videojs/plugins/pip/videojs.pip.min.js',
        'public/acm/videojs/nuevo.min.js',
        'public/acm/videojs/plugins/videojs.p2p.min.js',
        'public/acm/videojs/plugins/videojs.hotkeys.min.js',
        'public/acm/videojs/plugins/seek-to-point.js',
        'public/acm/videojs/lang/fa.js',

        'public/acm/AlaatvCustomFiles/components/summarizeText/js.js',

        'public/acm/AlaatvCustomFiles/js/UserCart.js',

        'public/acm/AlaatvCustomFiles/js/page-content-show.js'
    ],
    'public/js/content-show.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/components/MultiLevelSearch/js.js',
        'public/acm/AlaatvCustomFiles/js/page-content-search-filter-data.js',
        'public/acm/AlaatvCustomFiles/js/page-content-search.js'
    ],
    'public/js/content-search.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/js/page-error.js'
    ],
    'public/js/page-error.js'
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
        'public/assets/demo/demo12/custom/components/base/bootstrap-notify.js',
        'public/acm/videojs/video.min.js',
        'public/acm/videojs/plugins/pip/videojs.pip.min.js',
        'public/acm/videojs/nuevo.min.js',
        'public/acm/videojs/plugins/videojs.p2p.min.js',
        'public/acm/videojs/plugins/videojs.hotkeys.min.js',
        'public/acm/videojs/plugins/seek-to-point.js',
        'public/acm/videojs/lang/fa.js',
        'public/acm/AlaatvCustomFiles/js/UserCart.js',
        'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',

        'public/acm/AlaatvCustomFiles/js/page-product-show.js',
    ],
    'public/js/product-show.js'
).version();

mix.babel(
    [
        'public/acm/videojs/video.min.js',
        'public/acm/videojs/plugins/pip/videojs.pip.min.js',
        'public/acm/videojs/nuevo.min.js',
        'public/acm/videojs/plugins/videojs.p2p.min.js',
        'public/acm/videojs/plugins/videojs.hotkeys.min.js',
        'public/acm/videojs/plugins/seek-to-point.js',
        'public/acm/videojs/lang/fa.js',
        'public/acm/AlaatvCustomFiles/js/product-content-embed.js',
    ],
    'public/js/product-content-embed.js'
).version();

mix.babel(
    [
        'node_modules/jquery-sticky/jquery.sticky.js',
        'public/acm/AlaatvCustomFiles/js/UserCart.js',
        'public/acm/AlaatvCustomFiles/js/page-checkout-review.js'
    ],
    'public/js/checkout-review.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/js/UserCart.js',
        'public/acm/AlaatvCustomFiles/js/page-checkout-payment.js',
    ],
    'public/js/checkout-payment.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/js/page-checkout-verification.js',
    ],
    'public/js/checkout-verification.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/js/page-checkout-auth.js',
    ],
    'public/js/checkout-auth.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/js/page-checkout-completeInfo.js',
    ],
    'public/js/checkout-completeInfo.js'
).version();

mix.babel(
    [
        'node_modules/bootstrap-fileinput/js/fileinput.js',
        'node_modules/persian-date/dist/persian-date.js',
        'node_modules/persian-datepicker/dist/js/persian-datepicker.js',
        'public/acm/AlaatvCustomFiles/js/page-user-profile.js'
    ],
    'public/js/user-profile.js'
).version();

mix.babel(
    [
        'node_modules/highcharts/highcharts.js',
        'node_modules/highcharts/modules/map.js',
        'node_modules/highcharts/modules/drilldown.js',
        'node_modules/highcharts/modules/networkgraph.js',
        // 'public/acm/AlaatvCustomFiles/js/iran.geo-map.js'
    ],
    'public/js/user-profile-salesReport.js'
).version();

mix.babel(
    [
        'node_modules/persian-date/dist/persian-date.js',
        'public/acm/AlaatvCustomFiles/js/page-user-orders.js'
    ],
    'public/js/user-orders.js'
).version();

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
        'public/acm/AlaatvCustomFiles/js/page-user-dashboard.js',
    ],
    'public/js/user-dashboard.js'
);

mix.styles(
    [
        'node_modules/animate.css/animate.css',
        'node_modules/persian-datepicker/dist/css/persian-datepicker.css',
        'node_modules/bootstrap-fileinput/css/fileinput.css',
        'node_modules/bootstrap-fileinput/css/fileinput-rtl.css',
        'public/acm/AlaatvCustomFiles/css/page-user-profile.css',
    ],
    'public/css/user-profile.css'
).version();

mix.styles(
    [
        'node_modules/highcharts/css/highcharts.css',
    ],
    'public/css/user-profile-salesReport.css'
).version();

mix.styles(
    [
        'public/acm/AlaatvCustomFiles/css/page-user-orders.css',
    ],
    'public/css/user-orders.css'
).version();

mix.styles(
    [
        'public/acm/AlaatvCustomFiles/css/page-error.css',
    ],
    'public/css/page-error.css'
).version();


mix.styles(
    [
        'public/acm/AlaatvCustomFiles/css/page-contactUs.css',
    ],
    'public/css/page-contactUs.css'
).version();

mix.styles(
    [
        'node_modules/lightgallery/src/css/lightgallery.css',
        'public/acm/videojs/skins/alaa-theme/videojs.css',
        'public/acm/videojs/plugins/pip/videojs.pip.min.css',
        'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
        'public/acm/videojs/plugins/seek-to-point.css',
        'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',
        'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
        'public/acm/AlaatvCustomFiles/css/page-product-show.css',
    ],
    'public/css/product-show.css'
).version();

mix.styles(
    [
        'public/acm/videojs/skins/alaa-theme/videojs.css',
        'public/acm/videojs/plugins/pip/videojs.pip.min.css',
        'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
        'public/acm/videojs/plugins/seek-to-point.css',
        'public/acm/AlaatvCustomFiles/css/product-content-embed.css',
    ],
    'public/css/product-content-embed.css'
).version();

mix.styles(
    [
        'public/acm/AlaatvCustomFiles/components/step/step.css',
        'public/acm/AlaatvCustomFiles/css/page-checkout-review.css',
    ],
    'public/css/checkout-review.css'
).version();
mix.styles(
    [
        'node_modules/animate.css/animate.css',
        'node_modules/slick-carousel/slick/slick.css',
        'node_modules/slick-carousel/slick/slick-theme.css',
        'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
        'public/acm/AlaatvCustomFiles/css/page-user-dashboard.css',
    ],
    'public/css/user-dashboard.css'
).version();

mix.styles(
    [
        'public/acm/AlaatvCustomFiles/components/step/step.css',
        'public/acm/AlaatvCustomFiles/css/page-checkout-payment.css',
    ],
    'public/css/checkout-payment.css'
).version();

mix.babel(
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


mix.babel(
    [
        'node_modules/persian-date/dist/persian-date.js',
        'node_modules/persian-datepicker/dist/js/persian-datepicker.js',

        // 'node_modules/bootstrap-fileinput/js/fileinput.min.js',
        // 'node_modules/dropzone/dist/dropzone.js',
        // 'node_modules/dropzone/dist/dropzone-amd-module.js',
        // 'node_modules/summernote/dist/summernote.min.js',
        // 'node_modules/toastr/build/toastr.min.js',
        'node_modules/icheck/icheck.min.js',
        // 'node_modules/inputmask/dist/min/jquery.inputmask.bundle.min.js',
        'node_modules/jquery-multiselect/jquery-MultiSelect.js',
        'node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
        'node_modules/bootstrap-multiselect/dist/js/bootstrap-multiselect.js',
        // 'node_modules/toastr/build/toastr.min.js',
        'node_modules/select2/dist/js/select2.js',
    ],
    'public/js/admin-content-create.js'
);

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
        'public/acm/AlaatvCustomFiles/js/certificates.js',
        'public/acm/AlaatvCustomFiles/js/page-shop.js',
    ],
    'public/js/page-shop.js'
);

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
        'public/acm/AlaatvCustomFiles/js/page-landing7.js',
    ],
    'public/js/page-landing7.js'
);

mix.babel(
    [
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
        'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
        'public/acm/AlaatvCustomFiles/js/certificates.js',
        // 'public/acm/AlaatvCustomFiles/js/page-homePage.js',
    ],
    'public/js/page-homePage.js'
);

mix.styles(
    [
        'node_modules/persian-datepicker/dist/css/persian-datepicker.min.css',

        'node_modules/bootstrap-fileinput/css/fileinput.css',
        'node_modules/bootstrap-fileinput/css/fileinput-rtl.css',
        // 'node_modules/dropzone/dist/dropzone.css',
        // 'node_modules/dropzone/dist/basic.css',
        // 'node_modules/summernote/dist/summernote.css',
        // 'node_modules/toastr/build/toastr.min.css',
        // 'node_modules/icheck/skins/all.css',
        'node_modules/jquery-multiselect/jquery-MultiSelect.css',
        'node_modules/bootstrap-multiselect/dist/css/bootstrap-multiselect.css',
        'node_modules/bootstrap-tagsinput/src/bootstrap-tagsinput.css',
    ],
    'public/css/admin-content-create.css'
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

mix.styles(
    [
        'node_modules/slick-carousel/slick/slick.css',
        'node_modules/slick-carousel/slick/slick-theme.css',
        'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',

        'public/acm/videojs/skins/alaa-theme/videojs.css',
        'public/acm/videojs/skins/nuevo/videojs.rtl.css',
        'public/acm/videojs/plugins/pip/videojs.pip.min.css',
        'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
        'public/acm/videojs/plugins/seek-to-point.css',

        'public/acm/AlaatvCustomFiles/components/summarizeText/style.css',

        'public/acm/AlaatvCustomFiles/css/page-content-show.css'
    ],
    'public/css/content-show.css'
);

mix.styles(
    [
        'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
        'public/acm/AlaatvCustomFiles/components/MultiLevelSearch/style.css',
        'public/acm/AlaatvCustomFiles/css/page-content-search.css'
    ],
    'public/css/content-search.css'
);

mix.styles(
    [
        'node_modules/slick-carousel/slick/slick.css',
        'node_modules/slick-carousel/slick/slick-theme.css',
        'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
        'public/acm/AlaatvCustomFiles/css/certificates.css',
        'public/acm/AlaatvCustomFiles/css/page-shop.css',
    ],
    'public/css/page-shop.css'
).version();

mix.styles(
    [
        'node_modules/slick-carousel/slick/slick.css',
        'node_modules/slick-carousel/slick/slick-theme.css',
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
        'public/acm/AlaatvCustomFiles/css/page-landing7.css',
    ],
    'public/css/page-landing7.css'
).version();

mix.styles(
    [
        'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
        'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
        'public/acm/AlaatvCustomFiles/css/certificates.css',
        'public/acm/AlaatvCustomFiles/css/page-homePage.css',
    ],
    'public/css/page-homePage.css'
).version();