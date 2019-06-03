@ability(config('constants.ROLE_ADMIN'),config('constants.ADMIN_PANEL_ACCESS'))@extends("app",["pageName"=>$pageName])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css"/>
    {{--<link href="public/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>--}}


    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel="stylesheet" type="text/css"/>

    <style>
        .multiselect-native-select, .mt-multiselect {
            width: 100%;
        }
    </style>

@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
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
                                    <i class="la la-refresh"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon" id="user-expand">
                                    <i class="la la-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-expand"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <input type="hidden" id="contactUrl" value="/contact?user=">
                    <div class="portlet box red">
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
                                    {!! Form::open(['action' => 'Web\UserController@index' ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterUserForm']) !!}
                                    <input type="hidden" name="userAdmin" value="userAdmin">
                                    <div class="form-body m--padding-15" style="background: #e7ecf1">
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
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="la la-refresh"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-expand"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <img class="d-none" id="permission-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" style="width: 50px;">
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
                                            <!--end::Modal-->@endpermission
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
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="la la-refresh"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-expand"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet box blue-dark">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>
                                مدیریت نقش ها
                            </div>
                            <div class="tools">
                                <img class="d-none" id="role-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                                <a href="javascript:" class="collapse" id="role-expand"></a>
                                <a href="javascript:" class="reload"></a>
                                <a href="javascript:" class="remove"></a>
                            </div>
                            <div class="tools"></div>
                        </div>
                        <div class="portlet-body" style="display: block;">
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
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endrole


        </div>

    </div>

@endsection

@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>--}}

    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>

    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}

    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>


    <script type="text/javascript">

        function makeDataTable_loadWithAjax_users() {
            $("#user-portlet-loading").removeClass("d-none");
            $('#user_table > tbody').html("");
            let defaultContent="<span class=\"m-badge m-badge--wide label-sm m-badge--danger\"> درج نشده </span>";
            let columns = [
                {
                    "data": "row_child",
                    "defaultContent": ""
                },
                {"data": "lastName", "title": "نام خانوادگی", "defaultContent": defaultContent},
                {"data": "firstName", "title": "نام کوچک", "defaultContent": defaultContent},
                {"data": "info.major.name", "title": "رشته", "defaultContent": defaultContent},
                {"data": "nationalCode", "title": "کد ملی", "defaultContent": defaultContent},
                {"data": "mobile", "title": "موبایل", "defaultContent": defaultContent},
                {"data": "email", "title": "ایمیل", "defaultContent": defaultContent},
                {"data": "city", "title": "شهر", "defaultContent": defaultContent},
                {"data": "province", "title": "استان", "defaultContent": defaultContent},
                {
                    "data": null,
                    "name": "mobile_verify_status",
                    "title": "وضعیت شماره موبایل",
                    "render": function ( data, type, row ) {
                        if (row.mobile_verified_at === null) {
                            return '<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">تایید نشده</span>';
                        }
                        return '<span class="m-badge m-badge--success m-badge--wide m-badge--rounded">تایید شده</span>';
                    },
                },
                {"data": "postalCode", "title": "کد پستی", "defaultContent": defaultContent},
                {"data": "address", "title": "آدرس", "defaultContent": defaultContent},
                {"data": "school", "title": "مدرسه", "defaultContent": defaultContent},
                {"data": "userstatus.displayName", "title": "وضعیت", "defaultContent": defaultContent},
                {"data": "jalaliCreatedAt", "title": "زمان ثبت نام", "defaultContent": defaultContent},
                {"data": "jalaliUpdatedAt", "title": "زمان اصلاح", "defaultContent": defaultContent},
                {
                    "data": null,
                    "name": "roles",
                    "title": "نقش های کاربر",
                    defaultContent: '<span class="m-badge m-badge--metal m-badge--wide m-badge--rounded">ندارد</span>',
                    "render": function ( data, type, row ) {
                        if (row.roles  == null ||  row.roles.length === 0) {
                            return '<span class="m-badge m-badge--metal m-badge--wide m-badge--rounded">ندارد</span>';
                        }

                        let rolesHtml = '';
                        for (let index in row.roles) {
                            if(isNaN(index)) {
                                continue;
                            }
                            let role = row.roles[index];
                            rolesHtml += '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded">'+role.display_name+'</span>';
                        }
                        return rolesHtml;
                    },
                },
                {"data": "totalBonNumber", "title": "تعداد بن", "defaultContent": defaultContent},
                {
                    "data": null,
                    "name": "functions",
                    "title": "عملیات",
                    defaultContent: '',
                    "render": function (data, type, row) {
                        return '\n' +
                            '            <div class="btn-group">\n' +
                            '                <button class="btn btn-xs black dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> عملیات</button>\n' +
                            '                <ul class="dropdown-menu" role="menu" id="' + row.id + '">\n' +
                            '                    <li>\n' +
                            '                        <a target="_blank" href="'+row.editLink+'">\n' +
                            '                            <i class="flaticon-edit" aria-hidden="true"></i> ویرایش\n' +
                            '                        </a>\n' +
                            '                    </li>\n' +
                            '                    <li>\n' +
                            '                        <a class="deleteUser" data-target="#deleteUserConfirmationModal" data-toggle="modal" data-link="'+row.removeLink+'" data-fullname="'+row.firstName+' '+row.lastName+'">\n' +
                            '                            <i class="flaticon-delete" aria-hidden="true"></i> حذف\n' +
                            '                        </a>\n' +
                            '                    </li>\n' +
                            '                    <li>\n' +
                            '                        <a class="addBon" data-target="#addBonModal" data-toggle="modal">\n' +
                            '                            <i class="fa fa-plus" aria-hidden="true"></i> تخصیص بن\n' +
                            '                        </a>\n' +
                            '                    </li>\n' +
                            '                    <li>\n' +
                            '                        <a class="sendSms" data-target="#smsModal" data-toggle="modal">\n' +
                            '                            <i class="fa fa-envelope" aria-hidden="true"></i> ارسال پیامک\n' +
                            '                        </a>\n' +
                            '                    </li>\n' +
                            '                    <li>\n' +
                            '                        <a href="'+$('#contactUrl').val()+row.id+'" target="_blank">\n' +
                            '                            <i class="flaticon-book" aria-hidden="true"></i> دفترچه تلفن\n' +
                            '                        </a>\n' +
                            '                    </li>\n' +
                            '                </ul>\n' +
                            '                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>\n' +
                            '            </div>';
                    },
                    // function ( api, rowIdx, columns ) {
                    //     return 'hi';
                    //     // var data = $.map( columns, function ( col, i ) {
                    //     //     return col.hidden ?
                    //     //         '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                    //     //         '<td>'+col.title+':'+'</td> '+
                    //     //         '<td>'+col.data+'</td>'+
                    //     //         '</tr>' :
                    //     //         '';
                    //     // } ).join('');
                    //     //
                    //     // return data ?
                    //     //     $('<table/>').append( data ) :
                    //     //     false;
                    // }

                },
            ];
            let dataFilter = function (data) {
                var json = jQuery.parseJSON(data);
                console.log('dataFilter: ', json.data);
                json.recordsTotal = json.total;
                json.recordsFiltered = json.total;
                return JSON.stringify(json); // return JSON string
            };
            let ajaxData = function (data) {
                mApp.block('#user_table_wrapper', {
                    type: "loader",
                    state: "info",
                });
                data.orders = getNextPageParam(data.start, data.length);
                delete data.columns;
                let $form = $("#filterUserForm");
                let formData = getFormData($form);
                /* Merge data and formData, without modifying data */
                data = $.extend({}, data, formData);
                return data;
            };
            let dataSrc = function (json) {
                $("#user-portlet-loading").addClass("d-none");
                mApp.unblock('#user_table_wrapper');
                return json.data;
            };
            makeDataTable_loadWithAjax("user_table", $("#filterUserForm").attr("action"), columns, dataFilter, ajaxData, dataSrc);
        }
        
    </script>
    <script src="/acm/AlaatvCustomFiles/js/admin-index.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>


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
