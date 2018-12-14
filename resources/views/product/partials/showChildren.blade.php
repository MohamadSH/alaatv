@if(count($product->children)>0)
    <li class = "m-nav__item  m-nav__item--active">
        <a class = "m-nav__link a--radius-2" role = "tab" id = "m_nav_link_{{ $product->id }}" aria-expanded = " false">
@else
    <li class = "m-nav__item">
        <a class = "m-nav__link ">
@endif
            <span class = "m-nav__link-title">
            <span class = "m-nav__link-wrap">
                <span class = "m-nav__link-text">
                    <div class = "form-group m-form__group row">
                        <div>

                            @if(isset($product->pivot->control_id) && ( $product->pivot->control_id ==  Config::get("constants.CONTROL_SWITCH") || $product->pivot->control_id == Config::get("constants.CONTROL_GROUPED_CHECKBOX") ))
                                <span class = "m-switch m-switch--icon {{ $color > 0 ? 'm-switch--primary' : 'm-switch--warning' }}">
                                    <label>
                                        <input name = "products[]" value = "{{ $product->id }}" type = "checkbox" class = "hasParent_{{ $product->pivot->parent_id }} {{ count($product->children)>0 ? "hasChildren" : "" }} product"
                                                {{ isset($product->pivot->isDefault) && $product->pivot->isDefault ? 'checked="checked"':'' }}>
                                        <span></span>
                                    </label>
                                </span>
                            @else
                            @endif
                        </div>
                        <label class = "col-form-label">{{$product->name}}</label>
                    </div>
                </span>
                {{--@if((int)$product->cost > 0)--}}
                <span class = "m-nav__link-badge">
                        <span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded">
                            {{ $product->priceText }}
                        </span>
                    </span>
                {{--@endif--}}
            </span>
        </span>
        @if(count($product->children)>0)
            <span class = "m-nav__link-arrow"></span>
        @endif
        </a>
        @if(count($product->children)>0)
            <ul class = "m-nav__sub collapse show children_{{$product->id}}" id = "m_nav_sub_{{ $product->id }}" role = "tabpanel" aria-labelledby = "m_nav_link_{{ $product->id }}" data-parent = "#m_nav">
                @foreach($product->children as $p)
                    @include('product.partials.showChildren',['product' => $p, 'color' => $color * -1])
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




