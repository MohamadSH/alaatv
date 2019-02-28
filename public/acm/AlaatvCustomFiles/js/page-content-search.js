var MultiLevelSearch = function () {

    let selectorItems = [];
    let selectorId = '';

    function getSelectorItems(MultiLevelSearchSelectorId) {
        selectorId = MultiLevelSearchSelectorId;
        selectorItems = $('#' + selectorId + ' .selectorItem');
        return selectorItems;
    }

    function getSelectorItem(selectorIndex) {
        return $('#' + selectorId + ' .selectorItem[data-select-order="'  + selectorIndex +  '"]');
    }

    function getSelectorSubitems(selectorIndex) {
        return $('#' + selectorId + ' .selectorItem[data-select-order="'  + selectorIndex +  '"] .subItem');
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

    function setValueOfSelector(selectorIndex, value) {
        getSelectorItem(selectorIndex).attr('data-select-value', value);
    }

    function getValueOfSelector(selectorIndex) {
        let value = getSelectorItem(selectorIndex).attr('data-select-value');
        return (typeof value !== 'undefined') ? value : null;
    }

    function getActiveStepOrder() {
        return parseInt($('#' + selectorId + ' .selectorItem[data-select-active="true"]').data('select-order'));
    }

    function setActiveStep(selectorIndex) {
        $('#' + selectorId + ' .selectorItem').attr('data-select-active', 'false');
        getSelectorItem(selectorIndex).attr('data-select-active', 'true');
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

    function refreshNavbar(selectorIndex) {
        let filterNavigationWarper = $('#' + selectorId + ' .filterNavigationWarper');
        filterNavigationWarper.html('');

        selectorItems = $('#' + selectorId + ' .selectorItem');
        for (let index in selectorItems) {
            if(!isNaN(index)) {

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
                    selectedText = '('+ 'انتخاب ' + title +')';
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
            if(!isNaN(index)) {

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
                    selectedText = '('+title+')';
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
            showSelectorItem(parseInt(selectorOrder)+1);
            if(getMaxOrder()>=(parseInt(selectorOrder)+1)) {
                setActiveStep(parseInt(selectorOrder)+1);
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
            if(!isNaN(index)) {
                let title = $(selectorItems[index]).data('select-title');
                let order = $(selectorItems[index]).data('select-order');
                let selectedText = (typeof ($(selectorItems[index]).attr('data-select-value'))!=='undefined') ? $(selectorItems[index]).attr('data-select-value') : null;
                data.push({
                    title: title,
                    order: order,
                    selectedText: selectedText
                });
            }
        }
        return data;
    }

    return {
        init: function (initOptions, onChangeCallback) {
            let multiSelector = $('#' + initOptions.selectorId);
            multiSelector.fadeOut(0);
            getSelectorItems(initOptions.selectorId);
            showSelectorItem(getActiveStepOrder());
            $(document).on('click', '#' + initOptions.selectorId + ' .selectorItem .subItem', function () {
                let parent = $(this).parents('.selectorItem');
                let selectorOrder = parent.data('select-order');
                parent.attr('data-select-value', $(this).html());
                onChangeFilter(selectorOrder, initOptions);
                onChangeCallback();
            });
            $(document).on('change', '#' + initOptions.selectorId + ' .selectorItem .select2', function () {
                let parent = $(this).parents('.selectorItem');
                let selectorOrder = parent.data('select-order');
                parent.attr('data-select-value', $(this).select2('data')[0].text.trim());
                // parent.attr('data-select-value', $(this).find(':selected').text.trim());
                onChangeFilter(selectorOrder, initOptions);
                onChangeCallback();
            });
            $(document).on('click', '#' + initOptions.selectorId + ' .filterNavigationStep', function () {
                // let selectorOrder = $(this).parents('.filterNavigationStep').data('select-order');
                let selectorOrder = $(this).data('select-order');
                onFilterNavCliked(selectorOrder, initOptions);
            });
            multiSelector.fadeIn();
        },
        getSelectedData: function() {
            return getSelectedData();
        }
    };
}();


jQuery(document).ready(function() {

    // function insertParam(key, value)
    // {
    //     key = encodeURI(key); value = encodeURI(value);
    //
    //     var kvp = document.location.search.substr(1).split('&');
    //
    //     var i=kvp.length; var x; while(i--)
    //     {
    //         x = kvp[i].split('=');
    //
    //         if (x[0]==key)
    //         {
    //             x[1] = value;
    //             kvp[i] = x.join('=');
    //             break;
    //         }
    //     }
    //
    //     if(i<0) {kvp[kvp.length] = [key,value].join('=');}
    //
    //     //this will reload the page, it's likely better to store this until finished
    //     document.location.search = kvp.join('&');
    // }

    MultiLevelSearch.init({
        selectorId: 'contentSearchFilter'
    }, function() {
        let searchFilterData = MultiLevelSearch.getSelectedData();

        let tagsValue = '';
        for (let index in searchFilterData) {
            // insertParam('tags[]', searchFilterData[index].selectedText);
            let selectedText = searchFilterData[index].selectedText;
            if (selectedText !== '') {
                tagsValue += '&tags[]=' + selectedText;
            }
        }
        if (tagsValue !== '') {
            tagsValue = tagsValue.substr(1);
        }

        let url = document.location.href.split('?')[0];

        url += '?'+tagsValue;

        // if(document.location.href.indexOf("?") === -1) {
        //     url += '?'+tagsValue;
        // }else{
        //     console.log(tagsValue);
        //     url += '&'+tagsValue;
        // }


        // history.pushState('data to be passed', 'Title of the page', url);
        // The above will add a new entry to the history so you can press Back button to go to the previous state.
        // To change the URL in place without adding a new entry to history use
        // history.replaceState('data to be passed', 'Title of the page', '');


        // console.log(MultiLevelSearch.getSelectedData());
        // console.log(tagsValue);
        // console.log(document.location.href);
        // insertParam('tags[]', 'ali')
    });
});