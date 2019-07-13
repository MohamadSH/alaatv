@permission((config('constants.REPORT_ADMIN_PANEL_ACCESS')))

@extends('app',['pageName'=>$pageName])

@section('page-css')
    <link href="{{ mix('/css/admin-all.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">پنل گزارش گیری</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class = "row">
        <div class = "col">

            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--  @role((config("constants.ROLE_ADMIN")))<p>ادمین محترم‌، مستحضر باشید که لیست سفارشات جدا شده است. همچنین تعداد بن افزوده و درصد تخفیف بن برای هر محصول به جدول محصولات افزوده شده است و در اصلاح محصول امکان ویرایش این دو وجود دارد.</p>@endrole--}}
            {{--<strong class="m--font-danger">لطفا کش مرورگر خود را خالی کنید!</strong>--}}
            {{--</div>--}}

            @permission((config('constants.GET_USER_REPORT')))
            <!-- BEGIN USER TABLE PORTLET-->
            <div class = "m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet = "true" id = "report-portlet">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <span class = "m-portlet__head-icon">
                                <i class = "fa fa-cogs"></i>
                            </span>
                            <h3 class = "m-portlet__head-text">
                                گزارش
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <ul class = "m-portlet__nav">
                            <li class = "m-portlet__nav-item">
                                <a href = "#" m-portlet-tool = "reload" class = "m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class = "la la-refresh"></i>
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "#" m-portlet-tool = "toggle" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class = "la la-angle-down"></i>
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "#" m-portlet-tool = "fullscreen" class = "m-portlet__nav-link m-portlet__nav-link--icon" id = "report-expand">
                                    <i class = "la la-expand"></i>
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "#" m-portlet-tool = "remove" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class = "la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    <div class = "portlet box blue">
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class = "portlet-body" style = "border-top: #3598dc solid 1px">
                            {!! Form::open(['action' => 'Web\UserController@index' ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterReportForm']) !!}
                            <div class = "form-body form m--padding-15" style = "background: #e7ecf1">
                                @include("admin.filters.userFilterPack")
                                <div class = "form-group">
                                    @include('admin.filters.sort')
                                </div>
                                <div class = "form-group">
                                    <div class = "row">
                                        <div class = "col-md-3">
                                            <input type = "text" name = "minCost" class = "form-control filter" placeholder = "حداقل قیمت">
                                        </div>
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <div class = "row">
                                        <label class = "control-label" style = "float:right">
                                            <label class = "mt-checkbox mt-checkbox-outline">
                                                <input type = "checkbox" id = "userReportLotteryCheckbox" value = "1" name = "lotteryEnable">
                                                قرعه کشی:
                                                <span class = "bg-grey-cararra"></span>
                                            </label>
                                        </label>
                                        <div class = "col-md-3">
                                            {!! Form::select('lotteries',$lotteries,null,['class' => 'form-control a--full-width' , 'id'=>'userReportLottery' , 'disabled' ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <div>
                                        <a href = "javascript:" class = "btn m-btn--pill m-btn--air btn-info btn-lg reload" id = "filter" style = "background: #489fff">فیلتر</a>
                                        <img class = "d-none" id = "report-portlet-loading" src = "{{config("constants.FILTER_LOADING_GIF")}}" alt = "loading" width = "5%">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class = "table-toolbar">
                        <div class = "row">
                            <div class = "col-md-6">
                                <div class = "btn-group">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->@endpermission

            @permission((config('constants.GET_BOOK_SELL_REPORT')))
            <!-- BEGIN USER TABLE PORTLET-->
            <div class = "m-portlet m-portlet--head-solid-bg m-portlet--primary m-portlet--collapsed m-portlet--head-sm" m-portlet = "true" id = "bookSellingReport-portlet">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <span class = "m-portlet__head-icon">
                                <i class = "fa fa-cogs"></i>
                            </span>
                            <h3 class = "m-portlet__head-text">
                                گزارش فروش کتاب ها
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <ul class = "m-portlet__nav">
                            <li class = "m-portlet__nav-item">
                                <a href = "#" m-portlet-tool = "reload" class = "m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class = "la la-refresh"></i>
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "#" m-portlet-tool = "toggle" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class = "la la-angle-down"></i>
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "#" m-portlet-tool = "fullscreen" class = "m-portlet__nav-link m-portlet__nav-link--icon" id = "bookSellingReport-expand">
                                    <i class = "la la-expand"></i>
                                </a>
                            </li>
                            <li class = "m-portlet__nav-item">
                                <a href = "#" m-portlet-tool = "remove" class = "m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class = "la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    <div class = "portlet box blue">
                        <style>
                            .form .form-row-seperated .form-group {
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class = "portlet-body form" style = "border-top: #3598dc solid 1px">
                            {!! Form::open(['action' => 'Web\UserController@index' ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterBookSellingReportForm']) !!}
                            <input name = "reportType" type = "hidden" value = "bookSelling">
                            <div class = "form-body m--padding-15" style = "background: #e7ecf1">
                                <div class = "form-group">
                                    <div class = "row">
                                        <div class = "col-lg-6 col-md-6">
                                            @include('admin.filters.productsFilter' , ["products"=>$bookProducts ,"everyProduct"=>0, "name" => "orderProducts[]" , "withCheckbox"   => 0 ,
                                                    "enableName" => "orderProductEnable" , "enableId"=>"bookProductEnable", "description" => 1 , "id" => "bookProducts" , "withoutOrder" => 0])
                                        </div>
                                    </div>
                                    <div class = "row" style = "margin-top: 2%">
                                        <div class = "col-lg-6 col-md-6">
                                            @include('admin.filters.orderstatusFilter')
                                        </div>
                                        <div class = "col-lg-6 col-md-6">
                                            @include('admin.filters.paymentstatusFilter')
                                        </div>
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <div class = "row">
                                        <label class = "col-lg-2 col-md-2 bold control-label">تاریخ ثبت نهایی سفارش :</label>
                                        <div class = "col-lg-10 col-md-10">
                                            @include('admin.filters.timeFilter.completedAt' , ["id" => "book"])
                                        </div>
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <div>
                                        <a href = "javascript:" class = "btn m-btn--pill m-btn--air btn-info btn-lg reload" id = "filter" style = "background: #489fff">فیلتر</a>
                                        @permission((config('constants.SEE_PAID_COST')))
                                        <label class = "control-label">
                                            <label class = "mt-checkbox mt-checkbox-outline">نمایش قیمت
                                                <input type = "checkbox" value = "1" name = "seePaidCost">
                                                <span class = "bg-grey-cararra"></span>
                                            </label>
                                        </label>
                                        @endpermission
                                        <img class = "d-none" id = "bookSellingReport-portlet-loading" src = "{{config("constants.FILTER_LOADING_GIF")}}" alt = "loading" width = "5%">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div id = "report_div"></div>
                    {{--Table is bieng added through JQuety--}}
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->@endpermission

        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ mix('/js/admin-all.js') }}" type="text/javascript"></script>
    <script src = "{{ asset('/acm/AlaatvCustomFiles/js/admin/page-report.js') }}" type = "text/javascript"></script>

    <script type = "text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
        @permission((config('constants.GET_USER_REPORT')));
            $("#report-portlet > .portlet-body").append(reportTable);
            var newDataTable = $("#report_table").DataTable();
            newDataTable.destroy();
            makeDataTable("report_table");
            $("#report-expand").trigger("click");
            $("#report_table > tbody .dataTables_empty").text("برای نمایش اطلاعات ابتدا فیلتر کنید").addClass("m--font-danger bold");
            $('#report_role').multiSelect();
        @endpermission;

        @permission((config('constants.GET_BOOK_SELL_REPORT')));
            $("#bookSellingReport-expand").trigger("click");
            $("#report_div").text("برای نمایش اطلاعات ابتدا فیلتر کنید");
        @endpermission
        });
    </script>
@endsection

@endpermission