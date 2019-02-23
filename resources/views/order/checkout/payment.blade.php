@extends('app')

@section('page-css')
    <link href = "{{ mix('/css/checkout-payment.css') }}" rel = "stylesheet" type = "text/css"/>
@endsection

@section('content')

    <div class = "row">
        <div class = "col">
            @include('systemMessage.flash')
        </div>
    </div>

    <div class = "row">
        {{--روش پرداخت--}}
        <div class = "col-12 col-md-8 order-2 order-sm-2 order-md-1 order-lg-1">
            <div class = "row">
                <div class = "col">
                    <div class = "m-portlet m-portlet--creative m-portlet--bordered m-portlet--bordered-semi noHeadText">
                        <div class = "m-portlet__head">
                            <div class = "m-portlet__head-caption">
                                <div class = "m-portlet__head-title">
                                    <h2 class = "m-portlet__head-label m-portlet__head-label--accent a--white-space-nowrap">
                                        <span>
                                            <i class = "la la-bank"></i>
                                            روش پرداخت
                                        </span>
                                    </h2>
                                </div>
                            </div>
                            <div class = "m-portlet__head-tools"></div>
                        </div>
                        <div class = "m-portlet__body m--padding-bottom-10">

                            {{--tab title--}}
                            <div class = "row">
                                <div class = "col">
                                    <div class = "m-form__group form-group">
                                        <label for = "">
                                            روش پرداخت را مشخص کنید:
                                        </label>
                                        <div class = "m-radio-inline">
                                            <label class = "m-radio m-radio--solid m-radio--state-success">
                                                <input type = "radio" name = "radioPaymentType" data-btntext = "پرداخت" value = "online" checked>
                                                انترنتی
                                                <span></span>
                                            </label>
                                            {{--<label class="m-radio m-radio--solid m-radio--state-success">--}}
                                                {{--<input type="radio" name="radioPaymentType" data-btntext="ثبت سفارش" value="hozoori">--}}
                                                {{--حضوری--}}
                                                {{--<span></span>--}}
                                            {{--</label>--}}
                                            <label class = "m-radio m-radio--solid m-radio--state-success">
                                                <input type = "radio" name = "radioPaymentType" data-btntext = "ثبت سفارش" value = "card2card">
                                                کارت به کارت
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--tab content--}}
                            <div class = "row">
                                <div class = "col">

                                    <div class = "m-portlet PaymentType" id = "PaymentType-online">
                                        <div class = "m-portlet__body">
                                            <span>
                                                یکی از درگاه های بانکی زیر را انتخاب کنید:
                                            </span>
                                            <div class = "m-form__group form-group text-center m--margin-top-10">
                                                <div class = "m-radio-inline">
                                                    <label class = "m-radio m-radio--solid m-radio--state-info">
                                                        <input type = "radio" name = "radioBankType" value = "1" checked>
                                                        <img src = "/acm/extra/payment/gateway/zarinpal-logo.png" class = "img-thumbnail bankLogo" alt = "bank-logo">
                                                        <span></span>
                                                    </label>
                                                    <label class = "m-radio m-radio--solid m-radio--state-info">
                                                        <input type = "radio" name = "radioBankType" value = "2">
                                                        <img src = "/acm/extra/payment/gateway/mellat-logo.png" class = "img-thumbnail bankLogo" alt = "bank-logo">
                                                        <span></span>
                                                    </label>
                                                    <label class = "m-radio m-radio--solid m-radio--state-info">
                                                        <input type = "radio" name = "radioBankType" value = "3">
                                                        <img src = "/acm/extra/payment/gateway/pasargad-logo.jpg" class = "img-thumbnail bankLogo" alt = "bank-logo">
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="m-portlet PaymentType" id="PaymentType-hozoori">--}}
                                        {{--<div class="m-portlet__body">--}}
                                            {{--بعد از ثبت سفارش مبلغ 12،470 تومان را به صورت حضوری پرداخت کنید.--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class = "m-portlet PaymentType" id = "PaymentType-card2card">
                                        <div class = "m-portlet__body">
                                            <div class = "row">
                                                <div class = "col-12 col-md-9">
                                                    جهت تایید سفارش مبلغ
                                                    <b class = "finalPriceValue">{{ number_format($invoiceInfo['totalCost']) }}</b> تومان به شماره کارت:
                                                    <br>
                                                    4444-4444-4444-4444
                                                    <br>
                                                    به نام فلان فلانی بانک فلان واریز نمایید.
                                                </div>
                                                <div class = "col-12 col-md-3">
                                                    <img class = "a--full-width" src = "/acm/extra/payment/balance-transfer.png" alt = "کارت به کارت">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{--dicount code--}}
                            <div class = "row justify-content-center">
                                <div class = "col-12">
                                    <hr>
                                </div>
                                <div class = "col-12 col-sm-8 col-md-6 col-lg-6 m--margin-top-20 text-center">
                                    <span>
                                        <label for = "hasntDiscountCode">
                                            کد تخفیف:
                                        </label>
                                    </span>
                                    <span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
                                        <input type="checkbox"
                                          data-switch="true"
                                            @if(!isset($coupon))
                                               checked="checked"
                                            @endif
                                          data-on-text="ندارم"
                                          data-on-color="danger"
                                          data-off-text="دارم"
                                          data-off-color="success"
                                          data-size="small"
                                          {{--data-handle-width="40"--}}
                                           id="hasntDiscountCode">
                                    </span>
                                </div>
                                <div class="col-12 col-md-6 m--margin-top-10">
                                    <div class="input-group discountCodeValueWarper">
                                        <div class="discountCodeValueWarperCover"></div>
                                        <input type="text"
                                               class="form-control"
                                               placeholder="کد تخفیف ..."
                                               @if(isset($coupon))
                                                value="{{ $coupon['coupon']->code }}"
                                               @endif
                                               id="discountCodeValue">
                                        <div class="input-group-prepend DiscountCodeActionsWarper">
                                            <button class="btn btn-danger@if(!isset($coupon)) a--d-none @endif" type="button" id="btnRemoveDiscountCodeValue">حذف</button>
                                            <button class="btn btn-success@if(isset($coupon)) a--d-none @endif"  type="button" id="btnSaveDiscountCodeValue">ثبت</button>
                                        </div>
                                    </div>
                                </div>
                                <div class = "col-12">
                                    @if (isset($coupon))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            @if($coupon['coupon']->discounttype->id == config('constants.DISCOUNT_TYPE_COST'))
                                                کپن تخفیف
                                                <strong>{{$coupon['coupon']->name}}</strong>
                                                با
                                                {{number_format($coupon['discount'])}}
                                                تومان تخفیف برای سفارش شما ثبت شد.
                                            @else
                                                کپن تخفیف
                                                <strong>{{$coupon['coupon']->name}}</strong>
                                                با
                                                {{$coupon['discount']}}
                                                % تخفیف برای
                                                سفارش شما ثبت شده است.
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{--user description--}}
                            <div class = "row justify-content-center">
                                <div class = "col-12">
                                    <hr>
                                </div>
                                <div class = "col-12 col-sm-8 col-md-6 col-lg-6 m--margin-top-20 text-center">
                                    <div class = "form-group m-form__group">
                                        <label for = "bio">اگر توضیحی در مورد سفارش خود دارید اینجا بنویسید:</label>
                                        <div class = "m-input-icon m-input-icon--left">
                                            <textarea id = "bio" class = "form-control m-input m-input--air" placeholder = "توضیح شما..." rows = "2" name = "bio" cols = "50"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--btn submit order--}}
                            <div class = "row justify-content-center">
                                <div class = "col text-center">
                                    <hr>
                                    <button type = "button" class = "btn btn-lg m-btn--pill m-btn--air m-btn m-btn--gradient-from-info
                                            m-btn--gradient-to-accent m--padding-top-20 m--padding-bottom-20
                                             m--padding-right-50 m--padding-left-50 btnSubmitOrder"></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--مبلغ قابل پرداخت--}}
        <div class = "col-12 col-md-4 order-1 order-sm-1 order-md-2 order-lg-2 finalPriceReportWarper">
            <div class = "m-portlet m-portlet--head-overlay  m-portlet--full-heigh m-portlet--rounded-force">
                <div class = "m-portlet__head m-portlet__head--fit-">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title"></div>
                    </div>
                    <div class = "m-portlet__head-tools"></div>
                </div>
                <div class = "m-portlet__body">
                    <div class = "m-widget27 m-portlet-fit--sides">
                        <div class = "m-widget27__pic">
                            <img src = "/assets/app/media/img//bg/bg-4.jpg" alt = "">
                            <h3 class = "m-widget27__title text-center paymentAndWalletValue m--font-light">
                                <span>
                                    مبلغ قابل پرداخت:
                                    <br>
                                    <b class = "finalPriceValue">{{ number_format($invoiceInfo['totalCost']) }}</b>
                                    تومان
                                    <hr>
                                    <small>
                                        کیف پول شما:
                                        <br>
                                        {{ number_format($credit) }} تومان
                                    </small>
                                </span>
                            </h3>
                        </div>
                        <div class = "m-widget27__container m--margin-top-5">

                            <div class = "container-fluid">
                                <div class = "row">

                                    <div class = "col-12">
                                        <div class = "m-portlet m-portlet--creative noHeadText m-portlet--bordered m-portlet--full-height">
                                            <div class = "m-portlet__head">
                                                <div class = "m-portlet__head-caption">
                                                    <div class = "m-portlet__head-title">
                                                        <h2 class = "m-portlet__head-label m-portlet__head-label--accent a--white-space-nowrap">
                                                            <span>
                                                                <i class = "fa fa-donate"></i>
                                                                کمک به آلاء
                                                            </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class = "m-portlet__head-tools"></div>
                                            </div>
                                            <div class = "m-portlet__body m--padding-right-5 m--padding-left-5">
                                                <div class = "row align-items-center">
                                                    <div class = "col-12">
                                                        <div id = "m_nouislider_1" class = "m-nouislider m-nouislider--handle-danger m-nouislider--drag-danger noUi-target noUi-ltr noUi-horizontal visibleInDonate"></div>
                                                    </div>
                                                    <div class = "col-12 m--margin-top-10 text-center">
                                                        <span class = "visibleInDonate"> مبلغ </span>
                                                        <span class = "visibleInDonate">
                                                            <input type = "text" class = "form-control" id = "m_nouislider_1_input" placeholder = "مقدار کمک" readonly>
                                                        </span>
                                                        <span class = "visibleInDonate"> هزار تومان </span>
                                                        <br>
                                                        <span>
                                                            <label for = "hasntDonate">
                                                        به آلاء کمک
                                                            </label>
                                                        </span>
                                                        <span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
                                                            <input type="checkbox"
                                                                   data-switch="true"
                                                                   @if(isset($orderHasDonate) && $orderHasDonate)
                                                                   @else
                                                                   checked=""
                                                                   @endif
                                                                   data-on-text="نمی کنم"
                                                                   data-on-color="danger"
                                                                   data-off-text="می کنم"
                                                                   data-off-color="success"
                                                                   data-size="small"
                                                                   {{--data-handle-width="40"--}}
                                                                   id="hasntDonate">
                                                        </span>
                                                        <span>
                                                            <img src = "/acm/extra/sad.png" class = "face-sad m--margin-top-20" alt = "">
                                                            <img src = "/acm/extra/happy.png" class = "face-happy m--margin-top-20" alt = "">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>











    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="portlet light bordered ">--}}
                {{--<div class="portlet-body">--}}
                    {{--<div class="row">--}}
                        {{--@include("partials.checkoutSteps" , ["step"=>3])--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="portlet dark box">--}}

                                {{--<div class="portlet-body">--}}
                                    {{--<div class="row">--}}
                                        {{--<div class="col-lg-12">--}}
                                            {{--                                            {!! Form::open(['method' => 'POST','action' => ['OrderController@addOrderproduct' , 180] , 'class'=>'form-horizontal' , 'id'=>'donateForm' ]) !!}--}}
                                            {{--<label for="donateSwitch">5 هزار تومان مشارکت می کنم در هزینه های--}}
                                                {{--آلاء</label>--}}
                                            {{--<input type="hidden" name="mode" value="normal">--}}
                                            {{--<input type="checkbox"--}}
                                                   {{--@if(isset($orderHasDonate) && $orderHasDonate) checked--}}
                                                   {{--@endif  id="donateSwitch" value="" class="make-switch"--}}
                                                   {{--data-off-color="danger" data-on-color="success"--}}
                                                   {{--data-off-text="&nbsp;کمک&nbsp;نمی&nbsp;کنم&nbsp;"--}}
                                                   {{--data-on-text="&nbsp;کمک&nbsp;می&nbsp;کنم&nbsp;">--}}
                                            {{--                                            {!! Form::close() !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<hr>--}}
                                    {{--@if(session()->has("adminOrder_id") )--}}
                                        {{--<div class="row">--}}
                                            {{--                                            {!! Form::open(['method' => 'GET','action' => ['OrderController@verifyPayment'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}--}}
                                            {{--<div class="form-group">--}}
                                                {{--<div class="col-lg-12" style="text-align: center;">--}}
                                                    {{--<span class="label bg-green-soft" style="font-size: 15px">مبلغ قابل پرداخت: {{number_format($cost)}}</span>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group">--}}
                                                {{--<div class="col-lg-12" style="text-align: center;">--}}
                                                    {{--<a href = "{{action("Web\OrderController@checkoutReview")}}"--}}
                                                       {{--class="btn dark btn-outline"><i class="fa fa-chevron-right"--}}
                                                                                       {{--aria-hidden="true"></i>بازبینی</a>--}}
                                                    {{--<button type="submit" class="btn green btn-outline">ثبت نهایی--}}
                                                    {{--</button>--}}
                                                {{--</div>--}}
                                                {{--{!! Form::hidden('paymentmethod','inPersonPayment') !!}--}}
                                            {{--</div>--}}
                                            {{--                                            {!! Form::close() !!}--}}
                                        {{--</div>--}}
                                    {{--@elseif(!isset($invoiceInfo["totalCost"]) || $invoiceInfo["totalCost"] == 0)--}}
                                        {{--<div class="row">--}}
                                            {{--                                            {!! Form::open(['method' => 'GET','action' => ['OrderController@verifyPayment'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}--}}
                                            {{--<div class="col-md-12 margin-top-20">--}}
                                                {{--{!! Form::textarea('customerDescription',null,['class' => 'form-control' , 'placeholder'=>'اگر توضیحی درباره سفارش خود دارید لطفا اینجا بنویسید' , 'rows'=>'3']) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-12 margin-top-40" style="text-align: center;">--}}
                                                    {{--<span class="label bg-green-soft" style="font-size: 15px">--}}
                                                        {{--مبلغ قابل پرداخت: {{number_format($invoiceInfo["totalCost"])}}--}}
                                                        {{--15000--}}
                                                    {{--</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-12 margin-top-20" style="text-align: center;">--}}
                                                {{--<a href="{{action("Web\OrderController@checkoutReview")}}"--}}
                                                   {{--class="btn dark btn-outline" style="width: 100px"><i--}}
                                                            {{--class="fa fa-chevron-right"--}}
                                                            {{--aria-hidden="true"></i>بازبینی</a>--}}
                                                {{--<button type="submit" class="btn green btn-outline"--}}
                                                        {{--style="width: 100px">ثبت نهایی--}}
                                                {{--</button>--}}
                                            {{--</div>--}}
                                            {{--                                            {!! Form::close() !!}--}}
                                        {{--</div>--}}
                                    {{--@else--}}
                                        {{--<div class="row">--}}
                                            {{--{!! Form::open(['method' => 'POST','action' => ['Web\TransactionController@create'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}--}}
                                            {{--<div class="form-group text-center">--}}
                                                {{--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">--}}
                                                    {{--<label class="col-lg-5 col-md-5 col-sd-5 col-xs-5 text-center control-label"--}}
                                                           {{--style="text-align: center" for="gateway">روش پرداخت </label>--}}
                                                    {{--<div class="col-lg-7 col-md-7 col-sd-7 col-xs-7">--}}
                                                        {{--{!! Form::select('paymentmethod',["onlinePayment" => "آنلاین"],null,['class' => 'form-control' , 'id'=>'paymentMethod']) !!}--}}
                                                        {{--<text class="form-control-static bold"> آنلاین</text>--}}
                                                        {{--{!! Form::hidden('paymentmethod', 'onlinePayment' , ['id'=>'paymentMethod']) !!}--}}
                                                    {{--</div>--}}

                                                {{--</div>--}}
                                                {{--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " id="gatewayDiv">--}}
                                                    {{--<label class="col-lg-5 col-md-5 col-sd-5 col-xs-5 control-label"--}}
                                                           {{--style="text-align: center" for="gateway">انتخاب--}}
                                                        {{--درگاه </label>--}}
                                                    {{--<div class="col-lg-7 col-md-7 col-sd-7 col-xs-7">--}}
                                                        {{--{!! Form::select('gateway',$gateways,null,['class' => 'form-control' , 'id'=>'gatewaySelect' ]) !!}--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group">--}}
                                                {{--<div class="col-lg-3 col-md-3">--}}
                                                    {{--<label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left control-label bold font-blue-sharp"--}}
                                                           {{--style="text-align: center ; font-size: medium">--}}
                                                        {{--کیف پول شما: {{number_format($credit)}} تومان--}}
                                                    {{--</label>--}}
                                                    {{--@if($credit > 0 )--}}
                                                        {{--{!! Form::hidden('payByWallet',1 ) !!}--}}
                                                    {{--@endif--}}
                                                    {{--@if(isset($coupon))--}}
                                                        {{--<div class="col-lg-12 col-md-12 margin-top-20 text-left">--}}
                                                            {{--<span class="bold font-blue-sharp"--}}
                                                                  {{--style="font-size: 15px; padding: 0px 5px 0px 5px;">--}}
                                                                {{--{{($credit>0)?"جمع کل:":"مبلغ قابل پرداخت:"}}--}}
                                                                {{--<lable id="totalCost"--}}
                                                                       {{--style="text-decoration: line-through;">--}}
                                                                    {{--{{number_format($invoiceInfo["totalCost"])}}--}}
                                                                    {{--15000--}}
                                                                {{--</lable>--}}
                                                            {{--تومان--}}
                                                            {{--</span>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="col-lg-12 col-md-12 margin-top-20 text-left">--}}
                                                            {{--<span class="bold font-red"--}}
                                                                  {{--style="padding: 0px 5px 0px 5px; font-size: 15px">--}}
                                                                    {{--برای شما {{number_format($invoiceInfo["totalCost"])}} تومان--}}
                                                                {{--15000--}}
                                                            {{--</span>--}}
                                                        {{--</div>--}}
                                                    {{--@else--}}
                                                        {{--<div class="col-lg-12 col-md-12 margin-top-20 text-left">--}}
                                                            {{--<span class="bold font-blue-sharp" style="font-size: 15px">--}}
                                                                {{--{{($credit>0)?"جمع کل:":"مبلغ قابل پرداخت:"}}--}}
                                                                {{--<lable id="totalCost">--}}
                                                                    {{--{{number_format($invoiceInfo["totalCost"])}}--}}
                                                                    {{--15000--}}
                                                                {{--</lable>--}}
                                                            {{--تومان--}}
                                                            {{--</span>--}}
                                                        {{--</div>--}}
                                                    {{--@endif--}}
                                                    {{--@if($credit > 0)--}}
                                                        {{--<div class="col-lg-12 col-md-12 margin-top-20 text-left">--}}
                                                        {{--<span class="bold font-blue-sharp" style="font-size: 15px">--}}
                                                            {{--استفاده از کیف پول:--}}
                                                                    {{--<lable id="totalCost">--}}
                                                                        {{--{{number_format($invoiceInfo["paidByWallet"])}}--}}
                                                                    {{--</lable>--}}
                                                                    {{--تومان--}}
                                                        {{--</span>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="col-lg-12 col-md-12 margin-top-20 text-left">--}}
                                                            {{--<span class="bold font-blue-sharp" style="font-size: 15px">مبلغ قابل پرداخت:--}}
                                                                        {{--<lable id="totalCost">--}}
                                                                            {{--{{number_format( $invoiceInfo["payableCost"])}}--}}
                                                                            {{--15000--}}
                                                                        {{--</lable>--}}
                                                                        {{--تومان--}}
                                                            {{--</span>--}}
                                                        {{--</div>--}}
                                                    {{--@endif--}}
                                                {{--</div>--}}
                                                {{--<div class="col-lg-9 col-md-9" style="    padding: 0px 30px 0px 30px;">--}}
                                                    {{--{!! Form::textarea('customerDescription',null,['class' => 'form-control' , 'placeholder'=>'اگر توضیحی درباره سفارش خود دارید اینجا بنویسید' , 'rows'=>'3']) !!}--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group">--}}
                                                {{--<div class="col-lg-12 col-md-12 margin-top-10 text-center">--}}
                                                    {{--<a href="{{action("Web\OrderController@checkoutReview")}}"--}}
                                                       {{--class="btn dark btn-outline" style="width: 100px">--}}
                                                        {{--<i class="fa fa-chevron-right" aria-hidden="true"></i>--}}
                                                        {{--بازبینی--}}
                                                    {{--</a>--}}
                                                    {{--<button type="submit" class="btn green btn-outline"--}}
                                                            {{--style="width: 100px">--}}
                                                        {{--{{($invoiceInfo["payableCost"] == 0)?"ثبت نهایی":"پرداخت"}}--}}
                                                        {{--15000--}}
                                                    {{--</button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--{!! Form::close() !!}--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<br/>--}}
                    {{--<br/>--}}
                    {{--<br/>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <input type="hidden" id="invoiceInfo-totalCost" value="{{ $invoiceInfo['totalCost'] }}">
    <input type="hidden" id="invoiceInfo-couponCode" value="@if (isset($coupon)){{ $coupon['coupon']->code }}@endif">
    <input type="hidden" id="OrderController-submitCoupon" value="{{ action('Web\OrderController@submitCoupon') }}">
    <input type="hidden" id="OrderController-removeCoupon" value="{{ action('Web\OrderController@removeCoupon') }}">

@endsection

@section('page-js')

    <script src = "{{ mix('/js/checkout-payment.js') }}"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/checkout-payment.js') }}"></script>

    {{--function setPaymentController() {--}}
    {{--if ($("#paymentMethod").val() == "onlinePayment") {--}}
    {{--$("#paymentForm").attr("action", "{{action('TransactionController@paymentRedirect')}}");--}}
    {{--$("#gatewaySelect").prop('disabled', false);--}}
    {{--$("#gatewayDiv").show();--}}
    {{--} else if ($("#paymentMethod").val() == "inPersonPayment" || $("#paymentMethod").val() == "offlinePayment") {--}}
    {{--$("#paymentForm").attr("action", "{{action('OrderController@verifyPayment')}}");--}}
    {{--$("#gatewaySelect").prop('disabled', true);--}}
    {{--$("#gatewayDiv").hide();--}}
    {{--}--}}
    {{--}--}}

    {{--$(document).ready(function () {--}}
    {{--setPaymentController();--}}
    {{--});--}}

    {{--$(document).on("change", "#paymentMethod", function () {--}}
    {{--setPaymentController();--}}
    {{--});--}}

    {{--$(document).on("switchChange.bootstrapSwitch", "#couponSwitch", function () {--}}
    {{--if ($(this).is(':checked')) {--}}
    {{--$("#couponForm").fadeIn();--}}
    {{--} else {--}}
    {{--$("#couponForm").fadeOut(1000);--}}
    {{--}--}}
    {{--});--}}

    {{--var submitDonateAjax;--}}
    {{--var cancelDonateAjax;--}}
    {{--$(document).on("switchChange.bootstrapSwitch", "#donateSwitch", function () {--}}
    {{--if ($(this).is(':checked')) {--}}
    {{--var formData = $("#donateForm").serialize();--}}
    {{--if (submitDonateAjax) {--}}
    {{--submitDonateAjax.abort();--}}
    {{--}--}}
    {{--submitDonateAjax = $.ajax({--}}
    {{--type: "POST",--}}
    {{--url: $("#donateForm").attr("action"),--}}
    {{--data: formData,--}}
    {{--// contentType: "application/json",--}}
    {{--// dataType: "json",--}}
    {{--statusCode: {--}}
    {{--200: function (response) {--}}
    {{--location.reload();--}}
    {{--// $("#totalCost").text(response.cost).number(true) ;--}}
    {{--},--}}
    {{--//The status for when the user is not authorized for making the request--}}
    {{--401: function (ressponse) {--}}
    {{--location.reload();--}}
    {{--},--}}
    {{--403: function (response) {--}}
    {{--window.location.replace("/403");--}}
    {{--},--}}
    {{--404: function (response) {--}}
    {{--window.location.replace("/404");--}}
    {{--},--}}
    {{--//The status for when form data is not valid--}}
    {{--422: function (response) {--}}
    {{--//--}}
    {{--},--}}
    {{--//The status for when there is error php code--}}
    {{--500: function (response) {--}}
    {{--// console.log(response.responseText);--}}
    {{--// toastr["error"]("خطای برنامه!", "پیام سیستم");--}}
    {{--},--}}
    {{--//The status for when there is error php code--}}
    {{--503: function (response) {--}}
    {{--console.log(response);--}}
    {{--console.log(response.responseText);--}}
    {{--// toastr["error"]("خطای پایگاه داده!", "پیام سیستم");--}}
    {{--}--}}
    {{--}--}}
    {{--});--}}

    {{--return false;--}}
    {{--} else {--}}
    {{--if (cancelDonateAjax) {--}}
    {{--cancelDonateAjax.abort();--}}
    {{--}--}}
    {{--cancelDonateAjax = $.ajax({--}}
    {{--type: "DELETE",--}}
    {{--url: "{{action("Web\OrderController@removeOrderproduct" , 180)}}",--}}
    {{--contentType: "application/json",--}}
    {{--dataType: "json",--}}
    {{--statusCode: {--}}
    {{--200: function (response) {--}}
    {{--location.reload();--}}
    {{--// $("#totalCost").text(response.cost).number(true) ;--}}
    {{--},--}}
    {{--//The status for when the user is not authorized for making the request--}}
    {{--401: function (ressponse) {--}}
    {{--location.reload();--}}
    {{--},--}}
    {{--403: function (response) {--}}
    {{--window.location.replace("/403");--}}
    {{--},--}}
    {{--404: function (response) {--}}
    {{--window.location.replace("/404");--}}
    {{--},--}}
    {{--//The status for when form data is not valid--}}
    {{--422: function (response) {--}}
    {{--//--}}
    {{--},--}}
    {{--//The status for when there is error php code--}}
    {{--500: function (response) {--}}
    {{--// console.log(response.responseText);--}}
    {{--// toastr["error"]("خطای برنامه!", "پیام سیستم");--}}
    {{--},--}}
    {{--//The status for when there is error php code--}}
    {{--503: function (response) {--}}
    {{--// toastr["error"]("خطای پایگاه داده!", "پیام سیستم");--}}
    {{--}--}}
    {{--}--}}
    {{--});--}}

    {{--return false;--}}
    {{--}--}}

    {{--});--}}
    {{--</script>--}}
@endsection