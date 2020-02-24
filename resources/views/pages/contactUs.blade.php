@extends('partials.templatePage' , ["pageName"=>"contactUs"])

@section('page-css')
    <link href="{{ mix('/css/page-contactUs.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('pageBar')
    <nav aria-label = "breadcrumb">
        <ol class = "breadcrumb">
            <li class = "breadcrumb-item">
                <i class = "fa fa-home"></i>
                <a href = "{{action('Web\IndexPageController')}}">@lang('page.Home')</a>
            </li>
            <li class = "breadcrumb-item active" aria-current = "page">
                @lang('page.contact us')
            </li>
        </ol>
    </nav>
@endsection

@section('content')

    <div class = "row">
        <div class = "col-xl-6 col-md-6">
            <!--begin::Portlet-->
            <div class = "m-portlet">
                <div class = "m-portlet__head">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
						<span class = "m-portlet__head-icon m--hide">
						<i class = "fa fa-cog"></i>
						</span>
                            <h3 class = "m-portlet__head-text">
                                ارسال پیام به آلاء
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                {!! Form::open(['method' => 'POST','action' => ['Web\HomeController@sendMail'],'class' => 'm-form']) !!}
                <div class = "m-portlet__body">
                    <div class = "form-group m-form__group row {{ $errors->has('fullName') ? ' has-danger' : '' }}">
                        <label for = "example-text-input" class = "col-3 col-form-label">نام کامل:</label>
                        <div class = "col-9">
                            <input type = "text" name = "fullName" class = "form-control m-input" value = "{{ old("fullName") }}" placeholder = "نام و نام خانوادگی">
                            @if ($errors->has('fullName'))
                                <div class = "form-control-feedback">{{ $errors->first('fullName') }}</div>
                            @endif
                            <span class = "m-form__help">لطفا نام کامل خود را وارد نمایید</span>
                        </div>
                    </div>
                    <div class = "form-group m-form__group row {{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for = "example-text-input" class = "col-3 col-form-label">ایمیل شما:</label>
                        <div class = "col-9">
                            <input type = "text" name = "email" dir = "ltr" class = "form-control m-input" value = "{{ old("email") }}" placeholder = "ایمیل خود را وارد نمایید">
                            <span class = "m-form__help">ما ایمیل شما را به هیچ کس نخواهیم داد.</span>
                            @if ($errors->has('email'))
                                <div class = "form-control-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class = "form-group m-form__group row {{ $errors->has('phone') ? ' has-danger' : '' }}">
                        <label for = "example-text-input" class = "col-3 col-form-label">شماره شما:</label>
                        <div class = "col-9">
                            <input type = "text" name = "phone" dir = "ltr" class = "form-control m-input" value = "{{ old("phone") }}" placeholder = "شماره خود را وارد نمایید">
                            <span class = "m-form__help">ما شماره شما را به هیچ کس نخواهیم داد.</span>
                            @if ($errors->has('phone'))
                                <div class = "form-control-feedback">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class = "form-group m-form__group row {{ $errors->has('message') ? ' has-danger' : '' }}">
                        <label for = "example-text-input" class = "col-3 col-form-label">پیام شما:</label>
                        <div class = "col-9">
                            <textarea rows = "8" class = "form-control m-input" name = "message" placeholder = "متن پیام شما . . . ">{{ old("message") }}</textarea>
                            <span class = "m-form__help">اگر هنگام خرید مسئله مالی رخ داده است، به جای ارسال پیام تماس بگیرید تا سریع تر بررسی شود.</span>
                            @if ($errors->has('message'))
                                <div class = "form-control-feedback">{{ $errors->first('message') }}</div>
                            @endif
                        </div>
                    </div>
{{--                    <div class = "form-group m-form__group row {{ $errors->has('g-recaptcha-response') ? ' has-danger' : '' }}">--}}
{{--                        <label for = "example-text-input" class = "col-3 col-form-label">ربات نیستم:</label>--}}
{{--                        <div class = "col-9">--}}
{{--                            {!! Recaptcha::render() !!}--}}
{{--                            @if ($errors->has('g-recaptcha-response'))--}}
{{--                                <div class = "form-control-feedback">{{ $errors->first('g-recaptcha-response') }}</div>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
                <div class = "m-portlet__foot m-portlet__foot--fit">
                    <div class = "m-form__actions m-form__actions--solid">
                        <div class = "row">
                            <div class = "col-3">

                            </div>
                            <div class = "col-9">
                                <button type = "submit" class = "btn btn-brand">ارسال</button>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
        <div class = "col-xl-6 col-md-6">
            <!--begin:: Widgets/Blog-->
            <div class = "m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
                <div class = "m-portlet__head m-portlet__head--fit-">
                    <div class = "m-portlet__head-caption">
                        <div class = "m-portlet__head-title">
                            <h3 class = "m-portlet__head-text m--font-light">
                                راه های ارتباطی با آلاء
                            </h3>
                        </div>
                    </div>
                </div>
                <div class = "m-portlet__body">
                    <div class = "m-widget27 m-portlet-fit--sides">
                        <div class = "m-widget27__pic">
                            <img src = "./assets/app/media/img/bg/bg-4.jpg" alt = "">
                            <div class = "m-widget27__btn">
                                <button type = "button" class = "btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--bolder">دفتر مرکزی</button>
                            </div>
                        </div>
                        <div class = "m-widget27__container m--padding-left-15 m--padding-right-15">
                            <h5>نشانی</h5>
                            <p>
                                @if(isset($wSetting->branches->main->address->city)){{$wSetting->branches->main->address->city}}
                                ، @endif @if(isset($wSetting->branches->main->address->street)) {{$wSetting->branches->main->address->street}}
                                @endif
                                @if(isset($wSetting->branches->main->address->avenue)){{$wSetting->branches->main->address->avenue}}
                                @endif
                                @if(isset($wSetting->branches->main->address->extra)){{$wSetting->branches->main->address->extra}}
                                ، @endif @if(isset($wSetting->branches->main->address->plateNumber)){{$wSetting->branches->main->address->plateNumber}}@endif
                            </p>
                            <hr>
                            <h5>شماره تماس</h5>
                            @foreach($wSetting->branches->main->contacts as $contact)
                                <p dir = "rtl">
                                    {{$contact->number}}@if(strlen($contact->description)>0)
                                        -  {{$contact->description}}@endif
                                </p>
                            @endforeach
                            <hr>
                            @if(isset($emergencyContacts) && $emergencyContacts->isNotEmpty())
                                <div class = "c-section" style = "text-align: right;direction: ltr">
                                    <div class = "c-content-label uppercase bg-blue">تلفن ضروری</div>
                                    @foreach($emergencyContacts as $contact)
                                        <p dir = "rtl">
                                            {{$contact["number"]}}@if(strlen($contact["description"])>0)
                                                -  {{$contact["description"]}}@endif
                                        </p>
                                    @endforeach
                                </div>
                                <hr>
                            @endif
                            <h5> شبکه های اجتماعی</h5>
                            <ul class = "list-inline">
                                @if(isset($wSetting->socialNetwork->telegram->channel->link) && strlen($wSetting->socialNetwork->telegram->channel->link) > 0)
                                    <li class = "list-inline-item">
                                        <a target = "_blank" href = "{{$wSetting->socialNetwork->telegram->channel->link}}">
                                            <i class = "fab fa-telegram  m--icon-font-size-lg5"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($wSetting->socialNetwork->instagram->main->link) && strlen($wSetting->socialNetwork->instagram->main->link) > 0)
                                    <li class = "list-inline-item">
                                        <a target = "_blank" href = "{{$wSetting->socialNetwork->instagram->main->link}}">
                                            <i class = "fab fa-instagram  m--icon-font-size-lg5"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            <hr>
                            <h5>ارتباط با ادمین (امور مالی)</h5>
                            <ul class = "list-inline ">
                                @if(isset($wSetting->socialNetwork->telegram->channel->admin) && strlen($wSetting->socialNetwork->telegram->channel->admin) > 0)
                                    <li class = "list-inline-item">
                                        <a target = "_blank" href = "{{$wSetting->socialNetwork->telegram->channel->admin}}">
                                            <i class = "fab fa-telegram  m--icon-font-size-lg5"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                            <hr>
                            <h5>موسسه غیرتجاری توسعه علمی آموزشی عدالت محور آلاء</h5>
                            خدمات اصلی آموزش توسط آلاء رایگان ارائه می شوند و آلاء با فروش محصولات آموزشی جانبی، هزینه های خود را تامین می کند.
                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Blog-->
        </div>
    </div>
@endsection

@section('page-js')
    <script src = "{{ mix('/js/contactUs.js') }}"></script>
@endsection
