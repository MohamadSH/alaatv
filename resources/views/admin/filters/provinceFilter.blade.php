<div class="col-md-12">
    {!! Form::text('province' , null, ['class' => 'form-control filter', 'id' => 'provinceFilter', 'placeholder' => 'استان']) !!}
</div>
<div class="col-md-12">
    <label class="control-label bold font-blue" style="float: right;">
        <label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" id="withoutProvince" value="1" name="withoutProvince">
            <span class="bg-grey-cararra"></span>
        </label>
        بدون استان ها
    </label>
</div>

