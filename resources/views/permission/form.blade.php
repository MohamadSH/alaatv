@if(isset($permission))
    {!! Form::hidden('id',$permission->id, ['class' => 'btn red']) !!}
    <div class="form-body">
        <div class="note note-warning">
            <h4 class="caption-subject font-dark bold uppercase">
                وارد کردن اطلاعات زیر
                الزامیست:
            </h4>
        </div>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="name">نام دسترسی</label>
                <div class="col-md-9">
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('display_name') ? ' has-error' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="display_name">نام قابل نمایش دسترسی</label>
                <div class="col-md-9">
                {!! Form::text('display_name', null, ['class' => 'form-control', 'id' => 'display_name' ]) !!}
                @if ($errors->has('display_name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('display_name') }}</strong>
                </span>
                @endif
            </div>
            </div>
        </div>
        <br>
        <div class="note note-info">
            <h4 class="caption-subject font-dark bold uppercase">
                وارد کردن اطلاعات زیر اختیاری
                می باشد:
            </h4>
        </div>
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="description">توضیح دسترسی</label>
                <div class="col-md-9">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description' ]) !!}
                    @if ($errors->has('description'))
                        <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn m-btn--air btn-primary']) !!}
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
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'permissionName' , 'placeholder'=>'نام دسترسی']) !!}
            <span class="help-block" id="permissionNameAlert">
                <strong></strong>
            </span>
        </p>

        <p>
            {!! Form::text('display_name', null, ['class' => 'form-control', 'id' => 'permissionDisplayName'  , 'placeholder'=>'نام قابل نمایش']) !!}
            <span class="help-block" id="permissionDisplayNameAlert">
                <strong></strong>
            </span>
        </p>
    </div>
    <div class="col-md-12">
        <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد: </p>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <p>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'permissionDescription'  , 'placeholder'=>'توضیح درباره دسترسی']) !!}
            <span class="help-block" id="permissionDescriptionAlert">
                <strong></strong>
            </span>
        </p>
    </div>
@endif