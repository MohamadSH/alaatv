<div class = "form-body">
    <div class = "form-group">
        <div class = "row">
            <label class = "col-md-4 control-label">تیتر اسلاید</label>
            <div class = "col-md-6">
                {!! Form::text('title' , null, ['class' => 'form-control', 'placeholder'=>'عنوان نمایش داده شده روی عکس' , 'required']) !!}
                <span class="form-control-feedback">  </span>
            </div>
        </div>
    </div>
    <div class = "form-group">
        <div class = "row">
            <label class = "col-md-4 control-label">متن اسلاید</label>
            <div class = "col-md-6">
                {!! Form::text('shortDescription' , null, ['class' => 'form-control', 'placeholder'=>'متن کوتاه زیر عنوان']) !!}
                <span class="form-control-feedback">  </span>
            </div>
        </div>
    </div>
    <div class = "form-group">
        <div class = "row">
            <label class = "col-md-4 control-label">لینک اسلاید</label>
            <div class = "col-md-6">
                {!! Form::text('link' , null, ['class' => 'form-control default','placeholder'=>'با کلیک بر روی اسلاید باز می شود']) !!}
                <span class="form-control-feedback">  </span>
            </div>
        </div>
    </div>
    <div class = "form-group">
        <div class = "row">
            <label class = "col-md-4 control-label">صفحه اسلایدشو</label>
            <div class = "col-md-6">
                {!! Form::select(
                    'websitepage_id',
                    $websitePages,
                    null,
                    [
                        "class" => "form-control",
                    ])
                !!}
                <span class="form-control-feedback"></span>
            </div>
        </div>
    </div>
    <div class = "form-group">
        <div class = "row">
            <label class = "col-md-4 control-label">ترتیب</label>
            <div class = "col-md-6">
                {!! Form::text('order' , null, ['class' => 'form-control', 'placeholder'=>'ترتیب قرار گرفتن در بین اسلایدها']) !!}
                <span class="form-control-feedback">  </span>
            </div>
        </div>
    </div>
    <div class = "form-group {{ $errors->has('photo') ? ' has-danger' : '' }}">
        <div class = "row">
            <label class = "col-md-4 control-label" for = "questionFile">عکس اسلاید</label>
            <div class = "col-md-6">
                <div class = "fileinput fileinput-new" data-provides = "fileinput">
                    @if(isset($slide->photo))
                        <div class = "fileinput-new thumbnail">
                            <img style="width:100%" src = "{{ $slide->url }}" {{--alt="عکس خدمت" onerror="this.src='http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image';"/> </div>--}}alt = "عکس محصول @if(isset($slide->title[0])) {{$slide->title}} @endif"/>
                        </div>
                    @endif
                    <div class = "input-group input-large ">
                        <div class = "form-control uneditable-input input-fixed input-medium" data-trigger = "fileinput">
                            <i class = "fa fa-file fileinput-exists"></i>&nbsp;
                            <span class = "fileinput-filename"> @if(isset($slide->photo) && strlen($slide->photo)>0) {{$slide->photo}} @endif</span>
                        </div>
                        <span class = "input-group-addon btn default btn-file">
                            <span class = "fileinput-new btn m-btn--pill m-btn--air btn-info btn-sm"> انتخاب فایل </span>
                            <span class = "fileinput-exists btn m-btn--pill m-btn--air btn-warning btn-sm"> تغییر </span>
                            {!! Form::file('photo' ) !!}
                        </span>
                        <a href = "javascript:" class = "input-group-addon btn m-btn--pill m-btn--air btn-danger btn-sm fileinput-exists" data-dismiss = "fileinput">حذف</a>
                    </div>
                </div>
                @if ($errors->has('photo'))
                    <span class="form-control-feedback">
                        <strong>{{ $errors->first('photo') }}</strong>
                    </span>
                @endif
                <span class = "form-control-feedback bold">
                    <span class = "m-badge m-badge--wide label-sm m-badge--info"><strong>توجه!</strong></span>بهترین اندازه 500*1280 است
                </span>
            </div>
        </div>
    </div>
    <div class = "form-group">
        <div class = "row">
            <div class = "col-md-3"></div>
            <div class = "col-md-9">
                <label class = "mt-checkbox mt-checkbox-outline">
                    <div class = "md-checkbox">
                        {!! Form::checkbox('in_new_tab', '1', null,  ['value' => '1' , 'id' => 'checkbox_in_new_tab' , 'class'=>'md-check']) !!}
                        <label for = "checkbox_in_new_tab">
                            <span></span>
                            <span class = "check"></span>
                            <span class = "box"></span>
                            در تب جدید باز شود
                            <span></span>
                        </label>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <div class = "form-group {{ $errors->has('isEnable') ? ' has-danger' : '' }}">
        <div class = "row">
            <div class = "col-md-3"></div>
            <div class = "col-md-9">
                <label class = "mt-checkbox mt-checkbox-outline">
                    <div class = "md-checkbox">
                        @if(isset($slide))
                            {!! Form::checkbox('isEnable', '1', null,  ['value' => '1' , 'id' => 'checkbox_isEnable' , 'class'=>'md-check']) !!}
                        @else
                            {!! Form::checkbox('isEnable', '1', null,  ['value' => '1' , 'id' => 'checkbox_isEnable' , 'class'=>'md-check' , 'checked']) !!}
                        @endif
                        <label for = "checkbox_isEnable">
                            <span></span>
                            <span class = "check"></span>
                            <span class = "box"></span>
                            فعال/غیرفعال
                            <span></span>
                        </label>
                    </div>
                </label>
            </div>
        </div>
    </div>
    @permission((Config::get('constants.EDIT_SLIDESHOW_ACCESS')))
    @if(isset($slide))
        <button type = "submit" class = "btn m-btn--air btn-warning">اصلاح</button>
    @endif
    @endpermission
</div>
