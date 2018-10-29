@if(isset($caption))
    {!! Form::select('users[]', $users, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default',
                            "id"=>"selectUserFilter","data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" ,
                            "data-height" => "200" , "title" => $caption ]) !!}
@else
    {!! Form::select('users[]', $users, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default',
                        "id"=>"selectUserFilter" , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" ,
                        "data-height" => "200" , "title" => "انتخاب کاربر" ]) !!}
@endif