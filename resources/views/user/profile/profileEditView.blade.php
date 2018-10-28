@if(isset($text1p1) || isset($text1p2))
    {{--<div class="alert alert-info alert-dismissable" style="text-align: justify">--}}
    {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}
    {{--{{$text1}}--}}
    {{--</div>--}}
    <p class="list-group-item  bg-blue-soft bg-font-blue-soft margin-bottom-10" style="text-align: justify;">
        {{$text1p1}}
        <br>
        {{$text1p2}}
    </p>
@endif

{!! Form::model($user,['method' => 'PUT','action' => [(isset($formAction))?$formAction:'UserController@updateProfile'] , 'role'=>'form' ]) !!}
<div class="form-group {{ $errors->has('province') ? ' has-error' : '' }}">
    <label for="province" class="control-label ">استان</label>
    @if(isset($requiredFields) && in_array("province" , $requiredFields))
        <span class="required" aria-required="true"> * </span>
    @endif
    <div class="input-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i>
        <input id="province" class="form-control placeholder-no-fix" type="text" value="{{(!is_null(old("province"))?old("province"):$user->province)}}" name="province"/>
    </div>
    @if ($errors->has('province'))
        <span class="help-block">
            <strong>{{ $errors->first('province') }}</strong>
        </span>
    @endif
</div>
<div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
    <label for="city" class="control-label">شهر</label>
    @if(isset($requiredFields) && in_array("city" , $requiredFields))
        <span class="required" aria-required="true"> * </span>
    @endif
    <div class="input-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i>
        <input id="city" class="form-control placeholder-no-fix" type="text" value="{{(!is_null(old("city"))?old("city"):$user->city)}}" name="city"/>
    </div>
    @if ($errors->has('city'))
        <span class="help-block">
            <strong>{{ $errors->first('city') }}</strong>
        </span>
    @endif
</div>
<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
    <label for="address" class="control-label">آدرس محل سکونت</label>
    @if(isset($requiredFields) && in_array("address" , $requiredFields))
        <span class="required" aria-required="true"> * </span>
    @endif
    <div class="input-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>
        <input id="address" class="form-control placeholder-no-fix" type="text" value="{{(!is_null(old("address"))?old("address"):$user->address)}}" name="address"/>
    </div>
    @if ($errors->has('address'))
        <span class="help-block">
            <strong>{{ $errors->first('address') }}</strong>
        </span>
    @endif
</div>
<div class="form-group {{ $errors->has('postalCode') ? ' has-error' : '' }}">
    <label for="postalCode" class="control-label">کد پستی</label>
    @if(isset($requiredFields) && in_array("postalCode" , $requiredFields))
        <span class="required" aria-required="true"> * </span>
    @endif
    <div class="input-icon"><i class="fa fa-envelope-open" aria-hidden="true"></i>
        <input id="postalCode" class="form-control placeholder-no-fix" type="text" value="{{(!is_null(old("postalCode"))?old("postalCode"):$user->postalCode)}}"
               name="postalCode"/>
    </div>
    @if ($errors->has('postalCode'))
        <span class="help-block">
            <strong>{{ $errors->first('postalCode') }}</strong>
        </span>
    @endif
</div>
<div class="form-group {{ $errors->has('gender_id') ? ' has-error' : '' }}">
    <label for="gender" class="control-label">جنیست</label>
    @if(isset($requiredFields) && in_array("gender" , $requiredFields))
        <span class="required" aria-required="true"> * </span>
    @endif
    <div class="input-icon"><i class="fa fa-user" aria-hidden="true"></i>
        {!! Form::select('gender_id',$genders,null,['class' => 'form-control', 'id' => 'gender_id']) !!}
    </div>
    @if ($errors->has('gender_id'))
        <span class="help-block">
            <strong>{{ $errors->first('gender_id') }}</strong>
        </span>
    @endif
</div>
@if(isset($withBirthdate) && $withBirthdate)
    <div class="form-group {{ $errors->has('birthdate') ? ' has-error' : '' }}">
        <label for="birthdate" class="control-label">تاریخ تولد</label>
        @if(isset($requiredFields) && in_array("birthdate" , $requiredFields))
            <span class="required" aria-required="true"> * </span>
        @endif
        <div class="input-icon"><i class="fa fa-calendar-times-o" aria-hidden="true"></i>
            <input id="birthdate" type="text" class="form-control placeholder-no-fix" value="{{(!is_null(old("birthdate"))?old("birthdate"):$user->birthdate)}}">
            <input name="birthdate" id="birthdateAlt" type="text" class="form-control hidden" >
        </div>
        @if ($errors->has('birthdate'))
            <span class="help-block">
            <strong>{{ $errors->first('birthdate') }}</strong>
        </span>
        @endif
    </div>
