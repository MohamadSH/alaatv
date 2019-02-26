@if(optional($items)->isNotEmpty())
    <div class = "col-xl-12 m--margin-bottom-5">
        <a href = "#" class = "m-link m-link--primary">
            <h3 style = "font-weight: bold"><i class="la la-list-ul"></i>  دوره های آموزشی</h3>
        </a>
        <hr>
    </div>
    <div id = "set-carousel" class = "a--owl-carousel-type-1 owl-carousel owl-theme" data-per-page = "7">
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
    </div>
    <input id="owl--js-var-next-page-set-url" class = "m--hide" type = "hidden" value = '{{ $items->nextPageUrl() }}'>

@endif