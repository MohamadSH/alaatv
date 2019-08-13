@permission((config('constants.LIST_TRANSACTION_ACCESS')))
@foreach($transactions as $transaction)
    <tr id="{{$transaction->id}}">
        <th></th>
        <td>
            @if(isset($transaction->order->user->id)) @if(strlen($transaction->order->user->reverse_full_name) > 0)
                <a target="_blank"
                   href="{{action("Web\UserController@edit" , $transaction->order->user)}}">{{$transaction->order->user->reverse_full_name}}</a> @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif @endif
        </td>
        <td>
            @if($transaction->hasParents())
                <a target="_blank" href="{{action('TransactionController@edit' , $transaction->getGrandParent())}}">رفتن
                    به تراکنش</a>
            @else ندارد @endif
        </td>
        <td>
            @if(isset($transaction->order->user)) @if(!isset($transaction->order->user->mobile) )
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @else {{$transaction->order->user->mobile}} @endif @endif
        </td>
        @permission((config('constants.SHOW_TRANSACTION_TOTAL_COST_ACCESS')))
        <td>
            @if(isset($transaction->order->cost) || isset($transaction->order->costwithoutcoupon)){{number_format($transaction->order->totalCost())}} @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>  @endif
        </td>
        <td>
            @if(isset($transaction->cost))
                <span dir="ltr">{{number_format($transaction->cost)}}</span> @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>  @endif
        </td>
        @endpermission
        <td>
            @if(isset($transaction->transactionID)) {{$transaction->transactionID}}
            @elseif(isset($transaction->traceNumber)) {{$transaction->traceNumber}}
            @elseif(isset($transaction->referenceNumber)) {{$transaction->referenceNumber}}
            @elseif(isset($transaction->paycheckNumber)) {{$transaction->paycheckNumber}}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--warning"> ندارد </span>
            @endif
        </td>
        <td>
            @if(isset($transaction->transactiongateway))
                {{ $transaction->transactiongateway->displayName }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--info">بدون درگاه</span>
            @endif
        </td>
        <td>
            @if(isset($transaction->paymentmethod))
                {{$transaction->paymentmethod->displayName}}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($transaction->created_at) && strlen($transaction->created_at) > 0)
                {{ $transaction->CreatedAt_Jalali() }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @if(isset($transaction->deadline_at) && strlen($transaction->deadline_at) > 0)
                {{ $transaction->DeadlineAt_Jalali() }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--metal"> ندارد </span>
            @endif
        </td>
        <td>
            @if(isset($transaction->completed_at) && strlen($transaction->completed_at) > 0)
                {{ $transaction->CompletedAt_Jalali() }}
            @else
                <span class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>
        <td>
            @permission((config('constants.EDIT_TRANSACTION_ACCESS')))
            <a target="_blank" class="btn btn-success"
               href="{{action("Web\TransactionController@edit" , $transaction)}}">
                <i class="fa fa-pencil"></i>
                اصلاح تراکنش
            </a>
            @endpermission
            @if($transaction->cost < 0)
                @if(!isset($transaction->traceNumber))
                    <a target="_blank"
                       class="btn red transactionToDonateButton transactionSpecialButton_{{$transaction->id}}"
                       data-role="{{$transaction->id}}"
                       data-action="{{action('Web\TransactionController@convertToDonate' , $transaction)}}">
                        تبدیل به دونیت
                    </a>
                    <button class="btn purple completeTransactionInfo transactionSpecialButton transactionSpecialButton_{{$transaction->id}}"
                            data-role="{{$transaction->id}}"
                            data-action="{{action("Web\TransactionController@completeTransaction" , $transaction->id)}}"
                            data-target="#completeTransactionInfo" data-toggle="modal">
                        وارد کردن کد تراکنش
                    </button>
                @endif
            @endif
        </td>
        <td>
            @if(isset($transaction->order->managerDescription) && strlen($transaction->order->managerDescription)>0 || isset($transaction->managerComment) && strlen($transaction->managerComment)>0) @if(isset($transaction->order->managerDescription) && strlen($transaction->order->managerDescription)) {{$transaction->order->managerDescription}} @endif @if(isset($transaction->managerComment) && strlen($transaction->managerComment)>0) {{$transaction->managerComment}} @endif @else
                <span class="m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif
        </td>
        <td>
            <div class="btn-group">
                @if(isset($transaction->order->id))
                    @permission((config('constants.SHOW_ORDER_ACCESS')))
                    <a target="_blank" class="btn btn-success" href="{{action("Web\OrderController@edit" , $transaction->order)}}">
                        <i class="fa fa-pencil"></i>
                        اصلاح سفارش
                    </a>
                    @endpermission
                    @permission((config('constants.REMOVE_ORDER_ACCESS')))
                    <a class="deleteOrder btn btn-danger" data-target="#deleteOrderConfirmationModal" data-toggle="modal">
                        <i class="fa fa-remove" aria-hidden="true"></i> حذف سفارش
                    </a>
                    @endpermission
                @endif
            </div>
        </td>
    </tr>
@endforeach
@endpermission
