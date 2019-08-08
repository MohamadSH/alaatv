@extends('app' , ['pageName' => 'profile'])

@section('page-css')
    <link href="{{ mix('/css/user-profile-salesReport.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home m--padding-right-5"></i>
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
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="content-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
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
                                        <i class="fa fa-trophy"></i>
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
                                        <i class="fa fa-trophy"></i>
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
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="content-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
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
                                        <i class="fa fa-trophy"></i>
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
                                    <i class="fa fa-redo"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon" id="content-expand">
                                    <i class="fa fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="m-portlet__nav-item">
                                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                    <i class="fa fa-times"></i>
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
        console.log('data: ', data);
    </script>
    <script src="{{ mix('/js/user-profile-salesReport.js') }}"></script>
@endsection