@endif
<div class="form-group {{ $errors->has('school') ? ' has-error' : '' }}">
    <label for="school" class="control-label">مدرسه</label>
    @if(isset($requiredFields) && in_array("school" , $requiredFields))
        <span class="required" aria-required="true"> * </span>
    @endif
    <div class="input-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
        <input id="school" class="form-control placeholder-no-fix" type="text" value="{{(!is_null(old("school"))?old("school"):$user->school)}}"  name="school" /> </div>
    @if ($errors->has('school'))
        <span class="help-block">
            <strong>{{ $errors->first('school') }}</strong>
        </span>
    @endif
</div>
<div class="form-group {{ $errors->has('major_id') ? ' has-error' : '' }}">
    <label for="major" class="control-label">رشته</label>
    @if(isset($requiredFields) && in_array("major" , $requiredFields))
        <span class="required" aria-required="true"> * </span>
    @endif
    <div class="input-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
        {!! Form::select('major_id',$majors,null,['class' => 'form-control', 'id' => 'major_id']) !!}
    </div>
    @if ($errors->has('major_id'))
        <span class="help-block">
            <strong>{{ $errors->first('major_id') }}</strong>
        </span>
    @endif
</div>
@if(isset($withIntroducer) && $withIntroducer)
    <div class="form-group {{ $errors->has('introducedBy') ? ' has-error' : '' }}">
        <label for="introducedBy" class="control-label">چگونه با آلاء آشنا شدید؟</label>
        @if(isset($requiredFields) && in_array("introducedBy" , $requiredFields))
            <span class="required" aria-required="true"> * </span>
        @endif
        <div class="input-icon"><i class="fa fa-pencil" aria-hidden="true"></i>
            <input id="introducedBy" class="form-control placeholder-no-fix" type="text" value="{{(!is_null(old("introducedBy"))?old("introducedBy"):$user->introducedBy)}}"  name="introducedBy" /> </div>
        @if ($errors->has('introducedBy'))
            <span class="help-block">
            <strong>{{ $errors->first('introducedBy') }}</strong>
        </span>
        @endif
    </div>
@endif
<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="control-label">ایمیل(اختیاری)</label>
    <div class="input-icon"><i class="fa fa-envelope-o" aria-hidden="true"></i>
        <input id="email" class="form-control placeholder-no-fix" type="text" value="{{(!is_null(old("email"))?old("email"):$user->email)}}" name="email"/>
    </div>
    @if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
</div>

@if(isset($withBio) && $withBio)
    <div class="row static-info margin-top-20">
        <div class="form-group  {{ $errors->has('bio') ? ' has-error' : '' }}">
            <div class="col-md-12">
                {!! Form::textarea('bio',null,['class' => 'form-control' , 'placeholder'=>'درباره ی شما' , 'rows'=>'13']) !!}
            </div>
        </div>
    </div>
@endif


@if(isset($text3))
    @if(!$user->hasVerifiedMobile() || !isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)
        <div class="alert alert-danger alert-dismissable margin-top-10" id="profileEditViewText3" style="text-align: justify">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            @if(!$user->hasVerifiedMobile())لطفا شماره موبایل خود را تایید نمایید<br>@endif
            @if(!isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)<span id="profileEditViewText3-span2">لطفا عکس خود را آپلود نمایید</span>@endif
        </div>
    @endif
@endif
@if(isset($text2))
    <div class="alert alert-warning alert-dismissable" style="text-align: justify">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <strong>توجه!</strong>
        {!!  $text2 !!}
    </div>
@endif
<div class="margiv-top-10 ">
    <button type="submit" class="btn btn-lg green" id="updateProfileInfoFormButton" {{(isset($disableSubmit) && $disableSubmit)?"disabled":""}}> @if(isset($submitCaption)){{$submitCaption}} @else ثبت درخواست @endif</button>
</div>
{!! Form::close() !!}