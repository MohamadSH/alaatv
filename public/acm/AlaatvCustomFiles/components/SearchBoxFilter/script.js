function arabicToPersianWithEnNumber(inputString) {
    inputString = persianJs(inputString).arabicChar().toEnglishNumber().toString();
    inputString = inputString.split(' ').join('_');
    return inputString;
}

jQuery(document).ready(function() {
    $(document).on('click', '.SearchBoxFilter .GroupFilters .head', function () {
        console.log('clicked:', $(this).parents('.GroupFilters'));
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
        for (var i = 0; i < itemsLength; i++) {
            if (arabicToPersianWithEnNumber(items[i].innerText).includes(seacrText)) {
                $(items[i]).fadeIn(0);
            } else {
                $(items[i]).fadeOut(0);
            }
        }
        // console.log();

    });
});