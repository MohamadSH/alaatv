@if(isset($consultation))
    <div class = "form-body">
        <div class = "form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "name">عنوان</label>
                <div class = "col-md-9">
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                    @if ($errors->has('name'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('videoPageLink') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "videoPageLink">فیلم تجزیه تحلیل</label>
                <div class = "col-md-9">
                    {!! Form::text('videoPageLink', null, ['class' => 'form-control', 'id' => 'videoPageLink' ]) !!}
                    @if ($errors->has('videoPageLink'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('videoPageLink') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('textScriptLink') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "textScriptLink">فیلم تجزیه تحلیل</label>
                <div class = "col-md-9">
                    {!! Form::text('textScriptLink', null, ['class' => 'form-control', 'id' => 'textScriptLink' ]) !!}
                    @if ($errors->has('textScriptLink'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('textScriptLink') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('consultationstatus_id') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "consultationstatus_id">وضعیت</label>
                <div class = "col-md-9">
                    {!! Form::select('consultationstatus_id',$consultationStatuses,null,['class' => 'form-control', 'id' => 'consultationstatus']) !!}
                    @if ($errors->has('consultationstatus_id'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('consultationstatus_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('majors') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "major_id">رشته</label>
                <div class = "col-md-9">
                    {!! Form::select('majors[]',$majors,$consultationMajors,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'consultation_major' ]) !!}
                    @if ($errors->has('majors'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('majors') }}</strong>
                        </span>
                    @endif
                </div>
                <div class = "clearfix"></div>
                <div class = "col-12 m--margin-top-10">
                    <span class = "m-badge m-badge--info m-badge--wide">توجه</span>
                    <strong id = "assignmentQuestionFileAlert">ستون چپ رشته های انتخاب شده می باشند</strong>
                </div>
            </div>
        </div>
        <div class = "form-group">
            <div class = "row">
                <label class = "control-label col-md-3">تامبنیل</label>
                <div class = "col-md-9">
                    <div class = "fileinput fileinput-new" data-provides = "fileinput">
                        <div class = "fileinput-new thumbnail" style = "width: 200px; height: 150px;">
                            <img src = "{{ route('image', ['category'=>'7','w'=>'140' , 'h'=>'140' , 'filename' =>  $consultation->thumbnail ]) }}" alt = "تامبنیل"/>
                        </div>
                        <div class = "fileinput-preview fileinput-exists thumbnail" style = "max-width: 200px; max-height: 150px;"></div>
                        <div>
                            <span class = "btn default btn-file">
                                <span class = "fileinput-new btn m-btn--pill m-btn--air btn-info m-btn m-btn--custom"> تغییر تامبنیل </span>
                                <span class = "fileinput-exists btn m-btn--pill m-btn--air btn-warning m-btn m-btn--custom"> تغییر </span>
                                <input type = "file" name = "thumbnail">
                            </span>
                            <a href = "javascript:" class = "btn m-btn--pill m-btn--air btn-danger m-btn m-btn--custom fileinput-exists" id = "consultationThumbnail-remove" data-dismiss = "fileinput"> حذف</a>
                        </div>
                    </div>
                    <div class = "clearfix margin-top-10">
                        <span class = "m-badge m-badge--danger m-badge--wide">توجه</span>
                        فرمت های مجاز: jpg , png - حداکثر حجم مجاز: ۲۰۰KB
                    </div>
                </div>
            </div>
        </div>
        <div class = "form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
            <div class = "row">
                <label class = "col-md-3 control-label" for = "description">توضیحات</label>
                <div class = "col-md-9">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'summernote_1' ]) !!}
                    @if ($errors->has('description'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class = "form-actions">
            <div class = "row">
                <div class = "col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn m-btn--air btn-warning m-btn m-btn--custom']) !!}
                </div>
            </div>
        </div>
    </div>
@else
    <div class = "col-md-6">
        <div>{!! Form::text('name', null, ['class' => 'form-control', 'id' => 'consultationName' , 'placeholder'=>'عنوان']) !!}
            <span class="form-control-feedback" id = "consultationNameAlert">
                <strong></strong>
            </span>
        </div>
        <div>
            {!! Form::select('consultationstatus_id',$consultationStatuses,null,['class' => 'form-control', 'id' => 'consultationstatus_id']) !!}
            <span class="form-control-feedback" id = "consultationstatusAlert">
                <strong></strong>
            </span>
        </div>
        <div>
            {!! Form::text('textScriptLink', null, ['class' => 'form-control','dir' => 'ltr' , 'id' => 'consultationTextScriptLink' , 'placeholder'=> 'لینک فایل متنی']) !!}
            <span class="form-control-feedback" id = "consultationTextScriptLinkAlert">
                <strong></strong>
            </span>
        </div>
        <div>
            <label class = "control-label">رشته</label>
            {!! Form::select('majors[]',$majors,null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'consultation_major']) !!}
            <span class="form-control-feedback" id = "consultationMajorAlert">
                <strong></strong>
            </span>
            <div class = "clearfix margin-top-10">
                <span class = "m-badge m-badge--info m-badge--wide">توجه</span>
                <strong id = "assignmentQuestionFileAlert">ستون چپ رشته های انتخاب شده می باشند</strong>
            </div>
        </div>
    </div>
    <div class = "col-md-6">
        <p>
            {!! Form::text('videoPageLink', null, ['class' => 'form-control','dir' => 'ltr' , 'id' => 'consultationVideoPageLink' , 'placeholder'=>'لینک فیلم']) !!}
            <span class="form-control-feedback" id = "consultationVideoPageLinkAlert">
                <strong></strong>
            </span>
        </p>
    </div>
    <div class = "col-md-6">
        <div class = "fileinput fileinput-new" id = "thumbnail-div" data-provides = "fileinput">
            <div class = "input-group input-large">
                <div class = "form-control uneditable-input input-fixed input-medium" data-trigger = "fileinput">
                    <i class = "fa fa-file fileinput-exists"></i>&nbsp;
                    <span class = "fileinput-filename"> </span>
                </div>
                <span class = "input-group-addon btn default btn-file">
                    <span class = "fileinput-new btn m-btn--pill m-btn--air btn-info m-btn m-btn--custom"> تامبنیل </span>
                    <span class = "fileinput-exists btn m-btn--pill m-btn--air btn-warning m-btn m-btn--custom"> تغییر </span>
                    {!! Form::file('thumbnail' , ['id'=>'thumbnail']) !!}
                </span>
                <a href = "javascript:" class = "btn m-btn--pill m-btn--air btn-danger m-btn m-btn--custom fileinput-exists" data-dismiss = "fileinput">حذف</a>
            </div>
            <div class = "clearfix margin-top-10">
                <span class = "m-badge m-badge--danger m-badge--wide">توجه</span>
                <strong id = "thumbnailAlert">فرمت های مجاز: jpg , png - حداکثر حجم مجاز: ۲۰۰KB</strong>
            </div>
        </div>
    </div>
    <div class = "col-md-12">
        <p>{!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'consultationSummerNote' , 'placeholder'=>'توضیحات']) !!}</p>
    </div>
@endif





