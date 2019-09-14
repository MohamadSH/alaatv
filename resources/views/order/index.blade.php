@permission((config('constants.LIST_ORDER_ACCESS')))
@foreach($orders as $order)
    <tr>
        <th></th>
        <td id = "orderCustomerFullName_{{$order->id}}">
            @if(isset($order->user->id))
                @if(strlen($order->user->lastName) > 0)
                    <a target = "_blank" href = "{{action("Web\UserController@edit" , $order->user)}}">
                        {{$order->user->lastName}}
                    </a>
                @else
                    <span class = "m-badge m-badge--danger m-badge--wide">درج نشده</span>
                @endif
            @endif
        </td>
        <td>
            @if(isset($order->user->id))
                @if(strlen($order->user->firstName) > 0)
                    {{$order->user->firstName}}
                @else
                    <span class = "m-badge m-badge--danger m-badge--wide">درج نشده</span>
                @endif
            @else
                <span class = "m-badge m-badge--danger m-badge--wide">کاربر نامشخص است</span>
            @endif
        </td>
        <td>
            <div class = "btn-group">
                <span class = "order_id hidden" id = "{{$order->id}}"></span>
                <span class = "user_id hidden" id = "{{$order->user->id}}"></span>
                @permission((config('constants.SHOW_ORDER_ACCESS')))
                <a target = "_blank" class = "btn btn-success" href = "{{action("Web\OrderController@edit" , $order)}}">
                    <i class = "fa fa-pencil"></i>
                    اصلاح
                </a>
                @endpermission @permission((config('constants.REMOVE_ORDER_ACCESS')))
                <a class = "btn btn-danger deleteOrder" data-target = "#deleteOrderConfirmationModal" data-toggle = "modal">
                    <i class = "fa fa-remove" aria-hidden = "true"></i>
                    حذف
                </a>
                @endpermission @permission((config('constants.SEND_SMS_TO_USER_ACCESS')))
                <a class = "btn btn-info sendSms" data-target = "#sendSmsModal" data-toggle = "modal">
                    <i class = "fa fa-envelope" aria-hidden = "true"></i>
                    ارسال پیامک
                </a>
                @endpermission
                <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
            </div>
        </td>
        <td>
            @if($order->orderproducts)
                <br>
                @foreach($order->orderproducts as $orderproduct)
                    @if(isset($orderproduct->product->id))
                        <span class = "bold " style = "font-style: italic; ">
                            @if($orderproduct->orderproducttype_id == config("constants.ORDER_PRODUCT_GIFT"))
                                <img src = "/assets/extra/gift-box.png" width = "25">
                            @endif
                            <a style = "color:#607075" target = "_blank" href = "@if($orderproduct->product->hasParents()){{action("Web\ProductController@show",$orderproduct->product->parents->first())}} @else  {{action("Web\ProductController@show",$orderproduct->product)}} @endif">
                                {{$orderproduct->product->name}}
                            </a>
                        </span>
                        @if(isset($orderproduct->checkoutstatus_id))
                            -
                            <span class = "m--font-danger bold">{{$orderproduct->checkoutstatus->displayName}}</span>
                        @endif
                        <br>

                        @foreach($orderproduct->product->attributevalues('main')->get() as $attributevalue)
                            {{$attributevalue->attribute->displayName}} :
                            <span style = "font-weight: normal">
                                {{$attributevalue->name}}
                                @if(isset(   $attributevalue->pivot->description) && strlen($attributevalue->pivot->description)>0 )
                                    {{$attributevalue->pivot->description}}
                                @endif
                            </span>
                            <br>
                        @endforeach
                        @foreach($orderproduct->attributevalues as $extraAttributevalue)
                            {{$extraAttributevalue->attribute->displayName}} :
                            <span style = "font-weight: normal">
                                {{$extraAttributevalue->name}} (+ {{number_format($extraAttributevalue->pivot->extraCost)}} تومان)
                            </span>
                            <br>
                        @endforeach

                        <br>
                    @endif
                @endforeach
            @else
                <span class = "m-badge m-badge--wide m-badge--danger">ندارد</span>
            @endif
        </td>
        <td>@if(isset($order->user->major->name) > 0){{$order->user->major->name}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
        <td>@if(isset($order->user->id ) && strlen($order->user->province) > 0){{$order->user->province}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
        <td>@if(isset($order->user->id ) && strlen($order->user->city) > 0){{$order->user->city}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
        <td>@if(isset($order->user->id ) && strlen($order->user->address) > 0){{$order->user->address}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
        <td>@if(isset($order->user->id ) && strlen($order->user->postalCode) > 0){{$order->user->postalCode}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
        @permission((config('constants.SHOW_USER_MOBILE')))
        <td>
            @if(isset($order->user->id)){{$order->user->mobile}} @endif
        </td>
        <td>
            @if(isset($order->user->id)){{$order->user->nationalCode}} @endif
        </td>
        @endpermission
        <td>@if(isset($order->cost) || isset($order->costwithoutcoupon)){{number_format($order->totalCost())}} @else
                <span class = "m-badge m-badge--wide m-badge--danger">بدون مبلغ</span> @endif</td>
        @permission((config('constants.SHOW_USER_EMAIL')))
        <td>
            @if(isset($order->user->email) && strlen($order->user->email) > 0){{$order->user->email}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif
        </td>
        @endpermission
        <td>
            @if(isset($order->cost) || isset($order->costwithoutcoupon))
                {{number_format($order->totalPaidCost() + $order->totalRefund())}}
            @else
                <span class = "m-badge m-badge--wide m-badge--danger">بدون مبلغ</span>
            @endif
        </td>
        <td>
            @if(isset($order->cost) || isset($order->costwithoutcoupon))
                {{number_format(-$order->totalRefund())}}
            @else
                <span class = "m-badge m-badge--wide m-badge--danger">بدون مبلغ</span> @endif
        </td>
        <td>
            {{--            @if(isset($order->cost) || isset($order->costwithoutcoupon))@if($order->debt() > 0) {{number_format($order->debt())}} بدهکار @elseif($order->debt() < 0) {{number_format(abs($order->debt()))}} بستانکار @else 0 @endif--}}
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
                        <a target = "_blank" href = "{{action("Web\TransactionController@edit" ,$successfulTransaction->getGrandParent() )}}" class = "btn btn-xs blue-sharp btn-outline  sbold">رفتن به تراکنش والد</a>
                    @endif
                    @if(isset($successfulTransaction->paymentmethod->displayName))
                        {{ $successfulTransaction->paymentmethod->displayName}}
                    @else
                        <span class = "m-badge m-badge--wide m-badge--danger">- نحوه پرداخت نامشخص</span>
                    @endif
                    @if($successfulTransaction->getCode() === false)
                        - بدون کد
                    @else
                        - {{$successfulTransaction->getCode()}}
                    @endif
                        - مبلغ:
                    @if($successfulTransaction->cost >= 0)
                        {{ number_format($successfulTransaction->cost) }}
                        <br>
                    @else
                        {{ number_format(-$successfulTransaction->cost) }}(دریافت)
                        <br>
                    @endif
                        ,تاریخ پرداخت:
                    @if(isset($successfulTransaction->completed_at))
                        {{$successfulTransaction->CompletedAt_Jalali()}}
                    @else
                        <span class = "bold m--font-danger">نامشخص</span>
                    @endif
                        ,توضیح مدیریتی:
                    @if(strlen($successfulTransaction->managerComment)>0)
                        <span class = "bold m--font-info">{{$successfulTransaction->managerComment}}</span>
                    @else
                        <span class = "m-badge m-badge--wide m-badge--warning">ندارد</span>
                    @endif
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
                    @if(isset($pendingTransaction->transactionID))  ,شماره تراکنش: {{ $pendingTransaction->transactionID }}  @endif
                    @if(isset($pendingTransaction->traceNumber))  ,شماره پیگیری:{{$pendingTransaction->traceNumber}}@endif
                    @if(isset($pendingTransaction->referenceNumber))  ,شماره مرجع:{{$pendingTransaction->referenceNumber}}@endif
                    @if(isset($pendingTransaction->paycheckNumber))  ,شماره چک:{{$pendingTransaction->paycheckNumber}}@endif
                    @if(isset($pendingTransaction->cost))
                                                                    ,مبلغ: {{ number_format($pendingTransaction->cost) }}
                    @else
                        <span class = "bold m--font-danger">بدون مبلغ</span>
                    @endif
                                                                    ,تاریخ پرداخت:
                    @if(isset($pendingTransaction->completed_at))
                        {{$pendingTransaction->CompletedAt_Jalali()}}
                    @else
                        <span class = "bold m--font-danger">نامشخص</span>
                    @endif
                                                                    ,توضیح مدیریتی:
                    @if(strlen($pendingTransaction->managerComment)>0)
                        <span class = "bold m--font-info">
                            {{$pendingTransaction->managerComment}}
                        </span>
                    @else
                        <span class = "m-badge m-badge--wide m-badge--warning">ندارد</span>
                    @endif
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
                    @if(isset($unpaid->cost))
                        ,مبلغ: {{ number_format($unpaid->cost) }}
                    @else
                        <span class = "bold m--font-danger">بدون مبلغ</span>
                    @endif
                        ,مهلت پرداخت:
                    @if(isset($unpaid->deadline_at))
                        {{$unpaid->DeadlineAt_Jalali()}}
                    @else
                        <span class = "bold m--font-danger">نامشخص</span>
                    @endif
                        ,توضیح مدیریتی:
                    @if(strlen($unpaid->managerComment)>0)
                        <span class = "bold m--font-info">{{$unpaid->managerComment}}</span>
                    @else
                        <span class = "m-badge m-badge--wide m-badge--warning">ندارد</span>
                    @endif
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
            @if(!$order->orderpostinginfos->isEmpty())
                <span class = "m--font-danger bold">
                    @foreach($order->orderpostinginfos as $postingInfo)
                        {{$postingInfo->postCode}}
                        <br>
                    @endforeach
                </span>
            @else
                <span class = "m-badge m-badge--wide m-badge--info">ندارد</span>
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
            @if(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CLOSED"))
                <span class = "m-badge m-badge--wide m-badge--success"> {{$order->orderstatus->displayName}}</span>
            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_CANCELED"))
                <span class = "m-badge m-badge--wide m-badge--danger"> {{$order->orderstatus->displayName}}</span>
            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_POSTED") )
                <span class = "m-badge m-badge--wide m-badge--info"> {{$order->orderstatus->displayName}}</span>
            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_REFUNDED") )
                <span class = "m-badge m-badge--wide bg-grey-salsa"> {{$order->orderstatus->displayName}}</span>
            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_OPEN"))
                <span class = "m-badge m-badge--wide m-badge--danger"> {{$order->orderstatus->displayName}}</span>
            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_OPEN_BY_ADMIN"))
                <span class = "m-badge m-badge--wide m-badge--warning"> {{$order->orderstatus->displayName}}</span>
            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_READY_TO_POST"))
                <span class = "m-badge m-badge--wide m-badge--info"> {{$order->orderstatus->displayName}}</span>
            @elseif(isset($order->orderstatus->id) && $order->orderstatus->id == config("constants.ORDER_STATUS_PENDING") )
                <span class = "m-badge m-badge--wide bg-purple"> {{$order->orderstatus->displayName}}</span>
            @endif
        </td>
        <td style = "text-align: center;">
            @if(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_PAID"))
                <span class = "m-badge m-badge--wide m-badge--success">{{$order->paymentstatus->displayName}}</span>
            @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_UNPAID"))
                <span class = "m-badge m-badge--wide m-badge--danger"> {{$order->paymentstatus->displayName}}</span>
            @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == config("constants.PAYMENT_STATUS_INDEBTED"))
                <span class = "m-badge m-badge--wide m-badge--warning"> {{$order->paymentstatus->displayName}}</span>
            @elseif(isset($order->paymentstatus->id) && $order->paymentstatus->id == 4)
                <span class = "m-badge m-badge--wide m-badge--warning"> {{$order->paymentstatus->displayName}}</span>
            @endif
        </td>
        <td>
            @if(isset($order->updated_at) && strlen($order->updated_at)>0)
                {{ $order->UpdatedAt_Jalali() }}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($order->completed_at) && strlen($order->completed_at)>0)
                {{ $order->CompletedAt_Jalali() }}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            {{$order->usedBonSum()}}
        </td>
        <td>
            @if($order->orderproducts->isNotEmpty())
                {{$order->addedBonSum()}}
            @else
                <span class = "m-badge m-badge--wide m-badge--info">سفارش خالی است!</span>
            @endif
        </td>
        <td>
            @if($order->determineCoupontype() !== false)
                @if($order->determineCoupontype()["type"] == config("constants.DISCOUNT_TYPE_PERCENTAGE"))
                    کپن {{$order->coupon->name}} (کد:{{$order->coupon->code}}) با {{$order->determineCoupontype()["discount"]}}  % تخفیف

                @elseif($order->determineCoupontype()["type"] == config("constants.DISCOUNT_TYPE_COST"))
                    کپن {{$order->coupon->name}} (کد:{{$order->coupon->code}}) با {{number_format($order->determineCoupontype()["discount"])}}  تومان تخفیف

                @endif
            @else
                    بدون کپن
            @endif
        </td>
        <td>
            @if(isset($order->paymentstatus_id))
                {{$order->paymentstatus->displayName}}
            @else
                نا مشخص
            @endif
        </td>
        <td>
            @if(isset($order->created_at) && strlen($order->created_at)>0)
                {{ $order->CreatedAt_Jalali() }}
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
    </tr>
@endforeach
@endpermission
