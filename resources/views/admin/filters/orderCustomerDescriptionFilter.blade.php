<div class="col-md-12">
    {!! Form::text('orderCustomerDescription' , null, ['class' => 'form-control filter', 'id' => 'orderCustomerDescriptionFilter', 'placeholder' => 'توضیحات مشتری']) !!}
</div>
<div class="col-md-12">
    <label class="control-label bold m--font-info" style="float: right;">
        <label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" id="withoutOrderCustomerDescription" value="1" name="withoutOrderCustomerDescription">
            <span class="bg-grey-cararra"></span>
        </label>
        بدون توضح مشتری
    </label>
</div>
