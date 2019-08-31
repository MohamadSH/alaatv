@permission((config('constants.SHOW_ATTRIBUTESET_ACCESS')))@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel = "stylesheet" type = "text/css"/>
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\AdminController@adminProduct")}}">پنل مدیریت محصولات</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">اصلاح اطلاعات دسته صفت</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col-md-2"></div>
        <div class = "col-md-8">
            @include("systemMessage.flash")

            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                <i class = "fa fa-cogs m--margin-right-10"></i>
                                اصلاح اطلاعات دسته صفت {{$attributeset->name}}
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn btn-primary m-btn m-btn--icon m-btn--wide" href = "{{action("Web\AdminController@adminProduct")}}">
                            بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    {!! Form::model($attributeset,['method' => 'PUT','action' => ['Web\AttributesetController@update',$attributeset], 'class'=>'form-horizontal']) !!}
                    @include('attributeset.form')
                    {!! Form::close() !!}
                </div>
            </div>

            @permission((config('constants.LIST_ATTRIBUTEGROUP_ACCESS')))

            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                <i class = "fa fa-cogs m--margin-right-10"></i>
                                اصلاح اطلاعات گروه صفت {{$attributeset->name}}
                            </h3>
                        </div>
                    </div>
                </div>

                {{--Ajax modal loaded after inserting content--}}
                <div id = "ajax-modal" class = "modal fade" tabindex = "-1"></div>

                <div class = "m-portlet__body">
                    <div class = "form-horizontal">
                        <!-- BEGIN ASSIGNMENT TABLE PORTLET-->
                        <div class = "portlet box yellow-haze" id = "attributegroup-portlet">
                            <div class = "portlet-title">
                                <div class = "caption">
                                    <i class = "fa fa-cogs"></i>
                                    گروه صفت ها
                                </div>
                                <div class = "tools">
                                    <a href = "javascript:" class = "collapse" id = "attributegroup-expand"></a>
                                    <a href = "javascript:" class = "reload"></a>
                                    <a href = "javascript:" class = "remove"></a>
                                </div>
                                <div class = "tools"></div>
                            </div>
                            <div class = "portlet-body" style = "display: block;">

                                <div class = "table-toolbar">
                                    <div class = "row">
                                        <div class = "col-md-6">

                                            <div class = "btn-group">
                                                @permission((config('constants.INSERT_ATTRIBUTEGROUP_ACCESS')))
                                                <a id = "sample_editable_1_new" class = "btn btn-info m-btn m-btn--icon m-btn--wide" data-toggle = "modal" href = "#responsive-attributegroup" data-target = "#responsive-attributegroup">
                                                    <i class = "fa fa-plus"></i>
                                                    افزودن گروه صفت
                                                </a>

                                                <!--begin::Modal-->
                                                <div class = "modal fade" id = "responsive-attributegroup" tabindex = "-1" role = "dialog" aria-labelledby = "responsive-attributegroupModalLabel" aria-hidden = "true">
                                                    <div class = "modal-dialog modal-lg" role = "document">
                                                        <div class = "modal-content">
                                                            <div class = "modal-header">
                                                                <h5 class = "modal-title" id = "responsive-attributesetModalLabel">افزودن گروه صفت جدید</h5>
                                                                <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                                                                    <span aria-hidden = "true">&times;</span>
                                                                </button>
                                                            </div>
                                                            {!! Form::open(['method' => 'POST','action' => ['Web\AttributegroupController@store'], 'class'=>'nobottommargin' , 'id'=>'attributegroupForm']) !!}
                                                            <div class = "modal-body">
                                                                <div class = "row">
                                                                    @include('attributegroup.form')
                                                                </div>
                                                            </div>
                                                            {!! Form::close() !!}
                                                            <div class = "modal-footer">
                                                                <button type = "button" class = "btn btn-secondary" data-dismiss = "modal" id = "attributegroupForm-close">بستن</button>
                                                                <button type = "button" class = "btn btn-primary" id = "attributegroupForm-submit">ذخیره</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Modal-->@endpermission
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class = "table table-striped table-bordered table-hover dt-responsive " width = "100%" id = "attributegroup_table">
                                    {{Form::hidden('attributeset',$attributeset->id, ['id' => 'attributeset'])}}
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th class = "all"> نام</th>
                                        <th class = "desktop"> توضیح</th>
                                        <th class = "none"> صفت ها:</th>
                                        <th class = "none"> زمان درج</th>
                                        <th class = "none"> زمان اصلاح</th>
                                        <th class = "all"> عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--Loading by ajax--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>
                </div>
            </div>
            @endpermission
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>
@endsection

@section('page-js')
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type = "text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>--}}
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/js/admin/makeDataTable.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/js/admin-edit-attributeset.js" type = "text/javascript"></script>
@endsection

@endpermission
