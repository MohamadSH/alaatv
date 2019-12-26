(function($) {

    $.fn.pluginName = function(options) {

        var defaults = {

            color: "white",

            BackgroundColor: "#556b2f"

        };

        var settings = $.extend({}, defaults, options);

        if (this.length > 1) {

            this.each(function() { $(this).pluginName(options) });

            return this;

        }

        // private variables

        var privatevar1 = '';

        var privatevar2 = '';

        // private methods

        var getOptions = function() {
            $.fn.pluginName.owlCarouselOptions = $.extend(true, {}, $.fn.OwlCarouselType2.owlCarouseldefaultOptions, customOptions);
        };

        // public methods

        this.initialize = function() {

            // do something ...

            return this;

        };

        this.myPublicMethod = function() {

            // do something ...

        };

        return this.initialize();

    };


    $.fn.pluginName.defaultOptions = {
    };
    $.fn.pluginName.options = null;

})(jQuery);
