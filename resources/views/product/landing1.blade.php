@extends('partials.templatePage')
@section("headPageLevelPlugin")
    <link href = "/assets/pages/css/blog-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel = "stylesheet" type = "text/css"/>
@endsection
@section("headPageLevelStyle")
    <link href = "/assets/pages/css/portfolio-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/pages/css/coming-soon-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("pageBar")
@show

@section("contentClass")
    class="page-content blog-page blog-content-1"
@endsection

@section("content")
    {{--<div class="row" style="padding-bottom: 10px">--}}
    {{--<div class="col-md-12">--}}
    {{--<div class="blog-banner blog-container coming-soon-countdown text-center" style="background-image:url(http://takhtekhak.com/image/9/1280/500/clock_20171203125805.jpg); padding: 0px " >--}}
    {{--<h2 class="blog-title blog-banner-title">--}}
    {{--<a href="javascript:;">سبقت در پیچ اول رالی کنکور</a>--}}
    {{--</h2>--}}
    {{--<div class="row">--}}
    {{--<h3 class="font-white">سبقت در پیچ اول رالی کنکور</h3>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-4"></div>--}}
    {{--<div class="col-md-6 col-sm-12 col-xs-12">--}}
    {{--<div id="defaultCountdown"> </div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<img src="/img/extra/landing/banner-1.jpg" style="width: 100%">--}}
    {{--</div>--}}
    {{--</div>--}}




    <div class = "col-xs-12">
        <div class = "blog-banner blog-container" style = "background-image:url(https://takhtekhak.com/image/9/1280/500/clock_20171203125805.jpg);">
            <h2 class = "blog-title blog-banner-title">
                <a href = "javascript:">سبقت در پیچ اول رالی کنکور</a>
            </h2>
        </div>
    </div>
    <div class = "row">
        <div class = "col-md-3">
            {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
            {{--<img src="/img/extra/landing/hamayeshAD-256x56.jpg" style="width: 100%;">--}}
            {{--</div>--}}
            <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class = "dashboard-stat2 " style = "padding: 0px">

                    <div class = "progress-info" style = "font-style:italic">
                        <div class = "status" style = "font-size: medium">
                            <img src = "/img/extra/landing/hamayeshAD-256x56.jpg" style = "width: 100%;">
                        </div>

                    </div>
                </div>
            </div>
            {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
            {{--<div class="blog-page blog-content-1">--}}
            {{--<div class="blog-quote bordered blog-container">--}}
            {{--<div class="blog-quote-label bg-blue-madison" style="padding-top: 0px">--}}
            {{--<img src="/img/extra/landing/specialOffer.png" style="height: 100px;"></div>--}}
            {{--<div class="blog-quote-avatar">--}}
            {{--<a href="javascript:;">--}}
            {{--<img src="/img/extra/landing/5discount.jpg" />--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--<div class="blog-quote-author">--}}
            {{--<h3 class="blog-title blog-quote-title bold" style="font-size: 15px;">--}}
            {{--تخفیف ویژه--}}
            {{--</h3>--}}
            {{--<!--<p class="blog-quote-desc">تخفیف پیش فروش همایش ها</p>-->--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class = "dashboard-stat2 ">
                    <div class = "display">
                        <div class = "number">
                            <h3 class = "font-blue-sharp" style = "direction: ltr">
                                <span>۵ + ۱</span>
                            </h3>
                            <small>هر درس</small>
                        </div>
                        <div class = "icon">
                            <!--<i class="icon-like"></i>-->
                            <img src = "/img/extra/landing/like.png" style = "height: 40px;">
                        </div>
                    </div>
                    <div class = "progress-info" style = "font-style:italic">
                        <div class = "status" style = "font-size: small">
                            5 ساعت جمع بندی و نکته و تست داریم و 1 ساعت تست های پلاس مخصوص پزشکا و مهندسا
                        </div>

                    </div>
                </div>
            </div>
            <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class = "dashboard-stat2 ">
                    <div class = "display">
                        <div class = "number">
                            <h3 class = "font-green-sharp">
                                <span>۱/۳</span>
                                <!--<small class="font-green-sharp">$</small>-->
                            </h3>
                            <small>جمع بندی یک سوم کنکور</small>
                        </div>
                        <div class = "icon">
                            <i class = "icon-pie-chart font-green-sharp"></i>
                        </div>
                    </div>
                    <div class = "progress-info" style = "font-style:italic">
                        <div class = "progress">
                                    <span style = "width: 33%;" class = "progress-bar progress-bar-success green-sharp">
                                        <span class = "sr-only">76% progress</span>
                                    </span>
                        </div>
                        <div class = "status">
                            <div class = "status-title"> کنکور</div>
                            <div class = "status-number font-green-sharp"> ۳۳%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class = "dashboard-stat2 ">
                    <div class = "display">
                        <div class = "number">
                            <h3 class = "font-red-soft">
                                <span>ویژه دی ماه</span>
                            </h3>
                            <small>متناسب با تقویم کنکوری ها</small>
                        </div>
                        <div class = "icon">
                            <!--<i class="fa fa-calendar-check-o"></i>-->
                            <img src = "/img/extra/landing/calendar.png" style = "height: 40px;">
                        </div>
                    </div>
                    <div class = "progress-info" style = "font-style:italic">
                        <div class = "progress">
                                    <span style = "width: 100%;" class = "progress-bar progress-bar-success red-soft">
                                        <span class = "sr-only">45% grow</span>
                                    </span>
                        </div>
                        <div class = "status">
                            <div class = "status-title"></div>
                            <div class = "status-number font-red-soft"> ۱۰۰%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class = "dashboard-stat2 ">
                    <div class = "display">
                        <div class = "number">
                            <h3 style = "color: #d97200">
                                <span>اساتید آلاء</span>
                            </h3>
                            <small>اساتیدی که می شناسید</small>
                        </div>
                        <div class = "icon">
                            <!--<i class="icon-user"></i>-->
                            <img src = "/img/extra/landing/teacher-128.png" style = "height: 40px;">
                        </div>
                    </div>
                    <div class = "progress-info" style = "font-style:italic">
                        <div class = "progress">
                                    <span style = "width: 100%; background: #d97200" class = "progress-bar">
                                        <span class = "sr-only">۱۰۰٪ اساتید</span>
                                    </span>
                        </div>
                        <div class = "status">
                            <div class = "status-title"> همه اساتید</div>
                            <div class = "status-number " style = "color: #d97200"> ۱۰۰%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class = "col-md-9">
            <div class = "portfolio-content portfolio-3">
                <div class = "clearfix">
                    @if(isset($withFilter) && $withFilter)
                        <div id = "js-filters-lightbox-gallery2" class = "cbp-l-filters-button cbp-l-filters-right">
                            <div data-filter = "*" class = "cbp-filter-item-active cbp-filter-item btn blue btn-outline uppercase">همه
                            </div>
                            <div data-filter = ".تجربی" class = "cbp-filter-item btn blue btn-outline uppercase">تجربی</div>
                            <div data-filter = ".ریاضی" class = "cbp-filter-item btn blue btn-outline uppercase">ریاضی</div>
                            <div data-filter = ".انسانی" class = "cbp-filter-item btn blue btn-outline uppercase">انسانی
                            </div>
                        </div>
                    @endif
                </div>
                <div id = "js-grid-lightbox-gallery" class = "cbp">
                    @foreach( $landingProducts as $product)
                        <div class = "cbp-item @foreach ($product["majors"] as $major) {{ $major }} @endforeach">
                            <a href = "{{action("Web\ProductController@show" , $product["product"]->id)}}" class = "cbp-caption" data-title = "{{$product["product"]->name}}" rel = "nofollow">
                                <div class = "cbp-caption-defaultWrap">
                                    @if(isset($product["product"]->image[0]))
                                        <img src = "{{ $product["product"]->photo}}" alt = "عکس محصول@if(isset($product["product"]->name[0])) {{$product["product"]->name}} @endif">
                                </div>@endif
                                <div class = "cbp-caption-activeWrap">
                                    <div class = "cbp-l-caption-alignLeft">
                                        <div class = "cbp-l-caption-body">
                                            <div class = "cbp-l-caption-title">ثبت نام در همایش</div>
                                            @if($product["product"]->isFree)
                                                <div class = "cbp-l-caption-desc  bold m--font-danger product-potfolio-free">
                                                    رایگان
                                                </div>
                                            @elseif($product["product"]->basePrice == 0)
                                                <div class = "cbp-l-caption-desc  bold m--font-info product-potfolio-no-cost">
                                                    قیمت: پس از انتخاب محصول
                                                </div>
                                            @elseif($costCollection[$product["product"]->id]["productDiscount"]+$costCollection[$product["product"]->id]["bonDiscount"]>0)
                                                <div class = "cbp-l-caption-desc  bold m--font-danger product-potfolio-real-cost">@if(isset($costCollection[$product["product"]->id]["cost"])){{number_format($costCollection[$product["product"]->id]["cost"])}}
                                                    تومان@endif</div>
                                                <div class = "cbp-l-caption-desc  bold font-green product-potfolio-discount-cost">
                                                    فقط @if(Auth::check()) {{number_format((1 - ($costCollection[$product["product"]->id]["bonDiscount"] / 100)) * ((1 - ($costCollection[$product["product"]->id]["productDiscount"] / 100)) * $costCollection[$product["product"]->id]["cost"]))}} @else @if(isset($costCollection[$product["product"]->id]["cost"])){{number_format(((1-($costCollection[$product["product"]->id]["productDiscount"]/100))*$costCollection[$product["product"]->id]["cost"]))}}
                                                    تومان@endif @endif</div>
                                            @else
                                                <div class = "cbp-l-caption-desc bold font-green product-potfolio-no-discount">@if(isset($costCollection[$product["product"]->id]["cost"])){{number_format($costCollection[$product["product"]->id]["cost"])}}
                                                    تومان@endif </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src = "/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/countdown/jquery.countdown.min.js" type = "text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src = "/assets/pages/scripts/portfolio-3.min.js" type = "text/javascript"></script>
    <script src = "/assets/global/plugins/backstretch/jquery.backstretch.min.js" type = "text/javascript"></script>
    {{--<script src="/assets/pages/scripts/coming-soon.min.js" type="text/javascript"></script>--}}
    <script type = "text/javascript">
        var ComingSoon = function () {

            return {
                //main function to initiate the module
                init: function () {
                    var austDay = new Date();
                    austDay = new Date("2017-12-17");
                    $('#defaultCountdown').countdown({until: austDay});
                    $('#year').text(austDay.getFullYear());
                }

            };

        }();

        jQuery(document).ready(function () {
            ComingSoon.init();
        });
    </script>
@endsection
