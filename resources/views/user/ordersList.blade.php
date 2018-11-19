@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("title")
    <title>آلاء|سفارش های من</title>
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>سفارش های من</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div class="btn-group pull-right">

                <a class="btn btn-fit-height bg-red-soft bg-font-dark "
                   href="{{ action("UserController@userProductFiles")  }}"><i class="fa fa-download"></i>فیلم ها و جزوه
                    ها</a>
            </div>
        </div>
    </div>
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
                                            {!! Form::open(['method' => 'GET','action' => ['TransactionController@paymentRedirect']]) !!}
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
                                            {!! Form::open(['method' => 'POST','action' => ['TransactionController@store'], 'id'=>'offlinePaymentForm']) !!}
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
                                                                                                 target="_blank"
                                                                                                 href="@if($orderproduct->product->hasParents()){{action("ProductController@show",$orderproduct->product->parents->first())}} @else  {{action("ProductController@show",$orderproduct->product)}} @endif">
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
                                                        {{--<button   data-target="#ATMPaymentModal"  data-toggle="modal"  class="btn btn-xs bg-font-blue ATMPayment" style="width: 100px;background: #00c4e6" id="ATMPayment-button" data-role="{{$transaction->id}}" data-action="{{action("TransactionController@limitedUpdate" , $transaction)}}" data-control="POST" rel="{{$transaction->order_id}}" >کارت به کارت</button>--}}
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
                $("#offlinePaymentForm").attr("action", "{{action("TransactionController@store")}}");
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