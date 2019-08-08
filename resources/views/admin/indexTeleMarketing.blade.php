@extends('app')

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .mt-repeater-cell .d-table .d-table-cell {
            vertical-align: top;
        }
    </style>
@endsection

@section('content')
    <div class = "col-md-4">
        <!-- BEGIN Portlet PORTLET-->

        <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class = "m-portlet__body">
                {!! Form::open(['method'=>'GET' , 'action'=>'Web\AdminController@adminTeleMarketing']) !!}
                <div class = "row">
                    <div class = "col-lg-12">
                        <div class = "form-group mt-repeater">
                            <div data-repeater-list = "group-mobile">
                                <div data-repeater-item class = "mt-repeater-item mt-overflow">
                                    <div class = "mt-repeater-cell">
                                        <div class = "d-table a--full-width">
                                            <div class = "d-table-cell">
                                                <input type = "text" name = "mobile" placeholder = "شماره موبایل را وارد نمایید" class = "form-control mt-repeater-input-inline"/>
                                            </div>
                                            <div class = "d-table-cell">
                                                <a href = "javascript:" data-repeater-delete class = "btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                    <i class = "resources/views"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href = "javascript:" data-repeater-create class = "btn btn-success mt-repeater-add">
                                <i class = "fa fa-plus"></i>
                                افزودن شماره
                            </a>
                            <button class = "btn red-flamingo  bold" type = "submit">بگرد</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- END Portlet PORTLET-->
    </div>

    <div class = "col-md-8">
        <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class = "m-portlet__head">
                <div class = "m-portlet__head-caption">
                    <div class = "m-portlet__head-title">
                        <h3 class = "m-portlet__head-text">
                            <i class = "fa fa-list m--margin-right-10"></i>
                            لیست سفارش ها
                        </h3>
                    </div>
                </div>
            </div>
            <div class = "m-portlet__body">
                <div class = "table-toolbar">
                    <div class = "row">
                        <div class = "col-md-6">
                            <div class = "btn-group"></div>
                        </div>
                    </div>
                </div>
                @if(isset($orders))
                    <table class = "table table-striped table-bordered table-hover dt-responsive" width = "100%" id = "order_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class = "all"> نام خانوادگی</th>
                            <th class = "all"> نام کوچک</th>
                            <th class = "none"> محصولات</th>
                            <th class = "none"> رشته</th>
                            <th class = "desktop"> موبایل</th>
                            <th class = "min-tablet">مبلغ(تومان)</th>
                            <th class = "desktop">پرداخت شده(تومان)</th>
                            <th class = "none">مبلغ برگشتی(تومان)</th>
                            <th class = "none">بدهکار/بستانکار(تومان):</th>
                            <th class = "none">تراکنش های موفق:</th>
                            <th class = "none">تراکنش های منتظر تایید:</th>
                            <th class = "none">تراکنش های منتظر پرداخت:</th>
                            <th class = "none">توضیحات مسئول</th>
                            <th class = "none">توضیحات مشتری</th>
                            <th class = "min-tablet">وضعیت سفارش</th>
                            <th class = "min-tablet">وضعیت پرداخت</th>
                            <th class = "none"> تاریخ ثبت نهایی:</th>
                            <th class = "none">تعداد بن استفاده شده:</th>
                            <th class = "none">تعداد بن اضافه شده به شما از این سفارش:</th>
                            <th class = "none">کپن استفاده شده:</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <th>+</th>
                                <td>
                                    @if(isset($order->user->id)) @if(strlen($order->user->lastName) > 0) {{$order->user->lastName}} @else
                                        <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif @endif
                                </td>
                                <td>
                                    @if(isset($order->user->id)) @if(strlen($order->user->firstName) > 0) {{$order->user->firstName}} @else
                                        <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif @else
                                        <span class = "m-badge m-badge--wide label-sm m-badge--danger"> کاربر نامشخص است </span> @endif
                                </td>
                                <td>
                                    @if($order->orderproducts)
                                        <br>
                                        @foreach($order->orderproducts->whereIn("product_id" , $marketingProducts) as $orderproduct)
                                            @if(isset($orderproduct->product->id))
                                                <span class = "bold " style = "font-style: italic; ">
                                                    @if($orderproduct->orderproducttype_id == Config::get("constants.ORDER_PRODUCT_GIFT"))
                                                        <img src = "/acm/extra/gift-box.png" width = "25">
                                                    @endif
                                                    <a style = "color:#607075" target = "_blank" href = "@if($orderproduct->product->hasParents()){{action("Web\ProductController@show",$orderproduct->product->parents->first())}}@else{{action("Web\ProductController@show",$orderproduct->product)}}@endif">
                                                        {{$orderproduct->product->name}}
                                                        </a>
                                                </span>
                                                {{--@foreach($orderproduct->product->attributevalues('main')->get() as $attributevalue)--}}
                                                {{--{{$attributevalue->attribute->displayName}} : <span style="font-weight: normal">{{$attributevalue->name}} @if(isset(   $attributevalue->pivot->description) && strlen($attributevalue->pivot->description)>0 ) {{$attributevalue->pivot->description}} @endif</span><br>--}}
                                                {{--@endforeach--}}
                                                @foreach($orderproduct->attributevalues as $extraAttributevalue)
                                                    {{$extraAttributevalue->attribute->displayName}} :
                                                    <span style = "font-weight: normal">{{$extraAttributevalue->name}}
                                                        (+ {{number_format($extraAttributevalue->pivot->extraCost)}}
                                                        تومان)</span>
                                                    <br>
                                                @endforeach
                                            @endif
                                            <br>
                                        @endforeach
                                    @else
                                        <span class = "m-badge m-badge--wide m-badge--danger">ندارد</span>
                                    @endif
                                </td>
                                <td>@if(isset($order->user->major->name) > 0){{$order->user->major->name}} @else
                                        <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif
                                </td>
                                <td>
                                    @if(isset($order->user->id)){{$order->user->mobile}} @endif
                                </td>
                                <td>@if(isset($order->cost) || isset($order->costwithoutcoupon)){{number_format($order->totalCost())}} @else
                                        <span class = "m-badge m-badge--wide m-badge--danger">بدون مبلغ</span> @endif
                                </td>
                                <td>@if(isset($order->cost) || isset($order->costwithoutcoupon)){{number_format($order->totalPaidCost() + $order->totalRefund())}} @else
                                        <span class = "m-badge m-badge--wide m-badge--danger">بدون مبلغ</span> @endif
                                </td>
                                <td>@if(isset($order->cost) || isset($order->costwithoutcoupon)){{number_format(-$order->totalRefund())}} @else
                                        <span class = "m-badge m-badge--wide m-badge--danger">بدون مبلغ</span> @endif
                                </td>
                                <td>
                                    @if(isset($order->cost) || isset($order->costwithoutcoupon))
                                        {{number_format($order->debt())}}
                                    @else
                                        <span class = "m-badge m-badge--wide m-badge--danger">بدون مبلغ</span> @endif
                                </td>
                                <td>
                                    @if($order->successfulTransactions->isEmpty())
                                        <span class = "m-badge m-badge--wide m-badge--warning">ندارد</span>
                                    @else
                                        <br>
                                        @foreach($order->successfulTransactions as $successfulTransaction)
                                            <a target = "_blank" href = "{{action("Web\TransactionController@edit" ,$successfulTransaction )}}" class = "btn btn-xs blue-sharp btn-outline  sbold">اصلاح</a>
                                            @if($successfulTransaction->getGrandParent() !== false)
                                                <a target = "_blank" href = "{{action("Web\TransactionController@edit" ,$successfulTransaction->getGrandParent() )}}" class = "btn btn-xs blue-sharp btn-outline  sbold">رفتن به تراکنش والد</a>@endif
                                            @if(isset($successfulTransaction->paymentmethod->displayName)) {{ $successfulTransaction->paymentmethod->displayName}} @else
                                                <span class = "m-badge m-badge--wide m-badge--danger">- نحوه پرداخت نامشخص</span> @endif
                                            @if($successfulTransaction->getCode() === false) - بدون کد @else
                                                                                             - {{$successfulTransaction->getCode()}} @endif
                                                                                             - مبلغ: @if($successfulTransaction->cost >= 0)
                                                {{ number_format($successfulTransaction->cost) }}
                                                <br>
                                            @else
                                                {{ number_format(-$successfulTransaction->cost) }}(دریافت)
                                                <br>
                                            @endif
                                                                                             ,تاریخ
                                                                                             پرداخت:@if(isset($successfulTransaction->completed_at)){{$successfulTransaction->CompletedAt_Jalali()}}@else
                                                <span class = "bold m--font-danger">نامشخص</span>  @endif
                                                                                             ,توضیح مدیریتی: @if(strlen($successfulTransaction->managerComment)>0)
                                                <span class = "bold m--font-info">{{$successfulTransaction->managerComment}}</span>  @else
                                                <span class = "m-badge m-badge--wide m-badge--warning">ندارد</span>@endif
                                            <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($order->pendingTransactions->isEmpty())
                                        <span class = "m-badge m-badge--wide m-badge--success">ندارد</span>
                                    @else
                                        <br>
                                        @foreach($order->pendingTransactions as $pendingTransaction)
                                            <a target = "_blank" href = "{{action("Web\TransactionController@edit" ,$pendingTransaction )}}" class = "btn btn-xs blue-sharp btn-outline  sbold">اصلاح</a>
                                            @if(isset($pendingTransaction->paymentmethod->displayName)) {{$pendingTransaction->paymentmethod->displayName}} @endif
                                            @if(isset($pendingTransaction->transactionID))  ,شماره
                                                                                            تراکنش: {{ $pendingTransaction->transactionID }}  @endif
                                            @if(isset($pendingTransaction->traceNumber))  ,شماره
                                                                                            پیگیری:{{$pendingTransaction->traceNumber}}@endif
                                            @if(isset($pendingTransaction->referenceNumber))  ,شماره
                                                                                            مرجع:{{$pendingTransaction->referenceNumber}}@endif
                                            @if(isset($pendingTransaction->paycheckNumber))  ,شماره
                                                                                            چک:{{$pendingTransaction->paycheckNumber}}@endif
                                            @if(isset($pendingTransaction->cost))
                                                                                            ,مبلغ: {{ number_format($pendingTransaction->cost) }} @else
                                                <span class = "bold m--font-danger">بدون مبلغ</span>  @endif
                                                                                            ,تاریخ
                                                                                            پرداخت:@if(isset($pendingTransaction->completed_at)){{$pendingTransaction->CompletedAt_Jalali()}}@else
                                                <span class = "bold m--font-danger">نامشخص</span>  @endif
                                                                                            ,توضیح مدیریتی: @if(strlen($pendingTransaction->managerComment)>0)
                                                <span class = "bold m--font-info">{{$pendingTransaction->managerComment}}</span>  @else
                                                <span class = "m-badge m-badge--wide m-badge--warning">ندارد</span>@endif
                                            <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($order->unpaidTransactions->isEmpty())
                                        <span class = "m-badge m-badge--wide m-badge--success">ندارد</span>
                                    @else
                                        <br>
                                        @foreach($order->unpaidTransactions as $unpaid)
                                            <a target = "_blank" href = "{{action("Web\TransactionController@edit" ,$unpaid )}}" class = "btn btn-xs blue-sharp btn-outline  sbold">اصلاح</a>
                                            @if(isset($unpaid->cost))  ,مبلغ: {{ number_format($unpaid->cost) }} @else
                                                <span class = "bold m--font-danger">بدون مبلغ</span>  @endif
                                                                       ,مهلت
                                                                       پرداخت:@if(isset($unpaid->deadline_at)){{$unpaid->DeadlineAt_Jalali()}}@else
                                                <span class = "bold m--font-danger">نامشخص</span>  @endif
                                                                       ,توضیح مدیریتی: @if(strlen($unpaid->managerComment)>0)
                                                <span class = "bold m--font-info">{{$unpaid->managerComment}}</span>  @else
                                                <span class = "m-badge m-badge--wide m-badge--warning">ندارد</span>@endif
                                            <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if(!$order->ordermanagercomments->isEmpty())
                                        @foreach($order->ordermanagercomments as $managerComment)
                                            <span class = "m--font-danger bold">{{$managerComment->comment}}</span>
                                            <br>
                                        @endforeach
                                    @else
                                        <span class = "m-badge m-badge--wide m-badge--warning">بدون توضیح</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($order->customerDescription) && strlen($order->customerDescription)>0 )
                                        <span class = "m--font-danger bold">{{$order->customerDescription}}<br></span>
                                    @else
                                        <span class = "m-badge m-badge--wide m-badge--warning">بدون توضیح</span>
                                    @endif
                                </td>
                                <td style = "text-align: center;">
                                    @if(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_CLOSED"))
                                        <span class = "m-badge m-badge--wide m-badge--success"> {{$order->orderstatus->displayName}}</span>
                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_CANCELED"))
                                        <span class = "m-badge m-badge--wide m-badge--danger"> {{$order->orderstatus->displayName}}</span>
                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_POSTED") )
                                        <span class = "m-badge m-badge--wide m-badge--info"> {{$order->orderstatus->displayName}}</span>
                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_REFUNDED") )
                                        <span class = "m-badge m-badge--wide bg-grey-salsa"> {{$order->orderstatus->displayName}}</span>
                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_OPEN"))
                                        <span class = "m-badge m-badge--wide m-badge--danger"> {{$order->orderstatus->displayName}}</span>
                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_OPEN_BY_ADMIN"))
                                        <span class = "m-badge m-badge--wide m-badge--warning"> {{$order->orderstatus->displayName}}</span>
                                    @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == Config::get("constants.ORDER_STATUS_READY_TO_POST"))
                                        <span class = "m-badge m-badge--wide m-badge--info"> {{$order->orderstatus->displayName}}</span>
                                    @endif
                                </td>
                                <td style = "text-align: center;">
                                    @if(isset($order->paymentstatus->id) && $order->paymentstatus->id == Config::get("constants.PAYMENT_STATUS_PAID"))
                                        <span class = "m-badge m-badge--wide m-badge--success">{{$order->paymentstatus->displayName}}</span>
                                    @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == Config::get("constants.PAYMENT_STATUS_UNPAID"))
                                        <span class = "m-badge m-badge--wide m-badge--danger"> {{$order->paymentstatus->displayName}}</span>
                                    @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == Config::get("constants.PAYMENT_STATUS_INDEBTED"))
                                        <span class = "m-badge m-badge--wide m-badge--warning"> {{$order->paymentstatus->displayName}}</span>
                                    @endif
                                </td>
                                <td>@if(isset($order->completed_at) && strlen($order->completed_at)>0) {{ $order->CompletedAt_Jalali() }} @else
                                        <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif
                                </td>
                                <td>
                                    {{$order->usedBonSum()}}
                                </td>
                                <td>
                                    @if($order->orderproducts->isNotEmpty())
                                        {{$order->addedBonSum($order->user)}}
                                    @else
                                        <span class = "m-badge m-badge--wide m-badge--info">سفارش خالی است!</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->determineCoupontype() !== false)
                                        @if($order->determineCoupontype()["type"] == Config::get("constants.DISCOUNT_TYPE_PERCENTAGE"))
                                            کپن {{$order->coupon->name}} (کد:{{$order->coupon->code}})
                                            با {{$order->determineCoupontype()["discount"]}}  % تخفیف

                                        @elseif($order->determineCoupontype()["type"] == Config::get("constants.DISCOUNT_TYPE_COST"))
                                            کپن {{$order->coupon->name}} (کد:{{$order->coupon->code}})
                                            با {{number_format($order->determineCoupontype()["discount"])}}  تومان تخفیف

                                        @endif
                                    @else
                                            بدون کپن
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h4 class = "text-center bold">
                        لطفا ابتدا فیلتر کنید
                    </h4>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/admin/page-teleMarketingAdminPanel.js') }}" type="text/javascript"></script>
@endsection
