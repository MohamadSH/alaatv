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


<div id="profileMenuPage-setting" class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
							<i class="flaticon-statistics"></i>
						</span>
                <h3 class="m-portlet__head-text">
                    ویرایش اطلاعات شخصی
                </h3>
                <h2 class="m-portlet__head-label m-portlet__head-label--warning">
                                <span style="white-space: nowrap;">
                                    <i class="flaticon-cogwheel"></i>
                                    تنظیمات حساب کاربری
                                </span>
                </h2>
            </div>
        </div>
        <div class="m-portlet__head-tools">

        </div>
    </div>
    <div class="m-portlet__body">

        {!! Form::model($user,['method' => 'PUT','action' => [(isset($formAction))?$formAction:'Web\UserController@update' , Auth::user()] , 'role'=>'form' , 'id' => 'profileForm-setting']) !!}
            {!! Form::hidden('updateType',"profile") !!}
            <div class="form-group m-form__group {{ $errors->has('province') ? ' has-error' : '' }}">
                <label for="province">استان</label>
                <div class="m-input-icon m-input-icon--left">
                    <input type = "text" name = "province" id = "province" class = "form-control m-input m-input--air" placeholder = "استان">
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                        <span>
                            <i class = "flaticon-placeholder"></i>
                        </span>
                    </span>
                </div>
            </div>
            <div class="form-group m-form__group {{ $errors->has('city') ? ' has-error' : '' }}">
                <label for="city">شهر</label>
                <div class="m-input-icon m-input-icon--left">
                    <input type="text" name="city" id="city" class="form-control m-input m-input--air" placeholder="شهر">
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                        <span>
                            <i class = "flaticon-placeholder"></i>
                        </span>
                    </span>
                </div>
            </div>
            <div class="form-group m-form__group {{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="address">آدرس محل سکونت</label>
                <div class="m-input-icon m-input-icon--left">
                    <input type = "text" name = "address" id = "address" class = "form-control m-input m-input--air" placeholder = "آدرس محل سکونت">
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                        <span>
                            <i class = "flaticon-map-location"></i>
                        </span>
                    </span>
                </div>
            </div>
            <div class="form-group m-form__group {{ $errors->has('postalCode') ? ' has-error' : '' }}">
                <label for="postalCode">کد پستی</label>
                <div class="m-input-icon m-input-icon--left">
                    <input type = "text" name = "postalCode" id = "postalCode" class = "form-control m-input m-input--air" placeholder = "کد پستی">
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                        <span>
                            <i class = "flaticon-mail-1"></i>
                        </span>
                    </span>
                </div>
            </div>
            <div class="form-group m-form__group {{ $errors->has('gender_id') ? ' has-error' : '' }}">
                <label for="gender_id">جنسیت</label>
                <div class="m-input-icon m-input-icon--left">
                    {!! Form::select('gender_id',$genders,null,['class' => 'form-control m-input m-input--air', 'id' => 'gender_id']) !!}
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                        <span>
                            <i class = "la la-user"></i>
                        </span>
                    </span>
                </div>
            </div>

            @if(isset($withBirthdate) && $withBirthdate)
                <div class="form-group m-form__group {{ $errors->has('birthdate') ? ' has-error' : '' }}">
                    <label for="birthdate">تاریخ تولد</label>
                    <div class="m-input-icon m-input-icon--left">
                        <input class="form-control m-input m-input--air" name="birthdate" id="birthdate"/>
                        <input name="birthdateAlt" id="birthdateAlt" type="hidden"/>
                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class = "flaticon-calendar-1"></i>
                                </span>
                            </span>
                    </div>
                </div>
            @endif

            <div class="form-group m-form__group {{ $errors->has('school') ? ' has-error' : '' }}">
                <label for="school">مدرسه</label>
                <div class="m-input-icon m-input-icon--left">
                    <input type = "text" name = "school" id = "school" class = "form-control m-input m-input--air" placeholder = "مدرسه">
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class = "la la-university"></i>
                                    </span>
                                </span>
                </div>
            </div>
            <div class="form-group m-form__group {{ $errors->has('major_id') ? ' has-error' : '' }}">
                <label for="major_id">رشته</label>
                <div class="m-input-icon m-input-icon--left">
                    {!! Form::select('major_id',$majors,null,['class' => 'form-control m-input m-input--air', 'id' => 'major_id']) !!}
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                            <span>
                                <i class = "la la-mortar-board"></i>
                            </span>
                        </span>
                </div>
            </div>

            @if(isset($withIntroducer) && $withIntroducer)
                <div class="form-group m-form__group {{ $errors->has('introducedBy') ? ' has-error' : '' }}">
                    <label for="introducedBy">چگونه با آلاء آشنا شدید؟</label>
                    <div class="m-input-icon m-input-icon--left">
                        <input type = "text" name = "introducedBy" id = "introducedBy" class = "form-control m-input m-input--air" placeholder = "ایمیل">
                        <span class="m-input-icon__icon m-input-icon__icon--left">
                            <span>
                                <i class = "la la-mortar-board"></i>
                            </span>
                        </span>
                    </div>
                </div>
            @endif

            <div class="form-group m-form__group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">ایمیل(اختیاری)</label>
                <div class="m-input-icon m-input-icon--left">
                    <input type = "text" name = "email" id = "email" class = "form-control m-input m-input--air" placeholder = "ایمیل">
                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class = "flaticon-mail"></i>
                                    </span>
                                </span>
                </div>
            </div>

            @if(isset($withBio) && $withBio)
                <div class="form-group m-form__group {{ $errors->has('bio') ? ' has-error' : '' }}">
                    <label for="bio">درباره ی شما</label>
                    <div class="m-input-icon m-input-icon--left">
                        <textarea id = "bio" class = "form-control m-input m-input--air" placeholder = "درباره ی شما" rows = "13" name = "bio" cols = "50"></textarea>
                    </div>
                </div>
            @endif

            @if(isset($text3))
                @if(!$user->hasVerifiedMobile() || !isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)
                    <div class="m-alert m-alert--icon alert alert-danger" role="alert">
                        <div class="m-alert__icon">
                            <i class="flaticon-danger"></i>
                        </div>
                        <div class="m-alert__text">
                            <strong>
                                @if(!$user->hasVerifiedMobile())لطفا شماره موبایل خود را تایید نمایید
                                <br>@endif
                                @if(!isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)
                                    <span id="profileEditViewText3-span2">لطفا عکس خود را آپلود نمایید</span>
                                @endif
                            </strong>
                        </div>
                        <div class="m-alert__close">
                            <button type="button" class="close" data-close="alert" aria-label="Hide"></button>
                        </div>
                    </div>
                @endif
            @endif
            @if(isset($text2))
                <div class="m-alert m-alert--icon alert alert-warning" role="alert">
                    <div class="m-alert__icon">
                        <i class="flaticon-danger"></i>
                    </div>
                    <div class="m-alert__text">
                        <strong>توجه!</strong>
                        {!!  $text2 !!}
                    </div>
                    <div class="m-alert__close">
                        <button type="button" class="close" data-close="alert" aria-label="Hide"></button>
                    </div>
                </div>
            @endif

        <button type = "button" id = "btnUpdateProfileInfoForm" class = "btn m-btn--pill m-btn--air btn-primary">
                @if(isset($submitCaption))
                    {{$submitCaption}}
                @else
                    ثبت درخواست
                @endif
            </button>

        <input type = "hidden" id = "userUpdateProfileUrl" value = "{{ action((isset($formAction))?$formAction:'Web\UserController@update' , Auth::user()) }}">

        {!! Form::close() !!}
    </div>
