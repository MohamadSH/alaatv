<div class="row blockWraper a--owl-carousel-row
            @if(isset($customClass))
                {{ $customClass }}
            @endif
            @if(isset($customId))
                blockId-{{ $customId }}
            @endif"
            @if(isset($customId))
                id="{{ $customId }}"
            @endif>

    <div class="col">
        <div class="m-portlet a--owl-carousel-Wraper @if(isset($boxed) && $boxed) boxed @endif">
            <div class="m-portlet__head a--owl-carousel-head d-none">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">

                            @if(isset($squareSing))
                                @if($squareSing === 'red')
                                    <span class="redSquare"></span>
                                @elseif($squareSing === 'blue')
                                    <span class="blueSquare"></span>
                                @endif
                            @endif

                            @if(isset($titleLink) && isset($title))
                                <a href="{{ $titleLink }}" class="m-link">
                                    @endif

                                    @if(isset($title))
                                        {!! $title !!}
                                    @endif

                                    @if(isset($titleLink) && isset($title))
                                </a>
                            @endif


                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                    @if(isset($customTools))
                        {!! $customTools !!}
                    @endif

                </div>
            </div>
            <div class="m-portlet__body m-portlet__body--no-padding a--owl-carousel-body">

                <div class="m-widget_head-owlcarousel-items ScrollCarousel a--owl-carousel-type-2">

                    <div class="ScrollCarousel-Items">

                        @if(isset($scrollCarouselItems))
                            {!! $scrollCarouselItems !!}
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
