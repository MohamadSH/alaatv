@if(isset($price) && ((isset($price->base)) ? $price->base : $price['base'])>0)
    <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
        @if(((isset($price->final)) ? $price->final : $price['final'])!=((isset($price->base)) ? $price->base : $price['base']))
            <span class="m-badge m-badge--warning a--productRealPrice">
                @if(isset($extraCost))
                    {{ number_format(((isset($price->base)) ? $price->base : $price['base']) + $extraCost) }}
                @else
                    {{ number_format(((isset($price->base)) ? $price->base : $price['base'])) }}
                @endif
            </span>
            <span class="m-badge m-badge--info a--productDiscount">{{ round((1-(((isset($price->final)) ? $price->final : $price['final'])/((isset($price->base)) ? $price->base : $price['base'])))*100) }}%</span>
        @endif
        {{ number_format(((isset($price->final)) ? $price->final : $price['final'])) }} تومان
    </span>
@endif
