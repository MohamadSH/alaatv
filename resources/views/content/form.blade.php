<div class="portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-file-text"></i>@if(isset($content))اصلاح@elseدرج@endif محتوای آموزشی
        </div>
        <div class="actions btn-set">
            <label class="mt-checkbox mt-checkbox-outline">
                <div class="md-checkbox">
                    @if(isset($content))
                        @if($content->enable)
                            {!! Form::checkbox('enable', '1', null,  ['value' => '1' , 'id' => 'checkbox_enable' , 'class'=>'md-check' , 'checked']) !!}
                        @else
                            {!! Form::checkbox('enable', '1', null,  ['value' => '1' , 'id' => 'checkbox_enable' , 'class'=>'md-check' ]) !!}
                        @endif
                    @else
                        {!! Form::checkbox('enable', '1', null,  ['value' => '1' , 'id' => 'checkbox_enable' , 'class'=>'md-check' , 'checked']) !!}
                    @endif

                    <label for="checkbox_enable">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>
                        فعال بودن محتوا
                        <span></span>
                    </label>
                </div>
            </label>
            <button type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> @if(isset($content))اصلاح@elseذخیره@endif </button>
            <a href = "{{action("Web\HomeController@adminContent")}}" type = "button" title = "back"
               class="btn btn-dark btn-secondary-outline">
                <i class="fa fa-angle-left"></i> بازگشت </a>
        </div>
    </div>
</div>
<div class="portlet-body">
    <div class="tabbable-bordered">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_general" data-toggle="tab"> اطلاعات محتوا </a>
            </li>
            <li>
                <a href="#tab_category" data-toggle="tab"><span class="m--font-danger"> * </span>
                    دسته بندی محتوا </a>
            </li>
            <li>
                <a href="#tab_file" data-toggle="tab"> فایل محتوا </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_general">
                <div class="form-group {{ $errors->has('validSinceDate') ? ' has-error' : '' }}">
                    <label class=" col-md-4 control-label" for="validSinceDate">نمایان شدن برای کاربران</label>
                    <div class="col-md-3">
                        <input id="validSinceDate" type="text" class="form-control"
                               value="@if(isset($validSinceDate)) {{$validSinceDate}} @else {{old('validSinceDate')}} @endif"
                               dir="ltr">
                        <input name="validSinceDate" id="validSinceDateAlt" type="text" class="form-control hidden">
                    </div>
                    {{--<label class="col-md-1 control-label" for="validSinceTime">ساعت</label>--}}
                    <div class="col-md-2">
                        <input class="form-control" name="validSinceTime" id="validSinceTime" placeholder="00:00"
                               value="@if(isset($validSinceTime)){{$validSinceTime}} @else{{old('validSinceTime')}}@endif"
                               dir="ltr">
                    </div>
                </div>
                <hr>
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label" for="name">نام :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'maxlength'=>'100' ]) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                {{--<div class="form-group {{ $errors->has('order') ? ' has-error' : '' }}">--}}
                {{--<label class="col-md-2 control-label" for="order">ترتیب :--}}
                {{--<span class="required"> * </span>--}}
                {{--</label>--}}
                {{--<div class="col-md-9">--}}
                {{--{!! Form::text('order', null, ['class' => 'form-control', 'id' => 'order']) !!}--}}
                {{--@if ($errors->has('order'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('order') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label" for="description">توضیح:
                        {{--<span class="required"> * </span>--}}
                    </label>
                    <div class="col-md-9">
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'descriptionSummerNote', 'rows' => '15' ]) !!}

                        @if ($errors->has('description'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                 </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="tab_category">
                <div class="form-group">
                    {{--<label class="col-md-1 control-label" for="grades">--}}
                    {{--<span class="required"> * </span>--}}
                    {{--</label>--}}
                    <div class="col-md-6 {{ $errors->has('grades') ? ' has-error' : '' }}">
                        {{--{!! Form::select('grades[]', $grades , null, ['class' => 'form-control', 'id' => 'grades' , 'placeholder' => 'انتخاب مقطع' ]) !!}--}}
                        <select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left"
                                data-width="100%" data-filter="true" data-height="200"
                                id="grades" name="grades[]" title="انتخاب مقطع">
                            @foreach($grades as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('grades'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('grades') }}</strong>
                                </span>
                        @endif
                    </div>
                    {{--<label class="col-md-2 control-label" for="majors">--}}
                    {{--<span class="required"> * </span>--}}
                    {{--</label>--}}
                    <div class="col-md-6 {{ $errors->has('majors') ? ' has-error' : '' }}">
                        {{--                        {!! Form::select('majors[]', $majors , null, ['class' => 'form-control', 'id' => 'majors' , 'placeholder' => 'انتخاب رشته' ]) !!}--}}
                        <select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left"
                                data-width="100%" data-filter="true" data-height="200"
                                id="majors" name="majors[]" title="انتخاب رشته">
                            @foreach($majors as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('majors'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('majors') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('contenttypes') ? ' has-error' : '' }}">
                    {{--<label class="col-md-1 control-label" for="rootContentTypes">--}}
                    {{--<span class="required"> * </span>--}}
                    {{--</label>--}}
                    <div class="col-md-6">
                        {!! Form::select('contenttypes[]', $rootContentTypes , null, ['class' => 'form-control', 'id' => 'rootContentTypes' , 'placeholder' => 'انتخاب نوع محتوا' ]) !!}
                    </div>
                    {{--<label class="col-md-1 control-label" for="childContentTypes">--}}
                    {{--<span class="required"> * </span>--}}
                    {{--</label>--}}
                    <div class="col-md-6">
                        {!! Form::select('contenttypes[]', $childContentTypes , null, ['class' => 'form-control', 'id' => 'childContentTypes' , 'placeholder' => 'انتخاب زیر شاخه' , 'disabled' ]) !!}
                    </div>
                    @if ($errors->has('contenttypes'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('contenttypes') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="tab_file">
                <div class="form-group {{ $errors->has('file') ? ' has-error' : '' }}">
                    <div class="col-md-12 text-center">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span class="btn-file">
                                                                <span class="fileinput-new btn btn-success"><i
                                                                            class="fa fa-plus"></i>انتخاب فایل سوال آزمون/فایل جزوه</span>
                                                                <span class="fileinput-exists btn"> تغییر </span>
                                                                <input type="file" name="file"> </span>
                            <a href="javascript:" class="btn red fileinput-exists" id="file-remove"
                               data-dismiss="fileinput"> حذف </a>
                            <div class="clearfix margin-top-10">
                                <span class="m-badge m-badge--wide m-badge--danger">توجه</span> فرمت مجاز: pdf
                            </div>
                        </div>
                        @if ($errors->has('file'))
                            <span class="help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="form-group {{ $errors->has('file2') ? ' has-error' : '' }}">
                    <div class="col-md-12 text-center">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span class="btn-file">
                                                                <span class="fileinput-new btn btn-success"><i
                                                                            class="fa fa-plus"></i>انتخاب فایل پاسخ(آزمون)</span>
                                                                <span class="fileinput-exists btn"> تغییر </span>
                                                                <input type="file" name="file2"> </span>
                            <a href="javascript:" class="btn red fileinput-exists" id="file-remove"
                               data-dismiss="fileinput"> حذف </a>
                            <div class="clearfix margin-top-10">
                                <span class="m-badge m-badge--wide m-badge--danger">توجه</span> فرمت مجاز: pdf
                            </div>
                        </div>
                        @if ($errors->has('file2'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('file2') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>