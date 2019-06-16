@extends("app")

@section('page-css')
    <link href="{{ mix('/css/user-orders.css') }}" rel="stylesheet" type="text/css"/>
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

@section('content')

    @include("systemMessage.flash")

    <div class="row">
        <div class="col">

            @if(isset($debitCard))
                <div class="alert alert-info text-center" role="alert">
                    شماره کارت برای واریز کارت به کارت مبلغ:
                    <br>
                    <strong>{{$debitCard->cardNumber}}</strong>
                    <br>
                    به نام
                    @if(!isset($debitCard->user->firstName) && !isset($debitCard->user->lastName))
                        کاربر
                        ناشناس
                    @else
                        @if(isset($debitCard->user->firstName))
                            {{$debitCard->user->firstName}}
                        @endif
                        @if(isset($debitCard->user->lastName))
                            {{$debitCard->user->lastName}}
                        @endif
                    @endif
                    - بانک {{ optional($debitCard->bank)->name}}
                </div>
            @endif

        </div>
    </div>

    <div class="row">
        <div class="col">
    
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#user-orderList"
                                   role="tab">
                                    <i class="la la-shopping-cart"></i>
                                    لیست سفارشات
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#user-paymentsList" role="tab">
                                    <i class="la la-money"></i>
                                    لیست پرداخت ها
                                </a>
                            </li>
                            @if((isset($instalments) && $instalments->isNotEmpty()))
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#user-instalmentsList"
                                       role="tab">
                                        <i class="la la-bank"></i>
                                        لیست قسط های شما
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="user-orderList" role="tabpanel">
    
                            @if(!isset($orders) || count($orders)===0)
                                <div class="alert alert-info" role="alert">
                                    <strong>شما تاکنون سفارشی ثبت نکرده اید</strong>
                                </div>
                            @else
                                <div class="m-section">
                                    <div class="m-section__content">
                                        <div class="table-responsive">
    
                                            <table class="table m-table m-table--head-bg-success table-hover">
                                                <thead>
                                                <tr>
                                                    <th>شماره سفارش</th>
                                                    <th>وضعیت سفارش</th>
                                                    <th>وضعیت پرداخت</th>
                                                    <th>مبلغ(تومان)</th>
                                                    <th>پرداخت
                                                        شده(تومان)
                                                    </th>
                                                    <th>تاریخ ثبت نهایی</th>
                                                    <th>جزییات</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($orders as $orderKey=>$order)
                                                    <tr>
                                                        <td>
                                                            #{{$order->id}}
                                                        </td>
                                                        <td class="text-center">
                                                                <span class="m-badge m-badge--wide
                                                                @if(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED"))m-badge--success
                                                                @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CANCELED"))m-badge--danger
                                                                @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_POSTED") )m-badge--info
                                                                @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_REFUNDED") )m-badge--metal
                                                                @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_READY_TO_POST") )m-badge--info
                                                                @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_PENDING") )m-badge--primary
                                                                @endif">
                                                                    {{$order->orderstatus->displayName}}
                                                                </span>
                                                        </td>
                                                        <td>
    
                                                            @if(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_PAID"))
                                                                <span class="m-badge m-badge--wide m-badge--success">
                                                                        {{$order->paymentstatus->displayName}}
                                                                    </span>
                                                            @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_UNPAID"))
                                                                <span class="m-badge m-badge--wide m-badge--warning">
                                                                        {{$order->paymentstatus->displayName}}
                                                                    </span>
{{--                                                                $order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED") ||--}}
                                                                @if(isset($order->orderstatus->id) && ($order->orderstatus->id == config("constants.ORDER_STATUS_POSTED")))
                                                                    <button type="button"
                                                                            class="btn btn-sm m-btn--pill m-btn--air btn-accent btnOnlinePayment"
                                                                            data-order-id="{{$order->id}}"
                                                                            data-transaction-id="-"
                                                                            data-cost="{{$order->debt}}">
                                                                        پرداخت
                                                                    </button>
                                                                @endif
                                                            @elseif(isset($order->paymentstatus->id) && ($order->paymentstatus->id == config("constants.PAYMENT_STATUS_INDEBTED") || $order->paymentstatus->id == config("constants.PAYMENT_STATUS_VERIFIED_INDEBTED")))
                                                                <span class="m-badge m-badge--wide m-badge--warning">
                                                                    {{$order->paymentstatus->displayName}}
                                                                </span>
                                                                <button type="button"
                                                                        class="btn btn-sm m-btn--pill m-btn--air btn-accent btnOnlinePayment"
                                                                        data-order-id="{{$order->id}}"
                                                                        data-transaction-id="-"
                                                                        data-cost="{{$order->debt}}">
                                                                    پرداخت
                                                                </button>
                                                            @else
                                                                <span class="m-badge m-badge--wide m-badge--info">
                                                                    ندارد
                                                                </span>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            @if(isset($order->cost) || isset($order->costwithoutcoupon))
                                                                {{number_format($order->price )}}
                                                            @else
                                                                <span class="label m-badge--info">بدون مبلغ</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($order->cost) || isset($order->costwithoutcoupon))
                                                                {{number_format($order->totalPaidCost() + $order->totalRefund())}}
                                                            @else
                                                                <span class="label m-badge--info">بدون مبلغ</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($order->completed_at))
                                                                {{$order->CompletedAt_Jalali()}}
                                                            @else
                                                                <span class="label m-badge--info">درج نشده</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a onclick="event.preventDefault();"
                                                               data-order-key="{{ $orderKey  }}"
                                                               class="btn btn-outline-accent m-btn m-btn--icon btn-lg m-btn--icon-only m-btn--pill m-btn--air btnViewOrderDetailes">
                                                                <i class="flaticon-mark"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
    
                                            <!--begin::Modal-->
                                            <div id="orderDetailesModal" class="modal fade" tabindex="-1"
                                                 {{--role="dialog"--}}{{--aria-labelledby="exampleModalLabel"--}}{{--aria-hidden="true"--}}data-backdrop="static"
                                                 data-keyboard="false">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                جزییات سفارش
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
    
                                                            <div class="m-portlet m-portlet--skin-dark m-portlet--bordered-semi m--bg-accent">
                                                                <div class="m-portlet__head">
                                                                    <div class="m-portlet__head-caption">
                                                                        <div class="m-portlet__head-title">
                                                                            <span class="m-portlet__head-icon">
                                                                                <i class="flaticon-statistics"></i>
                                                                            </span>
                                                                            <h3 class="m-portlet__head-text">
                                                                                اطلاعات کلی
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="m-portlet__body orderTotalyInfoWraper">
    
                                                                    <div class="row">
                                                                        <div class="col col-md-6">
                                                                            <table class="table table-sm m-table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>وضعیت سفارش:</td>
                                                                                        <td class="orderDetailes-orderStatus"></td>
                                                                                    </tr>
                                                                                    <tr id="postedProductCodeReportWraper">
                                                                                        <td>کد مرسوله پست شده:</td>
                                                                                        <td class="orderDetailes-orderPostingInfo"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>تاریخ ایجاد اولیه:</td>
                                                                                        <td class="orderDetailes-created_at"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>تاریخ ثبت نهایی:</td>
                                                                                        <td class="orderDetailes-completed_at"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col col-md-6">
                                                                            <table class="table table-sm m-table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>وضعیت پرداخت:</td>
                                                                                        <td class="orderDetailes-paymentStatus"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>مبلغ(تومان):</td>
                                                                                        <td class="orderDetailes-price"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>پرداخت شده(تومان):</td>
                                                                                        <td class="orderDetailes-paidPrice"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>بدهی(تومان):</td>
                                                                                        <td class="orderDetailes-debt"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="alert alert-success" role="alert">
                                                                                <table class="table table-sm m-table orderDiscountInfoInModal">
                                                                                    <tbody>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            
                                                                            <div class="alert alert-success customerDescription customerDescriptionInModal" role="alert">
                                                                            
                                                                            </div>

                                                                        </div>
                                                                    </div>
    
                                                                    {{--<th>توضیح شما</th>--}}

                                                                </div>
                                                            </div>
    
                                                            <div class="m-portlet m-portlet--mobile orderDetailes-totalProductPortlet">
                                                                <div class="m-portlet__head">
                                                                    <div class="m-portlet__head-caption">
                                                                        <div class="m-portlet__head-title">
                                                                            <h3 class="m-portlet__head-text">
                                                                                لیست محصولات
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="m-portlet__body">
                                                                    <div class="m-widget3 orderDetailes-orderprouctList">

                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <div class="m-portlet m-portlet--skin-dark m-portlet--bordered-semi m--bg-info orderDetailes-totalTransactionsTable">
                                                                <div class="m-portlet__head">
                                                                    <div class="m-portlet__head-caption">
                                                                        <div class="m-portlet__head-title">
                                                                            <span class="m-portlet__head-icon">
                                                                                <i class="flaticon-statistics"></i>
                                                                            </span>
                                                                            <h3 class="m-portlet__head-text">
                                                                                لیست تراکنش ها
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="m-portlet__body">
    
                                                                    <table class="table table-sm m-table m-table--head-bg-primary orderDetailes-successfulTransactionsTable">
                                                                        <thead class="thead-inverse">
                                                                        <tr>
                                                                            <th class="text-center" colspan="4">
                                                                                تراکنش های موفق
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>مبلغ</th>
                                                                            <th>نوع تراکنش</th>
                                                                            <th>کد پیگیری</th>
                                                                            <th>زمان</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody class="orderDetailes-successfulTransactions"></tbody>
                                                                    </table>
    
                                                                    <table class="table table-sm m-table m-table--head-bg-primary orderDetailes-pendingTransactionsTable">
                                                                        <thead class="thead-inverse">
                                                                        <tr>
                                                                            <th class="text-center" colspan="4">
                                                                                تراکنش های منتظر تایید
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>مبلغ</th>
                                                                            <th>نوع تراکنش</th>
                                                                            <th>کد پیگیری</th>
                                                                            <th>زمان</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody class="orderDetailes-pending_transactions"></tbody>
                                                                    </table>
    
                                                                    <table class="table table-sm m-table m-table--head-bg-primary orderDetailes-unpaidTransactionsTable">
                                                                        <thead class="thead-inverse">
                                                                        <tr>
                                                                            <th class="text-center" colspan="4">
                                                                                قسط های پرداخت نشده
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>مبلغ</th>
                                                                            <th>تاریخ ایجاد</th>
                                                                            <th>مهلت پرداخت</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody class="orderDetailes-unpaid_transactions"></tbody>
                                                                    </table>

                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                    class="btn m-btn--pill m-btn--air btn-outline-brand m-btn m-btn--custom"
                                                                    data-dismiss="modal">
                                                                بستن
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Modal-->

                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="tab-pane" id="user-paymentsList" role="tabpanel">
    
                            @if(!isset($transactions) || count($transactions)===0)
                                <div class="alert alert-info" role="alert">
                                    <strong>برای شما تاکنون تراکنشی ثبت نشده است.</strong>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table m-table m-table--head-bg-success table-hover">
                                        <thead>
                                        <tr>
                                            <th>نحوه پرداخت</th>
                                            <th>وضعیت</th>
                                            <th>شماره سفارش</th>
                                            <th>شناسه</th>
                                            <th>مبلغ تراکنش (تومان)</th>
                                            <th>نوع</th>
                                            <th>تاریخ پرداخت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transactions as $key=>$transactionArray)
                                                @forelse($transactionArray as $transaction)
                                                    <tr>
                                                        <td>
                                                            @if(isset($transaction->paymentmethod))
                                                                {{$transaction->paymentmethod->displayName}}
                                                                @if($transaction->paymentmethod->id == config("constants.PAYMENT_METHOD_WALLET"))
                                                                    @if(
                                                                        isset($transaction->wallet_id) &&
                                                                        $transaction->wallet->wallettype_id == config("constants.WALLET_TYPE_GIFT")
                                                                        )
                                                                        - هدیه
                                                                    @endif
                                                                @elseif($transaction->transactiongateway !== null)
                                                                     ({{ $transaction->transactiongateway->displayName }})
                                                                @endif
                                                            @else
                                                                <span class="m-badge m-badge--wide m-badge--rounded m-badge--danger">درج نشده</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($transaction->transactionstatus))
                                                                @if($transaction->transactionstatus->id == config("constants.TRANSACTION_STATUS_PENDING"))
                                                                    <span class="m-badge m-badge--wide m-badge--rounded m-badge--info">
                                                                                        {{$transaction->transactionstatus->displayName}}
                                                                                    </span>
                                                                @else
                                                                    {{$transaction->transactionstatus->displayName}}
                                                                @endif
                                                            @else
                                                                <span class="m-badge m-badge--wide m-badge--rounded m-badge--info">
                                                                                    نامشخص
                                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td dir="ltr">#{{$key}}</tddir>
                                                        <td>
                                                            @if($transaction->getCode() === false)
                                                                <span class="m-badge m-badge--wide m-badge--rounded m-badge--warning">
                                                                                    ندارد
                                                                                </span>
                                                            @else
                                                                {{$transaction->getCode()}}
                                                            @endif
                                                        </td>
                                                        <td dir="ltr">
                                                            @if(isset($transaction->cost) && strlen($transaction->cost)>0)
                                                                @if($transaction->cost >= 0)
                                                                    {{number_format($transaction->cost)}}
                                                                @else
                                                                    {{number_format(-$transaction->cost)}}
                                                                @endif
                                                            @else
                                                                <span class="m-badge m-badge--wide m-badge--rounded m-badge--danger">
                                                                                    درج نشده
                                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($transaction->cost) && strlen($transaction->cost)>0)
                                                                @if($transaction->cost >= 0)
                                                                    پرداخت
                                                                @else
                                                                    دریافت
                                                                @endif
                                                            @else
                                                                <span class="m-badge m-badge--wide m-badge--rounded m-badge--danger">
                                                                                    درج نشده
                                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($transaction->completed_at) && strlen($transaction->completed_at) > 0)
                                                                {{ $transaction->CompletedAt_Jalali() }}
                                                            @else
                                                                <span class="m-badge m-badge--wide m-badge--rounded m-badge--danger">
                                                                                    درج نشده
                                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr class="m-table__row--info">
                                                        <td colspan="6">
                                                            شما تاکنون تراکنشی ثبت نکرده اید
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                        <div class="tab-pane" id="user-instalmentsList" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table m-table m-table--head-bg-success table-hover">
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
                                            <td dir="ltr">
                                                @if(isset($transaction->cost) && strlen($transaction->cost)>0)
                                                    @if($transaction->cost >= 0)
                                                        <span id="instalmentCost_{{$transaction->id}}">
                                                            {{number_format($transaction->cost)}}
                                                        </span>
                                                    @else
                                                        {{number_format(-$transaction->cost)}}
                                                    @endif
                                                @else
                                                    <span class="m-badge m-badge--wide m-badge--rounded m-badge--danger">
                                                        درج نشده
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button"
                                                        class="btn btn-sm m-btn--pill m-btn--air btn-accent btnOnlinePayment"
                                                        data-order-id="{{$transaction->order_id}}"
                                                        data-transaction-id="{{$transaction->id}}"
                                                        data-cost="{{$transaction->cost}}">
                                                    پرداخت آنلاین
                                                </button>
                                            </td>
                                            <td>
                                                @if(isset($transaction->deadline_at) && strlen($transaction->deadline_at) > 0)
                                                    {{ $transaction->DeadlineAt_Jalali() }}
                                                @else
                                                    <span class="m-badge m-badge--wide m-badge--rounded m-badge--danger">
                                                        نامشخص
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="m-table__row--info">
                                            <td colspan="7">
                                                شما تاکنون تراکنشی ثبت نکرده اید
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
    </div>




    <!--begin::Modal-->
    <div id="onlinePaymentModal" class="modal fade" tabindex="-1"
         {{--role="dialog"--}}{{--aria-labelledby="exampleModalLabel"--}}{{--aria-hidden="true"--}}data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        انتقال به درگاه بانکی
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                {!! Form::open(['method' => 'POST','route' => ['redirectToBank', 'paymentMethod'=>'zarinpal', 'device'=>'web'], 'id'=>'onlinePaymentModalForm']) !!}
                <div class="modal-body">
        
                    {!! Form::hidden('order_id',null) !!}
                    {!! Form::hidden('transaction_id',null , ["disabled"]) !!}
        
                    <div class="row margin-top-20" id="gatewayDiv">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="gateway">
                                    انتخاب درگاه:
                                </label>
                                <div class="col-md-7">
                                    {!! Form::select('paymentMethod',$gateways,null,['class' => 'form-control' , 'id'=>'gatewaySelect' ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-top-40 text-center">
                        <div class="col">
                            <span class="m-badge m-badge--success m-badge--wide m-badge--rounded orderCostReport"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn m-btn--pill m-btn--air btn-outline-brand m-btn m-btn--custom"
                            data-dismiss="modal">
                        بستن
                    </button>
                    <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">
                        انتقال به درگاه پرداخت
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <div id="ATMPaymentModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-header">ثبت اطلاعات رسید عابر بانک</div>
        {!! Form::open(['method' => 'POST','action' => ['Web\TransactionController@store'], 'id'=>'offlinePaymentForm']) !!}
        {!! Form::hidden('order_id',null) !!}
        {!! Form::hidden('transaction_id',null , ["disabled"]) !!}
        {!! Form::hidden('paymentMethodName','ATM') !!}
        {!! Form::hidden('paymentmethod_id', config("constants.PAYMENT_METHOD_ATM")) !!}
        <div class="modal-body">
            <div class="row static-info margin-top-20">
                <div class="form-group {{ $errors->has('cost') ? ' has-danger' : '' }}">
                    <label class="col-md-4 control-label" for="cost">مبلغ واریز شده(تومان):</label>
                    <div class="col-md-7">
                        {!! Form::text('cost',old('cost'),['class' => 'form-control' , 'id'=>"ATMTransactionCost" , 'dir'=>'ltr' ]) !!}
                        <text class="form-control-static m--font-info" id="ATMTransactionCost-static"></text>
                        @if ($errors->has('cost'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('cost') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row static-info margin-top-20">
                <div class="col-md-12">
                    <span class="label m-badge--info ">کاربر گرامی</span>
                    <span class="bold bold font-blue-dark">یکی از دو شماره ی زیر را از رسید عابر بانک با دقت وارد نموده و ثبت اطلاعات را بزنید .</span>
                </div>
            </div>
            <div class="mt-radio-list">
                <div class="row static-info margin-top-20">
                    <div class="form-group {{ $errors->has('referenceNumber') ? ' has-danger' : '' }}">
                        <div class="col-md-4">
                            <label class="mt-radio mt-radio-outline control-label">
                                شماره مرجع/ارجاع:
                                <input type="radio" value="referenceNumber" class="ATMRadio" name="ATMRadio" checked/>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-md-7">
                            {!! Form::text('referenceNumber',old('referenceNumber'),['class' => 'form-control', 'dir'=>'ltr' ]) !!}
                            @if ($errors->has('referenceNumber'))
                                <span class="form-control-feedback">
                                                                    <strong>{{ $errors->first('referenceNumber') }}</strong>
                                                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row static-info margin-top-20">
                    <div class="form-group {{ $errors->has('traceNumber') ? ' has-danger' : '' }}">
                        <div class="col-md-4">
                            <label class="mt-radio mt-radio-outline control-label">
                                شماره پیگیری:
                                <input type="radio" value="traceNumber" class="ATMRadio" name="ATMRadio"/>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-md-7">
                            {!! Form::text('traceNumber',old('traceNumber'),['class' => 'form-control' , 'disabled'=>'true', 'dir'=>'ltr' ]) !!}
                            @if ($errors->has('traceNumber'))
                                <span class="form-control-feedback">
                                                                <strong>{{ $errors->first('traceNumber') }}</strong>
                                                            </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-outline dark" id="sendSmsForm-close">بستن
            </button>
            <button type="submit" class="btn green">ثبت اطلاعات</button>
        </div>
        {!! Form::close() !!}
    </div>


@endsection

@section('page-js')
    <script>
        let orders = {!! json_encode($orders) !!};
    </script>
    <script src="{{ mix('/js/user-orders.js') }}"></script>
@endsection
