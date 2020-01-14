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
            <div class="m-portlet__head a--owl-carousel-head @if(isset($puls) && $puls) puls @endif">
                @if(isset($puls) && $puls)
                    <div class="puls1"></div>
                    <div class="puls2"></div>
                @endif
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">

                            @if(isset($squareSing))
                                @if($squareSing === 'red')
                                    <span class="redSquare"></span>
                                @elseif($squareSing === 'blue')
                                    <span class="blueSquare"></span>
                                @elseif($squareSing === 'recomender')
{{--                                    <span class="recomenderSquare"></span>--}}
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 481.882 481.882" xml:space="preserve" width="40px" height="40px" class="m--margin-right-10">
                                        <g>
                                            <circle style="fill:#22B7FF" cx="240.941" cy="240.941" r="240.941" data-original="#E56353" class="" data-old_color="#E56353"/>
                                            <circle style="fill:#2495CB" cx="240.941" cy="259.012" r="113.242" data-original="#D15241" class="active-path" data-old_color="#D15241"/>
                                            <circle style="fill:#E56353" cx="240.941" cy="240.941" r="113.242" data-original="#FFFFFF" class="" data-old_color="#FFFFFF"/>
                                        </g>
                                    </svg>
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

                    <div class="ScrollCarousel-Items @if(isset($sort) && $sort) SortItemsList @endif ">

                        @if(isset($scrollCarouselItems))
                            {!! $scrollCarouselItems !!}
                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
