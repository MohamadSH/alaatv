@if(optional($items)->isNotEmpty())
    <div class = "col-12 m--margin-bottom-5">

        <div class = "a--devider-with-title">
            <div class = "a--devider-title">

                <a href = "#" class = "m-link m-link--primary">
                    <i class = "la la-list-ul"></i>
                    دوره های آموزشی
                </a>
            </div>
        </div>

    </div>
    <div class = "col-12">
        <div id = "set-carousel" class = "a--owl-carousel-type-1 owl-carousel owl-theme" data-per-page = "7">
            @if($loadChild ?? true)
                @foreach($items as $lesson)

                    @include('partials.widgets.set2',[
                    'widgetActionName' => 'نمایش این دوره',
                    'widgetActionLink' => $lesson->url,
                    'widgetTitle'      => $lesson->shortName,
                    'widgetPic'        => (($lesson->photo) && strlen($lesson->photo)>0 ? $lesson->photo."?w=253&h=142" : 'https://via.placeholder.com/235x142'),
                    'widgetAuthor'     => optional($lesson->author),
                    'widgetLink'       => $lesson->url,
                    'widgetCount'      => $lesson->contents_count,
                    'widgetScroll'     => 1
                    ])
                @endforeach
            @endif
        </div>

        <input id = "owl--js-var-next-page-set-url" class = "m--hide" type = "hidden" value = '{{ $items->nextPageUrl() }}'>

    </div>
@endif