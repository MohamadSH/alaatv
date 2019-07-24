@if(isset($price) && $price['base']>0)
    <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
        @if($price['final']!=$price['base'])
            <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($price['base']) }}</span>
            <span class="m-badge m-badge--info a--productDiscount">{{ round((1-($price['final']/$price['base']))*100) }}%</span>
        @endif
        {{ number_format($price['final']) }} تومان
    </span>
@endif
