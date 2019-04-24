@permission(config('constants.PRODUCT_ADMIN_PANEL_ACCESS'))
@extends('app',['pageName'=>$pageName])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jplayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل مدیریت محصولات</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        {{--Ajax modal loaded after inserting content--}}
        <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
        {{--Ajax modal for panel startup --}}
        <!-- /.modal -->

        <div class="col-md-12">
            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--@role(('admin'))<p>ادمین محترم‌، لیست بنهای تخصیص داده شده به کاربران به این صفحه اضافه شده است! همچنین افزودن بنهای محصول بعد از تایید سفارش نیز در اصلاح سفارشهای تایید نشده اضافه شده است.</p>@endrole--}}
            {{--<strong class="m--font-danger"> اگر این بار اول است که از تاریخ ۳ اسفند به بعد از این پنل استفاده می کنید ، لطفا کش بروزر خود را خالی نمایید . با تشکر</strong>--}}
            {{--</div>--}}
            @permission((config('constants.LIST_PRODUCT_ACCESS')))
            <!-- BEGIN PRODUCT TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="product-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت محصولات
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-nonr" id="product-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload"><i class="la la-refresh"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="product-expand"><i class="la la-expand"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @permission((config('constants.INSERT_PRODUCT_ACCESS')))
                                    <a id="sample_editable_4_new" class="btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle="modal" href="#responsive-product" data-target="#responsive-product">
                                        <i class="fa fa-plus"></i> افزودن محصول
                                    </a>
                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-product" tabindex="-1" role="dialog" aria-labelledby="responsive-productModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-productModalLabel">افزودن محصول جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['Web\ProductController@store'], 'class'=>'nobottommargin' , 'id'=>'productForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('product.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                    <button type="button" class="btn btn-primary" id="productForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    @permission((config('constants.REMOVE_PRODUCT_ACCESS')))
                    <!--begin::Modal-->
                    <div class="modal fade" id="copyProductModal" tabindex="-1" role="dialog" aria-labelledby="copyProductModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                {!! Form::open(['class'=>'form-horizontal copyProductForm']) !!}
                                <div class="modal-header">
                                    <h5 class="modal-title" id="copyProductModalModalLabel"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4 class="modal-title">آیا مطمئن هستید؟</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                    <button type="submit" class="btn btn-primary" id="copy-product-loading-image">بله</button>
                                    <img class="d-nonr" id="copy-product-loading-image"
                                         src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px"
                                         width="25px">
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                    @endpermission
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="product_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام کالا</th>
                            <th class="all">قیمت پایه</th>
                            <th class="desktop">تخفیف</th>
                            <th class="min-tablet"> عکس</th>
                            <th class="desktop"> توضیحات کوتاه</th>
                            <th class="none"> توضیحات اجمالی</th>
                            <th class="desktop">نوع</th>
                            <th class="desktop">فعال/غیر فعال</th>
                            <th class="none">تعداد موجود</th>
                            <th class="none">کاتالوگ</th>
                            <th class="none">اسلوگان</th>
                            <th class="none">ترتیب</th>
                            <th class="none">دسته صفت ها</th>
                            <th class="none">معتبر از</th>
                            <th class="none">معتبر تا</th>
                            <th class="none">تاریخ ایجاد</th>
                            <th class="none">تاریخ اصلاح</th>
                            <th class="none">تعداد بن</th>
                            <th class="none">تخفیف هر بن(٪)</th>
                            <th class="all">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission

            @permission((config('constants.LIST_COUPON_ACCESS')))
            <!-- BEGIN COUPON TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--info m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="coupon-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت کپن ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-nonr" id="coupon-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload"><i class="la la-refresh"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="coupon-expand"><i class="la la-expand"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @permission((config('constants.INSERT_COUPON_ACCESS')))
                                    <a id="sample_editable_3_new" class="btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle="modal" href="#responsive-coupon" data-target="#responsive-coupon">
                                        <i class="fa fa-plus"></i> افزودن کپن
                                    </a>

                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-coupon" tabindex="-1" role="dialog" aria-labelledby="responsive-couponModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="copyProductModalModalLabel">افزودن کپن جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['method' => 'POST','action' => ['Web\CouponController@store'], 'class'=>'nobottommargin' , 'id'=>'couponForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('coupon.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                    <button type="button" class="btn btn-primary" id="couponForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="coupon_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام کپن</th>
                            <th class="all"> کد کپن</th>
                            {{--<th class="desktop"> عکس </th>--}}
                            <th class="min-tablet">میزان تخفیف (%)</th>
                            <th class="min-tablet">حداکثر مبلغ مجاز خرید</th>
                            <th class="min-tablet">تعداد این کپن</th>
                            <th class="min-tablet">استفاده شده</th>
                            <th class="none"> نوع کپن</th>
                            <th class="none">تاریخ ثبت</th>
                            <th class="none">تاریخ شروع اعتبار:</th>
                            <th class="none">تاریخ پایان اعتبار:</th>
                            @permission('config("constants.SHOW_COUPON_ACCESS") ,
                            config("constants.REMOVE_COUPON_ACCESS")')
                            <th class="all"> عملیات</th>
                            @endpermission
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission

            @permission((config('constants.LIST_ATTRIBUTE_ACCESS')))
            <!-- BEGIN ASSIGNMENT TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--primary m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="attribute-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت صفت ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-nonr" id="attribute-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload"><i class="la la-refresh"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="attribute-expand"><i class="la la-expand"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @permission((config('constants.INSERT_ATTRIBUTE_ACCESS')))
                                    <a id="sample_editable_1_new" class="btn btn-info m-btn m-btn--icon m-btn--wide"
                                       data-toggle="modal" href="#responsive-attribute" data-target="#responsive-attribute">
                                        <i class="fa fa-plus"></i>
                                        افزودن صفت
                                    </a>

                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-attribute" tabindex="-1" role="dialog" aria-labelledby="responsive-attributeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-attributeModalLabel">افزودن صفت جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['method' => 'POST','action' => ['Web\AttributeController@store'], 'class'=>'nobottommargin' , 'id'=>'attributeForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('attribute.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                    <button type="button" class="btn btn-primary" id="attributeForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive " width="100%"
                           id="attribute_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام (اصلی)</th>
                            <th class="all"> نام قابل نمایش (فارسی)</th>
                            <th class="all"> نوع کنترل صفت</th>
                            <th class="none"> توضیح</th>
                            <th class="none"> زمان درج</th>
                            <th class="none"> زمان اصلاح</th>
                            <th class="all"> عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission

            @permission((config('constants.LIST_ATTRIBUTESET_ACCESS')))
            <!-- BEGIN ASSIGNMENT TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--success m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="attributeset-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت دسته صفت ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-nonr" id="attributeset-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload"><i class="la la-refresh"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="attributeset-expand"><i class="la la-expand"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @permission((config('constants.INSERT_ATTRIBUTESET_ACCESS')))
                                    <a id="sample_editable_1_new" class="btn btn-info m-btn m-btn--icon m-btn--wide"
                                       data-toggle="modal" href="#responsive-attributeset" data-target="#responsive-attributeset"><i class="fa fa-plus"></i>
                                        افزودن دسته صفت
                                    </a>

                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-attributeset" tabindex="-1" role="dialog" aria-labelledby="responsive-attributesetModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-attributesetModalLabel">افزودن دسته صفت جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['method' => 'POST','action' => ['Web\AttributesetController@store'], 'class'=>'nobottommargin' , 'id'=>'attributesetForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('attributeset.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="attributesetForm-close">بستن</button>
                                                    <button type="button" class="btn btn-primary" id="attributesetForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive " width="100%"
                           id="attributeset_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام</th>
                            <th class="all"> توضیح</th>
                            <th class="desktop"> زمان درج</th>
                            <th class="none"> زمان اصلاح</th>
                            <th class="all"> عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission
        </div>
    </div>
@endsection

@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-indexProduct.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-coupon.js" type="text/javascript"></script>
    <script src="public/acm/AlaatvCustomFiles/js/admin-product.js" type="text/javascript"></script>
    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {

            /*
             validdSince
             */
            $("#couponValidSince").persianDatepicker({
                altField: '#couponValidSinceAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            /*
             validUntil
             */
            $("#couponValidUntil").persianDatepicker({
                altField: '#couponValidUntilAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            @permission(config('constants.LIST_PRODUCT_ACCESS'));
                $("#product-portlet .reload").trigger("click");
                $("#product-expand").trigger("click");
                $('#productShortDescriptionSummerNote').summernote({height: 200});
                $('#productLongDescriptionSummerNote').summernote({height: 200});
            @endpermission;
            @permission(config('constants.LIST_COUPON_ACCESS'));
                $("#coupon-portlet .reload").trigger("click");
                $("#coupon-expand").trigger("click");
            @endpermission;
            @permission(config('constants.LIST_ATTRIBUTE_ACCESS'));
                $("#attribute-portlet .reload").trigger("click");
                $("#attribute-expand").trigger("click");
            @endpermission;
            @permission(config('constants.LIST_ATTRIBUTESET_ACCESS'));
                $("#attributeset-portlet .reload").trigger("click");
                $("#attributeset-expand").trigger("click");
            @endpermission

        });

    </script>
@endsection
@endpermission