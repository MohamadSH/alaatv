<div class="row">
    <div class="col-md-12">
        {!! Form::text('email' , null, ['class' => 'form-control filter', 'id' => 'emailFilter', 'placeholder' => 'ایمیل']) !!}
    </div>
    <div class="col-md-12">
        <label class="control-label bold font-blue" style="float: right;">
            <label class="mt-checkbox mt-checkbox-outline">
                <input type="checkbox" id="withoutEmail" value="1" name="withoutEmail">
                <span class="bg-grey-cararra"></span>
            </label>
            بدون ایمیل ها
        </label>
    </div>
</div>