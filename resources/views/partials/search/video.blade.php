@if(optional($items)->isNotEmpty())
    <div class = "col-xl-12 m--margin-bottom-5">
        <a href = "#" class = "m-link m-link--primary">
            <h3 style = "font-weight: bold"><i class="la la-video-camera"></i>  فیلم های آموزشی</h3>
        </a>
        <hr>
    </div>
    <div id="video-carousel" class="owl-carousel owl-theme">
            @foreach($items as $content)
                @include('partials.widgets.video1',[
                'widgetActionName' => ''.'پخش / دانلود',
                'widgetActionLink' => action("Web\ContentController@show" , $content),
                'widgetTitle'      => $content->name ?? $content->name ,
                'widgetPic'        => $content->thumbnail ??  $content->thumbnail,
                'widgetAuthor'     => optional($content->author),
                'widgetLink'       => action("Web\ContentController@show" , $content),
                'widgetCount'      => 0,
                'widgetScroll'     => 1
                ])
            @endforeach
    </div>
    <input id="owl--js-var-next-page-video-url" class = "m--hide" type = "hidden" value = '{{ $items->nextPageUrl() }}'>

@endif