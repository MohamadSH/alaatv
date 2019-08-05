<div class="item carousel a--block-item a--block-type-content" data-position="{{ $contentKey }}">
    <div class="a--block-imageWrapper">
        <a href="{{ $content->url }}" class="btn btn-sm m-btn--pill btn-brand btnViewMore">
            <i class="fa fa-play"></i> / <i class="fa fa-cloud-download-alt"></i>
        </a>
        <a href="{{ $content->url }}" class="a--block-imageWrapper-image">
            <img class="a--block-image lazy-image"
                 src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"
                 data-src="{{ $content->thumbnail }}"
                alt="{{ $content->name }}"
                width="253" height="142" />
        </a>
    </div>
    <div class="a--block-infoWrapper">
        <div class="a--block-titleWrapper">
            <a href="{{ $content->url }}" class="m-link">
                <h6>
                    <span class="m-badge m-badge--info m-badge--dot"></span>
                    {{ $content->name }}
                </h6>
            </a>
        </div>
        @if(strlen(trim($content->author->full_name))>0)
        <div class="a--block-detailesWrapper">
            <div class="a--block-set-author-name">
                <span class="a--block-set-author-name-title">
                    <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                        {{ trim($content->author->full_name) }}
                    </span>
                </span>
            </div>
        </div>
        @endif
    </div>
</div>