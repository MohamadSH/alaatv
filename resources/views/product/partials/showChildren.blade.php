<li style="border:none">
    <label class="bold">
        @if(isset($product->pivot->control_id) && $product->pivot->control_id ==  Config::get("constants.CONTROL_SWITCH"))
            <input name="products[]" value="{{$product->id}}" type="checkbox"
                   class="hasParent_{{$product->pivot->parent_id}} {{(count($product->children)>0)?"hasChildren":""}} product make-switch  {{(isset($product->pivot->isDefault) && $product->pivot->isDefault)?"isDefault":""}}"
                   data-size="mini" data-on-color="success" data-off-color="danger" data-on-text="بله"
                   data-off-text="خیر"> {{$product->name}}
            @if(isset($product["simpleInfoAttributes"]))
                @foreach($product["simpleInfoAttributes"] as $key => $simpleInfoAttribute)
                    @foreach($simpleInfoAttribute as $key => $info)
                        <span> @if(count($simpleInfoAttribute)>1 && $key < (sizeof($simpleInfoAttribute)-1))
                                , @endif {{$info["name"]}}</span>
                    @endforeach
                @endforeach
            @endif @if((int)$product->cost > 0) : {{number_format((int)$product->cost)}} تومان@endif
            <span class="help-block font-red bold"></span>
            <input type="hidden" value="0" id="switchFlag_{{$product->id}}">
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

@if(count($product->children)>0)
    <ul class="children_{{$product->id}}">
        @each('product.partials.showChildren', $product->children, 'product')
    </ul>
@endif


