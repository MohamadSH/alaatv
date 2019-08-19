@if($slides->count() > 0)
    <div class="row m--margin-bottom-20">
        <div class="col">
            <div id="carouselMainSlideShow" class="carousel slide" data-ride="carousel">
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
                             @if(strlen(trim($slide->title))>0)
                             data-gtm-eec-promotion-name="{{ $slide->title }}"
                             @else
                             data-gtm-eec-promotion-name="تصویر اسلایدشو-بدون عنوان"
                             @endif
                             @if(isset($positionOfSlideShow))
                             data-gtm-eec-promotion-creative="اسلاید شو - {{ $positionOfSlideShow }}"
                             @else
                             data-gtm-eec-promotion-creative="اسلاید شو"
                             @endif
                             data-gtm-eec-promotion-position="{{ $key }}">
                            @if(isset($slide->link) && strlen($slide->link)>0)
                                <a href="{{$slide->link}}"
                                   class="a--gtm-eec-advertisement a--gtm-eec-advertisement a--gtm-eec-advertisement-click"
                                   data-gtm-eec-promotion-id="slideShow1-{{ $slide->id }}"
                                   @if(strlen(trim($slide->title))>0)
                                   data-gtm-eec-promotion-name="{{ $slide->title }}"
                                   @else
                                   data-gtm-eec-promotion-name="تصویر اسلایدشو-بدون عنوان"
                                   @endif
                                   @if(isset($positionOfSlideShow))
                                   data-gtm-eec-promotion-creative="اسلاید شو - {{ $positionOfSlideShow }}"
                                   @else
                                   data-gtm-eec-promotion-creative="اسلاید شو"
                                   @endif
                                   data-gtm-eec-promotion-position="{{ $key }}">
                            @endif
                                    
                                    <div class="lds-roller loadingSlideshow"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                                    
                                    <img class="d-block a--full-width imageSlideOfSlideshow lazy-image"
                                         data-src="{{ $slide->url }}"
                                         alt="عکس اسلاید @if(isset($slide->title[0])) {{ $slide->title }} @endif "
                                         id="slideshowid-{{ $slide->id }}"
                                         data-width="1280"
                                         width="1280"
                                         @if($pageName === 'shop')
                                         src="https://cdn.alaatv.com/loder.jpg?w=1&h=1"
                                         data-height="300"
                                         height="300"
                                         @else
                                         src="https://cdn.alaatv.com/loder.jpg?w=1&h=1"
                                         height="500"
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

