@if(isset($src) && isset($name) && isset($sets) && isset($key))

    <div class="productItem" data-pc="{{$category}}" data-product-key="{{$key}}" data-sort1="{{$sort1}}" data-sort2="{{$sort2}}">
        <div class="row no-gutters">
            <div class="col-md-2 productItem-imageCol">
                <div class="productItem-image">
                    <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-toggle="m-tooltip" data-placement="top" data-original-title="{{$name}}"
                         data-src="{{ $src }}"
                         alt="{{ $name }}"
                         class="lazy-image a--full-width" width="400" height="400" />
                </div>
            </div>
            <div class="col-md-10 productItem-descriptionCol">
                <div class="productItem-description">
                    <div class="title">
                        {{ $name }}
                    </div>
                    <div class="action">

                        @if(count($sets) === 1)

                            @if($sets->first()->getActiveContents2(config('constants.CONTENT_TYPE_VIDEO'))->isNotEmpty())
                                <button type="button"
                                        class="btn btn-warning btn-lg btnViewContentSet btnViewVideo"
                                        data-content-type="video"
                                        data-product-key="{{$key}}"
                                        data-content-url="{{ $sets->first()->contentUrl.'&orderBy=order' }}">
                                    فیلم ها
                                </button>
                            @endif
                            @if($sets->first()->getActiveContents2(config('constants.CONTENT_TYPE_PAMPHLET'))->isNotEmpty())
                                <button type="button"
                                        class="btn btn-secondary btn-lg btnViewContentSet btnViewPamphlet"
                                        data-content-type="pamphlet"
                                        data-product-key="{{$key}}"
                                        data-content-url="{{ $sets->first()->contentUrl.'&orderBy=order' }}">
                                    جزوات
                                </button>
                            @endif
                        @elseif(count($sets)>1)
                            <div class="CustomDropDown solidBackground background-yellow" data-parent-id="CustomDropDown{{$key}}">
                                <select>
                                    @foreach($sets as $setKey=>$set)
                                        <option value="{{ $set->contentUrl.'&orderBy=order' }}"
                                                data-product-key="{{$key}}"
                                                @if($set->getActiveContents2(config('constants.CONTENT_TYPE_VIDEO'))->isNotEmpty())
                                                    data-has-video="1"
                                                @else
                                                    data-has-video="0"
                                                @endif
                                                @if($set->getActiveContents2(config('constants.CONTENT_TYPE_PAMPHLET'))->isNotEmpty())
                                                    data-has-pamphlet="1"
                                                @else
                                                    data-has-pamphlet="0"
                                                @endif >
                                            {{ $set->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($sets)>1)
        <div id="CustomDropDown{{$key}}"></div>
    @endif

@endif
