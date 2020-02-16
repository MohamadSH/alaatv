@extends('partials.templatePage' , ['pageName'=>'login'])

@section('page-css')
    <link href="{{ mix('/css/auth-login.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('body')




    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin d-none" id="m_login">
        <div class="m-grid__item m-grid__item--order-tablet-and-mobile-1 m-login__aside">

            <div class="loginFormBackgroundForMobileAndTablet">

                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:rgba(255, 255, 255, 0);display:block;z-index:1;position:relative" preserveAspectRatio="xMidYMid" viewBox="0 0 1920 900">
                    <g transform=""><linearGradient id="lg-0.6590519274487807" x1="0" x2="1" y1="0" y2="0">
                            <stop stop-color="#ff6f00" offset="0"></stop>
                            <stop stop-color="#ffbc00" offset="1"></stop>
                        </linearGradient><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                            <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="0s" values="M0 0L 0 546.5967884672126Q 192 713.2369273885519  384 671.2270267357276T 768 548.3393711573123T 1152 645.3827444212593T 1536 675.3075340334177T 1920 537.8671790734181L 1920 0 Z;M0 0L 0 567.5670733199255Q 192 592.417625080102  384 552.7744912792721T 768 636.87964595838T 1152 628.1955537079805T 1536 573.808477897689T 1920 704.6302637819949L 1920 0 Z;M0 0L 0 702.4166448322239Q 192 723.82551594958  384 697.4701199242061T 768 600.2802675399195T 1152 655.9096605274854T 1536 629.6287267825378T 1920 673.5719168605297L 1920 0 Z;M0 0L 0 546.5967884672126Q 192 713.2369273885519  384 671.2270267357276T 768 548.3393711573123T 1152 645.3827444212593T 1536 675.3075340334177T 1920 537.8671790734181L 1920 0 Z"></animate>
                        </path><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                            <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-2s" values="M0 0L 0 570.3787913270386Q 192 633.5836756376103  384 608.8202835787736T 768 681.3109807054938T 1152 666.5125097674464T 1536 582.9554108152355T 1920 671.3930604391318L 1920 0 Z;M0 0L 0 570.5169314644627Q 192 660.8272380652922  384 637.6286751581895T 768 667.1357980107384T 1152 685.2816878400248T 1536 596.9164426119734T 1920 600.7527049502754L 1920 0 Z;M0 0L 0 570.3710720549185Q 192 582.465560458551  384 561.438411162126T 768 677.646223807402T 1152 655.2838678008707T 1536 625.674124380773T 1920 662.3845576441461L 1920 0 Z;M0 0L 0 570.3787913270386Q 192 633.5836756376103  384 608.8202835787736T 768 681.3109807054938T 1152 666.5125097674464T 1536 582.9554108152355T 1920 671.3930604391318L 1920 0 Z"></animate>
                        </path><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                            <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-4s" values="M0 0L 0 703.8542353769213Q 192 604.8360093903229  384 556.7499694638776T 768 628.3913236171925T 1152 701.8368403711436T 1536 583.6965965861567T 1920 665.3868717149039L 1920 0 Z;M0 0L 0 654.1225063769479Q 192 677.909181271205  384 651.8342681879976T 768 576.5884156540257T 1152 697.422084882304T 1536 593.3481530575232T 1920 590.3668216400752L 1920 0 Z;M0 0L 0 709.7582289234141Q 192 687.7855740637726  384 645.9486202471865T 768 675.0475492797551T 1152 684.439909260533T 1536 600.9716504555258T 1920 601.0681820979779L 1920 0 Z;M0 0L 0 703.8542353769213Q 192 604.8360093903229  384 556.7499694638776T 768 628.3913236171925T 1152 701.8368403711436T 1536 583.6965965861567T 1920 665.3868717149039L 1920 0 Z"></animate>
                        </path><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                            <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-6s" values="M0 0L 0 606.3222052204637Q 192 640.5660059494184  384 614.9431051809589T 768 563.5158322572134T 1152 651.0412481583627T 1536 663.1387762443412T 1920 589.6057596180527L 1920 0 Z;M0 0L 0 633.5355386976398Q 192 667.9435852585646  384 622.5305140620203T 768 603.6214254711541T 1152 692.7032727397816T 1536 626.8537603365265T 1920 610.5231149256455L 1920 0 Z;M0 0L 0 597.1914690099037Q 192 634.5077516584377  384 600.0571756851713T 768 587.7879529611296T 1152 686.486363838277T 1536 618.527582617397T 1920 680.0220941734856L 1920 0 Z;M0 0L 0 606.3222052204637Q 192 640.5660059494184  384 614.9431051809589T 768 563.5158322572134T 1152 651.0412481583627T 1536 663.1387762443412T 1920 589.6057596180527L 1920 0 Z"></animate>
                        </path><path d="" fill="url(#lg-0.6590519274487807)" opacity="0.4">
                            <animate attributeName="d" dur="10s" repeatCount="indefinite" keyTimes="0;0.333;0.667;1" calcmod="spline" keySplines="0.2 0 0.2 1;0.2 0 0.2 1;0.2 0 0.2 1" begin="-8s" values="M0 0L 0 675.068973495964Q 192 725.9732618418908  384 686.3397918304262T 768 575.1660118118252T 1152 557.4339722539198T 1536 624.7337634379641T 1920 619.7169536804358L 1920 0 Z;M0 0L 0 609.8908999302556Q 192 638.943277782745  384 622.8641455495701T 768 680.9824332256469T 1152 604.3151676000973T 1536 554.2848086644095T 1920 672.6674592722616L 1920 0 Z;M0 0L 0 655.4410999110182Q 192 657.1049819899372  384 620.8556200433279T 768 572.5931056983565T 1152 626.498651528957T 1536 658.1933233621113T 1920 699.374357564823L 1920 0 Z;M0 0L 0 675.068973495964Q 192 725.9732618418908  384 686.3397918304262T 768 575.1660118118252T 1152 557.4339722539198T 1536 624.7337634379641T 1920 619.7169536804358L 1920 0 Z"></animate>
                        </path></g>
                </svg>

            </div>
            <div class="m-stack m-stack--hor m-stack--desktop loginFormInputsAndLogos">
                <div class="m-stack__item m-stack__item--fluid">
                    <div class="m-login__wrapper">
                        <div class="m-login__logo">
                            <a href="#">
                                <img src="/acm/image/alaa_sharif.png" class="img-fluid">
                            </a>
                        </div>

                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">ورود به آلاء</h3>
                                <div class="m-login__desc">با کد ملی ایران نیازی به ثبت نام نیست.</div>
                            </div>

                            @include('partials.loginForm')
                        </div>

                        {{--<div class="m-login__signup">
                            <div class="m-login__head">
                                <h3 class="m-login__title">ثبت نام</h3>
                                <div class="m-login__desc">ویژه کسانی که کد ملی ایران ندارند.</div>
                            </div>
                            <form class="m-login__form m-form" action="">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="نام کامل" name="fullname">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="ایمیل" name="email" autocomplete="off">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="password" placeholder="رمز عبور دلخواه" name="password">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password" placeholder="رمز خود را تکرار کنید" name="rpassword">
                                </div>

                                <div class="m-login__form-action">
                                    <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">ثبت نام</button>
                                    <button id="m_login_signup_cancel" class="btn btn-outline-focus  m-btn m-btn--pill m-btn--custom">بازگشت</button>
                                </div>
                            </form>
                        </div>--}}

                        {{--                        <div class="m-login__forget-password">
                                                    <div class="m-login__head">
                                                        <h3 class="m-login__title">رمز عبور خود را فراموش کرده اید ؟</h3>
                                                        <div class="m-login__desc">ایمیل و یا شماره موبایل خود را برای دریافت رمز وارد نمایید</div>
                                                    </div>
                                                    <form class="m-login__form m-form" action="">
                                                        <div class="form-group m-form__group">
                                                            <input class="form-control m-input" type="text" placeholder="ایمیل یا موبایل" name="email" id="m_email" autocomplete="off">
                                                        </div>
                                                        <div class="m-login__form-action">
                                                            <button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">ارسال رمز</button>
                                                            <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">بازگشت</button>
                                                        </div>
                                                    </form>
                                                </div>--}}
                    </div>

                </div>
                {{--                <div class="m-stack__item m-stack__item--center">

                                    <div class="m-login__account">
                                        <span class="m-login__account-msg">
                اگر 						کد ملی ایران ندارید :
                                        </span>&nbsp;&nbsp;
                                        <a href="javascript:" id="m_login_signup" class="m-link m-link--focus m-login__account-link">ثبت نام کنید!</a>
                                    </div>

                                </div>--}}
            </div>
        </div>
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-2 m-login__content m-grid-item--center loginPicture" style="background-image: url(/acm/image/bg-4.jpg)">
            <div class="m-grid__item">
                <h3 class="m-login__welcome">آلایی شوید</h3>
                <p class="m-login__msg">
                    با همکاری دبیرستان دانشگاه صنعتی شریف
                    <br>
                    متوسطه دوم و مهارت آموزی
                </p>
            </div>
        </div>
    </div>

    {{--@include("partials.loginForm" ,["withHeader"=>false])--}}
@endsection

@section('page-js')
    <!--begin::Login page js -->
    <script src="{{ mix('/js/login.js') }}" type="text/javascript"></script>
    <!--end::Login page js -->
@endsection
