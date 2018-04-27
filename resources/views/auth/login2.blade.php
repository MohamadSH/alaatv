@extends("app")

@section("headThemeLayoutStyle")
    <link rel="stylesheet" href="/assets/pages/css/login-5-rtl.min.css">
@endsection

@section("bodyClass")
    class="login"
@endsection

@section("header")
@endsection
@section("sidebar")
@endsection
@section("themePanel")
@endsection
@section("pageBar")
@endsection
@section("bodyClass")
    class="login"
@endsection
@section("content")
    <!-- BEGIN : LOGIN PAGE 5-2 -->
    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 login-container bs-reset">
                {{--<div class="col-md-12">--}}
                    {{--<div class="m-heading-1 border-blue m-bordered margin-top-40">--}}
                        {{--<h3>به سایت آلاء خوش آمدید</h3>--}}
                        {{--<p>--}}
                    {{--ثبت نام در سایت آلاء به معنی ثبت نام در اردو نیستا!--}}
                        {{--</p>--}}
                        {{--<p>--}}
                        {{--برای دیدن انواع اردو ها و خدمات سایت ما مثل مشاوره ی فردی که به سفارش آلاء راه انداختیم باید اول تو سایتمون عضو شید.--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="col-md-12 margin-top-40">
                    <div class="note note-info bg-font-dark bg-green-sharp" >
                        <h4 class="block bold">به سایت آلاء خوش آمدید</h4>
                        <h5 class="bold" style="line-height: normal;">نیازی به ثبت نام نیست .برای ورود تنها کافی است شماره موبایل و کد ملی خود را وارد کنید</h5>
                    </div>
                </div>
                {{--<img class="login-logo login-6" src="../assets/pages/img/login/login-invert.png" />--}}
                <div class="login-content">
                    @include("partials.loginForm" , ["withHeader"=>true])
                </div>
                <div class="login-footer">
                    <div class="row bs-reset">
                        <div class="col-xs-5 bs-reset">
                            <ul class="login-social">
                                @if(isset($wSetting->socialNetwork->telegram->channel->link) && strlen($wSetting->socialNetwork->telegram->channel->link) > 0)
                                    <li>
                                        <a target="_blank" href="{{$wSetting->socialNetwork->telegram->channel->link}}">
                                            <i class="fa fa-telegram fa-2x" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                        <div class="col-xs-7 bs-reset">
                            <div class="login-copyright text-right">
                                <p>Copyright &copy; Alaa 2017</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 bs-reset">
                <div class="login-bg"> </div>
            </div>
        </div>
    </div>

    <!-- END : LOGIN PAGE 5-2 -->
@endsection
@section("footer")

@endsection
@section("footerPageLevelPlugin")
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
@endsection
@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/login-5.min.js" type="text/javascript"></script>
@endsection
