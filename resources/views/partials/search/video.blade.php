@if(optional($items)->isNotEmpty())
    <div class = "col-12 m--margin-bottom-5">
        <a href = "#" class = "m-link m-link--primary">
            <h3 style = "font-weight: bold">
                <i class="la la-video-camera"></i>
                @if(isset($title))
                    {{ $title }}
                @else
                    فیلم های آموزشی
                @endif
            </h3>
        </a>
        <hr>
    </div>
    <div class = "col">
            <div id = "{{ $widgetId ?? 'video-carousel' }}" class = "{{ $carouselType ?? 'a--owl-carousel-type-1' }} owl-carousel owl-theme" data-per-page = "7">
                @foreach($items as $content)
                    {{--{{ dd($content->photo) }}--}}
                    @include('partials.widgets.video1',[
                    'widgetActionName' => (($type ?? null) == 'product') ? 'خرید / دانلود' : ''.'پخش / دانلود',
                    'widgetActionLink' => action("Web\ContentController@show" , $content),
                    'widgetTitle'      => $content->name ?? $content->name ,
                    'widgetPic'        => $content->thumbnail ??  $content->photo,
                    'widgetAuthor'     => optional($content->author),
                    'widgetLink'       => action("Web\ContentController@show" , $content),
                    'widgetCount'      => 0,
                    'widgetScroll'     => 1,
                    'price'            => (($type ?? null) == 'product') ? $content->price : null
                    ], ['type' => $type ?? null])
                @endforeach
        </div>





        {{--{{ isset($widgetId) ? 'owl--js-var-next-page-'.$widgetId.'-url' : 'owl--js-var-next-page-video-url' }}: {{ $items->nextPageUrl() }}--}}
        <input id="11{{ isset($widgetId) ? 'owl--js-var-next-page-'.$widgetId.'-url' : 'owl--js-var-next-page-video-url' }}" class = "m--hide" type = "hidden" value = '{{ $items->nextPageUrl() }}'>
        <input id="{{ isset($widgetId) ? 'owl--js-var-next-page-'.$widgetId.'-url' : 'owl--js-var-next-page-video-url' }}" class = "m--hide" type = "hidden" value = '{{ $items->nextPageUrl() }}'>


    </div>
@endif