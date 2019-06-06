<div class="row">
    <div class="col-md-4">
    
        <label class="mt-checkbox mt-checkbox-outline">
            <div class="md-checkbox">
                @if(Auth::user()->can('constants.CHANGE_TO_PAID_CONTENT'))
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
            @if(isset($content->file) and $content->file->isNotEmpty())
                @if(!is_null($content->file->get('video')))
                    @foreach($content->file->get('video') as $file)
                        <li class="list-group-item" style="font-size: small">
                            <div class="row margin-bottom-5">
                                <span class="badge badge-danger" dir="ltr"> {{basename($file->link, "." . pathinfo($file->link, PATHINFO_EXTENSION)) }}</span>
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
                    @if(!is_null($content->file->get('pamphlet')))
                        @foreach($content->file->get('pamphlet') as $file)
                            <li class="list-group-item" style="font-size: small">
                                <div class="row margin-bottom-5">
                                    <span class="badge badge-danger" dir="ltr"> {{basename($file->link, "." . pathinfo($file->link, PATHINFO_EXTENSION)) }}</span>
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
                <li class="list-group-item text-center m--font-danger " style="font-size: small">فایلی درج نشده است
                </li>
            @endif
        </ul>
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
                <label class="col-md-2 control-label" for="name">ترتیب :
                </label>
                <div class="col-md-9">
                    {!! Form::text('order', null, ['class' => 'form-control', 'id' => 'order', 'maxlength'=>'100' ]) !!}
                    <span class="form-control-feedback">
                               <strong></strong>
                   </span>
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
                    <span class="form-control-feedback">
                                                   <strong></strong>
                                           </span>
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
