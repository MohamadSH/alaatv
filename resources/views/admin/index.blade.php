@ability(Config::get('constants.ROLE_ADMIN'),Config::get('constants.ADMIN_PANEL_ACCESS'))
@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")
    {{--<link href="/assets/extra/persian-datepicker/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet"
          type="text/css"/>

    <link href="/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet"
          type="text/css"/>
@endsection

@section("metadata")
    @parent()
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
                <span>پنل مدیریت کاربران</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        {{--Ajax modal loaded after inserting content--}}
        <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
    {{--Ajax modal for panel startup --}}

    <!-- /.modal -->
        <div class="col-md-12">

            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--  @role((Config::get("constants.ROLE_ADMIN")))<p>ادمین محترم‌، مستحضر باشید که لیست سفارشات جدا شده است. همچنین تعداد بن افزوده و درصد تخفیف بن برای هر محصول به جدول محصولات افزوده شده است و در اصلاح محصول امکان ویرایش این دو وجود دارد.</p>@endrole--}}
            {{--<strong class="font-red">لطفا کش مرورگر خود را خالی کنید!</strong>--}}
            {{--</div>--}}

            @permission((Config::get('constants.LIST_USER_ACCESS')))
            <!-- BEGIN USER TABLE PORTLET-->
            <div class="portlet box red" id="user-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>مدیریت کاربران
                    </div>
                    <div class="tools">
                        <a href="javascript:" class="collapse" id="user-expand"> </a>
                        {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                        <a href="javascript:" class="reload"> </a>
                        <a href="javascript:" class="remove"> </a>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body" style="display: block;">
                    <div class="portlet box blue">
                        {{--<div class="portlet-title">--}}
                        {{--<div class="caption"><h3 class="bold">--}}
                        {{--<i class="fa fa-filter"></i>فیلتر جدول</h3>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form " style="border-top: #3598dc solid 1px">
                            {!! Form::open(['action' => 'UserController@index' ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterUserForm']) !!}
                            <div class="form-body" style="background: #e7ecf1">
                                @include("admin.filters.userFilterPack")
                                <div class="form-group">
                                    <div class="col-lg-3 col-md-3" id="columnFilter">
                                        @include("admin.filters.columnFilter" , ["id" => "userTableColumnFilter"])
                                    </div>
                                    @include('admin.filters.sort')
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12">
                                        <a href="javascript:" class="btn btn-lg bg-font-dark reload" id="filter"
                                           style="background: #489fff">فیلتر</a>
                                        <img class="hidden" id="user-portlet-loading"
                                             src="{{Config::get("constants.FILTER_LOADING_GIF")}}" alt="loading"
                                             width="5%">
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @permission((Config::get('constants.INSERT_USER_ACCESS')))
                                    <a class="btn btn-outline red" data-toggle="modal" href="#responsive-user">
                                        <i class="fa fa-plus"></i> افزودن کاربر </a>
                                    <!-- responsive modal -->
                                    <div id="responsive-user" class="modal fade" tabindex="-1" data-width="760">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            <h4 class="modal-title">افزودن کاربر جدید</h4>
                                        </div>
                                        {!! Form::open(['files'=>true,'method' => 'POST','action' => ['UserController@store'], 'class'=>'nobottommargin' , 'id'=>'userForm']) !!}
                                        <div class="modal-body">
                                            <div class="row">
                                                @include('user.form')
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark"
                                                    id="userForm-close">بستن
                                            </button>
                                            <button type="button" class="btn blue" id="userForm-submit">ذخیره</button>
                                        </div>
                                    </div>
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="user_table">
                        {{--sms panel modal--}}
                        @permission((Config::get('constants.SEND_SMS_TO_USER_ACCESS')))
                        <div id="smsModal" class="modal fade" tabindex="-1" data-backdrop="static"
                             data-keyboard="false">
                            <div class="modal-header">ارسال پیامک به <span id="smsUserFullName"></span></div>
                            <div class="modal-body">
                                {!! Form::open(['method' => 'POST', 'action' => 'HomeController@sendSMS' , 'class'=>'nobottommargin' , 'id'=>'sendSmsForm']) !!}
                                {!! Form::hidden('users', null, ['id' => 'users']) !!}
                                {!! Form::textarea('message', null, ['class' => 'form-control' , 'id' => 'smsMessage', 'placeholder' => 'متن پیامک']) !!}
                                <span class="help-block" id="smsMessageAlert">
                                                    <strong></strong>
                                                </span>
                                {!! Form::close() !!}
                                <span class="">
                                    طول پیام: (<span style="color: red;"><span id="smsNumber">1</span>
                                                    پیامک</span> ) <span id="smsWords">70</span>    کارکتر باقی مانده تا پیام بعدی
                                                </span>
                                <br>
                                <label>هزینه پیامک(ریال): <span
                                            id="totalSmsCost">{{Config::get('constants.COST_PER_SMS_2')}}</span></label>
                                <br>
                                <label>شماره فرستنده : {{config("constants.SMS_PROVIDER_DEFAULT_NUMBER")}}</label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-outline dark"
                                        id="sendSmsForm-close">بستن
                                </button>
                                <button type="button" class="btn green" id="sendSmsForm-submit">ارسال</button>
                                <img class="hidden" id="send-sms-loading"
                                     src="{{Config::get('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px"
                                     width="25px">
                            </div>
                        </div>
                        @endpermission
                        {{--delete user confirmation modal--}}
                        @permission((Config::get('constants.REMOVE_USER_ACCESS')))
                        <div id="deleteUserConfirmationModal" class="modal fade" tabindex="-1" data-backdrop="static"
                             data-keyboard="false">
                            <div class="modal-header">حذف کاربر <span id="deleteUserFullName"></span></div>
                            <div class="modal-body">
                                <p> آیا مطمئن هستید؟ </p>
                                {!! Form::hidden('user_id', null) !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>
                                <button type="button" data-dismiss="modal" class="btn green" onclick="removeUser()">
                                    بله
                                </button>
                            </div>
                        </div>
                        @endpermission
                        @permission((Config::get('constants.INSERT_USER_BON_ACCESS')))
                        <div id="addBonModal" class="modal fade" tabindex="-1">
                            <div class="modal-header">تخصیص بن به کابر <span id="bonUserFullName"></span></div>
                            <div class="modal-body">
                                {!! Form::open(['method' => 'POST', 'action' => 'UserbonController@store' , 'class'=>'nobottommargin' , 'id'=>'userAttachBonForm']) !!}
                                {!! Form::text('totalNumber', null,['class' => 'form-control' , 'id' => 'userBonNumber', 'placeholder' => 'تعداد بن']) !!}
                                <span class="help-block" id="userBonNumberAlert">
                                                    <strong></strong>
                                                </span>
                                {!! Form::hidden('user_id', null) !!}
                                {!! Form::hidden('bon_id', 1) !!}
                                {!! Form::hidden('userbonstatus_id', Config::get("constants.USERBON_STATUS_ACTIVE")) !!}
                                {!! Form::close() !!}
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-outline dark"
                                        id="userAttachBonForm-close">بستن
                                </button>
                                <button type="button" class="btn green" id="userAttachBonForm-submit">ثبت</button>
                            </div>
                        </div>
                        @endpermission
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام خانوادگی</th>
                            <th class="all"> نام کوچک</th>
                            <th class="none"> رشته</th>
                            {{--<th class="desktop"> عکس </th>--}}
                            <th class="none"> کد ملی</th>
                            @permission((Config::get('constants.SHOW_USER_MOBILE')))
                            <th class="desktop"> موبایل</th>
                            @endpermission
                            {{--<th class="all">همایش فیزیک</th>--}}
                            {{--<th class="all">همایش دیفرانسیل</th>--}}
                            {{--<th class="all">همایش ریاضی تجربی</th>--}}
                            {{--<th class="all">همایش زیست</th>--}}
                            @permission((Config::get('constants.SHOW_USER_EMAIL')))
                            <th class="none"> ایمیل</th>
                            @endpermission
                            <th class="desktop"> شهر</th>
                            <th class="desktop"> استان</th>
                            <th class="none">وضعیت شماره موبایل</th>
                            <th class="all"> کد پستی</th>
                            <th class="all"> آدرس</th>
                            {{--<th class="none"> رشته </th>--}}
                            <th class="none"> مدرسه</th>
                            <th class="none"> وضعیت</th>
                            <th class="none"> زمان ثبت نام</th>
                            <th class="all"> زمان اصلاح</th>
                            <th class="none"> نقش های کاربر</th>
                            <th class="none"> تعداد بن</th>
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

            @permission((Config::get('constants.LIST_PERMISSION_ACCESS')))
            <!-- BEGIN PERMISSION TABLE PORTLET-->
            <div class="portlet box blue-hoki" id="permission-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>مدیریت دسترسی ها
                    </div>
                    <div class="tools">
                        <img class="hidden" id="permission-portlet-loading"
                             src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
                        <a href="javascript:" class="collapse" id="permission-expand"> </a>
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
                                    @permission((Config::get('constants.INSERT_PERMISSION_ACCESS')))
                                    <a class="btn btn-outline blue-hoki" data-toggle="modal"
                                       href="#responsive-permission">
                                        <i class="fa fa-plus"></i> افزودن دسترسی </a>
                                    <!-- responsive modal -->
                                    <div id="responsive-permission" class="modal fade" tabindex="-1" data-width="760">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            <h4 class="modal-title">افزودن دسترسی جدید</h4>
                                        </div>
                                        {!! Form::open(['method' => 'POST','action' => ['PermissionController@store'], 'class'=>'nobottommargin' , 'id'=>'permissionForm']) !!}
                                        <div class="modal-body">
                                            <div class="row">
                                                @include('permission.form')
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark"
                                                    id="permissionForm-close">بستن
                                            </button>
                                            <button type="button" class="btn blue-hoki" id="permissionForm-submit">
                                                ذخیره
                                            </button>
                                        </div>
                                    </div>
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="permission_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="none"> نام (اصلی)</th>
                            <th class="all"> نام دسترسی</th>
                            <th class="none"> توضیح</th>
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

            @role((Config::get("constants.ROLE_ADMIN")))
            <!-- BEGIN ROLE TABLE PORTLET-->
            <div class="portlet box blue-dark" id="role-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>مدیریت نقش ها
                    </div>
                    <div class="tools">
                        <img class="hidden" id="role-portlet-loading"
                             src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading"
                             style="width: 50px;">
                        <a href="javascript:" class="collapse" id="role-expand"> </a>
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
                                    @role((Config::get("constants.ROLE_ADMIN")))
                                    <a class="btn btn-outline blue-dark" data-toggle="modal" href="#responsive-role">
                                        <i class="fa fa-plus"></i> افزودن نقش </a>
                                    <!-- responsive modal -->
                                    <div id="responsive-role" class="modal fade" tabindex="-1" data-width="760">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true"></button>
                                            <h4 class="modal-title">افزودن نقش جدید</h4>
                                        </div>
                                        {!! Form::open(['method' => 'POST','action' => 'RoleController@store', 'class'=>'nobottommargin' , 'id'=>'roleForm']) !!}
                                        <div class="modal-body">
                                            <div class="row">
                                                @include('role.form')
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-outline dark"
                                                    id="roleForm-close">بستن
                                            </button>
                                            <button type="button" class="btn blue-dark" id="roleForm-submit">ذخیره
                                            </button>
                                        </div>
                                    </div>
                                    @endrole
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="role_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام (اصلی)</th>
                            <th class="all"> نام نقش</th>
                            <th class="none"> توضیح</th>
                            <th class="none">تاریخ درج</th>
                            <th class="none">تاریخ اصلاح</th>
                            <th class="none"> دسترسی های این نقش</th>
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
            @endrole
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    {{--<script src="/assets/extra/persian-datepicker/lib/bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>--}}
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>

    {{--<script src="../assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>--}}
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js"
            type="text/javascript"></script>

    <script src="/assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/admin-index.js" type="text/javascript"></script>
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/js/extraJS/scripts/admin-makeMultiSelect.js" type="text/javascript"></script>

    <script type="text/javascript">
        //should run at first
        $("#user_table thead tr th").each(function () {
            if (!$(this).hasClass("none")) {
                thText = $(this).text().trim();
                $("#userTableColumnFilter > option").each(function () {
                    if ($(this).val() === thText) {
                        $(this).prop("selected", true);
                    }
                });
            }
        });

        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
        @permission((Config::get('constants.LIST_USER_ACCESS')));
            var newDataTable = $("#user_table").DataTable();
            newDataTable.destroy();
            makeDataTable("user_table");
            $("#user-expand").trigger("click");
            $("#user_table > tbody .dataTables_empty").text("برای نمایش اطلاعات ابتدا فیلتر کنید").addClass("font-red bold");
            $('#user_role').multiSelect();
            @endpermission;
            @permission((Config::get('constants.LIST_PERMISSION_ACCESS')));
            $("#permission-portlet .reload").trigger("click");
            $("#permission-expand").trigger("click");
            @endpermission;
            @role((Config::get("constants.ROLE_ADMIN")));
            $("#role-portlet .reload").trigger("click");
            $("#role-expand").trigger("click");
            @endrole
        });
    </script>
@endsection
@endability