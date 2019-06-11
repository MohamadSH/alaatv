<div class="form-group m-form__group row">
    <label for="input-block-name" class="col-2 col-form-label">عنوان:</label>
    <div class="col-10">
        <input class="form-control m-input" type="text" value="{{ $block->title }}" id="input-block-name" name="title">
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-customUrl" class="col-2 col-form-label">لینک سفارشی:</label>
    <div class="col-10">
        <input class="form-control m-input" type="text" value="{{ $block->customUrl }}" id="input-block-customUrl" name="customUrl">
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-class" class="col-2 col-form-label">نام کلاس:</label>
    <div class="col-10">
        <input class="form-control m-input" type="text" value="{{ $block->class }}" id="input-block-customUrl" name="class">
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-enable" class="col-2 col-form-label">وضعیت:</label>
    <div class="col-10">
        <label class="m-checkbox m-checkbox--state-success">
            <input type="checkbox" value="{{ $block->enable }}" id="input-block-customUrl" name="enable"> فعال
            <span></span>
        </label>
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-order" class="col-2 col-form-label">ترتیب:</label>
    <div class="col-10">
        <input class="form-control m-input" type="number" value="{{ $block->order }}" id="input-block-customUrl" name="order">
    </div>
</div>

<div class="row">
    <label class="col-md-2 control-label" for="tags">
        تگ ها :
    </label>
    <div class="col-md-9">
        <input name="tags" type="text" class="form-control input-large productTags" value="{{implode(',',$block->tags)}}">
    </div>
</div>