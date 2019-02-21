var ProductSwitch = function () {

    function changeChildCheckStatus(parentId, status) {
        let items = $("input[name='products[]'].product.hasParent_"+parentId);
        for (let index in items) {
            if(!isNaN(index)) {
                let hasChildren = $(items[index]).hasClass('hasChildren');
                let defaultValue = items[index].defaultValue;
                $(items[index]).prop('checked', status);
                if (hasChildren) {
                    changeChildCheckStatus(defaultValue, status);
                }
            }
        }
    }

    function singleUpdateSelectedProductsStatus() {

        let items = $("input[name='products[]'].product");
        for (let index in items) {
            if(!isNaN(index)) {
                let hasChildren = $(items[index]).hasClass('hasChildren');
                let thisValue = items[index].defaultValue;
                let report1 = {
                    'allChildIsChecked': true,
                    'allChildIsNotChecked': true,
                    'counter': 0
                };
                let report = checkChildProduct(thisValue, report1);
                if(hasChildren) {
                    if(report.allChildIsChecked) {
                        $(items[index]).prop('checked', true);
                    } else {
                        $(items[index]).prop('checked', false);
                    }
                }
            }
        }
    }

    function checkChildProduct(parentId, report) {
        let items = $("input[name='products[]'].product.hasParent_"+parentId);
        report.counter++;
        for (let index in items) {
            if(!isNaN(index)) {
                let defaultValue = items[index].defaultValue;
                let thisCheckBox = $("input[name='products[]'][value='" + defaultValue + "'].product");
                let hasChildren = thisCheckBox.hasClass('hasChildren');
                let thisExist = thisCheckBox.length;
                let thisIsChecked = thisCheckBox.prop('checked');
                if (thisExist > 0 && thisIsChecked !== true) {
                    report.allChildIsChecked = false;
                }
                if (thisIsChecked === true) {
                    report.allChildIsNotChecked = false;
                }
                if (hasChildren) {
                    report = checkChildProduct(defaultValue, report);
                } else {
                    report.allChildIsNotChecked = false;
                }
            }
        }
        return report;
    }

    function getChildLevel() {
        if (typeof $("input[name='products[]'].product")[0] === "undefined") {
            return 1;
        }
        let firstDefaultValue = $("input[name='products[]'].product")[0].defaultValue;
        let report1 = {
            'allChildIsChecked': true,
            'allChildIsNotChecked': true,
            'counter': 0
        };
        let report = checkChildProduct(firstDefaultValue, report1);
        return report.counter;
    }

    function updateSelectedProductsStatus(childLevel, callback) {
        for (let i=0; i<childLevel; i++) {
            singleUpdateSelectedProductsStatus();
        }
        callback();
    }

    return {
        init:function () {
            return getChildLevel();
        },
        updateSelectedProductsStatus: function (childLevel, callback) {
            updateSelectedProductsStatus(childLevel, callback);
        },
        changeChildCheckStatus: function (parentId, status) {
            changeChildCheckStatus(parentId, status);
        }
    };
}();

jQuery(document).ready(function() {

    let childLevel = ProductSwitch.init();

    let callBack = function () {
        let productsState = getProductSelectValues();
        refreshPrice([], productsState, []);
    };

    $(document).on('change', "input[name='products[]'].product", function() {
        let thisValue = this.defaultValue;
        let hasChildren = $(this).hasClass('hasChildren');
        if(hasChildren) {
            ProductSwitch.changeChildCheckStatus(thisValue, $(this).prop('checked'));
        }
        ProductSwitch.updateSelectedProductsStatus(childLevel,callBack );
    });
});