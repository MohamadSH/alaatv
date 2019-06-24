<div class="m-widget_head-owlcarousel-item carousel noHoverEffect block-product-item"
     data-position="{{ $productKey }}"
     data-gtm-eec-product-id="{{ $product->id }}"
     data-gtm-eec-product-name="{{ $product->name }}"
     data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
     data-gtm-eec-product-brand="آلاء"
     data-gtm-eec-product-category="-"
     data-gtm-eec-product-variant="-"
     data-gtm-eec-product-position="{{ $productKey }}"
     data-gtm-eec-product-list="{{ $block->title }}" >
    
    @if($product->price['final'] !== $product->price['base'])
        <div class="ribbon">
            <span>
                <div class="glow">&nbsp;</div>
                {{ round((1-($product->price['final']/$product->price['base']))*100) }}%
                <span>تخفیف</span>
            </span>
        </div>
    @endif
    
    <a href="{{ $product->url }}"
       class="gtm-eec-product-impression-click"
       data-gtm-eec-product-id="{{ $product->id }}"
       data-gtm-eec-product-name="{{ $product->name }}"
       data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
       data-gtm-eec-product-brand="آلاء"
       data-gtm-eec-product-category="-"
       data-gtm-eec-product-variant="-"
       data-gtm-eec-product-position="{{ $productKey }}"
       data-gtm-eec-product-list="{{ $block->title }}">
        <img class="a--owl-carousel-type-2-item-image owl-lazy lazy-image" data-src="{{ $product->photo }}?w=253&h=142">
    </a>
    <div class="m--font-primary a--owl-carousel-type-2-item-title">
        @include('product.partials.price', ['price'=>$product->price])
    </div>
    <a href="{{ $product->url }}"
       target="_blank"
       class="m-link a--owl-carousel-type-2-item-subtitle gtm-eec-product-impression-click"
       data-gtm-eec-product-id="{{ $product->id }}"
       data-gtm-eec-product-name="{{ $product->name }}"
       data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
       data-gtm-eec-product-brand="آلاء"
       data-gtm-eec-product-category="-"
       data-gtm-eec-product-variant="-"
       data-gtm-eec-product-position="{{ $productKey }}"
       data-gtm-eec-product-list="{{ $block->title }}">
        {{ $product->name }}
    </a>
</div>