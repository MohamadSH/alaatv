(function($) {

    $.fn.FormGenerator = function(customOptions) {

        var defaultOptions = {
                ajax: null,
                form: null,
                formId: 'FormGenerator_'+Date.now(),
                inputData: []
            },
            defaultOptions_ajax = {
                type: 'GET',
                url: '',
                data: {},
                accept: 'application/json; charset=utf-8',
                dataType: 'json',
                contentType: 'application/json; charset=utf-8',
                beforeSend: function () {
                    var formData = this.getFormData();
                    this.setAjaxData(formData);
                    return true;
                },
                success: function (data) {},
                error: function (jqXHR, textStatus, errorThrown) {},
                cache: false,
                headers: {}
            },
            defaultOptions_form = {
                action: '',
                method: 'GET'
            },
            defaultOptions_inputText = {
                type: 'text',
                name: '',
                value: '',
                placeholder: '',
                label: null,
                iconLeft: null,
                iconsRight: null,
                id: null
            },
            defaultOptions_inputHidden = {
                type: 'hidden',
                name: '',
                value: '',
                id: null
            },
            defaultOptions_inputSubmit = {
                type: 'submit',
                name: '',
                class: '',
                id: null
            },
            defaultOptions_inputSendAjax = {
                type: 'sendAjax',
                text: '',
                class: '',
                id: null
            },
            defaultOptions_btn = {
                text: '',
                class: '',
                id: null
            },
            options = null;

        if (this.length > 1) {
            this.each(function() { $(this).FormGenerator(options) });
            return this;
        }

        // private variables

        var privatevar1 = '';

        var privatevar2 = '';

        // private methods

        var normalizeData = function(formData) {

            formData = $.extend(true, {}, defaultOptions, formData);

            if (formData.ajax !== null) {
                formData.ajax = $.extend(true, {}, defaultOptions_ajax, formData.ajax);
                formData.form = null;
            } else {
                formData.form = $.extend(true, {}, defaultOptions_form, formData.form);
            }

            var inputDataLength = formData.inputData.length,
                defaultOptionsMap = {
                    text: defaultOptions_inputText,
                    hidden: defaultOptions_inputHidden,
                    submit: defaultOptions_inputSubmit,
                    sendAjax: defaultOptions_inputSendAjax,
                    btn: defaultOptions_btn,
                };
            for (var i = 0; i < inputDataLength; i++) {
                var defaultOptions = null,
                    type = null;

                if (typeof formData.inputData[i].type === 'undefined') {
                    type = 'text';
                } else {
                    type = formData.inputData[i].type;
                }

                if (typeof defaultOptionsMap[type] !== 'undefined') {
                    defaultOptions = defaultOptionsMap[type];
                }

                if (defaultOptions !== null) {
                    formData.inputData[i] = $.extend(true, {}, defaultOptions, formData.inputData[i]);
                } else {
                    formData.inputData.splice(i,1);
                }
            }

            options = formData;
        };

        var createForm = function (formData) {

            var inputDataLength = formData.inputData.length,
                formBody = '',
                action = '',
                method = '';

            for (var i = 0; i < inputDataLength; i++) {
                formBody += createFormGroup(formData.inputData[i]);
            }

            if (formData.form !== null) {
                action = 'action="'+formData.form.action+'"';
                method = 'method="'+formData.form.method+'"';
            }

            return '' +
                '<form id="'+formData.formId+'" class="FormGenerator" '+action+' '+method+'>' +
                '  ' + formBody +
                '</form>';
        };

        var createFormGroup = function(inputItemData) {

            if (inputItemData.type === 'submit' || inputItemData.type === 'sendAjax' || inputItemData.type === 'hidden' || inputItemData.type === 'btn') {
                return createInput(inputItemData);
            }

            var withIconClass = 'withIcon',
                withIconDirectionClass = '',
                spanOfIcon = '',
                hasIcon = true,
                iconHtml = '',
                hasLabel = (inputItemData.label !== null & inputItemData.label.trim().length > 0),
                label = '';

            if (inputItemData.iconLeft !== null) {
                withIconDirectionClass = 'inputIcon left';
                iconHtml = inputItemData.iconLeft;
            } else if (inputItemData.iconsRight !== null) {
                withIconDirectionClass = 'inputIcon right';
                iconHtml = inputItemData.iconsRight;
            } else {
                withIconClass = '';
                hasIcon = false;
            }

            if (hasIcon) {
                spanOfIcon =
                    '    <span class="'+withIconDirectionClass+'">' +
                    '      <span>'+iconHtml+'</span>' +
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
                '    <div class="form-control-feedback"></div>' +
                '  </div>' +
                '</div>';
        };

        var createInput = function(inputItemData) {
            if (inputItemData.type === 'text') {
                return createInput_text(inputItemData);
            } else if (inputItemData.type === 'submit') {
                return createInput_submit(inputItemData);
            } else if (inputItemData.type === 'sendAjax') {
                return createInput_sendAjax(inputItemData);
            } else if (inputItemData.type === 'btn') {
                return createInput_btn(inputItemData);
            } else if (inputItemData.type === 'hidden') {
                return createInput_hidden(inputItemData);
            } else {
                return '';
            }
        };

        var normilizeItemId = function (id) {
            return (id !== null) ? 'id="'+id+'"' : '';
        };

        var createInput_text = function(inputItemData) {
            return '    <input type="text" name="'+inputItemData.name+'" '+normilizeItemId(inputItemData.id)+' class="form-control" placeholder="'+inputItemData.placeholder+'" value="'+inputItemData.value+'">';
        };

        var createInput_submit = function(inputItemData) {
            return '    <button type="submit" name="'+inputItemData.name+'" '+normilizeItemId(inputItemData.id)+' class="'+inputItemData.class+'">'+inputItemData.text+'</button>';
        };

        var createInput_sendAjax = function(inputItemData) {
            return '    <button '+normilizeItemId(inputItemData.id)+' class="btnSendAjax_FormGenerator '+inputItemData.class+'">'+inputItemData.text+'</button>';
        };

        var createInput_btn = function(inputItemData) {
            return '    <button '+normilizeItemId(inputItemData.id)+' class="'+inputItemData.class+'">'+inputItemData.text+'</button>';
        };

        var createInput_hidden = function(inputItemData) {
            return '    <input type="hidden" name="'+inputItemData.name+'" '+normilizeItemId(inputItemData.id)+' value="'+inputItemData.value+'">';
        };

        var addEventListener = function (formData) {
            if (formData.ajax !== null) {
                addEventListenerForAjax(formData.ajax);
            }
        };

        var addEventListenerForAjax = function (formDataAjax) {
            $('.btnSendAjax_FormGenerator').off('click');
            $(document).on('click', '.btnSendAjax_FormGenerator', function (e) {
                e.preventDefault();
                var canSendAjax = formDataAjax.beforeSend();
                if (canSendAjax === true) {
                    getAjaxContent(formDataAjax);
                }
            });
        };

        var ajaxSetup = function(formDataAjax) {
            $.ajaxSetup({
                cache: formDataAjax.cache,
                headers: formDataAjax.headers
            });
        };

        var getAjaxContent = function(formDataAjax) {
            ajaxSetup(formDataAjax);
            $.ajax({
                    type: formDataAjax.type,
                    url: formDataAjax.url,
                    // data: JSON.stringify(formDataAjax.data),
                    data: formDataAjax.data,
                    // accept: formDataAjax.accept,
                    dataType: formDataAjax.dataType,
                    // contentType: formDataAjax.contentType,
                    success: formDataAjax.success,
                    error:  formDataAjax.error
                }
            );
        };

        // public methods

        this.init = function(formData) {
            normalizeData(formData);
            $(this).html(createForm(options));
            addEventListener(options);
            return this;
        };

        this.getFormData = function() {
            var unindexed_array = $(this).find('form').serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function (n, i) {
                indexed_array[n['name']] = n['value'];
            });

            return indexed_array;
        };

        this.setAjaxData = function(data) {
            options.ajax.data = data;
        };

        this.inputFeedback = function(inputName, message, status) {
            var $input = $(this).find('[name="'+inputName+'"]');
            if (typeof status === 'undefined') {
                $input.parents('.form-group').removeClass('has-danger');
                $input.parents('.form-group').removeClass('has-success');
            } else if(status === 'success') {
                $input.parents('.form-group').removeClass('has-danger');
                $input.parents('.form-group').addClass('has-success');
            } else if(status === 'danger') {
                $input.parents('.form-group').removeClass('has-success');
                $input.parents('.form-group').addClass('has-danger');
            }
            $input.parents('.form-group').find('.form-control-feedback').html(message);
        };

        return this.init(customOptions);

    };


})(jQuery);
