(function($) {

    $.fn.FormGenerator = function(customOptions) {

        var defaultOptions = {},
            options = $.extend(true, {}, defaultOptions, customOptions);

        if (this.length > 1) {
            this.each(function() { $(this).FormGenerator(options) });
            return this;
        }

        // private variables

        var privatevar1 = '';

        var privatevar2 = '';

        // private methods

        var createInput = function(inputType, inputData) {

        };
        var createInput_text = function(inputData) {
            return '' +
                '<div class="form-group">' +
                '  <label for="'+inputData.id+'">'+inputData.label+'</label>' +
                '  <div class="FormGenerator-input-wrapper m-input-icon m-input-icon--left">' +
                '    <input type="text" name="'+inputData.name+'" id="'+inputData.id+'" class="form-control m-input m-input--air '+inputData.placeholder+'" placeholder="'+inputData.placeholder+'">' +
                '    <span class="m-input-icon__icon m-input-icon__icon--left">' +
                '      <span><i class="fa fa-university"></i></span>' +
                '    </span>' +
                '  </div>' +
                '</div>';
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


})(jQuery);
