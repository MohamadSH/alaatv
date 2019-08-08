@if(isset($users) && $users->count() > 0)
    <div class="row
                @if(isset($customClass))
                    {{ $customClass }}
                @endif
                @if(isset($customId))
                    carouselId-{{ $customId }}
                @endif"
                @if(isset($customId))
                    id="{{ $customId }}"
                @endif>
        <div class="col">
            <div class="m-portlet  m-portlet--bordered OwlCarouselType2-shopPage"
                 @if(isset($customId))
                 id="owlCarousel_{{ $customId }}"
                 @endif>
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @if(isset($url) && (!isset($urlDisable) || !$urlDisable))
                                    <a href="{{ $url }}" class="m-link">
                                @endif
                                @if(isset($title))
                                    {!! $title !!}
                                @endif
                                @if(isset($url) && (!isset($urlDisable) || !$urlDisable))
                                    </a>
                                @endif
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="#" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewGrid">
                            <i class="fa fa fa-th"></i>
                        </a>
                        <a href="#" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air btn-viewOwlCarousel">
                            <i class="fa fa-exchange-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <!--begin::Widget 30-->
                    <div class="m-widget30">
                        <div class="m-widget_head">
                            <div class="m-widget_head-owlcarousel-items owl-carousel a--owl-carousel-type-2">
                                @foreach($users as $userKey=>$user)
                                    <div class="m-widget_head-owlcarousel-item carousel background-gradient" data-position="{{ $userKey }}">
                                        <img class="a--owl-carousel-type-2-item-image" src="{{ $user->getCustomSizePhoto(105,140) }}" alt="{{ $user->full_name }}">
                                        <p class="userFullname">
                                            {{ $user->full_name }}
                                        </p>
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
@endif
