@if(count($product->children->where('enable',1))>0)
    <li class="m-nav__item  m-nav__item--active position-relative">

        {{--@if(isset($product->pivot->control_id) && ( $product->pivot->control_id ==  config("constants.CONTROL_SWITCH") || $product->pivot->control_id == Config::get("constants.CONTROL_GROUPED_CHECKBOX") ))--}}
        @if(
            (array_search($product->id, $purchasedProductIdArray) === false) &&
            !$childIsPurchased &&
            $product->children->where('enable',1)->pluck('id')->every(function ($value, $key) use ($purchasedProductIdArray) {
                return (array_search($value, $purchasedProductIdArray) === false);
            })
        )
        <span class="m-switch m-switch--sm m-switch--icon {{ $colors[$color] }} float-left a--font-line-height-10 m--padding-right-5 parentCheckBox">
            <label class="m--marginless">
                <input name="products[]"
                       value="{{ $product->id }}"
                       type="checkbox"
                       class="hasParent_{{ $product->pivot->parent_id }} @if(count($product->children->where('enable',1))>0) hasChildren @endif product"
{{--                       @if(isset($product->pivot->isDefault) && $product->pivot->isDefault)--}}
                       @if(
                            isset($product->pivot->isDefault) &&
                            $product->pivot->isDefault &&
                            ((array_search($product->id, $purchasedProductIdArray) === false) && !$childIsPurchased)
                       )
                       checked="checked"
                       @endif
                       @if((array_search($product->id, $purchasedProductIdArray) !== false) || $childIsPurchased)
                       disabled="disabled"
                       @endif

                       @include('partials.gtm-eec.product', ['position'=>'0', 'list'=>'صفحه نمایش محصول-محصولات فرزند', 'quantity'=>'1'])

