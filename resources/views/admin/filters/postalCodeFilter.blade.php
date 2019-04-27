<div class = "row">
    <div class = "col-md-12">
        {!! Form::text('postalCode' , null, ['class' => 'form-control filter', 'id' => 'postalCodeFilter', 'placeholder' => 'کد پستی']) !!}
    </div>
    <div class = "col-md-12">
        <label class = "control-label bold m--font-info" style = "float: right;">
            <label class = "mt-checkbox mt-checkbox-outline">
                <input type = "checkbox" id = "withoutPostalCode" value = "1" name = "withoutPostalCode">
                <span class = "bg-grey-cararra"></span>
            </label>
            بدون کد پستی ها
        </label>
    </div>
</div>
