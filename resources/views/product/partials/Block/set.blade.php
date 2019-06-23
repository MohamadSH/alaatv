<div class="item carousel">
    <!--begin:: Widgets/Blog-->
    <div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force">
        <div class="m-portlet__body">
            <div class="a-widget19 m-widget19">
                <div class="m-widget19__pic m-portlet-fit--sides" >
                    <a href="{{ $set->url }}" class="btn btn-sm m-btn--pill btn-brand btnViewMore">
                        <i class="fa fa-play"></i> / <i class="fa fa-cloud-download-alt"></i>
                    </a>
                    <a href="{{ $set->url }}">
                        <img data-src="{{ $set->photo }}?w=253&h=142" alt="{{ $set->small_name }}" class="a--full-width owl-lazy lazy-image"/>
                    </a>
                    <div class="m-widget19__shadow"></div>
                </div>
                <div class="m-widget19__content">
                    <div class="owl-carousel-fileTitle">
                        <a href="{{ $set->url }}" class="m-link">
                            <h6>
                                <span class="m-badge m-badge--info m-badge--dot"></span>
                                {{ $set->small_name }}
                            </h6>
                        </a>
                    </div>
                    
                    <div class="m-widget19__header">
                        <div class="m-widget19__user-img">
                            <img class="m-widget19__img owl-lazy lazy-image" data-src="{{ $set->author->photo }}" alt="{{ $set->author->full_name }}">
                        </div>
                        <div class="m-widget19__info">
                            <span class="m-widget19__username">
                                {{ $set->author->full_name }}
                            </span>
                            <br>
                            <span class="m-widget19__time">
                                موسسه غیرتجاری آلاء
                            </span>
                        </div>
                        <div class="m-widget19__stats">
                            <span class="m-widget19__number m--font-brand">
                                {{ $set->contents_count }}
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