</div>

{{--{!! Form::model($user,['method' => 'PUT','action' => [(isset($formAction))?$formAction:'Web\UserController@update' , Auth::user()] , 'role'=>'form' ]) !!}--}}{{--{!! Form::hidden('updateType',"profile") !!}--}}{{--<div class="form-group {{ $errors->has('province') ? ' has-error' : '' }}">--}}{{--<label for="province" class="control-label ">استان</label>--}}{{--@if(isset($requiredFields) && in_array("province" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i>--}}{{--<input id="province" class="form-control placeholder-no-fix" type="text"--}}{{--value="{{(!is_null(old("province"))?old("province"):$user->province)}}" name="province"/>--}}{{--</div>--}}{{--@if ($errors->has('province'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('province') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--<div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">--}}{{--<label for="city" class="control-label">شهر</label>--}}{{--@if(isset($requiredFields) && in_array("city" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-location-arrow" aria-hidden="true"></i>--}}{{--<input id="city" class="form-control placeholder-no-fix" type="text"--}}{{--value="{{(!is_null(old("city"))?old("city"):$user->city)}}" name="city"/>--}}{{--</div>--}}{{--@if ($errors->has('city'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('city') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">--}}{{--<label for="address" class="control-label">آدرس محل سکونت</label>--}}{{--@if(isset($requiredFields) && in_array("address" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-map-marker" aria-hidden="true"></i>--}}{{--<input id="address" class="form-control placeholder-no-fix" type="text"--}}{{--value="{{(!is_null(old("address"))?old("address"):$user->address)}}" name="address"/>--}}{{--</div>--}}{{--@if ($errors->has('address'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('address') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--<div class="form-group {{ $errors->has('postalCode') ? ' has-error' : '' }}">--}}{{--<label for="postalCode" class="control-label">کد پستی</label>--}}{{--@if(isset($requiredFields) && in_array("postalCode" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-envelope-open" aria-hidden="true"></i>--}}{{--<input id="postalCode" class="form-control placeholder-no-fix" type="text"--}}{{--value="{{(!is_null(old("postalCode"))?old("postalCode"):$user->postalCode)}}"--}}{{--name="postalCode"/>--}}{{--</div>--}}{{--@if ($errors->has('postalCode'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('postalCode') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--<div class="form-group {{ $errors->has('gender_id') ? ' has-error' : '' }}">--}}{{--<label for="gender" class="control-label">جنیست</label>--}}{{--@if(isset($requiredFields) && in_array("gender" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-user" aria-hidden="true"></i>--}}{{--{!! Form::select('gender_id',$genders,null,['class' => 'form-control', 'id' => 'gender_id']) !!}--}}{{--</div>--}}{{--@if ($errors->has('gender_id'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('gender_id') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--@if(isset($withBirthdate) && $withBirthdate)--}}{{--<div class="form-group {{ $errors->has('birthdate') ? ' has-error' : '' }}">--}}{{--<label for="birthdate" class="control-label">تاریخ تولد</label>--}}{{--@if(isset($requiredFields) && in_array("birthdate" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-calendar-times-o" aria-hidden="true"></i>--}}{{--<input id="birthdate" type="text" class="form-control placeholder-no-fix"--}}{{--value="{{(!is_null(old("birthdate"))?old("birthdate"):$user->birthdate)}}">--}}{{--<input name="birthdate" id="birthdateAlt" type="text" class="form-control hidden">--}}{{--</div>--}}{{--@if ($errors->has('birthdate'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('birthdate') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--@endif--}}{{--<div class="form-group {{ $errors->has('school') ? ' has-error' : '' }}">--}}{{--<label for="school" class="control-label">مدرسه</label>--}}{{--@if(isset($requiredFields) && in_array("school" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i>--}}{{--<input id="school" class="form-control placeholder-no-fix" type="text"--}}{{--value="{{(!is_null(old("school"))?old("school"):$user->school)}}" name="school"/></div>--}}{{--@if ($errors->has('school'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('school') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--<div class="form-group {{ $errors->has('major_id') ? ' has-error' : '' }}">--}}{{--<label for="major" class="control-label">رشته</label>--}}{{--@if(isset($requiredFields) && in_array("major" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-graduation-cap" aria-hidden="true"></i>--}}{{--{!! Form::select('major_id',$majors,null,['class' => 'form-control', 'id' => 'major_id']) !!}--}}{{--</div>--}}{{--@if ($errors->has('major_id'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('major_id') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--@if(isset($withIntroducer) && $withIntroducer)--}}{{--<div class="form-group {{ $errors->has('introducedBy') ? ' has-error' : '' }}">--}}{{--<label for="introducedBy" class="control-label">چگونه با آلاء آشنا شدید؟</label>--}}{{--@if(isset($requiredFields) && in_array("introducedBy" , $requiredFields))--}}{{--<span class="required" aria-required="true"> * </span>--}}{{--@endif--}}{{--<div class="input-icon"><i class="fa fa-pencil" aria-hidden="true"></i>--}}{{--<input id="introducedBy" class="form-control placeholder-no-fix" type="text"--}}{{--value="{{(!is_null(old("introducedBy"))?old("introducedBy"):$user->introducedBy)}}"--}}{{--name="introducedBy"/></div>--}}{{--@if ($errors->has('introducedBy'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('introducedBy') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}{{--@endif--}}{{--<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">--}}{{--<label for="email" class="control-label">ایمیل(اختیاری)</label>--}}{{--<div class="input-icon"><i class="fa fa-envelope-o" aria-hidden="true"></i>--}}{{--<input id="email" class="form-control placeholder-no-fix" type="text"--}}{{--value="{{(!is_null(old("email"))?old("email"):$user->email)}}" name="email"/>--}}{{--</div>--}}{{--@if ($errors->has('email'))--}}{{--<span class="help-block">--}}{{--<strong>{{ $errors->first('email') }}</strong>--}}{{--</span>--}}{{--@endif--}}{{--</div>--}}

{{--@if(isset($withBio) && $withBio)<div class="row static-info margin-top-20"><div class="form-group  {{ $errors->has('bio') ? ' has-error' : '' }}"><div class="col-md-12">{!! Form::textarea('bio',(!is_null(old("bio"))?old("bio"):$user->bio),['class' => 'form-control' , 'placeholder'=>'درباره ی شما' , 'rows'=>'13']) !!}</div></div></div>@endif--}}


{{--@if(isset($text3))--}}{{--@if(!$user->hasVerifiedMobile() || !isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)--}}{{--<div class="alert alert-danger alert-dismissable margin-top-10" id="profileEditViewText3"--}}{{--style="text-align: justify">--}}{{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}{{--@if(!$user->hasVerifiedMobile())لطفا شماره موبایل خود را تایید نمایید<br>@endif--}}{{--@if(!isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)<span--}}{{--id="profileEditViewText3-span2">لطفا عکس خود را آپلود نمایید</span>@endif--}}{{--</div>--}}{{--@endif--}}{{--@endif--}}{{--@if(isset($text2))--}}{{--<div class="alert alert-warning alert-dismissable" style="text-align: justify">--}}{{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>--}}{{--<strong>توجه!</strong>--}}{{--{!!  $text2 !!}--}}{{--</div>--}}{{--@endif--}}{{--<div class="margiv-top-10 ">--}}{{--<button type="submit" class="btn btn-lg green"--}}{{--id="updateProfileInfoFormButton" {{(isset($disableSubmit) && $disableSubmit)?"disabled":""}}> @if(isset($submitCaption)){{$submitCaption}} @else--}}{{--ثبت درخواست @endif</button>--}}{{--</div>--}}{{--{!! Form::close() !!}--}}