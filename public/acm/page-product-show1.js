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
        let productsState = UesrCart.getProductSelectValues();
        UesrCart.refreshPrice([], productsState, []);
    };

    $(document).on('change', "input[name='products[]'].product", function() {
        let thisValue = this.defaultValue;
        let hasChildren = $(this).hasClass('hasChildren');
        if(hasChildren) {
            ProductSwitch.changeChildCheckStatus(thisValue, $(this).prop('checked'));
        }
        ProductSwitch.updateSelectedProductsStatus(childLevel,callBack );
    });

    $(document).on('click', '.btnAddToCart', function () {

        if ($(this).attr('disabled')) {
            return false;
        }

        UesrCart.disableBtnAddToCart();
        var product = $("input[name=product_id]").val();
        let mainAttributeStates = UesrCart.getMainAttributeStates();
        let extraAttributeStates = UesrCart.getExtraAttributeStates();
        let productSelectValues = UesrCart.getProductSelectValues() ;

        if ($('#js-var-userId').val()) {

            $.ajax({
                type: 'POST',
                url: '/orderproduct',
                data: {
                    product_id: product,
                    products: productSelectValues,
                    attribute: mainAttributeStates,
                    extraAttribute: extraAttributeStates
                },
                statusCode: {
                    //The status for when action was successful
                    200: function (response) {
                        // console.log(response);

                        $.notify('محصول مورد نظر به سبد خرید اضافه شد.', {
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: false,
                            mouse_over: false,
                            showProgressbar: false,
                            spacing: 10,
                            timer: 2000,
                            placement: {
                                from: 'top',
                                align: 'center'
                            },
                            offset: {
                                x: 30,
                                y: 30
                            },
                            delay: 1000,
                            z_index: 10000,
                            animate: {
                                enter: "animated flip",
                                exit: "animated hinge"
                            }
                        });

                        setTimeout(function () {
                            window.location.replace('/checkout/review');
                        }, 1000);

                    },
                    //The status for when the user is not authorized for making the request
                    403: function (response) {
                        // window.location.replace("/403");
                    },
                    //The status for when the user is not authorized for making the request
                    401: function (response) {
                        // window.location.replace("/403");
                    },
                    404: function (response) {
                        // window.location.replace("/404");
                    },
                    //The status for when form data is not valid
                    422: function (response) {
                        console.log(response);
                    },
                    //The status for when there is error php code
                    500: function (response) {
                        Swal({
                            title: 'توجه!',
                            text: 'خطای سیستمی رخ داده است.',
                            type: 'danger',
                            confirmButtonText: 'بستن'
                        });
                        UesrCart.enableBtnAddToCart();
                    },
                    //The status for when there is error php code
                    503: function (response) {
                        Swal({
                            title: 'توجه!',
                            text: 'خطای پایگاه داده!',
                            type: 'danger',
                            confirmButtonText: 'بستن'
                        });
                        UesrCart.enableBtnAddToCart();
                    }
                }
            });

        } else {

            let data = {
                'product_id': $('input[name="product_id"][type="hidden"]').val(),
                'attribute': mainAttributeStates,
                'extraAttribute': extraAttributeStates,
                'products': productSelectValues,
            };

            UesrCart.addToCartInCookie(data);

            setTimeout(function () {
                window.location.replace('/checkout/review');
            }, 2000);
        }

    });

    $(document).on("ifChanged change", ".attribute", function ()
    {
        var attributeState = UesrCart.getMainAttributeStates();
        UesrCart.refreshPrice(attributeState , [] ,[]);
    });

    $(document).on("ifChanged change", ".extraAttribute", function ()
    {
        var attributeState = UesrCart.getExtraAttributeStates();
        UesrCart.refreshPrice([] , [] , attributeState);
    });

    $(document).on("ifChanged switchChange.bootstrapSwitch", ".product", function ()
    {
        var productsState = UesrCart.getProductSelectValues() ;
        UesrCart.refreshPrice([] , productsState , []);
    });
});

var totalExtraCost = 0 ;
var bonDiscount = 0 ;
var productDiscount = 0 ;
/*
var productShortDescription = "";
var productLongDescription = "";
*/
