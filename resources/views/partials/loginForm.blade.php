<form class = "m-login__form m-form" action = "{{ action("Auth\LoginController@login") }}" method = "post">
    @if($errors->login->has('validation'))
        <div class = "alert alert-danger">
            <button class = "close" data-close = "alert"></button>
            <span><strong>{{$errors->login->first('validation')}}</strong></span>
        </div>
    @elseif($errors->login->has('credential'))
        <div class = "alert alert-danger">
            <button class = "close" data-close = "alert"></button>
            <span><strong>{{$errors->login->first('credential')}}</strong></span>
        </div>
    @elseif($errors->login->has('inActive'))
        <div class = "alert alert-danger" dir = "rtl">
            <button class = "close" data-close = "alert"></button>
            <span><strong>{{$errors->login->first('inActive')}}</strong></span>
        </div>
    @endif
    {{ csrf_field() }}
    <div class = "form-group m-form__group {{ $errors->has('mobile') ? ' has-danger' : '' }}">
        <input class = "form-control m-input" type = "text" placeholder = "شماره موبایل" value = "{{ old('mobile') }}"  name = "mobile" autocomplete = "off">
        @if ($errors->has('mobile'))
            <div class="form-control-feedback">{{ $errors->first('mobile') }}</div>
        @endif
    </div>
    <div class = "form-group m-form__group {{ $errors->has('nationalCode') ? ' has-danger' : '' }}">
        <input class = "form-control m-input m-login__form-input--last" type = "password" placeholder = "کد ملی" value = "{{ old('password') }}" name = "password">
        @if ($errors->has('nationalCode'))
            <div class="form-control-feedback">{{ $errors->first('nationalCode') }}</div>
        @endif
    </div>
    <div class = "row m-login__form-sub">
        <div class = "col m--align-left">
            <a href = "javascript:" id = "m_login_forget_password" class = "m-link">رمز خود را فراموش کردید ؟</a>
        </div>
    </div>
    <div class = "m-login__form-action">
        <button id = "m_login_signin_submit" class = "btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air"  type = "submit">ورود</button>
    </div>
</form>
