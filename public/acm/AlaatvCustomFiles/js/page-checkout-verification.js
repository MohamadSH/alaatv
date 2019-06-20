$(document).ready(function () {
    if (paymentStatus) {
        GAEE.purchase(gtmEec.actionField, gtmEec.products);
    }
});