{{--                       data-gtm-eec-product-id="{{ $product->id }}"--}}
{{--                       data-gtm-eec-product-name="{{ $product->name }}"--}}
{{--                       data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"--}}
{{--                       data-gtm-eec-product-brand="آلاء"--}}
{{--                       data-gtm-eec-product-category="-"--}}
{{--                       data-gtm-eec-product-variant="-"--}}
{{--                       data-gtm-eec-product-quantity="1"--}}
                >
                <span></span>
            </label>
        </span>
        @endif
        {{--@else--}}
        {{--@endif--}}
        <a class="m-nav__link a--radius-2 m--padding-left-65" role="tab" id="m_nav_link_{{ $product->id }}" data-toggle="collapse" href="#m_nav_sub_{{ $product->id }}" aria-expanded=" false">
@else
    <li class="m-nav__item selectableProduct-child-lastNode">

        <a class="m-nav__link ">
            @endif
            <span class="m-nav__link-title a--full-width">
                <span class="m-nav__link-wrap">
                    <span class="m-nav__link-text">
                        @if(
                            !$product->children->where('enable',1)->count()>0 &&
                            (array_search($product->id, $purchasedProductIdArray) === false) &&
                            !$childIsPurchased
                            )
                            {{--@if(isset($product->pivot->control_id) && ( $product->pivot->control_id ==  config("constants.CONTROL_SWITCH") || $product->pivot->control_id == Config::get("constants.CONTROL_GROUPED_CHECKBOX") ))--}}
                            <span class="m-switch m-switch--sm m-switch--icon {{ $colors[$color] }} float-left a--font-line-height-10 m--padding-right-5">
                                    <label class="m--marginless">
                                        <input name="products[]"
                                               value="{{ $product->id }}"
                                               type="checkbox"
                                               class="hasParent_{{ $product->pivot->parent_id }} @if(count($product->children->where('enable',1))>0) hasChildren @endif product"
{{--                                               @if(isset($product->pivot->isDefault) && $product->pivot->isDefault)--}}
                                               @if(
                                                    isset($product->pivot->isDefault) &&
                                                    $product->pivot->isDefault &&
                                                    ((array_search($product->id, $purchasedProductIdArray) === false) && !$childIsPurchased)
                                               )
                                               checked="checked"
                                               @endif
                                               @if((array_search($product->id, $purchasedProductIdArray) !== false) || $childIsPurchased)
                                               disabled="disabled"
                                               @endif

                                               @include('partials.gtm-eec.product', ['position'=>'0', 'list'=>'صفحه نمایش محصول-محصولات فرزند', 'quantity'=>'1'])

{{--                                               data-gtm-eec-product-id="{{ $product->id }}"--}}
{{--                                               data-gtm-eec-product-name="{{ $product->name }}"--}}
{{--                                               data-gtm-eec-product-price="{{ number_format($product->price['final'], 2, '.', '') }}"--}}
{{--                                               data-gtm-eec-product-brand="آلاء"--}}
{{--                                               data-gtm-eec-product-category="-"--}}
{{--                                               data-gtm-eec-product-variant="-"--}}
{{--                                               data-gtm-eec-product-quantity="1"--}}
                                        >
                                        <span></span>
                                    </label>
                                </span>
                            {{--@else--}}
                            {{--@endif--}}
                        @endif
                        <div class="m--padding-5">
                            <span class="childProductName-{{ $product->id }}">
                                {{$product->name}}
                            </span>

                            {{--@if((int)$product->cost > 0)--}}
                            <span class="m-nav__link-badge float-right">

                                @if(!$product->children->where('enable',1)->count()>0 && (array_search($product->id, $purchasedProductIdArray) !== false) || $childIsPurchased)
                                    <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                                        خریده اید
                                        <a class="btn btn-sm m-btn m-btn--pill m-btn--air btn-info animated infinite pulse" role="button" href="{{ action("Web\UserController@userProductFiles") }}">
                                            <i class="fa fa-play-circle"></i>
                                        </a>
                                    </span>
                                @elseif(!$product->children->where('enable',1)->count()>0)
                                    @if($product->price['base']!==$product->price['final'])
                                        <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                        <span class="m-badge m-badge--warning a--productRealPrice">{{ number_format($product->price['base']) }}</span>
                                        {{ number_format($product->price['final']) }} تومان
                                        <span class="m-badge m-badge--info a--productDiscount">{{ (int)((1-($product->price['final']/$product->price['base']))*100) }}%</span>
                                    </span>
                                    @else
                                        <span class="m-widget6__text m--align-right m--font-boldest m--font-primary">
                                        {{ number_format($product->price['final']) }} تومان
                                    </span>
                                    @endIf
                                @endif

                            </span>
                            {{--@endif--}}
                        </div>
                        <div class="m--clearfix"></div>

                        @if(isset($product->introVideo))
                            <button type="button" class="btn btn-sm m-btn m-btn--pill m-btn--air btn-info btnShowVideoLink" data-videosrc="{{ $product->introVideo }}" data-videotitle="{{ $product->name }}" data-videodes="{{ $product->shortDescription }}">
                                <span>
                                    <i class="fa fa-play-circle"></i>
                                    <span>نمایش کلیپ معرفی</span>
                                </span>
                            </button>
                        @endif

                    </span>

                </span>
            </span>
            @if(count($product->children->where('enable',1))>0)
                <span class="m-nav__link-arrow"></span>
            @endif
        </a>
        @if(count($product->children->where('enable',1))>0)
            <ul class="m-nav__sub collapse show children_{{$product->id}} m--padding-top-5" id="m_nav_sub_{{ $product->id }}" role="tabpanel" aria-labelledby="m_nav_link_{{ $product->id }}" data-parent="#m_nav_link_{{ $product->id }}">
                @foreach($product->children->where('enable',1) as $p)
                    @include('product.partials.showChildren',['product' => $p, 'color' => $color + 1, 'childIsPurchased' => (array_search($product->id, $purchasedProductIdArray) !== false)])
                @endforeach
            </ul>
        @endif
    </li>




