
<div id="profileMenuPage-setting" class="m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon m--hide">
                    <i class="flaticon-statistics"></i>
                </span>
                <h3 class="m-portlet__head-text">
                    اطلاعات شخصی
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">

        </div>
    </div>
    <div class="m-portlet__body">

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

<p><i class="fa fa-location-arrow font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">استان: </strong><span class="bold"> {{$user->province}}</span>
</p>
<p><i class="fa fa-location-arrow font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">شهر: </strong><span class="bold"> {{$user->city}}</span>
</p>
<p><i class="fa fa-map-marker font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">آدرس محل سکونت: </strong><span class="bold"> {{$user->address}}</span>
</p>
<p><i class="fa fa-envelope-open font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">کد پستی: </strong><span class="bold"> {{$user->postalCode}}</span>
</p>
<p><i class="fa fa-user font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">جنیست: </strong><span
            class="bold">@if(isset($user->gender)) {{$user->gender->name}} @else <span class="label label-danger">درج نشده</span>  @endif</span>
</p>
@if(isset($user->birthdate))
    <p><i class="fa fa-calendar-times-o font-yellow-gold" aria-hidden="true"></i>
        <strong class="font-yellow-gold">تاریخ تولد: </strong><span
                class="bold">@if(isset($user->birthdate)) {{$user->Birthdate_Jalali()}} @else <span
                    class="label label-danger">درج نشده</span>  @endif</span>
    </p>
@endif
<p><i class="fa fa-graduation-cap font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">مدرسه: </strong><span
            class="bold">@if(isset($user->school)) {{$user->school}} @else <span
                class="label label-danger">درج نشده</span>  @endif</span>
</p>
<p><i class="fa fa-graduation-cap font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">رشته: </strong><span
            class="bold">@if(isset($user->major)) {{$user->major->name}} @else <span
                class="label label-danger">درج نشده</span>  @endif</span>
</p>
@if(isset($user->introducedBy))
    <p><i class="fa fa-pencil font-yellow-gold" aria-hidden="true"></i>
        <strong class="font-yellow-gold">چگونه با آلاء آشنا شدید: </strong><span
                class="bold">@if(isset($user->introducedBy)) {{$user->introducedBy}} @else <span
                    class="label label-danger">درج نشده</span>  @endif</span>
    </p>
@endif
<p><i class="fa fa-envelope-o font-yellow-gold" aria-hidden="true"></i>
    <strong class="font-yellow-gold">ایمیل: </strong><span class="bold"> @if(isset($user->email)){{$user->email}} @else
            <span class="label label-danger">درج نشده</span> @endif</span>
</p>