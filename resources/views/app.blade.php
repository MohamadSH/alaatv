<!DOCTYPE html>
<html lang = "fa" direction = "rtl" style = "direction: rtl">
<!-- begin::Head -->
<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name = "csrf-token" content = "{{ csrf_token() }}">

    <!-- begin::seo meta tags -->
{!! SEO::generate(true) !!}
<!-- end:: seo meta tags -->

    <!--begin::Web font -->
    <script src = "https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    <link href = "{{ mix('/css/all.css') }}" rel = "stylesheet" type = "text/css"/>
    <!--end::Global Theme Styles -->

    @yield('extra-css')

    <link rel = "shortcut icon" href = "@if(isset($wSetting->site->favicon)) {{route('image', ['category'=>'11','w'=>'150' , 'h'=>'150' ,  'filename' =>  $wSetting->site->favicon ])}} @endif"/>
    <!--begin: csrf token -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <!--end: csrf token -->
    <!--begin Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PNP8RDW');
    </script>
    <!-- End Google Tag Manager -->
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class = "m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-aside-right--enabled m-footer--push m-aside--offcanvas-default">

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src = "https://www.googletagmanager.com/ns.html?id=GTM-PNP8RDW" height = "0" width = "0" style = "display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- begin:: Page -->
<div class = "m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
@section("header")
    @include("partials.header1")
