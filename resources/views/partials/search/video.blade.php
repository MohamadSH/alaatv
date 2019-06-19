@if(optional($items)->isNotEmpty() || (!$loadChild ?? false))
    <div class="col-12 m--margin-bottom-5">
        <div class="a--devider-with-title">
            <div class="a--devider-title">
                <a href="#" class="m-link m-link--primary">
                    <i class="la la-video-camera"></i>
                    @if(isset($title))
                        {{ $title }}
                    @else
                        فیلم های آموزشی
                    @endif
                </a>
            </div>
        </div>
    </div>
    <div class="col">
        <div id="{{ $widgetId ?? 'video-carousel' }}" class="{{ $carouselType ?? 'a--owl-carousel-type-1' }} owl-carousel owl-theme" data-per-page="{{ isset($perPage) ? $perPage : 7 }}">
            @if($loadChild ?? true && optional($items)->isNotEmpty())
                @foreach($items as $content)
                    @include('partials.widgets.video1',[
                    'widgetActionName' => (($type ?? null) == 'product') ? 'خرید / دانلود' : ''.'پخش / دانلود',
                    'widgetActionLink' => action("Web\ContentController@show" , $content),
                    'widgetTitle'      => $content->name ?? $content->name ,
                    'widgetPic'        => $content->thumbnail ??  $content->photo,
                    'widgetAuthor'     => $content->author,
                    'widgetLink'       => action("Web\ContentController@show" , $content),
                    'widgetCount'      => 0,
                    'widgetScroll'     => 1,
                    'price'            => (($type ?? null) == 'product') ? $content->price : null
                    ], ['type' => $type ?? null])
                @endforeach
            @endif
        </div>

        <input id="{{ isset($widgetId) ? 'owl--js-var-next-page-'.$widgetId.'-url' : 'owl--js-var-next-page-video-url' }}"
               class="m--hide"
               type="hidden"
               @if(optional($items)->isNotEmpty())
               value="{{ $items->nextPageUrl() }}"
               @else
               value=""
               @endif>

    </div>
@endif