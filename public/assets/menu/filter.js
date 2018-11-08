$(document).ready(function () {
    /**
     * show_hid filter
     */
    $("#close_filter .right_icon").on('click', function () {
        $(".page-content-wrapper").addClass("in_filter");
        $(this).hide();
        $("#close_filter .left_icon").show();
    });
    $("#close_filter .left_icon").hide();
    $("#close_filter .left_icon").on('click', function () {
        $(".page-content-wrapper").removeClass("in_filter");
        $(this).hide();
        $("#close_filter .right_icon").show();
    });

    /**
     * accordion
     * @type {HTMLCollectionOf<Element>}
     */
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "100%";
            }
        });
    }
    $(document).ready(function () {


        /**
         * checkbox
         */
        $(".search_popup input[type=checkbox]").change(function () {
            if ($(this).is(':checked')) {
                $(this).parent().addClass('fill');
            } else {
                $(this).parent().removeClass('fill');
            }
        });

        /**
         * scroll
         */
        $(window).on("load", function () {

            /**
             * enable scrolling buttons by default
             */
            $.mCustomScrollbar.defaults.scrollButtons.enable = true;

            /**
             * enable 2 axis scrollbars by default
             */
            $.mCustomScrollbar.defaults.axis = "yx";

            $("#content-rds").mCustomScrollbar({theme: "rounded-dots"});

        });

        $('.check_item').on('click', function () {
            $(this).addClass('active_menu').siblings().removeClass('active_menu');
        });
        $("#filterClear").click(function () {
            $('.active_menu').removeClass('active_menu');
            $('.fill').removeClass('fill');
        });

        $(".click_menu").click(function () {
            $(".right_menu").addClass("menu_respon");
        });
        $(".close_menu").click(function () {
            $(".right_menu").removeClass("menu_respon");
        });

    });
});

