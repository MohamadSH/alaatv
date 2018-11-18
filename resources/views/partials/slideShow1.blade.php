@if($slides->count() > 0)
    <div class="row m--margin-bottom-20">
        <div class="col-xl-12">
            <div id="carouselMainSlideShow" class="carousel slide" data-ride="carousel">
                @if($slides->count() > 1)
                    <ol class="carousel-indicators">
                        @foreach($slides as $key => $slide)
                            <li data-target="#carouselMainSlideShow" data-slide-to="{{$key}}"
                                class="@if($key == 0) active @endif"></li>
                        @endforeach

                    </ol>
                @endif

                <div class="carousel-inner">
                    @foreach($slides as $key => $slide)
                        <div class="carousel-item @if($key == 0) active @endif">
                            @if(isset($slide->link) && strlen($slide->link)>0)
                                <a href="{{$slide->link}}">
                                    @endif
                                    <img class="d-block w-100"
                                         src="{{ route('image', ['category'=>$slideDisk,'w'=>'1280' , 'h'=>'500' ,  'filename' =>  $slide->photo ]) }}"
                                         alt="عکس اسلاید @if(isset($slide->title[0])) {{$slide->title}} @endif">
                                    <div class="carousel-caption d-none d-md-block">
                                        @if(isset($slide->title[0]))<h4 class="bold">{{$slide->title}}</h4>@endif
                                        @if(isset($slide->shortDescription[0]))<p
                                                class="bold">{{$slide->shortDescription}}</p>@endif
                                    </div>
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
                <br><br>
                <ol class="carousel-indicators">
                    <a target="_self"
                       onclick="$('html,body').animate({scrollTop: $('#learn-more').offset().top},'slow');"
                       id="move-to-products">
                        {{--<i class="fa fa-angle-down fa-3x font-white"></i>--}}
                        <img id="toggle" class="toggleAnim" alt="slideShowArrow" src="/assets/extra/symbol.png">
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

