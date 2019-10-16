<div class = "form-group">
    <label class = "mt-checkbox mt-checkbox-outline">
        <div class = "md-checkbox">
            @if(!isset($content)  || $content->enable)
                {!! Form::checkbox('enable', '1', null,  ['value' => '1' , 'id' => 'checkbox_enable' , 'class'=>'md-check' , 'checked']) !!}
            @else
                {!! Form::checkbox('enable', '1', null,  ['value' => '1' , 'id' => 'checkbox_enable' , 'class'=>'md-check' ]) !!}
            @endif

            <label for = "checkbox_enable">
                <span></span>
                <span class = "check"></span>
                <span class = "box"></span>
                فعال بودن
                <span></span>
            </label>
        </div>
    </label>
</div>
<div class = "form-group {{ $errors->has('validSinceDate') ? ' has-danger' : '' }}">
    <label class = "control-label" for = "validSinceDate">نمایان شدن برای کاربران</label>
    <input id = "validSinceDate" type = "text" class = "form-control" value = "@if(isset($validSinceDate)) {{$validSinceDate}} @else {{old('validSinceDate')}} @endif" dir = "ltr">
    <input name = "validSinceDate" id = "validSinceDateAlt" type = "text" class = "form-control d-none">
    <input class = "form-control" name = "validSinceTime" id = "validSinceTime" placeholder = "00:00" value = "@if(isset($validSinceTime)){{$validSinceTime}} @else{{old('validSinceTime')}}@endif" dir = "ltr">
</div>
@if(isset($include) && isset($include['set']))
    <div class = "form-group {{ $errors->has('contentset_id') ? ' has-danger' : '' }}">
        <label class = "control-label" for = "name">انتخاب دسته :</label>
        {!! Form::select('contentset_id',$contentSets) !!}
        @if ($errors->has('contentset_id'))
            <span class="form-control-feedback">
                    <strong>{{ $errors->first('contentset_id') }}</strong>
            </span>
        @endif
    </div>
@endif
<div class = "form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
    <label class = "control-label" for = "name">عنوان :</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'maxlength'=>'100' ]) !!}
        @if ($errors->has('name'))
            <span class="form-control-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
</div>
<div class="form-group {{ $errors->has('order') ? ' has-danger' : '' }}">
    <label class="control-label" for="order">ترتیب :</label>
    {!! Form::text('order', null, ['class' => 'form-control', 'id' => 'order']) !!}
    @if ($errors->has('order'))
        <span class="form-control-feedback">
                <strong>{{ $errors->first('order') }}</strong>
            </span>
    @endif
</div>
<div class="form-group {{ $errors->has('contentset_id') ? ' has-danger' : '' }}">
    <label class="control-label" for="order">ست :</label>
    {!! Form::text('contentset_id', null, ['class' => 'form-control', 'id' => 'contentset_id']) !!}
    @if ($errors->has('contentset_id'))
        <span class="form-control-feedback">
                <strong>{{ $errors->first('contentset_id') }}</strong>
            </span>
    @endif
</div>
<div class = "form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
    <label class = "control-label" for = "description">توضیح:</label>
    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'descriptionSummerNote', 'rows' => '15' ]) !!}

    @if ($errors->has('description'))
        <span class="form-control-feedback">
                <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>
<div class = "form-group {{ $errors->has('context') ? ' has-danger' : '' }}">
    <label class = "control-label" for = "description">متن مقاله:</label>
    {!! Form::textarea('context', null, ['class' => 'form-control', 'id' => 'contextSummerNote', 'rows' => '15' ]) !!}

    @if ($errors->has('context'))
        <span class="form-control-feedback">
                <strong>{{ $errors->first('context') }}</strong>
        </span>
    @endif
</div>
<div class = "form-group">
    <label class = "control-label" for = "description">تگ:</label>
    <input name="tags" type="text" id="contentSetTags" class="form-control input-large"  data-role="tagsinput">
</div>

@if(isset($include) && isset($include['file']))
<div class = "form-group {{ $errors->has('file') ? ' has-danger' : '' }}">
    <div class = "text-center">
        <div class = "fileinput fileinput-new" data-provides = "fileinput">
                                                        <span class = "btn-file">
                                                            <span class = "fileinput-new btn btn-success"><i class = "fa fa-plus"></i>انتخاب فایل سوال آزمون/فایل جزوه</span>
                                                            <span class = "fileinput-exists btn"> تغییر </span>
                                                            <input type = "file" name = "file"> </span>
            <a href = "javascript:" class = "btn red fileinput-exists" id = "file-remove" data-dismiss = "fileinput"> حذف</a>
            <div class = "clearfix margin-top-10">
                <span class = "m-badge m-badge--wide m-badge--danger">توجه</span>
                فرمت مجاز: pdf
            </div>
        </div>
        @if ($errors->has('file'))
            <span class="form-control-feedback">
                        <strong>{{ $errors->first('file') }}</strong>
            </span>
        @endif
    </div>
</div>

<hr>

<div class = "form-group {{ $errors->has('file2') ? ' has-danger' : '' }}">
    <div class = "text-center">
        <div class = "fileinput fileinput-new" data-provides = "fileinput">
                                                        <span class = "btn-file">
                                                            <span class = "fileinput-new btn btn-success"><i class = "fa fa-plus"></i>انتخاب فایل پاسخ(آزمون)</span>
                                                            <span class = "fileinput-exists btn"> تغییر </span>
                                                            <input type = "file" name = "file2"> </span>
            <a href = "javascript:" class = "btn red fileinput-exists" id = "file-remove" data-dismiss = "fileinput"> حذف</a>
            <div class = "clearfix margin-top-10">
                <span class = "m-badge m-badge--wide m-badge--danger">توجه</span>
                فرمت مجاز: pdf
            </div>
        </div>
        @if ($errors->has('file2'))
            <span class="form-control-feedback">
                    <strong>{{ $errors->first('file2') }}</strong>
            </span>
        @endif
    </div>
</div>
@endif

<button type = "submit" class = "btn btn-success"><i class = "fa fa-check"></i>ذخیره</button>
