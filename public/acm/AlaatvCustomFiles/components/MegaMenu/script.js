var AlaaMegaMenu = function () {

    function getCategoryIdFromchildElements($element) {
        if (typeof $element.attr('data-cat-id') === 'undefined' || $element.attr('data-cat-id').length === 0) {
            return $element.parents('.a--MegaMenu-categorySubItems').attr('data-cat-id')
        }
        return $element.attr('data-cat-id')
    }

    function getSubCategoryObject($categoryTarget) {
        var catId = getCategoryIdFromchildElements($categoryTarget);
        return getMegaMenuTitleObject($categoryTarget).find('.a--MegaMenu-subCategoryItemsCol .a--MegaMenu-categorySubItems[data-cat-id="'+catId+'"]');
    }
    function getMegaMenuTitleObject($hoverTarget) {
        return $hoverTarget.parents('.a--MegaMenu-title');
    }

    function showCategory($categoryTarget) {
        hideAllCategory($categoryTarget);
        $categoryTarget.addClass('a--MegaMenu-categoryItem-selected');
        showCategorySubItems(getSubCategoryObject($categoryTarget));
        // refreshPointerForCategoryItem();
    }
    function hideCategory($categoryTarget) {
        $categoryTarget.removeClass('a--MegaMenu-categoryItem-selected');
        hideCategorySubItems(getSubCategoryObject($categoryTarget));
    }
    function hideAllCategory($categoryTarget) {
        getMegaMenuTitleObject($categoryTarget).find('.a--MegaMenu-categoryItem').removeClass('a--MegaMenu-categoryItem-selected');
        getMegaMenuTitleObject($categoryTarget).find('.a--MegaMenu-categoryItem a').removeClass('a--MegaMenu-categoryItem-selected');
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
        // refreshPointerForCategoryItem();
    }

    function addHoverEvent() {
        const titleItems = document.getElementsByClassName('a--MegaMenu-title');
        const categoryItems = document.getElementsByClassName('a--MegaMenu-categoryItem');
        addTitleHoverEvent(titleItems);
        addCategoryItemsHoverEvent(categoryItems);
    }

    function addTitleHoverEvent(titleItems) {
        var titleItemsLength = titleItems.length;
        for (let i = 0; i < titleItemsLength; i++) {
            var titleItem = titleItems[i];

            // mouseover - mousedown - mouseleave - mouseup
            titleItem.addEventListener('mouseover', function(e) {
                showDropDownMenu($(e.target));
            });
            titleItem.addEventListener('mouseleave', function(e) {
                closeAllDropDownMenus();
            });
        }
    }

    function addCategoryItemsHoverEvent(categoryItems) {
        var categoryItemsLength = categoryItems.length;

        for (let i = 0; i < categoryItemsLength; i++) {
            var categoryItem = categoryItems[i];

            if ($(categoryItem).is(':first-child')) {
                showCategory($(categoryItem));
            } else {
                hideCategory($(categoryItem));
            }

            // mouseover - mousedown - mouseleave - mouseup
            categoryItem.addEventListener('mouseover', function(e) {
                showCategory($(e.target));
            });
        }
    }

    //
    // function refreshPointerForCategoryItem() {
    //     $('.a--MegaMenu-dropDownRow .a--MegaMenu-categoryItemsCol .a--MegaMenu-categoryItem .a--MegaMenu-categoryItem-pointer').remove();
    //     addPointerForCategoryItem();
    // }
    // function addPointerForCategoryItem() {
    //     $('.a--MegaMenu-dropDownRow').each(function () {
    //         var $this = $(this),
    //             maxHeight = getMaxHeightOfMegaMenu($this);
    //         // console.log('MegaMenu: ', $this);
    //         // console.log('maxHeight: ', maxHeight);
    //         $this.find('.a--MegaMenu-categoryItemsCol .a--MegaMenu-categoryItem').each(function () {
    //             var pointerHeight = getPointerWidth(maxHeight),
    //                 catId = $(this).attr('data-cat-id');
    //             $(this).css({'height': maxHeight+'px'});
    //             $(this).append('<div class="a--MegaMenu-categoryItem-pointer" data-cat-id="'+catId+'" ></div>');
    //             $(this).find('.a--MegaMenu-categoryItem-pointer').css({
    //                 'height': pointerHeight+'px',
    //                 'width': pointerHeight+'px',
    //                 'top': getPointerTopPositionAfterRotate(pointerHeight)+'px',
    //                 'left': getPointerLeftPositionAfterRotate(pointerHeight)+'px'
    //             });
    //         });
    //     });
    // }
    // function getPointerTopPositionAfterRotate(pointerHeight) {
    //     return (pointerHeight * Math.pow(2, 0.5 - 1))/4;
    // }
    // function getPointerLeftPositionAfterRotate(pointerHeight) {
    //     return (-1*(pointerHeight/2));
    // }
    // function getPointerWidth(height) {
    //     return height/Math.pow(2, 0.5);
    // }
    // function prepareMegaMenuToGetHeight() {
    //     $('.a--MegaMenu-dropDownRow').css({'display': 'block', 'visibility': 'hidden'});
    // }
    // function backToNormalStateMegaMenuToGetHeight() {
    //     $('.a--MegaMenu-dropDownRow').css({'display': '', 'visibility': ''});
    // }
    // function getMaxHeightOfMegaMenu($megaMenuDropDownRow) {
    //     var maxHeight = 0,
    //         categoryItemArray = $megaMenuDropDownRow.find('.a--MegaMenu-categoryItemsCol .a--MegaMenu-categoryItem').toArray(),
    //         categoryItemArrayLength = categoryItemArray.length;
    //     for (var i = 0; i < categoryItemArrayLength; i++) {
    //         prepareMegaMenuToGetHeight();
    //         if (maxHeight < $(categoryItemArray[i]).height()) {
    //             maxHeight = $(categoryItemArray[i]).height();
    //         }
    //         if ($megaMenuDropDownRow.attr('id')=='123') {
    //             console.log('maxHeight: ', maxHeight);
    //         }
    //         backToNormalStateMegaMenuToGetHeight();
    //     }
    //     return maxHeight;
    // }

    return {
        init: function () {
            addHoverEvent();
        },
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
    AlaaMegaMenu.init()

});
