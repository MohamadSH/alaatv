@if(((isset($product->price->final)) ? $product->price->final : $product->price['final']) !== ((isset($product->price->base)) ? $product->price->base : $product->price['base']))
    <div class="ribbon">
        <span>
            <div class="glow">&nbsp;</div>
            {{ round((1-(((isset($product->price->final)) ? $product->price->final : $product->price['final'])/((isset($product->price->base)) ? $product->price->base : $product->price['base'])))*100) }}%
            <span>تخفیف</span>
        </span>
    </div>
@endif
