var MultiLevelSearch = function () {

    var selectorItems = [];
    var selectorId = '';

    function getSelectorItems(MultiLevelSearchSelectorId) {
        selectorId = MultiLevelSearchSelectorId;
        selectorItems = $('#' + selectorId + ' .selectorItem');
        return selectorItems;
    }

    function getSelectorItem(selectorIndex) {
        return $('#' + selectorId + ' .selectorItem[data-select-order="' + selectorIndex + '"]');
    }

    function getSelectorSubitems(selectorIndex) {
        return $('#' + selectorId + ' .selectorItem[data-select-order="' + selectorIndex + '"] .subItem');
    }

    function showSelectorItem(selectorIndex) {

        var selectorItem = getSelectorItem(selectorIndex);

        if (selectorItem.length === 0) {
            refreshNavbar(selectorIndex);
            return false;
        }

        selectorItems.fadeOut(0);

        var title = selectorItem.data('select-title');
        var showType = selectorItem.data('select-display');
        if (typeof showType === 'undefined') {
            if (getSelectorSubitems(selectorIndex).length > 10) {
                showType = 'select2';
            } else {
                showType = 'grid';
            }
            selectorItem.attr('data-select-display', showType);
        }

        if (showType === 'grid') {
            if (selectorItem.find('.selectorItemTitle').length > 0) {
                selectorItem.find('.selectorItemTitle').html(title);
            } else {
                selectorItem.prepend('<div class="col-12 selectorItemTitle">' + title + '</div>');
            }
            if (selectorItem.length > 0) {
                selectorItem.fadeIn();
            }
        } else if (showType === 'select2') {
            var selectorSubitems = getSelectorSubitems(selectorIndex);
            selectorSubitems.fadeOut(0);

            var select2Html = '';
            var select2Id = 'MultiLevelSearch-select2-' + selectorId + '-' + selectorIndex;

            if (selectorItem.find('.selectorItemTitle').length > 0) {
                selectorItem.find('.selectorItemTitle').html(title);
            } else {
                selectorItem.prepend('<div class="col-12 selectorItemTitle">' + title + '</div>');
            }

            for (var index in selectorSubitems) {
                if (!isNaN(index)) {
                    var selected = '';
                    if ($(selectorSubitems[index]).attr('selected') === 'selected') {
                        selected = 'selected="selected"';
                    }
                    select2Html += '<option value="' + selectorSubitems[index].innerHTML + '" '+selected+'>' + selectorSubitems[index].innerHTML + '</option>';
                }
            }
            if (selectorItem.find('.form-control.select2').length > 0) {
                var oldSelect2 = $('#' + select2Id);
                if (!oldSelect2.data('select2')) {
                    oldSelect2.select2('destroy');
                }
                selectorItem.find('.select2warper').remove();
                selectorItem.append('<div class="col-12 col-sm-9 col-md-7 col-lg-6 select2warper"><div><select class="form-control select2" id="' + select2Id + '">' + select2Html + '</select></div></div>');
                $('#' + select2Id)
                    .select2({closeOnSelect: true})
                    .on('select2:select', function (event) {
                        $('.a--multi-level-search select').select2("close");
                    })
                    .on('select2:close', function (event) {
                        $('.a--multi-level-search select').select2('destroy');
                        $('.a--multi-level-search select').select2({closeOnSelect: true});
                        $('.a--multi-level-search select').select2("close");
                        $('.a--multi-level-search select').select2("close");
                    });
                selectorItem.fadeIn();
            } else {
                selectorItem.append('<div class="col-12 col-sm-9 col-md-7 col-lg-6 select2warper"><div><select class="form-control select2" id="' + select2Id + '">' + select2Html + '</select></div></div>');
                $('#' + select2Id)
                    .select2({closeOnSelect: true})
                    .on('select2:select', function (event) {
                        $('.a--multi-level-search select').select2('destroy');
                        $('.a--multi-level-search select').select2({closeOnSelect: true});
                        $('.a--multi-level-search select').select2("close");
                        $('.a--multi-level-search select').select2("close");
                    })
                    .on('select2:close', function (event) {
                        $('.a--multi-level-search select').select2('destroy');
                        $('.a--multi-level-search select').select2({closeOnSelect: true});
                        $('.a--multi-level-search select').select2("close");
                        $('.a--multi-level-search select').select2("close");
                    });
                selectorItem.fadeIn();
            }
        }
        refreshNavbar(selectorIndex);
    }

    function setValueOfSelector(selectorIndex, value) {
        getSelectorItem(selectorIndex).attr('data-select-value', value);
    }

    function getValueOfSelector(selectorIndex) {
        var value = getSelectorItem(selectorIndex).attr('data-select-value');
        return (typeof value !== 'undefined') ? value : null;
    }

    function getActiveStepOrder() {
        if ($('#' + selectorId + ' .selectorItem[data-select-active="true"]').length > 0) {
            return parseInt($('#' + selectorId + ' .selectorItem[data-select-active="true"]').data('select-order'));
        } else {
            return 0;
        }
    }

    function setActiveStep(selectorIndex) {
        $('#' + selectorId + ' .selectorItem').attr('data-select-active', 'false');
        getSelectorItem(selectorIndex).attr('data-select-active', 'true');
    }

    function getMaxOrder() {
        var maxOrder = 0;
        for (var index in selectorItems) {
            if (!isNaN(index)) {
                var order = parseInt($(selectorItems[index]).data('select-order'));
                if (maxOrder < order) {
                    maxOrder = order;
                }
            }
        }
        return maxOrder;
    }

    function refreshNavbar(selectorIndex) {
        var filterNavigationWarper = $('#' + selectorId + ' .filterNavigationWarper');
        filterNavigationWarper.html('');

        selectorItems = $('#' + selectorId + ' .selectorItem');
        for (var index in selectorItems) {
            if (!isNaN(index)) {

                var title = $(selectorItems[index]).data('select-title');
                var order = $(selectorItems[index]).data('select-order');
                var activeString = 'deactive';
                if (parseInt(order) < parseInt(selectorIndex)) {
                    activeString = 'active';
                } else if (parseInt(order) === parseInt(selectorIndex)) {
                    activeString = 'current';
                } else {
                    setValueOfSelector(order, '');
                }

                var selectedText = '';
                if (activeString === 'deactive') {
                    $(selectorItems[index]).attr('data-select-value', '');
                }
                selectedText = getValueOfSelector(order);

                if (selectedText === null || selectedText.trim().length === 0) {
                    selectedText = title;
                }

                if (activeString === 'current') {
                    selectedText = '(' + 'انتخاب ' + title + ')';
                }

                filterNavigationWarper.append('<li class="filterNavigationStep ' + activeString + '" data-select-order="' + order + '">' + selectedText + '</li>');
            }
        }
    }

    function refreshNavbar1(selectorIndex) {
        var filterNavigationWarper = $('#' + selectorId + ' .filterNavigationWarper');
        filterNavigationWarper.html('');

        selectorItems = $('#' + selectorId + ' .selectorItem');
        for (var index in selectorItems) {
            if (!isNaN(index)) {

                var title = $(selectorItems[index]).data('select-title');
                var order = $(selectorItems[index]).data('select-order');
                var activeString = 'deactive';
                if (parseInt(order) < parseInt(selectorIndex)) {
                    activeString = 'active';
                } else if (parseInt(order) === parseInt(selectorIndex)) {
                    activeString = 'current';
                } else {
                    setValueOfSelector(order, '');
                }

                var selectedText = '';
                if (activeString === 'deactive') {
                    $(selectorItems[index]).attr('data-select-value', '');
                }
                selectedText = getValueOfSelector(order);

                // filterNavigationWarper.append('<div class="col ' + activeString + ' filterNavigationStep" data-select-order="' + order + '"><div class="filterStepText">' + title + '</div><div class="filterStepSelectedText">'+selectedText+'</div></div>');

                if (selectedText === null || selectedText.trim().length === 0) {
                    selectedText = '(' + title + ')';
                }
                filterNavigationWarper.append('<div class="col ' + activeString + ' filterNavigationStep" data-select-order="' + order + '"><div class="filterStepText">' + selectedText + '</div></div>');
            }
        }
    }

    function onChangeFilter(selectorOrder, initOptions) {
        if (
            typeof (initOptions.selector) !== 'undefined' &&
            typeof (initOptions.selector[selectorOrder]) !== 'undefined' &&
            typeof (initOptions.selector[selectorOrder].ajax) !== 'undefined' &&
            initOptions.selector[selectorOrder].ajax !== null) {
            // ajax load ...
        } else {
            showSelectorItem(parseInt(selectorOrder) + 1);
            if (getMaxOrder() >= (parseInt(selectorOrder) + 1)) {
                setActiveStep(parseInt(selectorOrder) + 1);
            }
        }
    }

    function onFilterNavCliked(selectorOrder, initOptions) {
        if (
            typeof (initOptions.selector) !== 'undefined' &&
            typeof (initOptions.selector[selectorOrder]) !== 'undefined' &&
            typeof (initOptions.selector[selectorOrder].ajax) !== 'undefined' &&
            initOptions.selector[selectorOrder].ajax !== null) {
            // ajax load ...
        } else {
            if (selectorOrder < getActiveStepOrder()) {
                showSelectorItem(parseInt(selectorOrder));
                setActiveStep(selectorOrder);
            }
        }
    }

    function getSelectedData() {
        var data = [];
        selectorItems = $('#' + selectorId + ' .selectorItem');
        for (var index in selectorItems) {
            if (isNaN(index)) {
                continue;
            }
            var selectorItem = selectorItems[index];
            var title = $(selectorItem).data('select-title');
            var order = $(selectorItem).data('select-order');
            var selectValue = $(selectorItem).attr('data-select-value');
            var selectActive = $(selectorItem).attr('data-select-active');
            var selectedText = '';
            if(
                typeof selectValue !== 'undefined' &&
                typeof selectActive !== 'undefined' &&
                (
                    selectActive !== 'true' ||
                    getMaxOrder() === order
                )
            ) {
                selectedText = selectValue;
            }

            data.push({
                title: title,
                order: order,
                selectedText: selectedText
            });
        }
        return data;
    }

    return {
        init: function (initOptions, onChangeCallback, beforeChangeFilterCallback) {
            var multiSelector = $('#' + initOptions.selectorId);
            multiSelector.fadeOut(0);
            getSelectorItems(initOptions.selectorId);
            showSelectorItem(getActiveStepOrder());
            $(document).on('click', '#' + initOptions.selectorId + ' .selectorItem .subItem', function () {
                var parent = $(this).parents('.selectorItem');
                var selectorOrder = parent.data('select-order');
                parent.attr('data-select-value', $(this).html());
                var data = {
                    selectorOrder: selectorOrder,
                    selectorType: 'grid'
                };
                beforeChangeFilterCallback(data);
                onChangeFilter(selectorOrder, initOptions);
                onChangeCallback(data);
            });
            $(document).on('change', '#' + initOptions.selectorId + ' .selectorItem .select2', function () {
                var parent = $(this).parents('.selectorItem');
                var selectorOrder = parent.data('select-order');
                parent.attr('data-select-value', $(this).select2('data')[0].text.trim());
                // parent.attr('data-select-value', $(this).find(':selected').text.trim());
                var data = {
                    selectorOrder: selectorOrder,
                    selectorType: 'select2'
                };
                beforeChangeFilterCallback(data);
                onChangeFilter(selectorOrder, initOptions);
                onChangeCallback(data);
            });
            $(document).on('click', '#' + initOptions.selectorId + ' .filterNavigationStep', function () {
                // var selectorOrder = $(this).parents('.filterNavigationStep').data('select-order');
                var selectorOrder = $(this).data('select-order');
                onFilterNavCliked(selectorOrder, initOptions);
                onChangeCallback('click on filterNavigationStep');
            });
            multiSelector.fadeIn();
        },
        getSelectedData: function () {
            return getSelectedData();
        }
    };
}();