<div class = "m-portlet m-portlet--creative m-portlet--bordered-semi profileMenuPage profileMenuPage-setting profileMenuPage-setting-view">
    <div class = "m-portlet__head">
        <div class = "m-portlet__head-caption">
            <div class = "m-portlet__head-title">
                <span class = "m-portlet__head-icon m--hide">
                    <i class = "fa fa-chart-line"></i>
                </span>
                <h3 class = "m-portlet__head-text">
                    اطلاعات شخصی
                </h3>
            </div>
        </div>
        <div class = "m-portlet__head-tools">

        </div>
    </div>
    <div class = "m-portlet__body">

        <div class = "row">
            <div class = "col-md-6">
                <div class = "form-group m-form__group">
                    <label for = "province">استان</label>
                    <div class = "m-input-icon m-input-icon--left">
                        <i class = "fa fa-location-arrow float-left m--margin-right-10"></i>
                        <span>@if(isset($user->province)) {{ $user->province }} @else درج نشده @endif</span>
                    </div>
                </div>
                <div class = "form-group m-form__group">
                    <label for = "city">شهر</label>
                    <div class = "m-input-icon m-input-icon--left">
                        <i class = "fa fa-location-arrow float-left m--margin-right-10"></i>
                        <span>@if(isset($user->city)) {{ $user->city }} @else درج نشده @endif</span>
                    </div>
                </div>
                <div class = "form-group m-form__group">
                    <label for = "postalCode">کد پستی</label>
                    <div class = "m-input-icon m-input-icon--left">
                        <i class = "fa fa-envelope float-left m--margin-right-10"></i>
                        <span>@if(isset($user->postalCode)) {{ $user->postalCode }} @else درج نشده @endif</span>
                    </div>
                </div>
            </div>
            <div class = "col-md-6">
                <div class = "form-group m-form__group">
                    <label for = "school">مدرسه</label>
                    <div class = "m-input-icon m-input-icon--left">
                        <i class = "fa fa-university float-left m--margin-right-10"></i>
                        <span>@if(isset($user->school)) {{ $user->school }} @else درج نشده @endif</span>
                    </div>
                </div>
                <div class = "form-group m-form__group">
                    <label for = "major_id">رشته</label>
                    <div class = "m-input-icon m-input-icon--left">
                        <i class = "fa fa-graduation-cap float-left m--margin-right-10"></i>
                        <span>@if(isset($user->major)) {{ $user->major->name }} @else درج نشده @endif</span>
                    </div>
                </div>
                <div class = "form-group m-form__group">
                    <label for = "gender_id">جنسیت</label>
                    <div class = "m-input-icon m-input-icon--left">
                        <i class = "fa fa-user float-left m--margin-right-10"></i>
                        <span>@if(isset($user->gender)) {{ $user->gender->name }} @else درج نشده @endif</span>
                    </div>
                </div>
            </div>
            <div class = "col-12">
                @if(isset($user->birthdate))
                    <div class = "form-group m-form__group {{ $errors->has('birthdate') ? ' has-danger' : '' }}">
                        <label for = "birthdate">تاریخ تولد</label>
                        <div class = "m-input-icon m-input-icon--left">
                            <i class = "fa fa-calendar-alt float-left m--margin-right-10"></i> {{ $user->Birthdate_Jalali() }}
                        </div>
                    </div>
                @endif
                <div class = "form-group m-form__group">
                    <label for = "email">ایمیل</label>
                    <div class = "m-input-icon m-input-icon--left">
                        <i class = "fa fa-envelope float-left m--margin-right-10"></i>
                        <span>@if(isset($user->email)) {{ $user->email }} @else درج نشده @endif</span>
                    </div>
                </div>
                <div class = "form-group m-form__group">
                    <label for = "address">آدرس محل سکونت</label>
                    <div class = "m-input-icon m-input-icon--left">
                        <i class = "fa fa-location-arrow float-left m--margin-right-10"></i>
                        <span>@if(isset($user->address)) {{ $user->address }} @else درج نشده @endif</span>
                    </div>
                </div>
                @if(isset($user->introducedBy))
                    <div class = "form-group m-form__group">
                        <label for = "introducedBy">چگونه با آلاء آشنا شدید:</label>
                        <div class = "m-input-icon m-input-icon--left">
                            <i class = "fa fa-location-arrow float-left m--margin-right-10"></i>
                            <span>@if(isset($user->introducedBy)) {{ $user->introducedBy }} @else درج نشده @endif</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if(isset($withBio) && $withBio)
            <div class = "form-group m-form__group {{ $errors->has('bio') ? ' has-danger' : '' }}">
                <label for = "bio">درباره ی شما</label>
                <div class = "m-input-icon m-input-icon--left">
                    {{ $user->bio }}
                </div>
            </div>
        @endif
        @if(isset($text3))
            @if(!$user->hasVerifiedMobile() || !isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)
                <div class = "m-alert m-alert--icon alert alert-danger" role = "alert">
                    <div class = "m-alert__icon">
                        <i class = "fa fa-exclamation-triangle"></i>
                    </div>
                    <div class = "m-alert__text">
                        <strong>
                            @if(!$user->hasVerifiedMobile())لطفا شماره موبایل خود را تایید نمایید
                            <br>@endif
                            @if(!isset($user->photo) || strcmp($user->photo, config('constants.PROFILE_DEFAULT_IMAGE')) == 0)
                                <span id = "profileEditViewText3-span2">لطفا عکس خود را آپلود نمایید</span>
                            @endif
                        </strong>
                    </div>
                    <div class = "m-alert__close">
                        <button type = "button" class = "close" data-close = "alert" aria-label = "Hide"></button>
                    </div>
                </div>
            @endif
        @endif
        @if(isset($text2))
            <div class = "m-alert m-alert--icon alert alert-warning" role = "alert">
                <div class = "m-alert__icon">
                    <i class = "fa fa-exclamation-triangle"></i>
                </div>
                <div class = "m-alert__text">
                    <strong>توجه!</strong>
                    {!!  $text2 !!}
                </div>
                <div class = "m-alert__close">
                    <button type = "button" class = "close" data-close = "alert" aria-label = "Hide"></button>
                </div>
            </div>
        @endif

    </div>
</div>