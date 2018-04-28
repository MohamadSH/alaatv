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
    <meta name="apple-mobile-web-app-title" content="AlaaTV" />
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

    <link rel="stylesheet" href="/assets/extra/landing3/css/stylesheet.css" />
    <!--[if lt IE 10]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexibility/2.0.1/flexibility.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .primary-menu>li>a{
            font-size: 2rem !important;
        }
    </style>
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
                        <a href="{{action("ProductController@show" , 210)}}" title="جزوه و آزمون">همایش ادبیات دکتر سبطی </a>
                    </li>
                    <li>
                        <a href="{{action("ProductController@show" , 211)}}" title="صفحه اصلی">همایش دین و زندگی دکتر کاغذی</a>
                    </li>
                    <li>
                        <a href="{{action("ProductController@show" , 212)}}" title="درباره ما">همایش زیست شناسی دکتر چلاجور</a>
                    </li>
                    <li>
                        <a href="{{action("ProductController@show" , 213)}}" title="قوانین و مقررات">همایش زمین شناسی دکتر چلاجور</a>
                    </li>
                    <li>
                        <a href="{{action("HomeController@contactUs")}}" title="تماس با ما">تماس با ما</a>
                    </li>
                </ul>
                <div class="swiper-container menu-res">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="{{action("HomeController@index")}}" title="صفحه اصلی">صفحه اصلی</a>
                        </div>
                        <div class="swiper-slide">
                            <a href="{{action("ProductController@show" , 210)}}" title="جزوه و آزمون">همایش ادبیات دکتر سبطی </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="{{action("ProductController@show" , 211)}}" title="صفحه اصلی">همایش دین و زندگی دکتر کاغذی</a>
                        </div>
                        <div class="swiper-slide">
                            <a href="{{action("ProductController@show" , 212)}}" title="درباره ما">همایش زیست شناسی دکتر چلاجور</a>
                        </div>
                        <div class="swiper-slide">
                            <a href="{{action("ProductController@show" , 213)}}" title="قوانین و مقررات">همایش زمین شناسی دکتر چلاجور</a>
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
                        <img src="/assets/extra/landing3/images/sample/gold-fest.png" alt="" title="">
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
                                            <img src="/assets/extra/landing3/images/tablighat/1.png" alt="همه رشته ها" title="همه رشته ها">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                            <header class="header-res">
                                <a href="javascript:void(0)" title="همه رشته ها">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/sample/res-all.png" alt="همه رشته ها" title="همه رشته ها">
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
                                                <a href="{{action("ProductController@show" , 210)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G9.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 210)}}" title="">
                                                            <h1>
                                                                <span>ادبیات</span>
                                                                <em>سبطی</em>
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
                                                <a href="{{action("ProductController@show" , 211)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G10.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 211)}}" title="">
                                                            <h1>
                                                                <span>دین و زندگی</span>
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
                                                <a href="{{action("ProductController@show" , 216)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/1.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 216)}}" title="">
                                                            <h1>
                                                                <span>فیزیک</span>
                                                                <em>طلوعی</em>
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
                                                <a href="{{action("ProductController@show" , 217)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G7.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 217)}}" title="">
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
                                                <a href="{{action("ProductController@show" , 214)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G2.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 214)}}" title="">
                                                            <h1>
                                                                <span>عربی</span>
                                                                <em>ناصح زاده</em>
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
                                                <a href="{{action("ProductController@show" , 215)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G8.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 215)}}" title="">
                                                            <h1>
                                                                <span>عربی</span>
                                                                <em>آهویی</em>
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
                            <i class="icon-right-arrow i-all-next r0 i-all i-swiper-content"></i>
                            <i class="icon-left-arrow i-all-prev l0 i-all i-swiper-content"></i>
                        </article>
                    </div>
                </div>
            </section>

            <section class="sec-dwon-sample sec-res-down-sample">
                <a href="javascript:void(0)" class="down-sample" title="دانلود نمونه جزوه">
                        <span>
                            دانلود نمونه جزوه
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
                                            <bdi class="bdi-title math">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{action("ProductController@show" , 212)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G1.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 212)}}" title="">
                                                            <h1>
                                                                <span>زیست گیاهی</span>
                                                                <em>چلاجور</em>
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
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{action("ProductController@show" , 213)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G1.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 213)}}" title="">
                                                            <h1>
                                                                <span>زمین شناسی</span>
                                                                <em>چلاجور</em>
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
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{action("ProductController@show" , 219)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G5.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 219)}}" title="">
                                                            <h1>
                                                                <span>ریاضی تجربی</span>
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
                                            <bdi class="bdi-title math">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{action("ProductController@show" , 220)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G3.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 220)}}" title="">
                                                            <h1>
                                                                <span>ریاضی تجربی</span>
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
                    5 ساعت جمع بندی و نکته و تست داریم و 1 ساعت تست های پلاس مخصوص پزشکا و مهندسا 5 ساعت جمع بندی و نکته و تست 1 ساعت تست های
                    5 ساعت جمع بندی و نکته و تست داریم و 1 ساعت تست های پلاس مخصوص پزشکا و مهندساپلاس مخصوص پزشکا و مهندسا
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
                                                <a href="{{action("ProductController@show" , 218)}}" title="">
                                                    <img src="/assets/extra/landing3/images/professors/G6.png" alt="" title="">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{action("ProductController@show" , 218)}}" title="">
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
    <footer class="site-footer site-footer-lading" role="contentinfo">
        <ul class="tab-footer">
            <li>
                <a href="javascript:void(0)" title="">
                    <i class="icon-brain-and-head"></i>
                    <span>تیتر</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" title="">
                    <i class="icon-transport"></i>
                    <span>تیتر</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" title="">
                    <i class="icon-document"></i>
                    <span>تیتر</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" title="">
                    <i class="icon-light-bulb"></i>
                    <span>تیتر</span>
                </a>
            </li>
        </ul>
        <section class="sec-dwon-sample res-down">
            <a href="javascript:void(0)" class="down-sample" title="دانلود نمونه جزوه">
                    <span>
                        دانلود نمونه جزوه
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
<script src="/assets/extra/landing3/js/jquery-1.12.4.min.js" defer="defer"></script>
<script src="/assets/extra/landing3/js/swiper.jquery.min.js" defer="defer"></script>
<script src="/assets/extra/landing3/js/menu.min.js" defer="defer"></script>
<script src="/assets/extra/landing3/js/script.js" defer="defer"></script>
</body>
</html>