@permission((config('constants.LIST_ORDER_ACCESS')))

@extends('app',['pageName'=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .transactionItem {
            box-shadow: 0px 0px 10px 0px #A4AFFC;
            padding: 10px;
            margin: 5px;
            border-radius: 15px;
        }
        .Transaction_Total_Report {
            font-size: 14px;
            font-weight: bold;
        }

        .multiselect-native-select, .mt-multiselect {
            width: 100%;
        }
        #filterOrderForm .form-group {
            border-top: solid 1px #cecece;
            padding-top: 10px;
        }
        #filterOrderForm .form-group:first-child {
            border: none;
            padding-top: 0;
        }
        
    </style>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">پنل مدیریت سفاش ها</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        {{--Ajax modal loaded after inserting content--}}
        <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
        {{--Ajax modal for panel startup --}}
        <div class="col-md-12">
            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--@role(('admin'))<p>ادمین محترم‌، لیست بنهای تخصیص داده شده به کاربران به این صفحه اضافه شده است! همچنین افزودن بنهای محصول بعد از تایید سفارش نیز در اصلاح سفارشهای تایید نشده اضافه شده است.</p>@endrole--}}
            {{--<strong class="m--font-danger">ادمین محترم سیستم فیلتر جدول سفارش ها ارتقاء یافته است. اگر این بار اول است که از تاریخ ۷ اسفند به بعد از این پنل استفاده می کنید ، لطفا کش بروزر خود را خالی نمایید . با تشکر</strong>--}}
            {{--</div>--}}
    
            {{--delete order modal--}}
            @permission((config('constants.REMOVE_ORDER_ACCESS')))
            <!--begin::Modal-->
            <div class="modal fade" id="deleteOrderConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteOrderConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteOrderConfirmationModalLabel">
                                حذف سفارش محصول <span id="deleteOrderTitle"></span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p> آیا مطمئن هستید؟ </p>
                            {!! Form::hidden('order_id', null) !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                            <button type="button" class="btn btn-primary" onclick="removeOrder()">بله</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Modal-->
            @endpermission
            
            @permission((config('constants.LIST_ORDER_ACCESS')))
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="order-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت سفارش های بسته شده
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload"><i class="la la-refresh"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-expand"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                        {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterOrderForm']) !!}
                        <div class="form-body m--padding-15" style="background: #e7ecf1">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        @include('admin.filters.productsFilter' , ["id" => "orderProduct" , "everyProduct" => 1 ])
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            @include("admin.filters.extraValueFilter")
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            @include('admin.filters.couponFilter')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        @include('admin.filters.orderstatusFilter')
                                    </div>
                                    <div class="col-md-4">
                                        @include('admin.filters.paymentstatusFilter')
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            @include("admin.filters.transactionStatusFilter" , ["withCheckbox"=>true])
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            @include("admin.filters.checkoutStatusFilter")
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        @include('admin.filters.postalCodeFilter')
                                    </div>
                                    <div class="col-md-4">
                                        @include('admin.filters.provinceFilter')
                                    </div>
                                    <div class="col-md-4">
                                        @include('admin.filters.cityFilter')
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 2%">
                                    <div class="col-md-4">
                                        @include('admin.filters.addressFilter')
                                    </div>
                                    <div class="col-md-4">
                                        @include('admin.filters.schoolFilter')
                                    </div>
                                    <div class="col-md-4">
                                        @include('admin.filters.majorFilter' , ["withEnableCheckbox"=>true])
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                @include('admin.filters.identityFilter')
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        @include('admin.filters.orderCustomerDescriptionFilter')
                                    </div>
                                    <div class="col-md-6">
                                        @include('admin.filters.orderManagerCommentsFilter')
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-2 bold control-label">تاریخ ثبت اولیه : </label>
                                    <div class="col-md-10">
                                        @include('admin.filters.timeFilter.createdAt' , ["id" => "order"])
                                    </div>
                                    <label class="col-md-2 bold control-label">تاریخ اصلاح مدیریتی : </label>
                                    <div class="col-md-10">
                                        @include('admin.filters.timeFilter.updatedAt' , ["id" => "order"])
                                    </div>
                                    <label class="col-md-2 bold control-label">تاریخ ثبت نهایی : </label>
                                    <div class="col-md-10">
                                        @include('admin.filters.timeFilter.completedAt' , ["id" => "order"])
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        @include('admin.filters.costFilter', ["priceName" => "cost" , "compareName" => "filterByCost" ,"label"=>"قیمت سفارش"])
                                    </div>
                                    <div class="col-md-6">
                                        @include('admin.filters.costFilter' , ["priceName" => "discountCost" , "compareName" => "filterByDiscount" , "label"=>"تخفیف سفارش"])
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        @include("admin.filters.columnFilter" , ["id" => "orderTableColumnFilter" , "tableDefaultColumns" => $orderTableDefaultColumns])
                                    </div>
                                    <div class="col-md-9">
                                        @include('admin.filters.sort')
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <a href="javascript:" class="btn btn-lg bg-font-dark reload" style="background: #489fff">فیلتر</a>
                                        <img class="d-none" id="order-portlet-loading" src="{{config('constants.FILTER_LOADING_GIF')}}" width="5%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button id="checkOutButton" class="btn btn-outline blue d-none" data-toggle="modal" href="#responsive-checkout">
                                        محصولات انتخابی من در فیلتر شده ها را تسویه کن
                                    </button>

                                    <!--begin::Modal-->
                                    <div class="modal fade" id="responsive-checkout" tabindex="-1" role="dialog" aria-labelledby="responsive-checkoutModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="responsive-checkoutModalLabel">آیا مطمئن هستید؟</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="checkoutModal-close">خیر</button>
                                                    <button type="button" class="btn btn-primary" id="checkout-submit">بله</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Modal-->

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="order_table">

                        {{--sms panel modal--}}
                        @permission((config('constants.SEND_SMS_TO_USER_ACCESS')))

                        <!--begin::Modal-->
                        <div class="modal fade" id="sendSmsModal" tabindex="-1" role="dialog" aria-labelledby="sendSmsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="sendSmsModalLabel">
                                            ارسال پیامک به <span id="smsUserFullName"></span>
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
                                        طول پیام: (<span style="color: red;"><span id="smsNumber">1</span>
                                                        پیامک</span> ) <span id="smsWords">70</span>    کارکتر باقی مانده تا پیام بعدی
                                                    </span>
                                        <br>
                                        <label>هزینه پیامک(ریال): <span
                                                    id="totalSmsCost">{{config('constants.COST_PER_SMS_2')}}</span></label>
                                        <br>
                                        <label>شماره فرستنده : {{config("constants.SMS_PROVIDER_DEFAULT_NUMBER")}}</label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="sendSmsForm-close">بستن</button>
                                        <button type="button" class="btn btn-primary" id="sendSmsForm-submit">ارسال</button>
                                        <img class="d-none" id="send-sms-loading" src="{{config('constants.FILTER_LOADING_GIF')}}" height="25px" width="25px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->
                        @endpermission
                        <thead>
                            <tr>
                                <th></th>
                                <th class="all"> نام خانوادگی</th>
                                <th class="all"> نام کوچک</th>
                                <th class="none"> عملیات</th>
                                <th class="none"> محصولات</th>
                                <th class="none"> رشته</th>
                                <th class="none"> استان</th>
                                <th class="desktop"> شهر</th>
                                <th class="none"> آدرس</th>
                                <th class="none"> کد پستی</th>
                                @permission((config('constants.SHOW_USER_MOBILE')))
                                <th class="desktop"> موبایل</th>
                                <th class="all">کد ملی</th>
                                @endpermission
                                <th class="min-tablet">مبلغ(تومان)</th>
                                @permission((config('constants.SHOW_USER_EMAIL')))
                                <th class="none"> ایمیل</th>
                                @endpermission
                                <th class="desktop">پرداخت شده(تومان)</th>
                                <th class="none">مبلغ برگشتی(تومان)</th>
                                <th class="none">بدهکار/بستانکار(تومان):</th>
                                <th class="none">تراکنش های موفق:</th>
                                <th class="none">تراکنش های منتظر تایید:</th>
                                <th class="none">تراکنش های منتظر پرداخت:</th>
                                <th class="desktop">توضیحات مسئول</th>
                                <th class="none">کد مرسوله پستی</th>
                                <th class="none">توضیحات مشتری</th>
                                <th class="min-tablet">وضعیت سفارش</th>
                                <th class="min-tablet">وضعیت پرداخت</th>
                                <th class="none"> تاریخ اصلاح مدیریتی:</th>
                                <th class="none"> تاریخ ثبت نهایی:</th>
                                <th class="none">تعداد بن استفاده شده:</th>
                                <th class="none">تعداد بن اضافه شده به شما از این سفارش:</th>
                                <th class="none">کپن استفاده شده:</th>
                                <th class="none">وضعیت پرداخت:</th>
                                <th class="none">تاریخ ایجاد اولیه</th>
                            </tr>
                        </thead>
                        <tbody>
                        {{--Loading by ajax--}}
                        </tbody>
                    </table>
                </div>
            </div>
            @endpermission

            @permission((config('constants.LIST_TRANSACTION_ACCESS')))
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--info m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="transaction-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت تراکنش ها
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload"><i class="la la-refresh"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-expand"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                        {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterTransactionForm']) !!}
                        <div class="form-body m--padding-15" style="background: #e7ecf1">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        @include('admin.filters.orderstatusFilter' , ["id"=>"transactionOrderStatuses"])
                                    </div>
                                    <div class="col-md-3">
                                        @include('admin.filters.paymentstatusFilter' , ["id"=>"transactionPaymentStatuses"])
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            @include("admin.filters.transactionStatusFilter" , ["selectType"=>"dropdown"])
                                        </div>
                                    </div>
{{--                                    <div class="col-md-3">--}}
{{--                                        <div class="row">--}}
{{--                                            @include("admin.filters.checkoutStatusFilter" , ["dropdownId"=>"transactionCheckoutStatus" , "checkboxId"=>"transactionCheckoutStatusEnable"])--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        @include('admin.filters.paymentMethodFilter')
                                        @include('admin.filters.paymentGatewayFilter')
                                    </div>
                                    <div class="col-md-3">
                                        @include("admin.filters.transactionType")
                                    </div>
                                    <div class="col-md-3">
                                        @include("admin.filters.transactionCodeFilter")
                                    </div>
                                    <div class="col-md-3">
                                        @include("admin.filters.transactionManagerComment")
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                @include('admin.filters.identityFilter')
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-2 bold control-label">تاریخ پرداخت : </label>
                                    <div class="col-md-10">
                                        @include('admin.filters.timeFilter.createdAt' , ["id" => "transaction" , "default" => true])
                                    </div>
                                    <label class="col-md-2 bold control-label">مهلت پرداخت : </label>
                                    <div class="col-md-10">
                                        @include('admin.filters.timeFilter.generalFilter' , ["id"=>"transaction" , "enableId"=>"DeadlineTimeEnable" , "sinceDateId"=>"DeadlineSinceDate", "tillDateId"=>"DeadlineTillDate"])
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3">
                                        @include("admin.filters.columnFilter" , ["id" => "transactionTableColumnFilter" , "tableDefaultColumns" => $transactionTableDefaultColumns])
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="javascript:" class="btn btn-lg bg-font-dark reload" style="background: #489fff">فیلتر</a>
                                        <img class="d-none" id="transaction-portlet-loading" src="{{config('constants.FILTER_LOADING_GIF')}}" width="5%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @permission((config('constants.SHOW_TRANSACTION_TOTAL_COST_ACCESS')))
                    <span class="m-badge m-badge--success m-badge--wide m-badge--rounded Transaction_Total_Report">مجموع مبالغ تراکنشها : <span id="totalCost"></span>تومان</span>
                    @endpermission
                    <a target="_blank" href="{{action("Web\TransactionController@getUnverifiedTransactions")}}" class="btn btn-lg m-btn--pill m-btn--air btn-danger active m--margin-10">لیست تراکنشهای تایید نشده زرین پال</a>
                    <div class="table-toolbar"></div>

                    <!--begin::Modal-->
                    <div class="modal fade" id="completeTransactionInfo" tabindex="-1" role="dialog" aria-labelledby="completeTransactionInfoLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="completeTransactionInfoLabel">
                                        تکمیل اطلاعات تراکنش
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {!! Form::open([  'method'=>'POST'  , 'class'=>'completeTransactionInfoForm form-horizontal' ]) !!}
                                {!! Form::hidden('transaction_id' , null , ['id'=>'completeTransactionInfoForm_transactionId']) !!}
                                <div class="modal-body">
                                    <div class="row static-info margin-top-20">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="traceNumber">شماره پیگیری:</label>
                                            <div class="col-md-6">
                                                {!! Form::text('traceNumber',old('traceNumber'),['class' => 'form-control' , 'id'=>'completeTransactionInfoTraceNumber', 'dir'=>'ltr' ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row static-info margin-top-20">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="managerComment">شماره کارت:</label>
                                            <div class="col-md-6">
                                                {!! Form::text('managerComment',old('managerComment'),['class' => 'form-control' , 'id'=>'completeTransactionInfoCardNumber' , 'dir'=>'ltr' ]) !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                    <button type="submit" class="btn btn-primary">ذخیره</button>
                                    <img class="d-none" id="complete-transaction-info-loading" src="{{config('constants.FILTER_LOADING_GIF')}}" alt="loading" height="25px" width="25px">
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                    
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="transaction_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام مشتری</th>
                            <th class="none"> تراکنش پدر</th>
                            <th class="all"> موبایل</th>
                            @permission((config('constants.SHOW_TRANSACTION_TOTAL_COST_ACCESS')))
                            <th class="all"> مبلغ سفارش</th>
                            <th class="all"> مبلغ تراکنش</th>
                            @endpermission
                            @permission((config('constants.SHOW_TRANSACTION_TOTAL_FILTERED_COST_ACCESS')))
                            <th class="all"> مبلغ فیلتر شده</th>
                            <th class="all"> مبلغ آیتم افزوده</th>
                            @endpermission
                            <th class="all"> کد تراکنش</th>
                            <th class="all">درگاه پرداخت</th>
                            <th class="none"> نحوه پرداخت</th>
                            <th class="none"> تاریخ ثبت :</th>
                            <th class="none"> مهلت پرداخت :</th>
                            <th class="none"> تاریخ پرداخت :</th>
                            <th class="none">عملیات تراکنش</th>
                            <th class="none"> توضیح مدیریتی :</th>
                            <th class="all">عملیات سفارش</th>
                        </tr>
                        </thead>
                        <tbody>
                        Loading by ajax
                        </tbody>
                    </table>
                </div>
            </div>
            @endpermission

            @permission((config('constants.LIST_USER_BON_ACCESS')))
            <div class="m-portlet m-portlet--head-solid-bg m-portlet--primary m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="userBon-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                مدیریت بن کاربران
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload"><i class="la la-refresh"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-expand"></i></a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="portlet box blue" style="background: #e7ecf1">
                        <div class="portlet-title">
                            <div class="caption "><h3 class="bold">
                                    <i class="fa fa-filter"></i>فیلتر جدول</h3></div>
                        </div>
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form" style="border-top: #3598dc solid 1px">
                            {!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterUserBonForm']) !!}
                            <div class="form-body" style="background: #e7ecf1">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        @include("admin.filters.productsFilter" , ["id" => "userBonProduct" , "title" => "نام کالایی که از خرید آن بن دریافت کرده است" , "everyProduct"=>1])
                                    </div>
                                    <div class="col-md-4">
                                        @include("admin.filters.userBonStatusFilter")
                                    </div>
                                </div>
                                <div class="form-group">
                                    @include('admin.filters.identityFilter')
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 bold control-label">تاریخ درج : </label>
                                    <div class="col-md-10">
                                        @include('admin.filters.timeFilter.createdAt' , ["id" => "userBon" , "default" => true])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-md-3">
                                        @include("admin.filters.columnFilter" , ["id" => "userBonTableColumnFilter" , "tableDefaultColumns" => $userBonTableDefaultColumns])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <a href="javascript:" class="btn btn-lg bg-font-dark reload"
                                           style="background: #489fff">فیلتر</a>
                                        <img class="d-none" id="userBon-portlet-loading"
                                             src="{{config('constants.FILTER_LOADING_GIF')}}" width="5%">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    delete conformation
                    @permission((config('constants.REMOVE_USER_BON_ACCESS')))
    
                    <!--begin::Modal-->
                    <div class="modal fade" id="deleteUserBonConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="completeTransactionInfoLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="completeTransactionInfoLabel">
                                        حذف بن کاربر <span id="deleteUserBonFullName"></span>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p> آیا مطمئن هستید؟ </p>
                                    {!! Form::hidden('userbon_id', null) !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                                    <button type="button" class="btn btn-primary" onclick="removeUserBon();">بله</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal-->
                    
                    @endpermission
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="userBon_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام کاربر</th>
                            <th class="all"> تعداد بن تخصیص داده شده</th>
                            <th class="all"> وضعیت بن</th>
                            <th class="none"> نام کالایی که از خرید آن بن دریافت کرده است</th>
                            <th class="none">تاریخ درج</th>
                            <th class="all"> عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        Loading by ajax
                        </tbody>
                    </table>
                </div>
            </div>
            @endpermission

        </div>
    </div>
@endsection

@section('page-js')
    
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        @permission((config('constants.LIST_ORDER_ACCESS')));
        function makeDataTable_loadWithAjax_orders(dontLoadAjax) {
            
            $('#order_table > tbody').html("");
            let defaultContent = "<span class=\"m-badge m-badge--wide label-sm m-badge--danger\"> درج نشده </span>";
            let columns = [
                {
                    "data": null,
                    "name": "row_child",
                    "defaultContent": ""
                },
                {
                    "data": null,
                    "name": "user.lastName",
                    "title": "نام خانوادگی",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (row.user.lastName === null) {
                            return defaultContent;
                        }
                        return '<a href="'+row.user.editLink+'" target="_blank" class="m-link">'+row.user.lastName+'</a>';
                    },
                },
                { "data": "user.firstName" , "title": "نام کوچک", "defaultContent": defaultContent},
                {
                    "data": null,
                    "name": "functions",
                    "title": "عملیات",
                    defaultContent: '',
                    "render": function ( data, type, row ) {
                        return '\n' +
                            '            <div class="btn-group">\n' +
                            '                <input type="hidden" class="userFullname" name="userFullname" value="'+row.user.firstName+' '+row.user.lastName+'">\n' +
                            '                <input type="hidden" class="userId" name="userId" value="'+row.user.id+'">\n' +
                            '                <a target="_blank" class="btn btn-success" href="'+row.editLink+'">\n' +
                            '                    <i class="fa fa-pencil"></i> اصلاح \n' +
                            '                </a>\n' +
                            '                <a class="btn btn-danger deleteOrder" data-target="#deleteOrderConfirmationModal" data-toggle="modal" remove-link="'+row.removeLink+'" fullname="'+row.user.firstName+row.user.lastName+'">\n' +
                            '                    <i class="fa fa-remove" aria-hidden="true"></i> حذف \n' +
                            '                </a>\n' +
                            '                <a class="btn btn-info sendSms" data-target="#sendSmsModal" data-toggle="modal">\n' +
                            '                    <i class="fa fa-envelope" aria-hidden="true"></i> ارسال پیامک\n' +
                            '                </a>\n' +
                            '                <div id="ajax-modal" class="modal fade" tabindex="-1"></div>\n' +
                            '            </div>';
                    },
                },
                {
                    "data": null,
                    "name": "products",
                    "title": "محصولات",
                    defaultContent: '',
                    "render": function ( data, type, row ) {
                        if (row.orderproducts.length === 0) {
                            return '<span class="m-badge m-badge--wide m-badge--danger">ندارد</span>';
                        }
                        let produtsNames = '';
                        for (let index in row.orderproducts) {
                            if(isNaN(index)) {
                                continue;
                            }
                            let orderProduct = row.orderproducts[index];

                            produtsNames += '<span class="m-badge m-badge--info m-badge--wide m-badge--rounded">';
                            if (orderProduct.orderproducttype.name === 'gift') {
                                produtsNames += '<img class="m--margin-right-5" src="/acm/extra/gift-box.png" width="25">';
                            }
                            produtsNames += '<a class="m-link" target="_blank" href="'+orderProduct.product.url+'">\n' + orderProduct.product.name + '</a>';
                            produtsNames += '</span>';
                            if (typeof orderProduct.checkoutstatus_id !== 'undefined') {
                                produtsNames += '- <span class="m--font-danger bold">'+orderProduct.checkoutstatus.displayName+'</span>';
                            }
                            produtsNames += '<br>';
                        }
                        return produtsNames;
                    },
                },
                { "data": "user.info.major.name" , "title": "رشته", "defaultContent": defaultContent},
                { "data": "user.province" , "title": "استان", "defaultContent": defaultContent},
                { "data": "user.city" , "title": "شهر", "defaultContent": defaultContent},
                { "data": "user.address" , "title": "آدرس", "defaultContent": defaultContent},
                { "data": "user.postalCode" , "title": "کد پستی", "defaultContent": defaultContent},
                @permission((config('constants.SHOW_USER_MOBILE')))
                { "data": "user.mobile" , "title": "موبایل", "defaultContent": defaultContent},
                { "data": "user.nationalCode" , "title": "کد ملی", "defaultContent": defaultContent},
                @endpermission
                {
                    "data": null,
                    "name": "price",
                    "title": "مبلغ(تومان)",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (row.price === null) {
                            return defaultContent;
                        }
                        return row.price.toLocaleString('fa');
                    },
                },
                @permission((config('constants.SHOW_USER_EMAIL')))
                { "data": "user.email" , "title": "ایمیل", "defaultContent": defaultContent},
                @endpermission
                {
                    "data": null,
                    "name": "paidPrice",
                    "title": "پرداخت شده(تومان)",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (row.paidPrice === null) {
                            return defaultContent;
                        }
                        return row.paidPrice.toLocaleString('fa');
                    },
                },
                {
                    "data": null,
                    "name": "refundPrice",
                    "title": "مبلغ برگشتی(تومان)",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (row.refundPrice === null) {
                            return defaultContent;
                        }
                        return row.refundPrice.toLocaleString('fa');
                    },
                },
                {
                    "data": null,
                    "name": "debt",
                    "title": "بدهکار/بستانکار(تومان):",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (row.debt === null) {
                            return defaultContent;
                        }
                        return row.debt.toLocaleString('fa');
                    },
                },
                {
                    "data": null,
                    "name": "successfulTransactions",
                    "title": "تراکنش های موفق:",
                    defaultContent: '',
                    "render": function ( data, type, row ) {
                        if (row.successfulTransactions.length === 0) {
                            return '<span class="m-badge m-badge--wide m-badge--warning">ندارد</span>';
                        }

                        let successfulTransactions = '';
                        for (let index in row.successfulTransactions) {
                            if(isNaN(index)) {
                                continue;
                            }
                            successfulTransactions += '<div class="transactionItem successfulTransactionItem">';
                            let successfulTransaction = row.successfulTransactions[index];
                            if (typeof successfulTransaction.paymentmethod !== 'undefined') {
                                successfulTransactions += successfulTransaction.paymentmethod.displayName;
                            } else {
                                successfulTransactions += '<span class="m-badge m-badge--wide m-badge--danger">- نحوه پرداخت نامشخص</span>';
                            }
                            if (
                                typeof successfulTransaction.transactiongateway !== 'undefined' &&
                                successfulTransaction.transactiongateway !== null
                            ) {
                                successfulTransactions += '<span class="m-badge m-badge--wide m-badge--info">'+successfulTransaction.transactiongateway.displayName+'</span>';
                            }
                            successfulTransactions += '- مبلغ: ';
                            if (successfulTransaction.cost >= 0) {
                                successfulTransactions += successfulTransaction.cost.toLocaleString('fa');
                            } else {
                                successfulTransactions += successfulTransaction.cost.toLocaleString('fa') + ' (دریافت) ';
                            }

                            successfulTransactions += '<a target="_blank" href="'+successfulTransaction.editLink+'" class="btn btn-sm m-btn--pill m-btn--air btn-info m--margin-left-10">اصلاح</a>';
                            if (typeof successfulTransaction.grandParent !== 'undefined') {
                                successfulTransactions += '<a target="_blank" href="#" class="btn btn-sm m-btn--pill m-btn--air btn-info m--margin-left-10">رفتن به تراکنش والد</a>';
                            }
                            
                            successfulTransactions += '<br>';
                            
                            successfulTransactions += ',تاریخ پرداخت:';
                            if (typeof successfulTransaction.jalaliCompletedAt !== 'undefined' && successfulTransaction.jalaliCompletedAt !== null) {
                                successfulTransactions += successfulTransaction.jalaliCompletedAt;
                            } else {
                                successfulTransactions += '<span class="bold m--font-danger">نامشخص</span>';
                            }
                            successfulTransactions += ',توضیح مدیریتی:';
                            if (typeof successfulTransaction.managerComment !== 'undefined' && successfulTransaction.managerComment !== null) {
                                successfulTransactions += successfulTransaction.managerComment;
                            } else {
                                successfulTransactions += '<span class="m-badge m-badge--wide m-badge--warning">ندارد</span>';
                            }
                            successfulTransactions += '</div>';
                        }
                        return successfulTransactions;
                    },
                },
                {
                    "data": null,
                    "name": "pendingTransactions",
                    "title": "تراکنش های منتظر تایید:",
                    defaultContent: '',
                    "render": function ( data, type, row ) {
                        if (row.pendingTransactions.length === 0) {
                            return '<span class="m-badge m-badge--wide m-badge--success">ندارد</span>';
                        }
                        let pendingTransactions = '';
                        for (let index in row.pendingTransactions) {
                            if (isNaN(index)) {
                                continue;
                            }
                            pendingTransactions += '<div class="transactionItem pendingTransactionItem">';
                            let pendingTransaction = row.pendingTransactions[index];
                            
                            if (typeof pendingTransaction.paymentmethod !== 'undefined') {
                                pendingTransactions += pendingTransaction.paymentmethod.displayName;
                            }

                            if (
                                typeof pendingTransaction.transactiongateway !== 'undefined' &&
                                pendingTransaction.transactiongateway !== null
                            ) {
                                pendingTransactions += '<span class="m-badge m-badge--wide m-badge--info">'+pendingTransaction.transactiongateway.displayName+'</span>';
                            }
                            if (typeof pendingTransaction.cost !== 'undefined') {
                                pendingTransactions += ' ,مبلغ:  ' + pendingTransaction.cost.toLocaleString('fa');
                            } else {
                                pendingTransactions += '<span class="bold m--font-danger">بدون مبلغ</span>';
                            }
                            pendingTransactions += '<br>';
                            pendingTransactions += '<a target="_blank" href="#" class="btn-sm btn m-btn--pill m-btn--air btn-primary sbold m--margin-left-10">اصلاح</a>';
                            
                            if (typeof pendingTransaction.transactionID !== 'undefined') {
                                pendingTransactions += '  ,شماره تراکنش: ' + pendingTransaction.transactionID;
                            }
                            if (typeof pendingTransaction.traceNumber !== 'undefined') {
                                pendingTransactions += '  ,شماره پیگیری: ' + pendingTransaction.traceNumber;
                            }
                            if (typeof pendingTransaction.referenceNumber !== 'undefined') {
                                pendingTransactions += '  ,شماره مرجع: ' + pendingTransaction.referenceNumber;
                            }
                            if (typeof pendingTransaction.paycheckNumber !== 'undefined') {
                                pendingTransactions += '  ,شماره چک: ' + pendingTransaction.paycheckNumber;
                            }
                            pendingTransactions += ' ,تاریخ پرداخت: ';
                            if (typeof pendingTransaction.jalaliCompletedAt !== 'undefined' && pendingTransaction.jalaliCompletedAt !== null) {
                                pendingTransactions += pendingTransaction.jalaliCompletedAt;
                            } else {
                                pendingTransactions += '<span class="bold m--font-danger">نامشخص</span>';
                            }
                            pendingTransactions += ' ,توضیح مدیریتی: ';
                            if (typeof pendingTransaction.managerComment !== 'undefined' && pendingTransaction.managerComment !== null) {
                                pendingTransactions += '<span class="bold m--font-info">' + pendingTransaction.managerComment + '</span>';
                            } else {
                                pendingTransactions += '<span class="bold m--font-danger">نامشخص</span>';
                            }
                            pendingTransactions += '</div>';
                        }
                        return pendingTransactions;
                    },
                },
                {
                    "data": null,
                    "name": "unpaidTransactions",
                    "title": "تراکنش های منتظر پرداخت:",
                    defaultContent: '',
                    "render": function ( data, type, row ) {
                        if (row.unpaidTransactions.length === 0) {
                            return '<span class="m-badge m-badge--wide m-badge--success">ندارد</span>';
                        }
                        let unpaidTransactions = '';
                        for (let index in row.unpaidTransactions) {
                            if (isNaN(index)) {
                                continue;
                            }
                            unpaidTransactions += '<div class="transactionItem unpaidTransactionItem">';
                            let unpaidTransaction = row.unpaidTransactions[index];
                            
                            if (typeof unpaidTransaction.cost !== 'undefined') {
                                unpaidTransactions += ' ,مبلغ:  ' + unpaidTransaction.cost.toLocaleString('fa');
                            } else {
                                unpaidTransactions += '<span class="bold m--font-danger">بدون مبلغ</span>';
                            }
                            unpaidTransactions += '<a target="_blank" href="#" class="btn btn-sm m-btn--pill m-btn--air btn-info m--margin-left-10">اصلاح</a>';

                            unpaidTransactions += '<br>';
                            
                            unpaidTransactions += ' ,مهلت پرداخت: ';
                            if (typeof unpaidTransaction.jalaliDeadlineAt !== 'undefined') {
                                unpaidTransactions += unpaidTransaction.jalaliDeadlineAt;
                            } else {
                                unpaidTransactions += '<span class="bold m--font-danger">نامشخص</span>';
                            }
                            unpaidTransactions += ' ,توضیح مدیریتی: ';
                            if (typeof unpaidTransaction.managerComment !== 'undefined' &&  unpaidTransaction.managerComment !== null) {
                                unpaidTransactions += '<span class="bold m--font-info">' + unpaidTransaction.managerComment + '</span>';
                            } else {
                                unpaidTransactions += '<span class="m-badge m-badge--wide m-badge--warning">ندارد</span>';
                            }
                            unpaidTransactions += '</div>';
                        }
                        return unpaidTransactions;
                    },
                },
                { "data": "managerComment" , "title": "توضیحات مسئول", "defaultContent": defaultContent},
                {
                    "data": null,
                    "name": "postingInfo",
                    "title": "کد مرسوله پستی",
                    defaultContent: '<span class="m-badge m-badge--wide m-badge--info">ندارد</span>',
                    "render": function ( data, type, row ) {
                        if (row.postingInfo.length === 0) {
                            return '<span class="m-badge m-badge--wide m-badge--info">ندارد</span>';
                        }
                        let postingInfoHtml = '';
                        for (let index in row.postingInfo) {
                            if (isNaN(index)) {
                                continue;
                            }
                            let postingInfoItem = row.postingInfo[index];
                            postingInfoHtml += '<span class="m--font-danger bold">';
                            for (let index1 in postingInfoItem) {
                                if (isNaN(index1)) {
                                    continue;
                                }
                                postingInfoHtml += postingInfoItem[index1].postCode + '<br>';
                            }
                            postingInfoHtml += '</span>';
                        }
                        return postingInfoHtml;
                    },
                },
                {
                    "data": null,
                    "name": "customerDescription",
                    "title": "توضیحات مشتری",
                    defaultContent: '<span class="m-badge m-badge--wide m-badge--warning">بدون توضیح</span>',
                    "render": function ( data, type, row ) {
                        if (typeof row.customerDescription !== 'undefined' && row.customerDescription !== null && row.customerDescription.length > 0) {
                            return '<span class="m--font-danger bold">'+row.customerDescription+'<br></span>';
                        } else {
                            return '<span class="m-badge m-badge--wide m-badge--warning">بدون توضیح</span>';
                        }
                    },
                },
                {
                    "data": null,
                    "name": "orderstatus",
                    "title": "وضعیت سفارش",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (typeof row.orderstatus.id !== 'undefined') {
                            return defaultContent;
                        }
                        let orderstatusName = row.orderstatus.name;
                        let badgeStyle = 'm-badge--';
                        if (orderstatusName === 'closed') {
                            badgeStyle += 'success';
                        } else if (orderstatusName === 'canceled') {
                            badgeStyle += 'danger';
                        } else if (orderstatusName === 'posted') {
                            badgeStyle += 'info';
                        } else if (orderstatusName === 'refunded') {
                            badgeStyle += '';
                        } else if (orderstatusName === 'open') {
                            badgeStyle += 'danger';
                        } else if (orderstatusName === 'openByAdmin') {
                            badgeStyle += 'warning';
                        } else if (orderstatusName === 'readyToPost') {
                            badgeStyle += 'info';
                        } else if (orderstatusName === 'pending') {
                            badgeStyle += '';
                        }
                        return '<span class="m-badge m-badge--wide '+badgeStyle+'"> '+row.orderstatus.displayName+'</span>';
                    },
                },
                {
                    "data": null,
                    "name": "paymentstatus",
                    "title": "وضعیت پرداخت",
                    defaultContent: defaultContent,
                    "render": function ( data, type, row ) {
                        if (typeof row.paymentstatus.id !== 'undefined') {
                            return defaultContent;
                        }
                        let paymentstatusName = row.paymentstatus.name;
                        let badgeStyle = 'm-badge--';
                        if (paymentstatusName === 'paid') {
                            badgeStyle += 'success';
                        } else if (paymentstatusName === 'unpaid') {
                            badgeStyle += 'danger';
                        } else if (paymentstatusName === 'indebted') {
                            badgeStyle += 'warning';
                        } else if (paymentstatusName === 'approvedIndebted') {
                            badgeStyle += 'warning';
                        }
                        return '<span class="m-badge m-badge--wide '+badgeStyle+'">'+row.paymentstatus.displayName+'</span>';
                    },
                },
                { "data": "jalaliUpdatedAt" , "title": "تاریخ اصلاح مدیریتی:", "defaultContent": defaultContent },
                { "data": "jalaliCompletedAt" , "title": "تاریخ ثبت نهایی:", "defaultContent": defaultContent },
                { "data": "usedBonSum" , "title": "تعداد بن استفاده شده:", "defaultContent": defaultContent },
                {
                    "data": null,
                    "name": "addedBonSum",
                    "title": "تعداد بن اضافه شده به شما از این سفارش:",
                    defaultContent: '<span class="m-badge m-badge--wide m-badge--info">سفارش خالی است!</span>',
                    "render": function ( data, type, row ) {
                        if (row.orderproducts.length === 0) {
                            return '<span class="m-badge m-badge--wide m-badge--info">سفارش خالی است!</span>';
                        }

                        return row.addedBonSum;
                    },
                },
                {
                    "data": null,
                    "name": "couponInfo",
                    "title": "کپن استفاده شده:",
                    defaultContent: "<span class=\"m-badge m-badge--wide label-sm m-badge--info\"> ندارد </span>",
                    "render": function ( data, type, row ) {
                        if (row.couponInfo == null) {
                            return "<span class=\"m-badge m-badge--wide label-sm m-badge--info\"> ندارد </span>";
                        }

                        let couponReport = ' کپن تخفیف ' +
                            ' <strong>' + row.couponInfo.name + '</strong> ' +
                            ' (' + row.couponInfo.code + ') ' +
                            ' با ' +
                            row.couponInfo.discount;

                        if (row.couponInfo.typeHint === 'percentage') {
                            couponReport += '% تخفیف';
                        } else if (row.couponInfo.typeHint === 'cost') {
                            couponReport += ' تومان تخفیف';
                        }
                        return couponReport;
                    },
                },
                { "data": "paymentstatus.displayName" , "title": "وضعیت پرداخت:", "defaultContent": defaultContent },
                { "data": "jalaliCreatedAt" , "title": "تاریخ ایجاد اولیه", "defaultContent": defaultContent },
            ];
            let dataFilter = function(data){
                var json = jQuery.parseJSON( data );
                console.log(json);
                json.recordsTotal = json.total;
                json.recordsFiltered = json.total;
                return JSON.stringify( json ); // return JSON string
            };
            let ajaxData = function (data) {
                mApp.block('#order_table_wrapper', {
                    type: "loader",
                    state: "info",
                });
                data.orders = getNextPageParam(data.start, data.length);
                delete data.columns;
                let $form = $("#filterOrderForm");
                let formData = getFormData($form);
                data = $.extend({}, data, formData);
                return data;
            };
            let dataSrc = function (json) {
                $("#order-portlet-loading").addClass("d-none");
                mApp.unblock('#order_table_wrapper');
                return json.data;
            };
            let url = '/order';
            if (dontLoadAjax) {
                url = null;
            } else {
                $("#order-portlet-loading").removeClass("d-none");
            }
            let dataTable = makeDataTable_loadWithAjax("order_table", url, columns, dataFilter, ajaxData, dataSrc);
            return dataTable;
        }
        @endpermission;
    </script>
    <script src="/acm/AlaatvCustomFiles/js/admin/page-ordersAdmin.js" type="text/javascript"></script>

    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
            // $("#loadingAjax").click();
            @permission((config('constants.LIST_ORDER_ACCESS')));
                // $("#order-portlet .reload").trigger("click");
                var newDataTable = $("#order_table").DataTable();
                newDataTable.destroy();
                // makeDataTable("order_table");
                makeDataTable_loadWithAjax_orders(true);
                $("#order-expand").trigger("click");
                $("#order_table > tbody .dataTables_empty").text("برای نمایش اطلاعات ابتدا فیلتر کنید").addClass("m--font-danger bold");
            @endpermission;
            @permission((config('constants.LIST_TRANSACTION_ACCESS')));
                $("#transaction-portlet .reload").trigger("click");
                $("#transaction-expand").trigger("click");
            @endpermission;
            @permission((config('constants.LIST_USER_BON_ACCESS')));
                $("#userBon-portlet .reload").trigger("click");
                $("#userBon-expand").trigger("click");
            @endpermission

        });
    </script>

@endsection
@endability
