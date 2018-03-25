@if(isset($withCheckbox) && $withCheckbox)
<div class="col-md-1" style="padding-left: 0px">
    <label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox" id="{{isset($enableId) ? $enableId : "productEnable"}}" value="1" name="{{isset($enableName) ? $enableName : "productEnable"}}" @if(isset($defaultProductFilter)) checked @endif>
            <span class="bg-grey-cararra"></span>
        </label>
    </label>
</div>
@endif
@if(isset($withCheckbox))
<div class="col-md-11"  @if(isset($withCheckbox) && $withCheckbox) style="padding-right: 0px" @endif>
@endif
@if(isset($listType))
    @if(strcmp($listType , "configurables") == 0)
        <select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"
                id="{{isset($id) ? $id : "products"}}" name="{{isset($name) ? $name : 'products[]'}}"  @if(isset($withCheckbox) && $withCheckbox) disabled @endif
                title="{{isset($title) ? $title : 'انتخاب محصول دیده شده'}}">
            @foreach($products as $product)
                    <option value="{{$product["product"]->id}}">{{$product["product"]->name}}</option>
            @endforeach
        </select>
    @elseif(strcmp($listType , "childSelect") == 0)
        @if(isset($selectType) && strcmp($selectType , "searchable") == 0)
                @if(isset($label))<label for="{{(isset($id)?$id:'')}}" class="control-label">@if(isset($label)){{$label["caption"]}}@endif</label>@endif
                <select name="{{isset($name) ? $name : ''}}" @if(isset($id))id="{{$id}}"@endif class="form-control select2 {{isset($class) ? $class : ''}}"
                        {{isset($dataRole) ? 'data-role='.$dataRole : ''}}  {{isset($disabled) ? 'disabled' : ''}}>
                    <option></option>
                    @foreach($products as $product)
                        @if($product["product"]->producttype_id == Config::get("constants.PRODUCT_TYPE_SIMPLE"))
                            <option class="bold" value="{{$product["product"]->id}}" data-content="{{$product["product"]->calculatePayablePrice()}}" >{{$product["product"]->name}}</option>
                        @else
                            <optgroup class="bold" label="{{$product["product"]->name}}"></optgroup>
                        @endif
                        @foreach($product["children"] as $child)
                            <option value="{{$child->id}}" data-content="{{$child->calculatePayablePrice()}}" @if(isset($defaultProductFilter) && $product["product"]->id== $defaultProductFilter)selected="selected"@endif>{{$child->name}}</option>
                        @endforeach
                    @endforeach
                </select>
        @else
            <select name="{{isset($name) ? $name : ''}}" class="form-control {{isset($class) ? $class : ''}}" @if(isset($id))id="{{$id}}"@endif {{isset($dataRole) ? 'data-role='.$dataRole : ''}}  {{isset($disabled) ? 'disabled' : ''}} >
                @if(isset($defaultValue))<option selected="selected" value="@if(isset($defaultValue["value"])){{$defaultValue["value"]}}@endif">@if(isset($defaultValue["caption"])){{$defaultValue["caption"]}}@endif</option>@endif
                @foreach($products as $product)
                    @if($product["product"]->producttype_id == Config::get("constants.PRODUCT_TYPE_SIMPLE"))
                        <option value="{{$product["product"]->id}}" data-content="{{$product["product"]->calculatePayablePrice()}}" >{{$product["product"]->name}}</option>
                    @else
                        <optgroup label="{{$product["product"]->name}}"></optgroup>
                    @endif
                    @foreach($product["children"] as $child)
                        <option value="{{$child->id}}" data-content="{{$child->calculatePayablePrice()}}" @if(isset($defaultProductFilter) && $child->id== $defaultProductFilter) selected="selected" @endif>{{$child->name}}</option>
                    @endforeach
                @endforeach
            </select>
        @endif
    @else

        @if(isset($label))<label for="{{(isset($id)?$id:'')}}" class="control-label">@if(isset($label)){{$label["caption"]}}@endif</label>@endif
        <select name="{{isset($name) ? $name : ''}}" @if(isset($id))id="{{$id}}"@endif class="form-control select2 {{isset($class) ? $class : ''}}"
                {{isset($dataRole) ? 'data-role='.$dataRole : ''}}  {{isset($disabled) ? 'disabled' : ''}}>
            <option></option>
            @foreach($products as $product)
                    <optgroup label="{{$product["product"]->name}}"></optgroup>
                    <option value="{{$product["product"]->id}}" data-content="{{$product["product"]->calculatePayablePrice()}}" @if(isset($defaultProductFilter) && $product["product"]->id== $defaultProductFilter)selected="selected"@endif>{{$product["product"]->name}}</option>
                @foreach($product["children"] as $child)
                    <option value="{{$child->id}}" data-content="{{$child->calculatePayablePrice()}}" @if(isset($defaultProductFilter) && $child->id== $defaultProductFilter) selected="selected" @endif>{{$child->name}}</option>
                @endforeach
            @endforeach
        </select>
    @endif
@else
    <select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"
            id="{{isset($id) ? $id : "products"}}" name="{{isset($name) ? $name : 'products[]'}}" @if(isset($withCheckbox) && $withCheckbox) disabled @endif
            title="{{isset($title) ? $title : 'انتخاب محصول سفارش داده شده'}}">
        @if(isset($withoutOrder) && $withoutOrder)
            <option value="-1" class="font-red">بدون سفارش ها</option>
        @endif
        @if(isset($everyProduct) && $everyProduct)
            <option value="0" class="font-blue">هر محصولی</option>
        @endif
        @foreach($products as $product)
            @if($product["product"]->producttype_id == Config::get("constants.PRODUCT_TYPE_SIMPLE") ||
                $product["product"]->producttype_id == Config::get("constants.PRODUCT_TYPE_CONFIGURABLE"))
                <option value="{{$product["product"]->id}}" class="bold" @if(isset($defaultProductFilter) && in_array($product["product"]->id, $defaultProductFilter)) selected="selected" @endif>{{$product["product"]->name}}{{(!$product["product"]->enable)?"(غیرفعال)":""}}</option>
            @else
                <optgroup label="{{$product["product"]->name}}{{(!$product["product"]->enable)?"(غیرفعال)":""}}" class="bold"></optgroup>
            @endif
            @foreach($product["children"] as $child)
                    <option value="{{$child->id}}" @if(isset($defaultProductFilter) && in_array($child->id, $defaultProductFilter)) selected="selected" @endif>{{$child->name}}</option>
            @endforeach
        @endforeach
    </select>
@endif
@if(isset($withCheckbox))
</div>
@endif
