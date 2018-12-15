<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    {!! SEO::generate(true) !!}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('assets\extra\landing5') }}/css/allcss.min.css">

    {{--<link rel="stylesheet" href="{{ asset('assets\extra\landing5') }}/css/bootstrap4.min.css">--}}
    {{--<link rel="stylesheet" href="{{ asset('assets\extra\landing5') }}/css/animate.css">--}}
    {{--<link rel="stylesheet" href="{{ asset('assets\extra\landing5') }}/css/style.css">--}}
    {{--<link rel="stylesheet" href="{{ asset('assets\extra\landing5') }}/css/fonts.css">--}}

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{Config('constants.google.analytics')}}"></script>
</head>
<body>

    <div class="progress"></div>

    <div class="container-fluid">

        <div class="warperOfFirstAndSecondSection row">

            <canvas class="particles-js"></canvas>

            <div id="section1" class="hero-wrap js-fullheight col-md-12 ss-window">
                {{--<div class="overlay"></div>--}}

                <div class="container">
                    <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
                        <div class="col-md-6 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
                            <h1 class="mb-4" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><img class="homePageHeaderHamaiesh" src="/assets/extra/landing3/images/sample/gold-fest.png" alt="همایش طلایی آلاء" ></h1>
                            <p><a href="#section2" class="btn btn-primary btn-outline-white px-5 py-3 btnGoToProductSection">مشاهده همایش ها</a></p>
                        </div>
                    </div>
                </div>

            </div>

            <div id="section2" class="col-md-12 pt-5 ss-window">

                <div class="col-md-12 ftco-section-featured ftco-animate">
                    <div class="section2 row" data-scrollax-parent="true">

                            <div class="col-md-12 align-items-center">
                                <div class="row no-gutters">

                                    <div class="col-md-12 text-center">
                                        <div class="row">
                                            <div class="col-md-4 col-12 text-center" ><button class="action-button shadow animate fullWidth green btnAllReshteShadow btnShowAllReshte">ریاضی و تجربی</button></div>
                                            <div class="col-md-4 col-6 text-center" ><button class="action-button shadow animate fullWidth red btnShowRiazi">ریاضی</button></div>
                                            <div class="col-md-4 col-6 text-center" ><button class="action-button shadow animate fullWidth blue btnShowTajrobi">تجربی</button></div>
                                        </div>



                                    </div>


                                    <div class="col-md-12">
                                        <div class="row align-items-center  justify-content-center">
                                            @foreach($products as $key=>$product)
                                                <div class="col-md-2 productTile {{ $product['type']  }}">
                                                    <a href="{{ $product['link']  }}" class="featured-img {{ $product['type']  }}">
                                                        <div class="text-1 p-4 d-flex align-items-center">
                                                            <h3>{{ $product['name']  }}<br>
                                                                <span class="tag">
                                                                    @if($product['type']=='tajrobi') تجربی
                                                                    @else ریاضی
                                                                    @endif
                                                                </span>
                                                            </h3>
                                                        </div>
                                                        <img src="{{ $product['image']  }}" class="img-fluid" alt="{{ $product['name']  }}">
                                                        <div class="text p-4 d-flex align-items-center">
                                                            <div class="user d-flex align-items-center">
                                                                <h3>
                                                                    @if($product['price']=='-') قیمت: پس از انتخاب محصول
                                                                    @else {{ $product['price'] }} تومان
                                                                    @endif
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>

                    </div>
                </div>
            </div>

            <div id="section3" class="Section3 col-md-12 ss-window">


                <div id="particles-js2"></div>

                <div class="row mt-5 d-flex justify-content-center">
                    <div class="col-md-10 text-center heading-section ftco-animate">
                        <h2 class="h2">دانلود نمونه فیلم همایش</h2>
                        <p>
                            <a href="#" class="btn btn-primary mt-3 py-1 px-2">
                                <img src="{{ asset('assets\extra\landing5\images\دانلود-نمونه-فیلم-همایش.png') }}" class="downloadVideoImage"/>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="row justify-content-center mb-3">
                    <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
                        <h3>با ماندگاری مطالب در ذهنتان، استرس را فراموش کنید!</h3>

                        <p>
                            چند ماه مانده به کنکور؛ دوران گیجی دانش‌آموزان است: آن‌هایی که زیاد خوانده‌اند دیوانه‌وار بیشتر و بیشتر
                            می‌خوانند و آن‌هایی که کمتر خوانده‌اند پناهشان می‌شود جزوات متعدد دم کنکور! اما چاره این سرگیجه چیست؟

                            با بررسی دلیل موفقیت برترین‌های کنکور در سال‌های متوالی یک نکته مهم در برطرف‌شدن این استرس نهفته است:
                            مرور در ماه‌های آخر!
                        </p>


                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-self-stretch ftco-animate text-center">
                        <div class="media block-6 services d-block text-center" style="margin: auto;">
                            <div class="d-flex justify-content-center">
                                <div class="icon color-3 d-flex justify-content-center mb-3">
                                    <i class="icon-brain-and-head" style="font-size: 40px;"></i>
                                </div>
                            </div>
                            <div class="media-body p-2 mt-1 mb-5">
                                <h3 class="heading">مفهومی</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex align-self-stretch ftco-animate text-center">
                        <div class="media block-6 services d-block text-center" style="margin: auto;">
                            <div class="d-flex justify-content-center">
                                <div class="icon color-1 d-flex justify-content-center mb-3">
                                    <i class="icon-transport" style="font-size: 40px;"></i>
                                </div>
                            </div>
                            <div class="media-body p-2 mt-1 mb-5">
                                <h3 class="heading">سبقت</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-self-stretch ftco-animate text-center">
                        <div class="media block-6 services d-block text-center" style="margin: auto;">
                            <div class="d-flex justify-content-center">
                                <div class="icon color-2 d-flex justify-content-center mb-3">
                                    <i class="icon-document" style="font-size: 40px;"></i>
                                </div>
                            </div>
                            <div class="media-body p-2 mt-1 mb-5">
                                <h3 class="heading">جزوه</h3>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-lg-3 d-flex align-self-stretch ftco-animate text-center">
                        <div class="media block-6 services d-block text-center" style="margin: auto;">
                            <div class="d-flex justify-content-center">
                                <div class="icon color-4 d-flex justify-content-center mb-3">
                                    <i class="icon-light-bulb" style="font-size: 40px;"></i>
                                </div>
                            </div>
                            <div class="media-body p-2 mt-1 mb-5">
                                <h3 class="heading">تحلیل</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
        </svg>
    </div>

    <script src="{{ asset('assets\extra\landing5') }}/js/alljs.min.js"></script>

    {{--<script src="{{ asset('assets\extra\landing5') }}/js/jquery.min.js"></script>--}}
    {{--<script src="{{ asset('assets\extra\landing5') }}/js/jquery-migrate-3.0.1.min.js"></script>--}}
    {{--<script src="{{ asset('assets\extra\landing5') }}/js/jquery.easing.1.3.js"></script>--}}
    {{--<script src="{{ asset('assets\extra\landing5') }}/js/jquery.waypoints.min.js"></script>--}}
    {{--<script src="{{ asset('assets\extra\landing5') }}/js/particles.js-master/dist/particles.js"></script>--}}
    {{--<script src="{{ asset('assets\extra\landing5') }}/js/modernizr-2.6.2.min.js"></script>--}}
    {{--<script src="{{ asset('assets\extra\landing5') }}/js/ninjaScroll.js"></script>--}}
    {{--<script src="{{ asset('assets\extra\landing5') }}/js/jquery.mousewheel.js"></script>--}}
    {{--<script src="{{ asset('assets\extra\landing5') }}/js/main.js"></script>--}}


</body>
</html>