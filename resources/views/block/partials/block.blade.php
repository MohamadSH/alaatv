@if(
    isset($block) && $block !== null &&
    (
        (!isset($blockType)) ||
        isset($blockType)
        &&
        (
            ($blockType === 'productSampleVideo' && !is_null($block->getActiveContent()) && $block->getActiveContent()->count() > 0) ||
            ($blockType === 'productSampleVideo' && optional(optional(optional($block->sets)->first())->getActiveContents2())->count() > 0) ||

            ($blockType === 'content' && !is_null($block->contents) && $block->contents->count() > 0) ||
            ($blockType === 'product' && !is_null($block->products) && $block->products->count() > 0) ||
            ($blockType === 'set' && !is_null($block->sets) && $block->sets->count() > 0)
        )
    )
)
    <div class="row blockWraper a--owl-carousel-row
            @if(isset($blockCustomClass))
                {{ $blockCustomClass }}
            @endif
            blockId-{{ $block->id }}
            {{ $block->class }}
            @if(((isset($blockType) && $blockType === 'product') || !isset($blockType)) && isset($block->products))
                    blockWraper-hasProduct
            @endif "
         @if(isset($blockCustomId))
            id="{{ $blockCustomId }}"
         @else
            id="{{ $block->class }}"
        @endif>
        <div class="col">
            <div class="m-portlet a--owl-carousel-Wraper @if(isset($boxed) && $boxed) boxed @endif" id="owlCarousel_{{ $block->id }}">
                <div class="m-portlet__head a--owl-carousel-head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">

                                @if((isset($squareSing) && $squareSing === true) || !isset($squareSing))
                                    @if(((isset($blockType) && $blockType === 'product') || !isset($blockType)) && isset($block->products))
                                        <span class="redSquare"></span>
                                    @else
                                        <span class="blueSquare"></span>
                                    @endif
                                @endif

                                @if(!isset($blockUrlDisable) || !$blockUrlDisable)
                                    <a href="{{ $block->url }}" class="m-link">
                                        @endif
                                        @if(isset($blockTitle))
                                            {!! $blockTitle !!}
                                        @else
                                            {{ $block->title }}
                                        @endif
                                        @if((isset($blockUrlDisable) && !$blockUrlDisable) || !isset($blockUrlDisable))
                                    </a>
                                @endif
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="#"
                           class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid" title="نمایش شبکه ای">
                            <i class="fa fa-th"></i>
                        </a>
                        <a href="#"
                           class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel" title="نمایش افقی">
                            <i class="fa fa-exchange-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding a--owl-carousel-body">
                    
{{--                    <div class="a--owl-carousel-init-loading">--}}
{{--                        <div class="lds-roller">--}}
{{--                            <div></div>--}}
{{--                            <div></div>--}}
{{--                            <div></div>--}}
{{--                            <div></div>--}}
{{--                            <div></div>--}}
{{--                            <div></div>--}}
{{--                            <div></div>--}}
{{--                            <div></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
    
                    <div class="m-widget_head-owlcarousel-items ScrollCarousel a--owl-carousel-type-2 carousel_block_{{ $block->id }}">
    
        
                        @if(((isset($blockType) && $blockType === 'product' && isset($block->products) && $block->products->count() > 0) || !isset($blockType)) && isset($block->products))
                            @foreach($block->products as $productKey=>$product)
                                @include('block.partials.product')
                            @endforeach
                        {{-- old content block loop --}}
                        @elseif(((isset($blockType) && $blockType === 'content' && isset($block->contents) && $block->contents->count() > 0) || !isset($blockType)) && isset($block->contents))
                            @foreach($block->contents as $contentKey=>$content)
                                @include('block.partials.content')
                            @endforeach
                        @elseif(((isset($blockType) && $blockType === 'set' && isset($block->sets) && $block->sets->count() > 0) || !isset($blockType)) && isset($block->sets))
                            @foreach($block->sets as $setsKey=>$set)
                                @include('block.partials.set')
                            @endforeach
                        @elseif((isset($blockType) && $blockType === 'productSampleVideo') &&
                              (
                              (!is_null($block->getActiveContent()) && $block->getActiveContent()->count() > 0 && !is_null($block->sets->first()))
                              ||
                              (optional(optional(optional($block->sets)->first())->getActiveContents2())->count() > 0)
                              ) )
                            @foreach($block->sets->first()->getActiveContents2() as $contentKey=>$content)
                                @include('block.partials.content')
                            @endforeach
                        @endif
    
                        @if(strlen(trim($block->url))>0 && isset($btnLoadMore) && $btnLoadMore)
                            <div class="item carousel a--block-item a--block-item-showMoreItem w-44333211">
                                <a href="{{ $block->url }}">
                                    <button type="button" class="btn m-btn--air btn-outline-accent m-btn m-btn--custom m-btn--outline-2x">
                                        نمایش بیشتر از
                                        @if(isset($blockTitle))
                                            {{ $blockTitle }}
                                        @else
                                            {{ $block->title }}
                                        @endif
                                    </button>
                                </a>
                            </div>
                        @endif

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endif
