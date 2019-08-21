@permission((config('constants.LIST_COUPON_ACCESS')))
@foreach($coupons as $coupon)
    <tr>

        <th></th>
        <td>@if(isset($coupon->name[0])){{$coupon->name}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($coupon->description[0])){{$coupon->description}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--warning"> بدون توضیح </span> @endif</td>
        <td>{{($coupon->enable)?'بله':'خیر'}}</td>
        <td>@if(isset($coupon->code[0])){{$coupon->code}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        <td>@if(isset($coupon->discount)){{$coupon->discount}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        {{--        <td>@if(isset($coupon->maxCost[0])){{$coupon->maxCost}} @else <span class="m-badge m-badge--wide label-sm m-badge--warning"> ندارد </span> @endif</td>--}}

        <td>@if(isset($coupon->usageLimit)){{$coupon->usageLimit}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--info"> نامحدود </span> @endif</td>

        <td>@if(isset($coupon->usageNumber)){{$coupon->usageNumber}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>

        <td>
            @if(isset($coupon->coupontype))
                @if($coupon->coupontype->id == 1)
                    همه محصولات
                @elseif($coupon->coupontype->id == 2)
                    برخی محصولات
                        {{--@if(isset($coupon->products))--}}
                        {{--@foreach($coupon->products as $product)--}}
                        {{--<br>--}}
                        {{--{{$product->name}}--}}
                        {{--@endforeach--}}
                        {{--@else--}}
                        {{--بدون محصول--}}
                        {{--@endif--}}
                @endif
            @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span>
            @endif
        </td>

        <td>@if(isset($coupon->created_at) && strlen($coupon->created_at) > 0){{$coupon->CreatedAt_Jalali()}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        </td>
        <td>@if(isset($coupon->validSince) && strlen($coupon->validSince) > 0){{$coupon->ValidSince_Jalali()}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        </td>
        <td>@if(isset($coupon->validUntil) && strlen($coupon->validUntil) > 0){{$coupon->ValidUntil_Jalali()}} @else
                <span class = "m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
        </td>
        <td>
            <div class = "btn-group">
                <button class = "btn btn-xs black dropdown-toggle" type = "button" data-toggle = "dropdown" aria-expanded = "false"> عملیات
                    <i class = "fa fa-angle-down"></i>
                </button>
                <ul class = "dropdown-menu" role = "menu">
                    @permission((config('constants.SHOW_COUPON_ACCESS')))
                    <li>
                        <a target="_blank" href = "{{action("Web\CouponController@edit" , $coupon)}}">
                            <i class = "fa fa-pencil"></i>
                            اصلاح
                        </a>
                    </li>
                    @endpermission
                    @permission((config('constants.REMOVE_COUPON_ACCESS')))
                    <li>
                        <a data-target = "#static-{{$coupon->id}}" data-toggle = "modal">
                            <i class = "fa fa-remove"></i>
                            حذف
                        </a>
                    </li>
                    @endpermission
                </ul>
                <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>
                <!-- static -->
                @permission((config('constants.REMOVE_COUPON_ACCESS')))

                <!--begin::Modal-->
                <div class = "modal fade" id = "static-{{$coupon->id}}" tabindex = "-1" role = "dialog" aria-hidden = "true">
                    <div class = "modal-dialog" role = "document">
                        <div class = "modal-content">
                            <div class = "modal-body">
                                <p> آیا مطمئن هستید؟</p>
                            </div>
                            <div class = "modal-footer">
                                <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">خیر</button>
                                <button type = "button" class = "btn btn-primary" data-dismiss = "modal" onclick = "removeCoupon('{{action("Web\CouponController@destroy" , $coupon)}}');">بله</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->

                @endpermission
            </div>
        </td>
    </tr>
@endforeach
@endpermission
