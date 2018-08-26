@if($items->isNotEmpty())
<div class="portfolio-content portfolio-1">
    <div id="js-grid-juicy-projects" class="cbp">
        @foreach($items as $content)
            <div class="cbp-item">
                <div class="cbp-caption">
                    <div class="cbp-caption-defaultWrap">
                        <img src="{{($content->files->where("pivot.label" , "thumbnail")->isNotEmpty())?$content->files->where("pivot.label" , "thumbnail")->first()->name:"" }}" alt="@if(isset($content->name[0])){{$content->name}} @endif"> </div>
                    <div class="cbp-caption-activeWrap">
                        <div class="cbp-l-caption-alignCenter">
                            <div class="cbp-l-caption-body">
                                <a href="{{action("ContentController@show" , $content)}}" class="cbp-l-caption-buttonLeft btn red uppercase ">تماشای فیلم</a>
                                {{--<a href="/assets/global/img/portfolio/1200x900/57.jpg" class="cbp-lightbox cbp-l-caption-buttonRight btn red uppercase btn red uppercase" data-title="Dashboard<br>by Paul Flavius Nechita">view larger</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cbp-l-grid-projects-title text-center" style="font-size: small">
                    <a href="{{action("ContentController@show" , $content)}}">
                        @if(isset($content->name[0])){{$content->name}}@else <span class="font-red">بدون عنوان</span> @endif
                    </a>
                </div>
                {{--<div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center">Web Design / Graphic</div>--}}
            </div>
        @endforeach
    </div>
</div>
@else
<p class="text-center">
    موردی یافت نشد
</p>
@endif
@if($items instanceof \Illuminate\Pagination\LengthAwarePaginator )
<div class="row text-center">
{{ $items->links() }}
</div>
@endif