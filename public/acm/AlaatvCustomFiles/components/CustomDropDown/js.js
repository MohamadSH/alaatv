(function ($) { //an IIFE so safely alias jQuery to $

    $.fn.CustomDropDown = function (customOptions) {  //Add the function
        $.fn.CustomDropDown.options = $.extend(true, {}, $.fn.CustomDropDown.defaultOptions, customOptions);

        return this.each(function () { //Loop over each element in the set and return them to keep the chain alive.
            let $this = $(this),
                lastId = $.fn.CustomDropDown.getNewCustomDropDownId();

            if ($.fn.CustomDropDown.checkExistSelectElement($this)) {
                $this.attr('data-custom-dropdown-id', lastId);
                $.fn.CustomDropDown.clean($this);
                $.fn.CustomDropDown.createCustomDropDown($this);
                $.fn.CustomDropDown.options.onRendered($this);
            }
        });
    };

    $.fn.CustomDropDown.clean = function ($this) {
        // console.log($this.find('.select-selected'));
        // $this.find('.select-selected').remove();
        // $.fn.CustomDropDown.getItemsElement($this).remove();
    };

    $.fn.CustomDropDown.checkExistSelectElement = function ($this) {
        return $this.find('select').length === 1;
    };

    $.fn.CustomDropDown.getNewCustomDropDownId = function () {
        var lastId = 0,
            counter = 0;
        while ($('*[data-custom-dropdown-id="'+counter+'"]').length > 0) {
            counter++;
        }
        lastId = counter;
        return lastId;
    };

    $.fn.CustomDropDown.getSelectElement = function ($this) {
        return $this.find('select')[0];
    };

    $.fn.CustomDropDown.getItemsElement = function ($this) {
        var $customParentOptions = $.fn.CustomDropDown.checkCustomParentOptions($this);
        if ($customParentOptions) {
            return $customParentOptions.find('.select-items');
        } else {
            return $this.find('.select-items');
        }
    };

    $.fn.CustomDropDown.fixCustomParentOptionsClass = function ($customParentOptions) {
        if (!$customParentOptions.hasClass('CustomParentOptions')) {
            $customParentOptions.addClass('CustomParentOptions');
        }
        if (!$customParentOptions.hasClass('CustomDropDown')) {
            $customParentOptions.addClass('CustomDropDown');
        }
    };

    $.fn.CustomDropDown.checkCustomParentOptions = function ($this) {
        if (typeof $.fn.CustomDropDown.options.parentOptions === 'function') {
            var parentOptionsSelector = $.fn.CustomDropDown.options.parentOptions($this),
                $customParentOptions = $(parentOptionsSelector);
            if ($customParentOptions.length>0) {
                $.fn.CustomDropDown.fixCustomParentOptionsClass($customParentOptions);
                return $customParentOptions;
            } else {
                return false;
            }
        } else {
            return false;
        }
    };

    $.fn.CustomDropDown.renderOption = function (optionObject) {
        var label = optionObject.innerHTML,
            value = optionObject.getAttribute('value'),
            renderedLabel = label;
        if (typeof $.fn.CustomDropDown.options.renderOption === 'function') {
            renderedLabel = $.fn.CustomDropDown.options.renderOption(optionObject);
        }
        var item = document.createElement('DIV');
        item.innerHTML = renderedLabel;
        item.setAttribute('data-option-value', value);
        item.setAttribute('data-option-label', label);
        item.classList.add('select-item');
        $.fn.CustomDropDown.optionClickEvent(item);
        return item;
    };

    $.fn.CustomDropDown.optionClickEvent = function (item) {
        item.addEventListener('click', function(e) {


            var selectElement = $.fn.CustomDropDown.getSelectElement($(e.target).parents('.CustomDropDown')),
                selectSelectedElement = $(e.target).parents('.CustomDropDown').find('.select-selected')[0];
            if ($(e.target).parents('.CustomDropDown').hasClass('CustomParentOptions')) {
                var cddid = $(e.target).parents('.CustomDropDown').attr('id'),
                    $cddid = $('.CustomDropDown[data-parent-id="'+cddid+'"]');
                selectElement = $.fn.CustomDropDown.getSelectElement($cddid);
                selectSelectedElement = $cddid.find('.select-selected')[0];
            }


            /* When an item is clicked, update the original select box, and the selected item: */
            var sLength = selectElement.length,
                selectedItem = ($(e.target).hasClass('select-item')) ? $(e.target)[0] : $(e.target).parents('.select-item')[0],
                $selectItems = $(e.target).parents('.select-items').find('.select-item'),
                value, index;
            for (var i = 0; i < sLength; i++) {
                if (selectElement.options[i].innerHTML === selectedItem.getAttribute('data-option-label')) {
                    value = selectedItem.getAttribute('data-option-value');
                    index = i;
                    break;
                }
            }



            if ($.fn.CustomDropDown.options.onChange({
                target: $(e.target),
                selectObject: selectElement,
                index: index,
                totalCount: sLength,
                value: value,
                text: selectedItem.innerHTML
            }) === false) {
                return;
            }

            $.fn.CustomDropDown.selectItem(selectElement, selectSelectedElement, $selectItems, index, selectedItem);

            $.fn.CustomDropDown.options.onChanged({
                target: $(e.target),
                selectObject: selectElement,
                index: index,
                totalCount: sLength,
                value: value,
                text: selectedItem.innerHTML
            });
        });
    };

    $.fn.CustomDropDown.selectItem = function (selectElement, selectSelectedElement, $selectItems, index, selectedItem) {
        selectElement.selectedIndex = index;
        selectSelectedElement.innerHTML = selectedItem.getAttribute('data-option-label');
        $selectItems.removeClass('same-as-selected');
        selectedItem.classList.add('same-as-selected');
        // selectedItem.click();
        selectSelectedElement.setAttribute('data-option-value', selectedItem.getAttribute('data-option-value'));
    };

    $.fn.CustomDropDown.createSelectedItem = function ($this) {
        var selectElement = $.fn.CustomDropDown.getSelectElement($this);
        /* For each element, create a new DIV that will act as the selected item: */
        var selectedItem = document.createElement("DIV");
        selectedItem.setAttribute("class", "select-selected");
        selectedItem.innerHTML = selectElement.options[selectElement.selectedIndex].innerHTML;
        $this.append(selectedItem);
        return selectedItem;
    };

    $.fn.CustomDropDown.createOptions = function ($this, selectedItem) {
        /* For each element, create a new DIV that will contain the option list: */
        var itemsDiv = document.createElement('DIV'),
            selectElement = $.fn.CustomDropDown.getSelectElement($this);
        itemsDiv.setAttribute('class', 'select-items select-hide');
        for (var j = 0; j < selectElement.length; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */

            var label = selectElement.options[j].innerHTML,
                value = selectElement.options[j].getAttribute('value'),
                optionObject = selectElement.options[j],
                optionItem = $.fn.CustomDropDown.renderOption(optionObject);
            itemsDiv.appendChild(optionItem);
        }

        var $customParentOptions = $.fn.CustomDropDown.checkCustomParentOptions($this);
        if ($customParentOptions) {
            $customParentOptions.append(itemsDiv);
        } else {
            $this.append(itemsDiv);
        }

        selectedItem.addEventListener('click', function(e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            $.fn.CustomDropDown.closeAllSelect(this);
            var $itemsElement = $.fn.CustomDropDown.getItemsElement($this);
            $itemsElement.toggleClass('select-hide');
            var $that = $itemsElement.parents('.CustomParentOptions');
            $itemsElement.parents('.CustomParentOptions').slideToggle(400, function(){
                $that.toggleClass('CustomDropDown-show');
            });
            // this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    };

    $.fn.CustomDropDown.closeAllSelect = function (elmnt) {
        /* A function that will close all select boxes in the document,
        except the current select box: */
        var x, y, i, arrNo = [];
        x = document.getElementsByClassName('select-items');
        y = document.getElementsByClassName('select-selected');
        for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove('select-arrow-active');
            }
        }
        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add('select-hide');
                if ($(x[i]).parents('.CustomParentOptions.CustomDropDown').length > 0) {
                    var $that = $(x[i]).parents('.CustomParentOptions.CustomDropDown');
                    $(x[i]).parents('.CustomParentOptions.CustomDropDown').slideUp(400, function(){
                        $that.removeClass('CustomDropDown-show');
                    });
                }
            }
        }
    };

    $.fn.CustomDropDown.createCustomDropDown = function ($this) {
        var selectedItem = $.fn.CustomDropDown.createSelectedItem($this);
        $.fn.CustomDropDown.createOptions($this, selectedItem);
        /* If the user clicks anywhere outside the select box, then close all select boxes: */
        document.addEventListener('click', $.fn.CustomDropDown.closeAllSelect);
    };

    $.fn.CustomDropDown.defaultOptions = {
        onChange: function (data) {},
        onChanged: function (data) {},
        onRendered: function (data) {},
        parentOptions: null,
        renderOption: null
    };

    $.fn.CustomDropDown.options = null;

}(jQuery));
