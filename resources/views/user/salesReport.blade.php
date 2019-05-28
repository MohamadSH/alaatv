@extends('app' , ['pageName' => 'profile'])

@section('page-css')
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/css/multi-select-rtl.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/acm/extra/persian-datepicker/dist/css/persian-datepicker-0.4.5.min.css" rel = "stylesheet" type = "text/css"/>

    <link href = "{{ mix('/css/user-profile-salesReport.css') }}" rel = "stylesheet" type = "text/css"/>
    
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "flaticon-home-2 m--padding-right-5"></i>
                <a class = "m-link" href = "{{action("Web\IndexPageController")}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">پروفایل</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                <a class = "m-link" href = "#">گزارش فروش</a>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
    
    @include('systemMessage.flash')
    
    <div class = "row">
        <div class = "col">
            
            <div class = "m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-sabteRotbe">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
						<span class = "m-portlet__head-icon d-none">
							<i class = "flaticon-statistics"></i>
						</span>
                            <h3 class = "m-portlet__head-text">
                                گزارش فروش محصولات شما
                            </h3>
                            <h2 class = "m-portlet__head-label m-portlet__head-label--success">
                                <span>
                                    <i class = "la la-trophy"></i>
                                    گزارش فروش
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                    
                    </div>
                </div>
                <div class = "m-portlet__body">
                
                    <div id="container"></div>
                
                </div>
            </div>
            
            <div class = "m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-sabteRotbe">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
						<span class = "m-portlet__head-icon d-none">
							<i class = "flaticon-statistics"></i>
						</span>
                            <h3 class = "m-portlet__head-text">
                                ساخت بن تخفیف
                            </h3>
                            <h2 class = "m-portlet__head-label m-portlet__head-label--success">
                                <span>
                                    <i class = "la la-trophy"></i>
                                    بن تخفیف
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class = "m-portlet__head-tools">
                    
                    </div>
                </div>
                <div class = "m-portlet__body">
    
    
                    
                        {!! Form::hidden('discounttype_id',1) !!}
                        <div class = "col-md-12">
                            <p class = "caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر الزامی می باشد:</p>
                        </div>
                        <div class = "col-md-8 col-md-offset-2">
                            <p>
                                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'couponName' , 'placeholder'=>'نام کپن']) !!}
                                <span class = "help-block" id = "couponNameAlert">
                                    <strong></strong>
                                </span>
                            </p>
                            <p>
                                {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'couponCode'  , 'placeholder'=>'کد کپن']) !!}
                                <span class = "help-block" id = "couponCodeAlert">
                                    <strong></strong>
                                </span>
                            </p>
                        </div>
                        <div class = "col-md-12">
                            <p class = "caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد:</p>
                        </div>
                        <div class = "col-md-8 col-md-offset-2">
                            <p>
                                <label class = "control-label">
                                    <label class = "mt-checkbox mt-checkbox-outline">فعال/غیرفعال
                                        {!! Form::checkbox('enable', '1', null, ['class' => '', 'id' => 'enable' , 'checked' ]) !!}
                                        <span class = "bg-grey-cararra"></span>
                                    </label>
                                </label>
                            </p>
                            <p>
                                {!! Form::text('discount', null, ['class' => 'form-control', 'id' => 'couponDiscount'  , 'placeholder'=>'میزان تخفیف کپن (%)']) !!}
                                <span class = "help-block" id = "couponDiscountAlert">
                                    <strong></strong>
                                </span>
                            </p>
            
                            <div>
                                {!! Form::text('usageLimit', null, ['class' => 'form-control', 'id' => 'couponUsageLimit'  , 'placeholder'=>'حداکثر تعداد مجاز برای استفاده از این کپن']) !!}
                                <span class = "help-block" id = "couponUsageLimitAlert">
                                    <strong></strong>
                                </span>
                                <div class = "clearfix margin-top-10">
                                    {!! Form::select('limitStatus',$limitStatus, null, ['class' => 'form-control', 'id' => 'limitStatus']) !!}
                                </div>
                            </div>
                            <br>
                            <div>
                                <div class = "clearfix margin-bottom-10">
                                    <span class = "m-badge m-badge--wide m-badge--success">توجه</span>
                                    <strong id = "">محصولاتی که مشمول کپن می شوند</strong>
                                </div>
                                {!! Form::select('coupontype_id',$coupontype, null, ['class' => 'form-control', 'id' => 'coupontypeId']) !!}
                                <span class = "help-block" id = "coupontypeIdAlert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div>
                                {!! Form::select('products[]',$products, null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'coupon_product']) !!}
                                <span class = "help-block" id = "couponProductAlert">
                                    <strong></strong>
                                </span>
                                <div class = "clearfix margin-top-10">
                                    <span class = "m-badge m-badge--wide m-badge--info">توجه</span>
                                    <strong id = "">ستون چپ محصولات شامل تخفیف می باشند</strong>
                                </div>
                            </div>
                            <div>
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'couponDescription'  , 'placeholder'=>'توضیح درباره کپن']) !!}
                                <span class = "help-block" id = "couponDescriptionAlert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class = "col-md-6">
                                <label class = "control-label">
                                    <label class = "mt-checkbox mt-checkbox-outline">تاریخ شروع معتبر بودن کپن
                                        {!! Form::checkbox('validSinceEnable', '1', null, ['class' => '', 'id' => 'couponValidSinceEnable'  ]) !!}
                                        <span class = "bg-grey-cararra"></span>
                                    </label>
                                </label>
                                <div class = "col-md-12">
                                    <input id = "couponValidSince" type = "text" class = "form-control" dir = "ltr" disabled = "disabled">
                                    <input name = "validSince" id = "couponValidSinceAlt" type = "text" class = "form-control d-none">
                                    <input class = "form-control" name = "sinceTime" id = "couponValidSinceTime" placeholder = "00:00" dir = "ltr" disabled = "disabled">
                                    <span class = "help-block" id = "couponValidSinceAltAlert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <label class = "control-label">
                                    <label class = "mt-checkbox mt-checkbox-outline">تاریخ پایان معتبر بودن کپن
                                        {!! Form::checkbox('validUntilEnable', '1', null, ['class' => '', 'id' => 'couponValidUntilEnable'  ]) !!}
                                        <span class = "bg-grey-cararra"></span>
                                    </label>
                                </label>
                                <div class = "col-md-12">
                                    <input id = "couponValidUntil" type = "text" class = "form-control" dir = "ltr" disabled = "disabled">
                                    <input name = "validUntil" id = "couponValidUntilAlt" type = "text" class = "form-control d-none">
                                    <input class = "form-control" name = "untilTime" id = "couponValidUntilTime" placeholder = "00:00" dir = "ltr" disabled = "disabled">
                                    <span class = "help-block" id = "couponValidUntilAltAlert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    
                    
                </div>
            </div>
            
        </div>
    </div>
