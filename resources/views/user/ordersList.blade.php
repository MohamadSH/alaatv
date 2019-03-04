@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section('page-css')
    {{--<link href="{{ mix('/css/user-profile.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('/acm/AlaatvCustomFiles/css/page-user-orders.css') }}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ asset('/assets/vendors/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>--}}
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


            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#user-orderList" role="tab">
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
                            @if((isset($instalments) && $instalments->isNotEmpty()) || true)
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#user-instalmentsList" role="tab">
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

                            <div class="m-section">
                                <div class="m-section__content">
                                    <div class="table-responsive">

                                        <table class="table m-table m-table--head-bg-success table-hover">
                                            <thead>
                                                <tr>
                                                    <th>وضعیت سفارش</th>
                                                    <th>وضعیت پرداخت</th>
                                                    <th>مبلغ(تومان)</th>
                                                    <th>پرداخت شده(تومان)</th>
                                                    <th>تاریخ ثبت نهایی</th>
                                                    <th>جزییات</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($orders as $orderKey=>$order)
                                                    <tr>
                                                        <td class="text-center">
                                                            <span class="m-badge m-badge--wide
                                                            @if(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED"))
                                                                    m-badge--success
                                                            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CANCELED"))
                                                                    m-badge--danger
                                                            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_POSTED") )
                                                                    m-badge--info
                                                            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_REFUNDED") )
                                                                    m-badge--metal
                                                            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_READY_TO_POST") )
                                                                    m-badge--info
                                                            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_PENDING") )
                                                                    m-badge--primary
                                                            @endif
                                                            ">
                                                                {{$order->orderstatus->displayName}}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">

                                                            @if(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_PAID"))
                                                                <span class="m-badge m-badge--wide m-badge--success">
                                                                    {{$order->paymentstatus->displayName}}
                                                                </span>
                                                            @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_UNPAID"))
                                                                <span class="m-badge m-badge--wide m-badge--warning">
                                                                    {{$order->paymentstatus->displayName}}
                                                                </span>
                                                                @if(isset($order->orderstatus->id) &&
                                                                    (
                                                                        $order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED") ||
                                                                        $order->orderstatus->id == config("constants.ORDER_STATUS_POSTED")
                                                                    )
                                                                )
                                                                    <button type="button"
                                                                            class="btn btn-sm m-btn--pill m-btn--air btn-accent"
                                                                            data-target="#onlinePaymentModal"
                                                                            data-toggle="modal"
                                                                            rel="{{$order->id}}">
                                                                        پرداخت
                                                                    </button>
                                                                @endif
                                                            @elseif(
                                                            isset($order->paymentstatus->id) &&
                                                                  $order->paymentstatus->id == config("constants.PAYMENT_STATUS_INDEBTED")
                                                            )
                                                                <span class="m-badge m-badge--wide m-badge--warning">
                                                                    {{$order->paymentstatus->displayName}}
                                                                </span>
                                                                <button type="button"
                                                                        class="btn btn-sm m-btn--pill m-btn--air btn-accent"
                                                                        data-target="#onlinePaymentModal"
                                                                        data-toggle="modal"
                                                                        rel="{{$order->id}}">
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
                                                                <span class="label label-info">بدون مبلغ</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($order->cost) || isset($order->costwithoutcoupon))
                                                                {{number_format($order->totalPaidCost() + $order->totalRefund())}}
                                                            @else
                                                                <span class="label label-info">بدون مبلغ</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($order->completed_at))
                                                                {{$order->CompletedAt_Jalali()}}
                                                            @else
                                                                <span class="label label-info">درج نشده</span>
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
                                        <div class="modal fade" id="orderDetailesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            جزییات سفارش
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                                                <td>وضعیت سفارش: </td>
                                                                                <td class="orderDetailes-orderStatus"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>کد مرسوله پست شده: </td>
                                                                                <td class="orderDetailes-orderPostingInfo"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>تاریخ ایجاد اولیه: </td>
                                                                                <td class="orderDetailes-created_at"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>تاریخ ثبت نهایی: </td>
                                                                                <td class="orderDetailes-completed_at"></td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col col-md-6">
                                                                        <table class="table table-sm m-table">
                                                                            <tbody>
                                                                            <tr>
                                                                                <td>وضعیت پرداخت: </td>
                                                                                <td class="orderDetailes-paymentStatus"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>مبلغ(تومان): </td>
                                                                                <td class="orderDetailes-price"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>پرداخت شده(تومان): </td>
                                                                                <td class="orderDetailes-paidPrice"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>بدهی(تومان): </td>
                                                                                <td class="orderDetailes-debt"></td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="alert alert-success" role="alert">
                                                                            <table class="table table-sm m-table">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>کپن استفاده شده: </td>
                                                                                    <td class="orderDetailes-couponInfo"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>تعداد بن استفاده شده: </td>
                                                                                    <td class="orderDetailes-usedBonSum">1</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>تعداد بن اضافه شده به شما از این سفارش: </td>
                                                                                    <td class="orderDetailes-addedBonSum">1</td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                    </div>
                                                                </div>


                                                                {{--<th>توضیح شما</th>--}}

                                                                {{--<th>تعداد بن اضافه شده به شما از این سفارش:</th>--}}
                                                                {{--<th>تاریخ ایجاد اولیه</th>--}}




                                                                {{--<td>--}}
                                                                {{--@if(!$order->orderpostinginfos->isEmpty())--}}
                                                                {{--<span class="font-red bold">--}}
                                                                {{--@foreach($order->orderpostinginfos as $postingInfo)--}}
                                                                {{--{{$postingInfo->postCode}}<br>--}}
                                                                {{--@endforeach</span>--}}
                                                                {{--@else--}}
                                                                {{--<span class="label label-info">پست نشده</span>--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td>@if($order->successfulTransactions->isEmpty())--}}
                                                                {{--<span class="label label-warning">تراکنشی یافت نشد</span>--}}
                                                                {{--@else--}}
                                                                {{--<br>--}}
                                                                {{--@foreach($order->successfulTransactions as $successfulTransaction)--}}
                                                                {{--@if(isset($successfulTransaction->paymentmethod->displayName)) {{ $successfulTransaction->paymentmethod->displayName}} @else--}}
                                                                {{--<span class="label label-danger">- نحوه پرداخت نامشخص</span> @endif--}}
                                                                {{--@if($successfulTransaction->getGrandParent() === false)--}}
                                                                {{--@if($successfulTransaction->getCode() !== false)--}}
                                                                {{--- {{$successfulTransaction->getCode()}} @endif--}}
                                                                {{--- مبلغ: @if($successfulTransaction->cost >= 0)--}}
                                                                {{--{{ number_format($successfulTransaction->cost) }}--}}
                                                                {{--<br>--}}
                                                                {{--@else--}}
                                                                {{--{{ number_format(-$successfulTransaction->cost) }}--}}
                                                                {{--(دریافت) <br>--}}
                                                                {{--@endif--}}
                                                                {{--@else--}}
                                                                {{--@if($successfulTransaction->getGrandParent()->getCode() === false)--}}
                                                                {{--- کد نامشخص @else--}}
                                                                {{--- {{$successfulTransaction->getGrandParent()->getCode()}} @endif--}}
                                                                {{-----}}
                                                                {{--مبلغ: @if($successfulTransaction->getGrandParent()->cost >= 0)--}}
                                                                {{--{{ number_format($successfulTransaction->getGrandParent()->cost) }}--}}
                                                                {{--<br>--}}
                                                                {{--@else--}}
                                                                {{--{{ number_format(-$successfulTransaction->getGrandParent()->cost) }}--}}
                                                                {{--(پرداخت) <br>--}}
                                                                {{--@endif--}}
                                                                {{--@endif--}}

                                                                {{--@endforeach--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td>@if($order->pendingTransactions->isEmpty())--}}
                                                                {{--<span class="label label-success">تراکنشی یافت نشد</span>--}}
                                                                {{--@else--}}
                                                                {{--<br>--}}
                                                                {{--@foreach($order->pendingTransactions as $pendingTransaction)--}}
                                                                {{--@if(isset($pendingTransaction->paymentmethod->displayName)) {{$pendingTransaction->paymentmethod->displayName}} @endif--}}
                                                                {{--@if(isset($pendingTransaction->transactionID))  ,شماره--}}
                                                                {{--تراکنش: {{ $pendingTransaction->transactionID }}--}}
                                                                {{--مبلغ: {{ number_format($pendingTransaction->cost) }}@endif--}}
                                                                {{--@if(isset($pendingTransaction->traceNumber))  ,شماره--}}
                                                                {{--پیگیری:{{$pendingTransaction->traceNumber}}--}}
                                                                {{--مبلغ: {{ number_format($pendingTransaction->cost) }}@endif--}}
                                                                {{--@if(isset($pendingTransaction->referenceNumber))  ,شماره--}}
                                                                {{--مرجع:{{$pendingTransaction->referenceNumber}}--}}
                                                                {{--مبلغ: {{ number_format($pendingTransaction->cost) }}@endif--}}
                                                                {{--@if(isset($pendingTransaction->paycheckNumber))  ,شماره--}}
                                                                {{--چک:{{$pendingTransaction->paycheckNumber}}--}}
                                                                {{--مبلغ: {{ number_format($pendingTransaction->cost) }}@endif--}}
                                                                {{--,توضیح مدیریتی: @if(strlen($pendingTransaction->managerComment)>0) <span class="bold font-blue">{{$pendingTransaction->managerComment}}</span>  @else <span class="label label-warning">ندارد</span>@endif--}}
                                                                {{--<br>--}}
                                                                {{--@endforeach--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td>@if($order->unpaidTransactions->isEmpty())--}}
                                                                {{--<span class="label label-success">قسطی ندارید</span>--}}
                                                                {{--@else--}}
                                                                {{--<br>--}}
                                                                {{--@foreach($order->unpaidTransactions as $instalment)--}}
                                                                {{--@if($instalment->cost)--}}
                                                                {{--مبلغ: {{ number_format($instalment->cost) }}@endif--}}
                                                                {{--مهلت--}}
                                                                {{--پرداخت: @if(isset($instalment->deadline_at)){{$instalment->DeadlineAt_Jalali()}}@endif--}}
                                                                {{--,توضیح مدیریتی: @if(strlen($instalment->managerComment)>0) <span class="bold font-blue">{{$instalment->managerComment}}</span>  @else <span class="label label-warning">ندارد</span>@endif--}}
                                                                {{--<br>--}}
                                                                {{--@endforeach--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td id="cost_{{$order->id}}">@if(isset($order->cost)|| isset($order->costwithoutcoupon)){{number_format($order->debt())}} @else--}}
                                                                {{--0 @endif</td>--}}
                                                                {{--<td>--}}
                                                                {{--@if(isset($order->customerDescription) && strlen($order->customerDescription)>0)--}}
                                                                {{--<span class="font-red bold">{{$order->customerDescription}}</span>--}}
                                                                {{--@else--}}
                                                                {{--<span class="label label-warning">بدون توضیح</span>--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td>--}}
                                                                {{--@if(isset($orderCoupons[$order->id]))--}}
                                                                {{--{{$orderCoupons[$order->id]["caption"]}}--}}
                                                                {{--@else--}}
                                                                {{--<span class="label label-info">کپن ندارد</span>--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}













                                                                {{--<td>{{$order->usedBonSum()}}</td>--}}
                                                                {{--<td>--}}








                                                                {{--@if($order->orderproducts->isNotEmpty())--}}
                                                                {{--{{$order->addedBonSum()}}--}}

                                                                {{--@else--}}
                                                                {{--<span class="label label-info">سفارش خالی است!</span>--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td>@if(isset($order->created_at)) {{$order->CreatedAt_Jalali()}} @else--}}
                                                                {{--<span class="label label-info">درج نشده</span> @endif</td>--}}





































                                                                {{--<td class="text-center">--}}
                                                                {{--<span class="m-badge m-badge--wide--}}
                                                                {{--@if(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED"))--}}
                                                                {{--m-badge--success--}}
                                                                {{--@elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CANCELED"))--}}
                                                                {{--m-badge--danger--}}
                                                                {{--@elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_POSTED") )--}}
                                                                {{--m-badge--info--}}
                                                                {{--@elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_REFUNDED") )--}}
                                                                {{--m-badge--metal--}}
                                                                {{--@elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_READY_TO_POST") )--}}
                                                                {{--m-badge--info--}}
                                                                {{--@elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_PENDING") )--}}
                                                                {{--m-badge--primary--}}
                                                                {{--@endif--}}
                                                                {{--">--}}
                                                                {{--{{$order->orderstatus->displayName}}--}}
                                                                {{--</span>--}}
                                                                {{--</td>--}}
                                                                {{--<td class="text-center">--}}

                                                                {{--@if(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_PAID"))--}}
                                                                {{--<span class="m-badge m-badge--wide m-badge--success">--}}
                                                                {{--{{$order->paymentstatus->displayName}}--}}
                                                                {{--</span>--}}
                                                                {{--@elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_UNPAID"))--}}
                                                                {{--<span class="m-badge m-badge--wide m-badge--warning">--}}
                                                                {{--{{$order->paymentstatus->displayName}}--}}
                                                                {{--</span>--}}
                                                                {{--@if(isset($order->orderstatus->id) &&--}}
                                                                {{--(--}}
                                                                {{--$order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED") ||--}}
                                                                {{--$order->orderstatus->id == config("constants.ORDER_STATUS_POSTED")--}}
                                                                {{--)--}}
                                                                {{--)--}}
                                                                {{--<button type="button"--}}
                                                                {{--class="btn btn-sm m-btn--pill m-btn--air btn-accent"--}}
                                                                {{--data-target="#onlinePaymentModal"--}}
                                                                {{--data-toggle="modal"--}}
                                                                {{--rel="{{$order->id}}">--}}
                                                                {{--پرداخت--}}
                                                                {{--</button>--}}
                                                                {{--@endif--}}
                                                                {{--@elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_INDEBTED"))--}}

                                                                {{--<button type="button"--}}
                                                                {{--class="btn btn-sm m-btn--pill m-btn--air btn-accent"--}}
                                                                {{--data-target="#onlinePaymentModal"--}}
                                                                {{--data-toggle="modal"--}}
                                                                {{--rel="{{$order->id}}">--}}
                                                                {{--پرداخت--}}
                                                                {{--</button>--}}
                                                                {{--<span class="m-badge m-badge--wide m-badge--warning">--}}
                                                                {{--{{$order->paymentstatus->displayName}}--}}
                                                                {{--</span>--}}
                                                                {{--@else--}}
                                                                {{--<span class="m-badge m-badge--wide m-badge--info">--}}
                                                                {{--ندارد--}}
                                                                {{--</span>--}}
                                                                {{--@endif--}}

                                                                {{--</td>--}}
                                                                {{--<td>--}}
                                                                {{--@if(isset($order->cost) || isset($order->costwithoutcoupon))--}}
                                                                {{--{{number_format($order->totalCost() )}}--}}
                                                                {{--@else--}}
                                                                {{--<span class="label label-info">بدون مبلغ</span>--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td>--}}
                                                                {{--@if(isset($order->cost) || isset($order->costwithoutcoupon))--}}
                                                                {{--{{number_format($order->totalPaidCost() + $order->totalRefund())}}--}}
                                                                {{--@else--}}
                                                                {{--<span class="label label-info">بدون مبلغ</span>--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}
                                                                {{--<td>--}}
                                                                {{--@if(isset($order->completed_at))--}}
                                                                {{--{{$order->CompletedAt_Jalali()}}--}}
                                                                {{--@else--}}
                                                                {{--<span class="label label-info">درج نشده</span>--}}
                                                                {{--@endif--}}
                                                                {{--</td>--}}




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
                                                                    <tbody class="orderDetailes-successfulTransactions">
                                                                    </tbody>
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
                                                                    <tbody class="orderDetailes-pending_transactions">
                                                                    </tbody>
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
                                                                    <tbody class="orderDetailes-unpaid_transactions">
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn m-btn--pill m-btn--air btn-outline-brand m-btn m-btn--custom" data-dismiss="modal">
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



                        </div>
                        <div class="tab-pane" id="user-paymentsList" role="tabpanel">
                            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </div>
                        <div class="tab-pane" id="user-instalmentsList" role="tabpanel">
                            It hasafsgag f gds gds gds gdfs gds gdfs g survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
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
                                            {!! Form::hidden('paymentmethod_id', config("constants.PAYMENT_METHOD_ATM")) !!}
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
                                                    @if(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED"))
                                                        <span class="label label-success"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CANCELED"))
                                                        <span class="label label-danger"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_POSTED") )
                                                        <span class="label label-info"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_REFUNDED") )
                                                        <span class="label bg-grey-salsa"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_READY_TO_POST") )
                                                        <span class="label label-info"> {{$order->orderstatus->displayName}}</span>
                                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_PENDING") )
                                                        <span class="label bg-purple"> {{$order->orderstatus->displayName}}</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @if(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_PAID"))
                                                        <span class="label label-success"> {{$order->paymentstatus->displayName}}</span>
                                                    @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_UNPAID"))
                                                        <span class="label bg-yellow-gold"> {{$order->paymentstatus->displayName}}</span>
                                                        @if(isset($order->orderstatus->id) && ($order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED") ||
                                                            $order->orderstatus->id == config("constants.ORDER_STATUS_POSTED")) )
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
                                                    @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_INDEBTED"))
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
                                                                <span class="bold " style="font-style: italic; ">@if($orderproduct->orderproducttype_id == config("constants.ORDER_PRODUCT_GIFT"))
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
                                                                            @if($transaction->transactionstatus->id == config("constants.TRANSACTION_STATUS_PENDING"))
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

@endsection

@section('page-js')
    <script src="{{ mix('/js/user-orders.js') }}"></script>
    <script>

        var orders = {!! $orders !!};


    </script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/page-user-orders.js') }}"></script>
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