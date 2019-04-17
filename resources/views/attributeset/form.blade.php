@if(isset($attributeset))
    {!! Form::hidden('id',$attributeset->id, ['class' => 'btn red']) !!}
    <div class="form-body">
        <div class="note note-warning">
            <h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر
                الزامیست:
            </h4>
        </div>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="name">نام دسته صفت</label>
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
        <br>
        <div class="note note-info">
            <h4 class="caption-subject font-dark bold uppercase">
                وارد کردن اطلاعات زیر اختیاری
                می باشد:
            </h4>
        </div>
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <div class="row">
                <label class="col-md-3 control-label" for="description">توضیح دسته صفت</label>
                <div class="col-md-9">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
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
                    {!! Form::submit('اصلاح', ['class' => 'btn btn-warning m-btn m-btn--icon m-btn--wide']) !!}
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
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'attributesetName' , 'placeholder'=>'نام دسته صفت']) !!}
            <span class="help-block" id="attributesetNameAlert">
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
            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'attributesetDescription'  , 'placeholder'=>'توضیح درباره دسته صفت']) !!}
            <span class="help-block" id="attributesetDescriptionAlert">
                <strong></strong>
            </span>
        </p>
    </div>
@endif