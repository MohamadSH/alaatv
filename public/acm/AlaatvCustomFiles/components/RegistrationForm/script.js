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

        var myPrivateMethod = function() {

            // do something ...

        }

        // public methods

        this.initialize = function() {

            // do something ...

            return this;

        };

        this.myPublicMethod = function() {

            // do something ...

        };

        return this.initialize();

    }


    $.fn.pluginName.defaultOptions = {
        OwlCarousel: {
            stagePadding: 0,
            center: true,
            rtl: true,
            loop: true,
            nav: true,
            margin: 10,
            lazyLoad:true,
            responsive: {
                0: {
                    items: 1
                },
                400: {
                    items: 2
                },
                600: {
                    items: 3
                },
                800: {
                    items: 4
                },
                1000: {
                    items: 5
                }
            },
            // onDragged: this.callback,
            onTranslated: $.fn.OwlCarouselType2.showAlaaOwlCarouselItemDetail,
            btnSwfitchEvent: function() {},
            onTranslatedEvent: function() {},
        },
        grid: {
            btnSwfitchEvent: function() {},
            columnClass: 'col-12 col-sm-6 col-md-3'
        },
        defaultView: 'OwlCarousel', // or grid
        childCountHideOwlCarousel: 5
    };
    $.fn.pluginName.options = null;

})(jQuery);
