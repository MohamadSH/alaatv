@permission((Config::get('constants.SHOW_ORDER_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet"
          type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section("metadata")
    <meta name="_token" content="{{ csrf_token() }}">
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
                <a href="{{action("HomeController@adminOrder")}}">پنل مدیریتی</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح محصول سفارش</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    @include("systemMessage.flash")
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('userBonError'))
                <div class="custom-alerts alert alert-danger fade in margin-top-10">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <i class="fa fa-times-circle"></i>
                    {{ Session::pull('userBonError') }}
                </div>
        @endif
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase"> اصلاح محصول سفارش @if(!isset($orderproduct->order->user->firstName) && !isset($orderproduct->order->user->lastName))
                                کاربر
                                ناشناس @else @if(isset($orderproduct->order->user->firstName)){{$orderproduct->order->user->firstName}} @endif @if(isset($orderproduct->order->user->lastName)) {{$orderproduct->order->user->lastName}} @endif @endif</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm dark dropdown-toggle"
                               href="{{action("OrderController@edit" , $orderproduct->order)}}"> بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($orderproduct,['files'=>true,'method' => 'PUT','action' => ['OrderproductController@update',$orderproduct], 'class'=>'form-horizontal']) !!}
                    <div class="row">
                        <div class="col-md-12">
                            @include('order.orderproduct.form' )
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <h4 class="bold " style="padding-bottom: 2%"><i class="fa fa-plus-square-o"
                                                                            aria-hidden="true"></i> افزودن خدمات</h4>
                            <div class="col-md-6" style="border-left: #eeeeef solid 1px;">
                                <h4 class="bold" style="text-decoration: underline">صفمت های checkbox</h4>
                                @include("product.partials.extraCheckboxCollection" , ["withExtraCost" => true])
                            </div>
                            <div class="col-md-6">
                                <h4 class="bold" style="text-decoration: underline">صفمت های drop down</h4>
                                @include("product.partials.extraSelectCollection", ["withExtraCost" => true])
                            </div>
                        </div>
                        <hr class="col-md-12">
                        <div class="col-md-12 text-center">
                            {!! Form::submit('اصلاح', ['class' => 'btn green-soft']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
    <!-- END SAMPLE FORM PORTLET-->

    </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/js/extraJS/scripts/makeSelect2Single.js" type="text/javascript"></script>
@endsection
@section("extraJS")
    <script type="text/javascript">
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
            }
            else {
                $('.newProductSelect').prop('disabled', true);
            }
        });

        $(document).on("click", "#changeCost", function () {
            if ($('#changeCost').prop('checked') == true) {
                $('#cost').attr('disabled', false);
            }
            else {
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