@extends("app")

@section("title")
    <title>آلاء|پرداخت</title>
@endsection

@section("metadata")
    @parent
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('pageBar')

@endsection

@section('page-css')
    <style>
        .noUi-handle {
            cursor: pointer;
        }
    </style>
    <style>
        /*fix swithch*/
        .bootstrap-switch {
            line-height: 6px;
        }

        .m-widget27 .m-widget27__pic .m-widget27__title.paymentAndWalletValue > span {
            font-size: 1.5rem;
        }
        #m_nouislider_1_input {
            display: inline-block;
            width: 20px;
            padding: 5px 1px;
            text-align: center;
            height: 30px;
            border: none;
        }
        .m-portlet--creative.noHeadText > .m-portlet__body {
            padding-bottom: 0px;
            position: relative;
            z-index: 9;
        }
        .m-portlet--creative.noHeadText > .m-portlet__head {
            height: 0px;
        }
        .bankLogo {
            max-width: 60px;
            border-radius: 4px;
            box-shadow: 0px 0px 7px 0px #A5A5A5;
        }
        #PaymentType-online .m-radio-inline .m-radio:last-child {
            margin-left: 15px;
        }


        @media (max-width: 1024px) {
            .m-portlet--creative.noHeadText > .m-portlet__body {
                padding-bottom: 2.2rem
            }
        }
    </style>
@endsection

