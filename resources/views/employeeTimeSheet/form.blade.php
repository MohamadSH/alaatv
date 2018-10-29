<div class="col-md-12">
    <div class="form-group">
        @if(Auth::user()->can(Config::get('constants.INSERT_EMPLOPYEE_WORK_SHEET')))
            {{--<label class=" col-md-4 control-label" for="date">انتخاب کارمند</label>--}}
            @if(!isset($employeetimesheet))
                <div class="col-md-2 {{ $errors->has('user_id') ? ' has-error' : '' }}">
                    {!! Form::select("user_id" , $employees, null , ["class" => "form-control" , "placeholder" => "انتخاب کارمند"]) !!}
                    @if ($errors->has('user_id'))
                        <span class="help-block">
                        <strong>{{ $errors->first('user_id') }}</strong>
                    </span>
                    @endif
                </div>
            @endif
            {{--<label class=" col-md-2 control-label" for="date">انتخاب تاریخ</label>--}}
            <div class="col-md-2 {{ $errors->has('date') ? ' has-error' : '' }}">
                <input type="text" class="form-control text-center" id="date"
                       value="@if(isset($employeetimesheet->date)){{$employeetimesheet->getOriginal("date")}}@endif"
                       dir="ltr">
                {!! Form::text('date', null, ['class' => 'form-control hidden', 'id' => 'dateAlt'  ]) !!}
                @if ($errors->has('date'))
                    <span class="help-block">
                    <strong>{{ $errors->first('date') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success btn-sm  pull-right"><i class="fa fa-check"></i> ذخیره
                    اطلاعات
                </button>
            </div>
        @else
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> ذخیره اطلاعات</button>
            </div>
        @endif
    </div>
    <hr>
</div>
<div class="col-md-5 col-sm-5">
    <div class="form-group">
        <label class=" col-md-3 col-sm-3 control-label" for="clockIn" style="text-align: center">ورود</label>
        <div class="col-md-4 col-sm-4">
            {!! Form::text('clockIn', null, ['class' => 'form-control text-center', 'id' => 'clockIn' , 'placeholder'=>'00:00' , 'dir'=>'ltr' ]) !!}
        </div>
        @if(!Auth::user()->can(Config::get('constants.INSERT_EMPLOPYEE_WORK_SHEET')))
            <div class="col-md-5 col-sm-5 col-xs-12 text-stat text-center">
                <span class="label label-sm label-info"> شروع شیفت: @if(isset($employeeSchedule)){{$employeeSchedule->beginTime}}@endif </span>
            </div>
        @else
            <label class=" col-md-2 col-sm-2 control-label" for="userBeginTime" style="text-align: center">شروع
                شیفت:</label>
            <div class="col-md-3 col-sm-3">
                {!! Form::text('userBeginTime', null, ['class' => 'form-control text-center', 'id' => 'userBeginTime' , 'placeholder'=>'00:00' , 'dir'=>'ltr' ]) !!}
            </div>
        @endif
    </div>
    <div class="form-group">
        <label class=" col-md-3 col-sm-3 control-label" for="beginLunchBreak" style="text-align: center">خروج
            ناهار</label>
        <div class="col-md-4 col-sm-4">
            {!! Form::text('beginLunchBreak', null, ['class' => 'form-control text-center', 'id' => 'beginLunchBreak' , 'placeholder'=>'00:00' , 'dir'=>'ltr' ]) !!}
        </div>
    </div>
    <div class="form-group">
        <label class=" col-md-3 col-sm-3 control-label" for="finishLunchBreak" style="text-align: center">ورود بعد
            ناهار</label>
        <div class="col-md-4 col-sm-4">
            {!! Form::text('finishLunchBreak', null, ['class' => 'form-control text-center', 'id' => 'finishLunchBreak' , 'placeholder'=>'00:00' , 'dir'=>'ltr' ]) !!}
        </div>
    </div>
    <div class="form-group">
        <label class=" col-md-3 col-sm-3 control-label" for="clockOut" style="text-align: center">خروج نهایی</label>
        <div class="col-md-4 col-sm-4">
            {!! Form::text('clockOut', null, ['class' => 'form-control text-center', 'id' => 'clockOut' , 'placeholder'=>'00:00' , 'dir'=>'ltr' ]) !!}
        </div>
        @if(!Auth::user()->can(Config::get('constants.INSERT_EMPLOPYEE_WORK_SHEET')))
            <div class="col-md-5 col-sm-5 col-xs-12 text-stat">
                <span class="label label-sm label-info text-center"> پایان شیفت: @if(isset($employeeSchedule)){{$employeeSchedule->finishTime}}@endif </span>
            </div>
        @else
            <label class=" col-md-2 col-sm-2 control-label" for="userFinishTime" style="text-align: center">پایان
                شیفت:</label>
            <div class="col-md-3 col-sm-3">
                {!! Form::text('userFinishTime', null, ['class' => 'form-control text-center', 'id' => 'userFinishTime' , 'placeholder'=>'00:00' , 'dir'=>'ltr' ]) !!}
            </div>
        @endif
    </div>
    <div class="form-group">
        <label class=" col-md-3 col-sm-3 control-label" for="breakDurationInSeconds" style="text-align: center">استراحت(کسری)</label>
        <div class="col-md-4 col-sm-4">
            {!! Form::text('breakDurationInSeconds', null, ['class' => 'form-control text-center', 'id' => 'breakDurationInSeconds' , 'placeholder'=>'00:00' , 'dir'=>'ltr' ]) !!}
        </div>
    </div>
    @permission(Config::get('constants.INSERT_EMPLOPYEE_WORK_SHEET'))
    <div class="form-group">
        <label class=" col-md-3 col-sm-3 control-label" for="allowedLunchBreakInSec" style="text-align: center">زمان
            ناهار</label>
        <div class="col-md-4 col-sm-4">
            {!! Form::text('allowedLunchBreakInSec', null, ['class' => 'form-control text-center', 'id' => 'allowedLunchBreakInSec' , 'placeholder'=>'00:00' , 'dir'=>'ltr' ]) !!}
        </div>
    </div>
    @endpermission

</div>
<div class="col-md-7 col-sm-7">
    <div class="form-group">
        <div class="col-md-12">
            {!! Form::textarea('employeeComment', (isset($userTimeSheet))? $userTimeSheet->employeeComment : null, ['class' => 'form-control', 'id' => 'employeeCommentSummerNote'  ]) !!}
        </div>
    </div>

</div>
<div class="col-md-12">
    <div class="form-group text-center">
        <div class="col-md-12">
            <div class="input-group">
                <div class="icheck-inline">
                    <label>
                        {!! Form::checkbox('timeSheetLock', '1', (isset($employeetimesheet) )? $employeetimesheet->getOriginal("timeSheetLock") : null ,  ['value' => '1'  , 'class'=>'icheck' ,'data-checkbox'=>'icheckbox_line-red' , 'data-label'=>'قفل کردن'  ]) !!}
                    </label>
                    <label>
                        {!! Form::checkbox('isExtraDay', '1', (isset($isExtra))? $isExtra : null,  ['value' => '1'  , 'class'=>'icheck' ,'data-checkbox'=>'icheckbox_line-orange' , 'data-label'=>'به عنوان روز خاص ثبت شود' ]) !!}
                    </label>
                    {{--@permission((Config::get('constants.INSERT_EMPLOPYEE_WORK_SHEET')))--}}
                    <label>
                        {!! Form::checkbox('isPaid', '1', (isset($employeetimesheet) )? $employeetimesheet->getOriginal("isPaid") : null,  ['value' => '1'  , 'class'=>'icheck' ,'data-checkbox'=>'icheckbox_line-blue' , 'data-label'=>'تسویه شده' , (isset($employeetimesheet) )? "" : "checked"  ]) !!}
                    </label>
                    {{--@endpermission--}}

                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    @permission(Config::get('constants.INSERT_EMPLOPYEE_WORK_SHEET'))
    <div class="form-group">
        <div class="col-md-12">
            {!! Form::textarea('managerComment', (isset($userTimeSheet))? $userTimeSheet->managerComment : null, ['class' => 'form-control', 'id' => 'managerCommentSummerNote'  ]) !!}
        </div>
    </div>
    @endpermission
</div>
