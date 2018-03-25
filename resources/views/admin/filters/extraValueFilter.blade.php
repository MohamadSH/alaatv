{{--<select class="form-control" name="extraAttributes[]" style="height: 200px" multiple>--}}
    {{--@foreach($attributevalueCollection as $key => $attributevalueArray)--}}
        {{--<optgroup label="{{$key}}" class="bold">--}}
            {{--<option value="{{$product->id}}" @if(isset($defaultProductFilter) && in_array($product->id, $defaultProductFilter)) selected="selected" @endif>{{$product->name}}</option>--}}
            {{--@foreach($attributevalueArray as $key => $attributevalues)--}}
                {{--<option value="{{$attributevalues}}" >{{$key}}</option>--}}
            {{--@endforeach--}}
        {{--</optgroup>--}}
    {{--@endforeach--}}
{{--</select>--}}
<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"
        id="{{isset($id) ? $id : "extraAttributes"}}" name="{{isset($name) ? $name : 'extraAttributes[]'}}"
        title="{{isset($title) ? $title : 'انتخاب ویژگی افزوده'}}">
        @foreach($attributevalueCollection as $key => $attributevalueArray)
                <optgroup label="{{$key}}" class="bold">
                        @foreach($attributevalueArray as $key => $attributevalues)
                                <option value="{{$attributevalues}}" >{{$key}}</option>
                        @endforeach
                </optgroup>
        @endforeach
</select>