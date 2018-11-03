@if(isset($userPoints) && $userPoints)
    <div class="alert alert-block bg-dark bg-font-purple fade in">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading text-center" style="line-height: normal;">برای انصرف از قرعه کشی {{$lotteryName}} ، روی
            دکمه زیر کلیک کنید</h4>
        <h4 class="alert-heading text-center" style="line-height: normal;">در صورت انصراف
            مبلغ {{(isset($exchangeAmount))?number_format($exchangeAmount):""}} تومان اعتبار هدیه به رسم یاد بود به شما
            اهدا خواهد شد.</h4>
        <p style="text-align: center;">
            <button class="btn mt-sweetalert" data-title="آیا از انصراف خود مطمئنید؟" data-type="warning"
                    data-allow-outside-click="true" data-show-confirm-button="true" data-show-cancel-button="true"
                    data-cancel-button-class="btn-danger" data-cancel-button-text="خیر انصراف نمی دهم"
                    data-confirm-button-text="بله انصراف می دهم" data-confirm-button-class="btn-info"
                    style="background: #d6af18;">انصراف از قرعه کشی و دریافت مبلغ هدیه
            </button>
        </p>
    </div>
@elseif(isset($userLottery))
    @if(isset($prizeCollection))
        <div class="alert alert-block bg-blue bg-font-blue fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading text-center"
                style="line-height: normal;">{{$lotteryMessage}} {{($lotteryRank>0)?" جایزه شما:":""}}</h4>
            @foreach($prizeCollection as $prize )
                <h5 class="text-center bold" style="font-size: large">{{$prize["name"]}}</h5>
            @endforeach
            <h4 class="alert-heading text-center" style="line-height: normal;"> از طرف آلاء به شما تقدیم شده است. به
                امید موفقیت شما</h4>
        </div>
    @else
        <div class="alert alert-block bg-blue bg-font-blue fade in">
            <button type="button" class="close" data-dismiss="alert"></button>
            <h4 class="alert-heading text-center" style="line-height: normal;">{{$lotteryMessage}}</h4>

            <h4 class="alert-heading text-center" style="line-height: normal;">از شرکت شما در قرعه کشی سپاس گزاریم . با
                امید موفقیت شما.</h4>
        </div>
    @endif

@endif