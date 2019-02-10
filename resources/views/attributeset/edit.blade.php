@permission((Config::get('constants.SHOW_ATTRIBUTESET_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
@endsection

@section("metadata")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection


@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href = "{{action("Web\HomeController@adminProduct")}}">پنل مدیریتی محصولات</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح اطلاعات دسته صفت</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6 ">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح اطلاعات دسته صفت {{$attributeset->name}} </span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class = "btn btn-sm dark dropdown-toggle" href = "{{action("Web\HomeController@adminProduct")}}">
                                بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($attributeset,['method' => 'PUT','action' => ['AttributesetController@update',$attributeset], 'class'=>'form-horizontal']) !!}
                    @include('attributeset.form')
                    {!! Form::close() !!}
                </div>
            </div>
            @permission((Config::get('constants.LIST_ATTRIBUTEGROUP_ACCESS')))
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح اطلاعات گروه صفت {{$attributeset->name}} </span>
                    </div>
                </div>
                {{--Ajax modal loaded after inserting content--}}
                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>

                <div class="portlet-body form">
                    <div class="form-horizontal">
                        <!-- BEGIN ASSIGNMENT TABLE PORTLET-->
                        <div class="portlet box yellow-haze" id="attributegroup-portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-cogs"></i>گروه صفت ها
                                </div>
                                <div class="tools">
                                    <a href="javascript:" class="collapse" id="attributegroup-expand"> </a>
                                    <a href="javascript:" class="reload"> </a>
                                    <a href="javascript:" class="remove"> </a>
                                </div>
                                <div class="tools"></div>
                            </div>
                            <div class="portlet-body" style="display: block;">

                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="btn-group">
                                                @permission((Config::get('constants.INSERT_ATTRIBUTEGROUP_ACCESS')))
                                                <a id="sample_editable_1_new" class="btn btn-outline yellow-haze"
                                                   data-toggle="modal" href="#responsive-attributegroup"><i
                                                            class="fa fa-plus"></i> افزودن گروه صفت </a>
                                                <!-- responsive modal -->
                                                <div id="responsive-attributegroup" class="modal fade" tabindex="-1"
                                                     data-width="760">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        <h4 class="modal-title">افزودن گروه صفت جدید</h4>
                                                    </div>
                                                    {!! Form::open(['method' => 'POST','action' => ['AttributegroupController@store'], 'class'=>'nobottommargin' , 'id'=>'attributegroupForm']) !!}
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            @include('attributegroup.form')
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                                    <div class="modal-footer">
                                                        <button type="button" data-dismiss="modal"
                                                                class="btn btn-outline dark"
                                                                id="attributegroupForm-close">بستن
                                                        </button>
                                                        <button type="button" class="btn yellow-haze"
                                                                id="attributegroupForm-submit">ذخیره
                                                        </button>
                                                    </div>
                                                </div>
                                                @endpermission
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover dt-responsive "
                                       width="100%" id="attributegroup_table">
                                    {{Form::hidden('attributeset',$attributeset->id, ['id' => 'attributeset'])}}
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th class="all"> نام</th>
                                        <th class="desktop"> توضیح</th>
                                        <th class="none"> صفت ها:</th>
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
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-multi-select.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/js/extraJS/edit-attributeset.js" type="text/javascript"></script>
@endsection


@endpermission