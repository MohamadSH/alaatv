@if($items->isNotEmpty())
    <div class = "col-xl-12 m--margin-bottom-5">
        <a href = "#" class = "m-link m-link--primary">
            <h3 style = "font-weight: bold"><i class="la la-comment"></i>مقالات آموزشی</h3>
        </a>
        <hr>
    </div>
    @foreach($items as $content)
        @include('partials.widgets.article1',[
        'widgetActionName' => ''.'پخش / دانلود',
        'widgetActionLink' => action("Web\ContentController@show" , $content),
        'widgetTitle'      => $content->name ?? $content->name ,
        'widgetPic'        => $content->thumbnail ??  $content->thumbnail,
        'widgetAuthor'     => optional($content->author),
        'widgetLink'       => action("Web\ContentController@show" , $content),
        'widgetCount'      => 0,
        'widgetScroll'     => 0
        ])
    @endforeach
    <input id="owl--js-var-next-page-article-url" class = "m--hide" type = "hidden" value = '{{ $items->nextPageUrl() }}'>
@endif