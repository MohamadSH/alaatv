var MultiLevelSearch = function () {

    let selectorItems = [];
    let selectorId = '';

    function getSelectorItems(MultiLevelSearchSelectorId) {
        selectorId = MultiLevelSearchSelectorId;
        selectorItems = $('#' + selectorId + ' .selectorItem');
        return selectorItems;
    }

    function showSelectorItem(selectorIndex) {

        let selectorItem = getSelectorItem(selectorIndex);

        if (selectorItem.length === 0) {
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


        // $.when(selectorItems.fadeOut(0)).done(function() {
        //     selectorItem.fadeIn();
        // });

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
            let select2Id = 'MultiLevelSearch-select2-'+selectorId+'-'+selectorIndex;

            if (selectorItem.find('.selectorItemTitle').length > 0) {
                selectorItem.find('.selectorItemTitle').html(title);
            } else {
                selectorItem.prepend('<div class="col-12 selectorItemTitle">' + title + '</div>');
            }

            for (let index in selectorSubitems) {
                if(!isNaN(index)) {
                    select2Html += '<option value="' + selectorSubitems + '">' + selectorSubitems[index].innerHTML + '</option>';
                }
            }
            if (selectorItem.find('.form-control.select2').length > 0) {
                let oldSelect2 = $('#' + select2Id);
                if(!oldSelect2.data('select2')) {
                    oldSelect2.select2('destroy');
                }
                selectorItem.find('.select2warper').remove();
                selectorItem.append('<div class="col-12 col-sm-9 col-md-5 col-lg-4 select2warper"><select class="form-control select2" id="' + select2Id + '">' + select2Html + '</select></div>');
                $('#' + select2Id).select2({ width: 'resolve' });
                selectorItem.fadeIn();
            } else {
                selectorItem.append('<div class="col-12 col-sm-9 col-md-5 col-lg-4 select2warper"><select class="form-control select2" id="' + select2Id + '">' + select2Html + '</select></div>');
                $('#' + select2Id).select2({ width: 'resolve' });
                selectorItem.fadeIn();
            }
        }

        refreshNavbar(selectorIndex);
    }

    function refreshNavbar(selectorIndex) {
        let filterNavigationWarper = $('#' + selectorId + ' .filterNavigationWarper');
        filterNavigationWarper.html('');
        selectorItems.each(function() {
            let title = $(this).data('select-title');
            let order = $(this).data('select-order');
            let activeString = 'deactive';
            if (parseInt(order) < parseInt(selectorIndex)) {
                activeString = 'active';
            } else if (parseInt(order) === parseInt(selectorIndex)) {
                activeString = 'current';
            }

            filterNavigationWarper.append('<div class="col ' + activeString + ' filterNavigationStep" data-select-order="' + order + '"><div class="filterStepText">' + title + '</div></div>');
        });
    }

    function getSelectorItem(selectorIndex) {
        return $('#' + selectorId + ' .selectorItem[data-select-order="'  + selectorIndex +  '"]');
    }

    function getSelectorSubitems(selectorIndex) {
        return $('#' + selectorId + ' .selectorItem[data-select-order="'  + selectorIndex +  '"] .subItem');
    }

    function onChangeFilter(changedItem, initOptions) {
        let selectorOrder = $(changedItem).parents('.selectorItem').data('select-order');
        if (
            typeof (initOptions.selector) !== 'undefined' &&
            typeof (initOptions.selector[selectorOrder]) !== 'undefined' &&
            typeof (initOptions.selector[selectorOrder].ajax) !== 'undefined' &&
            initOptions.selector[selectorOrder].ajax !== null) {
            // ajax load ...
        } else {
            if(getMaxOrder()>=(parseInt(selectorOrder)+1)) {
                setActiveStep(parseInt(selectorOrder)+1);
            }
            showSelectorItem(parseInt(selectorOrder)+1);
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
                setActiveStep(selectorOrder);
                showSelectorItem(parseInt(selectorOrder));
            }
        }
    }

    function getMaxOrder() {
        let maxOrder = 0;
        for (let index in selectorItems) {
            if(!isNaN(index)) {
                let order = parseInt($(selectorItems[index]).data('select-order'));
                if (maxOrder < order) {
                    maxOrder = order;
                }
            }
        }
        return maxOrder;
    }

    function getActiveStepOrder() {
        return parseInt($('#' + selectorId + ' .selectorItem[data-select-active="true"]').data('select-order'));
    }

    function setActiveStep(selectorIndex) {
        $('#' + selectorId + ' .selectorItem').attr('data-select-active', 'false');
        getSelectorItem(selectorIndex).attr('data-select-active', 'true');
    }

    return {
        init: function (initOptions) {
            let multiSelector = $('#' + initOptions.selectorId);
            multiSelector.fadeOut(0);
            getSelectorItems(initOptions.selectorId);
            showSelectorItem('0');
            $(document).on('click', '#' + initOptions.selectorId + ' .selectorItem .subItem', function () {
                onChangeFilter(this, initOptions);
            });
            $(document).on('change', '#' + initOptions.selectorId + ' .selectorItem .select2', function () {
                onChangeFilter(this, initOptions);
            });
            $(document).on('click', '#' + initOptions.selectorId + ' .filterStepText', function () {
                let selectorOrder = $(this).parents('.filterNavigationStep').data('select-order');
                onFilterNavCliked(selectorOrder, initOptions);
            });
            multiSelector.fadeIn();
        },
    };
}();


jQuery(document).ready(function() {
    MultiLevelSearch.init({
        selectorId: 'contentSearchFilter'
    });
});