<div class="alert alert-warning alert-dismissable" style="text-align: justify">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>توجه!</strong> کاربر گرامی ، پس از تکمیل اطلاعات شخصی(فیلد های پایین) امکان اصلاح اطلاعات ثبت شده وجود
    نخواهد داشت. لذا خواهشمند هستیم این اطلاعات را در صحت و دقت کامل تکمیل نمایید . باتشکر
</div>
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
<div class="form-group">
    <label for="gender" class="control-label">جنیست</label>
    <div class="input-icon"><i class="fa fa-user" aria-hidden="true"></i>
        {!! Form::select('gender_id',$genders,null,['class' => 'form-control', 'id' => 'gender_id']) !!}
    </div>
</div>
<div class="form-group">
<label for="school" class="control-label">مدرسه</label>
<div class="input-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
<input id="school" class="form-control placeholder-no-fix" type="text" value="{{ $user->school }}"  name="school" /> </div>
</div>
<div class="form-group">
<label for="major" class="control-label">رشته</label>
<div class="input-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i>
{!! Form::select('major_id',$majors,null,['class' => 'form-control', 'id' => 'major_id']) !!}
</div>
</div>
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

{{--<div class="form-group {{ $errors->has('techCode') ? ' has-error' : '' }}">--}}
    {{--<label for="techCode" class="control-label">کد تکنسین</label>--}}
    {{--<div class="input-icon"><i class="fa fa-id-card" aria-hidden="true"></i>--}}
        {{--<input id="techCode" class="form-control placeholder-no-fix" type="text" value="{{ $user->techCode }}"--}}
               {{--name="techCode"/>--}}
    {{--</div>--}}
    {{--@if ($errors->has('techCode'))--}}
        {{--<span class="help-block">--}}
            {{--<strong>{{ $errors->first('techCode') }}</strong>--}}
        {{--</span>--}}
    {{--@endif--}}
{{--</div>--}}

<div class="row static-info margin-top-20">
    <div class="form-group  {{ $errors->has('bio') ? ' has-error' : '' }}">
        <div class="col-md-12">
            {!! Form::textarea('bio',null,['class' => 'form-control' , 'placeholder'=>'درباره ی شما' , 'rows'=>'13']) !!}
        </div>
    </div>
</div>
<div class="margiv-top-10">
    <button type="submit" class="btn green"> ذخیره</button>
</div>
{!! Form::close() !!}