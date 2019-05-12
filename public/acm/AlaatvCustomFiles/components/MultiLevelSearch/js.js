var MultiLevelSearch = function () {

    let selectorItems = [];
    let selectorId = '';

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

        let selectorItem = getSelectorItem(selectorIndex);

        if (selectorItem.length === 0) {
            refreshNavbar(selectorIndex);
            return false;
        }

        selectorItems.fadeOut(0);

        let title = selectorItem.data('select-title');
        let showType = selectorItem.data('select-display');
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
            let selectorSubitems = getSelectorSubitems(selectorIndex);
            selectorSubitems.fadeOut(0);
            let select2Html = '';
            let select2Id = 'MultiLevelSearch-select2-' + selectorId + '-' + selectorIndex;

            if (selectorItem.find('.selectorItemTitle').length > 0) {
                selectorItem.find('.selectorItemTitle').html(title);
            } else {
                selectorItem.prepend('<div class="col-12 selectorItemTitle">' + title + '</div>');
            }

            for (let index in selectorSubitems) {
                if (!isNaN(index)) {
                    let selected = '';
                    if ($(selectorSubitems[index]).attr('selected') === 'selected') {
                        selected = 'selected="selected"';
                    }
                    select2Html += '<option value="' + selectorSubitems[index].innerHTML + '" '+selected+'>' + selectorSubitems[index].innerHTML + '</option>';
                }
            }
            if (selectorItem.find('.form-control.select2').length > 0) {
                let oldSelect2 = $('#' + select2Id);
                if (!oldSelect2.data('select2')) {
                    oldSelect2.select2('destroy');
                }
                selectorItem.find('.select2warper').remove();
                selectorItem.append('<div class="col-12 col-sm-9 col-md-5 col-lg-4 select2warper"><div><select class="form-control select2" id="' + select2Id + '">' + select2Html + '</select></div></div>');
                $('#' + select2Id)
                    .select2({closeOnSelect: true})
                    .on('select2:select', function (event) {
                        $('.a--multi-level-search select').select2("close");
                    })
                    .on('select2:close', function (event) {
                        $('.a--multi-level-search select').select2("close");
                    });
                selectorItem.fadeIn();
            } else {
                selectorItem.append('<div class="col-12 col-sm-9 col-md-5 col-lg-4 select2warper"><div><select class="form-control select2" id="' + select2Id + '">' + select2Html + '</select></div></div>');
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
        let value = getSelectorItem(selectorIndex).attr('data-select-value');
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
        let maxOrder = 0;
        for (let index in selectorItems) {
            if (!isNaN(index)) {
                let order = parseInt($(selectorItems[index]).data('select-order'));
                if (maxOrder < order) {
                    maxOrder = order;
                }
            }
        }
        return maxOrder;
    }

    function refreshNavbar(selectorIndex) {
        let filterNavigationWarper = $('#' + selectorId + ' .filterNavigationWarper');
        filterNavigationWarper.html('');

        selectorItems = $('#' + selectorId + ' .selectorItem');
        for (let index in selectorItems) {
            if (!isNaN(index)) {

                let title = $(selectorItems[index]).data('select-title');
                let order = $(selectorItems[index]).data('select-order');
                let activeString = 'deactive';
                if (parseInt(order) < parseInt(selectorIndex)) {
                    activeString = 'active';
                } else if (parseInt(order) === parseInt(selectorIndex)) {
                    activeString = 'current';
                } else {
                    setValueOfSelector(order, '');
                }

                let selectedText = '';
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
        let filterNavigationWarper = $('#' + selectorId + ' .filterNavigationWarper');
        filterNavigationWarper.html('');

        selectorItems = $('#' + selectorId + ' .selectorItem');
        for (let index in selectorItems) {
            if (!isNaN(index)) {

                let title = $(selectorItems[index]).data('select-title');
                let order = $(selectorItems[index]).data('select-order');
                let activeString = 'deactive';
                if (parseInt(order) < parseInt(selectorIndex)) {
                    activeString = 'active';
                } else if (parseInt(order) === parseInt(selectorIndex)) {
                    activeString = 'current';
                } else {
                    setValueOfSelector(order, '');
                }

                let selectedText = '';
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
        let data = [];
        selectorItems = $('#' + selectorId + ' .selectorItem');
        for (let index in selectorItems) {
            if (isNaN(index)) {
                continue;
            }
            let selectorItem = selectorItems[index];
            let title = $(selectorItem).data('select-title');
            let order = $(selectorItem).data('select-order');
            let selectValue = $(selectorItem).attr('data-select-value');
            let selectActive = $(selectorItem).attr('data-select-active');
            let selectedText = null;
            if(typeof selectValue !== 'undefined' && typeof selectActive !== 'undefined' && selectActive !== 'true') {
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
            let multiSelector = $('#' + initOptions.selectorId);
            multiSelector.fadeOut(0);
            getSelectorItems(initOptions.selectorId);
            showSelectorItem(getActiveStepOrder());
            $(document).on('click', '#' + initOptions.selectorId + ' .selectorItem .subItem', function () {
                let parent = $(this).parents('.selectorItem');
                let selectorOrder = parent.data('select-order');
                parent.attr('data-select-value', $(this).html());
                let data = {
                    selectorOrder: selectorOrder,
                    selectorType: 'grid'
                };
                beforeChangeFilterCallback(data);
                onChangeFilter(selectorOrder, initOptions);
                onChangeCallback(data);
            });
            $(document).on('change', '#' + initOptions.selectorId + ' .selectorItem .select2', function () {
                let parent = $(this).parents('.selectorItem');
                let selectorOrder = parent.data('select-order');
                parent.attr('data-select-value', $(this).select2('data')[0].text.trim());
                // parent.attr('data-select-value', $(this).find(':selected').text.trim());
                let data = {
                    selectorOrder: selectorOrder,
                    selectorType: 'select2'
                };
                beforeChangeFilterCallback(data);
                onChangeFilter(selectorOrder, initOptions);
                onChangeCallback(data);
            });
            $(document).on('click', '#' + initOptions.selectorId + ' .filterNavigationStep', function () {
                // let selectorOrder = $(this).parents('.filterNavigationStep').data('select-order');
                let selectorOrder = $(this).data('select-order');
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