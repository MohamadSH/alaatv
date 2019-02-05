@permission((Config::get('constants.SHOW_ATTRIBUTE_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
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
                <a href="{{action("IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href="{{action("HomeController@adminProduct")}}">پنل مدیریتی محصولات</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح اطلاعات صفت</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 ">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح اطلاعات صفت {{$attribute->displayName}} </span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm dark dropdown-toggle" href="{{action("HomeController@adminProduct")}}">
                                بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($attribute,['method' => 'PUT','action' => ['AttributeController@update',$attribute], 'class'=>'form-horizontal']) !!}
                    @include('attribute.form')
                    {!! Form::close() !!}

                </div>
            </div>
            @permission((Config::get('constants.LIST_ATTRIBUTEVALUE_ACCESS')))
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح اطلاعات مقدار صفت {{$attribute->displayName}} </span>
                    </div>
                </div>
                <div class="portlet-body form">
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

@section("footerPageLevelPlugin")
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
@endsection


@section("extraJS")
    <script src="/js/extraJS/edit-attribute.js" type="text/javascript"></script>
@endsection

@endpermission