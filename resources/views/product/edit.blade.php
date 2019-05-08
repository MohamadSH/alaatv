@permission((config('constants.SHOW_PRODUCT_ACCESS')))@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel = "stylesheet" type = "text/css"/>
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href = "/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\HomeController@adminProduct")}}">پنل مدیریتی محصولات</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">اصلاح اطلاعات محصول</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "@if($product->hasParents()) {{action("Web\ProductController@edit" , $product->parents->first())}} @else{{action("Web\HomeController@adminProduct")}}@endif">
                    بازگشت
                </a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    @include("systemMessage.flash")

    <div class = "row">
        <div class = "col-md-6 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                اصلاح اطلاعات
                                <a class = "m-link" href = "{{action("Web\ProductController@show" , $product)}}">{{$product->name}}</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    <div class = "m-portlet__body-progress">Loading</div>
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
        @permission((config('constants.LIST_CONFIGURE_PRODUCT_ACCESS')))
        @if($product->hasChildren())
        <div class = "col-md-6 ">
                            @include('product.partials.configureTableForm')
        </div>
        @endif
        @endpermission

        @permission((config('constants.LIST_PRODUCT_FILE_ACCESS')))
        <div class = "col-md-6">
                            @include('product.productFile.index')
        </div>
        @endpermission

        @permission((config('constants.LIST_PRODUCT_SAMPLE_PHOTO_ACCESS')))
        <div class = "col-md-6">
                            @include('product.samplePhoto.index')
        </div>
        @endpermission

        <div class = "col-md-6">
                        @include("product.complimentary")
        </div>

        <div class = "col-md-6">
            @include("product.gift")
        </div>

        <!--begin::Modal-->
        <div class = "modal fade" id = "removeProductGiftModal" tabindex = "-1" role = "dialog" aria-hidden = "true">
            <div class = "modal-dialog" role = "document">
                <div class = "modal-content">
                    {!! Form::open(['action' => ['Web\ProductController@removeGift' , $product] ,'class'=>'form-horizontal' , 'class' => 'removeProductGiftForm']) !!}
                    <div class = "modal-body">
                        <p> آیا مطمئن هستید؟</p>
                        {!! Form::hidden('giftId',null) !!}
                    </div>
                    <div class = "modal-footer">
                        <button type = "button" class = "btn btn-secondary" data-dismiss = "modal">خیر</button>
                        <button type = "submit" class = "btn btn-primary">بله</button>
                        <img class = "hidden" id = "remove-product-gift-loading-image" src = "{{config('constants.FILTER_LOADING_GIF')}}" alt = "loading" height = "25px" width = "25px">
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!--end::Modal-->

    </div>

@endsection

@section('page-js')
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-summernote/summernote.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/lib/persian-date.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type = "text/javascript"></script>
    <script src = "public/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-editors.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type = "text/javascript"></script>

    <script>
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
    <script src = "public/acm/AlaatvCustomFiles/js/admin-product.js" type = "text/javascript"></script>
@endsection
@endpermission
