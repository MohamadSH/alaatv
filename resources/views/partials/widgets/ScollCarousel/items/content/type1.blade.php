<div class="item carousel a--block-item a--block-type-content
        @if(isset($sort) && $sort) SortItemsList-item @endif
        @if(isset($responsiveClass))
            {{ $responsiveClass }}
        @else
            w-44333211
        @endif"
     @if(isset($sort) && $sort) data-sort="{{$key}}" @endif>
    <div class="a--block-imageWrapper">
        <a href="{{ (isset($content->url->web)) ? $content->url->web : $content->url }}" class="btn btn-sm m-btn--pill btn-brand btnViewMore">
            <i class="fa fa-play"></i> / <i class="fa fa-cloud-download-alt"></i>
        </a>
        <a href="{{ (isset($content->url->web)) ? $content->url->web : $content->url }}" class="a--block-imageWrapper-image">
            <img class="a--block-image lazy-image"
                 src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"
                 data-src="{{ (isset($content->thumbnail)) ? $content->thumbnail : $content->photo }}"
                 alt="{{ (isset($content->name)) ? $content->name : $content->title }}"
                 width="253" height="142" />
        </a>
    </div>
    <div class="a--block-infoWrapper">
        <div class="a--block-titleWrapper">
            <a href="{{ (isset($content->url->web)) ? $content->url->web : $content->url }}" class="m-link">
                <span class="m-badge m-badge--info m-badge--dot"></span>
                {{ (isset($content->name)) ? $content->name : $content->title }}
            </a>
        </div>
        {{--        @if(strlen(trim($content->author->full_name))>0)--}}
        {{--        <div class="a--block-detailesWrapper">--}}
        {{--            <div class="a--block-set-author-name">--}}
        {{--                <span class="a--block-set-author-name-title">--}}
        {{--                    <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">--}}
        {{--                        {{ trim($content->author->full_name) }}--}}
        {{--                    </span>--}}
        {{--                </span>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        @endif--}}
    </div>
</div>
