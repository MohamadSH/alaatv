@permission((Config::get('constants.LIST_TRANSACTION_ACCESS')))
@foreach($transactions as $transaction)
    <tr id="{{$transaction->id}}">
        <th></th>
        <td>@if(isset($transaction->order->user->id)) @if(strlen($transaction->order->user->reverse_full_name) > 0)
                <a target="_blank"
                   href="{{action("UserController@edit" , $transaction->order->user)}}">{{$transaction->order->user->reverse_full_name}}</a> @else
                <span class="label label-sm label-danger"> درج نشده </span> @endif @endif</td>
        <td>@if($transaction->hasParents())<a target="_blank"
                                              href="{{action('TransactionController@edit' , $transaction->getGrandParent())}}">رفتن
                به تراکنش</a> @else ندارد @endif</td>
        <td>@if(isset($transaction->order->user)) @if(!isset($transaction->order->user->mobile) ) <span
                    class="label label-sm label-danger"> درج نشده </span> @else {{$transaction->order->user->mobile}} @endif @endif
        </td>
        @permission((Config::get('constants.SHOW_TRANSACTION_TOTAL_COST_ACCESS')))
        <td>@if(isset($transaction->order->cost) || isset($transaction->order->costwithoutcoupon)){{number_format($transaction->order->totalCost())}} @else
                <span class="label label-sm label-danger"> درج نشده </span>  @endif</td>
        <td>@if(isset($transaction->cost))<span dir="ltr">{{number_format($transaction->cost)}}</span> @else <span
                    class="label label-sm label-danger"> درج نشده </span>  @endif</td>
        @endpermission
        @permission((Config::get('constants.SHOW_TRANSACTION_TOTAL_FILTERED_COST_ACCESS')))
        <td>@if(isset($transactionOrderproductCost[$transaction->id]))<span
                    dir="ltr">{{number_format( $transactionOrderproductCost[$transaction->id]["cost"]  )}}</span>@else
                <span class="label label-sm label-warning"> نامشخص </span>  @endif</td>
        <td>@if(isset($transactionOrderproductCost[$transaction->id])){{number_format($transactionOrderproductCost[$transaction->id]["extraCost"])}} @else
                <span class="label label-sm label-warning"> نامشخص </span>  @endif</td>
        @endpermission
        <td>
            @if(isset($transaction->transactionID)) {{$transaction->transactionID}}
            @elseif(isset($transaction->traceNumber)) {{$transaction->traceNumber}}
            @elseif(isset($transaction->referenceNumber)) {{$transaction->referenceNumber}}
            @elseif(isset($transaction->paycheckNumber)) {{$transaction->paycheckNumber}}
            @else <span class="label label-sm label-warning"> ندارد </span>
            @endif
        </td>
        <td>@if(isset($transaction->paymentmethod)) {{$transaction->paymentmethod->displayName}} @else <span
                    class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($transaction->created_at) && strlen($transaction->created_at) > 0){{ $transaction->CreatedAt_Jalali() }}@else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>@if(isset($transaction->deadline_at) && strlen($transaction->deadline_at) > 0){{ $transaction->DeadlineAt_Jalali() }}@else
                <span class="label label-sm label-default"> ندارد </span> @endif</td>
        <td>@if(isset($transaction->completed_at) && strlen($transaction->completed_at) > 0){{ $transaction->CompletedAt_Jalali() }}@else
                <span class="label label-sm label-danger"> درج نشده </span> @endif</td>
        <td>
            @permission((Config::get('constants.EDIT_TRANSACTION_ACCESS')))
            <a target="_blank" class="btn btn-success" href="{{action("TransactionController@edit" , $transaction)}}"><i
                        class="fa fa-pencil"></i> اصلاح </a>
            @if(isset($transaction->order->id))
                <a target="_blank" class="btn blue" href="{{action("OrderController@edit" , $transaction->order)}}"><i
                            class="fa fa-pencil"></i> رفتن به سفارش </a>
            @endif
            @endpermission
            @if($transaction->cost < 0)
                @if(!isset($transaction->traceNumber))
                    <a target="_blank"
                       class="btn red transactionToDonateButton transactionSpecialButton_{{$transaction->id}}"
                       data-role="{{$transaction->id}}"
                       data-action="{{action('TransactionController@convertToDonate' , $transaction)}}">تبدیل به
                        دونیت</a>
                    <button class="btn purple completeTransactionInfo transactionSpecialButton transactionSpecialButton_{{$transaction->id}}"
                            data-role="{{$transaction->id}}"
                            data-action="{{action("TransactionController@completeTransaction" , $transaction->id)}}"
                            data-target="#completeTransactionInfo" data-toggle="modal">
                        وارد کردن کد تراکنش
                    </button>
                @endif
            @endif
        </td>
        <td>@if(isset($transaction->order->managerDescription) && strlen($transaction->order->managerDescription)>0 || isset($transaction->managerComment) && strlen($transaction->managerComment)>0) @if(isset($transaction->order->managerDescription) && strlen($transaction->order->managerDescription)) {{$transaction->order->managerDescription}} @endif @if(isset($transaction->managerComment) && strlen($transaction->managerComment)>0) {{$transaction->managerComment}} @endif @else
                <span class="label label-sm label-warning"> درج نشده </span> @endif</td>
        {{--<td>--}}
        {{--<div class="btn-group">--}}
        {{--<button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات--}}
        {{--<i class="fa fa-angle-down"></i>--}}
        {{--</button>--}}
        {{--<ul class="dropdown-menu" role="menu">--}}
        {{--@permission((Config::get('constants.SHOW_ORDER_ACCESS')))--}}
        {{--<li>--}}
        {{--<a href="{{action("OrderController@edit" , $order)}}">--}}
        {{--<i class="fa fa-pencil"></i> اصلاح </a>--}}
        {{--</li>--}}
        {{--@endpermission--}}
        {{--@permission((Config::get('constants.REMOVE_ORDER_ACCESS')))--}}
        {{--<li>--}}
        {{--<a class="deleteOrder" data-target="#deleteOrderConfirmationModal" data-toggle="modal">--}}
        {{--<i class="fa fa-remove" aria-hidden="true"></i> حذف </a>--}}
        {{--</li>--}}
        {{--@endpermission--}}

        {{--</ul>--}}
        {{--<div id="ajax-modal" class="modal fade" tabindex="-1"> </div>--}}
        {{--</div>--}}
        {{--</td>--}}
    </tr>
@endforeach
@endpermission
