@if(!isset($excluded) || !in_array("order_id" , $excluded))
    @if(isset($transaction))
        @if(Auth::user()->can(Config::get("constants.EDIT_TRANSACTION_ORDERID_ACCESS")))
            <div class="row static-info margin-top-20">
                <div class="col form-group {{ $errors->has('order_id') ? ' has-danger' : '' }}">
                    <div class="row">
                        <label class="col-md-3 control-label" for="cost">آیدی سفارش</label>
                        <div class="col-md-6">
                            {!! Form::text('order_id',old('order_id'),['class' => 'form-control' , 'dir'=>'ltr' ]) !!}
                            @if ($errors->has('order_id'))
                                <span class="form-control-feedback">
                                <strong>{{ $errors->first('order_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row static-info margin-top-20">
                <div class="col form-group">
                    <div class="row">
                        <label class="col-md-3 control-label" for="cost">لینک اصلاح سفارش</label>
                        <div class="col-md-6">
                            <a target="_blank" href="{{action('Web\OrderController@edit' , $transaction->order)}}">کلیک کنید</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {!! Form::hidden('order_id',$transaction->order->id) !!}
        @endif
    @else
        {!! Form::hidden('order_id',$order->id) !!}
    @endif
@endif
@if(!isset($excluded) || !in_array("deadline_at" , $excluded))
    <div class="row static-info margin-top-20">
        <div class="col form-group {{ $errors->has('deadline_at') ? ' has-danger' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="transactionDeadlineAt">
                    @if(isset($withCheckbox) && in_array("deadline_at" , $withCheckbox))
                        <input type="checkbox" name="deadlineAtEnable" value="1" id="transactionDeadlineAtEnable">
                    @endif
                    مهلت پرداخت:
                </label>
                <div class="col-md-6">
                    <input id="transactionDeadlineAt" type="text" class="form-control"
                           @if(isset($deadlineAt))
                            value="{{$deadlineAt}}"
                           @elseif(strlen(old('deadline_at')) > 0)
                            value="{{old('deadline_at')}}"
                           @endif
                           dir="ltr"
                            {{(isset($withCheckbox) && in_array("deadline_at" , $withCheckbox))?"disabled":""}}>
                    <input name="deadline_at" id="transactionDeadlineAtAlt" type="text" class="form-control d-none">
                    @if ($errors->has('deadline_at'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('deadline_at') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endif
@if(!isset($excluded) || !in_array("completed_at" , $excluded))
    <div class="row static-info margin-top-20">
        <div class="col form-group {{ $errors->has('completed_at') ? ' has-danger' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="transactionCompletedAt">
                    @if(isset($withCheckbox) && in_array("completed_at" , $withCheckbox))
                        <input type="checkbox" name="completedAtEnable" value="1" id="transactionCompletedAtEnable">
                    @endif
                    تاریخ پرداخت:
                </label>
                <div class="col-md-6">
                    <input id="transactionCompletedAt" type="text" class="form-control"
                           @if(isset($completedAt))
                           value="{{$completedAt}}"
                           @elseif(strlen(old('completed_at')) > 0)
                           value="{{old('completed_at')}}"
                           @endif
                           dir="ltr"
                            {{(isset($withCheckbox) && in_array("completed_at" , $withCheckbox))?"disabled":""}}>
                    <input name="completed_at" id="transactionCompletedAtAlt" type="text" class="form-control d-none">
                    @if ($errors->has('completed_at'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('completed_at') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
<div class="row static-info margin-top-20">
    <div class="col form-group {{ ($errors->has('paymentmethod_id')) ? ' has-danger' : '' }}">
        <div class="row">
            <label class="col-md-3 control-label" for="{{(isset($name["paymentmethod"]))?$name["paymentmethod"]:'paymentmethod_id'}}">
                روش پرداخت:
            </label>
            <div class="col-md-6">
                {!! Form::select( (isset($name["paymentmethod"]))?$name["paymentmethod"]:'paymentmethod_id',$transactionPaymentmethods,old((isset($name["paymentmethod"]))?$name["paymentmethod"]:'paymentmethod_id'),[ 'class' => (isset($class["paymentmethod"]))?'form-control '.$class["paymentmethod"]:'form-control' , 'id' => (isset($id["paymentmethod"]))?$id["paymentmethod"]:'' , 'placeholder'=>'نامشخص']) !!}
                @if ($errors->has('paymentmethod_id'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('paymentmethod_id') }}</strong>
                    </span>
                @endif
            </div>
            @if(isset($options['withWalletWithdrawCheckbox']))
            <div class="col-md-2">
                <input type="checkbox" name="walletWithdraw" value="1" >برداشت از کیف پول(مخصوص تراکنش کیف پول)
            </div>
            @endif
        </div>
    </div>
</div>
<div class="row static-info margin-top-20">
    <div class="col form-group {{ $errors->has('transactiongateway_id') ? ' has-danger' : '' }}">
        <div class="row">
            <label class="col-md-3 control-label" for="{{(isset($name["transactionGateways"]))?$name["transactionGateways"]:'transactiongateway_id'}}">
                انتخاب درگاه:
            </label>
            <div class="col-md-6">
                {!!
                    Form::select(
                        (isset($name["transactionGateways"]))?$name["transactionGateways"]:'transactiongateway_id',
                        $transactionGateways,
                        old((isset($name["transactionGateways"]))?$name["transactionGateways"]:'transactiongateway_id'),
                        [
                            'class' => (isset($class["transactionGateways"]))?'form-control '.$class["transactionGateways"]:'form-control',
                            'id' => (isset($id["transactionGateways"]))?$id["transactionGateways"]:'transactiongateway_id',
                            'placeholder'=>'نامشخص'
                        ]
                    )
                !!}
                @if ($errors->has('transactiongateway_id'))
                    <span class="form-control-feedback">
                            <strong>{{ $errors->first('transactiongateway_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
@if(isset($defaultValues) && array_has( $defaultValues , "transactionstatus" ))
    {!! Form::hidden("transactionstatus_id" , $defaultValues["transactionstatus"]) !!}
@elseif(!isset($excluded) || !in_array("transactionstatus" , $excluded))
    <div class="row static-info margin-top-20">
        <div class="col form-group {{ $errors->has('transactionstatus_id') ? ' has-danger' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="transactionstatus_id">وضعیت:</label>
                <div class="col-md-6">
                    {!! Form::select('transactionstatus_id',$transactionStatuses,old('transactionstatus_id'),['class' => 'form-control', 'id' => 'transactionstatus_id']) !!}
                    @if ($errors->has('transactionstatus_id'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('transactionstatus_id') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
<div class="row static-info margin-top-20">
    <div class="col form-group {{ $errors->has('cost') ? ' has-danger' : '' }}">
        <div class="row">
            <label class="col-md-3 control-label" for="cost">مبلغ(تومان):</label>
            <div class="col-md-6">
                {!! Form::text('cost',old("cost") ,['class' => 'form-control' , 'dir'=>'ltr' ,'id'=>(isset($id["cost"]))?$id["cost"]:""]) !!}
                @if ($errors->has('cost'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('cost') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row static-info margin-top-20">
    <div class="col form-group {{ $errors->has('referenceNumber') ? ' has-danger' : '' }}">
        <div class="row">
            <label class="col-md-3 control-label" for="referenceNumber">شماره مرجع:</label>
            <div class="col-md-6">
                {!! Form::text('referenceNumber',old('referenceNumber'),['class' => 'form-control', 'dir'=>'ltr' ]) !!}
                @if ($errors->has('referenceNumber'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('referenceNumber') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row static-info margin-top-20">
    <div class="col form-group {{ $errors->has('traceNumber') ? ' has-danger' : '' }}">
        <div class="row">
            <label class="col-md-3 control-label" for="traceNumber">شماره پیگیری:</label>
            <div class="col-md-6">
                {!! Form::text('traceNumber',old('traceNumber'),['class' => 'form-control', 'dir'=>'ltr' ]) !!}
                @if ($errors->has('traceNumber'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('traceNumber') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

@if(!isset($excluded) || !in_array("authority" , $excluded))
    <div class="row static-info margin-top-20">
        <div class="col form-group {{ $errors->has('authority') ? ' has-danger' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="authority">Authority(برای پرداخت آنلاین):</label>
                <div class="col-md-6">
                    {!! Form::text('authority',old('authority'),['class' => 'form-control', 'dir'=>'ltr' ]) !!}
                    @if ($errors->has('authority'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('authority') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
<div class="row static-info margin-top-20">
    <div class="col form-group {{ $errors->has('transactionID') ? ' has-danger' : '' }}">
        <div class="row">
            <label class="col-md-3 control-label" for="transactionID">شماره تراکنش(برای آنلاین):</label>
            <div class="col-md-6">
                {!! Form::text('transactionID',old('transactionID'),['class' => 'form-control', 'dir'=>'ltr' ]) !!}
                @if ($errors->has('transactionID'))
                    <span class="form-control-feedback">
                <strong>{{ $errors->first('transactionID') }}</strong>
            </span>
                @endif
            </div>
        </div>
    </div>
</div>
@if(!isset($excluded) || !in_array("paycheckNumber" , $excluded))
    <div class="row static-info margin-top-20">
        <div class="col form-group {{ $errors->has('paycheckNumber') ? ' has-danger' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="paycheckNumber">شماره چک(برای پرداخت با چک):</label>
                <div class="col-md-6">
                    {!! Form::text('paycheckNumber',old('paycheckNumber'),['class' => 'form-control' ]) !!}
                    @if ($errors->has('paycheckNumber'))
                        <span class="form-control-feedback">
                        <strong>{{ $errors->first('paycheckNumber') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
<div class="row static-info margin-top-20">
    <div class="col form-group {{ $errors->has('managerComment') ? ' has-danger' : '' }}">
        <div class="row">
            <label class="col-md-3 control-label" for="managerComment">توضیح مدیریتی:</label>
            <div class="col-md-6">
                {!! Form::text('managerComment',old('managerComment'),['class' => 'form-control' ]) !!}
                @if ($errors->has('managerComment'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('managerComment') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

