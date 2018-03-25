@role((Config::get("constants.ROLE_ADMIN")))
@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")
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
                <span>پنل مدیریت قرعه کشی</span>
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

            @role((Config::get("constants.ROLE_ADMIN")))
            <!-- BEGIN ROLE TABLE PORTLET-->
            <div class="portlet box blue-dark" id="lottery-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>برندگان قرعه کشی همایش 1 + 5</div>
                    <div class="tools">
                        <img class="hidden" id="lottery-portlet-loading" src="{{Config::get('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading"  style="width: 50px;">
                        <a href="javascript:;" class="collapse" id="lottery-expand"> </a>
                        <a href="javascript:;" class="reload"> </a>
                        <a href="javascript:;" class="remove"> </a>
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body" style="display: block;">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    @if(isset($userlotteries) && $userlotteries->isEmpty())
                                        <a href="{{action("LotteryController@doLottery")}}" class="btn btn-outline blue-dark" target="_blank">
                                             برگزاری قرعه کشی </a>
                                    @endif
                                        {{--<a href="{{action("LotteryController@givePrizes")}}" class="btn btn-outline red" target="_blank">--}}
                                            {{--اهدای جوایز </a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="lottery_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> رتبه برنده </th>
                            <th class="all"> نام </th>
                            <th class="all"> موبایل </th>
                            <th class="all"> جایزه </th>
                        </tr>
                        </thead>
                        <tbody>
                         @foreach($userlotteries as $userlottery)
                             <tr>
                                 <td></td>
                                 <td>{{$userlottery->pivot->rank}}</td>
                                 <td><a href="{{action("UserController@edit", $userlottery)}}" target="_blank">{{$userlottery->getfullName()}}</a></td>
                                 <td>{{$userlottery->mobile}}</td>
                                 <td>@foreach(json_decode($userlottery->pivot->prizes)->items as $item )
                                         <p class="text-center bold">{{$item->name}}</p>
                                     @endforeach
                                 </td>
                             </tr>
                         @endforeach
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
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/lib/persian-date.js" type="text/javascript" ></script>
@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/ui-extended-modals.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/assets/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript" ></script>

    <script src="/assets/pages/scripts/components-bootstrap-multiselect.min.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>

    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function() {
            @role((Config::get("constants.ROLE_ADMIN")))
            var newDataTable =$("#lottery_table").DataTable();
            newDataTable.destroy();
            makeDataTable("lottery_table");
            $("#lottery-expand").trigger("click");
            @endrole
        });
    </script>
@endsection
@endrole