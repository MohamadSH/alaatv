<div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="{{ $productKey }}">
    <a href="{{ $product->url }}" >
        <img class="a--owl-carousel-type-2-item-image" src="{{ $product->photo }}?w=253&h=142">
    </a>
    <div class="m--font-primary a--owl-carousel-type-2-item-title">
        @include('product.partials.price', ['price'=>$product->price])
    </div>
    <a href="{{ $product->url }}" target="_blank" class="m-link a--owl-carousel-type-2-item-subtitle">{{ $product->name }}</a>
</div>