@if(isset($attributegroup))
    <div class="form-body">
        <div class="note note-warning"><h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر
                الزامیست: </h4></div>
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="name"> نام گروه صفت</label>
            <div class="col-md-9">
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <br>
        <div class="note note-info"><h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری
                می باشد: </h4></div>
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="description"> توضیح گروه صفت</label>
            <div class="col-md-9">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description' ]) !!}
                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('attributes') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="attributes">صفت های گروه</label>
            <div class="col-md-9">
                {!! Form::select('attributes[]',$attributes,$groupAttributes,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'group_attributes' ]) !!}
                @if ($errors->has('attributes'))
                    <span class="help-block">
                        <strong>{{ $errors->first('attributes') }}</strong>
                    </span>
                @endif
            </div>
            <div class="clearfix margin-top-10">
                <span class="label label-info">توجه</span>
                <strong id="">ستون چپ صفت های انتخاب شده می باشند</strong>
            </div>
        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn yellow-haze' ] ) !!}
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
            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'attributegroupName' , 'placeholder'=>'نام گروه صفت']) !!}
            <span class="help-block" id="attributegroupNameAlert">
                <strong></strong>
            </span>
        </p>
    </div>
    <div class="col-md-12">
        <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد: </p>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <p>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'attributegroupDescription' , 'placeholder'=>'توضیح درباره گروه صفت']) !!}
            <span class="help-block" id="attributegroupDescriptionAlert">
                <strong></strong>
            </span>
        </p>

        <p>
            <label class="control-label">صفت ها</label>
            {!! Form::select('attributes[]',$attributes,null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'group_attributes']) !!}
            <span class="help-block" id="attributesAlert">
                    <strong></strong>
            </span>
        <div class="clearfix margin-top-10">
            <span class="label label-info">توجه</span>
            <strong id="">ستون چپ دسترسی های انتخاب شده می باشند</strong>
        </div>
        </p>
    </div>
    {!! Form::hidden('attributeset_id',$attributeset->id) !!}
@endif