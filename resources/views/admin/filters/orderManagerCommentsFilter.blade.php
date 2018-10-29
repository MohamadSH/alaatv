<div class="col-md-12">
    {!! Form::text('orderManagerComments' , null, ['class' => 'form-control filter', 'id' => 'orderManagerComments', 'placeholder' => 'توضیحات مدیر']) !!}
</div>
<div class="col-md-12">
    <label class="control-label bold font-blue" style="float: right;">
        <label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" id="withoutOrderManagerComments" value="1" name="withoutOrderManagerComments">
            <span class="bg-grey-cararra"></span>
        </label>
        بدون توضیحات مدیر
    </label>
</div>
