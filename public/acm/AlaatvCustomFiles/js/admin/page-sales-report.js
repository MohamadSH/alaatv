$(document).ready(function () {

    CustomInit.persianDatepicker('#dateFilterCreatedSince', '#dateFilterCreatedSinceAlt', false);
    CustomInit.persianDatepicker('#dateFilterCreatedTill', '#dateFilterCreatedTillAlt', false);

    $('.reportOfFilter').fadeOut();
    $('.report1').html('');
    $('.report2').html('');

    $(document).on('click', '.btnFilter', function () {


        $('.reportOfFilter').fadeOut();
        $('.report1').html('');
        $('.report2').html('');

        mApp.block('.btnFilter', {
            type: "loader",
            state: "success",
        });

        var dateFilterEnable = 0;
        if($('#dateFilterCreatedTimeEnable').is(':checked')){
            dateFilterEnable = 1;
        }

        var checkoutEnable = 0;
        if($('#checkoutEnable').is(':checked')){
            checkoutEnable = 1;
        }

        $.ajax({
            url: ajaxActionUrl,
            type: 'GET',
            data: {
                product_id: $('#productId').val(),
                since: $('#dateFilterCreatedSinceAlt').val(),
                till: $('#dateFilterCreatedTillAlt').val(),
                dateFilterEnable: dateFilterEnable,
                checkoutEnable : checkoutEnable,
            },
            dataType: 'json',
            success: function (data) {
                if (data.totalNumber != null && data.totalNumber != undefined) {

                    $('.reportOfFilter').fadeIn();
                    $('.report1').html('تعداد کل: ' + data.totalNumber);
                    $('.report2').html('فروش کل(تومان): ' + data.totalSale);

                    if(data.checkoutResult == null || data.checkoutResult== undefined )
                    {
                        $('.report3').html('وضعیت تسویه نامشخص');
                    }
                    else if(data.checkoutResult)
                    {
                        $('.report3').html('تسویه با موفقیت انجام شد');
                    }else{
                        $('.report3').html('تسویه ای انجام نشد');
                    }

                } else {

                    toastr.error('خطای سیستمی رخ داده است.');
                }
                mApp.unblock('.btnFilter');
            },
            error: function (jqXHR, textStatus, errorThrown) {

                let message = '';
                if (jqXHR.responseJSON.message === 'The given data was invalid.') {
                    message = getErrorMessage(jqXHR.responseJSON.errors);
                } else {
                    message = 'خطای سیستمی رخ داده است.';
                }

                toastr.warning(message);

                mApp.unblock('.btnFilter');
            }
        });



    });

    $(document).on('click', '#dateFilterCreatedTimeEnable', function(){
        if($('#dateFilterCreatedTimeEnable').is(':checked'))
        {
            $('#dateFilterCreatedSince').prop('disabled', false);
            $('#dateFilterCreatedTill').prop('disabled', false);
        }else{
            $('#dateFilterCreatedSince').prop('disabled', true);
            $('#dateFilterCreatedTill').prop('disabled', true);
        }
    });
});
