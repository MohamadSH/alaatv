@permission((Config::get('constants.SHOW_PRODUCT_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("metadata")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection


@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href="{{action("HomeController@adminProduct")}}">پنل مدیریتی محصولات</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح اطلاعات محصول</span>
            </li>
        </ul>
        <ul class="text-right margin-bottom-10 margin-top-10 margin-right-10">
            <a class="btn btn-sm dark dropdown-toggle"
               href="@if($product->hasParents()) {{action("ProductController@edit" , $product->parents->first())}} @else{{action("HomeController@adminProduct")}}@endif">
                بازگشت
                <i class="fa fa-angle-left"></i>
            </a>
        </ul>
    </div>
@endsection

@section("content")
    <div class="form-group">
        @include("systemMessage.flash")
    </div>
    <div class="row">
        <div class="col-md-6 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح اطلاعات <a
                                    href="{{action("ProductController@show" , $product)}}">{{$product->name}}</a></span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($product,['files'=>true,'method' => 'PUT','action' => ['ProductController@update',$product], 'class'=>'form-horizontal']) !!}
                    @include('product.form' )
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
        {{--<div class="col-md-6">--}}
        {{--<div class="actions">--}}
        {{--<div class="btn-group">--}}
        {{--<a class="btn btn-sm btn-info dropdown-toggle" href="{{action("ProductController@editAttributevalues", $product)}}" >اصلاح مقدار صفت ها--}}
        {{--<i class="fa fa-angle-left"></i>--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        @permission((Config::get('constants.LIST_CONFIGURE_PRODUCT_ACCESS')))
        {{--        @if($product->hasChildren())--}}
        <div class="col-md-6 ">
            @include('product.partials.configureTableForm')
        </div>
        {{--@endif--}}
        @endpermission

        @permission((Config::get('constants.LIST_PRODUCT_FILE_ACCESS')))
        <div class="col-md-6">
            @include('product.productFile.index')
        </div>
        @endpermission

        @permission((Config::get('constants.LIST_PRODUCT_SAMPLE_PHOTO_ACCESS')))
        <div class="col-md-6">
            @include('product.samplePhoto.index')
        </div>
        @endpermission

        <div class="col-md-6">
            @include("product.complimentary")
        </div>

        <div class="col-md-6">
            @include("product.gift")
        </div>
        <div id="removeProductGiftModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            {!! Form::open(['action' => ['ProductController@removeGift' , $product] ,'class'=>'form-horizontal' , 'class' => 'removeProductGiftForm']) !!}
            <div class="modal-header">
                <h4> آیا مطمئن هستید؟ </h4>
            </div>
            <div class="modal-body">
                {!! Form::hidden('giftId',null) !!}
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                <button type="submit" class="btn green">بله</button>
                <img class="hidden" id="remove-product-gift-loading-image"
                     src="{{Config::get('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/components-editors.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js"
            type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
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
    <script src="/js/extraJS/admin-product.js" type="text/javascript"></script>
@endsection
@endpermission
