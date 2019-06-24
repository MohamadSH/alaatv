var GAEE = function () {

    function getDataLayer() {
        window.dataLayer = window.dataLayer || [];
        return window.dataLayer;
    }

    function action_productDetailViews(actionFieldList, product) {
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
                        price : product.price,
                        brand : product.brand,//(String) The brand name of the product. Example: 'NIKE'
                        category : product.category, //(String) Product category of the item. Can have maximum five levels of hierarchy. Example: 'clothes/shirts/t-shirts'
                        variant : product.variant, //(String) What variant of the main product this is. Example: 'Large'
                        // dimensionN : product.dimensionN,//(String) A Product-scoped Custom Dimension for index number N. Example: 'Blue'
                        // metricN : product.metricN, //(Integer) A Product-scoped Custom Metric for index number N. Example: 3
                    }]
                }
            }
        });
    }

    function action_productAddToCart(actionFieldList, products) {
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

    function action_productRemoveFromCart(actionFieldList, product) {
        window.dataLayer.push({
            event: 'eec.remove',
            ecommerce: {
                remove: {
                    actionField: {
                        list: actionFieldList
                    },
                    products: [product]
                }
            }
        });
    }

    function action_checkout(step, option, products) {
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

    function action_checkoutOption(step, option) {
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

    function action_purchase(actionField, products) {
        window.dataLayer.push({
            event: 'eec.purchase',
            ecommerce: {
                //currencyCode: 'IRR',
                currencyCode: 'USD',
                purchase: {
                    actionField: actionField,
                    products: products
                }
            }
        });
    }

    function impression_view(impressions) {
        window.dataLayer.push({
            event: 'eec.impressionView',
            ecommerce: {
                impressions: impressions
            }
        });
    }

    function impression_click(actionFieldList, product) {
        window.dataLayer.push({
            event: 'eec.impressionClick',
            ecommerce: {
                click: {
                    actionField: {
                        list: actionFieldList
                    },
                    products: [product]
                }
            }
        });
    }

    function promotion_view(promotions) {
        window.dataLayer.push({
            event: 'eec.promotionView',
            ecommerce: {
                promoView: {
                    promotions: promotions
                }
            }
        });
    }

    function promotion_click(promotion) {
        window.dataLayer.push({
            event: 'eec.promotionClick',
            ecommerce: {
                promoClick: {
                    promotions: [promotion]
                }
            }
        });
    }

    return {

        reportGtmEecOnConsole: function () {
            return false;
        },

        productDetailViews: function (actionFieldList, product) {
            getDataLayer();
            action_productDetailViews(actionFieldList, product);
        },
        productAddToCart: function (actionFieldList, products) {
            getDataLayer();
            action_productAddToCart(actionFieldList, products);
        },
        productRemoveFromCart: function (actionFieldList, product) {
            getDataLayer();
            action_productRemoveFromCart(actionFieldList, product);
        },
        checkout: function (step, option, products) {
            getDataLayer();
            action_checkout(step, option, products);
        },
        checkoutOption: function (step, option) {
            getDataLayer();
            action_checkoutOption(step, option);
        },
        purchase: function (actionField, products) {
            getDataLayer();
            action_purchase(actionField, products);
        },

        impressionView: function (impressions) {
            getDataLayer();
            impression_view(impressions);
        },
        impressionClick: function (actionFieldList, product) {
            getDataLayer();
            impression_click(actionFieldList, product);
        },

        promotionView: function (promotions) {
            getDataLayer();
            promotion_view(promotions);
        },
        promotionClick: function (promotion) {
            getDataLayer();
            promotion_click(promotion);
        },


    };
}();