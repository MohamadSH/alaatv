<div class = "row">
    @if(isset($withCheckbox) && $withCheckbox)
        <div class = "col-md-1">
            <label class = "control-label" style = "float: right;">
                <label class = "mt-checkbox mt-checkbox-outline">
                    <input type = "checkbox" id = "majorEnable" value = "1" name = "majorEnable">
                    <span class = "bg-grey-cararra"></span>
                </label>
            </label>
        </div>
        <div class = "col-md-10">
            @endif

            {{--{!! Form::select('majors[]', $majors, null,['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default', 'id' => 'majors' ,--}}
            {{--"data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" , "data-height" => "200" ,--}}
            {{--"title" => "رشته ها" , "disabled"]) !!}--}}
            @if(isset($dropdown) && $dropdown)
                @if(isset($dropdownClass))
                    {!! Form::select('majors[]',$majors,null,['class' => 'form-control a--full-width '.$dropdownClass ]) !!}
                @else
                    {!! Form::select('majors[]',$majors,null,['class' => 'form-control a--full-width']) !!}
                @endif
            @else
                <select class = "mt-multiselect btn btn-default a--full-width" multiple = "multiple" data-label = "left" data-width = "100%" data-filter = "true" data-height = "200" id = "majors" name = "majors[]" title = "رشته ها" disabled>
                    <option value = "0" class = "bold m--font-danger">بدون رشته ها</option>
                    @foreach($majors as $key=>$value)
                        <option value = "{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
            @endif

            @if(isset($withCheckbox) && $withCheckbox)
        </div>
    @endif
</div>