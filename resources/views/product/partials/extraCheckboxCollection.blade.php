@if(isset($extraCheckboxCollection) )
    @foreach($extraCheckboxCollection as $checkboxArray)
        @foreach($checkboxArray as $index => $checkbox)
            @if(isset($withExtraCost))
                <div class="col-md-8">
                    @if(isset($defaultExtraAttributes) && in_array($index,$defaultExtraAttributes) )
                        {!! Form::checkbox('extraAttribute[]', $index, null, ['class' => '' ,'id'=>'attributevalue_'.$index, 'checked' ,  'data-checkbox'=>'icheckbox_square-blue']) !!}
                    @else
                        {!! Form::checkbox('extraAttribute[]', $index, null, ['class' => '' , 'id'=>'attributevalue_'.$index, 'data-checkbox'=>'icheckbox_square-blue']) !!}
                    @endif
                    <label for="attributevalue_{{$index}}">{{$checkbox["index"]}}</label>
                </div>
                <div class="col-md-4">
                    {!! Form::text('extraCost['.$index.']', $checkbox["extraCost"], ['class' => 'form-control' , 'dir' => 'ltr' , 'placeholder'=>'قیمت افزوده - تومان']) !!}
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
            @else
                @if(isset($defaultExtraAttributes) && in_array($index,$defaultExtraAttributes) )
                    {!! Form::checkbox('extraAttribute[]', $index, null, ['class' => 'extraAttribute icheck' , 'checked' ,  'data-checkbox'=>'icheckbox_square-blue']) !!}{{$checkbox["index"]}}
                @else
                    {!! Form::checkbox('extraAttribute[]', $index, null, ['class' => 'extraAttribute icheck' ,  'data-checkbox'=>'icheckbox_square-blue']) !!}{{$checkbox["index"]}}
                @endif
                <span></span>
            @endif
        @endforeach
    @endforeach
@endif