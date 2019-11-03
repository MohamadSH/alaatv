class Mix {

    constructor() {
        require('dotenv').config();
        this.appEnv = process.env.APP_ENV;
        this.outputCssFile = [];
        this.mix = require('laravel-mix');
        this.purify = require("purify-css");
        this.mix.sass('public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.scss', 'public/acm/AlaatvCustomFiles/components/OwlCarouselType2');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/MultiLevelSearch/style.scss', 'public/acm/AlaatvCustomFiles/components/MultiLevelSearch');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/SearchBoxFilter/style.scss', 'public/acm/AlaatvCustomFiles/components/SearchBoxFilter');
    }

    static getBaseCss() {
        return [
            'public/acm/webFonts/IRANSans/css/fontiran.css',
            'public/assets/vendors/base/vendors.bundle.rtl.css',
            'public/assets/demo/demo12/base/style.bundle.rtl.css',
            'public/acm/custom-css-app.css',

            'public/acm/AlaatvCustomFiles/css/customStyle.css',
            'public/acm/AlaatvCustomFiles/css/fixThemeStyle.css',
            'public/acm/AlaatvCustomFiles/components/loading/loading.css',
        ];
    }

    static getBaseJs() {
        return [
            'node_modules/intersection-observer/intersection-observer.js',
            'node_modules/lozad/dist/lozad.js',
            'public/assets/vendors/base/vendors.bundle.js',
            'public/assets/demo/demo12/base/scripts.bundle.js',
            'public/acm/AlaatvCustomFiles/js/GoogleAnalyticsEnhancedEcommerce.js',
            'public/acm/AlaatvCustomFiles/js/lazyLoad.js',
            'public/acm/AlaatvCustomFiles/js/app.js',
            'public/acm/AlaatvCustomFiles/js/mLayout.js'
        ];
    }

    mixCssAndJs(cssArray, cssName, jsArray, jsName) {
        //scripts - babel

        // mix.styles(Mix.getBaseCss().concat(cssArray), cssName)
        //     .scripts(Mix.getBaseJs().concat(jsArray), jsName).version();

        this.mix
            .scripts(jsArray, jsName)
            .styles(cssArray, cssName);

        if (this.mix.inProduction()) {
            this.mix.version();
        }

        this.outputCssFile.push({
            cssName: cssName,
            cssArray: cssArray,
            jsArray: jsArray
        });
        console.log('cssName: ', cssName);
    }

    mixAll() {
        this.mixBase();
        this.mixPages();
        this.mixUser();
        this.mixLanding();
        this.mixProduct();
        this.mixPageContentShow();
        this.mixPageSetShow();
        this.mixCheckout();
        this.mixAdmin();
        this.mixCopyDirectory();

        // if (this.mix.inProduction()) {
        //     this.mix.then(() => {
        //         this.purifyCss();
        //
        //         console.log('' +
        //             '              ##       ##              ##             ##       ############## ##          ##          ####           ####      ##          ##\n' +
        //             '             ####      ##             ####           ####            ##        ##        ##         ##    ##       ##    ##    ###        ###\n' +
        //             '            ##  ##     ##            ##  ##         ##  ##           ##         ##      ##        ##             ##        ##  ####      ####\n' +
        //             '           ##    ##    ##           ##    ##       ##    ##          ##          ##    ##        ##             ##          ## ## ##    ## ##\n' +
        //             '          ##########   ##          ##########     ##########         ##           ##  ##          ##             ##        ##  ##  ##  ##  ##\n' +
        //             '         ##        ##  ##         ##        ##   ##        ##        ##            ####      ###    ##    ##       ##    ##    ##   ####   ##\n' +
        //             '        ##          ## ######### ##          ## ##          ##       ##             ##       ###      ####           ####      ##    ##    ##\n');
        //     });
        // }

        if (this.appEnv === 'development') {

        } else {
            this.mix.then(() => {
                this.purifyCss();

                console.log('' +
                    '              ##       ##              ##             ##       ############## ##          ##          ####           ####      ##          ##\n' +
                    '             ####      ##             ####           ####            ##        ##        ##         ##    ##       ##    ##    ###        ###\n' +
                    '            ##  ##     ##            ##  ##         ##  ##           ##         ##      ##        ##             ##        ##  ####      ####\n' +
                    '           ##    ##    ##           ##    ##       ##    ##          ##          ##    ##        ##             ##          ## ## ##    ## ##\n' +
                    '          ##########   ##          ##########     ##########         ##           ##  ##          ##             ##        ##  ##  ##  ##  ##\n' +
                    '         ##        ##  ##         ##        ##   ##        ##        ##            ####      ###    ##    ##       ##    ##    ##   ####   ##\n' +
                    '        ##          ## ######### ##          ## ##          ##       ##             ##       ###      ####           ####      ##    ##    ##\n');
            });
        }
    }

    purifyCss() {
        let outputCssFilesLength = this.outputCssFile.length;
        for (let i = 0; i < outputCssFilesLength; i++) {
            let cssName = this.outputCssFile[i].cssName,
                jsArray = this.outputCssFile[i].jsArray;
            console.log('purifyCss: ', cssName);
            this.purify((['./resources/views/**/*.blade.php', './resources/views/**/**/*.blade.php', './resources/views/**/**/**/*.blade.php']).concat(jsArray), [cssName], {
                output: './' + cssName,
                // output: './public/css/'+fileName+'.purify.css',

                // Will minify CSS code in addition to purify.
                minify: true,
                // Logs info on how much css was removed
                info: true,

                // // Logs out removed selectors.
                // rejected: true
            });
        }
    }

    mixBase() {
        this.mixCssAndJs(
            Mix.getBaseCss(),
            'public/css/all.css',
            Mix.getBaseJs(),
            'public/js/all.js', 'all');
    }

    mixPageLive() {
        this.mixCssAndJs([
                'node_modules/@fullcalendar/core/main.css',

                'node_modules/@fullcalendar/daygrid/main.css',

                'node_modules/@fullcalendar/timegrid/main.css',


                // 'node_modules/@fullcalendar/timeline/main.css',
                // 'node_modules/@fullcalendar/resource-timeline/main.css',

                'public/acm/videojs/skins/alaa-theme/videojs.css',
                'public/acm/videojs/skins/nuevo/videojs.rtl.css',
                'public/acm/videojs/plugins/pip/videojs.pip.min.css',
                'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
                'public/acm/videojs/plugins/seek-to-point.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/live.css',
            ],
            'public/css/page-live.css',
            [
                'node_modules/@fullcalendar/core/main.js',

                // 'node_modules/@fullcalendar/timeline/main.js',
                // 'node_modules/@fullcalendar/resource-common/main.js',
                // 'node_modules/@fullcalendar/resource-timeline/main.js',

                'node_modules/@fullcalendar/daygrid/main.js',

                'node_modules/@fullcalendar/timegrid/main.js',

                'node_modules/@fullcalendar/core/locales/fa.js',

                'node_modules/tooltip/dist/Tooltip.js',



                'public/acm/videojs/video.min.js',
                'public/acm/videojs/plugins/pip/videojs.pip.min.js',
                'public/acm/videojs/nuevo.min.js',
                'public/acm/videojs/plugins/videojs.p2p.min.js',
                'public/acm/videojs/plugins/videojs.hotkeys.min.js',
                'public/acm/videojs/plugins/seek-to-point.js',
                'public/acm/videojs/lang/fa.js',
                'public/acm/AlaatvCustomFiles/js/page/pages/live.js',
            ],
            'public/js/page-live.js');
    }
    mixPageShop() {
        this.mixCssAndJs([
                'node_modules/slick-carousel/slick/slick.css',
                'node_modules/slick-carousel/slick/slick-theme.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/css/certificates.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/shop.css',
            ],
            'public/css/page-shop.css',
            [
                    'node_modules/owl.carousel/dist/owl.carousel.js',
                    'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                    'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                    'public/acm/AlaatvCustomFiles/js/certificates.js',
                    'public/acm/AlaatvCustomFiles/js/page/pages/shop.js',
                ],
                'public/js/page-shop.js'
            );
    }
    mixPageError() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/css/page/pages/error.css',
            ],
            'public/css/page-error.css',
            [
                    'public/acm/AlaatvCustomFiles/js/page/pages/error.js'
                ],
                'public/js/page-error.js'
            );
    }
    mixAuthLogin() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/css/page/pages/auth-login.css',
            ],
            'public/css/auth-login.css',
            [
                    'node_modules/block-ui/jquery.blockUI.js',
                    'node_modules/jquery-validation/dist/jquery.validate.js',
                    'public/acm/AlaatvCustomFiles/js/page/pages/login.js'
                ],
                'public/js/login.js'
            );
    }
    mixPageHomePage() {
        this.mixCssAndJs([
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/css/certificates.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/homePage.css',
            ],
            'public/css/page-homePage.css',
            [
                'node_modules/owl.carousel/dist/owl.carousel.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/js/certificates.js',
                'public/acm/AlaatvCustomFiles/js/page/pages/homePage.js',
            ],
            'public/js/page-homePage.js',
            'page-homePage');
    }
    mixPageContactUs() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/css/page/pages/contactUs.css',
            ],
            'public/css/page-contactUs.css',
            [
                'node_modules/inputmask/dist/jquery.inputmask.bundle.js',
                'node_modules/inputmask/dist/inputmask/inputmask.date.extensions.js',
                'node_modules/inputmask/dist/inputmask/inputmask.numeric.extensions.js',
                'public/acm/AlaatvCustomFiles/js/page/pages/contactUs.js'
            ],
            'public/js/contactUs.js'
        );
    }
    mixPageContentSearch() {
        this.mixCssAndJs([
                'node_modules/select2/dist/css/select2.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',

                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',

                // 'public/acm/AlaatvCustomFiles/components/SearchBoxFilter/style.css',

                'public/acm/AlaatvCustomFiles/components/MultiLevelSearch/style.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/content-search.css'
            ],
            'public/css/content-search.css',
            [
                    'node_modules/block-ui/jquery.blockUI.js',
                    'node_modules/select2/dist/js/select2.js',
                    'node_modules/owl.carousel/dist/owl.carousel.js',


                    // 'node_modules/persianjs/persian.min.js',
                    // 'public/acm/AlaatvCustomFiles/components/SearchBoxFilter/script.js',

                    'public/acm/AlaatvCustomFiles/components/MultiLevelSearch/js.js',
                    'public/acm/AlaatvCustomFiles/js/page-content-search-filter-data.js',
                    'public/acm/AlaatvCustomFiles/js/page/pages/content-search.js'
                ],
                'public/js/content-search.js'
            );
    }
    mixPages() {
        this.mixPageLive();
        this.mixPageShop();
        this.mixPageError();
        this.mixAuthLogin();
        this.mixPageHomePage();
        this.mixPageContactUs();
        this.mixPageContentSearch();
    }

    mixPageUserOrders() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/css/page/user-orders.css',
            ],
            'public/css/user-orders.css',
            [
                    'node_modules/persian-date/dist/persian-date.js',
                    'public/acm/AlaatvCustomFiles/js/page/user-orders.js'
                ],
                'public/js/user-orders.js'
            );
    }
    mixPageUserProfile() {
        this.mixCssAndJs(
            [
                'node_modules/toastr/build/toastr.css',
                'node_modules/animate.css/animate.css',
                'node_modules/persian-datepicker/dist/css/persian-datepicker.css',
                'node_modules/bootstrap-fileinput/css/fileinput.css',
                'node_modules/bootstrap-fileinput/css/fileinput-rtl.css',
                'public/acm/AlaatvCustomFiles/css/page/user-profile.css',
            ],
            'public/css/user-profile.css',
            [
                'node_modules/toastr/build/toastr.min.js',
                'node_modules/block-ui/jquery.blockUI.js',
                'node_modules/bootstrap-fileinput/js/fileinput.js',
                'node_modules/persian-date/dist/persian-date.js',
                'node_modules/persian-datepicker/dist/js/persian-datepicker.js',
                'public/acm/AlaatvCustomFiles/js/page/user-profile.js'
            ],
            'public/js/user-profile.js'
        );
    }
    mixPageCompleteUserProfile() {
        this.mixCssAndJs(
            [
                'node_modules/toastr/build/toastr.css',
                'node_modules/animate.css/animate.css',
                'node_modules/persian-datepicker/dist/css/persian-datepicker.css',
                'public/acm/AlaatvCustomFiles/css/page/user-profile.css',
            ],
            'public/css/user-completeInfo.css',
            [
                'node_modules/toastr/build/toastr.min.js',
                'node_modules/block-ui/jquery.blockUI.js',
                'node_modules/persian-date/dist/persian-date.js',
                'node_modules/persian-datepicker/dist/js/persian-datepicker.js',
                // 'public/acm/AlaatvCustomFiles/js/page/user-profile.js'
            ],
            'public/js/user-completeInfo.js'
        );
    }
    mixPageUserDashboard() {
        this.mixCssAndJs([
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'node_modules/animate.css/animate.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/css/page/user-dashboard.css',
            ],
            'public/css/user-dashboard.css',
            [
                    'node_modules/block-ui/jquery.blockUI.js',
                    'node_modules/owl.carousel/dist/owl.carousel.js',
                    'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                    'public/acm/AlaatvCustomFiles/js/page/user-dashboard.js',
                ],
                'public/js/user-dashboard.js'
            );
    }
    mixPageUserProfileSalesReport() {
        this.mixCssAndJs([
                'node_modules/highcharts/css/highcharts.css',
                'public/acm/AlaatvCustomFiles/css/page/user-sales-report.css',
            ],
            'public/css/user-profile-salesReport.css',
            [
                    'public/acm/AlaatvCustomFiles/js/iran.geo-map.js',
                    'node_modules/highcharts/highcharts.js',
                    'node_modules/highcharts/modules/map.js',
                    'node_modules/highcharts/modules/drilldown.js',
                    'node_modules/highcharts/modules/networkgraph.js',
                    'public/acm/AlaatvCustomFiles/js/page/user-sales-report.js',
                ],
                'public/js/user-profile-salesReport.js'
            );
    }
    mixUser() {
        this.mixPageUserOrders();
        this.mixPageUserProfile();
        this.mixPageCompleteUserProfile();
        this.mixPageUserDashboard();
        this.mixPageUserProfileSalesReport();
    }

    mixPageContentShow() {
        this.mixCssAndJs([
                'node_modules/toastr/build/toastr.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'node_modules/block-ui/jquery.blockUI.js',
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/videojs/skins/alaa-theme/videojs.css',
                'public/acm/videojs/skins/nuevo/videojs.rtl.css',
                'public/acm/videojs/plugins/pip/videojs.pip.min.css',
                'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
                'public/acm/videojs/plugins/seek-to-point.css',
                'public/acm/AlaatvCustomFiles/components/summarizeText/style.css',
                'public/acm/AlaatvCustomFiles/css/page/content-show.css'
            ],
            'public/css/content-show.css',
            [
                'node_modules/tooltip/dist/Tooltip.js',
                'node_modules/toastr/build/toastr.min.js',
                'node_modules/block-ui/jquery.blockUI.js',
                'node_modules/owl.carousel/dist/owl.carousel.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/videojs/video.min.js',
                'public/acm/videojs/plugins/pip/videojs.pip.min.js',
                'public/acm/videojs/nuevo.min.js',
                'public/acm/videojs/plugins/videojs.p2p.min.js',
                'public/acm/videojs/plugins/videojs.hotkeys.min.js',
                'public/acm/videojs/plugins/seek-to-point.js',
                'public/acm/videojs/lang/fa.js',
                'public/acm/AlaatvCustomFiles/components/summarizeText/js.js',
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/js/UserCart.js',
                'public/acm/AlaatvCustomFiles/js/page/content-show.js'
            ],
            'public/js/content-show.js'
        );
    }

    mixPageSetShow() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/css/page/set-show.css'
            ],
            'public/css/set-show.css',
            [
                'public/acm/AlaatvCustomFiles/js/page/set-show.js'
            ],
            'public/js/set-show.js'
        );
    }

    mixLanding5() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',
                'public/acm/AlaatvCustomFiles/css/page-product-landing5.css',
            ],
            'public/css/page-landing5.css',
            [
                    'public/acm/AlaatvCustomFiles/js/page-product-landing5.js',
                ],
                'public/js/page-landing5.js'
            );
    }
    mixLanding7() {
        this.mixCssAndJs([
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/css/page-product-landing7.css',
            ],
            'public/css/page-landing7.css',
            [
                    'node_modules/owl.carousel/dist/owl.carousel.js',
                    'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                    'public/acm/AlaatvCustomFiles/js/page-landing7.js',
                ],
                'public/js/page-landing7.js'
            );
    }
    mixLanding8() {
        this.mixCssAndJs([
                'node_modules/flipclock/dist/flipclock.css',
                'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/css/page-product-landing8.css',
            ],
            'public/css/page-landing8.css',
            [
                    'node_modules/flipclock/dist/flipclock.js',
                    'public/acm/AlaatvCustomFiles/js/page-product-landing8.js',
                ],
                'public/js/page-landing8.js'
            );
    }
    mixLanding9() {
        this.mixCssAndJs([
                'node_modules/slick-carousel/slick/slick.css',
                'node_modules/slick-carousel/slick/slick-theme.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/css/page-product-landing7.css',
                'public/acm/AlaatvCustomFiles/css/page-product-landing9.css',
            ],
            'public/css/page-landing9.css',
            [
                    'node_modules/owl.carousel/dist/owl.carousel.js',
                    'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                    'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                    'public/acm/AlaatvCustomFiles/js/page-product-landing9.js',
                ],
                'public/js/page-landing9.js'
            );
    }
    mixLanding10() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/css/page-product-landing7.css',
                'public/acm/AlaatvCustomFiles/css/page-product-landing9.css',
            ],
            'public/css/page-landing10.css',
            [
                    'node_modules/owl.carousel/dist/owl.carousel.js',
                    'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                    'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                    'public/acm/AlaatvCustomFiles/js/page-product-landing10.js',
                ],
                'public/js/page-landing10.js'
            );
    }
    mixLanding() {
        this.mixLanding5();
        this.mixLanding7();
        this.mixLanding8();
        this.mixLanding9();
        this.mixLanding10();
    }

    mixPageProductShow() {
        this.mixCssAndJs([
                'node_modules/toastr/build/toastr.css',
                'node_modules/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css',
                'node_modules/lightgallery/src/css/lightgallery.css',
                'public/acm/videojs/skins/alaa-theme/videojs.css',
                'public/acm/videojs/plugins/pip/videojs.pip.min.css',
                'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
                'public/acm/videojs/plugins/seek-to-point.css',
                'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'node_modules/owl.carousel/dist/assets/owl.carousel.css',
                'node_modules/owl.carousel/dist/assets/owl.theme.default.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/css/page/product-show.css',
            ],
            'public/css/product-show.css',
            [
                    'node_modules/toastr/build/toastr.min.js',
                    'node_modules/block-ui/jquery.blockUI.js',
                    'node_modules/bootstrap-switch/dist/js/bootstrap-switch.js',
                    'node_modules/owl.carousel/dist/owl.carousel.js',
                    'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                    'node_modules/lightgallery/src/js/lightgallery.js',
                    'node_modules/lightgallery/modules/lg-thumbnail.min.js',
                    'node_modules/lightgallery/modules/lg-autoplay.min.js',
                    'node_modules/lightgallery/modules/lg-fullscreen.min.js',
                    'node_modules/lightgallery/modules/lg-pager.min.js',
                    'node_modules/lightgallery/modules/lg-hash.min.js',
                    'node_modules/lightgallery/modules/lg-share.min.js',
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

                    'public/acm/AlaatvCustomFiles/js/page/product-show.js',
                ],
                'public/js/product-show.js'
            );
    }
    mixPageProductContentEmbed() {
        this.mixCssAndJs([
                'public/acm/videojs/skins/alaa-theme/videojs.css',
                'public/acm/videojs/plugins/pip/videojs.pip.min.css',
                'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
                'public/acm/videojs/plugins/seek-to-point.css',
                'public/acm/AlaatvCustomFiles/css/product-content-embed.css',
            ],
            'public/css/product-content-embed.css',
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
            );
    }
    mixProduct() {
        this.mixPageProductShow();
        this.mixPageProductContentEmbed();
    }

    mixPageCheckoutReview() {
        this.mixCssAndJs([
                'node_modules/toastr/build/toastr.css',
                'node_modules/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css',
                'node_modules/animate.css/animate.css',
                'public/acm/AlaatvCustomFiles/components/step/step.css',
                'public/acm/AlaatvCustomFiles/css/page/checkout-review.css',
            ],
            'public/css/checkout-review.css',
            [
                    'node_modules/toastr/build/toastr.min.js',
                    'node_modules/bootstrap-switch/dist/js/bootstrap-switch.js',
                    'node_modules/block-ui/jquery.blockUI.js',
                    'node_modules/jquery-sticky/jquery.sticky.js',
                    'public/acm/AlaatvCustomFiles/js/UserCart.js',
                    'public/acm/AlaatvCustomFiles/js/page/checkout-review.js'
                ],
                'public/js/checkout-review.js'
            );
    }
    mixPageCheckoutVerification() {
        this.mixCssAndJs([
                'node_modules/animate.css/animate.css',
            ],
            'public/css/checkout-verification.css',
            [
                    'public/acm/AlaatvCustomFiles/js/page/checkout-verification.js',
                ],
                'public/js/checkout-verification.js'
            );
    }
    mixCheckout() {
        this.mixPageCheckoutReview();
        this.mixPageCheckoutVerification();
    }

    mixAdminBase() {
        this.mixCssAndJs([
                'node_modules/summernote/dist/summernote.css',
                'node_modules/select2/dist/css/select2.css',
                'node_modules/icheck/skins/all.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/css/select2-bootstrap.min.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-sweetalert/sweetalert.css',
                'public/acm/extra/persian-datepicker/dist/css/persian-datepicker-1.1.3.min.css',
                'public/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css',
            ],
            'public/css/admin-all.css',
            [
                    'node_modules/persianjs/persian.min.js',
                    'node_modules/summernote/dist/summernote.js',
                    'node_modules/block-ui/jquery.blockUI.js',
                    'node_modules/tooltip/dist/Tooltip.js',
                    'node_modules/select2/dist/js/select2.js',
                    'node_modules/select2/dist/js/select2.full.js',
                    'node_modules/icheck/icheck.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery.sparkline.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-repeater/jquery.repeater.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jplayer/dist/jplayer/jquery.jplayer.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jQueryNumberFormat/jquery.number.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-sweetalert/sweetalert.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery.input-ip-address-control-1.0.min.js',

                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-repeater.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-confirmations.min.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/makeSelect2Single.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-input-mask.js',
                    'public/acm/AlaatvCustomFiles/components/alaa_old/scripts/form-icheck.js',
                    'public/acm/extra/persian-datepicker/lib/persian-date.js',
                    'public/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js',
                    'public/acm/AlaatvCustomFiles/js/admin/makeDataTable.js',
                    'public/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js',
                    'public/acm/AlaatvCustomFiles/js/admin-customInitComponent.js',
                ],
                'public/js/admin-all.js'
            );
    }
    mixAdminContentCreate() {
        this.mixCssAndJs([
                'node_modules/persian-datepicker/dist/css/persian-datepicker.min.css',
                'node_modules/bootstrap-fileinput/css/fileinput.css',
                'node_modules/bootstrap-fileinput/css/fileinput-rtl.css',
                'node_modules/jquery-multiselect/jquery-MultiSelect.css',
                'node_modules/bootstrap-multiselect/dist/css/bootstrap-multiselect.css',
                'node_modules/bootstrap-tagsinput/src/bootstrap-tagsinput.css',
            ],
            'public/css/admin-content-create.css',
            [
                    'node_modules/block-ui/jquery.blockUI.js',
                    'node_modules/persian-date/dist/persian-date.js',
                    'node_modules/persian-datepicker/dist/js/persian-datepicker.js',
                    'node_modules/icheck/icheck.min.js',
                    'node_modules/jquery-multiselect/jquery-MultiSelect.js',
                    'node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
                    'node_modules/bootstrap-multiselect/dist/js/bootstrap-multiselect.js',
                    'node_modules/select2/dist/js/select2.js',
                ],
                'public/js/admin-content-create.js'
            );
    }
    mixAdminContentEdit() {
        this.mixCssAndJs([
            ],
                'public/css/admin-content-edit.css',
            [
                'node_modules/diff-match-patch/index.js',
                ],
                'public/js/admin-content-edit.js'
            );
    }
    mixAdmin() {
        this.mixAdminBase();
        this.mixAdminContentCreate();
        this.mixAdminContentEdit();
    }

    mixCopyDirectory() {
        this.mix.copyDirectory('node_modules/summernote/dist/font', 'public/css/font');
        this.mix.copyDirectory('public/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/font', 'public/css/font');
    }

    oldMixCheckoutAuth() {
        mix.babel(
            [
                'public/acm/AlaatvCustomFiles/js/page-checkout-auth.js',
            ],
            'public/js/checkout-auth.js'
        ).version();
    }

    oldMixCheckoutCompleteInfo() {
        mix.babel(
            [
                'public/acm/AlaatvCustomFiles/js/page-checkout-completeInfo.js',
            ],
            'public/js/checkout-completeInfo.js'
        ).version();
    }

    oldMixCheckoutPayment() {
        mix.styles(
            [
                'public/acm/AlaatvCustomFiles/components/step/step.css',
                'public/acm/AlaatvCustomFiles/css/page/checkout-payment.css',
            ],
            'public/css/checkout-payment.css'
        ).version()
            .babel(
                [
                    'public/acm/AlaatvCustomFiles/js/UserCart.js',
                    'public/acm/AlaatvCustomFiles/js/page-checkout-payment.js',
                ],
                'public/js/checkout-payment.js'
            ).version();
    }
}

let mixAsset = new Mix();
mixAsset.mixAll();
