@if(isset($product->block))
<div class="m-divider m--margin-top-50">
    <span></span>
    <span>بلاک فعلی</span>
    <span></span>
</div>
<div class="row">
    <div class="col-md-6">
        {{ $product->block->title }}
    </div>
    <div class="col-md-6">
        <a href="#">
            <button type="button" class="btn m-btn--pill m-btn--air btn-danger">حذف بلاک</button>
        </a>
        <a href="{{ action('Web\BlockController@edit', $product->block->id) }}" target="_blank">
            <button type="button" class="btn m-btn--pill m-btn--air btn-warning">ویرایش بلاک</button>
        </a>
    </div>
</div>
@else
<div class="m-divider m--margin-top-50">
    <span></span>
    <span>انتخاب بلاک جدید</span>
    <span></span>
</div>
<select class="mt-multiselect btn btn-default a--full-width"
        data-label="left"
        data-width="100%"
        data-filter="true"
        data-height="200"
        id="blockId"
        name="productId"
        title="انتخاب بلاک">
    @foreach($blocks as $block)
    <option value="{{$block->id}}"
            class="bold">
        #{{$block->id}}-{{$block->name}}
    </option>
    @endforeach
</select>
@endif