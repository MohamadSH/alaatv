var InitPage = function() {
    var ordersData;

    function addEvents() {
        $(document).on('click', '.btnViewOrderDetailes', function (e) {
            let index = $(this).data('order-key');
            $('.orderDetailes-orderStatus').html(ordersData[index].orderstatus.displayName);
            $('.orderDetailes-paymentStatus').html(ordersData[index].paymentstatus.displayName);
            $('.orderDetailes-price').html(ordersData[index].price.toLocaleString('fa') + ' تومان ');
            $('.orderDetailes-paidPrice').html(ordersData[index].paidPrice.toLocaleString('fa') + ' تومان ');
            $('.orderDetailes-completed_at').html(new persianDate(Date.parse(ordersData[index].completed_at)).format("dddd, DD MMMM YYYY"));

            if (typeof ordersData[index].orderPostingInfo[0] !== 'undefined') {
                $('#postedProductCodeReportWraper').fadeIn();
                $('.orderDetailes-orderPostingInfo').html(ordersData[index].orderPostingInfo[0].postCode);
            } else {
                $('.orderDetailes-orderPostingInfo').html('پست نشده');
                $('#postedProductCodeReportWraper').fadeOut();
            }

            $('.orderDetailes-debt').html(ordersData[index].debt.toLocaleString('fa') + ' تومان ');

            let hideAllDiscountInfo = true;
            let couponMessage = 'کپن ندارد';
            $('.orderDiscountInfoInModal tbody').find('.orderDetailes-couponInfo').remove();
            if (ordersData[index].couponInfo !== null) {
                couponMessage = ordersData[index].couponInfo.name + ' با ' + ordersData[index].couponInfo.discount;
                if (ordersData[index].couponInfo.typeHint === 'percentage') {
                    couponMessage += '%';
                } else /*if (ordersData[index].couponInfo.typeHint === 'percentage')*/ {
                    couponMessage += ' تومان ';
                }
                couponMessage += ' تخفیف ';
                let orderDetailes_couponInfo = '\n' +
                    '<tr class="orderDetailes-couponInfo">\n' +
                    '    <td>کپن استفاده شده:</td>\n' +
                    '    <td>'+couponMessage+'</td>\n' +
                    '</tr>';
                $('.orderDiscountInfoInModal tbody').append(orderDetailes_couponInfo);
                hideAllDiscountInfo = false;
            }
            $('.orderDiscountInfoInModal tbody').find('.orderDetailes-usedBonSum').remove();
            if (ordersData[index].usedBonSum > 0) {
                let orderDetailes_usedBonSum = '\n' +
                    '<tr class="orderDetailes-usedBonSum">\n' +
                    '    <td>تعداد بن استفاده شده:</td>\n' +
                    '    <td>'+ordersData[index].usedBonSum+'</td>\n' +
                    '</tr>';
                $('.orderDiscountInfoInModal tbody').append(orderDetailes_usedBonSum);
                hideAllDiscountInfo = false;
            }
            $('.orderDiscountInfoInModal tbody').find('.orderDetailes-addedBonSum').remove();
            if (ordersData[index].addedBonSum > 0) {
                let orderDetailes_addedBonSum = '\n' +
                    '<tr class="orderDetailes-addedBonSum">\n' +
                    '    <td>تعداد بن اضافه شده به شما از این سفارش: </td>\n' +
                    '    <td>'+ordersData[index].addedBonSum+'</td>\n' +
                    '</tr>';
                $('.orderDiscountInfoInModal tbody').append(orderDetailes_addedBonSum);
                hideAllDiscountInfo = false;
            }

            $('.orderDiscountInfoInModal tbody').find('.orderDetailes-totalOrderDiscount').remove();
            if (ordersData[index].discount > 0) {
                let orderDetailes_totalOrderDiscount = '\n' +
                    '<tr class="orderDetailes-totalOrderDiscount">\n' +
                    '    <td>تخفیف کلی سفارش: </td>\n' +
                    '    <td>'+ordersData[index].discount.toLocaleString('fa') + ' تومان '+'</td>\n' +
                    '</tr>';
                $('.orderDiscountInfoInModal tbody').append(orderDetailes_totalOrderDiscount);
                hideAllDiscountInfo = false;
            }

            $('#orderDetailesModal .customerDescriptionInModal').fadeOut();
            $('#orderDetailesModal .customerDescriptionInModal').html('');
            if (
                ordersData[index].customerDescription !== null &&
                ordersData[index].customerDescription.length > 0
            ) {
                $('#orderDetailesModal .customerDescriptionInModal').html(ordersData[index].customerDescription);
                $('#orderDetailesModal .customerDescriptionInModal').fadeIn();
            }


            if (hideAllDiscountInfo) {
                $('.orderDiscountInfoInModal').parent('.alert-success').fadeOut();
            } else {
                $('.orderDiscountInfoInModal').parent('.alert-success').fadeIn();
            }

            $('.orderDetailes-created_at').html(new persianDate(Date.parse(ordersData[index].created_at)).format("dddd, DD MMMM YYYY"));


            let productHtml = '';
            for (let opIndex in ordersData[index].orderproducts) {
                let opItem = ordersData[index].orderproducts[opIndex];
                let atvHtml = '';
                for (let atvIndex in opItem.attributevalues) {
                    let atvItem = opItem.attributevalues[atvIndex];
                    atvHtml += '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded">' + atvItem.name + '</span>';
                }

                let price = '<span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">';
                if (opItem.price.final !== opItem.price.base) {
                    price += '<span class="m-badge m-badge--warning a--productRealPrice">' + opItem.price.base.toLocaleString('fa') + '</span>';
                }
                price += opItem.price.final.toLocaleString('fa') + ' تومان ';
                let percent = Math.round((1 - (opItem.price.final / opItem.price.base)) * 100);
                if (percent > 0) {
                    let percent = Math.round((1 - (opItem.price.final / opItem.price.base)) * 100);
                    price += '<span class="m-badge m-badge--info a--productDiscount">' + percent + '%</span>';
                }
                let gift = '';
                if(opItem.orderproducttype.name === 'gift') {
                    gift = '<span class="m-badge m-badge--success m-badge--wide m--margin-left-10">هدیه</span>';
                }
                price += '</span>';
                productHtml += '\n' +
                    '<div class="m-widget3__item">\n' +
                    '    <div class="m-widget3__header">\n' +
                    '        <div class="m-widget3__user-img">\n' +
                    '            <a class="m-link" href="'+opItem.product.url+'" target="_blank">' +
                    '                <img class="m-widget3__img" src="' + opItem.product.photo + '" alt="">\n' +
                    '            </a>' +
                    '        </div>\n' +
                    '        <div class="m-widget3__info">\n' +
                    '            <span class="m-widget3__username">\n' +
                    '                <a class="m-link" href="'+opItem.product.url+'" target="_blank">' +
                    '                    ' + opItem.product.name + gift + '\n' +
                    '                </a>' +
                    '            </span>\n' +
                    '            <br>\n' +
                    '            <span class="m-widget3__time">\n' +
                    '                ' + atvHtml + '\n' +
                    '            </span>\n' +
                    '        </div>\n' +
                    '        <span class="orderProductItemPrice">\n' +
                    '            ' + price + '\n' +
                    '        </span>\n' +
                    '    </div>\n' +
                    '    <div class="m-widget3__body">\n' +
                    '        <p class="m-widget3__text">\n' +
                    '        </p>\n' +
                    '    </div>\n' +
                    '</div>';
            }
            if (productHtml.trim().length > 0) {
                $('.orderDetailes-orderprouctList').html(productHtml);
                $('.orderDetailes-totalProductPortlet').fadeIn();
            } else {
                $('.orderDetailes-totalProductPortlet').fadeOut();
            }


            let successfulTransactionsHtml = '';
            for (let stIndex in ordersData[index].successfulTransactions) {
                let successfulTransactionItem = ordersData[index].successfulTransactions[stIndex];
                let refCode = getRefCode(successfulTransactionItem);
                let completed_at = new persianDate(Date.parse(successfulTransactionItem.completed_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

                let amount = Math.abs(successfulTransactionItem.cost).toLocaleString('fa') + ' تومان ';
                if (successfulTransactionItem.cost < 0) {
                    amount += '<span class="m-badge m-badge--wide m-badge--metal">بازگشت هزینه</span>';
                }
                let transactionType = '';
                if (successfulTransactionItem.transactiongateway !== null) {
                    transactionType = successfulTransactionItem.paymentmethod.description + '(' + successfulTransactionItem.transactiongateway.displayName + ')';
                } else {
                    transactionType = successfulTransactionItem.paymentmethod.description;
                }
                successfulTransactionsHtml +=
                    '<tr>\n' +
                    '    <td>' + amount + '</td>\n' +
                    '    <td>' + transactionType + '</td>\n' +
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
            for (let ptIndex in ordersData[index].pending_transactions) {
                let pendingTransactionItem = ordersData[index].pending_transactions[ptIndex];
                let refCode = getRefCode(pendingTransactionItem);
                let created_at = new persianDate(Date.parse(pendingTransactionItem.created_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

                let amount = Math.abs(pendingTransactionItem.cost).toLocaleString('fa') + ' تومان ';
                if (pendingTransactionItem.cost < 0) {
                    amount += '<span class="m-badge m-badge--wide m-badge--metal">بازگشت هزینه</span>';
                }
                pendingTransactionsHtml +=
                    '<tr>\n' +
                    '    <td>' + amount + '</td>\n' +
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
            for (let unptIndex in ordersData[index].unpaid_transactions) {
                let unpaidTransactionItem = ordersData[index].unpaid_transactions[unptIndex];
                let created_at = new persianDate(Date.parse(unpaidTransactionItem.created_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");
                let deadline_at = new persianDate(Date.parse(unpaidTransactionItem.deadline_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

                let amount = Math.abs(unpaidTransactionItem.cost).toLocaleString('fa') + ' تومان ';
                if (unpaidTransactionItem.cost < 0) {
                    amount += '<span class="m-badge m-badge--wide m-badge--metal">بازگشت هزینه</span>';
                }
                unpaidTransactionsHtml +=
                    '<tr>\n' +
                    '    <td>' + amount + '</td>\n' +
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

            if (transactionId === '-') {
                $('#onlinePaymentModal input[type="hidden"][name="order_id"]').prop("disabled", false);
                $('#onlinePaymentModal input[type="hidden"][name="transaction_id"]').prop("disabled", true);
            } else {
                $('#onlinePaymentModal input[type="hidden"][name="transaction_id"]').prop("disabled", false);
                $('#onlinePaymentModal input[type="hidden"][name="order_id"]').prop("disabled", true);
            }

            $('#onlinePaymentModal').modal('show');
        });

        $(document).on('change', 'select[name="paymentMethod"]', function () {
            $('#onlinePaymentModalForm').attr('action', $(this).val());
        });
    }

    function getRefCode(transactionItem) {
        let refCode = '';
        // if (transactionItem.paymentmethod.name === 'paycheck') {
        //     refCode = 'شماره چک: ' + transactionItem.paycheckNumber;
        // } else if (transactionItem.paymentmethod.name === 'wallet') {
        //     refCode = '';
        // } else if (transactionItem.paymentmethod.name === 'POS') {
        //     refCode = ' شماره مرجع: ' + transactionItem.referenceNumber;
        // } else if (transactionItem.paymentmethod.name === 'ATM') {
        //     refCode = ' شماره پیگیری: ' + transactionItem.traceNumber;
        // } else if (transactionItem.paymentmethod.name === 'online') {
        //     refCode = ' شماره تراکنش: ' + transactionItem.transactionID;
        // }

        if (transactionItem.paycheckNumber !== null && transactionItem.paycheckNumber.length > 0) {
            refCode = transactionItem.paycheckNumber;
        } else if (transactionItem.referenceNumber !== null && transactionItem.referenceNumber.length > 0) {
            refCode = transactionItem.referenceNumber;
        } else if (transactionItem.traceNumber !== null && transactionItem.traceNumber.length > 0) {
            refCode = transactionItem.traceNumber;
        } else if (transactionItem.transactionID !== null && transactionItem.transactionID.length > 0) {
            refCode = transactionItem.transactionID;
        } else {
            refCode = '';
        }


        return refCode;
    }

    function init(orders) {
        ordersData = (typeof orders.data !== 'undefined') ? orders.data : [];
        addEvents();
    }

    return {
        init: init
    };
}();

$(document).ready(function () {
    InitPage.init(orders);
});
