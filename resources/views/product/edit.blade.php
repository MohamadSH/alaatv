@permission((config('constants.SHOW_PRODUCT_ACCESS')))@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a class="m-link" href="{{action("Web\AdminController@adminProduct")}}">پنل مدیریتی محصولات</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">اصلاح اطلاعات محصول</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a class="m-link" href="@if($product->hasParents()) {{action("Web\ProductController@edit" , $product->parents->first())}} @else{{action("Web\AdminController@adminProduct")}}@endif">
                    بازگشت
                </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include("systemMessage.flash")

    <div class="row">
        <div class="
            @if(
                isset( $product->sets ) && $product->sets->count() > 0
                ||
                $product->hasChildren()
                )
                    col-md-6
            @else
                col-md-12
            @endif">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                اصلاح اطلاعات
                                <a class="m-link" href="{{action("Web\ProductController@show" , $product)}}">{{$product->name}}</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-portlet__body-progress">Loading</div>
                    {!! Form::model($product,['files'=>true,'method' => 'PUT','action' => ['Web\ProductController@update',$product], 'class'=>'form-horizontal']) !!}
                        @include('product.form' )
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>

       {{-- <div class="col-md-6">
        <div class="actions">
        <div class="btn-group">
        <a class="btn btn-sm btn-info dropdown-toggle" href="{{action("Web\ProductController@editAttributevalues", $product)}}" >اصلاح مقدار صفت ها
        <i class="fa fa-angle-left"></i>
        </a>
        </div>
        </div>
        </div>--}}
        @if(
            isset( $product->sets ) && $product->sets->count() > 0
            ||
            $product->hasChildren()
            )
        <div class="col-md-6 ">
            @if(isset( $product->sets ) && $product->sets->count() > 0)
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    @if($product->producttype->id == config("constants.PRODUCT_TYPE_CONFIGURABLE"))
                                        پیکربندی محصول ٬
                                    @endif
                                    <a href="{{action("Web\ProductController@show" , $product)}}">{{$product->name}}</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">نام</th>
                                <th class="text-center">مشاهده</th>
                                <th class="text-center">ویرایش</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($product->sets as $set)
                                    <tr>
                                        <td>{{ $set->name }}</td>
                                        <td>
                                            <a target="_blank" href="{{ action('Web\SetController@indexContent', $set->id) }}" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                                <i class="flaticon-medical"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{ action('Web\SetController@edit', $set->id) }}" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                                <i class="flaticon-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @permission((config('constants.LIST_CONFIGURE_PRODUCT_ACCESS')))
            @if($product->hasChildren())
                @include('product.partials.configureTableForm')
            @endif
        @endpermission
        </div>
        @endif

        @permission((config('constants.LIST_PRODUCT_FILE_ACCESS')))
            <div class="col-md-12">
                <!-- BEGIN PRODUCT TABLE PORTLET-->
                <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productFiles-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                                <h3 class="m-portlet__head-text">
                                    فایل های محصول
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                        <i class="fa fa-redo-alt"></i>
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
                        @include('product.productFile.index')
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        @endpermission

        @permission((config('constants.LIST_PRODUCT_SAMPLE_PHOTO_ACCESS')))
            <div class="col-md-12">
                <!-- BEGIN PRODUCT TABLE PORTLET-->
                <div class="m-portlet m-portlet--head-solid-bg m-portlet--info m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productPictures-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                                <h3 class="m-portlet__head-text">
                                    نمونه عکسهای محصول
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                        <i class="fa fa-redo-alt"></i>
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
                        @include('product.samplePhoto.index')
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        @endpermission

        <div class="col-md-12">
            <!-- BEGIN PRODUCT TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--primary m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productComplimentary-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                محصولات دوست
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo-alt"></i>
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
                    @include("product.complimentary")
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>

        <div class="col-md-12">
            <!-- BEGIN PRODUCT TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--success m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="productGift-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                محصولات هدیه
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo-alt"></i>
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
                    @include("product.gift")
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>

        <!--begin::Modal-->
        <div class="modal fade" id="removeProductGiftModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {!! Form::open(['action' => ['Web\ProductController@removeGift' , $product] ,'class'=>'form-horizontal' , 'class' => 'removeProductGiftForm']) !!}
                    <div class="modal-body">
                        <p> آیا مطمئن هستید؟</p>
                        {!! Form::hidden('giftId',null) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-primary">بله</button>
                        <img class="hidden" id="remove-product-gift-loading-image" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--end::Modal-->

    </div>

@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script>

        function removePhotoShowModal(actionLink, photoAddress) {
            $('#removeProductPhotoActionLink').val(actionLink);
            $('#removeProductPhoto img').attr('src', photoAddress);
            $('#removeProductPhoto').modal('show');
        }

        $("input.productTags").tagsinput({
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
            $('#productLongDescriptionSummerNote').summernote({height: 300});
            $('#productSpecialDescriptionSummerNote').summernote({height: 300});


        });

        $(document).on("change", "#productFileTypeSelect", function () {
            var lastOrder = $("#lastProductFileOrder_" + $(this).val()).val();
            $("#productFileOrder").val(lastOrder);
        });
    </script>
    <script src="public/acm/AlaatvCustomFiles/js/admin/page-productAdmin.js" type="text/javascript"></script>
@endsection
@endpermission
