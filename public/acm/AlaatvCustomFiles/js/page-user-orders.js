var UserOrder = function () {

    let orders = null;

    function getOrderByKey() {

    }


    return {
        refreshUi: function () {

        },
    };
}();

$(document).ready(function () {

    function getRefCode(transactionItem) {
        let refCode = '';
        if (transactionItem.paymentmethod.name === 'paycheck') {
            refCode = 'شماره چک: ' + transactionItem.paycheckNumber;
        } else if (transactionItem.paymentmethod.name === 'wallet') {
            refCode = '';
        } else if (transactionItem.paymentmethod.name === 'POS') {
            refCode = ' شماره مرجع: ' + transactionItem.referenceNumber;
        } else if (transactionItem.paymentmethod.name === 'ATM') {
            refCode = ' شماره پیگیری: ' + transactionItem.traceNumber;
        } else if (transactionItem.paymentmethod.name === 'online') {
            refCode = ' شماره تراکنش: ' + transactionItem.transactionID;
        }
        return refCode;
    }

    $(document).on('click', '.btnViewOrderDetailes', function (e) {
        let index = $(this).data('order-key');
        $('.orderDetailes-orderStatus').html(orders[index].orderstatus.displayName);
        $('.orderDetailes-paymentStatus').html(orders[index].paymentstatus.displayName);
        $('.orderDetailes-price').html(orders[index].price.toLocaleString('fa') + ' تومان ');
        $('.orderDetailes-paidPrice').html(orders[index].paidPrice.toLocaleString('fa') + ' تومان ');
        $('.orderDetailes-completed_at').html(new persianDate(Date.parse(orders[index].completed_at)).format("dddd, DD MMMM YYYY"));

        $('.orderDetailes-orderPostingInfo').html((typeof orders[index].orderPostingInfo[0] !== 'undefined') ? orders[index].orderPostingInfo[0].postCode : 'پست نشده');
        $('.orderDetailes-debt').html(orders[index].debt.toLocaleString('fa') + ' تومان ');
        let couponMessage = 'کپن ندارد';
        if (orders[index].couponInfo !== null) {
            couponMessage = orders[index].couponInfo.name + ' با ' + orders[index].couponInfo.discount;
            if (orders[index].couponInfo.typeHint === 'percentage') {
                couponMessage += '%';
            } else /*if (orders[index].couponInfo.typeHint === 'percentage')*/ {
                couponMessage += ' تومان ';
            }
            couponMessage += ' تخفیف ';
        }
        $('.orderDetailes-couponInfo').html(couponMessage);
        $('.orderDetailes-usedBonSum').html(orders[index].usedBonSum);
        $('.orderDetailes-addedBonSum').html(orders[index].addedBonSum);

        $('.orderDetailes-created_at').html(new persianDate(Date.parse(orders[index].created_at)).format("dddd, DD MMMM YYYY"));


        let productHtml = '';
        for (let opIndex in orders[index].orderproducts) {
            let opItem = orders[index].orderproducts[opIndex];
            let atvHtml = '';
            for (let atvIndex in opItem.attributevalues) {
                let atvItem = opItem.attributevalues[atvIndex];
                atvHtml += '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded">' + atvItem.name + '</span>';
            }

            let price = '<span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">';
            if (opItem.price.final !== opItem.price.base) {
                let sum = opItem.price.final + opItem.price.extraCost;
                price += '<span class="m-badge m-badge--warning a--productRealPrice">' + sum.toLocaleString('fa') + '</span>';
            }
            let paidPride = opItem.price.final + opItem.price.extraCost;
            console.log('paidPride', paidPride);
            price += paidPride.toLocaleString('fa') + ' تومان ';
            if ((opItem.price.discountDetail.bonDiscount + opItem.price.discountDetail.productDiscount) > 0) {
                let percent = Math.round((1 - (opItem.price.final / opItem.price.base)) * 100);
                price += '<span class="m-badge m-badge--info a--productDiscount">' + percent + '%</span>';
            }
            price += '</span>';

            productHtml += '\n' +
                '                                                                    <div class="m-widget3__item">\n' +
                '                                                                        <div class="m-widget3__header">\n' +
                '                                                                            <div class="m-widget3__user-img">\n' +
                '                                                                                <img class="m-widget3__img" src="' + opItem.product.photo + '" alt="">\n' +
                '                                                                            </div>\n' +
                '                                                                            <div class="m-widget3__info">\n' +
                '                                                                                <span class="m-widget3__username">\n' +
                '                                                                                ' + opItem.product.name + '\n' +
                '                                                                                </span>\n' +
                '                                                                                <br>\n' +
                '                                                                                <span class="m-widget3__time">\n' +
                '                                                                                ' + atvHtml + '\n' +
                '                                                                                </span>\n' +
                '                                                                            </div>\n' +
                '                                                                            <span class="orderProductItemPrice">\n' +
                '                                                                                ' + price + '\n' +
                '                                                                            </span>\n' +
                '                                                                        </div>\n' +
                '                                                                        <div class="m-widget3__body">\n' +
                '                                                                            <p class="m-widget3__text">\n' +
                '                                                                            </p>\n' +
                '                                                                        </div>\n' +
                '                                                                    </div>';
        }
        if (productHtml.trim().length > 0) {
            $('.orderDetailes-orderprouctList').html(productHtml);
            $('.orderDetailes-totalProductPortlet').fadeIn();
        } else {
            $('.orderDetailes-totalProductPortlet').fadeOut();
        }


        let successfulTransactionsHtml = '';
        for (let stIndex in orders[index].successfulTransactions) {
            let successfulTransactionItem = orders[index].successfulTransactions[stIndex];
            let refCode = getRefCode(successfulTransactionItem);
            let completed_at = new persianDate(Date.parse(successfulTransactionItem.completed_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

            successfulTransactionsHtml +=
                '<tr>\n' +
                '    <td>' + successfulTransactionItem.cost.toLocaleString('fa') + ' تومان ' + '</td>\n' +
                '    <td>' + successfulTransactionItem.paymentmethod.description + '</td>\n' +
                '    <td>' + refCode + '</td>\n' +
                '    <td>' + completed_at + '</td>\n' +
                '</tr>';
        }
        if (successfulTransactionsHtml.trim().length > 0) {
            $('.orderDetailes-successfulTransactions').html(successfulTransactionsHtml);
            $('.orderDetailes-successfulTransactionsTable').fadeIn();
        } else {
            $('.orderDetailes-successfulTransactionsTable').fadeOut();
        }


        let pendingTransactionsHtml = '';
        for (let ptIndex in orders[index].pending_transactions) {
            let pendingTransactionItem = orders[index].pending_transactions[ptIndex];
            let refCode = getRefCode(pendingTransactionItem);
            let created_at = new persianDate(Date.parse(pendingTransactionItem.created_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

            pendingTransactionsHtml +=
                '<tr>\n' +
                '    <td>' + pendingTransactionItem.cost.toLocaleString('fa') + ' تومان ' + '</td>\n' +
                '    <td>' + pendingTransactionItem.paymentmethod.description + '</td>\n' +
                '    <td>' + refCode + '</td>\n' +
                '    <td>' + created_at + '</td>\n' +
                '</tr>';
        }
        if (pendingTransactionsHtml.trim().length > 0) {
            $('.orderDetailes-pending_transactions').html(pendingTransactionsHtml);
            $('.orderDetailes-pendingTransactionsTable').fadeIn();
        } else {
            $('.orderDetailes-pendingTransactionsTable').fadeOut();
        }


        let unpaidTransactionsHtml = '';
        for (let unptIndex in orders[index].unpaid_transactions) {
            let unpaidTransactionItem = orders[index].unpaid_transactions[unptIndex];
            let created_at = new persianDate(Date.parse(unpaidTransactionItem.created_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");
            let deadline_at = new persianDate(Date.parse(unpaidTransactionItem.deadline_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

            unpaidTransactionsHtml +=
                '<tr>\n' +
                '    <td>' + unpaidTransactionItem.cost.toLocaleString('fa') + ' تومان ' + '</td>\n' +
                '    <td>' + created_at + '</td>\n' +
                '    <td>' + deadline_at + '</td>\n' +
                '</tr>';
        }
        if (unpaidTransactionsHtml.trim().length > 0) {
            $('.orderDetailes-unpaid_transactions').html(unpaidTransactionsHtml);
            $('.orderDetailes-unpaidTransactionsTable').fadeIn();
        } else {
            $('.orderDetailes-unpaidTransactionsTable').fadeOut();
        }

        if (
            successfulTransactionsHtml.trim().length === 0 &&
            pendingTransactionsHtml.trim().length === 0 &&
            unpaidTransactionsHtml.trim().length === 0
        ) {
            $('.orderDetailes-totalTransactionsTable').fadeOut();
        } else {
            $('.orderDetailes-totalTransactionsTable').fadeIn();
        }


        $('#orderDetailesModal').modal('show');
    });


    $(document).on('click', '.btnOnlinePayment', function () {
        var orderId = $(this).data('order-id');
        var transactionId = $(this).data('transaction-id');
        var cost = $(this).data('cost');

        $('#onlinePaymentModal input[type="hidden"][name="order_id"]').val(orderId);
        $('#onlinePaymentModal input[type="hidden"][name="transaction_id"]').val(transactionId);
        $('#onlinePaymentModal .orderCostReport').html(' مبلغ قابل پرداخت: ' + cost.toLocaleString('fa') + ' تومان ');

        $('#onlinePaymentModal').modal('show');
        // if ($(this).attr('data-role')) {
        //     var transaction_id = $(this).data("role");
        //     $("input[name=transaction_id]").val(transaction_id).prop("disabled", false);
        //     $("#orderCost").text($("#instalmentCost_" + transaction_id).text()).number(true).prepend("مبلغ قابل پرداخت: ").append(" تومان");
        // } else {
        //     $("input[name=transaction_id]").prop("disabled", true);
        //     $("#orderCost").text($("#cost_" + order_id).text()).number(true).prepend("مبلغ قابل پرداخت: ").append(" تومان");
        // }
        // $("input[name=order_id]").val(order_id);
    });


});