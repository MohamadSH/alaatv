@permission(config('constants.PRODUCT_ADMIN_PANEL_ACCESS'))@extends('app',['pageName'=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل مدیریت محصولات</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col">

            @permission((config('constants.LIST_PRODUCT_ACCESS')))

            <div class="modals-product-list">

                @permission((config('constants.COPY_PRODUCT_ACCESS')))
                <!--begin::Modal-->
                <div class="modal fade" id="copyProductModal" tabindex="-1" role="dialog" aria-labelledby="copyProductModalModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="copyProductModalModalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4 class="modal-title">آیا برای کپی مطمئن هستید؟</h4>
                                <input type="hidden" id="productIdForCopy" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                <button type="button" class="btn btn-primary" onclick="copyProductInModal()">بله</button>
                                <img class="d-none" id="copy-product-loading-image" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->
                @endpermission

                @permission((config('constants.REMOVE_PRODUCT_ACCESS')))
                <!--begin::Modal-->
                <div class="modal fade" id="removeProductModal" tabindex="-1" role="dialog" aria-labelledby="removeProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="removeProductModalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4 class="modal-title">آیا مطمئن هستید؟</h4>
                                <input type="hidden" id="product-removeLink" value="removeLink">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                <button type="submit" class="btn btn-primary btnRemoveProductInModal" onclick="removeProduct()">بله</button>
                                <img class="d-none" id="remove-product-loading-image" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->
                @endpermission


                @permission((config('constants.INSERT_PRODUCT_ACCESS')))
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
                                @include('product.form')
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

                <!--begin::Modal-->
                <div class="modal fade" id="showProductPhotoInModal" tabindex="-1" role="dialog" aria-labelledby="showProductPhotoInModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="showProductPhotoInModalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="" alt="" class="a--full-width">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->

                <!--begin::Modal-->
                <div class="modal fade" id="static-longDescription" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->
            </div>
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
                        <img class="d-none" id="product-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="product-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <div class="col">
                            @permission((config('constants.INSERT_PRODUCT_ACCESS')))
                            <a id="sample_editable_4_new" class="btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle="modal" href="#responsive-product" data-target="#responsive-product">
                                <i class="fa fa-plus"></i>
                                افزودن محصول
                            </a>
                            @endpermission
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="product_table">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="all"> نام کالا</th>
                                <th class="all">قیمت پایه</th>
                                <th class="desktop">تخفیف</th>
                                <th class="min-tablet">عکس</th>
                                <th class="desktop"> توضیحات کوتاه</th>
                                <th class="none"> توضیحات اجمالی</th>
                                <th class="desktop">نوع</th>
                                <th class="desktop">فعال/غیر فعال</th>
                                <th class="none">تعداد موجود</th>
    {{--                            <th class="none">کاتالوگ</th>--}}
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
                        <img class="d-none" id="coupon-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="coupon-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
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
                                        <i class="fa fa-plus"></i>
                                        افزودن کپن
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
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="coupon_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام کپن</th>
                            <th class="all"> کد کپن</th>
                            <th class="min-tablet"> فعال</th>
                            <th class="min-tablet">میزان تخفیف (%)</th>
                            <th class="min-tablet">حداکثر مبلغ مجاز خرید</th>
                            <th class="min-tablet">تعداد این کپن</th>
                            <th class="min-tablet">استفاده شده</th>
                            <th class="none"> نوع کپن</th>
                            <th class="none">تاریخ ثبت</th>
                            <th class="none">تاریخ شروع اعتبار:</th>
                            <th class="none">تاریخ پایان اعتبار:</th>
{{--                            @permission('config("constants.SHOW_COUPON_ACCESS") , config("constants.REMOVE_COUPON_ACCESS")')--}}
                            <th class="all"> عملیات</th>
{{--                            @endpermission--}}
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
                        <img class="d-none" id="attribute-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="attribute-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
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
                                    <a id="sample_editable_1_new" class="btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle="modal" href="#responsive-attribute" data-target="#responsive-attribute">
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
                                    <!--end::Modal-->@endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive " width="100%" id="attribute_table">
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
                        <img class="d-none" id="attributeset-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="attributeset-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
                                </a>
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
                                    <a id="sample_editable_1_new" class="btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle="modal" href="#responsive-attributeset" data-target="#responsive-attributeset">
                                        <i class="fa fa-plus"></i>
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
                                    <!--end::Modal-->@endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive " width="100%" id="attributeset_table">
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
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        @permission(config('constants.LIST_PRODUCT_ACCESS'))
        function makeDataTable_loadWithAjax_products(dontLoadAjax) {

            var newDataTable =$("#product_table").DataTable();
            newDataTable.destroy();

            $('#product_table > tbody').html("");
            let defaultContent = "<span class=\"m-badge m-badge--wide label-sm m-badge--danger\"> درج نشده </span>";
            let columns = [
                {
                    "data": null,
                    "name": "row_child",
                    "defaultContent": ""
                },
                {
                    "data": null,
                    "name": "name",
                    "title": "نام کالا",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (row.name.length === 0) {
                            return defaultContent;
                        }
                        return '<a href="'+row.url+'" target="_blank" class="m-link">'+row.name+'</a>';
                    },
                },
                { "data": "price.base" , "title": "قیمت پایه", "defaultContent": defaultContent},
                { "data": "price.discount" , "title": "تخفیف", "defaultContent": defaultContent},
                {
                    "data": null,
                    "name": "photo",
                    "title": "عکس",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        return '<img data-product-name="'+row.name+'" alt = "عکس محصول '+row.name+'" src="'+row.photo+'?w=250&h=250" class="a--full-width imgShowProductPhoto"/>';
                    },
                },
                {
                    "data": null,
                    "name": "shortDescription",
                    "title": " توضیحات کوتاه",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        return '<button class="btn m-btn--pill m-btn--air btn-info" data-target="#static-shortDescription-'+row.id+'" data-toggle="modal">نمایش</button>' +
                            "<!--begin::Modal-->\n" +
                            "<div class=\"modal fade\" id=\"static-shortDescription-"+row.id+"\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">\n" +
                            "    <div class=\"modal-dialog modal-lg\" role=\"document\">\n" +
                            "        <div class=\"modal-content\">\n" +
                            "            <div class=\"modal-body\">\n" +
                            "                <p>"+row.shortDescription+"</p>\n" +
                            "            </div>\n" +
                            "            <div class=\"modal-footer\">\n" +
                            "                <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">بستن</button>\n" +
                            "            </div>\n" +
                            "        </div>\n" +
                            "    </div>\n" +
                            "</div>\n" +
                            "<!--end::Modal-->";
                    },
                },
                {
                    "data": null,
                    "name": "longDescription",
                    "title": " توضیحات اجمالی",
                    "render": function ( data, type, row ) {
                        if (row.longDescription === null) {
                            return defaultContent;
                        }
                        return '<div class="d-none" id="txtLongDescription-'+row.id+'">'+row.longDescription+'</div><button class="btn m-btn--pill m-btn--air btn-info btnLongDescription" onclick="showLongDescription(' + "'" + row.id + "'" + ')" > '+ 'نمایش' +' </button>';
                    },
                },
                { "data": "type.hint" , "title": "نوع", "defaultContent": defaultContent},
                {
                    "data": null,
                    "name": "enable",
                    "title": "فعال/غیر فعال",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (row.enable === 0) {
                            return '<span class = "m-badge m-badge--wide label-sm m-badge--danger"> غیر فعال </span>'
                        }
                        return '<span class = "m-badge m-badge--wide label-sm m-badge--success">  فعال </span>';
                    },
                },
                { "data": "amount" , "title": "تعداد موجود", "defaultContent": 'بدون محدودیت'},
                { "data": "slogan" , "title": "اسلوگان", "defaultContent": defaultContent},
                { "data": "order" , "title": "ترتیب", "defaultContent": defaultContent},
                { "data": "attributeSet.name" , "title": "دسته صفت ها", "defaultContent": defaultContent},
                { "data": "jalaliValidSince" , "title": "معتبر از", "defaultContent": defaultContent},
                { "data": "jalaliValidUntill" , "title": "معتبر تا", "defaultContent": defaultContent},
                { "data": "jalaliValidCreatedAt" , "title": "تاریخ ایجاد", "defaultContent": defaultContent},
                { "data": "jalaliValidUpdatesAt" , "title": "تاریخ اصلاح", "defaultContent": defaultContent},
                { "data": "bonPlus" , "title": "تعداد بن", "defaultContent": defaultContent},
                { "data": "bonDiscount" , "title": "تخفیف هر بن(٪)", "defaultContent": defaultContent},
                {
                    "data": null,
                    "name": "functions",
                    "title": "عملیات",
                    defaultContent: '',
                    "render": function ( data, type, row ) {
                        let html = '<div class="btn-group">\n';
                        @permission((config('constants.SHOW_PRODUCT_ACCESS')))
                        html +=
                            '    <a target="_blank" class="btn btn-success" href="' + row.editLink + '">\n' +
                            '        <i class="fa fa-pencil"></i> اصلاح \n' +
                            '    </a>\n';
                        @endpermission
                        @permission((config('constants.REMOVE_PRODUCT_ACCESS')))
                        html +=
                            '    <a class="btn btn-danger btnDeleteOrder" remove-link="' + row.removeLink + '" data-product-name="' + row.name + '">\n' +
                            '        <i class="fa fa-remove" aria-hidden="true"></i> حذف \n' +
                            '    </a>\n';
                        @endpermission
                        @permission((config('constants.COPY_PRODUCT_ACCESS')))
                        html +=
                            '    <a class="btn btn-info copyProduct" onclick="showCopyProductModal(' + row.id + ', ' + "'" + row.name + "'" + ')">\n' +
                            '        <i class="fa fa-envelope" aria-hidden="true"></i> کپی از محصول\n' +
                            '    </a>\n';
                        @endpermission
                        html += '</div>';

                        return html;
                    }
                },
            ];
            let dataFilter = function(data){
                let json = jQuery.parseJSON( data );
                json.recordsTotal = json.result.total;
                json.recordsFiltered = json.result.total;
                return JSON.stringify( json );
            };
            let ajaxData = function (data) {
                mApp.block('#product_table_wrapper', {
                    type: "loader",
                    state: "info",
                });
                data.productPage = getNextPageParam(data.start, data.length);
                data.moderator = 1;
                delete data.columns;
                return data;
            };
            let dataSrc = function (json) {
                console.log('json.result.data: ', json.result.data);
                $("#product-portlet-loading").addClass("d-none");
                mApp.unblock('#product_table_wrapper');
                return json.result.data;
            };
            let url = '/product';
            if (dontLoadAjax) {
                url = null;
            } else {
                $("#product-portlet-loading").removeClass("d-none");
            }
            let dataTable = makeDataTable_loadWithAjax("product_table", url, columns, dataFilter, ajaxData, dataSrc);
            return dataTable;
        }
        @endpermission
    </script>

    <script src="/acm/AlaatvCustomFiles/js/admin/page-productAdmin.js" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            @permission(config('constants.LIST_PRODUCT_ACCESS'));
                $("#product-portlet .reload").trigger("click");
                $("#product-expand").trigger("click");
                $('#productShortDescriptionSummerNote').summernote({
                        lang: 'fa-IR',
                        height: 200,
                        popover: {
                            image: [],
                            link: [],
                            air: []
                        }
                    });
                $('#productLongDescriptionSummerNote').summernote({
                    lang: 'fa-IR',
                    height: 200,
                    popover: {
                        image: [],
                        link: [],
                        air: []
                    }
                });
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
