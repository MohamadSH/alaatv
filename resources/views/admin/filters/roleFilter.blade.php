<div class = "row">
    <div class = "col-md-1">
        <label class = "control-label" style = "float: right;">
            <label class = "mt-checkbox mt-checkbox-outline">
                <input type = "checkbox" id = "roleEnable" value = "1" name = "roleEnable">
                <span class = "bg-grey-cararra"></span>
            </label>
        </label>
    </div>
    <div class = "col-md-10">
        {!! Form::select('roles[]', $roles, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default a--full-width', 'id' => 'roles' ,
                            "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" , "data-height" => "200" ,
                            "title" => "نقش ها" , "disabled"]) !!}
        {{--<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"--}}
        {{--id="roles" name="roles[]" title="نقش ها" disabled>--}}
        {{--@foreach($roles as $key=>$value)--}}
        {{--<option value="{{$key}}">{{$value}}</option>--}}
        {{--@endforeach--}}
        {{--</select>--}}
    </div>
</div>
