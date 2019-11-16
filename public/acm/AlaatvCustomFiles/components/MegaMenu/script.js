var AlaaMegaMenu = function () {

    function getSubCategoryObject($categoryTarget) {
        return getMegaMenuTitleObject($categoryTarget).find('.a--MegaMenu-subCategoryItemsCol .a--MegaMenu-categorySubItems[data-cat-id="'+$categoryTarget.attr('dtat-cat-id')+'"]');
    }
    function getMegaMenuTitleObject($hoverTarget) {
        return $hoverTarget.parents('.a--MegaMenu-title');
    }

    function showCategory($categoryTarget) {
        hideAllCategory($categoryTarget);
        $categoryTarget.addClass('a--MegaMenu-categoryItem-selected');
        showCategorySubItems(getSubCategoryObject($categoryTarget));
    }
    function hideCategory($categoryTarget) {
        $categoryTarget.removeClass('a--MegaMenu-categoryItem-selected');
        hideCategorySubItems(getSubCategoryObject($categoryTarget));
    }
    function hideAllCategory($categoryTarget) {
        getMegaMenuTitleObject($categoryTarget).find('.a--MegaMenu-categoryItem').removeClass('a--MegaMenu-categoryItem-selected');
        getMegaMenuTitleObject($categoryTarget).find('.a--MegaMenu-categorySubItems').each(function() {
            hideCategorySubItems($(this));
        });
    }

    function showCategorySubItems($target) {
        $target.removeClass('a--MegaMenu-categorySubItems-hidden').addClass('a--MegaMenu-categorySubItems-show');
    }
    function hideCategorySubItems($target) {
        if (typeof $target === 'undefined') {
            $('.a--MegaMenu .a--MegaMenu-dropDownRow .a--MegaMenu-subCategoryItemsCol .a--MegaMenu-categorySubItems').removeClass('a--MegaMenu-categorySubItems-show').addClass('a--MegaMenu-categorySubItems-hidden');
        } else {
            $target.removeClass('a--MegaMenu-categorySubItems-show').addClass('a--MegaMenu-categorySubItems-hidden');
        }
    }

    function closeAllDropDownMenus() {
        $('.a--MegaMenu-title').removeClass('a--MegaMenu-title-hover');
    }
    function showDropDownMenu($hoverTarget) {
        closeAllDropDownMenus();
        getMegaMenuTitleObject($hoverTarget).addClass('a--MegaMenu-title-hover');
    }

    return {
        showCategory: function ($categoryTarget) {
            showCategory($categoryTarget)
        },
        hideCategory: function ($categoryTarget) {
            hideCategory($categoryTarget)
        },
        showDropDownMenu: function ($hoverTarget) {
            showDropDownMenu($hoverTarget);
        },
        closeAllDropDownMenus: function () {
            closeAllDropDownMenus();
        }
    };
}();



$(document).ready(function () {

    const titleItems = document.getElementsByClassName('a--MegaMenu-title');
    const categoryItems = document.getElementsByClassName('a--MegaMenu-categoryItem');
    let titleItemsLength = titleItems.length,
        categoryItemsLength = categoryItems.length;

    for (let i = 0; i < titleItemsLength; i++) {
        var titleItem = titleItems[i];

        // mouseover - mousedown - mouseleave - mouseup
        titleItem.addEventListener('mouseover', (e) => {
            AlaaMegaMenu.showDropDownMenu($(e.target));
        });
        titleItem.addEventListener('mouseleave', (e) => {
            AlaaMegaMenu.closeAllDropDownMenus();
        });
    }

    for (let i = 0; i < categoryItemsLength; i++) {
        var categoryItem = categoryItems[i];

        if ($(categoryItem).is(':first-child')) {
            AlaaMegaMenu.showCategory($(categoryItem));
        } else {
            AlaaMegaMenu.hideCategory($(categoryItem));
        }

        // mouseover - mousedown - mouseleave - mouseup
        categoryItem.addEventListener('mouseover', (e) => {
            AlaaMegaMenu.showCategory($(e.target));
        });
    }
});