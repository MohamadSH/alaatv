@permission((Config::get('constants.SHOW_ORDER_ACCESS')))@extends('app',['pageName'=>'admin'])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/datatables.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-modal/css/bootstrap-modal.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-toastr/toastr-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/icheck/skins/all.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/css/select2.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/css/select2-bootstrap.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/font/glyphicons-halflings/glyphicons-halflings.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home m--padding-right-5"></i>
                <a class = "m-link" href = "{{route('web.index')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item" aria-current = "page">
                <a class = "m-link" href = "{{action("Web\AdminController@adminOrder")}}">پنل مدیریتی</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">اصلاح محصول سفارش</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    @include("systemMessage.flash")

    <div class = "row">
        <div class = "col">

            @if (Session::has('userBonError'))
                <div class = "custom-alerts alert alert-danger fade in margin-top-10">
                    <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true"></button>
                    <i class = "fa fa-times-circle"></i>
                    {{ Session::pull('userBonError') }}
                </div>
        @endif
        <!-- BEGIN SAMPLE FORM PORTLET-->

            <div class = "m-portlet m-portlet--mobile m-portlet--body-progress-">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text">
                                اصلاح محصول سفارش
                                @if(!isset($orderproduct->order->user->firstName) && !isset($orderproduct->order->user->lastName))
                                کاربر ناشناس
                                @else
                                    @if(isset($orderproduct->order->user->firstName))
                                        {{$orderproduct->order->user->firstName}}
                                    @endif
                                    @if(isset($orderproduct->order->user->lastName))
                                        {{$orderproduct->order->user->lastName}}
                                    @endif
                                @endif
                            </h3>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                        <a class = "btn m-btn--air btn-primary" href = "{{action("Web\OrderController@edit" , $orderproduct->order)}}"> بازگشت
                            <i class = "fa fa-angle-left"></i>
                        </a>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    {!! Form::model($orderproduct,['files'=>true,'method' => 'PUT','action' => ['Web\OrderproductController@update',$orderproduct], 'class'=>'form-horizontal']) !!}
                    <div class = "row">
                        <div class = "col-12">
                            @include('order.orderproduct.form' )
                            <hr>
                        </div>
                        <div class = "col-12">
                            <h4 class = "bold " style = "padding-bottom: 2%">
                                <i class = "fa fa-plus-square-o" aria-hidden = "true"></i>
                                افزودن خدمات
                            </h4>
                            <div class = "col-md-6" style = "border-left: #eeeeef solid 1px;">
                                <h4 class = "bold" style = "text-decoration: underline">
                                    صفمت های checkbox
                                </h4>
                                @include("product.partials.extraCheckboxCollection" , ["withExtraCost" => true])
                            </div>
                            <div class = "col-md-6">
                                <h4 class = "bold" style = "text-decoration: underline">
                                    صفمت های drop down
                                </h4>
                                @include("product.partials.extraSelectCollection", ["withExtraCost" => true])
                            </div>
                        </div>
                        <hr>
                        <div class = "col-12 text-center">
                            {!! Form::submit('اصلاح', ['class' => 'btn m-btn--air btn-success']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>

@endsection

@section('page-js')
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/icheck/icheck.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/makeSelect2Single.js" type = "text/javascript"></script>
    <script type = "text/javascript">
        jQuery(document).ready(function () {
            $('.selectExtraAttribute').each(function () {
                var extraCostId = "extraCost_" + $(this).attr("id").split('_')[1];
                $("#" + extraCostId).attr("name", "extraCost[" + $(this).val() + "]");
            });
        });

        $(document).on("change", ".selectExtraAttribute", function () {
            var extraCostId = "extraCost_" + $(this).attr("id").split('_')[1];
            $("#" + extraCostId).attr("name", "extraCost[" + $(this).val() + "]");
        });

        $(document).on("click", "#changeProduct", function () {
            if ($('#changeProduct').prop('checked') == true) {
                $('.newProductSelect').prop('disabled', false);
            } else {
                $('.newProductSelect').prop('disabled', true);
            }
        });

        $(document).on("click", "#changeCost", function () {
            if ($('#changeCost').prop('checked') == true) {
                $('#cost').attr('disabled', false);
            } else {
                $('#cost').attr('disabled', true);
            }
        });

        $(document).on("change", "#newProductSelect", function () {
            var cost = $(this).find("option:selected").data("content");
            $("#newProductCostInput").val(cost);
            $("#newProductCostLabel").text(cost);
        });
    </script>
@endsection
@endpermission
