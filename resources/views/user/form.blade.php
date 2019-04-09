@if(!Auth::check())
    @if($formID == 1)
        <!-- BEGIN REGISTRATION FORM 1 -->
        <form action="{{ action("Auth\RegisterController@register") }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <h3>ثبت نام</h3>
            <p class="caption-subject font-red-thunderbird bold uppercase">وارد کردن تمام موارد الزامی می باشد: </p>
            <div class="form-group {{ $errors->has('firstName') ? ' has-error' : '' }}">
                <label for="firstName" class="control-label visible-ie8 visible-ie9">نام</label>
                <div class="input-icon">
                    <i class="fa fa-font"></i>
                    <input id="firstName" class="form-control placeholder-no-fix" type="text" value="{{ old('firstName') }}" placeholder="نام" name="firstName"/>
                    @if ($errors->has('firstName'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstName') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('lastName') ? ' has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">نام خانوادگی</label>
                <div class="input-icon">
                    <i class="fa fa-font"></i>
                    <input class="form-control placeholder-no-fix" type="text" value="{{ old('lastName') }}" placeholder="نام خانوادگی" name="lastName"/>
                </div>
                @if ($errors->has('lastName'))
                    <span class="help-block">
                        <strong>{{ $errors->first('lastName') }}</strong>
                    </span>
                @endif
            </div>
            <span class="help-block small bg-font-dark">کد ملی ده رقمی بدون خط فاصله</span>
            <div class="form-group {{ $errors->has('nationalCode') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">کد ملی</label>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input class="form-control placeholder-no-fix" type="text" value="{{ old('nationalCode') }}" placeholder="کد ملی(با اعداد انگلیسی)" name="nationalCode" maxlength="10"/>
                </div>
                @if ($errors->has('nationalCode'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nationalCode') }}</strong>
                    </span>
                @endif
            </div>
            <span class="help-block small bg-font-dark">مثال: 09191234567</span>
            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">شماره موبایل</label>
                <div class="input-icon">
                    <i class="fa fa-mobile"></i>
                    <input class="form-control placeholder-no-fix" type="text" value="{{ old('mobile') }}" placeholder="موبایل(با اعداد انگلیسی)" name="mobile" maxlength="11"/>
                </div>
                @if ($errors->has('mobile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
                <div class="clearfix">
                    <span class="label label-warning ">توجه</span>
                    <span class="small bg-font-dark">برای تایید حساب کاربری از این شماره استفاده می شود!</span>
                </div>
            </div>
            {{--<div class="form-group col-md-12 {{ $errors->has('major_id') ? ' has-error' : '' }}">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">رشته</label>--}}
            {{--<div class="input-icon">--}}
            {{--<i class="fa fa-graduation-cap"></i>--}}
            {{--{!! Form::select('major_id',$majors,old('major_id'),['class' => 'select2 form-control', 'id' => 'major_id']) !!}--}}
            {{--@if ($errors->has('major_id'))--}}
            {{--<span class="help-block">--}}
            {{--<strong>{{ $errors->first('major_id') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}" >--}}
            {{--<label class="control-label visible-ie8 visible-ie9">رمز عبور</label>--}}
            {{--<div class="input-icon">--}}
            {{--<i class="fa fa-lock"></i>--}}
            {{--<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="رمز عبور" name="password" />--}}
            {{--</div>--}}
            {{--@if ($errors->has('password'))--}}
            {{--<span class="help-block">--}}
            {{--<strong>{{ $errors->first('password') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
            {{--</div>--}}
            {{--<div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" >--}}
            {{--<label class="control-label visible-ie8 visible-ie9">تکرار رمز عبور</label>--}}
            {{--<div class="controls">--}}
            {{--<div class="input-icon">--}}
            {{--<i class="fa fa-check"></i>--}}
            {{--<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="تکرار رمز عبور   " name="password_confirmation" /> </div>--}}
            {{--@if ($errors->has('password_confirmation'))--}}
            {{--<span class="help-block">--}}
            {{--<strong>{{ $errors->first('password_confirmation') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<span class="help-block @if ($errors->has('photo')) font-red bold @else small @endif bg-font-dark">فرمتهای مجاز: jpg,png - حداکثر حجم مجاز: ۲۰۰ کیلوبایت</span>--}}
            {{--<div class="form-group {{ $errors->has('photo') ? ' has-error' : '' }}">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">عکس</label>--}}
            {{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}
            {{--<span class="btn green btn-file">--}}
            {{--<i class="fa fa-picture-o"></i>--}}
            {{--<span class="fileinput-new"> عکس  </span>--}}
            {{--<span class="fileinput-exists"> تغییر </span>--}}
            {{--<input class="form-control placeholder-no-fix" type="file" name="photo"> </span>--}}
            {{--<span class="fileinput-filename bg-font-dark"> </span> &nbsp;--}}
            {{--<a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}" >--}}
            {{--<div class="controls">--}}
            {{--{!! Recaptcha::render() !!}--}}
            {{--</div>--}}
            {{--@if ($errors->has('g-recaptcha-response'))--}}
            {{--<span class="help-block">--}}
            {{--<strong>{{ $errors->first('g-recaptcha-response') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
            {{--</div>--}}

            <div class="form-group">
                <label class="mt-checkbox mt-checkbox-outline">
                    <div class="md-checkbox @if($errors->has('rules')) has-error @else has-success @endif">
                        <input type="checkbox" id="rules_checkbox" name="rules" value="1" class="md-check"
                               onclick="if ($(this).parents('.has-error').length != 0) $(this).parent().removeClass('has-error').addClass('has-success' ) ;">
                        <label for="rules_checkbox">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <input type="checkbox" name="tnc"/> من با
                            <a class="font-grey-salt" data-toggle="modal" href="#rules">قوانین استفاده از سایت </a>
                            موافقم
                            <span></span>
                        </label>
                    </div>
                </label>
            </div>


            <!--begin::Modal-->
            <div class="modal fade" id="rules" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rulesModalLabel">قوانین استفاده از سایت</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            تابعیت از قوانین جمهوری اسلامی ایران برای استفاده از سایت الزامی می باشد
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Modal-->

            <div class="form-actions">
                <button id="register-back-btn" type="button" class="btn red btn-outline" onclick="location.href = '/'">
                    @lang('page.Home')
                </button>
                <button type="submit" id="register-submit-btn" class="btn green pull-right"> ثبت نام</button>
            </div>
        </form>
        <!-- END REGISTRATION FORM 1 -->
    @elseif($formID == 2)
        <!-- BEGIN REGISTRATION FORM 2 -->
        <form action="{{ action("Auth\RegisterController@register") }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <h2>عضویت در سایت آلاء</h2>
            <p class="caption-subject bold uppercase">
                بعد از ثبت نام می توانید خدمات مختلف را ببینید و هر کدام را که
                خواستید سفارش بدید.
            </p>
            <div class="form-group col-md-6 {{ $errors->has('firstName') ? ' has-error' : '' }}" style="border-bottom: none !important;">
                <label for="firstName" class="control-label visible-ie8 visible-ie9">نام</label>
                <div class="input-icon">
                    <i class="fa fa-font"></i>
                    <input id="firstName" class="form-control placeholder-no-fix" type="text" value="{{ old('firstName') }}" placeholder="نام(فارسی)" name="firstName"/>
                    {{--@if ($errors->has('firstName'))--}}
                    {{--<span class="help-block">--}}
                    {{--<strong>{{ $errors->first('firstName') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                </div>
            </div>
            <div class="form-group col-md-6 {{ $errors->has('lastName') ? ' has-error' : '' }}" style="border-bottom: none !important;">
                <label class="control-label visible-ie8 visible-ie9">نام خانوادگی</label>
                <div class="input-icon">
                    <i class="fa fa-font"></i>
                    <input class="form-control placeholder-no-fix" type="text" value="{{ old('lastName') }}" placeholder="نام خانوادگی(فارسی)" name="lastName"/>
                </div>
                {{--@if ($errors->has('lastName'))--}}
                {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('lastName') }}</strong>--}}
                {{--</span>--}}
                {{--@endif--}}
            </div>
            <div class="col-md-6">
                <span class="help-block small">کد ملی ده رقمی بدون خط فاصله</span>
                <div class="form-group {{ $errors->has('nationalCode') ? ' has-error' : '' }}" style="border-bottom: none !important;">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">کد ملی</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" value="{{ old('nationalCode') }}" placeholder="کد ملی(با اعداد انگلیسی)" name="nationalCode" maxlength="10"/>
                    </div>
                    @if ($errors->has('nationalCode'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nationalCode') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <span class="help-block small">مثال: 09191234567</span>
                <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}"
                     style="border-bottom: none !important;">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">شماره موبایل</label>
                    <div class="input-icon">
                        <i class="fa fa-mobile"></i>
                        <input class="form-control placeholder-no-fix" type="text" value="{{ old('mobile') }}" placeholder="موبایل(با اعداد انگلیسی)" name="mobile" maxlength="11"/>
                    </div>
                    {{--@if ($errors->has('mobile'))--}}
                    {{--<span class="help-block">--}}
                    {{--<strong>{{ $errors->first('mobile') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                    @if ($errors->has('mobile'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mobile') }}</strong>
                        </span>
                    @else
                        <div class="clearfix">
                            <span class="label label-warning">توجه</span>
                            <span class="small">برای تایید حساب کاربری از این شماره استفاده می شود!</span>
                        </div>
                    @endif
                </div>
            </div>
            {{--<div class="form-group col-md-12 {{ $errors->has('major_id') ? ' has-error' : '' }}">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">رشته</label>--}}
            {{--<div class="input-icon">--}}
            {{--<i class="fa fa-graduation-cap"></i>--}}
            {{--{!! Form::select('major_id',$majors,old('major_id'),['class' => 'select2 form-control', 'id' => 'major_id']) !!}--}}
            {{--@if ($errors->has('major_id'))--}}
            {{--<span class="help-block">--}}
            {{--<strong>{{ $errors->first('major_id') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-group col-md-6 {{ $errors->has('password') ? ' has-error' : '' }}" style="border-bottom: none !important;">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">رمز عبور</label>--}}
            {{--<div class="input-icon">--}}
            {{--<i class="fa fa-lock"></i>--}}
            {{--<input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="رمز عبور" name="password" />--}}
            {{--</div>--}}
            {{--@if ($errors->has('password'))--}}
            {{--<span class="help-block">--}}
            {{--<strong>{{ $errors->first('password') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
            {{--</div>--}}
            {{--<div class="form-group col-md-6 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" style="border-bottom: none !important;">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">تکرار رمز عبور</label>--}}
            {{--<div class="controls">--}}
            {{--<div class="input-icon">--}}
            {{--<i class="fa fa-check"></i>--}}
            {{--<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="تکرار رمز عبور   " name="password_confirmation" /> </div>--}}
            {{--@if ($errors->has('password_confirmation'))--}}
            {{--<span class="help-block">--}}
            {{--<strong>{{ $errors->first('password_confirmation') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<span class="help-block @if ($errors->has('photo')) font-red bold @else small @endif bg-font-dark">فرمتهای مجاز: jpg,png - حداکثر حجم مجاز: ۲۰۰ کیلوبایت</span>--}}
            {{--<div class="form-group {{ $errors->has('photo') ? ' has-error' : '' }}">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">عکس</label>--}}
            {{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}
            {{--<span class="btn green btn-file">--}}
            {{--<i class="fa fa-picture-o"></i>--}}
            {{--<span class="fileinput-new"> عکس  </span>--}}
            {{--<span class="fileinput-exists"> تغییر </span>--}}
            {{--<input class="form-control placeholder-no-fix" type="file" name="photo"> </span>--}}
            {{--<span class="fileinput-filename bg-font-dark"> </span> &nbsp;--}}
            {{--<a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-group col-md-12{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}" style="border-bottom: none !important; @if ($errors->has('g-recaptcha-response')) border-right: solid  #e73d4a; @endif">--}}
            {{--<div class="controls">--}}
            {{--{!! Recaptcha::render() !!}--}}
            {{--</div>--}}
            {{--@if ($errors->has('g-recaptcha-response'))--}}
            {{--<span class="help-block small">--}}
            {{--<strong>{{ $errors->first('g-recaptcha-response') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
            {{--</div>--}}
            @if(isset($pageName) && strcmp($pageName , "checkoutAuth") ==0)
                <div class="form-group col-md-8" style="border-bottom: none !important;">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <div class="md-checkbox @if($errors->has('rules')) has-error @else has-success @endif">
                            <input type="checkbox" id="rules_checkbox" name="rules" value="1" class="md-check"
                                   onclick="if ($(this).parents('.has-error').length != 0) $(this).parent().removeClass('has-error').addClass('has-success' ) ;">
                            <label for="rules_checkbox">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                <input type="checkbox" name="tnc"/> من با قوانین استفاده از سایت موافقم
                                <span></span>
                            </label>
                        </div>
                    </label>
                </div>
                <div class="form-actions col-md-4">
                    {{--<button id="register-back-btn" type="button" class="btn red btn-outline" onclick="location.href = '/'"> @lang('page.Home') </button>--}}
                    <button type="submit" id="register-submit-btn" class="btn green pull-right"> ثبت نام</button>
                </div>
                <div class="form-group col-md-12">
                    <div class="panel-group accordion" id="accordion1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse"
                                       data-parent="#accordion3" href="#collapse_3_1"> برای خواندن قوانین کلیک کنید </a>
                                </h4>
                            </div>
                            <div id="collapse_3_1" class="panel-collapse collapse">
                                <div class="panel-body"
                                     @if(isset($wSetting) && strlen($wSetting)>300)style="height:200px; overflow-y:auto;"@endif>
                                    <p> تابعیت از قوانین جمهوری اسلامی ایران برای استفاده از سایت الزامی می باشد</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="form-group col-md-8" style="border-bottom: none !important;">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <div class="md-checkbox @if($errors->has('rules')) has-error @else has-success @endif">
                            <input type="checkbox" id="rules_checkbox" name="rules" value="1" class="md-check"
                                   onclick="if ($(this).parents('.has-error').length != 0) $(this).parent().removeClass('has-error').addClass('has-success' ) ;">
                            <label for="rules_checkbox">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                <input type="checkbox" name="tnc"/> من با
                                <a class="font-grey-salt" data-toggle="modal" href="#rules">قوانین استفاده از سایت </a>
                                موافقم
                                <span></span>
                            </label>
                            {{--<div class="panel-group accordion" id="accordion1">--}}
                            {{--<div class="panel panel-default">--}}
                            {{--<div class="panel-heading">--}}
                            {{--<h4 class="panel-title">--}}
                            {{--<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1" aria-expanded="false"> قوانین استفاده از سایت </a>--}}
                            {{--</h4>--}}
                            {{--</div>--}}
                            {{--<div id="collapse_1" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">--}}
                            {{--<div class="panel-body">--}}
                            {{--<p> تابعیت از قوانین جمهوری اسلامی ایران برای استفاده از سایت الزامی می باشد</p>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--@endif--}}
                        </div>
                    </label>
                </div>


                <!--begin::Modal-->
                <div class="modal fade" id="rules" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rulesModalLabel">قوانین استفاده از سایت</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                تابعیت از قوانین جمهوری اسلامی ایران برای استفاده از سایت الزامی می باشد
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Modal-->

                <div class="form-actions col-md-4">
                    {{--<button id="register-back-btn" type="button" class="btn red btn-outline" onclick="location.href = '/'"> @lang('page.Home') </button>--}}
                    <button type="submit" id="register-submit-btn" class="btn green pull-right"> ثبت نام</button>
                </div>
            @endif
        </form>
        <!-- END REGISTRATION FORM 2 -->
    @endif
@elseif(isset($user))
    {!! Form::hidden('id',$user->id, ['class' => 'btn red']) !!}
    <div class="form-body">
        <div class="note note-warning"><h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر
                الزامیست: </h4></div>
        <div class="form-group {{ $errors->has('firstName') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="firstName">نام</label>
            <div class="col-md-9">
                {!! Form::text('firstName', null, ['class' => 'form-control', 'id' => 'firstName' ]) !!}
                @if ($errors->has('firstName'))
                    <span class="help-block">
                    <strong>{{ $errors->first('firstName') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('lastName') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="lastName">نام خانوادگی</label>
            <div class="col-md-9">
                {!! Form::text('lastName', null, ['class' => 'form-control', 'id' => 'lastName' ]) !!}
                @if ($errors->has('lastName'))
                    <span class="help-block">
                    <strong>{{ $errors->first('lastName') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="mobile">شماره موبایل</label>
            <div class="col-md-9">
                {!! Form::text('mobile', null, ['class' => 'form-control','maxlength'=>'11' , 'id' => 'mobile', 'dir'=>'ltr' ]) !!}
                @if ($errors->has('mobile'))
                    <span class="help-block">
                    <strong>{{ $errors->first('mobile') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('nationalCode') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="nationalCode">کد ملی</label>
            <div class="col-md-9">
                {!! Form::text('nationalCode', null, ['class' => 'form-control', 'maxlength'=>'10' ,'id' => 'nationalCode' , 'dir'=>'ltr' ]) !!}
                @if ($errors->has('nationalCode'))
                    <span class="help-block">
                    <strong>{{ $errors->first('nationalCode') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('userstatus_id') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="userstatus_id">وضعیت حساب کاربری</label>
            <div class="col-md-9">
                {!! Form::select('userstatus_id',$userStatuses,null,['class' => 'form-control', 'id' => 'userstatus']) !!}
                @if ($errors->has('userstatus_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('userstatus_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="note note-info"><h4 class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری
                می باشد: </h4></div>
        <div class="form-group {{ $errors->has('lockProfile') ? ' has-error' : '' }}">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <label class="mt-checkbox mt-checkbox-outline">
                    <div class="md-checkbox">
                        {!! Form::checkbox('lockProfile', '1', null,  ['value' => '1' , 'id' => 'checkbox_lockProfile' , 'class'=>'md-check']) !!}
                        <label for="checkbox_lockProfile">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            قفل کردن ویرایش اطلاعات شخصی
                            <span></span>
                        </label>
                    </div>
                </label>
            </div>
        </div>
        <div class="form-group {{ $errors->has('mobileNumberVerification') ? ' has-error' : '' }}">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <label class="mt-checkbox mt-checkbox-outline">
                    <div class="md-checkbox">
                        {!! Form::checkbox('mobileNumberVerification', '1', null,  ['value' => '1' , 'id' => 'checkbox_mobileNumberVerification' , 'class'=>'md-check']) !!}
                        <label for="checkbox_mobileNumberVerification">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            تایید شماره موبایل
                            <span></span>
                        </label>
                    </div>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">عکس</label>
            <div class="col-md-9">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                        <img class="a--fullWidth" src="{{ $user->photo }}" alt="عکس پروفایل"/>
                    </div>
                    <style>
                        .fileinput .thumbnail > img {
                            width: 100%;
                            height: auto;
                        }
                    </style>
                    <div class="fileinput-preview fileinput-exists thumbnail"
                         style="max-width: 200px; max-height: 150px;">
                    </div>
                    <div>
                        <span class="btn default btn-file">
                            <span class="fileinput-new btn btn-sm m-btn--air btn-warning"> تغییر عکس </span>
                            <span class="fileinput-exists btn btn-sm m-btn--air btn-warning"> تغییر </span>
                            <input type="file" name="photo">
                        </span>
                        <a href="javascript:" class="fileinput-exists btn btn-sm m-btn--air btn-danger" id="userPhoto-remove" data-dismiss="fileinput">
                            حذف
                        </a>
                    </div>
                </div>
                <div class="clearfix margin-top-10">
                    <span class="label label-danger">توجه</span> فرمت های مجاز: jpg , png - حداکثر حجم مجاز: 500KB
                </div>
            </div>
        </div>
        <div class="form-group {{ $errors->has('major_id') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="major_id">رشته</label>
            <div class="col-md-9">
                {!! Form::select('major_id',$majors,null,['class' => 'form-control', 'id' => 'major_id', 'placeholder' => 'نامشخص']) !!}
                @if ($errors->has('major_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('major_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('gender_id') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="gender_id">جنسیت</label>
            <div class="col-md-9">
                {!! Form::select('gender_id', $genders, null,['class' => 'form-control', 'id' => 'gender_id', 'placeholder' => 'نامشخص']) !!}
                @if ($errors->has('gender_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('gender_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="email">ایمیل</label>
            <div class="col-md-9">
                {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email' ]) !!}
                @if ($errors->has('email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('whatsapp') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="whatsapp">واتس اپ</label>
            <div class="col-md-9">
                {!! Form::text('whatsapp', null, ['class' => 'form-control', 'id' => 'whatsapp' ]) !!}
                @if ($errors->has('whatsapp'))
                    <span class="help-block">
                    <strong>{{ $errors->first('whatsapp') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('skype') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="skype">اسکایپ</label>
            <div class="col-md-9">
                {!! Form::text('skype', null, ['class' => 'form-control', 'id' => 'skype' ]) !!}
                @if ($errors->has('skype'))
                    <span class="help-block">
                    <strong>{{ $errors->first('skype') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('province') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="province">استان</label>
            <div class="col-md-9">
                {!! Form::text('province', null, ['class' => 'form-control', 'id' => 'province' ]) !!}
                @if ($errors->has('province'))
                    <span class="help-block">
                    <strong>{{ $errors->first('province') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="city">شهر</label>
            <div class="col-md-9">
                {!! Form::text('city', null, ['class' => 'form-control', 'id' => 'city' ]) !!}
                @if ($errors->has('city'))
                    <span class="help-block">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('postalCode') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="province">کد پستی</label>
            <div class="col-md-9">
                {!! Form::text('postalCode', null, ['class' => 'form-control', 'id' => 'postalCode', 'dir'=>'ltr' ]) !!}
                @if ($errors->has('postalCode'))
                    <span class="help-block">
                    <strong>{{ $errors->first('postalCode') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="province">آدرس</label>
            <div class="col-md-9">
                {!! Form::text('address', null, ['class' => 'form-control', 'id' => 'address' ]) !!}
                @if ($errors->has('address'))
                    <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('school') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="province">مدرسه</label>
            <div class="col-md-9">
                {!! Form::text('school', null, ['class' => 'form-control', 'id' => 'school' ]) !!}
                @if ($errors->has('school'))
                    <span class="help-block">
                    <strong>{{ $errors->first('school') }}</strong>
                </span>
                @endif
            </div>
        </div>

        {{--<div class="form-group {{ $errors->has('techCode') ? ' has-error' : '' }}">--}}
        {{--<label for="techCode" class=" control-label">کد تکنسین</label>--}}
        {{--<div class="input-icon"><i class="fa fa-id-card" aria-hidden="true"></i>--}}
        {{--<input id="techCode" class="form-control placeholder-no-fix" maxlength="5" type="text" value="{{ $user->techCode }}"--}}
        {{--name="techCode"  />--}}
        {{--</div>--}}
        {{--@if ($errors->has('techCode'))--}}
        {{--<span class="help-block">--}}
        {{--<strong>{{ $errors->first('techCode') }}</strong>--}}
        {{--</span>--}}
        {{--@endif--}}
        {{--</div>--}}

        <div class="row static-info margin-top-20">
            <label for="bio" class=" control-label">درباره من </label>
            <div class=" form-group  {{ $errors->has('bio') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    {!! Form::textarea('bio',null,['class' => 'form-control' , 'placeholder'=>'درباره ی شما' , 'rows'=>'13','id'=>'bio']) !!}
                </div>
            </div>
        </div>

        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="col-md-3">
                <label class="control-label" for="password">رمز عبور جدید</label>
            </div>
            <div class="col-md-9">
                <input type="password" class="form-control" name="password"/>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
            </div>
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <div class="col-md-3">
                <label class="control-label" for="password_confirmation">تکرار رمز عبور جدید</label>
            </div>
            <div class="col-md-9">
                <input type="password" class="form-control" name="password_confirmation"/>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                         <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        @permission((Config::get('constants.INSET_USER_ROLE')))
        <div class="form-group {{ $errors->has('permissions') ? ' has-error' : '' }}">
            <label class="col-md-3 control-label" for="roles">نقش ها</label>
            <div class="col-md-9">
                {!! Form::select('roles[]',$roles,$userRoles,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'user_role' ]) !!}
                @if ($errors->has('roles'))
                    <span class="help-block">
                    <strong>{{ $errors->first('roles') }}</strong>
                </span>
                @endif
            </div>
            <div class="clearfix margin-top-10">
                <span class="label label-info">توجه</span>
                <strong id="">ستون چپ نقش های اختصاص داده شده می باشند</strong>
            </div>
        </div>
        @endpermission
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    {!! Form::submit('اصلاح', ['class' => 'btn btn-lg m-btn--air btn-warning']) !!}
                </div>
            </div>
        </div>
    </div>
@else
    @if(isset($formID) && $formID == 1)
        @include("systemMessage.flash")
        @if(Auth::user()->lockProfile)
            <div class="custom-alerts alert alert-warning fade in margin-top-10">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <i class="fa fa-times-circle"></i>
                پروفایل شما قفل می باشد، لطفا با مسئولین سایت تماس بگیرید
            </div>
        @endif


        <!--begin::Form-->
        {!! Form::open(['files' => 'true', 'method' => 'PUT', 'class' => 'm-form m-form--fit m-form--label-align-right', 'action' => ['Web\UserController@update' , Auth::user()]]) !!}


            <div class="m-portlet__body">
                {!! Form::hidden('updateType',"atLogin") !!}
                <div class="form-group m-form__group m--margin-top-10">
                    <div class="alert m-alert m-alert--default @if(isset($noteFontColor)) {{$noteFontColor}} @endif" role="alert">
                        @if(isset($note))
                            {{$note}}
                        @endif
                    </div>
                </div>


                @foreach($formFields as $formField)

                    <div class="form-group m-form__group {{ $errors->has($formField->name) ? ' has-danger' : '' }}">
                        <label for="{{$formField->name}}">{{$formField->displayName}}</label>
                        <div class="m-input-icon m-input-icon--left">
                            @if(strpos($formField->name, "_id"))
                                {!! Form::select($formField->name, $tables[$formField->name], Auth::user()[$formField->name] , ['class' => 'form-control m-input m-input--air' , 'placeholder' => $formField->displayName]) !!}
                            @elseif(strcmp($formField->name , "photo") == 0)
                                <div></div>
                                <div class="custom-file">
                                    {!! Form::file('photo' , ['id'=>'photo', 'class' => 'custom-file-input']) !!}
                                    <label class="custom-file-label" for="customFile">انتخاب فایل</label>
                                </div>
                                <span class="m-form__help">
                                    <span class="m-badge m-badge--danger m-badge--wide">
                                        فرمت های مجاز: jpg , png - حداکثر حجم مجاز: 500KB
                                    </span>
                                </span>
                            @else
                                <input class="form-control m-input m-input--air" type="text"
                                       value="@if(isset(Auth::user()[$formField->name]) && strlen(preg_replace('/\s+/', '', Auth::user()[$formField->name]))>0) {{old($formField->name, Auth::user()[$formField->name])}} @else{{old($formField->name)}}@endif"
                                       placeholder="{{$formField->displayName}}"
                                       name="{{$formField->name}}"/>
                            @endif
                            @if ($errors->has($formField->name))
                                <div class="form-control-feedback">{{ $errors->first($formField->name) }}</div>
                            @endif
                            @if(strcmp($formField->name , "photo") !== 0)
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span><i class="flaticon-edit"></i></span>
                                </span>
                            @endif
                        </div>
                    </div>

                @endforeach

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions">
                    @if(isset($formByPass) && !$formByPass)
                        <button type="button" class="btn m-btn--pill m-btn--air btn-accent" onclick = "location.href = '@if(session()->has("redirectTo"))  {{session()->get("redirectTo")}}@else {{action("Web\IndexPageController")}} @endif' ">
                            بعدا پر می کنم
                        </button>
                    @elseif(isset($hasHomeButton))
                        <a href = "{{action("Web\IndexPageController")}}" class = "btn m-btn--pill m-btn--air btn-danger"> @lang('page.Home') </a>
                    @endif
                    @if(!Auth::user()->lockProfile)
                        <button type="submit" class="btn m-btn--pill m-btn--air btn-success"> ادامه</button>
                    @endif
                </div>
            </div>


        {!! Form::close() !!}
        <!--end::Form-->
    @else
        <div class="col-md-12">
            <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر الزامی می باشد: </p>
        </div>
        <div class="col-md-6">
            <p>{!! Form::text('firstName', null, ['class' => 'form-control', 'id' => 'firstName' , 'placeholder'=>'نام']) !!}
                <span class="help-block" id="firstNameAlert">
                <strong></strong>
            </span>
            </p>
            <p>{!! Form::text('nationalCode', null, ['class' => 'form-control', 'id' => 'nationalCode'  , 'maxlength'=>'10' , 'placeholder'=>'کد ملی']) !!}
                <span class="help-block" id="nationalCodeAlert">
                <strong></strong>
            </span>
            </p>
            <p>{!! Form::password('password', ['class' => 'form-control', 'id' => 'password' , 'placeholder'=>'رمز عبور']) !!}
                <span class="help-block" id="passwordAlert">
                <strong></strong>
            </span>
            </p>

        </div>
        <div class="col-md-6">
            <p>{!! Form::text('lastName', null, ['class' => 'form-control', 'id' => 'lastName' , 'placeholder'=>'نام خانوادگی']) !!}
                <span class="help-block" id="lastNameAlert">
                     <strong></strong>
                    </span>
            </p>
            <p>{!! Form::text('mobile', null, ['class' => 'form-control', 'id' => 'mobile' , 'maxlength'=>'11' , 'placeholder'=>'موبایل']) !!}
                <span class="help-block" id="mobileAlert">
                        <strong></strong>
                     </span>
            </p>
            <p>{!! Form::select('userstatus_id',$userStatuses,null,['class' => 'form-control', 'id' => 'userstatus_id']) !!}
                <span class="help-block" id="userstatusAlert">
                     <strong></strong>
                    </span>
            </p>
        </div>
        <div class="col-md-12">
            <p class="caption-subject font-dark bold uppercase"> وارد کردن اطلاعات زیر اختیاری می باشد: </p>
        </div>
        <div class="col-md-12">
            <label class="mt-checkbox mt-checkbox-outline">
                <div class="md-checkbox">
                    {!! Form::checkbox('mobileNumberVerification', '1', null,  [ 'id'=>'checkbox_insertUserMobileNumberVerification'  , 'class'=>'md-check']) !!}
                    <label for="checkbox_insertUserMobileNumberVerification">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>
                        تایید شماره موبایل
                        <span></span>
                    </label>
                </div>
            </label>
        </div>
        <div class="col-md-6">
            <p>{!! Form::text('province', null, ['class' => 'form-control', 'id' => 'province' , 'placeholder'=>'استان']) !!}
                <span class="help-block" id="provinceAlert">
                <strong></strong>
            </span>
            </p>
        </div>
        <div class="col-md-6">
            <p>{!! Form::text('city', null, ['class' => 'form-control', 'id' => 'city' , 'placeholder'=>'شهر']) !!}
                <span class="help-block" id="cityAlert">
                <strong></strong>
            </span>
            </p>
        </div>
        <div class="col-md-12">
            <p>{!! Form::text('address', null, ['class' => 'form-control', 'id' => 'address' , 'placeholder'=>'آدرس']) !!}
                <span class="help-block" id="addressAlert">
                <strong></strong>
            </span>
            </p>
        </div>
        <div class="col-md-6">
            <p>{!! Form::text('postalCode', null, ['class' => 'form-control', 'id' => 'postalCode' , 'placeholder'=>'کد پستی']) !!}
                <span class="help-block" id="postalCodeAlert">
                <strong></strong>
            </span>
            </p>

        </div>
        <div class="col-md-6">
            <p>{!! Form::text('school', null, ['class' => 'form-control', 'id' => 'school' , 'placeholder'=>'مدرسه']) !!}
                <span class="help-block" id="schoolAlert">
                <strong></strong>
            </span>
            </p>
        </div>
        <div class="col-md-6">
            <p>{!! Form::select('major_id', $majors, null,['class' => 'form-control', 'id' => 'userMajor', 'placeholder' => 'رشته نامشخص']) !!}
                <span class="help-block" id="userMajorAlert">
                <strong></strong>
            </span>
            </p>
        </div>
        <div class="col-md-6">
            <p>{!! Form::select('gender_id', $genders, null,['class' => 'form-control', 'id' => 'userGender', 'placeholder' => 'جنسیت نامشخص']) !!}
                <span class="help-block" id="userGenderAlert">
                <strong></strong>
            </span>
            </p>
        </div>
        <div class="col-md-6">
            <p>{!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email' , 'placeholder'=>'ایمیل']) !!}
                <span class="help-block" id="emailAlert">
					<strong></strong>
				</span>
            </p>
        </div>
        <div class="col-md-6">
            <div class="fileinput fileinput-new" id="photo-div" data-provides="fileinput">
                <div class="input-group input-large">
                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                        <span class="fileinput-filename"> </span>
                    </div>
                    <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> عکس </span>
                                                                <span class="fileinput-exists"> تغییر </span>
                        {!! Form::file('photo' , ['id'=>'photo']) !!} </span>
                    <a href="javascript:" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
                        حذف </a>
                </div>
                <div class="clearfix margin-top-10">
                    <span class="label label-danger">توجه</span><strong id="photoAlert">فرمت های مجاز: jpg , png -
                        حداکثر حجم مجاز: 500KB</strong>
                </div>
            </div>
        </div>
        @permission((Config::get('constants.INSET_USER_ROLE')))
        <div class="col-md-12">
            <p>
                <label class="control-label">نقش ها</label>
                {!! Form::select('roles[]', $roles ,null,['multiple' => 'multiple','class' => 'multi-select', 'id' => 'user_role']) !!}
                <span class="help-block" id="roleAlert">
                        <strong></strong>
                </span>
            <div class="clearfix margin-top-10">
                <span class="label label-info">توجه</span>
                <strong id="">ستون چپ نقش های انتخاب شده می باشند</strong>
            </div>
            </p>
        </div>
        @endpermission
    @endif
@endif