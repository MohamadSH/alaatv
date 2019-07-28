<div class="item carousel a--block-item a--block-type-set">
    <div class="a--block-imageWrapper">
        <a href="{{ $set->url }}" class="btn btn-sm m-btn--pill btn-brand btnViewMore">
            <i class="fa fa-play"></i> / <i class="fa fa-cloud-download-alt"></i>
        </a>
        <a href="{{ $set->url }}" class="a--block-imageWrapper-image">
            <img src="https://cdn.alaatv.com/loder.jpg?w=16&h=9" data-src="{{ $set->photo }}" alt="{{ $set->small_name }}" class="a--block-image lazy-image" width="453" height="254" />
        </a>
    </div>
    <div class="a--block-infoWrapper">
        <div class="a--block-titleWrapper">
            <a href="{{ $set->url }}" class="m-link">
                <h6>
                    <span class="m-badge m-badge--info m-badge--dot"></span>
                    {{ $set->small_name }}
                </h6>
            </a>
        </div>
        <div class="a--block-detailesWrapper">
    
            <div class="a--block-set-author-pic">
                <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" class="m-widget19__img lazy-image" data-src="{{ $set->author->photo }}" alt="{{ $set->author->full_name }}" width="40" height="40">
            </div>
            <div class="a--block-set-author-name">
                <span class="a--block-set-author-name-title">{{ $set->author->full_name }}</span>
                <br>
                <span class="a--block-set-author-name-alaa">موسسه غیرتجاری آلاء</span>
            </div>
            <div class="a--block-set-count">
                <span class="a--block-set-count-number">{{ $set->contents_count }}</span>
                <br>
                <span class="a--block-set-count-title">محتوا</span>
            </div>
            
        </div>
    </div>
</div>