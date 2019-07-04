@extends('app' , ['pageName' => 'profile'])

@section('page-css')
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel="stylesheet" type="text/css"/>
    <link href="/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel="stylesheet" type="text/css"/>

    <link href="{{ mix('/css/user-profile-salesReport.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .m-portlet.m-portlet--creative .m-portlet__head-label {
            white-space: nowrap;
        }
        .m-portlet.m-portlet--accent.m-portlet--head-solid-bg .m-portlet.m-portlet--creative .m-portlet__head,
        .m-portlet.m-portlet--info.m-portlet--head-solid-bg .m-portlet.m-portlet--creative .m-portlet__head {
            background-color: white;
            border-color: white;
        }
        .m-portlet.m-portlet--accent.m-portlet--head-solid-bg .m-portlet.m-portlet--creative .m-portlet__head .m-portlet__head-text,
        .m-portlet.m-portlet--info.m-portlet--head-solid-bg .m-portlet.m-portlet--creative .m-portlet__head .m-portlet__head-text {
            color: #575962;
        }
        
        .highcharts-container , .highcharts-container * {
            font-family: IRANSans;
        }
        .highcharts-label.highcharts-tooltip {
            text-align: right;
        }
        .highcharts-anchor {
            display: none;
        }
        
        .highcharts-data-label .highcharts-text-outline {
            display: none;
        }
        #mapContainer .highcharts-background {
            fill: #f2f3f8;
        }

        .topReport .totalReportInNumber {
            display: flex;
            align-items: center;
        }
        .topReport .totalReportInNumber > .m-portlet {
            display: table;
        }
    </style>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="flaticon-home-2 m--padding-right-5"></i>
                <a class="m-link" href="{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">پروفایل</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a class="m-link" href="#">گزارش فروش</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    
    @include('systemMessage.flash')
    
    <div class="row">
        <div class="col">
{{--            <h1>به دلیل کش سرورها، آمار ها حداکثر دارای 3.5 ساعت تاخیر هستند.</h1>--}}
            <div class="row topReport">
                <div class="col-md-6 totalReportInNumber">
                    <div class="m-portlet ">
                        <div class="m-portlet__body  m-portlet__body--no-padding">
                            <div class="row m-row--no-padding m-row--col-separator-xl">
                                <div class="col-12 col-md-6">
        
                                    <!--begin::New Orders-->
{{--                                    <div class="m-widget24">--}}
{{--                                        <div class="m-widget24__item">--}}
{{--                                            <h4 class="m-widget24__title">--}}
{{--                                                فروش امروز:--}}
{{--                                            </h4><br>--}}
{{--                                            <span class="m-widget24__desc">--}}
{{--                                                {{number_format($todaySum)}}--}}
{{--                                                 تومان--}}
{{--                                            </span>--}}
{{--                                            <span class="m-widget24__stats m--font-danger">--}}
{{--                                                تعداد:--}}
{{--                                                {{$todayCount}}--}}
{{--                                            </span>--}}
{{--                                            <div class="m--space-10"></div>--}}
{{--                                            --}}{{--<div class="progress m-progress--sm">--}}
{{--                                                <div class="progress-bar m--bg-danger" role="progressbar" style="width: {{$todayRate}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                            </div>--}}
{{--                                            <span class="m-widget24__change">--}}
{{--                                                نسبت به دیگران--}}
{{--                                            </span>--}}
{{--                                            <span class="m-widget24__number">--}}
{{--                                                {{$todayRate}}--}}
{{--                                            </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
        
                                    <!--end::New Orders-->
                                </div>
                                <div class="col-12 col-md-6">
                                    <!--begin::New Orders-->
{{--                                    <div class="m-widget24">--}}
{{--                                        <div class="m-widget24__item">--}}
{{--                                            <h4 class="m-widget24__title">--}}
{{--                                                فروش هفته:--}}
{{--                                            </h4><br>--}}
{{--                                            <span class="m-widget24__desc">--}}
{{--                                                {{number_format($thisWeekSum)}}--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                            <span class="m-widget24__stats m--font-info">--}}
{{--                                                تعداد:--}}
{{--                                                {{$thisWeekCount}}--}}
{{--                                            </span>--}}
{{--                                            <div class="m--space-10"></div>--}}
{{--                                            <div class="progress m-progress--sm">--}}
{{--                                                <div class="progress-bar m--bg-info" role="progressbar" style="width: {{$thisWeekRate}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                            </div>--}}
{{--                                            <span class="m-widget24__change">--}}
{{--                                                نسبت به دیگران--}}
{{--                                            </span>--}}
{{--                                            <span class="m-widget24__number">--}}
{{--                                                {{$thisWeekRate}}--}}
{{--                                            </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
        
                                    <!--end::New Orders-->
                                </div>
                                <div class="col-12 col-md-6">

                                    <!--begin::New Users-->
{{--                                    <div class="m-widget24">--}}
{{--                                        <div class="m-widget24__item">--}}
{{--                                            <h4 class="m-widget24__title">--}}
{{--                                                فروش این ماه:--}}
{{--                                            </h4><br>--}}
{{--                                            <span class="m-widget24__desc">--}}
{{--                                                {{number_format($thisMonthSum)}}--}}
{{--                                                تومان--}}
{{--                                            </span>--}}
{{--                                            <span class="m-widget24__stats m--font-success">--}}
{{--                                                تعداد:--}}
{{--                                                {{$thisMonthCount}}--}}
{{--                                            </span>--}}
{{--                                            <div class="m--space-10"></div>--}}
{{--                                            --}}{{--<div class="progress m-progress--sm">--}}
{{--                                                <div class="progress-bar m--bg-success" role="progressbar" style="width: {{$thisMonthRate}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                                            </div>--}}
{{--                                            <span class="m-widget24__change">--}}
{{--                                                نسبت به دیگران--}}
{{--                                            </span>--}}
{{--                                            <span class="m-widget24__number">--}}
{{--                                                {{$thisMonthRate}}--}}
{{--                                            </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
        
                                    <!--end::New Users-->
                                </div>
                                <div class="col-12 col-md-6">
                    
                                    <!--begin::Total Profit-->
                                    <div class="m-widget24">
                                        <div class="m-widget24__item">
                                            <h4 class="m-widget24__title">
                                                فروش کل:
                                            </h4><br>
                                            <span class="m-widget24__desc">
                                                {{number_format($allTimeSum)}}
                                                تومان
                                            </span>
                                            <span class="m-widget24__stats m--font-brand">
                                                تعداد:
                                                {{$allTimeCount}}
                                            </span>
                                            <div class="m--space-10"></div>
    
                                            <span class="m-widget24__desc">
                                                <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                                                    رتبه شما:
                                                    {{$userRank}}
                                                </span>
                                            </span>
                                            <div class="m--space-10"></div>
                                            {{--<div class="progress m-progress--sm">
                                                <div class="progress-bar m--bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="m-widget24__change">
                                                نسبت به دیگران
                                            </span>
                                            <span class="m-widget24__number">
                                                78%
                                            </span>--}}
                                        </div>
                                    </div>
                    
                                    <!--end::Total Profit-->
                                </div>
                            </div>
                        </div>
                        <h5 style="text-align:center ; color:red">تاریخ قرار داد شما به اتمام رسیده است</h5>
                        <div class="m--space-30"></div>
                        <h5 style="direction:ltr">ساعت : {{$now}}</h5>
                        <h5>به دلیل کش سرورها، آمار ها حداکثر دارای 5 دقیقه تاخیر هستند.</h5>

                    </div>

                </div>

                <div class="col-md-6">
                    <div id="mapContainer"></div>
                </div>
            </div>
            
            <!--begin::Portlet-->
            {{--<div class="m-portlet m-portlet--head-solid-bg m-portlet--accent m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="produc-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                گزارش فروش محصولات
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="content-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="la la-refresh"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="content-expand">
                                    <i class="la la-expand"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
    
    
                    <div class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-sabteRotbe">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon d-none">
                                        <i class="flaticon-statistics"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        از تاریخ 1398/4/12 تا تاریخ 1398/9/23
                                    </h3>
                                    <h2 class="m-portlet__head-label m-portlet__head-label--success">
                                    <span>
                                        <i class="la la-trophy"></i>
                                        تعداد فروش محصولات
                                    </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div id="chartcontainer1"></div>
                        </div>
                    </div>
    
    
                    <div class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-sabteRotbe">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon d-none">
                                        <i class="flaticon-statistics"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        از تاریخ 1398/4/12 تا تاریخ 1398/9/23
                                    </h3>
                                    <h2 class="m-portlet__head-label m-portlet__head-label--success">
                                    <span>
                                        <i class="la la-trophy"></i>
                                        مبلغ فروش محصولات
                                    </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div id="chartcontainer2"></div>
                        </div>
                    </div>
                    
                </div>
            </div>--}}
            <!--end::Portlet-->
            
            <!--begin::Portlet-->
            {{--<div class="m-portlet m-portlet--head-solid-bg m-portlet--info m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="bone-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                گزارش استفاده از کد تخفیف
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="content-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="la la-refresh"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="content-expand">
                                    <i class="la la-expand"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
    
    
    
                    <div class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-sabteRotbe">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon d-none">
                                        <i class="flaticon-statistics"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        از تاریخ 1398/4/12 تا تاریخ 1398/9/23
                                    </h3>
                                    <h2 class="m-portlet__head-label m-portlet__head-label--success">
                                    <span>
                                        <i class="la la-trophy"></i>
                                        تعداد استفاده از بن
                                    </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div id="chartcontainer3"></div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>--}}
            <!--end::Portlet-->
    
            <!--begin::Portlet-->
            {{--<div class="m-portlet m-portlet--head-solid-bg m-portlet--primary m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="createbone-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                ساخت کد تخفیف
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <img class="d-none" id="content-portlet-loading" src="{{config('constants.ADMIN_LOADING_BAR_GIF')}}" alt="loading" style="width: 50px;">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon reload">
                                    <i class="la la-refresh"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="content-expand">
                                    <i class="la la-expand"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="la la-close"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
    
    
                    {!! Form::hidden('discounttype_id',1) !!}
                    <div class="col-md-12">
                        <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر الزامی می باشد:</p>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <p>
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'couponName' , 'placeholder'=>'نام کپن']) !!}
                            <span class="form-control-feedback" id="couponNameAlert">
                                <strong></strong>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-12">
                        <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد:</p>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <p>
                            {!! Form::select('discount', [1,2,3,4,5,6,7,8,9,10], ['class' => 'form-control', 'id' => 'couponDiscount'  , 'placeholder'=>'میزان تخفیف کپن (%)']) !!}
                            <span class="form-control-feedback" id="couponDiscountAlert">
                                <strong></strong>
                            </span>
                        </p>
                        <div>
                            <div class="clearfix margin-bottom-10">
                                <span class="m-badge m-badge--wide m-badge--success">توجه</span>
                                <strong id="">محصولاتی که مشمول کپن می شوند</strong>
                            </div>
                            {!! Form::select('coupontype_id',$coupontype, null, ['class' => 'form-control', 'id' => 'coupontypeId']) !!}
                            <span class="form-control-feedback" id="coupontypeIdAlert">
                                    <strong></strong>
                                </span>
                        </div>
                        <div>
                            {!! Form::select('products[]',$products, null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'coupon_product']) !!}
                            <span class="form-control-feedback" id="couponProductAlert">
                                    <strong></strong>
                                </span>
                            <div class="clearfix margin-top-10">
                                <span class="m-badge m-badge--wide m-badge--info">توجه</span>
                                <strong id="">ستون چپ محصولات شامل تخفیف می باشند</strong>
                            </div>
                        </div>
                        <div>
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'couponDescription'  , 'placeholder'=>'توضیح درباره کپن']) !!}
                            <span class="form-control-feedback" id="couponDescriptionAlert">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">
                                <label class="mt-checkbox mt-checkbox-outline">تاریخ پایان معتبر بودن کپن
                                    {!! Form::checkbox('validUntilEnable', '1', null, ['class' => '', 'id' => 'couponValidUntilEnable'  ]) !!}
                                    <span class="bg-grey-cararra"></span>
                                </label>
                            </label>
                            <div class="col-md-12">
                                <input id="couponValidUntil" type="text" class="form-control" dir="ltr" disabled="disabled">
                                <input name="validUntil" id="couponValidUntilAlt" type="text" class="form-control d-none">
                                <span class="form-control-feedback" id="couponValidUntilAltAlert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>--}}
            <!--end::Portlet-->
            
        </div>
    </div>
@endsection


@section('page-js')
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/lib/persian-date.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type="text/javascript"></script>
    <script src="/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-coupon.js" type="text/javascript"></script>
    <script src="/acm/AlaatvCustomFiles/js/admin-customInitComponent.js" type="text/javascript"></script>

    <script src="/acm/AlaatvCustomFiles/js/admin-makeMultiSelect.js" type="text/javascript"></script>
    
    <script type="text/javascript">
        /**
         * Start up jquery
         */
        jQuery(document).ready(function () {
            /*
             validUntil
             */
            CustomInit.persianDatepicker('#couponValidUntil', '#couponValidUntilAlt', true);
        });

        $('#couponValidSinceEnable').change(function () {
            if ($(this).prop('checked') === true) {
                $('#couponValidSince').attr('disabled', false);
                $('#couponValidSinceTime').attr('disabled', false);
            } else {
                $('#couponValidSince').attr('disabled', true);
                $('#couponValidSinceTime').attr('disabled', true);
            }
        });

        $('#couponValidUntilEnable').change(function () {
            if ($(this).prop('checked') === true) {
                $('#couponValidUntil').attr('disabled', false);
                $('#couponValidUntilTime').attr('disabled', false);
            } else {
                $('#couponValidUntil').attr('disabled', true);
                $('#couponValidUntilTime').attr('disabled', true);
            }
        });
    
    </script>

    <script src="{{ asset('/acm/AlaatvCustomFiles/js/iran.geo-map.js') }}"></script>
    <script src="{{ mix('/js/user-profile-salesReport.js') }}"></script>
    
    
    <script>

        var data = [
            ['ir-5428', 0],
            ['ir-hg', {{$provinces->where('name' , 'ir-hg')->first()['count']}}],
            ['ir-bs', {{$provinces->where('name' , 'ir-bs')->first()['count']}}],
            ['ir-kb', {{$provinces->where('name' , 'ir-kb')->first()['count']}}],
            ['ir-fa', {{$provinces->where('name' , 'ir-fa')->first()['count']}}],
            ['ir-es', {{$provinces->where('name' , 'ir-es')->first()['count']}}],
            ['ir-sm', {{$provinces->where('name' , 'ir-sm')->first()['count']}}],
            ['ir-go', {{$provinces->where('name' , 'ir-go')->first()['count']}}],
            ['ir-mn', {{$provinces->where('name' , 'ir-mn')->first()['count']}}],
            ['ir-th', {{$provinces->where('name' , 'ir-th')->first()['count']}}],
            ['ir-mk', {{$provinces->where('name' , 'ir-mk')->first()['count']}}],
            ['ir-ya', {{$provinces->where('name' , 'ir-ya')->first()['count']}}],
            ['ir-cm', {{$provinces->where('name' , 'ir-cm')->first()['count']}}],
            ['ir-kz', {{$provinces->where('name' , 'ir-kz')->first()['count']}}],
            ['ir-lo', {{$provinces->where('name' , 'ir-lo')->first()['count']}}],
            ['ir-il', {{$provinces->where('name' , 'ir-il')->first()['count']}}],
            ['ir-ar', {{$provinces->where('name' , 'ir-ar')->first()['count']}}],
            ['ir-qm', {{$provinces->where('name' , 'ir-qm')->first()['count']}}],
            ['ir-hd', {{$provinces->where('name' , 'ir-hd')->first()['count']}}],
            ['ir-za', {{$provinces->where('name' , 'ir-za')->first()['count']}}],
            ['ir-qz', {{$provinces->where('name' , 'ir-qz')->first()['count']}}],
            ['ir-wa', {{$provinces->where('name' , 'ir-wa')->first()['count']}}],
            ['ir-ea', {{$provinces->where('name' , 'ir-ea')->first()['count']}}],
            ['ir-bk', {{$provinces->where('name' , 'ir-bk')->first()['count']}}],
            ['ir-gi', {{$provinces->where('name' , 'ir-gi')->first()['count']}}],
            ['ir-kd', {{$provinces->where('name' , 'ir-kd')->first()['count']}}],
            ['ir-kj', {{$provinces->where('name' , 'ir-kj')->first()['count']}}],
            ['ir-kv', {{$provinces->where('name' , 'ir-kv')->first()['count']}}],
            ['ir-ks', {{$provinces->where('name' , 'ir-ks')->first()['count']}}],
            ['ir-sb', {{$provinces->where('name' , 'ir-sb')->first()['count']}}],
            ['ir-ke', {{$provinces->where('name' , 'ir-ke')->first()['count']}}],
            ['ir-al', {{$provinces->where('name' , 'ir-al')->first()['count']}}],
            ['ir-un', {{$provinces->where('name' , 'ir-un')->first()['count']}}]
        ];

        // Create the chart
        Highcharts.mapChart('mapContainer', {

            chart: {
                backgroundColor: '#eff0f5',
                height: '100%'
            },

            title: {
                text: 'گزارش فروش محصولات'
            },
            
            credits: {
                enabled: true,
                href: '{{ asset('/') }}',
                text: 'آموزش مجازی آلاء'
            },

            subtitle: {
                text: 'تعداد فروش در استان های ایران'
            },

            tooltip: {
                useHTML: true,
                formatter: function() {
                    let province = this.key;
                    let value = this.point.value;
                    return '<div>استان: '+province+'</div>'+'<div>'+value+'</div>';
                }
            },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },

            colorAxis: {
                min: 1,
                minColor: '#f2f3f8',
                maxColor: '#ff9a17',
                // startOnTick: false,
                // endOnTick: false
            },

            series: [{

                mapData: mapGeoJSON,
                color: '#E0E0E0',
                nullColor: 'white',
                // enableMouseTracking: false,
                
                data: data,
                name: 'Random data',
                states: {
                    hover: {
                        color: '#BADA55'
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }]
        });

        Highcharts.chart('chartcontainer1', {

            title: {
                text: undefined
            },
            
            credits: {
                enabled: true,
                href: '{{ asset('/') }}',
                text: 'آموزش مجازی آلاء'
            },

            chart: {
                zoomType: 'x'
            },

            tooltip: {
                useHTML: true,
                formatter: function() {
                    let unixTimestamp = this.x;
                    let persianDateValue = persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
                    let value = this.y;
                    return '<div>تعداد فروش: '+value+'</div>'+'<div>'+persianDateValue+'</div>';
                }
            },

            xAxis: {
                type: 'datetime',
                labels: {
                    formatter: function() {
                        let unixTimestamp = this.value;
                        // return persianDate.unix(unixTimestamp).format("YYY/M/D");
                        return persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
                    }
                }
            },

            yAxis: {
                title: {
                    text: 'تعداد فروش'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            lang: {
                months: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                shortMonths: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                weekdays: ["یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج‌شنبه", "جمعه", "شنبه"]
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                }
            },

            series: [
                {
                    name: 'محصول شماره یک',
                    data: [{
                        x: Math.round((new Date('2013/09/04 15:34:00')).getTime()/1000),
                        y: 3
                    },
                        {
                            x: Math.round((new Date('2013/09/05 15:34:00')).getTime()/1000),
                            y: 5
                        },
                        {
                            x: Math.round((new Date('2013/09/06 15:34:00')).getTime()/1000),
                            y: 2
                        },
                        {
                            x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
                            y: 6
                        },
                        {
                            x: Math.round((new Date('2013/09/08 15:34:00')).getTime()/1000),
                            y: 2
                        },
                        {
                            x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
                            y: 8
                        },
                        {
                            x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/09/11 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/09/12 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/09/13 15:34:00')).getTime()/1000),
                            y: 3
                        },
                        {
                            x: Math.round((new Date('2013/09/14 15:34:00')).getTime()/1000),
                            y: 8
                        },
                        {
                            x: Math.round((new Date('2013/09/15 15:34:00')).getTime()/1000),
                            y: 15
                        },
                        {
                            x: Math.round((new Date('2013/09/16 15:34:00')).getTime()/1000),
                            y: 13
                        },
                        {
                            x: Math.round((new Date('2013/09/17 15:34:00')).getTime()/1000),
                            y: 11
                        },
                        {
                            x: Math.round((new Date('2013/09/18 15:34:00')).getTime()/1000),
                            y: 14
                        }]
                },
                {
                    name: 'محصول شماره دو',
                    data: [{
                        x: Math.round((new Date('2013/09/01 15:34:00')).getTime()/1000),
                        y: 4
                    },
                        {
                            x: Math.round((new Date('2013/09/03 15:34:00')).getTime()/1000),
                            y: 2
                        },
                        {
                            x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
                            y: 7
                        },
                        {
                            x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
                            y: 1
                        },
                        {
                            x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/04 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/05 15:34:00')).getTime()/1000),
                            y: 5
                        },
                        {
                            x: Math.round((new Date('2013/10/06 15:34:00')).getTime()/1000),
                            y: 2
                        },
                        {
                            x: Math.round((new Date('2013/10/07 15:34:00')).getTime()/1000),
                            y: 6
                        },
                        {
                            x: Math.round((new Date('2013/10/08 15:34:00')).getTime()/1000),
                            y: 2
                        },
                        {
                            x: Math.round((new Date('2013/10/09 15:34:00')).getTime()/1000),
                            y: 8
                        },
                        {
                            x: Math.round((new Date('2013/10/10 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/11 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/12 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/13 15:34:00')).getTime()/1000),
                            y: 3
                        },
                        {
                            x: Math.round((new Date('2013/10/14 15:34:00')).getTime()/1000),
                            y: 8
                        },
                        {
                            x: Math.round((new Date('2013/10/15 15:34:00')).getTime()/1000),
                            y: 15
                        },
                        {
                            x: Math.round((new Date('2013/10/16 15:34:00')).getTime()/1000),
                            y: 13
                        },
                        {
                            x: Math.round((new Date('2013/10/17 15:34:00')).getTime()/1000),
                            y: 11
                        },
                        {
                            x: Math.round((new Date('2013/10/18 15:34:00')).getTime()/1000),
                            y: 14
                        }
                    ]
                }
            ],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
        
        Highcharts.chart('chartcontainer2', {

            title: {
                text: undefined
            },
            
            credits: {
                enabled: true,
                href: '{{ asset('/') }}',
                text: 'آموزش مجازی آلاء'
            },

            chart: {
                zoomType: 'x'
            },

            tooltip: {
                useHTML: true,
                formatter: function() {
                    let unixTimestamp = this.x;
                    let persianDateValue = persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
                    let value = this.y;
                    return '<div>تعداد فروش: '+value+'</div>'+'<div>'+persianDateValue+'</div>';
                }
            },

            xAxis: {
                type: 'datetime',
                labels: {
                    formatter: function() {
                        let unixTimestamp = this.value;
                        // return persianDate.unix(unixTimestamp).format("YYY/M/D");
                        return persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
                    }
                }
            },

            yAxis: {
                title: {
                    text: 'مبلغ فروش'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            lang: {
                months: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                shortMonths: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                weekdays: ["یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج‌شنبه", "جمعه", "شنبه"]
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                }
            },

            series: [
                {
                    name: 'محصول شماره یک',
                    data: [{
                            x: Math.round((new Date('2013/09/04 15:34:00')).getTime()/1000),
                            y: 3000
                        },
                        {
                            x: Math.round((new Date('2013/09/05 15:34:00')).getTime()/1000),
                            y: 5000
                        },
                        {
                            x: Math.round((new Date('2013/09/06 15:34:00')).getTime()/1000),
                            y: 2000
                        },
                        {
                            x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
                            y: 6000
                        },
                        {
                            x: Math.round((new Date('2013/09/08 15:34:00')).getTime()/1000),
                            y: 2000
                        },
                        {
                            x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
                            y: 8000
                        },
                        {
                            x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/09/11 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/09/12 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/09/13 15:34:00')).getTime()/1000),
                            y: 3000
                        },
                        {
                            x: Math.round((new Date('2013/09/14 15:34:00')).getTime()/1000),
                            y: 8000
                        },
                        {
                            x: Math.round((new Date('2013/09/15 15:34:00')).getTime()/1000),
                            y: 15000
                        },
                        {
                            x: Math.round((new Date('2013/09/16 15:34:00')).getTime()/1000),
                            y: 13000
                        },
                        {
                            x: Math.round((new Date('2013/09/17 15:34:00')).getTime()/1000),
                            y: 11000
                        },
                        {
                            x: Math.round((new Date('2013/09/18 15:34:00')).getTime()/1000),
                            y: 14000
                        }]
                },
                {
                    name: 'محصول شماره دو',
                    data: [{
                            x: Math.round((new Date('2013/09/01 15:34:00')).getTime()/1000),
                            y: 40000
                        },
                        {
                            x: Math.round((new Date('2013/09/03 15:34:00')).getTime()/1000),
                            y: 20000
                        },
                        {
                            x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
                            y: 70000
                        },
                        {
                            x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
                            y: 10000
                        },
                        {
                            x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/04 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/05 15:34:00')).getTime()/1000),
                            y: 50000
                        },
                        {
                            x: Math.round((new Date('2013/10/06 15:34:00')).getTime()/1000),
                            y: 20000
                        },
                        {
                            x: Math.round((new Date('2013/10/07 15:34:00')).getTime()/1000),
                            y: 60000
                        },
                        {
                            x: Math.round((new Date('2013/10/08 15:34:00')).getTime()/1000),
                            y: 20000
                        },
                        {
                            x: Math.round((new Date('2013/10/09 15:34:00')).getTime()/1000),
                            y: 80000
                        },
                        {
                            x: Math.round((new Date('2013/10/10 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/11 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/12 15:34:00')).getTime()/1000),
                            y: null
                        },
                        {
                            x: Math.round((new Date('2013/10/13 15:34:00')).getTime()/1000),
                            y: 30000
                        },
                        {
                            x: Math.round((new Date('2013/10/14 15:34:00')).getTime()/1000),
                            y: 80000
                        },
                        {
                            x: Math.round((new Date('2013/10/15 15:34:00')).getTime()/1000),
                            y: 150000
                        },
                        {
                            x: Math.round((new Date('2013/10/16 15:34:00')).getTime()/1000),
                            y: 130000
                        },
                        {
                            x: Math.round((new Date('2013/10/17 15:34:00')).getTime()/1000),
                            y: 110000
                        },
                        {
                            x: Math.round((new Date('2013/10/18 15:34:00')).getTime()/1000),
                            y: 140000
                        }
                    ]
                }
            ],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });

        Highcharts.chart('chartcontainer3', {

            title: {
                text: undefined
            },

            credits: {
                enabled: true,
                href: '{{ asset('/') }}',
                text: 'آموزش مجازی آلاء'
            },
            
            chart: {
                type: 'column',
                zoomType: 'x'
            },
            
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'تعداد استفاده'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}'
                    }
                }
            },

            tooltip: {
                useHTML: true,
                formatter: function() {
                    return '<span style="font-size:11px">'+this.series.name+'</span><br><span style="color:'+this.point.color+'">'+this.point.name+'</span>: <b>'+this.point.y+'</b>';
                }
            },

            series: [
                {
                    name: "کد تخفیف",
                    colorByPoint: true,
                    data: [
                        {
                            name: "کد شماره یک",
                            y: 62.74,
                            drilldown: "p1"
                        },
                        {
                            name: "کد شماره دو",
                            y: 10.57,
                            drilldown: "p2"
                        },
                        {
                            name: "کد شماره سه",
                            y: 7.23,
                            drilldown: "کد شماره سه"
                        },
                        {
                            name: "کد شماره چهار",
                            y: 5.58,
                            drilldown: "کد شماره چهار"
                        },
                        {
                            name: "کد شماره پنج",
                            y: 4.02,
                            drilldown: "کد شماره پنج"
                        },
                        {
                            name: "کد شماره شش",
                            y: 1.92,
                            drilldown: "کد شماره شش"
                        },
                        {
                            name: "Other",
                            y: 7.62,
                            drilldown: null
                        }
                    ]
                }
            ],
            drilldown: {
                series: [
                    {
                        name: "کد شماره یک",
                        id: "p1",
                        data: [
                            [
                                "محصول شماره 1",
                                0.1
                            ],
                            [
                                "محصول شماره 2",
                                1.3
                            ],
                            [
                                "محصول شماره 3",
                                53.02
                            ],
                            [
                                "محصول شماره 4",
                                1.4
                            ],
                            [
                                "محصول شماره 5",
                                0.88
                            ],
                            [
                                "محصول شماره 6",
                                0.56
                            ],
                            [
                                "محصول شماره 7",
                                0.45
                            ],
                            [
                                "محصول شماره 8",
                                0.49
                            ],
                            [
                                "محصول شماره 9",
                                0.32
                            ],
                            [
                                "محصول شماره 10",
                                0.29
                            ],
                            [
                                "محصول شماره 11",
                                0.79
                            ],
                            [
                                "محصول شماره 12",
                                0.18
                            ],
                            [
                                "محصول شماره 13",
                                0.13
                            ],
                            [
                                "محصول شماره 14",
                                2.16
                            ],
                            [
                                "محصول شماره 15",
                                0.13
                            ],
                            [
                                "محصول شماره 16",
                                0.11
                            ],
                            [
                                "محصول شماره 17",
                                0.17
                            ],
                            [
                                "محصول شماره 18",
                                0.26
                            ]
                        ]
                    },
                    {
                        name: "کد شماره دو",
                        id: "p2",
                        data: [
                            [
                                "محصول شماره یک",
                                1.02
                            ],
                            [
                                "محصول شماره دو",
                                7.36
                            ],
                            [
                                "محصول شماره سه",
                                0.35
                            ],
                            [
                                "محصول شماره چهار",
                                0.11
                            ],
                            [
                                "محصول شماره پنج",
                                0.1
                            ],
                            [
                                "محصول شماره شش",
                                0.95
                            ],
                            [
                                "محصول شماره هفت",
                                0.15
                            ],
                            [
                                "محصول شماره هشت",
                                0.1
                            ],
                            [
                                "محصول شماره نه",
                                0.31
                            ],
                            [
                                "محصول شماره ده",
                                0.12
                            ]
                        ]
                    },
                    {
                        name: "کد شماره سه",
                        id: "کد شماره سه",
                        data: [
                            [
                                "محصول شماره یک",
                                6.2
                            ],
                            [
                                "محصول شماره دو",
                                0.29
                            ],
                            [
                                "محصول شماره سه",
                                0.27
                            ],
                            [
                                "محصول شماره چهار",
                                0.47
                            ]
                        ]
                    },
                    {
                        name: "کد شماره چهار",
                        id: "کد شماره چهار",
                        data: [
                            [
                                "محصول شماره یک",
                                3.39
                            ],
                            [
                                "محصول شماره دو",
                                0.96
                            ],
                            [
                                "محصول شماره سه",
                                0.36
                            ],
                            [
                                "محصول شماره چهار",
                                0.54
                            ],
                            [
                                "محصول شماره پنج",
                                0.13
                            ],
                            [
                                "محصول شماره شش",
                                0.2
                            ]
                        ]
                    },
                    {
                        name: "کد شماره پنج",
                        id: "کد شماره پنج",
                        data: [
                            [
                                "محصول شماره یک",
                                2.6
                            ],
                            [
                                "محصول شماره دو",
                                0.92
                            ],
                            [
                                "محصول شماره سه",
                                0.4
                            ],
                            [
                                "محصول شماره چهار",
                                0.1
                            ]
                        ]
                    },
                    {
                        name: "کد شماره شش",
                        id: "کد شماره شش",
                        data: [
                            [
                                "محصول شماره یک",
                                0.96
                            ],
                            [
                                "محصول شماره دو",
                                0.82
                            ],
                            [
                                "محصول شماره سه",
                                0.14
                            ]
                        ]
                    }
                ]
            }
        });
        

        
        
        

        //
        // Highcharts.chart('container', {
        //     chart: {
        //         type: 'networkgraph',
        //         height: '900px'
        //     },
        //     title: {
        //         text: 'لیست محصولات شما'
        //     },
        //     subtitle: {
        //         text: 'لیست درختی محصولات شما'
        //     },
        //     plotOptions: {
        //         networkgraph: {
        //             keys: ['from', 'to'],
        //             layoutAlgorithm: {
        //                 enableSimulation: true,
        //                 friction: -0.9
        //             }
        //         }
        //     },
        //     series: [{
        //         dataLabels: {
        //             enabled: true,
        //             linkFormat: ''
        //         },
        //         data: [
        //
        //             ['محصول مادر', 'محصول شماره دو'],
        //             ['محصول مادر', 'محصول شماره سه'],
        //             ['محصول مادر', 'محصول شماره چهار'],
        //             ['محصول شماره یک', 'محصول شماره پنج'],
        //             ['محصول شماره یک', 'محصول شماره پنج'],
        //             ['محصول شماره پنج', 'محصول شماره شش'],
        //             ['محصول شماره پنج', 'محصول شماره هفت'],
        //             ['محصول شماره یک', 'محصول شماره هشت'],
        //             ['محصول شماره یک', 'محصول شماره نه'],
        //             ['محصول شماره یک', 'محصول شماره ده'],
        //             ['محصول شماره یک', 'محصول شماره یازده'],
        //             ['محصول شماره یک', 'محصول شماره دوازده'],
        //             ['محصول شماره یک', 'محصول شماره سیزده'],
        //             ['محصول شماره دو', 'محصول شماره چهارده'],
        //             ['محصول شماره دو', 'محصول شماره پانزده'],
        //             ['محصول شماره دو', 'محصول شماره شانزده'],
        //             ['محصول شماره دو', 'محصول شماره هفده'],
        //             ['محصول شماره سه', 'محصول شماره هجده'],
        //             ['محصول شماره چهار', 'محصول شماره نوزده'],
        //             ['محصول شماره چهار', 'محصول شماره بیست'],
        //             ['محصول شماره چهار', 'محصول شماره بیست و یک'],
        //             ['محصول شماره چهار', 'محصول شماره بیست و دو']
        //         ]
        //     }]
        // });
        //
        
        $(document).ready(function () {
           let highchartsCredits = $('.highcharts-credits').html();
           console.log('highchartsCredits: ', highchartsCredits);
            $('.highcharts-credits').html(highchartsCredits.replace('©', '').trim());
        });
        
        
    </script>
@endsection
