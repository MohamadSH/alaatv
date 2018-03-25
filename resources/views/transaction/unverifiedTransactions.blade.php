@extends("app",["pageName"=>$pageName])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css" />
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
            <div class="portlet box green" >
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>تراکنش های موفق ثبت نشده </div>
                </div>
                <div class="portlet-body" style="display: block;">
                    <div class="table-toolbar"><div class="btn-group"></div></div>

                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="user_table">
                        <thead>
                        <tr>
                            <th class="all"> نام مشتری </th>
                            <th class="all"> موبایل مشتری </th>
                            <th class="all"> Authority </th>
                            <th class="all"> مبلغ </th>
                            <th class="all"> تاریخ </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($transactions))
                            @foreach( $transactions as $transaction)
                                <tr >
                                    <td>@if(isset(\App\Transaction::all()->where("authority",$transaction->Authority)->first()->order->user->firstName)  || isset(\App\Transaction::all()->where("authority",$transaction->Authority)->first()->order->user->lastName)) @if(isset(\App\Transaction::all()->where("authority",$transaction->Authority)->first()->order->user->firstName)) {{ \App\Transaction::all()->where("authority",$transaction->Authority)->first()->order->user->firstName}} @endif @if(isset(\App\Transaction::all()->where("authority",$transaction->Authority)->first()->order->user->lastName) ) {{\App\Transaction::all()->where("authority",$transaction->Authority)->first()->order->user->lastName}} @endif @else <span class="label label-sm label-danger">یافت نشد </span> @endif</td>
                                    <td>@if(isset(\App\Transaction::all()->where("authority",$transaction->Authority)->first()->order->user->mobile) )  {{ \App\Transaction::all()->where("authority",$transaction->Authority)->first()->order->user->mobile}} @else <span class="label label-sm label-danger">یافت نشد </span> @endif</td>
                                    <td>@if(isset($transaction->Authority) )  {{ $transaction->Authority}} @else <span class="label label-sm label-danger"> ندارد </span> @endif</td>
                                    <td>@if(isset($transaction->Amount) )  {{ number_format($transaction->Amount)}} @else <span class="label label-sm label-danger"> ندارد </span> @endif</td>
                                    <td>@if(isset(\App\Transaction::all()->where("authority",$transaction->Authority)->first()->created_at) )  {{ \App\Transaction::all()->where("authority",$transaction->Authority)->first()->CreatedAt_Jalali()}} @else <span class="label label-sm label-warning"> یافت نشد </span> @endif</td>
                                </tr>
                            @endforeach
                        @elseif(isset($error))
                            <tr><td colspan="5" class="font-red bold text-center">خطا در برقراری ارتباط با سرویس دهنده</td></tr>
                        @else
                            <tr><td colspan="5" class="font-green bold text-center">تراکنشی یافت نشد</td></tr>
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
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
@endsection

@section("extraJS")
    <script src="/js/extraJS/scripts/admin-makeDataTable.js" type="text/javascript"></script>
    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function() {
            var newDataTable =$("#user_table").DataTable();
            newDataTable.destroy();
            makeDataTable("user_table");
        });
    </script>
@endsection
