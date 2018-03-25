 <div class="mt-element-step">
                    <div class="row step-line">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mt-step-col first @if($step == 0) active @else  done @endif">
                            <div class="mt-step-number bg-white">
                                <i class="fa fa-sign-in"></i>
                            </div>
                            <div class="mt-step-title uppercase font-grey-cascade">ورود</div>
                            {{--<div class="mt-step-content font-grey-cascade">Purchasing the item</div>--}}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mt-step-col @if($step < 1)  @elseif($step == 1) active @else done @endif">
                            <div class="mt-step-number bg-white">
                                <i class="fa fa-info" aria-hidden="true"></i>
                            </div>
                            <div class="mt-step-title uppercase font-grey-cascade">تکمیل اطلاعات</div>
                            {{--<div class="mt-step-content font-grey-cascade">Complete your payment</div>--}}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mt-step-col @if($step < 2)  @elseif($step == 2) active @else done @endif">
                            <div class="mt-step-number bg-white">
                                <i class="fa fa-calendar-check-o"></i>
                            </div>
                            <div class="mt-step-title uppercase font-grey-cascade">بازبینی</div>
                            {{--<div class="mt-step-content font-grey-cascade">Complete your payment</div>--}}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 mt-step-col last @if($step < 3)  @elseif($step == 3) active @else done @endif">
                            <div class="mt-step-number bg-white">
                                <i class="icon-credit-card"></i>
                            </div>
                            <div class="mt-step-title uppercase font-grey-cascade">اطلاعات پرداخت</div>
                            {{--<div class="mt-step-content font-grey-cascade">Receive item integration</div>--}}
                        </div>
                    </div>
                    <br/>
                    <br/>
</div>
