@if(isset($assignment))
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
        <div class="form-group {{ $errors->has('numberOfQuestions') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="numberOfQuestions">تعداد سؤالات</label>
            <div class="col-md-9">
                {!! Form::text('numberOfQuestions', null, ['class' => 'form-control', 'id' => 'numberOfQuestions' ]) !!}
                @if ($errors->has('numberOfQuestions'))
                    <span class="help-block">
                    <strong>{{ $errors->first('numberOfQuestions') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('questionFile') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="questionFile">سؤالات</label>
            <div class="col-md-9">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="input-group input-large ">
                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                            <span class="fileinput-filename"> @if(isset($assignment->questionFile) && strlen($assignment->questionFile)>0) {{$assignment->questionFile}} @endif</span>
                        </div>
                        <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> انتخاب فایل </span>
                                                                <span class="fileinput-exists"> تغییر </span>
                            {!! Form::file('questionFile' , ['id'=>'questionFile']) !!} </span>
                        <a href="javascript:" class="input-group-addon btn red fileinput-exists"
                           data-dismiss="fileinput"> حذف </a>
                    </div>
                </div>
                @if ($errors->has('questionFile'))
                    <span class="help-block">
                    <strong>{{ $errors->first('questionFile') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('solutionFile') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="solutionFile">پاسخ</label>
            <div class="col-md-9">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="input-group input-large ">
                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                            <span class="fileinput-filename">@if(isset($assignment->solutionFile) && strlen($assignment->solutionFile)>0) {{$assignment->solutionFile}} @endif </span>
                        </div>
                        <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> انتخاب فایل </span>
                                                                <span class="fileinput-exists"> تغییر </span>
                            {!! Form::file('solutionFile' , ['id'=>'solutionFile']) !!} </span>
                        <a href="javascript:" class="input-group-addon btn red fileinput-exists"
                           data-dismiss="fileinput"> حذف </a>
                    </div>
                </div>
                @if ($errors->has('solutionFile'))
                    <span class="help-block">
                    <strong>{{ $errors->first('solutionFile') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('analysisVideoLink') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="analysisVideoLink">فیلم تجزیه تحلیل</label>
            <div class="col-md-9">
                {!! Form::text('analysisVideoLink', null, ['class' => 'form-control', 'id' => 'analysisVideoLink' ]) !!}
                @if ($errors->has('analysisVideoLink'))
                    <span class="help-block">
                    <strong>{{ $errors->first('analysisVideoLink') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('assignmentstatus_id') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="assignmentstatus_id">وضعیت</label>
            <div class="col-md-9">
                {!! Form::select('assignmentstatus_id',$assignmentStatuses,null,['class' => 'form-control', 'id' => 'assignmentstatus']) !!}
                @if ($errors->has('assignmentstatus_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('assignmentstatus_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('majors') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="majors">رشته</label>
            <div class="col-md-9">
                {!! Form::select('majors[]',$majors,$assignmentMajors,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'assignment_major' ]) !!}
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
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="description">توضیحات</label>
            <div class="col-md-9">
                {{--<div name="summernote" id="summernote_1">{!! $assignment->description !!}</div>--}}
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
                    {!! Form::submit('اصلاح', ['class' => 'btn blue' ] ) !!}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-6">
        <p>{!! Form::text('name', null, ['class' => 'form-control', 'id' => 'assignmentName' , 'placeholder'=>'نام']) !!}
            <span class="help-block" id="assignmentName_alert">
                <strong></strong>
            </span>
        </p>

        <div class="fileinput fileinput-new" id="assignmentQuestionFile-div" data-provides="fileinput">
            <div class="input-group input-large">
                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                    <span class="fileinput-filename"> </span>
                </div>
                <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> سؤالات </span>
                                                                <span class="fileinput-exists"> تغییر </span>
                    {!! Form::file('questionFile' , ['id'=>'questionFile']) !!}
                </span>
                <a href="javascript:" class="input-group-addon btn red fileinput-exists"
                   id="assignmentQuestionFile-remove" data-dismiss="fileinput"> حذف </a>
            </div>
            <div class="clearfix margin-top-10">
                <span class="label label-danger">توجه</span>
                <strong id="assignmentQuestionFileAlert">فرمت های مجاز: pdf , rar , zip</strong>
            </div>
        </div>

        <p>{!! Form::select('assignmentstatus_id',$assignmentStatuses,null,['class' => 'form-control', 'id' => 'assignmentstatus_id' ]) !!}
            <span class="help-block" id="assignmentstatusAlert">
                <strong></strong>
            </span>
        </p>
        <p>
            <label class="control-label">رشته</label>
            {!! Form::select('majors[]',$majors,null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'assignment_major']) !!}
            <span class="help-block" id="assignmentMajorAlert">
                    <strong></strong>
            </span>
        <div class="clearfix margin-top-10">
            <span class="label label-info">توجه</span>
            <strong id="assignmentQuestionFileAlert">ستون چپ رشته های انتخاب شده می باشند</strong>
        </div>
        </p>
    </div>
    <div class="col-md-6">
        <p>{!! Form::text('numberOfQuestions', null, ['class' => 'form-control', 'id' => 'assignmentNumberOfQuestions' , 'placeholder'=> 'تعداد سؤالات']) !!}
            <span class="help-block" id="assignmentNumberOfQuestionsAlert">
                <strong></strong>
            </span>
        </p>
        <div class="fileinput fileinput-new" id="assignmentSolutionFile-div" data-provides="fileinput">
            <div class="input-group input-large">
                <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                    <span class="fileinput-filename"> </span>
                </div>
                <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> پاسخ </span>
                                                                <span class="fileinput-exists"> تغییر </span>
                    {!! Form::file('solutionFile' , ['id'=>'solutionFile']) !!} </span>
                <a href="javascript:" class="input-group-addon btn red fileinput-exists"
                   id="assignmentSolutionFile-remove" data-dismiss="fileinput"> حذف </a>
            </div>
            <div class="clearfix margin-top-10">
                <span class="label label-danger">توجه</span>
                <strong id="assignmentSolutionFileAlert">فرمت های مجاز: pdf , rar , zip</strong>
            </div>
        </div>
        <p>
            {!! Form::text('analysisVideoLink', null, ['class' => 'form-control', 'id' => 'assignmentAnalysisVideoLink', 'dir' => 'ltr' , 'placeholder'=>'لینک فیلم تجزیه تحلیل']) !!}
            <span class="help-block" id="assignmentAnalysisVideoLinkAlert">
                <strong></strong>
            </span>
        </p>
    </div>

    <div class="col-md-12">
        <p>{!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'assignmentSummerNote' , 'placeholder'=>'توضیحات']) !!}
            {{--<p><div name="summernote" id="summernote_1"></div>--}}
            <span class="help-block" id="descriptionAlert">
                <strong></strong>
            </span>
        </p>
    </div>
@endif