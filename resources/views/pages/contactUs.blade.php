@extends("app" , ["pageName"=>"contactUs"])

@section("css")
    <link rel="stylesheet" href="{{ mix('/css/all.css') }}">
@endsection

@section("pageBar")
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="{{action("HomeController@index")}}">خانه</a>
                <i class="fa fa-angle-left"></i>
            </li>
            <li>
                <span>تماس با ما</span>
            </li>
        </ul>
    </div>
@endsection

{{--@section('title')--}}
{{--<title>آلاء|تماس با ما</title>--}}
{{--@endsection--}}

@section("content")
    @include("systemMessage.flash")
    <div class="c-content-contact-1 c-opt-1">
        <div class="row" data-auto-height=".c-height">
            <div class="col-lg-8 col-md-6 c-desktop"></div>
            <div class="col-lg-4 col-md-6">
                <div class="c-body">
                    <div class="c-section" style="text-align: right">
                        <h3>@if(isset($wSetting->branches->main->displayName)){{$wSetting->branches->main->displayName}}@endif</h3>
                    </div>
                    <div class="c-section" style="text-align: right">
                        <div class="c-content-label uppercase bg-blue">آدرس</div>
                        <p>
                            @if(isset($wSetting->branches->main->address->city)){{$wSetting->branches->main->address->city}}
                            ، @endif @if(isset($wSetting->branches->main->address->street)) {{$wSetting->branches->main->address->street}}
                            <br>
                            @endif
                            @if(isset($wSetting->branches->main->address->avenue)){{$wSetting->branches->main->address->avenue}}
                            <br>
                            @endif
                            @if(isset($wSetting->branches->main->address->extra)){{$wSetting->branches->main->address->extra}}
                            ، @endif @if(isset($wSetting->branches->main->address->plateNumber)){{$wSetting->branches->main->address->plateNumber}}@endif
                        </p>
                    </div>
                    <div class="c-section" style="text-align: right;direction: ltr">
                        <div class="c-content-label uppercase bg-blue">شماره تماس</div>
                        @foreach($wSetting->branches->main->contacts as $contact)
                            <p dir="rtl">
                                {{$contact->number}}@if(strlen($contact->description)>0)
                                    -  {{$contact->description}}@endif
                            </p>
                        @endforeach
                    </div>
                    @if(isset($wSetting->branches->main->address->postalCode))
                        <div class="c-section" style="text-align: right;direction: ltr">
                            <div class="c-content-label uppercase bg-blue">کد پستی</div>
                            <p dir="rtl">
                                {{$wSetting->branches->main->address->postalCode}}
                            </p>
                        </div>
                    @endif
                    @if(isset($emergencyContacts) && $emergencyContacts->isNotEmpty())
                        <div class="c-section" style="text-align: right;direction: ltr">
                            <div class="c-content-label uppercase bg-blue">تلفن ضروری</div>
                            @foreach($emergencyContacts as $contact)
                                <p dir="rtl">
                                    {{$contact["number"]}}@if(strlen($contact["description"])>0)
                                        -  {{$contact["description"]}}@endif
                                </p>
                            @endforeach
                        </div>
                    @endif
                    <div class="c-section" style="text-align: right">
                        <div class="c-content-label uppercase bg-blue">شبکه های اجتماعی</div>
                        <br/>
                        <ul class="c-content-iconlist-1">
                            @if(isset($wSetting->socialNetwork->telegram->channel->link) && strlen($wSetting->socialNetwork->telegram->channel->link) > 0)
                                <li>
                                    <a target="_blank" href="{{$wSetting->socialNetwork->telegram->channel->link}}">
                                        <i class="fa fa-telegram"></i>
                                    </a>
                                </li>
                            @endif
                            @if(isset($wSetting->socialNetwork->instagram->main->link) && strlen($wSetting->socialNetwork->instagram->main->link) > 0)
                                <li>
                                    <a target="_blank" href="{{$wSetting->socialNetwork->instagram->main->link}}">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="c-section" style="text-align: right">
                        <div class="c-content-label uppercase bg-blue">ارتباط با ادمین</div>
                        <br/>
                        <ul class="c-content-iconlist-1">
                            @if(isset($wSetting->socialNetwork->telegram->channel->admin) && strlen($wSetting->socialNetwork->telegram->channel->admin) > 0)
                                <li>
                                    <a target="_blank" href="{{$wSetting->socialNetwork->telegram->channel->admin}}">
                                        <i class="fa fa-telegram"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="" class="c-content-contact-1-gmap"
             style="height: 615px;background-image: url(/img/extra/contact_us_background.png);background-size: cover;"></div>
    </div>
    <div class="c-content-feedback-1 c-option-1">
        <div class="row">
            <div class="col-md-6">
                <div class="c-contact">
                    <div class="c-content-title-1">
                        <h3 class="uppercase">تماس با ما</h3>
                        <div class="c-line-left bg-dark"></div>
                        <p class="c-font-lowercase">شما می توانید برای ارتباط با ما به آدرس دبیرستان مراجعه نموده و یا
                            با شماره تلفن دبیرستان تماس حاصل فرمایید. همچنین می توانید از طریق فرم زیر پیام ، نظر و یا
                            پیشنهاد خود را برای ما ارسال نمایید</p>
                    </div>
                    {!! Form::open(['method' => 'POST','action' => ['HomeController@sendMail']]) !!}
                    <div class="form-group {{ $errors->has('fullName') ? ' has-error' : '' }}">
                        <span style="color:red;">*</span>
                        <input type="text" name="fullName" value="{{old("fullName")}}" placeholder="نام کامل"
                               class="form-control input-md">
                        @if ($errors->has('fullName'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('fullName') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="text" name="email" value="{{old("email")}}" placeholder="ایمیل"
                               class="form-control input-md">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" name="phone" value="{{old("phone")}}" placeholder="تلفن تماس"
                               class="form-control input-md">
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('message') ? ' has-error' : '' }}">
                        <span style="color:red;">*</span>
                        <textarea rows="8" name="message" placeholder="متن پیام ..."
                                  class="form-control input-md">{{old("message")}}</textarea>
                        @if ($errors->has('message'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                        @endif
                    </div>
                    {{--<div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">--}}
                    {{--<span style="color:red;">*</span>--}}
                    {{--<label for="securityQuestion">سوال امنیتی</label>--}}
                    {{--<input type="text" name="securityQuestion"  placeholder="حاصل 4+3 چند می شود؟ (جواب را به حروف بنویسید) " class="form-control input-md">--}}
                    {{--@if ($errors->has('g-recaptcha-response'))--}}
                    {{--<span class="help-block">--}}
                    {{--<strong>{{ $errors->first('g-recaptcha-response') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                        {!! Recaptcha::render() !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                        @endif
                    </div>
                    <button type="submit" class="btn grey">ارسال</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footerPageLevelPlugin")
    <script src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyCbQCgACu0rgugWcMB1QeXNMrroEvs1WTo"
            type="text/javascript"></script>
    <script src="/assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>
@endsection

@section("footerPageLevelScript")
    <script src="/js/extraJS/contactUs.js" type="text/javascript"></script>
@endsection