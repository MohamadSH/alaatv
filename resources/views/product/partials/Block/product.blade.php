<div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="{{ $productKey }}">
    <a href="{{ $product->url }}" >
        <img class="a--owl-carousel-type-2-item-image" src="{{ $product->photo }}?w=253&h=142">
    </a>
    <div class="m--font-primary a--owl-carousel-type-2-item-title">
        <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
            @if($product->price['final']!=$product->price['base'])
                <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($product->price['base']) }}</span>
            @endif
            {{ number_format($product->price['final']) }} تومان
            @if($product->price['final']!==$product->price['base'])
                <span class="m-badge m-badge--info a--productDiscount">{{ round((1-($product->price['final']/$product->price['base']))*100) }}%</span>
            @endif
        </span>
    </div>
    <a href="{{ $product->url }}" target="_blank" class="m-link a--owl-carousel-type-2-item-subtitle">{{ $product->name }}</a>
</div>