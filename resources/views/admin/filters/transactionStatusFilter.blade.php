@if(isset($withCheckbox) && $withCheckbox)
<div class="col-md-1">
    <label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" id="transactionStatusEnable" value="1" name="transactionStatusEnable">
            <span class="bg-grey-cararra"></span>
        </label>
    </label>
</div>
@endif
@if(isset($selectType))
    @if($selectType == "dropdown")
        <lable class="col-md-5 control-label">وضعیت تراکنش:</lable>
        <div class="col-md-7">
            {!! Form::select('transactionStatus', $transactionStatuses, null, ['class'=>'form-control']) !!}
        </div>
    @endif
@else
<div class="col-md-10">
    {!! Form::select('transactionStatuses[]', $transactionStatuses, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default',
                        'id' => 'transactionStatuses' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" ,
                        "data-height" => "200" , "title" => "وضعیت تراکنش" , "disabled"]) !!}

</div>
@endif