@if(isset($consultation))
    <div class="form-body">
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="name">عنوان</label>
            <div class="col-md-9">
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                @if ($errors->has('name'))
                    <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('videoPageLink') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="videoPageLink">فیلم تجزیه تحلیل</label>
            <div class="col-md-9">
                {!! Form::text('videoPageLink', null, ['class' => 'form-control', 'id' => 'videoPageLink' ]) !!}
                @if ($errors->has('videoPageLink'))
                    <span class="help-block">
                    <strong>{{ $errors->first('videoPageLink') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('textScriptLink') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="textScriptLink">فیلم تجزیه تحلیل</label>
            <div class="col-md-9">
                {!! Form::text('textScriptLink', null, ['class' => 'form-control', 'id' => 'textScriptLink' ]) !!}
                @if ($errors->has('textScriptLink'))
                    <span class="help-block">
                    <strong>{{ $errors->first('textScriptLink') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('consultationstatus_id') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="consultationstatus_id">وضعیت</label>
            <div class="col-md-9">
                {!! Form::select('consultationstatus_id',$consultationStatuses,null,['class' => 'form-control', 'id' => 'consultationstatus']) !!}
                @if ($errors->has('consultationstatus_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('consultationstatus_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('majors') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="major_id">رشته</label>
            <div class="col-md-9">
                {!! Form::select('majors[]',$majors,$consultationMajors,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'consultation_major' ]) !!}
                @if ($errors->has('majors'))
                    <span class="help-block">
                    <strong>{{ $errors->first('majors') }}</strong>
                </span>
                @endif
            </div>
            <div class="clearfix margin-top-10">
                <span class="label label-info">توجه</span>
                <strong id="assignmentQuestionFileAlert">ستون چپ رشته های انتخاب شده می باشند</strong>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">تامبنیل</label>
            <div class="col-md-9">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"><img
                                src="{{ route('image', ['category'=>'7','w'=>'140' , 'h'=>'140' , 'filename' =>  $consultation->thumbnail ]) }}"
                                alt="تامبنیل"/></div>
                    <div class="fileinput-preview fileinput-exists thumbnail"
                         style="max-width: 200px; max-height: 150px;"></div>
                    <div>
                                                            <span class="btn default btn-file">
                                                                <span class="fileinput-new"> تغییر تامبنیل </span>
                                                                <span class="fileinput-exists"> تغییر </span>
                                                                <input type="file" name="thumbnail"> </span>
                        <a href="javascript:" class="btn red fileinput-exists" id="consultationThumbnail-remove"
                           data-dismiss="fileinput"> حذف </a>
                    </div>
                </div>
                <div class="clearfix margin-top-10">
                    <span class="label label-danger">توجه</span> فرمت های مجاز: jpg , png - حداکثر حجم مجاز: ۲۰۰KB
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="description">توضیحات</label>
            <div class="col-md-9">
                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'summernote_1' ]) !!}
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
                    {!! Form::submit('اصلاح', ['class' => 'btn blue']) !!}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-6">
        <p>{!! Form::text('name', null, ['class' => 'form-control', 'id' => 'consultationName' , 'placeholder'=>'عنوان']) !!}
            <span class="help-block" id="consultationNameAlert">
                <strong></strong>
        </span>
        </p>
        <p>{!! Form::select('consultationstatus_id',$consultationStatuses,null,['class' => 'form-control', 'id' => 'consultationstatus_id']) !!}
            <span class="help-block" id="consultationstatusAlert">
                <strong></strong>
        </span>
        </p>
        <p>{!! Form::text('textScriptLink', null, ['class' => 'form-control','dir' => 'ltr' , 'id' => 'consultationTextScriptLink' , 'placeholder'=> 'لینک فایل متنی']) !!}
            <span class="help-block" id="consultationTextScriptLinkAlert">
                <strong></strong>
        </span>
        </p>
        <p>
            <label class="control-label">رشته</label>
            {!! Form::select('majors[]',$majors,null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'consultation_major']) !!}
            <span class="help-block" id="consultationMajorAlert">
                <strong></strong>
        </span>
        <div class="clearfix margin-top-10">
            <span class="label label-info">توجه</span>
            <strong id="assignmentQuestionFileAlert">ستون چپ رشته های انتخاب شده می باشند</strong>
        </div>
        </p>
    </div>
    <div class="col-md-6">
        <p>{!! Form::text('videoPageLink', null, ['class' => 'form-control','dir' => 'ltr' , 'id' => 'consultationVideoPageLink' , 'placeholder'=>'لینک فیلم']) !!}
            <span class="help-block" id="consultationVideoPageLinkAlert">
                <strong></strong>
        </span>
        </p>
    </div>
    <div class="col-md-6">
        <div class="fileinput fileinput-new" id="thumbnail-div" data-provides="fileinput">
            <div class="input-group input-large">
                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                    <span class="fileinput-filename"> </span>
                </div>
                <span class="input-group-addon btn default btn-file">
                                                                    <span class="fileinput-new"> تامبنیل </span>
                                                                    <span class="fileinput-exists"> تغییر </span>
                    {!! Form::file('thumbnail' , ['id'=>'thumbnail']) !!} </span>
                <a href="javascript:" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                    حذف </a>
            </div>
            <div class="clearfix margin-top-10">
                <span class="label label-danger">توجه</span><strong id="thumbnailAlert">فرمت های مجاز: jpg , png -
                    حداکثر حجم مجاز: ۲۰۰KB</strong>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <p>{!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'consultationSummerNote' , 'placeholder'=>'توضیحات']) !!}</p>
    </div>
@endif





