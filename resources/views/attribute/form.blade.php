@if(isset($attribute))
    {!! Form::hidden('id',$attribute->id, ['class' => 'btn red']) !!}
    <div class="form-body">
        <div class="note note-warning"><h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر
                الزامیست: </h4></div>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="name">نام صفت</label>
            <div class="col-md-9">
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group {{ $errors->has('displayName') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="displayName">نام قابل نمایش</label>
            <div class="col-md-9">
                {!! Form::text('displayName', null, ['class' => 'form-control', 'id' => 'displayName' ]) !!}
                @if ($errors->has('displayName'))
                    <span class="help-block">
                    <strong>{{ $errors->first('displayName') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('attributecontrol_id') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="attributecontrol_id">نوع کنترل صفت</label>
            <div class="col-md-9">
                {!! Form::select('attributecontrol_id',$attributecontrols,null,['class' => 'form-control', 'id' => 'attributecontrol_id' , 'placeholder' => 'نوع کنترل صفت را مشخص کنید']) !!}
                @if ($errors->has('attributecontrol_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('attributecontrol_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <br>
        <div class="note note-info"><h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری
                می باشد: </h4></div>

        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="description">توضیح صفت</label>
            <div class="col-md-9">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
                @if ($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn yellow-mint']) !!}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-12">
        <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر الزامی می باشد: </p>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <p>
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'attributeName' , 'placeholder'=>'نام صفت']) !!}
            <span class="help-block" id="attributeNameAlert">
                    <strong></strong>
            </span>
        </p>

        <p>
            {!! Form::text('displayName', null, ['class' => 'form-control', 'id' => 'attributeDisplayName'  , 'placeholder'=>'نام قابل نمایش']) !!}
            <span class="help-block" id="attributeDisplayNameAlert">
                    <strong></strong>
            </span>
        </p>
        <p>
            {!! Form::select('attributecontrol_id',$attributecontrols,null,['class' => 'form-control', 'id' => 'attributeControlID' , 'placeholder' => 'نوع کنترل صفت را مشخص کنید ' ])!!}
            <span class="help-block" id="attributeControlIDAlert">
                <strong></strong>
            </span>
        </p>
    </div>
    <div class="col-md-12">
        <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد: </p>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <br>
        <p>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'attributeDescription'  , 'placeholder'=>'توضیح درباره صفت']) !!}
            <span class="help-block" id="attributeDescriptionAlert">
                    <strong></strong>
            </span>
        </p>

    </div>
@endif