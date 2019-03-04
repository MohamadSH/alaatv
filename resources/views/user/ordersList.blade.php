@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section('page-css')
    {{--<link href="{{ mix('/css/user-profile.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/assets/vendors/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                سفارش های من
            </li>
        </ol>
    </nav>

@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            @include("systemMessage.flash")
            @if(isset($debitCard))
                <p class="list-group-item  bg-blue-soft bg-font-blue-soft" style="text-align: justify;"> شماره کارت برای
                    واریز کارت به کارت مبلغ: <span dir="ltr">{{$debitCard->cardNumber}}</span>
                    به نام @if(!isset($debitCard->user->firstName) && !isset($debitCard->user->lastName)) کاربر
                    ناشناس @else @if(isset($debitCard->user->firstName)) {{$debitCard->user->firstName}} @endif @if(isset($debitCard->user->lastName)) {{$debitCard->user->lastName}} @endif @endif
                    بانک {{$debitCard->bank->name}}
                </p>
            @endif
            <div class="portlet light ">
                <div class="tabbable-custom ">
                    <div class="portlet-title">
                        {{--<div class="caption font-yellow-casablanca">--}}
                        {{--<i class="fa fa-list-alt font-yellow-casablanca" aria-hidden="true"></i>--}}
                        {{--<span class="caption-subject  bold uppercase">لیست سفارش های شما</span>--}}
                        {{--</div>--}}
                        {{--<div class="tools"> </div>--}}
                        <ul class="nav nav-tabs ">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab" class="caption-subject  bold uppercase">لیست سفارش
                                    های شما</a>
                            </li>
                            <li>
                                <a href="#tab_2" data-toggle="tab" class="caption-subject  bold uppercase"> لیست تراکنش
                                    های شما</a>
                            </li>
                            @if(isset($instalments) && $instalments->isNotEmpty())
                                <li>
                                    <a href="#tab_3" data-toggle="tab" class="caption-subject  bold uppercase"> لیست قسط
                                        های شما</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                @if(!isset($orders))
                                    <div class="alert alert-info" style="text-align: center">
                                        <h3>شما تاکنون سفارشی ثبت نکرده اید </h3>
                                    </div>
                                @else
                                    <table class="table table-striped table-bordered table-hover dt-responsive"
                                           width="100%" id="orders_table">
                                        <div id="onlinePaymentModal" class="modal fade" tabindex="-1"
                                             data-backdrop="static" data-keyboard="false">
                                            <div class="modal-header">انتقال به درگاه بانکی</div>
                                            {!! Form::open(['method' => 'GET','action' => ['Web\OnlinePaymentController@paymentRedirect', 'paymentMethod'=>'web', 'device'=>'desktop-mobile']]) !!}
                                            {!! Form::hidden('order_id',null) !!}
                                            {!! Form::hidden('transaction_id',null , ["disabled"]) !!}
                                            <div class="modal-body">
                                                <div class="row static-info margin-top-20" id="gatewayDiv">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="gateway">انتخاب درگاه
                                                            :</label>
                                                        <div class="col-md-7">
                                                            {!! Form::select('gateway',$gateways,null,['class' => 'form-control' , 'id'=>'gatewaySelect' ]) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row static-info margin-top-40" style="text-align: center;">
                                                    <span class="label label-success" style="font-size: 15px"
                                                          id="orderCost"></span>
                                                </div>
                                                {{--<div class="row static-info margin-top-20" style="text-align: center;">--}}
                                                {{--<button type="submit"  class="btn green btn-outline">پرداخت</button>--}}
                                                {{--</div>--}}

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-outline dark"
                                                        id="sendSmsForm-close">بستن
                                                </button>
                                                <button type="submit" class="btn green">انتقال به درگاه پرداخت</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div id="ATMPaymentModal" class="modal fade" tabindex="-1"
                                             data-backdrop="static" data-keyboard="false">
                                            <div class="modal-header">ثبت اطلاعات رسید عابر بانک</div>
                                            {!! Form::open(['method' => 'POST','action' => ['Web\TransactionController@store'], 'id'=>'offlinePaymentForm']) !!}
                                            {!! Form::hidden('order_id',null) !!}
                                            {!! Form::hidden('transaction_id',null , ["disabled"]) !!}
                                            {!! Form::hidden('paymentMethodName','ATM') !!}
                                            {!! Form::hidden('paymentmethod_id', Config::get("constants.PAYMENT_METHOD_ATM")) !!}
                                            <div class="modal-body">
                                                <div class="row static-info margin-top-20">
                                                    <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
                                                        <label class="col-md-4 control-label" for="cost">مبلغ واریز
                                                            شده(تومان):</label>
                                                        <div class="col-md-7">
                                                            {!! Form::text('cost',old('cost'),['class' => 'form-control' , 'id'=>"ATMTransactionCost" , 'dir'=>'ltr' ]) !!}
                                                            <text class="form-control-static font-blue"
                                                                  id="ATMTransactionCost-static"></text>
                                                            @if ($errors->has('cost'))
                                                                <span class="help-block">
                                                                <strong>{{ $errors->first('cost') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row static-info margin-top-20">
                                                    <div class="col-md-12">
                                                        <span class="label label-info ">کاربر گرامی</span>
                                                        <span class="bold bold font-blue-dark">یکی از دو شماره ی زیر را از رسید عابر بانک با دقت وارد نموده و ثبت اطلاعات را بزنید .</span>
                                                    </div>
                                                </div>
                                                <div class="mt-radio-list">
                                                    <div class="row static-info margin-top-20">
                                                        <div class="form-group {{ $errors->has('referenceNumber') ? ' has-error' : '' }}">
                                                            <div class="col-md-4">
                                                                <label class="mt-radio mt-radio-outline control-label">
                                                                    شماره مرجع/ارجاع:
                                                                    <input type="radio" value="referenceNumber"
                                                                           class="ATMRadio" name="ATMRadio" checked/>
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                {!! Form::text('referenceNumber',old('referenceNumber'),['class' => 'form-control', 'dir'=>'ltr' ]) !!}
                                                                @if ($errors->has('referenceNumber'))
                                                                    <span class="help-block">
                                                                    <strong>{{ $errors->first('referenceNumber') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info margin-top-20">
                                                        <div class="form-group {{ $errors->has('traceNumber') ? ' has-error' : '' }}">
                                                            <div class="col-md-4">
                                                                <label class="mt-radio mt-radio-outline control-label">
                                                                    شماره پیگیری:
                                                                    <input type="radio" value="traceNumber"
                                                                           class="ATMRadio" name="ATMRadio"/>
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                {!! Form::text('traceNumber',old('traceNumber'),['class' => 'form-control' , 'disabled'=>'true', 'dir'=>'ltr' ]) !!}
                                                                @if ($errors->has('traceNumber'))
                                                                    <span class="help-block">
                                                                <strong>{{ $errors->first('traceNumber') }}</strong>
                                                            </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-outline dark"
                                                        id="sendSmsForm-close">بستن
                                                </button>
                                                <button type="submit" class="btn green">ثبت اطلاعات</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="all">وضعیت سفارش</th>
                                            <th class="min-tablet">وضعیت پرداخت</th>
                                            <th class="all">مبلغ(تومان)</th>
                                            <th class="min-desktop">پرداخت شده(تومان)</th>
                                            <th class="desktop">تاریخ ثبت نهایی</th>
                                            <th class="none">محصولات:</th>
                                            <th class="none">کد مرسوله پست شده</th>
                                            <th class="none"> تراکنش های موفق</th>
                                            <th class="none">تراکنش های منتظر تایید</th>
                                            <th class="none">قسط های پرداخت نشده</th>
                                            <th class="none">بدهی(تومان)</th>
                                            <th class="none">توضیح شما</th>
                                            <th class="none">کپن استفاده شده:</th>
                                            <th class="none">تعداد بن استفاده شده:</th>
                                            <th class="none">تعداد بن اضافه شده به شما از این سفارش:</th>
                                            <th class="none">تاریخ ایجاد اولیه</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <th></th>
                                                <td style="text-align: center;">
                                                    @if(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_CLOSED"))
                                                        <span class="label label-success"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_CANCELED"))
                                                        <span class="label label-danger"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_POSTED") )
                                                        <span class="label label-info"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_REFUNDED") )
                                                        <span class="label bg-grey-salsa"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_READY_TO_POST") )
                                                        <span class="label label-info"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_PENDING") )
                                                        <span class="label bg-purple"> {{$order->orderstatus->displayName}}</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @if(isset($order->paymentstatus->id) && $order->paymentstatus->id == Config::get("constants.PAYMENT_STATUS_PAID"))
                                                        <span class="label label-success"> {{$order->paymentstatus->displayName}}</span>
                                                    @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == Config::get("constants.PAYMENT_STATUS_UNPAID"))
                                                        <span class="label bg-yellow-gold"> {{$order->paymentstatus->displayName}}</span>
                                                        @if(isset($order->orderstatus->id) && ($order->orderstatus->id == Config::get("constants.ORDER_STATUS_CLOSED") ||
                                                            $order->orderstatus->id == Config::get("constants.ORDER_STATUS_POSTED")) )
                                                            <div class="btn-group pull-right">
                                                                <button class="btn btn-xs dark btn-outline onlinePayment"
                                                                        data-target="#onlinePaymentModal"
                                                                        data-toggle="modal" rel="{{$order->id}}">پرداخت
                                                                    {{--<i class="fa fa-credit-card-alt"></i>--}}
                                                                </button>
                                                                {{--<button class="btn btn-xs dark btn-outline dropdown-toggle" data-toggle="dropdown" aria-expanded="false">پرداخت--}}
                                                                {{--<i class="fa fa-angle-down"></i>--}}
                                                                {{--</button>--}}
                                                                {{--<button class="btn btn-xs dark btn-outline dropdown-toggle" data-toggle="dropdown" aria-expanded="false">پرداخت--}}
                                                                {{--<i class="fa fa-angle-down"></i>--}}
                                                                {{--</button>--}}
                                                                {{--<ul class="dropdown-menu pull-right">--}}
                                                                {{--<li>--}}
                                                                {{--<a  data-target="#onlinePaymentModal"  data-toggle="modal"  class="onlinePayment" rel="{{$order->id}}">پرداخت آنلاین</a>--}}
                                                                {{--</li>--}}
                                                                {{--<li>--}}
                                                                {{--<a  data-target="#ATMPaymentModal"  data-toggle="modal"  class="ATMPayment" id="ATMPayment-button" rel="{{$order->id}}">کارت به کارت</a>--}}
                                                                {{--</li>--}}
                                                                {{--</ul>--}}
                                                            </div>
                                                        @endif
                                                    @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == Config::get("constants.PAYMENT_STATUS_INDEBTED"))
                                                        <span class="label label-warning"> {{$order->paymentstatus->displayName}}</span>
                                                        <div class="btn-group pull-right">
                                                            <button class="btn btn-xs dark btn-outline onlinePayment"
                                                                    data-target="#onlinePaymentModal"
                                                                    data-toggle="modal" rel="{{$order->id}}">پرداخت
                                                                {{--<i class="fa fa-credit-card-alt"></i>--}}
                                                            </button>
                                                            {{--<button class="btn btn-xs dark btn-outline dropdown-toggle" data-toggle="dropdown" aria-expanded="false">پرداخت--}}
                                                            {{--<i class="fa fa-angle-down"></i>--}}
                                                            {{--</button>--}}
                                                            {{--<ul class="dropdown-menu pull-right">--}}
                                                            {{--<li>--}}
                                                            {{--<a  data-target="#onlinePaymentModal"  data-toggle="modal"  class="onlinePayment" rel="{{$order->id}}">پرداخت آنلاین</a>--}}
                                                            {{--</li>--}}
                                                            {{--<li>--}}
                                                            {{--<a  data-target="#ATMPaymentModal"  data-toggle="modal"  class="ATMPayment" id="ATMPayment-button" rel="{{$order->id}}">کارت به کارت</a>--}}
                                                            {{--</li>--}}
                                                            {{--</ul>--}}
                                                        </div>
                                                    @else
                                                        <span class="label label-info">ندارد</span>
                                                    @endif

                                                </td>
                                                <td>@if(isset($order->cost) || isset($order->costwithoutcoupon)){{number_format($order->totalCost() )}} @else
                                                        <span class="label label-info">بدون مبلغ</span> @endif</td>
                                                <td>@if(isset($order->cost) || isset($order->costwithoutcoupon)){{number_format($order->totalPaidCost() + $order->totalRefund())}} @else
                                                        <span class="label label-info">بدون مبلغ</span> @endif</td>
                                                <td>@if(isset($order->completed_at)) {{$order->CompletedAt_Jalali()}} @else
                                                        <span class="label label-info">درج نشده</span> @endif</td>
                                                <td>@if($order->orderproducts)
                                                        <br>
                                                        @foreach($order->orderproducts as $orderproduct)
                                                            @if(isset($orderproduct->product->id))
                                                                <span class="bold " style="font-style: italic; ">@if($orderproduct->orderproducttype_id == Config::get("constants.ORDER_PRODUCT_GIFT"))
                                                                        <img src="/acm/extra/gift-box.png"
                                                                             width="25">@endif<a style="color:#607075"
                                                                                                 target="_blank" href = "@if($orderproduct->product->hasParents()){{action("Web\ProductController@show",$orderproduct->product->parents->first())}} @else  {{action("Web\ProductController@show",$orderproduct->product)}} @endif">
                                                                    {{$orderproduct->product->name}}
                                                                </a></span><br>

                                                                @foreach($orderproduct->product->attributevalues('main')->get() as $attributevalue)
                                                                    {{$attributevalue->attribute->displayName}} : <span
                                                                            style="font-weight: normal">{{$attributevalue->name}} @if(isset(   $attributevalue->pivot->description) && strlen($attributevalue->pivot->description)>0 ) {{$attributevalue->pivot->description}} @endif</span>
                                                                    <br>
                                                                @endforeach
                                                                @foreach($orderproduct->attributevalues as $extraAttributevalue)
                                                                    {{$extraAttributevalue->attribute->displayName}} :
                                                                    <span style="font-weight: normal">{{$extraAttributevalue->name}}
                                                                        (+ {{number_format($extraAttributevalue->pivot->extraCost)}}
                                                                        تومان)</span><br>
                                                                @endforeach

                                                                <br>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <span class="label label-danger">ندارد</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!$order->orderpostinginfos->isEmpty())
                                                        <span class="font-red bold">
                                                        @foreach($order->orderpostinginfos as $postingInfo)
                                                                {{$postingInfo->postCode}}<br>
                                                            @endforeach</span>
                                                    @else
                                                        <span class="label label-info">پست نشده</span>
                                                    @endif
                                                </td>
                                                <td>@if($order->successfulTransactions->isEmpty())
                                                        <span class="label label-warning">تراکنشی یافت نشد</span>
                                                    @else
                                                        <br>
                                                        @foreach($order->successfulTransactions as $successfulTransaction)
                                                            @if(isset($successfulTransaction->paymentmethod->displayName)) {{ $successfulTransaction->paymentmethod->displayName}} @else
                                                                <span class="label label-danger">- نحوه پرداخت نامشخص</span> @endif
                                                            @if($successfulTransaction->getGrandParent() === false)
                                                                @if($successfulTransaction->getCode() !== false)
                                                                    - {{$successfulTransaction->getCode()}} @endif
                                                                - مبلغ: @if($successfulTransaction->cost >= 0)
                                                                    {{ number_format($successfulTransaction->cost) }}
                                                                    <br>
                                                                @else
                                                                    {{ number_format(-$successfulTransaction->cost) }}
                                                                    (دریافت) <br>
                                                                @endif
                                                            @else
                                                                @if($successfulTransaction->getGrandParent()->getCode() === false)
                                                                    - کد نامشخص @else
                                                                    - {{$successfulTransaction->getGrandParent()->getCode()}} @endif
                                                                -
                                                                مبلغ: @if($successfulTransaction->getGrandParent()->cost >= 0)
                                                                    {{ number_format($successfulTransaction->getGrandParent()->cost) }}
                                                                    <br>
                                                                @else
                                                                    {{ number_format(-$successfulTransaction->getGrandParent()->cost) }}
                                                                    (پرداخت) <br>
                                                                @endif
                                                            @endif

                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>@if($order->pendingTransactions->isEmpty())
                                                        <span class="label label-success">تراکنشی یافت نشد</span>
                                                    @else
                                                        <br>
                                                        @foreach($order->pendingTransactions as $pendingTransaction)
                                                            @if(isset($pendingTransaction->paymentmethod->displayName)) {{$pendingTransaction->paymentmethod->displayName}} @endif
                                                            @if(isset($pendingTransaction->transactionID))  ,شماره
                                                            تراکنش: {{ $pendingTransaction->transactionID }}
                                                            مبلغ: {{ number_format($pendingTransaction->cost) }}@endif
                                                            @if(isset($pendingTransaction->traceNumber))  ,شماره
                                                            پیگیری:{{$pendingTransaction->traceNumber}}
                                                            مبلغ: {{ number_format($pendingTransaction->cost) }}@endif
                                                            @if(isset($pendingTransaction->referenceNumber))  ,شماره
                                                            مرجع:{{$pendingTransaction->referenceNumber}}
                                                            مبلغ: {{ number_format($pendingTransaction->cost) }}@endif
                                                            @if(isset($pendingTransaction->paycheckNumber))  ,شماره
                                                            چک:{{$pendingTransaction->paycheckNumber}}
                                                            مبلغ: {{ number_format($pendingTransaction->cost) }}@endif
                                                            {{--,توضیح مدیریتی: @if(strlen($pendingTransaction->managerComment)>0) <span class="bold font-blue">{{$pendingTransaction->managerComment}}</span>  @else <span class="label label-warning">ندارد</span>@endif--}}
                                                            <br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>@if($order->unpaidTransactions->isEmpty())
                                                        <span class="label label-success">قسطی ندارید</span>
                                                    @else
                                                        <br>
                                                        @foreach($order->unpaidTransactions as $instalment)
                                                            @if($instalment->cost)
                                                                مبلغ: {{ number_format($instalment->cost) }}@endif
                                                            مهلت
                                                            پرداخت: @if(isset($instalment->deadline_at)){{$instalment->DeadlineAt_Jalali()}}@endif
                                                            {{--,توضیح مدیریتی: @if(strlen($instalment->managerComment)>0) <span class="bold font-blue">{{$instalment->managerComment}}</span>  @else <span class="label label-warning">ندارد</span>@endif--}}
                                                            <br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td id="cost_{{$order->id}}">@if(isset($order->cost)|| isset($order->costwithoutcoupon)){{number_format($order->debt())}} @else
                                                        0 @endif</td>
                                                <td>
                                                    @if(isset($order->customerDescription) && strlen($order->customerDescription)>0)
                                                        <span class="font-red bold">{{$order->customerDescription}}</span>
                                                    @else
                                                        <span class="label label-warning">بدون توضیح</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(isset($orderCoupons[$order->id]))
                                                        {{$orderCoupons[$order->id]["caption"]}}
                                                    @else
                                                        <span class="label label-info">کپن ندارد</span>
                                                    @endif
                                                </td>
                                                <td>{{$order->usedBonSum()}}</td>
                                                <td>
                                                    @if($order->orderproducts->isNotEmpty())
                                                        {{$order->addedBonSum()}}

                                                    @else
                                                        <span class="label label-info">سفارش خالی است!</span>
                                                    @endif
                                                </td>
                                                <td>@if(isset($order->created_at)) {{$order->CreatedAt_Jalali()}} @else
                                                        <span class="label label-info">درج نشده</span> @endif</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <div class="tab-pane" id="tab_2">
                                <div class="panel-group accordion scrollable" id="accordion2">
                                    @foreach($transactions as $key=>$transactionArray)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion2" href="#collapse_{{$key}}"> سفارش
                                                        #{{$key}} </a>
                                                </h4>
                                            </div>
                                            <div id="collapse_{{$key}}" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="table-scrollable table-scrollable-borderless">
                                                        <table class="table table-hover table-light">
                                                            <thead>
                                                            <tr class="uppercase">
                                                                <th> نحوه پرداخت</th>
                                                                <th> وضعیت</th>
                                                                <th> شناسه</th>
                                                                <th> مبلغ تراکنش (تومان)</th>
                                                                <th> نوع</th>
                                                                <th> تاریخ پرداخت</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($transactionArray as $transaction)
                                                                <tr>
                                                                    <td>@if(isset($transaction->paymentmethod))
                                                                            {{$transaction->paymentmethod->displayName}}
                                                                            @if($transaction->paymentmethod->id == config("constants.PAYMENT_METHOD_WALLET"))
                                                                                @if(isset($transaction->wallet_id) && $transaction->wallet->wallettype_id == config("constants.WALLET_TYPE_GIFT"))
                                                                                    - هدیه
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            <span class="label label-sm label-danger"> درج نشده </span>
                                                                        @endif
                                                                    </td>
                                                                    <td>@if(isset($transaction->transactionstatus))
                                                                            @if($transaction->transactionstatus->id == Config::get("constants.TRANSACTION_STATUS_PENDING"))
                                                                                <span class="label label-sm label-info">{{$transaction->transactionstatus->displayName}}</span>
                                                                            @else {{$transaction->transactionstatus->displayName}}
                                                                            @endif
                                                                        @else <span class="label label-sm label-info"> نامشخص </span> @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($transaction->getCode() === false)
                                                                            <span class="label label-sm label-warning"> ندارد </span>
                                                                        @else
                                                                            {{$transaction->getCode()}}
                                                                        @endif
                                                                    </td>
                                                                    <td style="direction: ltr; text-align: right">@if(isset($transaction->cost) && strlen($transaction->cost)>0)@if($transaction->cost >= 0) {{number_format($transaction->cost)}} @else {{number_format(-$transaction->cost)}} @endif @else
                                                                            <span class="label label-sm label-danger"> درج نشده </span>  @endif
                                                                    </td>
                                                                    <td>@if(isset($transaction->cost) && strlen($transaction->cost)>0)@if($transaction->cost >= 0)
                                                                            پرداخت @else دریافت @endif @else <span
                                                                                class="label label-sm label-danger"> درج نشده </span>  @endif
                                                                    </td>
                                                                    <td>@if(isset($transaction->completed_at) && strlen($transaction->completed_at) > 0){{ $transaction->CompletedAt_Jalali() }}@else
                                                                            <span class="label label-sm label-danger"> درج نشده </span> @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7"
                                                                        class="alert alert-info text-center bold">شما
                                                                        تاکنون تراکنشی ثبت نکرده اید
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3">
                                <div class="table-scrollable table-scrollable-borderless">
                                    <table class="table table-hover table-light">
                                        <thead>
                                        <tr class="uppercase">
                                            <th> مبلغ تراکنش (تومان)</th>
                                            <th>عملیات</th>
                                            <th> تاریخ سر رسید پرداخت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($instalments as $transaction)
                                            <tr>
                                                <td style="direction: ltr; text-align: right">@if(isset($transaction->cost) && strlen($transaction->cost)>0)@if($transaction->cost >= 0)
                                                        <span id="instalmentCost_{{$transaction->id}}">{{number_format($transaction->cost)}}</span> @else {{number_format(-$transaction->cost)}} @endif @else
                                                        <span class="label label-sm label-danger"> درج نشده </span>  @endif
                                                </td>
                                                <td>
                                                    <ul class="">
                                                        <li>
                                                            <button data-target="#onlinePaymentModal"
                                                                    data-toggle="modal"
                                                                    class="btn btn-xs green-jungle onlinePayment"
                                                                    style="width: 100px"
                                                                    rel="{{$transaction->order_id}}"
                                                                    data-role="{{$transaction->id}}">پرداخت آنلاین
                                                            </button>
                                                        </li>
                                                        {{--<li>--}}
                                                        {{--<button   data-target="#ATMPaymentModal"  data-toggle="modal"  class="btn btn-xs bg-font-blue ATMPayment" style="width: 100px;background: #00c4e6" id="ATMPayment-button" data-role="{{$transaction->id}}" data-action="{{action("Web\TransactionController@limitedUpdate" , $transaction)}}" data-control="POST" rel="{{$transaction->order_id}}" >کارت به کارت</button>--}}
                                                        {{--</li>--}}
                                                    </ul>
                                                </td>
                                                <td>@if(isset($transaction->deadline_at) && strlen($transaction->deadline_at) > 0){{ $transaction->DeadlineAt_Jalali() }}@else
                                                        <span class="label label-sm label-danger"> نامشخص </span> @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="alert alert-info text-center bold">شما تاکنون
                                                    تراکنشی ثبت نکرده اید
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>




    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Basic Example
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span>New record</span>
						</span>
                        </a>
                    </li>
                    <li class="m-portlet__nav-item"></li>
                    <li class="m-portlet__nav-item">
                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                             m-dropdown-toggle="hover" aria-expanded="true">
                            <a href="#"
                               class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                                <i class="la la-ellipsis-h m--font-brand"></i>
                            </a>
                            <div class="m-dropdown__wrapper">
                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                <div class="m-dropdown__inner">
                                    <div class="m-dropdown__body">
                                        <div class="m-dropdown__content">
                                            <ul class="m-nav">
                                                <li class="m-nav__section m-nav__section--first">
                                                    <span class="m-nav__section-text">Quick Actions</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                        <span class="m-nav__link-text">Create Post</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                        <span class="m-nav__link-text">Send Messages</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-multimedia-2"></i>
                                                        <span class="m-nav__link-text">Upload File</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__section">
                                                    <span class="m-nav__section-text">Useful Links</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-info"></i>
                                                        <span class="m-nav__link-text">FAQ</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__item">
                                                    <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                        <span class="m-nav__link-text">Support</span>
                                                    </a>
                                                </li>
                                                <li class="m-nav__separator m-nav__separator--fit m--hide">
                                                </li>
                                                <li class="m-nav__item m--hide">
                                                    <a href="#"
                                                       class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                <thead>
                <tr>
                    <th>Record ID</th>
                    <th>Order ID</th>
                    <th>Country</th>
                    <th>Ship City</th>
                    <th>Ship Address</th>
                    <th>Company Agent</th>
                    <th>Company Name</th>
                    <th>Ship Date</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>1</td>
                    <td>61715-075</td>
                    <td>China</td>
                    <td>Tieba</td>
                    <td>746 Pine View Junction</td>
                    <td>Nixie Sailor</td>
                    <td>Gleichner, Ziemann and Gutkowski</td>
                    <td>2/12/2018</td>
                    <td>3</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>63629-4697</td>
                    <td>Indonesia</td>
                    <td>Cihaur</td>
                    <td>01652 Fulton Trail</td>
                    <td>Emelita Giraldez</td>
                    <td>Rosenbaum-Reichel</td>
                    <td>8/6/2017</td>
                    <td>6</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>68084-123</td>
                    <td>Argentina</td>
                    <td>Puerto Iguazú</td>
                    <td>2 Pine View Park</td>
                    <td>Ula Luckin</td>
                    <td>Kulas, Cassin and Batz</td>
                    <td>5/26/2016</td>
                    <td>1</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>67457-428</td>
                    <td>Indonesia</td>
                    <td>Talok</td>
                    <td>3050 Buell Terrace</td>
                    <td>Evangeline Cure</td>
                    <td>Pfannerstill-Treutel</td>
                    <td>7/2/2016</td>
                    <td>1</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>31722-529</td>
                    <td>Austria</td>
                    <td>Sankt Andrä-Höch</td>
                    <td>3038 Trailsway Junction</td>
                    <td>Tierney St. Louis</td>
                    <td>Dicki-Kling</td>
                    <td>5/20/2017</td>
                    <td>2</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>64117-168</td>
                    <td>China</td>
                    <td>Rongkou</td>
                    <td>023 South Way</td>
                    <td>Gerhard Reinhard</td>
                    <td>Gleason, Kub and Marquardt</td>
                    <td>11/26/2016</td>
                    <td>5</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>43857-0331</td>
                    <td>China</td>
                    <td>Baiguo</td>
                    <td>56482 Fairfield Terrace</td>
                    <td>Englebert Shelley</td>
                    <td>Jenkins Inc</td>
                    <td>6/28/2016</td>
                    <td>2</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>64980-196</td>
                    <td>Croatia</td>
                    <td>Vinica</td>
                    <td>0 Elka Street</td>
                    <td>Hazlett Kite</td>
                    <td>Streich LLC</td>
                    <td>8/5/2016</td>
                    <td>6</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>0404-0360</td>
                    <td>Colombia</td>
                    <td>San Carlos</td>
                    <td>38099 Ilene Hill</td>
                    <td>Freida Morby</td>
                    <td>Haley, Schamberger and Durgan</td>
                    <td>3/31/2017</td>
                    <td>2</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>52125-267</td>
                    <td>Thailand</td>
                    <td>Maha Sarakham</td>
                    <td>8696 Barby Pass</td>
                    <td>Obed Helian</td>
                    <td>Labadie, Predovic and Hammes</td>
                    <td>1/26/2017</td>
                    <td>1</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>54092-515</td>
                    <td>Brazil</td>
                    <td>Canguaretama</td>
                    <td>32461 Ridgeway Alley</td>
                    <td>Sibyl Amy</td>
                    <td>Treutel-Ratke</td>
                    <td>3/8/2017</td>
                    <td>4</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>0185-0130</td>
                    <td>China</td>
                    <td>Jiamachi</td>
                    <td>23 Walton Pass</td>
                    <td>Norri Foldes</td>
                    <td>Strosin, Nitzsche and Wisozk</td>
                    <td>4/2/2017</td>
                    <td>3</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>21130-678</td>
                    <td>China</td>
                    <td>Qiaole</td>
                    <td>328 Glendale Hill</td>
                    <td>Myrna Orhtmann</td>
                    <td>Miller-Schiller</td>
                    <td>6/7/2016</td>
                    <td>3</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>40076-953</td>
                    <td>Portugal</td>
                    <td>Burgau</td>
                    <td>52550 Crownhardt Court</td>
                    <td>Sioux Kneath</td>
                    <td>Rice, Cole and Spinka</td>
                    <td>10/11/2017</td>
                    <td>4</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>36987-3005</td>
                    <td>Portugal</td>
                    <td>Bacelo</td>
                    <td>548 Morrow Terrace</td>
                    <td>Christa Jacmar</td>
                    <td>Brakus-Hansen</td>
                    <td>8/17/2017</td>
                    <td>1</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>67510-0062</td>
                    <td>South Africa</td>
                    <td>Pongola</td>
                    <td>02534 Hauk Trail</td>
                    <td>Shandee Goracci</td>
                    <td>Bergnaum, Thiel and Schuppe</td>
                    <td>7/24/2016</td>
                    <td>5</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>17</td>
                    <td>36987-2542</td>
                    <td>Russia</td>
                    <td>Novokizhinginsk</td>
                    <td>19427 Sloan Road</td>
                    <td>Jerrome Colvie</td>
                    <td>Kreiger, Glover and Connelly</td>
                    <td>3/4/2016</td>
                    <td>3</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>18</td>
                    <td>11673-479</td>
                    <td>Brazil</td>
                    <td>Conceição das Alagoas</td>
                    <td>191 Stone Corner Road</td>
                    <td>Michaelina Plenderleith</td>
                    <td>Legros-Gleichner</td>
                    <td>2/21/2018</td>
                    <td>1</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>19</td>
                    <td>47781-264</td>
                    <td>Ukraine</td>
                    <td>Yasinya</td>
                    <td>1481 Sauthoff Place</td>
                    <td>Lombard Luthwood</td>
                    <td>Haag LLC</td>
                    <td>1/21/2016</td>
                    <td>1</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>42291-712</td>
                    <td>Indonesia</td>
                    <td>Kembang</td>
                    <td>9029 Blackbird Point</td>
                    <td>Leonora Chevin</td>
                    <td>Mann LLC</td>
                    <td>9/6/2017</td>
                    <td>2</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>21</td>
                    <td>64679-154</td>
                    <td>Mongolia</td>
                    <td>Sharga</td>
                    <td>102 Holmberg Park</td>
                    <td>Tannie Seakes</td>
                    <td>Blanda Group</td>
                    <td>7/31/2016</td>
                    <td>6</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>49348-055</td>
                    <td>China</td>
                    <td>Guxi</td>
                    <td>45 Butterfield Street</td>
                    <td>Yardley Wetherell</td>
                    <td>Gerlach-Schultz</td>
                    <td>4/3/2017</td>
                    <td>2</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>23</td>
                    <td>47593-438</td>
                    <td>Portugal</td>
                    <td>Viso</td>
                    <td>97 Larry Center</td>
                    <td>Bryn Peascod</td>
                    <td>Larkin and Sons</td>
                    <td>5/22/2016</td>
                    <td>6</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>24</td>
                    <td>54569-0175</td>
                    <td>Japan</td>
                    <td>Minato</td>
                    <td>077 Hoffman Center</td>
                    <td>Chrissie Jeromson</td>
                    <td>Brakus-McCullough</td>
                    <td>11/26/2017</td>
                    <td>2</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>25</td>
                    <td>0093-1016</td>
                    <td>Indonesia</td>
                    <td>Merdeka</td>
                    <td>3150 Cherokee Center</td>
                    <td>Gusti Clamp</td>
                    <td>Stokes Group</td>
                    <td>4/12/2018</td>
                    <td>6</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>26</td>
                    <td>0093-5142</td>
                    <td>China</td>
                    <td>Jianggao</td>
                    <td>289 Badeau Alley</td>
                    <td>Otis Jobbins</td>
                    <td>Ruecker, Leffler and Abshire</td>
                    <td>3/6/2018</td>
                    <td>4</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>27</td>
                    <td>51523-026</td>
                    <td>Germany</td>
                    <td>Erfurt</td>
                    <td>132 Chive Way</td>
                    <td>Lonnie Haycox</td>
                    <td>Feest Group</td>
                    <td>4/24/2018</td>
                    <td>1</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>28</td>
                    <td>49035-522</td>
                    <td>Australia</td>
                    <td>Eastern Suburbs Mc</td>
                    <td>074 Algoma Drive</td>
                    <td>Heddi Castelli</td>
                    <td>Kessler and Sons</td>
                    <td>1/12/2017</td>
                    <td>5</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>29</td>
                    <td>58411-198</td>
                    <td>Ethiopia</td>
                    <td>Kombolcha</td>
                    <td>91066 Amoth Court</td>
                    <td>Tuck O'Dowgaine</td>
                    <td>Simonis, Rowe and Davis</td>
                    <td>5/6/2017</td>
                    <td>1</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>27495-006</td>
                    <td>Portugal</td>
                    <td>Arrifes</td>
                    <td>3 Fairfield Junction</td>
                    <td>Vernon Cosham</td>
                    <td>Kreiger-Nicolas</td>
                    <td>2/8/2017</td>
                    <td>4</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>31</td>
                    <td>55154-8284</td>
                    <td>Philippines</td>
                    <td>Talisay</td>
                    <td>09 Sachtjen Junction</td>
                    <td>Bryna MacCracken</td>
                    <td>Hyatt-Witting</td>
                    <td>7/22/2017</td>
                    <td>2</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>32</td>
                    <td>62678-207</td>
                    <td>Libya</td>
                    <td>Zuwārah</td>
                    <td>82 Thackeray Pass</td>
                    <td>Freda Arnall</td>
                    <td>Dicki, Morar and Stiedemann</td>
                    <td>7/22/2016</td>
                    <td>3</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>33</td>
                    <td>68428-725</td>
                    <td>China</td>
                    <td>Zhangcun</td>
                    <td>3 Goodland Terrace</td>
                    <td>Pavel Kringe</td>
                    <td>Goldner-Lehner</td>
                    <td>4/2/2017</td>
                    <td>4</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>34</td>
                    <td>0363-0724</td>
                    <td>Morocco</td>
                    <td>Temara</td>
                    <td>9550 Weeping Birch Crossing</td>
                    <td>Felix Nazaret</td>
                    <td>Waters, Quigley and Keeling</td>
                    <td>6/4/2016</td>
                    <td>5</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>35</td>
                    <td>37000-102</td>
                    <td>Paraguay</td>
                    <td>Los Cedrales</td>
                    <td>1 Ridge Oak Way</td>
                    <td>Penrod Allanby</td>
                    <td>Rodriguez Group</td>
                    <td>3/5/2018</td>
                    <td>2</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>36</td>
                    <td>55289-002</td>
                    <td>Philippines</td>
                    <td>Dologon</td>
                    <td>9 Vidon Terrace</td>
                    <td>Hubey Passby</td>
                    <td>Lemke-Hermiston</td>
                    <td>6/29/2017</td>
                    <td>2</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>37</td>
                    <td>15127-874</td>
                    <td>Tanzania</td>
                    <td>Nanganga</td>
                    <td>33 Anniversary Parkway</td>
                    <td>Magdaia Rotlauf</td>
                    <td>Hettinger, Medhurst and Heaney</td>
                    <td>2/18/2018</td>
                    <td>3</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>38</td>
                    <td>49349-123</td>
                    <td>Indonesia</td>
                    <td>Pule</td>
                    <td>77292 Bonner Plaza</td>
                    <td>Alfonse Lawrance</td>
                    <td>Schuppe-Harber</td>
                    <td>4/14/2017</td>
                    <td>1</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>39</td>
                    <td>17089-415</td>
                    <td>Palestinian Territory</td>
                    <td>Za‘tarah</td>
                    <td>42806 Ridgeview Terrace</td>
                    <td>Kessiah Chettoe</td>
                    <td>Mraz LLC</td>
                    <td>3/4/2017</td>
                    <td>5</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>40</td>
                    <td>51327-510</td>
                    <td>Philippines</td>
                    <td>Esperanza</td>
                    <td>4 Linden Court</td>
                    <td>Natka Fairbanks</td>
                    <td>Mueller-Greenholt</td>
                    <td>6/21/2017</td>
                    <td>3</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>41</td>
                    <td>0187-2201</td>
                    <td>Brazil</td>
                    <td>Rio das Ostras</td>
                    <td>5722 Buhler Place</td>
                    <td>Shaw Puvia</td>
                    <td>Veum LLC</td>
                    <td>6/10/2017</td>
                    <td>3</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>42</td>
                    <td>16590-890</td>
                    <td>Indonesia</td>
                    <td>Krajan Gajahmati</td>
                    <td>54 Corry Street</td>
                    <td>Alden Dingate</td>
                    <td>Heidenreich Inc</td>
                    <td>10/27/2016</td>
                    <td>5</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>43</td>
                    <td>75862-001</td>
                    <td>Indonesia</td>
                    <td>Pineleng</td>
                    <td>4 Messerschmidt Point</td>
                    <td>Cherish Peplay</td>
                    <td>McCullough-Gibson</td>
                    <td>11/23/2017</td>
                    <td>2</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>44</td>
                    <td>24559-091</td>
                    <td>Philippines</td>
                    <td>Amuñgan</td>
                    <td>5470 Forest Parkway</td>
                    <td>Nedi Swetman</td>
                    <td>Gerhold Inc</td>
                    <td>3/23/2017</td>
                    <td>5</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>45</td>
                    <td>0007-3230</td>
                    <td>Russia</td>
                    <td>Bilyarsk</td>
                    <td>5899 Basil Place</td>
                    <td>Ashley Blick</td>
                    <td>Cummings-Goodwin</td>
                    <td>10/1/2016</td>
                    <td>4</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>46</td>
                    <td>50184-1029</td>
                    <td>Peru</td>
                    <td>Chocope</td>
                    <td>65560 Daystar Center</td>
                    <td>Saunders Harmant</td>
                    <td>O'Kon-Wiegand</td>
                    <td>11/7/2017</td>
                    <td>3</td>
                    <td>2</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>47</td>
                    <td>10819-6003</td>
                    <td>France</td>
                    <td>Rivesaltes</td>
                    <td>4981 Springs Center</td>
                    <td>Mellisa Laurencot</td>
                    <td>Jacobs Group</td>
                    <td>10/30/2017</td>
                    <td>1</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>48</td>
                    <td>62750-003</td>
                    <td>Mongolia</td>
                    <td>Jargalant</td>
                    <td>94 Rutledge Way</td>
                    <td>Orland Myderscough</td>
                    <td>Gutkowski Inc</td>
                    <td>11/2/2016</td>
                    <td>5</td>
                    <td>3</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>49</td>
                    <td>68647-122</td>
                    <td>Philippines</td>
                    <td>Cardona</td>
                    <td>4765 Service Hill</td>
                    <td>Devi Iglesias</td>
                    <td>Ullrich-Dibbert</td>
                    <td>7/21/2016</td>
                    <td>1</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                <tr>
                    <td>50</td>
                    <td>36987-3093</td>
                    <td>China</td>
                    <td>Jiantou</td>
                    <td>373 Northwestern Plaza</td>
                    <td>Bliss Tummasutti</td>
                    <td>Legros-Cummings</td>
                    <td>11/27/2017</td>
                    <td>5</td>
                    <td>1</td>
                    <td nowrap></td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->



@endsection

@section('page-js')
    {{--<script src="{{ mix('/js/user-profile.js') }}"></script>--}}
    <script src="{{ asset('/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script>

        var DatatablesBasicBasic = {
            init: function () {
                var e;
                (e = $("#m_table_1")).DataTable({
                    responsive: !0,
                    dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    lengthMenu: [5, 10, 25, 50],
                    pageLength: 10,
                    language: {lengthMenu: "Display _MENU_"},
                    order: [[1, "desc"]],
                    headerCallback: function (e, a, t, n, s) {
                        e.getElementsByTagName("th")[0].innerHTML = '\n                    <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">\n                        <input type="checkbox" value="" class="m-group-checkable">\n                        <span></span>\n                    </label>'
                    },
                    columnDefs: [{
                        targets: 0,
                        width: "30px",
                        className: "dt-right",
                        orderable: !1,
                        render: function (e, a, t, n) {
                            return '\n                        <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">\n                            <input type="checkbox" value="" class="m-checkable">\n                            <span></span>\n                        </label>'
                        }
                    }, {
                        targets: -1, title: "Actions", orderable: !1, render: function (e, a, t, n) {
                            return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
                        }
                    }, {
                        targets: 8, render: function (e, a, t, n) {
                            var s = {
                                1: {title: "Pending", class: "m-badge--brand"},
                                2: {title: "Delivered", class: " m-badge--metal"},
                                3: {title: "Canceled", class: " m-badge--primary"},
                                4: {title: "Success", class: " m-badge--success"},
                                5: {title: "Info", class: " m-badge--info"},
                                6: {title: "Danger", class: " m-badge--danger"},
                                7: {title: "Warning", class: " m-badge--warning"}
                            };
                            return void 0 === s[e] ? e : '<span class="m-badge ' + s[e].class + ' m-badge--wide">' + s[e].title + "</span>"
                        }
                    }, {
                        targets: 9, render: function (e, a, t, n) {
                            var s = {
                                1: {title: "Online", state: "danger"},
                                2: {title: "Retail", state: "primary"},
                                3: {title: "Direct", state: "accent"}
                            };
                            return void 0 === s[e] ? e : '<span class="m-badge m-badge--' + s[e].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + s[e].state + '">' + s[e].title + "</span>"
                        }
                    }]
                }), e.on("change", ".m-group-checkable", function () {
                    var e = $(this).closest("table").find("td:first-child .m-checkable"), a = $(this).is(":checked");
                    $(e).each(function () {
                        a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
                    })
                }), e.on("change", "tbody tr .m-checkbox", function () {
                    $(this).parents("tr").toggleClass("active")
                })
            }
        };
        jQuery(document).ready(function () {
            DatatablesBasicBasic.init()
        });

    </script>
@endsection


@section("footerPageLevelPlugin")
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/js/extraJS/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>
    <script type="text/javascript">

        //    var newDataTable =$("#orders_table").DataTable();
        //    newDataTable.destroy();
        //    $('#orders_table > tbody').html(result);
        makeDataTableWithoutButton("orders_table");

        $(document).on("click", ".onlinePayment", function () {
            var order_id = $(this).attr("rel");
            if ($(this).attr('data-role')) {
                var transaction_id = $(this).data("role");
                $("input[name=transaction_id]").val(transaction_id).prop("disabled", false);
                $("#orderCost").text($("#instalmentCost_" + transaction_id).text()).number(true).prepend("مبلغ قابل پرداخت: ").append(" تومان");
            } else {
                $("input[name=transaction_id]").prop("disabled", true);
                $("#orderCost").text($("#cost_" + order_id).text()).number(true).prepend("مبلغ قابل پرداخت: ").append(" تومان");
            }
            $("input[name=order_id]").val(order_id);
        });

        $(document).on("click", ".ATMPayment", function () {
            var order_id = $(this).attr("rel");
            if ($(this).attr('data-role')) {
                var transaction_id = $(this).data("role");
                // Initializiing form attributes
                $("#offlinePaymentForm").attr("action", $(this).data("action"));
                $("#offlinePaymentForm").attr("method", $(this).data("control"));
                // Initializing form elements
                $("input[name=transaction_id]").val(transaction_id).prop("disabled", false);
                $("#ATMTransactionCost").hide().prop("disabled", true);
                $("#ATMTransactionCost-static").text($("#instalmentCost_" + transaction_id).text()).number(true).show()
            } else {
                // Initializing form attributes
                $("#offlinePaymentForm").attr("action", "{{action("Web\TransactionController@store")}}");
                $("#offlinePaymentForm").attr("method", "POST");
                // Initializing form elements
                $("input[name=transaction_id]").prop("disabled", true);
                $("#ATMTransactionCost").show().prop("disabled", false);
                $("#ATMTransactionCost-static").hide();
            }
            $("input[name=order_id]").val(order_id);

        });

        $(document).on("click", ".ATMRadio", function () {
            var radioValue = $(this).val();
            if (radioValue == "referenceNumber") {
                $("input[name=referenceNumber]").prop('disabled', false);
                $("input[name=traceNumber]").prop('disabled', true);
            } else if (radioValue == "traceNumber") {
                $("input[name=referenceNumber]").prop('disabled', true);
                $("input[name=traceNumber]").prop('disabled', false);
            }
        });

        jQuery(document).ready(function () {
            @if(!$errors->isEmpty())
            $("#ATMPayment-button").trigger("click");
            @endif
        });
    </script>
@endsection