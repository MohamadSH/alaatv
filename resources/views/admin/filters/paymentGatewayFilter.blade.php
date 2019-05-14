{!! Form::select(
    'transactiongateway_id',
    $paymentGateways,
    null,
    [
        "id" => "transactionGateWayType",
        "class" => "form-control",
        "placeholder" => "درگاه پرداخت"
    ])
!!}

{{--<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200"--}}{{--id="paymentMethods" name="paymentMethods[]" title="نحوه پرداخت">--}}{{--@foreach($paymentMethods as $key=>$value)--}}{{--<option value="{{$key}}">{{$value}}</option>--}}{{--@endforeach--}}{{--</select>--}}