<div class="form-group m-form__group row">
    <label for="input-block-name" class="col-2 col-form-label">عنوان:</label>
    <div class="col-10">
        <input class="form-control m-input" type="text"
               @if(isset($block))
               value="{{ $block->title }}"
               @endif
               id="input-block-name" name="title">
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-customUrl" class="col-2 col-form-label">لینک سفارشی:</label>
    <div class="col-10">
        <input class="form-control m-input" type="text"
               @if(isset($block))
               value="{{ $block->customUrl }}"
               @endif
               id="input-block-customUrl" name="customUrl">
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-class" class="col-2 col-form-label">نام کلاس:</label>
    <div class="col-10">
        <input class="form-control m-input" type="text"
               @if(isset($block))
               value="{{ $block->class }}"
               @endif
               id="input-block-customUrl" name="class">
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-enable" class="col-2 col-form-label">وضعیت:</label>
    <div class="col-10">
        <label class="m-checkbox m-checkbox--state-success">
            <input type="checkbox" value="1" id="input-block-customUrl" name="enable"
                   @if(isset($block) && $block->enable)
                   checked="checked"
                   @endif > فعال
            <span></span>
        </label>
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-order" class="col-2 col-form-label">ترتیب:</label>
    <div class="col-10">
        <input class="form-control m-input" type="number"
               @if(isset($block))
               value="{{ $block->order }}"
               @endif
               id="input-block-customUrl" name="order">
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="input-block-order" class="col-2 col-form-label">نوع:</label>
    <div class="col-10">
        <select id="blockType" name="type">
            @foreach($blockTypes as $blockType)
                <option value="{{ $blockType['value'] }}">{{ $blockType['name'] }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <label class="col-md-2 control-label" for="tags">
        تگ ها :
    </label>
    <div class="col-md-9">
        <input name="tags" type="text" class="form-control input-large blockTags"
               @if(isset($block))
               value="{{implode(',',$block->tags)}}"
               @endif >
    </div>
</div>