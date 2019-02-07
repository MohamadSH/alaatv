@permission((Config::get('constants.SHOW_COUPON_ACCESS')))
@extends("app",["pageName"=>"admin"])

@section("headPageLevelPlugin")
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.css" rel="stylesheet"
          type="text/css"/>
@endsection
@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("IndexPageController")}}">@lang('page.Home')</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <a href="{{action("HomeController@adminProduct")}}">پنل مدیریتی محصولات</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>اصلاح اطلاعات کپن</span>
            </li>
        </ul>
    </div>
@endsection

@section("content")
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 ">
        @include("systemMessage.flash")
        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">اصلاح اطلاعات کپن {{$coupon->name}}</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm dark dropdown-toggle" href="{{action("HomeController@adminProduct")}}">
                                بازگشت
                                <i class="fa fa-angle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::model($coupon,['method' => 'PUT','action' => ['CouponController@update',$coupon], 'class'=>'form-horizontal']) !!}
                    @include('coupon.form')
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->

        </div>
    </div>

@endsection

@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>

@endsection

@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js"
            type="text/javascript"></script>
@endsection
@section("extraJS")
    <script src="/js/extraJS/admin-coupon.js" type="text/javascript"></script>

    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
            /*
             validdSince
             */
            $("#couponValidSince").persianDatepicker({
                altField: '#couponValidSinceAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });

            /*
             validUntil
             */
            $("#couponValidUntil").persianDatepicker({
                altField: '#couponValidUntilAlt',
                altFormat: "YYYY MM DD",
                observer: true,
                format: 'YYYY/MM/DD',
                altFieldFormatter: function (unixDate) {
                    var d = new Date(unixDate).toISOString();
                    return d;
                }
            });
        });

        $('#couponValidSinceEnable').change(function () {
            if ($(this).prop('checked') === true) {
                $('#couponValidSince').attr('disabled', false);
                $('#couponValidSinceTime').attr('disabled', false);
            }
            else {
                $('#couponValidSince').attr('disabled', true);
                $('#couponValidSinceTime').attr('disabled', true);
            }
        });

        $('#couponValidUntilEnable').change(function () {
            if ($(this).prop('checked') === true) {
                $('#couponValidUntil').attr('disabled', false);
                $('#couponValidUntilTime').attr('disabled', false);
            }
            else {
                $('#couponValidUntil').attr('disabled', true);
                $('#couponValidUntilTime').attr('disabled', true);
            }
        });

    </script>

@endsection
@endpermission