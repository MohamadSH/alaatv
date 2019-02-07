{{--
@include('partials.widgets.set1',[
                'widgetActionName' => $section["descriptiveName"].'/ نمایش همه',
                'widgetActionLink' => urldecode(action("ContentController@index" , ["tags" => $section["tags"]])),
                'widgetTitle'      => $lesson["displayName"],
                'widgetPic'        => (isset($lesson["pic"]) && strlen($lesson["pic"])>0 ?  $lesson["pic"]."?w=253&h=142" : 'https://via.placeholder.com/235x142'),
                'widgetAuthor' => $lesson["author"],
                'widgetLink'       => (isset($lesson["content_id"]) && $lesson["content_id"]>0 ? action("ContentController@show", $lesson["content_id"]):""),
                'widgetCount' => $lesson["content_count"],
                'widgetScroll' => 1
                ])
                --}}
<div class = "@if($widgetScroll) item @else col-lg-3 col-xl-4 col-md-4 col-xs-4 @endif">
    <!--begin:: Widgets/Blog-->
    <div class = "m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force" style="min-height-: 286px">
        <div class = "m-portlet__head m-portlet__head--fit">
            <div class = "m-portlet__head-caption">
                <div class = "m-portlet__head-action">
                    <a href="{{ $widgetActionLink }}" class = "btn btn-sm m-btn--pill btn-brand">{{ $widgetActionName }}</a>
                </div>
            </div>
        </div>
        <div class = "m-portlet__body">
            <div class = "m-widget19">
                <div class = "m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" >
                    <img src = "{{ $widgetPic }}" alt = " {{ $widgetTitle }}"/>
                    <h4 class = "m-widget19__title m--font-light m--bg-brand m--padding-top-15 m--padding-right-25 a--opacity-7 a--full-width m--regular-font-size-lg2">
                        <a href = "{{ $widgetLink }}" class = "m-link m--font-boldest m--font-light">
                            {{ $widgetTitle }}
                        </a>
                    </h4>
                    <div class = "m-widget19__shadow"></div>
                </div>
                <div class = "m-widget19__content">
                    <div class = "m-widget19__header">
                        <div class = "m-widget19__user-img">
                            <img class = "m-widget19__img" src = "{{ optional($widgetAuthor)->photo }}" alt = "{{ optional($widgetAuthor)->full_name }}">
                        </div>
                        <div class = "m-widget19__info">
                                            <span class = "m-widget19__username">
                                            {{ optional($widgetAuthor)->full_name }}
                                            </span>
                            <br>
                            <span class = "m-widget19__time">
                                            موسسه غیرتجاری آلاء
                                            </span>
                        </div>
                        <div class = "m-widget19__stats">
                                            <span class = "m-widget19__number m--font-brand">
                                            {{ $widgetCount }}
                                            </span>
                            <span class = "m-widget19__comment">
                                            محتوا
                                            </span>
                        </div>
                    </div>
                </div>
                <div class = "m-widget19__action">
                    <a href = "{{ $widgetLink }}" class = "btn m-btn--pill    btn-outline-warning m-btn m-btn--outline-2x ">نمایش فیلم های این دوره</a>
                </div>
            </div>
        </div>
    </div>
    <!--end:: Widgets/Blog-->
</div>