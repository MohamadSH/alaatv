@if(isset($articlecategory))
    <div class = "form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
        <span class = "required" aria-required = "true"> * </span>
        <label class = "col-md-3 control-label" for = "name">نام دسته</label>
        <div class = "col-md-9">
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
            @if ($errors->has('name'))
                <span class="form-control-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class = "form-body">
        <div class = "form-group {{ $errors->has('enable') ? ' has-danger' : '' }}">
            <label class = "col-md-3 control-label" for = "enable">فعال بودن دسته</label>
            <div class = "col-md-9">
                {!! Form::checkbox('enable', '1', null, ['class' => '', 'id' => 'enable' ]) !!}
                @if ($errors->has('enable'))
                    <span class="form-control-feedback">
                    <strong>{{ $errors->first('enable') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class = "form-group {{ $errors->has('order') ? ' has-danger' : '' }}">
            <label class = "col-md-3 control-label" for = "order">ترتیب دسته</label>
            <div class = "col-md-9">
                {!! Form::text('order', null, ['class' => 'form-control', 'id' => 'order' ]) !!}
                @if ($errors->has('order'))
                    <span class="form-control-feedback">
                    <strong>{{ $errors->first('order') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class = "form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
            <label class = "col-md-3 control-label" for = "description">توضیح دسته</label>
            <div class = "col-md-9">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'articlecategoryDescription' ]) !!}
                @if ($errors->has('description'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('description') }}</strong>
                     </span>
                @endif
            </div>
        </div>
        <div class = "form-actions">
            <div class = "row">
                <div class = "col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn blue-steel' ] ) !!}
                </div>
            </div>
        </div>
    </div>
@else
    <div class = "col-md-8 col-md-offset-2">
        <p>
            <span class = "required m--font-danger" aria-required = "true"> * </span>
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'articlecategoryName' , 'placeholder'=>'نام دسته']) !!}
            <span class="form-control-feedback" id = "articlecategoryNameAlert">
                <strong></strong>
            </span>
        </p>
        <p>
            {!! Form::text('order', null, ['class' => 'form-control', 'id' => 'articlecategoryOrder' , 'placeholder'=>'ترتیب دسته']) !!}
            <span class="form-control-feedback" id = "articlecategoryOrderAlert">
                <strong></strong>
            </span>
        </p>
        <p>
            <label class = "control-label" for = "enable">فعال بودن دسته</label>
            <label class = "mt-checkbox mt-checkbox-outline">
                {!! Form::checkbox('enable', '1', 'checked', ['class' => 'form-control', 'id' => 'articlecategoryEnable']) !!}
                <span class="form-control-feedback" id = "articlecategoryEnableAlert">
                    <strong></strong>
                </span>
            </label>
        </p>
        <p>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'articlecategoryDescription' , 'placeholder'=>'توضیح دسته']) !!}
            <span class="form-control-feedback" id = "articlecategoryDescriptionAlert">
                <strong></strong>
            </span>
        </p>
    </div>
@endif