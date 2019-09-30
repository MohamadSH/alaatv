@if(optional($items)->isNotEmpty() || (!$loadChild ?? false))
    <div class = "col-12 m--margin-bottom-5">
        <div class = "a--devider-with-title">
            <div class = "a--devider-title">
                <a href = "#" class = "m-link m-link--primary">
                    <i class = "fa fa-list"></i>
                    @if(isset($title))
                        {{ $title }}
                    @else
                        دوره های آموزشی
                    @endif
                </a>
            </div>
        </div>

    </div>
    <div class = "col-12 a--owl-carousel-Wraper">
        <div id = "{{  $widgetId ?? 'set-carousel'}}" class = "{{ $carouselType ?? 'a--owl-carousel-type-1' }} a--owl-carousel-type-2 owl-carousel owl-theme" data-per-page = "7">
            @if($loadChild ?? true && optional($items)->isNotEmpty())
                @foreach($items as $lesson)

                    @include('partials.widgets.set2',[
                    'widgetActionName' => 'نمایش این دوره',
                    'widgetActionLink' => $lesson->url,
                    'widgetTitle'      => $lesson->shortName,
                    'widgetPic'        => (isset($lesson->photo) && strlen($lesson->photo)>0 ? $lesson->photo."?w=253&h=142" : 'https://via.placeholder.com/235x142'),
                    'widgetAuthor'     => $lesson->author,
                    'widgetLink'       => $lesson->url,
                    'widgetCount'      => $lesson->contents_count,
                    'widgetScroll'     => 1
                    ])
                @endforeach
            @endif
        </div>

        <input id = "{{ isset($widgetId) ? 'owl--js-var-next-page-'.$widgetId.'-url' : 'owl--js-var-next-page-set-url' }}" class = "m--hide" type = "hidden"
               @if(optional($items)->isNotEmpty())
               value = "{{ $items->nextPageUrl() }}"
               @else
               value = ""
               @endif>

    </div>
@endif
