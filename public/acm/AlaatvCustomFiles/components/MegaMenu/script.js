var AlaaMegaMenu = function () {

    function getSubCategoryObject($categoryTarget) {
        var $parentCategoryObject = getParentCategoryObject($categoryTarget);
        return $parentCategoryObject.find('.a--MegaMenu-subCategoryItemsCol .a--MegaMenu-categorySubItems[data-cat-id="'+$categoryTarget.attr('dtat-cat-id')+'"]');
    }
    function getParentCategoryObject($categoryTarget) {
        return $categoryTarget.parents('.a--MegaMenu-dropDownRow');
    }

    function showCategory($categoryTarget) {
        hideAllCategory($categoryTarget);
        $categoryTarget.addClass('a--MegaMenu-categoryItem-selected');
        showCategorySubItems(getSubCategoryObject($categoryTarget));
    }
    function hideCategory($categoryTarget) {
        $categoryTarget.removeClass('a--MegaMenu-categoryItem-selected');
        hideCategorySubItems($categoryTarget);
    }
    function hideAllCategory() {
        $('.a--MegaMenu-categoryItem').removeClass('a--MegaMenu-categoryItem-selected');
        hideCategorySubItems();
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

    return {
        showCategory: function ($categoryTarget) {
            showCategory($categoryTarget)
        },
        hideCategory: function ($categoryTarget) {
            hideCategory($categoryTarget)
        },
        hideAllCategory: function () {
            hideAllCategory()
        },
        getSelectedTags: function () {
            return getSelectedTags();
        },
        refreshPageTagsBadge: function () {
            refreshPageTagsBadge();
        },
        getNewDataBaseOnTags: function (contentSearchFilterData) {
            getNewDataBaseOnTags(contentSearchFilterData);
        }
    };
}();



$(document).ready(function () {

    AlaaMegaMenu.hideAllCategory();

    const categoryItems = document.getElementsByClassName('a--MegaMenu-categoryItem');
    let categoryItemsLength = categoryItems.length;

    for (let i = 0; i < categoryItemsLength; i++) {
        var categoryItem = categoryItems[i];

        if (i === 0) {
            AlaaMegaMenu.showCategory($(categoryItem));
        }

        // mouseover - mousedown - mouseleave - mouseup
        categoryItem.addEventListener('mouseover', (e) => {
            AlaaMegaMenu.showCategory($(e.target));
        });
        categoryItem.addEventListener('mouseleave', () => {
            // console.log('mouseleave');
        });
        categoryItem.addEventListener('mouseup', () => {
            // console.log('mouseup');
        });
    }
});