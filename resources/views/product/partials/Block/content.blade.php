<div class="m-widget_head-owlcarousel-item carousel" data-position="{{ $contentKey }}">
    <a href="{{ $content->url }}" >
        <img class="a--owl-carousel-type-2-item-image owl-lazy lazy-image main-photo-forLoading" data-src="{{ $content->thumbnail }}">
    </a>
    <div class="a--owl-carousel-type-2-item-title">
        @if($content->price['base']>0)
            <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                @if($content->price['final'] != $content->price['base'])
                    <span class="m-badge m-badge--warning a--productRealPrice">
                        {{ number_format($content->price['base']) }}
                    </span>
                @endif
                {{ number_format($content->price['final']) }} تومان
                @if($content->price['final']!==$content->price['base'])
                    <span class="m-badge m-badge--info a--productDiscount">
                        {{ round((1-($content->price['final']/$content->price['base']))*100) }}%
                    </span>
                @endif
            </span>
        @endif
        <div class="a--content-info">
            <div class="a--content-name">
                <a href="{{ $content->url }}" target="_blank" class="m-link">{{ $content->name }}</a>
            </div>
        </div>
    </div>
</div>