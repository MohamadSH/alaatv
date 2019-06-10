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
                        <a href="{{ $contentset->url }}" class="m-link">
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