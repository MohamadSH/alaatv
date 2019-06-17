var GAEE = function () {

    function getDataLayer() {
        window.dataLayer = window.dataLayer || [];
        return window.dataLayer;
    }

    function productDetailViews(actionFieldList, product) {
        window.dataLayer.push({
            event: 'eec.detail',
            ecommerce: {
                detail: {
                    actionField: {
                        list: actionFieldList
                    },
                    products: [{
                        id : product.id,//(String) The SKU of the product. I recommend sending any variant IDs using a Product-scoped Custom Dimension. Example: 'P12345'
                        name : product.name,//(String) The name of the product. Any variant name can be sent with the variant key. Example: 'T-Shirt'
                        category : product.category, //(String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
                        variant : product.variant, //(String) What variant of the main product this is. Example: 'Large'
                        brand : 'آلاء',//(String) The brand name of the product. Example: 'NIKE'
                        // dimensionN : product.dimensionN,//(String) A Product-scoped Custom Dimension for index number N. Example: 'Blue'
                        // metricN : product.metricN, //(Integer) A Product-scoped Custom Metric for index number N. Example: 3
                    }]
                }
            }
        });
        //(String) ddddddddddddddddddddddddd Example: ddddddddddddddddddddddddd
    }

    function productAddToCart(actionFieldList, products) {
        window.dataLayer.push({
            event: 'eec.add',
            ecommerce: {
                add: {
                    actionField: {
                        list: actionFieldList
                    },
                    products: [products]
                }
            }
        });
    }

    function productRemoveFromCart(actionFieldList, products) {
        window.dataLayer.push({
            event: 'eec.remove',
            ecommerce: {
                remove: {
                    actionField: {
                        list: actionFieldList
                    },
                    products: [products]
                }
            }
        });
    }

    function checkout(step, option, products) {
        window.dataLayer.push({
            event: 'eec.checkout',
            ecommerce: {
                checkout: {
                    actionField: {
                        step: step,
                        option: option
                    },
                    products: products
                }
            }
        });
    }

    function checkoutOption(step, option) {
        window.dataLayer.push({
            event: 'eec.checkout_option',
            ecommerce: {
                checkout_option: {
                    actionField: {
                        step: step,
                        option: option
                    }
                }
            }
        });
    }

    function purchase(actionField, products) {
        window.dataLayer.push({
            event: 'eec.purchase',
            ecommerce: {
                currencyCode: 'IRR',
                purchase: {
                    actionField: actionField,
                    products: products
                }
            }
        });
    }

    return {
        productDetailViews: function (actionFieldList, product) {
            getDataLayer();
            productDetailViews(actionFieldList, product);
        },
        productAddToCart: function (actionFieldList, products) {
            getDataLayer();
            productAddToCart(actionFieldList, products);
        },
        productRemoveFromCart: function (actionFieldList, products) {
            getDataLayer();
            productRemoveFromCart(actionFieldList, products);
        },
        checkout: function (step, option, products) {
            getDataLayer();
            checkout(step, option, products);
        },
        checkoutOption: function (step, option) {
            getDataLayer();
            checkoutOption(step, option);
        },
        purchase: function (actionField, products) {
            getDataLayer();
            purchase(actionField, products);
        },


    };
}();