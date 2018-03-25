<div class="portlet">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-file-text"></i>@if(isset($article))اصلاح@elseایجاد@endif مقاله </div>
        <div class="actions btn-set">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-check"></i> @if(isset($article))اصلاح@elseذخیره@endif </button>
            <a href="{{action("HomeController@adminContent")}}" type="button" name="back" class="btn btn-dark btn-secondary-outline">
                <i class="fa fa-angle-left"></i> بازگشت </a>
        </div>
    </div>
</div>
<div class="portlet-body">
    <div class="tabbable-bordered">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_general" data-toggle="tab"> عمومی </a>
            </li>
            <li>
                <a href="#tab_meta" data-toggle="tab"> متا </a>
            </li>
            <li>
                <a href="#tab_images" data-toggle="tab"> عکس </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_general">
                <div class="form-body">
                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label" for="title">عنوان :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'onkeyup' => "countChar(this,50,60,100,'#progressbar_title')", 'maxlength'=>'100' ]) !!}
                            <div class="progress" style="width: 100%; text-align: right; float: right;">
                                <div id="progressbar_title" class="progress-bar" style="text-align: right; float: right;"></div>
                            </div>
                            @if ($errors->has('title'))
                                <span class="help-block">
                                                        <strong>{{ $errors->first('title') }}</strong>
                                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('order') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label" for="order">ترتیب :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            {!! Form::text('order', null, ['class' => 'form-control', 'id' => 'order']) !!}
                            @if ($errors->has('order'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('order') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('brief') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label" for="brief">خلاصه:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            {!! Form::textarea('brief', null, ['class' => 'form-control', 'id' => 'brief', 'rows' => '8', 'onkeyup' => "countChar(this,150,160,200,'#progressbar_brief')", 'maxlength'=>'200']) !!}
                            <div class="progress" style="width: 100%; text-align: right; float: right;">
                                <div id="progressbar_brief" class="progress-bar" style="text-align: right; float: right;"></div>
                            </div>
                            @if ($errors->has('brief'))
                                <span class="help-block">
                                                        <strong>{{ $errors->first('brief') }}</strong>
                                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label" for="body">متن مقاله:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            {!! Form::textarea('body', null, ['class' => 'form-control', 'id' => 'bodySummerNote', 'rows' => '15' ]) !!}

                            @if ($errors->has('body'))
                                <span class="help-block">
                                                        <strong>{{ $errors->first('body') }}</strong>
                                                     </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('articlecategory_id') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label" for="articlecategory_id">دسته:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            {!! Form::select('articlecategory_id', $articlecategories , null, ['class' => 'form-control', 'id' => 'articlecategoryId' , 'placeholder' => 'بدون دسته' ]) !!}
                            @if ($errors->has('articlecategory_id'))
                                <span class="help-block">
                                                        <strong>{{ $errors->first('articlecategory_id') }}</strong>
                                                     </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_meta">
                <div class="form-body">
                    <div class="form-group {{ $errors->has('keyword') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label" for="keyword">کلمات کلیدی:</label>
                        <div class="col-md-9">
                            {!! Form::textarea('keyword', null, ['class' => 'form-control', 'id' => 'keyword', 'maxlength'=>'200','placeholder' => 'کلمات کلیدی رو با , از هم جدا کنید.' ]) !!}
                            <span class="help-block">
                                    <strong>کلمات را با ویرگول از یکدیگر جدا کنید</strong>
                             </span>
                            @if ($errors->has('keyword'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('keyword') }}</strong>
                             </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_images">
                <div class="form-group">
                <div class="col-md-6 left">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"><img src="{{isset($article) ? route('image', [ 'category'=>'8','w'=>'140' , 'h'=>'140' , 'filename' =>  $article->image ]) : "../assets/pages/media/works/img1.jpg"}}"  alt="عکس مقاله @if(isset($article->title[0])) {{$article->title}} @endif" /> </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                        <div>
                                                            <span class="btn-file">
                                                                <span class="fileinput-new btn btn-success"><i class="fa fa-plus"></i>انتخاب عکس</span>
                                                                <span class="fileinput-exists btn"> تغییر </span>
                                                                <input type="file" name="image"> </span>
                            <a href="javascript:;" class="btn red fileinput-exists" id="articleImage-remove" data-dismiss="fileinput"> حذف </a>
                        </div>
                        <div class="clearfix margin-top-10">
                            <span class="label label-danger">توجه</span> فرمت های مجاز: jpg , png - حداکثر حجم مجاز: ۲۰۰KB </div>
                    </div>
                </div>
                </div>

                {{--<table class="table table-bordered table-hover">--}}
                    {{--<thead>--}}
                    {{--<tr role="row" class="heading">--}}
                        {{--<th width="8%"> Image </th>--}}
                        {{--<th width="25%"> Label </th>--}}
                        {{--<th width="8%"> Sort Order </th>--}}
                        {{--<th width="10%"> Base Image </th>--}}
                        {{--<th width="10%"> Small Image </th>--}}
                        {{--<th width="10%"> Thumbnail </th>--}}
                        {{--<th width="10%"> </th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                        {{--<td>--}}
                            {{--<a href="../assets/pages/media/works/img1.jpg" class="fancybox-button" data-rel="fancybox-button">--}}
                                {{--<img class="img-responsive" src="../assets/pages/media/works/img1.jpg" alt="action"> </a>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<input type="text" class="form-control" name="product[images][1][label]" value="Thumbnail image"> </td>--}}
                        {{--<td>--}}
                            {{--<input type="text" class="form-control" name="product[images][1][sort_order]" value="1"> </td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][1][image_type]" value="1"> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][1][image_type]" value="2"> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][1][image_type]" value="3" checked> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<a href="javascript:;" class="btn btn-default btn-sm">--}}
                                {{--<i class="fa fa-times"></i> Remove </a>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>--}}
                            {{--<a href="../assets/pages/media/works/img2.jpg" class="fancybox-button" data-rel="fancybox-button">--}}
                                {{--<img class="img-responsive" src="../assets/pages/media/works/img2.jpg" alt="action"> </a>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<input type="text" class="form-control" name="product[images][2][label]" value="Product image #1"> </td>--}}
                        {{--<td>--}}
                            {{--<input type="text" class="form-control" name="product[images][2][sort_order]" value="1"> </td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][2][image_type]" value="1"> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][2][image_type]" value="2" checked> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][2][image_type]" value="3"> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<a href="javascript:;" class="btn btn-default btn-sm">--}}
                                {{--<i class="fa fa-times"></i> Remove </a>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>--}}
                            {{--<a href="../assets/pages/media/works/img3.jpg" class="fancybox-button" data-rel="fancybox-button">--}}
                                {{--<img class="img-responsive" src="../assets/pages/media/works/img3.jpg" alt="action"> </a>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<input type="text" class="form-control" name="product[images][3][label]" value="Product image #2"> </td>--}}
                        {{--<td>--}}
                            {{--<input type="text" class="form-control" name="product[images][3][sort_order]" value="1"> </td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][3][image_type]" value="1" checked> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][3][image_type]" value="2"> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="product[images][3][image_type]" value="3"> </label>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<a href="javascript:;" class="btn btn-default btn-sm">--}}
                                {{--<i class="fa fa-times"></i> Remove </a>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            </div>
        </div>
    </div>
</div>

