@permission((Config::get('constants.SHOW_PRODUCT_FILE_ACCESS')))
@extends('partials.templatePage',['pageName'=>'admin'])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item " aria-current = "page">
                <a class = "m-link" href = "{{action("Web\AdminController@adminProduct")}}">پنل مدیریتی محصولات</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\ProductController@edit" , $productFile->product_id)}}">
                    اصلاح محصول
                    {{$productFile->product->name}}
                </a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">اصلاح فایل</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col-md-2"></div>
        <div class = "col-md-8">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            @include("systemMessage.flash")
            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                <i class = "fa fa-cogs m--margin-right-10"></i>
                                اصلاح فایل {{$productFile->name}}
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn btn-primary m-btn m-btn--icon m-btn--wide" href = "{{action("Web\ProductController@edit" , $productFile->product_id)}}"> بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    {!! Form::model($productFile,['files'=>true,'method' => 'PUT','action' => ['Web\ProductfileController@update',$productFile], 'class'=>'form-horizontal']) !!}
                    <div class = "form-body">
                        @include('product.productFile.form')
                    </div>
                    <div class = "form-actions">
                        <div class = "row">
                            <div class = "col-md-offset-3 col-md-9">
                                {!! Form::submit('اصلاح', ['class' => 'btn btn-warning m-btn m-btn--icon m-btn--wide']) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/lib/persian-date.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type = "text/javascript"></script>
    <script type = "text/javascript">
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
        });
    </script>
@endsection

@endpermission
