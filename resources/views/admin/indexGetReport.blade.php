@permission((Config::get('constants.REPORT_ADMIN_PANEL_ACCESS')))
@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")
    {{--<link href="/assets/extra/persian-datepicker/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>--}}
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css" />
    <link href="/assets/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet" type="text/css"/>

    <link href="/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
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
                <span>پنل گزارش گیری</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        {{--Ajax modal loaded after inserting content--}}
        <div id="ajax-modal" class="modal fade" tabindex="-1"> </div>
    {{--Ajax modal for panel startup --}}

    <!-- /.modal -->
        <div class="col-md-12">

            {{--<div class="note note-info">--}}
            {{--<h4 class="block"><strong>توجه!</strong></h4>--}}
            {{--  @role((Config::get("constants.ROLE_ADMIN")))<p>ادمین محترم‌، مستحضر باشید که لیست سفارشات جدا شده است. همچنین تعداد بن افزوده و درصد تخفیف بن برای هر محصول به جدول محصولات افزوده شده است و در اصلاح محصول امکان ویرایش این دو وجود دارد.</p>@endrole--}}
            {{--<strong class="font-red">لطفا کش مرورگر خود را خالی کنید!</strong>--}}
            {{--</div>--}}

            @permission((Config::get('constants.GET_USER_REPORT')))
            <!-- BEGIN USER TABLE PORTLET-->
            <div class="portlet box purple" id="report-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>گزارش </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" id="report-expand"> </a>
                        {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                        <a href="javascript:;" class="reload"> </a>
                        <a href="javascript:;" class="remove"> </a>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body" style="display: block;">
                    <div class="portlet box blue" >
                        <style>
                            .form .form-row-seperated .form-group{
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form " style="border-top: #3598dc solid 1px" >
                            {!! Form::open(['action' => 'UserController@index' ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterReportForm']) !!}
                            <div class="form-body" style="background: #e7ecf1">
                                    @include("admin.filters.userFilterPack")
                                <div class="form-group">
                                    @include('admin.filters.sort')
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <input type="text" name="minCost" class="form-control filter"  placeholder="حداقل قیمت">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label" style="float:right"><label class="mt-checkbox mt-checkbox-outline">
                                                <input type="checkbox" id="userReportLotteryCheckbox" value="1" name="lotteryEnable" >قرعه کشی:
                                                <span class="bg-grey-cararra"></span>
                                            </label>
                                        </label>
                                        <div class="col-md-3">
                                            {!! Form::select('lotteries',$lotteries,null,['class' => 'form-control' , 'id'=>'userReportLottery' , 'disabled' ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12">
                                        <a href="javascript:;" class="btn btn-lg bg-font-dark reload" id="filter" style="background: #489fff">فیلتر</a>
                                        <img class="hidden" id="report-portlet-loading" src="{{Config::get("constants.FILTER_LOADING_GIF")}}" alt="loading" width="5%" >
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

                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Table is bieng added through JQuety--}}
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission

            @permission((Config::get('constants.GET_BOOK_SELL_REPORT')))
            <!-- BEGIN USER TABLE PORTLET-->
            <div class="portlet box dark" id="bookSellingReport-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>گزارش فروش کتاب ها </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" id="bookSellingReport-expand"> </a>
                        {{--<a href="#portlet-config" data-toggle="modal" class="config"> </a>--}}
                        <a href="javascript:;" class="reload"> </a>
                        <a href="javascript:;" class="remove"> </a>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body" style="display: block;">
                    <div class="portlet box blue" >
                        <style>
                            .form .form-row-seperated .form-group{
                                border-bottom-color: #bfbfbf !important;
                            }
                        </style>
                        <div class="portlet-body form " style="border-top: #3598dc solid 1px" >
                            {!! Form::open(['action' => 'UserController@index' ,'class'=>'form-horizontal form-row-seperated' , 'id' => 'filterBookSellingReportForm']) !!}
                            <input name="reportType" type="hidden" value="bookSelling">
                            <div class="form-body" style="background: #e7ecf1">
                                <div class="form-group">
                                    <div class="row" >
                                        <div class="col-lg-6 col-md-6">
                                            @include('admin.filters.productsFilter' , ["products"=>$bookProducts ,"everyProduct"=>0, "name" => "orderProducts[]" , "withCheckbox"   => 0 ,
                                                    "enableName" => "orderProductEnable" , "enableId"=>"bookProductEnable", "description" => 1 , "id" => "bookProducts" , "withoutOrder" => 0])
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 2%">
                                        <div class="col-md-12">
                                            <div class="col-lg-6 col-md-6">
                                                @include('admin.filters.orderstatusFilter')
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                @include('admin.filters.paymentstatusFilter')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 col-md-2 bold control-label">تاریخ ثبت نهایی سفارش : </label>
                                    <div class="col-lg-10 col-md-10">
                                        @include('admin.filters.timeFilter.completedAt' , ["id" => "book"])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12">
                                        <a href="javascript:;" class="btn btn-lg bg-font-dark reload" id="filter" style="background: #489fff">فیلتر</a>
                                        @permission((Config::get('constants.SEE_PAID_COST')))
                                            <label class="control-label">
                                                <label class="mt-checkbox mt-checkbox-outline">نمایش قیمت
                                                    <input type="checkbox"  value="1" name="seePaidCost" >
                                                    <span class="bg-grey-cararra"></span>
                                                </label>
                                            </label>
                                        @endpermission
                                        <img class="hidden" id="bookSellingReport-portlet-loading" src="{{Config::get("constants.FILTER_LOADING_GIF")}}" alt="loading" width="5%" >
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div id="report_div">

                    </div>
                    {{--Table is bieng added through JQuety--}}
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
            @endpermission
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    {{--<script src="/assets/extra/persian-datepicker/lib/bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>--}}
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/lib/persian-date.js" type="text/javascript" ></script>

    {{--<script src="../assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js" type="text/javascript"></script>--}}
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript" ></script>

    <script src="/assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/admin-indexReport.js" type="text/javascript"></script>
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>
    <script src="/js/extraJS/scripts/admin-makeMultiSelect.js" type="text/javascript"></script>

    <script type="text/javascript">
        //should run at first
        $("#report_table thead tr th").each(function() {
            if(!$(this).hasClass("none")){
                thText = $(this).text().trim();
                $("#reportTableColumnFilter > option").each(function () {
                    if($(this).val() === thText){
                        $(this).prop("selected" , true);
                    }
                });
            }
        });

        /**
         * Start up jquery
         */
        jQuery(document).ready(function() {
            @permission((Config::get('constants.GET_USER_REPORT')))
                $("#report-portlet > .portlet-body").append(reportTable) ;
                var newDataTable =$("#report_table").DataTable();
                newDataTable.destroy();
                makeDataTable("report_table" );
                $("#report-expand").trigger("click");
                $("#report_table > tbody .dataTables_empty").text("برای نمایش اطلاعات ابتدا فیلتر کنید").addClass("font-red bold");
                $('#report_role').multiSelect();
            @endpermission

            @permission((Config::get('constants.GET_BOOK_SELL_REPORT')))
                $("#bookSellingReport-expand").trigger("click");
                $("#report_div").text("برای نمایش اطلاعات ابتدا فیلتر کنید");
            @endpermission
        });
    </script>
@endsection
@endpermission