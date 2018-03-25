@extends("app")

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
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
@section("content")
    <!-- BEGIN : LOGIN PAGE 5-2 -->
    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 login-container bs-reset" id="rightSide">
                {{--<img class="login-logo login-6" src="/assets/pages/img/login/login-invert.png" alt="ورود" />--}}
                <div class="login-content margin-top-10">
                    <div class="col-md-12 border-bottom-default" style="border-bottom: solid 1px">
                        @include("user.form"  , ["formID"=>2])
                    </div>
                    @include("partials.loginForm")
                    <!-- BEGIN FORGOT PASSWORD FORM -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="forget-form col-md-12" action="{{ action("UserController@sendGeneratedPassword") }}" method="post" style="margin-top:15%;padding-bottom: 15%;">
                        {{ csrf_field() }}
                        <h4>رمز عبور خود را فراموش کرده اید؟</h4>
                        <p> جهت دریافت رمز عبور جدید ، شماره موبایل خود را وارد نمایید. </p>
                        <div class="form-group {{ $errors->has('mobileNumber') ? ' has-error' : '' }}" style="border-bottom: none !important;">
                            <input  class="form-control placeholder-no-fix" type="text" value="{{ old('mobileNumber') }}" autocomplete="off" placeholder="شماره موبایل" name="mobileNumber" maxlength="11"/>
                            @if ($errors->has('mobileNumber'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('mobileNumber') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-actions">
                            <button type="button" id="back-btn" class="btn blue btn-outline">بازگشت</button>
                            <button type="submit" class="btn blue uppercase pull-right">ارسال رمز جدید</button>
                        </div>
                    </form>
                    <!-- END FORGOT PASSWORD FORM -->
                </div>
                <div class="login-footer">
                    <div class="row bs-reset">
                        <div class="col-xs-5 bs-reset">
                            <ul class="login-social">
                                <li>
                                    <a target="_blank" href="https://telegram.me/alaa_sanatisharif">
                                        <i class="fa fa-telegram" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-7 bs-reset">
                            <div class="login-copyright text-right">
                                <p>Copyright &copy; Alaa 2016   </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 bs-reset" id="leftSide">
                <div class="portlet">
                    <div class="login-bg" > </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN Portlet PORTLET-->
                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>عضویت در سایت </div>
                            </div>
                            <div class="portlet-body">
                               <p>
                                   ثبت نام در سایت تخته خاک به معنی ثبت نام در اردو نیستا!
                                </p><p>
                                   برای دیدن انواع اردو ها و خدمات سایت ما مثل مشاوره ی فردی که به سفارش آلاء راه انداختیم باید اول تو سایتمون عضو شید.
                                </p>
                            </div>
                        </div>
                        <!-- END Portlet PORTLET-->
                    </div></div>
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
    <script src="/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
@endsection
@section("footerPageLevelScript")
    <script src="/assets/pages/scripts/login-5.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
@endsection
@section("extraJS")
	<script type="text/javascript">
		 $(document).ready(function() {
			@if ($errors->has('mobileNumber'))
						$("#forget-password").trigger("click");
					@endif  
			});
		
	</script>
	
@endsection
