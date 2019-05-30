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
        .highcharts-container , .highcharts-container * {
            font-family: IRANSans;
        }
        .highcharts-label.highcharts-tooltip {
            text-align: right;
        }
        .highcharts-anchor {
            display: none;
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
            
            <div class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-sabteRotbe">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon d-none">
							<i class="flaticon-statistics"></i>
						</span>
                            <h3 class="m-portlet__head-text">
                                گزارش فروش محصولات شما
                            </h3>
                            <h2 class="m-portlet__head-label m-portlet__head-label--success">
                                <span>
                                    <i class="la la-trophy"></i>
                                    گزارش فروش
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                    
                    </div>
                </div>
                <div class="m-portlet__body">
                
                    <div id="mapContainer"></div>
                    <div id="chartcontainer1"></div>
                    <div id="chartcontainer2"></div>
                    <div id="container"></div>
                
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
                                ساخت بن تخفیف
                            </h3>
                            <h2 class="m-portlet__head-label m-portlet__head-label--success">
                                <span>
                                    <i class="la la-trophy"></i>
                                    بن تخفیف
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                    
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
                                <span class="help-block" id="couponNameAlert">
                                    <strong></strong>
                                </span>
                            </p>
                            <p>
                                {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'couponCode'  , 'placeholder'=>'کد کپن']) !!}
                                <span class="help-block" id="couponCodeAlert">
                                    <strong></strong>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد:</p>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                            <p>
                                <label class="control-label">
                                    <label class="mt-checkbox mt-checkbox-outline">فعال/غیرفعال
                                        {!! Form::checkbox('enable', '1', null, ['class' => '', 'id' => 'enable' , 'checked' ]) !!}
                                        <span class="bg-grey-cararra"></span>
                                    </label>
                                </label>
                            </p>
                            <p>
                                {!! Form::text('discount', null, ['class' => 'form-control', 'id' => 'couponDiscount'  , 'placeholder'=>'میزان تخفیف کپن (%)']) !!}
                                <span class="help-block" id="couponDiscountAlert">
                                    <strong></strong>
                                </span>
                            </p>
            
                            <div>
                                {!! Form::text('usageLimit', null, ['class' => 'form-control', 'id' => 'couponUsageLimit'  , 'placeholder'=>'حداکثر تعداد مجاز برای استفاده از این کپن']) !!}
                                <span class="help-block" id="couponUsageLimitAlert">
                                    <strong></strong>
                                </span>
                                <div class="clearfix margin-top-10">
                                    {!! Form::select('limitStatus',$limitStatus, null, ['class' => 'form-control', 'id' => 'limitStatus']) !!}
                                </div>
                            </div>
                            <br>
                            <div>
                                <div class="clearfix margin-bottom-10">
                                    <span class="m-badge m-badge--wide m-badge--success">توجه</span>
                                    <strong id="">محصولاتی که مشمول کپن می شوند</strong>
                                </div>
                                {!! Form::select('coupontype_id',$coupontype, null, ['class' => 'form-control', 'id' => 'coupontypeId']) !!}
                                <span class="help-block" id="coupontypeIdAlert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div>
                                {!! Form::select('products[]',$products, null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'coupon_product']) !!}
                                <span class="help-block" id="couponProductAlert">
                                    <strong></strong>
                                </span>
                                <div class="clearfix margin-top-10">
                                    <span class="m-badge m-badge--wide m-badge--info">توجه</span>
                                    <strong id="">ستون چپ محصولات شامل تخفیف می باشند</strong>
                                </div>
                            </div>
                            <div>
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'couponDescription'  , 'placeholder'=>'توضیح درباره کپن']) !!}
                                <span class="help-block" id="couponDescriptionAlert">
                                    <strong></strong>
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">
                                    <label class="mt-checkbox mt-checkbox-outline">تاریخ شروع معتبر بودن کپن
                                        {!! Form::checkbox('validSinceEnable', '1', null, ['class' => '', 'id' => 'couponValidSinceEnable'  ]) !!}
                                        <span class="bg-grey-cararra"></span>
                                    </label>
                                </label>
                                <div class="col-md-12">
                                    <input id="couponValidSince" type="text" class="form-control" dir="ltr" disabled="disabled">
                                    <input name="validSince" id="couponValidSinceAlt" type="text" class="form-control d-none">
                                    <span class="help-block" id="couponValidSinceAltAlert">
                                        <strong></strong>
                                    </span>
                                </div>
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
                                    <span class="help-block" id="couponValidUntilAltAlert">
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
             validdSince
             */
            CustomInit.persianDatepicker('#couponValidSince', '#couponValidSinceAlt', true);

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

