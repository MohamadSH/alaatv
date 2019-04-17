@extends('app' , ['pageName'=> $pageName])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "#">مدیریت سفارش ها</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">تراکنش های ثبت نشده</a>
            </li>
        </ol>
    </nav>
@endsection

@section("content")
    <div class="row">
        <div class="col">


            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                تراکنش های موفق ثبت نشده
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

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
                                        <a target="_blank" href = "{{action("Web\UserController@edit" , (isset($transaction["userId"]))?$transaction["userId"]:0 )}}">
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

        </div>
    </div>
@endsection

@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/datatable.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/app.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-makeDataTable.js" type="text/javascript"></script>
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
