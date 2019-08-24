<div class="item carousel a--block-item a--block-type-product"
     data-gtm-eec-product-id="{{ $product->id }}"
     data-gtm-eec-product-name="{{ $product->name }}"
     data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
     data-gtm-eec-product-brand="آلاء"
     data-gtm-eec-product-category="-"
     data-gtm-eec-product-variant="-"
     data-gtm-eec-product-position="{{ $productKey }}"
     data-gtm-eec-product-list="{{ $block->title }}">
    
    @if($product->price['final'] !== $product->price['base'])
        <div class="ribbon">
            <span>
                <div class="glow">&nbsp;</div>
                {{ round((1-($product->price['final']/$product->price['base']))*100) }}%
                <span>تخفیف</span>
            </span>
        </div>
    @endif
    
    
    
    <div class="a--block-imageWrapper">
        <a href="{{ $product->url }}"
           class="a--block-imageWrapper-image a--gtm-eec-product a--gtm-eec-product-click d-block"
           data-gtm-eec-product-id="{{ $product->id }}"
           data-gtm-eec-product-name="{{ $product->name }}"
           data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
           data-gtm-eec-product-brand="آلاء"
           data-gtm-eec-product-category="-"
           data-gtm-eec-product-variant="-"
           data-gtm-eec-product-position="{{ $productKey }}"
           data-gtm-eec-product-list="{{ $block->title }}">
            <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{ $product->photo }}" alt="{{ $product->name }}" class="a--block-image lazy-image" width="400" height="400" />
        </a>
    </div>
    <div class="a--block-infoWrapper">
        <div class="a--block-titleWrapper">
            <a href="{{ $product->url }}"
               class="m-link a--owl-carousel-type-2-item-subtitle a--gtm-eec-product-click"
               data-gtm-eec-product-id="{{ $product->id }}"
               data-gtm-eec-product-name="{{ $product->name }}"
               data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
               data-gtm-eec-product-brand="آلاء"
               data-gtm-eec-product-category="-"
               data-gtm-eec-product-variant="-"
               data-gtm-eec-product-position="{{ $productKey }}"
               data-gtm-eec-product-list="{{ $block->title }}">
                <span class="m-badge m-badge--danger m-badge--dot"></span>
                {{ $product->name }}
            </a>
        </div>
        <div class="a--block-detailesWrapper">
            @include('product.partials.price', ['price'=>$product->price])
        </div>
    </div>
</div>