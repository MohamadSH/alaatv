@if(( !isset($blocks) || $blocks->isEmpty() ) && isset($allBlocks))
    {!! Form::open(['method'=>'POST' , 'url'=>route('web.product.attach.block', $product->id)]) !!}
    <div class="m-divider m--margin-top-50">
        <span></span>
        <span>انتخاب بلاک</span>
        <span></span>
    </div>
    <select class="btn btn-default a--full-width"
            data-label="left"
            data-width="100%"
            data-filter="true"
            data-height="200"
            id="blockId"
            name="block_id"
            title="انتخاب بلاک">
        @foreach($allBlocks as $key => $block)
        <option value="{{$key}}"
                class="bold">
            #{{$key}}-{{$block}}
        </option>
        @endforeach
    </select>

    <button type="submit" class="btn m-btn--pill m-btn--air btn-info">افزودن بلاک</button>
    {!! Form::close() !!}
@else
@foreach($blocks as $block)
<div class="row">
    <div class="col-md-4">
        {{ $block->title }}
    </div>
    <div class="col-md-2">
        {!! Form::open(['method'=>'DELETE' , 'url'=>route('web.product.detach.block', $product->id)]) !!}
            {!! Form::input('hidden', 'block_id' , $block->id ) !!}
            <button type="submit" class="btn m-btn--pill m-btn--air btn-danger">حذف بلاک</button>
        {!! Form::close() !!}
    </div>
    <div class="col-md-2">
        <a href="{{ route('block.edit', $block->id) }}" target="_blank" class="btn m-btn--pill m-btn--air btn-warning">
            ویرایش بلاک
        </a>
    </div>
</div>
@endforeach
@endif
