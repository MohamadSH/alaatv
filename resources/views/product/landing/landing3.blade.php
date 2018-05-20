<!DOCTYPE html>
<html dir="rtl" lang="fa-IR" class="no-js">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="application-name" content="" />
    <meta name="google" content="notranslate" />

    <meta name="google-site-verification" content="" />
    <meta name="alexaVerifyID" content="" />
    <meta name="norton-safeweb-site-verification" content="" />

    <meta name="designer" content="https://ivahid.com" />
    <meta name="copyright" content="&copy; 2017 ivahid.com" />
    <link rel="license" href="https://ivahid.com" />

    <link rel="author" href="" />
    <meta itemprop="name" content="" />
    <meta itemprop="description" content="" />
    <meta itemprop="image" content="" />

    <meta name="theme-color" content="#f7b519" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-title" content="Alaa" />
    <meta name="msapplication-tooltip" content="" />
    <meta name="msapplication-starturl" content="" />
    <meta name="msapplication-navbutton-color" content="" />
    <meta name="msapplication-TileColor" content="" />
    <meta name="screen-orientation" content="portrait" />
    <meta name="full-screen" content="yes" />
    <meta name="imagemode" content="force" />
    <meta name="layoutmode" content="fitscreen" />
    <meta name="wap-font-scale" content="no" />

    {!! SEO::generate(true) !!}
    <link rel="index" href="javascript:void(0)" />

    <title></title>

    <link rel="stylesheet" href="/assets/extra/landing3/css/stylesheet3.css" />
    <!--[if lt IE 10]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexibility/2.0.1/flexibility.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{Config('constants.google.analytics')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        var dimensionValue = '{{ request()->ip() }}';

        gtag('js', new Date());
        gtag('config', "{{Config('constants.google.analytics')}}", {
            'custom_map': {'dimension2': 'dimension2'}
        });
        @if(Auth::check())
            gtag('set', {'user_id': '{{ Auth::user() ->id }}'}); // Set the user ID using signed-in user_id.
        @endif
        // Sends the custom dimension to Google Analytics.
        gtag('event', 'hit', {'dimension2': dimensionValue});
    </script>
    @section("gtagJs")

    @show
</head>

<body>
<div class="wrapper" id="main-page">
    <header class="site-header">
        <section class="header-top">
            {{--<article class="sigin-login">--}}
                {{--<a href="javascript:void(0)" title="ورود">--}}
                    {{--<bdi class="bdi-sig-log">--}}
                        {{--<i class="icon-social-1"></i>--}}
                    {{--</bdi>--}}
                {{--</a>--}}
                {{--<a href="javascript:void(0)" class="a-login" title="ورود">--}}
                    {{--ورود--}}
                {{--</a>--}}
                {{--<a href="javascript:void(0)" class="a-sigin" title="ثبت نام">--}}
                    {{--ثبت نام--}}
                {{--</a>--}}
            {{--</article>--}}
            <nav class="nav-primary-menu" role="navigation">
                <ul class="primary-menu">
                    <li>
                        <a href="{{action("HomeController@index")}}" title="صفحه اصلی">صفحه اصلی</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-role="210" class="checkout" title="خرید همایش">همایش ادبیات دکتر سبطی </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-role="211" class="checkout" title="خرید همایش">همایش دینی خانم کاغذی</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-role="212" class="checkout" title="خرید همایش">همایش زیست شناسی دکتر چلاجور</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-role="213" class="checkout" title="خرید همایش">همایش زمین شناسی دکتر چلاجور</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-role="214" class="checkout" title="خرید همایش">همایش عربی مهندس ناصح زاده</a>
                    </li>
                </ul>
                <div class="swiper-container menu-res">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="{{action("HomeController@index")}}" title="آلاء - دبیرستان دانشگاه شریف">صفحه اصلی</a>
                        </div>
                        <div class="swiper-slide">
                            <a href="javascript:void(0)" data-role="210" class="checkout" title="همایش ادبیات دکتر سبطی">همایش ادبیات دکتر سبطی </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="javascript:void(0)" data-role="211" class="checkout" title="همایش دین و زندگی کاغذی">همایش دین و زندگی کاغذی</a>
                        </div>
                        <div class="swiper-slide">
                            <a href="javascript:void(0)" data-role="212" class="checkout" title="همایش زیست دکتر چلاجور">همایش زیست شناسی دکتر چلاجور</a>
                        </div>
                        <div class="swiper-slide">
                            <a href="javascript:void(0)" data-role="213" class="checkout" title="همایش زمین شناسی دکتر چلاجور">همایش زمین شناسی دکتر چلاجور</a>
                        </div>
                        <div class="swiper-slide">
                            <a href="{{action("HomeController@contactUs")}}" title="تماس با ما">تماس با ما</a>
                        </div>
                    </div>
                    <!-- <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div> -->
                </div>
            </nav>
        </section>
    </header>
    <main>
        <div class="container main-landing">
            <section class="res-gold-fest">
                <figure>
                    <header class="header-none">
                        <h2></h2>
                    </header>
                    <a href="javascript:void(0)">
                        <img src="/assets/extra/landing3/images/sample/gold-fest.png" alt="همایش طلایی آلاء" >
                    </a>
                </figure>
            </section>
            <section class="content-field">
                <div class="row p30">
                    <div class="col-md-9">
                        <article class="art-img-content-field">
                            <header class="header-main">
                                <a href="javascript:void(0)" title="همه رشته ها">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/tablighat/1.png" alt="همایش کنکور همه رشته ها" title="همه رشته ها">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                            <header class="header-res">
                                <a href="javascript:void(0)" title="همه رشته ها">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/sample/res-all.png" alt="همایش کنکور همه رشته ها" title="همه رشته ها">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                        </article>
                    </div>
                    <div class="col-md-15">
                        <article class="art-slider-field">
                            <div class="swiper-container swiper-content-field swiper-content-field-all">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title all">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="210" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G9.png" alt="همایش طلایی ادبیات کنکور دکتر سبطی آلاء" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="210" class="checkout" title="">
                                                            <h1>
                                                                <span>ادبیات</span>
                                                                <em>دکتر سبطی</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title all">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="211" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G10.png" alt="همایش طلایی دین و زندگی کنکور آلاء" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="211" class="checkout" title="">
                                                            <h1>
                                                                <span>دینی</span>
                                                                <em>کاغذی</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title all">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="216" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/1.png" alt="همایش طلایی فیزیک کنکور آلاء" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="216" class="checkout" title="">
                                                            <h1>
                                                                <span>فیزیک</span>
                                                                <em>دکتر طلوعی</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title all">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="217" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G7.png" alt="همایش طلایی شیمی کنکور آلاء" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="217" class="checkout" title="">
                                                            <h1>
                                                                <span>شیمی</span>
                                                                <em>صنیعی</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title all">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="214" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G2.png" alt="همایش طلایی عربی کنکور آلاء" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="214" class="checkout" title="">
                                                            <h1>
                                                                <span>عربی</span>
                                                                <em style="font-size: 4rem !important;">ناصح زاده</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>

                                    {{--<div class="swiper-slide">--}}
                                        {{--<article class="item-content-field">--}}
                                            {{--<bdi class="bdi-title all">--}}
                                                {{--<em>مشترک</em>--}}
                                            {{--</bdi>--}}
                                            {{--<figure>--}}
                                                {{--<a href="javascript:void(0)" data-role="215" class="checkout" title="">--}}
                                                    {{--<img src="/assets/extra/landing3/images/professors/G8.png" alt="" title="">--}}
                                                {{--</a>--}}
                                                {{--<figcaption>--}}
                                                    {{--<header>--}}
                                                        {{--<a href="javascript:void(0)" data-role="215" class="checkout" title="">--}}
                                                            {{--<h1>--}}
                                                                {{--<span>عربی</span>--}}
                                                                {{--<em>آهویی</em>--}}
                                                            {{--</h1>--}}
                                                        {{--</a>--}}
                                                    {{--</header>--}}
                                                    {{--<strong>--}}
                                                            {{--<span class="span-gold">--}}
                                                                {{--همایش طـــلایی--}}
                                                            {{--</span>--}}
                                                        {{--<bdi class="prsent">--}}
                                                            {{--<i>80%</i>--}}
                                                            {{--<em> کــــنـکور</em>--}}
                                                        {{--</bdi>--}}
                                                    {{--</strong>--}}
                                                {{--</figcaption>--}}
                                            {{--</figure>--}}
                                        {{--</article>--}}
                                    {{--</div>--}}

                                </div>
                            </div>
                            <i class="icon-right-arrow i-all-next r0 i-all i-swiper-content"></i>
                            <i class="icon-left-arrow i-all-prev l0 i-all i-swiper-content"></i>
                        </article>
                    </div>
                </div>
            </section>

            <section class="sec-dwon-sample sec-res-down-sample" style="display: none">
                <a href="javascript:void(0)" class="down-sample" title="دانلود نمونه جزوه">
                        <span>
                            ارسال کد ۳۳۳ به ۵۰۰۰۱۰۴۰۹۲۳۲ برای دریافت نمونه جزوه
                        </span>
                </a>
            </section>

            <section class="content-field">
                <div class="row p30">
                    <div class="col-md-9">
                        <article class="art-img-content-field">
                            <header class="header-main">
                                <a href="javascript:void(0)" title="رشته تجربی">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/tablighat/2.png" alt="رشته تجربی" title="رشته تجربی">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                            <header class="header-res">
                                <a href="javascript:void(0)" title="رشته تجربی">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/sample/res-experiential.png" alt="رشته تجربی" title="رشته تجربی">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                        </article>
                    </div>
                    <div class="col-md-15">
                        <article class="art-slider-field">
                            <div class="swiper-container swiper-content-field swiper-content-field-experiential">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title experiential">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="213" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G1.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="213" class="checkout" title="">
                                                            <h1>
                                                                <span>زمین</span>
                                                                <em>دکتر چلاجور</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title experiential">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="219" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G5.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="219" class="checkout" title="">
                                                            <h1>
                                                                <span>ریاضی</span>
                                                                <em>امینی</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title experiential">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="220" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G3.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="220" class="checkout" title="">
                                                            <h1>
                                                                <span>ریاضی</span>
                                                                <em>نباخته</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title experiential">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="212" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G1.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="212" class="checkout" title="">
                                                            <h1>
                                                                <span>زیست</span>
                                                                <em>دکتر چلاجور</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title experiential">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="221" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G11.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="221" class="checkout" title="">
                                                            <h1>
                                                                <span>ژنتیک</span>
                                                                <em>احمد آل علی</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                </div>
                            </div>
                            <i class="icon-right-arrow i-experiential-next r0 i-experiential i-swiper-content"></i>
                            <i class="icon-left-arrow i-experiential-prev l0 i-experiential i-swiper-content"></i>
                        </article>
                    </div>
                </div>
            </section>

            <section class="note-content sec-res-down-sample">
                <header>
                    <a href="javascript:void(0)" title="">
                        <h2>با ماندگاری مطالب در ذهنتان، استرس را فراموش کنید!</h2>
                    </a>
                </header>
                <p>
                    چند ماه مانده به کنکور؛ دوران گیجی دانش‌آموزان است: آن‌هایی که زیاد خوانده‌اند دیوانه‌وار بیشتر و بیشتر می‌خوانند و آن‌هایی که کمتر خوانده‌اند پناهشان می‌شود جزوات متعدد دم کنکور! اما چاره این سرگیجه چیست؟

                    با بررسی دلیل موفقیت برترین‌های کنکور در سال‌های متوالی یک نکته مهم در برطرف‌شدن این استرس نهفته است: مرور در ماه‌های آخر!
                </p>
            </section>

            <section class="content-field">
                <div class="row p30">
                    <div class="col-md-9">
                        <article class="art-img-content-field">
                            <header class="header-main">
                                <a href="javascript:void(0)" title="رشته ریاضی">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/tablighat/3.png" alt="رشته ریاضی" title="رشته ریاضی">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                            <header class="header-res">
                                <a href="javascript:void(0)" title="رشته ریاضی">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/sample/res-math.png" alt="رشته ریاضی" title="رشته ریاضی">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                        </article>
                    </div>
                    <div class="col-md-15">
                        <article class="art-slider-field">
                            <div class="swiper-container swiper-content-field swiper-content-field-math">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title math">
                                                <em>ریاضی</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="218" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G6.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="218" class="checkout" title="">
                                                            <h1>
                                                                <span>دیفرانیل</span>
                                                                <em>ثابتی</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title math">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="214" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G2.png" alt="همایش طلایی عربی کنکور آلاء" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="214" class="checkout" title="">
                                                            <h1>
                                                                <span>عربی</span>
                                                                <em style="font-size: 4rem !important;">ناصح زاده</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title math">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="javascript:void(0)" data-role="217" class="checkout" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G7.png" alt="همایش طلایی شیمی کنکور آلاء" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="javascript:void(0)" data-role="217" class="checkout" title="">
                                                            <h1>
                                                                <span>شیمی</span>
                                                                <em>صنیعی</em>
                                                            </h1>
                                                        </a>
                                                    </header>
                                                    <strong>
                                                            <span class="span-gold">
                                                                همایش طـــلایی
                                                            </span>
                                                        <bdi class="prsent">
                                                            <i>80%</i>
                                                            <em> کــــنـکور</em>
                                                        </bdi>
                                                    </strong>
                                                </figcaption>
                                            </figure>
                                        </article>
                                    </div>
                                </div>
                            </div>
                            <i class="icon-right-arrow i-math-next r0 i-math i-swiper-content"></i>
                            <i class="icon-left-arrow i-math-prev l0 i-math i-swiper-content"></i>
                        </article>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <section class="lottery-banner">
        <div class="container clearfix">
            <div class="ttla">هدیه خرید آلاء <span>برای کسانی که تا 3 خرداد خرید می کنند</span></div>

            <div class="bnra">
                <img class="banner" src="/assets/extra/landing4/images/banner2.png" alt="banner">
                <img class="infinite animated pulse shadow" src="/assets/extra/landing4/images/shadow.png" alt="banner">
            </div><!-- .bnra -->

            <div class="gifts">
                <table>
                    <thead>
                    <tr>
                        <th>نفر اول  :</th>
                        <th>آیفون x</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>5 نفر دوم  : </td>
                        <td>120 هزار تومان اعتبار هدیه</td>
                    </tr>
                    <tr>
                        <td>7 نفر سوم :</td>
                        <td>80 هزار تومان اعتبار هدیه</td>
                    </tr>

                    <tr>
                        <td>110 نفر چهارم : </td>
                        <td>60 هزار تومان اعتبار هدیه</td>
                    </tr>

                    <tr>
                        <td>180 نفر پنجم :</td>
                        <td>50 هزار تومان اعتبار هدیه</td>
                    </tr>

                    <tr>
                        <td>59 نفر ششم :</td>
                        <td>40 هزار تومان اعتبار هدیه</td>
                    </tr>

                    <tr>
                        <td>313 نفر هفتم :</td>
                        <td>25 هزار تومان اعتبار هدیه</td>
                    </tr>
                    </tbody>
                </table>
            </div><!-- .gifts -->

        </div><!-- .container -->
    </section>
    <footer class="site-footer site-footer-lading" role="contentinfo">
        <ul class="tab-footer">
            <li>
                <a href="javascript:void(0)" title="">
                    <i class="icon-brain-and-head"></i>
                    <span>مفهومی</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" title="">
                    <i class="icon-transport"></i>
                    <span>سبقت</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" title="">
                    <i class="icon-document"></i>
                    <span>جزوه</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" title="">
                    <i class="icon-light-bulb"></i>
                    <span>تحلیل</span>
                </a>
            </li>
        </ul>
        <section class="sec-dwon-sample res-down" style="display: none">
            <a href="javascript:void(0)" class="down-sample" title="دانلود نمونه جزوه">
                    <span>
                            ارسال کد ۳۳۳ به ۵۰۰۰۱۰۴۰۹۲۳۲ برای دریافت نمونه جزوه
                    </span>
            </a>
        </section>
        <section class="note-content res-note">
            <header>
                <a href="javascript:void(0)" title="">
                    <h2>با ماندگاری مطالب در ذهنتان، استرس را فراموش کنید!</h2>
                </a>
            </header>
            <p>
                5 ساعت جمع بندی و نکته و تست داریم و 1 ساعت تست های پلاس مخصوص پزشکا و مهندسا 5 ساعت جمع بندی و نکته و تست 1 ساعت تست های
                5 ساعت جمع بندی و نکته و تست داریم و 1 ساعت تست های پلاس مخصوص پزشکا و مهندساپلاس مخصوص پزشکا و مهندسا
            </p>
        </section>
    </footer>
</div>
<script>
    var storeOrderUrl = "{{ action('OrderproductController@store') }}";
</script>
<script src="/assets/extra/landing3/js/jquery-1.12.4.min.js"></script>
<script src="/assets/extra/landing3/js/swiper2.jquery.min.js" defer="defer"></script>
<script src="/assets/extra/landing3/js/script2.js" defer="defer"></script>
<script>
    $('a.checkout').click(function() {
        var id = $(this).data('role');
        $.ajax({
            url: '{{ action('OrderproductController@store') }}',
            type: 'POST',
            // contentType: 'application/json; charset=UTF-8',
            // dataType: 'json',
            // timeout: 10000,
            data: {
                product_id: id
            },
            statusCode: {
                //The status for when action was successful
                200: function (response) {
                    if(response.redirectUrl!= null && response.redirectUrl!="undefined")
                        window.location.replace(response.redirectUrl);
                },
                //The status for when the user is not authorized for making the request
                403: function (response) {
                    console.log("response 403");
                },
                //The status for when the user is not authorized for making the request
                401: function (response) {
                    console.log("response 401");
                },
                404: function (response) {
                    console.log("response 404");
                },
                //The status for when form data is not valid
                422: function (response) {
                    console.log(response);
                },
                //The status for when there is error php code
                500: function (response) {
                    console.log("response 500");
                    console.log(response.responseText);
                },
                //The status for when there is error php code
                503: function (response) {
                    response = $.parseJSON(response.responseText);
                    console.log(response.message);
                }
            }
        });
        return false;
    });
</script>
</body>
</html>