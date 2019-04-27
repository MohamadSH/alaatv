@if($items->isNotEmpty())
    @foreach($items as $product)
        <a href = "{{action("Web\ProductController@show" , $product)}}">
            @if(isset($product->image))
                <img src = "{{ route('image', ['category'=>'4','w'=>'300' , 'h'=>'300' ,  'filename' =>  $product->image ]) }}" alt = "عکس محصول">
            @endif
        </a>
    @endforeach
@else
    <p class = "text-center">
        موردی یافت نشد
    </p>
@endif