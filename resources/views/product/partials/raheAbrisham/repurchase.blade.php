<div class="row">
    <div class="col-md-5">
        <div class="Repurchase-infoVideo">
            <div class="video">
                <img class="lazy-image a--full-width"
                     src="https://cdn.alaatv.com/loder.jpg?w=16&h=9"
                     data-src="/acm/image/raheAbrisham/samplePhoto.png"
                     alt="samplePhoto"
                     width="253" height="142">
            </div>
            <div class="title">
                کلیپ معرفی
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="row no-gutters Repurchase-description">
            <div class="col-md-7 attributes">
                <div class="title display-6">
                    ویژگی های محصول راه ابریشم ریاضی تجربی آلاء
                </div>
                <div class="vlues">
                    <div class="item">
                        <span class="label font-weight-bold">
                            رشته:
                        </span>
                        <span class="value">
                        {{implode('، ',(array)Arr::get($product->info_attributes , 'major'))}}
                        </span>
                    </div>
                    <div class="item">
                        <span class="label font-weight-bold">
                            کنکور:
                        </span>
                        <span class="value">
                        {{implode('،',(array)Arr::get($product->info_attributes , 'educationalSystem'))}}
                        </span>
                    </div>
                    <div class="item">
                        <span class="label font-weight-bold">
                            زمان دریافت:
                        </span>
                        <span class="value">
                        {{ implode(' ',(array)Arr::get($product->info_attributes , 'downloadDate')) }}
                        </span>
                    </div>
                    <div class="item">
                        <span class="label font-weight-bold">
                            برنامه:
                        </span>
                        <span class="value">
                        {{implode('،',(array)Arr::get($product->info_attributes , 'studyPlan'))}}
                        </span>
                    </div>
                    <div class="item">
                        <span class="label font-weight-bold">
                            مدت برنامه:
                        </span>
                        <span class="value">
                            {{implode('،',(array)Arr::get($product->info_attributes , 'courseDuration'))}}
                            [ {{implode('،',(array)Arr::get($product->info_attributes , 'studyPlan'))}} ]
                        </span>
                    </div>
                    <div class="item">
                        <span class="label font-weight-bold">
                            دبیر:
                        </span>
                        <span class="value">
                        {{implode('،',(array)Arr::get($product->info_attributes , 'teacher'))}}
                        </span>
                    </div>
                    <div class="item">
                        <span class="label font-weight-bold">
                            نحوه دریافت:
                        </span>
                        <span class="value">
                        {{implode('،',(array)Arr::get($product->info_attributes , 'shippingMethod'))}}
                        </span>
                    </div>
{{--                    <div class="item">--}}
{{--                        <span class="label font-weight-bold">--}}
{{--                            سال تولید:--}}
{{--                        </span>--}}
{{--                        <span class="value">--}}
{{--                        {{implode('، ',(array)Arr::get($product->info_attributes , 'productionYear'))}}--}}
{{--                        </span>--}}
{{--                    </div>--}}
                </div>
            </div>
            <div class="col-md-5 Property">
                <div class="title display-6">
                    دارای
                </div>
                <div class="vlues">
                    <div class="item">
                        <div class="label font-weight-bold m--font-danger">
                            خدمات اصلی:
                        </div>
                        <div class="value">
                            @foreach($product->info_attributes['services'] as $s)
                                {{ $s }}
                            @endforeach

                        </div>
                    </div>
                    <div class="item m--margin-top-20">
                        <div class="label font-weight-bold m--font-danger">
                            خدمات جانبی:
                        </div>
                        <div class="value">
                            @foreach($product->info_attributes['accessoryServices'] as $s)
                                {{ $s }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row Repurchase-priceAndAddToCart priceAndAddToCartRow">
            <div class="col priceAndAddToCartCol">


                @if($product->price['discount']>0)
                    <div class="discount">

                        <svg class="discountIcon" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 54 54" xml:space="preserve">
                            <path style="fill:#DD352E;" d="M8.589,0C5.779,0,3.5,2.279,3.5,5.089V54l18-12l18,12V6c0-3.3,2.7-6,6-6H8.589z"/>
                            <path style="fill:#B02721;" d="M45.41,0.005C42.151,0.054,39.5,2.73,39.5,6v17h11V5.135C50.5,2.315,48.225,0.03,45.41,0.005z"/>
                        </svg>

                        <div class="discountValue">

                            <div class="discountValue-number">
                                {{ ($product->price['discount']*100/$product->price['base']) }}%
                            </div>
                            <div class="discountValue-text">
                                تخفیف
                            </div>


                        </div>

                    </div>
                @endif

                <div class="price">
                    <div>
                        @if( $product->priceText['discount'] == 0 )
                            {{ $product->priceText['basePriceText'] }}
                        @else
                            <div class="oldValue">{{ $product->priceText['basePriceText'] }} </div>
                            <div class="newValue">{{ $product->priceText['finalPriceText'] }}</div>
                        @endif
                    </div>
                </div>


{{--                <div class="display-6">--}}
{{--                    <span>قیمت محصول:</span>--}}
{{--                    <span>390,000</span>--}}
{{--                    <span>تومان</span>--}}
{{--                </div>--}}
                <button class="btn m-btn--square btn-success btnAddToCart" ><p class="display-6 m--marginless">افزودن به سبد خرید </p></button>
            </div>
        </div>
    </div>
</div>