@show
<!-- END: Header -->
    <!-- begin::Body -->
    <div class = "m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        @section("sidebar")
            @include("partials.sidebar")
        @show

        <div class = "m-grid__item m-grid__item--fluid m-wrapper">
            <div class = "m-content">
                {{--<!--Begin::Section-->
                <div class = "row">
                    <div class = "col-xl-4">
                        <!--begin:: Widgets/New Users-->
                        <div class = "m-portlet m-portlet--full-height  m-portlet--unair">
                            <div class = "m-portlet__head">
                                <div class = "m-portlet__head-caption">
                                    <div class = "m-portlet__head-title">
                                        <h3 class = "m-portlet__head-text">
                                            New Users
                                        </h3>
                                    </div>
                                </div>
                                <div class = "m-portlet__head-tools">
                                    <ul class = "nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role = "tablist">
                                        <li class = "nav-item m-tabs__item">
                                            <a class = "nav-link m-tabs__link active" data-toggle = "tab" href = "#m_widget4_tab1_content" role = "tab">
                                                Today
                                            </a>
                                        </li>
                                        <li class = "nav-item m-tabs__item">
                                            <a class = "nav-link m-tabs__link" data-toggle = "tab" href = "#m_widget4_tab2_content" role = "tab">
                                                Month
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class = "m-portlet__body">
                                <div class = "tab-content">
                                    <div class = "tab-pane active" id = "m_widget4_tab1_content">
                                        <!--begin::Widget 14-->
                                        <div class = "m-widget4">
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_4.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Anna Strong
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Visual Designer,Google Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_14.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Milano Esco
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Product Designer, Apple Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_11.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Nick Bold
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Web Developer, Facebook Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_1.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Wiltor Delton
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Project Manager, Amazon Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_5.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Nick Stone
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Visual Designer, Github Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                        </div>
                                        <!--end::Widget 14-->
                                    </div>
                                    <div class = "tab-pane" id = "m_widget4_tab2_content">
                                        <!--begin::Widget 14-->
                                        <div class = "m-widget4">
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_2.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Kristika Bold
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Product Designer,Apple Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_13.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Ron Silk
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Release Manager, Loop Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_9.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Nick Bold
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Web Developer, Facebook Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_2.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Wiltor Delton
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Project Manager, Amazon Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                            <!--end::Widget 14 Item-->
                                            <!--begin::Widget 14 Item-->
                                            <div class = "m-widget4__item">
                                                <div class = "m-widget4__img m-widget4__img--pic">
                                                    <img src = "assets/app/media/img/users/100_8.jpg" alt = "">
                                                </div>
                                                <div class = "m-widget4__info">
							<span class = "m-widget4__title">
							Nick Bold
							</span>
                                                    <br>
                                                    <span class = "m-widget4__sub">
							Web Developer, Facebook Inc
							</span>
                                                </div>
                                                <div class = "m-widget4__ext">
                                                    <a href = "#" class = "m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">Follow</a>
                                                </div>
                                            </div>
                                            <!--end::Widget 14 Item-->
                                        </div>
                                        <!--end::Widget 14-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end:: Widgets/New Users-->  </div>
                    <div class = "col-xl-4">
                        <!--begin:: Widgets/Inbound Bandwidth-->
                        <div class = "m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit  m-portlet--unair" style = "min-height: 300px">
                            <div class = "m-portlet__head">
                                <div class = "m-portlet__head-caption">
                                    <div class = "m-portlet__head-title">
                                        <h3 class = "m-portlet__head-text">
                                            Inbound Bandwidth
                                        </h3>
                                    </div>
                                </div>
                                <div class = "m-portlet__head-tools">
                                    <ul class = "m-portlet__nav">
                                        <li class = "m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle = "hover" aria-expanded = "true">
                                            <a href = "#" class = "m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                                Today
                                            </a>
                                            <div class = "m-dropdown__wrapper">
                                                <span class = "m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style = "left: auto; right: 36.5px;"></span>
                                                <div class = "m-dropdown__inner">
                                                    <div class = "m-dropdown__body">
                                                        <div class = "m-dropdown__content">
                                                            <ul class = "m-nav">
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-share"></i>
                                                                        <span class = "m-nav__link-text">Activity</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-chat-1"></i>
                                                                        <span class = "m-nav__link-text">Messages</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-info"></i>
                                                                        <span class = "m-nav__link-text">FAQ</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-lifebuoy"></i>
                                                                        <span class = "m-nav__link-text">Support</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class = "m-portlet__body">
                                <!--begin::Widget5-->
                                <div class = "m-widget20">
                                    <div class = "m-widget20__number m--font-success">670</div>
                                    <div class = "m-widget20__chart" style = "height:160px;">
                                        <canvas id = "m_chart_bandwidth1"></canvas>
                                    </div>
                                </div>
                                <!--end::Widget 5-->
                            </div>
                        </div>
                        <!--end:: Widgets/Inbound Bandwidth-->
                        <div class = "m--space-30"></div>
                        <!--begin:: Widgets/Outbound Bandwidth-->
                        <div class = "m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit  m-portlet--unair" style = "min-height: 300px">
                            <div class = "m-portlet__head">
                                <div class = "m-portlet__head-caption">
                                    <div class = "m-portlet__head-title">
                                        <h3 class = "m-portlet__head-text">
                                            Outbound Bandwidth
                                        </h3>
                                    </div>
                                </div>
                                <div class = "m-portlet__head-tools">
                                    <ul class = "m-portlet__nav">
                                        <li class = "m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle = "hover" aria-expanded = "true">
                                            <a href = "#" class = "m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                                Today
                                            </a>
                                            <div class = "m-dropdown__wrapper">
                                                <span class = "m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style = "left: auto; right: 36.5px;"></span>
                                                <div class = "m-dropdown__inner">
                                                    <div class = "m-dropdown__body">
                                                        <div class = "m-dropdown__content">
                                                            <ul class = "m-nav">
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-share"></i>
                                                                        <span class = "m-nav__link-text">Activity</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-chat-1"></i>
                                                                        <span class = "m-nav__link-text">Messages</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-info"></i>
                                                                        <span class = "m-nav__link-text">FAQ</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-lifebuoy"></i>
                                                                        <span class = "m-nav__link-text">Support</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class = "m-portlet__body">
                                <!--begin::Widget5-->
                                <div class = "m-widget20">
                                    <div class = "m-widget20__number m--font-warning">340</div>
                                    <div class = "m-widget20__chart" style = "height:160px;">
                                        <canvas id = "m_chart_bandwidth2"></canvas>
                                    </div>
                                </div>
                                <!--end::Widget 5-->
                            </div>
                        </div>
                        <!--end:: Widgets/Outbound Bandwidth-->  </div>
                    <div class = "col-xl-4">
                        <!--begin:: Widgets/Top Products-->
                        <div class = "m-portlet m-portlet--full-height m-portlet--fit  m-portlet--unair">
                            <div class = "m-portlet__head">
                                <div class = "m-portlet__head-caption">
                                    <div class = "m-portlet__head-title">
                                        <h3 class = "m-portlet__head-text">
                                            Top Products
                                        </h3>
                                    </div>
                                </div>
                                <div class = "m-portlet__head-tools">
                                    <ul class = "m-portlet__nav">
                                        <li class = "m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle = "hover" aria-expanded = "true">
                                            <a href = "#" class = "m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                                All
                                            </a>
                                            <div class = "m-dropdown__wrapper">
                                                <span class = "m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style = "left: auto; right: 36.5px;"></span>
                                                <div class = "m-dropdown__inner">
                                                    <div class = "m-dropdown__body">
                                                        <div class = "m-dropdown__content">
                                                            <ul class = "m-nav">
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-share"></i>
                                                                        <span class = "m-nav__link-text">Activity</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-chat-1"></i>
                                                                        <span class = "m-nav__link-text">Messages</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-info"></i>
                                                                        <span class = "m-nav__link-text">FAQ</span>
                                                                    </a>
                                                                </li>
                                                                <li class = "m-nav__item">
                                                                    <a href = "" class = "m-nav__link">
                                                                        <i class = "m-nav__link-icon flaticon-lifebuoy"></i>
                                                                        <span class = "m-nav__link-text">Support</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class = "m-portlet__body">
                                <!--begin::Widget5-->
                                <div class = "m-widget4 m-widget4--chart-bottom" style = "min-height: 480px">
                                    <div class = "m-widget4__item">
                                        <div class = "m-widget4__img m-widget4__img--logo">
                                            <img src = "assets/app/media/img/client-logos/logo3.png" alt = "">
                                        </div>
                                        <div class = "m-widget4__info">
					<span class = "m-widget4__title">
					Phyton
					</span>
                                            <br>
                                            <span class = "m-widget4__sub">
					A Programming Language
					</span>
                                        </div>
                                        <span class = "m-widget4__ext">
					<span class = "m-widget4__number m--font-brand">+$17</span>
				</span>
                                    </div>
                                    <div class = "m-widget4__item">
                                        <div class = "m-widget4__img m-widget4__img--logo">
                                            <img src = "assets/app/media/img/client-logos/logo1.png" alt = "">
                                        </div>
                                        <div class = "m-widget4__info">
					<span class = "m-widget4__title">
					FlyThemes
					</span>
                                            <br>
                                            <span class = "m-widget4__sub">
					A Let's Fly Fast Again Language
					</span>
                                        </div>
                                        <span class = "m-widget4__ext">
					<span class = "m-widget4__number m--font-brand">+$300</span>
				</span>
                                    </div>
                                    <div class = "m-widget4__item">
                                        <div class = "m-widget4__img m-widget4__img--logo">
                                            <img src = "assets/app/media/img/client-logos/logo4.png" alt = "">
                                        </div>
                                        <div class = "m-widget4__info">
					<span class = "m-widget4__title">
					Starbucks
					</span>
                                            <br>
                                            <span class = "m-widget4__sub">
					Good Coffee & Snacks
					</span>
                                        </div>
                                        <span class = "m-widget4__ext">
					<span class = "m-widget4__number m--font-brand">+$300</span>
				</span>
                                    </div>
                                    <div class = "m-widget4__chart m-portlet-fit--sides m--margin-top-20" style = "height:260px;">
                                        <canvas id = "m_chart_trends_stats_2"></canvas>
                                    </div>
                                </div>
                                <!--end::Widget 5-->
                            </div>
                        </div>
                        <!--end:: Widgets/Top Products-->  </div>
                </div>
                <!--End::Section-->--}}
                @yield("content")
            </div>
        </div>

        @section('right-aside')
        <!-- BEGIN: Right Aside -->
            <div class = "m-grid__item m-aside-right">

                <div>
                    <h6 class="m-badge m-badge--warning m-badge--wide m-badge--rounded">ترافیک رایگان آلاء</h6>
                    <p class="text-justify">
                        دانلود آسیاتکی ها از سایت آلاء رایگان است.
                        <br>
                        اگر آسیاتک ندارید، از
                        <a href = "/v/asiatech" class="m-link m--font-boldest">اینجا</a>
                        کد تخفیف
                        <span>
                            100%
                        </span>
                        آسیاتک را <strong> رایگان </strong> دریافت کنید.
                    </p>
                </div>
                <div class = "m-separator m-separator--dashed m--space-10"></div>
                <div>
                    <h6 class="m-badge m-badge--warning m-badge--wide m-badge--rounded"> کمک مالی به آلاء</h6>
                        <p class="mb-0 text-justify">
                            ما هرکاری که می کنیم، به تغییر وضعیت موجود اعتقاد داریم،
                            ما به متفاوت فکر کردن اعتقاد داریم.
                            <br>
                            روش ما برای به چالش کشیدن وضعیت موجود، تولید محتواهای کامل، جامع و بررسی دقیق پیشنهادهای  شما و نظرات کارشناسان آموزشی است.
                            <br>
                            اینگونه هست که ما بهترین فیلم های آموزشی را تولید می کنیم.
                            <br>
                            <a href="{{ action("HomeController@donate") }}" class="m-link m--font-boldest">
                                ما برای حفظ و توسعه خدمات، نیاز به کمک های مالی شما آلایی ها داریم.
                            </a>
                        </p>
                        <footer class="blockquote-footer">سهراب ابوذرخانی فرد <cite title="موسسه غیرتجاری توسعه علمی آموزشی عدالت محور آلاء">موسسه غیرتجاری آلاء</cite></footer>
                </div>

            </div>
        <!-- END: Right Aside -->
        @show
    </div>
    <!-- end:: Body -->


    @section("footer")
        @include("partials.footer1")
    @show
