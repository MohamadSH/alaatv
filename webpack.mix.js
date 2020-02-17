class Mix {

    constructor() {
        require('dotenv').config();
        this.appEnv = process.env.APP_ENV;
        this.outputCssFile = [];
        this.mix = require('laravel-mix');
        this.purify = require("purify-css");
    }

    static getBaseCss() {
        return [

            'public/acm/webFonts/IRANSans/css/fontiran.css', // 800B
            // 'public/assets/vendors/base/vendors.bundle.rtl.css',
            // 'public/assets/demo/demo12/base/style.bundle.rtl.css',// 1006 KB
            'public/assets/vendors/base/vendors.bundle.rtl.css',
            'public/assets/demo/demo12/base/style.bundle.rtl.css',// 475 KB

            'node_modules/toastr/build/toastr.css',// 481 KB

            'public/acm/custom-css-app.css',

            'public/acm/AlaatvCustomFiles/components/AjaxLogin/style.css',
            'public/acm/AlaatvCustomFiles/components/MegaMenu/style.css',
            'public/acm/AlaatvCustomFiles/components/loading/loading.css',// 488 KB

            'public/acm/AlaatvCustomFiles/css/customStyle.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/m-accordion.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/header-menu.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/productPrice.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/m-aside-menu.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/animation.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/megamenu.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/helper_display.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/lazyImage.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/colors.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/footer.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/mobile-topMenu.css',
            'public/acm/AlaatvCustomFiles/css/customStyle/font.css',// 500 KB

            'public/acm/AlaatvCustomFiles/css/fixThemeStyle.css',
        ];
    }

    static getBaseJs() {
        return [
            'node_modules/intersection-observer/intersection-observer.js',
            'node_modules/lozad/dist/lozad.js', // 9 KB

            'public/assets/vendors/base/vendors.bundle.js',// 173 KB
            'public/assets/demo/demo12/base/scripts.bundle.js',// 205 KB

            'node_modules/toastr/build/toastr.min.js',
            'node_modules/block-ui/jquery.blockUI.js',
            'node_modules/persianjs/persian.min.js',// 223 KB

            // 'node_modules/firebase/firebase-app.js',
            // 'node_modules/firebase/firebase-messaging.js',
            // 'public/acm/AlaatvCustomFiles/js/GoogleFirebase.js',// 290 KB

            'public/acm/AlaatvCustomFiles/components/MegaMenu/script.js',
            'public/acm/AlaatvCustomFiles/components/AjaxLogin/script.js',// 297 KB
            'public/acm/AlaatvCustomFiles/js/GlobalJsVar.js',
            'public/acm/AlaatvCustomFiles/js/Cookie.js',
            'public/acm/AlaatvCustomFiles/js/GoogleAnalyticsEnhancedEcommerce.js',
            'public/acm/AlaatvCustomFiles/js/lazyLoad.js',// 302 KB
            'public/acm/AlaatvCustomFiles/js/app.js'// 306 KB
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

        this.compileScss();
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

        if (this.appEnv === 'production') {
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

    compileScss() {
        this.mix.sass('public/acm/AlaatvCustomFiles/components/Favorite/style.scss', 'public/acm/AlaatvCustomFiles/components/Favorite');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/MegaMenu/style.scss', 'public/acm/AlaatvCustomFiles/components/MegaMenu');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/AjaxLogin/style.scss', 'public/acm/AlaatvCustomFiles/components/AjaxLogin');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/CustomDropDown/style.scss', 'public/acm/AlaatvCustomFiles/components/CustomDropDown');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.scss', 'public/acm/AlaatvCustomFiles/components/ScrollCarousel');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/SearchBoxFilter/style.scss', 'public/acm/AlaatvCustomFiles/components/SearchBoxFilter');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.scss', 'public/acm/AlaatvCustomFiles/components/OwlCarouselType2');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/MultiLevelSearch/style.scss', 'public/acm/AlaatvCustomFiles/components/MultiLevelSearch');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/ScrollCarousel/itemStyle.scss', 'public/acm/AlaatvCustomFiles/components/ScrollCarousel');
        this.mix.sass('public/acm/AlaatvCustomFiles/css/page/pages/content-search/searchResult.scss', 'public/acm/AlaatvCustomFiles/css/page/pages/content-search');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/FormGenerator/style.scss', 'public/acm/AlaatvCustomFiles/components/FormGenerator');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/Alist/type1/style.scss', 'public/acm/AlaatvCustomFiles/components/Alist/type1');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/Alist/type2/style.scss', 'public/acm/AlaatvCustomFiles/components/Alist/type2');
        this.mix.sass('public/acm/AlaatvCustomFiles/components/Alist/type3/style.scss', 'public/acm/AlaatvCustomFiles/components/Alist/type3');
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

    mixPageFaq() {
        this.mixCssAndJs([
                'public/acm/videojs/skins/alaa-theme/videojs.css',
                'public/acm/videojs/skins/nuevo/videojs.rtl.css',
                'public/acm/videojs/plugins/pip/videojs.pip.min.css',
                'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
                'public/acm/videojs/plugins/seek-to-point.css',
                'public/acm/AlaatvCustomFiles/components/Alist/type1/style.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/faq.css'
            ],
            'public/css/faq.css',
            [
                'public/acm/videojs/video.min.js',
                'public/acm/videojs/plugins/pip/videojs.pip.min.js',
                'public/acm/videojs/nuevo.min.js',
                'public/acm/videojs/plugins/videojs.p2p.min.js',
                'public/acm/videojs/plugins/videojs.hotkeys.min.js',
                'public/acm/videojs/plugins/seek-to-point.js',
                'public/acm/videojs/lang/fa.js',
                'public/acm/AlaatvCustomFiles/js/page/pages/faq.js'
            ],
            'public/js/faq.js'
        );
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
                'public/acm/AlaatvCustomFiles/css/customStyle/carouselMainSlideShow.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/shop.css',
            ],
            'public/css/page-shop.css',
            [
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
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
                'node_modules/jquery-validation/dist/jquery.validate.js',
                'public/acm/AlaatvCustomFiles/js/page/pages/login.js'
            ],
            'public/js/login.js'
        );
    }
    mixPageDonate() {
        this.mixCssAndJs([
                'node_modules/highcharts/css/highcharts.css',
                'public/acm/webFonts/IRANSans/css/fontiran.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/donate.css'
                // 'public/acm/extra/donate/css/styles.min.css'
            ],
            'public/css/page-donate.css',
            [
                'node_modules/jquery/dist/jquery.js',
                'node_modules/highcharts/highcharts.js',
                // 'public/acm/extra/donate/js/html5shiv.js',
                // 'public/acm/extra/donate/js/respond.min.js',
                // 'public/acm/extra/donate/js/Chart.bundle.min.js',
                'public/acm/AlaatvCustomFiles/js/page-donate.js'
            ],
            'public/js/page-donate.js');
    }
    mixVoucherLogin() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/components/AlaaLoading/style.css',
                'public/acm/AlaatvCustomFiles/components/FormGenerator/style.css',
                'public/acm/AlaatvCustomFiles/css/auth/voucherLogin.css',
            ],
            'public/css/voucher-login.css',
            [
                'public/acm/AlaatvCustomFiles/components/AlaaLoading/script.js',
                'public/acm/AlaatvCustomFiles/components/FormGenerator/script.js',
                'public/acm/AlaatvCustomFiles/js/auth/voucherLogin.js',
            ],
            'public/js/voucher-login.js'
        );
    }
    mixPageHomePage() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/css/customStyle/carouselMainSlideShow.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/homePage.css',
            ],
            'public/css/page-homePage.css',
            [
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/components/AnimateScrollTo/js.js',
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
                'node_modules/pretty-checkbox/dist/pretty-checkbox.css',

                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/components/SearchBoxFilter/style.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/content-search/searchResult.css',

                'public/acm/AlaatvCustomFiles/components/AlaaLoading/style.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/itemStyle.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/content-search/content-search.css'
            ],
            'public/css/content-search.css',
            [
                'node_modules/persian-date/dist/persian-date.js',
                'node_modules/truncatise/index.js',
                'node_modules/persianjs/persian.min.js',

                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/AlaaLoading/script.js',
                'public/acm/AlaatvCustomFiles/components/SearchBoxFilter/script.js',
                'public/acm/AlaatvCustomFiles/components/UrlParameter/UrlParameter.js',

                'public/acm/AlaatvCustomFiles/js/page-content-search-filter-data.js',
                'public/acm/AlaatvCustomFiles/js/page/pages/content-search.js'
            ],
            'public/js/content-search.js'
        );
    }
    mixPages() {
        this.mixPageFaq();
        this.mixPageLive();
        this.mixPageShop();
        this.mixPageError();
        this.mixAuthLogin();
        this.mixPageDonate();
        this.mixVoucherLogin();
        this.mixPageHomePage();
        this.mixPageContactUs();
        this.mixPageContentSearch();
    }

    mixPageUserOrders() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/css/customStyle/datatable.css',
                'public/acm/AlaatvCustomFiles/css/page/user/orders.css',
            ],
            'public/css/user-orders.css',
            [
                'node_modules/persian-date/dist/persian-date.js',
                'public/acm/AlaatvCustomFiles/components/Alist/type2/script.js',
                'public/acm/AlaatvCustomFiles/js/page/user/orders.js'
            ],
            'public/js/user-orders.js'
        );
    }
    mixPageUserProfile() {
        this.mixCssAndJs(
            [
                'node_modules/animate.css/animate.css',
                'node_modules/persian-datepicker/dist/css/persian-datepicker.css',
                'node_modules/bootstrap-fileinput/css/fileinput.css',
                'node_modules/bootstrap-fileinput/css/fileinput-rtl.css',
                'public/acm/AlaatvCustomFiles/css/page/user/profile.css',
            ],
            'public/css/user-profile.css',
            [
                'node_modules/bootstrap-fileinput/js/fileinput.js',
                'node_modules/persian-date/dist/persian-date.js',
                'node_modules/persian-datepicker/dist/js/persian-datepicker.js',
                'public/acm/AlaatvCustomFiles/js/page/user/profile.js'
            ],
            'public/js/user-profile.js'
        );
    }
    mixPageCompleteUserProfile() {
        this.mixCssAndJs(
            [
                'node_modules/animate.css/animate.css',
                'node_modules/persian-datepicker/dist/css/persian-datepicker.css',
                'public/acm/AlaatvCustomFiles/css/page/user-profile.css',
            ],
            'public/css/user-completeInfo.css',
            [
                'node_modules/persian-date/dist/persian-date.js',
                'node_modules/persian-datepicker/dist/js/persian-datepicker.js',
                'public/acm/AlaatvCustomFiles/js/page/user-profile.js'
            ],
            'public/js/user-completeInfo.js'
        );
    }
    mixPageUserDashboard() {
        this.mixCssAndJs([
                'node_modules/animate.css/animate.css',
                'public/acm/AlaatvCustomFiles/components/AlaaLoading/style.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/components/CustomDropDown/style.css',
                'public/acm/AlaatvCustomFiles/css/page/pages/content-search/searchResult.css',
                'public/acm/AlaatvCustomFiles/components/FormGenerator/style.css',
                'public/acm/AlaatvCustomFiles/css/page/user/dashboard.css',
            ],
            'public/css/user-dashboard.css',
            [
                'public/acm/AlaatvCustomFiles/components/CustomDropDown/js.js',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/AlaaLoading/script.js',
                'public/acm/AlaatvCustomFiles/components/AlaaLoading/script.js',
                'public/acm/AlaatvCustomFiles/components/SortElements/script.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/components/FormGenerator/script.js',
                'public/acm/AlaatvCustomFiles/js/page/user/dashboard.js',
            ],
            'public/js/user-dashboard.js'
        );
    }
    mixPageUserProfileSalesReport() {
        this.mixCssAndJs([
                'node_modules/highcharts/css/highcharts.css',
                'public/acm/AlaatvCustomFiles/css/page/user/sales-report.css',
            ],
            'public/css/user-profile-salesReport.css',
            [
                'public/acm/AlaatvCustomFiles/js/iran.geo-map.js',
                'node_modules/highcharts/highcharts.js',
                'node_modules/highcharts/modules/map.js',
                'node_modules/highcharts/modules/drilldown.js',
                'node_modules/highcharts/modules/networkgraph.js',
                'public/acm/AlaatvCustomFiles/js/page/user/sales-report.js',
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
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/components/Favorite/style.css',
                'public/acm/AlaatvCustomFiles/components/AlaaScroll/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',

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
                'public/acm/videojs/video.min.js',
                'public/acm/videojs/plugins/pip/videojs.pip.min.js',
                'public/acm/videojs/nuevo.min.js',
                'public/acm/videojs/plugins/videojs.p2p.min.js',
                'public/acm/videojs/plugins/videojs.hotkeys.min.js',
                'public/acm/videojs/plugins/seek-to-point.js',
                'public/acm/videojs/lang/fa.js',
                'public/acm/AlaatvCustomFiles/js/UserCart.js',
                'public/acm/AlaatvCustomFiles/components/Favorite/script.js',
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/components/summarizeText/js.js',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/AnimateScrollTo/js.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/components/SortElements/script.js',
                'public/acm/AlaatvCustomFiles/js/page/content-show.js'
            ],
            'public/js/content-show.js'
        );
    }

    mixPageSetShow() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/components/Favorite/style.css',
                'public/acm/AlaatvCustomFiles/components/Alist/type1/style.css',
                'public/acm/AlaatvCustomFiles/components/Alist/type2/style.css',
                'public/acm/AlaatvCustomFiles/css/page/set-show.css'
            ],
            'public/css/set-show.css',
            [
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/components/Favorite/script.js',
                'public/acm/AlaatvCustomFiles/components/UrlParameter/UrlParameter.js',
                'public/acm/AlaatvCustomFiles/components/Alist/type1/script.js',
                'public/acm/AlaatvCustomFiles/components/Alist/type2/script.js',
                'public/acm/AlaatvCustomFiles/js/page/set-show.js'
            ],
            'public/js/set-show.js'
        );
    }

    mixLanding5() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',
                'public/acm/AlaatvCustomFiles/css/page/product/landing/5.css',
            ],
            'public/css/page-landing5.css',
            [
                'public/acm/AlaatvCustomFiles/js/page/product/landing/5.js',
            ],
            'public/js/page-landing5.js'
        );
    }
    mixLanding7() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/css/page/product/landing/7.css',
            ],
            'public/css/page-landing7.css',
            [
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/js/page/product/landing/7.js',
            ],
            'public/js/page-landing7.js'
        );
    }
    mixLanding8() {
        this.mixCssAndJs([
                // 'node_modules/metrojs/release/MetroJs.Full/MetroJs.min.css',
                // 'node_modules/flipclock/dist/flipclock.css',
                'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/css/page/product/landing/8.css',
            ],
            'public/css/page-landing8.css',
            [
                // 'node_modules/flipclock/dist/flipclock.js',
                // 'public/acm/AlaatvCustomFiles/js/page/product/landing/8.js',
            ],
            'public/js/page-landing8.js'
        );
    }
    mixLanding9() {
        this.mixCssAndJs([
                'node_modules/slick-carousel/slick/slick.css',
                'node_modules/slick-carousel/slick/slick-theme.css',


                'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',


                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/css/page/product/landing/7.css',
                'public/acm/AlaatvCustomFiles/css/page/product/landing/9.css',
            ],
            'public/css/page-landing9.css',
            [
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/js/page/product/landing/9.js',
            ],
            'public/js/page-landing9.js'
        );
    }
    mixLanding10() {
        this.mixCssAndJs([
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/css/page/product/landing/7.css',
                'public/acm/AlaatvCustomFiles/css/page/product/landing/9.css',
            ],
            'public/css/page-landing10.css',
            [
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/js/page/product/landing/10.js',
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

    mixPageProductShow(baseProductShow) {
        this.mixCssAndJs(baseProductShow.css, 'public/css/product-show.css',
            baseProductShow.js, 'public/js/product-show.js');
    }
    mixPageProductShowRaheAbrisham(baseProductShow) {
        this.mixCssAndJs(
            baseProductShow.css.concat([
                'public/acm/AlaatvCustomFiles/components/CustomDropDown/style.css',
                'public/acm/AlaatvCustomFiles/components/AlaaLoading/style.css',
                'public/acm/AlaatvCustomFiles/css/page/product/customShow/raheAbrisham.css',
            ])
            ,
            'public/css/product-show-RaheAbrisham.css',
            baseProductShow.js.concat([

                'node_modules/hammerjs/hammer.js',
                'node_modules/@panzoom/panzoom/dist/panzoom.js',

                'public/acm/AlaatvCustomFiles/components/AlaaLoading/script.js',
                'public/acm/AlaatvCustomFiles/components/CustomDropDown/js.js',

                'public/acm/AlaatvCustomFiles/js/page/product/CustomShow/raheAbrisham.js',
            ]),
            'public/js/product-show-RaheAbrisham.js'
        );
    }
    mixPageProductContentEmbed() {
        this.mixCssAndJs([
                'public/acm/videojs/skins/alaa-theme/videojs.css',
                'public/acm/videojs/plugins/pip/videojs.pip.min.css',
                'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
                'public/acm/videojs/plugins/seek-to-point.css',
                'public/acm/AlaatvCustomFiles/css/page/product/content-embed.css',
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
        var baseProductShow = {
            css: [
                'node_modules/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css',
                'node_modules/lightgallery/src/css/lightgallery.css',
                'public/acm/videojs/skins/alaa-theme/videojs.css',
                'public/acm/videojs/plugins/pip/videojs.pip.min.css',
                'public/acm/videojs/plugins/pip/videojs.pip.rtl.css',
                'public/acm/videojs/plugins/seek-to-point.css',
                'public/acm/AlaatvCustomFiles/components/imageWithCaption/style.css',
                'public/acm/AlaatvCustomFiles/components/ribbon/style.css',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/style.css',
                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/style.css',
                'public/acm/AlaatvCustomFiles/components/Favorite/style.css',
                'public/acm/AlaatvCustomFiles/css/page/product/show.css',
            ],
            js: [
                'node_modules/bootstrap-switch/dist/js/bootstrap-switch.js',
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

                'public/acm/AlaatvCustomFiles/components/ScrollCarousel/js.js',
                'public/acm/AlaatvCustomFiles/components/OwlCarouselType2/js.js',
                'public/acm/AlaatvCustomFiles/components/AnimateScrollTo/js.js',
                'public/acm/AlaatvCustomFiles/components/aSticky/aSticky.js',
                'public/acm/AlaatvCustomFiles/components/Favorite/script.js',

                'public/acm/AlaatvCustomFiles/js/UserCart.js',

                'public/acm/AlaatvCustomFiles/js/page/product/product-show.js',
            ]
        };
        this.mixPageProductShow(baseProductShow);
        this.mixPageProductShowRaheAbrisham(baseProductShow);
        this.mixPageProductContentEmbed();
    }

    mixPageCheckoutReview() {
        this.mixCssAndJs([
                'node_modules/animate.css/animate.css',
                'node_modules/pretty-checkbox/dist/pretty-checkbox.css',
                'node_modules/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css',
                'public/acm/AlaatvCustomFiles/components/step/step.css',
                'public/acm/AlaatvCustomFiles/components/Alist/type3/style.css',
                'public/acm/AlaatvCustomFiles/css/page/checkout-review.css',
            ],
            'public/css/checkout-review.css',
            [
                'node_modules/bootstrap-switch/dist/js/bootstrap-switch.js',
                'node_modules/jquery-sticky/jquery.sticky.js',
                'public/acm/AlaatvCustomFiles/components/AnimateScrollTo/js.js',
                'public/acm/AlaatvCustomFiles/js/UserCart.js',
                'public/acm/AlaatvCustomFiles/js/page/checkout/review.js'
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
                'public/acm/AlaatvCustomFiles/js/page/checkout/verification.js',
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
                'public/acm/AlaatvCustomFiles/css/customStyle/datatable.css',
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
                'public/acm/AlaatvCustomFiles/css/admin/custom/summernote.css',
            ],
            'public/css/admin-all.css',
            [
                'node_modules/persianjs/persian.min.js',
                'node_modules/summernote/dist/summernote.js',
                'node_modules/tooltip/dist/Tooltip.js',
                'node_modules/select2/dist/js/select2.js',
                'node_modules/select2/dist/js/select2.full.js',
                'node_modules/icheck/icheck.js',

                'public/acm/AlaatvCustomFiles/components/portlet/portlet.js',
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
                'public/acm/AlaatvCustomFiles/js/admin/makeMultiSelect.js',
                'public/acm/AlaatvCustomFiles/js/admin/custom/init-component.js',
                'public/acm/AlaatvCustomFiles/js/admin/custom/summernote.js',
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
                'public/acm/AlaatvCustomFiles/js/page/checkout/auth.js',
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
                    'public/acm/AlaatvCustomFiles/js/page/checkout/payment.js',
                ],
                'public/js/checkout-payment.js'
            ).version();
    }
}

let mixAsset = new Mix();
mixAsset.mixAll();
