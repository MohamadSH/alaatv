@extends("app" , ["pageName"=>"login"])

@section("body")
    <div class = "m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id = "m_login">
        <div class = "m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
            <div class = "m-stack m-stack--hor m-stack--desktop">
                <div class = "m-stack__item m-stack__item--fluid">
                    <div class = "m-login__wrapper">
                        <div class = "m-login__logo">
                            <a href = "#">
                                <img src = "/acm/image/alaa_sharif.png" class = "img-fluid">
                            </a>
                        </div>

                        <div class = "m-login__signin">
                            <div class = "m-login__head">
                                <h3 class = "m-login__title">ورود به آلاء</h3>
                                <div class = "m-login__desc">با کد ملی ایران نیازی به ثبت نام نیست.</div>
                            </div>

                            @include('partials.loginForm')
                        </div>

                        {{--<div class = "m-login__signup">
                            <div class = "m-login__head">
                                <h3 class = "m-login__title">ثبت نام</h3>
                                <div class = "m-login__desc">ویژه کسانی که کد ملی ایران ندارند.</div>
                            </div>
                            <form class = "m-login__form m-form" action = "">
                                <div class = "form-group m-form__group">
                                    <input class = "form-control m-input" type = "text" placeholder = "نام کامل" name = "fullname">
                                </div>
                                <div class = "form-group m-form__group">
                                    <input class = "form-control m-input" type = "text" placeholder = "ایمیل" name = "email" autocomplete = "off">
                                </div>
                                <div class = "form-group m-form__group">
                                    <input class = "form-control m-input" type = "password" placeholder = "رمز عبور دلخواه" name = "password">
                                </div>
                                <div class = "form-group m-form__group">
                                    <input class = "form-control m-input m-login__form-input--last" type = "password" placeholder = "رمز خود را تکرار کنید" name = "rpassword">
                                </div>

                                <div class = "m-login__form-action">
                                    <button id = "m_login_signup_submit" class = "btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">ثبت نام</button>
                                    <button id = "m_login_signup_cancel" class = "btn btn-outline-focus  m-btn m-btn--pill m-btn--custom">بازگشت</button>
                                </div>
                            </form>
                        </div>--}}

{{--                        <div class = "m-login__forget-password">
                            <div class = "m-login__head">
                                <h3 class = "m-login__title">رمز عبور خود را فراموش کرده اید ؟</h3>
                                <div class = "m-login__desc">ایمیل و یا شماره موبایل خود را برای دریافت رمز وارد نمایید</div>
                            </div>
                            <form class = "m-login__form m-form" action = "">
                                <div class = "form-group m-form__group">
                                    <input class = "form-control m-input" type = "text" placeholder = "ایمیل یا موبایل" name = "email" id = "m_email" autocomplete = "off">
                                </div>
                                <div class = "m-login__form-action">
                                    <button id = "m_login_forget_password_submit" class = "btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">ارسال رمز</button>
                                    <button id = "m_login_forget_password_cancel" class = "btn btn-outline-focus m-btn m-btn--pill m-btn--custom">بازگشت</button>
                                </div>
                            </form>
                        </div>--}}
                    </div>

                </div>
{{--                <div class = "m-stack__item m-stack__item--center">

                    <div class = "m-login__account">
						<span class = "m-login__account-msg">
اگر 						کد ملی ایران ندارید :
						</span>&nbsp;&nbsp;
                        <a href = "javascript:" id = "m_login_signup" class = "m-link m-link--focus m-login__account-link">ثبت نام کنید!</a>
                    </div>

                </div>--}}
            </div>
        </div>
        <div class = "m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center" style = "background-image: url(/acm/image/bg-4.jpg)">
            <div class = "m-grid__item">
                <h3 class = "m-login__welcome">آلایی شوید</h3>
                <p class = "m-login__msg">
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
    <script src = "{{ mix('/js/login.js') }}" type = "text/javascript"></script>
    <!--end::Login page js -->
@endsection
