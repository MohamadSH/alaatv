<div class="row">
    <div class="col-md-12">
        {!! Form::text('school' , null, ['class' => 'form-control filter', 'id' => 'schoolFilter', 'placeholder' => 'مدرسه']) !!}
    </div>
    <div class="col-md-12">
        <label class="control-label bold m--font-info" style="float: right;">
            <label class="mt-checkbox mt-checkbox-outline">
                <input type="checkbox" id="withoutSchool" value="1" name="withoutSchool">
                <span class="bg-grey-cararra"></span>
            </label>
            بدون مدرسه ها
        </label>
    </div>
</div>