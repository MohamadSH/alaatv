<div class="row">
    <div class="col-md-12">
        {!! Form::text('city' , null, ['class' => 'form-control filter', 'id' => 'cityFilter', 'placeholder' => 'شهر']) !!}
    </div>
    <div class="col-md-12">
        <label class="control-label bold m--font-info" style="float: right;">
            <label class="mt-checkbox mt-checkbox-outline">
                <input type="checkbox" id="withoutCity" value="1" name="withoutCity">
                <span class="bg-grey-cararra"></span>
            </label>
            بدون شهر ها
        </label>
    </div>
</div>