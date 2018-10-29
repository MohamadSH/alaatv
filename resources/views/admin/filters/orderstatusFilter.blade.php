{!! Form::select('orderStatuses[]', $orderstatuses, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default',
                        'id' => (isset($id))?$id:'orderStatuses' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" ,
                        "data-height" => "200" , "title" => "وضعیت سفارش"]) !!}
{{--<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"--}}
{{--id="orderStatuses" name="orderStatuses[]" title="وضعیت سفارش">--}}
{{--@foreach($orderstatuses as $key=>$value)--}}
{{--<option value="{{$key}}">{{$value}}</option>--}}
{{--@endforeach--}}
{{--</select>--}}