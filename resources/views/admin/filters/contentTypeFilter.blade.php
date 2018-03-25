@if(isset($dropdownClass))
    {!! Form::select('rootContenttypes[]', $rootContentTypes , null, ['class' => 'form-control '.$dropdownClass, 'id' => 'rootContentTypes' ]) !!}
    {!! Form::select('childContenttypes[]', $childContentTypes , null, ['class' => 'form-control '.$dropdownClass, 'id' => 'childContentTypes' , 'disabled' ]) !!}
@else
    {!! Form::select('rootContenttypes[]', $rootContentTypes , null, ['class' => 'form-control ', 'id' => 'rootContentTypes' ]) !!}
    {!! Form::select('childContenttypes[]', $childContentTypes , null, ['class' => 'form-control ', 'id' => 'childContentTypes' , 'disabled' ]) !!}
@endif

