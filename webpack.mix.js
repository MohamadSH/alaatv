let mix = require('laravel-mix');

mix.styles([
    'public/assets/extra/fonts/IRANSans/css/fontiran.css',
    'public/assets/extra/fonts/IRANSans/css/style.css',
    'public/assets/global/plugins/font-awesome/css/font-awesome.min.css',
    'public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css',
    'public/assets/global/plugins/bootstrap/css/bootstrap-rtl.min.css',
    'public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch-rtl.min.css'
], 'public/css/mandatory_all.css').copy([
        'public/assets/global/plugins/font-awesome/fonts',
        'public/assets/extra/fonts/IRANSans/farsi_numeral',
        'public/assets/extra/fonts/IRANSans/fonts',
        'public/assets/global/plugins/simple-line-icons/fonts']
    , 'public/fonts') .version();
mix.copy('public/assets/global/plugins/simple-line-icons/fonts','public/css/fonts');
mix.copyDirectory(
    [
        'public/assets/extra/fonts/IRANSans'
    ],'public'
);
mix.styles([
    'public/assets/global/css/components-md-rtl.min.css',
    'public/assets/global/css/plugins-md-rtl.min.css',
], 'public/css/basic_all.css').version();

mix.styles([
    'public/assets/layouts/layout2/css/layout-rtl.min.css',
    'public/assets/layouts/layout2/css/themes/blue-rtl.min.css',
    'public/assets/layouts/layout2/css/custom-rtl.min.css',
], 'public/css/head_layout_all.css').version();

mix.styles(
    [
        'public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
        'public/assets/global/plugins/morris/morris.css',
        'public/assets/global/plugins/fullcalendar/fullcalendar.min.css',
        'public/assets/global/plugins/jqvmap/jqvmap/jqvmap.css',
        'public/assets/global/plugins/cubeportfolio/css/cubeportfolio.css',
        'public/assets/global/plugins/jquery-notific8/jquery.notific8.min.css',
    ],
    'public/css/home_page_level_plugin_all.css'
).version();

mix.styles(
    [
        'public/css/home_page_level_plugin_all.css',
        'public/assets/global/plugins/select2/css/select2.min.css',
        'public/assets/global/plugins/select2/css/select2-bootstrap.min.css',
        'public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css',
        'public/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css',
        'public/css/extraCSS/bootstrap-carousel.css',
        'public/assets/global/plugins/icheck/skins/all.css',
        'public/assets/global/plugins/datatables/datatables.min.css',
        'public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css',
        'public/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css',
        'public/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css',
        'public/assets/global/plugins/dropzone/dropzone.min.css',
        'public/assets/global/plugins/dropzone/basic.min.css'

    ],
    'public/css/page_level_plugin_all.css'
).version();



mix.styles(
    [
        'public/assets/pages/css/portfolio-rtl.min.css',
        'public/assets/pages/css/search-rtl.min.css',
    ],
    'public/css/home_page_level_style_all.css'
).version();

mix.styles(
    [
        'public/assets/pages/css/about-rtl.min.css',
        'public/assets/pages/css/contact-rtl.min.css',
        'public/assets/global/plugins/jstree/dist/themes/default/style.min.css',
        'public/assets/pages/css/profile-rtl.min.css',
        'public/assets/pages/css/profile-2-rtl.min.css',
        'public/css/home_page_level_style_all.css',

    ],
    'public/css/page_level_style_all.css'
).version();
mix.copy('public/assets/global/plugins/jstree/dist/themes/default/32px.png','public/css/32px.png');
mix.copy('public/assets/global/plugins/jstree/dist/themes/default/32px_line.png','public/css/32px_line.png');
mix.copy('public/assets/global/plugins/jstree/dist/themes/default/32px_original.png','public/css/32px_original.png');
mix.copy('public/assets/global/plugins/jstree/dist/themes/default/40px.png','public/css/40px.png');
mix.copy('public/assets/global/plugins/jstree/dist/themes/default/throbber.gif','public/css/throbber.gif');
mix.copy(['public/assets/layouts/layout2/img',
    'public/assets/global/plugins/cubeportfolio/img',
],'public/img');


