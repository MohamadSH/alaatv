@if(isset($reportType[0]))
    @if(strcmp($reportType , "bookSelling") == 0)
        @permission((Config::get('constants.GET_BOOK_SELL_REPORT')))
        @if($users->isNotEmpty())
            @if(isset($products))
                <ul>
                    @foreach( $users as $user)
                        <li class="bold">
                            @if(isset($user->firstName) && strlen($user->firstName)>0 || isset($user->lastName) && strlen($user->lastName)>0) @if(isset($user->firstName) && strlen($user->firstName)>0) {{ $user->firstName}} @endif @if(isset($user->lastName) && strlen($user->lastName)>0) {{$user->lastName}} @endif @else
                                - @endif
                        </li>
                        <ul style="    margin: 0px 0px 20px 0px;">
                            <li>کتاب ها:
                                @if(isset($orders))
                                    @foreach($products as $product)
                                        @if($user->orders()->whereIn("id" , $orders->pluck("id")->toArray())->whereHas("orderproducts" , function ($q) use($product){
                                            $q->whereHas("product" , function ($q2) use($product){
                                                $q2->where("id" , $product->id);
                                            });
                                            })->get()->isNotEmpty())
                                            {{$user->orders()->whereIn("id" , $orders->pluck("id")->toArray())->whereHas("orderproducts" , function ($q) use($product){
                                            $q->whereHas("product" , function ($q2) use($product){
                                                $q2->where("id" , $product->id);
                                            });
                                            })->count()}} عدد {{$product->name}} -
                                        @endif
                                    @endforeach
                                @else
                                    <span class="m-badge m-badge--wide label-sm m-badge--warning"> سفارشی یافت نشد </span>
                                @endif
                            </li>
                            @if(isset($hasPishtaz))
                                <li>
                                    @if(in_array(177,$products->pluck("id")->toArray()) || in_array(178,$products->pluck("id")->toArray()))
                                        پست پیشتاز ✅
                                    @else
                                        @if(in_array($user->id , $hasPishtaz ))
                                            پست پیشتاز ✅
                                        @else
                                            پست پیشتاز ❌
                                        @endif
                                    @endif
                                </li>
                            @endif
                            <li>
                                آدرس: @if(isset($user->province[0])) {{ $user->province }} @else استان: - @endif
                                @if(isset($user->city[0])) {{ $user->city }} @else شهر: - @endif
                                @if(isset($user->address[0])) {{ $user->address }} @else آدرس: - @endif

                            </li>
                            <li>
                                کد
                                پستی: @if(isset($user->postalCode) && strlen($user->postalCode)>0) {{ $user->postalCode }} @else
                                    - @endif
                            </li>
                            <li>
                                شماره
                                موبایل:@if(isset($user->mobile) && strlen($user->mobile)>0) {{ ltrim($user->mobile, '0')}} @else
                                    - @endif
                            </li>
                            @if(isset($seePaidCost) && $seePaidCost)
                                <li>
                                    مبلغ دریافت شده:
                                    @if(isset($orders)) {{$user->orders()->whereIn("id" , $orders->pluck("id")->toArray())->whereHas("orderproducts" , function ($q) use($products){
                                            $q->whereHas("product" , function ($q2) use($products){
                                                $q2->whereIn("id" , $products->pluck("id")->toArray());
                                            });
                                        })->get()->sum(function ($order) use($products) {
                                            return $order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->whereHas("product" , function ($q3) use($products){
                                                $q3->whereIn("id" , $products->pluck("id")->toArray());
                                            })->get()->sum(function ($orderproduct){
                                                    $costArray  = $orderproduct->obtainOrderproductCost(false);
                                                    return ((1-($costArray['discountDetail']["bonDiscount"])) * $costArray["base"])+$costArray["extraCost"];
                                            }) ;
                                        })}}
                                    @else
                                        -
                                    @endif
                                </li>
                            @endif
                        </ul>
                        -----------------------------------------
                    @endforeach
                </ul>
            @else
                <h4 class="text-center bold font-red">شما محصولی انتخاب ننموده اید!</h4>
            @endif
        @else
            <h4 class="text-center bold font-red">خریداری یافت نشد</h4>
        @endif
        @endpermission
    @endif
