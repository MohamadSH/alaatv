<div class = "row">
    <div class = "col">
        <div class = "Step-warper">
            <div class = "row a--step-warper">
                <div class = "col a--step-item @if($step == 0) current @elseif($step < 0) notPassed @elseif($step > 0) passed @endif">
                    <div class = "a--step-item-icon">
                        <i class = "flaticon-lock"></i>
                    </div>
                    <div class = "a--step-item-text">
                        ورود
                    </div>
                </div>
                <div class = "col a--step-item @if($step == 1) current @elseif($step < 1) notPassed @elseif($step > 1) passed @endif">
                    <div class = "a--step-item-icon">
                        <i class = "flaticon-information"></i>
                    </div>
                    <div class = "a--step-item-text">
                        تکمیل اطلاعات
                    </div>
                </div>
                <div class = "col a--step-item @if($step == 2) current @elseif($step < 2) notPassed @elseif($step > 2) passed @endif" @if($step !== 2)onclick = "window.location.href = '{{ action("Web\OrderController@checkoutReview") }}';"
                        @endif>
                    <div class = "a--step-item-icon">
                        <i class = "fa fa-clipboard-check"></i>
                    </div>
                    <div class = "a--step-item-text">
                        بازبینی
                    </div>
                </div>
                <div class = "col a--step-item @if($step == 3) current @elseif($step < 3) notPassed @elseif($step > 3) passed @endif">
                    <div class = "a--step-item-icon">
                        <i class = "fa fa-money-bill-wave"></i>
                    </div>
                    <div class = "a--step-item-text">
                        اطلاعات پرداخت
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--<div class="mt-element-step">--}}{{--<div class="row step-line">--}}{{--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-step-col first @if($step == 0) active @else  done @endif">--}}{{--<div class="mt-step-number bg-white">--}}{{--<i class="fa fa-sign-in"></i>--}}{{--</div>--}}{{--<div class="mt-step-title  font-grey-cascade" style="font-size: medium;">ورود</div>--}}{{--<div class="mt-step-content font-grey-cascade">Purchasing the item</div>--}}{{--</div>--}}{{--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-step-col @if($step < 1)  @elseif($step == 1) active @else done @endif">--}}{{--<div class="mt-step-number bg-white">--}}{{--<i class="fa fa-info" aria-hidden="true"></i>--}}{{--</div>--}}{{--<div class="mt-step-title  font-grey-cascade" style="font-size: medium;">تکمیل اطلاعات</div>--}}{{--<div class="mt-step-content font-grey-cascade">Complete your payment</div>--}}{{--</div>--}}{{--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-step-col @if($step < 2)  @elseif($step == 2) active @else done @endif">--}}{{--<div class="mt-step-number bg-white">--}}{{--<i class="fa fa-calendar-check-o"></i>--}}{{--</div>--}}{{--<div class="mt-step-title  font-grey-cascade" style="font-size: medium;">بازبینی</div>--}}{{--<div class="mt-step-content font-grey-cascade">Complete your payment</div>--}}{{--</div>--}}{{--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-step-col last @if($step < 3)  @elseif($step == 3) active @else done @endif">--}}{{--<div class="mt-step-number bg-white">--}}{{--<i class="icon-credit-card"></i>--}}{{--</div>--}}{{--<div class="mt-step-title  font-grey-cascade" style="font-size: medium;">اطلاعات پرداخت</div>--}}{{--<div class="mt-step-content font-grey-cascade">Receive item integration</div>--}}{{--</div>--}}{{--</div>--}}{{--<br/>--}}{{--<br/>--}}{{--</div>--}}
