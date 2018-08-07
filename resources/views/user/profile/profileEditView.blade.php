@if(isset($text1))
{{--<div class="alert alert-info alert-dismissable" style="text-align: justify">--}}
    {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}
      {{--{{$text1}}--}}
{{--</div>--}}
<p class="list-group-item  bg-blue-soft bg-font-blue-soft margin-bottom-10" style="text-align: justify;">
    {{$text1}}
</p>
@endif
@if(isset($text2))
    <div class="alert alert-warning alert-dismissable" style="text-align: justify">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <strong>توجه!</strong>
        {!!  $text2 !!}
    </div>
@endif
{!! Form::model($user,['method' => 'POST','action' => ['UserController@updateProfile'] , 'role'=>'form']) !!}
<input type="hidden" name="_method" value="PUT">
{{ csrf_field() }}
<div class="form-group">
    <label for="province" class="control-label ">استان</label>
    <div class="input-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i>
        <input id="province" class="form-control placeholder-no-fix" type="text" value="{{ $user->province }}"
       name="province"/></div>
</div>
<div class="form-group">
    <label for="city" class="control-label">شهر</label>
    <div class="input-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i>
        <input id="city" class="form-control placeholder-no-fix" type="text" value="{{ $user->city }}" name="city"/>
    </div>
</div>
<div class="form-group">
    <label for="address" class="control-label">آدرس محل سکونت</label>
    <div class="input-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>
        <input id="address" class="form-control placeholder-no-fix" type="text" value="{{ $user->address }}"
               name="address"/></div>
</div>
<div class="form-group {{ $errors->has('postalCode') ? ' has-error' : '' }}">
    <label for="postalCode" class="control-label">کد پستی</label>
    <div class="input-icon"><i class="fa fa-envelope-open" aria-hidden="true"></i>
        <input id="postalCode" class="form-control placeholder-no-fix" type="text" value="{{ $user->postalCode }}"
               name="postalCode"/>
        @if ($errors->has('postalCode'))
            <span class="help-block">
                <strong>{{ $errors->first('postalCode') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('gender_id') ? ' has-error' : '' }}">
    <label for="gender" class="control-label">جنیست</label>
    <div class="input-icon"><i class="fa fa-user" aria-hidden="true"></i>
        {!! Form::select('gender_id',$genders,null,['class' => 'form-control', 'id' => 'gender_id']) !!}
    </div>
</div>
@if(isset($withBirthdate) && $withBirthdate)
<div class="form-group {{ $errors->has('birthdate') ? ' has-error' : '' }}">
    <label for="birthdate" class="control-label">تاریخ تولد</label>
    <div class="input-icon"><i class="fa fa-calendar-times-o" aria-hidden="true"></i>
        <input id="birthdate" type="text" class="form-control placeholder-no-fix" value="{{ $user->birthdate }}">
        <input name="birthdate" id="birthdateAlt" type="text" class="form-control hidden" >
    </div>
</div>
@endif
<div class="form-group">
<label for="school" class="control-label">مدرسه</label>
<div class="input-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
<input id="school" class="form-control placeholder-no-fix" type="text" value="{{ $user->school }}"  name="school" /> </div>
</div>
<div class="form-group {{ $errors->has('major_id') ? ' has-error' : '' }}">
<label for="major" class="control-label">رشته</label>
<div class="input-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
{!! Form::select('major_id',$majors,null,['class' => 'form-control', 'id' => 'major_id']) !!}
</div>
</div>
@if(isset($withIntroducer) && $withIntroducer)
<div class="form-group">
    <label for="introducedBy" class="control-label">چگونه با آلاء آشنا شدید؟</label>
    <div class="input-icon"><i class="fa fa-pencil" aria-hidden="true"></i>
        <input id="introducedBy" class="form-control placeholder-no-fix" type="text" value="{{ $user->introducedBy }}"  name="introducedBy" /> </div>
</div>
@endif
<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="control-label">ایمیل</label>
    <div class="input-icon"><i class="fa fa-envelope-o" aria-hidden="true"></i>
        <input id="email" class="form-control placeholder-no-fix" type="text" value="{{ $user->email }}" name="email"/>
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
<div class="margiv-top-10">
    <button type="submit" class="btn green"> @if(isset($submitCaption)){{$submitCaption}} @else ثبت درخواست @endif</button>
</div>
{!! Form::close() !!}