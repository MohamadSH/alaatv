<div class="row">
    <div class="col-md-1">
        <label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">
                <input type="checkbox" id="couponEnable" value="1" name="couponEnable">
                <span class="bg-grey-cararra"></span>
            </label>
        </label>
    </div>

    <div class="col-md-10">
        {{--{!! Form::select('coupons[]', $coupons, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default', 'id' => 'coupons' ,--}}
        {{--"data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" , "data-height" => "200" ,--}}
        {{--"title" => "انتخاب کپن" , "disabled"]) !!}--}}
        <select class="mt-multiselect btn btn-default a--full-width" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"
                id="coupons" name="coupons[]" title="انتخاب کپن" disabled>
            <option value="-1" class="font-blue bold">کپن دار ها</option>
            <option value="0" class="font-red bold">بدون کپن ها</option>
            @foreach($coupons as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>