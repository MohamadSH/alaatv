@if(isset($withCheckbox) && $withCheckbox)
    <div class="col-md-1">
        <label class="control-label" style="float: right;"><label class="mt-checkbox mt-checkbox-outline">
                <input type="checkbox" id="gradeEnable" value="1" name="gradeEnable">
                <span class="bg-grey-cararra"></span>
            </label>
        </label>
    </div>
    <div class="col-md-10">
        @endif

        {{--{!! Form::select('grades[]', $grades, null,['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default', 'id' => 'grades' ,--}}
        {{--"data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" , "data-height" => "200" ,--}}
        {{--"title" => "رشته ها" , "disabled"]) !!}--}}
        @if(isset($dropdown) && $dropdown)
            @if(isset($dropdownClass))
                {!! Form::select('grades[]',$grades,null,['class' => 'form-control '.$dropdownClass ]) !!}
            @else
                {!! Form::select('grades[]',$grades,null,['class' => 'form-control '  ]) !!}
            @endif
        @else
            <select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%"
                    data-filter="true" data-height="200"
                    id="grades" name="grades[]" title="رشته ها" disabled>
                <option value="0" class="bold font-red">بدون رشته ها</option>
                @foreach($grades as $key=>$value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        @endif

        @if(isset($withCheckbox) && $withCheckbox)
    </div>
@endif
