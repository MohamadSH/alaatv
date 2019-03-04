var UserOrder = function () {

    let orders = null;

    function getOrderByKey() {

    }


    return {
        refreshUi:function () {

        },
    };
}();

$(document).ready(function () {

    for (let index in orders) {

        console.log('order'+index+': ' + orders[index]);
    }

    $(document).on('click', '.btnViewOrderDetailes', function (e) {
        let index = $(this).data('order-key');
        $('.orderDetailes-orderStatus').html(orders[index].orderstatus.displayName);
        $('.orderDetailes-paymentStatus').html(orders[index].paymentstatus.displayName);
        $('.orderDetailes-price').html(orders[index].price.toLocaleString('fa') + ' تومان ');
        $('.orderDetailes-paidPrice').html(orders[index].paidPrice.toLocaleString('fa') + ' تومان ');
        $('.orderDetailes-completed_at').html(new persianDate(Date.parse(orders[index].completed_at)).format("dddd, DD MMMM YYYY"));

        $('.orderDetailes-orderPostingInfo').html((typeof orders[index].orderPostingInfo[0]!=='undefined')?orders[index].orderPostingInfo[0].postCode:'پست نشده');
        $('.orderDetailes-debt').html(orders[index].debt.toLocaleString('fa') + ' تومان ');
        $('.orderDetailes-couponInfo').html(orders[index].price.toLocaleString('fa') + ' تومان ');

        $('#orderDetailesModal').modal('show');
    });
});