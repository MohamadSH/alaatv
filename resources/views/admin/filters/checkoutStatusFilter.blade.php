<div class="col-md-1">
    <label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" id="@if(isset($checkboxId)){{$checkboxId}}@else{{"checkoutStatusEnable"}}@endif"
                   value="1" name="checkoutStatusEnable">
            <span class="bg-grey-cararra"></span>
        </label>
    </label>
</div>

<div class="col-md-10">
    {!! Form::select('checkoutStatus[]', $checkoutStatuses, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default',
                        'id' => (isset($dropdownId))?$dropdownId:'checkoutStatuses' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" ,
                        "data-height" => "200" , "title" => "وضعیت تسویه" , "disabled"]) !!}

</div>