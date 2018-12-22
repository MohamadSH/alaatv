@if($items->isNotEmpty())
    @foreach($items as $content)
        @include('partials.widgets.set1',[
        'widgetActionName' => ''.'/ نمایش همه',
        'widgetActionLink' => action("ContentController@show" , $content),
        'widgetTitle'      => $content->name ?? $content->name ,
        'widgetPic'        => $content->thumbnail ??  $content->thumbnail,
        'widgetAuthor'     => $content->author,
        'widgetLink'       => action("ContentController@show" , $content),
        'widgetCount'      => 0,
        'widgetScroll'     => 0
        ])

    @endforeach
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