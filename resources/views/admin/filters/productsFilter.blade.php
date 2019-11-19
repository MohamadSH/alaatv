<div class="row">
    @if(isset($withCheckbox) && $withCheckbox)
        <div class="col-md-1" style="padding-left: 0px">
            <label class="control-label" style="float: right;">
                <label class="mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" id="{{isset($enableId) ? $enableId : "productEnable"}}" value="1" name="{{isset($enableName) ? $enableName : "productEnable"}}" @if(isset($defaultProductFilter)) checked @endif>
                    <span class="bg-grey-cararra"></span>
                </label>
            </label>
        </div>
    @endif
    @if(isset($withCheckbox))
        <div class="col-md-11" @if(isset($withCheckbox) && $withCheckbox) style="padding-right: 0px" @endif>
    @else
        <div class="col">
    @endif
            @if(isset($listType))
                @if(strcmp($listType , "configurables") == 0)
                    <input type="hidden" name="{{isset($name) ? $name : 'products[]'}}" value="" />
                    <select class="mt-multiselect btn btn-default a--full-width" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200" id="{{isset($id) ? $id : "products"}}" name="{{isset($name) ? $name : 'products[]'}}" @if(isset($withCheckbox) && $withCheckbox) disabled @endif title="{{isset($title) ? $title : 'انتخاب محصول دیده شده'}}">
                        @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                @elseif(strcmp($listType , "childSelect") == 0)
                    @if(isset($selectType) && strcmp($selectType , "searchable") == 0)
                        @if(isset($label))
                            <label for="{{(isset($id)?$id:'')}}" class="control-label">
                                @if(isset($label))
                                    {{$label["caption"]}}
                                @endif
                            </label>
                        @endif
                        <input type="hidden" name="{{isset($name) ? $name : ''}}" value="" />
                        <select name="{{isset($name) ? $name : ''}}"
                                @if(isset($id))id="{{$id}}" @endif
                                class="form-control select2 {{isset($class) ? $class : ''}} a--full-width"
                                {{isset($dataRole) ? 'data-role='.$dataRole : ''}}  {{isset($disabled) ? 'disabled' : ''}}>
                            <option></option>
                            @foreach($products as $product)
                                @if($product->producttype_id == config("constants.PRODUCT_TYPE_SIMPLE"))
                                    <option class="bold" value="{{$product->id}}" data-content="{{$product->calculatePayablePrice()["customerPrice"]}}">{{$product->name}}</option>
                                @else
                                    <optgroup class="bold" label="{{$product->name}}"></optgroup>
                                @endif
                                @foreach($product->children as $child)
                                    <option value="{{$child->id}}" data-content="{{$child->calculatePayablePrice()["customerPrice"]}}" @if(isset($defaultProductFilter) && $product->id== $defaultProductFilter)selected="selected"@endif>{{$child->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    @else
                        <input type="hidden" name="{{isset($name) ? $name : ''}}" value="" />
                        <select name="{{isset($name) ? $name : ''}}" class="form-control {{isset($class) ? $class : ''}} a--full-width" @if(isset($id))id="{{$id}}"@endif {{isset($dataRole) ? 'data-role='.$dataRole : ''}}  {{isset($disabled) ? 'disabled' : ''}} >
    
                            @if(isset($defaultValue))
                                <option selected="selected" value="@if(isset($defaultValue["value"])){{$defaultValue["value"]}}@endif">@if(isset($defaultValue["caption"])){{$defaultValue["caption"]}}@endif</option>@endif
                            @foreach($products as $product)
    
                                @if($product->producttype_id == config("constants.PRODUCT_TYPE_SIMPLE"))
                                    <option value="{{$product->id}}" data-content="{{$product->calculatePayablePrice()["customerPrice"]}}">{{$product->name}}</option>
                                @else
                                    <optgroup label="{{$product->name}}"></optgroup>
                                @endif
                                @foreach($product->children as $child)
                                    <option value="{{$child->id}}" data-content="{{$child->calculatePayablePrice()["customerPrice"]}}" @if(isset($defaultProductFilter) && $child->id== $defaultProductFilter) selected="selected" @endif>{{$child->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    @endif
                @elseif(strcmp($listType , "canSelectAllType") == 0)
                    <select class="mt-multiselect btn btn-default a--full-width" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200" id="{{isset($id) ? $id : "products"}}" name="{{isset($name) ? $name : 'products[]'}}" @if(isset($withCheckbox) && $withCheckbox) disabled @endif title="{{isset($title) ? $title : 'انتخاب محصول سفارش داده شده'}}">
                        
                        @if(isset($everyProduct) && $everyProduct)
                            <option value="0" class="m--font-info">هر محصولی</option>
                        @endif
                        @foreach($products as $product)
        
                            @if($product->hasChildren())
                                <option class="startOfChilds" disabled><hr></option>
                            @endif
                            
                            <option value="{{$product->id}}"
                                @if($product->hasChildren())
                                class="parentItem"
                                @endif
                                @if(isset($defaultProductFilter) && in_array($product->id, $defaultProductFilter)) selected="selected" @endif
                            >
                                {{$product->name}}{{(!$product->enable)?"(غیرفعال)":""}}
                            </option>
        
                            @if($product->hasChildren())
                                @foreach($product->children as $child)
                                    <option class="m--margin-left-30 childItem" value="{{$child->id}}" @if(isset($defaultProductFilter) && in_array($child->id, $defaultProductFilter)) selected="selected" @endif>{{$child->name}}</option>
                                    @if($child->hasChildren())
                                        @foreach($product->children as $grandChild)
                                            <option class="m--margin-left-40 childItem" value="{{$grandChild->id}}" @if(isset($defaultProductFilter) && in_array($grandChild->id, $defaultProductFilter)) selected="selected" @endif>{{$grandChild->name}}</option>
                                            @if($child->hasChildren())
                                                @foreach($grandChild->children as $grandgrandChild)
                                                    <option class="m--margin-left-50 childItem" value="{{$grandgrandChild->id}}" @if(isset($defaultProductFilter) && in_array($grandgrandChild->id, $defaultProductFilter)) selected="selected" @endif>{{$grandgrandChild->name}}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                <option class="endOfChilds" disabled><hr></option>
                            @endif
                            
                            
                        @endforeach
                    </select>
                @else
                    @if(isset($label))
                        <label for="{{(isset($id)?$id:'')}}" class="control-label">
                            @if(isset($label))
                                {{$label["caption"]}}
                            @endif
                        </label>
                    @endif
                    <input type="hidden" name="{{isset($name) ? $name : ''}}" value="" />
                    <select name="{{isset($name) ? $name : ''}}" @if(isset($id))id="{{$id}}" @endif class="form-control select2 {{isset($class) ? $class : ''}} a--full-width"
                            {{isset($dataRole) ? 'data-role='.$dataRole : ''}}  {{isset($disabled) ? 'disabled' : ''}}>
                        <option></option>
                        @foreach($products as $product)
                            <optgroup label="{{$product->name}}"></optgroup>
                            <option value="{{$product->id}}" data-content="{{$product->calculatePayablePrice()["customerPrice"]}}" @if(isset($defaultProductFilter) && $product->id== $defaultProductFilter)selected="selected"@endif>{{$product->name}}</option>
                            @foreach($product->children as $child)
                                <option value="{{$child->id}}" data-content="{{$child->calculatePayablePrice()["customerPrice"]}}" @if(isset($defaultProductFilter) && $child->id== $defaultProductFilter) selected="selected" @endif>{{$child->name}}</option>
                            @endforeach
                        @endforeach
                    </select>
                @endif
            @else
                <select class="mt-multiselect btn btn-default a--full-width" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200" id="{{isset($id) ? $id : "products"}}" name="{{isset($name) ? $name : 'products[]'}}" @if(isset($withCheckbox) && $withCheckbox) disabled @endif title="{{isset($title) ? $title : 'انتخاب محصول سفارش داده شده'}}">
                    @if(isset($withoutOrder) && $withoutOrder)
                        <option value="-1" class="m--font-danger">بدون سفارش ها</option>
                    @endif
                    @if(isset($everyProduct) && $everyProduct)
                        <option value="0" class="m--font-info">هر محصولی</option>
                    @endif
                    @foreach($products as $product)
                        @if($product->producttype_id == config("constants.PRODUCT_TYPE_SIMPLE") ||
                            $product->producttype_id == config("constants.PRODUCT_TYPE_CONFIGURABLE"))
                            <option value="{{$product->id}}" class="bold" @if(isset($defaultProductFilter) && in_array($product->id, $defaultProductFilter)) selected="selected" @endif>{{$product->name}}{{(!$product->enable)?"(غیرفعال)":""}}</option>
                        @else
                            <optgroup label="{{$product->name}}{{(!$product->enable)?"(غیرفعال)":""}}" class="bold"></optgroup>
                        @endif
                        @foreach($product->children as $child)
                            <option value="{{$child->id}}" @if(isset($defaultProductFilter) && in_array($child->id, $defaultProductFilter)) selected="selected" @endif>{{$child->name}}</option>
                            @if($child->hasChildren())
                                @foreach($product->children as $grandChild)
                                    <option value="{{$grandChild->id}}" @if(isset($defaultProductFilter) && in_array($grandChild->id, $defaultProductFilter)) selected="selected" @endif>{{$grandChild->name}}</option>
                                    @if($child->hasChildren())
                                        @foreach($grandChild->children as $grandgrandChild)
                                            <option value="{{$grandgrandChild->id}}" @if(isset($defaultProductFilter) && in_array($grandgrandChild->id, $defaultProductFilter)) selected="selected" @endif>{{$grandgrandChild->name}}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                </select>
            @endif

        </div>
</div>