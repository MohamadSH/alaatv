@if(isset($coupon))
    {!! Form::hidden('id',$coupon->id, ['class' => 'btn red']) !!}
    <div class="form-body">
        <div class="note note-warning"><h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر الزامیست: </h4></div>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="name">نام کپن</label>
            <div class="col-md-9">
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('code') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="code">کد کپن</label>
            <div class="col-md-9">
                {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'code' ]) !!}
                @if ($errors->has('code'))
                    <span class="help-block">
                    <strong>{{ $errors->first('code') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <br>
        <div class="note note-info"><h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد: </h4></div>
        <div class="form-group {{ $errors->has('discount') ? ' has-error' : '' }}">
            <div class="col-md-3"></div>
            <div class="col-md-9">
            <label class="control-label" >
                <label class="mt-checkbox mt-checkbox-outline">فعال/غیرفعال
                    {!! Form::checkbox('enable', '1', null, ['class' => '', 'id' => 'enable'  ]) !!}
                    <span class="bg-grey-cararra"></span>
                </label>
            </label>
            </div>
        </div>
        <div class="form-group {{ $errors->has('discount') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="discount">میزان تخفیف (%)</label>
            <div class="col-md-9">
                {!! Form::text('discount', null, ['class' => 'form-control', 'id' => 'discount' , 'dir'=>"ltr" ]) !!}
                @if ($errors->has('discount'))
                    <span class="help-block">
                    <strong>{{ $errors->first('discount') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('maxCost') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="maxCost">حداکثر مبلغ خرید مجاز(تومان)</label>
            <div class="col-md-9">
                {!! Form::text('maxCost', null, ['class' => 'form-control', 'id' => 'maxCost' , 'dir'=>"ltr" ]) !!}
                @if ($errors->has('maxCost'))
                    <span class="help-block">
                    <strong>{{ $errors->first('maxCost') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('usageLimit') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="usageLimit">حداکثر تعداد مجاز برای استفاده از این کپن</label>
            <div class="col-md-9">
                {!! Form::text('usageLimit', null, ['class' => 'form-control', 'id' => 'usageLimit' , 'dir'=>"ltr"]) !!}
                @if ($errors->has('usageLimit'))
                    <span class="help-block">
                    <strong>{{ $errors->first('usageLimit') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('usageLimit') ? ' has-error' : '' }}">
            <div class="clearfix margin-top-20 col-md-9 col-md-offset-3">
                {!! Form::select('limitStatus',$limitStatus, $defaultLimitStatus, ['class' => 'form-control', 'id' => 'limitStatus']) !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('coupontype_id') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="coupontype_id">نوع کپن</label>
            <div class="col-md-9">
                {!! Form::select('coupontype_id',$coupontype, null, ['class' => 'form-control', 'id' => 'coupontypeId']) !!}
            </div>
            @if ($errors->has('coupontype_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('coupontype_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('products') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="products">محصولات مشمول کپن</label>
            <div class="col-md-9">
                {!! Form::select('products[]',$products, $couponProducts,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'coupon_product']) !!}
                @if ($errors->has('products'))
                    <span class="help-block">
                    <strong>{{ $errors->first('products') }}</strong>
                </span>
                @endif
            </div>
            <div class="clearfix margin-top-10">
                <span class="label label-info">توجه</span>
                <strong id="">ستون چپ محصولات شامل تخفیف می باشند</strong>
            </div>
        </div>

        <div class="form-group {{ $errors->has('usageNumber') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="usageNumber">تعداد استفاده ، از این کپن</label>
            <div class="col-md-9">
                {!! Form::text('usageNumber', null, ['class' => 'form-control', 'id' => 'usageNumber' , 'dir'=>"ltr"]) !!}
                @if ($errors->has('usageNumber'))
                    <span class="help-block">
                    <strong>{{ $errors->first('usageNumber') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="description">توضیح کپن</label>
            <div class="col-md-9">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description' ]) !!}
                @if ($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('validSince') ? ' has-error' : '' }}">
            <label class="control-label" >
                <label class="mt-checkbox mt-checkbox-outline">تاریخ شروع معتبر بودن کپن
                    <input type="checkbox" name="validSinceEnable" class="" id="couponValidSinceEnable" @if(isset($validSinceDate)) checked @endif>
                    <span class="bg-grey-cararra"></span>
                </label>
            </label>
            <div class="col-md-9">
                <input id="couponValidSince" type="text" class="form-control" value="@if(isset($validSinceDate)) {{$validSinceDate}} @endif"  dir="ltr" @if(!isset($validSinceDate)) disabled="disabled" @endif>
                <input name="validSince" id="couponValidSinceAlt" type="text" class="form-control hidden">

                <input class="form-control" name="sinceTime" id="couponValidSinceTime" placeholder="00:00" value="@if(isset($validSinceTime)) {{$validSinceTime}} @endif" dir="ltr" @if(!isset($validSinceDate)) disabled="disabled" @endif>

                @if ($errors->has('validSince'))
                    <span class="help-block">
                    <strong>{{ $errors->first('validSince') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('validUntil') ? ' has-error' : '' }}">
            <label class="control-label" >
                <label class="mt-checkbox mt-checkbox-outline">تاریخ شروع معتبر بودن کپن
                    <input type="checkbox" name="validUntilEnable" class="" id="couponValidUntilEnable" @if(isset($validUntilDate)) checked @endif>
                    <span class="bg-grey-cararra"></span>
                </label>
            </label>
            <div class="col-md-9">
                <input id="couponValidUntil" type="text" class="form-control" value="@if(isset($validUntilDate)) {{$validUntilDate}} @endif" dir="ltr" @if(!isset($validUntilDate)) disabled="disabled" @endif>
                <input name="validUntil" id="couponValidUntilAlt" type="text" class="form-control hidden">

                <input class="form-control" name="untilTime" id="couponValidUntilTime" placeholder="00:00" value="@if(isset($validUntilTime)) {{$validUntilTime}} @endif" dir="ltr" @if(!isset($validUntilDate)) disabled="disabled" @endif>

                @if ($errors->has('validUntil'))
                    <span class="help-block">
                    <strong>{{ $errors->first('validUntil') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn blue-ebonyclay']) !!}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-12">
        <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر الزامی می باشد: </p>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <p>
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'couponName' , 'placeholder'=>'نام کپن']) !!}
            <span class="help-block" id="couponNameAlert">
                    <strong></strong>
            </span>
        </p>

        <p>
            {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'couponCode'  , 'placeholder'=>'کد کپن']) !!}
            <span class="help-block" id="couponCodeAlert">
                    <strong></strong>
            </span>
        </p>

    </div>
    <div class="col-md-12">
        <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد: </p>
    </div>

    <div class="col-md-8 col-md-offset-2">
        <p>
            <label class="control-label" >
                <label class="mt-checkbox mt-checkbox-outline">فعال/غیرفعال
                    {!! Form::checkbox('enable', '1', null, ['class' => '', 'id' => 'enable' , 'checked' ]) !!}
                    <span class="bg-grey-cararra"></span>
                </label>
            </label>
        </p>
        <p>
            {!! Form::text('discount', null, ['class' => 'form-control', 'id' => 'couponDiscount'  , 'placeholder'=>'میزان تخفیف کپن (%)']) !!}
            <span class="help-block" id="couponDiscountAlert">
                    <strong></strong>
            </span>
        </p>

        <p>
            {!! Form::text('maxCost', null, ['class' => 'form-control', 'id' => 'maxCost' , 'placeholder'=>'حداکثر مبلغ مجاز خرید']) !!}
            <span class="help-block" id="maxCost">
                    <strong></strong>
            </span>
        </p>

        <p>
            {!! Form::text('usageLimit', null, ['class' => 'form-control', 'id' => 'couponUsageLimit'  , 'placeholder'=>'حداکثر تعداد مجاز برای استفاده از این کپن']) !!}
            <span class="help-block" id="couponUsageLimitAlert">
                    <strong></strong>
            </span>
            <div class="clearfix margin-top-10">
                {!! Form::select('limitStatus',$limitStatus, null, ['class' => 'form-control', 'id' => 'limitStatus']) !!}
            </div>
        </p>
        <br>
        <p>
            <div class="clearfix margin-bottom-10" >
                <span class="label label-success">توجه</span>
                <strong id="">محصولاتی که مشمول کپن می شوند</strong>
            </div>
                {!! Form::select('coupontype_id',$coupontype, null, ['class' => 'form-control', 'id' => 'coupontypeId']) !!}
            <span class="help-block" id="coupontypeIdAlert">
                    <strong></strong>
            </span>
        </p>
        <p>
            {!! Form::select('products[]',$products, null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'coupon_product']) !!}
            <span class="help-block" id="couponProductAlert">
                    <strong></strong>
            </span>
            <div class="clearfix margin-top-10">
                <span class="label label-info">توجه</span>
                <strong id="">ستون چپ محصولات شامل تخفیف می باشند</strong>
            </div>
        </p>
        <p>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'couponDescription'  , 'placeholder'=>'توضیح درباره کپن']) !!}
            <span class="help-block" id="couponDescriptionAlert">
                    <strong></strong>
            </span>
        </p>
        <div class="col-md-6">
            <label class="control-label" >
                <label class="mt-checkbox mt-checkbox-outline">تاریخ شروع معتبر بودن کپن
                    {!! Form::checkbox('validSinceEnable', '1', null, ['class' => '', 'id' => 'couponValidSinceEnable'  ]) !!}
                    <span class="bg-grey-cararra"></span>
                </label>
            </label>
            <div class="col-md-12">
                <input id="couponValidSince" type="text" class="form-control"  dir="ltr" disabled="disabled">
                <input name="validSince" id="couponValidSinceAlt" type="text" class="form-control hidden">
                <input class="form-control" name="sinceTime" id="couponValidSinceTime" placeholder="00:00" dir="ltr" disabled="disabled">
                <span class="help-block" id="couponValidSinceAltAlert">
                        <strong></strong>
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <label class="control-label" >
                <label class="mt-checkbox mt-checkbox-outline">تاریخ پایان معتبر بودن کپن
                    {!! Form::checkbox('validUntilEnable', '1', null, ['class' => '', 'id' => 'couponValidUntilEnable'  ]) !!}
                    <span class="bg-grey-cararra"></span>
                </label>
            </label>
            <div class="col-md-12">
                <input id="couponValidUntil" type="text" class="form-control"  dir="ltr" disabled="disabled">
                <input name="validUntil" id="couponValidUntilAlt" type="text" class="form-control hidden">
                <input class="form-control" name="untilTime" id="couponValidUntilTime" placeholder="00:00" dir="ltr" disabled="disabled">
                <span class="help-block" id="couponValidUntilAltAlert">
                        <strong></strong>
                </span>
            </div>
        </div>
    </div>
@endif