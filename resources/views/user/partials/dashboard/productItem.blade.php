@if(isset($src) && isset($name) && isset($sets) && isset($key))
    <div class="productItem">
        <div class="row no-gutters">
            <div class="col-md-2">
                <div class="productItem-image">
                    <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1"
                         data-src="{{ $src }}"
                         alt="{{ $name }}"
                         class="lazy-image a--full-width" width="400" height="400" />
                </div>
            </div>
            <div class="col-md-10">
                <div class="productItem-description">
                    <div class="title">
                        {{ $name }}
                    </div>
                    <div class="action">

                        @if(count($sets) === 1)

                            @if($sets->first()->getActiveContents2(config('constants.CONTENT_TYPE_VIDEO'))->isNotEmpty())
                                <button type="button"
                                        class="btn btn-warning btn-lg"
                                        data-content-type="video"
                                        data-content-url="{{ $sets->first()->contentUrl.'&orderBy=order' }}">
                                    فیلم ها
                                </button>
                            @endif
                            @if($sets->first()->getActiveContents2(config('constants.CONTENT_TYPE_PAMPHLET'))->isNotEmpty())
                                <button type="button"
                                        class="btn btn-secondary btn-lg"
                                        data-content-type="pamphlet"
                                        data-content-url="{{ $sets->first()->contentUrl.'&orderBy=order' }}">
                                    جزوات
                                </button>
                            @endif
                        @elseif(count($sets)>1)
                            <div class="CustomDropDown solidBackground background-yellow" data-parent-id="CustomDropDown{{$key}}">
                                <select>
                                    @foreach($sets as $setKey=>$set)
                                        <option value="{{ $set->contentUrl.'&orderBy=order' }}">{{ $set->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="CustomDropDown{{$key}}"></div>

@endif
