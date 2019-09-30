{!! Form::hidden('id',$order->id, ['class' => 'btn red']) !!}
<div class = "form-body">
    <div class = "form-group">
        <div class = "row">
            <label class = "col-md-2 control-label " for = "cost">مبلغ خام سفارش (تومان)</label>
            <div class = "col-md-1">
                <text class = "form-control-static m--font-info">@if(isset($order->cost) || isset($order->costwithoutcoupon)) {{number_format($order->cost + $order->costwithoutcoupon)}} @else
                        یافت نشد @endif</text>
            </div>
            <label class = "col-md-2 control-label " for = "cost"> قابل پرداخت (تومان)</label>
            <div class = "col-md-1">
                <text class = "form-control-static m--font-info">@if(isset($order->cost) || isset($order->costwithoutcoupon)) {{number_format($order->totalCost() )}} @else
                        یافت نشد @endif</text>
            </div>
            <label class = "col-md-2 control-label " for = "cost"> پرداخت شده (تومان)</label>
            <div class = "col-md-1">
                <text class = "form-control-static m--font-info">@if(isset($order->cost) || isset($order->costwithoutcoupon)) {{number_format($order->totalPaidCost() + $order->totalRefund())}} @else
                        یافت نشد @endif</text>
            </div>
            <label class = "col-md-2 control-label" for = "discount">تخفیف کلی (تومان)</label>
            <div class = "col-md-1 {{ $errors->has('discount') ? ' has-danger' : '' }}">
                {!! Form::text('discount', null, ['class' => 'form-control', 'id' => 'discount' , 'dir'=>"ltr"]) !!}
                @if ($errors->has('discount'))
                    <span class="form-control-feedback">
                            <strong>{{ $errors->first('discount') }}</strong>
                        </span>
                @endif
            </div>
        </div>
    </div>
    <div class = "form-group ">
        <div class = "row">
            <label class = "col-md-3 control-label" for = "orderstatus_id">وضعیت سفارش</label>
            <div class = "col-md-2 {{ $errors->has('orderstatus_id') ? ' has-danger' : '' }}">
                {!! Form::select('orderstatus_id',$orderstatuses,null,['class' => 'form-control', 'id' => 'orderstatus_id']) !!}
                @if ($errors->has('orderstatus_id'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('orderstatus_id') }}</strong>
                    </span>
                @endif
                <label class = "mt-checkbox mt-checkbox-outline"> ارسال پیامک
                    <input type = "checkbox" value = "1" name = "orderstatusSMS"/>
                    <span></span>
                </label>
            </div>
            <label class = "col-md-2 control-label" for = "paymentstatus_id">وضعیت پرداخت</label>
            <div class = "col-md-3 {{ $errors->has('paymentstatus_id') ? ' has-danger' : '' }}">
                {!! Form::select('paymentstatus_id',$paymentstatuses,null,['class' => 'form-control', 'id' => 'paymentstatus_id']) !!}
                @if ($errors->has('paymentstatus_id'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('paymentstatus_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class = "form-group ">
        <div class = "row">
            <label class = "col-md-3 control-label" for = "coupon_id">کپن</label>
            <div class = "col-md-2 {{ $errors->has('coupon_id') ? ' has-danger' : '' }}">
                {!! Form::select('coupon_id', $coupons ,null,['class' => 'form-control', 'id' => 'coupon_id']) !!}@if($order->hasCoupon())
                    <label class = "m--font-danger">@if($order->determineCoupontype()["type"] == Config::get("constants.DISCOUNT_TYPE_PERCENTAGE")){{$order->determineCoupontype()["discount"]}}
                        %
                        تخفیف  @elseif($order->determineCoupontype()["type"] == Config::get("constants.DISCOUNT_TYPE_COST")) {{number_format($order->determineCoupontype()["discount"])}}
                        تومان @endif</label>@endif
                @if( count($coupons) == 1 )
                    <span class = "form-control-feedback m--font-danger">
                        <strong>توجه!</strong> کپنی در سایت درج نشده است
                    </span>
                @endif
                @if ($errors->has('coupon_id'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('coupon_id') }}</strong>
                    </span>
                @endif
            </div>
            <label class = "col-md-2 control-label" for = "discount">کد رهگیری مرسوله</label>
            <div class = "col-md-3 {{ $errors->has('postCode') ? ' has-danger' : '' }}">
                {!! Form::text('postCode', null, ['class' => 'form-control', 'id' => 'postCode' , 'dir'=>"ltr"]) !!}
                @if ($errors->has('postCode'))
                    <span class="form-control-feedback">
                            <strong>{{ $errors->first('postCode') }}</strong>
                        </span>
                @endif
                <label class = "mt-checkbox mt-checkbox-outline"> ارسال پیامک
                    <input type = "checkbox" value = "1" name = "postingSMS"/>
                    <span></span>
                </label>
                <h6 class = "bold">کدهای درج شده</h6>
                @forelse($order->orderpostinginfos as $orderpostinginfo)
                    <ul>
                        <li>
                            {{$orderpostinginfo->postCode}}
                        </li>
                    </ul>
                @empty
                    <span class = "bold m--font-danger">کدی درج نشده است</span>
                @endforelse

            </div>
        </div>

    </div>

    <div class = "form-group {{ $errors->has('managerDescription') ? ' has-danger' : '' }}">
        <div class = "row">
            <label class = "col-md-2 control-label" for = "coupon_id">توضیحات مسئول سایت</label>
            <div class = "col-md-10">
                @if($order->ordermanagercomments->isEmpty())
                    {!! Form::textarea('managerDescription', null, ['class' => 'form-control' , 'id' => 'managerDescription', 'placeholder' => 'توضیحات شما در اینجا' , 'rows' => 4]) !!}
                @else
                    {!! Form::textarea('managerDescription', $order->ordermanagercomments->first()->comment, ['class' => 'form-control' , 'id' => 'managerDescription', 'placeholder' => 'توضیحات شما در اینجا' , 'rows' => 4]) !!}
                @endif
                @if ($errors->has('managerDescription'))
                    <span class="form-control-feedback">
                    <strong>{{ $errors->first('managerDescription') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class = "form-group {{ $errors->has('customerDescription') ? ' has-danger' : '' }}">
        <div class = "row">
            <label class = "col-md-2 control-label" for = "coupon_id">توضیحات مشتری</label>
            <div class = "col-md-10">
                {!! Form::textarea('customerDescription', null, ['class' => 'form-control' , 'id' => 'customerDescription', 'placeholder' => 'توضیحات مشتری' , 'rows' => 3]) !!}
                @if ($errors->has('customerDescription'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('customerDescription') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class = "form-group {{ $errors->has('file') ? ' has-danger' : '' }}">
        <div class = "row">
            <label class = "col-md-2 control-label" for = "questionFile">فایل سفارش</label>
            <div class = "col-md-10">
                    @foreach($order->files as $key=>$file)
                        <a target = "_blank" class = "btn blue" href = "{{action("Web\HomeController@download" , ["content"=>"فایل سفارش","fileName"=>$file->file ])}}">دانلود فایل {{$key+1}}</a>
                        <br>
                    @endforeach
                <div class = "fileinput fileinput-new" data-provides = "fileinput">
                    <div class = "input-group input-large ">
                        <div class = "form-control uneditable-input input-fixed input-medium" data-trigger = "fileinput">
                            <i class = "fa fa-file fileinput-exists"></i>&nbsp;
                            <span class = "fileinput-filename"></span>
                        </div>
                        <span class = "input-group-addon btn btn-accent btn-file">
                                                                    <span class = "fileinput-new"> انتخاب فایل </span>
                                                                    <span class = "fileinput-exists"> تغییر </span>
                        {!! Form::file('file' , ['id'=>'file']) !!} </span>
                        <a href = "javascript:" class = "input-group-addon btn btn-danger fileinput-exists" data-dismiss = "fileinput"> حذف</a>
                    </div>
                </div>
                @if ($errors->has('file'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
