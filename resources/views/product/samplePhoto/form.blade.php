<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }} col-md-12">
    <label class="col-md-3 control-label" for="productPhotoTitle">عنوان</label>
    <div class="col-md-9">
        {!! Form::text('title', old('title') , ['class' => 'form-control' , 'id'=>'productPhotoTitle']) !!}
        @if ($errors->has('title'))
            <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('order') ? ' has-error' : '' }} col-md-12">
    <label class="col-md-3 control-label" for="productPhotoOrder">ترتیب</label>
    <div class="col-md-9">
        {!! Form::text('order', (isset($defaultProductPhotoOrder))?$defaultProductPhotoOrder : old('order'), ['class' => 'form-control' , 'id'=>'productPhotoOrder' , 'dir'=>'ltr']) !!}
        @if ($errors->has('order'))
            <span class="help-block">
            <strong>{{ $errors->first('order') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('file') ? ' has-error' : '' }} col-md-12">
    <label class="col-md-3 control-label" for="productPhoto">عکس</label>
    <div class="col-md-9">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="input-group input-large ">
                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                    <span class="fileinput-filename"> @if(isset($productPhoto->file)) {{$productPhoto->file}} @endif</span>
                </div>
                <span class="input-group-addon btn default btn-file">
                                                        <span class="fileinput-new"> انتخاب فایل </span>
                                                        <span class="fileinput-exists"> تغییر </span>
                    {!! Form::file('file' , ['id'=>'productPhoto']) !!} </span>
                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
            </div>
        </div>
        @if ($errors->has('file'))
            <span class="help-block">
            <strong>{{ $errors->first('file') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('description') ? ' has-error' : '' }} col-md-12">
    <label class="col-md-3 control-label" for="productPhotoDescription">توضیح کوتاه</label>
    <div class="col-md-9">
        {!! Form::text('description', old('description') , ['class' => 'form-control' , 'id'=>'productPhotoDescription']) !!}
        @if ($errors->has('description'))
            <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('enable') ? ' has-error' : '' }} col-md-12">
    <label class="col-md-3"></label>
    <div class="col-md-9">
        <div class="mt-checkbox-list">
            <label class="mt-checkbox mt-checkbox-outline bold">  فعال بودن
                <input type="checkbox" value="1" name="enable" @if(isset($productPhoto->enable) && $productPhoto->enable == 1) checked @endif/>
                <span></span>
            </label>
        </div>
    </div>
</div>
