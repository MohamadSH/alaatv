<div class="item carousel a--block-item a--block-type-dashboard
@if($product->sets->count() > 1)
background-gradient
@endif">



    <div class="a--block-imageWrapper">
        <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="{{ $product->photo }}" alt="{{ $product->name }}" class="a--block-image lazy-image" width="400" height="400" onclick="moveUpBtns(this)" />
    </div>

    <div class="a--block-infoWrapper">
        <div class="a--block-titleWrapper">
            <span class="m-badge m-badge--danger m-badge--dot"></span>
            {{ $product->name }}
        </div>
        @if($product->sets->count()!==0)
        <div class="a--block-detailesWrapper">

            @if($product->sets->count()===1)
                <div class="m-btn-group m-btn-group--pill btn-group btn-group-sm m--margin-bottom-5"
                     role="group" aria-label="Small button group">
                    @if($product->sets->first()->getActiveContents2(config('constants.CONTENT_TYPE_PAMPHLET'))->isNotEmpty())
                    <button type="button" class="btn btn-warning btnViewPamphlet"
                            data-content-type="pamphlet"
                            data-content-url="{{ $product->sets->first()->contentUrl.'&orderBy=order' }}">
                        <i class="fa fa-edit"></i>
                        جزوات
                    </button>
                    @endif
                    @if($product->sets->first()->getActiveContents2(config('constants.CONTENT_TYPE_VIDEO'))->isNotEmpty())
                    <button type="button" class="btn btn-success btnViewVideo"
                            data-content-type="video"
                            data-content-url="{{ $product->sets->first()->contentUrl.'&orderBy=order' }}">
                        <i class="fa fa-film"></i>
                        فیلم ها
                    </button>
                    @endif
                </div>
            @else
                <a class="btn btn-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill a--owl-carousel-show-detailes m--margin-bottom-5">
                    <i class="fa fa-ellipsis-h"></i>
                </a>
            @endif

        </div>
        @endif
    </div>
</div>
