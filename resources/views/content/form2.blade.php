<div class="row">
    <div class="col-md-4">

        <label class="mt-checkbox mt-checkbox-outline">
            <div class="md-checkbox">
                @if(Auth::user()->can(config('constants.CHANGE_TO_PAID_CONTENT')))
                {!!
                    Form::checkbox(
                        'isFree',
                        $content->isFree,
                        null,
                        [
                            'value' => '1',
                            'id' => 'checkbox_isFree_enable',
                            'class'=>'md-check',
                            ($content->isFree)?'checked':''
                        ]
                    )
                !!}
                @else
                    {!!
                        Form::checkbox(
                            'isFree',
                            $content->isFree,
                            null,
                            [
                                'value' => '1',
                                'id' => 'checkbox_isFree_enable',
                                'class'=>'md-check',
                                'disabled',
                                ($content->isFree)?'checked':''
                            ]
                        )
                    !!}
                    @if($content->isFree)
                        <input type="hidden" name="isFree" value="1">
                    @endif
                @endif
                <label for="checkbox_isFree_enable">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    رایگان
                    <span></span>
                </label>
            </div>
        </label>
        <br>
        <label class="mt-checkbox mt-checkbox-outline">
            <div class="md-checkbox">
                @if($content->enable)
                    {!! Form::checkbox('enable', '1', null,  ['value' => '1' , 'id' => 'checkbox_enable' , 'class'=>'md-check' , 'checked']) !!}
                @else
                    {!! Form::checkbox('enable', '1', null,  ['value' => '1' , 'id' => 'checkbox_enable' , 'class'=>'md-check' ]) !!}
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
        {{--{!! Form::select('grades[]',$grades,$content->grades,['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default', 'id' => 'grades' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" , "data-height" => "200" , "title" => "مقطع ها"]) !!}--}}

        {{--{!! Form::select('majors[]',$majors,$content->majors,['multiple' => 'multiple','class' => 'mt-multiselect btn btn-default', 'id' => 'majors' , "data-label" => "left" , "data-width" => "100%" , "data-filter" => "true" , "data-height" => "200" , "title" => "رشته ها"]) !!}--}}
        {{--<select name="contenttype_id" class="form-control" id="rootContentTypes" >--}}
        {{--<option value="" selected>انتخاب نوع محتوا</option>--}}
        {{--@foreach($rootContentTypes as $rootContentType)--}}
        {{--<option value="{{$rootContentType->id}}" data-title="{{$rootContentType->name}}" @if(in_array($rootContentType->id,$content->contenttypes->pluck('id')->toArray())) selected @endif >{{$rootContentType->displayName}}</option>--}}
        {{--@endforeach--}}
        {{--</select>--}}
        {{--{!! Form::select("contenttypes[]", $childContentTypes , null, ['class' => 'form-control', 'id'=>'childContentTypes' , 'placeholder' => 'انتخاب زیر شاخه' ]) !!}--}}
        <ul class="list-group margin-top-20 text-center">
            <li class="list-group-item bold" style="font-size: small">فایل های موجود
            </li>
            @if(isset($content->file_for_admin) and $content->file_for_admin->isNotEmpty())
                @if(!is_null($content->file_for_admin->get('video')))
                    @foreach($content->file_for_admin->get('video') as $file)
                        <li class="list-group-item" style="font-size: small">
                            <div class="row margin-bottom-5">
                                <span class="badge badge-danger" dir="ltr">{{$file->fileName}} </span>
                                <span class="badge badge-info" dir="ltr">{{$file->caption}} </span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-btn">

                                    <a target="_blank" href="{{$file->link}}" class="btn blue-dark"><i class="fa fa-download"></i>                                </a>
                                </span>

    {{--                            <span class="input-group-btn">--}}
    {{--                                <a class="btn btn-icon-only btn-outline red removeFile" data-target="#deleteFileConfirmationModal" data-toggle="modal" data-id="{{$file->id}}" data-to="{{$content->id}}">--}}
    {{--                                    <i class="fa fa-times"></i>--}}
    {{--                                </a>--}}
    {{--                            </span>--}}
    {{--                            <input type="text" value="@if(isset($file->pivot->caption[0])){{$file->pivot->caption}}@endif" id="caption_{{$file->id}}" class="form-control" maxlength="50" placeholder="کپشن">--}}
    {{--                            <span class="input-group-btn">--}}
    {{--                                <button type="button" class="btn blue fileCaptionSubmit" id="captionSubmit_{{$file->id}}" data-to="{{$content->id}}">ذخیره کپشن--}}
    {{--                                </button>--}}
    {{--                            </span>--}}
                            </div>
                            <!-- /input-group -->
                        </li>
                    @endforeach
                @endif
                    @if(!is_null($content->file_for_admin->get('pamphlet')))
                        @foreach($content->file_for_admin->get('pamphlet') as $file)
                            <li class="list-group-item" style="font-size: small">
                                <div class="row margin-bottom-5">
                                    <span class="badge badge-danger" dir="ltr">{{$file->fileName}}</span>
                                    <span class="badge badge-info" dir="ltr">{{$file->caption}} </span>
                                </div>
                                <div class="input-group input-group-sm">
                                <span class="input-group-btn">

                                    <a target="_blank" href="{{$file->link}}" class="btn blue-dark"><i class="fa fa-download"></i>                                </a>
                                </span>

                                    {{--                            <span class="input-group-btn">--}}
                                    {{--                                <a class="btn btn-icon-only btn-outline red removeFile" data-target="#deleteFileConfirmationModal" data-toggle="modal" data-id="{{$file->id}}" data-to="{{$content->id}}">--}}
                                    {{--                                    <i class="fa fa-times"></i>--}}
                                    {{--                                </a>--}}
                                    {{--                            </span>--}}
                                    {{--                            <input type="text" value="@if(isset($file->pivot->caption[0])){{$file->pivot->caption}}@endif" id="caption_{{$file->id}}" class="form-control" maxlength="50" placeholder="کپشن">--}}
                                    {{--                            <span class="input-group-btn">--}}
                                    {{--                                <button type="button" class="btn blue fileCaptionSubmit" id="captionSubmit_{{$file->id}}" data-to="{{$content->id}}">ذخیره کپشن--}}
                                    {{--                                </button>--}}
                                    {{--                            </span>--}}
                                </div>
                                <!-- /input-group -->
                            </li>
                        @endforeach
                    @endif
            @else
                <li class="list-group-item text-center m--font-danger " style="font-size: small">فایلی درج نشده است</li>
            @endif
        </ul>
        @if($content->contenttype_id != config('constants.CONTENT_TYPE_PAMPHLET'))
            <div class="row">
                <div class="col-md-12">
                    <img src="{{$content->thumbnail}}" width="100%">
                    <input type="file" name="thumbnail">
                </div>
            </div>
        @endif
        @if($content->isFree && $content->contenttype_id == config('constants.CONTENT_TYPE_PAMPHLET'))
            <div class="row">
                <label class=" col-md-4 control-label red" for="pamphlet">آپلود فایل جزوه</label>
                <div class="col-md-12">
                    <input name="pamphlet" type="file"/>
                </div>
            </div>
        @endif
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <select name="fileQuality" class="form-control">--}}
{{--                    <option value="">انتخاب کیفیت(در صورت وجود)</option>--}}
{{--                    <option value="HD_720p" data-role="hd" data-action="کیفیت عالی">کیفیت عالی</option>--}}
{{--                    <option value="hq" data-role="hq" data-action="کیفیت بالا">کیفیت بالا</option>--}}
{{--                    <option value="240p" data-role="240p" data-action="کیفیت متوسط">کیفیت متوسط</option>--}}
{{--                    <option value="thumbnail" data-role="thumbnail" data-action="تامبنیل">تامبنیل</option>--}}

{{--                </select>--}}
{{--                @if(isset($rootContentTypes))--}}
{{--                    <select name="contenttype" class="form-control">--}}
{{--                        <option value="" selected>انتخاب نوع فایل</option>--}}
{{--                        @foreach($rootContentTypes as $rootContentType)--}}
{{--                            <option value="{{$rootContentType->id}}" data-title="{{$rootContentType->name}}">{{$rootContentType->displayName}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div id="my-awesome-dropzone" class="dropzone dropzone-file-area needsclick dz-clickable">--}}
{{--            <div class="fallback">--}}
{{--                <input name="file" type="file" multiple/>--}}
{{--            </div>--}}
{{--            <div class="dropzone-previews"></div>--}}
{{--            <div class="dz-message needsclick">--}}
{{--                <h5 class="sbold text-justify" style="line-height: normal">--}}
{{--                    فایل های خود را اینجا بیندازید و یا بر روی این قسمت کلیک کنید.پس از بارگذاری فایل ها بر روی ذخیره اطلاعات کلیک کنید--}}
{{--                </h5>--}}
{{--                <span class="needsclick">--}}
{{--                    <span class="m-badge m-badge--wide m-badge--info">توجه:</span>--}}
{{--                    فرمت مجاز--}}
{{--                    <label style="color:red;">pdf</label>--}}
{{--                </span>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <div class="row">
                <label class=" col-md-4 control-label" for="validSinceDate">نمایان شدن برای کاربران</label>
                <div class="col-md-3">
                    <input type="text" name="validSinceDate" class="form-control" value="@if(isset($content->validSince)){{$content->validSince}}@endif" dir="ltr">
                    {{--<input  type="text" class="form-control" id="validSinceDate" value="@if(isset($content->validSince)){{$content->validSince}}@endif"  dir="ltr">--}}
                    {{--<input name="validSinceDate" id="validSinceDateAlt"  type="text" class="form-control hidden">--}}
                </div>
                {{--<div class="col-md-2">--}}
                {{--<input class="form-control" name="validSinceTime" id="validSinceTime" value="@if(isset($validSinceTime)) {{$validSinceTime}} @else {{old('validSinceTime')}} @endif"  placeholder="00:00" dir="ltr">--}}
                {{--</div>--}}
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class=" col-md-4 control-label" for="created_at">تاریخ درج</label>
                <div class="col-md-3">
                    <input type="text" name="created_at" class="form-control" value="@if(isset($content->created_at)){{$content->created_at}}@endif" dir="ltr">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-md-4 control-label" for="author_id">آیدی دبیر</label>
                <div class="col-md-8">
                    {!! Form::text('author_id', (isset($content)?($content->author_id):null), ['class' => 'form-control m-input m-input--air', 'placeholder'=>'آی دی دبیر' , 'id'=>'author_id', 'dir'=>'ltr']) !!}
                </div>
            </div>
        </div>

        @permission((config('constants.REDIRECT_EDUCATIONAL_CONTENT_ACCESS')))
        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="redirectUrl">لینک ریدایرکت :
                </label>
                <div class="col-md-9">
                    {!! Form::text('redirectUrl', null, ['class' => 'form-control', 'id' => 'redirectUrl' , 'dir'=>'ltr']) !!}
                    <span class="form-control-feedback">
                       <strong></strong>
                   </span>
                </div>
            </div>
        </div>
        @endpermission

        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="name">ترتیب :
                </label>
                <div class="col-md-9">
                    {!! Form::text('order', null, ['class' => 'form-control', 'id' => 'order', 'maxlength'=>'100' ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="name">نوع محتوا :
                </label>
                <div class="col-md-9">
                    {!! Form::select('contenttype_id', $contenttypes, null ,['class' => 'form-control m-input m-input--air', 'id' => 'contenttypes']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="name">سکشن محتوا :
                </label>
                <div class="col-md-9">
                    {!! Form::select('section_id', $sections, null ,['class' => 'form-control m-input m-input--air', 'id' => 'sections']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="name">نام :
                    <span class="required"> * </span>
                </label>
                <div class="col-md-9">
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'maxlength'=>'100' ]) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="description">توضیح:
                </label>
                <div class="col-md-9">
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'descriptionSummerNote', 'rows' => '5' ]) !!}
                </div>
            </div>
        </div>
        @if(isset($content) && isset($content->tmp_description))
            @permission((config('constants.ACCEPT_CONTENT_TMP_DESCRIPTION_ACCESS')))
            <hr>
            <textarea class="d-none"  id="tempDescriptionSummerNote">{{$content->tmp_description}}</textarea>
            <div id="descriptionComparisonOutput">
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-2 control-label" for="description">{!!Form::checkbox('acceptTmpDescription',null,null,['value' => '1'])!!}  تایید کردن توضیح</label>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <input class="btn btn-info" type="button" onClick="showTempDescription()" VALUE="نمایش توضیحات موقت">
                    <div class="col-md-12 d-none" id="tempDescriptionCol" >
                        {!! $content->tmp_description !!}
                    </div>
                </div>
            </div>
            <hr>
            @endpermission
        @endif
        @if(isset($content) && $content->contenttype_id == config('constants.CONTENT_TYPE_ARTICLE'))
            @permission((config('constants.EDIT_ARTICLE_ACCESS')))
            <div class="form-group">
                <div class="row">
                    <label class="col-md-2 control-label" for="context">مقاله:
                    </label>
                    <div class="col-md-9">
                        {!! Form::textarea('context', null, ['class' => 'form-control', 'id' => 'contextSummerNote', 'rows' => '5' ]) !!}
                    </div>
                </div>
            </div>
            @endpermission
        @endif
        <div class="form-group">
            <div class="row">
                <label class="col-md-2 control-label" for="tags">
                    تگ ها :
                </label>
                <div class="col-md-9">
                    <input name="tags" type="text" class="form-control input-large" value="{{$tags}}" data-role="tagsinput">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i>
                        ذخیره اطلاعات
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
