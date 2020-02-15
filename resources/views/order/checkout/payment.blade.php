@extends('app' , ["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/checkout-payment.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .m-widget27 .m-widget27__pic > img {
            height: 150px;
        }
    </style>
@endsection

@section('content')

    @include('systemMessage.flash')

    @include("partials.checkoutSteps" , ["step"=>3])

    <div class="row">
        {{--روش پرداخت--}}
        <div class="col-12 col-md-8 order-2 order-sm-2 order-md-1 order-lg-1">
            <div class="row">
                <div class="col">
                    <div class="m-portlet m-portlet--creative m-portlet--bordered m-portlet--bordered-semi noHeadText">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h2 class="m-portlet__head-label m-portlet__head-label--accent a--white-space-nowrap">
                                        <span>
                                            <i class="fa fa-dollar-sign"></i>
                                            روش پرداخت
                                        </span>
                                    </h2>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools"></div>
                        </div>
                        <div class="m-portlet__body m--padding-bottom-10">

                            <form method="GET" action="" id="frmGotoGateway">

                                <div class="row">
                                    <div class="col-12 col-md-6">


                                        {{--tab title--}}
                                        <div class="row">
                                            <div class="col">
                                                <div class="m-form__group form-group">
                                                    <label for="">
                                                        روش پرداخت را مشخص کنید:
                                                    </label>
                                                    <div class="m-radio-inline">
                                                        <label class="m-radio m-radio--solid m-radio--state-success">
                                                            <input type="radio" name="radioPaymentType"
                                                                   data-btntext="پرداخت" value="online" checked>
                                                            اینترنتی
                                                            <span></span>
                                                        </label>
                                                        {{--<label class="m-radio m-radio--solid m-radio--state-success">--}}
                                                        {{--<input type="radio" name="radioPaymentType" data-btntext="ثبت سفارش" value="hozoori">--}}
                                                        {{--حضوری--}}
                                                        {{--<span></span>--}}
                                                        {{--</label>--}}
                                                        {{--<label class = "m-radio m-radio--solid m-radio--state-success">--}}
                                                        {{--<input type = "radio" name = "radioPaymentType" data-btntext = "ثبت سفارش" value = "card2card">--}}
                                                        {{--کارت به کارت--}}
                                                        {{--<span></span>--}}
                                                        {{--</label>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--tab content--}}
                                        <div class="row">
                                            <div class="col">

                                                <div class="m-portlet PaymentType" id="PaymentType-online">
                                                    <div class="m-portlet__body">
                                                        <span>
                                                            یکی از درگاه های بانکی زیر را انتخاب کنید:
                                                        </span>
                                                        <div class="m-form__group form-group text-center m--margin-top-10">
                                                            <div class="m-radio-inline">
                                                                <label class="m-radio m-radio--solid m-radio--state-info">
                                                                    <input type="radio" name="radioBankType" value="{{route('redirectToBank', ['paymentMethod'=>'zarinpal', 'device'=>'web'])}}" data-bank-type="zarinpal" >
                                                                    <img src="/acm/extra/payment/gateway/zarinpal-logo.png"
                                                                         class="img-thumbnail bankLogo" alt="bank-logo">
                                                                    <span></span>
                                                                </label>
                                                                <label class = "m-radio m-radio--solid m-radio--state-info">
                                                                    <input type = "radio" name = "radioBankType" value = "{{route('redirectToBank', ['paymentMethod'=>'mellat', 'device'=>'web'])}}" data-bank-type="mellat" checked>
                                                                    <img src = "/acm/extra/payment/gateway/mellat-logo.png" class = "img-thumbnail bankLogo" alt = "bank-logo">
                                                                    <span></span>
                                                                </label>
                                                                {{--<label class = "m-radio m-radio--solid m-radio--state-info">--}}
                                                                {{--<input type = "radio" name = "radioBankType" value = "3">--}}
                                                                {{--<img src = "/acm/extra/payment/gateway/pasargad-logo.jpg" class = "img-thumbnail bankLogo" alt = "bank-logo">--}}
                                                                {{--<span></span>--}}
                                                                {{--</label>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--<div class="m-portlet PaymentType" id="PaymentType-hozoori">--}}
                                                {{--<div class="m-portlet__body">--}}
                                                {{--بعد از ثبت سفارش مبلغ 12،470 تومان را به صورت حضوری پرداخت کنید.--}}
                                                {{--</div>--}}
                                                {{--</div>--}}

                                                <div class="m-portlet PaymentType" id="PaymentType-card2card">
                                                    <div class="m-portlet__body">
                                                        <div class="row text-center">
                                                            <div class="col-12 col-md-9">
                                                                <div class="m--margin-top-20">
                                                                    جهت تایید سفارش مبلغ
                                                                    <b class="finalPriceValue">{{ number_format($invoiceInfo['price']['final']) }}</b>
                                                                    تومان به شماره کارت:
                                                                    <br>
                                                                    6104-3375-6000-0026
                                                                    <br>
                                                                    به نام مؤسسه توسعه علمی آموزشی عدالت محور آلاء بانک ملت
                                                                    واریز نمایید.
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-3">
                                                                <img class="card2cardImage"
                                                                     src="/acm/extra/payment/balance-transfer.png"
                                                                     alt="کارت به کارت">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-6">

                                        {{--dicount code--}}
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-sm-8 col-md-6 col-lg-6 m--margin-top-20 text-center hasntDiscountCodeWraper">
                                                <span>
                                                    <label for="hasntDiscountCode">
                                                        کد تخفیف:
                                                    </label>
                                                </span>

                                                <span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
                                                    <input type="checkbox" data-switch="true"
                                                           @if(!isset($coupon))checked="checked" @endif data-on-text="ندارم"
                                                           data-on-color="danger" data-off-text="دارم"
                                                           data-off-color="success" data-size="small"
                                                           {{--data-handle-width="40"--}}id="hasntDiscountCode">
                                                </span>
                                            </div>
                                            <div class="col-12 col-md-6 m--margin-top-10">
                                                <div class="input-group discountCodeValueWarper">
                                                    <div class="discountCodeValueWarperCover"></div>
                                                    <input type="text" class="form-control" placeholder="کد تخفیف ..."
                                                           @if(isset($coupon))value="{{ $coupon['code'] }}"
                                                           @endif id="discountCodeValue">
                                                    <div class="input-group-prepend DiscountCodeActionsWarper">
                                                        <button class="btn btn-danger @if (!isset($coupon)) a--d-none @endif"
                                                                type="button" id="btnRemoveDiscountCodeValue">حذف
                                                        </button>
                                                        <button class="btn btn-success @if (isset($coupon)) a--d-none @endif"
                                                                type="button" id="btnSaveDiscountCodeValue">ثبت
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">

                                                <div class="alert alert-success alert-dismissible fade show couponReportWarper @if (!isset($coupon)) a--d-none @endif"
                                                     role="alert">
                                                    {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>--}}
                                                    <div class="couponReport">
                                                        @if(isset($coupon) && $coupon['type'] == config('constants.DISCOUNT_TYPE_COST'))
                                                            کپن تخفیف
                                                            <strong>{{$coupon['name']}}</strong>
                                                            با
                                                            {{number_format($coupon['discount'])}}
                                                            تومان تخفیف برای سفارش شما ثبت شد.
                                                        @elseif(isset($coupon))
                                                            کپن تخفیف
                                                            <strong>{{$coupon['name']}}</strong>
                                                            با
                                                            {{$coupon['discount']}}
                                                            % تخفیف برای
                                                            سفارش شما ثبت شده است.
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        {{--user description--}}
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <hr>
                                            </div>
                                            <div class="col-12 m--margin-top-20 text-center">
                                                <div class="form-group m-form__group">
                                                    <label for="customerDescription">اگر توضیحی در مورد سفارش خود دارید اینجا
                                                        بنویسید:</label>
                                                    <div class="m-input-icon m-input-icon--left">
                                                        <textarea id="customerDescription" class="form-control m-input m-input--air"
                                                                  placeholder="توضیح شما..." rows="2" name="customerDescription"
                                                                  cols="50"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col notIncludedProductsInCouponReportArea">

                                    </div>
                                </div>


                                {{--btn submit order--}}
                                <div class="row justify-content-center">
                                    <div class="col text-center btnSubmitOrderWraper">
                                        <hr>

                                        <button type = "submit"
                                                onclick="mApp.block('.btnSubmitOrderWraper', {type: 'loader',state: 'info'});"
                                                class="btn btn-lg m-btn--pill m-btn--air m-btn btn-info m--padding-top-20 m--padding-bottom-20
                                                 m--padding-right-50 m--padding-left-50 btnSubmitOrder"></button>
                                    </div>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--مبلغ قابل پرداخت--}}
        <div class="col-12 col-md-4 order-1 order-sm-1 order-md-2 order-lg-2 finalPriceReportWarper">
            <div class="m-portlet m-portlet--head-overlay  m-portlet--full-heigh m-portlet--rounded-force">
                <div class="m-portlet__head m-portlet__head--fit-">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title"></div>
                    </div>
                    <div class="m-portlet__head-tools"></div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__pic">
                            <img src="/assets/app/media/img//bg/bg-4.jpg" alt="">
                            <h3 class="m-widget27__title text-center paymentAndWalletValue m--font-light">
                                <span>
                                    <s class="finalPriceValue">{{ number_format($invoiceInfo['price']['base']) }}</s>
                                    <br>
                                    مبلغ قابل پرداخت:
                                    <br>
                                    <b class="finalPriceValue">{{ number_format($invoiceInfo['price']['final']) }}</b>
                                    تومان
                                    <hr>
                                    <small class="d-none">
                                        کیف پول شما:
                                        <br>
                                        {{ number_format($credit) }} تومان
                                    </small>
                                </span>
                            </h3>
                        </div>
                        <div class="m-widget27__container m--margin-top-5">

                            <div class="container-fluid">
                                <div class="row">

                                    <div class="col-12">
                                        <div class="m-portlet m-portlet--creative noHeadText m-portlet--bordered m-portlet--full-height">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--accent a--white-space-nowrap">
                                                            <span>
                                                                <i class="fa fa-donate"></i>
                                                                کمک به آلاء
                                                            </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__head-tools"></div>
                                            </div>
                                            <div class="m-portlet__body m--padding-right-5 m--padding-left-5">
                                                <div class="row align-items-center">
                                                    <div class="col-12 d-none">
                                                        <div id="m_nouislider_1"
                                                             class="m-nouislider m-nouislider--handle-danger m-nouislider--drag-danger noUi-target noUi-ltr noUi-horizontal visibleInDonate"></div>
                                                    </div>
                                                    <div class="col-12 m--margin-top-10 text-center addDonateWarper">
                                                        <span class="visibleInDonate"> مبلغ </span>
                                                        <span class="visibleInDonate">
                                                            <input type="text" class="form-control"
                                                                   id="m_nouislider_1_input" placeholder="مقدار کمک"
                                                                   readonly>
                                                        </span>
                                                        <span class="visibleInDonate"> هزار تومان </span>
                                                        <br>
                                                        <span>
                                                            <label for="hasntDonate">
                                                                به آلاء کمک
                                                            </label>
                                                        </span>

                                                        <span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
                                                            <input type="checkbox" data-switch="true"
                                                                   @if(isset($orderHasDonate) && $orderHasDonate)
                                                                   @else
                                                                   checked=""
                                                                   @endif
                                                                   data-on-text="نمی کنم"
                                                                   data-on-color="danger"
                                                                   data-off-text="می کنم"
                                                                   data-off-color="success"
                                                                   data-size="small"
                                                                   {{--data-handle-width="40"--}}id="hasntDonate">

                                                        </span>
                                                        <span>
                                                            <img src="/acm/extra/sad.gif"
                                                                 class="face-sad m--margin-top-20" alt="">
                                                            <img src="/acm/extra/happy.gif"
                                                                 class="face-happy m--margin-top-20" alt="">
                                                        </span>
                                                        <input type="hidden" id="addDonateUrl"
                                                               value="{{ action('Web\OrderController@addOrderproduct' , 180) }}">
                                                        <input type="hidden" id="removeDonateUrl"
                                                               value="{{ action('Web\OrderController@removeOrderproduct' , 180) }}">
                                                        <input type="hidden" id="orderHasDonate"
                                                               @if(isset($orderHasDonate) && $orderHasDonate)
                                                               value="1"
                                                               @else
                                                               value="0"
                                                                @endif>
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

    <div id="invoiceInfo-totalCost" class="d-none">
        {{ $invoiceInfo['price']['final'] }}
    </div>

    <input type="hidden" id="invoiceInfo-couponCode" value="@if(isset($coupon)){{ $coupon['code'] }}@endif">

    <input type="hidden" id="OrderController-submitCoupon" value="{{ action('Web\OrderController@submitCoupon') }}">
    <input type="hidden" id="OrderController-removeCoupon" value="{{ action('Web\OrderController@removeCoupon') }}">

@endsection

@section('page-js')
    <script>
        var notIncludedProductsInCoupon = {!! json_encode($notIncludedProductsInCoupon) !!};
    </script>
    <script src="{{ mix('/js/checkout-payment.js') }}"></script>
@endsection