mix.scripts([
    'public/assets/global/plugins/jquery.min.js',
    'public/assets/global/plugins/bootstrap/js/bootstrap.min.js',
    'public/assets/global/plugins/js.cookie.min.js',
    'public/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
    'public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
    'public/assets/global/plugins/jquery.blockui.min.js',
    'public/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'
], 'public/js/core_all.js').version(); // Enable versioning.


mix.scripts([
    'public/assets/layouts/layout2/scripts/layout.min.js',
    'public/assets/layouts/layout2/scripts/demo.min.js',
    'public/assets/layouts/global/scripts/quick-sidebar.min.js'
], 'public/js/layout_.js').version(); // Enable versioning.

mix.scripts(
    [
        'public/assets/global/plugins/moment.min.js',
        'public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js',
        'public/assets/global/plugins/morris/morris.min.js',
        'public/assets/global/plugins/morris/raphael-min.js',
        'public/assets/global/plugins/counterup/jquery.waypoints.min.js',
        'public/assets/global/plugins/counterup/jquery.counterup.min.js',
        'public/assets/global/plugins/amcharts/amcharts/amcharts.js',
        'public/assets/global/plugins/amcharts/amcharts/serial.js',
        'public/assets/global/plugins/amcharts/amcharts/pie.js',
        'public/assets/global/plugins/amcharts/amcharts/radar.js',
        'public/assets/global/plugins/amcharts/amcharts/themes/light.js',
        'public/assets/global/plugins/amcharts/amcharts/themes/patterns.js',
        'public/assets/global/plugins/amcharts/amcharts/themes/chalk.js',
        'public/assets/global/plugins/amcharts/ammap/ammap.js',
        'public/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js',
        'public/assets/global/plugins/amcharts/amstockcharts/amstock.js',
        'public/assets/global/plugins/fullcalendar/fullcalendar.min.js',
        'public/assets/global/plugins/horizontal-timeline/horozontal-timeline.min.js',
        'public/assets/global/plugins/flot/jquery.flot.min.js',
        'public/assets/global/plugins/flot/jquery.flot.resize.min.js',
        'public/assets/global/plugins/flot/jquery.flot.categories.min.js',
        'public/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js',
        'public/assets/global/plugins/jquery.sparkline.min.js',
        'public/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js',
        'public/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js',
        'public/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js',
        'public/assets/global/plugins/jquery-ui/jquery-ui.min.js',
        'public/assets/global/plugins/jquery-notific8/jquery.notific8.min.js',
        'public/assets/global/plugins/bootstrap-toastr/toastr.min.js'
    ],  'public/js/home_footer_Page_Level_Plugin.js').version();

mix.scripts(
    [
        'public/js/home_footer_Page_Level_Plugin.js',
        'public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',
        'public/assets/global/plugins/bootstrap-toastr/toastr.min.js',
        'public/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js',
        'public/assets/global/plugins/icheck/icheck.min.js'
    ],'public/js/footer_Page_Level_Plugin.js'
).version();

mix.scripts(
    [
        'public/assets/pages/scripts/dashboard.min.js',
        'public/assets/pages/scripts/ui-toastr.min.js',
        'public/js/extraJS/jquery-ui/jquery-ui.js',
        'public/assets/pages/scripts/ui-modals.min.js',
        'public/assets/pages/scripts/form-icheck.min.js',
    ],'public/js/Page_Level_Script_all.js'
).version();

mix.styles(
    [
        'public/css/mandatory_all.css',
        'public/css/page_level_plugin_all.css',
        'public/css/basic_all.css',
        'public/css/page_level_style_all.css',
        'public/css/head_layout_all.css'
    ],
    'public/css/all.css'
).version();

// mix.scripts(
//     [
//         'public/js/core_all.js',
//         'public/js/footer_Page_Level_Plugin.js',
//         'public/assets/global/scripts/app.min.js',
//         'public/js/footer_Page_Level_Plugin.js',
//         'public/js/Page_Level_Script_all.js',
//         'public/js/layout_.js',
//         'public/js/extera.js'
//     ],'public/js/all.js'
// ).version();

mix.copyDirectory('public/assets/global/plugins/bootstrap/fonts/','public/fonts/').version();

mix.copyDirectory('public/assets/global/img/','public/img/').version();
mix.copy('public/assets/global/plugins/datatables/images','public/plugins/datatables/images');