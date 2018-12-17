@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet"
          type="text/css"/>
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <i class="fa fa-cogs"></i>
                <a href="{{action("HomeController@adminOrder")}}">مدیریت سفارش ها</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>تراکنش های ثبت نشده</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN USER TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>تراکنش های موفق ثبت نشده
                    </div>
                </div>
                <div class="portlet-body" style="display: block;">
                    <div class="table-toolbar">
                        <div class="btn-group"></div>
                    </div>

                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                           id="user_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="all"> نام مشتری</th>
                            <th class="all"> موبایل مشتری</th>
                            <th class="min-tablet"> Authority</th>
                            <th class="min-tablet"> مبلغ</th>
                            <th class="min-tablet"> تاریخ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $transactions as $transaction)
                            <tr>
                                <th></th>
                                <td>
                                    @if(strlen($transaction["firstName"])>0 || strlen($transaction["lastName"])>0)
                                        <a target="_blank"
                                           href="{{action("UserController@edit" , (isset($transaction["userId"]))?$transaction["userId"]:0 )}}">
                                            {{$transaction["firstName"]}} {{$transaction["lastName"]}}
                                        </a>
                                    @else
                                        <span class="label label-sm label-danger"> ناشناس </span>
                                    @endif
                                </td>
                                <td>
                                    @if(strlen($transaction["mobile"])>0)
                                        {{$transaction["mobile"]}}
                                    @else
                                        <span class="label label-sm label-danger"> نامشخص </span>
                                    @endif
                                </td>
                                <td>
                                    @if(strlen($transaction["authority"])>0)
                                        {{$transaction["authority"]}}
                                    @else
                                        <span class="label label-sm label-danger"> نامشخص </span>
                                    @endif
                                </td>
                                <td>
                                    @if(strlen($transaction["amount"])>0)
                                        {{$transaction["amount"]}}
                                    @else
                                        <span class="label label-sm label-danger"> نامشخص </span>
                                    @endif
                                </td>
                                <td dir="ltr">
                                    @if(strlen($transaction["created_at"])>0)
                                        {{$transaction["created_at"]}}
                                    @else
                                        <span class="label label-sm label-danger"> نامشخص </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if(isset($error))
                            <tr>
                                <td colspan="5" class="font-red bold text-center">خطا در برقراری ارتباط با سرویس دهنده
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>
    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
            var newDataTable = $("#user_table").DataTable();
            newDataTable.destroy();
            makeDataTable("user_table");
        });
    </script>
@endsection