</div>
<!-- end:: Page -->

@section('quick-sidebar')
    @include('partials.quickSidebar')
@show
<!-- begin::Scroll Top -->
<div id = "m_scroll_top" class = "m-scroll-top">
    <i class = "la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->
{{--
<!-- begin::Quick Nav -->
<ul class = "m-nav-sticky" style = "margin-top: 30px;">
    <li class = "m-nav-sticky__item" data-toggle = "m-tooltip" title = "سبد خرید" data-placement = "left">
        <a href = "https://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target = "_blank">
            <i class = "la la-cart-arrow-down"></i>
        </a>
    </li>
    <li class = "m-nav-sticky__item" data-toggle = "m-tooltip" title = "Documentation" data-placement = "left">
        <a href = "https://keenthemes.com/metronic/documentation.html" target = "_blank">
            <i class = "la la-code-fork"></i>
        </a>
    </li>
    <li class = "m-nav-sticky__item" data-toggle = "m-tooltip" title = "انجمن" data-placement = "left">
        <a href = "https://keenthemes.com/forums/forum/support/metronic5/" target = "_blank">
            <i class = "la la-life-ring"></i>
        </a>
    </li>
</ul>
<!-- begin::Quick Nav -->
--}}
<!--begin::Global Theme Bundle -->
<script src = "{{ mix('/js/all.js') }}" type = "text/javascript"></script>
<!--end::Global Theme Bundle -->
</body>
<!-- end::Body -->
</html>