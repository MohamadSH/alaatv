$(document).ready(function () {
    GAEE.checkoutOption(2, 'Payment Method: '+gtmEecPaymentMethod+((paymentStatus)?' (successful)':' (unsuccessful)'));
    if (paymentStatus) {
        GAEE.purchase(gtmEec.actionField, gtmEec.products);
    }
    if (GAEE.reportGtmEecOnConsole()) {
        console.log('checkout-payment-BankType: ', {actionField: gtmEec.actionField, products: gtmEec.products});
    }
});