@if(
    isset($block) && $block !== null &&
    (
        (!isset($blockType)) ||
        isset($blockType) &&
        (
            ($blockType === 'content' && !is_null($block->getActiveContent()) && $block->getActiveContent()->count() > 0) ||
            ($blockType === 'content' && optional(optional(optional($block->sets)->first())->getActiveContents2())->count() > 0) ||
            ($blockType === 'product' && !is_null($block->getActiveProducts()) && $block->getActiveProducts()->count() > 0) ||
            ($blockType === 'set' && !is_null($block->getActiveSets()) && $block->getActiveSets()->count() > 0)
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
                    scrollSensitiveOnScreen
            @endif "
         @if(isset($blockCustomId))
            id="{{ $blockCustomId }}"
         @else
            id="{{ $block->class }}"
        @endif>
        <div class="col">
            <div class="m-portlet a--owl-carousel-Wraper OwlCarouselType2-shopPage" id="owlCarousel_{{ $block->id }}">
                <div class="m-portlet__head">
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
                           class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid">
                            <i class="fa flaticon-shapes"></i>
                        </a>
                        <a href="#"
                           class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel">
                            <i class="flaticon-more-v4"></i>
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    
                    <div class="a--owl-carousel-init-loading">
                        <div class="lds-roller">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
    
                    <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 carousel_block_{{ $block->id }}">
        
        
                        @if(((isset($blockType) && $blockType === 'product') || !isset($blockType)) && isset($block->products))
                            @foreach($block->getActiveProducts() as $productKey=>$product)
                                @include('product.partials.Block.product')
                            @endforeach
                        @endif
        
        
        
                        {{-- old content block loop --}}
                        @if(((isset($blockType) && $blockType === 'content') || !isset($blockType)) && isset($block->contents))
                            @foreach($block->getActiveContent() as $contentKey=>$content)
                                @include('product.partials.Block.content')
                            @endforeach
                        @endif
        
        
                        {{--                                 new content block loop --}}
                        @if(((isset($blockType) && $blockType === 'content') || !isset($blockType)) && isset($block->sets) && $block->sets->count() > 0)
                            @foreach($block->sets->first()->getActiveContents2() as $contentKey=>$content)
                                @include('product.partials.Block.content')
                            @endforeach
                        @endif
        
                        @if(((isset($blockType) && $blockType === 'set') || !isset($blockType)) && isset($block->sets))
                            @foreach($block->getActiveSets() as $setsKey=>$set)
                                @include('product.partials.Block.set')
                            @endforeach
                        @endif
    
    
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endif
