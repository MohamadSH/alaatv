@if($slides->count() > 0)
    <div class="row margin-bottom-@if(isset($marginBottom)){{$marginBottom}}@endif">
        <div class="col-md-12">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                @if($slides->count() > 1)
                    <ol class="carousel-indicators margin-bottom-20">
                        @foreach($slides as $slide)
                            <li data-target="#myCarousel" data-slide-to="{{$slideCounter  - 1}}" class="@if($slideCounter++ == 1) active @endif"></li>
                        @endforeach

                    </ol>
                @endif

            <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    @foreach($slides as $slide)
                        <div class="item @if($slides->first()->id == $slide->id) active @endif" >
                            @if(isset($slide->link) && strlen($slide->link)>0)
                                <a href="{{$slide->link}}">
                                    @endif
                                    <img src="{{ route('image', ['category'=>$slideDisk,'w'=>'1280' , 'h'=>'500' ,  'filename' =>  $slide->photo ]) }}" alt="عکس اسلاید @if(isset($slide->title[0])) {{$slide->title}} @endif" >
                                    <div class="carousel-caption">
                                        @if(isset($slide->title[0]))<h4 class="bold">{{$slide->title}}</h4>@endif
                                        @if(isset($slide->shortDescription[0]))<p class="bold">{{$slide->shortDescription}}</p>@endif
                                    </div>
                                    @if(isset($slide->link) && strlen($slide->link)>0)
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($slides->count() > 1)
                <!-- Left and right controls -->
                    <a class="left carousel-control margin-right-0" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                @endif
            </div>
            @if(isset($withDownArrow) && $withDownArrow)
                <br><br>
                <ol class="carousel-indicators">
                    <a  target="_self" onclick="$('html,body').animate({scrollTop: $('#learn-more').offset().top},'slow');"  id="move-to-products" >
                        {{--<i class="fa fa-angle-down fa-3x font-white"></i>--}}
                        <img id="toggle" class="toggleAnim" alt="slideShowArrow" src="/assets/extra/symbol.png">
                        <style>
                            img.toggleAnim{
                                -webkit-filter: invert(1);
                                filter: invert(1);
                                height:70px;
                            }
                        </style>
                    </a>
                </ol>
            @endif
        </div>
    </div>
@endif

