<div class="row" id="a_top_section">
    <div class="col">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__body">

            @include('partials.favorite', [
                'favActionUrl' => route('web.mark.favorite.product', [ 'product' => $product->id ]),
                'unfavActionUrl' => route('web.mark.unfavorite.product', [ 'product' => $product->id ]),
                'isFavored' => $isFavored
            ])


            <!--begin::Section-->
                <div class="m-section m-section--last">
                    <div class="m-section__content">
                        <!--begin::Preview-->
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="m--margin-bottom-45">
                                    <img src="{{$product->photo}}?w=400&h=400" alt="عکس محصول@if(isset($product->name)) {{$product->name}} @endif" class="img-fluid m--marginless a--full-width"/>
                                </div>
                            </div>
                            <div class="col">

                                {{--ویژگی ها و دارای --}}
                                <div class="row">
                                    @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'simple'))->count()>0 ||  optional(optional( optional($product->attributes)->get('main'))->where('control', 'simple'))->count()>0)
                                        <div class="col-12
                                                            @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'checkBox'))->count())
                                            col-md-6
@endif">

                                            <div class="m-portlet m-portlet--bordered m-portlet--full-height productAttributes">
                                                <div class="m-portlet__head">
                                                    <div class="m-portlet__head-caption">
                                                        <div class="m-portlet__head-title">
                                                            <h3 class="m-portlet__head-text">
                                                                ویژگی های محصول {{$product->name}}
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__body m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10">
                                                    <!--begin::m-widget4-->
                                                    <div class="m-widget4">

                                                        @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'simple'))->count())
                                                            @foreach($product->attributes->get('information')->where('control', 'simple') as $key => $informationItem)
                                                                @if(count($informationItem->data) > 1)
                                                                    <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class="flaticon-like m--font-info"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    {{ $informationItem->title }}:
                                                                                </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @foreach($informationItem->data as $key => $informationItemData)

                                                                    <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            @if(count($informationItem->data) === 1)
                                                                                <i class="flaticon-like m--font-info"></i>
                                                                            @else
                                                                                <i class="flaticon-interface-5 m--font-info"></i>
                                                                            @endif
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    @if(count($informationItem->data) > 1)
                                                                                        {{ $informationItemData->name }}
                                                                                    @else
                                                                                        {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                    @endif
                                                                                </span>
                                                                        </div>
                                                                    </div>

                                                                @endforeach
                                                            @endforeach
                                                        @endif

                                                        @if(optional($product->attributes)->get('main') != null && $product->attributes->get('main')->where('control', 'simple'))
                                                            @foreach($product->attributes->get('main')->where('control', 'simple') as $key => $informationItem)
                                                                @if(count($informationItem->data) > 1)
                                                                    <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            <i class="flaticon-like m--font-warning"></i>
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    {{ $informationItem->title }}:
                                                                                </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @foreach($informationItem->data as $key => $informationItemData)
                                                                    <div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">
                                                                        <div class="m-widget4__img m-widget4__img--icon">
                                                                            @if(count($informationItem->data) === 1)
                                                                                <i class="flaticon-like m--font-warning"></i>
                                                                            @else
                                                                                <i class="flaticon-interface-5 m--font-warning"></i>
                                                                            @endif
                                                                        </div>
                                                                        <div class="m-widget4__info">
                                                                                <span class="m-widget4__text">
                                                                                    @if(count($informationItem->data) > 1)
                                                                                        {{ $informationItemData->name }}
                                                                                    @else
                                                                                        {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                    @endif
                                                                                </span>
                                                                        </div>
                                                                        @if(isset($informationItemData->id))
                                                                            <input type="hidden" value="{{ $informationItemData->id }}" name="attribute[]">
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                    <!--end::Widget 9-->
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                    @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'checkBox'))->count())
                                        <div class="col-12
                                            @if(optional(optional(optional($product->attributes)->get('information'))->where('control', 'simple'))->count()>0 ||  optional(optional( optional($product->attributes)->get('main'))->where('control', 'simple'))->count()>0)
                                            col-md-6 @endif">
                                            <div class="m-portlet m-portlet--bordered m-portlet--full-height productInformation">
                                                <div class="m-portlet__head">
                                                    <div class="m-portlet__head-caption">
                                                        <div class="m-portlet__head-title">
                                                            <h3 class="m-portlet__head-text">
                                                                دارای
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__body m--padding-5">
                                                    <!--begin::m-widget4-->
                                                    <div class="m-widget4">

                                                        @foreach($product->attributes->get('information')->where('control', 'checkBox') as $key => $informationItem)
                                                            @if(count($informationItem->data) > 1)
                                                                <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10 a--full-width m--font-boldest">
                                                                    {{ $informationItem->title }}
                                                                </div>
                                                            @endif
                                                            @foreach($informationItem->data as $key => $informationItemData)
                                                                <div class="m-widget4__item  m--padding-top-5 m--padding-bottom-5 m--padding-right-10 m--padding-left-10">
                                                                    <div class="m-widget4__img m-widget4__img--icon">
                                                                        <i class="fa fa-check"></i>
                                                                    </div>
                                                                    <div class="m-widget4__info">
                                                                            <span class="m-widget4__text">
                                                                                @if(count($informationItem->data) > 1)
                                                                                    {{ $informationItemData->name }}
                                                                                @else
                                                                                    {{ $informationItem->title }}: {{ $informationItemData->name }}
                                                                                @endif
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endforeach

                                                    </div>
                                                    <!--end::Widget 9-->
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{--خدمات اضافی--}}
                                @if(optional(optional($product->attributes)->get('extra'))->count())
                                    <div class="m-portlet  m-portlet--creative m-portlet--bordered-semi">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption col">
                                                <div class="m-portlet__head-title">
                                                                    <span class="m-portlet__head-icon">
                                                                        <i class="flaticon-confetti"></i>
                                                                    </span>
                                                    <h3 class="m-portlet__head-text">
                                                        خدماتی که برای این محصول نیاز دارید را انتخاب کنید:
                                                    </h3>
                                                    <h2 class="m-portlet__head-label m-portlet__head-label--warning">
                                                        <span>خدمات</span>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">

                                            @include("product.partials.extraSelectCollection")
                                            @include("product.partials.extraCheckboxCollection" , ["withExtraCost"])

                                        </div>
                                    </div>
                                @endif

                                {{--محصول ساده یا قابل پیکربندی و یا قابل انتخاب--}}
                                @if(in_array($product->type['id'] ,[config("constants.PRODUCT_TYPE_SELECTABLE")]))
                                    <div class="m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi selectChildOfSelectableProductPortlet">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption col">
                                                <div class="m-portlet__head-title">
                                                                <span class="m-portlet__head-icon">
                                                                    <i class="flaticon-multimedia-5"></i>
                                                                </span>
                                                    <h3 class="m-portlet__head-text">
                                                        موارد مورد نظر خود را انتخاب کنید:
                                                    </h3>
                                                    <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                        <span>انتخاب محصول</span>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">

                                            <ul class="m-nav m-nav--active-bg" id="m_nav" role="tablist">
                                                @if(!empty($children))
                                                    @foreach($children as $p)
                                                        @include('product.partials.showChildren',['product' => $p , 'color' => 1, 'childIsPurchased' => (array_search($p->id, $purchasedProductIdArray) !== false)])
                                                    @endforeach
                                                @endif
                                            </ul>

                                        </div>
                                    </div>
                                @elseif(in_array($product->type['id'] ,[config("constants.PRODUCT_TYPE_SIMPLE")]))

                                @elseif(in_array($product->type['id'], [config("constants.PRODUCT_TYPE_CONFIGURABLE")]))
                                    <div class="m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi">
                                        <div class="m-portlet__head">
                                            <div class="m-portlet__head-caption col">
                                                <div class="m-portlet__head-title">
                                                                <span class="m-portlet__head-icon">
                                                                    <i class="flaticon-settings-1"></i>
                                                                </span>
                                                    <h3 class="m-portlet__head-text">
                                                        ویژگی های مورد نظر خود را انتخاب کنید:
                                                    </h3>
                                                    <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                                        <span>ویژگی های محصول</span>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">

                                            @if(optional(optional(optional($product->attributes)->get('main'))->where('type', 'main'))->count()>0)

                                                @if($product->attributes->get('main')->where('type', 'main')->where('control', 'dropDown')->count()>0)
                                                    @foreach($product->attributes->get('main')->where('type', 'main')->where('control', 'dropDown') as $index => $select)

                                                        <div class="form-group m-form__group">
                                                            <label for="exampleSelect1">{{ $select->title }}</label>
                                                            <select name="attribute[]" class="form-control m-input attribute">
                                                                @foreach($select->data as $dropdownIndex => $dropdownOption)
                                                                    <option value="{{ $dropdownOption->id }}">{{ $dropdownOption->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    @endforeach
                                                @endif

                                                @if($product->attributes->get('main')->where('type', 'main')->where('control', 'checkBox')->count()>0)
                                                    @foreach($product->attributes->get('main')->where('type', 'main')->where('control', 'checkBox') as $index => $select)
                                                        @foreach($select->data as $selectData)
                                                            <label class="m-checkbox m-checkbox--air m-checkbox--state-success">
                                                                <input type="checkbox" name="attribute[]" value="{{ $selectData->id }}" class="attribute">
                                                                {{ $selectData->name }}
                                                                <span></span>
                                                            </label>
                                                        @endforeach
                                                    @endforeach
                                                @endif

                                            @endif

                                        </div>
                                    </div>
                                @endif

                                {!! Form::hidden('product_id',$product->id) !!}

                                {{--دکمه افزودن به سبد خرید--}}
                                @if($product->enable && !$isForcedGift)

                                    @if($hasUserPurchasedProduct)
                                        <div class="alert alert-info" role="alert">
                                            <strong>شما این محصول را خریده اید</strong>
                                        </div>
                                    @endif

                                    <h3 class="m--font-danger">
                                        <span id="a_product-price">
                                            @if($product->priceText['discount'] == 0 )
                                                {{ $product->priceText['basePriceText'] }}
                                            @else
                                                قیمت محصول: <strike>{{ $product->priceText['basePriceText'] }} </strike><br>
                                                قیمت با تخفیف
                                                <span class="m-badge m-badge--info m-badge--wide m-badge--rounded" id="a_product-discount">{{ ($product->price['discount']*100/$product->price['base']) }}%</span>
                                                :  {{ $product->priceText['finalPriceText'] }}
                                            @endif
                                        </span>
                                    </h3>

                                    @if($hasUserPurchasedProduct && empty($children))
                                        <a href="{{ action("Web\UserController@userProductFiles") }}?p={{$product->id}}">
                                            <button class="btn m-btn m-btn--pill m-btn--air btn-info animated infinite pulse YouHavePurchasedThisProductMessage">
                                                <i class="fa fa-play-circle"></i>
                                                مشاهده در صفحه فیلم ها و جزوه های من
                                            </button>
                                        </a>
                                    @endif
                                    <button class="btn m-btn--air btn-success m-btn--icon m--margin-bottom-5 btnAddToCart gta-track-add-to-card">
                                        <span>
                                            <i class="fa fa-cart-arrow-down"></i>
                                            <i class="fas fa-sync-alt fa-spin m--hide"></i>
                                            <span>
                                                @if($hasUserPurchasedProduct)
                                                    خرید مجدد
                                                @else
                                                    افزودن به سبد خرید
                                                @endif
                                            </span>
                                        </span>
                                    </button>

                                @else
                                    @if(!$product->enable)
                                        <button class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                                            <span>
                                                <i class="flaticon-shopping-basket"></i>
                                                <span>این محصول غیر فعال است.</span>
                                            </span>
                                        </button>
                                    @elseif($isForcedGift)
                                        @if($hasPurchasedEssentialProduct)
                                            <button class="btn btn-danger btn-lg m-btn  m-btn m-btn--icon">
                                                <span>
                                                    <i class="flaticon-arrows"></i>
                                                    <span>شما محصول راه ابریشم را خریده اید و این محصول به عنوان هدیه به شما تعلق می گیرد</span>
                                                </span>
                                            </button>
                                        @else
                                            <a class="btn btn-focus btn-lg m-btn  m-btn m-btn--icon" href="{{ route('product.show' , $shouldBuyProductId ) }}">
                                                <span>
                                                    <i class="flaticon-arrows"></i>
                                                    <span>این محصول بخشی از {{$shouldBuyProductName}} است برای خرید کلیک کنید </span>
                                                </span>
                                            </a>
                                        @endif
                                    @endif
                                @endif

                            </div>

                            @if( isset($product->introVideo) || (isset($product->gift) && $product->gift->isNotEmpty()))
                                <div class="col-lg-4">

                                    <div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force m--margin-bottom-45 videoPlayerPortlet @if(!isset($product->introVideo)) m--hide @endif">
                                        <div class="m-portlet__body">
                                            <div class="m-widget19 a--nuevo-alaa-theme a--media-parent">
                                                <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides a--video-wraper">

                                                    @if( $product->introVideo )
                                                        <input type="hidden" name="introVideo" value="{{ $product->introVideo }}">
                                                    @endif

                                                    <video id="videoPlayer"
                                                           class="video-js vjs-fluid vjs-default-skin vjs-big-play-centered"
                                                           controls
                                                           {{-- preload="auto"--}}
                                                           preload="none"
                                                           @if(isset($product->introVideoThumbnail))
                                                           poster = "{{$product->introVideoThumbnail}}?w=400&h=225"
                                                           @else
                                                           poster = "https://cdn.alaatv.com/media/204/240p/204054ssnv.jpg"
                                                        @endif >
                                                    </video>

                                                    <div class="m-widget19__shadow"></div>
                                                </div>
                                                <div class="m-widget19__content">
                                                    <div class="m-widget19__header">
                                                        <h4 id="videoPlayerTitle">
                                                            کلیپ معرفی
                                                        </h4>
                                                    </div>
                                                    <div class="m-widget19__body text-left" id="videoPlayerDescription"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-portlet m-portlet--bordered-semi m-portlet--rounded-force videoPlayerPortlet @if(isset($product->introVideo)) m--hide @endif">
                                        <div class="m-portlet__body">
                                            <svg version="1.1" class="a--full-width" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" viewBox="0 0 808 455"><defs><path d="M488.19 100.57L488.87 100.63L489.55 100.72L490.22 100.83L490.88 100.96L491.53 101.11L492.17 101.29L492.8 101.48L493.41 101.7L494.02 101.94L494.61 102.19L495.19 102.47L495.75 102.77L496.3 103.08L496.84 103.41L497.36 103.76L497.86 104.13L498.35 104.51L498.82 104.91L499.27 105.32L499.71 105.75L500.12 106.19L500.52 106.65L500.9 107.12L501.25 107.61L501.59 108.1L501.9 108.61L502.19 109.13L502.46 109.66L502.71 110.21L502.93 110.76L503.13 111.32L503.31 111.89L503.46 112.47L503.58 113.06L503.67 113.66L503.74 114.26L503.79 114.87L503.8 115.49L503.8 360.38L503.79 360.99L503.74 361.6L503.67 362.21L503.58 362.8L503.46 363.39L503.31 363.97L503.13 364.54L502.93 365.11L502.71 365.66L502.46 366.2L502.19 366.73L501.9 367.25L501.59 367.76L501.25 368.26L500.9 368.74L500.52 369.22L500.12 369.67L499.71 370.12L499.27 370.54L498.82 370.96L498.35 371.36L497.86 371.74L497.36 372.11L496.84 372.45L496.3 372.79L495.75 373.1L495.19 373.39L494.61 373.67L494.02 373.93L493.41 374.17L492.8 374.38L492.17 374.58L491.53 374.75L490.88 374.91L490.22 375.04L489.55 375.15L488.87 375.23L488.19 375.29L487.49 375.33L486.79 375.34L486.09 375.33L485.4 375.29L484.71 375.23L484.03 375.15L483.37 375.04L482.71 374.91L482.06 374.75L481.42 374.58L480.79 374.38L480.17 374.17L479.57 373.93L478.98 373.67L478.4 373.39L477.84 373.1L477.29 372.79L476.75 372.45L476.23 372.11L475.73 371.74L475.24 371.36L474.77 370.96L474.31 370.54L473.88 370.12L473.46 369.67L473.07 369.22L472.69 368.74L472.33 368.26L472 367.76L471.68 367.25L471.39 366.73L471.12 366.2L470.88 365.66L470.65 365.11L470.45 364.54L470.28 363.97L470.13 363.39L470.01 362.8L469.91 362.21L469.84 361.6L469.8 360.99L469.79 360.38L469.79 115.49L469.8 114.87L469.84 114.26L469.91 113.66L470.01 113.06L470.13 112.47L470.28 111.89L470.45 111.32L470.65 110.76L470.88 110.21L471.12 109.66L471.39 109.13L471.68 108.61L472 108.1L472.33 107.61L472.69 107.12L473.07 106.65L473.46 106.19L473.88 105.75L474.31 105.32L474.77 104.91L475.24 104.51L475.73 104.13L476.23 103.76L476.75 103.41L477.29 103.08L477.84 102.77L478.4 102.47L478.98 102.19L479.57 101.94L480.17 101.7L480.79 101.48L481.42 101.29L482.06 101.11L482.71 100.96L483.37 100.83L484.03 100.72L484.71 100.63L485.4 100.57L486.09 100.54L486.79 100.52L487.49 100.54L488.19 100.57Z" id="a2rBf4dlXC"/><path d="M487.87 100.55L488.41 100.59L488.94 100.64L489.47 100.71L489.99 100.79L490.51 100.88L491.02 100.99L491.53 101.11L492.03 101.25L492.52 101.4L493.01 101.56L493.49 101.73L493.97 101.92L494.44 102.12L494.9 102.33L495.35 102.56L495.79 102.79L496.23 103.04L496.66 103.3L497.07 103.57L497.48 103.85L497.88 104.14L498.27 104.44L498.65 104.76L499.01 105.08L499.37 105.42L499.71 105.76L500.05 106.11L500.37 106.48L500.68 106.85L500.98 107.23L501.26 107.62L501.53 108.02L501.79 108.43L502.03 108.84L502.26 109.27L502.48 109.7L502.68 110.14L502.86 110.59L626.72 425.21L626.93 425.8L627.12 426.39L627.28 426.98L627.41 427.57L627.51 428.16L627.59 428.75L627.64 429.34L627.66 429.93L627.65 430.52L627.62 431.1L627.56 431.68L627.48 432.26L627.37 432.83L627.24 433.39L627.08 433.95L626.9 434.51L626.7 435.05L626.47 435.59L626.22 436.12L625.95 436.64L625.65 437.15L625.33 437.66L624.99 438.15L624.63 438.63L624.25 439.09L623.84 439.55L623.42 439.99L622.98 440.42L622.51 440.83L622.03 441.23L621.53 441.61L621.01 441.98L620.47 442.33L619.91 442.66L619.34 442.97L618.75 443.27L618.14 443.54L617.51 443.8L616.87 444.03L616.21 444.25L615.55 444.44L614.88 444.6L614.2 444.74L613.53 444.86L612.86 444.95L612.18 445.01L611.51 445.05L610.84 445.07L610.18 445.07L609.51 445.04L608.85 444.99L608.2 444.92L607.55 444.82L606.91 444.71L606.27 444.57L605.64 444.41L605.02 444.23L604.41 444.03L603.8 443.81L603.21 443.56L602.63 443.3L602.06 443.02L601.5 442.72L600.96 442.41L600.43 442.07L599.91 441.71L599.41 441.34L598.92 440.95L598.46 440.54L598 440.12L597.57 439.68L597.15 439.22L596.76 438.75L596.38 438.26L596.02 437.75L595.69 437.23L595.38 436.7L595.09 436.15L594.82 435.58L594.58 435.01L495.3 182.82L495.08 182.3L494.82 181.81L494.53 181.34L494.22 180.9L493.88 180.49L493.52 180.1L493.13 179.74L492.73 179.41L492.3 179.1L491.86 178.82L491.4 178.57L490.92 178.34L490.43 178.14L489.93 177.97L489.43 177.82L488.91 177.7L488.39 177.61L487.86 177.54L487.33 177.5L486.79 177.49L486.26 177.5L485.73 177.54L485.2 177.61L484.68 177.7L484.16 177.82L483.65 177.97L483.15 178.14L482.67 178.34L482.19 178.57L481.73 178.82L481.29 179.1L480.86 179.41L480.45 179.74L480.07 180.1L479.7 180.49L479.37 180.9L479.05 181.34L478.77 181.81L478.51 182.3L478.29 182.82L379.01 435.01L378.77 435.58L378.5 436.15L378.21 436.7L377.9 437.23L377.56 437.76L377.21 438.26L376.83 438.75L376.43 439.22L376.02 439.68L375.58 440.12L375.13 440.55L374.66 440.96L374.17 441.35L373.67 441.72L373.15 442.07L372.62 442.41L372.08 442.73L371.52 443.03L370.95 443.31L370.37 443.57L369.77 443.81L369.17 444.03L368.56 444.23L367.94 444.41L367.31 444.57L366.67 444.71L366.03 444.82L365.38 444.92L364.72 444.99L364.07 445.04L363.4 445.07L362.74 445.07L362.07 445.05L361.4 445.01L360.73 444.95L360.05 444.85L359.38 444.74L358.71 444.6L358.04 444.44L357.38 444.25L356.72 444.03L356.08 443.8L355.45 443.54L354.84 443.27L354.25 442.97L353.68 442.66L353.12 442.33L352.58 441.98L352.06 441.61L351.56 441.23L351.08 440.83L350.61 440.42L350.17 439.99L349.74 439.55L349.34 439.09L348.96 438.63L348.6 438.15L348.26 437.66L347.94 437.15L347.64 436.64L347.37 436.12L347.12 435.59L346.89 435.05L346.69 434.51L346.5 433.95L346.35 433.39L346.22 432.83L346.11 432.26L346.02 431.68L345.97 431.1L345.94 430.52L345.93 429.93L345.95 429.34L346 428.75L346.08 428.16L346.18 427.57L346.31 426.98L346.47 426.39L346.65 425.8L346.87 425.21L470.72 110.59L470.91 110.14L471.11 109.7L471.33 109.27L471.56 108.84L471.8 108.43L472.06 108.02L472.33 107.62L472.61 107.23L472.91 106.85L473.22 106.48L473.54 106.11L473.87 105.76L474.22 105.42L474.57 105.08L474.94 104.76L475.32 104.44L475.71 104.14L476.1 103.85L476.51 103.57L476.93 103.3L477.36 103.04L477.79 102.79L478.24 102.56L478.69 102.33L479.15 102.12L479.62 101.92L480.09 101.73L480.57 101.56L481.06 101.4L481.56 101.25L482.06 101.11L482.57 100.99L483.08 100.88L483.6 100.79L484.12 100.71L484.65 100.64L485.18 100.59L485.71 100.55L486.25 100.53L486.79 100.52L487.34 100.53L487.87 100.55Z" id="e1uwW73gxz"/><path d="M589.81 83.76L590.13 83.79L590.44 83.84L590.75 83.91L591.05 83.98L591.35 84.07L591.63 84.18L591.92 84.29L592.19 84.41L592.46 84.55L592.72 84.7L592.97 84.85L593.21 85.02L593.45 85.2L593.67 85.39L593.88 85.58L594.08 85.79L594.28 86L594.46 86.22L594.62 86.45L594.78 86.69L594.92 86.93L595.05 87.18L595.17 87.44L595.27 87.7L595.36 87.97L595.43 88.25L595.48 88.53L595.53 88.81L595.55 89.1L595.56 89.39L595.56 123.85L595.55 124.14L595.53 124.43L595.48 124.71L595.43 124.99L595.36 125.26L595.27 125.53L595.17 125.8L595.05 126.05L594.92 126.3L594.78 126.55L594.63 126.79L594.46 127.01L594.28 127.24L594.09 127.45L593.89 127.65L593.67 127.85L593.45 128.04L593.22 128.22L592.98 128.38L592.73 128.54L592.47 128.69L592.2 128.82L591.92 128.95L591.64 129.06L591.35 129.16L591.05 129.25L590.75 129.33L590.44 129.39L590.13 129.44L589.81 129.48L589.49 129.5L589.17 129.51L588.84 129.51L588.5 129.49L548.13 126.09L548.13 87.15L588.5 83.75L588.83 83.73L589.16 83.72L589.49 83.73L589.81 83.76Z" id="e1KEE4hPZ0"/><path d="M556.33 64.92L556.7 64.95L557.07 65L557.43 65.06L557.78 65.13L558.13 65.21L558.48 65.3L558.81 65.41L559.15 65.52L559.47 65.65L559.79 65.79L560.1 65.94L560.4 66.1L560.7 66.27L560.99 66.44L561.27 66.63L561.54 66.83L561.8 67.04L562.05 67.25L562.3 67.47L562.53 67.7L562.75 67.94L562.97 68.19L563.17 68.44L563.36 68.7L563.54 68.97L563.71 69.24L563.87 69.52L564.01 69.81L564.15 70.1L564.26 70.4L564.37 70.7L564.47 71.01L564.55 71.32L564.61 71.63L564.66 71.96L564.7 72.28L564.72 72.61L564.73 72.94L564.73 140.29L564.72 140.63L564.7 140.95L564.66 141.28L564.61 141.6L564.55 141.92L564.47 142.23L564.37 142.54L564.26 142.84L564.14 143.14L564.01 143.43L563.87 143.71L563.71 143.99L563.54 144.27L563.36 144.54L563.17 144.8L562.97 145.05L562.75 145.3L562.53 145.53L562.29 145.76L562.05 145.99L561.8 146.2L561.54 146.41L561.27 146.6L560.99 146.79L560.7 146.97L560.4 147.14L560.1 147.3L559.79 147.45L559.47 147.58L559.14 147.71L558.81 147.83L558.47 147.93L558.13 148.03L557.78 148.11L557.43 148.18L557.07 148.24L556.7 148.29L556.33 148.32L555.96 148.34L555.58 148.35L418 148.35L417.62 148.34L417.24 148.32L416.88 148.29L416.51 148.24L416.15 148.18L415.8 148.11L415.45 148.03L415.1 147.93L414.77 147.83L414.43 147.71L414.11 147.58L413.79 147.45L413.48 147.3L413.18 147.14L412.88 146.97L412.59 146.79L412.31 146.6L412.04 146.41L411.78 146.2L411.53 145.99L411.28 145.76L411.05 145.53L410.83 145.3L410.61 145.05L410.41 144.8L410.22 144.54L410.04 144.27L409.87 143.99L409.71 143.71L409.57 143.43L409.43 143.14L409.31 142.84L409.21 142.54L409.11 142.23L409.03 141.92L408.97 141.6L408.92 141.28L408.88 140.95L408.86 140.63L408.85 140.29L408.85 72.94L408.86 72.61L408.88 72.28L408.92 71.96L408.97 71.63L409.03 71.32L409.11 71.01L409.21 70.7L409.31 70.4L409.43 70.1L409.57 69.81L409.71 69.52L409.87 69.24L410.04 68.97L410.22 68.7L410.41 68.44L410.61 68.19L410.83 67.94L411.05 67.7L411.28 67.47L411.53 67.25L411.78 67.04L412.04 66.83L412.31 66.63L412.59 66.44L412.88 66.27L413.18 66.1L413.48 65.94L413.79 65.79L414.11 65.65L414.44 65.52L414.77 65.41L415.1 65.3L415.45 65.21L415.8 65.13L416.15 65.06L416.51 65L416.88 64.95L417.25 64.92L417.62 64.9L418 64.89L555.58 64.89L555.96 64.9L556.33 64.92Z" id="a1yuRFhUeD"/><path d="M461.49 13.75L463.07 13.89L464.64 14.08L466.18 14.34L467.71 14.64L469.21 14.99L470.68 15.4L472.14 15.85L473.56 16.35L474.96 16.9L476.33 17.5L477.66 18.14L478.97 18.82L480.24 19.55L481.48 20.32L482.68 21.12L483.85 21.97L484.98 22.86L486.06 23.78L487.11 24.74L488.12 25.73L489.08 26.75L490 27.81L490.87 28.9L491.7 30.02L492.47 31.17L493.2 32.35L493.88 33.55L494.5 34.78L495.07 36.03L495.59 37.31L496.05 38.61L496.45 39.93L496.8 41.27L497.08 42.63L497.31 44.01L497.47 45.4L497.57 46.81L497.6 48.24L497.57 49.66L497.47 51.07L497.31 52.46L497.08 53.84L496.8 55.2L496.45 56.54L496.05 57.86L495.59 59.16L495.07 60.44L494.5 61.69L493.88 62.92L493.2 64.13L492.47 65.3L491.7 66.45L490.87 67.57L490 68.66L489.08 69.72L488.12 70.74L487.11 71.74L486.06 72.69L484.98 73.62L483.85 74.5L482.68 75.35L481.48 76.16L480.24 76.92L478.97 77.65L477.66 78.33L476.33 78.97L474.96 79.57L473.56 80.12L472.14 80.62L470.68 81.07L469.21 81.48L467.71 81.83L466.18 82.14L464.64 82.39L463.07 82.58L461.49 82.73L459.88 82.81L458.27 82.84L456.65 82.81L455.04 82.73L453.46 82.58L451.89 82.39L450.35 82.14L448.83 81.83L447.32 81.48L445.85 81.07L444.4 80.62L442.97 80.12L441.57 79.57L440.21 78.97L438.87 78.33L437.56 77.65L436.29 76.92L435.05 76.16L433.85 75.35L432.68 74.5L431.56 73.62L430.47 72.69L429.42 71.74L428.41 70.74L427.45 69.72L426.53 68.66L425.66 67.57L424.84 66.45L424.06 65.3L423.33 64.13L422.65 62.92L422.03 61.69L421.46 60.44L420.94 59.16L420.48 57.86L420.08 56.54L419.73 55.2L419.45 53.84L419.23 52.46L419.06 51.07L418.97 49.66L418.93 48.24L418.97 46.81L419.06 45.4L419.23 44.01L419.45 42.63L419.73 41.27L420.08 39.93L420.48 38.61L420.94 37.31L421.46 36.03L422.03 34.78L422.65 33.55L423.33 32.35L424.06 31.17L424.84 30.02L425.66 28.9L426.53 27.81L427.45 26.75L428.41 25.73L429.42 24.74L430.47 23.78L431.56 22.86L432.68 21.97L433.85 21.12L435.05 20.32L436.29 19.55L437.56 18.82L438.87 18.14L440.21 17.5L441.57 16.9L442.97 16.35L444.4 15.85L445.85 15.4L447.32 14.99L448.83 14.64L450.35 14.34L451.89 14.08L453.46 13.89L455.04 13.75L456.65 13.66L458.27 13.63L459.88 13.66L461.49 13.75ZM455.47 35.53L454.14 35.81L452.86 36.2L451.63 36.69L450.47 37.27L449.37 37.93L448.35 38.68L447.41 39.51L446.56 40.41L445.8 41.37L445.14 42.4L444.59 43.48L444.14 44.61L443.82 45.78L443.62 46.99L443.56 48.24L443.62 49.48L443.82 50.69L444.14 51.87L444.59 52.99L445.14 54.07L445.8 55.1L446.56 56.06L447.41 56.96L448.35 57.79L449.37 58.54L450.47 59.21L451.63 59.79L452.86 60.27L454.14 60.66L455.47 60.95L456.85 61.12L458.27 61.18L459.68 61.12L461.06 60.95L462.39 60.66L463.67 60.27L464.9 59.79L466.07 59.21L467.16 58.54L468.18 57.79L469.12 56.96L469.97 56.06L470.73 55.1L471.39 54.07L471.95 52.99L472.39 51.87L472.71 50.69L472.91 49.48L472.98 48.24L472.91 46.99L472.71 45.78L472.39 44.61L471.95 43.48L471.39 42.4L470.73 41.37L469.97 40.41L469.12 39.51L468.18 38.68L467.16 37.93L466.07 37.27L464.9 36.69L463.67 36.2L462.39 35.81L461.06 35.53L459.68 35.35L458.27 35.29L456.85 35.35L455.47 35.53Z" id="b3Kw8SlMC3"/><path d="M515.53 13.75L517.11 13.89L518.68 14.08L520.23 14.34L521.75 14.64L523.25 14.99L524.73 15.4L526.18 15.85L527.6 16.35L529 16.9L530.37 17.5L531.71 18.14L533.01 18.82L534.28 19.55L535.52 20.32L536.73 21.12L537.89 21.97L539.02 22.86L540.11 23.78L541.16 24.74L542.16 25.73L543.12 26.75L544.04 27.81L544.91 28.9L545.74 30.02L546.52 31.17L547.24 32.35L547.92 33.55L548.54 34.78L549.12 36.03L549.63 37.31L550.09 38.61L550.5 39.93L550.84 41.27L551.12 42.63L551.35 44.01L551.51 45.4L551.61 46.81L551.64 48.24L551.61 49.66L551.51 51.07L551.35 52.46L551.12 53.84L550.84 55.2L550.5 56.54L550.09 57.86L549.63 59.16L549.12 60.44L548.54 61.69L547.92 62.92L547.24 64.13L546.52 65.3L545.74 66.45L544.91 67.57L544.04 68.66L543.12 69.72L542.16 70.74L541.16 71.74L540.11 72.69L539.02 73.62L537.89 74.5L536.73 75.35L535.52 76.16L534.28 76.92L533.01 77.65L531.71 78.33L530.37 78.97L529 79.57L527.6 80.12L526.18 80.62L524.73 81.07L523.25 81.48L521.75 81.83L520.23 82.14L518.68 82.39L517.11 82.58L515.53 82.73L513.93 82.81L512.31 82.84L510.69 82.81L509.09 82.73L507.5 82.58L505.94 82.39L504.39 82.14L502.87 81.83L501.37 81.48L499.89 81.07L498.44 80.62L497.01 80.12L495.62 79.57L494.25 78.97L492.91 78.33L491.61 77.65L490.33 76.92L489.09 76.16L487.89 75.35L486.73 74.5L485.6 73.62L484.51 72.69L483.46 71.74L482.46 70.74L481.49 69.72L480.58 68.66L479.7 67.57L478.88 66.45L478.1 65.3L477.37 64.13L476.7 62.92L476.07 61.69L475.5 60.44L474.99 59.16L474.52 57.86L474.12 56.54L473.78 55.2L473.49 53.84L473.27 52.46L473.11 51.07L473.01 49.66L472.98 48.24L473.01 46.81L473.11 45.4L473.27 44.01L473.49 42.63L473.78 41.27L474.12 39.93L474.52 38.61L474.99 37.31L475.5 36.03L476.07 34.78L476.7 33.55L477.37 32.35L478.1 31.17L478.88 30.02L479.7 28.9L480.58 27.81L481.49 26.75L482.46 25.73L483.46 24.74L484.51 23.78L485.6 22.86L486.73 21.97L487.89 21.12L489.09 20.32L490.33 19.55L491.61 18.82L492.91 18.14L494.25 17.5L495.62 16.9L497.01 16.35L498.44 15.85L499.89 15.4L501.37 14.99L502.87 14.64L504.39 14.34L505.94 14.08L507.5 13.89L509.09 13.75L510.69 13.66L512.31 13.63L513.93 13.66L515.53 13.75ZM509.52 35.53L508.18 35.81L506.9 36.2L505.67 36.69L504.51 37.27L503.41 37.93L502.39 38.68L501.45 39.51L500.6 40.41L499.84 41.37L499.18 42.4L498.63 43.48L498.19 44.61L497.86 45.78L497.67 46.99L497.6 48.24L497.67 49.48L497.86 50.69L498.19 51.87L498.63 52.99L499.18 54.07L499.84 55.1L500.6 56.06L501.45 56.96L502.39 57.79L503.41 58.54L504.51 59.21L505.67 59.79L506.9 60.27L508.18 60.66L509.52 60.95L510.89 61.12L512.31 61.18L513.72 61.12L515.1 60.95L516.43 60.66L517.72 60.27L518.94 59.79L520.11 59.21L521.2 58.54L522.22 57.79L523.16 56.96L524.02 56.06L524.77 55.1L525.43 54.07L525.99 52.99L526.43 51.87L526.75 50.69L526.95 49.48L527.02 48.24L526.95 46.99L526.75 45.78L526.43 44.61L525.99 43.48L525.43 42.4L524.77 41.37L524.02 40.41L523.16 39.51L522.22 38.68L521.2 37.93L520.11 37.27L518.94 36.69L517.72 36.2L516.43 35.81L515.1 35.53L513.72 35.35L512.31 35.29L510.89 35.35L509.52 35.53Z" id="bi1wkj7GV"/><path d="M259.73 90.64L260.99 90.74L262.25 90.88L263.5 91.06L264.75 91.29L266 91.56L267.24 91.87L268.46 92.23L269.68 92.64L270.88 93.09L272.07 93.58L273.25 94.12L274.41 94.71L275.55 95.34L324.04 123.51L325.15 124.19L326.22 124.89L327.25 125.63L328.23 126.4L329.18 127.2L330.08 128.02L330.94 128.87L331.75 129.75L332.52 130.65L333.25 131.57L333.93 132.52L334.57 133.48L335.17 134.47L335.72 135.47L336.23 136.48L336.69 137.51L337.1 138.56L337.47 139.62L337.79 140.68L338.07 141.76L338.29 142.85L338.48 143.94L338.61 145.04L338.69 146.15L338.73 147.25L338.72 148.36L338.66 149.47L338.55 150.58L338.4 151.69L338.19 152.8L337.93 153.9L337.62 154.99L337.27 156.08L336.86 157.16L336.4 158.23L335.88 159.29L335.32 160.33L334.71 161.37L334.04 162.39L333.32 163.39L241.05 286.36L213.35 268.29L213.39 268.36L213.51 268.55L213.7 268.86L213.96 269.29L214.29 269.83L214.69 270.47L215.14 271.2L215.65 272.02L216.2 272.92L216.81 273.9L217.45 274.94L218.14 276.04L218.85 277.2L219.6 278.41L220.37 279.65L221.16 280.93L221.97 282.24L222.79 283.57L223.62 284.91L224.46 286.26L225.29 287.6L226.12 288.95L226.95 290.27L227.76 291.58L228.55 292.86L229.32 294.11L230.07 295.31L230.79 296.47L231.47 297.58L232.12 298.62L232.73 299.6L233.29 300.5L233.79 301.32L234.25 302.06L234.65 302.7L234.98 303.24L235.25 303.67L235.44 303.98L235.6 304.24L235.82 304.61L236.03 304.97L236.23 305.34L236.42 305.71L236.61 306.09L236.79 306.47L236.95 306.84L237.11 307.23L237.27 307.61L237.41 307.99L237.55 308.38L237.68 308.77L237.8 309.16L237.91 309.55L238.01 309.95L238.11 310.34L238.2 310.74L238.28 311.14L238.35 311.54L238.41 311.94L238.47 312.34L238.52 312.74L238.56 313.14L238.59 313.54L238.61 313.95L238.62 314.35L238.63 314.76L238.63 315.16L238.62 315.57L238.6 315.97L238.57 316.38L238.53 316.78L238.49 317.19L238.44 317.59L238.37 318L238.31 318.4L238.23 318.8L238.14 319.2L238.05 319.6L237.94 320L208.98 427.79L208.71 428.7L208.41 429.59L208.06 430.47L207.68 431.32L207.26 432.16L206.8 432.97L206.31 433.76L205.79 434.54L205.23 435.28L204.64 436.01L204.02 436.71L203.37 437.39L202.7 438.05L201.99 438.67L201.26 439.28L200.51 439.85L199.73 440.4L198.92 440.93L198.1 441.42L197.25 441.89L196.38 442.32L195.5 442.73L194.6 443.1L193.68 443.45L192.74 443.76L191.79 444.04L190.82 444.29L189.85 444.51L188.86 444.69L187.86 444.84L186.85 444.95L185.83 445.03L184.8 445.07L183.77 445.07L182.73 445.04L181.69 444.96L180.65 444.85L179.6 444.71L178.55 444.52L177.5 444.29L176.5 444.03L175.53 443.74L174.58 443.42L173.65 443.07L172.74 442.69L171.86 442.27L171 441.83L170.17 441.36L169.36 440.86L168.58 440.34L167.82 439.79L167.09 439.21L166.39 438.62L165.71 438L165.07 437.36L164.45 436.69L163.86 436.01L163.3 435.31L162.77 434.59L162.27 433.85L161.8 433.1L161.36 432.33L160.96 431.55L160.59 430.75L160.25 429.94L159.94 429.12L159.67 428.29L159.43 427.45L159.23 426.6L159.07 425.74L158.94 424.87L158.85 424L158.79 423.12L158.77 422.24L158.79 421.35L158.85 420.46L158.95 419.57L159.09 418.67L159.27 417.78L159.49 416.89L186.07 317.97L186.07 317.97L186.07 317.96L186.07 317.95L186.07 317.95L186.07 317.94L186.06 317.93L149.17 247.8L148.67 246.8L148.19 245.79L147.75 244.78L147.33 243.76L146.95 242.73L146.59 241.7L146.27 240.66L145.98 239.62L145.72 238.57L145.49 237.52L145.29 236.47L145.12 235.41L144.99 234.35L144.88 233.29L144.8 232.23L144.76 231.17L144.74 230.11L144.76 229.05L144.8 227.99L144.88 226.93L144.98 225.87L145.12 224.82L145.28 223.77L145.48 222.72L145.71 221.67L145.96 220.63L146.25 219.6L146.56 218.57L146.91 217.55L147.28 216.53L147.69 215.53L148.13 214.52L148.59 213.53L149.08 212.55L149.61 211.57L150.16 210.61L150.75 209.65L151.36 208.71L152 207.78L152.67 206.86L230.22 103.51L230.99 102.53L231.79 101.59L232.63 100.68L233.5 99.82L234.41 98.99L235.35 98.2L236.31 97.44L237.31 96.72L238.33 96.04L239.38 95.4L240.46 94.8L241.55 94.24L242.67 93.71L243.81 93.23L244.96 92.79L246.13 92.38L247.32 92.02L248.52 91.69L249.74 91.41L250.96 91.17L252.2 90.97L253.44 90.81L254.69 90.69L255.95 90.61L257.2 90.58L258.47 90.59L259.73 90.64Z" id="eeKxtzTXh"/><path d="M206.04 208.39L207.01 208.47L207.99 208.57L208.96 208.71L209.92 208.89L210.88 209.09L211.83 209.33L212.78 209.6L213.71 209.91L214.63 210.25L215.54 210.62L216.44 211.03L217.32 211.47L218.19 211.94L219.04 212.45L219.87 212.99L220.68 213.56L221.48 214.17L311.83 286.3L312.06 286.49L312.29 286.68L312.52 286.87L312.74 287.06L312.96 287.26L313.18 287.46L313.39 287.66L313.6 287.86L313.81 288.06L314.01 288.27L314.22 288.48L314.42 288.69L314.61 288.9L314.81 289.12L315 289.34L315.18 289.56L315.37 289.78L315.55 290L315.73 290.23L315.9 290.45L316.07 290.68L316.24 290.91L316.41 291.15L316.57 291.38L316.73 291.62L316.88 291.85L317.03 292.09L317.18 292.33L317.33 292.58L317.47 292.82L317.61 293.07L317.75 293.32L317.88 293.56L318.01 293.82L318.13 294.07L318.25 294.32L318.37 294.58L318.49 294.83L318.6 295.09L318.71 295.35L367.47 415.05L367.8 415.93L368.09 416.81L368.34 417.69L368.55 418.58L368.71 419.46L368.84 420.35L368.92 421.23L368.96 422.11L368.96 422.99L368.93 423.87L368.85 424.74L368.74 425.6L368.59 426.46L368.4 427.31L368.18 428.16L367.91 428.99L367.62 429.81L367.29 430.62L366.92 431.42L366.52 432.21L366.08 432.98L365.61 433.74L365.11 434.48L364.58 435.2L364.02 435.91L363.42 436.6L362.79 437.26L362.13 437.91L361.45 438.54L360.73 439.14L359.98 439.72L359.21 440.28L358.41 440.81L357.58 441.32L356.72 441.8L355.84 442.25L354.93 442.67L354 443.06L353.04 443.42L352.06 443.75L351.06 444.05L350.06 444.3L349.05 444.52L348.04 444.71L347.04 444.85L346.03 444.96L345.02 445.03L344.02 445.07L343.02 445.07L342.02 445.04L341.03 444.97L340.05 444.87L339.07 444.74L338.1 444.57L337.15 444.38L336.2 444.14L335.26 443.88L334.34 443.59L333.43 443.27L332.54 442.91L331.66 442.53L330.81 442.12L329.96 441.67L329.14 441.21L328.34 440.71L327.56 440.18L326.8 439.63L326.06 439.05L325.35 438.45L324.67 437.82L324.01 437.16L323.38 436.48L322.77 435.77L322.2 435.05L321.66 434.29L321.15 433.52L320.67 432.72L320.22 431.9L319.81 431.06L319.44 430.2L272.83 315.78L187.19 247.41L186.43 246.78L185.7 246.12L185.01 245.44L184.35 244.75L183.73 244.03L183.15 243.3L182.6 242.56L182.1 241.8L181.62 241.02L181.19 240.23L180.79 239.43L180.42 238.62L180.1 237.8L179.81 236.97L179.56 236.14L179.34 235.3L179.17 234.45L179.02 233.59L178.92 232.74L178.86 231.88L178.83 231.02L178.83 230.15L178.88 229.29L178.96 228.43L179.09 227.57L179.24 226.72L179.44 225.87L179.67 225.03L179.95 224.19L180.26 223.36L180.6 222.54L180.99 221.73L181.41 220.93L181.87 220.14L182.37 219.36L182.91 218.6L183.49 217.85L184.1 217.12L184.75 216.4L185.44 215.71L186.16 215.03L186.91 214.39L187.68 213.78L188.47 213.21L189.28 212.66L190.11 212.15L190.96 211.67L191.82 211.22L192.7 210.8L193.6 210.42L194.51 210.07L195.43 209.75L196.36 209.46L197.3 209.21L198.25 208.99L199.21 208.8L200.18 208.64L201.15 208.52L202.12 208.43L203.1 208.37L204.08 208.34L205.06 208.35L206.04 208.39Z" id="d6NQaEe4mi"/><path d="M259.73 90.64L260.99 90.74L262.25 90.88L263.5 91.06L264.75 91.29L266 91.56L267.24 91.87L268.46 92.23L269.68 92.64L270.88 93.09L272.07 93.58L273.25 94.12L274.41 94.71L275.55 95.34L276.41 95.84L277.33 96.38L278.29 96.94L279.31 97.53L280.37 98.14L281.46 98.78L282.6 99.44L283.78 100.12L284.99 100.83L286.23 101.55L287.49 102.28L288.78 103.03L290.1 103.8L291.43 104.57L295.53 106.95L296.91 107.75L298.3 108.56L299.7 109.37L301.09 110.18L302.48 110.99L303.87 111.8L305.25 112.6L306.62 113.39L307.98 114.18L309.32 114.96L310.64 115.73L311.94 116.48L313.22 117.22L314.47 117.95L315.69 118.66L316.87 119.35L318.02 120.02L319.14 120.66L320.21 121.29L321.24 121.89L322.22 122.46L323.16 123L324.04 123.51L325.15 124.19L326.22 124.89L327.25 125.63L328.23 126.4L329.18 127.2L330.08 128.02L330.94 128.87L331.75 129.75L332.52 130.65L333.25 131.57L333.93 132.52L334.57 133.48L335.17 134.46L335.72 135.46L336.23 136.48L336.69 137.51L337.1 138.55L337.47 139.61L337.79 140.68L338.07 141.76L338.29 142.84L338.48 143.94L338.61 145.04L338.69 146.14L338.73 147.25L338.72 148.36L338.66 149.47L338.55 150.58L338.4 151.69L338.19 152.79L337.93 153.89L337.62 154.98L337.27 156.07L336.86 157.15L336.4 158.22L335.88 159.28L335.32 160.33L334.71 161.36L334.04 162.38L333.32 163.38L284.04 229.06L267.32 251.35L266.2 252.77L265.03 254.14L263.81 255.46L262.53 256.72L261.21 257.93L259.85 259.09L258.44 260.19L256.99 261.23L255.49 262.22L253.97 263.16L252.4 264.04L250.8 264.86L249.18 265.62L247.52 266.33L245.84 266.97L244.13 267.56L242.4 268.1L240.65 268.57L238.88 268.98L237.09 269.33L235.29 269.63L233.48 269.86L231.66 270.03L229.83 270.14L227.99 270.19L226.16 270.17L224.32 270.1L222.48 269.96L220.64 269.76L218.81 269.49L216.99 269.16L215.18 268.76L213.37 268.31L211.59 267.78L209.81 267.19L208.06 266.53L206.32 265.81L204.61 265.02L202.92 264.17L201.26 263.24L147.18 231.83L147.11 231.79L147.04 231.75L146.97 231.71L146.9 231.67L146.84 231.62L146.77 231.58L146.7 231.54L146.63 231.49L146.57 231.45L146.5 231.4L146.44 231.36L146.37 231.31L146.31 231.27L146.24 231.22L146.18 231.18L146.12 231.13L146.06 231.08L145.99 231.04L145.93 230.99L145.87 230.94L145.81 230.89L145.75 230.84L145.69 230.79L145.63 230.74L145.57 230.69L145.51 230.64L145.46 230.59L145.4 230.54L145.34 230.49L145.29 230.44L145.23 230.39L145.18 230.34L145.12 230.29L145.07 230.23L145.01 230.18L144.96 230.13L144.91 230.07L144.86 230.02L144.8 229.97L144.75 229.91L144.76 229.31L144.78 228.7L144.8 228.1L144.84 227.49L144.89 226.89L144.95 226.29L145.01 225.68L145.09 225.08L145.18 224.48L145.27 223.88L145.38 223.28L145.49 222.69L145.62 222.09L145.75 221.5L145.9 220.9L146.05 220.31L146.22 219.72L146.39 219.14L146.58 218.55L146.77 217.97L146.97 217.38L147.18 216.8L147.41 216.23L147.64 215.65L147.88 215.08L148.13 214.51L148.39 213.94L148.67 213.38L148.95 212.82L149.24 212.26L149.54 211.7L149.85 211.15L150.17 210.6L150.49 210.06L150.83 209.52L151.18 208.98L151.54 208.44L151.91 207.91L152.28 207.38L152.67 206.86L230.22 103.51L230.99 102.53L231.79 101.59L232.63 100.68L233.51 99.82L234.41 98.99L235.35 98.2L236.32 97.44L237.31 96.72L238.34 96.04L239.38 95.4L240.46 94.8L241.55 94.24L242.67 93.71L243.81 93.23L244.96 92.79L246.14 92.38L247.32 92.02L248.52 91.69L249.74 91.41L250.96 91.17L252.2 90.97L253.44 90.81L254.69 90.69L255.95 90.61L257.2 90.58L258.47 90.59L259.73 90.64Z" id="jj2K3ykM9"/><path d="M347 22.8L348.95 22.97L350.87 23.21L352.77 23.52L354.65 23.89L356.49 24.33L358.31 24.82L360.1 25.38L361.85 26L363.56 26.67L365.25 27.4L366.89 28.19L368.49 29.03L370.06 29.92L371.58 30.86L373.06 31.85L374.49 32.89L375.87 33.98L377.21 35.11L378.5 36.29L379.73 37.51L380.92 38.77L382.04 40.07L383.11 41.41L384.13 42.78L385.08 44.19L385.97 45.64L386.8 47.12L387.57 48.63L388.27 50.17L388.9 51.74L389.47 53.34L389.96 54.96L390.39 56.61L390.74 58.29L391.01 59.98L391.21 61.7L391.33 63.43L391.37 65.18L391.33 66.94L391.21 68.67L391.01 70.39L390.74 72.08L390.39 73.76L389.96 75.4L389.47 77.03L388.9 78.63L388.27 80.2L387.57 81.74L386.8 83.25L385.97 84.73L385.08 86.17L384.13 87.59L383.11 88.96L382.04 90.3L380.92 91.6L379.73 92.86L378.5 94.08L377.21 95.26L375.87 96.39L374.49 97.48L373.06 98.52L371.58 99.51L370.06 100.45L368.49 101.34L366.89 102.18L365.25 102.97L363.56 103.7L361.85 104.37L360.1 104.99L358.31 105.54L356.49 106.04L354.65 106.48L352.77 106.85L350.87 107.16L348.95 107.4L347 107.57L345.02 107.68L343.03 107.71L341.04 107.68L339.07 107.57L337.12 107.4L335.19 107.16L333.29 106.85L331.42 106.48L329.57 106.04L327.75 105.54L325.97 104.99L324.22 104.37L322.5 103.7L320.82 102.97L319.17 102.18L317.57 101.34L316.01 100.45L314.49 99.51L313.01 98.52L311.57 97.48L310.19 96.39L308.85 95.26L307.57 94.08L306.33 92.86L305.15 91.6L304.02 90.3L302.95 88.96L301.94 87.59L300.98 86.17L300.09 84.73L299.26 83.25L298.49 81.74L297.79 80.2L297.16 78.63L296.59 77.03L296.1 75.4L295.68 73.76L295.33 72.08L295.05 70.39L294.85 68.67L294.73 66.94L294.69 65.18L294.73 63.43L294.85 61.7L295.05 59.98L295.33 58.29L295.68 56.61L296.1 54.96L296.59 53.34L297.16 51.74L297.79 50.17L298.49 48.63L299.26 47.12L300.09 45.64L300.98 44.19L301.94 42.78L302.95 41.41L304.02 40.07L305.15 38.77L306.33 37.51L307.57 36.29L308.85 35.11L310.19 33.98L311.57 32.89L313.01 31.85L314.49 30.86L316.01 29.92L317.57 29.03L319.17 28.19L320.82 27.4L322.5 26.67L324.22 26L325.97 25.38L327.75 24.82L329.57 24.33L331.42 23.89L333.29 23.52L335.19 23.21L337.12 22.97L339.07 22.8L341.04 22.69L343.03 22.66L345.02 22.69L347 22.8Z" id="b1X9AV01Ha"/><path d="M282.79 114.55L283.63 114.61L284.46 114.7L285.3 114.82L286.13 114.97L286.95 115.15L287.77 115.35L288.59 115.59L289.39 115.85L290.18 116.14L290.97 116.47L291.74 116.82L292.5 117.2L293.25 117.61L293.99 118.05L294.71 118.52L295.41 119.01L375.98 178.52L456.08 208.92L456.9 209.25L457.7 209.6L458.47 209.98L459.23 210.39L459.95 210.82L460.66 211.27L461.34 211.74L461.99 212.23L462.62 212.75L463.22 213.28L463.8 213.83L464.35 214.4L464.87 214.99L465.37 215.59L465.84 216.21L466.28 216.84L466.69 217.48L467.07 218.14L467.43 218.81L467.75 219.5L468.05 220.19L468.31 220.89L468.55 221.6L468.75 222.32L468.93 223.05L469.07 223.78L469.18 224.52L469.25 225.26L469.3 226.01L469.31 226.76L469.28 227.51L469.23 228.26L469.14 229.01L469.01 229.77L468.85 230.52L468.65 231.27L468.42 232.02L468.16 232.76L467.85 233.51L467.51 234.24L467.14 234.96L466.73 235.67L466.3 236.35L465.84 237.01L465.35 237.66L464.84 238.28L464.3 238.87L463.74 239.45L463.15 240L462.55 240.53L461.92 241.04L461.27 241.53L460.6 241.99L459.92 242.42L459.22 242.83L458.5 243.22L457.76 243.58L457.01 243.92L456.25 244.23L455.48 244.52L454.69 244.78L453.89 245.01L453.08 245.22L452.26 245.4L451.44 245.55L450.61 245.67L449.77 245.77L448.93 245.83L448.08 245.87L447.23 245.88L446.37 245.86L445.52 245.81L444.66 245.73L443.8 245.62L442.95 245.48L442.1 245.31L441.25 245.1L440.4 244.87L439.56 244.6L438.73 244.3L355.69 212.78L355.54 212.72L355.4 212.67L355.25 212.61L355.11 212.55L354.96 212.49L354.82 212.43L354.68 212.37L354.53 212.31L354.39 212.24L354.25 212.18L354.11 212.11L353.97 212.05L353.83 211.98L353.69 211.91L353.55 211.84L353.41 211.77L353.27 211.7L353.14 211.63L353 211.56L352.86 211.49L352.73 211.41L352.6 211.34L352.46 211.26L352.33 211.19L352.2 211.11L352.06 211.03L351.93 210.95L351.8 210.87L351.67 210.79L351.54 210.71L351.41 210.63L351.29 210.54L351.16 210.46L351.03 210.38L350.91 210.29L350.78 210.2L350.66 210.12L350.53 210.03L350.41 209.94L350.29 209.85L267.25 148.53L266.57 148.01L265.92 147.47L265.3 146.91L264.72 146.33L264.16 145.74L263.63 145.13L263.13 144.5L262.67 143.87L262.23 143.21L261.83 142.55L261.46 141.88L261.12 141.19L260.8 140.5L260.53 139.8L260.28 139.09L260.06 138.37L259.88 137.65L259.72 136.92L259.6 136.19L259.51 135.45L259.46 134.71L259.43 133.97L259.44 133.23L259.48 132.49L259.55 131.75L259.65 131.02L259.79 130.28L259.96 129.55L260.16 128.83L260.4 128.1L260.66 127.39L260.96 126.68L261.3 125.98L261.66 125.29L262.06 124.61L262.49 123.94L262.96 123.28L263.46 122.64L263.99 122.01L264.56 121.39L265.15 120.79L265.77 120.22L266.41 119.67L267.06 119.15L267.74 118.66L268.43 118.2L269.14 117.76L269.86 117.35L270.6 116.97L271.36 116.62L272.12 116.29L272.9 115.99L273.69 115.71L274.49 115.47L275.29 115.25L276.11 115.06L276.93 114.9L277.76 114.76L278.59 114.66L279.43 114.58L280.26 114.53L281.1 114.51L281.95 114.51L282.79 114.55Z" id="a49WyokNvr"/><path d="M282.79 114.55L283.63 114.61L284.46 114.7L285.3 114.82L286.13 114.97L286.95 115.15L287.77 115.35L288.59 115.59L289.39 115.85L290.18 116.15L290.97 116.47L291.74 116.82L292.5 117.2L293.25 117.61L293.99 118.05L294.71 118.52L295.41 119.02L338.68 150.97L313.83 182.93L312.75 182.13L311.65 181.32L310.55 180.5L309.43 179.68L308.3 178.84L307.15 178L306 177.15L304.84 176.29L303.68 175.43L302.5 174.56L301.32 173.69L300.13 172.81L298.94 171.93L297.74 171.05L296.54 170.16L295.33 169.27L294.13 168.38L292.92 167.49L291.71 166.59L290.5 165.7L289.28 164.8L288.07 163.91L286.87 163.02L284.46 161.24L283.26 160.35L282.06 159.47L280.87 158.59L279.69 157.72L278.51 156.85L277.34 155.98L276.18 155.12L275.03 154.27L273.88 153.43L272.75 152.59L271.62 151.76L270.51 150.94L269.41 150.13L268.33 149.33L267.25 148.53L266.57 148.01L265.92 147.47L265.3 146.91L264.72 146.33L264.16 145.74L263.63 145.13L263.13 144.5L262.67 143.86L262.23 143.21L261.83 142.55L261.46 141.88L261.12 141.19L260.8 140.5L260.53 139.8L260.28 139.09L260.06 138.37L259.88 137.65L259.72 136.92L259.6 136.19L259.51 135.45L259.46 134.71L259.43 133.97L259.44 133.23L259.48 132.49L259.55 131.75L259.65 131.02L259.79 130.28L259.96 129.55L260.16 128.82L260.4 128.1L260.66 127.39L260.96 126.68L261.3 125.98L261.66 125.29L262.06 124.61L262.49 123.94L262.96 123.28L263.46 122.64L263.99 122.01L264.56 121.39L265.15 120.79L265.77 120.22L266.41 119.67L267.06 119.15L267.74 118.66L268.43 118.2L269.14 117.76L269.86 117.35L270.6 116.97L271.36 116.62L272.12 116.29L272.9 115.99L273.69 115.71L274.49 115.47L275.29 115.25L276.11 115.06L276.93 114.9L277.76 114.76L278.59 114.66L279.43 114.58L280.26 114.53L281.1 114.51L281.95 114.51L282.79 114.55Z" id="c5it6tCvD7"/></defs><g><g><g><use xlink:href="#a2rBf4dlXC" opacity="1" fill="#3c5a73" fill-opacity="1"/><g><use xlink:href="#a2rBf4dlXC" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#e1uwW73gxz" opacity="1" fill="#46738c" fill-opacity="1"/><g><use xlink:href="#e1uwW73gxz" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#e1KEE4hPZ0" opacity="1" fill="#46738c" fill-opacity="1"/><g><use xlink:href="#e1KEE4hPZ0" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#a1yuRFhUeD" opacity="1" fill="#3c5a73" fill-opacity="1"/><g><use xlink:href="#a1yuRFhUeD" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#b3Kw8SlMC3" opacity="1" fill="#87afb9" fill-opacity="1"/><g><use xlink:href="#b3Kw8SlMC3" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#bi1wkj7GV" opacity="1" fill="#87afb9" fill-opacity="1"/><g><use xlink:href="#bi1wkj7GV" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#eeKxtzTXh" opacity="1" fill="#5f6e9b" fill-opacity="1"/><g><use xlink:href="#eeKxtzTXh" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#d6NQaEe4mi" opacity="1" fill="#414b82" fill-opacity="1"/><g><use xlink:href="#d6NQaEe4mi" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#jj2K3ykM9" opacity="1" fill="#ff9000" fill-opacity="1"/><g><use xlink:href="#jj2K3ykM9" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#b1X9AV01Ha" opacity="1" fill="#ffb69e" fill-opacity="1"/><g><use xlink:href="#b1X9AV01Ha" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#a49WyokNvr" opacity="1" fill="#ffb69e" fill-opacity="1"/><g><use xlink:href="#a49WyokNvr" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g><g><use xlink:href="#c5it6tCvD7" opacity="1" fill="#4fd7dd" fill-opacity="1"/><g><use xlink:href="#c5it6tCvD7" opacity="1" fill-opacity="0" stroke="#000000" stroke-width="1" stroke-opacity="0"/></g></g></g></g></svg>
                                        </div>
                                    </div>

                                    @if(isset($product->gift) && $product->gift->isNotEmpty())
                                        <div class="m-portlet m-portlet--bordered m-portlet--creative m-portlet--bordered-semi m--margin-top-25">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption col">
                                                    <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon">
                                                            <i class="flaticon-gift"></i>
                                                        </span>
                                                        <h3 class="m-portlet__head-text">
                                                            این محصول شامل هدایای زیر می باشد:
                                                        </h3>
                                                        <h2 class="m-portlet__head-label m-portlet__head-label--accent">
                                                            <span>هدایا</span>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet__body">
                                                <div class="row justify-content-center productGifts">
                                                    @foreach($product->gift as $gift)
                                                        <div class="col-12">
                                                            @if(strlen($gift->url)>0)
                                                                <a target="_blank" href="{{ $gift->url }}">
                                                                    <div>
                                                                        <img src="{{ $gift->photo }}" class="rounded-circle">
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn m-btn--pill m-btn--air m-btn btn-info">
                                                                            {{ $gift->name }}
                                                                        </button>
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <div>
                                                                    <img src="{{ $gift->photo }}" class="rounded-circle">
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="btn m-btn--pill m-btn--air m-btn btn-info">
                                                                        {{ $gift->name }}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <!--end::Preview-->
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
        <!--end::Portlet-->
    </div>
</div>
