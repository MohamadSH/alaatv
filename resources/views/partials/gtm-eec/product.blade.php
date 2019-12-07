data-gtm-eec-product-id="{{ $product->id }}"
data-gtm-eec-product-name="{{ $product->name }}"
data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"
data-gtm-eec-product-brand="آلاء"
@if(strlen(trim($product->category))>0)
    data-gtm-eec-product-category="{{$product->category}}"
@else
    data-gtm-eec-product-category="-"
@endif
data-gtm-eec-product-variant="{{($variant)??'-'}}"
data-gtm-eec-product-quantity="{{($quantity)??'-'}}"
data-gtm-eec-product-position="{{($position)??'-'}}"
data-gtm-eec-product-list="{{($list)??'-'}}"
