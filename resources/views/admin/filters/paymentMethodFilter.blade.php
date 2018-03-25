{!! Form::select('paymentMethods[]', $paymentMethods, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default',
                        'id' => 'paymentMethods' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" ,
                        "data-height" => "200" , "title" => "نحوه پرداخت"]) !!}

{{--<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"--}}
        {{--id="paymentMethods" name="paymentMethods[]" title="نحوه پرداخت">--}}
    {{--@foreach($paymentMethods as $key=>$value)--}}
        {{--<option value="{{$key}}">{{$value}}</option>--}}
    {{--@endforeach--}}
{{--</select>--}}