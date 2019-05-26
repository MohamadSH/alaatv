@permission((config('constants.SHOW_PRODUCT_ACCESS')))@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel="stylesheet" type="text/css"/>
    <style>
        .fileinput img {
            max-width: 100%;
            min-width: 100%;
        }

        .multiselect-native-select, .mt-multiselect {
            width: 100%;
        }
    </style>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a class="m-link" href="{{action("Web\AdminController@adminProduct")}}">پنل مدیریتی محصولات</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">اصلاح اطلاعات دسته</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include("systemMessage.flash")

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                اصلاح اطلاعات
                                <a class="m-link" href="{{action("Web\SetController@show" , $set)}}">{{$set->name}}</a>
                                 (تعداد محتوا: {{ $set->contents_count }})
                                
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        فعال
                                        <input type="checkbox" value="1" name="isFree" @if($set->enable) checked @endif />
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mt-checkbox-list">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        قابل نمایش برای کاربران
                                        <input type="checkbox" value="1" name="isFree" @if($set->display) checked @endif />
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
                                {!! Form::text('name', $set->name, ['class' => 'form-control', 'id' => 'name' ]) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
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
                                {!! Form::text('small_name', $set->small_name, ['class' => 'form-control', 'id' => 'name' ]) !!}
                                @if ($errors->has('small_name'))
                                    <span class="help-block">
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
                                {!! Form::textarea('description', $set->description, ['class' => 'form-control', 'id' => 'productShortDescriptionSummerNote' ]) !!}
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                     </span>
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                        <div class="row">
                            <label class="control-label col-md-3">عکس</label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="{{ $set->photo }}" class="a--full-width" @if(strlen($set->name)>0) alt="{{$set->name}}" @else  alt="عکس محصول" @endif/>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
                                        <span class="btn m-btn--pill m-btn--air btn-warning default btn-file">
                                            <span class="fileinput-new"> تغییر عکس </span>
                                            <span class="fileinput-exists"> تغییر </span>
                                            <input type="file" name="image">
                                        </span>
                                        <a href="javascript:" class="btn m-btn--pill m-btn--air btn-danger fileinput-exists" data-dismiss="fileinput"> حذف</a>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
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
                                <input name="tags" type="text" class="form-control input-large setTags" value="@if(isset($set->tags)){{ implode(',',$set->tags->tags) }}@endif" data-role="tagsinput">
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
                        
                        <div class="text-center m--margin-top-30">
                            <button type="button" class="btn m-btn--pill m-btn--air btn-primary btnAttachProductToSet">
                                افزودن
                            </button>
                        </div>
                        
                    </div>
                    
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
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>

    </div>

@endsection

@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>
    <script>

        $("input.setTags").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
            /*
             validdSince
             */
            $("#productFileValidSince").persianDatepicker({
                altField: '#productFileValidSinceAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            $('#productShortDescriptionSummerNote').summernote({height: 300});

            makeDataTable('productTable');

            $(document).on('click', '.btnAttachProductToSet', function(){
                let setProduct = $('#setProduct').val();
                alert('ابتدا مقادیر سلکت شده به بک اند فرستاده می شوند سپس صفحه رفرش می شود.');
            });

        });
    </script>
    <script src="/acm/AlaatvCustomFiles/js/admin-product.js" type="text/javascript"></script>
@endsection
@endpermission
