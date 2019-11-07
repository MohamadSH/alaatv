function arabicToPersianWithEnNumber(inputString) {
    if (typeof inputString === 'undefined' || inputString === null || inputString.length === 0) {
        return '';
    }
    inputString = persianJs(inputString).arabicChar().toEnglishNumber().toString();
    inputString = inputString.split(' ').join('_');
    return inputString;
}

jQuery(document).ready(function() {

    $(document).on('click', '.SearchBoxFilter .GroupFilters .body .showMoreItems', function () {
        if ($(this).data('moretype') === 'more') {
            $(this).parents('.m-checkbox-list').css({"max-height": "", "height": "auto", "padding-bottom":"20px"});
            $(this).data('more', $(this).data('more'));
            $(this).data('moretype', 'less');
            $(this).html('نمایش کمتر...');
        } else {
            $(this).parents('.m-checkbox-list').css({"max-height": (($(this).data('more')*29.5)+20)+"px", "padding-bottom":"20px"});
            $(this).data('moretype', 'more');
            $(this).html('نمایش بیشتر...');
        }
    });

    $(document).on('click', '.SearchBoxFilter .GroupFilters .head', function () {
        if($(this).parents('.GroupFilters').hasClass('status-close')) {
            $(this).parents('.GroupFilters').removeClass('status-close').addClass('status-open');
        } else {
            $(this).parents('.GroupFilters').removeClass('status-open').addClass('status-close');
        }
    });
    $(document).on('keyup', '.SearchBoxFilter .GroupFilters .body .tools input.GroupFilters-Search', function () {
        var items = $(this).parents('.body').find('.GroupFilters-item'),
            itemsLength = items.length,
            seacrText = $(this).val();
        seacrText = seacrText.trim();
        if (seacrText.length === 0) {
            $(this).parents('.body').find('.GroupFilters-item').fadeIn(0);
            return false;
        }
        seacrText = arabicToPersianWithEnNumber(seacrText);

        // console.log('$(this).parents(\'.body\')', $(this).parents('.body'));

        for (var i = 0; i < itemsLength; i++) {
            if (arabicToPersianWithEnNumber(items[i].innerText).includes(seacrText)) {
                $(items[i]).fadeIn(0);
            } else {
                $(items[i]).fadeOut(0);
            }
        }
    });
});