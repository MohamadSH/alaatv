@permission((config('constants.SMS_ADMIN_PANEL_ACCESS')))
@extends('app',['pageName'=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        h2.m-portlet__head-label.m-portlet__head-label--success {
            white-space: nowrap;
            line-height: 50px;
        }
    </style>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پنل ارسال پیامک</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        
        {{--<!-- /.modal -->--}}
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                <i class="fa fa-database"></i>
                @if($smsCredit === false)
                    خطا در دریافت اطالاعات
                @else
                    اعتبار فعلی شما
                        <span id="smsCredit">{{number_format($smsCredit)}}</span>
                    ریال برابر با
                        <span id="smsCreditNumber_2">{{number_format(ceil($smsCredit/config('constants.COST_PER_SMS_2')))}}</span>
                    پیامک اپراتور (1000) برابر با
                        <span id="smsCreditNumber_1">{{number_format(ceil($smsCredit/config('constants.COST_PER_SMS_1')))}}</span>
                    پیام کاپراتور(5000) برابر با
                        <span id="smsCreditNumber_3">{{number_format(ceil($smsCredit/config('constants.COST_PER_SMS_3')))}}</span>
                    پیامک اپراتور (sim)
                @endif
            </div>

        </div>
        <div class="col-md-12">
            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--@role(('admin'))<p>ادمین محترم‌، لیست بنهای تخصیص داده شده به کاربران به این صفحه اضافه شده است! همچنین افزودن بنهای محصول بعد از تایید سفارش نیز در اصلاح سفارشهای تایید نشده اضافه شده است.</p>@endrole--}}
            {{--<strong class="m--font-danger">لطفا کش مرورگر خود را خالی کنید</strong>--}}
            {{--</div>--}}
            @permission((config('constants.SEND_SMS_TO_USER_ACCESS')))
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <i class="fa fa-envelope bg-font-dark m--margin-right-5"></i>
                                پنل ارسال پیامک
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['method' => 'POST', 'action' => 'Web\HomeController@sendSMS' , 'class'=>'' , 'id'=>'sendSmsForm']) !!}
                            {!! Form::textarea('message', null, ['class' => 'form-control' , 'id' => 'smsMessage', 'placeholder' => 'متن پیامک' , 'rows' => 3]) !!}
                            <span class="form-control-feedback" id="smsMessageAlert">
                                    <strong></strong>
                                </span>
                            <br>
                            <div class="m-alert m-alert--outline alert alert-accent alert-dismissible fade show" role="alert">
                                طول پیام: (
                                <span style="color: red;">
                                    <span id="smsNumber">1</span>
                                    پیامک
                                </span>
                                )
                                <span id="smsWords">70</span>
                                کارکتر باقی مانده تا پیام بعدی
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row form-group">
                                <div class="col-md-2">
                                    <select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-width="100%" data-filter="true" data-height="200" id="relatives" name="relatives[]" title="ارسال به">
                                        @foreach($relatives as $key => $value)
                                            <option value="{{$key}}" @if($key == 0) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    {{--<label class="col-md-3">ارسال به</label>--}}
                                    {{--<div class="col-md-6" style="text-align: justify">--}}
                                    {{--{!! Form::select('relatives[]' , $relatives, [0], ['class' => 'form-control col-md-6', 'id' => 'relatives' , 'multiple']) !!}--}}
                                    {{--<span class="bold m--font-danger" style="font-size: small ; ">توجه پیامک به تمامی شماره موبایلهای ثبت شده برای پدر یا مادر ارسال خواهد شد</span>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="col-md-2">
                                    {{--<label class="control-label bold">انتخاب شماره</label>--}}
                                    {!! Form::select('smsProviderNumber' , $smsProviderNumber["phone"], null, ['class' => 'btn', 'id' => 'smsProviderNumber']) !!}
                                    {!! Form::select('smsProviderCost' , $smsProviderNumber["cost"], null, ['class' => 'btn d-none', 'id' => 'smsProviderCost']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::select('smsStatus' , ['selected' => 'به انتخاب شده ها', 'all' => 'به همه'], null, ['class' => 'btn', 'id' => 'smsStatus']) !!}
                                </div>
                                <div class="col-md-5 text-center">
                                    <a type="button" class="btn btn-outline-info m-btn--air m-btn--pill" data-target="#smsConformation" data-toggle="modal" id="sendSmsButton">
                                        ارسال
                                    </a>
                                </div>
                                {!! Form::hidden('allUsers', "[0]" , ['id' => 'allUsers']) !!}
                                {!! Form::hidden('allUsersNumber', "0" , ['id' => 'allUsersNumber']) !!}
                                {!! Form::hidden('numberOfFatherPhones', "0" , ['id' => 'numberOfFatherPhones']) !!}
                                {!! Form::hidden('numberOfMotherPhones', "0" , ['id' => 'numberOfMotherPhones']) !!}
                                <div class="col-md-12">
                                    <span class="form-control-feedback bold m--font-danger">توجه پیامک به تمامی شماره موبایلهای ثبت شده برای پدر یا مادر ارسال خواهد شد</span>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!--begin::Modal-->
                    <div class="modal fade" id="smsConformation" tabindex="-1" role="dialog" aria-labelledby="addBonModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addBonModalLabel">
                                        محاسبه هزینه پیام
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <br>
                                    <label>تعداد پیام:
                                        <span id="showSmsNumber">1</span>
                                    </label>
                                    <br>
                                    <label>هزینه هر پیام فارسی:
                                        <span id="perSmsCost">0</span>
                                    </label>
                                    {!! Form::hidden("smsCost_1" , config('constants.COST_PER_SMS_1') , ["id" => "smsCost_1"]) !!}
                                    {!! Form::hidden("smsCost_2" , config('constants.COST_PER_SMS_2') , ["id" => "smsCost_2"]) !!}
                                    {!! Form::hidden("smsCost_3" , config('constants.COST_PER_SMS_3') , ["id" => "smsCost_3"]) !!}
                                    <br>
                                    <label>تعداد گیرندگان:
                                        <span id="userGetSms">0</span>
                                    </label>
                                    <br>
                                    <label>هزینه کل:
                                        <span id="totalSmsCost">0</span>
                                    </label>
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="sendSmsForm-close">خیر</button>
                                    <button type="button" class="btn btn-primary" id="sendSmsForm-submit">ارسال</button>
                                    <img class="d-none" id="send-sms-loading" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                    
                    <div class="clear-fix" style="height: 50px"></div>
                    <div class="portlet box blue">
                        {{--<div class="portlet-title">--}}
                        {{--<div class="caption"><h3 class="bold">--}}
                        {{--<i class="fa fa-filter"></i>فیلتر جدول</h3></div>--}}
                        {{--</div>--}}
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                            {!! Form::open(['action' => 'Web\UserController@index' , 'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterUserForm']) !!}
                            <div class="form-body" style="background: #e7ecf1">
                                @include("admin.filters.userFilterPack")
    
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-2 col-md-2 bold control-label">تاریخ ایجاد سبد خرید :</label>
                                        <div class="col-lg-10 col-md-10">
                                            <div class = "row">
                                                <label class = "control-label" style = "float: right;">
                                                    <label class = "mt-checkbox mt-checkbox-outline">
                                                        <input type = "checkbox" id = "CreatedBasketEnable" value = "1" name = "createdTimeEnable">
                                                        <span class = "bg-grey-cararra"></span>
                                                    </label>
                                                </label>
                                                <label class = "control-label" style = " float: right;">از تاریخ</label>
                                                <div class = "col-md-3 col-xs-12">
                                                    <input id = "CreatedBasketSince" type = "text" class = "form-control" disabled = "disabled">
                                                    <input name = "CreatedBasketSince" id = "CreatedBasketSinceAlt" type = "text" class = "form-control d-none">
                                                </div>
                                                <label class = "control-label" style = "float: right;">تا تاریخ</label>
                                                <div class = "col-md-3 col-xs-12">
                                                    <input id = "CreatedBasketTill" type = "text" class = "form-control" disabled = "disabled">
                                                    <input name = "CreatedBasketTill" id = "CreatedBasketTillAlt" type = "text" class = "form-control d-none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="ccl-mg-12 col-md-12">
                                        <button type="button" id="filterButton" class="btn btn-lg bg-font-dark" style="background: #489fff">فیلتر
                                        </button>
                                        <img class="d-none" id="sms-portlet-loading" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" width="5%">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sms_table">
                        <thead>
                        <tr>
                            <th class="table-checkbox">
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="group-checkable" data-set="#sms_table"/>
                                    <span></span>
                                </label>
                            </th>
                            <th> نام</th>
                            <th> رشته</th>
                            <th> موبایل</th>
                            <th>وضعیت شماره موبایل</th>
                            <th>کد ملی</th>
                            <th> شهر</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->@endpermission
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/AlaatvCustomFiles/js/admin/makeDataTable.js" type="text/javascript"></script>--}}
{{--    --}}
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>--}}
{{--    <script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>--}}
    
    <script src="/acm/AlaatvCustomFiles/js/admin-indexSMS.js" type="text/javascript"></script>
    
    
@endsection

@endpermission