var GAEE = function () {

    let reportGtmEecOnConsole = false;

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
        // sample impression object => {
        //     'name': 'Triblend Android T-Shirt',       // Name or ID is required.
        //     'id': '12345',
        //     'price': '15.25',
        //     'brand': 'Google',
        //     'category': 'Apparel',
        //     'variant': 'Gray',
        //     'list': 'Search Results',
        //     'position': 1
        // },

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
                    promotions: promotion
                }
            }
        });
    }

    function getElementData(element, data) {
        let elementData = element.data(data);
        if (typeof elementData !== 'undefined') {
            return elementData;
        }
        return 'undefined';
    }

    function getElementData_product(element) {
        let gtmEecImpressionView = [];
        gtmEecImpressionView.push({
            id:       getElementData(element, 'gtm-eec-product-id').toString(),
            name:     getElementData(element, 'gtm-eec-product-name').toString(),
            price:    getElementData(element, 'gtm-eec-product-price').toString(),
            brand:    getElementData(element, 'gtm-eec-product-brand').toString(),
            category: getElementData(element, 'gtm-eec-product-category').toString(),
            variant:  getElementData(element, 'gtm-eec-product-variant').toString(),
            list:     getElementData(element, 'gtm-eec-product-list').toString(),
            position: getElementData(element, 'gtm-eec-product-position'),
        });
        return gtmEecImpressionView;
    }

    function getElementData_advertisement(element) {
        let gtmEecPromotionView = [];
        gtmEecPromotionView.push({
            id: getElementData(element, 'gtm-eec-promotion-id').toString(),
            name: getElementData(element, 'gtm-eec-promotion-name').toString(),
            creative: getElementData(element, 'gtm-eec-promotion-creative').toString(),
            position: getElementData(element, 'gtm-eec-promotion-position')
        });
        return gtmEecPromotionView;
    }

    return {

        reportGtmEecOnConsole: function () {
            return reportGtmEecOnConsole;
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
        impressionViewSingleItem: function (element) {
            getDataLayer();
            let impressions = getElementData_product(element);
            impression_view(impressions);
            if (reportGtmEecOnConsole) {
                console.log('gtmEecImpressionView: ', impressions);
            }
        },
        impressionClick: function (element) {
            getDataLayer();
            let impressions = getElementData_product(element),
                actionFieldList = impressions[0].list;
            impression_click(actionFieldList, impressions);
            if (reportGtmEecOnConsole) {
                console.log('gtmEecImpressionClick: ', impressions);
            }
        },

        promotionView: function (promotions) {
            getDataLayer();
            promotion_view(promotions);
        },
        promotionViewSingleItem: function (element) {
            getDataLayer();
            let promotions = getElementData_advertisement(element);
            promotion_view(promotions);
            if (reportGtmEecOnConsole) {
                console.log('gtmEecPromotionView: ', promotions);
            }
        },
        promotionClick: function (element) {
            getDataLayer();
            let promotion = getElementData_advertisement(element);
            promotion_click(promotion);
            if (reportGtmEecOnConsole) {
                console.log('gtmEecPromotionClick: ', promotion);
            }
        },


    };
}();
