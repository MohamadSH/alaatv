(function ($) { //an IIFE so safely alias jQuery to $

    $.fn.AnimateScrollTo = function (customOptions) {  //Add the function
        $.fn.AnimateScrollTo.options = $.extend(true, {}, $.fn.AnimateScrollTo.defaultOptions, customOptions);

        return this.each(function () { //Loop over each element in the set and return them to keep the chain alive.
            let $this = $(this);

            $(document).trigger('AnimateScrollTo.beforeScroll',[$this]);
            $([document.documentElement, document.body]).animate({
                scrollTop: $this.offset().top - $.fn.AnimateScrollTo.options.topPadding
            }, $.fn.AnimateScrollTo.options.speed);
            $(document).trigger('AnimateScrollTo.afterScroll',[$this]);

        });
    };

    $.fn.AnimateScrollTo.getHeaderHeight = function () {
        return $('#m_header').height();
    };

    $.fn.AnimateScrollTo.defaultOptions = {
        topPadding: $.fn.AnimateScrollTo.getHeaderHeight() + 5,
        speed: 500
    };

    $.fn.AnimateScrollTo.options = null;

}(jQuery));
