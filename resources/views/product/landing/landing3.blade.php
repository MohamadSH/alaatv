<!DOCTYPE html>
<html dir="rtl" lang="fa-IR" class="no-js">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <meta name="application-name" content="" />
    <meta name="google" content="notranslate" />

    <meta name="google-site-verification" content="" />
    <meta name="alexaVerifyID" content="" />
    <meta name="norton-safeweb-site-verification" content="" />

    <meta name="designer" content="https://sanatisharif.ir" />
    <meta name="copyright" content="آموزش مجازی آلاء" />
    <link rel="license" href="https://sanatisharif.ir" />

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

    <title>همایش طلایی کنکور آلاء</title>

    <link rel="stylesheet" href="/assets/extra/landing3/css/stylesheet9.css" />
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
    <script>
        now = new Date();
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        var script_address = 'https://cdn.yektanet.com/rg_woebegone/scripts/1603/rg.complete.js';
        script.src = script_address + '?v=' + now.getFullYear().toString() + '0'
            + now.getMonth() + '0' + now.getDate() + '0' + now.getHours();
        script.async = true;
        head.appendChild(script);
    </script>
    @section("gtagJs")

    @show
</head>

<body>
<div class="wrapper" id="main-page">
    {{--<section class="lottery-banner">
        <div class="container clearfix">
            <div class="bnra">
                <img class="banner" src="/assets/extra/landing3/images/banner5.png" alt="قرعه کشی آلاء">
            </div><!-- .bnra -->
        </div><!-- .container -->
    </section>--}}
    <main>
        <div class="container main-landing">
            <section class="res-gold-fest">
                <figure>
                    <header class="header-none">
                        <h2></h2>
                    </header>
                    <a href="">
                        <img src="/assets/extra/landing3/images/sample/gold-fest.png" alt="همایش طلایی آلاء" >
                    </a>
                </figure>
            </section>
            <section class="content-field">
                <div class="row p30">
                    <div class="col-md-24">
                        <article class="art-img-content-field">
                            <header class="header-res">
                                <a href="" title="همه رشته ها">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/sample/res-all2.png" alt="همایش کنکور همه رشته ها" title="همه رشته ها">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                        </article>
                    </div>
                    <div class="col-md-24">
                        <article class="art-slider-field">
                            <div class="swiper-container swiper-content-field swiper-content-field-all">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title all">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',210) }}" data-role="210"  title="همایش طلایی ادبیات کنکور دکتر سبطی">
                                                    <img src="/assets/extra/landing3/images/professors/G9.png" alt="همایش طلایی ادبیات کنکور دکتر سبطی آلاء" title="همایش طلایی ادبیات کنکور دکتر سبطی">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',210) }}" data-role="210"  title="همایش طلایی ادبیات کنکور دکتر سبطی">
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
                                                <a href="{{ action('ProductController@show',211) }}" data-role="211"  title="همایش طلایی دین و زندگی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G10.png" alt="همایش طلایی دین و زندگی کنکور آلاء" title="همایش طلایی دین و زندگی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',211) }}" data-role="211"  title="همایش طلایی دین و زندگی کنکور">
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
                                                <a href="{{ action('ProductController@show',216) }}" data-role="216"  title="همایش طلایی فیزیک کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/1.png" alt="همایش طلایی فیزیک کنکور آلاء" title="همایش طلایی فیزیک کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',216) }}" data-role="216"  title="">
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
                                                <a href="{{ action('ProductController@show',217) }}" data-role="217"  title="همایش طلایی شیمی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G7.png" alt="همایش طلایی شیمی کنکور آلاء" title="همایش طلایی شیمی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',217) }}" data-role="217"  title="همایش طلایی شیمی کنکور">
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
                                                <a href="{{ action('ProductController@show',214) }}" data-role="214"  title="همایش طلایی عربی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G2.png" alt="همایش طلایی عربی کنکور آلاء" title="همایش طلایی عربی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',214) }}" data-role="214"  title="همایش طلایی عربی کنکور">
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
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',220) }}" data-role="220"  title="همایش طلایی ریاضی تجربی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G3.png" alt="همایش طلایی ریاضی تجربی کنکور آلاء" title="همایش طلایی ریاضی تجربی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',220) }}" data-role="220"  title="همایش طلایی ریاضی تجربی کنکور">
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
                                            <bdi class="bdi-title all">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',219) }}" data-role="219"  title="همایش طلایی ریاضی تجربی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G5.png" alt="همایش طلایی ریاضی تجربی کنکور آلاء" title="همایش طلایی ریاضی تجربی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',219) }}" data-role="219"  title="همایش طلایی ریاضی تجربی کنکور">
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
                                            <bdi class="bdi-title all">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',213) }}" data-role="213"  title="همایش طلایی زمین شناسی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G1.png" alt="همایش طلایی زمین شناسی کنکور آلاء" title="همایش طلایی زمین شناسی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',213) }}" data-role="213"  title="همایش طلایی زمین شناسی کنکور">
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
                                            <bdi class="bdi-title all">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',212) }}" data-role="212"  title="همایش طلایی زیست شناسی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G1.png" alt="همایش طلایی زیست شناسی کنکور آلاء" title="همایش طلایی زیست شناسی کنکور آلاء">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',212) }}" data-role="212"  title="همایش طلایی زیست شناسی کنکور آلاء">
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
                                            <bdi class="bdi-title all">
                                                <em>انسانی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',222) }}" data-role="222"  title="همایش طلایی ریاضی انسانی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G5.png" alt="همایش طلایی ریاضی انسای کنکور آلاء" title="همایش طلایی ریاضی انسانی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',222) }}" data-role="222"  title="همایش طلایی ریاضی انسانی کنکور">
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
                                </div>
                            </div>
                            <i class="icon-right-arrow i-all-next r0 i-all i-swiper-content"></i>
                            <i class="icon-left-arrow i-all-prev l0 i-all i-swiper-content"></i>
                        </article>
                    </div>
                </div>
            </section>
            <section class="content-field">
                <div class="row p30">
                    <div class="col-md-24">
                        <article class="art-img-content-field">
                            <header class="header-res">
                                <a href="javascript:void(0)" title="رشته تجربی">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/sample/res-experiential2.png" alt="رشته تجربی" title="رشته تجربی">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                        </article>
                    </div>
                    <div class="col-md-24">
                        <article class="art-slider-field">
                            <div class="swiper-container swiper-content-field swiper-content-field-experiential">
                                <div class="swiper-wrapper">

                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title experiential">
                                                <em>تجربی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',213) }}" data-role="213"  title="همایش طلایی زمین شناسی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G1.png" alt="همایش طلایی زمین شناسی کنکور آلاء" title="همایش طلایی زمین شناسی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',213) }}" data-role="213"  title="همایش طلایی زمین شناسی کنکور">
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
                                                <a href="{{ action('ProductController@show',219) }}" data-role="219"  title="همایش طلایی ریاضی تجربی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G5.png" alt="همایش طلایی ریاضی تجربی کنکور آلاء" title="همایش طلایی ریاضی تجربی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',219) }}" data-role="219"  title="همایش طلایی ریاضی تجربی کنکور">
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
                                                <a href="{{ action('ProductController@show',220) }}" data-role="220"  title="همایش طلایی ریاضی تجربی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G3.png" alt="همایش طلایی ریاضی تجربی کنکور آلاء" title="همایش طلایی ریاضی تجربی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',220) }}" data-role="220"  title="همایش طلایی ریاضی تجربی کنکور">
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
                                                <a href="{{ action('ProductController@show',212) }}" data-role="212"  title="همایش طلایی زیست شناسی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G1.png" alt="همایش طلایی زیست شناسی کنکور آلاء" title="همایش طلایی زیست شناسی کنکور آلاء">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',212) }}" data-role="212"  title="همایش طلایی زیست شناسی کنکور آلاء">
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
                                                <a href="{{ action('ProductController@show',221) }}" data-role="221"  title="همایش طلایی زیست شناسی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G11.png" alt="همایش طلایی زیست شناسی کنکور آلاء" title="همایش طلایی زیست شناسی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',221) }}" data-role="221"  title="همایش طلایی زیست شناسی کنکور">
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
            <section class="content-field">
                <div class="row p30">
                    <div class="col-md-24">
                        <article class="art-img-content-field">
                            <header class="header-res">
                                <a href="javascript:void(0)" title="رشته ریاضی">
                                    <h1>
                                        <figure class="fig-img-content-field">
                                            <img src="/assets/extra/landing3/images/sample/res-math2.png" alt="رشته ریاضی" title="رشته ریاضی">
                                        </figure>
                                    </h1>
                                </a>
                            </header>
                        </article>
                    </div>
                    <div class="col-md-24">
                        <article class="art-slider-field">
                            <div class="swiper-container swiper-content-field swiper-content-field-math">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <article class="item-content-field">
                                            <bdi class="bdi-title math">
                                                <em>ریاضی</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',218) }}" data-role="218"  title="همایش طلایی دیفرانسیل کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G6.png" alt="همایش طلایی دیفرانسیل کنکور آلاء" title="همایش طلایی دیفرانسیل کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',218) }}" data-role="218"  title="همایش طلایی دیفرانسیل کنکور">
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
                                                <a href="{{ action('ProductController@show',214) }}" data-role="214"  title="همایش طلایی عربی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G2.png" alt="همایش طلایی عربی کنکور آلاء" title="همایش طلایی عربی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',214) }}" data-role="214"  title="همایش طلایی عربی کنکور">
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
                                            <bdi class="bdi-title math">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',217) }}" data-role="217"  title="همایش طلایی شیمی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G7.png" alt="همایش طلایی شیمی کنکور آلاء" title="همایش طلایی شیمی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',217) }}" data-role="217"  title="همایش طلایی شیمی کنکور">
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
                                            <bdi class="bdi-title math">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',210) }}" data-role="210"  title="همایش طلایی ادبیات کنکور دکتر سبطی">
                                                    <img src="/assets/extra/landing3/images/professors/G9.png" alt="همایش طلایی ادبیات کنکور دکتر سبطی آلاء" title="همایش طلایی ادبیات کنکور دکتر سبطی">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',210) }}" data-role="210"  title="همایش طلایی ادبیات کنکور دکتر سبطی">
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
                                            <bdi class="bdi-title math">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',211) }}" data-role="211"  title="همایش طلایی دین و زندگی کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/G10.png" alt="همایش طلایی دین و زندگی کنکور آلاء" title="همایش طلایی دین و زندگی کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',211) }}" data-role="211"  title="همایش طلایی دین و زندگی کنکور">
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
                                            <bdi class="bdi-title math">
                                                <em>مشترک</em>
                                            </bdi>
                                            <figure>
                                                <a href="{{ action('ProductController@show',216) }}" data-role="216"  title="همایش طلایی فیزیک کنکور">
                                                    <img src="/assets/extra/landing3/images/professors/1.png" alt="همایش طلایی فیزیک کنکور آلاء" title="همایش طلایی فیزیک کنکور">
                                                </a>
                                                <figcaption>
                                                    <header>
                                                        <a href="{{ action('ProductController@show',216) }}" data-role="216"  title="">
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
        <section class="sec-dwon-sample">
            <a href="{{ action('ContentController@show',7884) }}" class="down-sample" title="دانلود نمونه فیلم">
                        <span>
                           دانلود نمونه فیلم همایش
                        </span>
            </a>
        </section>
        <section class="note-content">
            <header>
                <a href="" title="">
                    <h2>با ماندگاری مطالب در ذهنتان، استرس را فراموش کنید!</h2>
                </a>
            </header>
            <p>
                چند ماه مانده به کنکور؛ دوران گیجی دانش‌آموزان است: آن‌هایی که زیاد خوانده‌اند دیوانه‌وار بیشتر و بیشتر می‌خوانند و آن‌هایی که کمتر خوانده‌اند پناهشان می‌شود جزوات متعدد دم کنکور! اما چاره این سرگیجه چیست؟

                با بررسی دلیل موفقیت برترین‌های کنکور در سال‌های متوالی یک نکته مهم در برطرف‌شدن این استرس نهفته است: مرور در ماه‌های آخر!
            </p>
        </section>
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

    </footer>
</div>
<script src="/assets/extra/landing3/js/jquery-1.12.4.min.js"></script>
<script src="/assets/extra/landing3/js/swiper2.jquery.min.js" defer="defer"></script>
<script src="/assets/extra/landing3/js/script3.js" defer="defer"></script>
</body>
</html>