{{--    <script src="{{ asset('/acm/AlaatvCustomFiles/js/iran.geo-map.js') }}"></script>--}}
    <script src="{{ mix('/js/user-profile-salesReport.js') }}"></script>
    
    <script>

        var data = [
            ['ir-5428', 0],
            ['ir-hg', 1],
            ['ir-bs', 2],
            ['ir-kb', 3],
            ['ir-fa', 4],
            ['ir-es', 5],
            ['ir-sm', 6],
            ['ir-go', 7],
            ['ir-mn', 8],
            ['ir-th', 9],
            ['ir-mk', 10],
            ['ir-ya', 11],
            ['ir-cm', 12],
            ['ir-kz', 13],
            ['ir-lo', 14],
            ['ir-il', 15],
            ['ir-ar', 16],
            ['ir-qm', 17],
            ['ir-hd', 18],
            ['ir-za', 19],
            ['ir-qz', 20],
            ['ir-wa', 21],
            ['ir-ea', 22],
            ['ir-bk', 23],
            ['ir-gi', 24],
            ['ir-kd', 25],
            ['ir-kj', 26],
            ['ir-kv', 27],
            ['ir-ks', 28],
            ['ir-sb', 29],
            ['ir-ke', 30],
            ['ir-al', 31]
        ];

        // Create the chart
        Highcharts.mapChart('mapContainer', {

            credits: {
                enabled: true,
                href: '{{ asset('/') }}',
                text: 'آموزش مجازی آلاء'
            },

            title: {
                text: 'گزارش فروش محصولات'
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
                nullColor: 'red',
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

            credits: {
                enabled: true,
                href: '{{ asset('/') }}',
                text: 'آموزش مجازی آلاء'
            },

            chart: {
                zoomType: 'x'
            },

            title: {
                text: 'گزارش فروش محصولات'
            },

            subtitle: {
                text: 'فروش محصولات شما از تاریخ 1398/1/21 الی 1399/8/25'
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
                            y: 9
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
                            y: 6
                        }]
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

            credits: {
                enabled: true,
                href: '{{ asset('/') }}',
                text: 'آموزش مجازی آلاء'
            },

            chart: {
                zoomType: 'x'
            },

            title: {
                text: 'گزارش فروش محصولات'
            },

            subtitle: {
                text: 'فروش محصولات شما از تاریخ 1398/1/21 الی 1399/8/25'
            },

            tooltip: {
                useHTML: true,
                formatter: function() {
                    let unixTimestamp = this.x;
                    let persianDateValue = persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
                    let value = this.y;
                    return '<div>مقدار فروش: ' + value + ' تومان ' + '</div>'+'<div>'+persianDateValue+'</div>';
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
                            y: 9000
                        }]
                },
                {
                    name: 'محصول شماره دو',
                    data: [{
                            x: Math.round((new Date('2013/09/01 15:34:00')).getTime()/1000),
                            y: 800000
                        },
                        {
                            x: Math.round((new Date('2013/09/03 15:34:00')).getTime()/1000),
                            y: 400000
                        },
                        {
                            x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
                            y: 1400000
                        },
                        {
                            x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
                            y: 200000
                        },
                        {
                            x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
                            y: 1200000
                        }]
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



        
        
        

        
        Highcharts.chart('container', {
            chart: {
                type: 'networkgraph',
                height: '900px'
            },
            title: {
                text: 'لیست محصولات شما'
            },
            subtitle: {
                text: 'لیست درختی محصولات شما'
            },
            plotOptions: {
                networkgraph: {
                    keys: ['from', 'to'],
                    layoutAlgorithm: {
                        enableSimulation: true,
                        friction: -0.9
                    }
                }
            },
            series: [{
                dataLabels: {
                    enabled: true,
                    linkFormat: ''
                },
                data: [
                    
                    ['محصول مادر', 'محصول شماره دو'],
                    ['محصول مادر', 'محصول شماره سه'],
                    ['محصول مادر', 'محصول شماره چهار'],
                    ['محصول شماره یک', 'محصول شماره پنج'],
                    ['محصول شماره یک', 'محصول شماره پنج'],
                    ['محصول شماره پنج', 'محصول شماره شش'],
                    ['محصول شماره پنج', 'محصول شماره هفت'],
                    ['محصول شماره یک', 'محصول شماره هشت'],
                    ['محصول شماره یک', 'محصول شماره نه'],
                    ['محصول شماره یک', 'محصول شماره ده'],
                    ['محصول شماره یک', 'محصول شماره یازده'],
                    ['محصول شماره یک', 'محصول شماره دوازده'],
                    ['محصول شماره یک', 'محصول شماره سیزده'],
                    ['محصول شماره دو', 'محصول شماره چهارده'],
                    ['محصول شماره دو', 'محصول شماره پانزده'],
                    ['محصول شماره دو', 'محصول شماره شانزده'],
                    ['محصول شماره دو', 'محصول شماره هفده'],
                    ['محصول شماره سه', 'محصول شماره هجده'],
                    ['محصول شماره چهار', 'محصول شماره نوزده'],
                    ['محصول شماره چهار', 'محصول شماره بیست'],
                    ['محصول شماره چهار', 'محصول شماره بیست و یک'],
                    ['محصول شماره چهار', 'محصول شماره بیست و دو']
                ]
            }]
        });
        
        
        $(document).ready(function () {
           let highchartsCredits = $('.highcharts-credits').html();
           console.log('highchartsCredits: ', highchartsCredits);
            $('.highcharts-credits').html(highchartsCredits.replace('©', '').trim());
        });
        
        
    </script>
@endsection
