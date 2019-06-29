@if($slides->count() > 0)
    <div class="row m--margin-bottom-20">
        <div class="col">
            <div id="carouselMainSlideShow" class="carousel slide scrollSensitiveOnScreen" data-ride="carousel">
                @if($slides->count() > 1)
                    <ol class="carousel-indicators">
                        @foreach($slides as $key => $slide)
                            <li data-target="#carouselMainSlideShow" data-slide-to="{{$key}}" class="@if($key == 0) active @endif"></li>
                        @endforeach
                    </ol>
                @endif

                <div class="carousel-inner">
                    @foreach($slides as $key => $slide)
                        <div class="carousel-item @if($key == 0) active @endif text-center"
                             data-gtm-eec-promotion-id="{{ $slide->id }}"
                             data-gtm-eec-promotion-name="{{ $slide->title }}"
                             @if(isset($positionOfSlideShow))
                             data-gtm-eec-promotion-creative="اسلاید شو - {{ $positionOfSlideShow }}"
                             @else
                             data-gtm-eec-promotion-creative="اسلاید شو"
                             @endif
                             data-gtm-eec-promotion-position="{{ $key }}">
                            @if(isset($slide->link) && strlen($slide->link)>0)
                                <a href="{{$slide->link}}"
                                   class="gtm-eec-promotion-click gtm-eec-promotion-slideShow"
                                   data-gtm-eec-promotion-id="slideShow1-{{ $slide->id }}"
                                   data-gtm-eec-promotion-name="{{ $slide->title }}"
                                   @if(isset($positionOfSlideShow))
                                   data-gtm-eec-promotion-creative="اسلاید شو - {{ $positionOfSlideShow }}"
                                   @else
                                   data-gtm-eec-promotion-creative="اسلاید شو"
                                   @endif
                                   data-gtm-eec-promotion-position="{{ $key }}">
                            @endif
                                    <img src="/acm/extra/loader.gif" alt="loading" class="loadingSlideshow">
                                    <img class="d-block w-100 imageSlideOfSlideshow lazy-image"
                                         data-src="{{ $slide->url }}"
                                         alt="عکس اسلاید @if(isset($slide->title[0])) {{ $slide->title }} @endif"
                                         id="slideshowid-{{ $slide->id }}"
                                         data-width="1280"
                                         @if($pageName === 'shop')
                                         data-height="300"
                                         @else
                                         data-height="500"
                                         @endif>
                                    @if(isset($slide->title[0]) && isset($slide->shortDescription[0]))
                                    <div class="carousel-caption d-none d-md-block">
                                        @if(isset($slide->title[0]))
                                            <h4 class="bold">{{ $slide->title  }}</h4>
                                        @endif
                                        @if(isset($slide->shortDescription[0]))
                                            <p class="bold">{{ $slide->shortDescription  }}</p>
                                        @endif
                                    </div>
                                    @endif
                            @if(isset($slide->link) && strlen($slide->link)>0)
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($slides->count() > 1)
                    <a class="carousel-control-next" href="#carouselMainSlideShow" role="button" data-slide="next">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">بعدی</span>
                    </a>
                    <a class="carousel-control-prev" href="#carouselMainSlideShow" role="button" data-slide="prev">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">قبلی</span>
                    </a>
                @endif
            </div>
            @if(isset($withDownArrow) && $withDownArrow)
                <br>
                <br>
                <ol class="carousel-indicators">
                    <a target="_self" onclick="$('html,body').animate({scrollTop: $('#learn-more').offset().top},'slow');" id="move-to-products">
                        {{--<i class="fa fa-angle-down fa-3x font-white"></i>--}}
                        <img id="toggle" class="toggleAnim" alt="slideShowArrow" src="/acm/extra/symbol.png">
                        <style>
                            img.toggleAnim {
                                -webkit-filter: invert(1);
                                filter: invert(1);
                                height: 70px;
                            }
                        </style>
                    </a>
                </ol>
            @endif
        </div>
    </div>
@endif

