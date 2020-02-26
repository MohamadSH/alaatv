<li class="m-nav__item @if(count($product->children->where('enable',1))>0) m-nav__item--active selectableProduct-parent @else selectableProduct-child-lastNode @endif">
    @if(count($product->children->where('enable',1))>0)
        <span class="m-switch m-switch--sm m-switch--icon {{ $colors[$color] }} float-left a--font-line-height-10 m--padding-right-5 parentCheckBox">
            <label class="m--marginless">
                <input name="products[]"
                       value="{{ $product->id }}"
                       type="checkbox"
                       class="hasParent_{{ $product->pivot->parent_id }} @if(count($product->children->where('enable',1))>0) hasChildren @endif product"

                       @if(
                            isset($product->pivot->isDefault) &&
                            $product->pivot->isDefault &&
                            ((array_search($product->id, $purchasedProductIdArray) === false) && !$childIsPurchased)
                       )
                       checked="checked"
                       @endif

                    @include('partials.gtm-eec.product', ['position'=>'0', 'list'=>'صفحه نمایش محصول-محصولات فرزند', 'quantity'=>'1'])>
                <span></span>
            </label>
        </span>
    @else

        <span class="m-switch m-switch--sm m-switch--icon {{ $colors[$color] }} float-left a--font-line-height-10 m--padding-right-5">
            <label class="m--marginless">
                <input name="products[]"
                       value="{{ $product->id }}"
                       type="checkbox"
                       class="hasParent_{{ $product->pivot->parent_id }} @if(count($product->children->where('enable',1))>0) hasChildren @endif product"
                       @if(
                            isset($product->pivot->isDefault) &&
                            $product->pivot->isDefault &&
                            ((array_search($product->id, $purchasedProductIdArray) === false) && !$childIsPurchased)
                       )
                       checked="checked"
                       @endif
                    @include('partials.gtm-eec.product', ['position'=>'0', 'list'=>'صفحه نمایش محصول-محصولات فرزند', 'quantity'=>'1'])>
                <span></span>
            </label>
        </span>

    @endif
    <a class="m-nav__link @if(count($product->children->where('enable',1))>0) a--radius-2 m--padding-left-65 @else @endif"
       role="tab"
       id="m_nav_link_{{ $product->id }}"
       data-toggle="collapse"
       href="#m_nav_sub_{{ $product->id }}"
       aria-expanded="false">

        <div class="m-nav__link-title a--full-width">
            <div class="m-nav__link-wrap">
                <div class="m-nav__link-text">

                    <div class="m--padding-5">
                        <span class="childProductName-{{ $product->id }}">
                            {{$product->name}}
                        </span>
                        <span class="m-nav__link-badge float-right">
                            @if(!$product->children->where('enable',1)->count()>0 && (array_search($product->id, $purchasedProductIdArray) !== false) || $childIsPurchased)

                                <span class="m-badge m-badge--info m-badge--wide m-badge--rounded" onclick="window.location.href = '{{ action("Web\UserController@userProductFiles") }}'">
                                    خریده اید
                                    <i class="fa fa-play-circle"></i>
                                </span>
                            @elseif(!$product->children->where('enable',1)->count()>0)
                                @include('product.partials.price', ['price' => $product->price])
                            @endif
                        </span>
                    </div>
                    <div class="m--clearfix"></div>

                    @if(isset($product->introVideo))
                        <button type="button" class="btn btn-sm m-btn m-btn--pill m-btn--air btn-info btnShowVideoLink"
                                data-videosrc="{{ $product->introVideo }}" data-videotitle="{{ $product->name }}"
                                data-videodes="{{ $product->shortDescription }}">
                            <span>
                                <i class="fa fa-play-circle"></i>
                                <span>نمایش کلیپ معرفی</span>
                            </span>
                        </button>
                    @endif

                </div>

            </div>
        </div>

        @if(count($product->children->where('enable',1))>0)
            <div class="m-nav__link-arrow"></div>
        @endif
    </a>
    @if(count($product->children->where('enable',1))>0)
        <ul class="m-nav__sub collapse show children_{{$product->id}} m--padding-top-5" id="m_nav_sub_{{ $product->id }}" role="tabpanel"
            aria-labelledby="m_nav_link_{{ $product->id }}" data-parent="#m_nav_link_{{ $product->id }}">
            @foreach($product->children->where('enable',1) as $p)
                @include('product.partials.showChildren',['product' => $p, 'color' => $color + 1, 'childIsPurchased' => (array_search($p->id, $purchasedProductIdArray) !== false)])
            @endforeach
        </ul>
    @endif
</li>




