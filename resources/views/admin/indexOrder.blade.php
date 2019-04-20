@permission((config('constants.LIST_ORDER_ACCESS')))
@extends('app',['pageName'=>$pageName])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel="stylesheet" type="text/css"/>
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
    <style>
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
    <div class="row">
        {{--Ajax modal loaded after inserting content--}}
        <div id="ajax-modal" class="modal fade" tabindex="-1"></div>
        {{--Ajax modal for panel startup --}}
        <div class="col-md-12">
            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--@role(('admin'))<p>ادمین محترم‌، لیست بنهای تخصیص داده شده به کاربران به این صفحه اضافه شده است! همچنین افزودن بنهای محصول بعد از تایید سفارش نیز در اصلاح سفارشهای تایید نشده اضافه شده است.</p>@endrole--}}
            {{--<strong class="font-red">ادمین محترم سیستم فیلتر جدول سفارش ها ارتقاء یافته است. اگر این بار اول است که از تاریخ ۷ اسفند به بعد از این پنل استفاده می کنید ، لطفا کش بروزر خود را خالی نمایید . با تشکر</strong>--}}
            {{--</div>--}}

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
                                        <div class="row">
                                            @include('admin.filters.postalCodeFilter')
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            @include('admin.filters.provinceFilter')
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            @include('admin.filters.cityFilter')
                                        </div>
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
                                <div class="row">
                                    @include('admin.filters.identityFilter')
                                </div>
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
                                        <div class="row">
                                            @include('admin.filters.timeFilter.createdAt' , ["id" => "order"])
                                        </div>
                                    </div>
                                    <label class="col-md-2 bold control-label">تاریخ اصلاح مدیریتی : </label>
                                    <div class="col-md-10">
                                        <div class="row">
                                            @include('admin.filters.timeFilter.updatedAt' , ["id" => "order"])
                                        </div>
                                    </div>
                                    <label class="col-md-2 bold control-label">تاریخ ثبت نهایی : </label>
                                    <div class="col-md-10">
                                        <div class="row">
                                            @include('admin.filters.timeFilter.completedAt' , ["id" => "order"])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            @include('admin.filters.costFilter', ["priceName" => "cost" , "compareName" => "filterByCost" ,"label"=>"قیمت سفارش"])
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            @include('admin.filters.costFilter' , ["priceName" => "discountCost" , "compareName" => "filterByDiscount" , "label"=>"تخفیف سفارش"])
                                        </div>
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
                                    <div class="col-md-12">
                                        <a href="javascript:" class="btn btn-lg bg-font-dark reload"
                                           style="background: #489fff">فیلتر</a>
                                        <img class="d-none" id="order-portlet-loading"
                                             src="{{config('constants.FILTER_LOADING_GIF')}}" width="5%">
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
                                    <button id="checkOutButton" class="btn btn-outline blue d-none" data-toggle="modal"
                                            href="#responsive-checkout">
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
                                    <div class="col-md-6">
                                        @include('admin.filters.productsFilter', ["id" => "transactionProduct" , "everyProduct"=>1])
                                    </div>
                                    <div class="col-md-4">
                                        @include("admin.filters.extraValueFilter" , ["id"=>"transactionExtraAttributes"])
                                    </div>
                                </div>
                            </div>
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
                                    <div class="col-md-3">
                                        <div class="row">
                                            @include("admin.filters.checkoutStatusFilter" , ["dropdownId"=>"transactionCheckoutStatus" , "checkboxId"=>"transactionCheckoutStatusEnable"])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        @include('admin.filters.paymentMethodFilter')
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
                                <div class="row">
                                    @include('admin.filters.identityFilter')
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-2 bold control-label">تاریخ پرداخت : </label>
                                    <div class="col-md-10">
                                        <div class="row">
                                            @include('admin.filters.timeFilter.createdAt' , ["id" => "transaction" , "default" => true])
                                        </div>
                                    </div>
                                    <label class="col-md-2 bold control-label">مهلت پرداخت : </label>
                                    <div class="col-md-10">
                                        <div class="row">
                                            @include('admin.filters.timeFilter.generalFilter' , ["id"=>"transaction" , "enableId"=>"DeadlineTimeEnable" , "sinceDateId"=>"DeadlineSinceDate", "tillDateId"=>"DeadlineTillDate"])
                                        </div>
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
                    <span class="m-badge m-badge--success m-badge--wide m-badge--rounded">مجموع مبالغ تراکنشها : <span id="totalCost"></span>تومان</span>
                    @endpermission
                    @permission((config('constants.SHOW_TRANSACTION_TOTAL_FILTERED_COST_ACCESS')))
                    <span class="m-badge m-badge--success m-badge--wide m-badge--rounded">مجموع مبالغ فیلتر شده ها : <span id="totalFilteredCost"></span> تومان</span>
                    <span class="m-badge m-badge--success m-badge--wide m-badge--rounded">مجموع مبالغ آیتم های اضافه : <span id="totalFilteredExtraCost"></span> تومان</span><br>
                    @endpermission
                    <a target="_blank" href="{{action("Web\TransactionController@getUnverifiedTransactions")}}" class="btn btn-lg m-btn--pill m-btn--air btn-danger active m--margin-10">لیست تراکنشهای ثبت نشده</a>
                    <div class="table-toolbar">
                    </div>

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
                            <th class="all"> نحوه پرداخت</th>
                            <th class="none"> تاریخ ثبت :</th>
                            <th class="none"> مهلت پرداخت :</th>
                            <th class="none"> تاریخ پرداخت :</th>
                            <th class="none">عملیات</th>
                            <th class="none"> توضیح مدیریتی :</th>
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

            {{--@permission((config('constants.LIST_USER_BON_ACCESS')))--}}
            {{--<!-- BEGIN ORDER TABLE PORTLET-->--}}
            {{--<div class="portlet box green-turquoise" id="userBon-portlet">--}}
                {{--<div class="portlet-title">--}}
                    {{--<div class="caption">--}}
                        {{--<i class="fa fa-cogs"></i>مدیریت بن کاربران--}}
                    {{--</div>--}}
                    {{--<div class="tools">--}}
                        {{--<a href="javascript:" class="collapse" id="userBon-expand"> </a>--}}
                        {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                        {{--<a href="javascript:" class="reload"> </a>--}}
                        {{--<a href="javascript:" class="remove"> </a>--}}
                    {{--</div>--}}
                    {{--<div class="tools"> </div>--}}
                {{--</div>--}}
                {{--<div class="portlet-body" style="display: block;">--}}
                    {{--<div class="portlet box blue" style="background: #e7ecf1">--}}
                        {{--<div class="portlet-title">--}}
                        {{--<div class="caption "><h3 class="bold">--}}
                        {{--<i class="fa fa-filter"></i>فیلتر جدول</h3></div>--}}
                        {{--</div>--}}
                        {{--<style>--}}
                            {{--.form .form-row-seperated .form-group {--}}
                                {{--border-bottom-color: #bfbfbf !important;--}}
                            {{--}--}}
                        {{--</style>--}}
                        {{--<div class="portlet-body form" style="border-top: #3598dc solid 1px">--}}
                            {{--{!! Form::open(['class'=>'form-horizontal form-row-seperated' , 'id' => 'filterUserBonForm']) !!}--}}
                            {{--<div class="form-body" style="background: #e7ecf1">--}}
                                {{--<div class="form-group">--}}
                                    {{--<div class="col-md-6">--}}
                                        {{--@include("admin.filters.productsFilter" , ["id" => "userBonProduct" , "title" => "نام کالایی که از خرید آن بن دریافت کرده است" , "everyProduct"=>1])--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--@include("admin.filters.userBonStatusFilter")--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--@include('admin.filters.identityFilter')--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<label class="col-md-2 bold control-label">تاریخ درج : </label>--}}
                                    {{--<div class="col-md-10">--}}
                                        {{--@include('admin.filters.timeFilter.createdAt' , ["id" => "userBon" , "default" => true])--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<div class="col-lg-3 col-md-3">--}}
                                        {{--@include("admin.filters.columnFilter" , ["id" => "userBonTableColumnFilter" , "tableDefaultColumns" => $userBonTableDefaultColumns])--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group">--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<a href="javascript:" class="btn btn-lg bg-font-dark reload"--}}
                                           {{--style="background: #489fff">فیلتر</a>--}}
                                        {{--<img class="d-none" id="userBon-portlet-loading"--}}
                                             {{--src="{{config('constants.FILTER_LOADING_GIF')}}" width="5%">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--{!! Form::close() !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="table-toolbar">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="btn-group">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--delete conformation--}}
                    {{--@permission((config('constants.REMOVE_USER_BON_ACCESS')))--}}
                    {{--<div id="deleteUserBonConfirmationModal" class="modal fade" tabindex="-1" data-backdrop="static"--}}
                         {{--data-keyboard="false">--}}
                        {{--<div class="modal-header">حذف بن کاربر <span id="deleteUserBonFullName"></span></div>--}}
                        {{--<div class="modal-body">--}}
                            {{--<p> آیا مطمئن هستید؟ </p>--}}
                            {{--{!! Form::hidden('userbon_id', null) !!}--}}
                        {{--</div>--}}
                        {{--<div class="modal-footer">--}}
                            {{--<button type="button" data-dismiss="modal" class="btn btn-outline dark">خیر</button>--}}
                            {{--<button type="button" data-dismiss="modal" class="btn green" onclick="removeUserBon();">--}}
                                {{--بله--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@endpermission--}}
                    {{--<table class="table table-striped table-bordered table-hover dt-responsive" width="100%"--}}
                           {{--id="userBon_table">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th></th>--}}
                            {{--<th class="all"> نام کاربر</th>--}}
                            {{--<th class="all"> تعداد بن تخصیص داده شده</th>--}}
                            {{--<th class="all"> وضعیت بن</th>--}}
                            {{--<th class="none"> نام کالایی که از خرید آن بن دریافت کرده است</th>--}}
                            {{--<th class="none">تاریخ درج</th>--}}
                            {{--<th class="all"> عملیات</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--Loading by ajax--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!-- END SAMPLE TABLE PORTLET-->--}}
            {{--@endpermission--}}

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

    <script src="/acm/AlaatvCustomFiles/js/admin-indexOrder.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>

    <script type="text/javascript">
        //should run at first
        $('#order_table > thead > tr').children('th:first').removeClass().addClass("none");
        $("#order_table thead tr th").each(function () {
            if (!$(this).hasClass("none")) {
                thText = $(this).text().trim();
                $("#orderTableColumnFilter > option").each(function () {
                    if ($(this).val() === thText) {
                        $(this).prop("selected", true);
                    }
                });
            }
        });

        $('#transaction_table > thead > tr').children('th:first').removeClass().addClass("none");
        $("#transaction_table thead tr th").each(function () {
            if (!$(this).hasClass("none")) {
                thText = $(this).text().trim();
                $("#transactionTableColumnFilter > option").each(function () {
                    if ($(this).val() === thText) {
                        $(this).prop("selected", true);
                    }
                });
            }
        });

        $("#userBon_table thead tr th").each(function () {
            if (!$(this).hasClass("none")) {
                thText = $(this).text().trim();
                $("#userBonTableColumnFilter > option").each(function () {
                    if ($(this).val() === thText) {
                        $(this).prop("selected", true);
                    }
                });
            }
        });

        $(document).on("click", "#orderSpecialFilterEnable", function () {
            if ($("#orderProduct option:selected").length === 0) {
                alert("لطفا ابتدا محصولی را انتخاب کنید");
                $(this).attr('checked', false);
            }
        });

        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
            // $("#loadingAjax").click();
        @permission((config('constants.LIST_ORDER_ACCESS')));
//            $("#order-portlet .reload").trigger("click");
            var newDataTable = $("#order_table").DataTable();
            newDataTable.destroy();
            makeDataTable("order_table");
            $("#order-expand").trigger("click");
            $("#order_table > tbody .dataTables_empty").text("برای نمایش اطلاعات ابتدا فیلتر کنید").addClass("font-red bold");
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