<div class="item carousel a--block-item a--block-type-content" data-position="{{ $contentKey }}">
    <div class="a--block-imageWrapper">
        <a href="{{ $content->url }}" class="btn btn-sm m-btn--pill btn-brand btnViewMore">
            <i class="fa fa-play"></i> / <i class="fa fa-cloud-download-alt"></i>
        </a>
        <a href="{{ $content->url }}" class="a--block-imageWrapper-image">
            <img class="a--block-image owl-lazy lazy-image"
                @if(isset($imageDimension))
                data-src="{{ $content->thumbnail }}{{ $imageDimension }}"
                @else
                data-src="{{ $content->thumbnail }}"
                @endif
                alt="{{ $content->name }}"
                width="253" height="142" />
        </a>
    </div>
    <div class="a--block-infoWrapper">
        <div class="a--block-titleWrapper">
            <a href="{{ $content->url }}" class="m-link">
                <h6>
                    <span class="m-badge m-badge--info m-badge--dot"></span>
                    {{ $content->name }}
                </h6>
            </a>
        </div>
        <div class="a--block-detailesWrapper">
            
            <div class="a--block-set-author-pic">
                <img class="m-widget19__img owl-lazy lazy-image" data-src="{{ $content->author->photo }}" alt="{{ $content->author->full_name }}">
            </div>
            <div class="a--block-set-author-name">
                <span class="a--block-set-author-name-title">{{ $content->author->full_name }}</span>
                <br>
                <span class="a--block-set-author-name-alaa">موسسه غیرتجاری آلاء</span>
            </div>
        
        </div>
    </div>
</div>


{{--<div class="m-widget_head-owlcarousel-item carousel" data-position="{{ $contentKey }}">--}}
{{--    <a href="{{ $content->url }}" >--}}
{{--        <img class="a--owl-carousel-type-2-item-image owl-lazy lazy-image main-photo-forLoading"--}}
{{--             @if(isset($imageDimension))--}}
{{--             data-src="{{ $content->thumbnail }}{{ $imageDimension }}"--}}
{{--             @else--}}
{{--             data-src="{{ $content->thumbnail }}"--}}
{{--             @endif >--}}
{{--    </a>--}}
{{--    <div class="a--owl-carousel-type-2-item-title">--}}
{{--        @if($content->price['base']>0)--}}
{{--            <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">--}}
{{--                @if($content->price['final'] != $content->price['base'])--}}
{{--                    <span class="m-badge m-badge--warning a--productRealPrice">--}}
{{--                        {{ number_format($content->price['base']) }}--}}
{{--                    </span>--}}
{{--                @endif--}}
{{--                {{ number_format($content->price['final']) }} تومان--}}
{{--                @if($content->price['final']!==$content->price['base'])--}}
{{--                    <span class="m-badge m-badge--info a--productDiscount">--}}
{{--                        {{ round((1-($content->price['final']/$content->price['base']))*100) }}%--}}
{{--                    </span>--}}
{{--                @endif--}}
{{--            </span>--}}
{{--        @endif--}}
{{--        <div class="a--content-info">--}}
{{--            <div class="a--content-name">--}}
{{--                <a href="{{ $content->url }}" target="_blank" class="m-link">{{ $content->name }}</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}