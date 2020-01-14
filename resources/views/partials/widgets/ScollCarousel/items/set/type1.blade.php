<div class="item carousel a--block-item a--block-type-set
        @if(isset($sort) && $sort) SortItemsList-item @endif
        @if(isset($responsiveClass))
            {{ $responsiveClass }}
        @else
            w-55443211
        @endif"
     @if(isset($sort) && $sort) data-sort="{{$key}}" @endif>
    <div class="a--block-imageWrapper">
{{--{{dd($set)}}--}}
        <div class="a--block-detailesWrapper">

            <div class="a--block-set-count">
                <span class="a--block-set-count-number">{{ (isset($set->active_contents_count)) ? $set->active_contents_count : $set->contents_count }}</span>
                <br>
                <span class="a--block-set-count-title">محتوا</span>
                <br>
                <a href="{{ (isset($set->web_url)) ? $set->web_url : $set->url->web }}" class="a--block-set-count-icon">

                    <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon">
                        <path d="M3.67 8.67h14V11h-14V8.67zm0-4.67h14v2.33h-14V4zm0 9.33H13v2.34H3.67v-2.34zm11.66 0v7l5.84-3.5-5.84-3.5z" class="style-scope yt-icon"></path>
                    </svg>

                </a>
            </div>

            <div class="a--block-set-author-pic">
                <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" class="m-widget19__img lazy-image" data-src="{{ $set->author->photo }}" alt="{{ (isset($set->author->full_name)) ? $set->author->full_name : ($set->author->first_name . $set->author->last_name) }}" width="40" height="40">
            </div>


        </div>

        <a href="{{ (isset($set->web_url)) ? $set->web_url : $set->url->web }}" class="a--block-imageWrapper-image">
            <img src="https://cdn.alaatv.com/loder.jpg?w=16&h=9" data-src="{{ $set->photo }}" alt="{{ (isset($set->small_name)) ? $set->small_name : $set->short_title }}" class="a--block-image a--full-width lazy-image" width="453" height="254" />
        </a>
    </div>

    <div class="a--block-infoWrapper">

        <div class="a--block-titleWrapper">
            <a href="{{ (isset($set->web_url)) ? $set->web_url : $set->url->web }}" class="m-link">
                <span class="m-badge m-badge--info m-badge--dot"></span>
                {{ (isset($set->small_name)) ? $set->small_name : $set->short_title }}
            </a>
        </div>

    </div>

</div>
