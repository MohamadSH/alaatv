@if(isset($withHeader) && $withHeader)<h1 class="bold">ورود به سایت آلاء</h1>@endif
<p> برای ورود <span class="font-red bold" style="line-height: normal">نیازی به ثبت نام نیست. </span> تنها شماره موبایل و کد ملی خود را وارد نمایند</p>
<form action="{{action("Auth\LoginController@login")}}" class="login-form" method="post" >
    {{ csrf_field() }}
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span>شماره موبایل و کد ملی خود را وارد نمایید </span>
    </div>
    @if (Session::has('warning'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <button class="close" data-close="alert"></button>
                    <span>{{Session::pull('warning')}}</span>
                </div>
            </div>
        </div>
    @elseif (Session::has('success'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <button class="close" data-close="alert"></button>
                    <span>{{Session::pull('success')}}</span>
                </div>
            </div>
        </div>
    @elseif(Session::has('error'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span>{{Session::pull('error')}}</span>
                </div>
            </div>
        </div>
    @endif
    @if($errors->login->has('validation'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span><strong>{{$errors->login->first('validation')}}</strong></span>
                </div>
            </div>
        </div>
    @elseif($errors->login->has('credential'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" dir="rtl">
                    <button class="close" data-close="alert"></button>
                    <span><strong>{{$errors->login->first('credential')}}</strong></span>
                </div>
            </div>
        </div>
    @elseif($errors->login->has('inActive'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" dir="rtl">
                    <button class="close" data-close="alert"></button>
                    <span><strong>{{$errors->login->first('inActive')}}</strong></span>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-xs-6 {{ $errors->has('mobile') ? ' has-error' : '' }}">
            <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('mobile') ? ' has-error' : '' }}" {{ $errors->has('mobile') ? ' style=margin-bottom:10px' : '' }} value="{{ old('mobile') }}" type="text" autocomplete="off" placeholder="شماره موبایل" name="mobile" />
            @if ($errors->has('mobile'))
                <span class="help-block">
                                          <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
            @endif
        </div>
        <div class="col-xs-6 {{ $errors->has('nationalCode') ? ' has-error' : '' }}" >
            <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('nationalCode') ? ' has-error' : '' }}" {{ $errors->has('nationalCode') ? ' style=margin-bottom:10px' : '' }} value="{{ old('password') }}" type="password" autocomplete="off" placeholder="کد ملی" name="password" />
            @if ($errors->has('nationalCode'))
                <span class="help-block">
                      <strong>{{ $errors->first('nationalCode') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="md-checkbox-inline">
                <div class="md-checkbox has-success">
                    <input type="checkbox" name="remember" value="1" id="rememberCheckbox" class="md-check">
                    <label for="rememberCheckbox">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>  مرا بخاطر بسپار </label>
                </div>
            </div>
        </div>
        <div class="col-sm-7 text-right">
            <button class="btn blue" type="submit">ورود</button>
        </div>
    </div>
</form>
<!-- BEGIN FORGOT PASSWORD FORM -->
