<!DOCTYPE html>
<html class="no-js" lang="fa-IR" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Designer" content="Developed by Am!n">
    
    {!! SEO::generate(true) !!}

    <link rel="stylesheet" href="{{ asset('/acm/extra/donate/css/styles.min.css') }}">

    <script src="{{ asset('/acm/extra/donate/js/jquery-2.2.4.min.js') }}"></script>

    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('/acm/extra/donate/js/html5shiv.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/acm/extra/donate/js/respond.min.js') }}"></script><![endif]-->
</head>
<body>
<div class="wrapper site-wrap" id="site_wrap">
    <div class="hero">
        <h1 class="hero-title">
            <span class="helps-farsi"></span>
            مجری طرح توسعه عدالت آموزشی
        </h1>

        <img class="hearts" src="{{ asset('/acm/extra/donate/images/hearts.png') }}" alt="hearts">

        {!! Form::open(['method'=>'POST' , 'action'=>'Web\OrderController@donateOrder' , 'class'=>'donation-form']) !!}
        <p>با کمک های شما عزیزان مجموعه آلا به راحتی بر روی کیفیت خدمات کار می کند</p>

        <div class="textfield">
            <input type="text" placeholder="مبلغ مورد نظر شما" name="amount" id="amount">
            <span class="suffix">تومان</span>
        </div><!-- .textfield -->

        <button id="btnDonationNow">همین الان کمک می کنم</button>
        {!! Form::close() !!}

    </div><!-- .hero -->

    <div class="last-donations container">
        <div class="row">
            <div class="recent-donators">
                <h3>آخرین کمک های هفته</h3>
                @if($latestDonors->isEmpty())
                    <div class="hero" style="margin-bottom: 200px">
                        <h2>کمکی نشده</h2>
                    </div>
                @else
                    <ul class="list">
                        @foreach($latestDonors as $latestDonor )
                            <li>
                                <div class="donator">
                                    <img src="{{$latestDonor["avatar"]}}" alt="donator">

                                    <span class="name">
                                    {{(strlen($latestDonor["firstName"])>0)?$latestDonor["firstName"]:""}} {{(strlen($latestDonor["lastName"])>0)?$latestDonor["lastName"]:""}}
                                </span>
                                    <span class="price">{{number_format($latestDonor["donateAmount"])}} <span class="currency">تومان</span></span>
                                </div><!-- .donator -->
                            </li>
                        @endforeach

                    </ul>
                @endif
            </div><!-- .recent-donators -->

            <div class="best-donators">
                <h3>بیشترین کمک های {{$currentJalaliMonthString}}</h3>
                @if($maxDonors->isEmpty())
                    <div class="hero" style="margin-bottom: 200px">
                        <h2>کمکی نشده</h2>
                    </div>
                @else
                    <ul class="list">
                        @foreach($maxDonors as $maxDonor )
                            <li>
                                <div class="donator">
                                    <img src="{{ $maxDonor["avatar"] }}" alt="donator">

                                    <span class="name">
                                        {{(strlen($maxDonor["firstName"])>0)?$maxDonor["firstName"]:""}} {{(strlen($maxDonor["lastName"])>0)?$maxDonor["lastName"]:""}}
                                    </span>
                                    <span class="price">{{number_format($maxDonor["donateAmount"])}} <span class="currency">تومان</span></span>
                                </div><!-- .donator -->
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div><!-- .recent-donators -->

        </div><!-- .row -->

    </div>
          <!-- .last-donations -->

    <div class="best-donators  container" style="margin-bottom: 25px">
        <div class="row">
            <div class="col-md-12">
                <div class="donator">
                    <h3>به هر میزان که می توانید در تامین هزینه های آلاء مشارکت نمایید.</h3>
                    <p style="  text-align: justify">مشارکت اختیاری بوده و از نظر شرعی آلاء متعهد می شود که این مشارکت ها را برای حفظ، نگهداری، توسعه و بهبود خدمات خود استفاده کند.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="monthly-charts">
        <div class="container">
            <div class="totals">

                <div class="total">
                    <span class="title">مجموع دونیت ها</span>

                    <span class="amount">{{number_format($totalIncome)}}<span class="currency">تومان</span></span>
                    <span class="title">از 1 مهر تا {{$currentJalaliDateString}}</span>
                </div><!-- .title -->

                <div class="total">
                    <span class="title">مجموع هزینه ها</span>

                    <span class="amount">{{number_format($totalSpend)}}<span class="currency">تومان</span></span>
                    <span class="title">از 1 مهر تا {{$currentJalaliDateString}}</span>
                </div><!-- .title -->

            </div><!-- .totals -->

            <div class="chart-by-month">
                <canvas id="monthlychart"></canvas>
            </div><!-- .chart-by-month -->

        </div><!-- .container -->

    </div><!-- .monthly-charts -->

    {{--<div class="provinces-charts">--}}
    {{--<div class="container">--}}
    {{--<div class="chart-by-province">--}}
    {{--<canvas id="provincecharts"></canvas>--}}

    {{--</div><!-- .chart-by-province -->--}}

    {{--<div class="province-donations">--}}
    {{--<h3>مجموع دونیت های پرداخت شده <strong>استان ها</strong></h3>--}}

    {{--<ul class="list">--}}
    {{--<li>--}}
    {{--<span class="color" style="background-color: #ff839c"></span>--}}
    {{--<span class="province">تهران</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #c7c7c7"></span>--}}
    {{--<span class="province">فارس</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #dadada"></span>--}}
    {{--<span class="province">اصفهان</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #39e4ce"></span>--}}
    {{--<span class="province">خراسان</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #2ae58b"></span>--}}
    {{--<span class="province">کرمان</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #ff839c"></span>--}}
    {{--<span class="province">بوشهر</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #dadada"></span>--}}
    {{--<span class="province">اهواز</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #ff839c"></span>--}}
    {{--<span class="province">تهران</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #c7c7c7"></span>--}}
    {{--<span class="province">فارس</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #dadada"></span>--}}
    {{--<span class="province">اصفهان</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #39e4ce"></span>--}}
    {{--<span class="province">خراسان</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #2ae58b"></span>--}}
    {{--<span class="province">کرمان</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #ff839c"></span>--}}
    {{--<span class="province">بوشهر</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--<li>--}}
    {{--<span class="color" style="background-color: #dadada"></span>--}}
    {{--<span class="province">اهواز</span>--}}
    {{--<span class="amount">390,000</span>--}}
    {{--</li>--}}

    {{--</ul>--}}

    {{--</div><!-- .province-donations -->--}}

    {{--</div><!-- .container -->--}}

    {{--</div><!-- .provinces-charts -->--}}

    <footer class="site-footer">
        <a class="copyright" href="{{action("Web\IndexPageController")}}">
            <img src="/acm/extra/donate/images/copyright.png" alt="Copyright">
        </a>
    </footer>

</div><!-- #site_wrap -->

<script src="/acm/extra/donate/js/Chart.bundle.min.js"></script>

<script>
    var MONTHS = {!! $chartData->pluck("month")->toJson() !!};
    
    var config = {
        type: 'line',
        data: {
            labels: MONTHS,
            datasets: [{
                label: 'مجموع دونیت ها',
                backgroundColor: '#49aaed',
                borderColor: '#49aaed',
                data: [
                    @foreach($chartData as $chartDatum)
                    {{$chartDatum["totalIncome"]}},
                    @endforeach
                ],
                fill: false,
            }, {
                label: 'مجموع هزینه ها',
                fill: false,
                backgroundColor: '#ff597c',
                borderColor: '#ff597c',
                data: [
                    @foreach($chartData as $chartDatum)
                    {{$chartDatum["totalSpend"]}},
                    // 25000000,
                    @endforeach
                ],
            }]
        },
        options: {
            elements: {
                line: {
                    tension: 0
                }
            },
            responsive: true,
            title: {
                display: false,
                text: 'مجموع دونیت ها / مجموع هزینه ها'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function (tooltipItem, data) {
                        return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    },
                },
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: ''
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: ''
                    },
                    ticks: {
                        callback: function (label, index, labels) {
                            var amount = label / 1000000;
                            if (amount < 1) {
                                amount = amount * 1000;
                                return amount + " هزار تومان";
                            }
                            return amount + " میلیون تومان";

                        },
                        beginAtZero: true,
                        max: 25000000,
                    },

                }]
            }
        }
    };
    
    var config2 = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    40,
                    4,
                    15,
                    19,
                    22,
                    18,
                ],
                backgroundColor: [
                    '#c7c7c7',
                    '#dadada',
                    '#2ae58b',
                    '#39e4ce',
                    '#ffd555',
                    '#ff839c',
                ],
                label: 'دونیت ها بر اساس استان'
            }],
            labels: [
                'فارس',
                'تهران',
                'اصفهان',
                'یزد',
                'هرمزگان',
                'بوشهر'
            ]
        },
        options: {
            responsive: true,
            legend: {display: false}
        }
    };

    window.onload = function () {
        var ctx = document.getElementById('monthlychart').getContext('2d');
        window.myLine = new Chart(ctx, config);

        var ctxx = document.getElementById('provincecharts').getContext('2d');
        window.myPie = new Chart(ctxx, config2);
    };
    
    $(document).ready(function () {
        $(document).on('click', '#btnDonationNow', function (e) {
            let amount = $('#amount').val();

            $.ajax({
                type: 'POST',
                url : '/api/v1/donate',
                data: data,
                dataType: 'json',

                success: function (data) {
                    if (data.url) {
                        window.location = data.url;
                    } else {
                        alert('مشکلی پیش آمده است. مجددا سعی کنید.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('مشکلی پیش آمده است. مجددا سعی کنید.');
                }

            });
        });
    });
</script>

</body>

</html>
