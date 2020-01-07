@if(isset($coupon))
    {!! Form::hidden('id',$coupon->id, ['class' => 'btn red']) !!}
    <div class = "form-body">
        <div class = "note note-warning">
            <h4 class = "caption-subject font-dark bold uppercase">
                وارد کردن اطلاعات زیر الزامیست:
            </h4>
        </div>
        <div class = "form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "name">نام کپن</label>
                <div class = "col-md-9">
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                    @if ($errors->has('name'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('code') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "code">کد کپن</label>
                <div class = "col-md-9">
                    {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'code' ]) !!}
                    @if ($errors->has('code'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('code') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <br>
        <div class = "note note-info">
            <h4 class = "caption-subject font-dark bold uppercase">
                وارد کردن اطلاعات زیر اختیاری می باشد:
            </h4>
        </div>
        <div class = "form-group {{ $errors->has('discount') ? ' has-danger' : '' }}">
            <div class = "row">
                <div class = "col-md-3"></div>
                <div class = "col-md-9">
                    <label class = "control-label">
                        <label class = "mt-checkbox mt-checkbox-outline">فعال/غیرفعال
                            {!! Form::checkbox('enable', '1', null, ['class' => '', 'id' => 'enable'  ]) !!}
                            <span class = "bg-grey-cararra"></span>
                        </label>
                    </label>
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('discount') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "discount">میزان تخفیف (%)</label>
                <div class = "col-md-9">
                    {!! Form::text('discount', null, ['class' => 'form-control', 'id' => 'discount' , 'dir'=>"ltr" ]) !!}
                    @if ($errors->has('discount'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('discount') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{--<div class="form-group {{ $errors->has('maxCost') ? ' has-danger' : '' }}">--}}
        {{--<label class="col-md-3 control-label" for="maxCost">حداکثر مبلغ خرید مجاز(تومان)</label>--}}
        {{--<div class="col-md-9">--}}
        {{--{!! Form::text('maxCost', null, ['class' => 'form-control', 'id' => 'maxCost' , 'dir'=>"ltr" ]) !!}--}}
        {{--@if ($errors->has('maxCost'))--}}
        {{--<span class="form-control-feedback">--}}
        {{--<strong>{{ $errors->first('maxCost') }}</strong>--}}
        {{--</span>--}}
        {{--@endif--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class = "form-group {{ $errors->has('usageLimit') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "usageLimit">حداکثر تعداد مجاز برای استفاده از این کپن</label>
                <div class = "col-md-9">
                    {!! Form::text('usageLimit', null, ['class' => 'form-control', 'id' => 'usageLimit' , 'dir'=>"ltr"]) !!}
                    @if ($errors->has('usageLimit'))
                        <span class="form-control-feedback">
                    <strong>{{ $errors->first('usageLimit') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('usageLimit') ? ' has-danger' : '' }}">
            <div class = "row">
                <div class = "clearfix margin-top-20 col-md-9 col-md-offset-3">
                    {!! Form::select('limitStatus',$limitStatus, $defaultLimitStatus, ['class' => 'form-control', 'id' => 'limitStatus']) !!}
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('coupontype_id') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "coupontype_id">نوع کپن</label>
                <div class = "col-md-9">
                    {!! Form::select('coupontype_id',$coupontype, null, ['class' => 'form-control', 'id' => 'coupontypeId']) !!}
                </div>
                @if ($errors->has('coupontype_id'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('coupontype_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class = "form-group {{ $errors->has('products') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "products">محصولات مشمول کپن</label>
                <div class = "col-md-9">
                    {!! Form::select('products[]',$products, $couponProducts,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'coupon_product']) !!}
                    @if ($errors->has('products'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('products') }}</strong>
                    </span>
                    @endif
                </div>
                <div class = "clearfix margin-top-10">
                    <span class = "m-badge m-badge--wide m-badge--info">توجه</span>
                    <strong id = "">ستون چپ محصولات شامل تخفیف می باشند</strong>
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('usageNumber') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "usageNumber">تعداد استفاده ، از این کپن</label>
                <div class = "col-md-9">
                    {!! Form::text('usageNumber', null, ['class' => 'form-control', 'id' => 'usageNumber' , 'dir'=>"ltr"]) !!}
                    @if ($errors->has('usageNumber'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('usageNumber') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "description">توضیح کپن</label>
                <div class = "col-md-9">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description' ]) !!}
                    @if ($errors->has('description'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('validSince') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "control-label">
                    <label class = "mt-checkbox mt-checkbox-outline">تاریخ شروع معتبر بودن کپن
                        <input type = "checkbox" name = "validSinceEnable" class = "" id = "couponValidSinceEnable" @if(isset($validSinceDate)) checked @endif>
                        <span class = "bg-grey-cararra"></span>
                    </label>
                </label>
                <div class = "col-md-9">
                    <input id = "couponValidSince" type = "text" class = "form-control" value = "" dir = "ltr" @if(!isset($validSinceDate)) disabled = "disabled" @endif>
                    <input name = "validSince" id = "couponValidSinceAlt" type = "text" class = "form-control d-none">

                    <input class = "form-control" name = "sinceTime" id = "couponValidSinceTime" placeholder = "00:00" value = "@if(isset($validSinceTime)){{$validSinceTime}}@endif" dir = "ltr" @if(!isset($validSinceDate)) disabled = "disabled" @endif>

                    @if ($errors->has('validSince'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('validSince') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('validUntil') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "control-label">
                    <label class = "mt-checkbox mt-checkbox-outline">تاریخ شروع معتبر بودن کپن
                        <input type = "checkbox" name = "validUntilEnable" class = "" id = "couponValidUntilEnable" @if(isset($validUntilDate)) checked @endif>
                        <span class = "bg-grey-cararra"></span>
                    </label>
                </label>
                <div class = "col-md-9">
                    <input id = "couponValidUntil" type = "text" class = "form-control" dir = "ltr" @if(!isset($validUntilDate)) disabled = "disabled" @endif>
                    <input name = "validUntil" id = "couponValidUntilAlt" type = "text" class = "form-control d-none">

                    <input class = "form-control" name = "untilTime" id = "couponValidUntilTime" placeholder = "00:00" value = "@if(isset($validUntilTime)){{$validUntilTime}}@endif" dir = "ltr" @if(!isset($validUntilDate)) disabled = "disabled" @endif>

                    @if ($errors->has('validUntil'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('validUntil') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class = "form-actions">
            <div class = "row">
                <div class = "col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn btn-lg m-btn--air btn-warning']) !!}
                </div>
            </div>
        </div>
    </div>
@else
    {!! Form::hidden('discounttype_id',1) !!}
    <div class = "col-md-12">
        <p class = "caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر الزامی می باشد:</p>
    </div>
    <div class = "col-md-8 col-md-offset-2">
        <p>
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'couponName' , 'placeholder'=>'نام کپن']) !!}
            <span class="form-control-feedback" id = "couponNameAlert">
                <strong></strong>
            </span>
        </p>
        <p>
            {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'couponCode'  , 'placeholder'=>'کد کپن']) !!}
            <span class="form-control-feedback" id = "couponCodeAlert">
                <strong></strong>
            </span>
        </p>
    </div>
    <div class = "col-md-12">
        <p class = "caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد:</p>
    </div>
    <div class = "col-md-8 col-md-offset-2">
        <p>
            <label class = "control-label">
                <label class = "mt-checkbox mt-checkbox-outline">فعال/غیرفعال
                    {!! Form::checkbox('enable', '1', null, ['class' => '', 'id' => 'enable' , 'checked' ]) !!}
                    <span class = "bg-grey-cararra"></span>
                </label>
            </label>
        </p>
        <p>
            {!! Form::text('discount', null, ['class' => 'form-control', 'id' => 'couponDiscount'  , 'placeholder'=>'میزان تخفیف کپن (%)']) !!}
            <span class="form-control-feedback" id = "couponDiscountAlert">
                <strong></strong>
            </span>
        </p>

        {{--<p>--}}
        {{--{!! Form::text('maxCost', null, ['class' => 'form-control', 'id' => 'maxCost' , 'placeholder'=>'حداکثر مبلغ مجاز خرید']) !!}--}}
        {{--<span class="form-control-feedback" id="maxCost">--}}
        {{--<strong></strong>--}}
        {{--</span>--}}
        {{--</p>--}}

        <div>
            {!! Form::text('usageLimit', null, ['class' => 'form-control', 'id' => 'couponUsageLimit'  , 'placeholder'=>'حداکثر تعداد مجاز برای استفاده از این کپن']) !!}
            <span class="form-control-feedback" id = "couponUsageLimitAlert">
                <strong></strong>
            </span>
            <div class = "clearfix margin-top-10">
                {!! Form::select('limitStatus',$limitStatus, null, ['class' => 'form-control', 'id' => 'limitStatus']) !!}
            </div>
        </div>
        <br>
        <div>
            <div class = "clearfix margin-bottom-10">
                <span class = "m-badge m-badge--wide m-badge--success">توجه</span>
                <strong id = "">محصولاتی که مشمول کپن می شوند</strong>
            </div>
            {!! Form::select('coupontype_id',$coupontype, null, ['class' => 'form-control', 'id' => 'coupontypeId']) !!}
            <span class="form-control-feedback" id = "coupontypeIdAlert">
                <strong></strong>
            </span>
        </div>
        <div>
            {!! Form::select('products[]',$products, null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'coupon_product']) !!}
            <span class="form-control-feedback" id = "couponProductAlert">
                <strong></strong>
            </span>
            <div class = "clearfix margin-top-10">
                <span class = "m-badge m-badge--wide m-badge--info">توجه</span>
                <strong id = "">ستون چپ محصولات شامل تخفیف می باشند</strong>
            </div>
        </div>
        <div>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'couponDescription'  , 'placeholder'=>'توضیح درباره کپن']) !!}
            <span class="form-control-feedback" id = "couponDescriptionAlert">
                <strong></strong>
            </span>
        </div>
        <div class = "col-md-6">
            <label class = "control-label">
                <label class = "mt-checkbox mt-checkbox-outline">تاریخ شروع معتبر بودن کپن
                    {!! Form::checkbox('validSinceEnable', '1', null, ['class' => '', 'id' => 'couponValidSinceEnable'  ]) !!}
                    <span class = "bg-grey-cararra"></span>
                </label>
            </label>
            <div class = "col-md-12">
                <input id = "couponValidSince" type = "text" class = "form-control" dir = "ltr" disabled = "disabled">
                <input name = "validSince" id = "couponValidSinceAlt" type = "text" class = "form-control d-none">
                <input class = "form-control" name = "sinceTime" id = "couponValidSinceTime" placeholder = "00:00" dir = "ltr" disabled = "disabled">

            </div>
        </div>
        <div class = "col-md-6">
            <label class = "control-label">
                <label class = "mt-checkbox mt-checkbox-outline">تاریخ پایان معتبر بودن کپن
                    {!! Form::checkbox('validUntilEnable', '1', null, ['class' => '', 'id' => 'couponValidUntilEnable'  ]) !!}
                    <span class = "bg-grey-cararra"></span>
                </label>
            </label>
            <div class = "col-md-12">
                <input id = "couponValidUntil" type = "text" class = "form-control" dir = "ltr" disabled = "disabled">
                <input name = "validUntil" id = "couponValidUntilAlt" type = "text" class = "form-control d-none">
                <input class = "form-control" name = "untilTime" id = "couponValidUntilTime" placeholder = "00:00" dir = "ltr" disabled = "disabled">
            </div>
        </div>
    </div>
@endif
