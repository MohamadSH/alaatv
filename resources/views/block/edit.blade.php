@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
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
        .operations {
            width: 172px;
        }
        .itemId {
            width: 100px;
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
                <a class="m-link" href="{{ route('blockAdmin') }}">لیست بلاک ها</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">
                    اصلاح بلاک
                    {{ $block->title }}
                </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    
    @include("systemMessage.flash")
    
    <div class="row">
        <div class="col">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--tabs m-portlet--success m-portlet--head-solid-bg m-portlet--bordered">
                {!! Form::model($block,['method' => 'PUT','action' => ['Web\BlockController@update',$block]]) !!}
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_12_1" role="tab">
                                    <i class="flaticon-cogwheel"></i>
                                    اصلاح اطلاعات کلی
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_12_2" role="tab">
                                    <i class="flaticon-open-box"></i>
                                    محصولات
                                    <span class="m-badge m-badge--info">{{ $block->products()->count() }}</span>
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_12_3" role="tab">
                                    <i class="flaticon-interface-3"></i>
                                    دسته محتوا
                                    <span class="m-badge m-badge--info">{{ $block->sets()->count() }}</span>
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_12_4" role="tab">
                                    <i class="flaticon-file-2"></i>
                                    محتوا
                                    <span class="m-badge m-badge--info">{{ $block->contents()->count() }}</span>
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_12_5" role="tab">
                                    <i class="flaticon-notes"></i>
                                    بنرها
                                    <span class="m-badge m-badge--info">{{ $block->banners()->count() }}</span>
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <button type="submit" class="btn m-btn--pill m-btn--air btn-warning">اصلاح</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_tabs_12_1" role="tabpanel">
                            @include('block.form' )
                        </div>
                        <div class="tab-pane" id="m_tabs_12_2" role="tabpanel">
                            <div>
        
                                <div class="m-divider m--margin-top-50">
                                    <span></span>
                                    <span>افزودن محصول جدید به این بلاک</span>
                                    <span></span>
                                </div>
        
                                @include('admin.filters.productsFilter', [
                                    "id" => "block-products",
                                    "name" => "block-products",
                                    'everyProduct'=>false,
                                    'title'=>'انتخاب محصول'
                                ])
    
                            </div>
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="block_product_table">
                                <thead>
                                    <tr>
                                        <th class="itemId">#</th>
                                        <th>نام</th>
                                        <th class="operations">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($block->products()->get() as $product)
                                        <tr>
                                            <td class="itemId">{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td class="operations">
                                                <div class="btn-group" role="group" aria-label="First group">
                                                    <a href="{{ $product->editLink }}" class="m-btn btn btn-warning">
                                                        <i class="la la-pencil"></i>
                                                        ویرایش
                                                    </a>
                                                    <button type="button" class="m-btn btn btn-danger">
                                                        <i class="la la-paperclip"></i>
                                                        حذف
                                                    </button>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="m_tabs_12_3" role="tabpanel">
                            <div>
        
                                <div class="m-divider m--margin-top-50">
                                    <span></span>
                                    <span>افزودن دسته جدید به این بلاک</span>
                                    <span></span>
                                </div>
                                <select class="mt-multiselect btn btn-default a--full-width"
                                        multiple="multiple"
                                        data-label="left"
                                        data-width="100%"
                                        data-filter="true"
                                        data-height="200"
                                        id="block-sets"
                                        name="block-sets[]"
                                        title="انتخاب دسته">
                                    @foreach($sets as $set)
                                        <option value="{{$set->id}}"
                                                @if($blockSets->contains('id', $set->id))
                                                class="bold"
                                                selected="selected"
                                                @endif>
                                            #{{$set->id}}-{{$set->name}}
                                        </option>
                                    @endforeach
                                </select>
    
                            </div>
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="block_set_table">
                                <thead>
                                <tr>
                                    <th class="itemId">#</th>
                                    <th>نام</th>
                                    <th class="operations">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blockSets as $set)
                                    <tr>
                                        <td class="itemId">{{ $set->id }}</td>
                                        <td>{{ $set->name }}</td>
                                        <td class="operations">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <a href="{{ $set->editLink }}" class="m-btn btn btn-warning">
                                                    <i class="la la-pencil"></i>
                                                    ویرایش
                                                </a>
                                                <button type="button" class="m-btn btn btn-danger">
                                                    <i class="la la-paperclip"></i>
                                                    حذف
                                                </button>
                                            </div>
                    
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="m_tabs_12_4" role="tabpanel">
                            <div>
        
                                <div class="m-divider m--margin-top-50">
                                    <span></span>
                                    <span>افزودن محتوا جدید به این بلاک</span>
                                    <span></span>
                                </div>
    
                                <div class="row">
                                    <label class="col-md-2 control-label" for="tags">
                                        شماره محتوا را وارد کنید:
                                    </label>
                                    <div class="col-md-9">
                                        <input name="contents" type="text" class="form-control input-large contents" value="{{ implode(',',$blockContents->pluck('id')->toArray()) }}">
                                    </div>
                                </div>
    
                            </div>
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="block_content_table">
                                <thead>
                                <tr>
                                    <th class="itemId">#</th>
                                    <th>نام</th>
                                    <th class="operations">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blockContents as $content)
                                    <tr>
                                        <td class="itemId">{{ $content->id }}</td>
                                        <td>{{ $content->name }}</td>
                                        <td class="operations">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <a href="{{ $content->editLink }}" class="m-btn btn btn-warning">
                                                    <i class="la la-pencil"></i>
                                                    ویرایش
                                                </a>
                                                <button type="button" class="m-btn btn btn-danger">
                                                    <i class="la la-paperclip"></i>
                                                    حذف
                                                </button>
                                            </div>
                    
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="m_tabs_12_5" role="tabpanel">
                            <div>
                                <button type="button" class="btn m-btn--pill m-btn--air btn-info">
                                    افزودن
                                    بنر
                                </button>
                            </div>
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="block_banner_table">
                                <thead>
                                <tr>
                                    <th class="itemId">#</th>
                                    <th>نام</th>
                                    <th class="operations">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($block->banners()->get() as $banner)
                                    <tr>
                                        <td class="itemId">{{ $banner->id }}</td>
                                        <td>{{ $banner->name }}</td>
                                        <td class="operations">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <a href="{{ $banner->editLink }}" class="m-btn btn btn-warning">
                                                    <i class="la la-pencil"></i>
                                                    ویرایش
                                                </a>
                                                <button type="button" class="m-btn btn btn-danger">
                                                    <i class="la la-paperclip"></i>
                                                    حذف
                                                </button>
                                            </div>
                    
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!--end::Portlet-->
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
    <script src="public/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>
    <script>

        $("input.productTags").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });
        $("input.contents").tagsinput({
            tagClass: 'm-badge m-badge--info m-badge--wide m-badge--rounded'
        });
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
            makeDataTable("block_product_table");
            makeDataTable("block_set_table");
            makeDataTable("block_content_table");
            makeDataTable("block_banner_table");
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
            $('#productLongDescriptionSummerNote').summernote({height: 300});
            $('#productSpecialDescriptionSummerNote').summernote({height: 300});


        });

        $(document).on("change", "#productFileTypeSelect", function () {
            var lastOrder = $("#lastProductFileOrder_" + $(this).val()).val();
            $("#productFileOrder").val(lastOrder);
        });
    </script>
@endsection