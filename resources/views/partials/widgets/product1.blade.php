{{--
@include('partials.widgets.product1',[
                'widgetTitle'      => $product->name,
                'widgetPic'        => $product->photo,
                'widgetLink'       => action("ProductController@show", $product),
                'widgetPrice'      => $lesson["content_count"],
                'widgetPriceLabel' => ($product->isFree || $product->basePrice == 0 ? 0 : 1)
                ])

                --}}
<div class = "col-xl-3 col-md-3 col-xs-3">
    {{--<a href = "{{ $widgetLink }}" class = "m-link m--font-boldest m--font-light">--}}
        <!--begin:: Widgets/Blog-->
        <div class = "m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force" style="min-height-: 286px">
            <div class="m-portlet__head m-portlet__head--fit">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-action">
                    </div>
                </div>
            </div>
            <div class = "m-portlet__body">
                <div class = "m-widget19 m--align-center">
                    <div class = "m-widget19__pic m-portlet-fit--top m-portlet-fit--sides">
                        <img src = "{{ $widgetPic }}" alt = " {{ $widgetTitle }}"/>
                        <div class = "m-widget19__shadow"></div>
                    </div>
                    <div class = "m-widget19__content ">
                        <div class = "m--font-primary m--icon-font-size-sm1 m--font-bolder m--margin-top-15">
                            <span>{{ $widgetPrice }}
                                @if($widgetPriceLabel)
                                    <span>تومان</span>
                                @endif
                            </span>
                        </div>
                        <h2 class="m--icon-font-size-sm2">{{ $widgetTitle }}</h2>
                    </div>
                    <div class = "m-widget19__action">
                        <a href = "{{ $widgetLink }}" class = "btn m-btn--pill    btn-outline-warning m-btn m-btn--outline-2x a--full-width">اطلاعات بیشتر</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Blog-->
    {{--</a>--}}
</div>