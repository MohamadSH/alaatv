@ability(config('constants.ROLE_ADMIN'),config('constants.ADMIN_PANEL_ACCESS'))@extends("app",["pageName"=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .multiselect-native-select, .mt-multiselect {
            width: 100%;
        }
        .form .form-row-seperated .form-group {
            border-bottom-color: #bfbfbf !important;
        }
    </style>

@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل مدیریت کاربران</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class="row">
        {{--Ajax modal loaded after inserting content--}}
        <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
    {{--Ajax modal for panel startup --}}

    <!-- /.modal -->

        <div class="col-md-12">


            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--  @role((config("constants.ROLE_ADMIN")))<p>ادمین محترم‌، مستحضر باشید که لیست سفارشات جدا شده است. همچنین تعداد بن افزوده و درصد تخفیف بن برای هر محصول به جدول محصولات افزوده شده است و در اصلاح محصول امکان ویرایش این دو وجود دارد.</p>@endrole--}}
            {{--<strong class="m--font-danger">لطفا کش مرورگر خود را خالی کنید!</strong>--}}
            {{--</div>--}}


            @permission((config('constants.LIST_USER_ACCESS')))
            <!-- BEGIN USER TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="user-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="flaticon-users"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                پنل مدیریت کاربران
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" id="user-expand">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
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
                    <input type="hidden" id="contactUrl" value="/contact?user=">

                    <div class="m-portlet m-portlet--skin-dark m-portlet--bordered-semi m--bg-brand">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        فیلتر
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            {!! Form::open(['action' => 'Web\UserController@index' ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterUserForm']) !!}
                            <input type="hidden" name="userAdmin" value="userAdmin">
                            <div class="form-body m--padding-15" style="/*background: #e7ecf1*/">
                                @include("admin.filters.userFilterPack")
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3" id="columnFilter">
                                            @include("admin.filters.columnFilter" , ["id" => "userTableColumnFilter"])
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            @include('admin.filters.sort')
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <a href="javascript:" class="btn btn-lg bg-font-dark reload" id="filter" style="background: #489fff">فیلتر</a>
                                            <img class="d-none" id="user-portlet-loading" src="{{config("constants.FILTER_LOADING_GIF")}}" alt="loading" width="5%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @permission((config('constants.INSERT_USER_ACCESS')))
                                    <a class="btn m-btn--air btn-info" data-toggle="modal" href="#responsive-user">
                                        <i class="fa fa-plus"></i>
                                        افزودن کاربر
                                    </a>
                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-userLabel">افزودن کاربر جدید</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                {!! Form::open(['files'=>true,'method' => 'POST','action' => ['Web\UserController@store'], 'class'=>'nobottommargin' , 'id'=>'userForm']) !!}
                                                <div class="modal-body">
                                                    <div class="row">
                                                        @include('user.form')
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                    <button type="button" class="btn btn-primary" id="userForm-submit">ذخیره</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->@endpermission
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="user_table">
                        {{--sms panel modal--}}
                        @permission((config('constants.SEND_SMS_TO_USER_ACCESS')))

                        <!--begin::Modal-->
                        <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="smsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="smsModalLabel">ارسال پیامک به
                                            <span id="smsUserFullName"></span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['method' => 'POST', 'action' => 'Web\HomeController@sendSMS' , 'class'=>'nobottommargin' , 'id'=>'sendSmsForm']) !!}
                                        {!! Form::hidden('users', null, ['id' => 'users']) !!}
                                        {!! Form::textarea('message', null, ['class' => 'form-control' , 'id' => 'smsMessage', 'placeholder' => 'متن پیامک']) !!}
                                        <span class="form-control-feedback" id="smsMessageAlert">
                                                        <strong></strong>
                                                </span>
                                        {!! Form::close() !!}
                                        <span class="">
                                            طول پیام: (
                                            <span style="color: red;">
                                                <span id="smsNumber">1</span>
                                                    پیامک
                                            </span>
                                            )
                                            <span id="smsWords">70</span>
                                            کارکتر باقی مانده تا پیام بعدی
                                        </span>
                                        <br>
                                        <label>هزینه پیامک(ریال):
                                            <span id="totalSmsCost">{{config('constants.COST_PER_SMS_2')}}</span>
                                        </label>
                                        <br>
                                        <label>شماره فرستنده : {{config("constants.SMS_PROVIDER_DEFAULT_NUMBER")}}</label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="sendSmsForm-close">بستن</button>
                                        <button type="button" class="btn btn-primary" id="sendSmsForm-submit">ارسال</button>
                                        <img class="d-none" id="send-sms-loading" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->@endpermission
                        {{--delete user confirmation modal--}}
                        @permission((config('constants.REMOVE_USER_ACCESS')))

                        <!--begin::Modal-->
                        <div class="modal fade" id="deleteUserConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteUserConfirmationModalLabel">حذف کاربر
                                            <span id="deleteUserFullName"></span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p> آیا مطمئن هستید؟</p>
                                        {!! Form::hidden('user_remove_link', null) !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                        <button type="button" class="btn btn-primary" onclick="removeUser()">بله</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->
                        @endpermission @permission((config('constants.INSERT_USER_BON_ACCESS')))
                        <!--begin::Modal-->
                        <div class="modal fade" id="addBonModal" tabindex="-1" role="dialog" aria-labelledby="addBonModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addBonModalLabel">تخصیص بن به کابر
                                            <span id="bonUserFullName"></span>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['method' => 'POST', 'action' => 'Web\UserbonController@store' , 'class'=>'nobottommargin' , 'id'=>'userAttachBonForm']) !!}
                                        {!! Form::text('totalNumber', null,['class' => 'form-control' , 'id' => 'userBonNumber', 'placeholder' => 'تعداد بن']) !!}
                                        <span class="form-control-feedback" id="userBonNumberAlert">
                                                        <strong></strong>
                                                    </span>
                                        {!! Form::hidden('user_id', null) !!}
                                        {!! Form::hidden('bon_id', 1) !!}
                                        {!! Form::hidden('userbonstatus_id', config("constants.USERBON_STATUS_ACTIVE")) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="userAttachBonForm-close">بستن</button>
                                        <button type="button" class="btn btn-primary" id="userAttachBonForm-submit">ثبت</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->
                        @endpermission
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all">نام خانوادگی</th>
                            <th class="all">نام کوچک</th>
                            <th class="none">رشته</th>
                            {{--<th class="desktop"> عکس </th>--}}
                            <th class="none">کد ملی</th>
                            @permission((config('constants.SHOW_USER_MOBILE')))
                            <th class="desktop">موبایل</th>
                            @endpermission
                            {{--<th class="all">همایش فیزیک</th>--}}
                            {{--<th class="all">همایش دیفرانسیل</th>--}}
                            {{--<th class="all">همایش ریاضی تجربی</th>--}}
                            {{--<th class="all">همایش زیست</th>--}}
                            @permission((config('constants.SHOW_USER_EMAIL')))
                            <th class="none">ایمیل</th>
                            @endpermission
                            <th class="desktop">شهر</th>
                            <th class="desktop">استان</th>
                            <th class="none">وضعیت شماره موبایل</th>
                            <th class="all">کد پستی</th>
                            <th class="all">آدرس</th>
                            {{--<th class="none"> رشته </th>--}}
                            <th class="none">مدرسه</th>
                            <th class="none">وضعیت</th>
                            <th class="none">زمان ثبت نام</th>
                            <th class="all">زمان اصلاح</th>
                            <th class="none">نقش های کاربر</th>
                            <th class="none">تعداد بن</th>
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


            @permission((config('constants.LIST_PERMISSION_ACCESS')))
            <!-- BEGIN PERMISSION TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--info m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="permission-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="flaticon-users"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت دسترسی ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <img class="d-none" id="permission-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
                            </li>
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
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
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
                    <div class="portlet box blue-hoki">
                        <div class="portlet-body" style="display: block;">
                            <div class="table-toolbar">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            @permission((config('constants.INSERT_PERMISSION_ACCESS')))
                                            <a class="btn m-btn--air btn-info" data-toggle="modal" href="#responsive-permission" data-target="#responsive-permission">
                                                <i class="fa fa-plus"></i>
                                                افزودن دسترسی
                                            </a>

                                            <!--begin::Modal-->
                                            <div class="modal fade" id="responsive-permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="responsive-permissionLabel">افزودن دسترسی جدید</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        {!! Form::open(['method' => 'POST','action' => ['Web\PermissionController@store'], 'class'=>'nobottommargin' , 'id'=>'permissionForm']) !!}
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                @include('permission.form')
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                            <button type="button" class="btn btn-primary" id="permissionForm-submit">ذخیره</button>
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
                            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="permission_table">
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
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission


            @role((config("constants.ROLE_ADMIN")))
            <!-- BEGIN ROLE TABLE PORTLET-->
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--primary m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="role-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="flaticon-users"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت نقش ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <img class="d-none" id="role-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                            </li>
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
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
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

                                @role((config("constants.ROLE_ADMIN")))
                                <a class="btn m-btn--air btn-info" data-toggle="modal" href="#responsive-role" data-target="#responsive-role">
                                    <i class="fa fa-plus"></i>
                                    افزودن نقش
                                </a>
                                <!--begin::Modal-->
                                <div class="modal fade" id="responsive-role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="responsive-roleLabel">افزودن نقش جدید</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            {!! Form::open(['method' => 'POST','action' => 'Web\RoleController@store', 'class'=>'nobottommargin' , 'id'=>'roleForm']) !!}
                                            <div class="modal-body">
                                                <div class="row">
                                                    @include('role.form')
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                                <button type="button" class="btn btn-primary" id="roleForm-submit">ذخیره</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->@endrole

                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="role_table">
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

@section('page-js')


    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/acm/AlaatvCustomFiles/js/admin/page-usersAdmin.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
        @permission((config('constants.LIST_USER_ACCESS')));
            var newDataTable = $("#user_table").DataTable();
            newDataTable.destroy();
            makeDataTable_loadWithAjax_users();
            $("#user-expand").trigger("click");
            $("#user_table > tbody .dataTables_empty").text("برای نمایش اطلاعات ابتدا فیلتر کنید").addClass("m--font-danger bold");
            $('#user_role').multiSelect();
        @endpermission;
        @permission((config('constants.LIST_PERMISSION_ACCESS')));
            $("#permission-portlet .reload").trigger("click");
            $("#permission-expand").trigger("click");
        @endpermission;
        @role((config("constants.ROLE_ADMIN")));
            $("#role-portlet .reload").trigger("click");
            $("#role-expand").trigger("click");
        @endrole
        });
    </script>
@endsection
@endability
