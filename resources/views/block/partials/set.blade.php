<div class="item carousel a--block-item a--block-type-set w-44333211">
    <div class="a--block-imageWrapper">

        <div class="a--block-detailesWrapper">

            <div class="a--block-set-count">
                <span class="a--block-set-count-number">{{ $set->active_contents_count }}</span>
                <br>
                <span class="a--block-set-count-title">محتوا</span>
                <br>
                <a href="{{ $set->web_url }}" class="a--block-set-count-icon">
                    <i class="fa fa-bars"></i>
                </a>
            </div>

            <div class="a--block-set-author-pic">
                <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" class="m-widget19__img lazy-image" data-src="{{ $set->author->photo }}" alt="{{ $set->author->full_name }}" width="40" height="40">
            </div>


        </div>

        <a href="{{ $set->web_url }}" class="a--block-imageWrapper-image">
            <img src="https://cdn.alaatv.com/loder.jpg?w=16&h=9" data-src="{{ $set->photo }}" alt="{{ $set->small_name }}" class="a--block-image lazy-image" width="453" height="254" />
        </a>
    </div>

    <div class="a--block-infoWrapper">

        <div class="a--block-titleWrapper">
            <a href="{{ $set->web_url }}" class="m-link">
                <span class="m-badge m-badge--info m-badge--dot"></span>
                {{ $set->small_name }}
            </a>
        </div>

    </div>

</div>
