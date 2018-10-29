@permission((Config::get('constants.SMS_ADMIN_PANEL_ACCESS')))
@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
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
                <span>پنل ارسال پیامک</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        {{--Ajax modal loaded after inserting content--}}
        <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
        {{--Ajax modal for panel startup --}}
        {{--<!-- /.modal -->--}}
        <div class="col-md-12">
            <p class="list-group-item bold bg-font-dark" style="text-align: justify; background: #489fff"><i
                        class="fa fa-database"></i>
                @if($smsCredit === false) خطا در دریافت اطالاعات @else   اعتبار فعلی شما <span
                        id="smsCredit">{{number_format($smsCredit)}}</span> ریال برابر با <span
                        id="smsCreditNumber_2">{{number_format(ceil($smsCredit/Config::get('constants.COST_PER_SMS_2')))}}</span>
                پیامک اپراتور (1000) برابر با <span
                        id="smsCreditNumber_1">{{number_format(ceil($smsCredit/Config::get('constants.COST_PER_SMS_1')))}}</span>
                پیام کاپراتور(5000) برابر با <span
                        id="smsCreditNumber_3">{{number_format(ceil($smsCredit/Config::get('constants.COST_PER_SMS_3')))}}</span>
                پیامک اپراتور (sim) @endif
            </p>
        </div>
        <div class="col-md-12">
            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--@role(('admin'))<p>ادمین محترم‌، لیست بنهای تخصیص داده شده به کاربران به این صفحه اضافه شده است! همچنین افزودن بنهای محصول بعد از تایید سفارش نیز در اصلاح سفارشهای تایید نشده اضافه شده است.</p>@endrole--}}
            {{--<strong class="font-red">لطفا کش مرورگر خود را خالی کنید</strong>--}}
            {{--</div>--}}
            @permission((Config::get('constants.SEND_SMS_TO_USER_ACCESS')))
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div class="portlet box " style="background: #708aa3;">
                <div class="portlet-title">
                    <div class="caption ">
                        <i class="fa fa-envelope bg-font-dark"></i>پنل ارسال پیامک
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['method' => 'POST', 'action' => 'HomeController@sendSMS' , 'class'=>'' , 'id'=>'sendSmsForm']) !!}
                            {!! Form::textarea('message', null, ['class' => 'form-control' , 'id' => 'smsMessage', 'placeholder' => 'متن پیامک' , 'rows' => 3]) !!}
                            <span class="help-block" id="smsMessageAlert">
                                        <strong></strong>
                                    </span>
                            <span class="help-block">
                                        طول پیام: (<span style="color: red;"><span id="smsNumber">1</span> پیامک</span> ) <span
                                        id="smsWords">70</span>    کارکتر باقی مانده تا پیام بعدی
                                    </span>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left"
                                            data-width="100%" data-filter="true" data-height="200"
                                            id="relatives" name="relatives[]" title="ارسال به">
                                        @foreach($relatives as $key => $value)
                                            <option value="{{$key}}" @if($key == 0) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    {{--<label class="col-md-3">ارسال به</label>--}}
                                    {{--<div class="col-md-6" style="text-align: justify">--}}
                                    {{--{!! Form::select('relatives[]' , $relatives, [0], ['class' => 'form-control col-md-6', 'id' => 'relatives' , 'multiple']) !!}--}}
                                    {{--<span class="bold font-red" style="font-size: small ; ">توجه پیامک به تمامی شماره موبایلهای ثبت شده برای پدر یا مادر ارسال خواهد شد</span>--}}
                                    {{--</div>--}}

                                </div>
                                <div class="col-md-2">
                                    {{--<label class="control-label bold">انتخاب شماره</label>--}}
                                    {!! Form::select('smsProviderNumber' , $smsProviderNumber["phone"], null, ['class' => 'btn', 'id' => 'smsProviderNumber']) !!}
                                    {!! Form::select('smsProviderCost' , $smsProviderNumber["cost"], null, ['class' => 'btn hidden', 'id' => 'smsProviderCost']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::select('smsStatus' , ['selected' => 'به انتخاب شده ها', 'all' => 'به همه'], null, ['class' => 'btn', 'id' => 'smsStatus']) !!}
                                </div>
                                <a type="button" class="btn green-soft" data-target="#smsConformation"
                                   data-toggle="modal" id="sendSmsButton">ارسال</a>
                                {!! Form::hidden('allUsers', "[0]" , ['id' => 'allUsers']) !!}
                                {!! Form::hidden('allUsersNumber', "0" , ['id' => 'allUsersNumber']) !!}
                                {!! Form::hidden('numberOfFatherPhones', "0" , ['id' => 'numberOfFatherPhones']) !!}
                                {!! Form::hidden('numberOfMotherPhones', "0" , ['id' => 'numberOfMotherPhones']) !!}
                                <div class="col-md-12">
                                    <span class="help-block bold font-red">توجه پیامک به تمامی شماره موبایلهای ثبت شده برای پدر یا مادر ارسال خواهد شد</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--conformation modal--}}
                    <div id="smsConformation" class="modal fade" tabindex="-1" data-backdrop="static"
                         data-keyboard="false">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">محاسبه هزینه پیام</h4>
                        </div>
                        <div class="modal-body">
                            <br>
                            <label>تعداد پیام: <span id="showSmsNumber">1</span> </label>
                            <br>
                            <label>هزینه هر پیام فارسی: <span id="perSmsCost">0</span></label>
                            {!! Form::hidden("smsCost_1" , Config::get('constants.COST_PER_SMS_1') , ["id" => "smsCost_1"]) !!}
                            {!! Form::hidden("smsCost_2" , Config::get('constants.COST_PER_SMS_2') , ["id" => "smsCost_2"]) !!}
                            {!! Form::hidden("smsCost_3" , Config::get('constants.COST_PER_SMS_3') , ["id" => "smsCost_3"]) !!}
                            <br>
                            <label>تعداد گیرندگان: <span id="userGetSms">0</span></label>
                            <br>
                            <label>هزینه کل: <span id="totalSmsCost">0</span></label>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-outline dark"
                                    id="sendSmsForm-close">خیر
                            </button>
                            <button type="button" class="btn green-soft" id="sendSmsForm-submit">ارسال</button>
                            <img class="hidden" id="send-sms-loading"
                                 src="{{Config::get('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px"
                                 width="25px">
                        </div>
                    </div>
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
                            {!! Form::open(['action' => 'UserController@index' , 'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterUserForm']) !!}
                            <div class="form-body" style="background: #e7ecf1">
                                @include("admin.filters.userFilterPack")
                                <div class="form-group">
                                    <div class="ccl-mg-12 col-md-12">
                                        <button type="button" id="filterButton" class="btn btn-lg bg-font-dark"
                                                style="background: #489fff">فیلتر
                                        </button>
                                        <img class="hidden" id="sms-portlet-loading"
                                             src="{{Config::get('constants.FILTER_LOADING_GIF')}}" alt="loading"
                                             width="5%">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="sms_table">
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
            <!-- END EXAMPLE TABLE PORTLET-->
            @endpermission
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
    <script src="/assets/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js"
            type="text/javascript"></script>

    <script src="/assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/js/extraJS/admin-indexSMS.js" type="text/javascript"></script>
    <script src="/js/extraJS/jQueryNumberFormat/jquery.number.min.js" type="text/javascript"></script>
    <script src="/js/extraJS/scripts/admin-makeMultiSelect.js" type="text/javascript"></script>
@endsection
@endpermission