@else
    @permission((Config::get('constants.GET_USER_REPORT')))
    @foreach( $users as $user)
        <tr>
            <th></th>
            <td id="userFullName_{{$user->id}}">{{$user->lastName}}</td>
            <td>{{$user->firstName}}</td>
            <td>@if(isset($user->major->id)) {{ $user->major->name }} @else  @endif</td>
            <td>@if(isset($user->nationalCode) && strlen($user->nationalCode)>0) {{ $user->nationalCode }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
            <td>@if(isset($user->mobile) && strlen($user->mobile)>0) {{ ltrim($user->mobile, '0')}} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
            <td>@if(isset($user->email) && strlen($user->email)>0) {{ $user->email }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
            <td>@if(isset($user->city) && strlen($user->city)>0) {{ $user->city }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span>  @endif</td>
            <td>@if(isset($user->province) && strlen($user->province)>0) {{ $user->province }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
            <td>@if($user->hasVerifiedMobile()) <span class="m-badge m-badge--wide label-sm m-badge--success">احراز هویت کرده</span> @else
                    <span class="m-badge m-badge--wide label-sm m-badge--danger"> نامعتبر </span> @endif</td>
            <td>@if(isset($user->postalCode) && strlen($user->postalCode)>0) {{ $user->postalCode }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
            <td>@if(isset($user->address) && strlen($user->address)>0) {{ $user->address }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
            <td>@if(isset($user->school) && strlen($user->school)>0) {{ $user->school }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--warning"> درج نشده </span> @endif</td>
            <td>
                <span class="m-badge m-badge--wide label-sm @if(strcmp($user->userstatus->name , "active")==0) m-badge--success @elseif(strcmp($user->userstatus->name , "inactive")==0) m-badge--warning @endif"> {{ $user->userstatus->displayName }} </span>
            </td>
            <td>@if(isset($user->created_at) && strlen($user->created_at)>0) {{ $user->CreatedAt_Jalali() }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
            <td>@if(isset($user->updated_at) && strlen($user->updated_at)>0) {{ $user->UpdatedAt_Jalali() }} @else <span
                        class="m-badge m-badge--wide label-sm m-badge--danger"> درج نشده </span> @endif</td>
            <td>{{$user->userHasBon(Config::get("constants.BON1"))}}</td>
            @if(isset($products))
                @foreach($products as $product)
                    <td>
                        @if($user->orders()->whereHas('orderproducts', function($q) use ($product){
                            $q->where("product_id",  $product->id)
                             ->where(function ($q2){
                                        $q2->whereNull("orderproducttype_id")->orWhere("orderproducttype_id" ,"<>", Config::get("constants.ORDER_PRODUCT_GIFT"));
                                    });
                            })->whereIn('orderstatus_id', [Config::get("constants.ORDER_STATUS_CLOSED") , Config::get("constants.ORDER_STATUS_POSTED")])
                            ->whereIn('paymentstatus_id', $paymentStatusesId )->get()->isNotEmpty())
                            {{--✅--}}
                            @foreach($user->orders()->whereHas('orderproducts', function($q) use ($product){
                                $q->Where("product_id", $product->id)
                                         ->where(function ($q2){
                                            $q2->whereNull("orderproducttype_id")->orWhere("orderproducttype_id" ,"<>", Config::get("constants.ORDER_PRODUCT_GIFT"));
                                        });
                                })->whereIn('orderstatus_id', [Config::get("constants.ORDER_STATUS_CLOSED")])
                                ->whereIn('paymentstatus_id', $paymentStatusesId )->get()
                                as $order)
                                {{--<ul>--}}
                                @foreach( $order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->Where("product_id",  $product->id)->get() as $orderproduct)
                                    {{--<li>--}}
                                    @if($orderproduct->attributevalues()->where("id" , 78)->get()->isNotEmpty())
                                        همراه خوابگاه -
                                    @endif
                                    {{--@if($order->paymentstatus->id == Config::get("constants.PAYMENT_STATUS_PAID"))<lable class="font-green">{{$order->paymentstatus->displayName}}</lable>--}}
                                    {{--@else--}}
                                    {{--{{$order->paymentstatus->displayName}}--}}
                                    1
                                    {{--@endif--}}

                                    {{--</li>--}}
                                @endforeach
                                {{--</ul>--}}
                            @endforeach
                            {{--@foreach($user->orders()->whereHas('orderproducts', function($q) use ($product){--}}
                            {{--$q->where("product_id",  $product->id);--}}
                            {{--})->whereIn('orderstatus_id', [Config::get("constants.ORDER_STATUS_CLOSED") , Config::get("constants.ORDER_STATUS_POSTED")])--}}
                            {{--->whereIn('paymentstatus_id', [Config::get("constants.PAYMENT_STATUS_PAID") , Config::get("constants.PAYMENT_STATUS_INDEBTED"), Config::get("constants.PAYMENT_STATUS_UNPAID")] )->get()--}}
                            {{--as $order)--}}
                            {{--{{$order->paymentstatus->displayName}}--}}
                            {{--@endforeach--}}
                            {{--@foreach($user->orders()->whereHas('orderproducts', function($q) use ($product){--}}
                            {{--$q->where("product_id",  $product->id);--}}
                            {{--})->whereIn('orderstatus_id', [Config::get("constants.ORDER_STATUS_CLOSED") , Config::get("constants.ORDER_STATUS_POSTED")])--}}
                            {{--->where('paymentstatus_id', Config::get("constants.PAYMENT_STATUS_PAID") , Config::get("constants.PAYMENT_STATUS_INDEBTED"))->get() as $order)--}}
                            {{--@foreach($order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->where("product_id" , $product->id) as $orderproduct)--}}
                            {{--@if($orderproduct->includedInCoupon)--}}
                            {{--{{ (int)( ((($orderproduct->cost / 88000)*9000)*(1-($orderproduct->getTotalBonNumber()/100))) * (1-($order->couponDiscount/100)) )}}<br>--}}
                            {{--@else--}}
                            {{--{{ (int)( (($orderproduct->cost / 88000)*9000)*(1-($orderproduct->getTotalBonNumber()/100)) )}} <br>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--@endforeach--}}
                        @elseif($user->orders()->whereHas('orderproducts', function($q) use ($product){
                            $q->whereIn("product_id",  \App\Product::whereHas('parents', function($q) use ($product)
                                    {
                                        $q->where("parent_id",  $product->id );
                                    })->pluck("id"))
                                    ->where(function ($q2){
                                        $q2->whereNull("orderproducttype_id")->orWhere("orderproducttype_id" ,"<>", Config::get("constants.ORDER_PRODUCT_GIFT"));
                                    });
                            })->whereIn('orderstatus_id', [Config::get("constants.ORDER_STATUS_CLOSED")])
                            ->whereIn('paymentstatus_id', $paymentStatusesId)->get()->isNotEmpty())
                            {{--@foreach($product->children as $child)--}}
                            {{--@if($user->orders()->whereHas('orderproducts', function($q) use ($child){--}}
                            {{--$q->where("product_id",  $child->id);--}}
                            {{--})->whereIn('orderstatus_id', [Config::get("constants.ORDER_STATUS_CLOSED")])--}}
                            {{--->where('paymentstatus_id', Config::get("constants.PAYMENT_STATUS_PAID"))->get()->isNotEmpty())--}}
                            {{--{{$child->name}} @if($child->attributevalues->where("attribute_id" , 4)->isNotEmpty())دبیر: {{$child->attributevalues->where("attribute_id" , 4)->first()->name}}@endif<br>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            @foreach($user->orders()->whereHas('orderproducts', function($q) use ($product){
                            $q->WhereIn("product_id",  \App\Product::whereHas('parents', function($q) use ($product)
                                    {
                                    $q->where("parent_id",  $product->id );
                                    })->pluck("id"))
                                     ->where(function ($q2){
                                        $q2->whereNull("orderproducttype_id")->orWhere("orderproducttype_id" ,"<>", Config::get("constants.ORDER_PRODUCT_GIFT"));
                                    });
                            })->whereIn('orderstatus_id', [Config::get("constants.ORDER_STATUS_CLOSED")])
                            ->whereIn('paymentstatus_id', $paymentStatusesId)->get()
                            as $order)
                                {{--<ul>--}}
                                @foreach( $order->orderproducts(Config::get("constants.ORDER_PRODUCT_TYPE_DEFAULT"))->WhereIn("product_id",  \App\Product::whereHas('parents', function($q) use ($product)
                                    {
                                    $q->where("parent_id",  $product->id );
                                    })->pluck("id"))->get() as $orderproduct)
                                    {{--<li>--}}
                                    @if($orderproduct->attributevalues()->where("id" , 78)->get()->isNotEmpty())
                                        همراه خوابگاه -
                                    @endif
                                    {{--@if($order->paymentstatus->id == Config::get("constants.PAYMENT_STATUS_PAID"))<lable class="font-green">{{$order->paymentstatus->displayName}}</lable>--}}
                                    {{--@else--}}
                                    {{--{{$order->paymentstatus->displayName}}--}}
                                    {{--@endif--}}
                                    1
                                    {{--</li>--}}
                                @endforeach
                                {{--</ul>--}}
                            @endforeach
                        @else
                            0
                        @endif
                    </td>
                @endforeach
            @endif
            @if(isset($lotteries) && $lotteries->isNotEmpty())
                <td>
                    @if($user->lotteries->where("id" , $lotteries->first()->id)->isNotEmpty())
                        @if( $user->lotteries->where("id" , $lotteries->first()->id)->first()->pivot->rank == 0 )
                            انصراف داده<br>هدیه:
                        @else
                            نفر {{$user->lotteries->where("id" , $lotteries->first()->id)->first()->pivot->rank}}<br>
                            جایزه:
                        @endif
                        @foreach(json_decode($user->lotteries->where("id" , $lotteries->first()->id)->first()->pivot->prizes)->items as $item)
                            {{$item->name}}
                            @if(isset($item->objectType) && strcmp($item->objectType , "App\Coupon") == 0 )
                                <br>
                                @if($user->orders->whereIn("orderstatus_id" , [2,5])->whereIn("paymentstatus_id" , [2,3])->where("coupon_id" , $item->objectId)->isEmpty())
                                    - استفاده نکرده
                                @else
                                    - استفاده کرده
                                @endif
                            @endif
                        @endforeach
                    @else
                        شرکت داده نشده
                    @endif
                </td>
            @endif
        </tr>
    @endforeach
    @endpermission
@endif
