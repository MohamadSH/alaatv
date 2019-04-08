@permission((config('constants.SHOW_ATTRIBUTE_ACCESS')))

@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a class="m-link" href="{{action("Web\HomeController@adminProduct")}}">پنل مدیریت محصولات</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">اصلاح اطلاعات صفت</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            @include("systemMessage.flash")

            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <i class="fa fa-cogs m--margin-right-10"></i>
                                اصلاح اطلاعات صفت {{$attribute->displayName}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a class = "btn btn-primary m-btn m-btn--icon m-btn--wide" href = "{{action("Web\HomeController@adminProduct")}}">
                            بازگشت
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body">
                    {!! Form::model($attribute,['method' => 'PUT','action' => ['Web\AttributeController@update',$attribute], 'class'=>'form-horizontal']) !!}
                    @include('attribute.form')
                    {!! Form::close() !!}
                </div>
            </div>
            
            @permission((config('constants.LIST_ATTRIBUTEVALUE_ACCESS')))

            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <i class="fa fa-cogs m--margin-right-10"></i>
                                اصلاح اطلاعات مقدار صفت {{$attribute->displayName}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a class = "btn btn-primary m-btn m-btn--icon m-btn--wide" href = "{{action("Web\HomeController@adminProduct")}}">
                            بازگشت
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="form-horizontal">
                        @include('attributevalue.index')
                    </div>
                </div>
            </div>
            @endpermission
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
@endsection

@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>--}}
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-edit-attribute.js" type="text/javascript"></script>
@endsection

@endpermission