<style>
    .parentCheckBox {
        position: absolute;
        z-index: 1;
        right: 9px;
        top: 6px;
    }
</style>
@if(count($product->children)>0)
    <li class = "m-nav__item  m-nav__item--active position-relative">
        {{--@if(isset($product->pivot->control_id) && ( $product->pivot->control_id ==  config("constants.CONTROL_SWITCH") || $product->pivot->control_id == Config::get("constants.CONTROL_GROUPED_CHECKBOX") ))--}}
            <span class = "m-switch m-switch--icon {{ $colors[$color] }} float-left a--font-line-height-10 m--padding-right-5 parentCheckBox">
                <label class="m--marginless">
                    <input name = "products[]" value = "{{ $product->id }}" type = "checkbox" class = "hasParent_{{ $product->pivot->parent_id }} {{ count($product->children)>0 ? "hasChildren" : "" }} product"
                            {{ isset($product->pivot->isDefault) && $product->pivot->isDefault ? 'checked="checked"':'' }}>
                    <span></span>
                </label>
            </span>
        {{--@else--}}
        {{--@endif--}}
        <a  class = "m-nav__link a--radius-2 m--padding-left-65" role = "tab" id = "m_nav_link_{{ $product->id }}" data-toggle="collapse" href="#m_nav_sub_{{ $product->id }}" aria-expanded = " false">
@else
    <li class = "m-nav__item">
        <a class = "m-nav__link ">
@endif
            <span class = "m-nav__link-title a--full-width">
                <span class = "m-nav__link-wrap">
                    <span class = "m-nav__link-text">
                        @if(!count($product->children)>0)
                            {{--@if(isset($product->pivot->control_id) && ( $product->pivot->control_id ==  config("constants.CONTROL_SWITCH") || $product->pivot->control_id == Config::get("constants.CONTROL_GROUPED_CHECKBOX") ))--}}
                                <span class = "m-switch m-switch--icon {{ $colors[$color] }} float-left a--font-line-height-10 m--padding-right-5">
                                    <label class="m--marginless">
                                        <input name = "products[]" value = "{{ $product->id }}" type = "checkbox" class = "hasParent_{{ $product->pivot->parent_id }} {{ count($product->children)>0 ? "hasChildren" : "" }} product"
                                                {{ isset($product->pivot->isDefault) && $product->pivot->isDefault ? 'checked="checked"':'' }}>
                                        <span></span>
                                    </label>
                                </span>
                            {{--@else--}}
                            {{--@endif--}}
                        @endif
                        <div class="m--padding-5">
                            {{$product->name}}
                            {{--@if((int)$product->cost > 0)--}}
                            <span class = "m-nav__link-badge float-right">
                                <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">
                                    <span class="m-badge m-badge--warning a--productRealPrice">14,000</span>
                                    {{ trim($product->priceText) }}
                                    <span class="m-badge m-badge--info a--productDiscount">20%</span>
                                </span>
                            </span>
                            {{--@endif--}}
                        </div>
                        <div class="m--clearfix"></div>

                        @if(isset($product->introVideo))
                            <button type="button"
                                    class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-focus m-btn--gradient-to-danger"
                                    id="btnShowVideoLink"
                                    data-videosrc="{{ $product->introVideo }}"
                                    data-videotitle="{{ $product->name }}"
                                    data-videodes="{{ $product->shortDescription }}">
                                <span>
                                    <i class="fa fa-play-circle"></i>
                                    <span>نمایش کلیپ معرفی</span>
                                </span>
                            </button>
                        @endif

                    </span>

                </span>
            </span>
        @if(count($product->children)>0)
            <span class = "m-nav__link-arrow"></span>
        @endif
        </a>
        @if(count($product->children)>0)
            <ul class = "m-nav__sub collapse show children_{{$product->id}} m--padding-top-5" id = "m_nav_sub_{{ $product->id }}" role = "tabpanel" aria-labelledby = "m_nav_link_{{ $product->id }}" data-parent = "#m_nav_link_{{ $product->id }}">
                @foreach($product->children as $p)
                    @include('product.partials.showChildren',['product' => $p, 'color' => $color + 1])
                @endforeach
            </ul>
        @endif
    </li>


    {{--
    <li style="border:none">
        <label class="bold">
            @if(isset($product->pivot->control_id) && $product->pivot->control_id ==  Config::get("constants.CONTROL_SWITCH"))
                <input name="products[]" value="{{$product->id}}" type="checkbox"
                       class="hasParent_{{$product->pivot->parent_id}} {{ count($product->children)>0 ? "hasChildren" : "" }} product make-switch  "
                       data-size="mini" data-on-color="success" data-off-color="danger" data-on-text="بله"
                       data-off-text="خیر"> {{$product->name}}

                @if((int)$product->cost > 0) : {{ number_format((int)$product->cost)}} تومان@endif
                <span class="help-block font-red bold"></span>
                <input type="hidden" value="0" id="switchFlag   _{{$product->id}}">
            @else
                <input name="products[]" type="checkbox" value="{{$product->id}}"
                       class="hasParent_{{$product->pivot->parent_id}} {{(count($product->children)>0)?"hasChildren":""}} product icheck {{(isset($product->pivot->isDefault) && $product->pivot->isDefault)?"isDefault":""}}"
                       data-checkbox="icheckbox_minimal-blue">{{$product->name}}
                @if(isset($product["simpleInfoAttributes"]))
                    @foreach($product["simpleInfoAttributes"] as $key => $simpleInfoAttribute)
                        @foreach($simpleInfoAttribute as $key => $info)
                            <span> @if(count($simpleInfoAttribute)>1 && $key < (sizeof($simpleInfoAttribute)-1))
                                    , @endif {{$info["name"]}}</span>
                        @endforeach
                    @endforeach
                @endif @if((int)$product->basePrice > 0) : {{number_format((int)$product->basePrice)}} تومان@endif
            @endif
            @if(isset($product->pivot->description[0])) <span class="help-block font-red bold"
                                                              style="font-size: smaller;text-align: justify">{{$product->pivot->description}}</span>@endif
        </label>

    </li>
    --}}




