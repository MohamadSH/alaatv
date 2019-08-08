<div class="row @if(isset($contentCustomClass)) {{ $contentCustomClass }} @endif"
    @if(isset($contentCustomId))
        id="{{ $contentCustomId }}"
    @endif>
    <div class="col">
        <div class="m-portlet m-portlet--bordered"
             @if(isset($contentCustomId))
                id="owlCarousel_{{ $contentCustomId }}"
             @else
                id="owlCarousel_{{ rand() }}"
             @endif >
            <div class="m-portlet__head a--owl-carousel-head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            @if(isset($contentTitle))
                                @if(isset($contentUrl))
                                    <a href="{{ $contentUrl }}" class="m-link">
                                        {{ $contentTitle }}
                                    </a>
                                @else
                                    {{ $contentTitle }}
                                @endif
                            @endif
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="#" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid">
                        <i class="fa fa-th"></i>
                    </a>
                    <a href="#" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel">
                        <i class="fa-exchange-alt"></i>
                    </a>
                </div>
            </div>
            <div class="m-portlet__body m-portlet__body--no-padding">
                <!--begin::Widget 30-->
                <div class="m-widget30">
                    <div class="m-widget_head">
                        <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2 carousel_block_{{ $contentCustomId }}">
                            @foreach($contentSets as $contentSetKey=>$contentSet)
                                <div class="item carousel">
                                    <!--begin:: Widgets/Blog-->
                                    <div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force">
                                        <div class="m-portlet__body">
                                            <div class="a-widget19 m-widget19">
                                                <div class="m-widget19__pic m-portlet-fit--sides" >
                                                    <a href="{{ action('Web\ContentController@show', $contentSet['content_id']) }}" class="btn btn-sm m-btn--pill btn-brand btnViewMore">
                                                        <i class="fa fa-play"></i> / <i class="fa fa-cloud-download-alt"></i>
                                                    </a>
                                                    <a href="{{ action('Web\ContentController@show', $contentSet['content_id']) }}">
                                                        <img src="{{ $contentSet['pic'] }}?w=253&h=142" alt="{{ $contentSet['displayName'] }}"/>
                                                    </a>
                                                    <div class="m-widget19__shadow"></div>
                                                </div>
                                                <div class="m-widget19__content">
                                                    <div class="owl-carousel-fileTitle">
                                                        <a href="{{ action('Web\ContentController@show', $contentSet['content_id']) }}" class="m-link">
                                                            <h6>
                                                                <span class="m-badge m-badge--info m-badge--dot"></span>
                                                                {{ $contentSet['displayName'] }}
                                                            </h6>
                                                        </a>
                                                    </div>
                            
                                                    <div class="m-widget19__header">
                                                        <div class="m-widget19__user-img">
                                                            <img class="m-widget19__img" src="{{ $contentSet['author']->photo }}" alt="{{ $contentSet['author']->full_name }}">
                                                        </div>
                                                        <div class="m-widget19__info">
                                                            <span class="m-widget19__username">
                                                                {{ $contentSet['author']->full_name }}
                                                            </span>
                                                            <br>
                                                            <span class="m-widget19__time">
                                                                موسسه غیرتجاری آلاء
                                                            </span>
                                                        </div>
                                                        <div class="m-widget19__stats">
                                                            <span class="m-widget19__number m--font-brand">
                                                                {{ $contentSet['content_count'] }}
                                                            </span>
                                                            <span class="m-widget19__comment">
                                                                محتوا
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end:: Widgets/Blog-->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--end::Widget 30-->
            </div>
        </div>
    </div>
</div>