@section('content')


    <div class="row">
        <div class="col-12 col-md-8 order-2 order-sm-2 order-md-1 order-lg-1">

            <div class="m-portlet m-portlet--creative m-portlet--bordered">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                اگر کد تخفیف دارید، در این قسمت وارد کنید:
                            </h3>
                            <h2 class="m-portlet__head-label m-portlet__head-label--accent" style="white-space: nowrap;">
                                <span>
                                    <i class="fa fa-ticket-alt"></i>
                                    کد تخفیف
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col-12 col-md-4 m--padding-top-5">
                            <span>
                                کد تخفیف:
                            </span>
                            <span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
                                <input type="checkbox"
                                       data-switch="true"
                                       checked=""
                                       data-on-text="ندارم"
                                       data-on-color="danger"
                                       data-off-text="دارم"
                                       data-off-color="success"
                                       data-size="small"
                                       {{--data-handle-width="40"--}}
                                       id="hasntDiscountCode">
                            </span>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="input-group discountCodeValueWarper">
                                <input type="text" class="form-control" placeholder="کد تخفیف ..." id="discountCodeValue">
                                <div class="input-group-prepend">
                                    <button class="btn btn-success" type="button">ثبت</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-portlet m-portlet--creative m-portlet--bordered m-portlet--bordered-semi noHeadText">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h2 class="m-portlet__head-label m-portlet__head-label--accent" style="white-space: nowrap;">
                                <span>
                                    <i class="la la-bank"></i>
                                    روش پرداخت
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools"></div>
                </div>
                <div class="m-portlet__body m--padding-bottom-10">



                    <div class="row">
                        <div class="col">
                            <div class="m-form__group form-group">
                                <label for="">
                                    روش پرداخت را مشخص کنید:
                                </label>
                                <div class="m-radio-inline">
                                    <label class="m-radio m-radio--solid m-radio--state-success">
                                        <input type="radio" name="radioPaymentType" value="1" checked>
                                        انترنتی
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--solid m-radio--state-success">
                                        <input type="radio" name="radioPaymentType" value="2">
                                        حضوری
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--solid m-radio--state-success">
                                        <input type="radio" name="radioPaymentType" value="3">
                                        کارت به کارت
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">

                            <div class="m-portlet" id="PaymentType-card2card">
                                <div class="m-portlet__body">
                                    جهت تایید سفارش مبلغ 12،470 تومان به شماره کارت:
                                    <br>
                                    4444-4444-4444-4444
                                    <br>
                                    به نام فلان فلانی بانک فلان واریز نمایید.
                                </div>
                            </div>
                            <div class="m-portlet" id="PaymentType-hozoori">
                                <div class="m-portlet__body">
                                    بعد از ثبت سفارش مبلغ 12،470 تومان را به صورت حضوری پرداخت کنید.
                                </div>
                            </div>
                            <div class="m-portlet" id="PaymentType-online">
                                <div class="m-portlet__body">
                                    <span>
                                        یکی از درگاه های بانکی زیر را انتخاب کنید:
                                    </span>
                                    <div class="m-form__group form-group text-center m--margin-top-10">
                                        <div class="m-radio-inline">
                                            <label class="m-radio m-radio--solid m-radio--state-info">
                                                <input type="radio" name="radioBankType" value="1" checked>
                                                <img src="/acm/extra/payment/gateway/zarinpal-logo.png" class="img-thumbnail bankLogo">
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--state-info">
                                                <input type="radio" name="radioBankType" value="2">
                                                <img src="/acm/extra/payment/gateway/mellat-logo.png" class="img-thumbnail bankLogo">
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--state-info">
                                                <input type="radio" name="radioBankType" value="3">
                                                <img src="/acm/extra/payment/gateway/pasargad-logo.jpg" class="img-thumbnail bankLogo">
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                </div>
            </div>

        </div>
        <div class="col-12 col-md-4 order-1 order-sm-1 order-md-2 order-lg-2">

            <div class="m-portlet m-portlet--head-overlay  m-portlet--full-heigh m-portlet--rounded-force">
                <div class="m-portlet__head m-portlet__head--fit-">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">

                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__pic">
                            <img src="/assets/app/media/img//bg/bg-4.jpg" alt="">
                            <h3 class="m-widget27__title text-center paymentAndWalletValue m--font-light">
                                <span>
                                    مبلغ قابل پرداخت:
                                    12،470
                                </span>
                            </h3>
                        </div>
                        <div class="m-widget27__container m--margin-top-5">

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="m-portlet m-portlet--creative noHeadText m-portlet--bordered m-portlet--full-height m--margin-top-25" >
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--accent" style="white-space: nowrap;">
                                                <span>
                                                    <i class="fa fa-wallet"></i> کیف پول
                                                </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__head-tools">
                                                </div>
                                            </div>
                                            <div class="m-portlet__body m--padding-right-5 m--padding-left-5 text-center" style="font-size: 13px;font-weight: bold;">

                                                <div>
                                                    <span>
                                                        کیف پول شما:
                                                        8،250
                                                    </span>
                                                </div>
                                                <div class="m--margin-top-20">
                                                    <span> از کیف پول استفاده: </span>
                                                    <span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
                                                        <input type="checkbox"
                                                               data-switch="true"
                                                               {{--checked="checked"--}}
                                                               data-on-text="نمی کنم"
                                                               data-on-color="danger"
                                                               data-off-text="می کنم"
                                                               data-off-color="success"
                                                               data-size="small">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-portlet m-portlet--creative noHeadText m-portlet--bordered m-portlet--full-height">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--accent" style="white-space: nowrap;">
                                                            <span>
                                                                <i class="fa fa-donate"></i>
                                                                کمک به آلاء
                                                            </span>
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__head-tools">
                                                </div>
                                            </div>
                                            <div class="m-portlet__body m--padding-right-5 m--padding-left-5">
                                                <div class="row align-items-center">
                                                    <div class="col-12">
                                                        <div id="m_nouislider_1" class="m-nouislider m-nouislider--handle-danger m-nouislider--drag-danger noUi-target noUi-ltr noUi-horizontal visibleInDonate"></div>
                                                    </div>
                                                    <div class="col-12 m--margin-top-10 text-center">
                                                        <span class="visibleInDonate"> مبلغ </span>
                                                        <span class="visibleInDonate">
                                                            <input type="text" class="form-control" id="m_nouislider_1_input" placeholder="مقدار کمک" readonly>
                                                        </span>
                                                        <span class="visibleInDonate"> هزار تومان </span>
                                                        <br>
                                                        <span> به آلاء کمک </span>
                                                        <span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
                                                            <input type="checkbox"
                                                                   data-switch="true"
                                                                   checked=""
                                                                   data-on-text="نمی کنم"
                                                                   data-on-color="danger"
                                                                   data-off-text="می کنم"
                                                                   data-off-color="success"
                                                                   data-size="small"
                                                                   {{--data-handle-width="40"--}}
                                                                   id="hasntDonate">
                                                        </span>
                                                        <span>
                                                            <img src="/acm/extra/sad.png" class="face-sad m--margin-top-20" alt="">
                                                            <img src="/acm/extra/happy.png" class="face-happy m--margin-top-20" alt="">
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



    <br>
    <br>
    <br>
    <br>
    <br>













    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered ">
                <div class="portlet-body">
                    <div class="row">
                        @include("partials.checkoutSteps" , ["step"=>3])
                        <div class="col-md-12">
                            <div class="portlet dark box">
                                <div class="portlet-title">
                                    <div class="caption">
                                        @if(session()->has("adminOrder_id"))
                                            ثبت نهایی سفارش
                                            برای {{Session::get("customer_firstName")}} {{Session::get("customer_lastName")}}
                                        @else
                                            پرداخت
                                        @endif
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    {{--<div class="row static-info margin-top-20">--}}
                                    @include("systemMessage.flash")
                                    {{--</div>--}}

                                    <div class="row margin-top-10">
                                        @if(!isset($coupon))
                                            <div class="col-lg-3 col-md-3 col-sd-3 col-xs-12 text-center">
                                                <input type="checkbox" class="make-switch"
                                                       data-on-text="&nbsp;کد&nbsp;تخفیف&nbsp;دارم&nbsp;"
                                                       data-off-text="&nbsp;کد&nbsp;تخفیف&nbsp;ندارم&nbsp;"
                                                       id="couponSwitch">
                                            </div>
                                        @endif
                                        <div class="col-lg-9 col-md-9 col-sd-9 col-xs-12"
                                             @if(!isset($coupon)) style="display: none" id="couponForm" @endif>
                                            {{--                                            {!! Form::open(['method' => 'POST','action' => ['OrderController@submitCoupon'] , 'class'=>'form-horizontal' ]) !!}--}}
                                            <div class="form-group">
                                                <label class="col-lg-2 col-md-2 col-sm-2 col-xs-12 control-label"
                                                       for="gateway" style="text-align: right">کد تخفیف </label>
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                    <div class="input-group">
                                                        @if(isset($coupon))
                                                            {!! Form::text('coupon',$coupon->code,['class' => 'form-control' , ]) !!}
                                                        @else
                                                            {!! Form::text('coupon',null,['class' => 'form-control' ]) !!}
                                                        @endif
                                                        <span class="input-group-btn">
                                                                        @if(isset($coupon))
                                                                <a href="{{action("Web\OrderController@removeCoupon")}}"
                                                                   class="btn red">حذف کد تخفیف</a>
                                                            @else
                                                                {!! Form::submit('ثبت کد تخفیف',['class' => 'btn blue']) !!}
                                                            @endif
                                                                        </span>
                                                    </div>
                                                </div>
                                                @if(isset($coupon))
                                                    <div class="col-lg-12">
                                                        <span class="help-block small bold font-green">
                                                            @if($coupon->discounttype->id == Config::get("constants.DISCOUNT_TYPE_COST"))
                                                                کپن تخفیف  {{$coupon->name}}
                                                                با {{number_format($coupon->discount)}}
                                                                تومان تخفیف برای سفارش شما ثبت شد.
                                                            @else
                                                                کپن تخفیف {{$coupon->name}}
                                                                با {{$coupon->discount}}% تخفیف برای
                                                                سفارش شما ثبت شده است.
                                                            @endif
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="col-lg-12">
                                                        <span class="help-block font-blue small bold">پس از وارد کردن کد و زدن دکمه ثبت میزان تخفیف در مبلغ قابل پرداخت اعمال خواهد شد</span>
                                                    </div>
                                                @endif
                                            </div>
                                            {{--                                            {!! Form::close() !!}--}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            {{--                                            {!! Form::open(['method' => 'POST','action' => ['OrderController@addOrderproduct' , 180] , 'class'=>'form-horizontal' , 'id'=>'donateForm' ]) !!}--}}
                                            <label for="donateSwitch">5 هزار تومان مشارکت می کنم در هزینه های
                                                آلاء</label>
                                            <input type="hidden" name="mode" value="normal">
                                            <input type="checkbox"
                                                   @if(isset($orderHasDonate) && $orderHasDonate) checked
                                                   @endif  id="donateSwitch" value="" class="make-switch"
                                                   data-off-color="danger" data-on-color="success"
                                                   data-off-text="&nbsp;کمک&nbsp;نمی&nbsp;کنم&nbsp;"
                                                   data-on-text="&nbsp;کمک&nbsp;می&nbsp;کنم&nbsp;">
                                            {{--                                            {!! Form::close() !!}--}}
                                        </div>
                                    </div>
                                    <hr>
                                    @if(session()->has("adminOrder_id") )
                                        <div class="row">
                                            {{--                                            {!! Form::open(['method' => 'GET','action' => ['OrderController@verifyPayment'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}--}}
                                            <div class="form-group">
                                                <div class="col-lg-12" style="text-align: center;">
                                                    <span class="label bg-green-soft" style="font-size: 15px">مبلغ قابل پرداخت: {{number_format($cost)}}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12" style="text-align: center;">
                                                    <a href="{{action("Web\OrderController@checkoutReview")}}"
                                                       class="btn dark btn-outline"><i class="fa fa-chevron-right"
                                                                                       aria-hidden="true"></i>بازبینی</a>
                                                    <button type="submit" class="btn green btn-outline">ثبت نهایی
                                                    </button>
                                                </div>
                                                {!! Form::hidden('paymentmethod','inPersonPayment') !!}
                                            </div>
                                            {{--                                            {!! Form::close() !!}--}}
                                        </div>
                                    @elseif(!isset($invoiceInfo["totalCost"]) || $invoiceInfo["totalCost"] == 0)
                                        <div class="row">
                                            {{--                                            {!! Form::open(['method' => 'GET','action' => ['OrderController@verifyPayment'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}--}}
                                            <div class="col-md-12 margin-top-20">
                                                {!! Form::textarea('customerDescription',null,['class' => 'form-control' , 'placeholder'=>'اگر توضیحی درباره سفارش خود دارید لطفا اینجا بنویسید' , 'rows'=>'3']) !!}
                                            </div>
                                            <div class="col-md-12 margin-top-40" style="text-align: center;">
                                                    <span class="label bg-green-soft" style="font-size: 15px">
                                                        {{--مبلغ قابل پرداخت: {{number_format($invoiceInfo["totalCost"])}}--}}
                                                        15000
                                                    </span>
                                            </div>
                                            <div class="col-md-12 margin-top-20" style="text-align: center;">
                                                <a href="{{action("Web\OrderController@checkoutReview")}}"
                                                   class="btn dark btn-outline" style="width: 100px"><i
                                                            class="fa fa-chevron-right"
                                                            aria-hidden="true"></i>بازبینی</a>
                                                <button type="submit" class="btn green btn-outline"
                                                        style="width: 100px">ثبت نهایی
                                                </button>
                                            </div>
                                            {{--                                            {!! Form::close() !!}--}}
                                        </div>
                                    @else
                                        <div class="row">
                                            {!! Form::open(['method' => 'POST','action' => ['TransactionController@create'] , 'id'=>'paymentForm' , 'class'=>'form-horizontal' ]) !!}
                                            <div class="form-group text-center">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                                    <label class="col-lg-5 col-md-5 col-sd-5 col-xs-5 text-center control-label"
                                                           style="text-align: center" for="gateway">روش پرداخت </label>
                                                    <div class="col-lg-7 col-md-7 col-sd-7 col-xs-7">
                                                        {{--{!! Form::select('paymentmethod',["onlinePayment" => "آنلاین"],null,['class' => 'form-control' , 'id'=>'paymentMethod']) !!}--}}
                                                        <text class="form-control-static bold"> آنلاین</text>
                                                        {!! Form::hidden('paymentmethod', 'onlinePayment' , ['id'=>'paymentMethod']) !!}
                                                    </div>

                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 " id="gatewayDiv">
                                                    <label class="col-lg-5 col-md-5 col-sd-5 col-xs-5 control-label"
                                                           style="text-align: center" for="gateway">انتخاب
                                                        درگاه </label>
                                                    <div class="col-lg-7 col-md-7 col-sd-7 col-xs-7">
                                                        {!! Form::select('gateway',$gateways,null,['class' => 'form-control' , 'id'=>'gatewaySelect' ]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-3 col-md-3">
                                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left control-label bold font-blue-sharp"
                                                           style="text-align: center ; font-size: medium">
                                                        کیف پول شما: {{number_format($credit)}} تومان
                                                    </label>
                                                    @if($credit > 0 )
                                                        {!! Form::hidden('payByWallet',1 ) !!}
                                                    @endif
                                                    @if(isset($coupon))
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                            <span class="bold font-blue-sharp"
                                                                  style="font-size: 15px; padding: 0px 5px 0px 5px;">
                                                                {{($credit>0)?"جمع کل:":"مبلغ قابل پرداخت:"}}
                                                                <lable id="totalCost"
                                                                       style="text-decoration: line-through;">
                                                                    {{--{{number_format($invoiceInfo["totalCost"])}}--}}
                                                                    15000
                                                                </lable>
                                                            تومان
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                            <span class="bold font-red"
                                                                  style="padding: 0px 5px 0px 5px; font-size: 15px">
                                                                    {{--برای شما {{number_format($invoiceInfo["totalCost"])}} تومان--}}
                                                                15000
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                            <span class="bold font-blue-sharp" style="font-size: 15px">
                                                                {{($credit>0)?"جمع کل:":"مبلغ قابل پرداخت:"}}
                                                                <lable id="totalCost">
                                                                    {{--{{number_format($invoiceInfo["totalCost"])}}--}}
                                                                    15000
                                                                </lable>
                                                            تومان
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if($credit > 0)
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                        <span class="bold font-blue-sharp" style="font-size: 15px">
                                                            استفاده از کیف پول:
                                                                    <lable id="totalCost">
                                                                        {{number_format($invoiceInfo["paidByWallet"])}}
                                                                    </lable>
                                                                    تومان
                                                        </span>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 margin-top-20 text-left">
                                                            <span class="bold font-blue-sharp" style="font-size: 15px">مبلغ قابل پرداخت:
                                                                        <lable id="totalCost">
                                                                            {{--{{number_format( $invoiceInfo["payableCost"])}}--}}
                                                                            15000
                                                                        </lable>
                                                                        تومان
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg-9 col-md-9" style="    padding: 0px 30px 0px 30px;">
                                                    {!! Form::textarea('customerDescription',null,['class' => 'form-control' , 'placeholder'=>'اگر توضیحی درباره سفارش خود دارید اینجا بنویسید' , 'rows'=>'3']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12 col-md-12 margin-top-10 text-center">
                                                    <a href="{{action("Web\OrderController@checkoutReview")}}"
                                                       class="btn dark btn-outline" style="width: 100px">
                                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                        بازبینی
                                                    </a>
                                                    <button type="submit" class="btn green btn-outline"
                                                            style="width: 100px">
                                                        {{--{{($invoiceInfo["payableCost"] == 0)?"ثبت نهایی":"پرداخت"}}--}}
                                                        15000
                                                    </button>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <br/>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')

    <script src="{{ mix('/js/checkout-payment.js') }}"></script>

    <script>

        jQuery(document).ready(function () {
            function refreshUi() {
                refreshUiBasedOnPaymentType();
                refreshUiBasedOnDonateStatus();
                refreshUiBasedOnHasntDiscountCodeStatus();
            }
            function refreshUiBasedOnPaymentType() {
                let radioPaymentType = $('input[type="radio"][name="radioPaymentType"]:checked').val();
                if (radioPaymentType==1) {
                    $('#PaymentType-online').slideDown();
                    $('#PaymentType-hozoori').slideUp();
                    $('#PaymentType-card2card').slideUp();
                } else if (radioPaymentType==2) {
                    $('#PaymentType-online').slideUp();
                    $('#PaymentType-hozoori').slideDown();
                    $('#PaymentType-card2card').slideUp();
                } else if (radioPaymentType==3) {
                    $('#PaymentType-online').slideUp();
                    $('#PaymentType-hozoori').slideUp();
                    $('#PaymentType-card2card').slideDown();
                }
            }
            function donate() {
                $('.face-sad').fadeOut(0);
                $('.face-happy').fadeIn(0);
                $('.visibleInDonate').css({'visibility':'visible'});
            }
            function dontdonate() {
                $('.face-sad').fadeIn(0);
                $('.face-happy').fadeOut(0);
                $('.visibleInDonate').css({'visibility':'hidden'});
            }
            function getDonateStatus() {
                let switchStatus = $('#hasntDonate').prop('checked');
                if(switchStatus) {
                    return false;
                } else {
                    return true;
                }
            }

            function refreshUiBasedOnDonateStatus() {
                if(getDonateStatus()) {
                    donate();
                } else {
                    dontdonate();
                }
            }
            function refreshUiBasedOnHasntDiscountCodeStatus() {
                $('#discountCodeValue').val('');
                if(!$('#hasntDiscountCode').prop('checked')) {
                    $('.discountCodeValueWarper').fadeIn();
                } else {
                    $('.discountCodeValueWarper').fadeOut();
                }
            }

            refreshUi();
            $(document).on('change', 'input[type="radio"][name="radioPaymentType"]', function(e) {
                refreshUiBasedOnPaymentType();
            });
            $(document).on('switchChange.bootstrapSwitch', '#hasntDiscountCode', function(e) {
                refreshUiBasedOnHasntDiscountCodeStatus();
            });
            $(document).on('switchChange.bootstrapSwitch', '#hasntDonate', function(e) {
                refreshUiBasedOnDonateStatus();
            });
            var e = document.getElementById("m_nouislider_1");
            noUiSlider.create(e, {
                start: [5],
                connect: [!0, !1],
                step: 1,
                range: {min: [1], max: [50]},
                format: wNumb({decimals: 0})
            });
            var n = document.getElementById("m_nouislider_1_input");
            e.noUiSlider.on("update", function (e, t) {
                n.value = e[t];
                refreshUiBasedOnDonateStatus();
            }), n.addEventListener("change", function () {
                e.noUiSlider.set(this.value)
            });
        });
    </script>
    {{--<script src="/js/extraJS/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>--}}
    {{--<script type="text/javascript">--}}
    {{--/**--}}
    {{--* Set token for ajax request--}}
    {{--*/--}}
    {{--$(function () {--}}
    {{--$.ajaxSetup({--}}
    {{--headers: {--}}
    {{--'X-CSRF-TOKEN': window.Laravel.csrfToken,--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}

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