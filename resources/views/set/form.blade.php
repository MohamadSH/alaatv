<div class="row">
    <div class="col-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
    
        @if($editForm)
            {!! Form::open(['method'=>'PUT' , 'action'=>['Web\SetController@update' , $set], 'files'=>true]) !!}
        @else
            {!! Form::open(['method'=>'POST', 'action'=>'Web\SetController@store'          , 'files'=>true]) !!}
        @endif
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            @if($editForm)
                                اصلاح اطلاعات
                                <a class="m-link" href="{{action("Web\SetController@indexContent" , $set)}}">{{$set->name}}</a>
                                (تعداد محتوا: {{ $set->contents_count }})
                            @else
                                ثبت دسته محتوای جدید
                            @endif
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <button type="submit" class="btn m-btn--pill m-btn--air btn-warning">
                        @if($editForm)
                            اصلاح
                        @else
                            ثبت
                        @endif
                    </button>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-checkbox-list">
                                <label class="mt-checkbox mt-checkbox-outline">
                                    فعال
                                    <input type="checkbox" value="1" name="enable" @if($editForm && $set->enable) checked @endif />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-checkbox-list">
                                <label class="mt-checkbox mt-checkbox-outline">
                                    قابل نمایش برای کاربران
                                    <input type="checkbox" value="1" name="display" @if($editForm && $set->display) checked @endif />
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 control-label" for="name">نام</label>
                        <div class="col-md-10">
                            {!! Form::text('name', ($editForm) ? $set->name : null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                            @if ($errors->has('name'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 control-label" for="name">نام کوتاه</label>
                        <div class="col-md-10">
                            {!! Form::text('small_name', ($editForm) ? $set->small_name : null, ['class' => 'form-control', 'id' => 'name' ]) !!}
                            @if ($errors->has('small_name'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('small_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 control-label" for="shortDescription">توضیحات</label>
                        <div class="col-md-10">
                            {!! Form::textarea('description', ($editForm) ? $set->description : null, ['class' => 'form-control', 'id' => 'productShortDescriptionSummerNote' ]) !!}
                            @if ($errors->has('description'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('photo') ? ' has-danger' : '' }}">
                    <div class="row">
                        <label class="control-label col-md-3">عکس</label>
                        <div class="col-md-9">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                @if($editForm)
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="{{ $set->photo }}" class="a--full-width" @if(strlen($set->name)>0) alt="{{$set->name}}" @else  alt="عکس محصول" @endif/>
                                    </div>
                                @endif

                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>

{{--                                <div>--}}
{{--                                    <span class="btn m-btn--pill m-btn--air btn-warning default btn-file">--}}
{{--                                        <span class="fileinput-new">--}}
{{--                                            @if($editForm)--}}
{{--                                                تغییر عکس--}}
{{--                                            @else--}}
{{--                                                انتخاب عکس--}}
{{--                                            @endif--}}
{{--                                        </span>--}}
{{--                                        <span class="fileinput-exists"> تغییر </span>--}}
{{--                                        {!! Form::file('photo') !!}--}}
{{--                                    </span>--}}
{{--                                    <a href="javascript:" class="btn m-btn--pill m-btn--air btn-danger fileinput-exists" data-dismiss="fileinput"> حذف</a>--}}
{{--                                </div>--}}
                            </div>
                            @if ($errors->has('photo'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('photo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-2 control-label" for="tags">
                            تگ ها :
                        </label>
                        <div class="col-md-9">
                            <input name="tags" type="text" class="form-control input-large setTags" value="@if($editForm && isset($set->tags)){{ implode(',',$set->tags->tags) }}@endif" data-role="tagsinput">
                        </div>
                    </div>
                </div>
                <div>
        
                    <div class="m-divider m--margin-top-50">
                        <span></span>
                        <span>افزودن محصول جدید به این دسته محتوا</span>
                        <span></span>
                    </div>
    
                    @include('admin.filters.productsFilter', [
                        "id" => "setProduct",
                        'everyProduct'=>false,
                        'title'=>'انتخاب محصول'
                    ])
    
                </div>
                
                @if($editForm)
                
                <div>
                    <div class="m-divider m--margin-top-50">
                        <span></span>
                        <span>محصولات این دسته محتوا</span>
                        <span></span>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" id="productTable" width="100%">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تصویر</th>
                            <th>نام</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($setProducts as $key=>$product)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td><img src="{{ $product->photo }}" alt="تصویر محصول {{ $product->name }}" width="100"></td>
                                <td>
                                    <a href="{{ action('Web\ProductController@show', $product) }}" class="m-link" target="_blank">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ action('Web\ProductController@edit', $product) }}" target="_blank">
                                        <button type="button" class="btn m-btn--pill m-btn--air btn-warning">
                                            ویرایش
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
    
                <button type="submit" class="btn m-btn--pill m-btn--air btn-warning a--full-width m--margin-top-30">
                    @if($editForm)
                        اصلاح
                    @else
                        ثبت
                    @endif
                </button>
                
            </div>
        </div>
        {!! Form::close() !!}
    <!-- END SAMPLE FORM PORTLET-->
    </div>

</div>
