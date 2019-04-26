{!! Form::select('paymentStatuses[]', $paymentstatuses, null, ['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default a--full-width',
                        'id' => (isset($id))?$id:'paymentStatuses' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" ,
                        "data-height" => "200" , "title" => "وضعیت پرداخت"]) !!}

{{--<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"--}}{{--id="paymentStatuses" name="paymentStatuses[]" title="وضعیت پرداخت">--}}{{--@foreach($paymentstatuses as $key=>$value)--}}{{--<option value="{{$key}}">{{$value}}</option>--}}{{--@endforeach--}}{{--</select>--}}