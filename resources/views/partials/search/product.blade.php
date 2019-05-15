@if($items->isNotEmpty())
    @foreach($items as $product)
        <a href = "{{action("Web\ProductController@show" , $product)}}">
            @if(isset($product->image))
                <img src = "{{ $product->photo }}" alt = "عکس محصول">
            @endif
        </a>
    @endforeach
@else
    <p class = "text-center">
        موردی یافت نشد
    </p>
@endif
