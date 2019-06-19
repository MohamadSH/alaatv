@if(
    isset($block) && $block !== null &&
    (
        (!isset($blockType)) ||
        isset($blockType) &&
        (
            ($blockType === 'content' && isset($block->contents) && $block->contents->count() > 0) ||
            ($blockType === 'content' && optional(optional(optional($block->sets)->first())->contents)->count() > 0) ||
            ($blockType === 'product' && isset($block->products) && $block->products->count() > 0) ||
            ($blockType === 'set' && isset($block->sets) && $block->sets->count() > 0)
        )
    )
)
    <div class="row blockWraper
                @if(isset($blockCustomClass))
                    {{ $blockCustomClass }}
                @endif
                blockId-{{ $block->id }}
                {{ $block->class }}
                @if(((isset($blockType) && $blockType === 'product') || !isset($blockType)) && isset($block->products))
                blockWraper-hasProduct
                @endif"
         @if(isset($blockCustomId))
            id="{{ $blockCustomId }}"
         @else
            id="{{ $block->class }}"
         @endif>
        <div class="col">
            <div class="m-portlet  m-portlet--bordered OwlCarouselType2-shopPage" id="owlCarousel_{{ $block->id }}">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
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
                        <a href="#" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid">
                            <i class="fa flaticon-shapes"></i>
                        </a>
                        <a href="#" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel">
                            <i class="flaticon-more-v4"></i>
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <!--begin::Widget 30-->
                    <div class="m-widget30">
                        <div class="m-widget_head">
                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 carousel_block_{{ $block->id }}">
                                
                                
                                @if(((isset($blockType) && $blockType === 'product') || !isset($blockType)) && isset($block->products))
                                    @foreach($block->products as $productKey=>$product)
                                        @include('product.partials.Block.product')
                                    @endforeach
                                @endif
                                
                                
                                
                                {{-- old content block loop --}}
                                @if(((isset($blockType) && $blockType === 'content') || !isset($blockType)) && isset($block->contents))
                                    @foreach($block->contents as $contentKey=>$content)
                                        @include('product.partials.Block.content')
                                    @endforeach
                                @endif
                                
                                
                                
                                
                                
{{--                                 new content block loop --}}
                                @if(((isset($blockType) && $blockType === 'content') || !isset($blockType)) && isset($block->sets) && $block->sets->count() > 0)
                                    @foreach($block->sets->first()->contents as $contentKey=>$content)
                                        @include('product.partials.Block.content')
                                    @endforeach
                                @endif
    
                                @if(((isset($blockType) && $blockType === 'set') || !isset($blockType)) && isset($block->sets))
                                    @foreach($block->sets as $setsKey=>$set)
                                        @include('product.partials.Block.set')
                                    @endforeach
                                @endif
                            
                                
                            
                            
                            </div>
                        </div>
                    </div>
                    <!--end::Widget 30-->
                </div>
            </div>
        </div>
    </div>
@endif