@endsection


@section('page-js')
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/bootstrap-select/js/bootstrap-select.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/jquery-multi-select/js/jquery.multi-select.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/plugins/select2/js/select2.full.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/lib/persian-date.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/components/alaa_old/scripts/components-multi-select.min.js" type = "text/javascript"></script>
    <script src = "/acm/extra/persian-datepicker/dist/js/persian-datepicker-0.4.5.min.js" type = "text/javascript"></script>
    <script src = "/acm/AlaatvCustomFiles/js/admin-coupon.js" type = "text/javascript"></script>
    <script type = "text/javascript">
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

    <script src = "{{ mix('/js/user-profile-salesReport.js') }}"></script>
    
    <script>

        Highcharts.chart('container', {

            chart: {
                zoomType: 'x'
            },
            
            title: {
                text: 'گزارش فروش محصولات'
            },

            subtitle: {
                text: 'فروش محصولات شما از تاریخ 1398/1/21 الی 1399/8/25'
            },

            xAxis: {
                type: 'category'
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

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    // pointStart: 2010
                }
            },

            series: [{
                name: 'محصول شماره یک',
                data: [['1398/1/12', 5], ['1398/1/12', 6], ['1398/1/12', 2], ['1398/1/12', 3]]
            }, {
                name: 'محصول شماره دو',
                data: [['1398/1/12', 7], ['1398/1/12', 7], ['1398/1/12', 4], ['1398/1/12', 2]]
            }, {
                name: 'محصول شماره سه',
                data: [['1398/1/12', 2], ['1398/1/12', 3], ['1398/1/12', 7], ['1398/1/12', 8]]
            }, {
                name: 'محصول شماره چهار',
                data: [['1398/1/12', 8], ['1398/1/12', 1], ['1398/1/12', 1], ['1398/1/12', 4]]
            }, {
                name: 'محصول شماره پنج',
                data: [['1398/1/12', 1], ['1398/1/12', 9], ['1398/1/12', 7], ['1398/1/12', 6]]
            }],

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
        
        
        
        
    </script>
@endsection
