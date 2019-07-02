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
        <div class="col">
            
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
    
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                
                
                                <div class="m-divider m--margin-top-50">
                                    <span></span>
                                    <span>انتخاب محصول</span>
                                    <span></span>
                                </div>
                                <select class="mt-multiselect btn btn-default a--full-width"
                                        {{--                                                multiple="multiple"--}}
                                        data-label="left"
                                        data-width="100%"
                                        data-filter="true"
                                        data-height="200"
                                        id="productId"
                                        name="productId"
                                        title="انتخاب دسته">
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}"
                                                class="bold">
                                            #{{$product->id}}-{{$product->name}}
                                        </option>
                                    @endforeach
                                </select>
            
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 bold control-label">فیلتر تاریخ: </label>
                            <div class="col-md-10">
                                @include('admin.filters.timeFilter.createdAt' , ["id" => "dateFilter"])
                            </div>
                        </div>
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <div class="row">--}}
{{--                                <label class = "control-label" style = "float: right;">--}}
{{--                                    <label class = "mt-checkbox mt-checkbox-outline">--}}
{{--                                        @include("admin.filters.checkoutStatusFilter" , ["dropdownId"=>"checkoutStatus" , "checkboxId"=>"checkoutStatusEnable"])--}}
{{--                                        <span class = "bg-grey-cararra"></span>--}}
{{--                                    </label>--}}
{{--                                </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="form-group">
                        <div class="row">
                                <label class = "control-label" style = "float: right;">
                                    <label class = "mt-checkbox mt-checkbox-outline">
                                        فیلتر شده ها را تسویه حساب کن
                                        <input type = "checkbox" id = "checkoutEnable" value = "1" name = "checkoutEnable">
                                        <span class = "bg-grey-cararra"></span>
                                    </label>
                                </label>
                        </div>
                    </div>

                    <button type="button" class="btn m-btn--pill m-btn--air btn-info btnFilter">فیلتر</button>
                    
                    <div class="reportOfFilter">
                        <span class="m-badge m-badge--info m-badge--wide m-badge--rounded report1">
                        
                        </span>
                        <br>
                        <span class="report2">
                        
                        </span>
                        <br>
                        <span class="report3">

                        </span>
                    </div>
                    
                </div>
            </div>
            @endpermission
        
        </div>
    </div>
@endsection

@section('page-js')
    
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    
    {{--<script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-extended-modals.min.js" type="text/javascript"></script>--}}
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/ui-toastr.min.js" type="text/javascript"></script>
{{--    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type="text/javascript"></script>--}}
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
    
    <script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-customInitComponent.js" type="text/javascript"></script>
    
    
    <script type="text/javascript">
        var ajaxActionUrl = '{{ $ajaxActionUrl }}';
        /**
         * Start up jquery
         */
        $(document).ready(function () {

            CustomInit.persianDatepicker('#dateFilterCreatedSince', '#dateFilterCreatedSinceAlt', true);
            CustomInit.persianDatepicker('#dateFilterCreatedTill', '#dateFilterCreatedTillAlt', true);
            
            $('.reportOfFilter').fadeOut();
            $('.report1').html('');
            $('.report2').html('');
            
            $(document).on('click', '.btnFilter', function(){


                $('.reportOfFilter').fadeOut();
                $('.report1').html('');
                $('.report2').html('');
                
                mApp.block('.btnFilter', {
                    type: "loader",
                    state: "success",
                });

                var dateFilterEnable = 0;
                if($('#dateFilterCreatedTimeEnable').is(':checked')){
                    dateFilterEnable = 1;
                }

                var checkoutEnable = 0;
                if($('#checkoutEnable').is(':checked')){
                    checkoutEnable = 1;
                }

                $.ajax({
                    url: ajaxActionUrl,
                    type: 'POST',
                    data: {
                        product_id: $('#productId').val(),
                        since: $('#dateFilterCreatedSinceAlt').val(),
                        till: $('#dateFilterCreatedTillAlt').val(),
                        dateFilterEnable: dateFilterEnable,
                        checkoutEnable : checkoutEnable,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.totalNumber != null && data.totalNumber != undefined) {

                            $('.reportOfFilter').fadeIn();
                            $('.report1').html('تعداد کل: ' + data.totalNumber);
                            $('.report2').html('فروش کل(تومان): ' + data.totalSale);

                            if(data.checkoutResult == null || data.checkoutResult== undefined )
                            {
                                $('.report3').html('وضعیت تسویه نامشخص');
                            }
                            else if(data.checkoutResult)
                            {
                                $('.report3').html('تسویه با موفقیت انجام شد');
                            }else{
                                $('.report3').html('تسویه ای انجام نشد');
                            }

                        } else {

                            toastr.error('خطای سیستمی رخ داده است.');
                        }
                        mApp.unblock('.btnFilter');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                        let message = '';
                        if (jqXHR.responseJSON.message === 'The given data was invalid.') {
                            message = getErrorMessage(jqXHR.responseJSON.errors);
                        } else {
                            message = 'خطای سیستمی رخ داده است.';
                        }

                        toastr.warning(message);
                        
                        mApp.unblock('.btnFilter');
                    }
                });

                
                
            });

            $(document).on('click', '#dateFilterCreatedTimeEnable', function(){
                if($('#dateFilterCreatedTimeEnable').is(':checked'))
                {
                    $('#dateFilterCreatedSince').enable();
                    $('#dateFilterCreatedTill').enable();
                }else{
                    $('#dateFilterCreatedSince').enable(false);
                    $('#dateFilterCreatedTill').enable(false);
                }
            });
        });
    </script>

@endsection
@endability
