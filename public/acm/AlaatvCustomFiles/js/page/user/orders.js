var InitPage = function() {
    var ordersData;

    function addEvents() {
        $(document).on('click', '.btnViewOrderDetailes', function (e) {
            var index = $(this).data('order-key');
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

            var hideAllDiscountInfo = true;
            var couponMessage = 'کپن ندارد';
            $('.orderDiscountInfoInModal tbody').find('.orderDetailes-couponInfo').remove();
            if (ordersData[index].couponInfo !== null) {
                couponMessage = ordersData[index].couponInfo.name + ' با ' + ordersData[index].couponInfo.discount;
                if (ordersData[index].couponInfo.typeHint === 'percentage') {
                    couponMessage += '%';
                } else /*if (ordersData[index].couponInfo.typeHint === 'percentage')*/ {
                    couponMessage += ' تومان ';
                }
                couponMessage += ' تخفیف ';
                var orderDetailes_couponInfo = '\n' +
                    '<tr class="orderDetailes-couponInfo">\n' +
                    '    <td>کپن استفاده شده:</td>\n' +
                    '    <td>'+couponMessage+'</td>\n' +
                    '</tr>';
                $('.orderDiscountInfoInModal tbody').append(orderDetailes_couponInfo);
                hideAllDiscountInfo = false;
            }
            $('.orderDiscountInfoInModal tbody').find('.orderDetailes-usedBonSum').remove();
            if (ordersData[index].usedBonSum > 0) {
                var orderDetailes_usedBonSum = '\n' +
                    '<tr class="orderDetailes-usedBonSum">\n' +
                    '    <td>تعداد بن استفاده شده:</td>\n' +
                    '    <td>'+ordersData[index].usedBonSum+'</td>\n' +
                    '</tr>';
                $('.orderDiscountInfoInModal tbody').append(orderDetailes_usedBonSum);
                hideAllDiscountInfo = false;
            }
            $('.orderDiscountInfoInModal tbody').find('.orderDetailes-addedBonSum').remove();
            if (ordersData[index].addedBonSum > 0) {
                var orderDetailes_addedBonSum = '\n' +
                    '<tr class="orderDetailes-addedBonSum">\n' +
                    '    <td>تعداد بن اضافه شده به شما از این سفارش: </td>\n' +
                    '    <td>'+ordersData[index].addedBonSum+'</td>\n' +
                    '</tr>';
                $('.orderDiscountInfoInModal tbody').append(orderDetailes_addedBonSum);
                hideAllDiscountInfo = false;
            }

            $('.orderDiscountInfoInModal tbody').find('.orderDetailes-totalOrderDiscount').remove();
            if (ordersData[index].discount > 0) {
                var orderDetailes_totalOrderDiscount = '\n' +
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


            var productHtml = '';
            for (var opIndex in ordersData[index].orderproducts) {
                var opItem = ordersData[index].orderproducts[opIndex];
                var atvHtml = '';
                for (var atvIndex in opItem.attributevalues) {
                    var atvItem = opItem.attributevalues[atvIndex];
                    atvHtml += '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded">' + atvItem.name + '</span>';
                }

                var price = '<span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">';
                if (opItem.price.final !== opItem.price.base) {
                    price += '<span class="m-badge m-badge--warning a--productRealPrice">' + opItem.price.base.toLocaleString('fa') + '</span>';
                }
                price += opItem.price.final.toLocaleString('fa') + ' تومان ';
                var percent = Math.round((1 - (opItem.price.final / opItem.price.base)) * 100);
                if (percent > 0) {
                    var percent = Math.round((1 - (opItem.price.final / opItem.price.base)) * 100);
                    price += '<span class="m-badge m-badge--info a--productDiscount">' + percent + '%</span>';
                }
                var gift = '';
                if(opItem.orderproducttype.name === 'gift') {
                    gift = '<span class="m-badge m-badge--success m-badge--wide m--margin-left-10">هدیه</span>';
                }
                price += '</span>';
                productHtml += Alist2.getItem({
                    link: opItem.product.url,
                    img: '<img class="img-thumbnail" src="' + opItem.product.photo + '" alt="">',
                    title: opItem.product.name + gift,
                    info: atvHtml,
                    desc: '',
                    action: price,
                });
            }
            if (productHtml.trim().length > 0) {
                $('.orderDetailes-orderprouctList').html(productHtml);
                $('.orderDetailes-totalProductPortlet').fadeIn();
            } else {
                $('.orderDetailes-totalProductPortlet').fadeOut();
            }


            var successfulTransactionsHtml = '';
            for (var stIndex in ordersData[index].successfulTransactions) {
                var successfulTransactionItem = ordersData[index].successfulTransactions[stIndex];
                var refCode = getRefCode(successfulTransactionItem);
                var completed_at = new persianDate(Date.parse(successfulTransactionItem.completed_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

                var amount = Math.abs(successfulTransactionItem.cost).toLocaleString('fa') + ' تومان ';
                if (successfulTransactionItem.cost < 0) {
                    amount += '<span class="m-badge m-badge--wide m-badge--metal">بازگشت هزینه</span>';
                }
                var transactionType = '';
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


            var pendingTransactionsHtml = '';
            for (var ptIndex in ordersData[index].pending_transactions) {
                var pendingTransactionItem = ordersData[index].pending_transactions[ptIndex];
                var refCode = getRefCode(pendingTransactionItem);
                var created_at = new persianDate(Date.parse(pendingTransactionItem.created_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

                var amount = Math.abs(pendingTransactionItem.cost).toLocaleString('fa') + ' تومان ';
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


            var unpaidTransactionsHtml = '';
            for (var unptIndex in ordersData[index].unpaid_transactions) {
                var unpaidTransactionItem = ordersData[index].unpaid_transactions[unptIndex];
                var created_at = new persianDate(Date.parse(unpaidTransactionItem.created_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");
                var deadline_at = new persianDate(Date.parse(unpaidTransactionItem.deadline_at)).format("dddd, DD MMMM YYYY, h:mm:ss a");

                var amount = Math.abs(unpaidTransactionItem.cost).toLocaleString('fa') + ' تومان ';
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
        var refCode = '';
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
