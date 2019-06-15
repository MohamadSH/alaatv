<div class="m-widget_head-owlcarousel-item carousel noHoverEffect background-gradient" data-position="{{ $productKey }}">
    
    @if($product->price['final']!=$product->price['base'])
        <div class="ribbon">
            <span>
                <div class="glow">&nbsp;</div>
                {{ round((1-($product->price['final']/$product->price['base']))*100) }}%
            </span>
        </div>
    @endif
    
    <a href="{{ $product->url }}" >
        <img class="a--owl-carousel-type-2-item-image" src="{{ $product->photo }}?w=253&h=142">
    </a>
    <div class="m--font-primary a--owl-carousel-type-2-item-title">
        @include('product.partials.price', ['price'=>$product->price])
    </div>
    <a href="{{ $product->url }}" target="_blank" class="m-link a--owl-carousel-type-2-item-subtitle">{{ $product->name }}</a>
</div>