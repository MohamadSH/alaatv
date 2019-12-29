(function($) {

    $.fn.FormGenerator = function(customOptions) {

        var defaultOptions = {
                inputData: []
            },
            defaultOptions_inputText = {
                type: 'text',
                name: '',
                placeholder: '',
                id: ''
            },
            options = $.extend(true, {}, defaultOptions, customOptions);

        if (this.length > 1) {
            this.each(function() { $(this).FormGenerator(options) });
            return this;
        }

        // private variables

        var privatevar1 = '';

        var privatevar2 = '';

        // private methods

        var createFormHtml = function(inputData) {
            if (typeof inputData.type === 'undefined') {
                return '';
            }
            if (inputData.type === 'text') {
                return createInput_text(inputData);
            } else {
                return '';
            }
        };

        var createFormGroup = function(inputItemData) {

            var withIconClass = '',
                withIconDirectionClass = '',
                spanOfIcon = '',
                hasIcon = true,
                hasLabel = (typeof inputItemData.label !== 'undefined'),
                label = '';

            if (typeof inputItemData.icons !== 'undefined') {
                withIconClass = 'withIcon';
                if (typeof inputItemData.icons.left !== 'undefined') {
                    withIconDirectionClass = 'left';
                } else if (typeof inputItemData.icons.right !== 'undefined') {
                    withIconDirectionClass = 'right';
                } else {
                    hasIcon = false;
                }
            }

            if (hasIcon) {
                spanOfIcon =
                    '    <span class="'+withIconDirectionClass+'">' +
                    '      <span>'+inputItemData.icons.right+'</span>' +
                    '    </span>';
            }

            if (hasLabel) {
                label = '  <label for="'+inputItemData.id+'">'+inputItemData.label+'</label>';
            }

            return '' +
                '<div class="form-group">' +
                '  ' + label +
                '  <div class="'+withIconClass+'">' +
                '    ' + createInput(inputItemData) +
                '    ' + spanOfIcon +
                '  </div>' +
                '</div>';
        };

        var createInput = function(inputItemData) {
            if (typeof inputItemData.type === 'undefined') {
                return '';
            }
            if (inputItemData.type === 'text') {
                return createInput_text(inputItemData);
            } else {
                return '';
            }
        };

        var createInput_text = function(inputItemData) {
            inputItemData = $.extend(true, {}, defaultOptions_inputText, inputItemData);
            return '    <input type="text" name="'+inputItemData.name+'" id="'+inputItemData.id+'" class="form-control" placeholder="'+inputItemData.placeholder+'">';
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
