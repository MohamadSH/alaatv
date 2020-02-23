var APortlet = function () {

    function addEvent() {
        $(document).on('click', '.m-portlet .m-portlet__head .m-portlet__head-tools [m-portlet-tool="toggle"]', function (e) {
            $portlet = $(this).parents('.m-portlet');
            if ($portlet.hasClass('m-portlet--collapsed')) {
                riseAbove($portlet);
            } else {
                collapse($portlet);
            }
            e.stopPropagation();
            e.preventDefault();
        });
    }

    function collapse($portlet) {
        $portlet.addClass('m-portlet--collapsed');
    }

    function riseAbove($portlet) {
        $portlet.removeClass('m-portlet--collapsed');
    }

    function init() {
        addEvent()
    }

    return {
        init: init
    }

}();

APortlet.init();
