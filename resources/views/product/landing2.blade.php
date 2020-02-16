@extends('partials.templatePage')

@section("headPageLevelPlugin")
    <link href = "/assets/pages/css/blog-rtl.min.css" rel = "stylesheet" type = "text/css"/>
@endsection

@section("headPageLevelStyle")
    <link href = "/assets/pages/css/contact-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <link href = "/assets/pages/css/pricing-rtl.min.css" rel = "stylesheet" type = "text/css"/>
    <style>
        .pricing-content-1 .price-table-pricing > h3 {
            font-size: 40px !important;
        }
    </style>
@endsection

@section("bodyClass")
    class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md blog-page blog-content-1"
@endsection

@section("pageBar")
@endsection

@section("content")
    <div class = "row">
        <div class = "col-xs-12">
            <div class = "blog-banner blog-container" style = "background-image:url(https://takhtekhak.com/image/9/1280/500/Untitled-1_20180213153803.jpg);">
                <h2 class = "blog-title blog-banner-title">
                    <a href = "javascript:">اردوطلایی: سبقت در پیچ دوم رالی کنکور</a>
                </h2>
            </div>
        </div>
    </div>
    <div class = "row widget-row">
        <div class = "col-md-12">
            <div class = "mt-element-card mt-element-overlay">
                <div class = "row">
                    <div class = "col-md-3">
                        <div class = "mt-card-item">
                            <div class = "mt-card-avatar mt-overlay-7">
                                <img id = "b1" src = "https://takhtekhak.com/image/9/582/280/box-1_20180213165237.jpg"/>
                                <div class = "mt-overlay">
                                    <h2 style = "padding: 0">نشست با رتبه 1 کنکور 95</h2>
                                    <div class = "mt-info font-white">
                                        <div class = "mt-card-content">
                                            <p class = "mt-card-desc font-white">اردوطلایی 96</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-3">
                        <div class = "mt-card-item">
                            <div class = "mt-card-avatar mt-overlay-7">
                                <img src = "https://takhtekhak.com/image/9/582/280/ordu2-new_20180215143133.jpg"/>
                                <div class = "mt-overlay">
                                    <h2 style = "padding: 0">مشاوره فردی</h2>
                                    <div class = "mt-info font-white">
                                        <div class = "mt-card-content">
                                            <p class = "mt-card-desc font-white">اردوطلایی 96</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class = "col-md-3">
                        <div class = "mt-card-item">
                            <div class = "mt-card-avatar mt-overlay-7">
                                <img src = "https://takhtekhak.com/image/9/582/280/box-3_20180213165250.jpg"/>
                                <div class = "mt-overlay">
                                    <h2 style = "padding: 0">کلاس آموزشی</h2>
                                    <div class = "mt-info font-white">
                                        <div class = "mt-card-content">
                                            <p class = "mt-card-desc font-white">اردوطلایی 96</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-3">
                        <div class = "mt-card-item">
                            <div class = "mt-card-avatar mt-overlay-7">
                                <img src = "https://takhtekhak.com/image/9/582/280/box-2_20180213165244.jpg"/>
                                <div class = "mt-overlay">
                                    <h2 style = "padding: 0">برنامه های تفریحی</h2>
                                    <div class = "mt-info font-white">
                                        <div class = "mt-card-content">
                                            <p class = "mt-card-desc font-white">اردوطلایی 96</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class = "portlet light portlet-fit ">
        {{--<div class="portlet-title">--}}
        {{--<div class="caption">--}}
        {{--<i class="icon-share font-green"></i>--}}
        {{--<span class="caption-subject font-green bold uppercase">Pricing 1</span>--}}
        {{--</div>--}}
        {{--<div class="actions">--}}
        {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
        {{--<i class="icon-cloud-upload"></i>--}}
        {{--</a>--}}
        {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
        {{--<i class="icon-wrench"></i>--}}
        {{--</a>--}}
        {{--<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>--}}
        {{--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">--}}
        {{--<i class="icon-trash"></i>--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class = "portlet-body">
            <div class = "pricing-content-1">
                <div class = "row">
                    <div class = "col-md-4">
                        <div class = "price-column-container border-active">
                            <div class = "price-table-head" style = "background: #ee5a29 !important;">
                                <h2 class = "no-margin">حضوری</h2>
                            </div>
                            <div class = "arrow-down" style = "border-top-color: #ee5a29 !important;"></div>
                            <div class = "price-table-pricing">
                                <h3>
                                    <sup class = "price-sign">تومان</sup>
                                    <span style = "@if($costCollection[184]["productDiscount"]>0)text-decoration: line-through;@endif">@if(isset($costCollection[184]["cost"])){{number_format($costCollection[184]["cost"])}} @endif</span>
                                </h3>
                                @if($costCollection[184]["productDiscount"]>0)
                                    <p>@if(isset($costCollection[184]["cost"])){{number_format(((1-($costCollection[184]["productDiscount"]/100))*$costCollection[184]["cost"]))}} @endif</p>@endif
                            </div>
                            <div class = "price-table-content">
                                <div class = "row mobile-padding">
                                    <div class = "col-xs-3 text-right mobile-padding">
                                        <i class = "fa fa-calendar"></i>
                                    </div>
                                    <div class = "col-xs-9 text-left mobile-padding">2 الی 12 فروردین</div>
                                </div>
                                <div class = "row mobile-padding">
                                    <div class = "col-xs-3 text-right mobile-padding">
                                        <i class = "fa fa-briefcase"></i>
                                    </div>
                                    <div class = "col-xs-9 text-left mobile-padding">برنامه ریزی</div>
                                </div>
                                <div class = "row mobile-padding">
                                    <div class = "col-xs-3 text-right mobile-padding">
                                        <i class = "fa fa-star"></i>
                                    </div>
                                    <div class = "col-xs-9 text-left mobile-padding"> رفع اشکال</div>
                                </div>
                                <div class = "row mobile-padding">
                                    <div class = "col-xs-3 text-right mobile-padding">
                                        <i class = "fa fa-map-marker"></i>
                                    </div>
                                    <div class = "col-xs-9 text-left mobile-padding">محلی مناسب برای مطالعه</div>
                                </div>
                                <div class = "row mobile-padding">
                                    <div class = "col-xs-3 text-right mobile-padding">
                                        <i class = "icon-heart"></i>
                                    </div>
                                    <div class = "col-xs-9 text-left mobile-padding">برنامه های متنوع درسی و تفریحی</div>
                                </div>
                            </div>
                            <div class = "arrow-down arrow-grey"></div>
                            <div class = "price-table-footer">
                                {{--<a href="{{action("Web\ProductController@show", 184) }}" class="btn green btn-outline sbold uppercase price-button">اطلاعات اردو دختران</a>--}}

                                {{--<a href="{{action("Web\ProductController@show", 184) }}" class="btn green btn-outline price-button sbold uppercase">اطلاعت اردو پسران</a>--}}
                                <a href = "{{action("Web\ProductController@show", 184) }}" class = "btn green btn-outline sbold uppercase price-button">اطلاعات اردوی حضوری</a>
                            </div>
                        </div>
                    </div>

                    {{--<div class="col-md-4">--}}
                    {{--<div class="price-column-container border-active">--}}
                    {{--<div class="price-table-head" style="background: #3a0256 !important;">--}}
                    {{--<h2 class="no-margin">غیرحضوری</h2>--}}
                    {{--</div>--}}
                    {{--<div class="arrow-down" style="border-top-color: #3a0256 !important;"></div>--}}
                    {{--<div class="price-table-pricing">--}}
                    {{--<h3>--}}
                    {{--<sup class="price-sign">تومان</sup><span style="@if($costCollection[$gheireHozoori]["productDiscount"]>0)text-decoration: line-through;@endif">@if(isset($costCollection[$gheireHozoori]["cost"])){{number_format($costCollection[$gheireHozoori]["cost"])}} @endif</span></h3>--}}
                    {{--@if($costCollection[$gheireHozoori]["productDiscount"]>0)<p>@if(isset($costCollection[$gheireHozoori]["cost"])){{number_format(((1-($costCollection[$gheireHozoori]["productDiscount"]/100))*$costCollection[$gheireHozoori]["cost"]))}} @endif</p>@endif--}}
                    {{--<div class="price-ribbon" style="background-color: #f9e603 !important; color:black!important;">جدید</div>--}}
                    {{--</div>--}}
                    {{--<div class="price-table-content">--}}
                    {{--<div class="row mobile-padding">--}}
                    {{--<div class="col-xs-3 text-right mobile-padding">--}}
                    {{--<i class="fa fa-briefcase"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-left mobile-padding" style="font-size: small">برنامه و دفترچه شخصی سازی شده عید </div>--}}
                    {{--</div>--}}
                    {{--<div class="row mobile-padding">--}}
                    {{--<div class="col-xs-3 text-right mobile-padding">--}}
                    {{--<i class="icon-drawer"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-left mobile-padding" style="font-size: small">پاسخگویی به سوالات درسی در طول عید</div>--}}
                    {{--</div>--}}
                    {{--<div class="row mobile-padding">--}}
                    {{--<div class="col-xs-3 text-right mobile-padding">--}}
                    {{--<i class="icon-cloud-download"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-left mobile-padding" style="font-size: small">مشاوره و پشتیبانی در طول عید</div>--}}
                    {{--</div>--}}
                    {{--<div class="row mobile-padding">--}}
                    {{--<div class="col-xs-3 text-right mobile-padding">--}}
                    {{--<i class="icon-refresh"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-left mobile-padding" style="font-size: small">برنامه و دفترچه قبل و بعد از عید</div>--}}
                    {{--</div>--}}
                    {{--<div class="row mobile-padding">--}}
                    {{--<div class="col-xs-3 text-right mobile-padding">--}}
                    {{--<i class="icon-refresh"></i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-9 text-left mobile-padding" style="font-size: small">برنامه شخصی 60 روز تا کنکور</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="arrow-down arrow-grey"></div>--}}
                    {{--<div class="price-table-footer">--}}
                    {{--<a href="{{action("Web\ProductController@show", Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ROOT")) }}?dp={{$gheireHozoori}}" class="btn green btn-outline sbold uppercase price-button">اطلاعات اردوطلایی غیر حضوری</a>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    <div class = "col-md-4">
                        <div class = "mt-element-ribbon bg-grey-steel">
                            <div class = "ribbon ribbon-vertical-left ribbon-color-warning uppercase">
                                <div class = "ribbon-sub ribbon-bookmark"></div>
                                <i class = "fa fa-star"></i>
                            </div>
                            <p class = "ribbon-content">
                                اردو طلایی بهترین فرصت سبقت در کورس کنکور در این 10 روز که پیش مایی یاد می گیری که چطور درس بخونی، چی بخونی و چی نخونی
                            </p>
                        </div>
                        <div class = "mt-element-ribbon bg-grey-steel">
                            <div class = "ribbon ribbon-right ribbon-vertical-right ribbon-shadow ribbon-border-dash-vert ribbon-color-primary uppercase">
                                <div class = "ribbon-sub ribbon-bookmark"></div>
                                <i class = "fa fa-star"></i>
                            </div>
                            <p class = "ribbon-content">
                                تو خونه باش! ولی اردوی مطالعاتی عید داشته باش مشاور ما صبح به صبح پی گیری می کنه شما رو که طبق برنامه پیش بری
                            </p>
                        </div>
                        <div class = "mt-element-ribbon bg-grey-steel">
                            <div class = "ribbon ribbon-vertical-left ribbon-color-warning uppercase">
                                <div class = "ribbon-sub ribbon-bookmark"></div>
                                <i class = "fa fa-star"></i>
                            </div>
                            <p class = "ribbon-content">
                                عید نوبت توعه که جلو بیافتی؛ با نظارت دبیرستان دانشگاه شریف عید با اردو طلایی بهترین و آخرین فرصت برای سبقت از بقیه است.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class = "c-content-feedback-1 c-option-1">
        <div class = "row">
            <div class = "col-md-12 text-center">
                <div class = "c-container bg-green">
                    <div class = "c-content-title-1 c-inverse">
                        <h3 class = "uppercase">درباره اردو سوال داری؟
                            <a href = "https://telegram.me/sanati_sharif" class = "btn blue">
                                <i class = "fa fa-telegram fa-lg" aria-hidden = "true"></i>
                                تو تلگرام بپرس
                            </a>
                        </h3>
                        {{--<div class="c-line-left"></div>--}}
                        {{--<p class="c-font-lowercase">تو تلگرام از پشتیبان بپرس</p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .mt-element-overlay .mt-overlay-7 {
            width: 100%;
            height: 100%;

            overflow: hidden;
            position: relative;
            text-align: center;
            cursor: default;
        }

        .mt-element-overlay .mt-overlay-7 img {
            display: block;
            position: relative;
            -webkit-transition: all .4s cubic-bezier(.88, -.99, 0, 1.81);
            transition: all .4s cubic-bezier(.88, -.99, 0, 1.81);
            width: 100%;
            height: auto;
        }

        .mt-element-overlay .mt-overlay-7 h2 {
            text-transform: uppercase;
            color: #fff;
            text-align: center;
            position: relative;
            font-size: 17px;
            background: rgba(0, 0, 0, .6);
            -ms-transform: translatey(0);
            -webkit-transform: translatey(0);
            transform: translatey(0)
            padding: 10px;
        }

        .mt-element-overlay .mt-overlay-7 .mt-info {
            display: inline-block;
            text-transform: uppercase;
            opacity: 1;
            -webkit-transition: all .4s ease;
            transition: all .4s ease;
            margin: 50px 0 0
        }

        .mt-element-overlay .mt-overlay-7:hover .mt-info, .mt-element-overlay .mt-overlay-7:hover h2 {
            opacity: 0;

            -webkit-transform: translatey(-100px);
            -ms-transform: translatey(-100px);
            transform: translatey(-100px);
            -webkit-transition: all .4s cubic-bezier(.88, -.99, 0, 1.81);
            transition: all .4s cubic-bezier(.88, -.99, 0, 1.81);

        }

        .mt-element-overlay .mt-overlay-7:hover .mt-info {
            -webkit-transition-delay: .2s;
            transition-delay: .2s
        }

        .mt-element-overlay .mt-overlay-7 .mt-overlay {
            width: 100%;
            height: 100%;
            position: absolute;
            overflow: hidden;
            top: 0;
            right: 0;
            background-color: rgba(0, 0, 0, .7);
            -webkit-transition: all .4s cubic-bezier(.88, -.99, 0, 1.81);
            transition: all .4s cubic-bezier(.88, -.99, 0, 1.81);
            opacity: 1
        }

        .mt-element-overlay .mt-overlay-7:hover .mt-overlay {
            opacity: 0;
        }

        .mt-element-overlay .mt-overlay-7.mt-overlay-7-icons .mt-info {
            border: none;
            position: absolute;
            padding: 0;
            top: 50%;
            right: 0;
            left: 0;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            margin: auto
        }

        .mt-element-overlay .mt-overlay-7.mt-overlay-7-icons .mt-info:hover {
            box-shadow: none
        }

        .mt-element-overlay .mt-overlay-7.mt-overlay-7-icons .mt-info > li {
            list-style: none;
            display: inline-block;
            margin: 0 3px
        }

        .mt-element-overlay .mt-overlay-7.mt-overlay-7-icons .mt-info > li:hover {
            -webkit-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
            cursor: pointer
        }

    </style>
@endsection
